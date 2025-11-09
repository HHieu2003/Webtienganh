<?php
$sql_lecturers = "SELECT ten_giangvien, mo_ta, hinh_anh, email FROM giangvien ORDER BY id_giangvien";
$result_lecturers = $conn->query($sql_lecturers);
?>

<style>
    /* --- Biến màu và cài đặt chung --- */
    :root {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --accent-color: #ffc107;
        --neutral-white: #FFFFFF;
        --neutral-light: #F8F9FA;
        --neutral-gray: #6C757D;
        --text-dark: #212529;
        --shadow-soft: 0 8px 25px rgba(0, 0, 0, 0.07);
        --shadow-medium: 0 12px 35px rgba(13, 179, 59, 0.12);
    }

    /* --- Section Container --- */
    .lecturer-section-v2 {
        padding: 60px 0;
        background: linear-gradient(135deg, #f0fdf4 0%, #e7f7ec 100%);
        /* Nền gradient xanh lá nhạt */
        position: relative;
        overflow: hidden;
    }

    /* Họa tiết nền */
    .lecturer-section-v2::before {
        content: '';
        position: absolute;
        top: 10%;
        left: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(13, 179, 59, 0.06), transparent 70%);
        border-radius: 50%;
        animation: float-shape 8s ease-in-out infinite alternate;
    }

    .lecturer-section-v2::after {
        content: '';
        position: absolute;
        bottom: 5%;
        right: -80px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 193, 7, 0.08), transparent 70%);
        border-radius: 50%;
        animation: float-shape 10s ease-in-out infinite alternate 1s;
    }

    @keyframes float-shape {
        from {
            transform: translateY(0px) rotate(0deg);
        }

        to {
            transform: translateY(-15px) rotate(20deg);
        }
    }

    /* --- Card Giảng Viên --- */
    .lecturer-card-v2 {
        background-color: var(--neutral-white);
        border-radius: 20px;
        /* Bo góc mềm mại hơn */
        text-align: center;
        padding: 35px 25px;
        /* Tăng padding */
        box-shadow: var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        /* Hiệu ứng mượt hơn */
        height: 100%;
        position: relative;
        /* Cho hiệu ứng nền */
        overflow: hidden;
        /* Ẩn phần thừa của hiệu ứng nền */
        border: 1px solid #eee;
    }

    /* Hiệu ứng nền khi hover */
    .lecturer-card-v2::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(13, 179, 59, 0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        transition: transform 0.6s ease-out;
        opacity: 0;
        z-index: 0;
    }

    .lecturer-card-v2:hover::before {
        transform: rotate(0deg) scale(1.1);
        opacity: 1;
    }

    .lecturer-card-v2>* {
        /* Đảm bảo nội dung nổi lên trên nền */
        position: relative;
        z-index: 1;
    }

    .lecturer-card-v2:hover {
        transform: translateY(-12px) scale(1.03);
        /* Hiệu ứng nổi bật hơn */
        box-shadow: var(--shadow-medium);
        border-color: var(--brand-color);
    }

    /* Ảnh đại diện */
    .lecturer-avatar-v2 {
        position: relative;
        /* Cho viền gradient */
        width: 160px;
        height: 160px;
        border-radius: 50%;
        margin: 0 auto 25px;
        padding: 6px;
        /* Khoảng cách cho viền gradient */
        background: linear-gradient(135deg, var(--brand-color), var(--accent-color));
    }

    .lecturer-avatar-v2 img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--neutral-white);
        /* Viền trắng bên trong */
        transition: transform 0.4s ease;
    }

    .lecturer-card-v2:hover .lecturer-avatar-v2 img {
        transform: scale(1.05) rotate(3deg);
    }

    /* Tên Giảng Viên */
    .lecturer-name-v2 {
        font-size: 20px;
        /* Giảm nhẹ font size */
        font-weight: 700;
        /* Tăng độ đậm */
        color: var(--brand-color-dark);
        /* Màu xanh lá đậm */
        margin-bottom: 8px;
        line-height: 1.4;
    }

    /* Mô tả */
    .lecturer-description-v2 {
        font-size: 15px;
        color: var(--neutral-gray);
        /* Màu xám nhạt */
        line-height: 1.7;
        min-height: 85px;
        /* Tăng chiều cao tối thiểu */
        display: -webkit-box;
        -webkit-line-clamp: 4;
        /* Giới hạn 4 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .lecturer-avatar-v2 {
            width: 140px;
            height: 140px;
        }
    }

    @media (max-width: 767px) {
        .lecturer-avatar-v2 {
            width: 120px;
            height: 120px;
        }

        .lecturer-name-v2 {
            font-size: 18px;
        }

        .lecturer-description-v2 {
            font-size: 14px;
            min-height: 75px;
        }
    }


    /* ==========================================================
   CSS CHO ICON SOCIAL CỦA GIẢNG VIÊN
   ========================================================== */

    .lecturer-social-v2 {
        margin-top: 20px;
        /* Khoảng cách với phần mô tả */
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
        /* Đường kẻ mỏng phân cách */
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        /* Khoảng cách giữa các icon */
    }

    .lecturer-social-v2 a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #eef7f0;
        /* Màu nền xanh lá rất nhạt */
        color: var(--brand-color);
        /* Màu icon xanh lá */
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .lecturer-social-v2 a:hover {
        background-color: var(--brand-color);
        /* Đổi nền khi hover */
        color: var(--neutral-white);
        /* Đổi màu icon khi hover */
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 4px 12px rgba(13, 179, 59, 0.25);
    }
</style>

<div class="lecturer-section-v2 section-wrapper">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">ĐỘI NGŨ GIẢNG VIÊN TẠI FIGHTER</h2>
            <p class="section-subtitle">Những người thầy, người cô tận tâm, giàu kinh nghiệm và chuyên môn cao sẽ đồng hành cùng bạn trên chặng đường chinh phục tiếng Anh.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php
            if ($result_lecturers && $result_lecturers->num_rows > 0) {
                $delay = 0;
                while ($row = $result_lecturers->fetch_assoc()) {
                    // Cắt ngắn mô tả nếu quá dài
                    $description = htmlspecialchars($row['mo_ta']);
                    if (mb_strlen($description) > 150) {
                        // $description = mb_substr($description, 0, 147) . '...';
                    }
                    $image_url = htmlspecialchars(!empty($row['hinh_anh']) ? $row['hinh_anh'] : 'images/default-avatar.png');
                    $lecturer_name = htmlspecialchars($row['ten_giangvien']);
                    $email = htmlspecialchars($row['email']); // Lấy email
            ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="lecturer-card-v2">
                            <div class="lecturer-avatar-v2">
                                <img src="<?php echo $image_url; ?>" alt="<?php echo $lecturer_name; ?>">
                            </div>
                            <h4 class="lecturer-name-v2"><?php echo $lecturer_name; ?></h4>
                            <p class="lecturer-description-v2"><?php echo $description; ?></p>

                            <div class="lecturer-social-v2">
                                <?php if (!empty($email)): ?>
                                    <a href="mailto:<?php echo $email; ?>" title="Gửi Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                <?php endif; ?>

                                <a href="#" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                    $delay += 100; // Tăng delay cho hiệu ứng nối tiếp
                }
            } else {
                echo '<div class="col-12"><p class="text-center alert alert-info">Thông tin giảng viên đang được cập nhật. Vui lòng quay lại sau.</p></div>';
            }
            ?>
        </div>
    </div>
</div>