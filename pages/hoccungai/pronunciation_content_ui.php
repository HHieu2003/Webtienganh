<!-- PRONUNCIATION SECTION -->
<section id="pronunciation-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-volume-up"></i>
                Luyện Phát Âm (Pronunciation)
            </h2>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Rèn luyện phát âm tiếng Anh chuẩn với sự hỗ trợ của AI.</p>
            
            <!-- Hướng dẫn -->
            <div class="alert" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; margin-bottom: 20px;">
                <h4 style="margin-bottom: 10px; font-weight: bold;">
                    <i class="fas fa-info-circle"></i> Cách sử dụng:
                </h4>
                <ol style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>Chọn chủ đề bạn muốn luyện</li>
                    <li>Nhấn "Bắt đầu luyện tập" để nhận từ/cụm từ</li>
                    <li>Nhấn "Nghe mẫu" để nghe phát âm chuẩn</li>
                    <li>Nhấn "Ghi âm của bạn" và phát âm từ đó</li>
                    <li>Nhấn "Kiểm tra phát âm" để nhận đánh giá từ AI</li>
                </ol>
                <p style="margin: 10px 0 0 0; font-size: 0.95rem;">
                    💡 <strong>Tip:</strong> Nghe mẫu vài lần trước khi ghi âm!
                </p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Chọn chủ đề:</label>
                <select id="pronunciation-focus" class="form-control">
                    <option value="vowels">Vowel Sounds (Nguyên âm)</option>
                    <option value="consonants">Consonant Sounds (Phụ âm)</option>
                    <option value="stress">Word Stress (Trọng âm từ)</option>
                    <option value="intonation">Intonation (Ngữ điệu)</option>
                    <option value="minimal-pairs">Minimal Pairs (Cặp âm tối thiểu)</option>
                </select>
            </div>

            <div class="text-center mb-4">
                <button class="btn btn-primary btn-lg" id="pronunciation-start-btn">
                    <i class="fas fa-play"></i> Bắt đầu luyện tập
                </button>
            </div>

            <div id="pronunciation-exercise-container" style="display: none;">
                <div class="ai-card mb-3" style="background: var(--bg-secondary);">
                    <h3 class="mb-2">Từ/Cụm từ cần luyện:</h3>
                    <div id="pronunciation-word" style="font-size: 2rem; font-weight: bold; color: var(--primary-color); text-align: center; margin: 1rem 0;"></div>
                    <div id="pronunciation-phonetic" style="font-size: 1.2rem; text-align: center; color: var(--text-secondary);"></div>
                </div>

                <div class="text-center mb-4">
                    <button class="btn btn-success btn-lg" id="pronunciation-listen-btn">
                        <i class="fas fa-play"></i> Nghe mẫu
                    </button>
                    <button class="btn btn-danger btn-lg" id="pronunciation-record-btn">
                        <i class="fas fa-microphone"></i> Ghi âm của bạn
                    </button>
                    <button class="btn btn-warning btn-lg" id="pronunciation-stop-record-btn" style="display: none;">
                        <i class="fas fa-stop"></i> Dừng
                    </button>
                </div>

                <div id="pronunciation-transcription" style="display: none;" class="mb-4">
                    <div class="ai-card">
                        <h4>Phát âm của bạn:</h4>
                        <div id="pronunciation-user-text" style="font-size: 1.2rem; padding: 1rem; background: white; border-radius: var(--border-radius-sm);"></div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-success" id="pronunciation-check-btn">
                            <i class="fas fa-check"></i> Kiểm tra phát âm
                        </button>
                    </div>
                </div>

                <div id="pronunciation-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<script>
console.log('📄 Pronunciation script loaded');

document.addEventListener('skillSectionInit', (e) => {
    console.log('🎯 skillSectionInit event received:', e.detail);
    if (e.detail.skill === 'pronunciation') {
        console.log('✅ Initializing Pronunciation Section...');
        initPronunciationSection();
    }
});

