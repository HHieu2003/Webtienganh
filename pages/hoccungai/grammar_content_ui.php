<!-- ============================================ -->
<!-- GRAMMAR CONTENT -->
<!-- ============================================ -->
<div id="grammar-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-book"></i> Ngữ Pháp (Grammar)</h2>
        <p>Nắm vững các quy tắc ngữ pháp tiếng Anh</p>
    </div>

    <!-- Grammar Topics -->
    <div class="grammar-topics">
        <div class="topic-grid">
            <div class="topic-card" data-topic="tenses">
                <i class="fas fa-clock"></i>
                <h3>Thì (Tenses)</h3>
                <p>12 thì trong tiếng Anh</p>
                <span class="lesson-count">24 bài học</span>
            </div>

            <div class="topic-card" data-topic="conditionals">
                <i class="fas fa-question"></i>
                <h3>Câu điều kiện</h3>
                <p>4 loại câu điều kiện</p>
                <span class="lesson-count">8 bài học</span>
            </div>

            <div class="topic-card" data-topic="passive-voice">
                <i class="fas fa-exchange-alt"></i>
                <h3>Câu bị động</h3>
                <p>Passive Voice</p>
                <span class="lesson-count">6 bài học</span>
            </div>

            <div class="topic-card" data-topic="reported-speech">
                <i class="fas fa-quote-left"></i>
                <h3>Câu gián tiếp</h3>
                <p>Reported Speech</p>
                <span class="lesson-count">5 bài học</span>
            </div>

            <div class="topic-card" data-topic="modal-verbs">
                <i class="fas fa-language"></i>
                <h3>Modal Verbs</h3>
                <p>Can, Could, Must, Should...</p>
                <span class="lesson-count">10 bài học</span>
            </div>

            <div class="topic-card" data-topic="articles">
                <i class="fas fa-font"></i>
                <h3>Mạo từ</h3>
                <p>A, An, The</p>
                <span class="lesson-count">4 bài học</span>
            </div>

            <div class="topic-card" data-topic="prepositions">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Giới từ</h3>
                <p>Prepositions</p>
                <span class="lesson-count">12 bài học</span>
            </div>

            <div class="topic-card" data-topic="adjectives">
                <i class="fas fa-adjust"></i>
                <h3>Tính từ & Trạng từ</h3>
                <p>Adjectives & Adverbs</p>
                <span class="lesson-count">8 bài học</span>
            </div>
        </div>
    </div>

    <!-- Grammar Lesson Detail -->
    <div id="grammar-lesson-detail" class="grammar-lesson-detail" style="display: none;">
        <button id="back-to-topics" class="btn-back">
            <i class="fas fa-arrow-left"></i> Quay lại
        </button>

        <div class="lesson-content">
            <div class="lesson-title">
                <h3 id="grammar-lesson-title">Present Simple Tense</h3>
                <span class="difficulty-badge">Beginner</span>
            </div>

            <!-- Theory Section -->
            <div class="theory-section">
                <h4><i class="fas fa-book-open"></i> Lý thuyết</h4>
                <div id="grammar-theory" class="theory-content">
                    <!-- Theory content will be loaded here -->
                </div>
            </div>

            <!-- Examples Section -->
            <div class="examples-section">
                <h4><i class="fas fa-lightbulb"></i> Ví dụ</h4>
                <div id="grammar-examples" class="examples-list">
                    <!-- Examples will be loaded here -->
                </div>
            </div>

            <!-- Practice Section -->
            <div class="practice-section">
                <h4><i class="fas fa-pen"></i> Bài tập thực hành</h4>
                <div id="grammar-exercises" class="exercises-container">
                    <!-- Exercises will be loaded here -->
                </div>
                
                <button id="check-grammar-exercises" class="btn-primary">
                    <i class="fas fa-check-circle"></i> Kiểm tra bài tập
                </button>
            </div>

            <!-- Results -->
            <div id="grammar-results" class="grammar-results" style="display: none;">
                <!-- Results will be displayed here -->
            </div>
        </div>
    </div>

    <!-- Quick Grammar Check -->
    <div class="quick-check-section">
        <h3><i class="fas fa-spell-check"></i> Kiểm tra ngữ pháp nhanh</h3>
        <p>Nhập câu tiếng Anh để AI kiểm tra ngữ pháp</p>
        
        <div class="grammar-check-box">
            <textarea 
                id="grammar-check-input" 
                placeholder="Enter your sentence here...&#10;Example: I goes to school everyday."
                rows="4"
            ></textarea>
            
            <button id="check-grammar-btn" class="btn-primary">
                <i class="fas fa-check"></i> Kiểm tra
            </button>
        </div>

        <div id="grammar-check-result" class="grammar-check-result" style="display: none;">
            <!-- Grammar check result will be displayed here -->
        </div>
    </div>
</div>
