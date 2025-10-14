<?php
// user/modules/lichhoc.php

if (!isset($_GET['id_khoahoc'])) {
    die("Không tìm thấy thông tin khóa học.");
}
$id_khoahoc = (int)$_GET['id_khoahoc'];
$id_hocvien = $_SESSION['id_hocvien'];

// Lấy thông tin khóa học để hiển thị tên
$sql_course = "SELECT ten_khoahoc FROM khoahoc WHERE id_khoahoc = ?";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("i", $id_khoahoc);
$stmt_course->execute();
$result_course = $stmt_course->get_result();
if ($row_course = $result_course->fetch_assoc()) {
    $ten_khoahoc = $row_course['ten_khoahoc'];
} else {
    die("Khóa học không tồn tại.");
}
$stmt_course->close();

// Lấy thông tin lịch học của khóa học mà học viên này đã được xếp lớp
$sql_schedule = "
    SELECT 
        lh.ngay_hoc, 
        lh.gio_bat_dau, 
        lh.gio_ket_thuc, 
        lh.phong_hoc, 
        lh.ghi_chu, 
        l.ten_lop
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    JOIN dangkykhoahoc dk ON l.id_lop = dk.id_lop
    WHERE dk.id_hocvien = ? AND dk.id_khoahoc = ? AND l.trang_thai = 'dang hoc'
    ORDER BY lh.ngay_hoc ASC, lh.gio_bat_dau ASC
";
$stmt = $conn->prepare($sql_schedule);
$stmt->bind_param('ii', $id_hocvien, $id_khoahoc);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content-pane">
    <h2 class="mb-4">Lịch học chi tiết: <?php echo htmlspecialchars($ten_khoahoc); ?></h2>

    <div class="schedule-timeline">
        <?php if ($result->num_rows > 0): ?>
            <?php
            $index = 0; // Biến cho animation delay
            while ($row = $result->fetch_assoc()):
            ?>
                <div class="timeline-item" style="animation-delay: <?php echo $index * 100; ?>ms;">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="date"><i class="fa-solid fa-calendar-day"></i> <?php echo date("d/m/Y", strtotime($row['ngay_hoc'])); ?></span>
                            <span class="time"><i class="fa-solid fa-clock"></i> <?php echo date("H:i", strtotime($row['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($row['gio_ket_thuc'])); ?></span>
                        </div>
                        <div class="timeline-body">
                            <p><strong>Lớp:</strong> <?php echo htmlspecialchars($row['ten_lop']); ?></p>
                            <p><strong>Phòng học:</strong> <?php echo htmlspecialchars($row['phong_hoc']); ?></p>

                            <?php if (!empty($row['ghi_chu'])): ?>
                                <div class="note-container"
                                    data-date="<?php echo $row['ngay_hoc']; ?>"
                                    data-start="<?php echo $row['gio_bat_dau']; ?>"
                                    data-end="<?php echo $row['gio_ket_thuc']; ?>"
                                    style="display: none;">
                                    <p class="note"><strong>Ghi chú:</strong> <a href="<?php echo htmlspecialchars($row['ghi_chu']); ?>"><?php echo htmlspecialchars($row['ghi_chu']); ?> </a> </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
                $index++;
            endwhile;
            ?>
        <?php else: ?>
            <div class="alert alert-info text-center">Lớp học của bạn cho khóa này chưa có lịch học. Vui lòng quay lại sau.</div>
        <?php endif; ?>
    </div>
</div>

<style>
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .schedule-timeline {
        position: relative;
        padding-left: 30px;
        border-left: 3px solid #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
        opacity: 0;
        animation: slideInLeft 0.6s ease-out forwards;
    }

    .timeline-dot {
        position: absolute;
        left: -18px;
        top: 5px;
        width: 18px;
        height: 18px;
        background-color: var(--primary-color);
        border: 4px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 3px #e9ecef;
    }

    .timeline-content {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: var(--border-radius);
        border: 1px solid #e9ecef;
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ced4da;
    }

    .timeline-header .date {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-color-dark);
    }

    .timeline-header .time {
        font-size: 15px;
        color: var(--dark-text);
    }

    .timeline-body p {
        margin-bottom: 8px;
        font-size: 15px;
        color: var(--gray-text);
    }

    .timeline-body p.note {
        font-style: italic;
        background-color: #fff3cd;
        color: #664d03;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 3px solid #ffc107;
    }

    .timeline-body i {
        margin-right: 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const noteContainers = document.querySelectorAll('.note-container');

        function checkNotesVisibility() {
            const now = new Date();

            noteContainers.forEach(container => {
                const date = container.dataset.date;
                const startTimeStr = container.dataset.start;
                const endTimeStr = container.dataset.end;

                // Tạo đối tượng Date từ chuỗi ngày và giờ
                const startDateTime = new Date(`${date}T${startTimeStr}`);
                const endDateTime = new Date(`${date}T${endTimeStr}`);

                // So sánh thời gian hiện tại với thời gian bắt đầu và kết thúc
                if (now >= startDateTime && now <= endDateTime) {
                    container.style.display = 'block'; // Hiển thị ghi chú
                } else {
                    container.style.display = 'none'; // Ẩn ghi chú
                }
            });
        }

        // Chạy hàm kiểm tra ngay khi tải trang
        checkNotesVisibility();
        // Lặp lại việc kiểm tra mỗi 30 giây
        setInterval(checkNotesVisibility, 30000);
    });
</script>