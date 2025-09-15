
<div class="about-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="about-post" data-aos="fade-up">
                    <h2>Chào mừng bạn đến với Tiếng Anh Fighter!</h2>
                    <p class="lead-text">
                        Dựa trên 5 giá trị cốt lõi "Tử tế - Lắng nghe - Chia sẻ - Học tập - Kỷ luật", mỗi sản phẩm của chúng tôi đều là tâm huyết của đội ngũ giảng viên cùng với óc sáng tạo và tinh thần đoàn kết.
                    </p>
                    <img src="images/khoahoc1.jpg" alt="Môi trường học tập tại Tiếng Anh Fighter" class="img-fluid rounded mb-4">
                    
                    <h3>Lĩnh vực hoạt động chính:</h3>
                    <ul>
                        <li>Đào tạo các khóa học tiếng Anh trực tuyến và trực tiếp.</li>
                        <li>Biên soạn sách và các tài liệu học tập độc quyền.</li>
                        <li>Tổ chức thi thử và các sự kiện học thuật.</li>
                    </ul>
                    <p>Với phương châm đặt khách hàng làm trung tâm, chúng tôi luôn không ngừng nâng cao chất lượng sản phẩm dịch vụ bằng cách ứng dụng công nghệ để có thể đáp ứng được mọi nhu cầu ngày càng cao của khách hàng.</p>
                </div>

                <div class="values-section" data-aos="fade-up">
                     <div class="row">
                        <div class="col-md-4">
                            <div class="value-card">
                                <div class="value-icon"><i class="fas fa-users"></i></div>
                                <h4>Về Chúng Tôi</h4>
                                <p>Hành trình thắp lửa, chắp cánh ước mơ IELTS cho hàng triệu người Việt.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="value-card">
                                <div class="value-icon"><i class="fas fa-book-open-reader"></i></div>
                                <h4>Phương Pháp Đào Tạo</h4>
                                <p>Phương pháp RIPL độc quyền, đề cao tương tác và thực hành liên tục.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="value-card">
                                <div class="value-icon"><i class="fas fa-chalkboard-user"></i></div>
                                <h4>Đội Ngũ Giảng Viên</h4>
                                <p>Những người "thầy" tài năng, tâm huyết và luôn truyền cảm hứng.</p>
                            </div>
                        </div>
                     </div>
                </div>

                <div class="about-post" data-aos="fade-up">
                    <h2>Hành trình phát triển</h2>
                    <p>Trải qua 17 năm hình thành và phát triển, Tiếng Anh Fighter đã nâng tổng số lên hơn 150 chi nhánh đào tạo tại khắp các tỉnh thành trên toàn quốc, đào tạo thành công hơn 1.000.000 học viên.</p>
                    <ul>
                        <li>Hệ thống giáo dục Anh ngữ uy tín hàng đầu tại Việt Nam với các chương trình học chuẩn quốc tế.</li>
                        <li>Áp dụng công nghệ hiện đại và Hệ thống quản lý học tập trực tuyến (LMS) hàng đầu thế giới.</li>
                        <li>Tiên phong với sứ mệnh "Giúp hàng triệu người Việt Nam giỏi tiếng Anh", trở thành nơi thắp sáng tiềm năng cho hàng triệu học viên.</li>
                    </ul>
                </div>

                 <div class="welcome-img text-center" data-aos="fade-up">
                    <img src="images/anh1.png" alt="Đội ngũ Tiếng Anh Fighter" class="img-fluid rounded">
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-sticky">
                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                        <h4>Tìm kiếm nhanh</h4>
                        <form class="search-form" method="GET" action="index.php">
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
                        <div class="advertise-card">
                            <img src="https://vietop.edu.vn/wp-content/uploads/2025/09/popup-back-to-school.jpg" alt="Quảng cáo">
                             <div class="advertise-content">
                                <h5>Nhận lộ trình học miễn phí!</h5>
                                <p>Để lại thông tin để được các chuyên gia của chúng tôi tư vấn lộ trình học phù hợp nhất.</p>
                                <a href="#consult-form" class="btn btn-success w-100">Đăng Ký Ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('pages/main/form-dk.php'); ?>


<style>
    /* Hero Banner */
    .about-hero-section {
        position: relative;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        overflow: hidden;
        background-image: linear-gradient(103deg, #8bf398 0%, #21d157 100%);
    }
    .parallax-bg {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 120%; /* Lớn hơn để có không gian di chuyển */
        background-size: cover;
        background-position: center;
        z-index: -1;
        filter: brightness(0.6);
    }
    .hero-content h1 {
        font-size: 48px;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }
    .hero-content p {
        font-size: 20px;
        opacity: 0.9;
    }

    /* Bố cục chính */
    .about-container {
        margin: 0px auto;
        padding: 20px 0;
    }

    /* Nội dung bài viết */
    .about-post {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .about-post h2 {
        font-size: 28px;
        font-weight: 600;
        color: #0db33b;
        margin-bottom: 20px;
    }
    .about-post h3 {
        font-size: 20px;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 15px;
    }
    .about-post p, .about-post li {
        font-size: 16px;
        line-height: 1.8;
        color: #555;
    }
    .about-post ul {
        padding-left: 20px;
    }
    .lead-text {
        font-size: 18px !important;
        font-style: italic;
        color: #333 !important;
    }

    /* Thẻ giá trị cốt lõi */
    .values-section {
        margin-bottom: 30px;
    }
    .value-card {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        text-align: center;
        height: 100%;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }
    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: #0db33b;
    }
    .value-icon {
        font-size: 36px;
        color: #0db33b;
        margin-bottom: 15px;
    }
    .value-card h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .value-card p {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
    }

    /* Sidebar */
    .sidebar-sticky {
        position: -webkit-sticky; /* Dành cho Safari */
        position: sticky;
        top: 100px; /* Vị trí bắt đầu dính lại */
    }
    .sidebar-widget {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    .sidebar-widget h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
     .sidebar-widget h4::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #0db33b;
    }

    .search-form {
        display: flex;
        position: relative;
    }
    .search-form input {
        padding-right: 45px;
    }
    .search-form button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 45px;
        border: none;
        background: transparent;
        color: #0db33b;
        cursor: pointer;
    }

    .course-item-sidebar a {
        display: flex;
        gap: 15px;
        align-items: center;
        text-decoration: none;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    .course-item-sidebar a:hover {
        background-color: #f8f9fa;
    }
    .course-item-sidebar img {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
    }
    .course-item-sidebar p {
        font-size: 15px;
        color: #333;
        font-weight: 500;
        margin: 0;
    }
    
    .advertise-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .advertise-content {
        padding: 20px;
    }
    .advertise-content h5 {
        font-weight: 600;
    }
    .advertise-content p {
        font-size: 14px;
        margin-bottom: 15px;
    }
</style>

<script>
    // Hiệu ứng Parallax cho banner
    window.addEventListener('scroll', function() {
        const parallax = document.querySelector('.parallax-bg');
        if (parallax) {
            let offset = window.pageYOffset;
            parallax.style.transform = 'translateY(' + offset * 0.3 + 'px)';
        }
    });
</script>