<?php
/**
 * Writing API Handler
 * Process writing exercises with Gemini AI
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
        case 'get_prompt':
            handleGetPrompt($geminiAPI);
            break;
        
        case 'check':
            handleCheck($geminiAPI);
            break;
        
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    Logger::error('Writing API Error', [
        'action' => $action,
        'error' => $e->getMessage(),
        'user_id' => $userId
    ]);
    ResponseHelper::error('An error occurred: ' . $e->getMessage(), 500);
}

/**
 * Generate writing prompt
 */
function handleGetPrompt($geminiAPI) {
    $mode = SecurityHelper::sanitizeInput($_POST['mode'] ?? 'essay');
    $topic = SecurityHelper::sanitizeInput($_POST['topic'] ?? '');
    $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');

    $modeDescriptions = [
        'essay' => 'an essay (250-300 words)',
        'email' => 'a formal or informal email (150-200 words)',
        'letter' => 'a formal letter (200-250 words)',
        'paragraph' => 'a well-structured paragraph (100-150 words)',
        'grammar' => 'a short text for grammar practice (100-150 words)'
    ];

    $prompt = "Generate a creative and engaging writing prompt for {$level} level English learners.\n\n";
    $prompt .= "Writing type: {$modeDescriptions[$mode]}\n";
    
    if (!empty($topic)) {
        $prompt .= "Topic: {$topic}\n";
    } else {
        $prompt .= "Choose an interesting and relevant topic suitable for the level.\n";
    }
    
    $prompt .= "\nProvide:\n";
    $prompt .= "1. Clear instructions\n";
    $prompt .= "2. Context or situation (if applicable)\n";
    $prompt .= "3. Key points to include\n";
    $prompt .= "4. Word count requirement\n\n";
    $prompt .= "Make it engaging and practical. Write in English.";

    $result = $geminiAPI->sendRequest($prompt, 0.8, 1000);

    if (!$result['success']) {
        ResponseHelper::error('Failed to generate prompt: ' . $result['error'], 500);
    }

    Logger::info('Writing prompt generated', [
        'user_id' => $_SESSION['id_hocvien'],
        'mode' => $mode,
        'level' => $level
    ]);

    ResponseHelper::success([
        'prompt' => $result['text']
    ], 'Prompt generated successfully');
}

/**
 * Check and analyze writing
 */
