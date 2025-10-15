<?php
session_start();
include('../config/config.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Tạo session ID unique nếu chưa có
if (!isset($_SESSION['chat_session_id'])) {
    $_SESSION['chat_session_id'] = uniqid('chat_', true);
}

$session_id = $_SESSION['chat_session_id'];
$user_id = isset($_SESSION['id_hocvien']) ? $_SESSION['id_hocvien'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'save_message':
                saveMessage($conn, $session_id, $user_id, $input['type'], $input['content']);
                break;
                
            case 'load_history':
                loadChatHistory($conn, $session_id);
                break;
                
            case 'clear_history':
                clearChatHistory($conn, $session_id);
                break;
                
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

function saveMessage($conn, $session_id, $user_id, $type, $content) {
    try {
        $sql = "INSERT INTO chat_history (id_hocvien, session_id, message_type, message_content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("isss", $user_id, $session_id, $type, $content);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $conn->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function loadChatHistory($conn, $session_id) {
    try {
        $sql = "SELECT message_type, message_content, created_at FROM chat_history 
                WHERE session_id = ? 
                ORDER BY created_at ASC 
                LIMIT 50";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $session_id);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $history = [];
            
            while ($row = $result->fetch_assoc()) {
                $history[] = [
                    'type' => $row['message_type'],
                    'content' => $row['message_content'],
                    'time' => $row['created_at']
                ];
            }
            
            echo json_encode(['success' => true, 'history' => $history]);
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function clearChatHistory($conn, $session_id) {
    try {
        $sql = "DELETE FROM chat_history WHERE session_id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $session_id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'deleted' => $stmt->affected_rows]);
            } else {
                echo json_encode(['success' => false, 'error' => $conn->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
