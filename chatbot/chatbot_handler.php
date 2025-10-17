<?php
// chatbot/chatbot_handler.php - Updated to use conversation context

require_once 'config.php';
require_once 'ChatbotService.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? 'chat';

try {
    if (!$conn) {
        throw new Exception('Không thể kết nối database');
    }

    // Get user info
    $userId = 0;
    $userName = null;
    $userInfo = getUserInfo();
    if ($userInfo) {
        $userId = $userInfo['id_hocvien'] ?? 0;
        $userName = $userInfo['ten_hocvien'] ?? null;
    }

    // Initialize chatbot service with userId (để load context)
    $chatbot = new ChatbotService($conn, $userId);

    // Route by action
    switch ($action) {
        case 'chat':
            handleChatRequest($chatbot, $userId, $userName);
            break;

        case 'history':
            handleHistoryRequest($chatbot, $userId);
            break;

        case 'quick_actions':
            handleQuickActionsRequest($conn);
            break;

        case 'clear_context':
            handleClearContext($chatbot, $userId);
            break;

        case 'get_context':
            handleGetContext($chatbot);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * Xử lý chat request WITH CONTEXT
 */
function handleChatRequest($chatbot, $userId, $userName)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Chỉ cho phép POST');
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['message']) || empty(trim($input['message']))) {
        throw new Exception('Tin nhắn không được để trống');
    }

    $message = trim(strip_tags($input['message']));

    if (strlen($message) > MAX_MESSAGE_LENGTH) {
        throw new Exception('Tin nhắn quá dài! Tối đa ' . MAX_MESSAGE_LENGTH . ' ký tự.');
    }

    // Detect intent
    $intent = $chatbot->detectIntent($message);

    $response = '';
    $chatType = 'general';

    // Route by intent (WITH CONTEXT)
    switch ($intent) {
        case 'english_learning':
            $result = $chatbot->teachEnglish($message, true); // true = include context
            $response = $result['response'] ?? 'Xin lỗi, tôi không thể trả lời câu hỏi này.';
            $chatType = $result['type'] ?? 'ai_teaching';
            break;

        case 'center_info':
            $result = $chatbot->getDatabaseAdvice($message, true); // true = include context
            if ($result) {
                $response = $result['response'];
                $chatType = $result['type'];
            } else {
                $result = $chatbot->teachEnglish($message, true);
                $response = $result['response'] ?? 'Xin lỗi, tôi không thể trả lời câu hỏi này.';
                $chatType = 'ai_teaching';
            }
            break;

        case 'mixed':
            $result = $chatbot->getDatabaseAdvice($message, true);
            if ($result && !empty($result['context'])) {
                $response = $result['response'];
                $chatType = $result['type'];
            } else {
                $result = $chatbot->teachEnglish($message, true);
                $response = $result['response'] ?? 'Xin lỗi, tôi không thể trả lời câu hỏi này.';
                $chatType = 'ai_teaching';
            }
            break;
        case 'general':
            $result = $chatbot->answerGeneral($message, true);
            $response = $result['response'] ?? 'Xin lỗi, tôi không thể trả lời câu hỏi này.';
            $chatType = $result['type'] ?? 'general_ai';
            break;
    }

    // Save to database
    $chatbot->saveChatHistory($userId, $message, $response, $chatType);

    // Get context summary for debugging
    $contextSummary = $chatbot->getContextSummary();

    // Return response with context info
    echo json_encode([
        'success' => true,
        'response' => $response,
        'type' => $chatType,
        'intent' => $intent,
        'context_info' => $contextSummary,
        'timestamp' => time()
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * NEW: Clear conversation context
 */
/**
 * NEW: Clear conversation context AND database history
 */
function handleClearContext($chatbot, $userId)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Chỉ cho phép POST');
    }

    // Clear memory context
    $chatbot->clearContext();

    // Clear database history
    if ($userId > 0) {
        $chatbot->clearChatHistory($userId);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Context and history cleared successfully'
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * NEW: Get current context
 */
function handleGetContext($chatbot)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Chỉ cho phép GET');
    }

    $context = $chatbot->getContext();
    $summary = $chatbot->getContextSummary();

    echo json_encode([
        'success' => true,
        'context' => $context,
        'summary' => $summary
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * Xử lý history request
 */
function handleHistoryRequest($chatbot, $userId)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Chỉ cho phép GET');
    }

    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
    $limit = min(max($limit, 1), 50);

    // ✅ THÊM LOG
    error_log("📊 Loading history for userId: {$userId}, limit: {$limit}");

    if ($userId > 0) {
        $history = $chatbot->getChatHistory($userId, $limit);

        // ✅ THÊM LOG
        error_log("📦 Found " . count($history) . " history items");

        $messages = [];
        foreach ($history as $item) {
            $messages[] = [
                'content' => $item['user_message'],
                'sender' => 'user',
                'time' => $item['time'],
                'timestamp' => $item['timestamp']
            ];
            $messages[] = [
                'content' => $item['bot_response'],
                'sender' => 'bot',
                'time' => $item['time'],
                'timestamp' => $item['timestamp']
            ];
        }

        echo json_encode([
            'success' => true,
            'history' => $messages,
            'count' => count($messages),
            'userid' => $userId
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            'success' => true,
            'history' => [],
            'count' => 0,
            'userid' => 0,
            'message' => 'Guest mode'
        ], JSON_UNESCAPED_UNICODE);
    }
}

/**
 * Xử lý quick actions request
 */
function handleQuickActionsRequest($conn)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Chỉ cho phép GET');
    }

    $quickActions = [];

    $sql = "SELECT ten_khoahoc, chi_phi FROM khoahoc ORDER BY danh_gia_tb DESC LIMIT 2";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $quickActions[] = [
                'type' => 'course',
                'icon' => 'fas fa-graduation-cap',
                'label' => $row['ten_khoahoc'],
                'message' => 'Tôi muốn biết về khóa ' . $row['ten_khoahoc']
            ];
        }
    }

    $commonActions = [
        [
            'type' => 'faq',
            'icon' => 'fas fa-money-bill-wave',
            'label' => 'Học phí',
            'message' => 'Học phí các khóa học bao nhiêu?'
        ],
        [
            'type' => 'faq',
            'icon' => 'fas fa-calendar',
            'label' => 'Lịch học',
            'message' => 'Lịch học như thế nào?'
        ],
        [
            'type' => 'faq',
            'icon' => 'fas fa-book',
            'label' => 'Học tiếng Anh',
            'message' => 'Cách học tiếng Anh hiệu quả'
        ],
        [
            'type' => 'faq',
            'icon' => 'fas fa-phone',
            'label' => 'Liên hệ',
            'message' => 'Thông tin liên hệ trung tâm'
        ]
    ];

    $quickActions = array_merge($quickActions, $commonActions);
    $quickActions = array_slice($quickActions, 0, 6);

    echo json_encode([
        'success' => true,
        'actions' => $quickActions,
        'count' => count($quickActions)
    ], JSON_UNESCAPED_UNICODE);
}
