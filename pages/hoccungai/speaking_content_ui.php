<!-- SPEAKING SECTION -->
<section id="speaking-section" class="skill-content-section">
    <div class="speaking-main-card">
        <div class="speaking-header">
            <div class="speaking-icon-wrapper">
                <i class="fas fa-microphone"></i>
            </div>
            <h2 class="speaking-title">Luyện Nói (Speaking)</h2>
            <p class="speaking-subtitle">Rèn luyện kỹ năng nói tiếng Anh với phản hồi chi tiết từ AI</p>
        </div>

        <!-- Settings Panel -->
        <div class="speaking-settings-panel">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Chọn cấp độ
                    </label>
                    <select id="speaking-level" class="form-select">
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
                            <option value="ielts_5">IELTS 5.0-6.0</option>
                            <option value="ielts_7">IELTS 7.0-8.0</option>
                            <option value="business">Business English</option>
                            <option value="academic">Academic English</option>
                        </optgroup>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-bookmark"></i> Chọn chủ đề
                    </label>
                    <select id="speaking-topic" class="form-select">
                        <option value="self-introduction">🙋 Self Introduction</option>
                        <option value="daily-routine">🌅 Daily Routine</option>
                        <option value="hobbies">🎨 Hobbies & Interests</option>
                        <option value="travel">✈️ Travel & Tourism</option>
                        <option value="food">🍔 Food & Cuisine</option>
                        <option value="technology">💻 Technology</option>
                        <option value="education">📚 Education</option>
                        <option value="work">💼 Work & Career</option>
                        <option value="environment">🌍 Environment</option>
                        <option value="health">💪 Health & Fitness</option>
                        <option value="entertainment">🎬 Entertainment</option>
                        <option value="family">👨‍👩‍👧 Family & Relationships</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-question-circle"></i> Loại câu hỏi
                    </label>
                    <select id="speaking-question-type" class="form-select">
                        <option value="general">Câu hỏi chung</option>
                        <option value="describe">Mô tả chi tiết</option>
                        <option value="opinion">Ý kiến cá nhân</option>
                        <option value="experience">Trải nghiệm</option>
                        <option value="compare">So sánh</option>
                        <option value="future">Tương lai/Giả định</option>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="speaking-generate-btn" id="speaking-start-btn">
                    <i class="fas fa-play-circle"></i>
                    Bắt đầu luyện nói
                </button>
            </div>
        </div>

        <!-- Microphone Test Section -->
        <div class="speaking-mic-test-panel">
            <div class="alert alert-info mb-3">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle" style="font-size: 1.5rem; margin-right: 1rem; color: #667eea;"></i>
                    <div style="flex: 1;">
                        <h5 class="mb-2" style="color: #667eea; font-weight: 700;">📢 Hướng dẫn quan trọng</h5>
                        <ul style="margin: 0; padding-left: 1.2rem; line-height: 1.8;">
                            <li><strong>Nói ngay</strong> khi thấy "🔴 Đang ghi âm..." (trong vòng 2 giây đầu)</li>
                            <li><strong>Nói rõ ràng</strong> và đủ to (không cần hét, nói bình thường)</li>
                            <li><strong>Kiểm tra mic</strong> trước khi bắt đầu bằng nút "Test Microphone"</li>
                            <li><strong>Chuẩn bị sẵn</strong> câu trả lời trong đầu trước khi ghi âm</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-outline-primary me-2" id="speaking-test-mic-btn">
                    <i class="fas fa-volume-up"></i> Test Microphone
                </button>
                <button class="btn btn-outline-secondary" id="speaking-check-mic-btn">
                    <i class="fas fa-info-circle"></i> Kiểm tra chi tiết
                </button>
            </div>

            <!-- Microphone Status Display -->
            <div id="mic-status-display" class="mt-3" style="background: #f8f9fa; border-radius: 12px; padding: 1.25rem; display: none;">
                <h5 class="mb-3" style="color: #667eea; font-weight: 700;">
                    <i class="fas fa-microphone-alt"></i> Trạng thái Microphone
                </h5>
                <div id="mic-status-content" style="font-size: 0.95rem; line-height: 1.8;"></div>
            </div>
        </div>

        <!-- Speaking Exercise Container -->
        <div id="speaking-exercise-container" style="display: none;">
            <!-- Question Card -->
            <div class="speaking-question-card">
                <div class="question-card-header">
                    <i class="fas fa-comment-dots"></i>
                    <span id="speaking-instruction">Hãy trả lời câu hỏi sau trong 1-2 phút</span>
                </div>
                <div class="question-card-body">
                    <div id="speaking-question"></div>
                </div>
                <div id="speaking-tips-container" class="question-tips" style="display: none;">
                    <h5><i class="fas fa-lightbulb"></i> Gợi ý trả lời:</h5>
                    <ul id="speaking-tips-list"></ul>
                </div>
            </div>

            <!-- Recording Controls Card -->
            <div class="speaking-recording-card">
                <div class="recording-controls">
                    <button class="btn-recording-main" id="speaking-record-btn">
                        <div class="recording-icon">
                            <i class="fas fa-microphone"></i>
                        </div>
                        <span>Bắt đầu ghi âm</span>
                    </button>
                    <button class="btn-recording-stop" id="speaking-stop-btn" style="display: none;">
                        <div class="recording-icon pulsing">
                            <i class="fas fa-stop"></i>
                        </div>
                        <span>Dừng ghi âm</span>
                    </button>
                </div>
                
                <div id="speaking-recording-status" class="recording-status" style="display: none;">
                    <div class="recording-indicator">
                        <div class="recording-pulse"></div>
                        <i class="fas fa-microphone"></i>
                    </div>
                    <div class="recording-text">
                        <strong>Đang ghi âm...</strong>
                        <div class="recording-timer" id="recording-timer">0:00</div>
                    </div>
                </div>
            </div>

            <!-- Transcription Card -->
            <div id="speaking-transcription-container" class="speaking-transcription-card" style="display: none;">
                <div class="transcription-header">
                    <i class="fas fa-file-alt"></i>
                    <span>Bản ghi âm của bạn</span>
                    <div class="transcription-stats">
                        <span id="word-count-display"></span>
                        <span id="sentence-count-display"></span>
                    </div>
                </div>
                <div class="transcription-body">
                    <div id="speaking-transcription"></div>
                </div>
                <div class="transcription-actions">
                    <button class="btn-transcription-action btn-analyze" id="speaking-analyze-btn">
                        <i class="fas fa-chart-line"></i>
                        <span>Phân tích câu trả lời</span>
                    </button>
                    <button class="btn-transcription-action btn-retry" id="speaking-retry-btn">
                        <i class="fas fa-redo"></i>
                        <span>Ghi lại</span>
                    </button>
                </div>
            </div>

            <!-- Results Container -->
            <div id="speaking-results" class="mt-4" style="display: none;"></div>
        </div>
    </div>
