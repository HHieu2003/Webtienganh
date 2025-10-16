<?php
// chatbot/ai_teacher.php - Advanced AI Teacher with Gemini
require_once 'config.php';

class AITeacher {
    private $apiKey;
    private $apiUrl;
    private $maxRetries = 2;
    private $contextWindow = [];
    
    public function __construct() {
        $this->apiKey = GEMINI_API_KEY;
        $this->apiUrl = GEMINI_API_URL;
    }
    
    /**
     * Main method: Teach English using Gemini AI
     */
    public function teachEnglish($message, $context = []) {
        try {
            // Check if this is an English learning question
            if (!$this->isEnglishLearningQuestion($message)) {
                return null;
            }
            
            // Detect question type
            $questionType = $this->detectQuestionType($message);
            
            // Build specialized prompt based on question type
            $prompt = $this->buildPrompt($message, $questionType, $context);
            
            // Call Gemini API
            $response = $this->callGeminiAPI($prompt);
            
            // Format and enhance response
            return $this->enhanceResponse($response, $questionType);
            
        } catch (Exception $e) {
            error_log("AITeacher Error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Detect if message is English learning related
     */
    private function isEnglishLearningQuestion($message) {
        $message = strtolower($message);
        
        // English learning keywords
        $englishKeywords = [
            // English words
            'how', 'what', 'when', 'where', 'why', 'who', 'which',
            'explain', 'mean', 'meaning', 'difference', 'between',
            'grammar', 'vocabulary', 'pronunciation', 'tense',
            'verb', 'noun', 'adjective', 'adverb', 'preposition',
            'speaking', 'listening', 'reading', 'writing',
            'sentence', 'phrase', 'word', 'translate',
            
            // Vietnamese keywords
            'nghĩa', 'dịch', 'phát âm', 'ngữ pháp', 'từ vựng',
            'cách nói', 'cách dùng', 'khác nhau', 'là gì',
            'tiếng anh', 'english', 'học'
        ];
        
        foreach ($englishKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        
        // Check if message contains mostly English characters
        $englishChars = preg_match_all('/[a-zA-Z]/', $message);
        $totalChars = mb_strlen(preg_replace('/\s/', '', $message));
        
        if ($totalChars > 3 && ($englishChars / $totalChars) > 0.5) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Detect specific question type
     */
    private function detectQuestionType($message) {
        $message = strtolower($message);
        
        // Question type patterns
        $patterns = [
            'grammar' => ['grammar', 'ngữ pháp', 'tense', 'thì', 'cấu trúc'],
            'vocabulary' => ['vocabulary', 'từ vựng', 'word', 'từ', 'nghĩa', 'meaning'],
            'pronunciation' => ['pronunciation', 'phát âm', 'pronounce', 'accent', 'giọng'],
            'translation' => ['translate', 'dịch', 'mean', 'nghĩa là'],
            'usage' => ['how to use', 'cách dùng', 'usage', 'sử dụng', 'when to use'],
            'difference' => ['difference', 'khác nhau', 'between', 'vs', 'so sánh'],
            'speaking' => ['speaking', 'nói', 'conversation', 'talk', 'giao tiếp'],
            'writing' => ['writing', 'viết', 'essay', 'email', 'letter'],
            'general' => []
        ];
        
        foreach ($patterns as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $type;
                }
            }
        }
        
        return 'general';
    }
    
    /**
     * Build specialized prompt based on question type
     */
    private function buildPrompt($message, $questionType, $context = []) {
        $systemRole = "Bạn là giáo viên tiếng Anh AI chuyên nghiệp của Fighter English Center.";
        
        $commonRules = "
NGUYÊN TẮC CHUNG:
- Trả lời bằng tiếng Việt và tiếng Anh kết hợp
- Giải thích đơn giản, dễ hiểu cho người Việt
- Luôn đưa ra ví dụ cụ thể có dịch nghĩa
- Sử dụng emoji phù hợp: 📚 🎯 💡 ✨ 🗣️ 📝 ✅ ❌
- Độ dài: 250-400 từ
- Giọng điệu: Thân thiện, nhiệt tình, khuyến khích
";

        // Specialized prompts for each question type
        $typePrompts = [
            'grammar' => "
CHUYÊN MÔN NGỮ PHÁP:
1. Giải thích quy tắc ngữ pháp rõ ràng
2. So sánh với tiếng Việt nếu có thể
3. Đưa ra 3-4 ví dụ từ dễ đến khó
4. Chỉ ra lỗi thường gặp
5. Tips ghi nhớ

CẤU TRÚC TRẢ LỜI:
📚 **Giải thích quy tắc**
✍️ **Cấu trúc**: [Formula]
📝 **Ví dụ**: [Examples with translation]
⚠️ **Lưu ý**: [Common mistakes]
💡 **Mẹo**: [Memory tips]
",
            'vocabulary' => "
CHUYÊN MÔN TỪ VỰNG:
1. Giải nghĩa tiếng Việt chính xác
2. Phiên âm IPA + cách đọc đơn giản
3. Word family (noun, verb, adj, adv)
4. Collocations & phrases phổ biến
5. Ví dụ trong câu thực tế

CẤU TRÚC TRẢ LỜI:
📖 **Từ**: [Word] /IPA/ (cách đọc)
🇻🇳 **Nghĩa**: [Vietnamese meaning]
📚 **Word Family**: [Related words]
🔗 **Collocations**: [Common phrases]
📝 **Ví dụ**: [3 examples with translation]
",
            'pronunciation' => "
CHUYÊN MÔN PHÁT ÂM:
1. Phiên âm IPA chuẩn
2. Hướng dẫn cách đọc chi tiết
3. So sánh với âm tiếng Việt
4. Điểm nhấn (stress)
5. Tips luyện phát âm

CẤU TRÚC TRẢ LỜI:
🗣️ **Phát âm**: /IPA/
🔊 **Cách đọc**: [Giải thích bằng tiếng Việt]
⭐ **Trọng âm**: [Stress position]
💡 **Tips**: [Practice methods]
📝 **Ví dụ**: [Words/sentences to practice]
",
            'translation' => "
CHUYÊN MÔN DỊCH THUẬT:
1. Dịch chính xác, tự nhiên
2. Giải thích ngữ cảnh sử dụng
3. Đưa ra nhiều cách diễn đạt
4. Lưu ý về văn hóa nếu có

CẤU TRÚC TRẢ LỜI:
🇬🇧 **Tiếng Anh**: [English]
🇻🇳 **Tiếng Việt**: [Vietnamese]
💡 **Giải thích**: [Context & usage]
📝 **Các cách nói khác**: [Alternatives]
⚠️ **Lưu ý**: [Cultural/contextual notes]
",
            'difference' => "
CHUYÊN MÔN SO SÁNH:
1. Nêu rõ điểm khác biệt
2. Bảng so sánh trực quan
3. Ví dụ minh họa từng trường hợp
4. Khi nào dùng cái nào

CẤU TRÚC TRẢ LỜI:
🔍 **Sự khác biệt chính**
📊 **So sánh**:
   • [Item 1]: [Explanation + Example]
   • [Item 2]: [Explanation + Example]
🎯 **Khi nào dùng**:
   ✅ Dùng [A] khi: [Situation]
   ✅ Dùng [B] khi: [Situation]
",
            'speaking' => "
CHUYÊN MÔN GIAO TIẾP:
1. Cung cấp mẫu câu thực tế
2. Phân tích ngữ cảnh sử dụng
3. Luyện tập theo chủ đề
4. Tips giao tiếp tự tin

CẤU TRÚC TRẢ LỜI:
🗣️ **Tình huống**: [Context]
📝 **Mẫu câu**:
   1. [Formal option]
   2. [Informal option]
   3. [Casual option]
💡 **Tips giao tiếp**: [Communication tips]
🎯 **Luyện tập**: [Practice suggestions]
",
            'writing' => "
CHUYÊN MÔN VIẾT:
1. Cấu trúc bài viết chuẩn
2. Từ vựng & cụm từ hữu ích
3. Mẫu câu hay
4. Tips viết hay

CẤU TRÚC TRẢ LỜI:
📝 **Cấu trúc**: [Writing structure]
📚 **Từ vựng hữu ích**: [Useful vocabulary]
✍️ **Mẫu câu hay**: [Sample sentences]
💡 **Tips**: [Writing tips]
🎯 **Luyện tập**: [Practice tasks]
",
            'general' => "
CHUYÊN MÔN TỔNG HỢP:
1. Phân tích câu hỏi kỹ
2. Trả lời đầy đủ, logic
3. Ví dụ phong phú
4. Khuyến khích học tập

CẤU TRÚC TRẢ LỜI:
📚 **Giải đáp**: [Main answer]
📝 **Ví dụ**: [Examples]
💡 **Lưu ý**: [Important notes]
🎯 **Khuyến nghị**: [Learning tips]
"
        ];
        
        $typePrompt = $typePrompts[$questionType] ?? $typePrompts['general'];
        
        $fullPrompt = "{$systemRole}

{$commonRules}

{$typePrompt}

CÂU HỎI CỦA HỌC VIÊN:
{$message}

TRẢ LỜI:";

        return $fullPrompt;
    }
    
    /**
     * Call Gemini API
     */
    private function callGeminiAPI($prompt, $retryCount = 0) {
        try {
            $url = $this->apiUrl . '?key=' . $this->apiKey;
            
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
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                    'stopSequences' => []
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ]
                ]
            ];
            
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => true,
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                throw new Exception("cURL Error: " . $error);
            }
            
            if ($httpCode !== 200) {
                if ($retryCount < $this->maxRetries) {
                    sleep(1);
                    return $this->callGeminiAPI($prompt, $retryCount + 1);
                }
                throw new Exception("API Error: HTTP " . $httpCode);
            }
            
            $result = json_decode($response, true);
            
            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                throw new Exception("Invalid API response format");
            }
            
