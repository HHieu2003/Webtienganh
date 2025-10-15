<!-- Footer với AI Chatbot Hybrid + Speech Practice -->
<footer class="footer-wrapper-light" data-aos="fade-up">
    <div class="container">
        <div class="footer-main">
            <div class="footer-content about-us">
                <a href="./index.php" class="footer-logo-link">
                    <img class="logo-footer" src="images/logo2.jpg" alt="Logo Tiếng Anh Fighter">
                    <div>
                        <div class="logo-item">Tiếng Anh Fighter!</div>
                        <div class="logo-row">Learning is an adventure!</div>
                    </div>
                </a>
                <p class="about-text">Nền tảng học Tiếng Anh toàn diện, giúp bạn tự tin chinh phục mọi mục tiêu học tập và sự nghiệp.</p>
                
                <!-- AI Assistant Info -->
                <div class="ai-assistant-info">
                    <h5><i class="fa-solid fa-brain"></i> AI Assistant 3-in-1</h5>
                    <p><strong>Tư vấn</strong> + <strong>Dạy học</strong> + <strong>Luyện nói</strong></p>
                    <button class="btn-chat-now" onclick="document.getElementById('chatbot-toggler').click();">
                        <i class="fa-solid fa-robot"></i> Chat AI
                    </button>
                </div>
                
                <div class="social-icons">
                    <a href="https://facebook.com/englishfighter" aria-label="Facebook" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://youtube.com/englishfighter" aria-label="Youtube" title="Youtube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="https://t.me/englishfighter" aria-label="Telegram" title="Telegram">
                        <i class="fa-brands fa-telegram"></i>
                    </a>
                    <a href="https://zalo.me/0962501832" aria-label="Zalo" title="Zalo">
                        <i class="fa-solid fa-comment-dots"></i>
                    </a>
                </div>
            </div>

            <div class="footer-content quick-links">
                <h4>VỀ TIẾNG ANH FIGHTER</h4>
                <ul class="footer-links">
                    <li><a href="./index.php?nav=about">Giới thiệu về trung tâm</a></li>
                    <li><a href="./index.php?nav=khoahoc">Tất cả khóa học</a></li>
                    <li><a href="./index.php?nav=huongdandangky">Hướng dẫn đăng ký</a></li>
                    <li><a href="./pages/login.php">Đăng nhập / Đăng ký</a></li>
                    <li><a href="./index.php?nav=lecturers">Đội ngũ giảng viên</a></li>
                </ul>
                
                <!-- AI Features Links -->
                <h4 style="margin-top: 25px;">🤖 AI FEATURES</h4>
                <ul class="footer-links ai-features">
                    <li><a href="javascript:void(0);" onclick="openChatWithMessage('📊 Xem thống kê trung tâm', 'customer_service')">📊 Thống kê realtime</a></li>
                    <li><a href="javascript:void(0);" onclick="openChatWithMessage('📚 Danh sách khóa học', 'customer_service')">📚 Tư vấn khóa học</a></li>
                    <li><a href="javascript:void(0);" onclick="openChatWithMessage('📖 Học ngữ pháp cơ bản', 'english_teacher')">📖 Học ngữ pháp</a></li>
                    <li><a href="javascript:void(0);" onclick="openChatWithMessage('🎤 Luyện nói với AI', 'speech_practice')">🎤 Luyện phát âm</a></li>
                </ul>
            </div>

            <div class="footer-content contact-info">
                <h4>THÔNG TIN LIÊN HỆ</h4>
                <ul class="footer-links-contact">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Lê Văn Lương - Thanh Xuân, Hà Nội</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>0962.501.832 - 0336.123.130</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:nthuphuong2710@gmail.com">nthuphuong2710@gmail.com</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-clock"></i>
                        <span>Giờ làm việc: 8:00 - 22:00 hàng ngày</span>
                    </li>
                </ul>
                
                <!-- Live Stats từ Database -->
                <div class="quick-stats">
                    <h5><i class="fa-solid fa-chart-line"></i> Thống Kê Live</h5>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number" id="footer-total-courses">--</span>
                            <span class="stat-label">Khóa học</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="footer-total-students">--</span>
                            <span class="stat-label">Học viên</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="footer-total-teachers">--</span>
                            <span class="stat-label">Giảng viên</span>
                        </div>
                    </div>
                </div>
                
                <img class="logo-footer-small" src="./images/logofooter.png" alt="Logo Bộ Công Thương">
            </div>
        </div>
    </div>

    <div class="footer-bar">
        <div class="container">
            <div class="footer-bar-content">
                <div class="left">
                    &copy; 2025 Bản quyền thuộc về <strong>Tiếng Anh Fighter</strong> - Hệ thống học tiếng Anh thông minh với AI.
                </div>
                <div class="right">
                    <a href="./index.php?nav=huongdandangky">Điều khoản dịch vụ</a>
                    <a href="./index.php?nav=huongdandangky">Chính sách bảo mật</a>
                    <a href="javascript:void(0);" onclick="document.getElementById('chatbot-toggler').click();">
                        <i class="fa-solid fa-brain"></i> Hybrid AI
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- HYBRID AI CHATBOT WITH SPEECH PRACTICE -->
<div class="chatbot" id="chatbot">
    <header>
        <h2>🤖 English Fighter AI</h2>
        <div class="header-controls">
            <div class="current-mode-indicator">
                <span id="current-mode-text">🏢 Customer Service</span>
            </div>
            <button id="expand-chatbot" title="Mở rộng chat">
                <i class="fa-solid fa-expand"></i>
            </button>
            <button id="close-chatbot" title="Đóng chat">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </header>
    
    <!-- Speech Practice Panel -->
    <div class="speech-practice-panel" id="speech-panel" style="display: none;">
        <div class="speech-header">
            <h4>🎤 Speech Practice with AI</h4>
            <button class="close-speech" onclick="closeSpeechPanel()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="speech-lesson" id="current-lesson">
            <div class="lesson-info">
                <div class="lesson-meta">
                    <span class="lesson-level" id="lesson-level">Beginner</span>
                    <span class="lesson-focus" id="lesson-focus">Basic pronunciation</span>
                </div>
                <h5 class="lesson-title" id="lesson-title">Self Introduction</h5>
            </div>
            
            <div class="lesson-text">
                <div class="target-text" id="target-text">
                    [translate:Hello, my name is John. I am from Vietnam. Nice to meet you.]
                </div>
                <div class="vietnamese-text" id="vietnamese-text">
                    Xin chào, tên tôi là John. Tôi đến từ Việt Nam. Rất vui được gặp bạn.
                </div>
            </div>
            
            <div class="speech-controls">
                <button class="speech-btn primary" id="start-recording" onclick="startRecording()">
                    <i class="fa-solid fa-microphone"></i> Bắt đầu nói
                </button>
                <button class="speech-btn secondary" id="stop-recording" onclick="stopRecording()" disabled>
                    <i class="fa-solid fa-stop"></i> Dừng lại
                </button>
                <button class="speech-btn tertiary" id="play-sample" onclick="playSample()">
                    <i class="fa-solid fa-volume-up"></i> Nghe mẫu
                </button>
                <button class="speech-btn quaternary" id="change-lesson" onclick="showLessonSelector()">
                    <i class="fa-solid fa-book"></i> Đổi bài
                </button>
            </div>
            
            <div class="recording-indicator" id="recording-indicator" style="display: none;">
                <div class="pulse-circle"></div>
                <span>🎤 Đang ghi âm... (<span id="record-timer">0</span>s)</span>
            </div>
            
            <div class="speech-results" id="speech-results" style="display: none;">
                <h5>📊 Kết quả phân tích AI</h5>
                <div class="score-grid">
                    <div class="score-item">
                        <div class="score-circle" id="pronunciation-score">0</div>
                        <span>Pronunciation</span>
                    </div>
                    <div class="score-item">
                        <div class="score-circle" id="fluency-score">0</div>
                        <span>Fluency</span>
                    </div>
                    <div class="score-item">
                        <div class="score-circle" id="accuracy-score">0</div>
                        <span>Accuracy</span>
                    </div>
                </div>
                <div class="ai-feedback" id="ai-feedback">
                    <div class="feedback-loading">
                        <i class="fa-solid fa-brain"></i> AI đang phân tích...
                    </div>
                </div>
                <div class="speech-actions">
                    <button class="speech-btn small" onclick="startRecording()">
                        <i class="fa-solid fa-redo"></i> Thử lại
                    </button>
                    <button class="speech-btn small tertiary" onclick="showLessonSelector()">
                        <i class="fa-solid fa-forward"></i> Bài tiếp theo
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="chat-body">
        <!-- AI messages sẽ xuất hiện ở đây -->
    </div>
    
    <form class="chat-form">
        <!-- Mode Selector -->
        <div class="mode-selector">
            <button type="button" class="mode-btn active" data-mode="customer_service" title="Customer Service - Tư vấn khóa học">
                <i class="fa-solid fa-headset"></i>
            </button>
            <button type="button" class="mode-btn" data-mode="english_teacher" title="English Teacher - Dạy tiếng Anh">
                <i class="fa-solid fa-chalkboard-user"></i>
            </button>
            <button type="button" class="mode-btn speech-mode" data-mode="speech_practice" title="Speech Practice - Luyện nói">
                <i class="fa-solid fa-microphone"></i>
            </button>
        </div>
        
        <!-- Input Group -->
        <div class="input-group">
            <input type="text" class="message-input" placeholder="🏢 Hỏi về khóa học, giá cả, thống kê..." required>
            <button type="button" class="voice-input-btn" id="voice-input-btn" title="Nói thay vì gõ">
                <i class="fa-solid fa-microphone-lines"></i>
            </button>
            <button type="submit" class="send-btn">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>