</section>

<style>
/* Speaking Section Styles */
.speaking-main-card {
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    border: 2px solid #667eea30;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
}

.speaking-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.speaking-icon-wrapper {
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

.speaking-icon-wrapper i {
    font-size: 2.5rem;
    color: white;
}

.speaking-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.speaking-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    margin: 0;
}

.speaking-settings-panel {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.speaking-settings-panel .form-label {
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.speaking-settings-panel .form-label i {
    color: #667eea;
}

.speaking-settings-panel .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.speaking-settings-panel .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.speaking-generate-btn {
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

.speaking-generate-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
}

.speaking-generate-btn i {
    font-size: 1.3rem;
}

.speaking-mic-test-panel {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

/* Question Card */
.speaking-question-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
    border: 2px solid #667eea20;
}

.question-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.05rem;
    font-weight: 600;
}

.question-card-header i {
    font-size: 1.3rem;
}

.question-card-body {
    padding: 2rem;
}

.question-card-body #speaking-question {
    font-size: 1.3rem;
    line-height: 1.8;
    color: #1e293b;
    font-weight: 600;
}

.question-tips {
    padding: 1.5rem;
    background: #f8fafc;
    border-top: 2px dashed #e2e8f0;
}

.question-tips h5 {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.question-tips ul {
    margin: 0;
    padding-left: 1.5rem;
    line-height: 1.8;
}

.question-tips li {
    margin-bottom: 0.5rem;
    color: #475569;
}

/* Recording Card */
.speaking-recording-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.recording-controls {
    text-align: center;
}

.btn-recording-main,
.btn-recording-stop {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    padding: 1.5rem 3rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 1rem;
}

.btn-recording-main {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.btn-recording-stop {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
}

.btn-recording-main:hover,
.btn-recording-stop:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(239, 68, 68, 0.5);
}

.recording-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.recording-icon i {
    font-size: 1.5rem;
}

.recording-icon.pulsing {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.recording-status {
    margin-top: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 12px;
}

.recording-indicator {
    position: relative;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.recording-pulse {
    position: absolute;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #ef4444;
    opacity: 0.3;
    animation: pulse-expand 1.5s ease-out infinite;
}

@keyframes pulse-expand {
    0% { transform: scale(0.8); opacity: 0.5; }
    100% { transform: scale(1.5); opacity: 0; }
}

.recording-indicator i {
    position: relative;
    z-index: 1;
    font-size: 1.8rem;
    color: #ef4444;
}

.recording-text {
    text-align: left;
}

.recording-text strong {
    display: block;
    font-size: 1.2rem;
    color: #92400e;
    margin-bottom: 0.25rem;
}

.recording-timer {
    font-size: 1.5rem;
    font-weight: 700;
    color: #b45309;
    font-family: 'Courier New', monospace;
}

/* Transcription Card */
.speaking-transcription-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
    border: 2px solid #10b98120;
}

.transcription-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.05rem;
    font-weight: 600;
}

.transcription-header i {
    font-size: 1.3rem;
}

.transcription-stats {
    margin-left: auto;
    display: flex;
    gap: 1rem;
    font-size: 0.9rem;
}

.transcription-stats span {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
}

.transcription-body {
    padding: 2rem;
}

.transcription-body #speaking-transcription {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #334155;
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #10b981;
}

