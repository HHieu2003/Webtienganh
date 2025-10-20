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
        case 'get_word':
            $focus = SecurityHelper::sanitizeInput($_POST['focus'] ?? 'vowels');
            
            $prompt = "Generate a word or phrase for English pronunciation practice focusing on {$focus}.\n";
            $prompt .= 'Return JSON: {"word": "word", "phonetic": "IPA phonetic", "tip": "pronunciation tip in Vietnamese"}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.8);
            
            if ($result['success'] && preg_match('/\{[^\}]+\}/', $result['text'], $matches)) {
                $data = json_decode($matches[0], true);
                ResponseHelper::success($data ?: ['word' => 'Hello', 'phonetic' => '/həˈloʊ/', 'tip' => 'Phát âm rõ ràng']);
            } else {
                ResponseHelper::success(['word' => 'Hello', 'phonetic' => '/həˈloʊ/', 'tip' => 'Phát âm rõ ràng']);
            }
            break;
            
        case 'check':
            $target = $_POST['target'] ?? '';
            $userInput = $_POST['user_input'] ?? '';
            
            if (empty($userInput)) ResponseHelper::error('No pronunciation provided', 400);
            
            $prompt = "Compare pronunciation:\nTarget: {$target}\nUser said: {$userInput}\n\n";
            $prompt .= "Provide feedback in Vietnamese. Give a score 1-10 and constructive feedback.";
            $prompt .= "\nReturn JSON: {\"score\": <1-10>, \"feedback\": \"feedback in Vietnamese\"}";
            
            $result = $geminiAPI->sendRequest($prompt, 0.5);
            
            if ($result['success']) {
                if (preg_match('/\{[^\}]+\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    ResponseHelper::success($data ?: ['score' => 7, 'feedback' => 'Phát âm tốt!']);
                } else {
                    ResponseHelper::success(['score' => 7, 'feedback' => $result['text']]);
                }
            } else {
                ResponseHelper::error('Failed to check');
            }
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    ResponseHelper::error('An error occurred', 500);
}
