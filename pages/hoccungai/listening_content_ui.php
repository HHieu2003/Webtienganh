<!-- LISTENING SECTION -->
<section id="listening-section" class="skill-content-section">
    <div class="ai-card listening-main-card">
        <div class="ai-card-header">
            <div class="d-flex align-items-center gap-2">
                <div class="skill-icon-wrapper listening-icon">
                    <i class="fas fa-headphones"></i>
                </div>
                <div>
                    <h2 class="ai-card-title mb-0">Luyện Nghe (Listening)</h2>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Rèn luyện kỹ năng nghe hiểu với AI</p>
                </div>
            </div>
        </div>
        <div class="ai-card-body">
            <!-- Settings Panel -->
            <div class="listening-settings-panel">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-layer-group text-primary"></i> Cấp độ
                        </label>
                        <select id="listening-level" class="form-control form-select">
                            <optgroup label="Cơ bản">
                                <option value="beginner">Beginner (A1-A2)</option>
                                <option value="elementary">Elementary (A2)</option>
                            </optgroup>
                            <optgroup label="Trung cấp">
                                <option value="intermediate" selected>Intermediate (B1)</option>
                                <option value="upper_intermediate">Upper-Intermediate (B2)</option>
                            </optgroup>
                            <optgroup label="Nâng cao">
                                <option value="advanced">Advanced (C1)</option>
                                <option value="proficiency">Proficiency (C2)</option>
                            </optgroup>
                            <optgroup label="Luyện thi">
                                <option value="ielts_5">IELTS 5.0-6.0</option>
                                <option value="ielts_7">IELTS 7.0-8.0</option>
                                <option value="toeic_600">TOEIC 600-700</option>
                                <option value="toeic_800">TOEIC 800+</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-bookmark text-warning"></i> Chủ đề (tùy chọn)
                        </label>
                        <input type="text" id="listening-topic" class="form-control" 
                               placeholder="Ví dụ: travel, technology, health...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-list-ol text-success"></i> Số câu hỏi
                        </label>
                        <select id="listening-question-count" class="form-control form-select">
                            <option value="3">3 câu hỏi</option>
                            <option value="5" selected>5 câu hỏi</option>
                            <option value="7">7 câu hỏi</option>
                            <option value="10">10 câu hỏi</option>
                            <option value="15">15 câu hỏi</option>
                            <option value="20">20 câu hỏi</option>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg listening-generate-btn" id="listening-generate-btn">
                        <i class="fas fa-wand-magic-sparkles"></i> Tạo bài nghe mới
                    </button>
                </div>
            </div>

            <!-- Exercise Container -->
            <div id="listening-exercise-container" class="mt-4" style="display: none;">
                <!-- Exercise Title -->
                <div class="listening-exercise-title mb-4">
                    <h3 id="listening-exercise-title" class="text-center">
                        <i class="fas fa-book-open"></i> <span></span>
                    </h3>
                </div>

                <!-- Audio Player Card -->
                <div class="listening-audio-card">
                    <div class="audio-card-header">
                        <i class="fas fa-volume-up"></i> Audio Player
                    </div>
                    <div class="audio-card-body">
                        <!-- Progress Bar -->
                        <div class="audio-progress-container mb-3">
                            <div class="audio-progress-bar" id="listening-progress-bar">
                                <div class="audio-progress-fill" id="listening-progress-fill"></div>
                            </div>
                            <div class="audio-time-display">
                                <span id="listening-current-time">0:00</span>
                                <span id="listening-total-time">0:00</span>
                            </div>
                        </div>

                        <!-- Control Buttons -->
                        <div class="audio-controls">
                            <button class="btn-audio-control" id="listening-play-btn" title="Phát">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="btn-audio-control" id="listening-pause-btn" style="display: none;" title="Tạm dừng">
                                <i class="fas fa-pause"></i>
                            </button>
                            <button class="btn-audio-control" id="listening-replay-btn" title="Phát lại">
                                <i class="fas fa-redo"></i>
                            </button>
                            <button class="btn-audio-speed" id="listening-speed-btn" title="Tốc độ">
                                <i class="fas fa-gauge"></i> 1.0x
                            </button>
                        </div>

                        <!-- Transcript Toggle -->
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-secondary btn-sm" id="listening-show-transcript-btn">
                                <i class="fas fa-file-alt"></i> Hiển thị transcript
                            </button>
                        </div>

                        <!-- Transcript -->
                        <div id="listening-transcript-container" class="listening-transcript" style="display: none;">
                            <div class="transcript-header">
                                <i class="fas fa-file-alt"></i> Transcript
                            </div>
                            <div id="listening-audio-text" class="transcript-text"></div>
                        </div>
                    </div>
                </div>

                <!-- Questions Container -->
                <div id="listening-questions-container" class="mt-4"></div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg listening-submit-btn" id="listening-submit-btn">
                        <i class="fas fa-paper-plane"></i> Nộp bài
                    </button>
                </div>

                <!-- Results -->
                <div id="listening-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<style>