            $text = $result['candidates'][0]['content']['parts'][0]['text'];
            return $text;
            
        } catch (Exception $e) {
            error_log("Gemini API Error: " . $e->getMessage());
            
            if ($retryCount < $this->maxRetries) {
                sleep(1);
                return $this->callGeminiAPI($prompt, $retryCount + 1);
            }
            
            return null;
        }
    }
    
    /**
     * Enhance response with additional elements
     */
    private function enhanceResponse($response, $questionType) {
        if (!$response) {
            return null;
        }
        
        // Clean up response
        $response = trim($response);
        $response = preg_replace('/\n{3,}/', "\n\n", $response);
        
        // Add footer based on question type
        $footers = [
            'grammar' => "\n\n🎯 **Muốn luyện tập thêm?** Hỏi tôi về bài tập hoặc ví dụ khác!",
            'vocabulary' => "\n\n🎯 **Muốn học từ liên quan?** Hỏi tôi về từ vựng cùng chủ đề!",
            'pronunciation' => "\n\n🎯 **Muốn luyện thêm?** Hỏi tôi về các từ khó phát âm khác!",
            'speaking' => "\n\n🎯 **Muốn thực hành?** Hỏi tôi về tình huống giao tiếp khác!",
            'writing' => "\n\n🎯 **Muốn viết tốt hơn?** Hỏi tôi về các dạng bài viết khác!",
            'general' => "\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!"
        ];
        
        $footer = $footers[$questionType] ?? $footers['general'];
        
        return $response . $footer;
    }
    
    /**
     * Quick answer for simple questions
     */
    public function quickAnswer($message) {
        // Quick answers for common questions
        $quickAnswers = [
            'hello' => "👋 [translate:Hello]! Chào bạn! Tôi có thể giúp gì về tiếng Anh cho bạn?",
            'thanks' => "😊 [translate:You're welcome]! Rất vui được giúp bạn học tiếng Anh!",
            'help' => "📚 Tôi có thể giúp bạn:\n• Giải thích ngữ pháp\n• Dạy từ vựng\n• Phát âm\n• Dịch thuật\n• Giao tiếp\n• Viết luận\n\nHãy hỏi tôi bất cứ điều gì!"
        ];
        
        $message = strtolower(trim($message));
        
        foreach ($quickAnswers as $keyword => $answer) {
            if (strpos($message, $keyword) !== false) {
                return $answer;
            }
        }
        
        return null;
    }
}
?>
