<?php
// --- BẮT ĐẦU: LẤY DỮ LIỆU THỐNG KÊ CHO FOOTER ---
// Đảm bảo biến $conn tồn tại từ file config.php
if (isset($conn)) {
    // 1. Lấy tổng lượt truy cập
    $total_views_result = $conn->query("SELECT SUM(so_luot) AS total FROM luot_truy_cap");
    $total_views = $total_views_result ? $total_views_result->fetch_assoc()['total'] : 0;

    // 2. Lấy tổng số khóa học
    $total_courses_result = $conn->query("SELECT COUNT(*) AS total FROM khoahoc");
    $total_courses = $total_courses_result ? $total_courses_result->fetch_assoc()['total'] : 0;

    // 3. Lấy tổng số học viên
    $total_students_result = $conn->query("SELECT COUNT(*) AS total FROM hocvien WHERE is_admin = 0");
    $total_students = $total_students_result ? $total_students_result->fetch_assoc()['total'] : 0;
} else {
    // Giá trị mặc định nếu không có kết nối CSDL
    $total_views = 0;
    $total_courses = 0;
    $total_students = 0;
}
// --- KẾT THÚC: LẤY DỮ LIỆU ---
?>

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
                
                <div class="ai-assistant-info">
                    <h5><i class="fa-solid fa-brain"></i> Hybrid AI Assistant</h5>
                    <p><strong>2-in-1:</strong> Tư vấn khóa học + Dạy tiếng Anh</p>
                    <button class="btn-chat-now" onclick="document.getElementById('chatbotFloatButton').click();">
                        <i class="fa-solid fa-comment"></i> Chat Ngay
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
                
                <img class="logo-footer-small" src="./images/logofooter.png" alt="Logo Bộ Công Thương">
             
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
                
                <div class="quick-stats">
                    <h5><i class="fa-solid fa-chart-line"></i> Thống Kê Live</h5>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number" id="footer-total-views">0</span>
                            <span class="stat-label">Lượt truy cập</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="footer-total-courses">0</span>
                            <span class="stat-label">Khóa học</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="footer-total-students">0</span>
                            <span class="stat-label">Học viên</span>
                        </div>
                    </div>
                </div>
                
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
                    <a href="javascript:void(0);" onclick="document.getElementById('chatbotFloatButton').click();">
                        <i class="fa-solid fa-brain"></i> Hybrid AI
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    // Initialize AOS Animation
    AOS.init({
        duration: 1000,
        once: true,
    });
    
    // Hiệu ứng đếm số với easing
    function animateCounter(elementId, targetValue, duration = 1500) {
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
            
            element.textContent = currentValue.toLocaleString();
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = parseInt(targetValue).toLocaleString();
            }
        }
        
        requestAnimationFrame(updateCounter);
    }

    // Initialize everything
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Initializing footer stats...');
        
        // Lấy dữ liệu từ các biến PHP đã được truy vấn ở đầu file
        const totalViews = <?php echo (int)$total_views; ?>;
        const totalCourses = <?php echo (int)$total_courses; ?>;
        const totalStudents = <?php echo (int)$total_students; ?>;

        // Khởi chạy animation
        animateCounter('footer-total-views', totalViews);
        animateCounter('footer-total-courses', totalCourses);
        animateCounter('footer-total-students', totalStudents);
        
        console.log('✅ Footer stats loaded');
    });

</script>

<style>
    /* CSS gốc của bạn không cần thay đổi, tôi giữ nguyên ở đây */
    :root {
        --brand-color: #0db33b;
        --teacher-color: #3498db;
        --text-color-dark: #333;
        --text-color-light: #666;
        --background-light-gray: #f8f9fa;
        --border-color-light: #e9ecef;
    }

    .footer-wrapper-light {
        background-color: var(--background-light-gray);
        color: var(--text-color-light);
        padding-top: 30px;
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
        padding-bottom: 10px;
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
        font-size: 18px;
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
        background: linear-gradient(135deg, var(--brand-color) 0%, var(--teacher-color) 100%);
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
        background: linear-gradient(135deg, #0a8f2e 0%, #2980b9 100%);
    }

    /* Footer Content Styles */
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
        font-size: 18px;
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
        font-size: 18px;
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

    .quick-stats:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
        border: 1px solid transparent;
    }

    .stat-item:hover {
        background: white;
        border-color: var(--brand-color);
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

    .logo-footer-small:hover {
        transform: scale(1.05);
    }

    /* Footer Bar */
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

    
    @keyframes hybridPulse {
        0%, 100% {
            box-shadow: 0 4px 12px rgba(13, 179, 59, 0.3) !important;
        }
        50% {
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5) !important;
        }
    }

    #chatbot-toggler:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 6px 20px rgba(13, 179, 59, 0.5) !important;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .footer-main {
            grid-template-columns: 1fr 1fr;
        }
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

        .footer-bar .right a {
            margin: 5px 10px;
        }

        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .stat-number {
            font-size: 16px;
        }

        .stat-label {
            font-size: 10px;
        }

        .chatbot {
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            top: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            transform-origin: center !important;
        }
        
        #chatbot-toggler {
            right: 20px !important;
            bottom: 20px !important;
        }
    }

    @media (max-width: 576px) {
        .footer-wrapper-light {
            padding-top: 30px;
        }

        .footer-main {
            gap: 25px;
        }

        .ai-assistant-info {
            padding: 15px;
        }

        .quick-stats {
            padding: 15px;
        }

        .btn-chat-now {
            font-size: 12px;
            padding: 8px 16px;
        }
    }
</style>