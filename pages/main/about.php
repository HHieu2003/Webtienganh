<?php
// File: pages/main/about.php
?>

<style>

    /* --- Hero Section --- */
    .about-hero {
        padding: 60px 0;
        background: linear-gradient(135deg, rgba(240, 253, 244, 0.7), rgba(231, 247, 236, 0.7)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center;
        background-size: cover;
        text-align: center;
        color: var(--text-dark);
    }

    .about-hero .introduce-title {
        font-size: 42px;
        color: var(--brand-color-dark);
    }

    .about-hero .section-subtitle {
        font-size: 18px;
        color: var(--text-light);
    }

    /* --- Mission & Values Section --- */
    .mission-section {
        padding: 30px 0;
    }

    .mission-card {
        background-color: var(--neutral-white);
        padding: 40px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-soft);
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }

    .mission-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
        border-color: var(--brand-color);
    }

    .mission-icon {
        font-size: 40px;
        width: 80px;
        height: 80px;
        line-height: 80px;
        border-radius: 50%;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, var(--brand-color), var(--accent-color));
        color: var(--neutral-white);
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.2);
    }

    .mission-card h3 {
        font-size: 22px;
        font-weight: 700;
        color: var(--brand-color-dark);
        margin-bottom: 15px;
    }

    .mission-card p {
        color: var(--text-light);
        font-size: 16px;
    }

    /* --- Reasons Section --- */
    .reasons-section {
        padding: 60px 0;
        background: var(--neutral-light);
    }

    .reason-card {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        background-color: var(--neutral-white);
        padding: 25px;
        border-radius: 16px;
        height: 100%;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
    }

    .reason-card:hover {
        transform: scale(1.03);
        box-shadow: var(--shadow-medium);
    }

    .reason-icon {
        flex-shrink: 0;
        font-size: 24px;
        color: var(--brand-color);
        background-color: #e7f7ec;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .reason-content h4 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .reason-content p {
        font-size: 15px;
        color: var(--text-light);
        line-height: 1.7;
        margin: 0;
    }

    /* --- Timeline Section --- */
    .timeline-section {
        padding: 60px 0;
    }

    .timeline-wrapper {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    .timeline-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 3px;
        height: 100%;
        background-color: var(--border-color);
    }

    .timeline-item {
        position: relative;
        width: 50%;
        padding: 10px 40px;
        margin-bottom: 40px;
    }

    .timeline-item:nth-child(odd) {
        left: 0;
    }

    .timeline-item:nth-child(even) {
        left: 50%;
    }

    .timeline-content {
        background-color: var(--neutral-white);
        padding: 25px;
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
        position: relative;
        border-top: 4px solid var(--brand-color);
    }

    .timeline-item:nth-child(odd) .timeline-content {
        text-align: right;
    }

    .timeline-year {
        font-size: 20px;
        font-weight: 700;
        color: var(--brand-color-dark);
        margin-bottom: 10px;
    }

    .timeline-content h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .timeline-content p {
        font-size: 15px;
        color: var(--text-light);
        margin: 0;
    }

    .timeline-dot {
        content: '';
        position: absolute;
        top: 20px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: var(--brand-color);
        border: 4px solid var(--bg-light);
        z-index: 1;
        box-shadow: 0 0 10px rgba(13, 179, 59, 0.5);
    }

    .timeline-item:nth-child(odd) .timeline-dot {
        right: -10px;
    }

    .timeline-item:nth-child(even) .timeline-dot {
        left: -10px;
    }

    /* --- Partners & Locations --- */
    .partners-section,
    .locations-section {
        padding: 60px 0;
        background-color: var(--neutral-light);
    }
    
    .partner-logo-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 40px;
    }
    
    .partner-logo {
        height: 60px;
        filter: grayscale(100%);
        opacity: 0.6;
        transition: all 0.3s ease;
    }
    
    .partner-logo:hover {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.1);
    }
    
    .location-card {
        background: var(--neutral-white);
        padding: 25px;
        border-radius: 16px;
        text-align: center;
        box-shadow: var(--shadow-soft);
        height: 100%;
        border-bottom: 4px solid var(--brand-color);
        transition: all 0.3s ease;
    }
    
    .location-card:hover {
        transform: translateY(-8px);
    }
    
    .location-icon {
        font-size: 30px;
        color: var(--brand-color);
        margin-bottom: 15px;
    }
    
    .location-card p {
        font-size: 16px;
        color: var(--text-light);
        margin: 0;
        font-weight: 500;
    }


    /* --- Responsive cho Timeline --- */
    @media screen and (max-width: 768px) {
        .timeline-wrapper::before {
            left: 10px;
        }

        .timeline-item {
            width: 100%;
            padding-left: 50px;
            padding-right: 15px;
            margin-bottom: 30px;
        }

        .timeline-item:nth-child(even) {
            left: 0%;
        }

        .timeline-item:nth-child(odd) .timeline-content,
        .timeline-item:nth-child(even) .timeline-content {
            text-align: left;
        }

        .timeline-dot {
            left: 0;
        }

        .timeline-item:nth-child(odd) .timeline-dot,
        .timeline-item:nth-child(even) .timeline-dot {
            left: 0;
        }
    }
</style>

