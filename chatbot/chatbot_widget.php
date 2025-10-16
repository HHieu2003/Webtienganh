<?php
// chatbot/chatbot_widget.php - Optimized Widget
$chatbot_userName = null;
$chatbot_userId = 0;

if (isset($_SESSION['id_hocvien']) && !empty($_SESSION['id_hocvien'])) {
    $chatbot_userId = $_SESSION['id_hocvien'];
    
    if (isset($conn) && $conn) {
        $sql = "SELECT ten_hocvien FROM hocvien WHERE id_hocvien = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $chatbot_userId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $userRow = $result->fetch_assoc();
                $chatbot_userName = $userRow['ten_hocvien'];
            }
            $stmt->close();
        }
    }
}

if (!defined('CHATBOT_MAX_LENGTH')) {
    define('CHATBOT_MAX_LENGTH', 1000);
}
?>

<!-- Fullscreen Overlay -->
<div class="chatbot-fullscreen-overlay" id="chatbotFullscreenOverlay"></div>

<!-- Chatbot Container -->
<div class="chatbot-container" id="chatbotContainer">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="chatbot-info">
            <h3>Fighter AI</h3>
            <div class="chatbot-status">
                <span class="chatbot-status-dot"></span>
                <span>Đang online</span>
            </div>
        </div>
        <div class="chatbot-actions">
            <button class="chatbot-header-btn" id="chatbotFullscreenBtn" title="Phóng to">
                <i class="fas fa-expand"></i>
            </button>
            <button class="chatbot-header-btn" id="chatbotMinimizeBtn" title="Thu nhỏ">
                <i class="fas fa-minus"></i>
            </button>
            <button class="chatbot-header-btn" id="chatbotCloseBtn" title="Đóng">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    
    <!-- Compact Welcome Bar (Collapsible) -->
    <div class="chatbot-welcome-bar" id="chatbotWelcomeBar">
        <div class="chatbot-welcome-message">
            <span class="chatbot-wave">👋</span>
            <div class="chatbot-welcome-text">
                <strong>Xin chào<?php echo $chatbot_userName ? ', ' . htmlspecialchars($chatbot_userName) : ''; ?>!</strong>
                <span>Tôi có thể giúp gì cho bạn?</span>
            </div>
        </div>
        <button class="chatbot-toggle-welcome" id="chatbotToggleWelcome" title="Thu gọn">
            <i class="fas fa-chevron-up"></i>
        </button>
    </div>
    
    <!-- Quick Actions (Collapsible) -->
    <div class="chatbot-quick-actions" id="chatbotQuickActions">
        <button class="chatbot-action-btn" data-message="Tư vấn khóa học phù hợp cho tôi">
            <i class="fas fa-graduation-cap"></i>
            <span>Tư vấn khóa học</span>
        </button>
        <button class="chatbot-action-btn" data-message="How to learn English effectively?">
            <i class="fas fa-language"></i>
            <span>Dạy tiếng Anh</span>
        </button>
        <button class="chatbot-action-btn" data-message="Học phí các khóa học">
            <i class="fas fa-money-bill-wave"></i>
            <span>Học phí</span>
        </button>
        <button class="chatbot-action-btn" data-message="Thông tin liên hệ">
            <i class="fas fa-phone-alt"></i>
            <span>Liên hệ</span>
        </button>
    </div>
    
    <!-- Chat Messages -->
    <div class="chatbot-messages" id="chatbotMessages">
        <!-- Messages will be added here dynamically -->
    </div>
    
    <!-- Typing Indicator -->
    <div class="chatbot-typing-indicator chatbot-hidden" id="chatbotTypingIndicator">
        <div class="chatbot-message chatbot-bot">
            <div class="chatbot-message-bubble">
                <div class="chatbot-message-content">
                    <div class="chatbot-loading-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="chatbot-typing-text">Đang trả lời...</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Suggestions -->
    <div class="chatbot-quick-suggestions" id="chatbotQuickSuggestions">
        <div class="chatbot-suggestion-item" data-message="Khóa học cho người mới">
            📚 Khóa học mới
        </div>
        <div class="chatbot-suggestion-item" data-message="How to improve pronunciation?">
            🗣️ Phát âm
        </div>
        <div class="chatbot-suggestion-item" data-message="Học phí bao nhiêu?">
            💰 Học phí
        </div>
    </div>
    
    <!-- Chat Input -->
    <div class="chatbot-input-container">
        <textarea 
            id="chatbotInput" 
            class="chatbot-textarea"
            placeholder="Nhập tin nhắn..." 
            maxlength="<?php echo CHATBOT_MAX_LENGTH; ?>"
            rows="1"
        ></textarea>
        <div class="chatbot-input-actions">
            <span class="chatbot-char-counter">
                <span id="chatbotCharCount">0</span>/<span><?php echo CHATBOT_MAX_LENGTH; ?></span>
            </span>
            <button class="chatbot-send-button" id="chatbotSendButton" disabled>
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
    
    
</div>

<!-- Float Button -->
<button class="chatbot-float-button" id="chatbotFloatButton">
    <i class="fas fa-comments"></i>
    <span class="chatbot-notification-badge">AI</span>
</button>

<script>
    const CHATBOT_CONFIG = {
        userId: <?php echo $chatbot_userId; ?>,
        userName: <?php echo $chatbot_userName ? '"' . addslashes($chatbot_userName) . '"' : 'null'; ?>,
        apiUrl: './chatbot/chat_handler.php',
        maxMessageLength: <?php echo CHATBOT_MAX_LENGTH; ?>
    };
</script>
