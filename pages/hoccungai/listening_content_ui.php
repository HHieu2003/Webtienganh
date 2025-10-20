<!-- LISTENING SECTION -->
<section id="listening-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-headphones"></i>
                Luyện Nghe (Listening)
            </h2>
            <button class="btn btn-primary btn-sm" id="listening-generate-btn">
                <i class="fas fa-plus"></i> Tạo bài mới
            </button>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Rèn luyện kỹ năng nghe hiểu tiếng Anh qua các bài tập đa dạng với sự hỗ trợ của AI.</p>
            
            <!-- Settings -->
            <div class="form-group">
                <label class="form-label">Chọn cấp độ:</label>
                <select id="listening-level" class="form-control">
                    <option value="beginner">Beginner (A1-A2)</option>
                    <option value="intermediate" selected>Intermediate (B1-B2)</option>
                    <option value="advanced">Advanced (C1-C2)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Chủ đề (tùy chọn):</label>
                <input type="text" id="listening-topic" class="form-control" placeholder="Ví dụ: du lịch, công việc, giáo dục...">
            </div>

            <!-- Exercise Container -->
            <div id="listening-exercise-container" class="mt-4" style="display: none;">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Nghe audio và trả lời các câu hỏi bên dưới.</span>
                </div>

                <!-- Audio Player -->
                <div id="listening-audio-player" class="mb-4" style="background: var(--bg-secondary); padding: 1.5rem; border-radius: var(--border-radius); text-align: center;">
                    <div id="listening-audio-text" class="mb-3" style="font-size: 1.1rem; line-height: 1.8; color: var(--text-primary);"></div>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary" id="listening-play-btn">
                            <i class="fas fa-play"></i> Phát audio
                        </button>
                        <button class="btn btn-secondary" id="listening-pause-btn" style="display: none;">
                            <i class="fas fa-pause"></i> Tạm dừng
                        </button>
                        <button class="btn btn-outline" id="listening-show-transcript-btn">
                            <i class="fas fa-file-alt"></i> Hiển thị transcript
                        </button>
                    </div>
                </div>

                <!-- Questions -->
                <div id="listening-questions-container"></div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg" id="listening-submit-btn">
                        <i class="fas fa-check"></i> Nộp bài
                    </button>
                </div>

                <!-- Results -->
                <div id="listening-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'listening') {
        initListeningSection();
    }
});

