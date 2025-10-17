<!-- ============================================ -->
<!-- LISTENING CONTENT -->
<!-- ============================================ -->
<div id="listening-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-headphones"></i> Luyện Nghe (Listening)</h2>
        <p>Rèn luyện khả năng nghe hiểu tiếng Anh qua các bài học thực tế</p>
    </div>

    <!-- Listening Controls -->
    <div class="listening-controls">
        <div class="control-group">
            <label for="listening-level">
                <i class="fas fa-layer-group"></i> Trình độ:
            </label>
            <select id="listening-level" class="level-select">
                <option value="beginner">Beginner</option>
                <option value="intermediate" selected>Intermediate</option>
                <option value="advanced">Advanced</option>
            </select>
        </div>
        
        <div class="control-group">
            <label for="listening-category">
                <i class="fas fa-folder"></i> Chủ đề:
            </label>
            <select id="listening-category" class="category-select">
                <option value="all">Tất cả</option>
                <option value="daily-conversation">Hội thoại hàng ngày</option>
                <option value="business">Kinh doanh</option>
                <option value="travel">Du lịch</option>
                <option value="academic">Học thuật</option>
            </select>
        </div>

        <button id="load-listening-btn" class="btn-primary">
            <i class="fas fa-random"></i> Tải bài mới
        </button>
    </div>

    <!-- Lesson Display -->
    <div class="lesson-container">
        <div class="lesson-header">
            <div class="lesson-info">
                <h3 id="lesson-title">Đang tải bài học...</h3>
                <div class="lesson-meta">
                    <span class="meta-item">
                        <i class="fas fa-signal"></i>
                        <span id="lesson-level">-</span>
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span id="lesson-duration">-</span>
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-folder"></i>
                        <span id="lesson-category">-</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Audio Player -->
        <div class="audio-player-container">
            <audio id="listening-audio" controls preload="metadata">
                <source src="" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            
            <div class="player-controls">
                <button id="play-pause-btn" class="control-btn" title="Play/Pause">
                    <i class="fas fa-play"></i>
                </button>
                <button id="rewind-btn" class="control-btn" title="Rewind 5s">
                    <i class="fas fa-backward"></i>
                </button>
                <button id="forward-btn" class="control-btn" title="Forward 5s">
                    <i class="fas fa-forward"></i>
                </button>
                
                <div class="time-display">
                    <span id="current-time">0:00</span> / <span id="total-time">0:00</span>
                </div>
                
                <div class="speed-control">
                    <label><i class="fas fa-tachometer-alt"></i></label>
                    <select id="playback-speed">
                        <option value="0.5">0.5x</option>
                        <option value="0.75">0.75x</option>
                        <option value="1" selected>1x</option>
                        <option value="1.25">1.25x</option>
                        <option value="1.5">1.5x</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Transcript Toggle -->
        <div class="transcript-toggle">
            <button id="show-transcript-btn" class="btn-secondary">
                <i class="fas fa-file-alt"></i> Hiện transcript
            </button>
            <button id="hide-transcript-btn" class="btn-secondary" style="display: none;">
                <i class="fas fa-eye-slash"></i> Ẩn transcript
            </button>
        </div>

        <!-- Transcript -->
        <div id="transcript-container" class="transcript-container" style="display: none;">
            <h4><i class="fas fa-file-alt"></i> Nội dung bài nghe</h4>
            <div id="transcript-content" class="transcript-content">
                <!-- Transcript will be loaded here -->
            </div>
        </div>

        <!-- Questions -->
        <div class="questions-container">
            <h4><i class="fas fa-question-circle"></i> Câu hỏi (Tổng: <span id="total-questions">0</span>)</h4>
            <div id="questions-list" class="questions-list">
                <!-- Questions will be loaded here -->
            </div>
            
            <button id="check-listening-answers-btn" class="btn-primary" style="display: none;">
                <i class="fas fa-check-circle"></i> Kiểm tra đáp án
            </button>
        </div>

        <!-- Results -->
        <div id="listening-results" class="results-container" style="display: none;">
            <!-- Results will be displayed here -->
        </div>
    </div>
</div>
