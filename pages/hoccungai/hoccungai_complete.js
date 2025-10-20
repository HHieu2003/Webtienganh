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
        this.recognition = null;
        this.isRecording = false;
        this.initRecognition();
    }

    initRecognition() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            try {
                this.recognition = new SpeechRecognition();
                this.recognition.lang = 'en-US';
                this.recognition.continuous = false;
                this.recognition.interimResults = false;
                this.recognition.maxAlternatives = 1;
                
                // Add event listeners
                this.recognition.onstart = () => {
                    console.log('Speech recognition started');
                    this.isRecording = true;
                };
                
                this.recognition.onend = () => {
                    console.log('Speech recognition ended');
                    this.isRecording = false;
                };
                
                console.log('Speech Recognition initialized successfully');
            } catch (error) {
                console.error('Failed to initialize Speech Recognition:', error);
                this.recognition = null;
            }
        } else {
            console.warn('Speech Recognition not supported in this browser');
        }
    }

    isSupported() {
        return this.recognition !== null;
    }

    async startRecording() {
        if (!this.isSupported()) {
            throw new Error('Trình duyệt không hỗ trợ nhận dạng giọng nói. Vui lòng sử dụng Chrome hoặc Edge.');
        }

        if (this.isRecording) {
            throw new Error('Đang ghi âm rồi!');
        }

        return new Promise((resolve, reject) => {
            let timeoutId = null;

            this.recognition.onresult = (event) => {
                if (timeoutId) clearTimeout(timeoutId);
                
                try {
                    const transcript = event.results[0][0].transcript;
                    console.log('Transcript received:', transcript);
                    this.isRecording = false;
                    resolve(transcript);
                } catch (error) {
                    console.error('Error processing transcript:', error);
                    reject(new Error('Không thể xử lý bản ghi âm'));
                }
            };

            this.recognition.onerror = (event) => {
                if (timeoutId) clearTimeout(timeoutId);
                
                console.error('Speech recognition error:', event.error);
                this.isRecording = false;
                
                let errorMessage = 'Lỗi nhận dạng giọng nói';
                switch(event.error) {
                    case 'no-speech':
                        errorMessage = 'Không nghe thấy giọng nói!\n\n📌 Hãy thử:\n✓ Nói NGAY sau khi thấy "Đang ghi âm..."\n✓ Nói rõ và đủ lớn\n✓ Kiểm tra mic có bật không\n✓ Đưa mic gần miệng hơn';
                        break;
                    case 'audio-capture':
                        errorMessage = 'Không thể truy cập microphone!\n\n📌 Kiểm tra:\n✓ Mic có cắm/bật không?\n✓ Windows có tắt mic không?\n✓ App khác có đang dùng mic không?';
                        break;
                    case 'not-allowed':
                        errorMessage = 'Quyền truy cập microphone bị từ chối!\n\n📌 Cách sửa:\n1. Click biểu tượng 🔒 trên thanh địa chỉ\n2. Cho phép Microphone\n3. Tải lại trang (F5)';
                        break;
                    case 'network':
                        errorMessage = 'Lỗi kết nối mạng. Vui lòng kiểm tra kết nối internet.';
                        break;
                    case 'aborted':
                        errorMessage = 'Ghi âm bị hủy. Vui lòng thử lại.';
                        break;
                    default:
                        errorMessage = 'Lỗi: ' + event.error;
                }
                
                reject(new Error(errorMessage));
            };

            // Timeout after 60 seconds (tăng từ 30s lên 60s)
            timeoutId = setTimeout(() => {
                console.log('Speech recognition timeout');
                this.stopRecording();
                reject(new Error('Hết thời gian ghi âm (60 giây). Vui lòng thử lại.'));
            }, 60000);

            try {
                console.log('Starting speech recognition...');
                
                // Phát âm thanh beep để báo hiệu bắt đầu
                this.playBeep();
                
                this.recognition.start();
            } catch (error) {
                if (timeoutId) clearTimeout(timeoutId);
                console.error('Failed to start recognition:', error);
                
                if (error.name === 'InvalidStateError') {
                    // Recognition is already started, stop it and try again
                    this.stopRecording();
                    setTimeout(() => {
                        this.recognition.start();
                    }, 100);
                } else {
                    reject(new Error('Không thể khởi động ghi âm: ' + error.message));
                }
            }
        });
    }

    stopRecording() {
        if (this.recognition && this.isRecording) {
            try {
                console.log('Stopping speech recognition...');
                this.recognition.stop();
                this.isRecording = false;
            } catch (error) {
                console.error('Error stopping recognition:', error);
            }
        }
    }

    // Phát âm thanh beep để báo hiệu
    playBeep() {
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = 800; // Tần số 800Hz
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        } catch (error) {
            console.warn('Cannot play beep sound:', error);
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
