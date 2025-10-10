// Enhanced English Learning Chatbot
// Tích hợp các tính năng học tiếng Anh nâng cao

class EnglishLearningChatbot {
    constructor() {
        this.initializeElements();
        this.initializeData();
        this.setupEventListeners();
        this.currentMode = 'chat';
        this.userProgress = this.loadProgress();
        this.setupSpeechRecognition();
    }

    initializeElements() {
        this.chatBody = document.querySelector(".chat-body");
        this.messageInput = document.querySelector(".message-input");
        this.chatbotToggler = document.querySelector("#chatbot-toggler");
        this.closeChatbot = document.querySelector("#close-chatbot");
        this.chatForm = document.querySelector(".chat-form");
        this.modeButtons = document.querySelector(".mode-buttons");
        this.progressBar = document.querySelector(".progress-bar");
        this.streakCounter = document.querySelector(".streak-counter");
    }

    initializeData() {
        // API Configuration
        this.API_KEY = "AIzaSyBu3OOT0rNIc-1DDdFYW8EJh-s9sNzm_lc";
        this.API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${this.API_KEY}`;
        
        // Chat History with Enhanced System Prompt
        this.chatHistory = [{
            "role": "user",
            "parts": [{
                "text": "You are 'English Fighter Bot', an advanced AI English tutor with multiple teaching modes. You can: 1) Have conversations to practice speaking, 2) Create grammar quizzes with explanations, 3) Build vocabulary with examples and usage, 4) Help with pronunciation using phonetic guides, 5) Provide writing exercises with feedback, 6) Simulate real-life scenarios for practice. Always be encouraging, provide clear explanations, and adapt to the student's level. When giving feedback, be constructive and include specific improvement suggestions."
            }]
        }, {
            "role": "model",
            "parts": [{
                "text": "Hello! I'm your English Fighter Bot - your comprehensive English learning companion! 🚀\n\nI can help you with:\n📝 **Grammar Practice** - Interactive quizzes and explanations\n🎯 **Vocabulary Building** - Learn new words with context\n🗣️ **Speaking Practice** - Conversation and pronunciation\n✍️ **Writing Skills** - Essays, emails, and creative writing\n🎭 **Real Scenarios** - Job interviews, shopping, travel\n\nWhat would you like to practice today? Choose a mode or just start chatting!"
            }]
        }];

        // Learning Modes Data
        this.modes = {
            chat: { icon: '💬', name: 'Chat', description: 'Free conversation practice' },
            grammar: { icon: '📝', name: 'Grammar', description: 'Grammar quizzes and exercises' },
            vocabulary: { icon: '📚', name: 'Vocabulary', description: 'Word building and definitions' },
            pronunciation: { icon: '🗣️', name: 'Speaking', description: 'Pronunciation and speaking practice' },
            writing: { icon: '✍️', name: 'Writing', description: 'Writing exercises and feedback' },
            scenarios: { icon: '🎭', name: 'Scenarios', description: 'Real-life situation practice' }
        };

        // Vocabulary Topics
        this.vocabularyTopics = [
            'Business English', 'Travel & Tourism', 'Food & Cooking', 'Technology',
            'Health & Fitness', 'Education', 'Environment', 'Entertainment',
            'Sports', 'Shopping', 'Family & Relationships', 'Work & Career'
        ];

        // Grammar Topics
        this.grammarTopics = [
            'Present Tenses', 'Past Tenses', 'Future Tenses', 'Modal Verbs',
            'Passive Voice', 'Conditionals', 'Reported Speech', 'Articles',
            'Prepositions', 'Relative Clauses', 'Gerunds & Infinitives', 'Phrasal Verbs'
        ];

        // Speaking Scenarios
        this.speakingScenarios = [
            'Job Interview', 'Restaurant Ordering', 'Airport Check-in', 'Doctor Visit',
            'Shopping Mall', 'Hotel Booking', 'Making Friends', 'Business Meeting',
            'University Application', 'Phone Conversation', 'Complaint Resolution', 'Small Talk'
        ];
    }

    setupEventListeners() {
        // Basic chat functionality
        this.chatForm.addEventListener("submit", (e) => this.handleOutgoingMessage(e));
        this.messageInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 768) {
                this.handleOutgoingMessage(e);
            }
        });
        this.messageInput.addEventListener("input", () => this.adjustTextareaHeight());
        
        // Chatbot toggle
        this.chatbotToggler.addEventListener("click", () => {
            document.body.classList.toggle("show-chatbot");
            this.updateProgress();
        });
        this.closeChatbot.addEventListener("click", () => {
            document.body.classList.remove("show-chatbot");
        });

        // Mode selection
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('mode-btn')) {
                this.switchMode(e.target.dataset.mode);
            }
            if (e.target.classList.contains('quick-action-btn')) {
                this.handleQuickAction(e.target.dataset.action);
            }
            if (e.target.classList.contains('voice-btn')) {
                this.toggleVoiceRecording();
            }
        });
    }

    setupSpeechRecognition() {
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            this.recognition = new SpeechRecognition();
            this.recognition.continuous = false;
            this.recognition.interimResults = false;
            this.recognition.lang = 'en-US';
            
            this.recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                this.messageInput.value = transcript;
                this.handleOutgoingMessage(new Event('submit'));
            };

            this.recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
                this.showNotification('Voice recognition failed. Please try again.', 'error');
            };
        }
    }

    switchMode(mode) {
        this.currentMode = mode;
        document.querySelectorAll('.mode-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-mode="${mode}"]`).classList.add('active');
        
