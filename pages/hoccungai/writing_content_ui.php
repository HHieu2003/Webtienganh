<!-- WRITING SECTION -->
<section id="writing-section" class="skill-content-section">
    <div class="writing-main-card">
        <div class="writing-header">
            <div class="writing-icon-wrapper">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <h2 class="writing-title">Luyện Viết (Writing)</h2>
            <p class="writing-subtitle">Rèn luyện kỹ năng viết tiếng Anh với phản hồi chi tiết từ AI</p>
        </div>

        <!-- Settings Panel -->
        <div class="writing-settings-panel">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Chọn cấp độ
                    </label>
                    <select id="writing-level" class="form-select">
                        <optgroup label="🎯 Cơ bản">
                            <option value="beginner">Beginner (A1-A2)</option>
                            <option value="elementary">Elementary (A2-B1)</option>
                        </optgroup>
                        <optgroup label="📚 Trung cấp">
                            <option value="intermediate" selected>Intermediate (B1-B2)</option>
                            <option value="upper_intermediate">Upper Intermediate (B2)</option>
                        </optgroup>
                        <optgroup label="🏆 Nâng cao">
                            <option value="advanced">Advanced (C1-C2)</option>
                        </optgroup>
                        <optgroup label="🎓 Luyện thi & Chuyên ngành">
                            <option value="ielts_6">IELTS 6.0-6.5</option>
                            <option value="ielts_7">IELTS 7.0+</option>
                            <option value="toefl">TOEFL Writing</option>
                            <option value="business">Business Writing</option>
                            <option value="academic">Academic Writing</option>
                        </optgroup>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-file-alt"></i> Loại bài viết
                    </label>
                    <select id="writing-mode" class="form-select">
                        <option value="essay">📝 Essay (Luận)</option>
                        <option value="email">✉️ Email</option>
                        <option value="letter">💌 Letter (Thư)</option>
                        <option value="paragraph">📄 Paragraph (Đoạn văn)</option>
                        <option value="story">📖 Story (Câu chuyện)</option>
                        <option value="report">📊 Report (Báo cáo)</option>
                        <option value="description">🖼️ Description (Mô tả)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-bookmark"></i> Chủ đề (tùy chọn)
                    </label>
                    <input type="text" id="writing-topic" class="form-control" placeholder="Để trống để AI gợi ý...">
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="writing-generate-btn" id="writing-get-prompt-btn">
                    <i class="fas fa-lightbulb"></i>
                    Tạo đề bài
                </button>
            </div>
        </div>

        <!-- Writing Prompt Card -->
        <div id="writing-prompt-container" class="writing-prompt-card" style="display: none;">
            <div class="prompt-header">
                <i class="fas fa-tasks"></i>
                <span>Đề bài của bạn</span>
            </div>
            <div class="prompt-body">
                <div id="writing-prompt-text"></div>
            </div>
        </div>

        <!-- Writing Editor Card -->
        <div class="writing-editor-card">
            <div class="editor-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-edit"></i>
                    <span>Bài viết của bạn</span>
                </div>
                <div class="editor-stats">
                    <span class="stat-badge">
                        <i class="fas fa-font"></i>
                        <span id="writing-word-count">0</span> từ
                    </span>
                    <span class="stat-badge">
                        <i class="fas fa-paragraph"></i>
                        <span id="writing-char-count">0</span> ký tự
                    </span>
                </div>
            </div>
            <div class="editor-body">
                <textarea id="writing-text-area" class="writing-textarea" placeholder="Bắt đầu viết bài của bạn tại đây...

💡 Lời khuyên:
• Đọc kỹ đề bài trước khi viết
• Lập dàn ý ngắn gọn
• Viết rõ ràng, mạch lạc
• Kiểm tra lại trước khi nộp"></textarea>
            </div>
            <div class="editor-actions">
                <button class="btn-editor-action btn-submit" id="writing-submit-btn">
                    <i class="fas fa-check-circle"></i>
                    <span>Kiểm tra bài viết</span>
                </button>
                <button class="btn-editor-action btn-clear" id="writing-clear-btn">
                    <i class="fas fa-trash-alt"></i>
                    <span>Xóa nội dung</span>
                </button>
            </div>
        </div>

        <!-- Results Container -->
        <div id="writing-results" class="mt-4" style="display: none;"></div>
    </div>
