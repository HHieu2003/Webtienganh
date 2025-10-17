<?php

/**
 * 
 * @package FighterChatbot
 * @author Your Name
 * @date 2025-10-18
 */

class ChatbotService
{
    private $conn;
    private $geminiApiKey;
    private $geminiApiUrl;
    private $conversationHistory = [];
    private $maxHistoryLength = 10;
    private $userId = 0;

    /**
     * Constructor
     * 
     * @param mysqli $connection Database connection
     * @param int $userId User ID for loading conversation context
     */
    public function __construct($connection, $userId = 0)
    {
        $this->conn = $connection;
        $this->geminiApiKey = GEMINI_API_KEY;
        $this->geminiApiUrl = GEMINI_API_URL;
        $this->userId = $userId;

        // Load recent conversation history for context
        if ($userId > 0) {
            $this->loadConversationContext($userId);
        }

        error_log("ChatbotService initialized for user ID: {$userId}");
    }

    // =========================================================================
    // CONVERSATIONAL MEMORY METHODS
    // =========================================================================

    /**
     * Load recent conversation history from database
     * 
     * @param int $userId User ID
     * @param int $limit Number of recent messages to load
     * @return void
     */
    private function loadConversationContext($userId, $limit = 5)
    {
        try {
            $sql = "SELECT user_message, bot_response, chat_type, created_at 
                    FROM chat_history 
                    WHERE id_hocvien = ? 
                    ORDER BY created_at DESC 
                    LIMIT ?";

            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                error_log("Failed to prepare statement: " . $this->conn->error);
                return;
            }

            $stmt->bind_param("ii", $userId, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            $history = [];
            while ($row = $result->fetch_assoc()) {
                // Store in reverse order (oldest first)
                $history[] = [
                    'user' => $row['user_message'],
                    'bot' => $row['bot_response'],
                    'type' => $row['chat_type'],
                    'time' => $row['created_at']
                ];
            }

            // Reverse to get chronological order (oldest to newest)
            $this->conversationHistory = array_reverse($history);

            $stmt->close();

            error_log("Loaded " . count($this->conversationHistory) . " messages for context");
        } catch (Exception $e) {
            error_log("Load conversation context error: " . $e->getMessage());
        }
    }

    /**
     * Add current message pair to conversation context
     * 
     * @param string $userMessage User's message
     * @param string $botResponse Bot's response
     * @return void
     */
    public function addToContext($userMessage, $botResponse)
    {
        $this->conversationHistory[] = [
            'user' => $userMessage,
            'bot' => $botResponse,
            'time' => date('Y-m-d H:i:s')
        ];

        // Keep only last N messages to avoid context overflow
        if (count($this->conversationHistory) > $this->maxHistoryLength) {
            $this->conversationHistory = array_slice(
                $this->conversationHistory,
                -$this->maxHistoryLength
            );
        }

        error_log("Added to context. Total messages: " . count($this->conversationHistory));
    }

    /**
     * Build formatted conversation context for AI prompt
     * 
     * @return string Formatted conversation history
     */
    private function buildConversationContext()
    {
        if (empty($this->conversationHistory)) {
            return "";
        }

        $contextText = "\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $contextText .= "📜 LỊCH SỬ HỘI THOẠI TRƯỚC ĐÓ\n";
        $contextText .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $contextText .= "⚠️ QUAN TRỌNG: Sử dụng thông tin này để:\n";
        $contextText .= "• Hiểu ngữ cảnh câu hỏi hiện tại\n";
        $contextText .= "• Trả lời các câu hỏi mơ hồ (ví dụ: 'còn khóa đó?', 'nó thế nào?', 'cho tôi biết thêm')\n";
        $contextText .= "• Tạo sự liên kết mạch lạc giữa các câu trả lời\n";
        $contextText .= "• Tham chiếu lại thông tin đã đề cập trước đó\n\n";

        foreach ($this->conversationHistory as $index => $item) {
            $msgNumber = $index + 1;
            $contextText .= "┌─ Tin nhắn #{$msgNumber}\n";
            $contextText .= "│ 👤 HỌC VIÊN HỎI: {$item['user']}\n";
            $contextText .= "│ 🤖 TRỢ LÝ TRẢ LỜI: " . $this->shortenText($item['bot'], 200) . "\n";
            $contextText .= "└─────────────────────────────────────────\n\n";
        }

        $contextText .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $contextText .= "📌 KẾT THÚC LỊCH SỬ - BẮT ĐẦU CÂU HỎI MỚI\n";
        $contextText .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

        return $contextText;
    }

