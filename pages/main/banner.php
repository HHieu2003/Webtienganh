<div class="banner-section-v3">
    <div class="wave-background"></div>

    <div class="container">
        <div class="section-header text-center mb-4" data-aos="fade-up">
            <h2 class="introduce-title">Giá Trị Khác Biệt Để Bứt Phá</h2>
            <p class="section-subtitle">Phương pháp học đúng, tài liệu chuẩn và công nghệ hiện đại là ba yếu tố chính giúp bạn tự tin chinh phục mục tiêu.</p>
        </div>

        <div class="feature-block-v3" data-aos="fade-up" data-aos-duration="700">
            <div class="row g-lg-5 align-items-center">
                <div class="col-lg-6">
                    <div class="feature-block-v3__image text-center">
                        <img src="https://vietop.edu.vn/wp-content/uploads/2025/03/phuong-phap-EMPOWER.webp" alt="Phương pháp EMPOWER" style="width:60%">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-block-v3__content">
                        <div class="feature-block-v3__icon"><i class="fas fa-lightbulb"></i></div>
                        <h3>Phương pháp E.M.P.O.W.E.R</h3>
                        <p>Phương pháp học độc quyền giúp học viên chủ động tiếp thu kiến thức, tăng cường tư duy phản biện và ứng dụng tiếng Anh hiệu quả vào thực tế.</p>
                        <a href="./index.php?nav=phuongphaphoc" class="feature-block-v3__link">Tìm hiểu thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="feature-block-v3" data-aos="fade-up" data-aos-duration="700">
            <div class="row g-lg-5 align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="feature-block-v3__image">
                        <img src="https://vietop.edu.vn/wp-content/uploads/2025/03/tai-lieu-hoc-doc-quyen.webp" alt="Tài liệu học tập độc quyền">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-block-v3__content text-lg-end alt">
                        <div class="feature-block-v3__icon"><i class="fas fa-book-reader"></i></div>
                        <h3>Tài liệu học tập độc quyền</h3>
                        <p>Biên soạn bởi đội ngũ giáo viên 8.0+ IELTS, bám sát xu hướng ra đề thi mới nhất, giúp học viên ôn luyện đúng trọng tâm và hiệu quả.</p>
                        <a href="./index.php?nav=blog" class="feature-block-v3__link">Khám phá học liệu <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="feature-block-v3" data-aos="fade-up" data-aos-duration="700">
            <div class="row g-lg-5 align-items-center">
                <div class="col-lg-6">
                    <div class="feature-block-v3__image">
                        <img src="https://vietop.edu.vn/wp-content/uploads/2025/03/cong-nghe-hoc-tap.webp" alt="Nền tảng công nghệ">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-block-v3__content">
                        <div class="feature-block-v3__icon"><i class="fas fa-robot"></i></div>
                        <h3>Nền tảng công nghệ AI</h3>
                        <ul class="feature-tech-list-v3">
                            <li><i class="fas fa-check-circle"></i> Trợ lý AI hỗ trợ học tập & chấm chữa 24/7.</li>
                            <li><i class="fas fa-check-circle"></i> Hệ thống LMS quản lý học tập cá nhân hóa.</li>
                            <li><i class="fas fa-check-circle"></i> Thuận tiện luyện tập mọi lúc, mọi nơi.</li>
                        </ul>
                        <a href="javascript:void(0);" onclick="openChatWithMessage('Tìm hiểu về công nghệ AI', 'customer_service')" class="feature-block-v3__link">Trải nghiệm ngay công nghệ ai <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .banner-section-v3 {
        position: relative;
        padding: 60px 0;
        background-color: var(--neutral-white);
        /* Nền trắng */
        overflow: hidden;
    }

    /* --- Họa tiết nền chuyển động --- */
    .banner-section-v3 .wave-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23f0fdf4" fill-opacity="0.6" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,133.3C672,117,768,139,864,165.3C960,192,1056,224,1152,218.7C1248,213,1344,171,1392,149.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-repeat: no-repeat;
        background-position: bottom;
        background-size: cover;
        z-index: 0;
        animation: wave-flow 20s linear infinite alternate;
    }

    @keyframes wave-flow {
        from {
            transform: translateX(-10%);
        }

        to {
            transform: translateX(10%);
        }
    }

    /* --- Khối Tính Năng --- */
    .banner-section-v3 .feature-block-v3 {
        position: relative;
        /* Đảm bảo nội dung nổi trên nền */
        z-index: 1;
        margin-bottom: 20px;
        background: var(--neutral-white);
        border-radius: 24px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        padding: 15px 0;
        transition: transform 0.3s ease, box-shadow 0.3s ease
    }

    /* --- Hình ảnh --- */
    .banner-section-v3 .feature-block-v3__image {
        position: relative;
        transition: transform 0.3s ease;
    }

    .banner-section-v3 .feature-block-v3:hover .feature-block-v3__image {
        transform: scale(1.03);
    }

    .banner-section-v3 .feature-block-v3__image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* --- Nội dung --- */
    .banner-section-v3 .feature-block-v3__content {
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
    }

    .banner-section-v3 .feature-block-v3__content.alt {
        display: flex;
        margin-left: 20px;
    }

    .banner-section-v3 .feature-block-v3__icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--brand-color-dark), var(--brand-color));
        color: white;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        box-shadow: 0 8px 20px rgba(13, 179, 59, 0.3);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        margin: auto 0px;
    }

    .banner-section-v3 .feature-block-v3:hover .feature-block-v3__icon {
        transform: scale(1.15) rotate(15deg);
    }

    .banner-section-v3 .feature-block-v3__content h3 {
        font-size: 28px;
        font-weight: 700;
        color: var(--brand-color-dark);
        margin-bottom: 15px;
        margin: auto 0px auto 20px;

    }

    .banner-section-v3 .feature-block-v3__content p {
        font-size: 17px;
        line-height: 1.8;
        color: var(--text-light);
        max-width: 486px;
        margin-top: 20px;
    }

    .banner-section-v3 .feature-block-v3__content.alt p {}


    /* --- Danh sách Công nghệ --- */
    .banner-section-v3 .feature-tech-list-v3 {
        list-style: none;
        padding-left: 0;
        margin: 20px 0;
    }

    .banner-section-v3 .feature-tech-list-v3 li {
        font-size: 17px;
        color: #333;
        font-weight: 500;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .banner-section-v3 .feature-tech-list-v3 i {
        color: var(--brand-color);
        font-size: 20px;
    }

    /* --- Link --- */
    .banner-section-v3 .feature-block-v3__link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 15px;
        color: var(--brand-color-dark);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 20px;
    }

    .banner-section-v3 .feature-block-v3__link i {
        transition: transform 0.3s ease;
    }

    .banner-section-v3 .feature-block-v3__link:hover {
        color: var(--brand-color);
    }

    .banner-section-v3 .feature-block-v3__link:hover i {
        transform: translateX(5px);
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .banner-section-v3 .feature-block-v3__content.alt {
            align-items: flex-start;
            text-align: left !important;
        }

        .banner-section-v3 .feature-block-v3__content.alt p {
            text-align: left;
        }

        .banner-section-v3 .feature-block-v3__image {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 555px) {
        .banner-section-v3 .feature-block-v3__content.alt {
            align-items: flex-start;
            text-align: left !important;
        }

        .banner-section-v3 .feature-block-v3__content.alt p {
            text-align: left;
        }

        .banner-section-v3 .feature-block-v3__image {
            margin-bottom: 30px;
        }

        .banner-section-v3 .feature-block-v3__content h3 {
            font-size: 22px;
        }
    }
</style>