        // Add mode-specific UI elements
        this.updateModeInterface(mode);
        
        // Send mode switch message
        const modeInfo = this.modes[mode];
        const systemMessage = `Switched to ${modeInfo.name} mode. ${this.getModeInstructions(mode)}`;
        this.addSystemMessage(systemMessage);
    }

    getModeInstructions(mode) {
        const instructions = {
            chat: "Let's have a natural conversation! Talk about anything you'd like.",
            grammar: "I'll help you practice grammar with quizzes and explanations. What grammar topic interests you?",
            vocabulary: "Let's build your vocabulary! Choose a topic or ask me about specific words.",
            pronunciation: "Practice your pronunciation! I can help with phonetics and provide audio examples.",
            writing: "Let's work on your writing skills! I can help with essays, emails, stories, or any writing task.",
            scenarios: "Let's practice real-life situations! Choose a scenario or describe a situation you want to practice."
        };
        return instructions[mode] || "How can I help you today?";
    }

    updateModeInterface(mode) {
        // Update quick actions based on mode
        const quickActionsContainer = document.querySelector('.quick-actions');
        if (quickActionsContainer) {
            quickActionsContainer.innerHTML = this.generateQuickActions(mode);
        }
    }

    generateQuickActions(mode) {
        const actions = {
            grammar: this.grammarTopics.slice(0, 4),
            vocabulary: this.vocabularyTopics.slice(0, 4),
            scenarios: this.speakingScenarios.slice(0, 4)
        };

        if (!actions[mode]) return '';

        return actions[mode].map(action => 
            `<button class="quick-action-btn" data-action="${action}">${action}</button>`
        ).join('');
    }

    handleQuickAction(action) {
        let message = '';
        switch (this.currentMode) {
            case 'grammar':
                message = `Create a quiz about ${action} with 3 questions and explanations.`;
                break;
            case 'vocabulary':
                message = `Teach me 5 important words related to ${action} with examples.`;
                break;
            case 'scenarios':
                message = `Let's practice a ${action} scenario. Start the roleplay.`;
                break;
            default:
                message = `Tell me about ${action}.`;
        }
        
        this.messageInput.value = message;
        this.handleOutgoingMessage(new Event('submit'));
    }

    toggleVoiceRecording() {
        if (this.recognition) {
            if (this.isRecording) {
                this.recognition.stop();
                this.isRecording = false;
                document.querySelector('.voice-btn').classList.remove('recording');
            } else {
                this.recognition.start();
                this.isRecording = true;
                document.querySelector('.voice-btn').classList.add('recording');
            }
        } else {
            this.showNotification('Voice recognition not supported in this browser.', 'warning');
        }
    }

    async handleOutgoingMessage(e) {
        e.preventDefault();
        const message = this.messageInput.value.trim();
        if (!message) return;

        // Clear input and reset height
        this.messageInput.value = "";
        this.adjustTextareaHeight();

        // Add user message
        this.addMessage(message, 'user');
        
        // Update progress
        this.updateUserProgress('message_sent');

        // Generate bot response
        setTimeout(() => {
            this.generateBotResponse(message);
        }, 600);
    }

    addMessage(content, sender) {
        const messageDiv = this.createMessageElement(content, sender);
        this.chatBody.appendChild(messageDiv);
        this.scrollToBottom();
    }

    addSystemMessage(content) {
        const messageDiv = this.createMessageElement(content, 'system');
        this.chatBody.appendChild(messageDiv);
        this.scrollToBottom();
    }

    createMessageElement(content, sender) {
        const div = document.createElement("div");
        div.classList.add("message", `${sender}-message`);
        
        if (sender === 'bot') {
            div.innerHTML = `
                <div class="bot-avatar"><i class="fas fa-robot"></i></div>
                <div class="message-text">${this.formatResponse(content)}</div>
                <div class="message-actions">
                    <button class="action-btn speak-btn" onclick="chatbot.speakText('${content.replace(/'/g, "\\'")}')">🔊</button>
                    <button class="action-btn copy-btn" onclick="chatbot.copyText('${content.replace(/'/g, "\\'")}')">📋</button>
                </div>
            `;
        } else if (sender === 'user') {
            div.innerHTML = `<div class="message-text">${content}</div>`;
        } else if (sender === 'system') {
            div.innerHTML = `
                <div class="system-icon"><i class="fas fa-info-circle"></i></div>
                <div class="message-text">${content}</div>
            `;
        }
        
        div.style.animation = 'fadeIn 0.4s ease forwards';
        return div;
    }

    async generateBotResponse(userMessage) {
        // Add thinking indicator
        const thinkingDiv = this.createThinkingIndicator();
        this.chatBody.appendChild(thinkingDiv);
        this.scrollToBottom();

        // Add user message to chat history
        this.chatHistory.push({ 
            role: "user", 
            parts: [{ text: `[Mode: ${this.currentMode}] ${userMessage}` }] 
        });

        try {
            const response = await fetch(this.API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ contents: this.chatHistory })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error.message);
            }

            const data = await response.json();
            if (data.candidates && data.candidates.length > 0) {
                const botResponse = data.candidates[0].content.parts[0].text;
                
                // Remove thinking indicator
                thinkingDiv.remove();
                
                // Add bot response
                this.addMessage(botResponse, 'bot');
                
                // Add to chat history
                this.chatHistory.push({ 
                    role: "model", 
                    parts: [{ text: botResponse }] 
                });
                
                // Update progress
                this.updateUserProgress('response_received');
                
            } else {
                throw new Error("No response generated");
            }
        } catch (error) {
            thinkingDiv.remove();
            this.addMessage(
                `Sorry, I encountered an error: ${error.message}. Please check your API key or try again later.`,
                'bot'
            );
        }
    }

    createThinkingIndicator() {
        const div = document.createElement("div");
        div.classList.add("message", "bot-message", "thinking");
        div.innerHTML = `
            <div class="bot-avatar"><i class="fas fa-robot"></i></div>
            <div class="message-text">
                <div class="thinking-indicator">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        `;
        return div;
    }

    formatResponse(text) {
        // Enhanced text formatting
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
        text = text.replace(/^\* (.*$)/gm, '<li>$1</li>');
        text = text.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
        text = text.replace(/\n\n/g, '</p><p>');
        text = text.replace(/\n/g, '<br>');
        text = `<p>${text}</p>`;
        return text;
    }

    adjustTextareaHeight() {
        this.messageInput.style.height = "auto";
        this.messageInput.style.height = `${this.messageInput.scrollHeight}px`;
    }

    scrollToBottom() {
        this.chatBody.scrollTo({ top: this.chatBody.scrollHeight, behavior: "smooth" });
    }

    // Progress and Achievement System
    updateUserProgress(action) {
        const points = {
            'message_sent': 1,
            'response_received': 2,
            'quiz_completed': 5,
            'vocabulary_learned': 3,
            'scenario_completed': 10
        };

        this.userProgress.totalPoints += points[action] || 0;
        this.userProgress.messagesCount += action === 'message_sent' ? 1 : 0;
        this.userProgress.lastActivity = new Date().toISOString();
        
        // Update streak
        this.updateStreak();
        
        // Save progress
        this.saveProgress();
        
        // Update UI
        this.updateProgress();
    }

    updateStreak() {
        const today = new Date().toDateString();
        const lastActivity = new Date(this.userProgress.lastActivity).toDateString();
        
        if (today === lastActivity) {
            // Same day, maintain streak
            return;
        }
        
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        
        if (lastActivity === yesterday.toDateString()) {
            // Consecutive day
            this.userProgress.streak += 1;
        } else {
            // Streak broken
            this.userProgress.streak = 1;
        }
    }

    updateProgress() {
        if (this.progressBar) {
            const level = Math.floor(this.userProgress.totalPoints / 100) + 1;
            const progressInLevel = (this.userProgress.totalPoints % 100);
            this.progressBar.style.width = `${progressInLevel}%`;
            
            const levelDisplay = document.querySelector('.level-display');
            if (levelDisplay) {
                levelDisplay.textContent = `Level ${level}`;
            }
        }
        
        if (this.streakCounter) {
            this.streakCounter.textContent = `🔥 ${this.userProgress.streak} day streak`;
        }
    }

    loadProgress() {
        const saved = localStorage.getItem('englishChatbotProgress');
        return saved ? JSON.parse(saved) : {
            totalPoints: 0,
            messagesCount: 0,
            streak: 0,
            lastActivity: new Date().toISOString(),
            completedLessons: [],
            favoriteTopics: []
        };
    }

    saveProgress() {
        localStorage.setItem('englishChatbotProgress', JSON.stringify(this.userProgress));
    }

    // Utility Functions
    speakText(text) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text.replace(/<[^>]*>/g, ''));
            utterance.lang = 'en-US';
            utterance.rate = 0.8;
            speechSynthesis.speak(utterance);
        } else {
            this.showNotification('Text-to-speech not supported in this browser.', 'warning');
        }
    }

    copyText(text) {
        navigator.clipboard.writeText(text.replace(/<[^>]*>/g, '')).then(() => {
            this.showNotification('Text copied to clipboard!', 'success');
        }).catch(() => {
            this.showNotification('Failed to copy text.', 'error');
        });
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 100001;
            animation: slideIn 0.3s ease;
        `;
        
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            warning: '#ffc107',
            info: '#17a2b8'
        };
        
        notification.style.backgroundColor = colors[type] || colors.info;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Initialize enhanced features
    initializeEnhancedFeatures() {
        // Add mode buttons to header
        this.addModeButtons();
        
        // Add progress display
        this.addProgressDisplay();
        
        // Add quick actions container
        this.addQuickActions();
        
        // Add voice button
        this.addVoiceButton();
    }

    addModeButtons() {
        const header = document.querySelector('.chat-header .header-info');
        if (header) {
            const modeButtons = document.createElement('div');
            modeButtons.className = 'mode-buttons';
            modeButtons.innerHTML = Object.entries(this.modes).map(([key, mode]) => 
                `<button class="mode-btn ${key === 'chat' ? 'active' : ''}" data-mode="${key}" title="${mode.description}">
                    ${mode.icon}
                </button>`
            ).join('');
            header.appendChild(modeButtons);
        }
    }

    addProgressDisplay() {
        const header = document.querySelector('.chat-header');
        if (header) {
            const progressDiv = document.createElement('div');
            progressDiv.className = 'progress-display';
            progressDiv.innerHTML = `
                <div class="level-display">Level 1</div>
                <div class="progress-bar-container">
                    <div class="progress-bar"></div>
                </div>
                <div class="streak-counter">🔥 0 day streak</div>
            `;
            header.appendChild(progressDiv);
        }
    }

    addQuickActions() {
        const chatBody = document.querySelector('.chat-body');
        if (chatBody) {
            const quickActions = document.createElement('div');
            quickActions.className = 'quick-actions';
            chatBody.insertBefore(quickActions, chatBody.firstChild);
        }
    }

    addVoiceButton() {
        const chatControls = document.querySelector('.chat-controls');
        if (chatControls && this.recognition) {
            const voiceBtn = document.createElement('button');
            voiceBtn.className = 'voice-btn';
            voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            voiceBtn.title = 'Voice input';
            chatControls.insertBefore(voiceBtn, chatControls.firstChild);
        }
    }
}

// Initialize the enhanced chatbot when DOM is loaded
let chatbot;
document.addEventListener('DOMContentLoaded', () => {
    chatbot = new EnglishLearningChatbot();
    chatbot.initializeEnhancedFeatures();
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
});