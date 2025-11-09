<?php
// File: admin/modules/teacher/teacher_home.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) {
    die("Truy cập bị từ chối.");
}
date_default_timezone_set('Asia/Ho_Chi_Minh');

$id_giangvien = $_SESSION['id_giangvien'];

// --- LẤY DỮ LIỆU CHO DASHBOARD ---
// 1. Dữ liệu cho các thẻ thống kê chính
$total_classes_active = $conn->query("SELECT COUNT(*) as total FROM lop_hoc WHERE id_giangvien = $id_giangvien AND trang_thai = 'dang hoc'")->fetch_assoc()['total'] ?? 0;

$today = new DateTime();
$start_of_week = (clone $today)->modify('monday this week')->format('Y-m-d');
$end_of_week = (clone $today)->modify('sunday this week')->format('Y-m-d');

$stmt_week_schedule = $conn->prepare("
    SELECT COUNT(*) as total
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    WHERE l.id_giangvien = ? AND lh.ngay_hoc BETWEEN ? AND ?
");
$stmt_week_schedule->bind_param("iss", $id_giangvien, $start_of_week, $end_of_week);
$stmt_week_schedule->execute();
$total_week_schedules = $stmt_week_schedule->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_week_schedule->close();

$total_classes_completed = $conn->query("SELECT COUNT(*) as total FROM lop_hoc WHERE id_giangvien = $id_giangvien AND trang_thai = 'da xong'")->fetch_assoc()['total'] ?? 0;


// 2. Lấy 5 buổi dạy sắp tới
$sql_upcoming_schedule = "
    SELECT lh.id_lichhoc, lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc, l.ten_lop, lh.phong_hoc, lh.ghi_chu
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    WHERE l.id_giangvien = ? AND CONCAT(lh.ngay_hoc, ' ', lh.gio_ket_thuc) >= NOW()
    ORDER BY lh.ngay_hoc ASC, lh.gio_bat_dau ASC
    LIMIT 5
";
$stmt_schedule = $conn->prepare($sql_upcoming_schedule);
$stmt_schedule->bind_param("i", $id_giangvien);
$stmt_schedule->execute();
$upcoming_schedules = $stmt_schedule->get_result();
$total_upcoming_schedules = $upcoming_schedules->num_rows;


// 3. Lấy danh sách các lớp học đang dạy để tạo lối tắt
$sql_my_classes = "
    SELECT id_lop, ten_lop, so_luong_hoc_vien, ten_khoahoc
    FROM lop_hoc lh
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE lh.id_giangvien = ? AND lh.trang_thai = 'dang hoc'
    ORDER BY ten_lop ASC
    LIMIT 6
";
$stmt_classes = $conn->prepare($sql_my_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$my_classes = $stmt_classes->get_result();
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
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--brand-color-light), #fff);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome-banner h1 {
        font-weight: 700;
        color: var(--brand-color-dark);
        margin-bottom: 5px;
    }

    .welcome-banner p {
        color: var(--sidebar-text);
    }

    .welcome-banner .welcome-icon {
        font-size: 50px;
        color: var(--brand-color);
        opacity: 0.5;
    }

    .widget {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
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
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--sidebar-text);
    }

    .widget-header h4 i {
        color: var(--brand-color);
    }

    .widget-header .view-all-link {
        font-size: 14px;
        text-decoration: none;
        font-weight: 500;
        color: var(--brand-color);
    }

    .widget-body {
        flex-grow: 1;
    }

    .schedule-list-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .schedule-list-item:not(:last-child) {
        border-bottom: 1px dashed var(--border-color);
    }

    .schedule-date {
        flex-shrink: 0;
        text-align: center;
        font-weight: 600;
        width: 60px;
    }

    .schedule-date .day {
        display: block;
        font-size: 24px;
        color: var(--brand-color);
    }

    .schedule-date .month {
        font-size: 14px;
        color: var(--text-color-light);
    }

    .schedule-details h6 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .schedule-details p {
        font-size: 14px;
        color: var(--text-color-light);
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .schedule-note {
        background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
        border-left: 4px solid #f59e0b;
        padding: 6px 7px;
        margin-top: 12px;
        font-size: 13px;
        border-radius: 8px;
        display: none;
        animation: fadeInUp 0.5s;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
        transition: all 0.3s ease;
    }

    .schedule-note.visible {
        display: block;
    }

    .schedule-note:hover {
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        transform: translateY(-2px);
    }

    .schedule-note strong {
        color: #92400e;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    /* Xử lý URL dài trong ghi chú */
    .schedule-note-content {
        display: block;
        padding: 4px 5px;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 6px;
        word-wrap: break-word;
        word-break: break-all;
        font-size: 13px;
        color: #78350f;
        line-height: 1.6;
        max-height: 80px;
        overflow-y: auto;
    }

    /* Scrollbar cho nội dung dài */
    .schedule-note-content::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    .schedule-note-content::-webkit-scrollbar-track {
        background: #fef3c7;
        border-radius: 10px;
    }

    .schedule-note-content::-webkit-scrollbar-thumb {
        background: #f59e0b;
        border-radius: 10px;
    }

    .schedule-note-content::-webkit-scrollbar-thumb:hover {
        background: #d97706;
    }

    /* Link trong ghi chú */
    .schedule-note-content a {
        color: #2563eb;
        text-decoration: none;
        word-break: break-all;
        transition: color 0.2s ease;
    }

    .schedule-note-content a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* Responsive cho mobile */
    @media (max-width: 767.98px) {
        .schedule-note {
            padding: 10px 12px;
            font-size: 12px;
        }

        .schedule-note-content {
            font-size: 11px;
            max-height: 60px;
        }
    }

    .quick-access-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .class-shortcut-card {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .class-shortcut-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
        border-color: var(--brand-color);
    }

    .class-shortcut-card .class-info h6 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .class-shortcut-card .class-info p {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .class-shortcut-card .class-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }

    .class-shortcut-card .btn-manage {
        background-color: var(--brand-color-light);
        color: var(--brand-color-dark);
        border: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .class-shortcut-card:hover .btn-manage {
        background-color: var(--brand-color);
        color: #fff;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100%;
        color: var(--text-color-light);
        padding: 20px;
    }

    .empty-state i {
        font-size: 40px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 767.98px) {
        .welcome-banner {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .welcome-banner h1 {
            font-size: 1.5rem;
        }

        .welcome-banner p {
            font-size: 1rem;
        }

        .widget {
            padding: 20px;
        }

        .quick-access-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card bg-primary animated-component" style="animation-delay: 100ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-school"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lớp đang dạy</h5>
                        <p class="card-number" data-target="<?php echo $total_classes_active; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card bg-success animated-component" style="animation-delay: 200ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-calendar-week"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lịch dạy tuần này</h5>
                        <p class="card-number" data-target="<?php echo $total_week_schedules; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card bg-info animated-component" style="animation-delay: 300ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Buổi dạy sắp tới</h5>
                        <p class="card-number" data-target="<?php echo $total_upcoming_schedules; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card bg-secondary animated-component" style="animation-delay: 400ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-check-double"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lớp đã hoàn thành</h5>
                        <p class="card-number" data-target="<?php echo $total_classes_completed; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="widget animated-component h-100" style="animation-delay: 500ms;">
                <div class="widget-header">
                    <h4><i class="fa-solid fa-calendar-check"></i>Lịch dạy sắp tới</h4>
                    <a href="./admin.php?nav=teacher_classes" class="view-all-link">Xem tất cả</a>
                </div>
                <div class="widget-body">
                    <?php if ($upcoming_schedules->num_rows > 0): ?>
                        <div class="schedule-list">
                            <?php mysqli_data_seek($upcoming_schedules, 0);
                            while ($schedule = $upcoming_schedules->fetch_assoc()):
                                $start_timestamp = strtotime($schedule['ngay_hoc'] . ' ' . $schedule['gio_bat_dau']) * 1000;
                                $end_timestamp = strtotime($schedule['ngay_hoc'] . ' ' . $schedule['gio_ket_thuc']) * 1000;
                            ?>
                                <div class="schedule-list-item"
                                    id="schedule-<?php echo $schedule['id_lichhoc']; ?>"
                                    data-start-timestamp="<?php echo $start_timestamp; ?>"
                                    data-end-timestamp="<?php echo $end_timestamp; ?>">
                                    <div class="schedule-date">
                                        <span class="day"><?php echo date("d", strtotime($schedule['ngay_hoc'])); ?></span>
                                        <span class="month">Th <?php echo date("m", strtotime($schedule['ngay_hoc'])); ?></span>
                                    </div>
                                    <div class="schedule-details">
                                        <h6><?php echo htmlspecialchars($schedule['ten_lop']); ?></h6>
                                        <p><i class="fa-solid fa-clock"></i> <?php echo date("H:i", strtotime($schedule['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($schedule['gio_ket_thuc'])); ?></p>
                                        <p><i class="fa-solid fa-map-marker-alt"></i> <?php echo htmlspecialchars($schedule['phong_hoc']); ?></p>
                                        <?php if (!empty($schedule['ghi_chu'])): ?>
                                            <div class="schedule-note">
                                                <strong>Ghi chú:</strong>
                                                <div class="schedule-note-content">
                                                    <?php
                                                    // Tự động chuyển URL thành link nếu có
                                                    $note = htmlspecialchars($schedule['ghi_chu']);
                                                    $note = preg_replace(
                                                        '/(https?:\/\/[^\s]+)/',
                                                        '<a href="$1" target="_blank" title="Nhấn để mở link">$1</a>',
                                                        $note
                                                    );
                                                    echo $note;
                                                    ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-calendar-xmark"></i>
                            <p>Không có lịch dạy nào sắp tới.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="widget animated-component h-100" style="animation-delay: 600ms;">
                <div class="widget-header">
                    <h4><i class="fa-solid fa-list-check"></i>Truy cập nhanh lớp học</h4>
                    <a href="./admin.php?nav=teacher_classes" class="view-all-link">Xem tất cả</a>
                </div>
                <div class="widget-body">
                    <?php if ($my_classes->num_rows > 0): ?>
                        <div class="quick-access-grid">
                            <?php while ($class = $my_classes->fetch_assoc()): ?>
                                <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $class['id_lop']; ?>" class="text-decoration-none">
                                    <div class="class-shortcut-card">
                                        <div class="class-info">
                                            <h6><?php echo htmlspecialchars($class['ten_lop']); ?></h6>
                                            <p><?php echo htmlspecialchars($class['ten_khoahoc']); ?></p>
                                        </div>
                                        <div class="class-meta">
                                            <span class="badge bg-primary rounded-pill"><?php echo $class['so_luong_hoc_vien']; ?> học viên</span>
                                            <span class="btn btn-sm btn-manage">Quản lý <i class="fa-solid fa-arrow-right"></i></span>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-school-circle-xmark"></i>
                            <p>Bạn chưa được phân công lớp học nào.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Hiệu ứng đếm số ---
        const counters = document.querySelectorAll('.card-number');
        const speed = 200;

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    if (isNaN(target)) {
                        counter.innerText = counter.getAttribute('data-target');
                        return;
                    }

                    const animate = () => {
                        const count = +counter.innerText;
                        const increment = Math.ceil(target / speed);

                        if (count < target) {
                            counter.innerText = Math.min(count + increment, target);
                            setTimeout(animate, 10);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    animate();
                    observer.unobserve(counter);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(counter => {
            counter.innerText = '0';
            observer.observe(counter);
        });

        // --- Logic hiển thị ghi chú và ẩn lịch học ---
        function checkScheduleStatus() {
            const scheduleItems = document.querySelectorAll('.schedule-list-item');
            const now = new Date().getTime();
            const oneHourInMs = 60 * 60 * 1000; // 1 giờ = 3,600,000 milliseconds

            scheduleItems.forEach(item => {
                const startTime = parseInt(item.dataset.startTimestamp);
                const endTime = parseInt(item.dataset.endTimestamp);
                const note = item.querySelector('.schedule-note');

                const timeAfterEnd = now - endTime;

                if (note) {
                    // Thời gian bắt đầu hiển thị: trước 1 giờ
                    const showStartTime = startTime - oneHourInMs;
                    // Thời gian kết thúc hiển thị: sau 1 giờ kết thúc lớp
                    const showEndTime = endTime + oneHourInMs;

                    // Hiển thị ghi chú nếu thời gian hiện tại nằm trong khoảng
                    // từ [trước 1h bắt đầu] đến [sau 1h kết thúc]
                    if (now >= showStartTime && now <= showEndTime) {
                        note.classList.add('visible');
                    } else {
                        note.classList.remove('visible');
                    }
                }

                // Ẩn buổi học nếu đã kết thúc hơn 1 tiếng
                if (timeAfterEnd > oneHourInMs) {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 500);
                }
            });
        }

        // Chạy lần đầu khi tải trang và lặp lại mỗi 30 giây để cập nhật
        checkScheduleStatus();
        setInterval(checkScheduleStatus, 30000); // 30 giây
    });
</script>