    /**
     * Shorten text for context display
     * 
     * @param string $text Text to shorten
     * @param int $maxLength Maximum length
     * @return string Shortened text
     */
    private function shortenText($text, $maxLength = 200)
    {
        if (strlen($text) <= $maxLength) {
            return $text;
        }

        return substr($text, 0, $maxLength) . "...";
    }

    /**
     * Clear conversation context
     * 
     * @return void
     */
    public function clearContext()
    {
        $this->conversationHistory = [];
        error_log("Conversation context cleared for user ID: {$this->userId}");
    }

    /**
     * Get current conversation context
     * 
     * @return array Conversation history
     */
    public function getContext()
    {
        return $this->conversationHistory;
    }

    /**
     * Get context summary for debugging
     * 
     * @return array Context summary
     */
    public function getContextSummary()
    {
        return [
            'user_id' => $this->userId,
            'message_count' => count($this->conversationHistory),
            'oldest_message' => !empty($this->conversationHistory) ? $this->conversationHistory[0]['time'] : null,
            'newest_message' => !empty($this->conversationHistory) ? end($this->conversationHistory)['time'] : null,
            'max_history_length' => $this->maxHistoryLength
        ];
    }

    // =========================================================================
    // MAIN CHATBOT FUNCTIONS
    // =========================================================================

    /**
     * CHỨC NĂNG 1: TƯ VẤN TỪ DATABASE + AI
     * Lấy thông tin từ database và dùng Gemini để tổng hợp câu trả lời
     * 
     * @param string $message User's message
     * @param bool $includeContext Include conversation context
     * @return array|null Response array or null if no database context found
     */
    public function getDatabaseAdvice($message, $includeContext = true)
    {
        $context = $this->gatherDatabaseContext($message);

        if (empty($context)) {
            error_log("No database context found for message: {$message}");
            return null;
        }

        // Build prompt with conversation history
        $prompt = $this->buildDatabasePrompt($message, $context, $includeContext);
        $response = $this->callGeminiAPI($prompt);

        // Add to context for next message
        if ($response) {
            $this->addToContext($message, $response);
        }

        return [
            'response' => $response,
            'type' => 'database_advice',
            'context' => $context,
            'has_conversation_history' => !empty($this->conversationHistory)
        ];
    }

    /**
     * CHỨC NĂNG 2: GIẢNG DẠY TIẾNG ANH
     * Dùng Gemini AI để dạy tiếng Anh với khả năng ghi nhớ
     * 
     * @param string $message User's message
     * @param bool $includeContext Include conversation context
     * @return array Response array
     */
    public function teachEnglish($message, $includeContext = true)
    {
        $prompt = $this->buildTeachingPrompt($message, $includeContext);
        $response = $this->callGeminiAPI($prompt);

        // Add to context for next message
        if ($response) {
            $this->addToContext($message, $response);
        }

        return [
            'response' => $response,
            'type' => 'ai_teaching',
            'has_conversation_history' => !empty($this->conversationHistory)
        ];
    }

    // =========================================================================
    // DATABASE CONTEXT GATHERING
    // =========================================================================

