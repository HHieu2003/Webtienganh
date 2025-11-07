<!-- READING SECTION -->
<section id="reading-section" class="skill-content-section">
    <div class="reading-main-card">
        <div class="reading-header">
            <div class="reading-icon-wrapper">
                <i class="fas fa-book-open"></i>
            </div>
            <h2 class="reading-title">Luyện Đọc (Reading)</h2>
            <p class="reading-subtitle">Nâng cao kỹ năng đọc hiểu tiếng Anh với các bài đọc đa dạng</p>
        </div>

        <!-- Settings Panel -->
        <div class="reading-settings-panel">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Chọn cấp độ
                    </label>
                    <select id="reading-level" class="form-select">
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
                        <optgroup label="🎓 Luyện thi">
                            <option value="ielts_6">IELTS 6.0-6.5</option>
                            <option value="ielts_7">IELTS 7.0+</option>
                            <option value="toefl">TOEFL Reading</option>
                            <option value="sat">SAT Reading</option>
                        </optgroup>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-bookmark"></i> Chủ đề (tùy chọn)
                    </label>
                    <input type="text" id="reading-topic" class="form-control" placeholder="Ví dụ: khoa học, công nghệ, văn hóa...">
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-question-circle"></i> Số câu hỏi
                    </label>
                    <select id="reading-question-count" class="form-select">
                        <option value="3">3 câu hỏi</option>
                        <option value="5" selected>5 câu hỏi</option>
                        <option value="7">7 câu hỏi</option>
                        <option value="10">10 câu hỏi</option>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="reading-generate-btn" id="reading-generate-btn">
                    <i class="fas fa-magic"></i>
                    Tạo bài đọc mới
                </button>
            </div>
        </div>

        <!-- Exercise Container -->
        <div id="reading-exercise-container" class="mt-4" style="display: none;">
            <!-- Passage Card -->
            <div class="reading-passage-card">
                <div class="passage-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-file-alt"></i>
                        <span id="reading-passage-title">Bài đọc</span>
                    </div>
                    <div class="passage-stats">
                        <span class="stat-badge">
                            <i class="fas fa-file-word"></i>
                            <span id="reading-word-count">0</span> từ
                        </span>
                    </div>
                </div>
                <div class="passage-body">
                    <div id="reading-passage"></div>
                </div>
            </div>

            <!-- Questions Container -->
            <div id="reading-questions-container"></div>

            <!-- Submit Button -->
            <div class="text-center mt-4 mb-3">
                <button class="reading-submit-btn" id="reading-submit-btn">
                    <i class="fas fa-check-circle"></i>
                    <span>Nộp bài và xem kết quả</span>
                </button>
            </div>

            <!-- Results Container -->
            <div id="reading-results" class="mt-4" style="display: none;"></div>
        </div>
    </div>
</section>

<style>
/* Reading Section Styles */
.reading-main-card {
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    border: 2px solid #667eea30;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
}

.reading-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.reading-icon-wrapper {
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

.reading-icon-wrapper i {
    font-size: 2.5rem;
    color: white;
}

.reading-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.reading-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    margin: 0;
}

.reading-settings-panel {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.reading-settings-panel .form-label {
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.reading-settings-panel .form-label i {
    color: #667eea;
}

.reading-settings-panel .form-select,
.reading-settings-panel .form-control {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.reading-settings-panel .form-select:focus,
.reading-settings-panel .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.reading-generate-btn {
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

.reading-generate-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
}

/* Passage Card */
.reading-passage-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
    border: 2px solid #3b82f620;
}

.passage-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.05rem;
    font-weight: 600;
}

.passage-header i {
    font-size: 1.3rem;
}

.passage-stats .stat-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.4rem 0.875rem;
    border-radius: 20px;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.passage-body {
    padding: 2.5rem;
}

.passage-body #reading-passage {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #1e293b;
    text-align: justify;
}

.passage-body #reading-passage p {
    margin-bottom: 1.5rem;
}

