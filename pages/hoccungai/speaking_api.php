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
            $questionType = SecurityHelper::sanitizeInput($_POST['question_type'] ?? 'general');
            
            // Enhanced level descriptions
            $levelDescriptions = [
                'beginner' => 'A1-A2: Use simple vocabulary, present simple tense, basic sentence structures. Questions should be about very familiar topics.',
                'elementary' => 'A2-B1: Use common vocabulary, simple past and present tenses, questions about daily life and personal experiences.',
                'intermediate' => 'B1-B2: Use intermediate vocabulary, various tenses, questions requiring opinions and explanations.',
                'upper_intermediate' => 'B2: Use advanced vocabulary, complex sentence structures, questions requiring analysis and argumentation.',
                'advanced' => 'C1-C2: Use sophisticated vocabulary, idiomatic expressions, abstract concepts and complex reasoning.',
                'ielts_5' => 'IELTS 5.0-6.0: Part 1 style questions - familiar topics with some detail and examples.',
                'ielts_7' => 'IELTS 7.0-8.0: Part 2-3 style questions - abstract topics requiring extended discourse and critical thinking.',
                'business' => 'Business English: Professional scenarios, workplace communication, meetings, presentations.',
                'academic' => 'Academic English: Research, presentations, academic discussions, formal language.',
                'conversation' => 'Natural Conversation: Casual everyday topics with natural flow and follow-up questions.'
            ];
            
            $topicMap = [
                'self-introduction' => 'introducing yourself (name, background, interests, goals)',
                'daily-routine' => 'daily activities and routines (morning routine, work schedule, evening activities)',
                'hobbies' => 'hobbies and interests (free time activities, sports, creative pursuits)',
                'travel' => 'travel and tourism (favorite destinations, travel experiences, dream trips)',
                'food' => 'food and cuisine (favorite dishes, cooking, restaurants, food culture)',
                'technology' => 'technology and innovation (smartphones, social media, AI, digital life)',
                'education' => 'education and learning (school experiences, study methods, online learning)',
                'work' => 'work and career (job responsibilities, workplace culture, career goals)',
                'environment' => 'environment and sustainability (climate change, recycling, green living)',
                'health' => 'health and fitness (exercise, diet, mental health, wellness)',
                'entertainment' => 'entertainment and media (movies, music, books, TV shows)',
                'family' => 'family and relationships (family members, traditions, celebrations)'
            ];
            
            $questionTypes = [
                'describe' => 'Ask them to describe something in detail',
                'opinion' => 'Ask for their opinion and reasons',
                'experience' => 'Ask about a personal experience or memory',
                'compare' => 'Ask them to compare two things or situations',
                'future' => 'Ask about plans, predictions, or hypothetical situations',
                'general' => 'Ask a general open-ended question'
            ];
            
            $levelDesc = $levelDescriptions[$level] ?? $levelDescriptions['intermediate'];
            $topicDesc = $topicMap[$topic] ?? 'general conversation';
            $questionTypeDesc = $questionTypes[$questionType] ?? 'Ask a general open-ended question';
            
            $prompt = "You are an English speaking teacher creating a speaking exercise.\n\n";
            $prompt .= "LEVEL: {$levelDesc}\n";
            $prompt .= "TOPIC: {$topicDesc}\n";
            $prompt .= "QUESTION TYPE: {$questionTypeDesc}\n\n";
            $prompt .= "Create ONE clear, engaging speaking question appropriate for this level.\n";
            $prompt .= "The question should encourage the learner to speak for 1-2 minutes.\n\n";
            $prompt .= "Provide your response in valid JSON format:\n";
            $prompt .= '{"question": "The speaking question in English", "instruction": "Brief instruction in Vietnamese (e.g., \'Hãy trả lời câu hỏi này trong 1-2 phút. Giải thích ý kiến của bạn và đưa ra ví dụ cụ thể.\')", "topic": "' . $topic . '", "level": "' . $level . '", "tips": ["tip 1 in Vietnamese", "tip 2 in Vietnamese", "tip 3 in Vietnamese"]}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.8, 1500);
            
            if ($result['success']) {
                if (preg_match('/\{[\s\S]*\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    if ($data && isset($data['question'])) {
                        ResponseHelper::success($data);
                    } else {
                        ResponseHelper::success([
                            'question' => $result['text'], 
                            'instruction' => 'Trả lời câu hỏi này trong 1-2 phút.',
                            'topic' => $topic,
                            'level' => $level,
                            'tips' => []
                        ]);
                    }
                } else {
                    ResponseHelper::success([
                        'question' => $result['text'], 
                        'instruction' => 'Trả lời câu hỏi này trong 1-2 phút.',
                        'topic' => $topic,
                        'level' => $level,
                        'tips' => []
                    ]);
                }
            } else {
                ResponseHelper::error('Failed to generate question');
            }
            break;
            
        case 'analyze':
            $question = $_POST['question'] ?? '';
            $answer = $_POST['answer'] ?? '';
            $level = SecurityHelper::sanitizeInput($_POST['level'] ?? 'intermediate');
            
            if (empty($answer)) ResponseHelper::error('No answer provided', 400);
            
            $wordCount = str_word_count($answer);
            $sentenceCount = preg_match_all('/[.!?]+/', $answer);
            
            $prompt = "You are an English speaking teacher evaluating a student's spoken response.\n\n";
            $prompt .= "STUDENT LEVEL: {$level}\n";
            $prompt .= "QUESTION: {$question}\n";
            $prompt .= "STUDENT'S ANSWER: {$answer}\n";
            $prompt .= "WORD COUNT: {$wordCount} words\n";
            $prompt .= "SENTENCE COUNT: {$sentenceCount} sentences\n\n";
            $prompt .= "Provide a detailed analysis considering:\n";
            $prompt .= "1. FLUENCY (1-10): Flow, coherence, confidence, natural speech patterns\n";
            $prompt .= "2. PRONUNCIATION (1-10): Clarity, accuracy (estimate based on text structure)\n";
            $prompt .= "3. GRAMMAR (1-10): Sentence structure, tense usage, accuracy\n";
            $prompt .= "4. VOCABULARY (1-10): Range, appropriacy, sophistication for level\n";
            $prompt .= "5. RELEVANCE (1-10): How well they answered the question\n";
            $prompt .= "6. CONTENT (1-10): Depth, examples, development of ideas\n\n";
            $prompt .= "Provide detailed feedback in Vietnamese explaining:\n";
            $prompt .= "- What they did well (specific examples)\n";
            $prompt .= "- Areas for improvement (with examples)\n";
            $prompt .= "- Grammar/vocabulary mistakes (if any)\n\n";
            $prompt .= "Provide 3-5 specific, actionable suggestions in Vietnamese.\n\n";
            $prompt .= "Response format (valid JSON):\n";
            $prompt .= '{"scores": {"fluency": <1-10>, "pronunciation": <1-10>, "grammar": <1-10>, "vocabulary": <1-10>, "relevance": <1-10>, "content": <1-10>}, "feedback": "detailed feedback in Vietnamese (3-5 sentences)", "strengths": ["strength 1", "strength 2"], "improvements": ["improvement 1", "improvement 2"], "suggestions": ["suggestion 1", "suggestion 2", "suggestion 3"], "overall_comment": "encouraging comment in Vietnamese"}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.5, 2000);
            
            if ($result['success']) {
                if (preg_match('/\{[\s\S]*\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    if ($data && isset($data['scores'])) {
                        // Calculate overall score
                        $totalScore = 0;
                        $scoreCount = 0;
                        foreach ($data['scores'] as $score) {
                            $totalScore += $score;
                            $scoreCount++;
                        }
                        $data['overall_score'] = $scoreCount > 0 ? round($totalScore / $scoreCount, 1) : 7;
                        $data['word_count'] = $wordCount;
                        $data['sentence_count'] = $sentenceCount;
                        ResponseHelper::success($data);
                    } else {
                        // Fallback response
                        ResponseHelper::success([
                            'scores' => [
                                'fluency' => 7, 
                                'pronunciation' => 7, 
                                'grammar' => 7, 
                                'vocabulary' => 7, 
                                'relevance' => 7,
                                'content' => 7
                            ], 
                            'feedback' => $result['text'],
                            'strengths' => [],
                            'improvements' => [],
                            'suggestions' => [],
                            'overall_comment' => 'Tốt lắm! Hãy tiếp tục luyện tập.',
                            'overall_score' => 7,
                            'word_count' => $wordCount,
                            'sentence_count' => $sentenceCount
                        ]);
                    }
                } else {
                    ResponseHelper::success([
                        'scores' => [
                            'fluency' => 7, 
                            'pronunciation' => 7, 
                            'grammar' => 7, 
                            'vocabulary' => 7, 
                            'relevance' => 7,
                            'content' => 7
                        ], 
                        'feedback' => $result['text'],
                        'strengths' => [],
                        'improvements' => [],
                        'suggestions' => [],
                        'overall_comment' => 'Tốt lắm! Hãy tiếp tục luyện tập.',
                        'overall_score' => 7,
                        'word_count' => $wordCount,
                        'sentence_count' => $sentenceCount
                    ]);
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
