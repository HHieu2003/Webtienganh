<?php
/**
 * Listening API Handler
 * Process listening exercises with Gemini AI
 */

require_once 'config.php';
require_once 'api_handler.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check authentication
if (!isset($_SESSION['id_hocvien'])) {
    ResponseHelper::error('Unauthorized', 401);
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !SecurityHelper::verifyCSRFToken($_POST['csrf_token'])) {
    ResponseHelper::error('Invalid CSRF token', 403);
}

// Rate limiting
$userId = $_SESSION['id_hocvien'];
if (!RateLimiter::checkLimit($userId)) {
    ResponseHelper::error('Rate limit exceeded. Please try again later.', 429);
}

// Get action
$action = $_POST['action'] ?? '';

// Initialize API handler
$apiService = APIService::getInstance();
$geminiAPI = $apiService->getHandler();

try {
    switch ($action) {
        case 'generate':
            handleGenerate($geminiAPI);
            break;
        
        case 'check':
            handleCheck($geminiAPI);
            break;
        
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    Logger::error('Listening API Error', [
        'action' => $action,
        'error' => $e->getMessage(),
        'user_id' => $userId
    ]);
    ResponseHelper::error('An error occurred: ' . $e->getMessage(), 500);
}

/**
 * Generate listening exercise
 */
function handleGenerate($geminiAPI) {
    $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');
    $topic = SecurityHelper::sanitizeInput($_POST['topic'] ?? '');

    // Create prompt for Gemini
    $prompt = "Create an English listening comprehension exercise.\n\n";
    $prompt .= "Level: {$level}\n";
    if (!empty($topic)) {
        $prompt .= "Topic: {$topic}\n";
    }
    $prompt .= "\nGenerate:\n";
    $prompt .= "1. A natural English text (150-250 words) suitable for listening practice\n";
    $prompt .= "2. 5 multiple choice questions to test comprehension\n";
    $prompt .= "3. Each question should have 4 options\n\n";
    $prompt .= "Return ONLY valid JSON in this exact format:\n";
    $prompt .= "{\n";
    $prompt .= '  "text": "The listening passage text...",'."\n";
    $prompt .= '  "questions": ['."\n";
    $prompt .= "    {\n";
    $prompt .= '      "question": "Question text?",'."\n";
    $prompt .= '      "options": ["A", "B", "C", "D"],'."\n";
    $prompt .= '      "correct": 0'."\n";
    $prompt .= "    }\n";
    $prompt .= "  ]\n";
    $prompt .= "}";

    $result = $geminiAPI->sendRequest($prompt, 0.8, 2000);

    if (!$result['success']) {
        ResponseHelper::error('Failed to generate exercise: ' . $result['error'], 500);
    }

    // Parse JSON from response
    $text = $result['text'];
    
    // Try to extract JSON
    if (preg_match('/\{[\s\S]*\}/m', $text, $matches)) {
        $jsonData = json_decode($matches[0], true);
        
        if ($jsonData && isset($jsonData['text']) && isset($jsonData['questions'])) {
            Logger::info('Listening exercise generated', [
                'user_id' => $_SESSION['id_hocvien'],
                'level' => $level,
                'topic' => $topic
            ]);
            
            ResponseHelper::success($jsonData, 'Exercise generated successfully');
        } else {
            ResponseHelper::error('Invalid JSON format from AI', 500);
        }
    } else {
        ResponseHelper::error('Failed to parse AI response', 500);
    }
}

/**
 * Check listening answers
 */
function handleCheck($geminiAPI) {
    $exerciseJson = $_POST['exercise'] ?? '';
    $answersJson = $_POST['answers'] ?? '';

    if (empty($exerciseJson) || empty($answersJson)) {
        ResponseHelper::error('Missing exercise or answers data', 400);
    }

    $exercise = json_decode($exerciseJson, true);
    $userAnswers = json_decode($answersJson, true);

    if (!$exercise || !is_array($userAnswers)) {
        ResponseHelper::error('Invalid data format', 400);
    }

    // Check answers
    $correctCount = 0;
    $totalCount = count($exercise['questions']);
    $details = [];

    foreach ($exercise['questions'] as $index => $question) {
        $userAnswer = $userAnswers[$index] ?? -1;
        $correctAnswer = $question['correct'] ?? 0;
        $isCorrect = ($userAnswer === $correctAnswer);

        if ($isCorrect) {
            $correctCount++;
        }

        $details[] = [
            'question' => $question['question'],
            'user_answer' => $userAnswer >= 0 ? $question['options'][$userAnswer] : 'No answer',
            'correct_answer' => $question['options'][$correctAnswer],
            'is_correct' => $isCorrect,
            'feedback' => $isCorrect ? 'Chính xác!' : 'Cần xem lại.'
        ];
    }

    $score = ($correctCount / $totalCount) * 10;

    // Generate AI feedback
    $feedbackPrompt = "Provide brief encouraging feedback in Vietnamese for a listening test result:\n";
    $feedbackPrompt .= "Score: {$correctCount}/{$totalCount} correct answers\n";
    $feedbackPrompt .= "Give 2-3 sentences of constructive feedback and encouragement.";

    $feedbackResult = $geminiAPI->sendRequest($feedbackPrompt, 0.7, 200);
    $overallFeedback = $feedbackResult['success'] ? $feedbackResult['text'] : 'Tốt lắm! Hãy tiếp tục luyện tập.';

    Logger::info('Listening exercise checked', [
        'user_id' => $_SESSION['id_hocvien'],
        'score' => $score,
        'correct' => $correctCount,
        'total' => $totalCount
    ]);

    ResponseHelper::success([
        'correct_count' => $correctCount,
        'total_count' => $totalCount,
        'score' => $score,
        'details' => $details,
        'feedback' => $overallFeedback
    ], 'Answers checked successfully');
}
