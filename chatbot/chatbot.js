

class FighterChatbot {
    constructor(config = {}) {
        // Configuration
        this.config = {
            userId: 0,
            userName: null,
            apiUrl: './chatbot/chatbot_handler.php',
            maxMessageLength: 1000,
            autoScroll: true,
            typingDelay: 800,
            retryAttempts: 2,
            ...config
        };

        // State
        this.isTyping = false;
        this.isMinimized = true;
        this.isSending = false;
        this.messageQueue = [];
        this.historyLoaded = false;

        // Statistics
        this.stats = {
            messagesSent: 0,
            messagesReceived: 0,
            errors: 0
        };

        console.log('🤖 Initializing FighterChatbot v2.0...', this.config);
        this.init();
    }

    // ============================================================================
    // INITIALIZATION
    // ============================================================================

 init() {
    try {
        this.initElements();
        this.bindEvents();
        this.setupAutoResize();
        
        // ✅ THÊM ĐOẠN NÀY: Load lịch sử ngay khi trang load
        if (this.config.userId > 0) {
            this.loadChatHistory();
            this.loadQuickActions();
            this.historyLoaded = true;
        }
        
        console.log('✅ Chatbot initialized successfully');
    } catch (error) {
        console.error('❌ Chatbot initialization error:', error);
        this.showError('Không thể khởi tạo chatbot. Vui lòng tải lại trang.');
    }
}


    initElements() {
        // Main containers
        this.container = document.getElementById('chatbotContainer');
        this.floatButton = document.getElementById('chatbotFloatButton');

        // Chat elements
        this.chatMessages = document.getElementById('chatbotMessages');
        this.chatInput = document.getElementById('chatbotInput');
        this.sendButton = document.getElementById('chatbotSendButton');

        // Additional elements
        this.quickActions = document.getElementById('chatbotQuickActions');
        this.welcomeBar = document.getElementById('chatbotWelcomeBar');
        this.typingIndicator = document.getElementById('chatbotTypingIndicator');
        this.charCount = document.getElementById('chatbotCharCount');

        // Buttons
        this.minimizeBtn = document.getElementById('chatbotMinimizeBtn');

        // Validate required elements
        if (!this.container || !this.chatMessages || !this.chatInput) {
            throw new Error('Required DOM elements not found');
        }
    }

    bindEvents() {
        // Float button - Toggle chatbot
        if (this.floatButton) {
            this.floatButton.addEventListener('click', () => this.toggleChatbot());
        }

        // Minimize button
        if (this.minimizeBtn) {
            this.minimizeBtn.addEventListener('click', () => this.toggleChatbot());
        }

        // Send button
        if (this.sendButton) {
            this.sendButton.addEventListener('click', () => this.sendMessage());
        }

        // Input events
        if (this.chatInput) {
            // Enter to send
            this.chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });

            // Character count
            this.chatInput.addEventListener('input', () => {
                this.updateCharCount();
                this.adjustTextareaHeight();
            });

