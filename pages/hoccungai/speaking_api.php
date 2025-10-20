<?php
require_once 'config.php';
require_once 'api_handler.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id_hocvien'])) ResponseHelper::error('Unauthorized', 401);
if (!isset($_POST['csrf_token']) || !SecurityHelper::verifyCSRFToken($_POST['csrf_token'])) ResponseHelper::error('Invalid CSRF token', 403);

$userId = $_SESSION['id_hocvien'];
if (!RateLimiter::checkLimit($userId)) ResponseHelper::error('Rate limit exceeded', 429);

$action = $_POST['action'] ?? '';
$apiService = APIService::getInstance();
$geminiAPI = $apiService->getHandler();

try {
    switch ($action) {
        case 'get_question':
            $topic = SecurityHelper::sanitizeInput($_POST['topic'] ?? 'general');
            $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');
            
            $topicMap = [
                'self-introduction' => 'introducing yourself',
                'daily-routine' => 'daily activities and routines',
                'hobbies' => 'hobbies and interests',
                'travel' => 'travel and tourism',
                'food' => 'food and cuisine',
                'technology' => 'technology',
                'education' => 'education',
                'work' => 'work and career'
            ];
            
            $topicDesc = $topicMap[$topic] ?? 'general conversation';
            
            $prompt = "Generate a speaking question for {$level} level English learners about {$topicDesc}.\n\n";
            $prompt .= "Provide a JSON response:\n";
            $prompt .= '{"question": "The question", "instruction": "Brief instruction in Vietnamese"}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.8);
            
            if ($result['success']) {
                if (preg_match('/\{[^\}]+\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    ResponseHelper::success($data ?: ['question' => $result['text'], 'instruction' => 'Trả lời câu hỏi này']);
                } else {
                    ResponseHelper::success(['question' => $result['text'], 'instruction' => 'Trả lời câu hỏi này']);
                }
            } else {
                ResponseHelper::error('Failed to generate question');
            }
            break;
            
        case 'analyze':
            $question = $_POST['question'] ?? '';
            $answer = $_POST['answer'] ?? '';
            
            if (empty($answer)) ResponseHelper::error('No answer provided', 400);
            
            $prompt = "Analyze this speaking response:\n\nQuestion: {$question}\nAnswer: {$answer}\n\n";
            $prompt .= "Provide analysis in JSON:\n";
            $prompt .= '{"scores": {"fluency": <1-10>, "pronunciation": <1-10>, "grammar": <1-10>, "vocabulary": <1-10>, "relevance": <1-10>}, "feedback": "feedback in Vietnamese", "suggestions": ["suggestion 1", "suggestion 2"]}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.5);
            
            if ($result['success']) {
                if (preg_match('/\{[\s\S]*\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    ResponseHelper::success($data ?: ['scores' => ['fluency' => 7, 'pronunciation' => 7, 'grammar' => 7, 'vocabulary' => 7, 'relevance' => 7], 'feedback' => 'Tốt lắm!', 'suggestions' => []]);
                } else {
                    ResponseHelper::success(['scores' => ['fluency' => 7, 'pronunciation' => 7, 'grammar' => 7, 'vocabulary' => 7, 'relevance' => 7], 'feedback' => $result['text'], 'suggestions' => []]);
                }
            } else {
                ResponseHelper::error('Failed to analyze');
            }
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    Logger::error('Speaking API Error', ['error' => $e->getMessage()]);
    ResponseHelper::error('An error occurred', 500);
}
