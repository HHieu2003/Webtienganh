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
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'pronunciation') {
        initPronunciationSection();
    }
});

function initPronunciationSection() {
    const startBtn = document.getElementById('pronunciation-start-btn');
    const listenBtn = document.getElementById('pronunciation-listen-btn');
    const recordBtn = document.getElementById('pronunciation-record-btn');
    const stopRecordBtn = document.getElementById('pronunciation-stop-record-btn');
    const checkBtn = document.getElementById('pronunciation-check-btn');
    
    let currentWord = null;
    let userTranscript = '';

    startBtn?.addEventListener('click', async () => {
        const focus = document.getElementById('pronunciation-focus').value;
        Utils.showLoading('Đang chuẩn bị...');

        try {
            const result = await Utils.apiRequest('pronunciation_api.php', {
                action: 'get_word',
                focus: focus
            });

            if (result.success) {
                currentWord = result.data;
                displayPronunciationExercise(currentWord);
                Utils.showToast('Hãy nghe và luyện tập!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo bài tập', 'error');
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
        if (!window.speechRecognition.isSupported()) {
            Utils.showToast('Trình duyệt không hỗ trợ nhận dạng giọng nói', 'warning');
            return;
        }

        recordBtn.style.display = 'none';
        stopRecordBtn.style.display = 'inline-flex';

        try {
            userTranscript = await window.speechRecognition.startRecording();
            displayUserPronunciation(userTranscript);
            Utils.showToast('Đã ghi âm xong!', 'success');
        } catch (error) {
            Utils.showToast('Lỗi ghi âm: ' + error.message, 'error');
        } finally {
            recordBtn.style.display = 'inline-flex';
            stopRecordBtn.style.display = 'none';
        }
    });

    checkBtn?.addEventListener('click', async () => {
        if (!currentWord || !userTranscript) return;

        Utils.showLoading('Đang phân tích...');

        try {
            const result = await Utils.apiRequest('pronunciation_api.php', {
                action: 'check',
                target: currentWord.word,
                user_input: userTranscript
            });

            if (result.success) {
                displayPronunciationResults(result.data);
                Utils.showToast('Đã phân tích xong!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể phân tích', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    function displayPronunciationExercise(data) {
        document.getElementById('pronunciation-exercise-container').style.display = 'block';
        document.getElementById('pronunciation-word').textContent = data.word;
        document.getElementById('pronunciation-phonetic').textContent = data.phonetic || '';
        document.getElementById('pronunciation-transcription').style.display = 'none';
        document.getElementById('pronunciation-results').style.display = 'none';
    }

    function displayUserPronunciation(text) {
        document.getElementById('pronunciation-user-text').textContent = text;
        document.getElementById('pronunciation-transcription').style.display = 'block';
    }

    function displayPronunciationResults(data) {
        const resultsDiv = document.getElementById('pronunciation-results');
        resultsDiv.style.display = 'block';
        
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3><i class="fas fa-star"></i> Đánh giá: ${data.score || 7}/10</h3>
                <div style="font-size: 1.2rem; margin-top: 1rem;">${data.feedback || 'Tốt lắm! Tiếp tục luyện tập.'}</div>
            </div>
        `;
    }
}
</script>