    /**
     * Thu thập thông tin từ database theo câu hỏi
     * 
     * @param string $message User's message
     * @return array Database context
     */
    private function gatherDatabaseContext($message)
    {
        $context = [];
        $messageLower = strtolower($message);

        // Phát hiện intent từ keywords
        $isAboutCourse = $this->containsKeywords($messageLower, [
            'khóa học',
            'course',
            'lớp',
            'khoá',
            'khóa'
        ]);

        $isAboutFee = $this->containsKeywords($messageLower, [
            'học phí',
            'giá',
            'tiền',
            'cost',
            'fee',
            'phí',
            'bao nhiêu'
        ]);

        $isAboutSchedule = $this->containsKeywords($messageLower, [
            'lịch học',
            'thời gian',
            'schedule',
            'giờ học',
            'buổi học',
            'khi nào'
        ]);

        $isAboutTeacher = $this->containsKeywords($messageLower, [
            'giảng viên',
            'teacher',
            'giáo viên',
            'thầy',
            'cô'
        ]);

        $isAboutContact = $this->containsKeywords($messageLower, [
            'liên hệ',
            'contact',
            'hotline',
            'địa chỉ',
            'email',
            'số điện thoại'
        ]);

        // Lấy thông tin khóa học
        if ($isAboutCourse || $isAboutFee) {
            $sql = "SELECT id_khoahoc, ten_khoahoc, mo_ta, chi_phi, thoi_gian, danh_gia_tb 
                    FROM khoahoc 
                    ORDER BY danh_gia_tb DESC 
                    LIMIT 5";
            $result = $this->conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $context['courses'] = [];
                while ($row = $result->fetch_assoc()) {
                    $context['courses'][] = $row;
                }
                error_log("Found " . count($context['courses']) . " courses");
            }
        }