function initListeningSection() {
    const generateBtn = document.getElementById('listening-generate-btn');
    const playBtn = document.getElementById('listening-play-btn');
    const pauseBtn = document.getElementById('listening-pause-btn');
    const transcriptBtn = document.getElementById('listening-show-transcript-btn');
    const submitBtn = document.getElementById('listening-submit-btn');
    
    let currentExercise = null;
    let audioSynthesis = null;

    // Generate exercise
    generateBtn?.addEventListener('click', async () => {
        const level = document.getElementById('listening-level').value;
        const topic = document.getElementById('listening-topic').value;

        Utils.showLoading('Đang tạo bài nghe...');

        try {
            const result = await Utils.apiRequest('listening_api.php', {
                action: 'generate',
                level: level,
                topic: topic
            });

            if (result.success) {
                currentExercise = result.data;
                displayListeningExercise(currentExercise);
                Utils.showToast('Đã tạo bài nghe thành công!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo bài nghe', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    // Play audio
    playBtn?.addEventListener('click', () => {
        if (currentExercise && currentExercise.text) {
            playAudio(currentExercise.text);
        }
    });

    // Pause audio
    pauseBtn?.addEventListener('click', () => {
        if (audioSynthesis) {
            window.speechSynthesis.cancel();
            playBtn.style.display = 'inline-flex';
            pauseBtn.style.display = 'none';
        }
    });

    // Show transcript
    transcriptBtn?.addEventListener('click', () => {
        if (currentExercise && currentExercise.text) {
            const textDiv = document.getElementById('listening-audio-text');
            if (textDiv.style.display === 'none' || textDiv.style.display === '') {
                textDiv.style.display = 'block';
                transcriptBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Ẩn transcript';
            } else {
                textDiv.style.display = 'none';
                transcriptBtn.innerHTML = '<i class="fas fa-file-alt"></i> Hiển thị transcript';
            }
        }
    });

    // Submit answers
    submitBtn?.addEventListener('click', async () => {
        if (!currentExercise) return;

        const answers = collectListeningAnswers();
        
        Utils.showLoading('Đang chấm bài...');

        try {
            const result = await Utils.apiRequest('listening_api.php', {
                action: 'check',
                exercise: JSON.stringify(currentExercise),
                answers: JSON.stringify(answers)
            });

            if (result.success) {
                displayListeningResults(result.data);
                Utils.showToast('Đã chấm bài xong!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể chấm bài', 'error');
            console.error(error);
        } finally {
            Utils.hideLoading();
        }
    });

    function playAudio(text) {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'en-US';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            
            utterance.onstart = () => {
                playBtn.style.display = 'none';
                pauseBtn.style.display = 'inline-flex';
            };
            
            utterance.onend = () => {
                playBtn.style.display = 'inline-flex';
                pauseBtn.style.display = 'none';
            };
            
            window.speechSynthesis.speak(utterance);
            audioSynthesis = utterance;
        } else {
            Utils.showToast('Trình duyệt không hỗ trợ text-to-speech', 'warning');
        }
    }

    function displayListeningExercise(exercise) {
        document.getElementById('listening-exercise-container').style.display = 'block';
        document.getElementById('listening-results').style.display = 'none';
        
        const textDiv = document.getElementById('listening-audio-text');
        textDiv.textContent = exercise.text;
        textDiv.style.display = 'none';
        
        const questionsContainer = document.getElementById('listening-questions-container');
        questionsContainer.innerHTML = '';
        
        exercise.questions.forEach((q, index) => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'ai-card mb-3';
            questionDiv.innerHTML = `
                <h4 style="margin-bottom: 1rem;">Câu ${index + 1}: ${q.question}</h4>
                ${q.options.map((opt, i) => `
                    <div class="mb-2">
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 0.75rem; background: var(--bg-secondary); border-radius: var(--border-radius-sm); transition: all 0.2s;">
                            <input type="radio" name="listening-q${index}" value="${i}" style="margin-right: 0.75rem;">
                            <span>${opt}</span>
                        </label>
                    </div>
                `).join('')}
            `;
            questionsContainer.appendChild(questionDiv);
        });
    }

    function collectListeningAnswers() {
        const answers = [];
        if (currentExercise) {
            currentExercise.questions.forEach((q, index) => {
                const selected = document.querySelector(`input[name="listening-q${index}"]:checked`);
                answers.push(selected ? parseInt(selected.value) : -1);
            });
        }
        return answers;
    }

    function displayListeningResults(results) {
        const resultsDiv = document.getElementById('listening-results');
        resultsDiv.style.display = 'block';
        
        const correctCount = results.correct_count || 0;
        const totalCount = results.total_count || 0;
        const score = results.score || 0;
        
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3 style="margin-bottom: 1rem;"><i class="fas fa-trophy"></i> Kết quả</h3>
                <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                    ${correctCount}/${totalCount} câu đúng
                </div>
                <div style="font-size: 1.5rem;">Điểm: ${score.toFixed(1)}/10</div>
            </div>
            
            <div class="ai-card mt-3">
                <h4 class="mb-3">Chi tiết đáp án:</h4>
                ${results.details.map((detail, index) => `
                    <div class="mb-3 p-3" style="background: ${detail.is_correct ? '#d1fae5' : '#fee2e2'}; border-radius: var(--border-radius-sm);">
                        <strong>Câu ${index + 1}:</strong> ${detail.question}<br>
                        <span style="color: ${detail.is_correct ? '#065f46' : '#991b1b'};">
                            ${detail.is_correct ? '✓ Đúng' : '✗ Sai'}
                        </span><br>
                        ${!detail.is_correct ? `<small>Đáp án đúng: ${detail.correct_answer}</small>` : ''}
                        ${detail.feedback ? `<br><small>${detail.feedback}</small>` : ''}
                    </div>
                `).join('')}
            </div>
        `;

        // Update progress
        window.progressTracker?.updateProgress('listening', {
            completed: window.progressTracker.getProgress('listening').completed + 1,
            total: window.progressTracker.getProgress('listening').total + 1,
            score: score
        });
    }
}
</script>
