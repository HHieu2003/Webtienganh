<?php
// user/modules/lichhoctuan.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- XỬ LÝ NGÀY THÁNG VÀ ĐIỀU HƯỚNG TUẦN ---
$selected_date_str = $_GET['date'] ?? 'today';
try {
    $current_date = new DateTime($selected_date_str);
} catch (Exception $e) {
    $current_date = new DateTime('today');
}

// Tính toán ngày đầu tuần (Thứ 2)
$current_date->setISODate((int)$current_date->format('Y'), (int)$current_date->format('W'));
$start_of_week_dt = clone $current_date;

// Tính toán các ngày khác trong tuần
$end_of_week_dt = (clone $start_of_week_dt)->modify('+6 days');
$start_of_week_sql = $start_of_week_dt->format('Y-m-d');
$end_of_week_sql = $end_of_week_dt->format('Y-m-d');
$prev_week_dt = (clone $start_of_week_dt)->modify('-1 week');
$next_week_dt = (clone $start_of_week_dt)->modify('+1 week');

$days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$vietnamese_days = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];


// --- Lấy dữ liệu và xử lý thành ma trận [Buổi][Ngày] ---
// THÊM: Lấy cả `ghi_chu`
$sql_schedule = "
    SELECT lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc, lh.phong_hoc, l.ten_lop, kh.ten_khoahoc, lh.ghi_chu
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    JOIN khoahoc kh ON l.id_khoahoc = kh.id_khoahoc
    JOIN dangkykhoahoc dk ON l.id_lop = dk.id_lop
    WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan' AND lh.ngay_hoc BETWEEN ? AND ?
    ORDER BY lh.ngay_hoc, lh.gio_bat_dau ASC
";

$stmt = $conn->prepare($sql_schedule);
$stmt->bind_param('iss', $id_hocvien, $start_of_week_sql, $end_of_week_sql);
$stmt->execute();
$result = $stmt->get_result();

