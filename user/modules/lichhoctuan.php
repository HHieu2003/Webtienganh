<?php
// user/modules/lichhoctuan.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- XỬ LÝ NGÀY THÁNG VÀ ĐIỀU HƯỚNG TUẦN ---

// Lấy ngày được chọn từ URL, nếu không có thì lấy ngày hôm nay
$selected_date_str = $_GET['date'] ?? 'today';
$current_date = new DateTime($selected_date_str);

// Tính toán ngày đầu tuần (Thứ 2) và cuối tuần (Chủ Nhật)
$current_date->setISODate($current_date->format('Y'), $current_date->format('W'));
$start_of_week = $current_date->format('Y-m-d');
$start_of_week_dt = clone $current_date; // Sao chép để tính toán

$current_date->modify('+6 days');
$end_of_week = $current_date->format('Y-m-d');

// Tính toán ngày cho tuần trước và tuần sau
$prev_week_dt = (clone $start_of_week_dt)->modify('-1 week');
$next_week_dt = (clone $start_of_week_dt)->modify('+1 week');

// --- Lấy dữ liệu lịch học cho tuần đã chọn ---

$sql_schedule = "
    SELECT 
        lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc, lh.phong_hoc,
        l.ten_lop, kh.ten_khoahoc
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    JOIN khoahoc kh ON l.id_khoahoc = kh.id_khoahoc
    JOIN dangkykhoahoc dk ON l.id_lop = dk.id_lop
    WHERE dk.id_hocvien = ? AND lh.ngay_hoc BETWEEN ? AND ?
    ORDER BY lh.ngay_hoc, lh.gio_bat_dau ASC
";

$stmt = $conn->prepare($sql_schedule);
$stmt->bind_param('iss', $id_hocvien, $start_of_week, $end_of_week);
$stmt->execute();
$result = $stmt->get_result();

// Sắp xếp các buổi học vào mảng theo ngày trong tuần
$schedule_by_day = [
    'Monday' => [], 'Tuesday' => [], 'Wednesday' => [], 'Thursday' => [],
    'Friday' => [], 'Saturday' => [], 'Sunday' => []
];

while ($row = $result->fetch_assoc()) {
    $day_of_week = date('l', strtotime($row['ngay_hoc']));
    $schedule_by_day[$day_of_week][] = $row;
}
$stmt->close();
?>

<style>
    /* CSS cho bảng lịch học và các item (giữ nguyên) */
    .weekly-schedule-table { border-collapse: collapse; width: 100%; table-layout: fixed; }
    .weekly-schedule-table th, .weekly-schedule-table td { border: 1px solid #dee2e6; padding: 8px; text-align: left; vertical-align: top; }
    .weekly-schedule-table thead th { background-color: #f8f9fa; text-align: center; font-weight: 600; }
    .schedule-day { min-height: 150px; }
    .schedule-item { background-color: #e7f7ec; border-left: 4px solid #0db33b; padding: 10px; border-radius: 6px; margin-bottom: 10px; font-size: 14px; animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
    .schedule-item p { margin: 0 0 5px 0; }
    .schedule-item .time { font-weight: bold; color: #0a8a2c; }
    .schedule-item .course { font-style: italic; }
    .no-schedule { color: #6c757d; font-size: 14px; text-align: center; padding-top: 20px; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* CSS mới cho thanh điều hướng */
    .week-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }
    .week-navigation .nav-buttons a {
        padding: 8px 15px;
        border: 1px solid var(--border-color);
        background-color: #f8f9fa;
        color: var(--dark-text);
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .week-navigation .nav-buttons a:hover {
        background-color: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }
    .week-navigation .date-picker-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .week-navigation .form-control-sm {
        max-width: 150px;
    }
</style>

<div class="content-pane">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Lịch học tuần</h2>
        <h4><?php echo date("d/m/Y", strtotime($start_of_week)) . " - " . date("d/m/Y", strtotime($end_of_week)); ?></h4>
    </div>

    <div class="week-navigation">
        <div class="nav-buttons">
            <a href="?nav=lichhoctuan&date=<?php echo $prev_week_dt->format('Y-m-d'); ?>"><i class="fa-solid fa-chevron-left"></i> Tuần trước</a>
        </div>
        <div class="date-picker-group">
            <label for="date-picker" class="col-form-label text-nowrap">Chọn ngày:</label>
            <input type="date" class="form-control form-control-sm" id="date-picker" value="<?php echo $start_of_week_dt->format('Y-m-d'); ?>">
            <a href="?nav=lichhoctuan" class="btn btn-sm btn-outline-secondary text-nowrap">Hôm nay</a>
        </div>
        <div class="nav-buttons">
            <a href="?nav=lichhoctuan&date=<?php echo $next_week_dt->format('Y-m-d'); ?>">Tuần sau <i class="fa-solid fa-chevron-right"></i></a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="weekly-schedule-table">
            <thead>
                <tr>
                    <th>Thứ Hai</th><th>Thứ Ba</th><th>Thứ Tư</th><th>Thứ Năm</th><th>Thứ Sáu</th><th>Thứ Bảy</th><th>Chủ Nhật</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($schedule_by_day as $day => $schedules): ?>
                        <td>
                            <div class="schedule-day">
                                <?php if (!empty($schedules)): ?>
                                    <?php foreach ($schedules as $item): ?>
                                        <div class="schedule-item">
                                            <p class="time"><i class="fa-solid fa-clock"></i> <?php echo date("H:i", strtotime($item['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($item['gio_ket_thuc'])); ?></p>
                                            <p class="course"><i class="fa-solid fa-book"></i> <?php echo htmlspecialchars($item['ten_khoahoc']); ?></p>
                                            <p><i class="fa-solid fa-chalkboard-user"></i> Lớp: <?php echo htmlspecialchars($item['ten_lop']); ?></p>
                                            <p><i class="fa-solid fa-map-marker-alt"></i> Phòng: <?php echo htmlspecialchars($item['phong_hoc']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="no-schedule">-</div>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const datePicker = document.getElementById('date-picker');
    if(datePicker) {
        datePicker.addEventListener('change', function() {
            const selectedDate = this.value;
            if(selectedDate) {
                // Tự động chuyển đến trang lịch học tuần của ngày đã chọn
                window.location.href = `?nav=lichhoctuan&date=${selectedDate}`;
            }
        });
    }
});
</script>