</section>

<style>
/* Writing Section Styles */
.writing-main-card {
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    border: 2px solid #667eea30;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
}

.writing-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.writing-icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.writing-icon-wrapper i {
    font-size: 2.5rem;
    color: white;
}

.writing-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.writing-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    margin: 0;
}

.writing-settings-panel {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.writing-settings-panel .form-label {
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.writing-settings-panel .form-label i {
    color: #667eea;
}

.writing-settings-panel .form-select,
.writing-settings-panel .form-control {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.writing-settings-panel .form-select:focus,
.writing-settings-panel .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.writing-generate-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 3rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.writing-generate-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
}

/* Prompt Card */
.writing-prompt-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
    border: 2px solid #3b82f620;
}

.prompt-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.05rem;
    font-weight: 600;
}

.prompt-header i {
    font-size: 1.3rem;
}

.prompt-body {
    padding: 2rem;
}

.prompt-body #writing-prompt-text {
    line-height: 1.8;
    color: #334155;
    font-size: 1.05rem;
}

/* Editor Card */
.writing-editor-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.editor-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.05rem;
    font-weight: 600;
}

.editor-header i {
    font-size: 1.3rem;
}

.editor-stats {
    display: flex;
    gap: 1rem;
}

.stat-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.4rem 0.875rem;
    border-radius: 20px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.stat-badge i {
    font-size: 0.9rem;
}

.editor-body {
    padding: 0;
}

.writing-textarea {
    width: 100%;
    min-height: 400px;
    border: none;
    padding: 2rem;
    font-size: 1.05rem;
    line-height: 1.8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    resize: vertical;
    color: #1e293b;
}

.writing-textarea:focus {
    outline: none;
}

.writing-textarea::placeholder {
    color: #94a3b8;
    line-height: 1.8;
}

.editor-actions {
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
    background: #f8fafc;
    border-top: 2px dashed #e2e8f0;
}

.btn-editor-action {
    padding: 0.875rem 2.5rem;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    border: none;
}

.btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(16, 185, 129, 0.4);
}

.btn-clear {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.btn-clear:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #475569;
}

/* Results Card */
.writing-results-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 2rem;
}

.results-header {
    padding: 2.5rem;
    text-align: center;
    color: white;
}

.results-header h3 {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.results-statistics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-bottom: 2px dashed #e2e8f0;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
}

.stat-label {
    font-size: 0.85rem;
    color: #64748b;
    margin-top: 0.25rem;
}

.results-score-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    padding: 2rem;
    background: #f8fafc;
}