            // Focus event
            this.chatInput.addEventListener('focus', () => {
                this.scrollToBottom();
            });
        }

        // Click outside to close (optional)
        document.addEventListener('click', (e) => {
            if (!this.isMinimized &&
                !this.container.contains(e.target) &&
                !this.floatButton.contains(e.target)) {
                // Uncomment to enable click-outside-to-close
                // this.toggleChatbot();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // ESC to close chatbot
            if (e.key === 'Escape' && !this.isMinimized) {
                this.toggleChatbot();
            }
        });
        // Expand button
        const expandBtn = document.getElementById('chatbotExpandBtn');
        if (expandBtn) {
            expandBtn.addEventListener('click', () => this.toggleExpand());
        }

        // Welcome close button
        const welcomeCloseBtn = document.getElementById('chatbotWelcomeCloseBtn');
        if (welcomeCloseBtn) {
            welcomeCloseBtn.addEventListener('click', () => this.hideWelcomeBar());
        }

        // Quick actions toggle
        const quickActionsHeader = document.querySelector('.chatbot-quick-actions-header');
        const quickActionsToggle = document.getElementById('chatbotQuickActionsToggle');
        if (quickActionsHeader && quickActionsToggle) {
            quickActionsHeader.addEventListener('click', () => this.toggleQuickActions());
        }

        // Thêm vào bindEvents()
        const clearContextBtn = document.getElementById('chatbotClearContextBtn');
        if (clearContextBtn) {
            clearContextBtn.addEventListener('click', () => this.clearContext());
        }
    }
    async clearContext() {
        if (!confirm('Bạn có chắc muốn xóa lịch sử hội thoại? Chatbot sẽ không còn nhớ các câu hỏi trước đó.')) {
            return;
        }

        try {
            const response = await fetch(`${this.config.apiUrl}?action=clear_context`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    userId: this.config.userId
                })
            });

            const data = await response.json();

            if (data.success) {
                // XÓA TIN NHẮN HIỂN THỊ TRÊN GIAO DIỆN
                this.chatMessages.innerHTML = '';

                // Hiển thị lại welcome message
                this.showWelcomeMessage();

                this.showNotification('✅ Đã xóa lịch sử hội thoại', 'success');
                console.log('🗑️ Context cleared');
            } else {
                this.showNotification('❌ Không thể xóa lịch sử: ' + (data.error || 'Unknown error'), 'error');
            }
        } catch (error) {
            console.error('Clear context error:', error);
            this.showNotification('❌ Không thể xóa lịch sử', 'error');
        }
    }

    // Cập nhật showNotification để hiển thị toast
    showNotification(message, type = 'info') {
        console.log(`📢 [${type.toUpperCase()}] ${message}`);

        // Create toast notification
        const toast = document.createElement('div');
        toast.className = `chatbot-toast chatbot-toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
        position: fixed;
        bottom: 100px;
        right: 30px;
        padding: 12px 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }


    // Thêm các phương thức mới
    toggleExpand() {
        const expandBtn = document.getElementById('chatbotExpandBtn');
        const isExpanded = this.container.classList.toggle('chatbot-expanded');

        if (expandBtn) {
            const icon = expandBtn.querySelector('i');
            if (icon) {
                icon.className = isExpanded ? 'fas fa-compress' : 'fas fa-expand';
            }
            expandBtn.title = isExpanded ? 'Thu nhỏ' : 'Mở rộng';
        }

        this.scrollToBottom();
        console.log(isExpanded ? '🔲 Expanded mode' : '🔳 Normal mode');
    }

    hideWelcomeBar() {
        const welcomeBar = document.getElementById('chatbotWelcomeBar');
        if (welcomeBar) {
            welcomeBar.classList.add('chatbot-hidden');

            // Save to localStorage
            try {
                localStorage.setItem('chatbot_welcome_dismissed', 'true');
            } catch (e) {
                console.warn('Cannot save to localStorage:', e);
            }
        }
    }

    toggleQuickActions() {
        const container = document.getElementById('chatbotQuickActionsContainer');
        if (container) {
            container.classList.toggle('collapsed');

            // Save state to localStorage
            const isCollapsed = container.classList.contains('collapsed');
            try {
                localStorage.setItem('chatbot_quick_actions_collapsed', isCollapsed.toString());
            } catch (e) {
                console.warn('Cannot save to localStorage:', e);
            }
        }
    }

    // Cập nhật showChatbot() để restore states
    async showChatbot() {
        this.container.style.display = 'flex';
        this.container.classList.remove('chatbot-minimized');
        this.isMinimized = false;

        if (this.floatButton) {
            this.floatButton.classList.add('chatbot-hidden');
        }

        if (!this.historyLoaded) {
            await this.loadInitialData();
            this.historyLoaded = true;

            // Restore welcome bar state
            try {
                const welcomeDismissed = localStorage.getItem('chatbot_welcome_dismissed');
                if (welcomeDismissed === 'true') {
                    this.hideWelcomeBar();
                }
            } catch (e) { }

            // Restore quick actions state
            try {
                const quickActionsCollapsed = localStorage.getItem('chatbot_quick_actions_collapsed');
                const container = document.getElementById('chatbotQuickActionsContainer');
                if (quickActionsCollapsed === 'true' && container) {
                    container.classList.add('collapsed');
                }
            } catch (e) { }
        }

        setTimeout(() => {
            if (this.chatInput) {
                this.chatInput.focus();
            }
        }, 300);

        this.scrollToBottom();
        console.log('📖 Chatbot opened');
    }


    setupAutoResize() {
        if (!this.chatInput) return;

        // Reset height calculation
        this.chatInput.style.height = 'auto';
        this.chatInput.style.minHeight = '40px';
        this.chatInput.style.maxHeight = '120px';
    }

    // ============================================================================
    // CHATBOT VISIBILITY
    // ============================================================================

    toggleChatbot() {
        if (this.isMinimized) {
            this.showChatbot();
        } else {
            this.hideChatbot();
        }
    }

    async showChatbot() {
        // Show container
        this.container.style.display = 'flex';
        this.container.classList.remove('chatbot-minimized');
        this.isMinimized = false;

        // Update float button
        if (this.floatButton) {
            this.floatButton.classList.add('chatbot-hidden');
        }

        // Load data on first open
        if (!this.historyLoaded) {
            await this.loadInitialData();
            this.historyLoaded = true;
        }

        // Focus input
        setTimeout(() => {
            if (this.chatInput) {
                this.chatInput.focus();
            }
        }, 300);

        // Scroll to bottom
        this.scrollToBottom();

        console.log('📖 Chatbot opened');
    }

    hideChatbot() {
        // Hide container
        this.container.classList.add('chatbot-minimized');
        this.isMinimized = true;

        // Update float button
        if (this.floatButton) {
            this.floatButton.classList.remove('chatbot-hidden');
        }

        // Slight delay before hiding completely
        setTimeout(() => {
            if (this.isMinimized) {
                this.container.style.display = 'none';
            }
        }, 300);

        console.log('📕 Chatbot closed');
    }

    // ============================================================================
    // DATA LOADING
    // ============================================================================

   async loadInitialData() {
    try {
        // Load in parallel
        await Promise.all([
            this.loadChatHistory(),
            this.loadQuickActions()
        ]);
        
        // ✅ CHỈ hiển thị welcome message nếu KHÔNG CÓ lịch sử
        if (this.chatMessages.children.length === 0) {
            this.showWelcomeMessage();
        }
    } catch (error) {
        console.error('Load initial data error:', error);
    }
}


    async loadChatHistory() {
        // Only for logged-in users
        if (this.config.userId === 0) {
            console.log('👤 Guest mode - no history to load');
            return;
        }

        try {
            const url = `${this.config.apiUrl}?action=history&userId=${this.config.userId}&limit=20`;
            const response = await fetch(url);
            const data = await response.json();

            if (data.success && data.history && data.history.length > 0) {
                // Clear existing messages
                this.chatMessages.innerHTML = '';

                // Add history messages
                data.history.forEach(msg => {
                    this.addMessage(msg.content, msg.sender, false);
                });

                console.log(`📚 Loaded ${data.history.length} messages from history`);
            }
        } catch (error) {
            console.error('❌ Load history error:', error);
        }
    }

    async loadQuickActions() {
        if (!this.quickActions) return;

        try {
            const url = `${this.config.apiUrl}?action=quick_actions`;
            const response = await fetch(url);
            const data = await response.json();

            if (data.success && data.actions) {
                this.renderQuickActions(data.actions);
                console.log(`⚡ Loaded ${data.actions.length} quick actions`);
            }
        } catch (error) {
            console.error('❌ Load quick actions error:', error);
        }
    }

    renderQuickActions(actions) {
        if (!this.quickActions) return;

        this.quickActions.innerHTML = '';

        actions.forEach(action => {
            const btn = document.createElement('button');
            btn.className = 'chatbot-action-btn';
            btn.innerHTML = `
                <i class="${action.icon}"></i>
                <span>${this.escapeHtml(action.label)}</span>
            `;
            btn.onclick = () => this.handleQuickAction(action.message);
            btn.title = action.message;

            this.quickActions.appendChild(btn);
        });
    }

    handleQuickAction(message) {
        if (this.chatInput) {
            this.chatInput.value = message;
            this.updateCharCount();
            this.chatInput.focus();

            // Auto-send after short delay
            setTimeout(() => {
                this.sendMessage();
            }, 300);
        }
    }

    showWelcomeMessage() {
        const welcomeText = this.config.userName
            ? `👋 Xin chào **${this.config.userName}**! Tôi là trợ lý AI của Fighter English Center.`
            : '👋 Xin chào! Tôi là trợ lý AI của Fighter English Center.';

        const message = `${welcomeText}

Tôi có thể giúp bạn:

📚 **Học tiếng Anh** - Giải đáp ngữ pháp, từ vựng, phát âm
🎓 **Tư vấn khóa học** - Thông tin về các khóa học, học phí, lịch học
👨‍🏫 **Thông tin giảng viên** - Đội ngũ giảng viên chuyên nghiệp
📞 **Liên hệ** - Thông tin liên hệ trung tâm

Hãy hỏi tôi bất cứ điều gì! 😊`;

        this.addMessage(message, 'bot');
    }

    // ============================================================================
    // MESSAGE HANDLING
    // ============================================================================

    async sendMessage() {
        // Prevent multiple sends
        if (this.isSending || this.isTyping) {
            console.log('⏳ Already sending or bot is typing');
            return;
        }

        // Get message
        const message = this.chatInput.value.trim();

        // Validate
        if (!message) {
            this.chatInput.focus();
            return;
        }

        if (message.length > this.config.maxMessageLength) {
            this.showNotification(
                `Tin nhắn quá dài! Tối đa ${this.config.maxMessageLength} ký tự.`,
                'error'
            );
            return;
        }

        // Lock sending
        this.isSending = true;
        this.disableInput();

        // Clear input
        this.chatInput.value = '';
        this.updateCharCount();
        this.adjustTextareaHeight();

        // Add user message
        this.addMessage(message, 'user');
        this.stats.messagesSent++;

        // Show typing indicator
        this.showTyping();

        try {
            // Send to API
            const response = await this.sendToAPI(message);

            // Hide typing
            this.hideTyping();

            if (response.success) {
                // Add bot response
                this.addMessage(response.response, 'bot');
                this.stats.messagesReceived++;

                // Log intent for debugging
                if (response.intent) {
                    console.log(`🎯 Detected intent: ${response.intent}`);
                }
            } else {
                // Error from API
                this.addMessage(
                    '❌ Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.',
                    'bot'
                );
                this.stats.errors++;
            }
        } catch (error) {
            console.error('❌ Send message error:', error);
            this.hideTyping();

            this.addMessage(
                '❌ Không thể kết nối đến máy chủ. Vui lòng kiểm tra kết nối mạng và thử lại.',
                'bot'
            );
            this.stats.errors++;
        } finally {
            // Unlock sending
            this.isSending = false;
            this.enableInput();
            this.chatInput.focus();
        }
    }

    async sendToAPI(message, retryCount = 0) {
        const url = `${this.config.apiUrl}?action=chat`;

        const payload = {
            message: message,
            userId: this.config.userId
        };

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();
            return data;

        } catch (error) {
            // Retry logic
            if (retryCount < this.config.retryAttempts) {
                console.log(`🔄 Retrying... (${retryCount + 1}/${this.config.retryAttempts})`);
                await this.sleep(1000);
                return this.sendToAPI(message, retryCount + 1);
            }

            throw error;
        }
    }

    addMessage(content, sender, scroll = true) {
        if (!content || !sender) return;

        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message chatbot-${sender}`;

        // Get timestamp
        const time = new Date().toLocaleTimeString('vi-VN', {
            hour: '2-digit',
            minute: '2-digit'
        });

        // Format content
        const formattedContent = this.formatMessage(content);

        // Build HTML
        messageDiv.innerHTML = `
            <div class="chatbot-message-bubble">
                <div class="chatbot-message-content">${formattedContent}</div>
                <div class="chatbot-message-time">${time}</div>
            </div>
        `;

        // Add to chat
        this.chatMessages.appendChild(messageDiv);

        // Animate
        requestAnimationFrame(() => {
            messageDiv.style.opacity = '1';
            messageDiv.style.transform = 'translateY(0)';
        });

        // Scroll
        if (scroll && this.config.autoScroll) {
            this.scrollToBottom();
        }
    }

    formatMessage(text) {
        if (!text) return '';

        // Escape HTML first
        text = this.escapeHtml(text);

        // Convert markdown-style formatting
        // Bold: **text**
        text = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');

        // Italic: *text*
        text = text.replace(/\*(.+?)\*/g, '<em>$1</em>');

        // Code: `code`
        text = text.replace(/`(.+?)`/g, '<code>$1</code>');

        // Links: [text](url)
        text = text.replace(/\[(.+?)\]\((.+?)\)/g, '<a href="$2" target="_blank">$1</a>');

        // Line breaks
        text = text.replace(/\n/g, '<br>');

        // Lists (simple)
        text = text.replace(/^- (.+)$/gm, '<li>$1</li>');
        if (text.includes('<li>')) {
            text = text.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
        }

        return text;
    }

    // ============================================================================
    // UI CONTROLS
    // ============================================================================

    showTyping() {
        this.isTyping = true;

        if (this.typingIndicator) {
            this.typingIndicator.classList.remove('chatbot-hidden');
        }

        this.scrollToBottom();
    }

    hideTyping() {
        this.isTyping = false;

        if (this.typingIndicator) {
            this.typingIndicator.classList.add('chatbot-hidden');
        }
    }

    disableInput() {
        if (this.chatInput) {
            this.chatInput.disabled = true;
            this.chatInput.placeholder = 'Đang xử lý...';
        }
        if (this.sendButton) {
            this.sendButton.disabled = true;
        }
    }

    enableInput() {
        if (this.chatInput) {
            this.chatInput.disabled = false;
            this.chatInput.placeholder = 'Nhập câu hỏi của bạn...';
        }
        if (this.sendButton) {
            this.sendButton.disabled = false;
        }
    }

    updateCharCount() {
        if (!this.charCount || !this.chatInput) return;

        const length = this.chatInput.value.length;
        const max = this.config.maxMessageLength;

        this.charCount.textContent = `${length}/${max}`;

        // Color coding
        if (length > max) {
            this.charCount.style.color = '#ef4444'; // Red
        } else if (length > max * 0.9) {
            this.charCount.style.color = '#f59e0b'; // Orange
        } else {
            this.charCount.style.color = '#9ca3af'; // Gray
        }
    }

    adjustTextareaHeight() {
        if (!this.chatInput) return;

        // Reset height to calculate new height
        this.chatInput.style.height = 'auto';

        // Set new height based on content
        const newHeight = Math.min(this.chatInput.scrollHeight, 120);
        this.chatInput.style.height = newHeight + 'px';
    }

    scrollToBottom(smooth = true) {
        if (!this.chatMessages) return;

        if (smooth) {
            this.chatMessages.scrollTo({
                top: this.chatMessages.scrollHeight,
                behavior: 'smooth'
            });
        } else {
            this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
        }
    }

    showNotification(message, type = 'info') {
        // Simple notification (can be enhanced with a toast library)
        console.log(`📢 [${type.toUpperCase()}] ${message}`);

        // You can implement a toast notification here
        if (type === 'error') {
            alert(message);
        }
    }

    showError(message) {
        this.addMessage(`❌ ${message}`, 'bot');
    }

    // ============================================================================
    // UTILITY METHODS
    // ============================================================================

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // ============================================================================
    // PUBLIC API
    // ============================================================================

    /**
     * Send a message programmatically
     * @param {string} message - The message to send
     */
    send(message) {
        if (this.chatInput) {
            this.chatInput.value = message;
            this.sendMessage();
        }
    }

    /**
     * Open the chatbot
     */
    open() {
        if (this.isMinimized) {
            this.showChatbot();
        }
    }

    /**
     * Close the chatbot
     */
    close() {
        if (!this.isMinimized) {
            this.hideChatbot();
        }
    }

    /**
     * Clear chat history (UI only)
     */
    clearChat() {
        if (this.chatMessages) {
            this.chatMessages.innerHTML = '';
            this.showWelcomeMessage();
        }
    }

    /**
     * Get statistics
     */
    getStats() {
        return {
            ...this.stats,
            isOpen: !this.isMinimized,
            isTyping: this.isTyping,
            messageCount: this.chatMessages ? this.chatMessages.children.length : 0
        };
    }

    /**
     * Destroy chatbot instance
     */
    destroy() {
        // Remove event listeners
        // Clean up DOM
        console.log('🗑️ Chatbot destroyed');
    }
}

