<?php
// File này được include từ file index.php, vì vậy biến $conn đã có sẵn
// Chúng ta không cần tạo kết nối mới.

// Lấy 8 khóa học ngẫu nhiên, kết nối với bảng `giangvien` để lấy tên giảng viên
$sql_courses = "SELECT kh.*, gv.ten_giangvien 
                FROM khoahoc kh
                LEFT JOIN giangvien gv ON kh.id_giangvien = gv.id_giangvien
                ORDER BY RAND() 
                LIMIT 8";
$result_courses = $conn->query($sql_courses);
?>

<div class="featured-courses-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="introduce-title">CÁC KHÓA HỌC TIÊU BIỂU</h2>
            <p class="section-subtitle">Những cuộc phiêu lưu tri thức đang chờ bạn khám phá</p>
        </div>

        <div class="row g-4">
            <?php
            if ($result_courses && $result_courses->num_rows > 0) {
                $delay = 0;
                while ($row = $result_courses->fetch_assoc()) {
                    $chiphi = number_format($row['chi_phi'], 0, ',', '.');
            ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="course-card-featured">
                        <div class="course-image-container">
                            <a href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>">
                                <img src="<?php echo htmlspecialchars($row['hinh_anh']); ?>" class="course-image" alt="<?php echo htmlspecialchars($row['ten_khoahoc']); ?>">
                            </a>
                            <div class="badge-popular">Nổi bật</div>
                        </div>
                        <div class="course-details">
                            <h3 class="course-title">
                                <a href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>">
                                    <?php echo htmlspecialchars($row['ten_khoahoc']); ?>
                                </a>
                            </h3>
                           
                        </div>
                        <div class="course-footer">
                             <span class="price"><?php echo $chiphi; ?> VNĐ</span>
                             <a class="btn-view-detail" href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>">
                                 <span>Chi tiết</span> <i class="fas fa-arrow-right"></i>
                             </a>
                        </div>
                    </div>
                </div>
            <?php
                    $delay += 100; // Tăng độ trễ cho thẻ tiếp theo
                }
            } else {
                echo '<p class="text-center col-12">Hiện chưa có khóa học tiêu biểu.</p>';
            }
            ?>
        </div>
    </div>
</div>

<style>
    .featured-courses-section {
        padding: 0px 0;
        background-color: #f8f9fa; /* Màu nền xám rất nhẹ để tách biệt với các khu vực khác */
    }

    /* Tinh chỉnh lại tiêu đề chung */
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .introduce-title {
        font-size: 36px;
        font-weight: 700;
        color: #222;
        margin-bottom: 10px;
    }
    .section-subtitle {
        font-size: 18px;
        color: #666;
    }

    /* Thiết kế thẻ khóa học nổi bật */
    .course-card-featured {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Hiệu ứng mượt mà */
    }

    /* Hiệu ứng HOVER nổi bật */
    .course-card-featured:hover {
        transform: translateY(-10px); /* Nâng thẻ lên */
        box-shadow: 0 12px 35px rgba(13, 179, 59, 0.15); /* Đổ bóng màu xanh lá */
    }

    .course-image-container {
        position: relative;
        overflow: hidden;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .course-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .course-card-featured:hover .course-image {
        transform: scale(1.1); /* Phóng to ảnh khi hover */
    }
    .badge-popular {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 5px 12px;
        color: #fff;
        font-size: 13px;
        font-weight: 500;
        border-radius: 50px;
        background: linear-gradient(45deg, #ff416c, #ff4b2b);
        z-index: 2;
    }

    .course-details {
        padding: 20px;
        flex-grow: 1; /* Đẩy footer xuống dưới cùng */
    }

    .course-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.4;
        min-height: 50px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .course-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .course-card-featured:hover .course-title a {
        color: #0db33b; /* Đổi màu tiêu đề khi hover */
    }

    .course-instructor {
        font-size: 14px;
        color: #555;
    }
    .course-instructor i {
        margin-right: 8px;
        color: #0db33b;
    }

    /* Phần chân thẻ */
    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px 20px 20px;
        border-top: 1px solid #f0f0f0;
        margin: 15px 20px 0 20px;
    }
    .price {
        color: #0db33b;
        font-weight: bold;
        font-size: 20px;
    }
    
    .btn-view-detail {
        color: #0db33b;
        font-weight: 600;
        text-decoration: none;
        position: relative;
    }
    .btn-view-detail i {
        opacity: 0; /* Ẩn mũi tên đi */
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }
    /* Khi hover vào thẻ cha, nút sẽ có hiệu ứng */
    .course-card-featured:hover .btn-view-detail i {
        opacity: 1; /* Hiện mũi tên */
        transform: translateX(0);
    }
</style>