<!-- Single Toggle Button -->
<button id="chatbot-toggler">
    <span><i class="fa-solid fa-brain"></i></span>
    <span><i class="fa-solid fa-times"></i></span>
</button>

<!-- Overlay -->
<div class="chatbot-overlay" id="chatbot-overlay"></div>

<!-- Load Assets -->
<link rel="stylesheet" href="./chatbot/style.css">
<script src="./chatbot/script.js"></script>

<!-- Dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
    });

    // ==================================================
    // FOOTER INTEGRATION
    // ==================================================

    // Hàm mở chat với mode cụ thể
    window.openChatWithMessage = function(message, mode = 'customer_service') {
        console.log(`🚀 Opening chat: "${message}" in ${mode} mode`);
        
        document.body.classList.add("show-chatbot");
        
        setTimeout(() => {
            if (window.switchMode) {
                window.switchMode(mode);
            }
            
            setTimeout(() => {
                const messageInput = document.querySelector('.message-input');
                if (messageInput && mode !== 'speech_practice') {
                    messageInput.value = message;
                    messageInput.focus();
                    
                    setTimeout(() => {
                        document.querySelector('.chat-form')?.dispatchEvent(new Event('submit'));
                    }, 500);
                }
            }, 600);
        }, 300);
    };

    // Load footer stats
    async function loadFooterStats() {
        try {
            const response = await fetch('./chatbot/data_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get_website_stats' })
            });
            
            const data = await response.json();
            if (data.success) {
                setTimeout(() => animateCounter('footer-total-courses', data.data.total_courses || 0), 500);
                setTimeout(() => animateCounter('footer-total-students', data.data.total_students || 0), 700);
                setTimeout(() => animateCounter('footer-total-teachers', data.data.total_teachers || 0), 900);
            }
        } catch (error) {
            document.getElementById('footer-total-courses').textContent = '10+';
            document.getElementById('footer-total-students').textContent = '500+';
            document.getElementById('footer-total-teachers').textContent = '15+';
        }
    }

    function animateCounter(elementId, targetValue, duration = 2000) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        const startValue = 0;
        const startTime = performance.now();
        
        function easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeOutCubic(progress);
            const currentValue = Math.floor(startValue + (targetValue - startValue) * easedProgress);
            
            element.textContent = currentValue > 0 ? currentValue.toLocaleString() : '--';
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = targetValue.toLocaleString();
            }
        }
        
        requestAnimationFrame(updateCounter);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(loadFooterStats, 1000);
    });
