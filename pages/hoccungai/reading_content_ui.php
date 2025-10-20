<!-- READING SECTION -->
<section id="reading-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-book-open"></i>
                Luyện Đọc (Reading)
            </h2>
            <button class="btn btn-primary btn-sm" id="reading-generate-btn">
                <i class="fas fa-plus"></i> Tạo bài mới
            </button>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Nâng cao kỹ năng đọc hiểu tiếng Anh với các bài đọc đa dạng.</p>
            
            <div class="form-group">
                <label class="form-label">Cấp độ:</label>
                <select id="reading-level" class="form-control">
                    <option value="beginner">Beginner (A1-A2)</option>
                    <option value="intermediate" selected>Intermediate (B1-B2)</option>
                    <option value="advanced">Advanced (C1-C2)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Chủ đề:</label>
                <input type="text" id="reading-topic" class="form-control" placeholder="Ví dụ: khoa học, văn hóa, công nghệ...">
            </div>

            <div id="reading-exercise-container" class="mt-4" style="display: none;">
                <div class="ai-card mb-4" style="background: var(--bg-secondary);">
                    <h3 class="mb-3">Bài đọc</h3>
                    <div id="reading-passage" style="line-height: 2; font-size: 1.05rem;"></div>
                </div>

                <div id="reading-questions-container"></div>

                <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg" id="reading-submit-btn">
                        <i class="fas fa-check"></i> Nộp bài
                    </button>
                </div>

                <div id="reading-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

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

        Utils.showLoading('Đang tạo bài đọc...');

        try {
            const result = await Utils.apiRequest('reading_api.php', {
                action: 'generate',
                level: level,
                topic: topic
            });

            if (result.success) {
                currentExercise = result.data;
                displayReadingExercise(currentExercise);
                Utils.showToast('Đã tạo bài đọc!', 'success');
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
        document.getElementById('reading-exercise-container').style.display = 'block';
        document.getElementById('reading-passage').innerHTML = exercise.passage.replace(/\n/g, '<br><br>');
        
        const questionsContainer = document.getElementById('reading-questions-container');
        questionsContainer.innerHTML = '';
        
        exercise.questions.forEach((q, i) => {
            const qDiv = document.createElement('div');
            qDiv.className = 'ai-card mb-3';
            qDiv.innerHTML = `<h4>Câu ${i+1}: ${q.question}</h4>` +
                q.options.map((opt, j) => `
                    <div class="mb-2">
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 0.75rem; background: var(--bg-secondary); border-radius: var(--border-radius-sm);">
                            <input type="radio" name="reading-q${i}" value="${j}" style="margin-right: 0.75rem;">
                            <span>${opt}</span>
                        </label>
                    </div>
                `).join('');
            questionsContainer.appendChild(qDiv);
        });
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
        
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3><i class="fas fa-trophy"></i> Kết quả</h3>
                <div style="font-size: 2rem; font-weight: bold;">${results.correct_count}/${results.total_count} đúng</div>
                <div style="font-size: 1.5rem;">Điểm: ${results.score.toFixed(1)}/10</div>
            </div>
            <div class="ai-card mt-3">
                <h4>Chi tiết:</h4>
                ${results.details.map((d, i) => `
                    <div class="mb-3 p-3" style="background: ${d.is_correct ? '#d1fae5' : '#fee2e2'}; border-radius: var(--border-radius-sm);">
                        <strong>Câu ${i+1}:</strong> ${d.question}<br>
                        <span style="color: ${d.is_correct ? '#065f46' : '#991b1b'};">${d.is_correct ? '✓ Đúng' : '✗ Sai'}</span><br>
                        ${!d.is_correct ? `<small>Đáp án đúng: ${d.correct_answer}</small>` : ''}
                    </div>
                `).join('')}
            </div>
        `;
    }
}
</script>
