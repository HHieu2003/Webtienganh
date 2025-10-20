<!-- VOCABULARY SECTION -->
<section id="vocabulary-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-spell-check"></i>
                Luyện Từ Vựng (Vocabulary)
            </h2>
            <button class="btn btn-primary btn-sm" id="vocab-generate-btn">
                <i class="fas fa-plus"></i> Tạo bài mới
            </button>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Mở rộng vốn từ vựng tiếng Anh với các bài tập thực hành.</p>
            
            <div class="form-group">
                <label class="form-label">Chủ đề:</label>
                <select id="vocab-topic" class="form-control">
                    <option value="business">Business (Kinh doanh)</option>
                    <option value="technology">Technology (Công nghệ)</option>
                    <option value="health">Health (Sức khỏe)</option>
                    <option value="education">Education (Giáo dục)</option>
                    <option value="travel">Travel (Du lịch)</option>
                    <option value="environment">Environment (Môi trường)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Loại bài tập:</label>
                <select id="vocab-exercise-type" class="form-control">
                    <option value="matching">Matching (Nối từ)</option>
                    <option value="fill-blank">Fill in the blanks (Điền vào chỗ trống)</option>
                    <option value="synonym">Synonyms (Từ đồng nghĩa)</option>
                    <option value="definition">Definitions (Định nghĩa)</option>
                </select>
            </div>

            <div id="vocab-exercise-container" class="mt-4" style="display: none;">
                <div id="vocab-content"></div>
                <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg" id="vocab-submit-btn">
                        <i class="fas fa-check"></i> Nộp bài
                    </button>
                </div>
                <div id="vocab-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'vocabulary') {
        initVocabularySection();
    }
});

function initVocabularySection() {
    const generateBtn = document.getElementById('vocab-generate-btn');
    const submitBtn = document.getElementById('vocab-submit-btn');
    let currentExercise = null;

    generateBtn?.addEventListener('click', async () => {
        const topic = document.getElementById('vocab-topic').value;
        const type = document.getElementById('vocab-exercise-type').value;

        Utils.showLoading('Đang tạo bài tập từ vựng...');

        try {
            const result = await Utils.apiRequest('vocabulary_api.php', {
                action: 'generate',
                topic: topic,
                type: type
            });

            if (result.success) {
                currentExercise = result.data;
                displayVocabExercise(currentExercise);
                Utils.showToast('Đã tạo bài tập!', 'success');
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
        const answers = collectVocabAnswers();

        Utils.showLoading('Đang chấm bài...');

        try {
            const result = await Utils.apiRequest('vocabulary_api.php', {
                action: 'check',
                exercise: JSON.stringify(currentExercise),
                answers: JSON.stringify(answers)
            });

            if (result.success) {
                displayVocabResults(result.data);
                Utils.showToast('Đã chấm bài!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể chấm bài', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    function displayVocabExercise(exercise) {
        document.getElementById('vocab-exercise-container').style.display = 'block';
        const content = document.getElementById('vocab-content');
        content.innerHTML = '';
        
        exercise.questions.forEach((q, i) => {
            const qDiv = document.createElement('div');
            qDiv.className = 'ai-card mb-3';
            qDiv.innerHTML = `<h4>Câu ${i+1}: ${q.question}</h4>` +
                q.options.map((opt, j) => `
                    <div class="mb-2">
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 0.75rem; background: var(--bg-secondary); border-radius: var(--border-radius-sm);">
                            <input type="radio" name="vocab-q${i}" value="${j}" style="margin-right: 0.75rem;">
                            <span>${opt}</span>
                        </label>
                    </div>
                `).join('');
            content.appendChild(qDiv);
        });
    }

    function collectVocabAnswers() {
        const answers = [];
        if (currentExercise) {
            currentExercise.questions.forEach((q, i) => {
                const selected = document.querySelector(`input[name="vocab-q${i}"]:checked`);
                answers.push(selected ? parseInt(selected.value) : -1);
            });
        }
        return answers;
    }

    function displayVocabResults(results) {
        const resultsDiv = document.getElementById('vocab-results');
        resultsDiv.style.display = 'block';
        
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3><i class="fas fa-trophy"></i> Kết quả: ${results.correct_count}/${results.total_count} đúng</h3>
                <div style="font-size: 1.5rem;">Điểm: ${results.score.toFixed(1)}/10</div>
            </div>
        `;
    }
}
</script>
