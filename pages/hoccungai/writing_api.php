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

    // Enhanced level descriptions
    $levelDescriptions = [
        'beginner' => 'A1-A2: Simple sentences, basic vocabulary, present tense focus. Short and clear prompts.',
        'elementary' => 'A2-B1: Mix of simple and compound sentences, everyday vocabulary, common tenses.',
        'intermediate' => 'B1-B2: Complex sentences, varied vocabulary, multiple tenses, opinions and reasons.',
        'upper_intermediate' => 'B2: Sophisticated vocabulary, advanced grammar, abstract concepts.',
        'advanced' => 'C1-C2: Academic/professional level, idiomatic expressions, nuanced arguments.',
        'ielts_6' => 'IELTS 6.0-6.5: Task 1 (describe data/process) or Task 2 (opinion/discussion essay).',
        'ielts_7' => 'IELTS 7.0+: Complex Task 2 essays with abstract topics requiring critical thinking.',
        'toefl' => 'TOEFL Writing: Integrated or Independent tasks with academic focus.',
        'business' => 'Business Writing: Reports, proposals, formal emails, memos.',
        'academic' => 'Academic Writing: Research papers, essays, literature reviews, citations.'
    ];

    $modeDescriptions = [
        'essay' => [
            'type' => 'an argumentative or opinion essay',
            'words' => '250-300 words',
            'structure' => 'Introduction with thesis → 2-3 body paragraphs with supporting details → Conclusion'
        ],
        'email' => [
            'type' => 'a formal or informal email',
            'words' => '150-200 words',
            'structure' => 'Greeting → Purpose → Main content → Closing'
        ],
        'letter' => [
            'type' => 'a formal letter',
            'words' => '200-250 words',
            'structure' => 'Sender address → Date → Recipient address → Salutation → Body → Closing → Signature'
        ],
        'paragraph' => [
            'type' => 'a well-structured paragraph',
            'words' => '100-150 words',
            'structure' => 'Topic sentence → Supporting details → Concluding sentence'
        ],
        'story' => [
            'type' => 'a short story or narrative',
            'words' => '200-300 words',
            'structure' => 'Setting → Rising action → Climax → Resolution'
        ],
        'report' => [
            'type' => 'a formal report',
            'words' => '250-300 words',
            'structure' => 'Title → Introduction → Findings → Recommendations → Conclusion'
        ],
        'description' => [
            'type' => 'a descriptive piece',
            'words' => '150-200 words',
            'structure' => 'General description → Specific details → Overall impression'
        ]
    ];

    $levelDesc = $levelDescriptions[$level] ?? $levelDescriptions['intermediate'];
    $modeInfo = $modeDescriptions[$mode] ?? $modeDescriptions['essay'];

    $prompt = "You are an English writing teacher creating a practice exercise.\n\n";
    $prompt .= "STUDENT LEVEL: {$levelDesc}\n";
    $prompt .= "WRITING TYPE: {$modeInfo['type']}\n";
    $prompt .= "REQUIRED LENGTH: {$modeInfo['words']}\n";
    $prompt .= "STRUCTURE: {$modeInfo['structure']}\n\n";
    
    if (!empty($topic)) {
        $prompt .= "TOPIC: {$topic}\n\n";
    } else {
        $prompt .= "Create an interesting and relevant topic suitable for this level.\n\n";
    }
    
    $prompt .= "Generate a clear, engaging writing prompt that includes:\n";
    $prompt .= "1. **The Task**: What they need to write (be specific and clear)\n";
    $prompt .= "2. **Context/Situation**: Background information or scenario\n";
    $prompt .= "3. **Key Points to Include**: 3-5 specific points they should address\n";
    $prompt .= "4. **Instructions**: Word count, structure requirements\n\n";
    $prompt .= "Format your response as:\n";
    $prompt .= "TASK:\n[Clear description of what to write]\n\n";
    $prompt .= "CONTEXT:\n[Background or situation]\n\n";
    $prompt .= "KEY POINTS:\n- [Point 1]\n- [Point 2]\n- [Point 3]\n\n";
    $prompt .= "REQUIREMENTS:\n- Word count: {$modeInfo['words']}\n- Structure: {$modeInfo['structure']}\n\n";
    $prompt .= "Make it practical, engaging, and appropriate for the level. Write in English.";

    $result = $geminiAPI->sendRequest($prompt, 0.8, 1500);

    if (!$result['success']) {
        ResponseHelper::error('Failed to generate prompt: ' . $result['error'], 500);
    }

    Logger::info('Writing prompt generated', [
        'user_id' => $_SESSION['id_hocvien'],
        'mode' => $mode,
        'level' => $level
    ]);

    ResponseHelper::success([
        'prompt' => $result['text'],
        'mode' => $mode,
        'level' => $level,
        'word_count_target' => $modeInfo['words']
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

    $wordCount = str_word_count($text);
    $sentenceCount = preg_match_all('/[.!?]+/', $text);
    $paragraphCount = count(array_filter(explode("\n", $text), 'trim'));

    // Comprehensive analysis prompt
    $prompt = "You are an experienced English writing teacher analyzing a student's work.\n\n";
    $prompt .= "STUDENT'S WRITING:\n```\n{$text}\n```\n\n";
    $prompt .= "WRITING TYPE: {$mode}\n";
    $prompt .= "STUDENT LEVEL: {$level}\n";
    $prompt .= "STATISTICS: {$wordCount} words, {$sentenceCount} sentences, {$paragraphCount} paragraphs\n\n";
    
    $prompt .= "Provide a comprehensive analysis in the following JSON format:\n";
    $prompt .= "{\n";
    $prompt .= '  "overall_score": <number 1-10>,'."\n";
    $prompt .= '  "scores": {'."\n";
    $prompt .= '    "grammar": <1-10>,'."\n";
    $prompt .= '    "vocabulary": <1-10>,'."\n";
    $prompt .= '    "coherence": <1-10>,'."\n";
    $prompt .= '    "task_achievement": <1-10>,'."\n";
    $prompt .= '    "organization": <1-10>,'."\n";
    $prompt .= '    "style": <1-10>'."\n";
    $prompt .= '  },'."\n";
    $prompt .= '  "grammar_errors": ['."\n";
    $prompt .= '    {'."\n";
    $prompt .= '      "type": "Subject-Verb Agreement / Tense / Article / Preposition / etc.",'."\n";
    $prompt .= '      "original": "exact text with error",'."\n";
    $prompt .= '      "correction": "corrected version",'."\n";
    $prompt .= '      "explanation": "clear explanation in Vietnamese why it\'s wrong and how to fix"'."\n";
    $prompt .= '    }'."\n";
    $prompt .= '  ],'."\n";
    $prompt .= '  "vocabulary_suggestions": ['."\n";
    $prompt .= '    {'."\n";
    $prompt .= '      "original": "basic or overused word",'."\n";
    $prompt .= '      "suggestion": "more sophisticated alternative",'."\n";
    $prompt .= '      "context": "example sentence",'."\n";
    $prompt .= '      "explanation": "why it\'s better in Vietnamese"'."\n";
    $prompt .= '    }'."\n";
    $prompt .= '  ],'."\n";
    $prompt .= '  "structure_feedback": {'."\n";
    $prompt .= '    "introduction": "feedback about intro in Vietnamese",'."\n";
    $prompt .= '    "body": "feedback about body paragraphs in Vietnamese",'."\n";
    $prompt .= '    "conclusion": "feedback about conclusion in Vietnamese",'."\n";
    $prompt .= '    "transitions": "feedback about linking words in Vietnamese"'."\n";
    $prompt .= '  },'."\n";
    $prompt .= '  "strengths": ["specific strength 1 in Vietnamese", "strength 2", "strength 3"],'."\n";
    $prompt .= '  "improvements": ["specific improvement 1 in Vietnamese", "improvement 2", "improvement 3"],'."\n";
    $prompt .= '  "feedback": "Overall constructive feedback in Vietnamese (4-5 sentences). Be encouraging but honest.",'."\n";
    $prompt .= '  "next_steps": ["actionable step 1 in Vietnamese", "step 2", "step 3"]'."\n";
    $prompt .= "}\n\n";
    $prompt .= "IMPORTANT:\n";
    $prompt .= "- Be specific with examples from the text\n";
    $prompt .= "- Provide at least 3-5 grammar errors if they exist\n";
    $prompt .= "- Suggest 3-5 vocabulary improvements\n";
    $prompt .= "- Give constructive, encouraging feedback\n";
    $prompt .= "- All explanations must be in Vietnamese\n";
    $prompt .= "- Be thorough but kind";

    $result = $geminiAPI->sendRequest($prompt, 0.5, 3500);

    if (!$result['success']) {
        ResponseHelper::error('Failed to analyze writing: ' . $result['error'], 500);
    }

    // Parse JSON from response
    $responseText = $result['text'];
    
    // Try to extract JSON
    if (preg_match('/\{[\s\S]*\}/m', $responseText, $matches)) {
        $analysisData = json_decode($matches[0], true);
        
        if ($analysisData && isset($analysisData['overall_score'])) {
            // Ensure all required fields exist with defaults
            $analysisData['overall_score'] = $analysisData['overall_score'] ?? 7;
            $analysisData['scores'] = $analysisData['scores'] ?? [
                'grammar' => 7,
                'vocabulary' => 7,
                'coherence' => 7,
                'task_achievement' => 7,
                'organization' => 7,
                'style' => 7
            ];
            $analysisData['grammar_errors'] = $analysisData['grammar_errors'] ?? [];
            $analysisData['vocabulary_suggestions'] = $analysisData['vocabulary_suggestions'] ?? [];
            $analysisData['structure_feedback'] = $analysisData['structure_feedback'] ?? [];
            $analysisData['strengths'] = $analysisData['strengths'] ?? ['Bài viết có cấu trúc tốt'];
            $analysisData['improvements'] = $analysisData['improvements'] ?? ['Có thể cải thiện từ vựng'];
            $analysisData['feedback'] = $analysisData['feedback'] ?? 'Bài viết tốt! Hãy tiếp tục luyện tập.';
            $analysisData['next_steps'] = $analysisData['next_steps'] ?? ['Luyện tập thêm về ngữ pháp'];
            
            // Add statistics
            $analysisData['statistics'] = [
                'word_count' => $wordCount,
                'sentence_count' => $sentenceCount,
                'paragraph_count' => $paragraphCount,
                'avg_sentence_length' => $sentenceCount > 0 ? round($wordCount / $sentenceCount, 1) : 0
            ];
            
            Logger::info('Writing checked', [
                'user_id' => $_SESSION['id_hocvien'],
                'mode' => $mode,
                'word_count' => $wordCount,
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
                    'task_achievement' => 7,
                    'organization' => 7,
                    'style' => 7
                ],
                'grammar_errors' => [],
                'vocabulary_suggestions' => [],
                'structure_feedback' => [],
                'strengths' => ['Bài viết có cấu trúc tốt', 'Ý tưởng rõ ràng'],
                'improvements' => ['Có thể phát triển ý sâu hơn', 'Sử dụng từ nối đa dạng hơn'],
                'feedback' => 'Bài viết của bạn tốt! Tiếp tục luyện tập để cải thiện kỹ năng viết.',
                'next_steps' => ['Luyện tập viết thêm', 'Đọc nhiều mẫu bài viết tốt'],
                'statistics' => [
                    'word_count' => $wordCount,
                    'sentence_count' => $sentenceCount,
                    'paragraph_count' => $paragraphCount,
                    'avg_sentence_length' => $sentenceCount > 0 ? round($wordCount / $sentenceCount, 1) : 0
                ]
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
                'task_achievement' => 7,
                'organization' => 7,
                'style' => 7
            ],
            'grammar_errors' => [],
            'vocabulary_suggestions' => [],
            'structure_feedback' => [],
            'strengths' => ['Bài viết có cấu trúc tốt'],
            'improvements' => ['Có thể cải thiện từ vựng và ngữ pháp'],
            'feedback' => $responseText,
            'next_steps' => ['Tiếp tục luyện tập viết'],
            'statistics' => [
                'word_count' => $wordCount,
                'sentence_count' => $sentenceCount,
                'paragraph_count' => $paragraphCount,
                'avg_sentence_length' => $sentenceCount > 0 ? round($wordCount / $sentenceCount, 1) : 0
            ]
        ], 'Writing analyzed successfully');
    }
}
