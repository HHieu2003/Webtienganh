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
    $questionCount = intval($_POST['question_count'] ?? 5);
    
    // Limit question count (increased to 20)
    $questionCount = max(3, min(20, $questionCount));

    // Level descriptions
    $levelDescriptions = [
        'beginner' => 'A1-A2 (Basic vocabulary, simple sentences, everyday topics)',
        'elementary' => 'A2 (Familiar daily situations, basic conversations)',
        'intermediate' => 'B1 (Common topics, standard speech, clear pronunciation)',
        'upper_intermediate' => 'B2 (Complex topics, extended speech, idiomatic expressions)',
        'advanced' => 'C1 (Sophisticated content, nuanced meanings, varied accents)',
        'proficiency' => 'C2 (Native-like understanding, abstract topics, all accents)',
        'ielts_5' => 'IELTS 5.0-6.0 (Academic/general content, moderate complexity)',
        'ielts_7' => 'IELTS 7.0-8.0 (Academic discourse, inference questions)',
        'toeic_600' => 'TOEIC 600-700 (Business context, office situations)',
        'toeic_800' => 'TOEIC 800+ (Complex business, meetings, presentations)'
    ];

    $levelDesc = $levelDescriptions[$level] ?? $levelDescriptions['intermediate'];

    // Create prompt for Gemini
    $prompt = "Create an English listening comprehension exercise.\n\n";
    $prompt .= "Level: {$levelDesc}\n";
    if (!empty($topic)) {
        $prompt .= "Topic: {$topic}\n";
    } else {
        $prompt .= "Topic: Choose an engaging and relevant topic for this level\n";
    }
    $prompt .= "\nGenerate:\n";
    $prompt .= "1. A natural, engaging English text suitable for listening practice\n";
    $prompt .= "   - Length: " . ($questionCount <= 5 ? "200-300" : ($questionCount <= 10 ? "350-500" : "500-700")) . " words\n";
    $prompt .= "   - Use appropriate vocabulary and grammar for the level\n";
    $prompt .= "   - Include clear context and interesting content\n";
    $prompt .= "   - Make it sound natural as spoken English\n";
    $prompt .= "2. {$questionCount} multiple choice questions to test comprehension\n";
    $prompt .= "   - Include different question types: main idea, details, inference, vocabulary\n";
    $prompt .= "   - Each question should have 4 options (A, B, C, D)\n";
    $prompt .= "   - Make distractors plausible but clearly wrong\n";
    $prompt .= "3. A short title (max 10 words)\n\n";
    $prompt .= "Return ONLY valid JSON in this exact format:\n";
    $prompt .= "{\n";
    $prompt .= '  "title": "Exercise Title",'."\n";
    $prompt .= '  "text": "The listening passage text...",'."\n";
    $prompt .= '  "questions": ['."\n";
    $prompt .= "    {\n";
    $prompt .= '      "question": "Question text?",'."\n";
    $prompt .= '      "options": ["Option A", "Option B", "Option C", "Option D"],'."\n";
    $prompt .= '      "correct": 0,'."\n";
    $prompt .= '      "type": "main_idea"'."\n";
    $prompt .= "    }\n";
    $prompt .= "  ]\n";
    $prompt .= "}\n\n";
    $prompt .= "Question types: main_idea, detail, inference, vocabulary, tone";

    $result = $geminiAPI->sendRequest($prompt, 0.8, 2500);

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
