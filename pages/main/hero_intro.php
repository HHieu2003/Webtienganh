<div class="hero-intro-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="intro-content">
                    <h1 class="hero-title">
                        <span class="brand-name">Tiếng Anh Fighter</span><br>
                        Học là phải dùng được!
                    </h1>
                    <p class="hero-description">Việc học tiếng Anh không chỉ dừng lại ở điểm số, mà là hành trình giúp bạn phát triển tư duy, phản xạ ngôn ngữ và ứng dụng hiệu quả vào học tập, công việc và cuộc sống thực tế.</p>
                    <p class="hero-description">Trung tâm mang đến môi trường học hiện đại – nơi học viên rèn luyện toàn diện với:</p>

                    <ul class="features-list">
                        <li class="feature-item" data-aos="fade-right" data-aos-delay="200">
                            <i class="fas fa-check-circle feature-icon"></i>
                            <span>Phương pháp E.M.P.O.W.E.R – Tăng phản xạ, tư duy phản biện</span>
                        </li>
                        <li class="feature-item" data-aos="fade-right" data-aos-delay="300">
                            <i class="fas fa-check-circle feature-icon"></i>
                            <span>Nền tảng công nghệ toàn diện và đột phá.</span>
                        </li>
                        <li class="feature-item" data-aos="fade-right" data-aos-delay="400">
                            <i class="fas fa-check-circle feature-icon"></i>
                            <span>Đội ngũ giáo viên chuyên môn cao và tận tâm.</span>
                        </li>
                    </ul>

                    <a href="./index.php?nav=about" class="cta-button" data-aos="fade-up" data-aos-delay="500">Tìm hiểu về chúng tôi</a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="image-grid-container">
                    <div class="image-grid">
                        <div class="grid-item" data-aos="zoom-in" data-aos-delay="300"><img src="./images/intro1.png" alt="Lớp học Tiếng Anh Fighter"></div>
                        <div class="grid-item" data-aos="zoom-in" data-aos-delay="400"><img src="./images/intro2.png" alt="Học viên thành công"></div>
                        <div class="grid-item" data-aos="zoom-in" data-aos-delay="500"><img src="./images/intro3.png" alt="Giáo viên tận tâm"></div>
                        <div class="grid-item" data-aos="zoom-in" data-aos-delay="600"><img src="./images/intro4.png" alt="Môi trường học tập"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-intro-section {
        /* THAY ĐỔI 1: Đổi màu nền sang xanh nhạt của dự án */
        background-color: #f4fbf7;
        overflow: hidden;
    }

    .intro-content {
        max-width: 500px;
    }

    .hero-description {
        font-weight: 400;
        text-align: justify;
        color: #3a424a;
    }

    .hero-title {
        text-align: left;

        font-size: 42px;
        line-height: 1.3;
        color: #333;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .hero-title .brand-name {
        color: #0db33b;
    }

    .hero-title .highlight {
        color: #0db33b;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 0 0 35px 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 17px;
        color: #505460;
    }

    .feature-icon {
        color: #0db33b;
        font-size: 20px;
        margin-right: 12px;
    }

    .cta-button {
        background: linear-gradient(45deg, #0db33b, #28a745);
        color: #FFFFFF;
        border: none;
        border-radius: 50px;
        padding: 14px 35px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.3);
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(13, 179, 59, 0.4);
        color: #fff;
    }

    /* THAY ĐỔI 2: Lưới hình ảnh theo đúng ảnh mẫu */
    .image-grid-container {
        position: relative;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .grid-item {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .grid-item:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 15px 35px rgba(13, 179, 59, 0.2);
    }

    .grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 991px) {
        .hero-intro-section {
            text-align: center;
        }

        .feature-item {
            justify-content: center;
        }

        .image-grid {
            margin-top: 40px;
        }
    }
</style>