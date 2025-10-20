<?php
require_once 'config.php';
require_once 'api_handler.php';

// Enable error logging for debugging
error_log("Pronunciation API called - Action: " . ($_POST['action'] ?? 'none'));
error_log("POST data: " . print_r($_POST, true));

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['id_hocvien'])) {
    error_log("Pronunciation API: Unauthorized - No session");
    ResponseHelper::error('Unauthorized', 401);
}

if (!isset($_POST['csrf_token'])) {
    error_log("Pronunciation API: No CSRF token in request");
    ResponseHelper::error('Invalid CSRF token', 403);
}

if (!SecurityHelper::verifyCSRFToken($_POST['csrf_token'])) {
    error_log("Pronunciation API: CSRF token verification failed");
    ResponseHelper::error('Invalid CSRF token', 403);
}

if (!RateLimiter::checkLimit($_SESSION['id_hocvien'])) {
    error_log("Pronunciation API: Rate limit exceeded");
    ResponseHelper::error('Rate limit exceeded', 429);
}

$action = $_POST['action'] ?? '';
error_log("Pronunciation API: Processing action - " . $action);

$apiService = APIService::getInstance();
$geminiAPI = $apiService->getHandler();

try {
    switch ($action) {
        case 'get_word':
            $focus = SecurityHelper::sanitizeInput($_POST['focus'] ?? 'vowels');
            
            $focusDescriptions = [
                'vowels' => 'vowel sounds (nguyên âm như /i:/, /æ/, /ə/, etc.)',
                'consonants' => 'consonant sounds (phụ âm như /θ/, /ð/, /ʃ/, /ʒ/, etc.)',
                'stress' => 'word stress patterns (trọng âm từ)',
                'intonation' => 'intonation patterns (ngữ điệu câu)',
                'minimal-pairs' => 'minimal pairs (cặp từ chỉ khác 1 âm)'
            ];
            
            $focusDesc = $focusDescriptions[$focus] ?? 'general pronunciation';
            
            $prompt = "Generate ONE word or short phrase (max 3 words) for English pronunciation practice.\n";
            $prompt .= "Focus: {$focusDesc}\n\n";
            $prompt .= "Requirements:\n";
            $prompt .= "- Choose a common, useful word/phrase\n";
            $prompt .= "- Provide IPA phonetic transcription\n";
            $prompt .= "- Give a helpful pronunciation tip in Vietnamese\n\n";
            $prompt .= 'Return ONLY valid JSON in this exact format:\n';
            $prompt .= '{"word": "example", "phonetic": "/ɪɡˈzɑːmpəl/", "tip": "Nhấn mạnh vào âm tiết thứ 2"}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.8);
            
            if ($result['success']) {
                // Extract JSON from response
                if (preg_match('/\{[^}]+\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    if ($data && isset($data['word'])) {
                        ResponseHelper::success($data);
                        break;
                    }
                }
            }
            
            // Fallback words based on focus
            $fallbacks = [
                'vowels' => ['word' => 'sheep', 'phonetic' => '/ʃiːp/', 'tip' => 'Âm /iː/ dài, môi dàn ngang'],
                'consonants' => ['word' => 'think', 'phonetic' => '/θɪŋk/', 'tip' => 'Đặt lưỡi giữa răng khi phát âm /θ/'],
                'stress' => ['word' => 'photograph', 'phonetic' => '/ˈfoʊtəɡræf/', 'tip' => 'Nhấn mạnh âm tiết đầu'],
                'intonation' => ['word' => 'Really?', 'phonetic' => '/ˈriːəli/', 'tip' => 'Giọng lên ở cuối khi hỏi'],
                'minimal-pairs' => ['word' => 'ship', 'phonetic' => '/ʃɪp/', 'tip' => 'So sánh với "sheep" /ʃiːp/']
            ];
            
            ResponseHelper::success($fallbacks[$focus] ?? $fallbacks['vowels']);
            break;
            
        case 'check':
            $target = SecurityHelper::sanitizeInput($_POST['target'] ?? '');
            $userInput = SecurityHelper::sanitizeInput($_POST['user_input'] ?? '');
            
            if (empty($target)) ResponseHelper::error('No target word provided', 400);
            if (empty($userInput)) ResponseHelper::error('No pronunciation provided', 400);
            
            $prompt = "Bạn là giáo viên phát âm tiếng Anh chuyên nghiệp.\n\n";
            $prompt .= "Nhiệm vụ: So sánh phát âm của học viên với từ chuẩn.\n\n";
            $prompt .= "Từ chuẩn (target): {$target}\n";
            $prompt .= "Học viên đã nói: {$userInput}\n\n";
            $prompt .= "Hãy đánh giá:\n";
            $prompt .= "1. Độ chính xác (accuracy): Học viên có phát âm đúng từ không?\n";
            $prompt .= "2. Phát âm (pronunciation): Các âm có chuẩn không?\n";
            $prompt .= "3. Lưu loát (fluency): Có tự nhiên không?\n\n";
            $prompt .= "Cho điểm từ 1-10:\n";
            $prompt .= "- 9-10: Xuất sắc, gần như người bản xứ\n";
            $prompt .= "- 7-8: Tốt, có thể hiểu rõ\n";
            $prompt .= "- 5-6: Trung bình, cần cải thiện\n";
            $prompt .= "- 3-4: Yếu, khó hiểu\n";
            $prompt .= "- 1-2: Rất yếu, sai hoàn toàn\n\n";
            $prompt .= "Phản hồi bằng tiếng Việt, ngắn gọn, khuyến khích.\n";
            $prompt .= "Nếu sai, chỉ ra lỗi cụ thể và cách sửa.\n\n";
            $prompt .= 'Trả về JSON format:\n';
            $prompt .= '{"score": <1-10>, "feedback": "nhận xét chi tiết bằng tiếng Việt", "tip": "mẹo cải thiện (optional)"}';
            
            $result = $geminiAPI->sendRequest($prompt, 0.5);
            
            if ($result['success']) {
                // Try to extract JSON
                if (preg_match('/\{[^}]+\}/', $result['text'], $matches)) {
                    $data = json_decode($matches[0], true);
                    if ($data && isset($data['score'])) {
                        ResponseHelper::success($data);
                        break;
                    }
                }
                
                // If no JSON, create from plain text
                $score = 7; // Default
                
                // Try to find score in text
                if (preg_match('/(\d+)\/10/i', $result['text'], $scoreMatch)) {
                    $score = intval($scoreMatch[1]);
                } elseif (preg_match('/score[:\s]+(\d+)/i', $result['text'], $scoreMatch)) {
                    $score = intval($scoreMatch[1]);
                }
                
                ResponseHelper::success([
                    'score' => $score,
                    'feedback' => $result['text']
                ]);
            } else {
                // Fallback comparison
                $targetLower = strtolower(trim($target));
                $userLower = strtolower(trim($userInput));
                
                if ($targetLower === $userLower) {
                    ResponseHelper::success([
                        'score' => 9,
                        'feedback' => '🎉 Xuất sắc! Bạn đã phát âm chính xác từ "' . $target . '". Tiếp tục luyện tập để phát âm ngày càng tự nhiên hơn!',
                        'tip' => 'Hãy chú ý đến ngữ điệu và tốc độ nói để phát âm như người bản xứ.'
                    ]);
                } else {
                    // Calculate similarity
                    similar_text($targetLower, $userLower, $percent);
                    $score = max(3, min(8, round($percent / 10)));
                    
                    ResponseHelper::success([
                        'score' => $score,
                        'feedback' => 'Bạn đã nói "' . $userInput . '" thay vì "' . $target . '". Hãy nghe kỹ phát âm mẫu và thử lại. Chú ý đến từng âm trong từ.',
                        'tip' => 'Luyện tập nhiều lần và so sánh với phát âm chuẩn sẽ giúp bạn cải thiện nhanh chóng.'
                    ]);
                }
            }
            break;
            
        default:
            ResponseHelper::error('Invalid action', 400);
    }
} catch (Exception $e) {
    ResponseHelper::error('An error occurred', 500);
}
