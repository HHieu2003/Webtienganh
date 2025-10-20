<!-- SPEAKING SECTION -->
<section id="speaking-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-microphone"></i>
                Luyện Nói (Speaking)
            </h2>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Rèn luyện kỹ năng nói tiếng Anh với các chủ đề đa dạng và phản hồi từ AI.</p>
            
            <div class="form-group">
                <label class="form-label">Chọn chủ đề:</label>
                <select id="speaking-topic" class="form-control">
                    <option value="self-introduction">Self Introduction (Giới thiệu bản thân)</option>
                    <option value="daily-routine">Daily Routine (Hoạt động hàng ngày)</option>
                    <option value="hobbies">Hobbies & Interests (Sở thích)</option>
                    <option value="travel">Travel & Tourism (Du lịch)</option>
                    <option value="food">Food & Cuisine (Ẩm thực)</option>
                    <option value="technology">Technology (Công nghệ)</option>
                    <option value="education">Education (Giáo dục)</option>
                    <option value="work">Work & Career (Công việc)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Cấp độ:</label>
                <select id="speaking-level" class="form-control">
                    <option value="beginner">Beginner (A1-A2)</option>
                    <option value="intermediate" selected>Intermediate (B1-B2)</option>
                    <option value="advanced">Advanced (C1-C2)</option>
                </select>
            </div>

            <div class="text-center mb-4">
                <button class="btn btn-primary btn-lg" id="speaking-start-btn">
                    <i class="fas fa-play"></i> Bắt đầu luyện nói
                </button>
            </div>

            <!-- Speaking Exercise Container -->
            <div id="speaking-exercise-container" style="display: none;">
                <div class="alert alert-info">
                    <i class="fas fa-microphone"></i>
                    <span id="speaking-instruction"></span>
                </div>

                <!-- Question Display -->
                <div class="ai-card mb-3" style="background: var(--bg-secondary);">
                    <h3 class="mb-2">Câu hỏi:</h3>
                    <div id="speaking-question" style="font-size: 1.2rem; line-height: 1.8;"></div>
                </div>

                <!-- Recording Controls -->
                <div class="text-center mb-4">
                    <button class="btn btn-danger btn-lg" id="speaking-record-btn">
                        <i class="fas fa-microphone"></i> Bắt đầu ghi âm
                    </button>
                    <button class="btn btn-warning btn-lg" id="speaking-stop-btn" style="display: none;">
                        <i class="fas fa-stop"></i> Dừng ghi âm
                    </button>
                    <div id="speaking-recording-status" class="mt-2" style="display: none;">
                        <span class="loading-spinner"></span>
                        <span>Đang ghi âm...</span>
                    </div>
                </div>

                <!-- Transcription Display -->
                <div id="speaking-transcription-container" style="display: none;" class="mb-4">
                    <div class="ai-card">
                        <h4 class="mb-2">Bản ghi của bạn:</h4>
                        <div id="speaking-transcription" style="padding: 1rem; background: white; border-radius: var(--border-radius-sm); line-height: 1.8;"></div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-success" id="speaking-analyze-btn">
                            <i class="fas fa-chart-line"></i> Phân tích câu trả lời
                        </button>
                        <button class="btn btn-outline" id="speaking-retry-btn">
                            <i class="fas fa-redo"></i> Ghi lại
                        </button>
                    </div>
                </div>

                <!-- Results -->
                <div id="speaking-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'speaking') {
        initSpeakingSection();
    }
});