// Khởi tạo ma trận lịch học
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
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated-component {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .week-navigation {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 15px;
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .week-navigation a {
        text-decoration: none;
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

    .schedule-table-wrapper {
        background-color: #fff;
        padding: 10px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow-x: auto;
        /* KÍCH HOẠT THANH CUỘN NGANG */
    }

    .weekly-schedule-table {
        border-collapse: collapse;
        width: 100%;
        min-width: 900px;
        /* Chiều rộng tối thiểu để bảng không bị co lại */
        
    }
.weekly-schedule-table {
    table-layout: fixed;
    width: 100%;
}

/* Tùy chỉnh chiều rộng từng cột */
.weekly-schedule-table thead th:nth-child(2) { width: 170px; } /* Thứ Ba */
.weekly-schedule-table thead th:nth-child(3) { width: 170px; } /* Thứ Tư */
.weekly-schedule-table thead th:nth-child(4) { width: 170px; } /* Thứ Năm */
.weekly-schedule-table thead th:nth-child(5) { width: 170px; } /* Thứ Sáu */
.weekly-schedule-table thead th:nth-child(6) { width: 170px; } /* Thứ Bảy */
.weekly-schedule-table thead th:nth-child(7) { width: 170px; } /* Chủ Nhật */
.weekly-schedule-table thead th:nth-child(8) { width: 170px; } /* Chủ Nhật */


/* Áp dụng cho td tương ứng */
.weekly-schedule-table tbody td:nth-child(2) { width: 170px; }
.weekly-schedule-table tbody td:nth-child(3) { width: 170px; }
.weekly-schedule-table tbody td:nth-child(4) { width: 170px; }
.weekly-schedule-table tbody td:nth-child(5) { width: 170px; }
.weekly-schedule-table tbody td:nth-child(6) { width: 170px; }
.weekly-schedule-table tbody td:nth-child(7) { width: 170px; }
.weekly-schedule-table thead th:nth-child(8) { width: 170px; } /* Chủ Nhật */


    .weekly-schedule-table th,
    .weekly-schedule-table td {
        border: 1px solid var(--border-color);
        padding: 8px;
        vertical-align: top;
        /* min-width: 160px;
        max-width: 170px; */
    }

    .weekly-schedule-table thead th {
        background-color: #f8f9fa;
        text-align: center;
        font-weight: 600;
        position: sticky;
        top: -1px;
        z-index: 2;
    }

    
    .weekly-schedule-table tbody .session-cell {
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        background-color: #f8f9fa;
        /* min-width: 100px; */
        left: 0;
        z-index: 1;
    }

    /* Thẻ hiển thị buổi học */
    .schedule-item {
        background-color: #e7f7ec;
        border-left: 4px solid var(--primary-color);
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .schedule-item p {
        margin: 0 0 5px 0;
    }

    .schedule-item .time {
        font-weight: bold;
        color: var(--primary-color-dark);
    }

    .schedule-item .course {
        font-style: italic;
    }

    /* THÊM: CSS CHO GHI CHÚ */
    .schedule-item .note {
        font-style: italic;
        background-color: #fff3cd;
        color: #664d03;
        padding: 5px 5px;
        border-radius: 6px;
        border-left: 3px solid #ffc107;
        margin-top: 8px;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Giới hạn 2 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.5;
        /* Điều chỉnh khoảng cách dòng */
        max-width: 100%;
        /* Đảm bảo không vượt quá container */
        word-wrap: break-word;
        /* Ngắt từ khi quá dài */
    }

    .no-schedule {
        text-align: center;
        padding-top: 20px;
    }

    .no-schedule-dot {
        font-size: 24px;
        color: #ced4da;
    }

    @media (max-width: 767px) {
        .week-navigation {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
<div class="content-pane">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Lịch học tuần</h2>
        <h2 class="d-none d-md-block content-date-now"><?php echo $start_of_week_dt->format("d/m") . " - " . $end_of_week_dt->format("d/m/Y"); ?></h2>
    </div>

    <div class="week-navigation animated-component">
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

    <div class="table-responsive schedule-table-wrapper animated-component" style="animation-delay: 200ms;">
        <table class="weekly-schedule-table">
            <thead>
                <tr>
                    <th class="session-cell" style="z-index: 3; width: 55px">Buổi</th>
                    <?php for ($i = 0; $i < 7; $i++):
                        $day_dt = (clone $start_of_week_dt)->modify("+$i days");
                    ?>
                        <th style="min-width: 160px;"><?php echo $vietnamese_days[$i]; ?><br><small><?php echo $day_dt->format('d/m'); ?></small></th>
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
                                            <p class="time"><i class="fa-solid fa-clock"></i> <?php echo date("H:i", strtotime($item['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($item['gio_ket_thuc'])); ?></p>
                                            <p class="course"><i class="fa-solid fa-book"></i> <?php echo htmlspecialchars($item['ten_khoahoc']); ?></p>
                                            <p><i class="fa-solid fa-chalkboard-user"></i> Lớp: <?php echo htmlspecialchars($item['ten_lop']); ?></p>
                                            <p><i class="fa-solid fa-map-marker-alt"></i> Phòng: <?php echo htmlspecialchars($item['phong_hoc']); ?></p>

                                            <?php if (!empty($item['ghi_chu'])): ?>
                                                <div class="note-container"
                                                    data-date="<?php echo $item['ngay_hoc']; ?>"
                                                    data-start="<?php echo $item['gio_bat_dau']; ?>"
                                                    data-end="<?php echo $item['gio_ket_thuc']; ?>"
                                                    style="display: none;">
                                                    <div class="note">
                                                        <strong> Ghi chú:</strong>
                                                        <div class="note-content">
                                                            <?php
                                                            $note = htmlspecialchars($item['ghi_chu']);

                                                            // Kiểm tra xem ghi chú có phải URL không
                                                            if (filter_var($note, FILTER_VALIDATE_URL)) {
                                                                // Nếu là URL hợp lệ, tạo link rút gọn
                                                                $parsedUrl = parse_url($note);
                                                                $displayUrl = $parsedUrl['host'] . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '');

                                                                // Cắt ngắn URL nếu quá dài
                                                                if (strlen($displayUrl) > 50) {
                                                                    $displayUrl = substr($displayUrl, 0, 47) . '...';
                                                                }

                                                                echo '<a href="' . $note . '" target="_blank" rel="noopener noreferrer" class="note-link" title="' . $note . '">';
                                                                echo ' ' . $displayUrl;
                                                                echo '</a>';
                                                            } else {
                                                                // Nếu không phải URL, tìm và chuyển đổi các URL có trong text
                                                                $pattern = '/(https?:\/\/[^\s<>"]+)/i';
                                                                $noteWithLinks = preg_replace_callback($pattern, function ($matches) {
                                                                    $url = $matches[1];
                                                                    $parsedUrl = parse_url($url);
                                                                    $displayUrl = $parsedUrl['host'] . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '');

                                                                    if (strlen($displayUrl) > 50) {
                                                                        $displayUrl = substr($displayUrl, 0, 47) . '...';
                                                                    }

                                                                    return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer" class="note-link" title="' . $url . '">'
                                                                        . ' ' . $displayUrl . '</a>';
                                                                }, $note);

                                                                echo $noteWithLinks;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="no-schedule"><span class="no-schedule-dot">&middot;</span></div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý chọn ngày
        const datePicker = document.getElementById('date-picker');
        if (datePicker) {
            datePicker.addEventListener('change', function() {
                const selectedDate = this.value;
                if (selectedDate) {
                    window.location.href = `?nav=lichhoctuan&date=${selectedDate}`;
                }
            });
        }

        // Xử lý hiển thị ghi chú động
        const noteContainers = document.querySelectorAll('.note-container');

        function checkNotesVisibility() {
            const now = new Date();
            noteContainers.forEach(container => {
                const date = container.dataset.date;
                const startTimeStr = container.dataset.start;
                const endTimeStr = container.dataset.end;

                const startDateTime = new Date(`${date}T${startTimeStr}`);
                const endDateTime = new Date(`${date}T${endTimeStr}`);

                // Tính thời gian trước 1 tiếng (60 phút) và sau 1 tiếng (60 phút)
                const oneHourInMs = 60 * 60 * 1000; // 1 giờ = 60 phút * 60 giây * 1000 ms
                const showStartTime = new Date(startDateTime.getTime() - oneHourInMs); // Trước 1 giờ
                const showEndTime = new Date(endDateTime.getTime() + oneHourInMs); // Sau 1 giờ

                // Hiển thị nếu thời gian hiện tại nằm trong khoảng [trước 1h -> sau 1h]
                if (now >= showStartTime && now <= showEndTime) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        }

        checkNotesVisibility();
        setInterval(checkNotesVisibility, 30000); // Kiểm tra lại mỗi 30 giây
    });
</script>