<!-- WRITING SECTION -->
<section id="writing-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-pen-fancy"></i>
                Luyện Viết (Writing)
            </h2>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Rèn luyện kỹ năng viết tiếng Anh với sự phản hồi chi tiết từ AI.</p>
            
            <!-- Writing Mode Selection -->
            <div class="form-group">
                <label class="form-label">Chọn chế độ:</label>
                <select id="writing-mode" class="form-control">
                    <option value="essay">Essay Writing (Viết luận)</option>
                    <option value="email">Email Writing (Viết email)</option>
                    <option value="letter">Letter Writing (Viết thư)</option>
                    <option value="paragraph">Paragraph Writing (Viết đoạn văn)</option>
                    <option value="grammar">Grammar Check (Kiểm tra ngữ pháp)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Chủ đề:</label>
                <input type="text" id="writing-topic" class="form-control" placeholder="Nhập chủ đề hoặc để trống để AI gợi ý">
            </div>

            <div class="form-group">
                <label class="form-label">Cấp độ:</label>
                <select id="writing-level" class="form-control">
                    <option value="beginner">Beginner (A1-A2)</option>
                    <option value="intermediate" selected>Intermediate (B1-B2)</option>
                    <option value="advanced">Advanced (C1-C2)</option>
                </select>
            </div>

            <div class="text-center mb-4">
                <button class="btn btn-primary" id="writing-get-prompt-btn">
                    <i class="fas fa-lightbulb"></i> Lấy đề bài
                </button>
            </div>

            <!-- Writing Prompt Display -->
            <div id="writing-prompt-container" style="display: none;" class="mb-4">
                <div class="alert alert-info">
                    <h4><i class="fas fa-tasks"></i> Đề bài</h4>
                    <div id="writing-prompt-text"></div>
                </div>
            </div>

            <!-- Writing Area -->
            <div class="form-group">
                <label class="form-label">Viết bài của bạn:</label>
                <textarea id="writing-text-area" class="form-control" rows="15" placeholder="Bắt đầu viết tại đây..."></textarea>
                <small class="text-muted">Số từ: <span id="writing-word-count">0</span></small>
            </div>

            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-success btn-lg" id="writing-submit-btn">
                    <i class="fas fa-check"></i> Kiểm tra bài viết
                </button>
                <button class="btn btn-outline" id="writing-clear-btn">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </div>

            <!-- Results -->
            <div id="writing-results" class="mt-4" style="display: none;"></div>
        </div>
    </div>
