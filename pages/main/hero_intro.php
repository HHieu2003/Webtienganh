<div class="hero-intro-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="intro-content">
                    <h1 class="hero-title">
                        <span class="brand-name">Tiếng Anh Fighter</span><br>
                        Học là phải dùng được!
                    </h1>
                    <p class="hero-description">Việc học tiếng anh không chỉ dừng lại ở điểm số, mà là hành trình giúp bạn phát triển tư duy, phản xạ ngôn ngữ và ứng dụng hiệu quả vào học tập, công việc và cuộc sống thực tế.</p>
                    <p class="hero-description">Trung tâm mang đến môi trường học hiện đại – nơi học viên rèn luyện toàn diện với:</p>
                    <ul class="features-list">
                        <li class="feature-item" data-aos="fade-right" data-aos-delay="200">
                        <span>
                            <i class="fas fa-check-circle feature-icon"></i>Phương pháp E.M.P.O.W.E.R – Tăng phản xạ, tư duy phản biện.</span>
                        </li>
                        <li class="feature-item" data-aos="fade-right" data-aos-delay="300">

                            <span> <i class="fas fa-check-circle feature-icon"></i>Nền tảng công nghệ toàn diện và đột phá.</span>
                        </li>
                        <li class="feature-item" data-aos="fade-right" data-aos-delay="400">

                            <span><i class="fas fa-check-circle feature-icon"></i>Đội ngũ giáo viên chuyên môn cao và tận tâm.</span>
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
    overflow: hidden;
    /* Màu xanh lá nhẹ nhàng */
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
    padding: 40px 0;
    position: relative;
}

/* Thêm hiệu ứng nền nhẹ */
.hero-intro-section::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
    pointer-events: none;
}

.intro-content {
    max-width: 520px;
    position: relative;
    z-index: 1;
}

.hero-description {
    font-weight: 400;
    text-align: justify;
    color: #166534;
    font-size: 17px;
    margin-bottom: 10px;
    line-height: 1.7;
    transition: color 0.3s ease;
}

.hero-title {
    text-align: left;
    font-size: 42px;
    line-height: 1.3;
    color: #14532d;
    font-weight: 700;
    margin-bottom: 25px;
}

.hero-title .brand-name {
    background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: all 0.3s ease;
}

.hero-title .highlight {
    color: #16a34a;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0 0 35px 0;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 17px;
    color: #166534;
    padding: 12px 15px;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    border-left: 3px solid transparent;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.feature-item:hover {
    background: rgba(255, 255, 255, 0.95);
    border-left-color: #22c55e;
    transform: translateX(8px);
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.15);
}

.feature-icon {
    color: #22c55e;
    font-size: 20px;
    margin-right: 12px;
    transition: all 0.3s ease;
}

.feature-item:hover .feature-icon {
    transform: scale(1.2);
    color: #16a34a;
}

.cta-button {
    background: linear-gradient(45deg, #16a34a, #22c55e);
    color: #FFFFFF;
    border: none;
    border-radius: 50px;
    padding: 14px 35px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    position: relative;
    overflow: hidden;
}

.cta-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.cta-button:hover::before {
    left: 100%;
}

.cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
    color: #fff;
    background: linear-gradient(45deg, #22c55e, #16a34a);
}

.cta-button:active {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
}

/* LƯỚI HÌNH ẢNH - Giữ nguyên bố cục */
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
    box-shadow: 0 8px 25px rgba(21, 128, 61, 0.12);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    border: 2px solid rgba(255, 255, 255, 0.8);
}

.grid-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 1;
}

.grid-item:hover::before {
    opacity: 1;
}

.grid-item:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 40px rgba(34, 197, 94, 0.25);
    border-color: #22c55e;
}

.grid-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.grid-item:hover img {
    transform: scale(1.08);
}

/* Hiệu ứng stagger cho các grid item */
.grid-item:nth-child(1) {
    transition-delay: 0s;
}

.grid-item:nth-child(2) {
    transition-delay: 0.05s;
}

.grid-item:nth-child(3) {
    transition-delay: 0.1s;
}

.grid-item:nth-child(4) {
    transition-delay: 0.15s;
}

@media (max-width: 991px) {
    .hero-intro-section {
        text-align: center;
    }

    .feature-item {
        text-align: left;
    }

    .image-grid {
        margin-top: 40px;
    }
}

@media (max-width: 551px) {
    .hero-intro-section {
        text-align: center;
    }

    .image-grid {
        margin-top: 40px;
    }
    
    .hero-title {
        font-size: 30px;
    }
    
    .hero-description {
        font-size: 15px;
    }
    
    .feature-item {
        font-size: 15px;
        padding: 10px 12px;
    }
    
    .cta-button {
        padding: 12px 30px;
        font-size: 15px;
    }
}

/* Thêm animation khi scroll vào view */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Smooth scrolling cho toàn bộ section */
.hero-intro-section * {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

</style>