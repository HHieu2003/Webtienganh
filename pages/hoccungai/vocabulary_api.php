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
            $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');
            $topic = SecurityHelper::sanitizeInput($_POST['topic'] ?? '');
            $type = SecurityHelper::sanitizeInput($_POST['type'] ?? 'definition');
            $questionCount = intval($_POST['question_count'] ?? 10);
            
            if ($questionCount < 5) $questionCount = 5;
            if ($questionCount > 20) $questionCount = 20;
            
            $levelDescriptions = [
                'beginner' => 'A1-A2: Basic everyday vocabulary (300-500 words)',
                'elementary' => 'A2-B1: Elementary vocabulary for common situations',
                'intermediate' => 'B1: Intermediate vocabulary for various topics',
                'upper_intermediate' => 'B1-B2: Upper-intermediate with abstract concepts',
                'advanced' => 'B2-C1: Advanced vocabulary with nuances',
                'ielts' => 'IELTS: Academic and topic-specific vocabulary',
                'toefl' => 'TOEFL: Academic English vocabulary',
                'business' => 'Business English: Professional terminology',
                'academic' => 'Academic: Scholarly and formal vocabulary',
                'general' => 'General: Mixed vocabulary levels'
            ];
            
            $typeDescriptions = [
                'definition' => 'Match words with their definitions',
                'synonym' => 'Find synonyms (words with similar meanings)',
                'antonym' => 'Find antonyms (words with opposite meanings)',
                'usage' => 'Choose the correct word in context',
                'collocation' => 'Common word combinations',
                'idiom' => 'Idiomatic expressions'
            ];
            
            $levelDesc = $levelDescriptions[$level] ?? $levelDescriptions['intermediate'];
            $typeDesc = $typeDescriptions[$type] ?? $typeDescriptions['definition'];
            $topicFilter = $topic ? "Topic: {$topic}. " : '';
            
            error_log("Vocabulary API: Generating {$questionCount} {$type} questions, level {$level}");
            
            $prompt = "You are an expert English vocabulary teacher. Create {$questionCount} vocabulary questions.\n\n";
            $prompt .= "LEVEL: {$levelDesc}\n";
            $prompt .= "TYPE: {$typeDesc}\n";
            $prompt .= $topicFilter ? "{$topicFilter}\n" : '';
            $prompt .= "\nREQUIREMENTS:\n";
            $prompt .= "1. Each question should test vocabulary knowledge\n";
            $prompt .= "2. Provide 4 options with only ONE correct answer\n";
            $prompt .= "3. Include the target word being tested\n";
            $prompt .= "4. Add Vietnamese explanation for the correct answer\n";
            $prompt .= "5. If type is 'usage', provide a sentence with a blank\n\n";
            $prompt .= 'Return ONLY valid JSON:\n';
            $prompt .= '{"title": "Vocabulary Exercise", "questions": [{"question": "What does \'elaborate\' mean?", "options": ["simple", "detailed", "quick", "small"], "correct": 1, "word": "elaborate", "explanation": "Elaborate nghĩa là chi tiết, phức tạp"}]}\n';
            
            $result = $geminiAPI->sendRequest($prompt, 0.7, 3000);
            
            if ($result['success'] && preg_match('/\{[\s\S]*"questions"[\s\S]*\}/U', $result['text'], $matches)) {
                $data = json_decode($matches[0], true);
                if ($data && isset($data['questions'])) {
                    error_log("Vocabulary API: Generated " . count($data['questions']) . " questions");
                    ResponseHelper::success($data);
                    break;
                }
            }
            
            ResponseHelper::success([
                'title' => 'Vocabulary Exercise',
                'questions' => [
                    ['question' => 'What does "abundant" mean?', 'options' => ['scarce', 'plentiful', 'small', 'quick'], 'correct' => 1, 'word' => 'abundant', 'explanation' => 'Abundant = plentiful (phong phú, dồi dào)']
                ]
            ]);
            break;
            
        case 'check':
            $exercise = json_decode($_POST['exercise'] ?? '', true);
            $answers = json_decode($_POST['answers'] ?? '', true);
            
            if (!$exercise || !$answers) ResponseHelper::error('Invalid data', 400);
            
            $correctCount = 0;
            $details = [];
            
            foreach ($exercise['questions'] as $i => $q) {
                $userAnswer = $answers[$i] ?? -1;
                $correctAnswer = $q['correct'] ?? 0;
                $isCorrect = $userAnswer === $correctAnswer;
                
                if ($isCorrect) $correctCount++;
                
                $details[] = [
                    'question' => $q['question'] ?? '',
                    'word' => $q['word'] ?? '',
                    'user_answer' => $userAnswer >= 0 ? ($q['options'][$userAnswer] ?? '') : 'Chưa chọn',
                    'correct_answer' => $q['options'][$correctAnswer] ?? '',
                    'is_correct' => $isCorrect,
                    'explanation' => $q['explanation'] ?? '',
                    'all_options' => $q['options'] ?? []
                ];
            }
            
            $totalCount = count($exercise['questions']);
            $percentage = $totalCount > 0 ? ($correctCount / $totalCount) * 100 : 0;
            $score = $totalCount > 0 ? ($correctCount / $totalCount) * 10 : 0;
            
            ResponseHelper::success([
                'correct_count' => $correctCount,
                'total_count' => $totalCount,
                'percentage' => round($percentage, 1),
                'score' => round($score, 1),
                'details' => $details,
                'feedback' => generateVocabularyFeedback($percentage, $totalCount)
            ]);
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    error_log("Vocabulary API Error: " . $e->getMessage());
    ResponseHelper::error('An error occurred', 500);
}

function generateVocabularyFeedback($percentage, $totalCount) {
    if ($percentage >= 90) {
        return "🏆 Xuất sắc! Vốn từ vựng của bạn rất tốt. Hãy tiếp tục học thêm từ vựng mới mỗi ngày để mở rộng kiến thức!";
    } elseif ($percentage >= 80) {
        return "🌟 Tốt lắm! Bạn đã nắm vững phần lớn từ vựng. Với {$totalCount} câu hỏi, bạn đã trả lời đúng hầu hết. Hãy ôn lại các từ còn nhầm lẫn.";
    } elseif ($percentage >= 70) {
        return "👍 Khá tốt! Bạn đã biết nhiều từ vựng hữu ích. Hãy học thêm từ mới và luyện tập sử dụng chúng trong câu.";
    } elseif ($percentage >= 60) {
        return "💪 Được! Bạn đã có vốn từ vựng cơ bản. Tuy nhiên, cần mở rộng thêm bằng cách đọc nhiều và học từ mới mỗi ngày.";
    } elseif ($percentage >= 50) {
        return "📚 Cần cố gắng thêm! Vốn từ vựng cần được bồi đắp hàng ngày. Hãy học 5-10 từ mới mỗi ngày và ôn lại thường xuyên.";
    } else {
        return "💡 Đừng nản lòng! Từ vựng cần thời gian tích lũy. Hãy bắt đầu với những từ cơ bản nhất, học qua hình ảnh và ngữ cảnh thực tế.";
    }
}
