<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Application Configuration
define('APP_NAME', 'Học Cùng AI');
define('APP_VERSION', '3.1');

// Gemini AI API Configuration
define('GEMINI_API_KEY', 'AIzaSyCw79baxbVs0yJ8sxHH2PYUKQN3LDR2kQQ'); // Thay bằng API key thực của bạn
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');
define('GEMINI_VISION_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');

// Security Settings
define('CSRF_TOKEN_NAME', 'csrf_token');
define('CSRF_TOKEN_EXPIRE', 3600); // 1 hour

// Rate Limiting
define('API_RATE_LIMIT', 100); // requests per hour
define('API_RATE_WINDOW', 3600); // 1 hour in seconds

// Error Reporting (set to false in production)
define('DEBUG_MODE', true);

// Helper Classes
class SecurityHelper {
    public static function generateCSRFToken() {
        if (!isset($_SESSION[CSRF_TOKEN_NAME]) || 
            !isset($_SESSION[CSRF_TOKEN_NAME . '_time']) ||
            (time() - $_SESSION[CSRF_TOKEN_NAME . '_time']) > CSRF_TOKEN_EXPIRE) {
            
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
            $_SESSION[CSRF_TOKEN_NAME . '_time'] = time();
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    public static function verifyCSRFToken($token) {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            return false;
        }
        
        if ((time() - $_SESSION[CSRF_TOKEN_NAME . '_time']) > CSRF_TOKEN_EXPIRE) {
            return false;
        }
        
        return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }

    public static function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizeInput'], $data);
        }
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}

class Logger {
    public static function log($level, $message, $context = []) {
        if (!DEBUG_MODE && $level === 'DEBUG') {
            return;
        }
        
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'user_id' => $_SESSION['id_hocvien'] ?? null
        ];
        
        error_log(json_encode($logEntry, JSON_UNESCAPED_UNICODE));
    }

    public static function info($message, $context = []) {
        self::log('INFO', $message, $context);
    }

    public static function error($message, $context = []) {
        self::log('ERROR', $message, $context);
    }

    public static function debug($message, $context = []) {
        self::log('DEBUG', $message, $context);
    }
}

class RateLimiter {
    public static function checkLimit($userId) {
        $key = 'api_requests_' . $userId;
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'count' => 0,
                'reset_time' => time() + API_RATE_WINDOW
            ];
        }
        
        if (time() > $_SESSION[$key]['reset_time']) {
            $_SESSION[$key] = [
                'count' => 0,
                'reset_time' => time() + API_RATE_WINDOW
            ];
        }
        
        $_SESSION[$key]['count']++;
        
        return $_SESSION[$key]['count'] <= API_RATE_LIMIT;
    }
    
    public static function getRemainingRequests($userId) {
        $key = 'api_requests_' . $userId;
        
        if (!isset($_SESSION[$key])) {
            return API_RATE_LIMIT;
        }
        
        return max(0, API_RATE_LIMIT - $_SESSION[$key]['count']);
    }
}

// Response Helper
class ResponseHelper {
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function success($data = [], $message = 'Success') {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error($message = 'Error', $statusCode = 400, $errors = []) {
        self::json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }
}
