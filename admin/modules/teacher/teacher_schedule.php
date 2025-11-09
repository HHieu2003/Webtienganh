<?php
// File: admin/modules/teacher/teacher_schedule.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- XỬ LÝ NGÀY THÁNG VÀ ĐIỀU HƯỚNG TUẦN ---
$selected_date_str = $_GET['date'] ?? 'today';
try {
    $current_date = new DateTime($selected_date_str);
} catch (Exception $e) {
    $current_date = new DateTime('today');
}

$current_date->setISODate((int)$current_date->format('Y'), (int)$current_date->format('W'));
$start_of_week_dt = clone $current_date;

$end_of_week_dt = (clone $start_of_week_dt)->modify('+6 days');
$start_of_week_sql = $start_of_week_dt->format('Y-m-d');
$end_of_week_sql = $end_of_week_dt->format('Y-m-d');
$prev_week_dt = (clone $start_of_week_dt)->modify('-1 week');
$next_week_dt = (clone $start_of_week_dt)->modify('+1 week');

$days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$vietnamese_days = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];

// --- Lấy dữ liệu lịch dạy của giảng viên ---
$sql_schedule = "
    SELECT lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc, lh.phong_hoc, l.ten_lop, kh.ten_khoahoc
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    JOIN khoahoc kh ON l.id_khoahoc = kh.id_khoahoc
    WHERE l.id_giangvien = ? AND lh.ngay_hoc BETWEEN ? AND ?
    ORDER BY lh.ngay_hoc, lh.gio_bat_dau ASC
";

$stmt = $conn->prepare($sql_schedule);
$stmt->bind_param('iss', $id_giangvien, $start_of_week_sql, $end_of_week_sql);
$stmt->execute();
$result = $stmt->get_result();

$sessions = ['Sáng', 'Chiều', 'Tối'];
$schedule_matrix = array_fill_keys($sessions, array_fill_keys($days_of_week, []));

define('MORNING_END', '12:00:00');
define('AFTERNOON_END', '18:00:00');

