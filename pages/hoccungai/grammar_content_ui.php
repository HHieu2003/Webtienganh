<!-- GRAMMAR SECTION -->
<section id="grammar-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-book"></i>
                Luyện Ngữ Pháp (Grammar)
            </h2>
            <button class="btn btn-primary btn-sm" id="grammar-generate-btn">
                <i class="fas fa-plus"></i> Tạo bài mới
            </button>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Củng cố kiến thức ngữ pháp tiếng Anh.</p>
            
            <div class="form-group">
                <label class="form-label">Chủ đề ngữ pháp:</label>
                <select id="grammar-topic" class="form-control">
                    <option value="tenses">Tenses (Thì)</option>
                    <option value="conditionals">Conditionals (Câu điều kiện)</option>
                    <option value="passive">Passive Voice (Câu bị động)</option>
                    <option value="reported">Reported Speech (Câu gián tiếp)</option>
                    <option value="modals">Modal Verbs (Động từ khuyết thiếu)</option>
                    <option value="articles">Articles (Mạo từ)</option>
                </select>
            </div>

            <div id="grammar-exercise-container" class="mt-4" style="display: none;">
                <div id="grammar-content"></div>
                <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg" id="grammar-submit-btn">
                        <i class="fas fa-check"></i> Nộp bài
                    </button>
                </div>
                <div id="grammar-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

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
        const topic = document.getElementById('grammar-topic').value;
        Utils.showLoading('Đang tạo bài tập ngữ pháp...');

        try {
            const result = await Utils.apiRequest('grammar_api.php', {
                action: 'generate',
                topic: topic
            });

            if (result.success) {
                currentExercise = result.data;
                displayGrammarExercise(currentExercise);
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
        const answers = collectGrammarAnswers();

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
        document.getElementById('grammar-exercise-container').style.display = 'block';
        const content = document.getElementById('grammar-content');
        content.innerHTML = '';
        
        exercise.questions.forEach((q, i) => {
            const qDiv = document.createElement('div');
            qDiv.className = 'ai-card mb-3';
            qDiv.innerHTML = `<h4>Câu ${i+1}: ${q.question}</h4>` +
                q.options.map((opt, j) => `
                    <div class="mb-2">
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 0.75rem; background: var(--bg-secondary); border-radius: var(--border-radius-sm);">
                            <input type="radio" name="grammar-q${i}" value="${j}" style="margin-right: 0.75rem;">
                            <span>${opt}</span>
                        </label>
                    </div>
                `).join('');
            content.appendChild(qDiv);
        });
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
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3><i class="fas fa-trophy"></i> Kết quả: ${results.correct_count}/${results.total_count} đúng</h3>
                <div style="font-size: 1.5rem;">Điểm: ${results.score.toFixed(1)}/10</div>
            </div>
        `;
    }
}
</script>
