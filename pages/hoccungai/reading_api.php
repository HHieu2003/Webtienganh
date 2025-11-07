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
            $questionCount = intval($_POST['question_count'] ?? 5);
            
            // Validate question count
            if ($questionCount < 3) $questionCount = 3;
            if ($questionCount > 10) $questionCount = 10;
            
            // Enhanced level descriptions
            $levelDescriptions = [
                'beginner' => 'A1-A2: Simple vocabulary, present tense, short sentences, everyday topics. Passage 150-200 words.',
                'elementary' => 'A2-B1: Basic vocabulary, common tenses, clear structure, familiar topics. Passage 200-250 words.',
                'intermediate' => 'B1-B2: Varied vocabulary, multiple tenses, longer paragraphs, diverse topics. Passage 250-350 words.',
                'upper_intermediate' => 'B2: Advanced vocabulary, complex sentences, abstract concepts. Passage 300-400 words.',
                'advanced' => 'C1-C2: Sophisticated vocabulary, academic/professional level, nuanced ideas. Passage 350-500 words.',
                'ielts_6' => 'IELTS 6.0-6.5: Academic passages with clear structure, moderate complexity. Passage 300-400 words.',
                'ielts_7' => 'IELTS 7.0+: Complex academic texts, advanced vocabulary, critical thinking required. Passage 400-500 words.',
                'toefl' => 'TOEFL Reading: Academic passages with detailed information and analysis. Passage 350-450 words.',
                'sat' => 'SAT Reading: Literature, science, or historical passages with analytical questions. Passage 400-500 words.',
                'general' => 'General Reading: Mix of topics with moderate difficulty. Passage 250-350 words.'
            ];
            
            $levelDesc = $levelDescriptions[$level] ?? $levelDescriptions['intermediate'];
            
            $prompt = "You are an English reading comprehension expert creating a practice exercise.\n\n";
            $prompt .= "LEVEL: {$levelDesc}\n";
            if ($topic) {
                $prompt .= "TOPIC: {$topic}\n";
            } else {
                $prompt .= "Choose an interesting and engaging topic suitable for this level (science, culture, history, technology, nature, society, etc.)\n";
            }
            $prompt .= "NUMBER OF QUESTIONS: {$questionCount}\n\n";
            
            $prompt .= "Create a complete reading comprehension exercise with:\n\n";
            $prompt .= "1. **PASSAGE**: An engaging, well-written passage appropriate for the level\n";
            $prompt .= "   - Include interesting facts or perspectives\n";
            $prompt .= "   - Use varied sentence structures\n";
            $prompt .= "   - Ensure proper paragraph breaks\n\n";
            
            $prompt .= "2. **QUESTIONS**: {$questionCount} comprehension questions with these types:\n";
            $prompt .= "   - Main idea / purpose (1-2 questions)\n";
            $prompt .= "   - Detail / specific information (2-3 questions)\n";
            $prompt .= "   - Inference / implied meaning (1-2 questions)\n";
            $prompt .= "   - Vocabulary in context (1 question)\n";
            $prompt .= "   - Author's tone/attitude (optional)\n\n";
            
            $prompt .= "Each question must have:\n";
            $prompt .= "   - Clear question text\n";
            $prompt .= "   - Exactly 4 options (A, B, C, D)\n";
            $prompt .= "   - One correct answer\n";
            $prompt .= "   - Distractors that are plausible but incorrect\n";
            $prompt .= "   - Question type label\n\n";
            
            $prompt .= "Return ONLY valid JSON in this exact format:\n";
            $prompt .= "{\n";
            $prompt .= '  "title": "Engaging title for the passage",'."\n";
            $prompt .= '  "passage": "The complete passage text with \\n for paragraph breaks",'."\n";
            $prompt .= '  "word_count": <number>,'."\n";
            $prompt .= '  "questions": ['."\n";
            $prompt .= '    {'."\n";
            $prompt .= '      "question": "Clear question text?",'."\n";
            $prompt .= '      "type": "main_idea|detail|inference|vocabulary|tone",'."\n";
            $prompt .= '      "options": ["Option A", "Option B", "Option C", "Option D"],'."\n";
            $prompt .= '      "correct": <0-3>,'."\n";
            $prompt .= '      "explanation": "Brief explanation in Vietnamese why this is correct"'."\n";
            $prompt .= '    }'."\n";
            $prompt .= '  ]'."\n";
            $prompt .= "}\n\n";
            $prompt .= "IMPORTANT: Ensure questions test actual comprehension, not just word matching.";
            
            $result = $geminiAPI->sendRequest($prompt, 0.8, 3000);
            
            if ($result['success'] && preg_match('/\{[\s\S]*\}/', $result['text'], $matches)) {
                $data = json_decode($matches[0], true);
                if ($data && isset($data['passage']) && isset($data['questions'])) {
                    Logger::info('Reading exercise generated', [
                        'user_id' => $userId,
                        'level' => $level,
                        'topic' => $topic,
                        'question_count' => count($data['questions'])
                    ]);
                    ResponseHelper::success($data);
                } else {
                    ResponseHelper::success([
                        'title' => 'Reading Comprehension',
                        'passage' => $result['text'], 
                        'word_count' => str_word_count($result['text']),
                        'questions' => []
                    ]);
                }
            } else {
                ResponseHelper::error('Failed to generate reading exercise');
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
                $correctIndex = $q['correct'] ?? 0;
                $isCorrect = ($userAnswer === $correctIndex);
                
                if ($isCorrect) $correctCount++;
                
                $details[] = [
                    'question' => $q['question'],
                    'type' => $q['type'] ?? 'general',
                    'is_correct' => $isCorrect,
                    'user_answer_index' => $userAnswer,
                    'user_answer' => $userAnswer >= 0 && $userAnswer < count($q['options']) ? $q['options'][$userAnswer] : 'Không trả lời',
                    'correct_answer_index' => $correctIndex,
                    'correct_answer' => $q['options'][$correctIndex] ?? 'N/A',
                    'explanation' => $q['explanation'] ?? '',
                    'all_options' => $q['options']
                ];
            }
            
            $score = $totalCount > 0 ? ($correctCount / $totalCount) * 10 : 0;
            $percentage = $totalCount > 0 ? round(($correctCount / $totalCount) * 100) : 0;
            
            Logger::info('Reading checked', [
                'user_id' => $userId,
                'correct' => $correctCount,
                'total' => $totalCount,
                'score' => $score
            ]);
            
            ResponseHelper::success([
                'correct_count' => $correctCount,
                'total_count' => $totalCount,
                'score' => round($score, 1),
                'percentage' => $percentage,
                'details' => $details,
                'feedback' => generateReadingFeedback($percentage, $totalCount)
            ]);
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    Logger::error('Reading API Error', ['error' => $e->getMessage()]);
    ResponseHelper::error('An error occurred', 500);
}

/**
 * Generate feedback based on score
 */
function generateReadingFeedback($percentage, $totalCount) {
    if ($percentage >= 90) {
        return "Xuất sắc! Bạn đã hiểu rất tốt bài đọc. Kỹ năng đọc hiểu của bạn ở mức cao.";
    } elseif ($percentage >= 80) {
        return "Tốt lắm! Bạn nắm vững nội dung chính. Hãy tiếp tục luyện tập để đạt điểm cao hơn.";
    } elseif ($percentage >= 70) {
        return "Khá tốt! Bạn hiểu phần lớn nội dung. Chú ý đọc kỹ hơn các chi tiết nhỏ.";
    } elseif ($percentage >= 60) {
        return "Được! Bạn đang trên đà cải thiện. Hãy đọc lại bài văn và chú ý đến các từ khóa.";
    } elseif ($percentage >= 50) {
        return "Cần cố gắng thêm! Hãy đọc chậm hơn và gạch chân những thông tin quan trọng.";
    } else {
        return "Đừng nản lòng! Hãy đọc bài văn nhiều lần, tra từ mới và làm thêm nhiều bài tập.";
    }
}
