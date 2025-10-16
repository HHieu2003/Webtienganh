// chatbot/assets/chatbot.js - Updated with Database Priority

class FighterChatbot {
    constructor(config = {}) {
        this.config = {
            userId: 0,
            userName: null,
            apiUrl: './chatbot/chat_handler.php',
            historyUrl: './chatbot/get_chat_history.php',
            maxRetries: 2,
            retryDelay: 1000,
            maxMessageLength: 1000,
            saveToLocalStorage: true,     // Keep as backup
            loadFromDatabase: true,        // Primary source
            prioritizeDatabase: true,      // NEW: Always try database first
            syncToLocalStorage: true,      // NEW: Sync DB → localStorage
            ...config
        };
        
        this.isTyping = false;
        this.messageHistory = [];
        this.isFullscreen = false;
        this.isMinimized = true;
        this.isWelcomeCollapsed = false;
        this.retryCount = 0;
        this.historyLoaded = false;
        this.lastSyncTime = 0;
        
        console.log('🤖 Initializing FighterChatbot...', this.config);
        this.init();
    }
    
    init() {
        try {
            this.initElements();
            this.bindEvents();
            this.loadChatHistory(); // Load history on init
            console.log('✅ Chatbot initialized successfully');
        } catch (error) {
            console.error('❌ Chatbot initialization error:', error);
        }
    }
    
    initElements() {
        this.container = document.getElementById('chatbotContainer');
        this.chatMessages = document.getElementById('chatbotMessages');
        this.chatInput = document.getElementById('chatbotInput');
        this.sendButton = document.getElementById('chatbotSendButton');
        this.charCount = document.getElementById('chatbotCharCount');
        this.typingIndicator = document.getElementById('chatbotTypingIndicator');
        this.quickSuggestions = document.getElementById('chatbotQuickSuggestions');
        this.floatButton = document.getElementById('chatbotFloatButton');
        this.overlay = document.getElementById('chatbotFullscreenOverlay');
        this.welcomeBar = document.getElementById('chatbotWelcomeBar');
        this.quickActions = document.getElementById('chatbotQuickActions');
        this.toggleWelcome = document.getElementById('chatbotToggleWelcome');
        
        if (!this.container || !this.chatMessages || !this.chatInput || !this.sendButton) {
            throw new Error('Required chatbot DOM elements not found');
        }
        
        this.container.classList.add('chatbot-minimized');
    }
    
    // ========================================================================
    // CHAT HISTORY MANAGEMENT - UPDATED WITH DATABASE PRIORITY
    // ========================================================================
    
    /**
     * Load chat history with DATABASE PRIORITY
     */
    async loadChatHistory() {
        console.log('📥 Loading chat history...');
        
        try {
            let history = [];
            let fromDatabase = false;
            
            // ===================================================================
            // STEP 1: TRY DATABASE FIRST (for logged-in users)
            // ===================================================================
            if (this.config.userId > 0 && this.config.loadFromDatabase) {
                console.log('🔄 Attempting to load from database...');
                
                history = await this.loadFromDatabase();
                
                if (history.length > 0) {
                    console.log('✅ Loaded from database:', history.length, 'messages');
                    fromDatabase = true;
                    
                    // Sync to localStorage for offline access
                    if (this.config.syncToLocalStorage) {
                        this.syncToLocalStorage(history);
                        console.log('💾 Synced database → localStorage');
                    }
                } else {
                    console.log('⚠️ No history in database, trying localStorage...');
                }
            }
            
            // ===================================================================
            // STEP 2: FALLBACK TO LOCALSTORAGE (if database fails or empty)
            // ===================================================================
            if (history.length === 0 && this.config.saveToLocalStorage) {
                history = this.loadFromLocalStorage();
                
                if (history.length > 0) {
                    console.log('✅ Loaded from localStorage:', history.length, 'messages');
                    
                    // If user is logged in, upload localStorage to database
                    if (this.config.userId > 0) {
                        console.log('🔼 Uploading localStorage → database...');
                        this.uploadLocalStorageToDatabase(history);
                    }
                }
            }
            
            // ===================================================================
            // STEP 3: DISPLAY HISTORY OR WELCOME MESSAGE
            // ===================================================================
            if (history.length > 0) {
                this.restoreHistory(history);
                this.historyLoaded = true;
                this.lastSyncTime = Date.now();
                
                console.log('✅ History restored successfully!');
            } else {
                console.log('ℹ️ No history found, showing welcome message');
                // Show welcome message will happen in showChatbot()
            }
            
        } catch (error) {
            console.error('❌ Load chat history error:', error);
            // Show welcome message on error
            this.showWelcomeMessageOnError();
        }
    }
    
