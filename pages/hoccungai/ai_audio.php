<?php
/**
 * AI AUDIO HANDLER - IMPROVED STANDALONE VERSION
 * Đánh giá phát âm sử dụng Gemini API
 */

header('Content-Type: application/json; charset=utf-8');

// Gemini API Config
define('GEMINI_API_KEY', 'AIzaSyCw79baxbVs0yJ8sxHH2PYUKQN3LDR2kQQ'); // Thay bằng API key thật
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'evaluate':
            evaluatePronunciation();
            break;
            
        case 'generate_exercise':
            generatePronunciationExercise();
            break;
            
        case 'compare':
            comparePronunciation();
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

/**
 * Đánh giá phát âm từ transcript
 */
function evaluatePronunciation() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $transcript = $input['transcript'] ?? '';
    $targetText = $input['targetText'] ?? '';
    $accent = $input['accent'] ?? 'american';
    
    if (empty($transcript)) {
        throw new Exception('No transcript provided');
    }
    
    // Tính độ tương đồng cơ bản
    $similarity = calculateSimilarity($transcript, $targetText);
    
    // Gọi Gemini AI để đánh giá chi tiết
    $prompt = "Bạn là chuyên gia đánh giá phát âm tiếng Anh.

🎯 NHIỆM VỤ: Đánh giá phát âm dựa trên transcript.

📝 TEXT CẦN ĐỌC:
\"$targetText\"

🎤 TEXT NGƯỜI DÙNG ĐÃ NÓI:
\"$transcript\"

🔍 ACCENT: " . strtoupper($accent) . " English

📊 YÊU CẦU ĐÁNH GIÁ:

1. **Điểm tổng thể** (0-100):
   - 90-100: Excellent (Xuất sắc)
   - 70-89: Good (Tốt)
   - 50-69: Fair (Khá)
   - 0-49: Need improvement (Cần cải thiện)

2. **Phân tích chi tiết**:
   - Độ chính xác từ vựng
   - Phát âm nguyên âm/phụ âm
   - Trọng âm từ
   - Ngữ điệu câu
   - Tốc độ nói

3. **Nhận xét cụ thể**:
   - Điểm mạnh
   - Điểm cần cải thiện
   - Từ/âm phát âm sai (nếu có)

4. **Gợi ý luyện tập**:
   - 2-3 gợi ý cụ thể để cải thiện

Trả lời bằng JSON format:
{
    \"score\": 85,
    \"level\": \"Good\",
    \"accuracy\": 90,
    \"fluency\": 80,
    \"intonation\": 85,
    \"strengths\": [\"...\", \"...\"],
    \"weaknesses\": [\"...\", \"...\"],
    \"suggestions\": [\"...\", \"...\"]
}";

    $aiResponse = callGeminiAPI($prompt);
    
    if ($aiResponse) {
        // Parse JSON từ response
        $evaluation = parseJSONFromText($aiResponse);
        
        echo json_encode([
            'success' => true,
            'score' => $evaluation['score'] ?? $similarity,
            'level' => $evaluation['level'] ?? 'Fair',
            'details' => [
                'accuracy' => $evaluation['accuracy'] ?? 70,
                'fluency' => $evaluation['fluency'] ?? 70,
                'intonation' => $evaluation['intonation'] ?? 70
            ],
            'feedback' => [
                'strengths' => $evaluation['strengths'] ?? [],
                'weaknesses' => $evaluation['weaknesses'] ?? [],
                'suggestions' => $evaluation['suggestions'] ?? []
            ],
            'similarity' => $similarity
        ], JSON_UNESCAPED_UNICODE);
    } else {
        // Fallback nếu AI không hoạt động
        echo json_encode([
            'success' => true,
            'score' => $similarity,
            'level' => getLevel($similarity),
            'details' => [
                'accuracy' => $similarity,
                'fluency' => 70,
                'intonation' => 70
            ],
            'feedback' => [
                'strengths' => ['Bạn đã cố gắng đọc đầy đủ câu'],
                'weaknesses' => ['Cần luyện phát âm chính xác hơn'],
                'suggestions' => ['Nghe và lặp lại nhiều lần', 'Chú ý trọng âm từ']
            ]
        ], JSON_UNESCAPED_UNICODE);
    }
}