</script>

<style>
    /* Footer CSS - Giữ nguyên thiết kế gốc */
    :root {
        --brand-color: #0db33b;
        --teacher-color: #3498db;
        --speech-color: #9c27b0;
        --text-color-dark: #333;
        --text-color-light: #666;
        --background-light-gray: #f8f9fa;
        --border-color-light: #e9ecef;
    }

    .footer-wrapper-light {
        background-color: var(--background-light-gray);
        color: var(--text-color-light);
        padding-top: 50px;
        border-top: 1px solid var(--border-color-light);
    }

    .footer-wrapper-light .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .footer-main {
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr;
        gap: 40px;
        padding-bottom: 40px;
    }

    .footer-content.about-us .footer-logo-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        margin-bottom: 15px;
    }

    .footer-content.about-us .logo-footer {
        height: 50px;
        width: auto;
        border-radius: 8px;
    }

    .footer-content.about-us .logo-item {
        font-size: 20px;
        color: var(--brand-color);
        font-weight: bold;
    }

    .footer-content.about-us .logo-row {
        font-size: 13px;
        color: var(--text-color-light);
    }

    .footer-content.about-us .about-text {
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    /* AI Assistant Info */
    .ai-assistant-info {
        background: linear-gradient(135deg, rgba(13, 179, 59, 0.1) 0%, rgba(52, 152, 219, 0.1) 100%);
        padding: 18px;
        border-radius: 12px;
        margin: 20px 0;
        border-left: 4px solid var(--brand-color);
        transition: all 0.3s ease;
        text-align: center;
    }

    .ai-assistant-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.15);
    }

    .ai-assistant-info h5 {
        color: var(--brand-color);
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .ai-assistant-info p {
        font-size: 13px;
        margin-bottom: 12px;
        color: var(--text-color-light);
        line-height: 1.4;
    }

    .btn-chat-now {
        background: linear-gradient(135deg, var(--brand-color) 0%, var(--teacher-color) 50%, var(--speech-color) 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }

    .btn-chat-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(13, 179, 59, 0.3);
    }

    .footer-content h4 {
        font-size: 18px;
        margin-bottom: 20px;
        color: var(--text-color-dark);
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-content h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background-color: var(--brand-color);
        border-radius: 2px;
    }

    .social-icons {
        margin-top: 20px;
        text-align: center;
    }

    .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        font-size: 16px;
        color: var(--text-color-light);
        margin-right: 8px;
        border: 1px solid var(--border-color-light);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        background-color: var(--brand-color);
        color: #fff;
        border-color: var(--brand-color);
        transform: translateY(-2px);
    }

    .footer-links {
        list-style: none;
        padding-left: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links li a {
        color: var(--text-color-light);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
    }

    .footer-links li a:hover {
        color: var(--brand-color);
        transform: translateX(5px);
    }

    .footer-links li a::before {
        content: '-';
        margin-right: 8px;
        color: var(--brand-color);
        font-weight: bold;
    }

    .footer-links.ai-features li a {
        font-size: 13px;
        background: rgba(13, 179, 59, 0.05);
        padding: 6px 10px;
        border-radius: 15px;
        margin: 2px 0;
        transition: all 0.3s ease;
    }

    .footer-links.ai-features li a::before {
        content: none;
    }

    .footer-links.ai-features li a:hover {
        background: rgba(13, 179, 59, 0.1);
        color: var(--brand-color);
        transform: translateX(8px);
        cursor: pointer;
    }

    .footer-links-contact {
        list-style: none;
        padding-left: 0;
    }

    .footer-links-contact li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .footer-links-contact li:hover {
        transform: translateX(3px);
    }

    .footer-links-contact i {
        margin-right: 12px;
        margin-top: 4px;
        font-size: 16px;
        color: var(--brand-color);
        min-width: 18px;
    }

    .footer-links-contact a {
        color: var(--text-color-light);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links-contact a:hover {
        color: var(--brand-color);
    }

    /* Quick Stats */
    .quick-stats {
        background: white;
        padding: 18px;
        border-radius: 12px;
        margin: 20px 0;
        border: 1px solid var(--border-color-light);
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .quick-stats h5 {
        color: var(--brand-color);
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .stat-item {
        text-align: center;
        padding: 12px 8px;
        background: var(--background-light-gray);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: scale(1.05);
    }

    .stat-number {
        display: block;
        font-size: 18px;
        font-weight: bold;
        color: var(--brand-color);
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 11px;
        color: var(--text-color-light);
        font-weight: 500;
    }

    .logo-footer-small {
        width: 150px;
        height: auto;
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .footer-bar {
        background-color: #0db33b;
        color: #ffffff;
        padding: 15px 0;
        font-size: 14px;
    }

    .footer-bar-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .footer-bar .right a {
        color: #ffffff;
        text-decoration: none;
        margin-left: 20px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    .footer-bar .right a:hover {
        color: #b8e6c1;
        transform: translateY(-1px);
    }

    /* CHATBOT POSITIONING */
    .chatbot {
        position: fixed !important;
        right: 35px !important;
        bottom: 90px !important;
        width: 420px !important;
        height: auto !important;
        max-height: 500px !important;
        background: white !important;
        border-radius: 15px !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        overflow: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
        transform: scale(0.5) !important;
        transform-origin: bottom right !important;
        transition: all 0.3s ease !important;
        z-index: 999998 !important;
        display: flex !important;
        flex-direction: column !important;
        top: auto !important;
        left: auto !important;
        margin: 0 !important;
    }

    body.show-chatbot .chatbot {
        opacity: 1 !important;
        pointer-events: auto !important;
        transform: scale(1) !important;
    }

    #chatbot-toggler {
        position: fixed !important;
        bottom: 30px !important;
        right: 35px !important;
        height: 50px !important;
        width: 50px !important;
        z-index: 999999 !important;
        background: linear-gradient(135deg, var(--brand-color) 0%, var(--teacher-color) 50%, var(--speech-color) 100%) !important;
        border: none !important;
        border-radius: 50% !important;
        color: white !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
        animation: tripleColorPulse 4s infinite !important;
    }

    @keyframes tripleColorPulse {
        0%, 100% {
            box-shadow: 0 4px 12px rgba(13, 179, 59, 0.4);
        }
        33% {
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
        }
        66% {
            box-shadow: 0 8px 25px rgba(156, 39, 176, 0.6);
        }
    }

    #chatbot-toggler:hover {
        transform: scale(1.1) !important;
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.6) !important;
    }

    @media (max-width: 768px) {
        .footer-main {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-bar-content {
            flex-direction: column;
            text-align: center;
        }

        .chatbot {
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            border-radius: 0 !important;
        }
        
        #chatbot-toggler {
            right: 20px !important;
            bottom: 20px !important;
        }
    }
</style>
