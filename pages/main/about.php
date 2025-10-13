<style>
    /* --- Cài đặt chung & Biến màu --- */
    :root {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --background-light: #f8f9fa;
        --text-dark: #212529;
        --text-light: #6c757d;
        --border-color: #dee2e6;
        --shadow-sm: 0 4px 15px rgba(0,0,0,0.06);
    }

    /* --- Hero Banner Section --- */
    .about-hero-section {
        padding: 80px 0;
        background: linear-gradient(135deg, rgba(13, 179, 59, 0.8), rgba(40, 167, 69, 0.9)), url('images/khoahoc1.jpg') no-repeat center center;
        background-size: cover;
        color: #fff;
        text-align: center;
    }
    .about-hero-section h1 {
        font-size: 48px;
        font-weight: 700;
        text-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }
    .about-hero-section p {
        font-size: 18px;
        max-width: 700px;
        margin: 15px auto 0;
        opacity: 0.9;
    }

    /* --- Bố cục chính --- */
    .about-container {
        padding: 60px 0;
    }

    /* --- Nội dung bài viết & các khối Section --- */
    .about-post-section {
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 40px;
    }
    .about-post-section h2 {
        font-size: 28px;
        font-weight: 600;
        color: var(--brand-color);
        margin-bottom: 20px;
    }
    .about-post-section .lead-text {
        font-size: 18px;
        font-style: italic;
        color: var(--text-dark);
        margin-bottom: 25px;
    }
    .about-post-section p, .about-post-section li {
        font-size: 16px;
        line-height: 1.8;
        color: var(--text-light);
    }
    .about-post-section ul {
        padding-left: 20px;
        list-style-type: '✓  ';
    }
    .about-post-section ul li {
        padding-left: 10px;
        margin-bottom: 10px;
    }

    /* --- Mục "Giá trị cốt lõi" --- */
    .values-section .value-card {
        background-color: var(--background-light);
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        height: 100%;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    .values-section .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: var(--brand-color);
    }
    .values-section .value-icon {
        font-size: 40px;
        color: var(--brand-color);
        margin-bottom: 15px;
    }
    .values-section .value-card h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-dark);
    }

    /* --- Timeline Hành trình phát triển --- */
    .timeline-section {
        position: relative;
        padding: 40px 0;
    }
    .timeline-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 3px;
        height: 100%;
        background-color: #e9ecef;
    }
    .timeline-item {
        position: relative;
        width: 50%;
        padding: 20px 40px;
        box-sizing: border-box;
    }
    .timeline-item:nth-child(odd) {
        left: 0;
        padding-right: 60px;
        text-align: right;
    }
    .timeline-item:nth-child(even) {
        left: 50%;
        padding-left: 60px;
        text-align: left;
    }
    .timeline-dot {
        position: absolute;
        top: 35px;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border: 4px solid var(--brand-color);
        border-radius: 50%;
        z-index: 1;
    }
    .timeline-item:nth-child(odd) .timeline-dot {
        right: -10px;
    }
    .timeline-item:nth-child(even) .timeline-dot {
        left: -10px;
    }
    .timeline-content .year {
        font-size: 22px;
        font-weight: 700;
        color: var(--brand-color);
    }
    .timeline-content h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 10px 0;
    }
    
    /* --- Sidebar --- */
    .sidebar-sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 100px;
    }
    .sidebar-widget {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 25px;
    }
    .sidebar-widget h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }
    .sidebar-widget h4::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0;
        width: 50px; height: 2px;
        background-color: var(--brand-color);
    }
    .course-item-sidebar a {
        display: flex; gap: 15px; align-items: center;
        text-decoration: none; margin-bottom: 15px; padding: 10px;
        border-radius: 8px; transition: background-color 0.3s ease;
    }
    .course-item-sidebar a:hover { background-color: var(--background-light); }
    .course-item-sidebar img { width: 70px; height: 70px; border-radius: 8px; object-fit: cover; }
    .course-item-sidebar p { font-size: 15px; color: var(--text-dark); font-weight: 500; margin: 0; }
    
    /* Responsive cho Timeline */
    @media (max-width: 767px) {
        .timeline-section::before { left: 10px; }
        .timeline-item { width: 100%; padding-left: 50px; padding-right: 20px; text-align: left !important; }
        .timeline-item:nth-child(even) { left: 0; }
        .timeline-dot { left: 1px; }
    }

</style>
<div class="about-hero-section" data-aos="fade-in">
    <div class="container">
        <h1>Về Tiếng Anh Fighter</h1>
        <p>Thắp lửa đam mê, chắp cánh ước mơ Anh ngữ cho hàng triệu người Việt.</p>
    </div>
</div>

