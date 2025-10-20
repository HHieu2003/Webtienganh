/**
 * HỌC CÙNG AI - COMPLETE JAVASCRIPT
 * Main JavaScript file for AI Learning Platform
 * Version: 3.1
 */

// Global state management
const AppState = {
    currentSkill: 'listening',
    isLoading: false,
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '',
    apiBaseUrl: 'pages/hoccungai/'
};

// Utility Functions
const Utils = {
    // Show toast notification
    showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        toast.innerHTML = `
            <i class="fas ${icons[type] || icons.info}"></i>
            <span>${message}</span>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    },

    // Show loading overlay
    showLoading(message = 'Đang xử lý...') {
        let overlay = document.getElementById('loading-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'loading-overlay';
            overlay.className = 'loading-overlay';
            document.body.appendChild(overlay);
        }

        overlay.innerHTML = `
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <p style="margin-top: 1rem; color: var(--text-primary);">${message}</p>
            </div>
        `;
        overlay.style.display = 'flex';
        AppState.isLoading = true;
    },

    // Hide loading overlay
    hideLoading() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
        AppState.isLoading = false;
    },

    // API Request wrapper
    async apiRequest(endpoint, data = {}, method = 'POST') {
        try {
            const formData = new FormData();
            formData.append('csrf_token', AppState.csrfToken);
            
            Object.keys(data).forEach(key => {
                formData.append(key, data[key]);
            });

            const response = await fetch(AppState.apiBaseUrl + endpoint, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            return result;

        } catch (error) {
            console.error('API Request Error:', error);
            throw error;
        }
    },

    // Format date/time
    formatDateTime(date) {
        return new Date(date).toLocaleString('vi-VN');
    },

    // Sanitize HTML
    sanitizeHTML(str) {
        const temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML;
    },

    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};

// Tab Navigation System
class TabNavigator {
    constructor() {
        this.tabs = document.querySelectorAll('.skill-tab-btn');
        this.contentSections = document.querySelectorAll('.skill-content-section');
        this.init();
    }

    init() {
        this.tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                this.switchTab(e.currentTarget);
            });
        });

        // Show first tab by default
        if (this.tabs.length > 0) {
            this.switchTab(this.tabs[0]);
        }
    }

    switchTab(selectedTab) {
        const skillName = selectedTab.dataset.skill;
        
        // Update tab buttons
        this.tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        selectedTab.classList.add('active');

        // Update content sections
        this.contentSections.forEach(section => {
            section.classList.remove('active');
        });

        const targetSection = document.getElementById(`${skillName}-section`);
        if (targetSection) {
            targetSection.classList.add('active');
            AppState.currentSkill = skillName;
            
            // Trigger skill-specific initialization
            this.initializeSkillSection(skillName);
        }

        // Scroll to top of content
        const scrollableContent = document.querySelector('.ai-scrollable-content');
        if (scrollableContent) {
            scrollableContent.scrollTop = 0;
        }
    }

    initializeSkillSection(skillName) {
        // Initialize skill-specific features
        const initEvent = new CustomEvent('skillSectionInit', { 
            detail: { skill: skillName } 
        });
        document.dispatchEvent(initEvent);
    }
}

// Base class for skill handlers
class SkillHandler {
    constructor(skillName) {
        this.skillName = skillName;
        this.apiEndpoint = `${skillName}_api.php`;
    }

    async generateExercise(level, topic = '') {
        Utils.showLoading('Đang tạo bài tập...');
        try {
            const result = await Utils.apiRequest(this.apiEndpoint, {
                action: 'generate',
                level: level,
                topic: topic
            });

            if (result.success) {
                Utils.showToast('Đã tạo bài tập thành công!', 'success');
                return result.data;
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo bài tập: ' + error.message, 'error');
            return null;
        } finally {
            Utils.hideLoading();
        }
    }

    async submitAnswer(questionId, answer) {
        Utils.showLoading('Đang kiểm tra câu trả lời...');
        try {
            const result = await Utils.apiRequest(this.apiEndpoint, {
                action: 'check',
                question_id: questionId,
                answer: answer
            });

            if (result.success) {
                return result.data;
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            Utils.showToast('Không thể kiểm tra câu trả lời: ' + error.message, 'error');
            return null;
        } finally {
            Utils.hideLoading();
        }
    }

    async getFeedback(data) {
        Utils.showLoading('Đang phân tích...');
        try {
            const result = await Utils.apiRequest(this.apiEndpoint, {
                action: 'feedback',
                ...data
            });

            if (result.success) {
                return result.data;
            } else {
                throw new Error(result.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            Utils.showToast('Không thể lấy phản hồi: ' + error.message, 'error');
            return null;
        } finally {
            Utils.hideLoading();
        }
    }
}

// Audio Player Helper
class AudioPlayer {
    constructor() {
        this.currentAudio = null;
    }

    play(audioUrl) {
        if (this.currentAudio) {
            this.currentAudio.pause();
        }

        this.currentAudio = new Audio(audioUrl);
        this.currentAudio.play();

        return this.currentAudio;
    }

    pause() {
        if (this.currentAudio) {
            this.currentAudio.pause();
        }
    }

    stop() {
        if (this.currentAudio) {
            this.currentAudio.pause();
            this.currentAudio.currentTime = 0;
        }
    }
}

// Speech Recognition Helper
class SpeechRecognitionHelper {
    constructor() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            this.recognition = new SpeechRecognition();
            this.recognition.lang = 'en-US';
            this.recognition.continuous = false;
            this.recognition.interimResults = false;
        } else {
            this.recognition = null;
        }
    }

    isSupported() {
        return this.recognition !== null;
    }

    async startRecording() {
        if (!this.isSupported()) {
            throw new Error('Trình duyệt không hỗ trợ nhận dạng giọng nói');
        }

        return new Promise((resolve, reject) => {
            this.recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                resolve(transcript);
            };

            this.recognition.onerror = (event) => {
                reject(new Error('Lỗi nhận dạng giọng nói: ' + event.error));
            };

            this.recognition.start();
        });
    }

    stopRecording() {
        if (this.recognition) {
            this.recognition.stop();
        }
    }
}

// Progress Tracker
class ProgressTracker {
    constructor() {
        this.progress = this.loadProgress();
    }

    loadProgress() {
        const saved = localStorage.getItem('ai_learning_progress');
        return saved ? JSON.parse(saved) : {};
    }

    saveProgress() {
        localStorage.setItem('ai_learning_progress', JSON.stringify(this.progress));
    }

    updateProgress(skill, data) {
        if (!this.progress[skill]) {
            this.progress[skill] = {
                completed: 0,
                total: 0,
                score: 0,
                lastActivity: null
            };
        }

        Object.assign(this.progress[skill], data);
        this.progress[skill].lastActivity = new Date().toISOString();
        this.saveProgress();
    }

    getProgress(skill) {
        return this.progress[skill] || {
            completed: 0,
            total: 0,
            score: 0,
            lastActivity: null
        };
    }

    getAllProgress() {
        return this.progress;
    }
}

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('Hoc Cung AI - Initializing...');

    // Initialize tab navigation
    const tabNavigator = new TabNavigator();

    // Initialize global instances
    window.audioPlayer = new AudioPlayer();
    window.speechRecognition = new SpeechRecognitionHelper();
    window.progressTracker = new ProgressTracker();

    // Make utilities globally available
    window.Utils = Utils;
    window.SkillHandler = SkillHandler;

    // Log initialization complete
    console.log('Hoc Cung AI - Ready!');
    console.log('Current skill:', AppState.currentSkill);
});

// Handle page visibility change
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        // Pause any playing audio when page is hidden
        if (window.audioPlayer) {
            window.audioPlayer.pause();
        }
    }
});

// Handle before unload
window.addEventListener('beforeunload', (e) => {
    if (AppState.isLoading) {
        e.preventDefault();
        e.returnValue = 'Có thao tác đang xử lý. Bạn có chắc muốn rời khỏi trang?';
    }
});

// Export for use in other scripts
window.AppState = AppState;
