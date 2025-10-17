<?php
/**
 * HỌC CÙNG AI - CONFIGURATION FILE
 * Version: 3.0
 * Updated: 2025
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/php_errors.log');

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Strict'
    ]);
}

// Database configuration (if needed)
define('DB_HOST', 'localhost');
define('DB_NAME', 'fighter_english');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Gemini API Configuration - ⚠️ THAY API KEY CỦA BẠN
define('GEMINI_API_KEY', 'AIzaSyCw79baxbVs0yJ8sxHH2PYUKQN3LDR2kQQ'); // THAY ĐỔI NÀY
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent');
define('GEMINI_TIMEOUT', 60);
define('GEMINI_MAX_RETRIES', 3);

// Application settings
define('APP_NAME', 'Học Cùng AI');
define('APP_VERSION', '3.0');
define('BASE_URL', '/fighter/'); // Adjust according to your setup

/**
 * Security Helper Class
 */
class SecurityHelper {
    // Sanitize input data
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars(trim(stripslashes($data)), ENT_QUOTES, 'UTF-8');
    }

    // Validate text length
    public static function validateLength($text, $min = 1, $max = 5000) {
        $length = mb_strlen($text, 'UTF-8');
        return $length >= $min && $length <= $max;
    }

    // Simple rate limiting using session
    public static function checkRateLimit($action = 'api_call', $limit = 30, $window = 3600) {
        $key = 'rate_limit_' . $action;
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'count' => 0,
                'reset_time' => time() + $window
            ];
        }

        // Reset if window expired
        if (time() > $_SESSION[$key]['reset_time']) {
            $_SESSION[$key] = [
                'count' => 0,
                'reset_time' => time() + $window
            ];
        }

        // Check limit
        if ($_SESSION[$key]['count'] >= $limit) {
            return false;
        }

        // Increment counter
        $_SESSION[$key]['count']++;
        return true;
    }

    // Generate CSRF Token
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Verify CSRF Token
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && 
               hash_equals($_SESSION['csrf_token'], $token);
    }
}

/**
 * Simple Logger (File-based)
 */
class Logger {
    public static function log($level, $message, $context = []) {
        $logDir = __DIR__ . '/logs';
        if (!file_exists($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . '/app_' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? json_encode($context) : '';
        
        $logEntry = sprintf(
            "[%s] %s: %s %s\n",
            $timestamp,
            strtoupper($level),
            $message,
            $contextStr
        );

        @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    public static function error($message, $context = []) {
        self::log('error', $message, $context);
    }

    public static function info($message, $context = []) {
        self::log('info', $message, $context);
    }
}

// Create necessary directories
$dirs = ['logs', 'uploads', 'uploads/audio'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (!file_exists($path)) {
        @mkdir($path, 0755, true);
    }
}

// Database connection (if needed)
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset(DB_CHARSET);
    
    if ($conn->connect_error) {
        Logger::error('Database connection failed', ['error' => $conn->connect_error]);
        $conn = null;
    }
} catch (Exception $e) {
    Logger::error('Database exception', ['error' => $e->getMessage()]);
    $conn = null;
}

Logger::info('Config loaded successfully');
?>
