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
                <div class="social-icons">
                    <a href="#" aria-label="Facebook" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Youtube" title="Youtube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" aria-label="Telegram" title="Telegram"><i class="fa-brands fa-telegram"></i></a>
                </div>
            </div>

            <div class="footer-content quick-links">
                <h4>VỀ TIẾNG ANH FIGHTER</h4>
                <ul class="footer-links">
                    <li><a href="./index.php?nav=about">Giới thiệu về trung tâm</a></li>
                    <li><a href="./index.php?nav=khoahoc">Tất cả khóa học</a></li>
                    <li><a href="./index.php?nav=huongdandangky">Hướng dẫn đăng ký</a></li>
                    <li><a href="./pages/login.php">Đăng nhập / Đăng ký</a></li>
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
                </ul>
                <img class="logo-footer-small" src="./images/logofooter.png" alt="Logo Bộ Công Thương">
            </div>
        </div>
    </div>

    <div class="footer-bar">
        <div class="container">
            <div class="footer-bar-content">
                <div class="left">
                    &copy; 2025 Bản quyền thuộc về Tiếng Anh Fighter.
                </div>
                <div class="right">
                    <a href="./index.php?nav=huongdandangky">Điều khoản dịch vụ</a>
                    <a href="./index.php?nav=huongdandangky">Chính sách bảo mật</a>
                </div>
            </div>
        </div>
    </div>



</footer>


<link rel="stylesheet" href="chatbot/style.css">

<button id="chatbot-toggler">
    <span class="fa-solid fa-comment-dots"></span>
    <span class="fa-solid fa-times"></span>
</button>
<div class="chatbot-popup">
    <div class="chat-header">
        <div class="header-info">
            <div class="chatbot-logo"><i class="fa-solid fa-robot"></i></div>
            <h2 class="logo-text">English Fighter Bot</h2>
        </div>
        <i id="close-chatbot" class="fa-solid fa-chevron-down"></i>
    </div>
    <div class="chat-body">
        <div class="message bot-message">
            <div class="bot-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="message-text"> Hello! I'm the English Fighter Bot. <br>How can I help you practice your English today? </div>
        </div>
    </div>
    <div class="chat-footer">
        <form action="#" class="chat-form">
            <textarea placeholder="Nhập tin nhắn..." class="message-input" required></textarea>
            <button type="submit" id="send-message"><i class="fa-solid fa-paper-plane"></i></button>
        </form>
    </div>
</div>

<script src="chatbot/script.js" defer></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 1000,
        once: true,
    });
</script>

<style>
    /* ==================================================================
       CSS MỚI CHO FOOTER - PHIÊN BẢN TÔNG MÀU SÁNG
    ================================================================== */

    :root {
        --brand-color: #0db33b;
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

    /* Phần nội dung chính */
    .footer-main {
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr;
        /* Phân chia cột không đều */
        gap: 40px;
        padding-bottom: 40px;
    }

    /* Cột giới thiệu (Cột 1) */
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
    }

    /* Tiêu đề chung */
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

    /* Mạng xã hội */
    .social-icons {
        margin-top: 20px;
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

    /* Cột liên kết nhanh (Cột 2) */
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
        transition: color 0.3s ease;
    }

    .footer-links li a:hover {
        color: var(--brand-color);
    }

    .footer-links li a::before {
        content: '-';
        /* Icon chevron-right */
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-right: 8px;
        color: var(--brand-color);
    }

    /* Cột liên hệ (Cột 3) */
    .footer-links-contact {
        list-style: none;
        padding-left: 0;
    }

    .footer-links-contact li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        font-size: 15px;
    }

    .footer-links-contact i {
        margin-right: 12px;
        margin-top: 4px;
        font-size: 16px;
        color: var(--brand-color);
    }

    .footer-links-contact a {
        color: var(--text-color-light);
        text-decoration: none;
    }

    .footer-links-contact a:hover {
        color: var(--brand-color);
    }

    .logo-footer-small {
        width: 150px;
        height: auto;
        margin-top: 15px;
    }

    /* Thanh Copyright */
    .footer-bar {
        background-color: #0db33b;
        color: #ffffffff;
        padding: 10px 0;
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
        color: #ffffffff;
        text-decoration: none;
        margin-left: 20px;
        transition: color 0.3s ease;
    }

    .footer-bar .right a:hover {
        color: var(--brand-color);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .footer-main {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .footer-main {
            grid-template-columns: 1fr;
        }

        .footer-bar-content {
            flex-direction: column;
            text-align: center;
        }

        .footer-bar .right a {
            margin: 5px 10px;
        }
    }
</style>