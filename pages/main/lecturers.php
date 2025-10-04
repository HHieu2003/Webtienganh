<?php
// File: pages/main/lecturers.php
// Lấy danh sách giảng viên từ CSDL
$sql_lecturers = "SELECT ten_giangvien, mo_ta, hinh_anh, email FROM giangvien ORDER BY id_giangvien";
$result_lecturers = $conn->query($sql_lecturers);
?>

<style>
    .lecturer-section { padding: 60px 0; background-color: #f8f9fa; }
    .lecturer-card {
        background-color: #fff;
        border-radius: 15px;
        text-align: center;
        padding: 30px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        height: 100%;
    }
    .lecturer-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.1);
    }
    .lecturer-avatar img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 5px solid #e7f7ec;
    }
    .lecturer-name {
        font-size: 22px;
        font-weight: 600;
        color: #0db33b;
        margin-bottom: 10px;
    }
    .lecturer-description {
        font-size: 15px;
        color: #555;
        line-height: 1.6;
        min-height: 70px; /* Giữ chỗ cho mô tả */
    }
</style>

<div class="lecturer-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">ĐỘI NGŨ GIẢNG VIÊN TẠI FIGHTER</h2>
            <p class="section-subtitle">Những người thầy, người cô tận tâm sẽ đồng hành cùng bạn trên chặng đường chinh phục tiếng Anh.</p>
        </div>

        <div class="row g-4">
            <?php
            if ($result_lecturers && $result_lecturers->num_rows > 0) {
                $delay = 0;
                while($row = $result_lecturers->fetch_assoc()) {
            ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="lecturer-card">
                    <div class="lecturer-avatar">
                        <img src="<?php echo htmlspecialchars(!empty($row['hinh_anh']) ? $row['hinh_anh'] : 'images/default-avatar.png'); ?>" alt="<?php echo htmlspecialchars($row['ten_giangvien']); ?>">
                    </div>
                    <h4 class="lecturer-name"><?php echo htmlspecialchars($row['ten_giangvien']); ?></h4>
                    <p class="lecturer-description"><?php echo htmlspecialchars($row['mo_ta']); ?></p>
                </div>
            </div>
            <?php
                    $delay += 100;
                }
            } else {
                echo '<p class="text-center col-12">Thông tin giảng viên đang được cập nhật.</p>';
            }
            ?>
        </div>
    </div>
</div>