// ============================================================================
// AUTO-INITIALIZATION
// ============================================================================

document.addEventListener('DOMContentLoaded', function () {
    try {
        // Get user info from PHP variables
        const userId = typeof chatbotUserId !== 'undefined' ? chatbotUserId : 0;
        const userName = typeof chatbotUserName !== 'undefined' ? chatbotUserName : null;

        // Initialize chatbot
        window.fighterChatbot = new FighterChatbot({
            userId: userId,
            userName: userName
        });

        console.log('🚀 Fighter Chatbot is ready!');
        console.log('📊 User ID:', userId);
        console.log('👤 User Name:', userName || 'Guest');

    } catch (error) {
        console.error('❌ Failed to initialize chatbot:', error);
    }
});

// ============================================================================
// GLOBAL HELPER FUNCTIONS (Optional)
// ============================================================================

/**
 * Quick access to send message
 */
window.chatbotSend = function (message) {
    if (window.fighterChatbot) {
        window.fighterChatbot.send(message);
    }
};

/**
 * Quick access to open chatbot
 */
window.chatbotOpen = function () {
    if (window.fighterChatbot) {
        window.fighterChatbot.open();
    }
};

/**
 * Quick access to close chatbot
 */
window.chatbotClose = function () {
    if (window.fighterChatbot) {
        window.fighterChatbot.close();
    }
};

// ============================================================================
// END OF FILE
// ============================================================================
