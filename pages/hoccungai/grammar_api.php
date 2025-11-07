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
            $questionCount = intval($_POST['question_count'] ?? 5);
            
            // Validate question count
            if ($questionCount < 3) $questionCount = 3;
            if ($questionCount > 15) $questionCount = 15;
            
            // 10 Grammar levels with detailed descriptions
            $levelDescriptions = [
                'beginner' => 'A1-A2: Basic grammar (present simple, to be, articles, basic pronouns)',
                'elementary' => 'A2-B1: Elementary grammar (present continuous, past simple, basic modals, comparatives)',
                'intermediate' => 'B1: Intermediate grammar (present perfect, conditionals type 1-2, passive voice, reported speech)',
                'upper_intermediate' => 'B1-B2: Upper-intermediate (all tenses, conditionals type 3, wish clauses, relative clauses)',
                'advanced' => 'B2-C1: Advanced grammar (advanced tenses, inversions, subjunctive, cleft sentences)',
                'ielts_6' => 'IELTS 6.0-6.5: Grammar for IELTS bands 6-6.5 (complex sentences, varied structures)',
                'ielts_7' => 'IELTS 7.0+: Grammar for IELTS band 7+ (sophisticated structures, grammatical range)',
                'toefl' => 'TOEFL: Academic grammar for TOEFL (complex syntax, academic structures)',
                'business' => 'Business English: Grammar for professional contexts (formal structures, business terminology)',
                'mixed' => 'Mixed levels: Various grammar topics across different levels'
            ];
            
            $levelDesc = $levelDescriptions[$level] ?? $levelDescriptions['intermediate'];
            $topicFilter = $topic ? "Topic focus: {$topic}. " : '';
            
            error_log("Grammar API: Generating {$questionCount} questions for level {$level}, topic: " . ($topic ?: 'general'));
            
            $prompt = "You are an expert English grammar teacher. Create {$questionCount} grammar questions.\n\n";
            $prompt .= "LEVEL: {$levelDesc}\n";
            $prompt .= $topicFilter ? "{$topicFilter}\n" : '';
            $prompt .= "\nREQUIREMENTS:\n";
            $prompt .= "1. Each question should test a specific grammar point\n";
            $prompt .= "2. Provide 4 options (A, B, C, D) with only ONE correct answer\n";
            $prompt .= "3. Include the grammar point being tested (e.g., 'present_perfect', 'conditionals', 'passive_voice')\n";
            $prompt .= "4. Add a detailed explanation in Vietnamese for why the correct answer is right\n";
            $prompt .= "5. Questions should be clear, unambiguous, and test understanding, not just memorization\n\n";
            $prompt .= "GRAMMAR POINT CATEGORIES:\n";
            $prompt .= "- tenses (present_simple, present_continuous, past_simple, present_perfect, etc.)\n";
            $prompt .= "- modals (can, could, should, must, might, etc.)\n";
            $prompt .= "- conditionals (type_1, type_2, type_3, mixed)\n";
            $prompt .= "- passive_voice\n";
            $prompt .= "- reported_speech\n";
            $prompt .= "- relative_clauses\n";
            $prompt .= "- articles (a, an, the)\n";
            $prompt .= "- prepositions\n";
            $prompt .= "- comparatives_superlatives\n";
            $prompt .= "- gerunds_infinitives\n\n";
            $prompt .= 'Return ONLY valid JSON in this format:\n';
            $prompt .= '{"title": "Grammar Exercise Title", "questions": [{"question": "Choose the correct form: I ___ to Paris last year.", "options": ["go", "went", "have gone", "had gone"], "correct": 1, "grammar_point": "past_simple", "explanation": "Dùng past simple \'went\' vì..."}]}\n';
            
            $result = $geminiAPI->sendRequest($prompt, 0.7, 3000);
            
            if ($result['success']) {
                error_log("Grammar API: AI response received, extracting JSON...");
                
                // Extract JSON from response
                if (preg_match('/\{[\s\S]*"questions"[\s\S]*\}/U', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    
                    if ($data && isset($data['questions']) && is_array($data['questions'])) {
                        error_log("Grammar API: Successfully generated " . count($data['questions']) . " questions");
                        ResponseHelper::success($data);
                        break;
                    }
                }
                
                error_log("Grammar API: JSON parsing failed, response: " . substr($result['text'], 0, 200));
            }
            
            // Fallback response
            ResponseHelper::success([
                'title' => 'Grammar Exercise',
                'questions' => [
                    [
                        'question' => 'I ___ English for 5 years.',
                        'options' => ['learn', 'am learning', 'have learned', 'learned'],
                        'correct' => 2,
                        'grammar_point' => 'present_perfect',
                        'explanation' => 'Dùng present perfect "have learned" vì hành động bắt đầu trong quá khứ và còn liên quan đến hiện tại.'
                    ]
                ]
            ]);
            break;
            
        case 'check':
            $exercise = json_decode($_POST['exercise'] ?? '', true);
            $answers = json_decode($_POST['answers'] ?? '', true);
            
            if (!$exercise || !$answers) ResponseHelper::error('Invalid data', 400);
            
            error_log("Grammar API: Checking answers for " . count($exercise['questions']) . " questions");
            
            $correctCount = 0;
            $details = [];
            
            foreach ($exercise['questions'] as $i => $q) {
                $userAnswer = $answers[$i] ?? -1;
                $correctAnswer = $q['correct'] ?? 0;
                $isCorrect = $userAnswer === $correctAnswer;
                
                if ($isCorrect) $correctCount++;
                
                $details[] = [
                    'question' => $q['question'] ?? '',
                    'grammar_point' => $q['grammar_point'] ?? 'general',
                    'user_answer' => $userAnswer >= 0 ? ($q['options'][$userAnswer] ?? '') : 'Chưa chọn',
                    'user_answer_index' => $userAnswer,
                    'correct_answer' => $q['options'][$correctAnswer] ?? '',
                    'correct_answer_index' => $correctAnswer,
                    'is_correct' => $isCorrect,
                    'explanation' => $q['explanation'] ?? '',
                    'all_options' => $q['options'] ?? []
                ];
            }
            
            $totalCount = count($exercise['questions']);
            $percentage = $totalCount > 0 ? ($correctCount / $totalCount) * 100 : 0;
            $score = $totalCount > 0 ? ($correctCount / $totalCount) * 10 : 0;
            
            error_log("Grammar API: Check complete - {$correctCount}/{$totalCount} correct ({$percentage}%)");
            
            ResponseHelper::success([
                'correct_count' => $correctCount,
                'total_count' => $totalCount,
                'percentage' => round($percentage, 1),
                'score' => round($score, 1),
                'details' => $details,
                'feedback' => generateGrammarFeedback($percentage, $totalCount, $details)
            ]);
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    error_log("Grammar API Error: " . $e->getMessage());
    ResponseHelper::error('An error occurred', 500);
}

