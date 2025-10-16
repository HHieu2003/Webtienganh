<?php
/**
 * ============================================================================
 * FIGHTER CHATBOT - CONFIGURATION
 * ============================================================================
 * File: config.php
 * Description: Database connection and configuration settings
 * Version: 2.0 - Fixed duplicate function declarations
 * ============================================================================
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/chatbot_errors.log');

// ============================================================================
// DATABASE CONFIGURATION
// ============================================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'quanlykhoahoc');

// ============================================================================
// API CONFIGURATION
// ============================================================================
define('GEMINI_API_KEY', 'AIzaSyCw79baxbVs0yJ8sxHH2PYUKQN3LDR2kQQ');
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent');

// ============================================================================
// CHATBOT SETTINGS
// ============================================================================
define('MAX_MESSAGE_LENGTH', 1000);
define('SESSION_TIMEOUT', 3600);
define('MAX_CHAT_HISTORY', 50);

// ============================================================================
// DATABASE CONNECTION
// ============================================================================
$conn = null;

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    // Fallback: Set $conn to null so scripts can handle it gracefully
    $conn = null;
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in, false otherwise
 */
function isUserLoggedIn() {
    return isset($_SESSION['id_hocvien']) && !empty($_SESSION['id_hocvien']);
}

/**
 * Get current user information from database
 * 
 * @return array|null User data or null if not found
 */
function getUserInfo() {
    global $conn;
    
    if (!isUserLoggedIn() || !$conn) {
        return null;
    }
    
    try {
        $userId = $_SESSION['id_hocvien'];
        
        // Try different possible ID column names
        $possibleColumns = ['id_hocvien', 'id', 'ma_hocvien'];
        $idColumn = 'id_hocvien'; // default
        
        // Check which column exists
        foreach ($possibleColumns as $column) {
            $checkSql = "SHOW COLUMNS FROM hocvien LIKE '$column'";
            $result = $conn->query($checkSql);
            if ($result && $result->num_rows > 0) {
                $idColumn = $column;
                break;
            }
        }
        
        // Get user data
        $sql = "SELECT * FROM hocvien WHERE $idColumn = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Prepare statement failed: " . $conn->error);
            return null;
        }
        
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
        
    } catch (Exception $e) {
        error_log("getUserInfo error: " . $e->getMessage());
        return null;
    }
}

// ============================================================================
// NOTE: logChatMessage() and createChatHistoryTable() functions are now
// defined in chat_handler.php to avoid duplicate function declarations
// ============================================================================

?>
