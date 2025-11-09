<!-- GRAMMAR SECTION -->
<section id="grammar-section" class="skill-content-section">
    <div class="container">
        <div class="grammar-main-card">
            <!-- Header -->
            <div class="grammar-header">
                <div class="grammar-icon-wrapper">
                    <i class="fas fa-book-open"></i>
                </div>
                <h2 class="grammar-title">Luyện Ngữ Pháp (Grammar)</h2>
                <p class="grammar-subtitle">Nắm vững các quy tắc ngữ pháp tiếng Anh</p>
            </div>

            <!-- Settings Panel -->
            <div class="grammar-settings-panel">
                <div class="row g-3">
                    <!-- Level Selection -->
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-layer-group"></i>
                            Cấp độ
                        </label>
                        <select id="grammar-level" class="form-select">
                            <optgroup label="Cơ bản">
                                <option value="beginner">A1-A2: Ngữ pháp cơ bản</option>
                                <option value="elementary">A2-B1: Ngữ pháp sơ cấp</option>
                            </optgroup>
                            <optgroup label="Trung cấp">
                                <option value="intermediate" selected>B1: Trung cấp</option>
                                <option value="upper_intermediate">B1-B2: Trung cấp cao</option>
                            </optgroup>
                            <optgroup label="Nâng cao">
                                <option value="advanced">B2-C1: Nâng cao</option>
                                <option value="business">Business: Kinh doanh</option>
                                <option value="mixed">Mixed: Hỗn hợp</option>
                            </optgroup>
                            <optgroup label="Luyện thi">
                                <option value="ielts_6">IELTS 6.0-6.5</option>
                                <option value="ielts_7">IELTS 7.0+</option>
                                <option value="toefl">TOEFL</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Topic Selection -->
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-tags"></i>
                            Chủ đề (không bắt buộc)
                        </label>
                        <input type="text" id="grammar-topic" class="form-control" placeholder="Ví dụ: Present Perfect, Conditionals...">
                    </div>

                    <!-- Question Count -->
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-list-ol"></i>
                            Số câu hỏi
                        </label>
                        <select id="grammar-question-count" class="form-select">
                            <option value="3">3 câu</option>
                            <option value="5" selected>5 câu</option>
                            <option value="8">8 câu</option>
                            <option value="10">10 câu</option>
                            <option value="15">15 câu</option>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button class="grammar-generate-btn" id="grammar-generate-btn">
                        <i class="fas fa-magic"></i>
                        <span>Tạo bài tập ngữ pháp</span>
                    </button>
                </div>
            </div>

            <!-- Exercise Container -->
            <div id="grammar-exercise-container" class="mt-4" style="display: none;">
                <!-- Title Card -->
                <div class="grammar-title-card">
                    <div class="title-header">
                        <i class="fas fa-clipboard-list"></i>
                        <span id="grammar-exercise-title">Bài tập ngữ pháp</span>
                    </div>
                </div>

                <!-- Questions Container -->
                <div id="grammar-questions-container"></div>

                <!-- Submit Button -->
                <div class="text-center mt-4 mb-3">
                    <button class="grammar-submit-btn" id="grammar-submit-btn">
                        <i class="fas fa-check-circle"></i>
                        <span>Nộp bài và xem kết quả</span>
                    </button>
                </div>

                <!-- Results Container -->
                <div id="grammar-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Grammar Section Styles */
    .grammar-main-card {
        background: linear-gradient(135deg, #10b98115 0%, #059669 15 100%);
        border: 2px solid #10b98130;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
    }

    .grammar-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .grammar-icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }

    .grammar-icon-wrapper i {
        font-size: 2.5rem;
        color: white;
    }

    .grammar-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .grammar-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        margin: 0;
    }

    .grammar-settings-panel {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .grammar-settings-panel .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .grammar-settings-panel .form-label i {
        color: #10b981;
    }

    .grammar-settings-panel .form-select,
    .grammar-settings-panel .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .grammar-settings-panel .form-select:focus,
    .grammar-settings-panel .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .grammar-generate-btn {
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

    .grammar-generate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(16, 185, 129, 0.5);
    }

    /* Title Card */
    .grammar-title-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .title-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .title-header i {
        font-size: 1.5rem;
    }

    /* Question Card */
    .grammar-question-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
        border-left: 5px solid #10b981;
        transition: all 0.3s ease;
    }

    .grammar-question-card:hover {
        transform: translateX(5px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    }

    .grammar-question-header {
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border-bottom: 2px dashed #e2e8f0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }

    .grammar-question-text {
        flex: 1;
        font-size: 1.05rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.6;
    }

    .grammar-point-badge {
        padding: 0.3rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Grammar point colors */
    .point-tenses {
        background: #dbeafe;
        color: #1e40af;
    }

    .point-modals {
        background: #dcfce7;
        color: #166534;
    }

    .point-conditionals {
        background: #fef3c7;
        color: #92400e;
    }

    .point-passive_voice {
        background: #fce7f3;
        color: #9f1239;
    }

    .point-reported_speech {
        background: #f3e8ff;
        color: #6b21a8;
    }

    .point-relative_clauses {
        background: #ffedd5;
        color: #9a3412;
    }

    .point-articles {
        background: #e0f2fe;
        color: #075985;
    }

    .point-prepositions {
        background: #fce7f3;
        color: #831843;
    }

    .point-comparatives_superlatives {
        background: #fef9c3;
        color: #854d0e;
    }

    .point-gerunds_infinitives {
        background: #f0fdf4;
        color: #14532d;
    }

    .point-general {
        background: #f1f5f9;
        color: #475569;
    }

    /* Map all possible tenses */
    .point-present_simple,
    .point-present_continuous,
    .point-past_simple,
    .point-present_perfect,
    .point-past_perfect,
    .point-future_simple,
    .point-future_perfect {
        background: #dbeafe;
        color: #1e40af;
    }

    .grammar-question-options {
        padding: 1.5rem;
    }

    .grammar-option {
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

    .grammar-option:hover {
        background: #ecfdf5;
        border-color: #10b981;
        transform: translateX(5px);
    }

    .grammar-option.selected {
        background: linear-gradient(135deg, #10b98115 0%, #05966915 100%);
        border-color: #10b981;
        border-width: 3px;
    }

    .grammar-option input[type="radio"] {
        margin-top: 0.2rem;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .grammar-option label {
        flex: 1;
        cursor: pointer;
        margin: 0;
        line-height: 1.6;
        color: #334155;
        font-size: 1rem;
    }

    /* Submit Button */
    .grammar-submit-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        padding: 1rem 3rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    .grammar-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(245, 158, 11, 0.5);
    }

    /* Results Card */
    .grammar-results-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
        color: #10b981;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.2rem;
    }

    .grammar-result-item {
        background: white;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 5px solid #64748b;
    }

    .grammar-result-item.correct {
        border-left-color: #10b981;
        background: #ecfdf515;
    }

    .grammar-result-item.incorrect {
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
        .grammar-main-card {
            padding: 1.5rem;
        }

        .grammar-title {
            font-size: 1.8rem;
        }

        .grammar-generate-btn,
        .grammar-submit-btn {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }

        .grammar-question-header {
            flex-direction: column;
        }

        .grammar-option {
            padding: 0.875rem 1rem;
        }
    }
</style>

<script>
    document.addEventListener('skillSectionInit', (e) => {
        if (e.detail.skill === 'grammar') {
            initGrammarSection();
        }
    });

    function initGrammarSection() {
        const generateBtn = document.getElementById('grammar-generate-btn');
        const submitBtn = document.getElementById('grammar-submit-btn');
        let currentExercise = null;

        generateBtn?.addEventListener('click', async () => {
            const level = document.getElementById('grammar-level').value;
            const topic = document.getElementById('grammar-topic').value;
            const questionCount = parseInt(document.getElementById('grammar-question-count').value);

            Utils.showLoading('Đang tạo bài tập ngữ pháp...');

            try {
                const result = await Utils.apiRequest('grammar_api.php', {
                    action: 'generate',
                    level: level,
                    topic: topic,
                    question_count: questionCount
                });

                if (result.success) {
                    currentExercise = result.data;
                    displayGrammarExercise(currentExercise);
                    Utils.showToast('Đã tạo bài tập ngữ pháp!', 'success');

                    document.getElementById('grammar-exercise-container').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else {
                    Utils.showToast('Lỗi: ' + result.message, 'error');
                }
            } catch (error) {
                Utils.showToast('Không thể tạo bài tập', 'error');
            } finally {
                Utils.hideLoading();
            }
        });

        submitBtn?.addEventListener('click', async () => {
            if (!currentExercise) return;
            const answers = collectGrammarAnswers();

            const unanswered = answers.filter(a => a === -1).length;
            if (unanswered > 0) {
                if (!confirm(`Bạn chưa trả lời ${unanswered} câu hỏi. Bạn có muốn nộp bài không?`)) {
                    return;
                }
            }

            Utils.showLoading('Đang chấm bài...');

            try {
                const result = await Utils.apiRequest('grammar_api.php', {
                    action: 'check',
                    exercise: JSON.stringify(currentExercise),
                    answers: JSON.stringify(answers)
                });

                if (result.success) {
                    displayGrammarResults(result.data);
                    Utils.showToast('Đã chấm bài!', 'success');

                    document.getElementById('grammar-results').scrollIntoView({
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

        function displayGrammarExercise(exercise) {
            const container = document.getElementById('grammar-exercise-container');
            container.style.display = 'block';

            // Set title
            const title = exercise.title || 'Bài tập ngữ pháp';
            document.getElementById('grammar-exercise-title').textContent = title;

            // Display questions
            const questionsContainer = document.getElementById('grammar-questions-container');
            questionsContainer.innerHTML = '';

            exercise.questions.forEach((q, i) => {
                const questionCard = createGrammarQuestionCard(q, i);
                questionsContainer.appendChild(questionCard);
            });

            // Add option selection handlers
            document.querySelectorAll('.grammar-option').forEach(option => {
                option.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;

                    const siblings = this.parentElement.querySelectorAll('.grammar-option');
                    siblings.forEach(s => s.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            document.getElementById('grammar-results').style.display = 'none';
        }

        function createGrammarQuestionCard(question, index) {
            const card = document.createElement('div');
            card.className = 'grammar-question-card';

            const grammarPoint = question.grammar_point || 'general';
            const grammarLabels = {
                'present_simple': 'Present Simple',
                'present_continuous': 'Present Continuous',
                'past_simple': 'Past Simple',
                'present_perfect': 'Present Perfect',
                'past_perfect': 'Past Perfect',
                'future_simple': 'Future Simple',
                'modals': 'Modal Verbs',
                'conditionals': 'Conditionals',
                'type_1': 'Conditional Type 1',
                'type_2': 'Conditional Type 2',
                'type_3': 'Conditional Type 3',
                'passive_voice': 'Passive Voice',
                'reported_speech': 'Reported Speech',
                'relative_clauses': 'Relative Clauses',
                'articles': 'Articles',
                'prepositions': 'Prepositions',
                'comparatives_superlatives': 'Comparatives/Superlatives',
                'gerunds_infinitives': 'Gerunds/Infinitives',
                'tenses': 'Tenses',
                'general': 'General'
            };

            card.innerHTML = `
            <div class="grammar-question-header">
                <div class="grammar-question-text">
                    <span style="color: #10b981; font-weight: 700;">Câu ${index + 1}:</span> ${question.question}
                </div>
                <span class="grammar-point-badge point-${grammarPoint.replace(/_/g, '_')}">
                    ${grammarLabels[grammarPoint] || 'Grammar'}
                </span>
            </div>
            <div class="grammar-question-options">
                ${question.options.map((option, optIndex) => `
                    <div class="grammar-option">
                        <input type="radio" name="grammar-q${index}" value="${optIndex}" id="gq${index}-opt${optIndex}">
                        <label for="gq${index}-opt${optIndex}">${option}</label>
                    </div>
                `).join('')}
            </div>
        `;

            return card;
        }

        function collectGrammarAnswers() {
            const answers = [];
            if (currentExercise) {
                currentExercise.questions.forEach((q, i) => {
                    const selected = document.querySelector(`input[name="grammar-q${i}"]:checked`);
                    answers.push(selected ? parseInt(selected.value) : -1);
                });
            }
            return answers;
        }

        function displayGrammarResults(results) {
            const resultsDiv = document.getElementById('grammar-results');
            resultsDiv.style.display = 'block';

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
            <div class="grammar-results-card">
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
                    <div class="results-section" style="background: #ecfdf5;">
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
                    ${results.details.map((detail, index) => createGrammarResultItem(detail, index)).join('')}
                </div>
            </div>
        `;
        }

        function createGrammarResultItem(detail, index) {
            const isCorrect = detail.is_correct;
            const grammarLabels = {
                'present_simple': 'Present Simple',
                'present_continuous': 'Present Continuous',
                'past_simple': 'Past Simple',
                'present_perfect': 'Present Perfect',
                'modals': 'Modal Verbs',
                'conditionals': 'Conditionals',
                'passive_voice': 'Passive Voice',
                'reported_speech': 'Reported Speech',
                'relative_clauses': 'Relative Clauses',
                'articles': 'Articles',
                'prepositions': 'Prepositions',
                'comparatives_superlatives': 'Comparatives/Superlatives',
                'gerunds_infinitives': 'Gerunds/Infinitives',
                'tenses': 'Tenses',
                'general': 'General'
            };

            return `
            <div class="grammar-result-item ${isCorrect ? 'correct' : 'incorrect'}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="result-question">
                        <span style="color: #10b981; font-weight: 700;">Câu ${index + 1}:</span> ${detail.question}
                    </div>
                    <span class="grammar-point-badge point-${detail.grammar_point || 'general'}">
                        ${grammarLabels[detail.grammar_point] || 'Grammar'}
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
    }
</script>