.score-item {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.score-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.score-value-large {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.score-label {
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 600;
    margin-top: 0.5rem;
}

.results-section {
    padding: 2rem;
    border-top: 2px dashed #e2e8f0;
}

.results-section h4 {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.2rem;
}

.error-item,
.suggestion-item {
    background: white;
    padding: 1.25rem;
    margin-bottom: 1rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-left: 4px solid #ef4444;
}

.suggestion-item {
    border-left-color: #3b82f6;
}

.error-type {
    display: inline-block;
    background: #fee2e2;
    color: #991b1b;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.text-original {
    color: #ef4444;
    font-weight: 600;
    text-decoration: line-through;
    margin: 0.5rem 0;
}

.text-correction {
    color: #10b981;
    font-weight: 600;
    margin: 0.5rem 0;
}

.text-explanation {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-top: 0.75rem;
}

.structure-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.structure-item {
    background: #f8fafc;
    padding: 1.25rem;
    border-radius: 12px;
    border-left: 4px solid #667eea;
}

.structure-item h5 {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.structure-item p {
    color: #475569;
    line-height: 1.6;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .writing-main-card {
        padding: 1.5rem;
    }
    
    .writing-title {
        font-size: 1.8rem;
    }
    
    .writing-generate-btn {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }
    
    .writing-textarea {
        min-height: 300px;
        padding: 1.5rem;
        font-size: 1rem;
    }
    
    .editor-actions {
        flex-direction: column;
    }
    
    .editor-stats {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .results-score-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .structure-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'writing') {
        initWritingSection();
    }
});

function initWritingSection() {
    const modeSelect = document.getElementById('writing-mode');
    const topicInput = document.getElementById('writing-topic');
    const levelSelect = document.getElementById('writing-level');
    const getPromptBtn = document.getElementById('writing-get-prompt-btn');
    const textArea = document.getElementById('writing-text-area');
    const wordCountSpan = document.getElementById('writing-word-count');
    const charCountSpan = document.getElementById('writing-char-count');
    const submitBtn = document.getElementById('writing-submit-btn');
    const clearBtn = document.getElementById('writing-clear-btn');

    // Word and character count
    textArea?.addEventListener('input', () => {
        const text = textArea.value.trim();
        const words = text.split(/\s+/).filter(w => w.length > 0);
        wordCountSpan.textContent = words.length;
        charCountSpan.textContent = textArea.value.length;
    });

    // Get writing prompt
    getPromptBtn?.addEventListener('click', async () => {
        const mode = modeSelect.value;
        const topic = topicInput.value;
        const level = levelSelect.value;

        Utils.showLoading('Đang tạo đề bài...');

        try {
            const result = await Utils.apiRequest('writing_api.php', {
                action: 'get_prompt',
                mode: mode,
                topic: topic,
                level: level
            });

            if (result.success) {
                displayWritingPrompt(result.data);
                Utils.showToast('✅ Đề bài đã sẵn sàng! Hãy bắt đầu viết.', 'success');
                
                // Scroll to editor
                setTimeout(() => {
                    document.querySelector('.writing-editor-card').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 300);
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo đề bài', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    // Submit writing
    submitBtn?.addEventListener('click', async () => {
        const text = textArea.value.trim();
        
        if (text.length < 50) {
            Utils.showToast('⚠️ Vui lòng viết ít nhất 50 ký tự (hiện tại: ' + text.length + ')', 'warning');
            return;
        }

        const mode = modeSelect.value;
        const level = levelSelect.value;

        Utils.showLoading('Đang phân tích bài viết của bạn...');

        try {
            const result = await Utils.apiRequest('writing_api.php', {
                action: 'check',
                text: text,
                mode: mode,
                level: level
            });

            if (result.success) {
                displayWritingResults(result.data);
                
                // Scroll to results
                setTimeout(() => {
                    document.getElementById('writing-results').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 300);
                
                Utils.showToast('✅ Đã phân tích xong! Xem kết quả bên dưới.', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể phân tích bài viết', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    // Clear text
    clearBtn?.addEventListener('click', () => {
        if (confirm('Bạn có chắc muốn xóa toàn bộ bài viết?')) {
            textArea.value = '';
            wordCountSpan.textContent = '0';
            charCountSpan.textContent = '0';
            document.getElementById('writing-results').style.display = 'none';
            Utils.showToast('Đã xóa nội dung', 'success');
        }
    });

    function displayWritingPrompt(data) {
        const container = document.getElementById('writing-prompt-container');
        const textDiv = document.getElementById('writing-prompt-text');
        
        textDiv.innerHTML = data.prompt.replace(/\n/g, '<br>');
        container.style.display = 'block';
    }

    function displayWritingResults(data) {
        const resultsDiv = document.getElementById('writing-results');
        resultsDiv.style.display = 'block';

        const overallScore = data.overall_score || 7;
        const scores = data.scores || {};
        const stats = data.statistics || {};
        
        // Determine performance level
        let performanceEmoji = '🎉';
        let performanceText = 'Tốt lắm!';
        let performanceColor = '#10b981';
        
        if (overallScore >= 9) {
            performanceEmoji = '🏆';
            performanceText = 'Xuất sắc!';
            performanceColor = '#fbbf24';
        } else if (overallScore >= 8) {
            performanceEmoji = '🌟';
            performanceText = 'Rất tốt!';
            performanceColor = '#10b981';
        } else if (overallScore >= 7) {
            performanceEmoji = '👍';
            performanceText = 'Tốt!';
            performanceColor = '#3b82f6';
        } else if (overallScore >= 6) {
            performanceEmoji = '💪';
            performanceText = 'Khá!';
            performanceColor = '#8b5cf6';
        } else {
            performanceEmoji = '📚';
            performanceText = 'Cần cố gắng thêm!';
            performanceColor = '#f59e0b';
        }
        
        let html = '<div class="writing-results-card">';
        
        // Header with overall score
        html += `<div class="results-header" style="background: linear-gradient(135deg, ${performanceColor} 0%, ${performanceColor}dd 100%);">`;
        html += `<div style="font-size: 4rem; margin-bottom: 0.75rem;">${performanceEmoji}</div>`;
        html += `<h3 style="margin: 0 0 1rem 0;">${performanceText}</h3>`;
        html += `<div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem;">${overallScore}/10</div>`;
        html += `<div style="font-size: 1.1rem; opacity: 0.95;">Điểm tổng thể</div>`;
        html += `</div>`;
        
        // Statistics
        if (stats.word_count) {
            html += '<div class="results-statistics">';
            html += `<div class="stat-item">
                <div class="stat-value">${stats.word_count}</div>
                <div class="stat-label">Từ</div>
            </div>`;
            html += `<div class="stat-item">
                <div class="stat-value">${stats.sentence_count || 0}</div>
                <div class="stat-label">Câu</div>
            </div>`;
            html += `<div class="stat-item">
                <div class="stat-value">${stats.paragraph_count || 0}</div>
                <div class="stat-label">Đoạn</div>
            </div>`;
            html += `<div class="stat-item">
                <div class="stat-value">${stats.avg_sentence_length || 0}</div>
                <div class="stat-label">Từ/Câu TB</div>
            </div>`;
            html += '</div>';
        }
        
        // Score Grid
        const scoreLabels = {
            grammar: { label: 'Ngữ pháp', icon: '📖' },
            vocabulary: { label: 'Từ vựng', icon: '📚' },
            coherence: { label: 'Mạch lạc', icon: '🔗' },
            task_achievement: { label: 'Hoàn thành', icon: '🎯' },
            organization: { label: 'Bố cục', icon: '📋' },
            style: { label: 'Phong cách', icon: '✨' }
        };
        
        html += '<div class="results-score-grid">';
        Object.keys(scores).forEach(key => {
            const scoreInfo = scoreLabels[key] || { label: key, icon: '📊' };
            const score = scores[key];
            let scoreColor = '#64748b';
            if (score >= 9) scoreColor = '#fbbf24';
            else if (score >= 8) scoreColor = '#10b981';
            else if (score >= 7) scoreColor = '#3b82f6';
            else if (score >= 6) scoreColor = '#8b5cf6';
            else if (score >= 5) scoreColor = '#f59e0b';
            else scoreColor = '#ef4444';
            
            html += `<div class="score-item">`;
            html += `<div style="font-size: 2rem; margin-bottom: 0.5rem;">${scoreInfo.icon}</div>`;
            html += `<div class="score-value-large" style="color: ${scoreColor};">${score}/10</div>`;
            html += `<div class="score-label">${scoreInfo.label}</div>`;
            html += `</div>`;
        });
        html += '</div>';
        
        // Grammar errors
        if (data.grammar_errors && data.grammar_errors.length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> Lỗi ngữ pháp cần sửa</h4>';
            data.grammar_errors.forEach((error, i) => {
                html += `<div class="error-item">`;
                html += `<div class="error-type">${error.type || 'Grammar Error'}</div>`;
                html += `<div class="text-original">❌ ${error.original}</div>`;
                html += `<div class="text-correction">✅ ${error.correction}</div>`;
                html += `<div class="text-explanation">${error.explanation}</div>`;
                html += `</div>`;
            });
            html += '</div>';
        }

        // Vocabulary suggestions
        if (data.vocabulary_suggestions && data.vocabulary_suggestions.length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-book-open" style="color: #3b82f6;"></i> Gợi ý cải thiện từ vựng</h4>';
            data.vocabulary_suggestions.forEach((sug, i) => {
                html += `<div class="suggestion-item">`;
                html += `<div style="margin-bottom: 0.75rem;">`;
                html += `<strong style="color: #ef4444;">"${sug.original}"</strong> → `;
                html += `<strong style="color: #10b981;">"${sug.suggestion}"</strong>`;
                html += `</div>`;
                if (sug.context) {
                    html += `<div style="background: #f0f9ff; padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem; font-style: italic;">`;
                    html += `💡 Ví dụ: ${sug.context}`;
                    html += `</div>`;
                }
                html += `<div class="text-explanation">${sug.explanation}</div>`;
                html += `</div>`;
            });
            html += '</div>';
        }
        
        // Structure feedback
        if (data.structure_feedback && Object.keys(data.structure_feedback).length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-sitemap" style="color: #8b5cf6;"></i> Phản hồi về cấu trúc</h4>';
            html += '<div class="structure-grid">';
            
            const structureLabels = {
                introduction: { label: 'Mở bài', icon: '📝' },
                body: { label: 'Thân bài', icon: '📄' },
                conclusion: { label: 'Kết bài', icon: '🎯' },
                transitions: { label: 'Từ nối', icon: '🔗' }
            };
            
            Object.keys(data.structure_feedback).forEach(key => {
                if (data.structure_feedback[key]) {
                    const info = structureLabels[key] || { label: key, icon: '📌' };
                    html += `<div class="structure-item">`;
                    html += `<h5>${info.icon} ${info.label}</h5>`;
                    html += `<p>${data.structure_feedback[key]}</p>`;
                    html += `</div>`;
                }
            });
            
            html += '</div></div>';
        }
        
        // Overall feedback
        if (data.feedback) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-comment-dots" style="color: #10b981;"></i> Nhận xét tổng quan</h4>';
            html += `<div style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 1.5rem; border-radius: 8px; line-height: 1.8;">${data.feedback.replace(/\n/g, '<br>')}</div>`;
            html += '</div>';
        }
        
        // Strengths and improvements in two columns
        if ((data.strengths && data.strengths.length > 0) || (data.improvements && data.improvements.length > 0)) {
            html += '<div class="results-section">';
            html += '<div class="row g-3">';
            
            if (data.strengths && data.strengths.length > 0) {
                html += '<div class="col-md-6">';
                html += '<h4 style="color: #10b981; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">';
                html += '<i class="fas fa-check-circle"></i> Điểm mạnh</h4>';
                html += '<ul style="list-style: none; padding: 0; margin: 0;">';
                data.strengths.forEach(s => {
                    html += `<li style="padding: 0.75rem 1rem; margin-bottom: 0.5rem; background: #ecfdf5; border-left: 4px solid #10b981; border-radius: 8px; line-height: 1.6;">`;
                    html += `<strong style="color: #10b981;">✓</strong> ${s}`;
                    html += `</li>`;
                });
                html += '</ul></div>';
            }
            
            if (data.improvements && data.improvements.length > 0) {
                html += '<div class="col-md-6">';
                html += '<h4 style="color: #f59e0b; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">';
                html += '<i class="fas fa-arrow-up"></i> Cần cải thiện</h4>';
                html += '<ul style="list-style: none; padding: 0; margin: 0;">';
                data.improvements.forEach(i => {
                    html += `<li style="padding: 0.75rem 1rem; margin-bottom: 0.5rem; background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 8px; line-height: 1.6;">`;
                    html += `<strong style="color: #f59e0b;">!</strong> ${i}`;
                    html += `</li>`;
                });
                html += '</ul></div>';
            }
            
            html += '</div></div>';
        }
        
        // Next steps
        if (data.next_steps && data.next_steps.length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-tasks" style="color: #667eea;"></i> Bước tiếp theo</h4>';
            html += '<ul style="list-style: none; padding: 0; margin: 0;">';
            data.next_steps.forEach((step, idx) => {
                html += `<li style="padding: 1rem 1.25rem; margin-bottom: 0.75rem; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border: 2px solid #667eea30; border-radius: 12px; line-height: 1.6;">`;
                html += `<strong style="color: #667eea; margin-right: 0.5rem;">${idx + 1}.</strong> ${step}`;
                html += `</li>`;
            });
            html += '</ul></div>';
        }
        
        html += '</div>';
        
        resultsDiv.innerHTML = html;
    }
}
</script>
