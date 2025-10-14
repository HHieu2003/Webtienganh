<?php
// user/modules/home.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ.");
}
$id_hocvien = $_SESSION['id_hocvien'];

// Lấy buổi học gần nhất sắp tới
$sql_upcoming = "
    SELECT lh.ngay_hoc, lh.gio_bat_dau, l.ten_lop, kh.ten_khoahoc
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop JOIN khoahoc kh ON l.id_khoahoc = kh.id_khoahoc
    JOIN dangkykhoahoc dk ON l.id_lop = dk.id_lop
    WHERE dk.id_hocvien = ? AND lh.ngay_hoc >= CURDATE() AND l.trang_thai = 'dang hoc'
    ORDER BY lh.ngay_hoc ASC, lh.gio_bat_dau ASC LIMIT 1
";
$stmt_upcoming = $conn->prepare($sql_upcoming);
$stmt_upcoming->bind_param("i", $id_hocvien);
$stmt_upcoming->execute();
$upcoming_class = $stmt_upcoming->get_result()->fetch_assoc();
$stmt_upcoming->close();

// Lấy 3 khóa học ĐANG HỌC gần nhất
$sql_active = "
    SELECT kh.ten_khoahoc, td.tien_do, dk.id_khoahoc
    FROM tien_do_hoc_tap td
    JOIN khoahoc kh ON td.id_khoahoc = kh.id_khoahoc
    JOIN dangkykhoahoc dk ON td.id_hocvien = dk.id_hocvien AND td.id_lop = dk.id_lop
    JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    WHERE td.id_hocvien = ? AND lh.trang_thai = 'dang hoc'
    ORDER BY dk.ngay_dangky DESC LIMIT 3
";
$stmt_active = $conn->prepare($sql_active);
$stmt_active->bind_param("i", $id_hocvien);
$stmt_active->execute();
$active_courses = $stmt_active->get_result();
$stmt_active->close();

// Lấy thông báo chưa đọc gần nhất
$sql_latest_notification = "
    SELECT tieu_de, noi_dung, ngay_tao FROM thongbao
    WHERE id_hocvien = ? AND trang_thai = 'chưa đọc'
    ORDER BY ngay_tao DESC LIMIT 1
";
$stmt_notification = $conn->prepare($sql_latest_notification);
$stmt_notification->bind_param("i", $id_hocvien);
$stmt_notification->execute();
$latest_notification = $stmt_notification->get_result()->fetch_assoc();
$stmt_notification->close();