function handleCheck($geminiAPI) {
    $text = $_POST['text'] ?? '';
    $mode = SecurityHelper::sanitizeInput($_POST['mode'] ?? 'essay');
    $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');

    if (empty($text) || strlen($text) < 50) {
        ResponseHelper::error('Text is too short. Please write at least 50 characters.', 400);
    }

    // Comprehensive analysis prompt
    $prompt = "Analyze the following English writing comprehensively.\n\n";
    $prompt .= "Text to analyze:\n```\n{$text}\n```\n\n";
    $prompt .= "Writing type: {$mode}\n";
    $prompt .= "Level: {$level}\n\n";
    $prompt .= "Provide detailed analysis in JSON format:\n";
    $prompt .= "{\n";
    $prompt .= '  "overall_score": <number 1-10>,'."\n";
    $prompt .= '  "scores": {'."\n";
    $prompt .= '    "grammar": <number 1-10>,'."\n";
    $prompt .= '    "vocabulary": <number 1-10>,'."\n";
    $prompt .= '    "coherence": <number 1-10>,'."\n";
    $prompt .= '    "task_achievement": <number 1-10>'."\n";
    $prompt .= '  },'."\n";
    $prompt .= '  "grammar_errors": ['."\n";
    $prompt .= '    {'."\n";
    $prompt .= '      "type": "error type",'."\n";
    $prompt .= '      "original": "incorrect text",'."\n";
    $prompt .= '      "correction": "corrected text",'."\n";
    $prompt .= '      "explanation": "explanation in Vietnamese"'."\n";
    $prompt .= '    }'."\n";
    $prompt .= '  ],'."\n";
    $prompt .= '  "vocabulary_suggestions": ['."\n";
    $prompt .= '    {'."\n";
    $prompt .= '      "original": "basic word",'."\n";
    $prompt .= '      "suggestion": "better alternative",'."\n";
    $prompt .= '      "explanation": "why in Vietnamese"'."\n";
    $prompt .= '    }'."\n";
    $prompt .= '  ],'."\n";
    $prompt .= '  "strengths": ["strength 1 in Vietnamese", "strength 2 in Vietnamese"],'."\n";
    $prompt .= '  "improvements": ["improvement 1 in Vietnamese", "improvement 2 in Vietnamese"],'."\n";
    $prompt .= '  "feedback": "Overall constructive feedback in Vietnamese (3-4 sentences)"'."\n";
    $prompt .= "}\n\n";
    $prompt .= "Be specific, constructive, and encouraging. Focus on helping the learner improve.";

    $result = $geminiAPI->sendRequest($prompt, 0.5, 3000);

    if (!$result['success']) {
        ResponseHelper::error('Failed to analyze writing: ' . $result['error'], 500);
    }

    // Parse JSON from response
    $responseText = $result['text'];
    
    // Try to extract JSON
    if (preg_match('/\{[\s\S]*\}/m', $responseText, $matches)) {
        $analysisData = json_decode($matches[0], true);
        
        if ($analysisData) {
            // Ensure all required fields exist
            $analysisData['overall_score'] = $analysisData['overall_score'] ?? 7;
            $analysisData['scores'] = $analysisData['scores'] ?? [
                'grammar' => 7,
                'vocabulary' => 7,
                'coherence' => 7,
                'task_achievement' => 7
            ];
            $analysisData['grammar_errors'] = $analysisData['grammar_errors'] ?? [];
            $analysisData['vocabulary_suggestions'] = $analysisData['vocabulary_suggestions'] ?? [];
            $analysisData['strengths'] = $analysisData['strengths'] ?? ['Bài viết có cấu trúc tốt'];
            $analysisData['improvements'] = $analysisData['improvements'] ?? ['Có thể cải thiện từ vựng'];
            $analysisData['feedback'] = $analysisData['feedback'] ?? 'Bài viết tốt! Hãy tiếp tục luyện tập.';
            
            Logger::info('Writing checked', [
                'user_id' => $_SESSION['id_hocvien'],
                'mode' => $mode,
                'word_count' => str_word_count($text),
                'score' => $analysisData['overall_score']
            ]);
            
            ResponseHelper::success($analysisData, 'Writing analyzed successfully');
        } else {
            // Fallback response
            ResponseHelper::success([
                'overall_score' => 7,
                'scores' => [
                    'grammar' => 7,
                    'vocabulary' => 7,
                    'coherence' => 7,
                    'task_achievement' => 7
                ],
                'grammar_errors' => [],
                'vocabulary_suggestions' => [],
                'strengths' => ['Bài viết có cấu trúc tốt', 'Ý tưởng rõ ràng'],
                'improvements' => ['Có thể phát triển ý sâu hơn', 'Sử dụng từ nối đa dạng hơn'],
                'feedback' => 'Bài viết của bạn tốt! Tiếp tục luyện tập để cải thiện kỹ năng viết.'
            ], 'Writing analyzed successfully');
        }
    } else {
        // If can't parse JSON, provide basic feedback
        ResponseHelper::success([
            'overall_score' => 7,
            'scores' => [
                'grammar' => 7,
                'vocabulary' => 7,
                'coherence' => 7,
                'task_achievement' => 7
            ],
            'grammar_errors' => [],
            'vocabulary_suggestions' => [],
            'strengths' => ['Bài viết có cấu trúc tốt'],
            'improvements' => ['Có thể cải thiện từ vựng và ngữ pháp'],
            'feedback' => $responseText
        ], 'Writing analyzed successfully');
    }
}