/* Listening Section Styles */
.listening-main-card {
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    border: 2px solid #667eea30;
}

.listening-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.listening-settings-panel {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.listening-generate-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.75rem 2rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.listening-generate-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.listening-exercise-title h3 {
    color: #667eea;
    font-weight: 700;
    font-size: 1.5rem;
}

.listening-audio-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    color: white;
}

.audio-card-header {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.audio-card-body {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
}

.audio-progress-container {
    position: relative;
}

.audio-progress-bar {
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
    cursor: pointer;
}

.audio-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #fff 0%, #ffd700 100%);
    width: 0%;
    transition: width 0.1s linear;
}

.audio-time-display {
    display: flex;
    justify-content: space-between;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    opacity: 0.9;
}

.audio-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-audio-control {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: white;
    color: #667eea;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    display: flex;
    justify-content: center;
    align-items: center;
}

.btn-audio-control:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0,0,0,0.3);
}

.btn-audio-speed {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-audio-speed:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.listening-transcript {
    margin-top: 1.5rem;
    background: white;
    color: #333;
    border-radius: 12px;
    overflow: hidden;
}

.transcript-header {
    background: #667eea;
    color: white;
    padding: 0.75rem 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.transcript-text {
    padding: 1.5rem;
    line-height: 1.8;
    font-size: 1.05rem;
    max-height: 300px;
    overflow-y: auto;
}

.listening-question-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.listening-question-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateX(4px);
}

.listening-question-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.question-type-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.type-main_idea { background: #dbeafe; color: #1e40af; }
.type-detail { background: #dcfce7; color: #166534; }
.type-inference { background: #fef3c7; color: #92400e; }
.type-vocabulary { background: #fce7f3; color: #9f1239; }
.type-tone { background: #f3e8ff; color: #6b21a8; }

.listening-option {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border: 2px solid transparent;
    border-radius: 8px;
    margin-bottom: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.listening-option:hover {
    background: #e9ecef;
    border-color: #667eea50;
}

.listening-option input[type="radio"] {
    width: 20px;
    height: 20px;
    margin-right: 1rem;
    cursor: pointer;
    accent-color: #667eea;
}

.listening-option.selected {
    background: #667eea15;
    border-color: #667eea;
}

.listening-submit-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    padding: 0.75rem 3rem;
    font-weight: 600;
    font-size: 1.1rem;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    transition: all 0.3s ease;
}

.listening-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.listening-results-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.results-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.results-score {
    font-size: 3rem;
    font-weight: 700;
    margin: 1rem 0;
}

.results-details {
    padding: 2rem;
}

.result-item {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-left: 4px solid;
}

.result-item.correct {
    background: #dcfce7;
    border-color: #10b981;
}

.result-item.incorrect {
    background: #fee2e2;
    border-color: #ef4444;
}

@media (max-width: 768px) {
    .audio-controls {
        flex-wrap: wrap;
    }
    
    .btn-audio-control {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .listening-option {
        padding: 0.75rem;
    }
}
</style>

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
    const replayBtn = document.getElementById('listening-replay-btn');
    const speedBtn = document.getElementById('listening-speed-btn');
    const transcriptBtn = document.getElementById('listening-show-transcript-btn');
    const submitBtn = document.getElementById('listening-submit-btn');
    
    console.log('Listening Section Init:', {
        generateBtn: generateBtn ? 'Found' : 'NOT FOUND',
        playBtn: playBtn ? 'Found' : 'NOT FOUND'
    });
    
    let currentExercise = null;
    let audioSynthesis = null;
    let currentSpeed = 1.0;
    const speeds = [0.75, 1.0, 1.25, 1.5];
    let speedIndex = 1;
    let progressInterval = null;
    let startTime = 0;
    let estimatedDuration = 0;

    // Generate exercise
    if (generateBtn) {
        console.log('Attaching click event to generate button');
        generateBtn.addEventListener('click', async () => {
            console.log('Generate button clicked!');
            const level = document.getElementById('listening-level').value;
            const topic = document.getElementById('listening-topic').value;
            const questionCount = document.getElementById('listening-question-count').value;

            Utils.showLoading('Đang tạo bài nghe với AI...');

            try {
                const result = await Utils.apiRequest('listening_api.php', {
                    action: 'generate',
                    level: level,
                    topic: topic,
                    question_count: questionCount
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
    } else {
        console.error('Generate button NOT FOUND!');
    }

    // Play audio
    playBtn?.addEventListener('click', () => {
        if (currentExercise && currentExercise.text) {
            playAudio(currentExercise.text, currentSpeed);
        }
    });

    // Pause audio
    pauseBtn?.addEventListener('click', () => {
        if (audioSynthesis) {
            window.speechSynthesis.cancel();
            playBtn.style.display = 'flex';
            pauseBtn.style.display = 'none';
            clearInterval(progressInterval);
        }
    });

    // Replay audio
    replayBtn?.addEventListener('click', () => {
        window.speechSynthesis.cancel();
        clearInterval(progressInterval);
        if (currentExercise && currentExercise.text) {
            playAudio(currentExercise.text, currentSpeed);
        }
    });

    // Speed control
    speedBtn?.addEventListener('click', () => {
        speedIndex = (speedIndex + 1) % speeds.length;
        currentSpeed = speeds[speedIndex];
        speedBtn.innerHTML = `<i class="fas fa-gauge"></i> ${currentSpeed}x`;
        
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
            clearInterval(progressInterval);
            playAudio(currentExercise.text, currentSpeed);
        }
    });

    // Show transcript
    transcriptBtn?.addEventListener('click', () => {
        const container = document.getElementById('listening-transcript-container');
        if (container.style.display === 'none') {
            container.style.display = 'block';
            transcriptBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Ẩn transcript';
        } else {
            container.style.display = 'none';
            transcriptBtn.innerHTML = '<i class="fas fa-file-alt"></i> Hiển thị transcript';
        }
    });

    // Submit answers
    submitBtn?.addEventListener('click', async () => {
        if (!currentExercise) return;

        const answers = collectListeningAnswers();
        
        // Check if all questions answered
        const unanswered = answers.filter(a => a === -1).length;
        if (unanswered > 0) {
            if (!confirm(`Bạn còn ${unanswered} câu chưa trả lời. Bạn có muốn nộp bài không?`)) {
                return;
            }
        }
        
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
                
                // Scroll to results
                setTimeout(() => {
                    document.getElementById('listening-results').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 300);
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

    function playAudio(text, speed = 1.0) {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            clearInterval(progressInterval);
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'en-US';
            utterance.rate = speed;
            utterance.pitch = 1;
            utterance.volume = 1;
            
            // Estimate duration based on text length and speed
            // Average reading speed: ~150 words per minute at 1.0x
            const wordCount = text.split(/\s+/).length;
            estimatedDuration = (wordCount / 150) * 60 / speed; // in seconds
            
            // Update total time display
            const totalTimeEl = document.getElementById('listening-total-time');
            if (totalTimeEl) {
                totalTimeEl.textContent = formatTime(estimatedDuration);
            }
            
            utterance.onstart = () => {
                playBtn.style.display = 'none';
                pauseBtn.style.display = 'flex';
                startTime = Date.now();
                
                // Start progress tracking
                progressInterval = setInterval(() => {
                    const elapsed = (Date.now() - startTime) / 1000; // in seconds
                    const progress = Math.min((elapsed / estimatedDuration) * 100, 100);
                    
                    // Update progress bar
                    const progressFill = document.getElementById('listening-progress-fill');
                    if (progressFill) {
                        progressFill.style.width = progress + '%';
                    }
                    
                    // Update current time
                    const currentTimeEl = document.getElementById('listening-current-time');
                    if (currentTimeEl) {
                        currentTimeEl.textContent = formatTime(Math.min(elapsed, estimatedDuration));
                    }
                    
                    // Stop if reached end
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                    }
                }, 100); // Update every 100ms for smooth animation
            };
            
            utterance.onend = () => {
                playBtn.style.display = 'flex';
                pauseBtn.style.display = 'none';
                clearInterval(progressInterval);
                
                // Set to 100% complete
                const progressFill = document.getElementById('listening-progress-fill');
                if (progressFill) {
                    progressFill.style.width = '100%';
                }
                const currentTimeEl = document.getElementById('listening-current-time');
                if (currentTimeEl) {
                    currentTimeEl.textContent = formatTime(estimatedDuration);
                }
            };
            
            utterance.onerror = () => {
                playBtn.style.display = 'flex';
                pauseBtn.style.display = 'none';
                clearInterval(progressInterval);
                Utils.showToast('Lỗi phát audio', 'error');
            };
            
            window.speechSynthesis.speak(utterance);
            audioSynthesis = utterance;
        } else {
            Utils.showToast('Trình duyệt không hỗ trợ text-to-speech', 'warning');
        }
    }
    
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }

    function displayListeningExercise(exercise) {
        document.getElementById('listening-exercise-container').style.display = 'block';
        document.getElementById('listening-results').style.display = 'none';
        
        // Set title
        const titleSpan = document.querySelector('#listening-exercise-title span');
        if (titleSpan && exercise.title) {
            titleSpan.textContent = exercise.title;
        }
        
        // Set transcript
        const textDiv = document.getElementById('listening-audio-text');
        textDiv.textContent = exercise.text;
        
        // Hide transcript initially
        const transcriptContainer = document.getElementById('listening-transcript-container');
        transcriptContainer.style.display = 'none';
        
        // Render questions
        const questionsContainer = document.getElementById('listening-questions-container');
        questionsContainer.innerHTML = '';
        
        exercise.questions.forEach((q, index) => {
            const questionType = q.type || 'detail';
            const typeLabel = {
                'main_idea': 'Ý chính',
                'detail': 'Chi tiết',
                'inference': 'Suy luận',
                'vocabulary': 'Từ vựng',
                'tone': 'Giọng điệu'
            }[questionType] || 'Chi tiết';
            
            const questionDiv = document.createElement('div');
            questionDiv.className = 'listening-question-card';
            questionDiv.innerHTML = `
                <div class="listening-question-title">
                    <span style="color: #667eea; font-weight: 700;">Câu ${index + 1}:</span>
                    <span>${q.question}</span>
                    <span class="question-type-badge type-${questionType}">${typeLabel}</span>
                </div>
                ${q.options.map((opt, i) => `
                    <div class="listening-option" data-question="${index}" data-option="${i}">
                        <input type="radio" name="listening-q${index}" value="${i}" id="listening-q${index}-opt${i}">
                        <label for="listening-q${index}-opt${i}" style="cursor: pointer; flex: 1; margin: 0;">
                            <strong>${String.fromCharCode(65 + i)}.</strong> ${opt}
                        </label>
                    </div>
                `).join('')}
            `;
            questionsContainer.appendChild(questionDiv);
        });
        
        // Add click handlers to options
        document.querySelectorAll('.listening-option').forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove selected class from siblings
                const questionIndex = this.dataset.question;
                document.querySelectorAll(`.listening-option[data-question="${questionIndex}"]`).forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to this option
                this.classList.add('selected');
            });
        });
        
        // Scroll to exercise
        setTimeout(() => {
            document.getElementById('listening-exercise-container').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 300);
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
        const percentage = Math.round((correctCount / totalCount) * 100);
        
        // Determine performance level
        let performanceEmoji = '🎉';
        let performanceText = 'Xuất sắc!';
        let performanceColor = '#10b981';
        
        if (percentage >= 90) {
            performanceEmoji = '🏆';
            performanceText = 'Hoàn hảo!';
            performanceColor = '#fbbf24';
        } else if (percentage >= 80) {
            performanceEmoji = '🎉';
            performanceText = 'Xuất sắc!';
            performanceColor = '#10b981';
        } else if (percentage >= 70) {
            performanceEmoji = '👍';
            performanceText = 'Tốt!';
            performanceColor = '#3b82f6';
        } else if (percentage >= 60) {
            performanceEmoji = '💪';
            performanceText = 'Khá!';
            performanceColor = '#8b5cf6';
        } else {
            performanceEmoji = '📚';
            performanceText = 'Cần cố gắng thêm!';
            performanceColor = '#ef4444';
        }
        
        resultsDiv.innerHTML = `
            <div class="listening-results-card">
                <div class="results-header" style="background: linear-gradient(135deg, ${performanceColor} 0%, ${performanceColor}dd 100%);">
                    <div style="font-size: 4rem; margin-bottom: 0.5rem;">${performanceEmoji}</div>
                    <h3 style="margin: 0 0 0.5rem 0;">${performanceText}</h3>
                    <div class="results-score">${correctCount}/${totalCount}</div>
                    <div style="font-size: 1.2rem;">Điểm: ${score.toFixed(1)}/10</div>
                    <div style="font-size: 1rem; opacity: 0.9; margin-top: 0.5rem;">Tỷ lệ đúng: ${percentage}%</div>
                </div>
                
                <div class="results-details">
                    <h4 class="mb-3" style="color: #667eea; font-weight: 700;">
                        <i class="fas fa-clipboard-list"></i> Chi tiết đáp án
                    </h4>
                    ${results.details.map((detail, index) => {
                        const icon = detail.is_correct ? 
                            '<i class="fas fa-check-circle" style="color: #10b981;"></i>' : 
                            '<i class="fas fa-times-circle" style="color: #ef4444;"></i>';
                        return `
                            <div class="result-item ${detail.is_correct ? 'correct' : 'incorrect'}">
                                <div style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    ${icon}
                                    <strong style="flex: 1;">Câu ${index + 1}: ${detail.question}</strong>
                                </div>
                                ${!detail.is_correct ? `
                                    <div style="margin-left: 1.75rem;">
                                        <div style="margin-bottom: 0.25rem;">
                                            <span style="color: #ef4444;">❌ Bạn chọn:</span> ${detail.user_answer}
                                        </div>
                                        <div>
                                            <span style="color: #10b981;">✓ Đáp án đúng:</span> ${detail.correct_answer}
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                    }).join('')}
                    
                    ${results.feedback ? `
                        <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 8px; margin-top: 1.5rem;">
                            <h5 style="color: #1e40af; margin-bottom: 0.5rem;">
                                <i class="fas fa-comment-dots"></i> Nhận xét từ AI
                            </h5>
                            <p style="margin: 0; line-height: 1.6;">${results.feedback}</p>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;

        // Update progress
        if (window.progressTracker) {
            const progress = window.progressTracker.getProgress('listening');
            window.progressTracker.updateProgress('listening', {
                completed: progress.completed + 1,
                total: progress.total + 1,
                score: score
            });
        }
    }
}
</script>
