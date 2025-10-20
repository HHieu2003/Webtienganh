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

            <!-- Hướng dẫn quan trọng -->
            <div class="alert" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-weight: bold;">
                    <i class="fas fa-exclamation-triangle"></i> QUAN TRỌNG - ĐỌC KỸ TRƯỚC KHI BẮT ĐẦU!
                </h4>
                <div style="background: rgba(255,255,255,0.15); padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                    <p style="margin: 0; font-size: 1.1rem; line-height: 1.8;">
                        <strong>⚠️ Vấn đề "no-speech" (không nghe thấy giọng nói):</strong>
                    </p>
                    <ul style="margin: 10px 0 0 20px; line-height: 1.8;">
                        <li>🎤 Hãy <strong>NÓI NGAY</strong> khi thấy thông báo "🔴 Đang ghi âm..."</li>
                        <li>📢 Nói <strong>RÕ RÀNG và ĐỦ TO</strong> (không cần hét!)</li>
                        <li>⏱️ Đừng đợi lâu - hãy nói trong vòng <strong>2 giây đầu</strong></li>
                        <li>🔊 Kiểm tra microphone có bật và không bị tắt tiếng</li>
                        <li>✅ Nhấn <strong>"Test Microphone"</strong> trước để chắc chắn</li>
                    </ul>
                </div>
                <p style="margin: 10px 0 0 0; font-size: 0.95rem;">
                    💡 <strong>Tip:</strong> Chuẩn bị sẵn câu trả lời trong đầu TRƯỚC KHI nhấn nút ghi âm!
                </p>
            </div>

            <!-- Microphone Status Display -->
            <div id="mic-status-display" style="background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px; text-align: center; display: none;">
                <div style="font-size: 1.1rem; margin-bottom: 10px;">
                    <strong>📊 Trạng thái Microphone:</strong>
                </div>
                <div id="mic-status-content" style="font-size: 1rem; line-height: 1.8;"></div>
            </div>

            <div class="text-center mb-4">
                <button class="btn btn-primary btn-lg" id="speaking-start-btn">
                    <i class="fas fa-play"></i> Bắt đầu luyện nói
                </button>
                <button class="btn btn-outline btn-sm" id="speaking-test-mic-btn" style="margin-left: 10px;">
                    <i class="fas fa-volume-up"></i> Test Microphone
                </button>
                <button class="btn btn-outline btn-sm" id="speaking-check-mic-btn" style="margin-left: 10px;">
                    <i class="fas fa-info-circle"></i> Kiểm tra Mic
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
        console.log('Record button clicked');
        
        // Check if speechRecognition is available
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
        
        // Hiển thị hướng dẫn TRƯỚC KHI bắt đầu
        Utils.showToast('📌 SẴN SÀNG!\n\nSau 2 giây sẽ bắt đầu ghi âm.\nHãy NÓI NGAY khi thấy "🔴 Đang ghi âm..."', 'info', 2000);
        
        // Đợi 2 giây
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        recordBtn.style.display = 'none';
        stopBtn.style.display = 'inline-flex';
        document.getElementById('speaking-recording-status').style.display = 'block';
        
        // Hiển thị thông báo BẮT ĐẦU GHI ÂM
        Utils.showToast('🔴 Đang ghi âm... HÃY NÓI NGAY! Bạn có 60 giây.', 'warning', 60000);

        try {
            recordedTranscript = await window.speechRecognition.startRecording();
            console.log('Recording completed:', recordedTranscript);
            
            stopBtn.style.display = 'none';
            recordBtn.style.display = 'inline-flex';
            document.getElementById('speaking-recording-status').style.display = 'none';
            
            if (recordedTranscript && recordedTranscript.trim().length > 0) {
                displayTranscription(recordedTranscript);
                Utils.showToast('Đã ghi âm xong! (' + recordedTranscript.split(' ').length + ' từ)', 'success');
            } else {
                Utils.showToast('Không phát hiện giọng nói. Vui lòng thử lại.', 'warning');
            }
        } catch (error) {
            console.error('Recording error:', error);
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
