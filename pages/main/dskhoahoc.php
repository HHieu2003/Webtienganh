<?php
// File: pages/main/dskhoahoc.php
// Phiên bản được thiết kế lại bởi Đối tác lập trình của bạn

// File này được include từ file index.php, vì vậy biến $conn đã có sẵn
$sql_courses = "SELECT * FROM khoahoc ORDER BY RAND() LIMIT 8";
$result_courses = $conn->query($sql_courses);
?>

<div class="featured-courses-section-reimagined">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="introduce-title">Các Khóa Học Tiêu Biểu</h2>
            <p class="section-subtitle">Những cuộc phiêu lưu tri thức được thiết kế để giúp bạn bứt phá.</p>
        </div>

        <div class="row g-4">
            <?php
            if ($result_courses && $result_courses->num_rows > 0) {
                $delay = 0;
                while ($row = $result_courses->fetch_assoc()) {
                    $chiphi = number_format($row['chi_phi'], 0, ',', '.');
            ?>
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="course-card-v2">
                            <div class="course-card-v2__image-container">
                                <a href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>">
                                    <img src="<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row['ten_khoahoc']); ?>">
                                </a>
                                <div class="course-card-v2__overlay">
                                    <a href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>" class="overlay-icon" title="Xem chi tiết">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </div>
                                <div class="course-card-v2__badge">Nổi bật</div>
                            </div>
                            <div class="course-card-v2__content">
                                <h3 class="course-card-v2__title">
                                    <a href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>">
                                        <?php echo htmlspecialchars($row['ten_khoahoc']); ?>
                                    </a>
                                </h3>
                                <div class="course-card-v2__footer">
                                    <span class="course-card-v2__price"><?php echo $chiphi; ?> <br> VNĐ</span>
                                    <a class="course-card-v2__button" href="./index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>">
                                        Khám phá
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $delay += 100; // Tăng delay cho thẻ tiếp theo
                }
            } else {
                echo '<p class="text-center col-12 alert alert-info">Hiện chưa có khóa học tiêu biểu nào.</p>';
            }
            ?>
        </div>
        <div class="text-center mt-2" data-aos="fade-up" data-aos-delay="200">
            <a href="./index.php?nav=khoahoc" class="btn-view-all-courses">Xem tất cả khóa học <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>

<style>
    /* ==========================================================
       CSS NÂNG CẤP CHO SECTION KHÓA HỌC TIÊU BIỂU
       ========================================================== */
    .featured-courses-section-reimagined {
        padding: 40px 0;
        background-color: var(--neutral-light); /* Sử dụng màu nền xám nhạt */
    }

    .course-card-v2 {
        background-color: var(--neutral-white);
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        border: 1px solid var(--border-color, #e9ecef);
    }

    .course-card-v2:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 28px rgba(13, 179, 59, 0.15);
        border-color: var(--brand-color);
    }

    .course-card-v2__image-container {
        position: relative;
        overflow: hidden;
    }

    .course-card-v2__image-container img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: transform 0.4s ease, filter 0.4s ease;
    }

    .course-card-v2:hover .course-card-v2__image-container img {
        transform: scale(1.1);
        filter: brightness(0.9);
    }
    
    .course-card-v2__overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 138, 44, 0.5); /* Màu xanh lá đậm mờ */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .course-card-v2:hover .course-card-v2__overlay {
        opacity: 1;
    }

    .course-card-v2 .overlay-icon {
        color: white;
        font-size: 24px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        border-radius: 50%;
        transform: scale(0.8);
        transition: transform 0.4s ease, background-color 0.4s ease;
    }
    
    .course-card-v2:hover .overlay-icon {
        transform: scale(1) rotate(360deg);
    }
    
    .overlay-icon:hover {
        background-color: rgba(255,255,255,0.2);
    }

    .course-card-v2__badge {
        position: absolute;
        top: 15px;
        left: -40px; /* Ẩn ban đầu */
        background: linear-gradient(45deg, var(--accent-color), #ffd04e);
        color: var(--text-dark);
        padding: 6px 40px 6px 15px;
        font-size: 13px;
        font-weight: 700;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        transition: left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    
    .course-card-v2:hover .course-card-v2__badge {
        left: 0; /* Hiện ra khi hover */
    }

    .course-card-v2__content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .course-card-v2__title {
        font-size: 17px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
        line-height: 1.5;
        min-height: 51px;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course-card-v2__title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .course-card-v2:hover .course-card-v2__title a {
        color: var(--brand-color);
    }

    .course-card-v2__footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid var(--border-color, #e9ecef);
    }

    .course-card-v2__price {
        color: var(--brand-color-dark);
        font-weight: 800;
        font-size: 20px;
    }

    .course-card-v2__button {
        background: #e7f7ec; /* Nền xanh lá rất nhạt */
        color: var(--brand-color-dark);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .course-card-v2:hover .course-card-v2__button {
        background: var(--brand-color);
        color: var(--neutral-white);
        box-shadow: 0 4px 10px rgba(13, 179, 59, 0.2);
    }
    
    .btn-view-all-courses {
        color: var(--brand-color-dark);
        border: 2px solid var(--brand-color-dark);
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-view-all-courses:hover {
        background-color: var(--brand-color-dark);
        color: var(--neutral-white);
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.2);
    }
    
    .btn-view-all-courses i {
        transition: transform 0.3s ease;
    }
    
    .btn-view-all-courses:hover i {
        transform: translateX(5px);
    }

</style>