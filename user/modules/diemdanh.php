<?php
// user/modules/diemdanh.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];

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
$classes = $result_classes->fetch_all(MYSQLI_ASSOC);
$stmt_classes->close();


// Hàm để tạo badge trạng thái điểm danh
function get_attendance_badge_details($status) {
    switch ($status) {
        case 'co mat':
            return '<span class="badge status-badge status-present"><i class="fa-solid fa-check-circle me-1"></i> Có mặt</span>';
        case 'vang':
            return '<span class="badge status-badge status-absent"><i class="fa-solid fa-times-circle me-1"></i> Vắng</span>';
        case 'muon':
            return '<span class="badge status-badge status-late"><i class="fa-solid fa-clock me-1"></i> Muộn</span>';
        default:
            return '<span class="badge status-badge status-none"><i class="fa-solid fa-question-circle me-1"></i> Chưa điểm danh</span>';
    }
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .attendance-card {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 25px;
        border: 1px solid var(--border-color);
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
        overflow: hidden; /* Quan trọng cho accordion */
    }
    .card-main-info {
        padding: 25px;
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .attendance-chart {
        flex-shrink: 0;
        position: relative;
        width: 100px;
        height: 100px;
    }
    .attendance-chart .percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-color-dark);
    }
    .attendance-details {
        flex-grow: 1;
    }
    .attendance-details h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 5px 0;
    }
    .attendance-details p {
        margin: 0;
        color: var(--gray-text);
    }
    .attendance-stats {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        font-size: 14px;
    }
    .attendance-stats span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .attendance-stats i {
        color: var(--gray-text);
    }
    .card-toggle-footer {
        background-color: #f8f9fa;
        padding: 10px 25px;
        text-align: center;
        border-top: 1px solid var(--border-color);
    }
    .card-toggle-footer .btn-toggle-details {
        font-weight: 500;
        color: var(--primary-color);
        background: none;
        border: none;
        cursor: pointer;
    }
    .card-toggle-footer .btn-toggle-details i {
        transition: transform 0.3s ease;
    }
    .card-toggle-footer .btn-toggle-details:not(.collapsed) i {
        transform: rotate(180deg);
    }

    /* Chi tiết điểm danh bên trong accordion */
    .attendance-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .attendance-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
    }
    .attendance-list-item:not(:last-child) {
        border-bottom: 1px solid var(--border-color);
    }
    .status-badge {
        font-size: 13px; padding: 6px 12px; font-weight: 600; border-radius: 50px;
    }
    .status-present { background-color: #d1e7dd; color: #0f5132; }
    .status-absent { background-color: #f8d7da; color: #842029; }
    .status-late { background-color: #fff3cd; color: #664d03; }
    .status-none { background-color: #e2e3e5; color: #41464b; }
</style>
<div class="content-pane">
    <h2 class="mb-4">Tình hình chuyên cần</h2>

    <?php if (!empty($classes)): ?>
        <div class="accordion" id="attendanceAccordion">
            <?php 
            $index = 0;
            foreach ($classes as $class):
                $id_lop = $class['id_lop'];
                
                // Lấy dữ liệu điểm danh cho từng lớp
                $sql_attendance = "
                    SELECT lh.ngay_hoc, dd.trang_thai
                    FROM lichhoc lh
                    LEFT JOIN diem_danh dd ON lh.id_lichhoc = dd.id_lichhoc AND dd.id_hocvien = ?
                    WHERE lh.id_lop = ? AND lh.ngay_hoc <= CURDATE()
                    ORDER BY lh.ngay_hoc DESC
                ";
                $stmt_attendance = $conn->prepare($sql_attendance);
                $stmt_attendance->bind_param("is", $id_hocvien, $id_lop);
                $stmt_attendance->execute();
                $attendance_data = $stmt_attendance->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt_attendance->close();

                // Tính toán thống kê
                $total_sessions = count($attendance_data);
                $present_count = 0;
                $absent_count = 0;
                $late_count = 0;
                foreach($attendance_data as $att) {
                    if ($att['trang_thai'] === 'co mat') $present_count++;
                    elseif ($att['trang_thai'] === 'vang') $absent_count++;
                    elseif ($att['trang_thai'] === 'muon') $late_count++;
                }
                $attendance_rate = ($total_sessions > 0) ? round(($present_count / $total_sessions) * 100) : 0;
            ?>
            <div class="attendance-card" style="animation-delay: <?php echo $index * 100; ?>ms;">
                <div class="card-main-info">
                    <div class="attendance-chart">
                        <canvas id="chart-<?php echo $id_lop; ?>"></canvas>
                        <div class="percentage" data-rate="<?php echo $attendance_rate; ?>">0%</div>
                    </div>
                    <div class="attendance-details">
                        <h5><?php echo htmlspecialchars($class['ten_lop']); ?></h5>
                        <p><?php echo htmlspecialchars($class['ten_khoahoc']); ?></p>
                        <div class="attendance-stats">
                            <span><i class="fa-solid fa-check text-success"></i> <?php echo $present_count; ?></span>
                            <span><i class="fa-solid fa-times text-danger"></i> <?php echo $absent_count; ?></span>
                            <span><i class="fa-solid fa-clock text-warning"></i> <?php echo $late_count; ?></span>
                        </div>
                    </div>
                </div>
                <?php if ($total_sessions > 0): ?>
                <div class="card-toggle-footer">
                    <button class="btn-toggle-details collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id_lop; ?>">
                        Xem chi tiết <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div id="collapse-<?php echo $id_lop; ?>" class="accordion-collapse collapse" data-bs-parent="#attendanceAccordion">
                    <ul class="attendance-list">
                        <?php foreach($attendance_data as $att_row): ?>
                        <li class="attendance-list-item">
                            <span><i class="fa-solid fa-calendar-day me-2 text-muted"></i><?php echo date("d/m/Y", strtotime($att_row['ngay_hoc'])); ?></span>
                            <?php echo get_attendance_badge_details($att_row['trang_thai']); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <?php 
            $index++;
            endforeach; 
            ?>
        </div>
    <?php else: ?>
        <div class="alert alert-light text-center mt-4">
            <i class="fa-solid fa-school-circle-xmark fa-3x mb-3 text-muted"></i>
            <p class="mb-0">Bạn chưa được xếp vào lớp học nào để xem điểm danh.</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const charts = document.querySelectorAll('.attendance-chart canvas');

    charts.forEach(chartCanvas => {
        const percentageEl = chartCanvas.nextElementSibling;
        const rate = parseFloat(percentageEl.getAttribute('data-rate'));
        const ctx = chartCanvas.getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [rate, 100 - rate],
                    backgroundColor: ['#0db33b', '#e9ecef'],
                    borderColor: '#fff',
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true,
                cutout: '80%',
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                animation: { animateRotate: true, animateScale: true }
            }
        });
        
        // Hiệu ứng số đếm
        let currentPercentage = 0;
        const counter = setInterval(() => {
            if (currentPercentage >= rate) {
                currentPercentage = rate;
                clearInterval(counter);
            }
            percentageEl.textContent = Math.round(currentPercentage) + '%';
            currentPercentage++;
        }, 15);
    });
});
</script>