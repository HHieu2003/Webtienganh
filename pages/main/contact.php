<style>
    .contact-section {
    }

    .contact-info-box {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 15px;
        height: 100%;
        border: 1px solid #eee;
    }

    .contact-info-box h4 {
        font-weight: 600;
        margin-bottom: 25px;        
        padding-bottom: 10px;
        border-bottom: 2px solid #0db33b;
        display: inline-block;
    }
   
    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }

    .contact-info-icon {
        font-size: 20px;
        color: #0db33b;
        width: 40px;
        height: 40px;
        background: #e7f7ec;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .map-container {
        border-radius: 15px;
        overflow: hidden;
        height: 250px;
        margin-top: 20px;
        border: 1px solid #ddd;
    }

    /* --- CSS CHO PHẦN KẾT NỐI MẠNG XÃ HỘI --- */
    .social-connect-wrapper {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        height: 100%;
    }

    .social-connect-wrapper h4 {
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
    }

    .social-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* Tạo lưới 2 cột */
        gap: 15px;
        /* Giảm khoảng cách một chút */
    }

    .social-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
        border-radius: 12px;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
    }

    .social-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        color: #fff;
    }

    .social-card i {
        font-size: 36px;
        /* Giảm kích thước icon một chút */
        margin-bottom: 10px;
    }

    .social-card .social-name {
        font-size: 17px;
        font-weight: 600;
    }

    .social-card .social-action {
        font-size: 13px;
        opacity: 0.8;
    }

    /* Màu sắc đặc trưng cho từng mạng xã hội */
    .social-card.facebook {
        background: linear-gradient(135deg, #1877F2, #3b5998);
    }

    .social-card.messenger {
        background: linear-gradient(135deg, #00B2FF, #006AFF);
    }

    .social-card.youtube {
        background: linear-gradient(135deg, #FF0000, #c4302b);
    }

    .social-card.tiktok {
        background: linear-gradient(135deg, #010101, #25f4ee);
    }

    .social-card.instagram {
        background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);
    }

    .social-card.zalo {
        background: linear-gradient(135deg, #0068ff, #0091ff);
    }

    /* Responsive cho lưới social */
    @media (max-width: 576px) {
        .social-grid {
            grid-template-columns: 1fr;
            /* 1 cột trên điện thoại */
        }
    }
</style>
<div class="contact-section section-p20">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">LIÊN HỆ VỚI CHÚNG TÔI</h2>
            <p class="section-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="contact-info-box">
                    <h4>Thông tin liên hệ</h4>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <strong>Địa chỉ:</strong><br>
                            Lê Văn Lương - Thanh Xuân - Hà Nội
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <strong>Hotline:</strong><br>
                            0962.501.832 - 0336.123.130
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <strong>Email:</strong><br>
                            nthuphuong2710@gmail.com
                        </div>
                    </div>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.854381533261!2d105.80165907490216!3d20.99849188899908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac9881643d57%3A0x29221b6973551508!2zTMOqIFbEg24gTMawxqFuZywgVGhhbmggWHXDom4sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1728852378906!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                <div class="social-connect-wrapper">
                    <h4>Kết nối với chúng tôi</h4>
                    <div class="social-grid">

                        <a href="https://www.facebook.com/" class="social-card facebook" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-facebook-f"></i>
                            <span class="social-name">Facebook</span>
                            <span class="social-action">Theo dõi Fanpage</span>
                        </a>

                        <a href="https://www.facebook.com/profile.php?id=100091706867917&mibextid=LQQJ4d" class="social-card messenger" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-facebook-messenger"></i>
                            <span class="social-name">Messenger</span>
                            <span class="social-action">Nhắn tin cho chúng tôi</span>
                        </a>

                        <a href="https://www.youtube.com" class="social-card youtube" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-youtube"></i>
                            <span class="social-name">YouTube</span>
                            <span class="social-action">Xem video bài giảng</span>
                        </a>

                        <a href="https://tiktok.com" class="social-card tiktok" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-tiktok"></i>
                            <span class="social-name">TikTok</span>
                            <span class="social-action">Xem video ngắn</span>
                        </a>

                        <a href="https://www.instagram.com" class="social-card instagram" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-instagram"></i>
                            <span class="social-name">Instagram</span>
                            <span class="social-action">Xem hình ảnh lớp học</span>
                        </a>

                        <a href="tel:+84123456789" class="social-card zalo" target="_blank" rel="noopener noreferrer">
                            <i class="fa-solid fa-comment-dots"></i>
                            <span class="social-name">Zalo</span>
                            <span class="social-action">Chat với tư vấn viên</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>