<?php
// chatbot/config.php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'quanlykhoahoc');

// Gemini API configuration
define('GEMINI_API_KEY', 'AIzaSyCw79baxbVs0yJ8sxHH2PYUKQN3LDR2kQQ'); // Thay bằng API key thực
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');

// Chatbot settings
define('MAX_MESSAGE_LENGTH', 1000);
define('CHAT_HISTORY_LIMIT', 50);

// Connect to database
$conn = null;
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    $conn = null;
}

// Helper functions
function isUserLoggedIn() {
    return isset($_SESSION['id_hocvien']) && !empty($_SESSION['id_hocvien']);
}

function getUserInfo() {
    global $conn;
    if (!isUserLoggedIn() || !$conn) {
        return null;
    }
    
    try {
        $userId = $_SESSION['id_hocvien'];
        $sql = "SELECT * FROM hocvien WHERE id_hocvien = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
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
?>