function generateGrammarFeedback($percentage, $totalCount, $details) {
    // Analyze grammar points
    $grammarPoints = [];
    foreach ($details as $detail) {
        $point = $detail['grammar_point'];
        if (!isset($grammarPoints[$point])) {
            $grammarPoints[$point] = ['correct' => 0, 'total' => 0];
        }
        $grammarPoints[$point]['total']++;
        if ($detail['is_correct']) {
            $grammarPoints[$point]['correct']++;
        }
    }
    
    // Find weak points
    $weakPoints = [];
    foreach ($grammarPoints as $point => $stats) {
        if ($stats['total'] >= 2 && ($stats['correct'] / $stats['total']) < 0.5) {
            $weakPoints[] = $point;
        }
    }
    
    // Generate feedback based on percentage
    if ($percentage >= 90) {
        $feedback = "🏆 Xuất sắc! Bạn đã nắm vững các điểm ngữ pháp. ";
        $feedback .= "Kiến thức ngữ pháp của bạn rất tốt. Hãy tiếp tục luyện tập để duy trì và nâng cao hơn nữa!";
    } elseif ($percentage >= 80) {
        $feedback = "🌟 Tốt lắm! Bạn hiểu rõ phần lớn các quy tắc ngữ pháp. ";
        $feedback .= "Với {$totalCount} câu hỏi, bạn đã trả lời đúng hầu hết. Hãy ôn lại các câu sai để hoàn thiện hơn.";
    } elseif ($percentage >= 70) {
        $feedback = "👍 Khá tốt! Bạn đã nắm được các điểm ngữ pháp cơ bản. ";
        if (!empty($weakPoints)) {
            $feedback .= "Hãy chú ý ôn lại: " . implode(', ', array_slice($weakPoints, 0, 3)) . ".";
        } else {
            $feedback .= "Hãy luyện tập thêm để cải thiện độ chính xác.";
        }
    } elseif ($percentage >= 60) {
        $feedback = "💪 Được! Bạn đã có nền tảng ngữ pháp cơ bản. ";
        $feedback .= "Tuy nhiên, bạn cần ôn lại một số điểm ngữ pháp quan trọng để nâng cao độ chính xác.";
    } elseif ($percentage >= 50) {
        $feedback = "📚 Cần cố gắng thêm! Bạn cần dành nhiều thời gian hơn để học và luyện tập ngữ pháp. ";
        if (!empty($weakPoints)) {
            $feedback .= "Tập trung vào: " . implode(', ', array_slice($weakPoints, 0, 3)) . ".";
        }
    } else {
        $feedback = "💡 Đừng nản lòng! Ngữ pháp cần thời gian để nắm vững. ";
        $feedback .= "Hãy bắt đầu từ những điểm ngữ pháp cơ bản nhất, học từng phần một và luyện tập đều đặn mỗi ngày.";
    }
    
    return $feedback;
}