function initPronunciationSection() {
    console.log('Initializing Pronunciation Section...');
    
    const startBtn = document.getElementById('pronunciation-start-btn');
    const listenBtn = document.getElementById('pronunciation-listen-btn');
    const checkMicBtn = document.getElementById('pronunciation-check-mic-btn');
    const recordBtn = document.getElementById('pronunciation-record-btn');
    const stopRecordBtn = document.getElementById('pronunciation-stop-record-btn');
    const checkBtn = document.getElementById('pronunciation-check-btn');
    
    // Debug: Log button status
    console.log('Buttons found:', {
        startBtn: !!startBtn,
        listenBtn: !!listenBtn,
        recordBtn: !!recordBtn,
        stopRecordBtn: !!stopRecordBtn,
        checkBtn: !!checkBtn
    });
    
    if (!startBtn) {
        console.error('❌ Start button not found!');
        return;
    }
    
    let currentWord = null;
    let userTranscript = '';

    startBtn.addEventListener('click', async () => {
        const focus = document.getElementById('pronunciation-focus').value;
        console.log('🎯 Starting pronunciation exercise with focus:', focus);
        Utils.showLoading('Đang chuẩn bị...');

        try {
            console.log('📡 Calling API...');
            const result = await Utils.apiRequest('pronunciation_api.php', {
                action: 'get_word',
                focus: focus
            });

            console.log('✅ Get word result:', result);

            if (result.success) {
                currentWord = result.data;
                console.log('📝 Current word:', currentWord);
                displayPronunciationExercise(currentWord);
                Utils.showToast('Hãy nghe và luyện tập!', 'success');
            } else {
                console.error('❌ API returned error:', result.message);
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('❌ Exception occurred:', error);
            Utils.showToast('Không thể tạo bài tập: ' + error.message, 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    listenBtn?.addEventListener('click', () => {
        if (currentWord && currentWord.word) {
            const utterance = new SpeechSynthesisUtterance(currentWord.word);
            utterance.lang = 'en-US';
            utterance.rate = 0.8;
            window.speechSynthesis.speak(utterance);
        }
    });

    recordBtn?.addEventListener('click', async () => {
        console.log('Record button clicked');
        
        if (!window.speechRecognition) {
            Utils.showToast('❌ Speech Recognition chưa được khởi tạo', 'error');
            return;
        }
        
        if (!window.speechRecognition.isSupported()) {
            Utils.showToast('❌ Trình duyệt không hỗ trợ nhận dạng giọng nói', 'warning');
            return;
        }

        recordBtn.style.display = 'none';
        stopRecordBtn.style.display = 'inline-flex';
        
        Utils.showToast('🎤 Chuẩn bị ghi âm...', 'info', 2000);
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        Utils.showToast('🔴 Đang ghi âm... Hãy phát âm từ: "' + currentWord.word + '"', 'warning', 60000);

        try {
            console.log('Starting recording for word:', currentWord.word);
            userTranscript = await window.speechRecognition.startRecording();
            console.log('Recording completed. Transcript:', userTranscript);
            
            displayUserPronunciation(userTranscript);
            Utils.showToast('✅ Đã ghi âm xong! (' + userTranscript.split(' ').length + ' từ)', 'success');
        } catch (error) {
            console.error('Recording error:', error);
            Utils.showToast('❌ Lỗi ghi âm: ' + error.message, 'error');
        } finally {
            recordBtn.style.display = 'inline-flex';
            stopRecordBtn.style.display = 'none';
        }
    });

    stopRecordBtn?.addEventListener('click', () => {
        console.log('Stop button clicked');
        if (window.speechRecognition) {
            window.speechRecognition.stopRecording();
            Utils.showToast('Đã dừng ghi âm', 'info');
        }
    });

    checkBtn?.addEventListener('click', async () => {
        if (!currentWord || !userTranscript) {
            Utils.showToast('⚠️ Chưa có bản ghi âm để kiểm tra!', 'warning');
            return;
        }

        console.log('Checking pronunciation. Target:', currentWord.word, 'User said:', userTranscript);
        Utils.showLoading('Đang phân tích phát âm...');

        try {
            const result = await Utils.apiRequest('pronunciation_api.php', {
                action: 'check',
                target: currentWord.word,
                user_input: userTranscript
            });

            console.log('Check pronunciation result:', result);

            if (result.success) {
                displayPronunciationResults(result.data);
                Utils.showToast('✅ Đã phân tích xong!', 'success');
            } else {
                Utils.showToast('❌ Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Check pronunciation error:', error);
            Utils.showToast('❌ Không thể phân tích', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    function displayPronunciationExercise(data) {
        console.log('Displaying exercise:', data);
        document.getElementById('pronunciation-exercise-container').style.display = 'block';
        document.getElementById('pronunciation-word').textContent = data.word;
        document.getElementById('pronunciation-phonetic').textContent = data.phonetic || '';
        document.getElementById('pronunciation-transcription').style.display = 'none';
        document.getElementById('pronunciation-results').style.display = 'none';
        
        // Reset transcript
        userTranscript = '';
    }

    function displayUserPronunciation(text) {
        console.log('Displaying user pronunciation:', text);
        document.getElementById('pronunciation-user-text').textContent = text;
        document.getElementById('pronunciation-transcription').style.display = 'block';
    }

    function displayPronunciationResults(data) {
        console.log('Displaying results:', data);
        const resultsDiv = document.getElementById('pronunciation-results');
        resultsDiv.style.display = 'block';
        
        const score = data.score || 7;
        const feedback = data.feedback || 'Phát âm tốt! Tiếp tục luyện tập.';
        
        // Determine color based on score
        let scoreColor = '#dc3545'; // red
        let scoreLabel = 'Cần cải thiện';
        if (score >= 8) {
            scoreColor = '#28a745'; // green
            scoreLabel = 'Xuất sắc!';
        } else if (score >= 6) {
            scoreColor = '#ffc107'; // yellow
            scoreLabel = 'Tốt';
        }
        
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3 style="margin-bottom: 20px;">
                    <i class="fas fa-star"></i> Kết quả phân tích
                </h3>
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                    <div>
                        <div style="font-size: 0.9rem; opacity: 0.9;">Điểm số</div>
                        <div style="font-size: 2.5rem; font-weight: bold; color: ${scoreColor};">${score}/10</div>
                        <div style="font-size: 1rem; opacity: 0.9;">${scoreLabel}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.9rem; opacity: 0.9;">So sánh</div>
                        <div style="font-size: 1.2rem; margin-top: 5px;">
                            <div>Từ chuẩn: <strong>${currentWord.word}</strong></div>
                            <div style="margin-top: 5px;">Bạn nói: <strong>${userTranscript}</strong></div>
                        </div>
                    </div>
                </div>
                
                <div style="background: rgba(255,255,255,0.15); padding: 15px; border-radius: 8px;">
                    <h4 style="margin-bottom: 10px;"><i class="fas fa-comment-dots"></i> Nhận xét từ AI:</h4>
                    <div style="font-size: 1.1rem; line-height: 1.6;">${feedback}</div>
                </div>
                
                ${data.tip ? `
                <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 8px; margin-top: 15px;">
                    <h4 style="margin-bottom: 10px;"><i class="fas fa-lightbulb"></i> Mẹo:</h4>
                    <div style="font-size: 1rem; line-height: 1.6;">${data.tip}</div>
                </div>
                ` : ''}
                
                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-outline" onclick="document.getElementById('pronunciation-start-btn').click();" style="background: white; color: #667eea;">
                        <i class="fas fa-redo"></i> Luyện từ khác
                    </button>
                    <button class="btn btn-outline" onclick="document.getElementById('pronunciation-record-btn').click();" style="background: white; color: #764ba2; margin-left: 10px;">
                        <i class="fas fa-microphone"></i> Thử lại
                    </button>
                </div>
            </div>
        `;
    }
}
</script>