        // Lấy thông tin lịch học
        if ($isAboutSchedule) {
            $sql = "SELECT lh.*, lp.ten_lop, kh.ten_khoahoc 
                    FROM lichhoc lh
                    JOIN lop_hoc lp ON lh.id_lop = lp.id_lop
                    JOIN khoahoc kh ON lp.id_khoahoc = kh.id_khoahoc
                    WHERE lh.ngay_hoc >= CURDATE()
                    ORDER BY lh.ngay_hoc ASC
                    LIMIT 5";
            $result = $this->conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $context['schedules'] = [];
                while ($row = $result->fetch_assoc()) {
                    $context['schedules'][] = $row;
                }
                error_log("Found " . count($context['schedules']) . " schedules");
            }
        }

        // Lấy thông tin giảng viên
        if ($isAboutTeacher) {
            $sql = "SELECT ten_giangvien, mo_ta, email, so_dien_thoai 
                    FROM giangvien 
                    LIMIT 5";
            $result = $this->conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $context['teachers'] = [];
                while ($row = $result->fetch_assoc()) {
                    $context['teachers'][] = $row;
                }
                error_log("Found " . count($context['teachers']) . " teachers");
            }
        }

        // Thông tin liên hệ
        if ($isAboutContact) {
            $context['contact'] = [
                'center_name' => 'Fighter English Center',
                'address' => '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh',
                'hotline' => '0962.501.832',
                'support' => '0336.123.130',
                'email' => 'info@tienganfighter.com',
                'website' => 'www.tienganfighter.com'
            ];
            error_log("Added contact information");
        }

        return $context;
    }

    // =========================================================================
    // PROMPT BUILDERS
    // =========================================================================

    /**
     * Build database advice prompt with conversation context
     * 
     * @param string $message User's message
     * @param array $context Database context
     * @param bool $includeContext Include conversation history
     * @return string Complete prompt for AI
     */
    private function buildDatabasePrompt($message, $context, $includeContext = true)
    {
        $contextText = "📊 THÔNG TIN TỪ CƠ SỞ DỮ LIỆU:\n\n";

        // Add database context (courses, schedules, etc.)
        if (isset($context['courses'])) {
            $contextText .= "🎓 DANH SÁCH KHÓA HỌC:\n";
            foreach ($context['courses'] as $course) {
                $contextText .= "─────────────────────────────────────────\n";
                $contextText .= "📚 Tên khóa: {$course['ten_khoahoc']}\n";
                $contextText .= "💰 Học phí: " . number_format($course['chi_phi'], 0, ',', '.') . " VNĐ\n";
                $contextText .= "⏱️ Thời lượng: {$course['thoi_gian']} buổi\n";
                $contextText .= "⭐ Đánh giá: {$course['danh_gia_tb']}/5\n";
                $contextText .= "📖 Mô tả: " . strip_tags($course['mo_ta']) . "\n\n";
            }
        }

        if (isset($context['schedules'])) {
            $contextText .= "\n📅 LỊCH HỌC SẮP TỚI:\n";
            foreach ($context['schedules'] as $schedule) {
                $contextText .= "─────────────────────────────────────────\n";
                $contextText .= "🏫 Lớp: {$schedule['ten_lop']} ({$schedule['ten_khoahoc']})\n";
                $contextText .= "📆 Ngày: {$schedule['ngay_hoc']}\n";
                $contextText .= "⏰ Giờ: {$schedule['gio_bat_dau']} - {$schedule['gio_ket_thuc']}\n";
                $contextText .= "🚪 Phòng: {$schedule['phong_hoc']}\n\n";
            }
        }

        if (isset($context['teachers'])) {
            $contextText .= "\n👨‍🏫 ĐỘI NGŨ GIẢNG VIÊN:\n";
            foreach ($context['teachers'] as $teacher) {
                $contextText .= "─────────────────────────────────────────\n";
                $contextText .= "👤 Tên: {$teacher['ten_giangvien']}\n";
                $contextText .= "📝 Kinh nghiệm: " . strip_tags($teacher['mo_ta']) . "\n";
                $contextText .= "📧 Email: {$teacher['email']}\n";
                $contextText .= "📞 SĐT: {$teacher['so_dien_thoai']}\n\n";
            }
        }

        if (isset($context['contact'])) {
            $c = $context['contact'];
            $contextText .= "\n📞 THÔNG TIN LIÊN HỆ:\n";
            $contextText .= "─────────────────────────────────────────\n";
            $contextText .= "🏢 Trung tâm: {$c['center_name']}\n";
            $contextText .= "📍 Địa chỉ: {$c['address']}\n";
            $contextText .= "☎️ Hotline: {$c['hotline']}\n";
            $contextText .= "💬 Hỗ trợ: {$c['support']}\n";
            $contextText .= "📧 Email: {$c['email']}\n";
            $contextText .= "🌐 Website: {$c['website']}\n\n";
        }

        // Add conversation history if available
        $conversationContext = "";
        if ($includeContext) {
            $conversationContext = $this->buildConversationContext();
        }

        $prompt = "Bạn là trợ lý AI thông minh và thân thiện của Fighter English Center.

🎯 NHIỆM VỤ: 
Dựa vào thông tin từ cơ sở dữ liệu và lịch sử hội thoại (nếu có), hãy trả lời câu hỏi của học viên một cách chuyên nghiệp, chi tiết và có liên kết với các câu hỏi trước đó.

$contextText
$conversationContext

❓ CÂU HỎI HIỆN TẠI CỦA HỌC VIÊN:
{$message}

📋 YÊU CẦU TRẢ LỜI:

1. **Ngôn ngữ**: Trả lời bằng tiếng Việt, rõ ràng và dễ hiểu

2. **Xử lý câu hỏi mơ hồ**:
   - NẾU học viên hỏi về điều gì đã được đề cập trước đó
   - Ví dụ: 'còn khóa đó thì sao?', 'giá bao nhiêu?', 'cho tôi biết thêm về nó'
   - HÃY dựa vào lịch sử hội thoại để hiểu chính xác ngữ cảnh
   - Đề cập rõ: 'Như em đã hỏi về [tên khóa học]...' hoặc 'Về [chủ đề] mà em quan tâm...'

3. **Cấu trúc câu trả lời**:
   - Bắt đầu với câu tóm tắt ngắn gọn
   - Chia thành các phần rõ ràng với emoji phù hợp
   - Kết thúc với lời khuyên/hành động tiếp theo

4. **Emoji sử dụng**: 📚 🎓 💰 📞 ⏰ ✨ 🎯 💡 👍 ✅

5. **Độ dài**: 200-400 từ

6. **Tone**: Thân thiện, nhiệt tình, chuyên nghiệp

7. **Call-to-action**: Nếu cần thêm thông tin, khuyến khích học viên:
   - Liên hệ hotline: 0962.501.832
   - Hoặc hỏi thêm chatbot

🤖 BẮT ĐẦU TRẢ LỜI:";

        return $prompt;
    }

    /**
     * Build teaching prompt with conversation context
     * 
     * @param string $message User's message
     * @param bool $includeContext Include conversation history
     * @return string Complete prompt for AI
     */
    private function buildTeachingPrompt($message, $includeContext = true)
    {
        // Add conversation history if available
        $conversationContext = "";
        if ($includeContext) {
            $conversationContext = $this->buildConversationContext();
        }

        $prompt = "Bạn là giáo viên tiếng Anh AI chuyên nghiệp và tận tâm của Fighter English Center.

🎯 NHIỆM VỤ: 
Giúp học viên học tiếng Anh hiệu quả, có liên kết với các câu hỏi trước đó và tạo trải nghiệm học tập mạch lạc.

📚 NGUYÊN TẮC GIẢNG DẠY:

1. **Ngôn ngữ**: Trả lời bằng tiếng Việt kết hợp tiếng Anh

2. **Xử lý câu hỏi liên tục**:
   - NẾU học viên hỏi tiếp về chủ đề đã học trước đó
   - Ví dụ: 'cho tôi thêm ví dụ', 'còn cách nào khác?', 'nó khác gì với...'
   - HÃY tham khảo lịch sử để đưa ra câu trả lời có liên kết
   - Đề cập: 'Như em vừa học về...', 'Tiếp tục với chủ đề...'

3. **Giải thích**:
   - Đơn giản, dễ hiểu, từng bước
   - Luôn có ví dụ cụ thể kèm dịch nghĩa
   - Chỉ ra lỗi thường gặp

4. **Emoji**: 📚 🎯 💡 ✨ 🗣️ ✅ ❌ 📖 ✍️ 🔊

5. **Độ dài**: 250-400 từ

6. **Tone**: Thân thiện, khuyến khích, kiên nhẫn
$conversationContext

📝 CẤU TRÚC TRẢ LỜI (Tùy loại câu hỏi):

【NGỮ PHÁP】
📚 **Giải thích quy tắc**
[Giải thích dễ hiểu]

✍️ **Cấu trúc**
[Formula rõ ràng]

📝 **Ví dụ**
1. [Example 1] - [Dịch nghĩa]
2. [Example 2] - [Dịch nghĩa]
3. [Example 3] - [Dịch nghĩa]

⚠️ **Lỗi thường gặp**
❌ [Wrong example] - [Tại sao sai]
✅ [Correct example] - [Cách đúng]

💡 **Mẹo ghi nhớ**
[Tips hữu ích]

【TỪ VỰNG】
📖 **Từ**: [Word] /IPA/ (cách đọc bằng tiếng Việt)
🇻🇳 **Nghĩa**: [Vietnamese meaning]
📚 **Word Family**:
   • Noun: [noun form]
   • Verb: [verb form]
   • Adjective: [adj form]
   • Adverb: [adv form]

📝 **Ví dụ trong câu**:
1. [Sentence 1] - [Dịch]
2. [Sentence 2] - [Dịch]
3. [Sentence 3] - [Dịch]

💡 **Tips sử dụng**
[Usage tips, collocations]

【PHÁT ÂM】
🗣️ **Phát âm**: /IPA/
🔊 **Cách đọc**: [Chi tiết bằng tiếng Việt]
⭐ **Trọng âm**: [Vị trí và cách nhấn]
💡 **Tips**: [Phương pháp luyện tập]

【GIAO TIẾP】
🗣️ **Tình huống**: [Mô tả context]
📝 **Mẫu câu**:
   • Formal: [Formal expression]
   • Informal: [Informal expression]
   • Casual: [Casual expression]

💡 **Tips giao tiếp**
[Communication tips]

🎯 **Luyện tập**
[Practice suggestions]

❓ CÂU HỎI HIỆN TẠI CỦA HỌC VIÊN:
{$message}

🤖 BẮT ĐẦU GIẢNG BÀI:";

        return $prompt;
    }

    // =========================================================================
    // GEMINI API INTEGRATION
    // =========================================================================

    /**
     * Call Gemini API with retry logic
     * 
     * @param string $prompt Prompt to send
     * @param int $retryCount Current retry attempt
     * @return string|null Response text or null on failure
     */
    private function callGeminiAPI($prompt, $retryCount = 0)
    {
        try {
            $url = $this->geminiApiUrl . '?key=' . $this->geminiApiKey;

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
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => true
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new Exception("cURL Error: " . $error);
            }

            if ($httpCode !== 200) {
                error_log("Gemini API HTTP Error: {$httpCode}");

                // Retry logic
                if ($retryCount < 2) {
                    error_log("Retrying API call... Attempt " . ($retryCount + 1));
                    sleep(1);
                    return $this->callGeminiAPI($prompt, $retryCount + 1);
                }

                throw new Exception("API Error: HTTP " . $httpCode);
            }

            $result = json_decode($response, true);

            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                error_log("Invalid API response format: " . json_encode($result));
                throw new Exception("Invalid API response format");
            }

            $responseText = trim($result['candidates'][0]['content']['parts'][0]['text']);
            error_log("Gemini API response length: " . strlen($responseText) . " characters");

            return $responseText;
        } catch (Exception $e) {
            error_log("Gemini API Error: " . $e->getMessage());

            // Retry logic
            if ($retryCount < 2) {
                error_log("Retrying API call... Attempt " . ($retryCount + 1));
                sleep(1);
                return $this->callGeminiAPI($prompt, $retryCount + 1);
            }

            return null;
        }
    }
    /**
     * CHỨC NĂNG 3: TRẢ LỜI CÂU HỎI CHUNG
     * Dùng Gemini AI để trả lời bất kỳ câu hỏi nào
     * 
     * @param string $message User's message
     * @param bool $includeContext Include conversation context
     * @return array Response array
     */
    public function answerGeneral($message, $includeContext = true)
    {
        $prompt = $this->buildGeneralPrompt($message, $includeContext);
        $response = $this->callGeminiAPI($prompt);

        // Add to context for next message
        if ($response) {
            $this->addToContext($message, $response);
        }

        return [
            'response' => $response,
            'type' => 'general_ai',
            'has_conversation_history' => !empty($this->conversationHistory)
        ];
    }

    /**
     * Build general AI prompt
     * 
     * @param string $message User's message
     * @param bool $includeContext Include conversation history
     * @return string Complete prompt for AI
     */
    private function buildGeneralPrompt($message, $includeContext = true)
    {
        // Add conversation history if available
        $conversationContext = "";
        if ($includeContext) {
            $conversationContext = $this->buildConversationContext();
        }

        $prompt = "Bạn là trợ lý AI thông minh và hữu ích của Fighter English Center.

🎯 NHIỆM VỤ:
Trả lời câu hỏi của người dùng một cách chính xác, chi tiết và dễ hiểu.

$conversationContext

❓ CÂU HỎI HIỆN TẠI CỦA NGƯỜI DÙNG:
{$message}

📋 YÊU CẦU TRẢ LỜI:
1. **Ngôn ngữ**: Trả lời bằng tiếng Việt
2. **Độ chính xác**: Đảm bảo thông tin chính xác và đáng tin cậy
3. **Cấu trúc**:
   - Bắt đầu với câu trả lời trực tiếp
   - Giải thích chi tiết nếu cần
   - Kết thúc với thông tin bổ sung (nếu có)
4. **Emoji**: Sử dụng emoji phù hợp để làm rõ nội dung
5. **Độ dài**: 100-300 từ
6. **Tone**: Thân thiện, chuyên nghiệp
7. **Xử lý toán học**: 
   - Nếu là bài toán, tính toán chính xác
   - Hiển thị công thức và cách giải
   - Kiểm tra kết quả trước khi trả lời

🤖 BẮT ĐẦU TRẢ LỜI:";

        return $prompt;
    }

    // =========================================================================
    // INTENT DETECTION
    // =========================================================================

    /**
     * Detect user intent from message
     * 
     * @param string $message User's message
     * @return string Intent type: 'english_learning', 'center_info', or 'mixed'
     */
    public function detectIntent($message)
    {
        $messageLower = strtolower($message);

        // Keywords cho English learning
        $englishKeywords = [
            'grammar',
            'ngữ pháp',
            'vocabulary',
            'từ vựng',
            'pronunciation',
            'phát âm',
            'how to',
            'what is',
            'what\'s',
            'nghĩa là gì',
            'dịch',
            'translate',
            'meaning',
            'tense',
            'thì',
            'verb',
            'noun',
            'adjective',
            'adverb',
            'speaking',
            'listening',
            'reading',
            'writing',
            'ielts',
            'toeic',
            'sentence',
            'câu',
            'word',
            'phrase'
        ];

        // Keywords cho center info
        $centerKeywords = [
            'khóa học',
            'khoá',
            'course',
            'học phí',
            'giá',
            'tiền',
            'cost',
            'fee',
            'lịch học',
            'schedule',
            'thời gian',
            'lớp',
            'class',
            'giảng viên',
            'teacher',
            'liên hệ',
            'contact',
            'hotline',
            'địa chỉ',
            'đăng ký',
            'register',
            'trung tâm',
            'center',
            'tư vấn',
            'hỏi về'
        ];

        $englishScore = 0;
        $centerScore = 0;

        // Count keyword matches
        foreach ($englishKeywords as $keyword) {
            if (strpos($messageLower, $keyword) !== false) {
                $englishScore++;
            }
        }

        foreach ($centerKeywords as $keyword) {
            if (strpos($messageLower, $keyword) !== false) {
                $centerScore++;
            }
        }

        // Decision logic
        if ($englishScore > $centerScore) {
            error_log("Intent detected: english_learning (score: {$englishScore} vs {$centerScore})");
            return 'english_learning';
        } elseif ($centerScore > $englishScore) {
            error_log("Intent detected: center_info (score: {$centerScore} vs {$englishScore})");
            return 'center_info';
        } elseif ($englishScore > 0 && $centerScore > 0) {
            error_log("Intent detected: mixed (score: {$englishScore} = {$centerScore})");
            return 'mixed';
        } else {
            error_log("Intent detected: general (no specific keywords)");
            return 'general';
        }
    }

    // =========================================================================
    // DATABASE OPERATIONS
    // =========================================================================

    /**
     * Save chat history to database
     * 
     * @param int $userId User ID
     * @param string $userMessage User's message
     * @param string $botResponse Bot's response
     * @param string $type Chat type
     * @return bool Success status
     */
    public function saveChatHistory($userId, $userMessage, $botResponse, $type)
    {
        try {
            $sql = "INSERT INTO chat_history (id_hocvien, user_message, bot_response, chat_type, created_at)
                    VALUES (?, ?, ?, ?, NOW())";

            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                error_log("Failed to prepare save statement: " . $this->conn->error);
                return false;
            }

            $stmt->bind_param("isss", $userId, $userMessage, $botResponse, $type);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                error_log("Chat history saved successfully for user ID: {$userId}");
            } else {
                error_log("Failed to save chat history for user ID: {$userId}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("Save chat history error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get chat history from database
     * 
     * @param int $userId User ID
     * @param int $limit Number of messages to retrieve
     * @return array Chat history
     */
    public function getChatHistory($userId, $limit = 20)
    {
        try {
            $sql = "SELECT user_message, bot_response, chat_type, 
                           DATE_FORMAT(created_at, '%H:%i') as time,
                           UNIX_TIMESTAMP(created_at) as timestamp
                    FROM chat_history
                    WHERE id_hocvien = ?
                    ORDER BY created_at DESC
                    LIMIT ?";

            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                error_log("Failed to prepare get history statement: " . $this->conn->error);
                return [];
            }

            $stmt->bind_param("ii", $userId, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            $history = [];
            while ($row = $result->fetch_assoc()) {
                $history[] = $row;
            }

            $stmt->close();

            error_log("Retrieved " . count($history) . " messages for user ID: {$userId}");

            // Reverse to get chronological order
            return array_reverse($history);
        } catch (Exception $e) {
            error_log("Get chat history error: " . $e->getMessage());
            return [];
        }
    }

    // =========================================================================
    // UTILITY METHODS
    // =========================================================================

    /**
     * Check if message contains any of the keywords
     * 
     * @param string $message Message to check
     * @param array $keywords Keywords to search for
     * @return bool True if any keyword found
     */
    private function containsKeywords($message, $keywords)
    {
        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
    public function clearChatHistory($userId)
    {
        try {
            $sql = "DELETE FROM chat_history WHERE id_hocvien = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                error_log("Failed to prepare delete statement: " . $this->conn->error);
                return false;
            }

            $stmt->bind_param("i", $userId);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                error_log("Chat history cleared successfully for user ID: {$userId}");
            } else {
                error_log("Failed to clear chat history for user ID: {$userId}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("Clear chat history error: " . $e->getMessage());
            return false;
        }
    }
}
