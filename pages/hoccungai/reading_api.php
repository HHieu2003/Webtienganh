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
        case 'generate':
            $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');
            $topic = SecurityHelper::sanitizeInput($_POST['topic'] ?? '');
            
            $prompt = "Create a reading comprehension passage for {$level} level.\n";
            if ($topic) $prompt .= "Topic: {$topic}\n";
            $prompt .= "\nGenerate:\n1. A passage (200-300 words)\n2. 5 comprehension questions with 4 options each\n\n";
            $prompt .= 'Return JSON: {"passage": "text", "questions": [{"question": "q", "options": ["A","B","C","D"], "correct": 0}]}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.8, 2500);
            
            if ($result['success'] && preg_match('/\{[\s\S]*\}/', $result['text'], $matches)) {
                $data = json_decode($matches[0], true);
                ResponseHelper::success($data ?: ['passage' => $result['text'], 'questions' => []]);
            } else {
                ResponseHelper::error('Failed to generate');
            }
            break;
            
        case 'check':
            $exercise = json_decode($_POST['exercise'] ?? '', true);
            $answers = json_decode($_POST['answers'] ?? '', true);
            
            if (!$exercise || !$answers) ResponseHelper::error('Invalid data', 400);
            
            $correctCount = 0;
            $totalCount = count($exercise['questions']);
            $details = [];
            
            foreach ($exercise['questions'] as $i => $q) {
                $userAnswer = $answers[$i] ?? -1;
                $isCorrect = ($userAnswer === ($q['correct'] ?? 0));
                if ($isCorrect) $correctCount++;
                
                $details[] = [
                    'question' => $q['question'],
                    'is_correct' => $isCorrect,
                    'user_answer' => $userAnswer >= 0 ? $q['options'][$userAnswer] : 'No answer',
                    'correct_answer' => $q['options'][$q['correct'] ?? 0]
                ];
            }
            
            ResponseHelper::success([
                'correct_count' => $correctCount,
                'total_count' => $totalCount,
                'score' => ($correctCount / $totalCount) * 10,
                'details' => $details
            ]);
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    Logger::error('Reading API Error', ['error' => $e->getMessage()]);
    ResponseHelper::error('An error occurred', 500);
}