.transcription-actions {
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
    background: #f8fafc;
    border-top: 2px dashed #e2e8f0;
}

.btn-transcription-action {
    padding: 0.875rem 2rem;
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

.btn-analyze {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.btn-analyze:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(16, 185, 129, 0.4);
}

.btn-retry {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.btn-retry:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}

/* Results Card */
.speaking-results-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
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

.score-value {
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
}

.results-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.results-section li {
    padding: 0.75rem 1rem;
    margin-bottom: 0.5rem;
    background: #f8fafc;
    border-left: 4px solid #667eea;
    border-radius: 8px;
    line-height: 1.6;
}

.results-section li.strength {
    border-left-color: #10b981;
    background: #ecfdf5;
}

.results-section li.improvement {
    border-left-color: #f59e0b;
    background: #fffbeb;
}

/* Responsive Design */
@media (max-width: 768px) {
    .speaking-main-card {
        padding: 1.5rem;
    }
    
    .speaking-title {
        font-size: 1.8rem;
    }
    
    .speaking-generate-btn {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }
    
    .question-card-body #speaking-question {
        font-size: 1.1rem;
    }
    
    .btn-recording-main,
    .btn-recording-stop {
        padding: 1.25rem 2rem;
        font-size: 1rem;
    }
    
    .transcription-actions {
        flex-direction: column;
    }
    
    .results-score-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'speaking') {
        console.log('Initializing Speaking Section...');
        console.log('Speech Recognition available:', !!window.speechRecognition);
        console.log('Speech Recognition supported:', window.speechRecognition?.isSupported());
        initSpeakingSection();
    }
});