<div class="about-container">
    <div class="container">
        <div class="row gx-lg-5">
            <div class="col-lg-8">

                <div class="about-post-section" data-aos="fade-up">
                    <h2>Chào mừng bạn đến với Tiếng Anh Fighter!</h2>
                    <p class="lead-text">
                        Chúng tôi tin rằng việc học tiếng Anh không chỉ dừng lại ở điểm số, mà là một hành trình khám phá, giúp bạn phát triển tư duy, phản xạ ngôn ngữ và tự tin ứng dụng vào học tập, công việc và cuộc sống.
                    </p>
                    <img src="images/khoahoc1.jpg" alt="Môi trường học tập tại Tiếng Anh Fighter" class="img-fluid rounded mb-4">
                    
                    <h3>Sứ mệnh của chúng tôi</h3>
                    <p>Với phương châm "Học là phải dùng được", Tiếng Anh Fighter ra đời với sứ mệnh mang đến một môi trường học tập hiện đại, thực tiễn và truyền cảm hứng. Chúng tôi không ngừng nâng cao chất lượng dịch vụ bằng cách ứng dụng công nghệ và đổi mới phương pháp giảng dạy để đáp ứng mọi nhu cầu ngày càng cao của học viên.</p>
                    
                    <h3>Lĩnh vực hoạt động chính:</h3>
                    <ul>
                        <li>Đào tạo và luyện thi các chứng chỉ quốc tế: IELTS, TOEIC,...</li>
                        <li>Các khóa học tiếng Anh giao tiếp, tiếng Anh cho người đi làm.</li>
                        <li>Biên soạn sách và các tài liệu học tập độc quyền.</li>
                        <li>Tổ chức thi thử và các sự kiện học thuật cộng đồng.</li>
                    </ul>
                </div>

                <div class="about-post-section values-section" data-aos="fade-up">
                    <h2>Giá trị cốt lõi</h2>
                     <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="value-card">
                                <div class="value-icon"><i class="fas fa-users"></i></div>
                                <h4>Tận tâm vì học viên</h4>
                                <p>Luôn đặt sự tiến bộ và thành công của học viên làm trung tâm cho mọi hoạt động.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="value-card">
                                <div class="value-icon"><i class="fas fa-book-open-reader"></i></div>
                                <h4>Phương pháp vượt trội</h4>
                                <p>Phương pháp RIPL độc quyền, đề cao tương tác và thực hành liên tục để tối ưu hiệu quả.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                             <div class="value-card">
                                <div class="value-icon"><i class="fas fa-chalkboard-user"></i></div>
                                <h4>Đội ngũ chuyên môn</h4>
                                <p>Những người "thầy" tài năng, tâm huyết và luôn là người truyền cảm hứng bất tận.</p>
                            </div>
                        </div>
                     </div>
                </div>
                
                <div class="about-post-section" data-aos="fade-up">
                    <h2>Hành trình phát triển</h2>
                    <div class="timeline-section">
                        <div class="timeline-item" data-aos="fade-right">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="year">2008</p>
                                <h5>Thành lập</h5>
                                <p>Tiếng Anh Fighter ra đời với cơ sở đầu tiên tại Hà Nội, mang trong mình khát vọng thay đổi cách học tiếng Anh truyền thống.</p>
                            </div>
                        </div>
                        <div class="timeline-item" data-aos="fade-left">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="year">2015</p>
                                <h5>Mở rộng chi nhánh</h5>
                                <p>Phát triển hệ thống chi nhánh tại các thành phố lớn, đưa phương pháp học hiệu quả đến với hàng ngàn học viên.</p>
                            </div>
                        </div>
                        <div class="timeline-item" data-aos="fade-right">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="year">2020</p>
                                <h5>Chuyển đổi số</h5>
                                <p>Tiên phong ứng dụng công nghệ, ra mắt hệ thống học tập trực tuyến (LMS), giúp học viên học tập mọi lúc, mọi nơi.</p>
                            </div>
                        </div>
                        <div class="timeline-item" data-aos="fade-left">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="year">Hiện tại</p>
                                <h5>Khẳng định vị thế</h5>
                                <p>Trở thành một trong những hệ thống Anh ngữ uy tín hàng đầu, đào tạo thành công hơn 1.000.000 học viên trên toàn quốc.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center" data-aos="fade-up">
                    <img src="images/anh1.png" alt="Đội ngũ Tiếng Anh Fighter" class="img-fluid rounded">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-sticky">
                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                        <h4>Tìm kiếm nhanh</h4>
                        <form class="search-form d-flex" method="GET" action="index.php">
                            <input type="hidden" name="nav" value="khoahoc">
                            <input type="text" name="search" class="form-control" placeholder="Tìm khóa học, bài viết...">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="300">
                        <h4>Khóa học nổi bật</h4>
                        <?php
                            // Lấy 3 khóa học ngẫu nhiên để hiển thị
                            $sql_sidebar = "SELECT id_khoahoc, ten_khoahoc, hinh_anh FROM khoahoc ORDER BY RAND() LIMIT 3";
                            $result_sidebar = $conn->query($sql_sidebar);
                            if ($result_sidebar && $result_sidebar->num_rows > 0) {
                                while($row_sidebar = $result_sidebar->fetch_assoc()) {
                        ?>
                        <div class="course-item-sidebar">
                            <a href="./index.php?nav=course_detail&course_id=<?php echo $row_sidebar['id_khoahoc']; ?>">
                                <img src="<?php echo htmlspecialchars($row_sidebar['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row_sidebar['ten_khoahoc']); ?>">
                                <p><?php echo htmlspecialchars($row_sidebar['ten_khoahoc']); ?></p>
                            </a>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                    
                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="400">
                        <h4>Đăng ký tư vấn</h4>
                        <p>Để lại thông tin để được các chuyên gia của chúng tôi tư vấn lộ trình học phù hợp nhất.</p>
                        <a href="#consult-form" class="btn btn-success w-100">Đăng Ký Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('pages/main/form-dk.php'); ?>