/* Question Card */
.reading-question-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
    border-left: 5px solid #667eea;
    transition: all 0.3s ease;
}

.reading-question-card:hover {
    transform: translateX(5px);
    box-shadow: 0 6px 25px rgba(0,0,0,0.12);
}

.question-header {
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    border-bottom: 2px dashed #e2e8f0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.question-text {
    flex: 1;
    font-size: 1.05rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.6;
}

.question-type-badge {
    padding: 0.3rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
}

.type-main_idea {
    background: #dbeafe;
    color: #1e40af;
}

.type-detail {
    background: #dcfce7;
    color: #166534;
}

.type-inference {
    background: #fef3c7;
    color: #92400e;
}

.type-vocabulary {
    background: #fce7f3;
    color: #9f1239;
}

.type-tone {
    background: #f3e8ff;
    color: #6b21a8;
}

.type-general {
    background: #f1f5f9;
    color: #475569;
}

.question-options {
    padding: 1.5rem;
}

.reading-option {
    padding: 1rem 1.25rem;
    margin-bottom: 0.75rem;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.reading-option:hover {
    background: #f0f9ff;
    border-color: #667eea;
    transform: translateX(5px);
}

.reading-option.selected {
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    border-color: #667eea;
    border-width: 3px;
}

.reading-option input[type="radio"] {
    margin-top: 0.2rem;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.reading-option label {
    flex: 1;
    cursor: pointer;
    margin: 0;
    line-height: 1.6;
    color: #334155;
    font-size: 1rem;
}

/* Submit Button */
.reading-submit-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 1rem 3rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.reading-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(16, 185, 129, 0.5);
}

/* Results Card */
.reading-results-card {
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

.results-section {
    padding: 2rem;
    border-top: 2px dashed #e2e8f0;
}

.results-section h4 {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.2rem;
}

.result-item {
    background: white;
    padding: 1.5rem;
    margin-bottom: 1.25rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-left: 5px solid #64748b;
}

.result-item.correct {
    border-left-color: #10b981;
    background: #ecfdf515;
}

.result-item.incorrect {
    border-left-color: #ef4444;
    background: #fef2f215;
}

.result-question {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1rem;
    font-size: 1.05rem;
    line-height: 1.6;
}

.result-answer {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.answer-correct {
    background: #dcfce7;
    color: #166534;
    border-left: 3px solid #10b981;
}

.answer-incorrect {
    background: #fee2e2;
    color: #991b1b;
    border-left: 3px solid #ef4444;
}

.answer-explanation {
    background: #f0f9ff;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
    border-left: 3px solid #3b82f6;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #1e40af;
}

/* Responsive Design */
@media (max-width: 768px) {
    .reading-main-card {
        padding: 1.5rem;
    }
    
    .reading-title {
        font-size: 1.8rem;
    }
    
    .reading-generate-btn,
    .reading-submit-btn {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }
    
    .passage-body {
        padding: 1.5rem;
    }
    
    .passage-body #reading-passage {
        font-size: 1rem;
    }
    
    .question-header {
        flex-direction: column;
    }
    
    .reading-option {
        padding: 0.875rem 1rem;
    }
}
</style>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'reading') {
        initReadingSection();
    }
});