function initSpeakingSection() {
    const startBtn = document.getElementById('speaking-start-btn');
    const testMicBtn = document.getElementById('speaking-test-mic-btn');
    const checkMicBtn = document.getElementById('speaking-check-mic-btn');
    const recordBtn = document.getElementById('speaking-record-btn');
    const stopBtn = document.getElementById('speaking-stop-btn');
    const analyzeBtn = document.getElementById('speaking-analyze-btn');
    const retryBtn = document.getElementById('speaking-retry-btn');
    const micStatusDisplay = document.getElementById('mic-status-display');
    const micStatusContent = document.getElementById('mic-status-content');
    
    let currentQuestion = null;
    let recordedTranscript = '';

    // Check Microphone button - Kiểm tra chi tiết
    checkMicBtn?.addEventListener('click', async () => {
        console.log('Checking microphone status...');
        
        micStatusDisplay.style.display = 'block';
        micStatusContent.innerHTML = '⏳ Đang kiểm tra...';
        
        let status = [];
        
        // 1. Check Speech Recognition support
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            status.push('✅ Speech Recognition: Supported');
        } else {
            status.push('❌ Speech Recognition: NOT Supported');
            status.push('⚠️ Vui lòng dùng Chrome hoặc Edge!');
            micStatusContent.innerHTML = status.join('<br>');
            return;
        }
        
        // 2. Check MediaDevices support
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            status.push('✅ MediaDevices API: Supported');
        } else {
            status.push('❌ MediaDevices API: NOT Supported');
            micStatusContent.innerHTML = status.join('<br>');
            return;
        }
        
        // 3. Try to get microphone access
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            status.push('✅ Microphone Access: Granted');
            
            // 4. Get microphone info
            const audioTracks = stream.getAudioTracks();
            if (audioTracks.length > 0) {
                const track = audioTracks[0];
                status.push('✅ Microphone Device: ' + track.label);
                status.push('📊 Status: ' + (track.enabled ? 'Enabled' : 'Disabled'));
                status.push('🔊 Ready State: ' + track.readyState);
            }
            
            // 5. List all available microphones
            const devices = await navigator.mediaDevices.enumerateDevices();
            const audioInputs = devices.filter(d => d.kind === 'audioinput');
            
            if (audioInputs.length > 0) {
                status.push('<br><strong>🎤 Microphones phát hiện được:</strong>');
                audioInputs.forEach((device, index) => {
                    const label = device.label || `Microphone ${index + 1}`;
                    status.push(`${index + 1}. ${label}`);
                });
            } else {
                status.push('⚠️ Không tìm thấy microphone nào!');
            }
            
            // Clean up
            stream.getTracks().forEach(track => track.stop());
            
            status.push('<br>✅ <strong>Microphone sẵn sàng sử dụng!</strong>');
            status.push('💡 Bây giờ hãy nhấn "Test Microphone" để test thử');
            
        } catch (error) {
            status.push('❌ Microphone Access: DENIED');
            
            if (error.name === 'NotAllowedError') {
                status.push('⚠️ Lý do: Quyền truy cập bị từ chối');
                status.push('<br><strong>🔧 Cách sửa:</strong>');
                status.push('1. Click biểu tượng 🔒 trên thanh địa chỉ');
                status.push('2. Chọn "Cho phép" cho Microphone');
                status.push('3. Tải lại trang (F5)');
            } else if (error.name === 'NotFoundError') {
                status.push('⚠️ Lý do: Không tìm thấy microphone');
                status.push('<br><strong>🔧 Cách sửa:</strong>');
                status.push('1. Kiểm tra mic có cắm vào máy không');
                status.push('2. Bật mic trong Windows Settings');
                status.push('3. Cài driver mic nếu cần');
            } else {
                status.push('⚠️ Lỗi: ' + error.message);
            }
        }
        
        micStatusContent.innerHTML = status.join('<br>');
    });

    // Test Microphone button với audio level checking
    testMicBtn?.addEventListener('click', async () => {
        console.log('Testing microphone...');
        
        if (!window.speechRecognition) {
            Utils.showToast('❌ Speech Recognition chưa được khởi tạo', 'error');
            return;
        }
        
        if (!window.speechRecognition.isSupported()) {
            Utils.showToast('❌ Trình duyệt không hỗ trợ Speech Recognition', 'error');
            return;
        }
        
        // BƯỚC 1: Test audio input stream trước
        Utils.showToast('🔍 Kiểm tra microphone...', 'info', 3000);
        
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            console.log('✅ Microphone access granted');
            
            // Tạo audio context để đo volume
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const analyser = audioContext.createAnalyser();
            const microphone = audioContext.createMediaStreamSource(stream);
            const dataArray = new Uint8Array(analyser.frequencyBinCount);
            
            microphone.connect(analyser);
            analyser.fftSize = 256;
            
            // Đo volume trong 3 giây
            let maxVolume = 0;
            const checkVolume = () => {
                analyser.getByteFrequencyData(dataArray);
                const volume = Math.max(...dataArray);
                maxVolume = Math.max(maxVolume, volume);
            };
            
            Utils.showToast('🎤 Hãy nói "HELLO TEST" ngay bây giờ!\n\n📊 Đang đo âm lượng...', 'warning', 3000);
            
            const volumeInterval = setInterval(checkVolume, 100);
            
            await new Promise(resolve => setTimeout(resolve, 3000));
            
            clearInterval(volumeInterval);
            stream.getTracks().forEach(track => track.stop());
            audioContext.close();
            
            console.log('📊 Max volume detected:', maxVolume);
            
            if (maxVolume < 10) {
                Utils.showToast('❌ KHÔNG PHÁT HIỆN GIỌNG NÓI!\n\n' +
                    '📊 Volume: ' + maxVolume + '/255 (quá thấp!)\n\n' +
                    '🔧 Hãy kiểm tra:\n' +
                    '✓ Mic có bật không?\n' +
                    '✓ Mic đúng device không?\n' +
                    '✓ Volume >= 50% trong Windows?\n' +
                    '✓ Nói to hơn?', 'error', 10000);
                return;
            } else if (maxVolume < 30) {
                Utils.showToast('⚠️ Volume hơi thấp!\n\n' +
                    '� Volume: ' + maxVolume + '/255\n\n' +
                    '💡 Nên tăng volume hoặc nói to hơn', 'warning', 5000);
            } else {
                Utils.showToast('✅ Microphone OK!\n\n' +
                    '📊 Volume: ' + maxVolume + '/255\n\n' +
                    'Bây giờ test Speech Recognition...', 'success', 3000);
            }
            
            // BƯỚC 2: Test Speech Recognition
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            Utils.showToast('�🔴 Đang ghi âm... HÃY NÓI: "Hello test"', 'warning', 60000);
            
            const testTranscript = await window.speechRecognition.startRecording();
            Utils.showToast('✅ Hoàn hảo!\n\n📝 Nhận được: "' + testTranscript + '"', 'success', 5000);
            console.log('✅ Test successful:', testTranscript);
            
        } catch (error) {
            console.error('❌ Microphone test failed:', error);
            
            if (error.name === 'NotAllowedError') {
                Utils.showToast('❌ QUYỀN BỊ TỪ CHỐI!\n\n' +
                    '🔧 Cách sửa:\n' +
                    '1. Click biểu tượng 🔒 trên thanh địa chỉ\n' +
                    '2. Cho phép Microphone\n' +
                    '3. Tải lại trang (F5)', 'error', 10000);
            } else if (error.name === 'NotFoundError') {
                Utils.showToast('❌ KHÔNG TÌM THẤY MICROPHONE!\n\n' +
                    '🔧 Hãy kiểm tra:\n' +
                    '✓ Mic có cắm vào máy không?\n' +
                    '✓ Mic có bật trong Windows không?\n' +
                    '✓ Driver mic đã cài chưa?', 'error', 10000);
            } else {
                Utils.showToast('❌ ' + error.message, 'error', 8000);
            }
        }
    });

    startBtn?.addEventListener('click', async () => {
        const topic = document.getElementById('speaking-topic').value;
        const level = document.getElementById('speaking-level').value;
        const questionType = document.getElementById('speaking-question-type').value;

        Utils.showLoading('Đang chuẩn bị câu hỏi...');

        try {
            const result = await Utils.apiRequest('speaking_api.php', {
                action: 'get_question',
                topic: topic,
                level: level,
                question_type: questionType
            });

            if (result.success) {
                currentQuestion = result.data;
                displaySpeakingQuestion(currentQuestion);
                Utils.showToast('Câu hỏi đã sẵn sàng! Hãy bắt đầu trả lời.', 'success');
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
        console.log('Record button clicked');
        
        if (!window.speechRecognition) {
            console.error('speechRecognition object not found');
            Utils.showToast('Lỗi: Hệ thống nhận dạng giọng nói chưa được khởi tạo. Vui lòng tải lại trang.', 'error');
            return;
        }
        
        if (!window.speechRecognition.isSupported()) {
            console.warn('Speech recognition not supported');
            Utils.showToast('Trình duyệt không hỗ trợ nhận dạng giọng nói. Vui lòng dùng Chrome/Edge phiên bản mới nhất.', 'warning');
            return;
        }

        console.log('Starting recording...');
        
        Utils.showToast('📌 SẴN SÀNG!\n\nSau 2 giây sẽ bắt đầu ghi âm.\nHãy NÓI NGAY khi thấy "🔴 Đang ghi âm..."', 'info', 2000);
        
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        recordBtn.style.display = 'none';
        stopBtn.style.display = 'inline-flex';
        document.getElementById('speaking-recording-status').style.display = 'flex';
        
        // Start timer
        let seconds = 0;
        const timerElement = document.getElementById('recording-timer');
        const timerInterval = setInterval(() => {
            seconds++;
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            timerElement.textContent = `${mins}:${secs.toString().padStart(2, '0')}`;
        }, 1000);
        
        Utils.showToast('🔴 Đang ghi âm... HÃY NÓI NGAY! Bạn có 60 giây.', 'warning', 60000);

        try {
            recordedTranscript = await window.speechRecognition.startRecording();
            console.log('Recording completed:', recordedTranscript);
            
            clearInterval(timerInterval);
            stopBtn.style.display = 'none';
            recordBtn.style.display = 'inline-flex';
            document.getElementById('speaking-recording-status').style.display = 'none';
            
            if (recordedTranscript && recordedTranscript.trim().length > 0) {
                displayTranscription(recordedTranscript);
                const wordCount = recordedTranscript.split(/\s+/).length;
                Utils.showToast(`✅ Đã ghi âm xong!\n\n📊 ${wordCount} từ trong ${timerElement.textContent} phút`, 'success');
            } else {
                Utils.showToast('Không phát hiện giọng nói. Vui lòng thử lại.', 'warning');
            }
        } catch (error) {
            console.error('Recording error:', error);
            clearInterval(timerInterval);
            Utils.showToast(error.message || 'Lỗi ghi âm không xác định', 'error');
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

        Utils.showLoading('Đang phân tích câu trả lời của bạn...');

        try {
            const result = await Utils.apiRequest('speaking_api.php', {
                action: 'analyze',
                question: currentQuestion.question,
                answer: recordedTranscript,
                level: document.getElementById('speaking-level').value
            });

            if (result.success) {
                displaySpeakingResults(result.data);
                
                // Scroll to results
                setTimeout(() => {
                    document.getElementById('speaking-results').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 300);
                
                Utils.showToast('✅ Đã phân tích xong! Xem kết quả bên dưới.', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể phân tích câu trả lời', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    retryBtn?.addEventListener('click', () => {
        document.getElementById('speaking-transcription-container').style.display = 'none';
        document.getElementById('speaking-results').style.display = 'none';
        recordedTranscript = '';
        document.getElementById('recording-timer').textContent = '0:00';
    });

    function displaySpeakingQuestion(data) {
        document.getElementById('speaking-exercise-container').style.display = 'block';
        document.getElementById('speaking-instruction').textContent = data.instruction || 'Hãy trả lời câu hỏi sau trong 1-2 phút';
        document.getElementById('speaking-question').textContent = data.question;
        
        // Display tips if available
        const tipsContainer = document.getElementById('speaking-tips-container');
        const tipsList = document.getElementById('speaking-tips-list');
        
        if (data.tips && data.tips.length > 0) {
            tipsList.innerHTML = '';
            data.tips.forEach(tip => {
                const li = document.createElement('li');
                li.textContent = tip;
                tipsList.appendChild(li);
            });
            tipsContainer.style.display = 'block';
        } else {
            tipsContainer.style.display = 'none';
        }
        
        document.getElementById('speaking-transcription-container').style.display = 'none';
        document.getElementById('speaking-results').style.display = 'none';
        
        // Scroll to question
        setTimeout(() => {
            document.getElementById('speaking-exercise-container').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 300);
    }

    function displayTranscription(text) {
        const wordCount = text.split(/\s+/).filter(w => w.length > 0).length;
        const sentenceCount = (text.match(/[.!?]+/g) || []).length;
        
        document.getElementById('speaking-transcription').textContent = text;
        document.getElementById('word-count-display').textContent = `${wordCount} từ`;
        document.getElementById('sentence-count-display').textContent = `${sentenceCount} câu`;
        document.getElementById('speaking-transcription-container').style.display = 'block';
        
        // Scroll to transcription
        setTimeout(() => {
            document.getElementById('speaking-transcription-container').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 300);
    }

    function displaySpeakingResults(data) {
        const resultsDiv = document.getElementById('speaking-results');
        resultsDiv.style.display = 'block';

        const overallScore = data.overall_score || 7;
        const scores = data.scores || {};
        
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
        
        let html = '<div class="speaking-results-card">';
        
        // Header with overall score
        html += `<div class="results-header" style="background: linear-gradient(135deg, ${performanceColor} 0%, ${performanceColor}dd 100%);">`;
        html += `<div style="font-size: 4rem; margin-bottom: 0.75rem;">${performanceEmoji}</div>`;
        html += `<h3 style="margin: 0 0 1rem 0;">${performanceText}</h3>`;
        html += `<div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem;">${overallScore}/10</div>`;
        html += `<div style="font-size: 1.1rem; opacity: 0.95;">Điểm trung bình</div>`;
        
        if (data.word_count) {
            html += `<div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.3); font-size: 0.95rem;">`;
            html += `📝 ${data.word_count} từ`;
            if (data.sentence_count) {
                html += ` • ${data.sentence_count} câu`;
            }
            html += `</div>`;
        }
        html += `</div>`;
        
        // Score Grid
        const scoreLabels = {
            fluency: { label: 'Lưu loát', icon: '🗣️' },
            pronunciation: { label: 'Phát âm', icon: '🎤' },
            grammar: { label: 'Ngữ pháp', icon: '📖' },
            vocabulary: { label: 'Từ vựng', icon: '📚' },
            relevance: { label: 'Phù hợp', icon: '🎯' },
            content: { label: 'Nội dung', icon: '💡' }
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
            html += `<div class="score-value" style="color: ${scoreColor};">${score}/10</div>`;
            html += `<div class="score-label">${scoreInfo.label}</div>`;
            html += `</div>`;
        });
        html += '</div>';
        
        // Feedback
        if (data.feedback) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-comment-dots"></i> Nhận xét tổng quan</h4>';
            html += `<div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 1.25rem; border-radius: 8px; line-height: 1.8;">${data.feedback.replace(/\n/g, '<br>')}</div>`;
            html += '</div>';
        }
        
        // Strengths
        if (data.strengths && data.strengths.length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-star"></i> Điểm mạnh</h4>';
            html += '<ul>';
            data.strengths.forEach(s => {
                html += `<li class="strength"><strong>✓</strong> ${s}</li>`;
            });
            html += '</ul></div>';
        }
        
        // Improvements
        if (data.improvements && data.improvements.length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-exclamation-circle"></i> Cần cải thiện</h4>';
            html += '<ul>';
            data.improvements.forEach(i => {
                html += `<li class="improvement"><strong>!</strong> ${i}</li>`;
            });
            html += '</ul></div>';
        }
        
        // Suggestions
        if (data.suggestions && data.suggestions.length > 0) {
            html += '<div class="results-section">';
            html += '<h4><i class="fas fa-lightbulb"></i> Gợi ý cải thiện</h4>';
            html += '<ul>';
            data.suggestions.forEach(s => {
                html += `<li><strong>💡</strong> ${s}</li>`;
            });
            html += '</ul></div>';
        }
        
        // Overall comment
        if (data.overall_comment) {
            html += '<div class="results-section">';
            html += `<div style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border: 2px solid #667eea30; padding: 1.5rem; border-radius: 12px; text-align: center;">`;
            html += `<div style="font-size: 1.8rem; margin-bottom: 0.5rem;">💬</div>`;
            html += `<div style="font-size: 1.1rem; font-weight: 600; color: #667eea; line-height: 1.8;">${data.overall_comment}</div>`;
            html += `</div></div>`;
        }
        
        html += '</div>';
        
        resultsDiv.innerHTML = html;
    }
}
</script>