<section class="about-hero">
    <div class="container" data-aos="fade-in">
        <h1 class="introduce-title">Về Tiếng Anh Fighter</h1>
        <p class="section-subtitle">Đồng hành cùng bạn trên hành trình chinh phục tiếng Anh từ 2013, với phương châm cốt lõi: "Học là phải dùng được!".</p>
    </div>
</section>

<section class="mission-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5 col-md-6" data-aos="fade-up">
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Sứ Mệnh</h3>
                    <p>Kiến tạo một môi trường học thuật chất lượng, năng động và truyền cảm hứng, giúp mỗi học viên khai phá tiềm năng ngôn ngữ và đạt được kết quả học tập tối ưu.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-hands-helping"></i></div>
                    <h3>Phương Châm</h3>
                    <p>"Học là phải dùng được" – Chúng tôi không chỉ tập trung vào điểm số, mà còn chú trọng vào khả năng ứng dụng tiếng Anh một cách tự tin và hiệu quả trong học tập, công việc và đời sống.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="reasons-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">7 Lý Do Chọn Tiếng Anh Fighter</h2>
            <p class="section-subtitle">Những giá trị khác biệt tạo nên sự tin tưởng của hàng ngàn học viên.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;">
                <div class="reason-card">
                    <div class="reason-icon"><i class="fas fa-file-signature"></i></div>
                    <div class="reason-content">
                        <h4>Cam kết đầu ra</h4>
                        <p>Đảm bảo mục tiêu bằng hợp đồng pháp lý, đào tạo lại miễn phí đến khi bạn đạt điểm cam kết.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="50">
                <div class="reason-card">
                    <div class="reason-icon"><i class="fas fa-users"></i></div>
                    <div class="reason-content">
                        <h4>Lớp sĩ số ít</h4>
                        <p>Mô hình lớp học nhóm nhỏ giúp tối đa hóa tương tác và đảm bảo mỗi học viên được quan tâm sát sao.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="100">
                <div class="reason-card">
                    <div class="reason-icon"><i class="fas fa-brain"></i></div>
                    <div class="reason-content">
                        <h4>Phương pháp E.M.P.O.W.E.R</h4>
                        <p>Phương pháp học độc quyền giúp bạn chủ động, tăng phản xạ và tư duy phản biện.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="150">
                <div class="reason-card">
                    <div class="reason-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="reason-content">
                        <h4>Giảng viên chất lượng</h4>
                        <p>Đội ngũ 100% có chứng chỉ sư phạm, trình độ chuyên môn cao và giàu kinh nghiệm thực chiến.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="200">
                <div class="reason-card">
                    <div class="reason-icon"><i class="fas fa-headset"></i></div>
                    <div class="reason-content">
                        <h4>Chăm sóc chuyên biệt</h4>
                        <p>Đội ngũ CSKH tận tâm, luôn đồng hành và hỗ trợ, tháo gỡ mọi khó khăn trong quá trình học.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="250">
                <div class="reason-card">
                    <div class="reason-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="reason-content">
                        <h4>Thời gian linh hoạt</h4>
                        <p>Các lớp học được sắp xếp linh hoạt, phù hợp với lịch trình của học sinh, sinh viên và người đi làm.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="timeline-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">Hành Trình Phát Triển</h2>
            <p class="section-subtitle">Nhìn lại những cột mốc quan trọng trên chặng đường hơn 10 năm xây dựng và phát triển.</p>
        </div>
        <div class="timeline-wrapper">
            <div class="timeline-item" data-aos="fade-right">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2013</div>
                    <h5>Khởi đầu đam mê</h5>
                    <p>Thành lập cơ sở đầu tiên tại Phú Nhuận với mô hình lớp nhóm nhỏ, cam kết đầu ra bằng văn bản và trở thành đối tác chính thức của IDP/BC.</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-left">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2017</div>
                    <h5>Mở rộng và phát triển</h5>
                    <p>Khai trương chi nhánh tại Gò Vấp, nâng cao chất lượng giảng dạy và hoàn thiện hệ thống quản lý nội bộ chuyên nghiệp.</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-right">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2020</div>
                    <h5> khẳng định vị thế</h5>
                    <p>Tiếp tục mở rộng với chi nhánh Quận 10, giữ vững tâm huyết giáo dục và nhận được sự tín nhiệm lớn từ học viên.</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-left">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2023</div>
                    <h5>Đối tác Bạch Kim</h5>
                    <p>Chính thức trở thành Đối tác Bạch Kim – mức hợp tác cao nhất của IDP Việt Nam, khẳng định uy tín và chất lượng hàng đầu.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="locations-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">Hệ Thống Cơ Sở</h2>
            <p class="section-subtitle">Tìm cơ sở Tiếng Anh Fighter gần bạn nhất.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;">
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <p>27 Lê Văn Lương, Quận Thanh Xuân, TP.HN</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="100">
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <p>321 Lê Hồng Phong, Phường 12, Quận 10, TP.HCM</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" style="margin-bottom: 20px;" data-aos-delay="200">
                <div class="location-card">
                    <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <p>65 Gò Dầu, Phường Tân Quý, Quận Tân Phú, TP.HCM</p>
                </div>
            </div>
        </div>
    </div>
</section>