</section>

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
    const submitBtn = document.getElementById('writing-submit-btn');
    const clearBtn = document.getElementById('writing-clear-btn');

    // Word count
    textArea?.addEventListener('input', () => {
        const words = textArea.value.trim().split(/\s+/).filter(w => w.length > 0);
        wordCountSpan.textContent = words.length;
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
                displayWritingPrompt(result.data.prompt);
                Utils.showToast('Đã tạo đề bài!', 'success');
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
            Utils.showToast('Vui lòng viết ít nhất 50 ký tự', 'warning');
            return;
        }

        const mode = modeSelect.value;
        const level = levelSelect.value;

        Utils.showLoading('Đang phân tích bài viết...');

        try {
            const result = await Utils.apiRequest('writing_api.php', {
                action: 'check',
                text: text,
                mode: mode,
                level: level
            });

            if (result.success) {
                displayWritingResults(result.data);
                Utils.showToast('Đã phân tích xong!', 'success');
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
        if (confirm('Bạn có chắc muốn xóa bài viết?')) {
            textArea.value = '';
            wordCountSpan.textContent = '0';
            document.getElementById('writing-results').style.display = 'none';
        }
    });

    function displayWritingPrompt(prompt) {
        const container = document.getElementById('writing-prompt-container');
        const textDiv = document.getElementById('writing-prompt-text');
        
        textDiv.innerHTML = prompt.replace(/\n/g, '<br>');
        container.style.display = 'block';
    }

    function displayWritingResults(data) {
        const resultsDiv = document.getElementById('writing-results');
        resultsDiv.style.display = 'block';

        let html = '<div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">';
        html += '<h3 class="mb-3"><i class="fas fa-chart-line"></i> Đánh giá tổng quan</h3>';
        html += '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">';
        
        if (data.overall_score) {
            html += `<div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.1); border-radius: var(--border-radius);">
                <div style="font-size: 2rem; font-weight: bold;">${data.overall_score}/10</div>
                <div>Điểm tổng</div>
            </div>`;
        }
        
        if (data.scores) {
            Object.keys(data.scores).forEach(key => {
                const label = {
                    grammar: 'Ngữ pháp',
                    vocabulary: 'Từ vựng',
                    coherence: 'Mạch lạc',
                    task_achievement: 'Hoàn thành'
                }[key] || key;
                
                html += `<div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.1); border-radius: var(--border-radius);">
                    <div style="font-size: 1.5rem; font-weight: bold;">${data.scores[key]}/10</div>
                    <div>${label}</div>
                </div>`;
            });
        }
        
        html += '</div></div>';

        // Grammar errors
        if (data.grammar_errors && data.grammar_errors.length > 0) {
            html += '<div class="ai-card mt-3">';
            html += '<h4 class="mb-3"><i class="fas fa-exclamation-triangle" style="color: var(--warning-color);"></i> Lỗi ngữ pháp</h4>';
            data.grammar_errors.forEach((error, i) => {
                html += `<div class="mb-3 p-3" style="background: var(--bg-secondary); border-radius: var(--border-radius-sm); border-left: 4px solid var(--warning-color);">
                    <div><strong>Lỗi ${i+1}:</strong> ${error.type || 'Grammar error'}</div>
                    <div style="color: var(--error-color); margin: 0.5rem 0;">❌ ${error.original}</div>
                    <div style="color: var(--success-color); margin: 0.5rem 0;">✓ ${error.correction}</div>
                    <div style="color: var(--text-secondary); font-size: 0.9rem;">${error.explanation}</div>
                </div>`;
            });
            html += '</div>';
        }

        // Vocabulary suggestions
        if (data.vocabulary_suggestions && data.vocabulary_suggestions.length > 0) {
            html += '<div class="ai-card mt-3">';
            html += '<h4 class="mb-3"><i class="fas fa-book" style="color: var(--info-color);"></i> Gợi ý từ vựng</h4>';
            data.vocabulary_suggestions.forEach((sug, i) => {
                html += `<div class="mb-2 p-2" style="background: var(--bg-secondary); border-radius: var(--border-radius-sm);">
                    <strong>${sug.original}</strong> → <strong style="color: var(--primary-color);">${sug.suggestion}</strong>
                    ${sug.explanation ? `<br><small style="color: var(--text-secondary);">${sug.explanation}</small>` : ''}
                </div>`;
            });
            html += '</div>';
        }

        // Overall feedback
        if (data.feedback) {
            html += '<div class="ai-card mt-3">';
            html += '<h4 class="mb-3"><i class="fas fa-comments"></i> Nhận xét</h4>';
            html += `<div style="line-height: 1.8;">${data.feedback.replace(/\n/g, '<br>')}</div>`;
            html += '</div>';
        }

        // Strengths and improvements
        if (data.strengths || data.improvements) {
            html += '<div class="ai-card mt-3">';
            html += '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">';
            
            if (data.strengths) {
                html += '<div>';
                html += '<h4 class="mb-2" style="color: var(--success-color);"><i class="fas fa-check-circle"></i> Điểm mạnh</h4>';
                html += '<ul style="line-height: 1.8;">';
                data.strengths.forEach(s => {
                    html += `<li>${s}</li>`;
                });
                html += '</ul></div>';
            }
            
            if (data.improvements) {
                html += '<div>';
                html += '<h4 class="mb-2" style="color: var(--warning-color);"><i class="fas fa-arrow-up"></i> Cần cải thiện</h4>';
                html += '<ul style="line-height: 1.8;">';
                data.improvements.forEach(i => {
                    html += `<li>${i}</li>`;
                });
                html += '</ul></div>';
            }
            
            html += '</div></div>';
        }

        resultsDiv.innerHTML = html;

        // Scroll to results
        resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        // Update progress
        if (data.overall_score) {
            window.progressTracker?.updateProgress('writing', {
                completed: window.progressTracker.getProgress('writing').completed + 1,
                total: window.progressTracker.getProgress('writing').total + 1,
                score: data.overall_score
            });
        }
    }
}
</script>
