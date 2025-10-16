<?php
/**
 * ============================================================================
 * FIGHTER CHATBOT - CHAT HANDLER
 * ============================================================================
 * File: chat_handler.php
 * Description: Smart chat handler with AI routing and response generation
 * Version: 2.0
 * Author: Fighter English Center
 * Last Update: October 17, 2025
 * ============================================================================
 */

// Start output buffering
ob_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/chatbot_errors.log');

// Load required files
try {
    require_once 'config.php';
    require_once 'database_advisor.php';
    require_once 'ai_teacher.php';
    
} catch (Exception $e) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'error' => 'Lỗi tải file: ' . $e->getMessage(),
        'type' => 'system_error'
    ]);
    exit;
}

// Clean output buffer and set headers
ob_clean();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Chỉ cho phép phương thức POST',
        'type' => 'method_error'
    ]);
    exit;
}

// Get and validate input
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Dữ liệu JSON không hợp lệ: ' . json_last_error_msg(),
        'type' => 'json_error'
    ]);
    exit;
}

// Validate message
if (!isset($input['message']) || empty(trim($input['message']))) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Tin nhắn không được để trống',
        'type' => 'validation_error'
    ]);
    exit;
}

$message = trim($input['message']);

// Check message length
if (strlen($message) > MAX_MESSAGE_LENGTH) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Tin nhắn quá dài! Tối đa ' . MAX_MESSAGE_LENGTH . ' ký tự.',
        'type' => 'validation_error',
        'max_length' => MAX_MESSAGE_LENGTH
    ]);
    exit;
}

// Security: Basic XSS prevention
$message = strip_tags($message);