function initSpeakingSection() {
    const startBtn = document.getElementById('speaking-start-btn');
    const recordBtn = document.getElementById('speaking-record-btn');
    const stopBtn = document.getElementById('speaking-stop-btn');
    const analyzeBtn = document.getElementById('speaking-analyze-btn');
    const retryBtn = document.getElementById('speaking-retry-btn');
    
    let currentQuestion = null;
    let recordedTranscript = '';

    startBtn?.addEventListener('click', async () => {
        const topic = document.getElementById('speaking-topic').value;
        const level = document.getElementById('speaking-level').value;

        Utils.showLoading('Đang chuẩn bị câu hỏi...');

        try {
            const result = await Utils.apiRequest('speaking_api.php', {
                action: 'get_question',
                topic: topic,
                level: level
            });

            if (result.success) {
                currentQuestion = result.data;
                displaySpeakingQuestion(currentQuestion);
                Utils.showToast('Hãy bắt đầu trả lời!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo câu hỏi', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    recordBtn?.addEventListener('click', async () => {
        if (!window.speechRecognition.isSupported()) {
            Utils.showToast('Trình duyệt không hỗ trợ nhận dạng giọng nói. Vui lòng dùng Chrome/Edge.', 'warning');
            return;
        }

        recordBtn.style.display = 'none';
        stopBtn.style.display = 'inline-flex';
        document.getElementById('speaking-recording-status').style.display = 'block';

        try {
            recordedTranscript = await window.speechRecognition.startRecording();
            
            stopBtn.style.display = 'none';
            recordBtn.style.display = 'inline-flex';
            document.getElementById('speaking-recording-status').style.display = 'none';
            
            displayTranscription(recordedTranscript);
            Utils.showToast('Đã ghi âm xong!', 'success');
        } catch (error) {
            Utils.showToast('Lỗi ghi âm: ' + error.message, 'error');
            stopBtn.style.display = 'none';
            recordBtn.style.display = 'inline-flex';
            document.getElementById('speaking-recording-status').style.display = 'none';
        }
    });

    stopBtn?.addEventListener('click', () => {
        window.speechRecognition.stopRecording();
    });

    analyzeBtn?.addEventListener('click', async () => {
        if (!recordedTranscript || !currentQuestion) return;

        Utils.showLoading('Đang phân tích...');

        try {
            const result = await Utils.apiRequest('speaking_api.php', {
                action: 'analyze',
                question: currentQuestion.question,
                answer: recordedTranscript
            });

            if (result.success) {
                displaySpeakingResults(result.data);
                Utils.showToast('Đã phân tích xong!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể phân tích', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    retryBtn?.addEventListener('click', () => {
        document.getElementById('speaking-transcription-container').style.display = 'none';
        document.getElementById('speaking-results').style.display = 'none';
        recordedTranscript = '';
    });

    function displaySpeakingQuestion(data) {
        document.getElementById('speaking-exercise-container').style.display = 'block';
        document.getElementById('speaking-instruction').textContent = data.instruction || 'Trả lời câu hỏi bằng tiếng Anh. Nhấn nút ghi âm để bắt đầu.';
        document.getElementById('speaking-question').textContent = data.question;
        document.getElementById('speaking-transcription-container').style.display = 'none';
        document.getElementById('speaking-results').style.display = 'none';
    }

    function displayTranscription(text) {
        document.getElementById('speaking-transcription').textContent = text;
        document.getElementById('speaking-transcription-container').style.display = 'block';
    }

    function displaySpeakingResults(data) {
        const resultsDiv = document.getElementById('speaking-results');
        resultsDiv.style.display = 'block';

        let html = '<div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">';
        html += '<h3 class="mb-3"><i class="fas fa-star"></i> Đánh giá</h3>';
        html += '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">';
        
        if (data.scores) {
            Object.keys(data.scores).forEach(key => {
                const labels = {
                    fluency: 'Lưu loát',
                    pronunciation: 'Phát âm',
                    grammar: 'Ngữ pháp',
                    vocabulary: 'Từ vựng',
                    relevance: 'Phù hợp'
                };
                html += `<div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.1); border-radius: var(--border-radius);">
                    <div style="font-size: 1.5rem; font-weight: bold;">${data.scores[key]}/10</div>
                    <div>${labels[key] || key}</div>
                </div>`;
            });
        }
        
        html += '</div></div>';

        if (data.feedback) {
            html += `<div class="ai-card mt-3">
                <h4 class="mb-3"><i class="fas fa-comments"></i> Nhận xét</h4>
                <div style="line-height: 1.8;">${data.feedback.replace(/\n/g, '<br>')}</div>
            </div>`;
        }

        if (data.suggestions && data.suggestions.length > 0) {
            html += '<div class="ai-card mt-3"><h4 class="mb-3"><i class="fas fa-lightbulb"></i> Gợi ý cải thiện</h4><ul style="line-height: 1.8;">';
            data.suggestions.forEach(s => {
                html += `<li>${s}</li>`;
            });
            html += '</ul></div>';
        }

        resultsDiv.innerHTML = html;
        resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}
</script>
