<?php
// Giả định $conn và session đã có
$id_giangvien = $_SESSION['id_giangvien'];

// Đếm số lớp học đang dạy
$total_classes = $conn->query("SELECT COUNT(*) as total FROM lop_hoc WHERE id_giangvien = $id_giangvien")->fetch_assoc()['total'] ?? 0;

// Đếm tổng số học viên trong các lớp mình dạy
$sql_total_students = "
    SELECT COUNT(DISTINCT dk.id_hocvien) as total
    FROM dangkykhoahoc dk
    JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    WHERE lh.id_giangvien = $id_giangvien
";
$total_students = $conn->query($sql_total_students)->fetch_assoc()['total'] ?? 0;
?>
<div class="container-fluid">
    <h1 class="title-color">Bảng điều khiển</h1>
    <p class="lead">Chào mừng, <?php echo htmlspecialchars($_SESSION['teacher_name']); ?>!</p>
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card stat-card bg-success animated-card">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-school"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lớp học đang dạy</h5>
                        <p class="card-number"><?php echo $total_classes; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card stat-card bg-primary animated-card" style="animation-delay: 100ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-users"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Tổng số học viên</h5>
                        <p class="card-number"><?php echo $total_students; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>