while ($row = $result->fetch_assoc()) {
    $day_of_week = date('l', strtotime($row['ngay_hoc']));
    $start_time = $row['gio_bat_dau'];
    $session = '';
    if ($start_time < MORNING_END) {
        $session = 'Sáng';
    } elseif ($start_time < AFTERNOON_END) {
        $session = 'Chiều';
    } else {
        $session = 'Tối';
    }
    if ($session) {
        $schedule_matrix[$session][$day_of_week][] = $row;
    }
}
$stmt->close();
?>
<style>
    /* Container chính không bị tràn */
    .container-fluid {
        max-width: 100%;
        overflow-x: hidden;
        /* Ngăn tràn ngang */
    }

    /* Week navigation - không scroll */
    .week-navigation {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        max-width: 100%;
        /* Giới hạn chiều rộng */
    }

    /* Wrapper bảng - CHỈ PHẦN NÀY có scroll */
    .schedule-table-wrapper {
        background-color: #fff;
        padding: 10px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow-x: auto;
        /* Cho phép scroll ngang */
        overflow-y: visible;
        max-width: 100%;
        /* Giới hạn trong container */
        -webkit-overflow-scrolling: touch;
        /* Smooth scroll trên iOS */
    }

    /* Custom scrollbar cho bảng */
    .schedule-table-wrapper::-webkit-scrollbar {
        height: 10px;
    }

    .schedule-table-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .schedule-table-wrapper::-webkit-scrollbar-thumb {
        background: var(--brand-color);
        border-radius: 10px;
    }

    .schedule-table-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--brand-color-dark);
    }

    /* Bảng có chiều rộng cố định để scroll */
    .weekly-schedule-table {
        border-collapse: collapse;
        width: 100%;
        min-width: 950px;
        /* Đặt chiều rộng tối thiểu để bảng rộng hơn viewport */
        table-layout: fixed;
    }

    .weekly-schedule-table th,
    .weekly-schedule-table td {
        border: 1px solid var(--border-color);
        padding: 10px;
        vertical-align: top;
    }

    .weekly-schedule-table thead th {
        background-color: #f8f9fa;
        text-align: center;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }

    /* Cột Buổi cố định khi scroll ngang */
    .weekly-schedule-table .session-cell {
        text-align: center;
        vertical-align: middle;
        background-color: #f8f9fa;
        position: sticky;
        left: 0;
        z-index: 11;
        width: 66px;
        min-width: 60px;
        font-size: 12px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
    }

    .weekly-schedule-table thead .session-cell {
        z-index: 12;
        /* Header + sticky cần z-index cao hơn */
    }

    /* Các cột ngày trong tuần */
    .weekly-schedule-table th:not(.session-cell),
    .weekly-schedule-table td:not(.session-cell) {
        min-width: 180px;
        width: calc((100% - 100px) / 7);
        /* Chia đều 7 cột */
    }

    .schedule-item {
        background-color: var(--brand-color-light);
        border-left: 4px solid var(--brand-color);
        padding: 5px;
        border-radius: 6px;
        margin-bottom: 8px;
        font-size: 13px;
        animation: fadeInUp 0.5s;
        word-wrap: break-word;
    }

    .schedule-item p {
        margin: 0 0 5px 0;
        word-break: break-word;
    }

    .schedule-item .time {
        font-weight: bold;
        color: var(--brand-color-dark);
    }

    .no-schedule-dot {
        font-size: 24px;
        color: #ced4da;
    }

    /* Header section không scroll */
    .page-header {
        max-width: 100%;
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .week-navigation {
            flex-direction: column;
            gap: 15px;
        }

        .week-navigation>* {
            width: 100%;
            text-align: center;
        }

        .weekly-schedule-table {
            min-width: 900px;
            /* Giảm chiều rộng tối thiểu trên mobile */
        }

        .weekly-schedule-table th:not(.session-cell),
        .weekly-schedule-table td:not(.session-cell) {
            min-width: 150px;
        }

        .schedule-item {
            font-size: 12px;
            padding: 8px;
        }
    }

    @media (max-width: 767.98px) {
        .week-navigation {
            padding: 12px;
        }

        .schedule-table-wrapper {
            padding: 5px;
        }

        .weekly-schedule-table {
            min-width: 800px;
        }

        .weekly-schedule-table .session-cell {
            width: 60px;
            min-width: 60px;
            font-size: 11px;
        }

        .weekly-schedule-table th:not(.session-cell),
        .weekly-schedule-table td:not(.session-cell) {
            min-width: 130px;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header section - không scroll -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="title-color mb-0" style="border:none; padding-bottom: 0;">Lịch dạy theo tuần</h1>
        <h4 class="text-success fw-bold d-none d-md-block">
            <?php echo $start_of_week_dt->format("d/m") . " - " . $end_of_week_dt->format("d/m/Y"); ?>
        </h4>
    </div>

    <!-- Week navigation - không scroll -->
    <div class="week-navigation animated-card">
        <a href="?nav=teacher_schedule&date=<?php echo $prev_week_dt->format('Y-m-d'); ?>"
            class="btn btn-outline-secondary">
            <i class="fa-solid fa-chevron-left"></i> Tuần trước
        </a>
        <div class="d-flex align-items-center gap-2">
            <label for="date-picker" class="col-form-label text-nowrap">Chọn ngày:</label>
            <input type="date" class="form-control form-control-sm" id="date-picker"
                value="<?php echo $start_of_week_dt->format('Y-m-d'); ?>">
            <a href="?nav=teacher_schedule" class="btn btn-sm btn-primary text-nowrap">Hôm nay</a>
        </div>
        <a href="?nav=teacher_schedule&date=<?php echo $next_week_dt->format('Y-m-d'); ?>"
            class="btn btn-outline-secondary">
            Tuần sau <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>

    <!-- Bảng lịch học - CÓ SCROLL NGANG -->
    <div class="schedule-table-wrapper animated-card" style="animation-delay: 200ms;">
        <table class="weekly-schedule-table">
            <thead>
                <tr>
                    <th class="session-cell">Buổi</th>
                    <?php for ($i = 0; $i < 7; $i++):
                        $day_dt = (clone $start_of_week_dt)->modify("+$i days");
                    ?>
                        <th>
                            <?php echo $vietnamese_days[$i]; ?><br>
                            <small><?php echo $day_dt->format('d/m'); ?></small>
                        </th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $session): ?>
                    <tr>
                        <td class="session-cell"><strong><?php echo $session; ?></strong></td>
                        <?php foreach ($days_of_week as $day): ?>
                            <td>
                                <?php if (!empty($schedule_matrix[$session][$day])): ?>
                                    <?php foreach ($schedule_matrix[$session][$day] as $item): ?>
                                        <div class="schedule-item">
                                            <p class="time">
                                                <i class="fa-solid fa-clock"></i>
                                                <?php echo date("H:i", strtotime($item['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($item['gio_ket_thuc'])); ?>
                                            </p>
                                            <p>
                                                <i class="fa-solid fa-book-open"></i>
                                                <?php echo htmlspecialchars($item['ten_khoahoc']); ?>
                                            </p>
                                            <p>
                                                <i class="fa-solid fa-school"></i>
                                                <strong><?php echo htmlspecialchars($item['ten_lop']); ?></strong>
                                            </p>
                                            <p>
                                                <i class="fa-solid fa-map-marker-alt"></i>
                                                <?php echo htmlspecialchars($item['phong_hoc']); ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <span class="no-schedule-dot">&middot;</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('date-picker').addEventListener('change', function() {
        if (this.value) {
            window.location.href = `?nav=teacher_schedule&date=${this.value}`;
        }
    });
</script>