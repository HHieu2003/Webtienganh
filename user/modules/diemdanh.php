<?php
// user/modules/diemdanh.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];
$selected_lop_id = $_GET['lop_id'] ?? null;

// --- Lấy danh sách các lớp học mà học viên đang tham gia ---
$sql_classes = "
    SELECT 
        lh.id_lop, 
        lh.ten_lop, 
        kh.ten_khoahoc
    FROM dangkykhoahoc dk
    JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE 
        dk.id_hocvien = ? 
        AND dk.trang_thai = 'da xac nhan' 
        AND dk.id_lop IS NOT NULL
    ORDER BY kh.ten_khoahoc, lh.ten_lop
";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id_hocvien);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

// Lấy dữ liệu điểm danh nếu một lớp đã được chọn
$attendance_data = [];
if ($selected_lop_id) {
    // Lấy lịch học và trạng thái điểm danh cho lớp hiện tại, chỉ lấy các ngày từ hôm nay trở về trước
    $sql_attendance = "
        SELECT 
            lh.ngay_hoc,
            dd.trang_thai
        FROM lichhoc lh
        LEFT JOIN diem_danh dd ON lh.id_lichhoc = dd.id_lichhoc AND dd.id_hocvien = ?
        WHERE lh.id_lop = ? AND lh.ngay_hoc <= CURDATE()
        ORDER BY lh.ngay_hoc DESC
    ";
    $stmt_attendance = $conn->prepare($sql_attendance);
    $stmt_attendance->bind_param("is", $id_hocvien, $selected_lop_id);
    $stmt_attendance->execute();
    $attendance_data = $stmt_attendance->get_result();
}

// Hàm để tạo badge trạng thái điểm danh
function get_attendance_badge($status) {
    switch ($status) {
        case 'co mat':
            return '<span class="badge status-present"><i class="fa-solid fa-check-circle me-1"></i> Có mặt</span>';
        case 'vang':
            return '<span class="badge status-absent"><i class="fa-solid fa-times-circle me-1"></i> Vắng</span>';
        case 'muon':
            return '<span class="badge status-late"><i class="fa-solid fa-clock me-1"></i> Muộn</span>';
        default:
            return '<span class="badge status-none"><i class="fa-solid fa-question-circle me-1"></i> Chưa điểm danh</span>';
    }
}
?>

<style>
    /* CSS cho bố cục 2 cột */
    .attendance-container {
        display: flex;
        gap: 20px;
    }
    .class-list-sidebar {
        flex: 0 0 300px; /* Độ rộng cố định cho sidebar */
        border-right: 1px solid var(--border-color);
        padding-right: 20px;
    }
    .attendance-details {
        flex-grow: 1;
    }
    
    /* CSS cho danh sách lớp */
    .list-group-item {
        transition: all 0.2s ease;
    }

    /* CSS cho hiển thị điểm danh dạng timeline */
    .attendance-timeline {
        position: relative;
        padding-left: 20px;
        border-left: 3px solid #e9ecef;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 25px;
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .timeline-dot {
        position: absolute;
        left: -12.5px;
        top: 5px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: #fff;
        border: 3px solid var(--primary-color);
    }
    .timeline-content {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .timeline-date {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark-text);
    }
    
    /* CSS cho các badge trạng thái */
    .badge {
        font-size: 14px;
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 50px;
    }
    .status-present { background-color: #d1e7dd; color: #0f5132; }
    .status-absent { background-color: #f8d7da; color: #842029; }
    .status-late { background-color: #fff3cd; color: #664d03; }
    .status-none { background-color: #e2e3e5; color: #41464b; }
</style>

<div class="content-pane">
    <h2>Tình hình chuyên cần</h2>
    <div class="attendance-container mt-4">
        <div class="class-list-sidebar">
            <h5 class="mb-3">Chọn lớp học</h5>
            <?php if ($result_classes->num_rows > 0): ?>
                <div class="list-group">
                    <?php mysqli_data_seek($result_classes, 0); // Reset con trỏ
                          while($class = $result_classes->fetch_assoc()): ?>
                        <a href="./dashboard.php?nav=diemdanh&lop_id=<?php echo $class['id_lop']; ?>" 
                           class="list-group-item list-group-item-action <?php echo ($selected_lop_id == $class['id_lop']) ? 'active' : ''; ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?php echo htmlspecialchars($class['ten_lop']); ?></h6>
                            </div>
                            <small class="text-muted"><?php echo htmlspecialchars($class['ten_khoahoc']); ?></small>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-secondary">Bạn chưa được xếp vào lớp học nào.</div>
            <?php endif; ?>
        </div>

        <div class="attendance-details">
            <?php if ($selected_lop_id): ?>
                <h5 class="mb-3">Chi tiết điểm danh</h5>
                <?php if ($attendance_data->num_rows > 0): ?>
                    <div class="attendance-timeline">
                        <?php 
                        $att_index = 0;
                        while($att_row = $attendance_data->fetch_assoc()): ?>
                            <div class="timeline-item" style="animation-delay: <?php echo $att_index++ * 100; ?>ms;">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <span class="timeline-date">
                                        <i class="fa-solid fa-calendar-day me-2"></i><?php echo date("d/m/Y", strtotime($att_row['ngay_hoc'])); ?>
                                    </span>
                                    <?php echo get_attendance_badge($att_row['trang_thai']); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">Chưa có buổi học nào đã diễn ra cho lớp này.</div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-light text-center d-flex align-items-center justify-content-center h-100">
                    <p class="mb-0"><i class="fa-solid fa-arrow-left me-2"></i> Vui lòng chọn một lớp học để xem chi tiết điểm danh.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