/**
 * Tạo bài tập phát âm ngẫu nhiên
 */
function generatePronunciationExercise() {
    $level = $_GET['level'] ?? 'beginner';
    
    $exercises = [
        'beginner' => [
            ['text' => 'Hello, how are you?', 'focus' => 'Cơ bản'],
            ['text' => 'My name is John.', 'focus' => 'Giới thiệu'],
            ['text' => 'Nice to meet you.', 'focus' => 'Chào hỏi'],
            ['text' => 'Thank you very much.', 'focus' => 'Lịch sự'],
            ['text' => 'I live in Hanoi.', 'focus' => 'Địa điểm']
        ],
        'intermediate' => [
            ['text' => 'I\'m interested in learning English.', 'focus' => 'Sở thích'],
            ['text' => 'Could you speak more slowly, please?', 'focus' => 'Yêu cầu lịch sự'],
            ['text' => 'I\'ve been studying English for two years.', 'focus' => 'Present Perfect'],
            ['text' => 'The weather is beautiful today.', 'focus' => 'Mô tả'],
            ['text' => 'What time does the meeting start?', 'focus' => 'Hỏi thông tin']
        ],
        'advanced' => [
            ['text' => 'I\'d appreciate it if you could help me with this project.', 'focus' => 'Formal request'],
            ['text' => 'Despite the challenges, we managed to complete the task on time.', 'focus' => 'Complex sentence'],
            ['text' => 'The implementation of this strategy requires careful consideration.', 'focus' => 'Business'],
            ['text' => 'I\'m thoroughly convinced that this approach will yield positive results.', 'focus' => 'Opinion'],
            ['text' => 'Had I known about this earlier, I would have acted differently.', 'focus' => 'Conditional']
        ]
    ];
    
    $levelExercises = $exercises[$level] ?? $exercises['beginner'];
    $randomExercise = $levelExercises[array_rand($levelExercises)];
    
    echo json_encode([
        'success' => true,
        'exercise' => $randomExercise,
        'level' => $level
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * So sánh 2 đoạn phát âm
 */
function comparePronunciation() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $text1 = $input['text1'] ?? '';
    $text2 = $input['text2'] ?? '';
    
    $similarity = calculateSimilarity($text1, $text2);
    
    echo json_encode([
        'success' => true,
        'similarity' => $similarity,
        'message' => $similarity > 80 ? 'Rất giống!' : ($similarity > 60 ? 'Khá giống' : 'Cần cải thiện')
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * Tính độ tương đồng giữa 2 chuỗi (Levenshtein)
 */
function calculateSimilarity($str1, $str2) {
    $str1 = strtolower(trim($str1));
    $str2 = strtolower(trim($str2));
    
    if (empty($str1) || empty($str2)) {
        return 0;
    }
    
    $maxLen = max(strlen($str1), strlen($str2));
    $distance = levenshtein($str1, $str2);
    
    return round((1 - ($distance / $maxLen)) * 100, 2);
}

/**
 * Gọi Gemini API
 */
function callGeminiAPI($prompt) {
    $url = GEMINI_API_URL . '?key=' . GEMINI_API_KEY;
    
    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.7,
            'maxOutputTokens' => 1024
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
    
    return null;
}

/**
 * Parse JSON từ text response
 */
function parseJSONFromText($text) {
    // Tìm JSON trong text
    preg_match('/\{.*\}/s', $text, $matches);
    
    if (!empty($matches[0])) {
        $json = json_decode($matches[0], true);
        if ($json) {
            return $json;
        }
    }
    
    return [];
}

/**
 * Chuyển điểm thành level
 */
function getLevel($score) {
    if ($score >= 90) return 'Excellent';
    if ($score >= 70) return 'Good';
    if ($score >= 50) return 'Fair';
    return 'Need Improvement';
}
?>