function initReadingSection() {
    const generateBtn = document.getElementById('reading-generate-btn');
    const submitBtn = document.getElementById('reading-submit-btn');
    let currentExercise = null;

    generateBtn?.addEventListener('click', async () => {
        const level = document.getElementById('reading-level').value;
        const topic = document.getElementById('reading-topic').value;
        const questionCount = parseInt(document.getElementById('reading-question-count').value);

        Utils.showLoading('Đang tạo bài đọc...');

        try {
            const result = await Utils.apiRequest('reading_api.php', {
                action: 'generate',
                level: level,
                topic: topic,
                question_count: questionCount
            });

            if (result.success) {
                currentExercise = result.data;
                displayReadingExercise(currentExercise);
                Utils.showToast('Đã tạo bài đọc!', 'success');
                
                // Scroll to exercise
                document.getElementById('reading-exercise-container').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo bài đọc', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    submitBtn?.addEventListener('click', async () => {
        if (!currentExercise) return;
        const answers = collectReadingAnswers();

        // Check if all questions are answered
        const unanswered = answers.filter(a => a === -1).length;
        if (unanswered > 0) {
            if (!confirm(`Bạn chưa trả lời ${unanswered} câu hỏi. Bạn có muốn nộp bài không?`)) {
                return;
            }
        }

        Utils.showLoading('Đang chấm bài...');

        try {
            const result = await Utils.apiRequest('reading_api.php', {
                action: 'check',
                exercise: JSON.stringify(currentExercise),
                answers: JSON.stringify(answers)
            });

            if (result.success) {
                displayReadingResults(result.data);
                Utils.showToast('Đã chấm bài!', 'success');
                
                // Scroll to results
                document.getElementById('reading-results').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể chấm bài', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    function displayReadingExercise(exercise) {
        // Show exercise container
        const container = document.getElementById('reading-exercise-container');
        container.style.display = 'block';
        
        // Display passage with title and word count
        const title = exercise.title || 'Bài đọc';
        const wordCount = exercise.word_count || countWords(exercise.passage);
        
        document.getElementById('reading-passage-title').textContent = title;
        document.getElementById('reading-word-count').textContent = wordCount;
        
        // Format passage with paragraphs
        const formattedPassage = exercise.passage
            .split('\n')
            .filter(p => p.trim())
            .map(p => `<p>${p.trim()}</p>`)
            .join('');
        document.getElementById('reading-passage').innerHTML = formattedPassage;
        
        // Display questions
        const questionsContainer = document.getElementById('reading-questions-container');
        questionsContainer.innerHTML = '';
        
        exercise.questions.forEach((q, i) => {
            const questionCard = createQuestionCard(q, i);
            questionsContainer.appendChild(questionCard);
        });
        
        // Add option selection handlers
        document.querySelectorAll('.reading-option').forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove selected class from siblings
                const siblings = this.parentElement.querySelectorAll('.reading-option');
                siblings.forEach(s => s.classList.remove('selected'));
                
                // Add selected class to this option
                this.classList.add('selected');
            });
        });
        
        // Hide previous results
        document.getElementById('reading-results').style.display = 'none';
    }

    function createQuestionCard(question, index) {
        const card = document.createElement('div');
        card.className = 'reading-question-card';
        
        // Get question type and label
        const type = question.type || 'general';
        const typeLabels = {
            'main_idea': 'Ý chính',
            'detail': 'Chi tiết',
            'inference': 'Suy luận',
            'vocabulary': 'Từ vựng',
            'tone': 'Giọng điệu',
            'general': 'Tổng quát'
        };
        
        card.innerHTML = `
            <div class="question-header">
                <div class="question-text">
                    <span style="color: #667eea; font-weight: 700;">Câu ${index + 1}:</span> ${question.question}
                </div>
                <span class="question-type-badge type-${type}">${typeLabels[type]}</span>
            </div>
            <div class="question-options">
                ${question.options.map((option, optIndex) => `
                    <div class="reading-option">
                        <input type="radio" name="reading-q${index}" value="${optIndex}" id="q${index}-opt${optIndex}">
                        <label for="q${index}-opt${optIndex}">${option}</label>
                    </div>
                `).join('')}
            </div>
        `;
        
        return card;
    }

    function collectReadingAnswers() {
        const answers = [];
        if (currentExercise) {
            currentExercise.questions.forEach((q, i) => {
                const selected = document.querySelector(`input[name="reading-q${i}"]:checked`);
                answers.push(selected ? parseInt(selected.value) : -1);
            });
        }
        return answers;
    }

    function displayReadingResults(results) {
        const resultsDiv = document.getElementById('reading-results');
        resultsDiv.style.display = 'block';
        
        // Determine performance level and color
        const percentage = results.percentage || 0;
        let headerColor, emoji, performanceText;
        
        if (percentage >= 90) {
            headerColor = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            emoji = '🏆';
            performanceText = 'Xuất sắc!';
        } else if (percentage >= 80) {
            headerColor = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
            emoji = '🌟';
            performanceText = 'Tốt lắm!';
        } else if (percentage >= 70) {
            headerColor = 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)';
            emoji = '👍';
            performanceText = 'Khá tốt!';
        } else if (percentage >= 60) {
            headerColor = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
            emoji = '💪';
            performanceText = 'Được!';
        } else if (percentage >= 50) {
            headerColor = 'linear-gradient(135deg, #f97316 0%, #ea580c 100%)';
            emoji = '📚';
            performanceText = 'Cần cố gắng!';
        } else {
            headerColor = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
            emoji = '💡';
            performanceText = 'Đừng nản lòng!';
        }
        
        resultsDiv.innerHTML = `
            <div class="reading-results-card">
                <div class="results-header" style="background: ${headerColor};">
                    <div style="font-size: 4rem; margin-bottom: 0.5rem;">${emoji}</div>
                    <h3>${performanceText}</h3>
                    <div style="font-size: 3rem; font-weight: 800; margin: 1rem 0;">
                        ${results.correct_count}/${results.total_count}
                    </div>
                    <div style="font-size: 1.3rem; opacity: 0.95;">
                        <i class="fas fa-percentage"></i> ${percentage.toFixed(1)}% - 
                        <i class="fas fa-star"></i> ${results.score.toFixed(1)}/10 điểm
                    </div>
                </div>
                
                ${results.feedback ? `
                    <div class="results-section" style="background: #f0f9ff;">
                        <h4>
                            <i class="fas fa-comment-dots"></i>
                            Nhận xét
                        </h4>
                        <div style="font-size: 1.05rem; line-height: 1.8; color: #1e293b;">
                            ${results.feedback}
                        </div>
                    </div>
                ` : ''}
                
                <div class="results-section">
                    <h4>
                        <i class="fas fa-list-check"></i>
                        Chi tiết các câu hỏi
                    </h4>
                    ${results.details.map((detail, index) => createResultItem(detail, index)).join('')}
                </div>
            </div>
        `;
    }

    function createResultItem(detail, index) {
        const isCorrect = detail.is_correct;
        const typeLabels = {
            'main_idea': 'Ý chính',
            'detail': 'Chi tiết',
            'inference': 'Suy luận',
            'vocabulary': 'Từ vựng',
            'tone': 'Giọng điệu',
            'general': 'Tổng quát'
        };
        
        return `
            <div class="result-item ${isCorrect ? 'correct' : 'incorrect'}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="result-question">
                        <span style="color: #667eea; font-weight: 700;">Câu ${index + 1}:</span> ${detail.question}
                    </div>
                    <span class="question-type-badge type-${detail.type || 'general'}">
                        ${typeLabels[detail.type || 'general']}
                    </span>
                </div>
                
                <div class="result-answer ${isCorrect ? 'answer-correct' : 'answer-incorrect'}">
                    <i class="fas ${isCorrect ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                    <strong>${isCorrect ? 'Đúng' : 'Sai'}:</strong>
                    ${isCorrect ? detail.correct_answer : 'Bạn chọn: ' + (detail.user_answer || 'Chưa chọn')}
                </div>
                
                ${!isCorrect ? `
                    <div class="result-answer answer-correct" style="margin-top: 0.5rem;">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Đáp án đúng:</strong> ${detail.correct_answer}
                    </div>
                ` : ''}
                
                ${detail.explanation ? `
                    <div class="answer-explanation">
                        <i class="fas fa-info-circle"></i>
                        <strong>Giải thích:</strong> ${detail.explanation}
                    </div>
                ` : ''}
            </div>
        `;
    }

    function countWords(text) {
        return text.trim().split(/\s+/).filter(w => w.length > 0).length;
    }
}
</script>
