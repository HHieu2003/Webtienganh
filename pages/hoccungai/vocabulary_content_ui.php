<!-- ============================================ -->
<!-- VOCABULARY CONTENT -->
<!-- ============================================ -->
<div id="vocabulary-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-spell-check"></i> Từ Vựng (Vocabulary)</h2>
        <p>Mở rộng vốn từ vựng tiếng Anh của bạn</p>
    </div>

    <!-- Vocabulary Modes -->
    <div class="vocab-modes">
        <button class="vocab-mode-btn active" data-mode="flashcards">
            <i class="fas fa-layer-group"></i>
            <span>Flashcards</span>
        </button>
        <button class="vocab-mode-btn" data-mode="quiz">
            <i class="fas fa-question-circle"></i>
            <span>Quiz</span>
        </button>
        <button class="vocab-mode-btn" data-mode="wordlist">
            <i class="fas fa-list"></i>
            <span>Danh sách</span>
        </button>
        <button class="vocab-mode-btn" data-mode="game">
            <i class="fas fa-gamepad"></i>
            <span>Trò chơi</span>
        </button>
    </div>

    <!-- Vocabulary Settings -->
    <div class="vocab-settings">
        <div class="setting-group">
            <label><i class="fas fa-folder"></i> Chủ đề:</label>
            <select id="vocab-topic" class="topic-select">
                <option value="common">Từ vựng thông dụng</option>
                <option value="business">Kinh doanh</option>
                <option value="technology">Công nghệ</option>
                <option value="travel">Du lịch</option>
                <option value="food">Ăn uống</option>
                <option value="health">Sức khỏe</option>
                <option value="education">Giáo dục</option>
            </select>
        </div>
        
        <div class="setting-group">
            <label><i class="fas fa-signal"></i> Level:</label>
            <select id="vocab-level" class="level-select">
                <option value="beginner">Beginner</option>
                <option value="intermediate" selected>Intermediate</option>
                <option value="advanced">Advanced</option>
            </select>
        </div>

        <button id="load-vocab-btn" class="btn-primary">
            <i class="fas fa-download"></i> Tải từ vựng
        </button>
    </div>

    <!-- Flashcards Mode -->
    <div id="flashcards-mode" class="vocab-mode-content">
        <div class="flashcard-container">
            <div class="flashcard-counter">
                <span id="current-card">1</span> / <span id="total-cards">20</span>
            </div>

            <div class="flashcard" id="flashcard">
                <div class="flashcard-inner">
                    <div class="flashcard-front">
                        <div class="word-display">
                            <h2 id="vocab-word">achievement</h2>
                            <div class="pronunciation">
                                <span id="vocab-pronunciation">/əˈtʃiːvmənt/</span>
                                <button id="play-vocab-audio" class="audio-btn">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flip-hint">
                            <i class="fas fa-sync-alt"></i> Click để xem nghĩa
                        </div>
                    </div>

                    <div class="flashcard-back">
                        <div class="meaning-display">
                            <h3>Nghĩa</h3>
                            <p id="vocab-meaning">thành tích, thành tựu</p>
                            
                            <h4>Ví dụ</h4>
                            <p id="vocab-example" class="example-sentence">
                                "Winning the championship was a great achievement."
                            </p>
                            
                            <h4>Từ loại</h4>
                            <span id="vocab-type" class="word-type">Noun</span>
                        </div>
                        <div class="flip-hint">
                            <i class="fas fa-sync-alt"></i> Click để quay lại
                        </div>
                    </div>
                </div>
            </div>

            <div class="flashcard-actions">
                <button id="prev-card-btn" class="nav-btn">
                    <i class="fas fa-chevron-left"></i> Trước
                </button>
                
                <div class="knowledge-buttons">
                    <button id="dont-know-btn" class="know-btn dont-know">
                        <i class="fas fa-times"></i> Chưa biết
                    </button>
                    <button id="know-btn" class="know-btn know">
                        <i class="fas fa-check"></i> Đã biết
                    </button>
                </div>
                
                <button id="next-card-btn" class="nav-btn">
                    Sau <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="progress-bar">
                <div id="flashcard-progress" class="progress-fill" style="width: 5%"></div>
            </div>
        </div>
    </div>

    <!-- Quiz Mode -->
    <div id="quiz-mode" class="vocab-mode-content" style="display: none;">
        <div class="quiz-container">
            <div class="quiz-header">
                <div class="quiz-info">
                    <span>Câu <span id="quiz-current">1</span>/<span id="quiz-total">10</span></span>
                </div>
                <div class="quiz-score">
                    Điểm: <span id="quiz-score">0</span>
                </div>
            </div>

            <div class="quiz-question-card">
                <div class="question-text" id="quiz-question">
                    What is the meaning of "<strong>achievement</strong>"?
                </div>

                <div class="quiz-options" id="quiz-options">
                    <button class="quiz-option" data-answer="a">
                        A. Thành tích, thành tựu
                    </button>
                    <button class="quiz-option" data-answer="b">
                        B. Hành động
                    </button>
                    <button class="quiz-option" data-answer="c">
                        C. Phiêu lưu
                    </button>
                    <button class="quiz-option" data-answer="d">
                        D. Quảng cáo
                    </button>
                </div>
            </div>

            <button id="submit-quiz-answer" class="btn-primary" style="display: none;">
                <i class="fas fa-check"></i> Xác nhận
            </button>
            <button id="next-quiz-question" class="btn-secondary" style="display: none;">
                Câu tiếp theo <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <div id="quiz-results" class="quiz-results" style="display: none;">
            <!-- Quiz results will be shown here -->
        </div>
    </div>

    <!-- Word List Mode -->
    <div id="wordlist-mode" class="vocab-mode-content" style="display: none;">
        <div class="wordlist-container">
            <div class="wordlist-tools">
                <input type="text" id="search-word" placeholder="Tìm kiếm từ..." class="search-input">
                <button id="sort-words-btn" class="tool-btn">
                    <i class="fas fa-sort-alpha-down"></i> Sắp xếp
                </button>
                <button id="export-words-btn" class="tool-btn">
                    <i class="fas fa-download"></i> Xuất
                </button>
            </div>

            <div class="wordlist-table">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Từ vựng</th>
                            <th>Phát âm</th>
                            <th>Nghĩa</th>
                            <th>Loại từ</th>
                            <th>Ví dụ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="wordlist-body">
                        <!-- Word list will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Game Mode -->
    <div id="game-mode" class="vocab-mode-content" style="display: none;">
        <div class="vocab-game-container">
            <div class="game-selector">
                <div class="game-card" data-game="matching">
                    <i class="fas fa-puzzle-piece"></i>
                    <h3>Matching Game</h3>
                    <p>Ghép từ với nghĩa</p>
                    <button class="btn-primary">Chơi</button>
                </div>
                
                <div class="game-card" data-game="typing">
                    <i class="fas fa-keyboard"></i>
                    <h3>Typing Challenge</h3>
                    <p>Đánh vần từ vựng</p>
                    <button class="btn-primary">Chơi</button>
                </div>
                
                <div class="game-card" data-game="memory">
                    <i class="fas fa-brain"></i>
                    <h3>Memory Cards</h3>
                    <p>Trí nhớ siêu phàm</p>
                    <button class="btn-primary">Chơi</button>
                </div>
            </div>

            <div id="game-area" class="game-area" style="display: none;">
                <!-- Game content will be loaded here -->
            </div>
        </div>
    </div>
</div>
