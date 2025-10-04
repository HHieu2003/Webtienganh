<style>
    .contact-section { padding: 60px 0; }
    .contact-info-box {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 15px;
        height: 100%;
    }
    .contact-info-box h4 { font-weight: 600; margin-bottom: 20px; }
    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }
    .contact-info-icon {
        font-size: 20px;
        color: #0db33b;
        width: 40px; height: 40px;
        background: #e7f7ec;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
    }
    .contact-form {
         background: #fff;
         padding: 30px;
         border-radius: 15px;
         box-shadow: 0 5px 25px rgba(0,0,0,0.07);
    }
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        height: 250px; /* Chiều cao bản đồ */
        margin-top: 20px;
    }
</style>
<div class="contact-section">
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
                         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.854499149495!2d105.8017596154019!3d20.99847829415518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac9886337423%3A0x7a3648a1a361a343!2zTMOqIFbEg24gTMawxqFuZywgVGhhbmggWHXDom4sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1664182873461!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
             <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                <form class="contact-form h-100">
                    <h4 class="mb-3">Gửi tin nhắn cho chúng tôi</h4>
                     <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Họ và tên của bạn" required>
                    </div>
                     <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" rows="6" placeholder="Nội dung tin nhắn" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Gửi đi</button>
                </form>
            </div>
        </div>
    </div>
</div>