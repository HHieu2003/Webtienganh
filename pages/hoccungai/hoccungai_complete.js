/**
 * HỌC CÙNG AI - COMPLETE SYSTEM
 * Main JavaScript Controller
 * Version: 3.0
 * Author: Fighter English Center
 */

// ============================================
// GLOBAL STATE MANAGEMENT
// ============================================
const AppState = {
    currentSkill: 'listening',
    currentData: null,
    isPlaying: false,
    isRecording: false,
    audioContext: null,
    speechRecognition: null,
    currentAudio: null,
    currentLesson: null,
    currentArticle: null,
    currentTopic: null,
    currentWritingType: 'essay',
    currentWritingLevel: 'intermediate',
    userProgress: {},
    settings: {
        playbackSpeed: 1.0,
        voiceLanguage: 'en-US',
        accentPreference: 'american'
    }
};

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Initializing Học Cùng AI Complete System...');
    
    initializeSkillSwitching();
    initializeListening();
    initializeSpeaking();
    initializeReading();
    initializeWriting();
    initializeVocabulary();
    initializeGrammar();
    initializePronunciation();
    initializeCommunication();
    loadUserProgress();
    
    console.log('✅ System initialized successfully!');
});

// ============================================
// SKILL SWITCHING
// ============================================
function initializeSkillSwitching() {
    const skillItems = document.querySelectorAll('.skill-item');
    
    skillItems.forEach(item => {
        item.addEventListener('click', function() {
            const skill = this.getAttribute('data-skill');
            switchSkill(skill);
            
            // Update active state
            skillItems.forEach(si => si.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

function switchSkill(skillName) {
    console.log(`🔄 Switching to skill: ${skillName}`);
    
    // Hide all content sections
    const allContents = document.querySelectorAll('.skill-content');
    allContents.forEach(content => {
        content.style.display = 'none';
    });
    
    // Show selected content
    const selectedContent = document.getElementById(`${skillName}-content`);
    if (selectedContent) {
        selectedContent.style.display = 'block';
        AppState.currentSkill = skillName;
        
        // Load content if needed
        loadSkillContent(skillName);
    }
}

function loadSkillContent(skill) {
    switch(skill) {
        case 'listening':
            loadListeningLesson();
            break;
        case 'reading':
            loadReadingArticle();
            break;
        case 'writing':
            loadWritingTopic();
            break;
    }
}

// ============================================
// WRITING MODULE - HOÀN CHỈNH
// ============================================
function initializeWriting() {
    console.log('📝 Initializing Writing Module...');
    
    // Writing type tabs
    const writingTypeTabs = document.querySelectorAll('.writing-type-tab');
    writingTypeTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            switchWritingType(type);
            
            writingTypeTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Level selector
    const levelSelector = document.getElementById('writing-level-select');
    if (levelSelector) {
        levelSelector.addEventListener('change', function() {
            AppState.currentWritingLevel = this.value;
            loadWritingTopic();
        });
    }

    // Topic generator
    const generateTopicBtn = document.getElementById('generate-topic-btn');
    if (generateTopicBtn) {
        generateTopicBtn.addEventListener('click', loadWritingTopic);
    }

    // Text editor events
    const writingTextarea = document.getElementById('writing-textarea');
    if (writingTextarea) {
        writingTextarea.addEventListener('input', updateWordCount);
        writingTextarea.addEventListener('input', debounce(saveWritingDraft, 2000));
    }

    // Action buttons
    const checkBtn = document.getElementById('check-writing-btn');
    if (checkBtn) {
        checkBtn.addEventListener('click', checkWriting);
    }

    const suggestBtn = document.getElementById('get-suggestions-btn');
    if (suggestBtn) {
        suggestBtn.addEventListener('click', getWritingSuggestions);
    }

    const paraphraseBtn = document.getElementById('paraphrase-btn');
    if (paraphraseBtn) {
        paraphraseBtn.addEventListener('click', paraphraseText);
    }

    const clearBtn = document.getElementById('clear-writing-btn');
    if (clearBtn) {
        clearBtn.addEventListener('click', clearWriting);
    }

    const saveDraftBtn = document.getElementById('save-draft-btn');
    if (saveDraftBtn) {
        saveDraftBtn.addEventListener('click', () => saveWritingDraft(true));
    }

    // Initialize state
    AppState.currentWritingType = 'essay';
    AppState.currentWritingLevel = 'intermediate';
    
    // Load saved draft if exists
    loadSavedDraft();
}

function switchWritingType(type) {
    console.log(`📝 Switching writing type to: ${type}`);
    AppState.currentWritingType = type;
    
    const instructions = {
        'essay': 'Viết một bài luận hoàn chỉnh với Introduction, Body, và Conclusion.',
        'email': 'Viết một email chính thức hoặc không chính thức theo yêu cầu.',
        'paragraph': 'Viết một đoạn văn mạch lạc về chủ đề cho trước.',
        'letter': 'Viết một lá thư với định dạng phù hợp.',
        'report': 'Viết một báo cáo phân tích với dữ liệu và kết luận.'
    };
    
    const instructionBox = document.querySelector('.writing-instructions');
    if (instructionBox) {
        instructionBox.innerHTML = `<i class="fas fa-info-circle"></i> ${instructions[type] || instructions['essay']}`;
    }
    
    loadWritingTopic();
}

async function loadWritingTopic() {
    const topicDisplay = document.querySelector('.topic-display');
    if (!topicDisplay) return;
    
    topicDisplay.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Đang tạo đề bài...</div>';
    
    try {
        const response = await fetch(`pages/hoccungai/writing_handler.php?action=generate_topic&type=${AppState.currentWritingType}&level=${AppState.currentWritingLevel}`);
        const data = await response.json();
        
        if (data.success) {
            topicDisplay.innerHTML = `
                <div class="topic-card">
                    <div class="topic-header">
                        <i class="fas fa-lightbulb"></i>
                        <span class="topic-label">Đề bài</span>
                        <span class="topic-level badge badge-${data.level}">${data.level.toUpperCase()}</span>
                    </div>
                    <h3 class="topic-title">${data.topic}</h3>
                    <div class="topic-requirements">
                        <div class="requirement-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Loại: <strong>${data.type}</strong></span>
                        </div>
                        <div class="requirement-item">
                            <i class="fas fa-text-width"></i>
                            <span>Độ dài: <strong>${data.wordTarget}</strong></span>
                        </div>
                    </div>
                </div>
            `;
            
            AppState.currentTopic = data.topic;
            showToast('Đã tạo đề bài mới!', 'success');
        } else {
            topicDisplay.innerHTML = `<div class="error-message"><i class="fas fa-exclamation-triangle"></i> ${data.message}</div>`;
        }
    } catch (error) {
        console.error('Error loading topic:', error);
        topicDisplay.innerHTML = '<div class="error-message"><i class="fas fa-exclamation-triangle"></i> Không thể tải đề bài</div>';
    }
}

function updateWordCount() {
    const textarea = document.getElementById('writing-textarea');
    const wordCountDisplay = document.querySelector('.word-count');
    
    if (!textarea || !wordCountDisplay) return;
    
    const text = textarea.value.trim();
    const wordCount = text ? text.split(/\s+/).length : 0;
    const charCount = text.length;
    
    wordCountDisplay.innerHTML = `
        <i class="fas fa-text-width"></i> 
        <span>${wordCount} từ / ${charCount} ký tự</span>
    `;
    
    // Update progress bar
    const progressBar = document.querySelector('.writing-progress-bar');
    if (progressBar) {
        const targetWords = getTargetWordCount();
        const progress = Math.min((wordCount / targetWords) * 100, 100);
        progressBar.style.setProperty('--progress', `${progress}%`);
    }
}

function getTargetWordCount() {
    const targets = {
        'beginner': 120,
        'intermediate': 225,
        'advanced': 350
    };
    return targets[AppState.currentWritingLevel] || 200;
}

async function checkWriting() {
    const textarea = document.getElementById('writing-textarea');
    const text = textarea?.value.trim();
    
    if (!text || text.length < 50) {
        showToast('Vui lòng viết ít nhất 50 ký tự!', 'warning');
        return;
    }
    
    const feedbackContainer = document.querySelector('.writing-feedback');
    feedbackContainer.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Đang đánh giá bài viết...</div>';
    
    try {
        const response = await fetch('pages/hoccungai/writing_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'check',
                text: text,
                type: AppState.currentWritingType
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            displayWritingFeedback(data);
            saveWritingProgress(text, data.score);
            showToast('Đánh giá hoàn tất!', 'success');
        } else {
            feedbackContainer.innerHTML = `<div class="error-message"><i class="fas fa-exclamation-triangle"></i> ${data.message || 'Không thể đánh giá bài viết'}</div>`;
        }
    } catch (error) {
        console.error('Error checking writing:', error);
        feedbackContainer.innerHTML = '<div class="error-message"><i class="fas fa-exclamation-triangle"></i> Lỗi khi kiểm tra bài viết</div>';
    }
}

function displayWritingFeedback(data) {
    const feedbackContainer = document.querySelector('.writing-feedback');
    if (!feedbackContainer) return;
    
    const scores = data.scores || {};
    const errors = data.errors || [];
    const suggestions = data.suggestions || [];
    
    let scoreColor = '#e74c3c';
    let scoreLevel = 'Cần cải thiện';
    
    if (data.score >= 90) {
        scoreColor = '#0db33b';
        scoreLevel = 'Xuất sắc';
    } else if (data.score >= 75) {
        scoreColor = '#3498db';
        scoreLevel = 'Tốt';
    } else if (data.score >= 60) {
        scoreColor = '#f39c12';
        scoreLevel = 'Khá';
    }
    
    feedbackContainer.innerHTML = `
        <div class="feedback-header">
            <h3><i class="fas fa-chart-bar"></i> Đánh Giá Bài Viết</h3>
        </div>
        
        <div class="overall-score">
            <div class="score-circle" style="border-color: ${scoreColor}">
                <div class="score-value" style="color: ${scoreColor}">${data.score}</div>
                <div class="score-label">${scoreLevel}</div>
            </div>
            <div class="score-breakdown">
                <div class="score-item">
                    <span class="score-name">Ngữ pháp</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: ${scores.grammar || 0}%"></div>
                    </div>
                    <span class="score-number">${scores.grammar || 0}</span>
                </div>
                <div class="score-item">
                    <span class="score-name">Từ vựng</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: ${scores.vocabulary || 0}%"></div>
                    </div>
                    <span class="score-number">${scores.vocabulary || 0}</span>
                </div>
                <div class="score-item">
                    <span class="score-name">Cấu trúc</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: ${scores.structure || 0}%"></div>
                    </div>
                    <span class="score-number">${scores.structure || 0}</span>
                </div>
                <div class="score-item">
                    <span class="score-name">Mạch lạc</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: ${scores.coherence || 0}%"></div>
                    </div>
                    <span class="score-number">${scores.coherence || 0}</span>
                </div>
            </div>
        </div>
        
        ${errors.length > 0 ? `
        <div class="errors-section">
            <h4><i class="fas fa-exclamation-triangle"></i> Lỗi tìm thấy (${errors.length})</h4>
            <div class="errors-list">
                ${errors.map((error, index) => `
                    <div class="error-item">
                        <div class="error-number">${index + 1}</div>
                        <div class="error-content">
                            <div class="error-original">
                                <i class="fas fa-times-circle"></i>
                                <span>${escapeHtml(error.original)}</span>
                            </div>
                            <div class="error-corrected">
                                <i class="fas fa-check-circle"></i>
                                <span>${escapeHtml(error.corrected)}</span>
                            </div>
                            <div class="error-explanation">
                                <i class="fas fa-info-circle"></i>
                                ${escapeHtml(error.explanation)}
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
        ` : '<div class="no-errors"><i class="fas fa-check-circle"></i> Không phát hiện lỗi rõ ràng!</div>'}
        
        ${data.correctedText ? `
        <div class="corrected-section">
            <h4><i class="fas fa-edit"></i> Bài viết đã sửa</h4>
            <div class="corrected-text">${escapeHtml(data.correctedText)}</div>
            <button class="btn-secondary" onclick="copyToClipboard(\`${escapeHtml(data.correctedText)}\`)">
                <i class="fas fa-copy"></i> Sao chép
            </button>
        </div>
        ` : ''}
        
        ${suggestions.length > 0 ? `
        <div class="suggestions-section">
            <h4><i class="fas fa-lightbulb"></i> Gợi ý cải thiện</h4>
            <ul class="suggestions-list">
                ${suggestions.map(s => `<li><i class="fas fa-arrow-right"></i> ${escapeHtml(s)}</li>`).join('')}
            </ul>
        </div>
        ` : ''}
        
        <div class="feedback-stats">
            <div class="stat-item">
                <i class="fas fa-text-width"></i>
                <span>${data.wordCount || 0} từ</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-clock"></i>
                <span>${new Date().toLocaleTimeString('vi-VN')}</span>
            </div>
        </div>
    `;
    
    feedbackContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

async function getWritingSuggestions() {
    const topic = AppState.currentTopic;
    
    if (!topic) {
        showToast('Vui lòng tạo đề bài trước!', 'warning');
        return;
    }
    
    const suggestionsContainer = document.querySelector('.writing-suggestions');
    suggestionsContainer.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Đang tạo gợi ý...</div>';
    
    try {
        const response = await fetch('pages/hoccungai/writing_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'suggest',
                topic: topic,
                type: AppState.currentWritingType,
                level: AppState.currentWritingLevel
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            displayWritingSuggestions(data);
            showToast('Đã tạo gợi ý!', 'success');
        } else {
            suggestionsContainer.innerHTML = `<div class="error-message"><i class="fas fa-exclamation-triangle"></i> ${data.message}</div>`;
        }
    } catch (error) {
        console.error('Error getting suggestions:', error);
        suggestionsContainer.innerHTML = '<div class="error-message"><i class="fas fa-exclamation-triangle"></i> Không thể lấy gợi ý</div>';
    }
}

function displayWritingSuggestions(data) {
    const container = document.querySelector('.writing-suggestions');
    if (!container) return;
    
    const outline = data.outline || {};
    const vocabulary = data.vocabulary || [];
    const sentences = data.usefulSentences || [];
    const tips = data.tips || [];
    
    container.innerHTML = `
        <div class="suggestions-header">
            <h3><i class="fas fa-lightbulb"></i> Gợi Ý Viết Bài</h3>
        </div>
        
        ${outline.introduction || outline.body || outline.conclusion ? `
        <div class="outline-section">
            <h4><i class="fas fa-list-ol"></i> Dàn ý</h4>
            
            ${outline.introduction ? `
            <div class="outline-part">
                <div class="part-title">Introduction (Mở bài)</div>
                <ul>
                    ${outline.introduction.map(item => `<li>${escapeHtml(item)}</li>`).join('')}
                </ul>
            </div>
            ` : ''}
            
            ${outline.body ? `
            <div class="outline-part">
                <div class="part-title">Body (Thân bài)</div>
                <ul>
                    ${outline.body.map(item => `<li>${escapeHtml(item)}</li>`).join('')}
                </ul>
            </div>
            ` : ''}
            
            ${outline.conclusion ? `
            <div class="outline-part">
                <div class="part-title">Conclusion (Kết bài)</div>
                <ul>
                    ${outline.conclusion.map(item => `<li>${escapeHtml(item)}</li>`).join('')}
                </ul>
            </div>
            ` : ''}
        </div>
        ` : ''}
        
        ${vocabulary.length > 0 ? `
        <div class="vocabulary-section">
            <h4><i class="fas fa-book"></i> Từ vựng hữu ích</h4>
            <div class="vocabulary-grid">
                ${vocabulary.map(item => `
                    <div class="vocab-card">
                        <div class="vocab-word">${escapeHtml(item.word)}</div>
                        <div class="vocab-meaning">${escapeHtml(item.meaning)}</div>
                        <div class="vocab-example">"${escapeHtml(item.example)}"</div>
                    </div>
                `).join('')}
            </div>
        </div>
        ` : ''}
        
        ${sentences.length > 0 ? `
        <div class="sentences-section">
            <h4><i class="fas fa-quote-left"></i> Mẫu câu hữu ích</h4>
            <div class="sentences-list">
                ${sentences.map((sentence, index) => `
                    <div class="sentence-item">
                        <span class="sentence-number">${index + 1}</span>
                        <span class="sentence-text">${escapeHtml(sentence)}</span>
                    </div>
                `).join('')}
            </div>
        </div>
        ` : ''}
        
        ${tips.length > 0 ? `
        <div class="tips-section">
            <h4><i class="fas fa-star"></i> Mẹo viết hay</h4>
            <ul class="tips-list">
                ${tips.map(tip => `<li><i class="fas fa-check"></i> ${escapeHtml(tip)}</li>`).join('')}
            </ul>
        </div>
        ` : ''}
    `;
    
    container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

async function paraphraseText() {
    const textarea = document.getElementById('writing-textarea');
    const selectedText = getSelectedText(textarea);
    
    if (!selectedText || selectedText.length < 10) {
        showToast('Vui lòng bôi đen đoạn văn bản cần viết lại (ít nhất 10 ký tự)!', 'warning');
        return;
    }
    
    const modal = createParaphraseModal(selectedText);
    document.body.appendChild(modal);
    
    try {
        const response = await fetch('pages/hoccungai/writing_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'paraphrase',
                text: selectedText,
                style: 'formal'
            })
        });
        
        const data = await response.json();
        
        if (data.success && data.alternatives) {
            displayParaphraseOptions(modal, data.alternatives, selectedText);
        } else {
            const optionsContainer = modal.querySelector('.paraphrase-options');
            optionsContainer.innerHTML = '<div class="error-message">Không thể tạo cách viết lại</div>';
        }
    } catch (error) {
        console.error('Error paraphrasing:', error);
        const optionsContainer = modal.querySelector('.paraphrase-options');
        optionsContainer.innerHTML = '<div class="error-message">Lỗi khi viết lại câu</div>';
    }
}

function createParaphraseModal(originalText) {
    const modal = document.createElement('div');
    modal.className = 'modal paraphrase-modal';
    modal.id = 'paraphrase-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-sync-alt"></i> Viết Lại Câu</h3>
                <button class="close-modal" onclick="closeParaphraseModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="original-text">
                    <strong>Văn bản gốc:</strong>
                    <p>"${escapeHtml(originalText)}"</p>
                </div>
                <div class="paraphrase-options">
                    <div class="loading">
                        <i class="fas fa-spinner fa-spin"></i> Đang tạo các cách viết lại...
                    </div>
                </div>
            </div>
        </div>
    `;
    return modal;
}

function displayParaphraseOptions(modal, alternatives, originalText) {
    const optionsContainer = modal.querySelector('.paraphrase-options');
    optionsContainer.innerHTML = `
        <strong>Chọn cách viết lại:</strong>
        ${alternatives.map((alt, index) => `
            <div class="paraphrase-option" onclick="selectParaphrase(\`${escapeHtml(alt)}\`, \`${escapeHtml(originalText)}\`)">
                <div class="option-number">${index + 1}</div>
                <div class="option-text">${escapeHtml(alt)}</div>
                <button class="btn-icon" title="Chọn">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        `).join('')}
    `;
}

function selectParaphrase(newText, originalText) {
    const textarea = document.getElementById('writing-textarea');
    if (!textarea) return;
    
    const currentText = textarea.value;
    textarea.value = currentText.replace(originalText, newText);
    
    updateWordCount();
    closeParaphraseModal();
    showToast('Đã thay thế văn bản!', 'success');
}

function closeParaphraseModal() {
    const modal = document.getElementById('paraphrase-modal');
    if (modal) {
        modal.remove();
    }
}

function getSelectedText(textarea) {
    if (!textarea) return '';
    
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    
    return textarea.value.substring(start, end);
}

function clearWriting() {
    if (confirm('Bạn có chắc muốn xóa toàn bộ bài viết?')) {
        document.getElementById('writing-textarea').value = '';
        updateWordCount();
        document.querySelector('.writing-feedback').innerHTML = '';
        document.querySelector('.writing-suggestions').innerHTML = '';
        localStorage.removeItem('writing_draft');
        showToast('Đã xóa bài viết!', 'info');
    }
}

function saveWritingDraft(showMessage = false) {
    const textarea = document.getElementById('writing-textarea');
    const text = textarea?.value || '';
    
    if (text.trim().length > 0) {
        const draft = {
            text: text,
            topic: AppState.currentTopic,
            type: AppState.currentWritingType,
            level: AppState.currentWritingLevel,
            timestamp: Date.now()
        };
        
        localStorage.setItem('writing_draft', JSON.stringify(draft));
        
        if (showMessage) {
            showToast('Đã lưu nháp!', 'success');
        }
    }
}

function loadSavedDraft() {
    const savedDraft = localStorage.getItem('writing_draft');
    
    if (savedDraft) {
        try {
            const draft = JSON.parse(savedDraft);
            const textarea = document.getElementById('writing-textarea');
            
            if (textarea && confirm('Bạn có muốn khôi phục bài viết đã lưu?')) {
                textarea.value = draft.text;
                AppState.currentTopic = draft.topic;
                AppState.currentWritingType = draft.type || 'essay';
                AppState.currentWritingLevel = draft.level || 'intermediate';
                
                updateWordCount();
                showToast('Đã khôi phục nháp!', 'success');
            }
        } catch (error) {
            console.error('Error loading draft:', error);
        }
    }
}

async function saveWritingProgress(text, score) {
    try {
        await fetch('pages/hoccungai/api_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'save_progress',
                skill: 'writing',
                data: {
                    text: text.substring(0, 500),
                    score: score,
                    type: AppState.currentWritingType,
                    topic: AppState.currentTopic
                }
            })
        });
    } catch (error) {
        console.error('Error saving progress:', error);
    }
}

// ============================================
// LISTENING MODULE
// ============================================
function initializeListening() {
    console.log('🎧 Initializing Listening Module...');
    // Implement listening functionality here
}

function loadListeningLesson() {
    // Implement loading listening lessons
}

// ============================================
// SPEAKING MODULE
// ============================================
function initializeSpeaking() {
    console.log('🎤 Initializing Speaking Module...');
    // Implement speaking functionality here
}

// ============================================
// READING MODULE
// ============================================
function initializeReading() {
    console.log('📖 Initializing Reading Module...');
    // Implement reading functionality here
}

function loadReadingArticle() {
    // Implement loading reading articles
}

// ============================================
// VOCABULARY MODULE
// ============================================
function initializeVocabulary() {
    console.log('📚 Initializing Vocabulary Module...');
    // Implement vocabulary functionality here
}

// ============================================
// GRAMMAR MODULE
// ============================================
function initializeGrammar() {
    console.log('📖 Initializing Grammar Module...');
    // Implement grammar functionality here
}

// ============================================
// PRONUNCIATION MODULE
// ============================================
function initializePronunciation() {
    console.log('🔊 Initializing Pronunciation Module...');
    // Implement pronunciation functionality here
}

// ============================================
// COMMUNICATION MODULE
// ============================================
function initializeCommunication() {
    console.log('💬 Initializing Communication Module...');
    // Implement communication functionality here
}

// ============================================
// UTILITY FUNCTIONS
// ============================================
function showToast(message, type = 'info') {
    // Remove existing toast
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
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
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function debounce(func, wait) {
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

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Đã sao chép!', 'success');
    }).catch(err => {
        console.error('Copy failed:', err);
        showToast('Không thể sao chép', 'error');
    });
}

function loadUserProgress() {
    // Load user progress from backend
    console.log('📊 Loading user progress...');
}

// Make functions globally accessible
window.selectParaphrase = selectParaphrase;
window.closeParaphraseModal = closeParaphraseModal;
window.copyToClipboard = copyToClipboard;