// Hàm tạo badge điểm danh
function get_latest_attendance_badge($status)
{
    if ($status === null) return '';
    switch ($status) {
        case 'co mat':
            return '<span class="badge bg-success-soft text-success">Có mặt</span>';
        case 'vang':
            return '<span class="badge bg-danger-soft text-danger">Vắng</span>';
        case 'muon':
            return '<span class="badge bg-warning-soft text-warning">Muộn</span>';
        default:
            return '<span class="badge bg-secondary-soft text-secondary">Chưa điểm danh</span>';
    }
}
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated-component {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-color-light), #fff);
        padding: 25px;
        border-radius: var(--border-radius);
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
    }

    .welcome-banner h2 {
        font-weight: 700;
        color: var(--dark-text);
    }

    .welcome-banner p {
        color: var(--gray-text);
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #f0f0f0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        flex-shrink: 0;
    }

    .stat-info h5 {
        font-size: 15px;
        color: var(--gray-text);
        margin: 0;
        font-weight: 500;
    }

    .stat-info p {
        font-size: 26px;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }

    .widget {
        background: #fff;
        padding: 25px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        height: 100%;
    }

    .widget-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .widget-header h4 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .widget-header a {
        font-size: 14px;
        text-decoration: none;
        font-weight: 500;
    }

    .course-progress-item {
        margin-bottom: 15px;
    }

    .course-progress-item:last-child {
        margin-bottom: 0;
    }

    .course-progress-item .info {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .upcoming-class-card {
        background: var(--primary-color-light);
        border-left: 5px solid var(--primary-color);
        padding: 20px;
        border-radius: 10px;
    }

    .notification-card {
        background-color: #fff3cd;
        border-left: 5px solid #ffc107;
        padding: 20px;
        border-radius: 10px;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
    }

    .notification-card:hover {
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
    }

    /* Custom badge colors */
    .bg-success-soft {
        background-color: #d4edda;
    }

    .text-success {
        color: #155724 !important;
    }

    .bg-warning-soft {
        background-color: #fff3cd;
    }

    .text-warning {
        color: #856404 !important;
    }

    .bg-danger-soft {
        background-color: #f8d7da;
    }

    .text-danger {
        color: #721c24 !important;
    }

    .bg-secondary-soft {
        background-color: #e2e3e5;
    }

    .text-secondary {
        color: #41464b !important;
    }
</style>

<div class="stat-grid">
    <div class="stat-card animated-component" style="animation-delay: 100ms;">
        <div class="stat-icon" style="background: #0db33b;"><i class="fa-solid fa-person-running"></i></div>
        <div class="stat-info">
            <h5>Đang học</h5>
            <p><?php echo htmlspecialchars($total_courses); ?></p>
        </div>
    </div>
    <div class="stat-card animated-component" style="animation-delay: 200ms;">
        <div class="stat-icon" style="background: #0d6efd;"><i class="fa-solid fa-pen-to-square"></i></div>
        <div class="stat-info">
            <h5>Bài test</h5>
            <p><?php echo htmlspecialchars($total_tests); ?></p>
        </div>
    </div>
    <div class="stat-card animated-component" style="animation-delay: 300ms;">
        <div class="stat-icon" style="background: #6f42c1;"><i class="fa-solid fa-calendar-week"></i></div>
        <div class="stat-info">
            <h5>Lịch tuần này</h5>
            <p><?php echo htmlspecialchars($total_classes_this_week); ?></p>
        </div>
    </div>
    <div class="stat-card animated-component" style="animation-delay: 400ms;">
        <div class="stat-icon" style="background: #fd7e14;"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-info">
            <h5>Hoàn thành</h5>
            <p><?php echo htmlspecialchars($completed_courses); ?></p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="widget animated-component" style="animation-delay: 500ms;">
            <div class="widget-header">
                <h4><i class="fa-solid fa-person-chalkboard text-primary"></i> Khóa học đang học</h4>
                <a href="./dashboard.php?nav=khoahoc&filter=active">Xem tất cả</a>
            </div>
            <?php if ($active_courses->num_rows > 0): ?>
                <?php while ($course = $active_courses->fetch_assoc()): ?>
                    <div class="course-progress-item">
                        <div class="info">
                            <strong><?php echo htmlspecialchars($course['ten_khoahoc']); ?></strong>
                            <span><?php echo round($course['tien_do']); ?>%</span>
                        </div>
                        <div class="progress" style="height: 10px;" role="progressbar" aria-valuenow="<?php echo $course['tien_do']; ?>">
                            <div class="progress-bar" style="width: <?php echo $course['tien_do']; ?>%;"></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center p-4 text-muted">
                    <i class="fa-solid fa-box-open fa-2x mb-3"></i>
                    <p>Bạn chưa có khóa học nào đang hoạt động.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="d-flex flex-column gap-4">
            <div class="widget animated-component" style="animation-delay: 600ms;">
                <div class="widget-header">
                    <h4><i class="fa-solid fa-calendar-day text-success"></i> Lịch học sắp tới</h4>
                    <a href="./dashboard.php?nav=lichhoctuan">Xem lịch tuần</a>
                </div>
                <?php if ($upcoming_class): ?>
                    <div class="upcoming-class-card">
                        <h5><?php echo htmlspecialchars($upcoming_class['ten_khoahoc']); ?></h5>
                        <p class="mb-1"><strong>Lớp:</strong> <?php echo htmlspecialchars($upcoming_class['ten_lop']); ?></p>
                        <p class="mb-0"><strong>Thời gian:</strong> <?php echo date("H:i", strtotime($upcoming_class['gio_bat_dau'])); ?> - <?php echo date("d/m/Y", strtotime($upcoming_class['ngay_hoc'])); ?></p>
                    </div>
                <?php else: ?>
                    <div class="text-center p-3 text-muted"><i class="fa-solid fa-calendar-xmark fa-2x mb-2"></i>
                        <p class="mb-0">Không có buổi học nào sắp diễn ra.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="widget animated-component" style="animation-delay: 700ms;">
                <div class="widget-header">
                    <h4><i class="fa-solid fa-user-check text-info"></i> Điểm danh gần nhất</h4>
                    <a href="./dashboard.php?nav=diemdanh">Xem chi tiết</a>
                </div>
                <?php if ($latest_attendance): ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Buổi học ngày: <strong><?php echo date("d/m/Y", strtotime($latest_attendance['ngay_hoc'])); ?></strong></span>
                        <?php echo get_latest_attendance_badge($latest_attendance['trang_thai']); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center p-3 text-muted"><i class="fa-solid fa-file-circle-question fa-2x mb-2"></i>
                        <p class="mb-0">Chưa có dữ liệu điểm danh.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($latest_notification): ?>
                <div class="animated-component" style="animation-delay: 800ms;">
                    <a href="./dashboard.php?nav=thongbao" class="text-decoration-none">
                        <div class="notification-card">
                            <h5 class="mb-2 text-dark"><i class="fa-solid fa-bell text-warning"></i> Thông báo mới</h5>
                            <p class="mb-1 text-dark"><strong><?php echo htmlspecialchars($latest_notification['tieu_de']); ?></strong></p>
                            <p class="mb-0 small text-muted"><?php echo htmlspecialchars(substr($latest_notification['noi_dung'], 0, 100)) . '...'; ?></p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>