<?php
// File: admin/modules/teacher_home.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) {
    die("Truy cập bị từ chối.");
}

$id_giangvien = $_SESSION['id_giangvien'];

// --- LẤY DỮ LIỆU CHO DASHBOARD ---

// 1. Chỉ lấy dữ liệu cho thẻ "Lớp đang dạy"
$total_classes = $conn->query("SELECT COUNT(*) as total FROM lop_hoc WHERE id_giangvien = $id_giangvien AND trang_thai = 'dang hoc'")->fetch_assoc()['total'] ?? 0;

// 2. Lấy 5 buổi dạy sắp tới
$sql_upcoming_schedule = "
    SELECT lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc, l.ten_lop, lh.phong_hoc
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    WHERE l.id_giangvien = ? AND lh.ngay_hoc >= CURDATE()
    ORDER BY lh.ngay_hoc ASC, lh.gio_bat_dau ASC
    LIMIT 5
";
$stmt_schedule = $conn->prepare($sql_upcoming_schedule);
$stmt_schedule->bind_param("i", $id_giangvien);
$stmt_schedule->execute();
$upcoming_schedules = $stmt_schedule->get_result();

// 3. Lấy danh sách các lớp học đang dạy để tạo lối tắt
$sql_my_classes = "
    SELECT id_lop, ten_lop, so_luong_hoc_vien 
    FROM lop_hoc 
    WHERE id_giangvien = ? AND trang_thai = 'dang hoc' 
    ORDER BY ten_lop ASC
";
$stmt_classes = $conn->prepare($sql_my_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$my_classes = $stmt_classes->get_result();
?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color-dark));
   
        border-radius: 12px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow);
    }
    .welcome-icon {
        font-size: 60px;
        opacity: 0.2;
    }
    .list-group-item {
        transition: background-color 0.2s ease-in-out, border-left-color 0.2s ease-in-out;
        border-left: 3px solid transparent;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
        border-left-color: var(--primary-color);
    }
    .card-footer {
        background-color: #f8f9fa;
    }
</style>

<div class="container-fluid">
    <div class="welcome-banner animated-card mb-4">
        <div class="welcome-content">
            <h1 class="h3">Chào mừng, <?php echo htmlspecialchars($_SESSION['teacher_name']); ?>!</h1>
            <p class="lead mb-0">Chúc bạn một ngày vui vẻ và tràn đầy năng lượng.</p>
        </div>
        <div class="welcome-icon">
            <i class="fa-solid fa-mug-hot"></i>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="mb-4">
            <div class="card stat-card bg-success animated-card" style="animation-delay: 100ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-school"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lớp đang dạy</h5>
                        <p class="card-number" data-target="<?php echo $total_classes; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card animated-card h-100" style="animation-delay: 400ms;">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa-solid fa-calendar-alt me-2"></i>Lịch dạy sắp tới</h4>
                </div>
                <div class="card-body">
                    <?php if ($upcoming_schedules->num_rows > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php while($schedule = $upcoming_schedules->fetch_assoc()): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="d-block text-primary"><?php echo htmlspecialchars($schedule['ten_lop']); ?></strong>
                                        <small class="text-muted">
                                            <i class="fa-solid fa-clock"></i> <?php echo date("H:i", strtotime($schedule['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($schedule['gio_ket_thuc'])); ?>
                                            <span class="mx-2">|</span>
                                            <i class="fa-solid fa-map-marker-alt"></i> <?php echo htmlspecialchars($schedule['phong_hoc']); ?>
                                        </small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?php echo date("d/m/Y", strtotime($schedule['ngay_hoc'])); ?></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center text-muted p-4">Không có lịch dạy nào sắp tới.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card animated-card h-100" style="animation-delay: 500ms;">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa-solid fa-list-check me-2"></i>Truy cập nhanh lớp học</h4>
                </div>
                <div class="card-body">
                     <?php if ($my_classes->num_rows > 0): ?>
                        <div class="list-group">
                            <?php while($class = $my_classes->fetch_assoc()): ?>
                                <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $class['id_lop']; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($class['ten_lop']); ?>
                                    <span class="badge bg-success rounded-pill" title="Sĩ số"><?php echo $class['so_luong_hoc_vien']; ?> <i class="fa-solid fa-user"></i></span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted p-4">Bạn chưa được phân công lớp học nào.</div>
                    <?php endif; ?>
                </div>
                 <div class="card-footer text-center">
                    <a href="./admin.php?nav=teacher_classes" class="btn btn-outline-primary btn-sm">Xem tất cả lớp học <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Hiệu ứng đếm số cho các thẻ thống kê
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.card-number');
    
    counters.forEach(counter => {
        counter.innerText = '0'; // Luôn bắt đầu từ 0

        const animate = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / 100; // Tính bước nhảy để hoàn thành trong khoảng 100 frame

            if (count < target) {
                counter.innerText = `${Math.ceil(count + increment)}`;
                setTimeout(animate, 20);
            } else {
                counter.innerText = target;
            }
        };

        setTimeout(animate, 400); 
    });
});
</script>