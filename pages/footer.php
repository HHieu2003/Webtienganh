<footer class="footer-wrapper" data-aos="fade-up">
    <div class="footer-main">
        <div class="footer-content">
            <h4>TRUNG TÂM ANH NGỮ FIGHTER</h4>
            <p><i class="fa-solid fa-location-dot"></i> Lê Văn Lương - Thanh Xuân - Hà Nội</p>
            <p><i class="fa-solid fa-phone-volume"></i> Hotline: 0962.501.832 - 0336.123.130</p>
            <p><i class="fa-solid fa-envelope"></i> Email: <a href="mailto:nthuphuong2710@gmail.com">nthuphuong2710@gmail.com</a></p>
            <div class="social-icons">
                <a href="#" aria-label="Telegram"><i class="fa-brands fa-telegram"></i></a>
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" aria-label="Youtube"><i class="fa-brands fa-youtube"></i></a>
                <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>

        <div class="footer-content">
            <h4>HỖ TRỢ KHÁCH HÀNG</h4>
            <ul class="footer-links">
                <li><a href="./index.php?nav=huongdandangky">Hướng dẫn đăng ký khóa học</a></li>
                <li><a href="./index.php?nav=huongdandangky">Hướng dẫn đăng ký và đăng nhập</a></li>
                <li><a href="./index.php?nav=huongdandangky">Hướng dẫn đổi mật khẩu</a></li>
            </ul>
        </div>

        <div class="footer-content">
            <h4>ĐỒNG HÀNH CÙNG CHÚNG TÔI</h4>
            <img class="logo-footer" src="images/logo.png" alt="Logo Footer">
             <img class="logo-footer-small" src="./images/logofooter.png" alt="Logo Bộ Công Thương">
        </div>
    </div>

    <div class="footer-bar">
        <div class="left">
            &copy; 2024 Tiếng Anh Fighter. All rights reserved.
        </div>
        <div class="right">
            <a href="./index.php?nav=about">Giới thiệu</a>
            <a href="./index.php?nav=huongdandangky">Điều khoản dịch vụ</a>
            <a href="./index.php?nav=huongdandangky">Chính sách bảo mật</a>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
  AOS.init({
      duration: 1000, // Thời gian hiệu ứng diễn ra (miligiây)
      once: true,     // Chỉ chạy hiệu ứng một lần
  });
</script>

<style>
    /* ==================================================================
    CSS cho Footer
    ==================================================================
    */

    /* Phần bao ngoài cùng */
    .footer-wrapper {
        background-color: #f3f7f8;
        border-top: 3px solid #0b9331;
        color: #333;
        font-family: Arial, sans-serif;
    }

    /* Phần nội dung chính của footer */
    .footer-main {
        display: flex;
        flex-wrap: wrap; /* Cho phép các cột xuống hàng trên màn hình nhỏ */
        justify-content: space-between;
        padding: 40px 5%; /* Dùng % để co giãn */
        gap: 20px; /* Khoảng cách giữa các cột */
    }

    .footer-content {
        flex: 1; /* Các cột tự động chia đều không gian */
        min-width: 250px; /* Chiều rộng tối thiểu cho mỗi cột */
    }

    .footer-content h4 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #000;
        font-weight: bold;
        position: relative;
        padding-bottom: 10px;
    }
    /* Gạch chân cho tiêu đề */
    .footer-content h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 2px;
        background-color: #0db33b;
    }

    .footer-content p {
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 12px;
        color: #555;
    }
    .footer-content p i {
        margin-right: 10px;
        color: #0db33b;
    }
    .footer-content p a {
        color: #555;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .footer-content p a:hover {
        color: #0db33b;
        text-decoration: underline;
    }

    /* Liên kết mạng xã hội */
    .social-icons a {
        font-size: 28px;
        color: #555;
        margin-right: 15px;
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .social-icons a:hover {
        transform: translateY(-3px);
        color: #0db33b;
    }

    /* Danh sách liên kết hỗ trợ */
    .footer-links {
        list-style: none;
        padding-left: 0;
    }
    .footer-links li a {
        color: #555;
        text-decoration: none;
        line-height: 2;
        transition: color 0.3s ease, padding-left 0.3s ease;
    }
    .footer-links li a:hover {
        color: #0db33b;
        padding-left: 5px;
    }

    /* Hình ảnh trong footer */
    .logo-footer {
        width: auto;
        height: 120px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .logo-footer:hover {
        transform: scale(1.05);
    }
    .logo-footer-small {
        width: 180px;
        height: auto;
        margin-top: 15px;
    }

    /*----------- Thanh footer cuối cùng -----------*/
    .footer-bar {
        background-color: #0b9331;
        color: white;
        padding: 15px 5%;
        font-size: 14px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }
    .footer-bar .right a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
        transition: text-decoration 0.3s ease;
    }
    .footer-bar .right a:hover {
        text-decoration: underline;
    }

    /* Reponsive cho Footer trên màn hình nhỏ */
    @media (max-width: 768px) {
        .footer-main {
            flex-direction: column; /* Xếp các cột theo chiều dọc */
        }
        .footer-bar {
            flex-direction: column;
            text-align: center;
        }
    }
</style>