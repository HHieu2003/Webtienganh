<!-- ============================================ -->
<!-- WRITING CONTENT -->
<!-- ============================================ -->
<div id="writing-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-pen-fancy"></i> Luyện Viết (Writing)</h2>
        <p>Phát triển kỹ năng viết tiếng Anh với sự hỗ trợ của AI</p>
    </div>

    <!-- Writing Type Tabs -->
    <div class="writing-type-tabs">
        <button class="writing-type-tab active" data-type="essay">
            <i class="fas fa-file-alt"></i>
            <span>Bài luận</span>
        </button>
        <button class="writing-type-tab" data-type="email">
            <i class="fas fa-envelope"></i>
            <span>Email</span>
        </button>
        <button class="writing-type-tab" data-type="paragraph">
            <i class="fas fa-paragraph"></i>
            <span>Đoạn văn</span>
        </button>
        <button class="writing-type-tab" data-type="letter">
            <i class="fas fa-mail-bulk"></i>
            <span>Thư</span>
        </button>
        <button class="writing-type-tab" data-type="report">
            <i class="fas fa-chart-line"></i>
            <span>Báo cáo</span>
        </button>
    </div>

    <!-- Writing Settings -->
    <div class="writing-settings">
        <div class="setting-group">
            <label for="writing-level-select">
                <i class="fas fa-layer-group"></i> Trình độ:
            </label>
            <select id="writing-level-select" class="level-select">
                <option value="beginner">Beginner (100-150 từ)</option>
                <option value="intermediate" selected>Intermediate (200-250 từ)</option>
                <option value="advanced">Advanced (300-400 từ)</option>
            </select>
        </div>
        <button id="generate-topic-btn" class="btn-secondary">
            <i class="fas fa-random"></i> Tạo đề mới
        </button>
    </div>

    <!-- Topic Display -->
    <div class="topic-display">
        <div class="loading">
            <i class="fas fa-spinner fa-spin"></i> Đang tải đề bài...
        </div>
    </div>

    <!-- Writing Instructions -->
    <div class="writing-instructions">
        <i class="fas fa-info-circle"></i> Viết một bài luận hoàn chỉnh với Introduction, Body, và Conclusion.
    </div>

    <!-- Writing Editor -->
    <div class="writing-editor-container">
        <div class="editor-toolbar">
            <div class="word-count">
                <i class="fas fa-text-width"></i> 
                <span>0 từ / 0 ký tự</span>
            </div>
            <div class="writing-progress-bar" style="--progress: 0%"></div>
        </div>
        
        <textarea 
            id="writing-textarea" 
            class="writing-textarea" 
            placeholder="Bắt đầu viết bài của bạn tại đây...

Mẹo: Bôi đen văn bản và nhấn 'Viết lại câu' để được gợi ý cách diễn đạt khác."
            spellcheck="true"
        ></textarea>
        
        <div class="editor-actions">
            <button id="check-writing-btn" class="btn-primary">
                <i class="fas fa-check-circle"></i> Kiểm tra bài viết
            </button>
            <button id="get-suggestions-btn" class="btn-secondary">
                <i class="fas fa-lightbulb"></i> Gợi ý viết bài
            </button>
            <button id="paraphrase-btn" class="btn-secondary">
                <i class="fas fa-sync-alt"></i> Viết lại câu
            </button>
            <button id="save-draft-btn" class="btn-secondary">
                <i class="fas fa-save"></i> Lưu nháp
            </button>
            <button id="clear-writing-btn" class="btn-danger">
                <i class="fas fa-trash"></i> Xóa
            </button>
        </div>
    </div>

    <!-- Writing Feedback -->
    <div class="writing-feedback"></div>

    <!-- Writing Suggestions -->
    <div class="writing-suggestions"></div>

</div>
