<?php
require_once 'config.php';
require_once 'api_handler.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id_hocvien'])) ResponseHelper::error('Unauthorized', 401);
if (!isset($_POST['csrf_token']) || !SecurityHelper::verifyCSRFToken($_POST['csrf_token'])) ResponseHelper::error('Invalid CSRF token', 403);
if (!RateLimiter::checkLimit($_SESSION['id_hocvien'])) ResponseHelper::error('Rate limit exceeded', 429);

$action = $_POST['action'] ?? '';
$apiService = APIService::getInstance();
$geminiAPI = $apiService->getHandler();

try {
    switch ($action) {
        case 'start':
            $scenario = SecurityHelper::sanitizeInput($_POST['scenario'] ?? 'general');
            
            $scenarioMap = [
                'shopping' => 'shopping at a store',
                'restaurant' => 'ordering food at a restaurant',
                'hotel' => 'checking in at a hotel',
                'airport' => 'at the airport',
                'interview' => 'a job interview',
                'phone' => 'a phone conversation',
                'meeting' => 'a business meeting'
            ];
            
            $scenarioDesc = $scenarioMap[$scenario] ?? 'a general conversation';
            
            $prompt = "You are a friendly English conversation partner. Start a conversation about {$scenarioDesc}.\n";
            $prompt .= "Greet the user and set the scene in 2-3 sentences. Be natural and encouraging.";
            
            $result = $geminiAPI->sendRequest($prompt, 0.9);
            
            if ($result['success']) {
                $_SESSION['communication_scenario'] = $scenario;
                ResponseHelper::success(['greeting' => $result['text']]);
            } else {
                ResponseHelper::error('Failed to start conversation');
            }
            break;
            
        case 'reply':
            $message = SecurityHelper::sanitizeInput($_POST['message'] ?? '');
            $history = json_decode($_POST['history'] ?? '[]', true);
            
            if (empty($message)) ResponseHelper::error('No message provided', 400);
            
            $prompt = "You are a friendly English conversation partner. Continue this conversation naturally.\n\n";
            $prompt .= "Previous messages:\n";
            foreach (array_slice($history, -5) as $msg) {
                $prompt .= ($msg['role'] === 'user' ? 'User' : 'AI') . ": " . $msg['text'] . "\n";
            }
            $prompt .= "User: {$message}\n\nRespond naturally in 2-3 sentences. Be encouraging and helpful.";
            
            $result = $geminiAPI->sendRequest($prompt, 0.9);
            
            if ($result['success']) {
                ResponseHelper::success(['reply' => $result['text']]);
            } else {
                ResponseHelper::error('Failed to generate reply');
            }
            break;
            
        case 'feedback':
            $history = json_decode($_POST['history'] ?? '[]', true);
            
            if (empty($history)) ResponseHelper::error('No conversation history', 400);
            
            $prompt = "Analyze this English conversation and provide feedback in Vietnamese:\n\n";
            foreach ($history as $msg) {
                $prompt .= ($msg['role'] === 'user' ? 'Người học' : 'AI') . ": " . $msg['text'] . "\n";
            }
            $prompt .= "\nProvide: 1) Score 1-10 for communication effectiveness 2) Brief constructive feedback in Vietnamese\n";
            $prompt .= 'Return JSON: {"score": <1-10>, "feedback": "feedback in Vietnamese"}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.5);
            
            if ($result['success']) {
                if (preg_match('/\{[^\}]+\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    ResponseHelper::success($data ?: ['score' => 7, 'feedback' => 'Bạn giao tiếp tốt!']);
                } else {
                    ResponseHelper::success(['score' => 7, 'feedback' => $result['text']]);
                }
            } else {
                ResponseHelper::error('Failed to generate feedback');
            }
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    ResponseHelper::error('An error occurred', 500);
}
