<div class="hero-reimagined-section">
    <div class="hero-background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-content">
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                        <span class="brand-name">Tiếng Anh Fighter</span>
                        Học là phải dùng được!
                    </h1>
                    <p class="hero-description" data-aos="fade-up" data-aos-delay="200">
                        Việc học tiếng Anh không chỉ dừng lại ở điểm số, mà là hành trình giúp bạn phát triển tư duy, phản xạ ngôn ngữ và ứng dụng hiệu quả vào học tập, công việc và cuộc sống thực tế.
                    </p>
                    <p class="hero-description">Trung tâm mang đến môi trường học hiện đại – nơi học viên rèn luyện toàn diện với:</p>
                    <ul class="features-list">
                        <li data-aos="fade-up" data-aos-delay="300">
                            <i class="fas fa-check-circle feature-icon"></i>
                            Phương pháp E.M.P.O.W.E.R – Tăng phản xạ, tư duy phản biện.
                        </li>
                        <li data-aos="fade-up" data-aos-delay="400">
                            <i class="fas fa-check-circle feature-icon"></i>
                            Nền tảng công nghệ toàn diện và đột phá.
                        </li>
                        <li data-aos="fade-up" data-aos-delay="500">
                            <i class="fas fa-check-circle feature-icon"></i>
                            Đội ngũ giáo viên chuyên môn cao và tận tâm.
                        </li>
                    </ul>

                    <a href="./index.php?nav=about" class="cta-button">Tìm hiểu về chúng tôi</a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="hero-image-collage">
                    <div class="image-wrapper img-1">
                        <img src="./images/intro1.png" alt="Lớp học Tiếng Anh Fighter">
                    </div>
                    <div class="image-wrapper img-2">
                        <img src="./images/intro2.png" alt="Học viên thành công">
                    </div>
                    <div class="image-wrapper img-3">
                        <img src="./images/intro4.png" alt="Môi trường học tập">
                    </div>
                    <div class="image-wrapper img-4">
                        <img src="./images/intro3.png" alt="Giáo viên tận tâm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- Biến màu và Font --- */
    :root {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --accent-color: #ffc107;
        --text-dark: #212529;
        --text-light: #555;
        --bg-light: #f0fdf4;
    }

    /* --- Khung chính của Section --- */
    .hero-reimagined-section {
        position: relative;
        padding: 40px 0;
        background: linear-gradient(135deg, var(--bg-light) 0%, #e7f7ec 100%);
        overflow: hidden;
    }

    /* --- Các hình khối trang trí nền --- */
    .hero-background-shapes .shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(13, 179, 59, 0.08);
        transition: all 0.5s ease;
        animation: float-animation 6s ease-in-out infinite alternate;
    }

    .shape-1 {
        width: 200px;
        height: 200px;
        top: 10%;
        left: 5%;
        animation-duration: 7s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        top: 60%;
        left: 40%;
        animation-duration: 8s;
    }

    .shape-3 {
        width: 100px;
        height: 100px;
        top: 20%;
        right: 10%;
        animation-duration: 5s;
    }

    @keyframes float-animation {
        from {
            transform: translateY(0px) scale(1);
        }

        to {
            transform: translateY(-20px) scale(1.05);
        }
    }

    /* --- Nội dung bên trái --- */
    .hero-content {
        z-index: 2;
        position: relative;
    }

    .hero-title {
        font-size: 48px;
        line-height: 1.25;
        color: var(--text-dark);
        font-weight: 800;
        margin-bottom: 15px;
    }

    .hero-title .brand-name {
        display: block;
        background: linear-gradient(45deg, var(--brand-color-dark), var(--brand-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description {
        font-size: 18px;
        color: var(--text-light);
        margin-bottom: 10px;
        line-height: 1.7;
        max-width: 500px;
    }

    .features-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 30px;
    }

    .features-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        font-size: 17px;
        font-weight: 500;
        color: #333;
        transition: all 0.3s ease;
    }

    .features-list li:hover {
        color: var(--brand-color);
        transform: translateX(5px);
    }

    .feature-icon {
        color: var(--brand-color);
        font-size: 22px;
    }

    .cta-button {
        background: linear-gradient(45deg, var(--brand-color-dark), var(--brand-color));
        color: #FFFFFF;
        border: none;
        border-radius: 50px;
        padding: 15px 40px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(13, 179, 59, 0.3);
        position: relative;
        overflow: hidden;
    }

    .cta-button:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(13, 179, 59, 0.4);
        color: #fff;
    }

    .cta-button:active {
        transform: translateY(-1px);
    }

    /* --- Cụm ảnh bên phải --- */
    .hero-image-collage {
        position: relative;
        height: 450px;
        transition: transform 0.3s ease-out;
        /* For parallax effect */
    }

    .image-wrapper {
        position: absolute;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 4px solid white;
        transition: all 0.4s ease;
    }

    .image-wrapper:hover {
        transform: translateY(-10px) scale(1.05);
        z-index: 10 !important;
        box-shadow: 0 15px 40px rgba(13, 179, 59, 0.2);
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .img-1 {
        width: 55%;
        height: 65%;
        top: 0;
        left: 0;
        z-index: 2;
    }

    .img-2 {
        width: 50%;
        height: 50%;
        top: 50%;
        left: 45%;
        z-index: 3;
    }

    .img-3 {
        width: 40%;
        height: 45%;
        top: 5%;
        right: 0;
        z-index: 1;
    }

    .img-4 {
        width: 30%;
        height: 30%;
        top: 65%;
        left: 10%;
        z-index: 4;
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .hero-reimagined-section {
            text-align: center;
            padding: 60px 0;
        }

        .hero-title {
            font-size: 40px;
        }

        .hero-description {
            margin-left: auto;
            margin-right: auto;
        }

        .features-list {
            display: inline-block;
            text-align: left;
        }

        .hero-image-collage {
            margin-top: 50px;
            height: 400px;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 32px;
        }

        .hero-description,
        .features-list li {
            font-size: 16px;
            text-align: left;
        }

        .hero-image-collage {
            height: 350px;
        }

        .img-1 {
            width: 65%;
            height: 60%;
        }

        .img-2 {
            width: 55%;
            height: 45%;
            left: 40%;
        }

        .img-3 {
            display: none;
        }

        .img-4 {
            width: 40%;
            height: 35%;
            top: 60%;
            left: 5%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Hiệu ứng Parallax khi di chuyển chuột trên cụm ảnh
        const collage = document.querySelector('.hero-image-collage');
        if (collage && window.matchMedia("(min-width: 992px)").matches) {
            document.querySelector('.hero-reimagined-section').addEventListener('mousemove', function(e) {
                const {
                    clientX,
                    clientY
                } = e;
                const {
                    innerWidth,
                    innerHeight
                } = window;

                const moveX = ((clientX / innerWidth) - 0.5) * -30; // -30 to 30
                const moveY = ((clientY / innerHeight) - 0.5) * -20; // -20 to 20

                collage.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        }
    });
</script>