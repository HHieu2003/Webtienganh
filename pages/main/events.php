<?php
?>

<style>
    :root {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --text-dark: #212529;
        --text-light: #6c757d;
        --bg-light: #f8f9fa;
        --white: #fff;
        --border-color: #e9ecef;
        --shadow-soft: 0 8px 25px rgba(0, 0, 0, 0.07);
        --shadow-medium: 0 12px 35px rgba(13, 179, 59, 0.1);
    }

    .events-section-v4 {
        padding: 60px 0;
        background-color: var(--bg-light);
        position: relative;
        overflow-x: hidden;
    }

    .events-section-v4::before,
    .events-section-v4::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(13, 179, 59, 0.06), transparent 70%);
        z-index: 0;
        animation: float-animation 10s ease-in-out infinite alternate;
    }

    .events-section-v4::before {
        width: 350px;
        height: 350px;
        top: 10%;
        left: -180px;
    }

    .events-section-v4::after {
        width: 250px;
        height: 250px;
        bottom: 15%;
        right: -120px;
        animation-duration: 12s;
    }

    @keyframes float-animation {
        from {
            transform: translateY(0px) rotate(0deg);
        }

        to {
            transform: translateY(20px) rotate(30deg);
        }
    }

    /* --- Thẻ Sự Kiện --- */
    .event-card-v4 {
        display: flex;
        background-color: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-soft);
        margin-bottom: 40px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 1;
    }

    .event-card-v4:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }

    /* Đảo ngược thứ tự cho thẻ chẵn */
    .event-card-v4.reverse {
        flex-direction: row-reverse;
    }

    /* --- Hình ảnh sự kiện --- */
    .event-image-v4 {
        flex: 0 0 40%;
        position: relative;
        overflow: hidden;
        border-radius: 24px 0 0 24px;
    }

    .event-card-v4.reverse .event-image-v4 {
        border-radius: 0 24px 24px 0;
    }

    .event-image-v4 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .event-card-v4:hover .event-image-v4 img {
        transform: scale(1.08);
    }

    /* --- Tag ngày tháng --- */
    .event-date-tag-v4 {
        position: absolute;
        top: 25px;
        left: -1px;
        /* Dính sát cạnh */
        background: linear-gradient(135deg, var(--brand-color), var(--brand-color-dark));
        color: var(--white);
        text-align: center;
        padding: 12px 20px;
        border-radius: 0 12px 12px 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .event-date-tag-v4 .day {
        font-size: 38px;
        font-weight: 800;
        line-height: 1;
    }

    .event-date-tag-v4 .month {
        font-size: 16px;
        font-weight: 500;
        text-transform: uppercase;
    }

    /* --- Chi tiết sự kiện --- */
    .event-details-v4 {
        padding: 35px 40px;
        flex: 1;
    }

    .event-category-v4 {
        display: inline-block;
        padding: 7px 18px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--white);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-category-v4.workshop {
        background: linear-gradient(135deg, #8E2DE2, #4A00E0);
    }

    /* Tím */
    .event-category-v4.test {
        background: linear-gradient(135deg, #F9A825, #FDD835);
        color: var(--text-dark);
    }

    /* Vàng */
    .event-category-v4.webinar {
        background: linear-gradient(135deg, #0072ff, #00c6ff);
    }

    /* Xanh dương */
    .event-category-v4.club {
        background: linear-gradient(135deg, #d31027, #ea384d);
    }

    /* Đỏ */
    .event-category-v4.seminar {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }

    /* Xanh ngọc */
    .event-category-v4.contest {
        background: linear-gradient(135deg, #FF416C, #FF4B2B);
    }

    /* Hồng cam */
    .event-category-v4.career {
        background: linear-gradient(135deg, #02AAB0, #00CDAC);
    }

    /* Xanh mint */
    .event-category-v4.livestream {
        background: linear-gradient(135deg, #e52d27, #b31217);
    }

    /* Đỏ đậm */

    .event-title-v4 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .event-meta-v4 {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
        color: var(--text-light);
    }

    .event-meta-v4 li {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 16px;
    }

    .event-meta-v4 i {
        color: var(--brand-color);
        width: 22px;
        text-align: center;
        font-size: 18px;
    }

    .event-description-v4 {
        font-size: 16px;
        line-height: 1.8;
        color: var(--text-light);
        margin-bottom: 30px;
    }

    .btn-register-v4 {
        background: var(--brand-color);
        color: var(--white);
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.2);
    }

    .btn-register-v4:hover {
        background: var(--brand-color-dark);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.3);
        color: var(--white);
    }

    .btn-register-v4 i {
        transition: transform 0.3s ease;
    }

    .btn-register-v4:hover i {
        transform: translateX(5px) rotate(360deg);
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {

        .event-card-v4,
        .event-card-v4.reverse {
            flex-direction: column;
        }

        .event-image-v4,
        .event-card-v4.reverse .event-image-v4 {
            flex-basis: 280px;
            min-height: 280px;
            border-radius: 24px 24px 0 0;
        }

        .event-details-v4 {
            padding: 30px;
        }

        .event-title-v4 {
            font-size: 22px;
        }
    }
</style>

<div class="events-section-v4">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">SỰ KIỆN & HỘI THẢO SẮP TỚI</h2>
            <p class="section-subtitle">Nâng cao kỹ năng, mở rộng kiến thức và kết nối với cộng đồng học viên năng động.</p>
        </div>

        <div class="events-list">

            <div class="event-card-v4" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop" alt="Workshop IELTS Speaking">
                    <div class="event-date-tag-v4">
                        <span class="day">15</span><span class="month">Thg 10</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 workshop">Workshop</span>
                    <h3 class="event-title-v4">Chinh Phục IELTS Speaking Band 8.0+</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 18:00 - 20:00, Thứ Sáu</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Online qua Zoom</li>
                    </ul>
                    <p class="event-description-v4">Học hỏi các chiến lược trả lời và những mẫu câu "ăn điểm" trong phần thi Speaking từ chuyên gia IELTS 8.5.</p>
                    <a href="#" class="btn-register-v4">Đăng ký miễn phí <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4 reverse" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=1740&auto=format&fit=crop" alt="Thi thử IELTS">
                    <div class="event-date-tag-v4">
                        <span class="day">25</span><span class="month">Thg 10</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 test">Thi thử</span>
                    <h3 class="event-title-v4">Ngày Hội Thi Thử IELTS 4 Kỹ Năng</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 08:00 - 11:00, Chủ Nhật</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Trung tâm Tiếng Anh Fighter</li>
                    </ul>
                    <p class="event-description-v4">Trải nghiệm kỳ thi IELTS như thật với đề thi chuẩn và được chấm điểm chi tiết. Số lượng có hạn, đăng ký ngay!</p>
                    <a href="#" class="btn-register-v4">Đăng ký giữ chỗ <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=1740&auto=format&fit=crop" alt="Webinar IELTS Writing">
                    <div class="event-date-tag-v4">
                        <span class="day">05</span><span class="month">Thg 11</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 webinar">Webinar</span>
                    <h3 class="event-title-v4">Bí Quyết "Hack" Điểm IELTS Writing Task 2</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 19:30 - 21:00, Thứ Ba</li>
                        <li><i class="fa-solid fa-video"></i> Livestream trên Fanpage</li>
                    </ul>
                    <p class="event-description-v4">Học cách phân tích đề, xây dựng dàn ý logic và sử dụng từ vựng học thuật hiệu quả cho bài thi Writing Task 2.</p>
                    <a href="#" class="btn-register-v4">Tham gia ngay <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4 reverse" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="CLB Giao tiếp">
                    <div class="event-date-tag-v4">
                        <span class="day">09</span><span class="month">Thg 11</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 club">CLB Tiếng Anh</span>
                    <h3 class="event-title-v4">Speaking Club: Chủ đề "Technology & Future"</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 09:00 - 11:00, Thứ Bảy</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Sảnh sự kiện, Tiếng Anh Fighter</li>
                    </ul>
                    <p class="event-description-v4">Cơ hội thực hành giao tiếp, tranh luận về chủ đề công nghệ và tương lai trong một môi trường cởi mở và năng động.</p>
                    <a href="#" class="btn-register-v4">Tham gia CLB <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1740&auto=format&fit=crop" alt="Hội thảo du học">
                    <div class="event-date-tag-v4">
                        <span class="day">16</span><span class="month">Thg 11</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 seminar">Hội thảo</span>
                    <h3 class="event-title-v4">Con Đường Du Học: Từ IELTS Đến Học Bổng</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 14:00 - 16:00, Thứ Bảy</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Hội trường trung tâm</li>
                    </ul>
                    <p class="event-description-v4">Gặp gỡ các chuyên gia tư vấn du học và cựu du học sinh để lắng nghe chia sẻ kinh nghiệm săn học bổng và chuẩn bị hồ sơ.</p>
                    <a href="#" class="btn-register-v4">Tìm hiểu thêm <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4 reverse" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1740&auto=format&fit=crop" alt="Workshop CV">
                    <div class="event-date-tag-v4">
                        <span class="day">22</span><span class="month">Thg 11</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 career">Career Workshop</span>
                    <h3 class="event-title-v4">Xây Dựng CV & Phỏng Vấn Tiếng Anh Chuyên Nghiệp</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 18:30 - 20:30, Thứ Sáu</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Online qua Zoom</li>
                    </ul>
                    <p class="event-description-v4">Học cách viết một CV ấn tượng và trả lời các câu hỏi phỏng vấn hóc búa bằng tiếng Anh để chinh phục nhà tuyển dụng.</p>
                    <a href="#" class="btn-register-v4">Đăng ký ngay <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?q=80&w=1740&auto=format&fit=crop" alt="Livestream Luyện nghe">
                    <div class="event-date-tag-v4">
                        <span class="day">28</span><span class="month">Thg 11</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 livestream">Livestream</span>
                    <h3 class="event-title-v4">Chiến Thuật Luyện Nghe "Bắt Trọn Keywords"</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 20:00 - 21:00, Thứ Năm</li>
                        <li><i class="fa-solid fa-video"></i> Livestream trên Fanpage</li>
                    </ul>
                    <p class="event-description-v4">Chuyên gia sẽ chia sẻ kỹ thuật nghe chủ động, cách nhận biết 'distractors' và phương pháp ghi chú hiệu quả để tối đa hóa điểm số.</p>
                    <a href="#" class="btn-register-v4">Nhận thông báo <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4 reverse" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1740&auto=format&fit=crop" alt="Cuộc thi hùng biện">
                    <div class="event-date-tag-v4">
                        <span class="day">07</span><span class="month">Thg 12</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 contest">Cuộc thi</span>
                    <h3 class="event-title-v4">Fighter's English Champion 2025</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> Cả ngày, Thứ Bảy</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Hội trường trung tâm</li>
                    </ul>
                    <p class="event-description-v4">Cuộc thi hùng biện tiếng Anh thường niên với nhiều giải thưởng hấp dẫn. Thể hiện bản thân và tranh tài cùng các tài năng khác.</p>
                    <a href="#" class="btn-register-v4">Xem thể lệ <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1593463591421-2a811d33169f?q=80&w=1740&auto=format&fit=crop" alt="English Speaking Club">
                    <div class="event-date-tag-v4">
                        <span class="day">12</span><span class="month">Thg 11</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 club">CLB Tiếng Anh</span>
                    <h3 class="event-title-v4">English Speaking Club: "Travel & Adventure"</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 09:00 - 11:00</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Sảnh sự kiện, Tiếng Anh Fighter</li>
                    </ul>
                    <p class="event-description-v4">Cùng giao lưu, kết bạn và thực hành kỹ năng nói tiếng Anh trong một môi trường thân thiện và năng động.</p>
                    <a href="#" class="btn-register-v4">Tham gia CLB <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="event-card-v4 reverse" data-aos="fade-up">
                <div class="event-image-v4">
                    <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=1740&auto=format&fit=crop" alt="Câu lạc bộ">
                    <div class="event-date-tag-v4">
                        <span class="day">22</span><span class="month">Thg 12</span>
                    </div>
                </div>
                <div class="event-details-v4">
                    <span class="event-category-v4 club">CLB Tiếng Anh</span>
                    <h3 class="event-title-v4">Year-End Party: Giao lưu và tổng kết cuối năm</h3>
                    <ul class="event-meta-v4">
                        <li><i class="fa-solid fa-clock"></i> 18:00 - 21:00</li>
                        <li><i class="fa-solid fa-map-marker-alt"></i> Sảnh sự kiện, Tiếng Anh Fighter</li>
                    </ul>
                    <p class="event-description-v4">Buổi tiệc cuối năm ấm cúng dành cho tất cả học viên. Cùng nhìn lại một năm học tập và nhận những phần quà đặc biệt.</p>
                    <a href="#" class="btn-register-v4">Xác nhận tham dự <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>