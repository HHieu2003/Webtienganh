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
        case 'generate':
            $topic = SecurityHelper::sanitizeInput($_POST['topic'] ?? 'general');
            $type = SecurityHelper::sanitizeInput($_POST['type'] ?? 'matching');
            
            $prompt = "Create 10 vocabulary questions about {$topic} in {$type} format.\n";
            $prompt .= 'Return JSON: {"questions": [{"question": "q", "options": ["A","B","C","D"], "correct": 0}]}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.8, 2000);
            
            if ($result['success'] && preg_match('/\{[\s\S]*\}/', $result['text'], $matches)) {
                $data = json_decode($matches[0], true);
                ResponseHelper::success($data ?: ['questions' => []]);
            } else {
                ResponseHelper::error('Failed to generate');
            }
            break;
            
        case 'check':
            $exercise = json_decode($_POST['exercise'] ?? '', true);
            $answers = json_decode($_POST['answers'] ?? '', true);
            
            if (!$exercise || !$answers) ResponseHelper::error('Invalid data', 400);
            
            $correctCount = 0;
            foreach ($exercise['questions'] as $i => $q) {
                if (($answers[$i] ?? -1) === ($q['correct'] ?? 0)) $correctCount++;
            }
            
            ResponseHelper::success([
                'correct_count' => $correctCount,
                'total_count' => count($exercise['questions']),
                'score' => ($correctCount / count($exercise['questions'])) * 10
            ]);
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    ResponseHelper::error('An error occurred', 500);
}