// Main processing
try {
    // Check database connection
    if (!isset($conn) || !$conn) {
        throw new Exception('Không thể kết nối database');
    }
    
    // Get user information
    $userId = 0;
    $userName = null;
    $userInfo = getUserInfo();
    
    if ($userInfo) {
        $userId = $userInfo['id_hocvien'] ?? 0;
        $userName = $userInfo['ten_hocvien'] ?? null;
    }
    
    // Initialize services
    $dbAdvisor = new DatabaseAdvisor($conn);
    $aiTeacher = new AITeacher();
    
    // Response variables
    $response = '';
    $chatType = 'general';
    $confidence = 0;
    $processingTime = microtime(true);
    
    // ========================================================================
    // SMART ROUTING SYSTEM
    // ========================================================================
    
    // Step 1: Quick Answers (instant response)
    $quickAnswer = $aiTeacher->quickAnswer($message);
    if ($quickAnswer) {
        $response = $quickAnswer;
        $chatType = 'quick_answer';
        $confidence = 100;
    }
    
    // Step 2: Intent Analysis & Smart Routing
    if (empty($response)) {
        $intent = analyzeIntent($message);
        $confidence = $intent['confidence'];
        
        switch ($intent['priority']) {
            case 'ai_first':
                // ============================================================
                // AI-FIRST ROUTING: English learning questions
                // ============================================================
                try {
                    $aiResponse = $aiTeacher->teachEnglish($message);
                    if ($aiResponse) {
                        $response = $aiResponse;
                        $chatType = 'ai_teaching';
                    }
                } catch (Exception $e) {
                    error_log("AI Teacher Error: " . $e->getMessage());
                }
                
                // Fallback to database if AI fails
                if (empty($response)) {
                    try {
                        $dbResponse = $dbAdvisor->getAdvice($message);
                        if ($dbResponse) {
                            $response = $dbResponse;
                            $chatType = 'database_advice';
                        }
                    } catch (Exception $e) {
                        error_log("Database Advisor Error: " . $e->getMessage());
                    }
                }
                break;
                
            case 'database_first':
                // ============================================================
                // DATABASE-FIRST ROUTING: Center information
                // ============================================================
                try {
                    $dbResponse = $dbAdvisor->getAdvice($message);
                    if ($dbResponse) {
                        $response = $dbResponse;
                        $chatType = 'database_advice';
                    }
                } catch (Exception $e) {
                    error_log("Database Advisor Error: " . $e->getMessage());
                }
                
                // Fallback to AI if database has no specific answer
                if (empty($response)) {
                    try {
                        $aiResponse = $aiTeacher->teachEnglish($message);
                        if ($aiResponse) {
                            $response = $aiResponse;
                            $chatType = 'ai_teaching';
                        }
                    } catch (Exception $e) {
                        error_log("AI Teacher Error: " . $e->getMessage());
                    }
                }
                break;
                
            case 'hybrid':
                // ============================================================
                // HYBRID ROUTING: Use both database and AI
                // ============================================================
                $dbResponse = null;
                $aiResponse = null;
                
                // Get database response
                try {
                    $dbResponse = $dbAdvisor->getAdvice($message);
                } catch (Exception $e) {
                    error_log("Database Advisor Error: " . $e->getMessage());
                }
                
                // Get AI response
                try {
                    $aiResponse = $aiTeacher->teachEnglish($message);
                } catch (Exception $e) {
                    error_log("AI Teacher Error: " . $e->getMessage());
                }
                
                // Combine responses intelligently
                if ($dbResponse && $aiResponse) {
                    $response = combineResponses($dbResponse, $aiResponse, $intent['type']);
                    $chatType = 'hybrid';
                } elseif ($aiResponse) {
                    $response = $aiResponse;
                    $chatType = 'ai_teaching';
                } elseif ($dbResponse) {
                    $response = $dbResponse;
                    $chatType = 'database_advice';
                }
                break;
                
            default:
                // General query - try both
                try {
                    $aiResponse = $aiTeacher->teachEnglish($message);
                    if ($aiResponse) {
                        $response = $aiResponse;
                        $chatType = 'ai_teaching';
                    }
                } catch (Exception $e) {
                    error_log("AI Teacher Error: " . $e->getMessage());
                }
                
                if (empty($response)) {
                    try {
                        $dbResponse = $dbAdvisor->getAdvice($message);
                        if ($dbResponse) {
                            $response = $dbResponse;
                            $chatType = 'database_advice';
                        }
                    } catch (Exception $e) {
                        error_log("Database Advisor Error: " . $e->getMessage());
                    }
                }
                break;
        }
    }
    
    // Step 3: Default fallback response
    if (empty($response)) {
        $response = getDefaultResponse($userName);
        $chatType = 'general';
        $confidence = 50;
    }
    
    // ========================================================================
    // POST-PROCESSING
    // ========================================================================
    
    // Calculate processing time
    $processingTime = round((microtime(true) - $processingTime) * 1000, 2);
    
    // Generate smart suggestions
    $suggestions = getSuggestions($message, $chatType, $intent['type'] ?? 'general');
    
    // Log chat history (async - don't block response)
    if ($userId > 0) {
        try {
            logChatMessage($userId, $message, $response, $chatType);
        } catch (Exception $e) {
            error_log("Log Chat Error: " . $e->getMessage());
            // Don't block response even if logging fails
        }
    }
    
    // Prepare response metadata
    $metadata = [
        'chat_type' => $chatType,
        'confidence' => $confidence,
        'processing_time' => $processingTime . 'ms',
        'timestamp' => date('H:i'),
        'date' => date('Y-m-d'),
        'user_id' => $userId,
        'user_name' => $userName,
        'intent' => $intent['type'] ?? 'general'
    ];
    
    // Send successful response
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'response' => $response,
        'suggestions' => $suggestions,
        'metadata' => $metadata,
        'type' => $chatType
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
} catch (Exception $e) {
    // Critical error handling
    error_log("Chat Handler Critical Error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Hệ thống đang bảo trì. Vui lòng thử lại sau hoặc liên hệ hotline 0962.501.832!',
        'type' => 'system_error',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE);
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

/**
 * Analyze message intent and determine routing priority
 * 
 * @param string $message User message
 * @return array Intent information with priority and type
 */
function analyzeIntent($message) {
    $message = strtolower($message);
    
    // Database-first keywords (center information)
    $databaseKeywords = [
        'khóa học' => 3,
        'course' => 3,
        'lớp học' => 3,
        'học phí' => 5,
        'giá' => 4,
        'fee' => 5,
        'cost' => 4,
        'tiền' => 3,
        'lịch học' => 5,
        'schedule' => 5,
        'thời gian' => 3,
        'liên hệ' => 5,
        'contact' => 5,
        'hotline' => 5,
        'địa chỉ' => 5,
        'address' => 5,
        'đăng ký' => 5,
        'register' => 5,
        'sign up' => 5
    ];
    
    // AI-first keywords (learning questions)
    $aiKeywords = [
        'how' => 4,
        'what' => 3,
        'why' => 4,
        'when' => 3,
        'where' => 3,
        'explain' => 5,
        'mean' => 4,
        'meaning' => 4,
        'difference' => 5,
        'between' => 4,
        'grammar' => 5,
        'vocabulary' => 5,
        'pronunciation' => 5,
        'tense' => 5,
        'verb' => 4,
        'noun' => 4,
        'adjective' => 4,
        'nghĩa' => 4,
        'dịch' => 5,
        'phát âm' => 5,
        'ngữ pháp' => 5,
        'cách dùng' => 5,
        'cách nói' => 4,
        'translate' => 5
    ];
    
    // Hybrid keywords (need both database and AI)
    $hybridKeywords = [
        'học tiếng anh' => 5,
        'learn english' => 5,
        'cải thiện' => 4,
        'improve' => 4,
        'phương pháp' => 5,
        'method' => 5,
        'tips' => 4,
        'mẹo' => 4,
        'bí quyết' => 4,
        'secret' => 4,
        'lộ trình' => 5,
        'roadmap' => 5
    ];
    
    // Calculate scores
    $dbScore = 0;
    $aiScore = 0;
    $hybridScore = 0;
    
    // Check hybrid keywords first (highest priority)
    foreach ($hybridKeywords as $keyword => $weight) {
        if (strpos($message, $keyword) !== false) {
            $hybridScore += $weight;
        }
    }
    
    // Check database keywords
    foreach ($databaseKeywords as $keyword => $weight) {
        if (strpos($message, $keyword) !== false) {
            $dbScore += $weight;
        }
    }
    
    // Check AI keywords
    foreach ($aiKeywords as $keyword => $weight) {
        if (strpos($message, $keyword) !== false) {
            $aiScore += $weight;
        }
    }
    
    // Additional heuristics
    
    // Check if message is mostly English (favor AI)
    $englishChars = preg_match_all('/[a-zA-Z]/', $message);
    $totalChars = mb_strlen(preg_replace('/\s/', '', $message));
    if ($totalChars > 3 && ($englishChars / $totalChars) > 0.6) {
        $aiScore += 3;
    }
    
    // Check for question marks (favor AI for learning questions)
    if (strpos($message, '?') !== false) {
        $aiScore += 2;
    }
    
    // Check for Vietnamese-specific center questions
    $vietnamesePatterns = ['bao nhiêu', 'như thế nào', 'ở đâu', 'khi nào'];
    foreach ($vietnamesePatterns as $pattern) {
        if (strpos($message, $pattern) !== false) {
            $dbScore += 2;
        }
    }
    
    // Determine priority and type
    $maxScore = max($hybridScore, $dbScore, $aiScore);
    $confidence = min(100, ($maxScore / 10) * 100);
    
    if ($hybridScore > 0 && $hybridScore >= $maxScore) {
        return [
            'priority' => 'hybrid',
            'type' => 'learning_method',
            'confidence' => $confidence,
            'scores' => ['hybrid' => $hybridScore, 'db' => $dbScore, 'ai' => $aiScore]
        ];
    } elseif ($dbScore > $aiScore && $dbScore > 0) {
        return [
            'priority' => 'database_first',
            'type' => 'info_query',
            'confidence' => $confidence,
            'scores' => ['hybrid' => $hybridScore, 'db' => $dbScore, 'ai' => $aiScore]
        ];
    } elseif ($aiScore > $dbScore && $aiScore > 0) {
        return [
            'priority' => 'ai_first',
            'type' => 'learning_query',
            'confidence' => $confidence,
            'scores' => ['hybrid' => $hybridScore, 'db' => $dbScore, 'ai' => $aiScore]
        ];
    } else {
        // Default: AI first for better user experience
        return [
            'priority' => 'ai_first',
            'type' => 'general_query',
            'confidence' => 60,
            'scores' => ['hybrid' => $hybridScore, 'db' => $dbScore, 'ai' => $aiScore]
        ];
    }
}

/**
 * Combine responses from database and AI intelligently
 * 
 * @param string $dbResponse Database response
 * @param string $aiResponse AI response
 * @param string $intentType Intent type
 * @return string Combined response
 */
function combineResponses($dbResponse, $aiResponse, $intentType) {
    switch ($intentType) {
        case 'learning_method':
            // For learning methods, provide center info first, then AI guidance
            return "📚 **Thông tin từ Fighter Center:**\n\n" .
                   $dbResponse .
                   "\n\n" .
                   "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
                   "🤖 **Hướng dẫn từ AI Teacher:**\n\n" .
                   $aiResponse;
            
        case 'course_detail':
            // For course details, AI explains then show center options
            return $aiResponse .
                   "\n\n" .
                   "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
                   "🏢 **Khóa học tại Fighter:**\n\n" .
                   $dbResponse;
            
        default:
            // Default: Show both with clear separation
            return $dbResponse .
                   "\n\n" .
                   "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
                   $aiResponse;
    }
}

/**
 * Get default response when no specific answer is found
 * 
 * @param string|null $userName User's name
 * @return string Default response
 */
function getDefaultResponse($userName = null) {
    $greeting = $userName ? "👋 **Chào " . htmlspecialchars($userName) . "!**" : "👋 **Chào bạn!**";
    
    $responses = [
        $greeting . " Tôi là trợ lý AI của Fighter.\n\n" .
        "🎯 **Tôi có thể giúp bạn:**\n" .
        "• 📚 Tư vấn khóa học tiếng Anh\n" .
        "• 💰 Thông tin học phí và lịch học\n" .
        "• 🎓 Dạy ngữ pháp, từ vựng, phát âm\n" .
        "• 🗣️ Hướng dẫn giao tiếp tiếng Anh\n" .
        "• ✍️ Giải đáp bài tập và thắc mắc\n" .
        "• 📞 Thông tin liên hệ và đăng ký\n\n" .
        "💬 **Hãy hỏi tôi bất cứ điều gì về tiếng Anh!**",
        
        "🤔 **Tôi chưa hiểu rõ câu hỏi của bạn.**\n\n" .
        "📝 **Bạn có thể hỏi:**\n" .
        "• 'Có khóa học nào phù hợp cho người mới?'\n" .
        "• 'How to improve English speaking skills?'\n" .
        "• 'Học phí các khóa bao nhiêu?'\n" .
        "• 'What's the difference between A and B?'\n" .
        "• 'Lịch học có linh hoạt không?'\n\n" .
        "✨ **Hoặc click các gợi ý bên dưới để bắt đầu!**",
        
        "😊 **Rất vui được hỗ trợ bạn!**\n\n" .
        "🎓 **Về tiếng Anh, tôi có thể:**\n" .
        "• Giải thích ngữ pháp chi tiết\n" .
        "• Dạy từ vựng và cách sử dụng\n" .
        "• Hướng dẫn phát âm chuẩn\n" .
        "• Dịch thuật và giải nghĩa\n" .
        "• Tips học tập hiệu quả\n\n" .
        "🏢 **Về Fighter Center:**\n" .
        "• Thông tin các khóa học\n" .
        "• Học phí và ưu đãi\n" .
        "• Lịch học và đăng ký\n\n" .
        "💡 **Hãy hỏi tôi điều bạn muốn biết!**"
    ];
    
    return $responses[array_rand($responses)];
}

/**
 * Generate smart suggestions based on context
 * 
 * @param string $message User message
 * @param string $chatType Type of chat response
 * @param string $intentType Intent type
 * @return array Array of suggestions
 */
function getSuggestions($message, $chatType, $intentType) {
    // Suggestion pools organized by context
    $allSuggestions = [
        'ai_teaching' => [
            'How do you say "cảm ơn" in English?',
            'Explain present perfect tense',
            'Difference between "in", "on", "at"',
            'Common English phrases for beginners',
            'How to improve pronunciation?',
            'Tips for learning vocabulary',
            'What does "awesome" mean?',
            'How to use "would" and "could"?'
        ],
        'database_advice' => [
            'Tư vấn khóa học phù hợp',
            'Học phí các khóa học',
            'Lịch học có linh hoạt không?',
            'Đăng ký học thử miễn phí',
            'Thông tin liên hệ',
            'Ưu đãi cho học viên mới',
            'Địa chỉ trung tâm',
            'Khóa học cho người mới bắt đầu'
        ],
        'hybrid' => [
            'How to learn English effectively?',
            'Phương pháp học tiếng Anh tại Fighter',
            'Tips cải thiện 4 kỹ năng',
            'Lộ trình học cho người mới',
            'Best way to practice speaking',
            'Khóa học nào phù hợp với tôi?',
            'How long to become fluent?',
            'Tài liệu học tiếng Anh hay'
        ],
        'quick_answer' => [
            'How to improve speaking?',
            'Explain past simple tense',
            'Học phí bao nhiêu?',
            'Common mistakes in English',
            'Lịch học như thế nào?',
            'Grammar rules for beginners',
            'Đăng ký học online',
            'Pronunciation tips'
        ],
        'general' => [
            'Tư vấn khóa học',
            'Learn English grammar',
            'Học phí các khóa',
            'How to pronounce correctly?',
            'Lịch học linh hoạt',
            'English vocabulary tips',
            'Đăng ký học thử',
            'Improve listening skills'
        ]
    ];
    
    // Context-aware suggestion selection
    $suggestions = $allSuggestions[$chatType] ?? $allSuggestions['general'];
    
    // Filter out similar suggestions to current message
    $messageLower = strtolower($message);
    $suggestions = array_filter($suggestions, function($suggestion) use ($messageLower) {
        $suggestionLower = strtolower($suggestion);
        // Don't suggest if too similar to current message
        similar_text($messageLower, $suggestionLower, $percent);
        return $percent < 70;
    });
    
    // Randomize and return 3 suggestions
    shuffle($suggestions);
    $selectedSuggestions = array_slice($suggestions, 0, 3);
    
    // Ensure we always have 3 suggestions
    while (count($selectedSuggestions) < 3) {
        $fallbackSuggestions = [
            'How can I help you?',
            'Có gì tôi có thể giúp?',
            'Ask me anything!'
        ];
        $selectedSuggestions[] = $fallbackSuggestions[count($selectedSuggestions)];
    }
    
    return array_values($selectedSuggestions);
}

/**
 * Log chat message to database
 * 
 * @param int $userId User ID
 * @param string $message User message
 * @param string $response Bot response
 * @param string $type Chat type
 * @return bool Success status
 */
function logChatMessage($userId, $message, $response, $type = 'general') {
    global $conn;
    
    if (!$conn) {
        return false;
    }
    
    try {
        // Ensure table exists
        createChatHistoryTable();
        
        // Truncate long messages for storage
        $message = mb_substr($message, 0, 1000);
        $response = mb_substr($response, 0, 5000);
        
        $sql = "INSERT INTO chat_history 
                (id_hocvien, user_message, bot_response, chat_type, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Prepare log statement failed: " . $conn->error);
            return false;
        }
        
        $stmt->bind_param("isss", $userId, $message, $response, $type);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
        
    } catch (Exception $e) {
        error_log("logChatMessage error: " . $e->getMessage());
        return false;
    }
}

/**
 * Create chat history table if not exists
 * 
 * @return bool Success status
 */
function createChatHistoryTable() {
    global $conn;
    
    if (!$conn) {
        return false;
    }
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS chat_history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_hocvien INT DEFAULT 0,
            user_message TEXT NOT NULL,
            bot_response TEXT NOT NULL,
            chat_type VARCHAR(50) DEFAULT 'general',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_hocvien (id_hocvien),
            INDEX idx_created_at (created_at),
            INDEX idx_chat_type (chat_type)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $result = $conn->query($sql);
        
        if (!$result) {
            error_log("Create chat_history table failed: " . $conn->error);
        }
        
        return $result;
        
    } catch (Exception $e) {
        error_log("createChatHistoryTable error: " . $e->getMessage());
        return false;
    }
}

// End of file
?>
