<!-- <div class="guideline-hero-section">
    <div class="hero-content text-center" data-aos="fade-in">
        <h1>Hướng Dẫn Đăng Ký</h1>
        <p>Quy trình đăng ký khóa học đơn giản chỉ trong vài bước</p>
    </div>
</div> -->

<div class="guideline-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="guideline-post">
                    <div class="step-card" data-aos="fade-up">
                        <div class="step-number">01</div>
                        <div class="step-content">
                            <h3>Truy cập và Chọn Khóa Học</h3>
                            <p>Từ trang chủ, chọn mục "Khóa Học" trên thanh điều hướng hoặc tìm kiếm khóa học bạn quan tâm. Sau đó, nhấn vào khóa học để xem thông tin chi tiết.</p>
                        </div>
                        <div class="step-image">
                            <img src="images/huongdan.png" alt="Bước 1: Chọn khóa học" class="img-fluid rounded">
                        </div>
                    </div>

                    <div class="step-card" data-aos="fade-up">
                         <div class="step-number">02</div>
                        <div class="step-content">
                            <h3>Bắt đầu Đăng Ký</h3>
                            <p>Tại trang chi tiết, sau khi đã xem kỹ thông tin, hãy nhấn vào nút "Đăng Ký Ngay" để chuyển đến trang thanh toán.</p>
                        </div>
                        <div class="step-image">
                            <img src="images/huongdan2.png" alt="Bước 2: Nhấn nút đăng ký" class="img-fluid rounded">
                        </div>
                    </div>

                    <div class="step-card" data-aos="fade-up">
                         <div class="step-number">03</div>
                        <div class="step-content">
                            <h3>Hoàn tất Thanh Toán</h3>
                            <p>Kiểm tra lại thông tin cá nhân, chi phí khóa học. Chọn hình thức thanh toán phù hợp và làm theo hướng dẫn để hoàn tất học phí.</p>
                        </div>
                        <div class="step-image">
                             <img src="images/huongdan3.png" alt="Bước 3: Hoàn tất thanh toán" class="img-fluid rounded">
                        </div>
                    </div>

                     <div class="step-card" data-aos="fade-up">
                        <div class="step-number">04</div>
                        <div class="step-content">
                            <h3>Nhận Thông Báo và Vào Học</h3>
                            <p>Sau khi thanh toán thành công, bạn sẽ nhận được thông báo xác nhận. Bây giờ bạn đã có thể truy cập vào khu vực cá nhân để xem lịch học và tài liệu!</p>
                        </div>
                        <div class="step-image">
                             <img src="https://img.freepik.com/free-vector/online-certification-illustration_23-2148575645.jpg" alt="Bước 4: Thành công" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-sticky">
                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                        <h4>Tìm kiếm nhanh</h4>
                        <form class="search-form" method="GET" action="index.php">
                            <input type="hidden" name="nav" value="khoahoc">
                            <input type="text" name="search" class="form-control" placeholder="Tìm khóa học...">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="300">
                        <h4>Khóa học khác</h4>
                        <?php
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
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('form-dk.php'); ?>

<style>
    /* Hero Banner */
    .guideline-hero-section {
        padding: 60px 20px;
        background: linear-gradient(135deg, #0db33b, #28a745);
        color: #fff;
    }
    .hero-content h1 { font-size: 42px; font-weight: 700; }
    .hero-content p { font-size: 18px; opacity: 0.9; }

    /* Bố cục chính */
    .guideline-container {
        margin: 0px auto;
        padding: 20px 0;
    }

    /* Thẻ Hướng dẫn từng bước */
    .step-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.07);
        margin-bottom: 40px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        border-left: 5px solid #0db33b;
    }
    .step-number {
        font-size: 36px;
        font-weight: 700;
        color: #0db33b;
        
    }
    .step-content h3 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    .step-content p {
        font-size: 16px;
        line-height: 1.8;
        color: #555;
    }
    .step-image {
        text-align: center;
    }

    /* Sidebar Styles (đồng bộ với trang about) */
    .sidebar-sticky { position: -webkit-sticky; position: sticky; top: 100px; }
    .sidebar-widget {
        background-color: #fff; padding: 25px; border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05); margin-bottom: 25px;
    }
    .sidebar-widget h4 {
        font-size: 20px; font-weight: 600; margin-bottom: 20px;
        position: relative; padding-bottom: 10px; border-bottom: 1px solid #eee;
    }
    .sidebar-widget h4::after {
        content: ''; position: absolute; bottom: -1px; left: 0;
        width: 50px; height: 2px; background-color: #0db33b;
    }
    .search-form { display: flex; position: relative; }
    .search-form input { padding-right: 45px; }
    .search-form button {
        position: absolute; right: 0; top: 0; height: 100%; width: 45px;
        border: none; background: transparent; color: #0db33b; cursor: pointer;
    }
    .course-item-sidebar a {
        display: flex; gap: 15px; align-items: center; text-decoration: none;
        margin-bottom: 15px; padding: 10px; border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    .course-item-sidebar a:hover { background-color: #f8f9fa; }
    .course-item-sidebar img {
        width: 70px; height: 70px; border-radius: 8px; object-fit: cover;
    }
    .course-item-sidebar p {
        font-size: 15px; color: #333; font-weight: 500; margin: 0;
    }
</style>