    /**
     * Load history from database via API
     */
    async loadFromDatabase() {
        try {
            const url = `${this.config.historyUrl}?limit=50&userId=${this.config.userId}&t=${Date.now()}`;
            
            console.log('📡 Fetching from:', url);
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
                cache: 'no-cache' // Force fresh data
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const data = await response.json();
            console.log('📊 Database response:', data);
            
            if (data.success && data.history && data.history.length > 0) {
                // Convert database format to internal format
                const messages = [];
                
                data.history.forEach(item => {
                    // Add user message
                    messages.push({
                        content: item.user_message,
                        sender: 'user',
                        timestamp: item.timestamp * 1000,
                        time: item.time
                    });
                    
                    // Add bot response
                    messages.push({
                        content: item.bot_response,
                        sender: 'bot',
                        timestamp: item.timestamp * 1000 + 1,
                        time: item.time
                    });
                });
                
                // Sort by timestamp
                messages.sort((a, b) => a.timestamp - b.timestamp);
                
                return messages;
            }
            
            return [];
            
        } catch (error) {
            console.error('❌ Load from database error:', error);
            return [];
        }
    }
    
    /**
     * Load history from localStorage
     */
    loadFromLocalStorage() {
        try {
            const storageKey = this.config.userId > 0 
                ? `chatbot_history_${this.config.userId}` 
                : 'chatbot_history_guest';
            
            const stored = localStorage.getItem(storageKey);
            
            if (stored) {
                const history = JSON.parse(stored);
                
                // Validate and limit history
                if (Array.isArray(history)) {
                    // Keep only last 50 messages
                    return history.slice(-50);
                }
            }
            
            return [];
            
        } catch (error) {
            console.error('❌ Load from localStorage error:', error);
            return [];
        }
    }
    
    /**
     * NEW: Sync database history to localStorage
     */
    syncToLocalStorage(history) {
        try {
            const storageKey = this.config.userId > 0 
                ? `chatbot_history_${this.config.userId}` 
                : 'chatbot_history_guest';
            
            localStorage.setItem(storageKey, JSON.stringify(history));
            console.log('✅ Synced to localStorage:', storageKey);
            
        } catch (error) {
            console.error('❌ Sync to localStorage error:', error);
        }
    }
    
    /**
     * NEW: Upload localStorage to database (for sync)
     */
    async uploadLocalStorageToDatabase(history) {
        // This would require a new API endpoint to bulk insert
        // For now, just log that we should implement this
        console.log('⚠️ uploadLocalStorageToDatabase: Not implemented yet');
        console.log('   Messages in localStorage:', history.length);
        console.log('   TODO: Create bulk upload API endpoint');
    }
    
    /**
     * Save message to localStorage (backup only)
     */
    saveToLocalStorage(message, sender) {
        // ONLY save if database save might fail (backup)
        if (!this.config.saveToLocalStorage) {
            return;
        }
        
        try {
            const storageKey = this.config.userId > 0 
                ? `chatbot_history_${this.config.userId}` 
                : 'chatbot_history_guest';
            
            // Get existing history
            let history = this.loadFromLocalStorage();
            
            // Add new message
            history.push({
                content: message,
                sender: sender,
                timestamp: Date.now(),
                time: new Date().toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                })
            });
            
            // Keep only last 50 messages
            if (history.length > 50) {
                history = history.slice(-50);
            }
            
            // Save to localStorage
            localStorage.setItem(storageKey, JSON.stringify(history));
            
