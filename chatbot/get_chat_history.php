<?php
/**
 * ============================================================================
 * FIGHTER CHATBOT - GET CHAT HISTORY API
 * ============================================================================
 * File: get_chat_history.php
 * Description: Retrieve user's chat history from database
 * Version: 1.0
 * ============================================================================
 */

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    require_once 'config.php';
} catch (Exception $e) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'Lỗi tải config']);
    exit;
}

ob_clean();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Chỉ cho phép GET']);
    exit;
}

try {
    // Check database connection
    if (!isset($conn) || !$conn) {
        throw new Exception('Không thể kết nối database');
    }
    
    // Get user ID
    $userId = 0;
    if (isUserLoggedIn()) {
        $userId = $_SESSION['id_hocvien'];
    }
    
    // Get limit parameter (default 20 messages)
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
    $limit = min(max($limit, 1), 50); // Between 1-50
    
    // Get offset for pagination
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    if ($userId > 0) {
        // Get chat history from database for logged-in users
        $sql = "SELECT 
                    id,
                    user_message,
                    bot_response,
                    chat_type,
                    created_at,
                    DATE_FORMAT(created_at, '%H:%i') as time,
                    DATE_FORMAT(created_at, '%Y-%m-%d') as date
                FROM chat_history 
                WHERE id_hocvien = ? 
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception('Prepare statement failed');
        }
        
        $stmt->bind_param("iii", $userId, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = [
                'id' => $row['id'],
                'user_message' => $row['user_message'],
                'bot_response' => $row['bot_response'],
                'type' => $row['chat_type'],
                'time' => $row['time'],
                'date' => $row['date'],
                'timestamp' => strtotime($row['created_at'])
            ];
        }
        
        // Reverse to show oldest first
        $history = array_reverse($history);
        
        echo json_encode([
            'success' => true,
            'history' => $history,
            'count' => count($history),
            'user_id' => $userId,
            'limit' => $limit,
            'offset' => $offset
        ], JSON_UNESCAPED_UNICODE);
        
    } else {
        // For guests, return empty history (they will use localStorage)
        echo json_encode([
            'success' => true,
            'history' => [],
            'count' => 0,
            'user_id' => 0,
            'message' => 'Guest mode - using local storage'
        ], JSON_UNESCAPED_UNICODE);
    }
    
} catch (Exception $e) {
    error_log("Get Chat History Error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Không thể tải lịch sử chat',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
