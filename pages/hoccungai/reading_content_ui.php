<!-- ============================================ -->
<!-- READING CONTENT -->
<!-- ============================================ -->
<div id="reading-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-book-open"></i> Luyện Đọc (Reading)</h2>
        <p>Nâng cao kỹ năng đọc hiểu qua các bài văn đa dạng</p>
    </div>

    <!-- Reading Controls -->
    <div class="reading-controls">
        <div class="control-group">
            <label for="reading-level">
                <i class="fas fa-layer-group"></i> Trình độ:
            </label>
            <select id="reading-level" class="level-select">
                <option value="beginner">Beginner</option>
                <option value="intermediate" selected>Intermediate</option>
                <option value="advanced">Advanced</option>
            </select>
        </div>
        
        <div class="control-group">
            <label for="reading-category">
                <i class="fas fa-tag"></i> Thể loại:
            </label>
            <select id="reading-category" class="category-select">
                <option value="all">Tất cả</option>
                <option value="news">Tin tức</option>
                <option value="story">Truyện ngắn</option>
                <option value="science">Khoa học</option>
                <option value="lifestyle">Lối sống</option>
                <option value="culture">Văn hóa</option>
            </select>
        </div>

        <button id="load-article-btn" class="btn-primary">
            <i class="fas fa-book"></i> Tải bài đọc mới
        </button>
    </div>

    <!-- Article Container -->
    <div class="article-container">
        <div class="article-header">
            <h3 id="article-title">Đang tải bài đọc...</h3>
            <div class="article-meta">
                <span class="meta-badge" id="article-level">-</span>
                <span class="meta-badge" id="article-category">-</span>
                <span class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span id="reading-time">- min</span>
                </span>
            </div>
        </div>

        <!-- Reading Tools -->
        <div class="reading-tools">
            <button id="text-to-speech-btn" class="tool-btn">
                <i class="fas fa-volume-up"></i> Đọc cho tôi
            </button>
            <button id="highlight-mode-btn" class="tool-btn">
                <i class="fas fa-highlighter"></i> Highlight
            </button>
            <button id="dictionary-btn" class="tool-btn">
                <i class="fas fa-book"></i> Từ điển
            </button>
            
            <div class="font-size-control">
                <label><i class="fas fa-text-height"></i></label>
                <button id="decrease-font" class="size-btn">A-</button>
                <button id="increase-font" class="size-btn">A+</button>
            </div>
        </div>

        <!-- Article Content -->
        <div id="article-content" class="article-content" data-font-size="medium">
            <div class="loading">
                <i class="fas fa-spinner fa-spin"></i> Đang tải nội dung...
            </div>
        </div>

        <!-- Vocabulary Helper (Popup) -->
        <div id="word-popup" class="word-popup" style="display: none;">
            <div class="popup-header">
                <strong id="popup-word"></strong>
                <button id="close-popup" class="close-btn">×</button>
            </div>
            <div class="popup-content">
                <div class="pronunciation">
                    <span id="popup-pronunciation"></span>
                    <button id="play-word-audio" class="play-word-btn">
                        <i class="fas fa-volume-up"></i>
                    </button>
                </div>
                <div class="definition" id="popup-definition">
                    Đang tra cứu...
                </div>
            </div>
        </div>

        <!-- Comprehension Questions -->
        <div class="comprehension-section">
            <h4><i class="fas fa-question-circle"></i> Câu hỏi đọc hiểu</h4>
            <div id="reading-questions" class="reading-questions">
                <!-- Questions will be loaded here -->
            </div>
            
            <button id="check-reading-answers-btn" class="btn-primary" style="display: none;">
                <i class="fas fa-check-circle"></i> Kiểm tra đáp án
            </button>
        </div>

        <!-- Reading Results -->
        <div id="reading-results" class="reading-results" style="display: none;">
            <!-- Results will be displayed here -->
        </div>
    </div>
</div>