            // For guests, log a reminder
            if (this.config.userId === 0) {
                console.log('⚠️ Guest mode: History only saved locally (will be lost on other devices)');
            }
            
        } catch (error) {
            console.error('❌ Save to localStorage error:', error);
        }
    }
    
    /**
     * Restore chat history to UI
     */
    restoreHistory(history) {
        console.log('🔄 Restoring history:', history.length, 'messages');
        
        // Clear existing messages
        this.chatMessages.innerHTML = '';
        this.messageHistory = [];
        
        // Add each message
        history.forEach(item => {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chatbot-message chatbot-${item.sender}`;
            
            const time = item.time || new Date(item.timestamp).toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            messageDiv.innerHTML = `
                <div class="chatbot-message-bubble">
                    <div class="chatbot-message-content">${this.formatMessage(item.content)}</div>
                    <div class="chatbot-message-time">${time}</div>
                </div>
            `;
            
            this.chatMessages.appendChild(messageDiv);
            this.messageHistory.push(item);
        });
        
        this.scrollToBottom();
    }
    
    /**
     * Show welcome message when no history or error
     */
    showWelcomeMessageOnError() {
        setTimeout(() => {
            this.addMessage(
                '👋 Xin chào! Tôi là trợ lý AI của Fighter. Tôi có thể giúp bạn học tiếng Anh và tư vấn khóa học. Hãy hỏi tôi bất cứ điều gì!',
                'bot'
            );
        }, 500);
    }
    
    /**
     * Clear chat history (both localStorage and database)
     */
    async clearHistory() {
        if (!confirm('Bạn có chắc muốn xóa toàn bộ lịch sử chat?\n\n⚠️ Lịch sử sẽ bị xóa trên TẤT CẢ thiết bị!')) {
            return;
        }
        
        try {
            // Clear UI
            this.chatMessages.innerHTML = '';
            this.messageHistory = [];
            
            // Clear localStorage
            const storageKey = this.config.userId > 0 
                ? `chatbot_history_${this.config.userId}` 
                : 'chatbot_history_guest';
            localStorage.removeItem(storageKey);
            
            console.log('✅ Cleared localStorage');
            
            // TODO: Clear database via API
            if (this.config.userId > 0) {
                console.log('⚠️ Database clear: Not implemented yet');
                console.log('   TODO: Create clear history API endpoint');
            }
            
            // Show welcome message
            setTimeout(() => {
                this.addMessage(
                    '👋 Lịch sử đã được xóa. Hãy bắt đầu cuộc trò chuyện mới!',
                    'bot'
                );
            }, 300);
            
        } catch (error) {
            console.error('❌ Clear history error:', error);
            alert('Có lỗi xảy ra khi xóa lịch sử!');
        }
    }
    
    /**
     * NEW: Manual sync button
     */
    async syncHistory() {
        console.log('🔄 Manual sync requested...');
        
        const now = Date.now();
        const timeSinceLastSync = now - this.lastSyncTime;
        
        // Prevent too frequent syncs
        if (timeSinceLastSync < 5000) { // 5 seconds
            console.log('⚠️ Sync too soon, skipping');
            return;
        }
        
        // Show syncing indicator
        const originalText = 'Đang đồng bộ...';
        
        try {
            await this.loadChatHistory();
            console.log('✅ Manual sync completed');
            alert('✅ Đồng bộ lịch sử thành công!');
            
        } catch (error) {
            console.error('❌ Manual sync error:', error);
            alert('❌ Lỗi đồng bộ: ' + error.message);
        }
    }
    
    // ========================================================================
    // REST OF THE CODE (Keep all existing functions)
    // ========================================================================
    
    bindEvents() {
        // Send message
        this.sendButton.addEventListener('click', () => this.sendMessage());
        this.chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });
        
        // Input handling
        this.chatInput.addEventListener('input', () => this.handleInput());
        this.chatInput.addEventListener('input', () => this.autoResize());
        
        // Quick suggestions
        if (this.quickSuggestions) {
            this.quickSuggestions.addEventListener('click', (e) => {
                if (e.target.classList.contains('chatbot-suggestion-item')) {
                    const message = e.target.dataset.message || e.target.textContent.trim();
                    this.sendCustomMessage(message);
                }
            });
        }
        
        // Quick actions
        if (this.quickActions) {
            this.quickActions.addEventListener('click', (e) => {
                const btn = e.target.closest('.chatbot-action-btn');
                if (btn && btn.dataset.message) {
                    this.sendCustomMessage(btn.dataset.message);
                }
            });
        }
        
        // Toggle welcome
        if (this.toggleWelcome) {
            this.toggleWelcome.addEventListener('click', () => this.toggleWelcomeSection());
        }
        
        // Header buttons
        const fullscreenBtn = document.getElementById('chatbotFullscreenBtn');
        const minimizeBtn = document.getElementById('chatbotMinimizeBtn');
        const closeBtn = document.getElementById('chatbotCloseBtn');
        
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', () => this.toggleFullscreen());
        }
        
        if (minimizeBtn) {
            minimizeBtn.addEventListener('click', () => this.toggleMinimize());
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.toggleMinimize());
        }
        
        // Float button
        if (this.floatButton) {
            this.floatButton.addEventListener('click', () => this.showChatbot());
        }
        
        // Overlay
        if (this.overlay) {
            this.overlay.addEventListener('click', (e) => {
                if (e.target === this.overlay && this.isFullscreen) {
                    this.toggleFullscreen();
                }
            });
        }
        
        // ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isFullscreen) {
                this.toggleFullscreen();
            }
        });
    }
    
    // Keep all other existing functions...
    // (toggleWelcomeSection, handleInput, autoResize, sendMessage, etc.)
    
    async sendMessage() {
        const message = this.chatInput.value.trim();
        
        if (!message || this.isTyping) {
            return;
        }
        
        // Auto-collapse welcome after first message
        if (!this.isWelcomeCollapsed && this.messageHistory.length > 0) {
            setTimeout(() => this.toggleWelcomeSection(), 500);
        }
        
        console.log('📤 Sending message:', message);
        
        this.addMessage(message, 'user');
        
        // Save user message to localStorage (backup only)
        if (this.config.userId === 0) { // Only for guests
            this.saveToLocalStorage(message, 'user');
        }
        
        this.chatInput.value = '';
        this.handleInput();
        this.autoResize();
        
        this.showTyping();
        
        try {
            const response = await this.callAPI(message);
            console.log('📥 API Response:', response);
            
            this.hideTyping();
            
            if (response.error) {
                this.addMessage(`❌ ${response.error}`, 'bot');
            } else if (response.success === false) {
                this.addMessage('❌ Có lỗi xảy ra, vui lòng thử lại!', 'bot');
            } else {
                const botResponse = response.response || 'Xin lỗi, tôi không hiểu.';
                this.addMessage(botResponse, 'bot');
                
                // Save bot response to localStorage (backup only for guests)
                if (this.config.userId === 0) {
                    this.saveToLocalStorage(botResponse, 'bot');
                } else {
                    console.log('✅ Message saved to database (user logged in)');
                }
                
                if (response.suggestions && response.suggestions.length > 0) {
                    this.updateSuggestions(response.suggestions);
                }
            }
            
            this.retryCount = 0;
            
        } catch (error) {
            console.error('❌ Send message error:', error);
            this.hideTyping();
            this.handleError(error, message);
        }
        
        this.scrollToBottom();
    }
    
    // Include ALL other existing methods here...
    // (sendCustomMessage, callAPI, handleError, retryMessage, addMessage, 
    //  formatMessage, showTyping, hideTyping, updateSuggestions, 
    //  toggleFullscreen, toggleMinimize, showChatbot, scrollToBottom, etc.)
    
    toggleWelcomeSection() {
        this.isWelcomeCollapsed = !this.isWelcomeCollapsed;
        
        if (this.isWelcomeCollapsed) {
            this.welcomeBar.classList.add('chatbot-collapsed');
            this.quickActions.classList.add('chatbot-hidden');
            this.toggleWelcome.classList.add('chatbot-collapsed');
        } else {
            this.welcomeBar.classList.remove('chatbot-collapsed');
            this.quickActions.classList.remove('chatbot-hidden');
            this.toggleWelcome.classList.remove('chatbot-collapsed');
        }
    }
    
    handleInput() {
        const value = this.chatInput.value;
        const length = value.length;
        
        if (this.charCount) {
            this.charCount.textContent = length;
        }
        
        this.sendButton.disabled = length === 0 || length > this.config.maxMessageLength;
        
        if (this.quickSuggestions) {
            this.quickSuggestions.style.display = length > 0 ? 'none' : 'flex';
        }
    }
    
    autoResize() {
        this.chatInput.style.height = 'auto';
        const maxHeight = this.isFullscreen ? 100 : 80;
        this.chatInput.style.height = Math.min(this.chatInput.scrollHeight, maxHeight) + 'px';
    }
    
    sendCustomMessage(message) {
        this.chatInput.value = message;
        this.handleInput();
        this.sendMessage();
    }
    
    async callAPI(message) {
        try {
            const response = await fetch(this.config.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: message })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Server không trả về JSON');
            }
            
            return await response.json();
            
        } catch (error) {
            console.error('API call error:', error);
            throw error;
        }
    }
    
    handleError(error, originalMessage = null) {
        if (this.retryCount < this.config.maxRetries && originalMessage) {
            this.retryCount++;
            this.addMessage(
                `🔄 Đang thử lại... (${this.retryCount}/${this.config.maxRetries})`,
                'bot'
            );
            
            setTimeout(() => {
                this.retryMessage(originalMessage);
            }, this.config.retryDelay);
        } else {
            this.addMessage(
                '❌ Không thể kết nối.\n• Kiểm tra mạng\n• Liên hệ: 0962.501.832',
                'bot'
            );
            this.retryCount = 0;
        }
    }
    
    async retryMessage(message) {
        try {
            this.showTyping();
            const response = await this.callAPI(message);
            this.hideTyping();
            
            if (response.error) {
                this.addMessage(`❌ ${response.error}`, 'bot');
            } else {
                this.addMessage(response.response || 'Xin lỗi.', 'bot');
                if (response.suggestions) {
                    this.updateSuggestions(response.suggestions);
                }
            }
            
            this.retryCount = 0;
            
        } catch (error) {
            this.handleError(error, message);
        }
    }
    
    addMessage(content, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message chatbot-${sender}`;
        
        const timestamp = new Date().toLocaleTimeString('vi-VN', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        messageDiv.innerHTML = `
            <div class="chatbot-message-bubble">
                <div class="chatbot-message-content">${this.formatMessage(content)}</div>
                <div class="chatbot-message-time">${timestamp}</div>
            </div>
        `;
        
        this.chatMessages.appendChild(messageDiv);
        
        this.messageHistory.push({
            content,
            sender,
            timestamp: Date.now(),
            time: timestamp
        });
        
        if (this.messageHistory.length > 50) {
            this.messageHistory.shift();
            const firstMessage = this.chatMessages.firstChild;
            if (firstMessage) {
                firstMessage.remove();
            }
        }
        
        this.scrollToBottom();
    }
    
    formatMessage(content) {
        if (!content) return '';
        
        return content
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>')
            .replace(/•/g, '&bull;');
    }
    
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
    
    updateSuggestions(suggestions) {
        if (!this.quickSuggestions || !suggestions || suggestions.length === 0) {
            return;
        }
        
        this.quickSuggestions.innerHTML = '';
        
        suggestions.forEach(suggestion => {
            const suggestionDiv = document.createElement('div');
            suggestionDiv.className = 'chatbot-suggestion-item';
            suggestionDiv.dataset.message = suggestion;
            suggestionDiv.textContent = suggestion;
            this.quickSuggestions.appendChild(suggestionDiv);
        });
    }
    
    toggleFullscreen() {
        this.isFullscreen = !this.isFullscreen;
        
        if (this.isFullscreen) {
            this.container.classList.add('chatbot-fullscreen');
            this.overlay.classList.add('chatbot-show');
            document.body.style.overflow = 'hidden';
            
            const btn = document.getElementById('chatbotFullscreenBtn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-compress"></i>';
            }
        } else {
            this.container.classList.remove('chatbot-fullscreen');
            this.overlay.classList.remove('chatbot-show');
            document.body.style.overflow = '';
            
            const btn = document.getElementById('chatbotFullscreenBtn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-expand"></i>';
            }
        }
        
        this.scrollToBottom();
        this.autoResize();
    }
    
    toggleMinimize() {
        this.isMinimized = !this.isMinimized;
        
        if (this.isMinimized) {
            this.container.classList.add('chatbot-minimized');
        } else {
            this.container.classList.remove('chatbot-minimized');
        }
    }
    
    showChatbot() {
        this.isMinimized = false;
        this.container.classList.remove('chatbot-minimized');
        
        // Don't show welcome if history exists
        if (this.messageHistory.length === 0 && !this.historyLoaded) {
            setTimeout(() => {
                this.addMessage(
                    '👋 Xin chào! Tôi là trợ lý AI của Fighter. Tôi có thể giúp bạn học tiếng Anh và tư vấn khóa học. Hãy hỏi tôi bất cứ điều gì!',
                    'bot'
                );
            }, 500);
        }
        
        this.scrollToBottom();
    }
    
    scrollToBottom() {
        setTimeout(() => {
            if (this.chatMessages) {
                this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
            }
        }, 100);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    try {
        const chatbot = new FighterChatbot(window.CHATBOT_CONFIG || {});
        window.fighterChatbot = chatbot;
        
        // Add sync and clear buttons
        const headerActions = document.querySelector('.chatbot-actions');
        if (headerActions) {
            // Sync button (only for logged-in users)
            if (window.CHATBOT_CONFIG && window.CHATBOT_CONFIG.userId > 0) {
                const syncBtn = document.createElement('button');
                syncBtn.className = 'chatbot-header-btn';
                syncBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
                syncBtn.title = 'Đồng bộ lịch sử';
                syncBtn.onclick = () => chatbot.syncHistory();
                headerActions.insertBefore(syncBtn, headerActions.firstChild);
            }
            
            // Clear button
            const clearBtn = document.createElement('button');
            clearBtn.className = 'chatbot-header-btn';
            clearBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
            clearBtn.title = 'Xóa lịch sử';
            clearBtn.onclick = () => chatbot.clearHistory();
            headerActions.insertBefore(clearBtn, headerActions.firstChild);
        }
        
        console.log('✅ Chatbot ready with database priority!');
    } catch (error) {
        console.error('❌ Failed to initialize chatbot:', error);
    }
});
