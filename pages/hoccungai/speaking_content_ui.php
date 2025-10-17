<!-- ============================================ -->
<!-- SPEAKING CONTENT -->
<!-- ============================================ -->
<div id="speaking-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-microphone"></i> Luyện Nói (Speaking)</h2>
        <p>Cải thiện kỹ năng phát âm và giao tiếp tiếng Anh</p>
    </div>

    <!-- Speaking Mode Selection -->
    <div class="speaking-modes">
        <button class="mode-btn active" data-mode="pronunciation">
            <i class="fas fa-volume-up"></i>
            <span>Luyện Phát Âm</span>
        </button>
        <button class="mode-btn" data-mode="conversation">
            <i class="fas fa-comments"></i>
            <span>Hội Thoại</span>
        </button>
        <button class="mode-btn" data-mode="free-speaking">
            <i class="fas fa-microphone-alt"></i>
            <span>Nói Tự Do</span>
        </button>
    </div>

    <!-- Pronunciation Mode -->
    <div id="pronunciation-mode" class="speaking-mode-content">
        <div class="practice-card">
            <div class="card-header">
                <h3><i class="fas fa-book-open"></i> Câu cần luyện</h3>
                <button id="generate-sentence-btn" class="btn-secondary">
                    <i class="fas fa-random"></i> Câu khác
                </button>
            </div>
            
            <div class="target-text-display">
                <div id="target-text" class="target-text">
                    Click to Practice: The quick brown fox jumps over the lazy dog.
                </div>
                <button id="play-target-audio-btn" class="play-btn">
                    <i class="fas fa-volume-up"></i> Nghe mẫu
                </button>
            </div>

            <div class="recording-section">
                <div class="recording-controls">
                    <button id="start-recording-btn" class="record-btn">
                        <i class="fas fa-microphone"></i>
                        <span>Bắt đầu thu âm</span>
                    </button>
                    <button id="stop-recording-btn" class="record-btn recording" style="display: none;">
                        <i class="fas fa-stop-circle"></i>
                        <span>Dừng thu âm</span>
                    </button>
                </div>
                
                <div id="recording-timer" class="recording-timer" style="display: none;">
                    <i class="fas fa-circle recording-indicator"></i>
                    <span>Recording... <span id="timer-display">0:00</span></span>
                </div>
            </div>

            <!-- Transcript Display -->
            <div id="speech-transcript" class="speech-transcript" style="display: none;">
                <h4><i class="fas fa-text"></i> Bạn đã nói:</h4>
                <div id="transcript-result" class="transcript-result">
                    Chưa có transcript...
                </div>
            </div>

            <!-- Evaluation Result -->
            <div id="pronunciation-result" class="evaluation-result" style="display: none;">
                <!-- AI evaluation will be displayed here -->
            </div>
        </div>
    </div>

    <!-- Conversation Mode -->
    <div id="conversation-mode" class="speaking-mode-content" style="display: none;">
        <div class="conversation-container">
            <div class="conversation-settings">
                <div class="setting-group">
                    <label>Chủ đề:</label>
                    <select id="conversation-topic" class="topic-select">
                        <option value="greeting">Chào hỏi</option>
                        <option value="shopping">Mua sắm</option>
                        <option value="restaurant">Nhà hàng</option>
                        <option value="direction">Hỏi đường</option>
                        <option value="interview">Phỏng vấn</option>
                    </select>
                </div>
                <button id="start-conversation-btn" class="btn-primary">
                    <i class="fas fa-play"></i> Bắt đầu hội thoại
                </button>
            </div>

            <div id="conversation-messages" class="conversation-messages">
                <div class="message ai-message">
                    <i class="fas fa-robot"></i>
                    <div class="message-content">
                        Xin chào! Hãy chọn chủ đề và bắt đầu hội thoại nhé.
                    </div>
                </div>
            </div>

            <div class="conversation-input">
                <button id="speak-response-btn" class="btn-primary">
                    <i class="fas fa-microphone"></i> Trả lời
                </button>
                <button id="next-conversation-btn" class="btn-secondary" style="display: none;">
                    <i class="fas fa-forward"></i> Câu tiếp theo
                </button>
            </div>
        </div>
    </div>

    <!-- Free Speaking Mode -->
    <div id="free-speaking-mode" class="speaking-mode-content" style="display: none;">
        <div class="free-speaking-container">
            <div class="prompt-card">
                <h3><i class="fas fa-lightbulb"></i> Chủ đề gợi ý</h3>
                <div id="speaking-prompt" class="speaking-prompt">
                    Talk about your favorite hobby and why you enjoy it.
                </div>
                <button id="new-prompt-btn" class="btn-secondary">
                    <i class="fas fa-random"></i> Chủ đề khác
                </button>
            </div>

            <div class="free-speaking-controls">
                <button id="start-free-speaking-btn" class="btn-primary large">
                    <i class="fas fa-microphone"></i> Bắt đầu nói
                </button>
                <button id="stop-free-speaking-btn" class="btn-danger large" style="display: none;">
                    <i class="fas fa-stop"></i> Kết thúc
                </button>
            </div>

            <div id="free-speaking-timer" class="speaking-timer" style="display: none;">
                <i class="fas fa-clock"></i>
                <span id="speaking-time">0:00</span>
            </div>

            <div id="free-speaking-transcript" class="free-speaking-transcript" style="display: none;">
                <h4><i class="fas fa-file-alt"></i> Nội dung bạn đã nói</h4>
                <div id="free-transcript-content" class="transcript-content"></div>
            </div>

            <div id="free-speaking-feedback" class="speaking-feedback" style="display: none;">
                <!-- AI feedback will be displayed here -->
            </div>
        </div>
    </div>

    <!-- Browser Support Warning -->
    <div id="browser-warning" class="warning-box" style="display: none;">
        <i class="fas fa-exclamation-triangle"></i>
        Trình duyệt của bạn không hỗ trợ ghi âm. Vui lòng sử dụng Chrome, Edge, hoặc Safari.
    </div>
</div>
