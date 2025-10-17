<?php
// Đảm bảo session được start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ THÊM LOG ĐỂ DEBUG
error_log("🔍 Session ID: " . session_id());
error_log("🔍 Session data: " . print_r($_SESSION, true));

// Get user info from session
$chatbot_userId = 0;
$chatbot_userName = 'Guest';

if (isset($_SESSION['id_hocvien']) && $_SESSION['id_hocvien'] > 0) {
    $chatbot_userId = intval($_SESSION['id_hocvien']);
    $chatbot_userName = $_SESSION['ten_hocvien'] ?? 'User';
    
    // ✅ THÊM LOG
    error_log("✅ User logged in - ID: {$chatbot_userId}, Name: {$chatbot_userName}");
} else {
    error_log("⚠️ No user logged in - Guest mode");
}

// Alternatively, get from database if needed
if ($chatbot_userId > 0 && isset($conn)) {
    $sql = "SELECT ten_hocvien FROM hocvien WHERE id_hocvien = ?";
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
?>

<!-- Chatbot Float Button -->
<button id="chatbotFloatButton" class="chatbot-float-button" title="Chat với AI Fighter" aria-label="Open Chatbot">
    <i class="fas fa-comments"></i>
    <span class="chatbot-pulse-ring"></span>
</button>

<!-- Chatbot Container -->
<div id="chatbotContainer" class="chatbot-container chatbot-minimized">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-avatar">
            <i class="fas fa-robot"></i>
            <span class="chatbot-status-dot"></span>
        </div>
        <div class="chatbot-info">
            <h3>Fighter AI Assistant</h3>
            <div class="chatbot-status">
                <span class="chatbot-status-indicator"></span>
                <span>Đang hoạt động</span>
            </div>
        </div>
        <!-- Thêm vào chatbot-header-actions -->
        <div class="chatbot-header-actions">
            <!-- Clear Context Button -->
            <button id="chatbotClearContextBtn" class="chatbot-header-btn" title="Xóa lịch sử hội thoại" aria-label="Clear Context">
                <i class="fas fa-trash-alt"></i>
            </button>
            <!-- Expand/Collapse Button -->
            <button id="chatbotExpandBtn" class="chatbot-header-btn" title="Mở rộng" aria-label="Expand">
                <i class="fas fa-expand"></i>
            </button>
            <!-- Close Button -->
            <button id="chatbotMinimizeBtn" class="chatbot-header-btn" title="Đóng" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>

    </div>

    <!-- Quick Actions (Collapsible) -->
    <div id="chatbotQuickActionsContainer" class="chatbot-quick-actions-container">
        <div class="chatbot-quick-actions-header">
            <span class="chatbot-quick-actions-title">
                <i class="fas fa-bolt"></i> Gợi ý nhanh
            </span>
            <button id="chatbotQuickActionsToggle" class="chatbot-toggle-btn" title="Thu gọn" aria-label="Toggle Quick Actions">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
        <div id="chatbotQuickActions" class="chatbot-quick-actions">
            <!-- Quick actions will be loaded here by JS -->
        </div>
    </div>

    <!-- Messages Area -->
    <div id="chatbotMessages" class="chatbot-messages">
        <!-- Messages will appear here -->
    </div>

    <!-- Typing Indicator -->
    <div id="chatbotTypingIndicator" class="chatbot-typing-indicator chatbot-hidden">
        <div class="chatbot-typing-bubble">
            <div class="chatbot-loading-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="chatbot-typing-text">Đang suy nghĩ...</span>
        </div>
    </div>

    <!-- Input Area -->
    <div class="chatbot-input-container">
        <div class="chatbot-input-wrapper">
            <textarea
                id="chatbotInput"
                class="chatbot-textarea"
                placeholder="Nhập câu hỏi của bạn... (Enter để gửi)"
                rows="1"
                maxlength="1000"></textarea>
            <div class="chatbot-input-actions ">
                <span id="chatbotCharCount" class="chatbot-char-counter">0/1000</span>
                <button id="chatbotSendButton" class="chatbot-send-button" title="Gửi tin nhắn" aria-label="Send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>


</div>

<!-- Pass PHP variables to JavaScript -->
<script>
    const chatbotUserId = <?php echo $chatbot_userId; ?>;
    const chatbotUserName = <?php echo json_encode($chatbot_userName, JSON_UNESCAPED_UNICODE); ?>;
</script>

<!-- Load Chatbot Assets -->
<link rel="stylesheet" href="./chatbot/chatbot.css">
<script src="./chatbot/chatbot.js"></script>