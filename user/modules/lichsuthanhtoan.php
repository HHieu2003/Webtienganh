<?php
// Kết nối CSDL và Session đã được khởi tạo từ file dashboard.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để xem lịch sử thanh toán.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// Lấy lịch sử thanh toán của học viên
$sql_payments = "
    SELECT 
        lt.ngay_thanhtoan, 
        lt.so_tien, 
        lt.hinh_thuc, 
        lt.trang_thai, 
        kh.ten_khoahoc
    FROM lichsu_thanhtoan lt
    JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
    WHERE lt.id_hocvien = ?
    ORDER BY lt.ngay_thanhtoan DESC
";
$stmt = $conn->prepare($sql_payments);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

// Hàm để tạo badge trạng thái
function get_payment_status_badge($status) {
    switch (strtolower($status)) {
        case 'Đã chuyển':
        case 'thanh cong':
            return '<span class="badge bg-success-soft text-success">Thành công</span>';
        case 'dang cho':
            return '<span class="badge bg-warning-soft text-warning">Đang chờ</span>';
        default:
            return '<span class="badge bg-danger-soft text-danger">Thất bại</span>';
    }
}
?>

<div class="content-pane">
    <h2>Lịch Sử Giao Dịch</h2>

    <div class="payment-history-list">
        <?php if ($result->num_rows > 0): ?>
            <?php 
            $index = 0; // Biến đếm cho animation delay
            while ($row = $result->fetch_assoc()): 
            ?>
                <div class="payment-item" style="animation-delay: <?php echo $index * 100; ?>ms;">
                    <div class="payment-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div class="payment-details">
                        <div class="details-main">
                            <span class="course-name"><?php echo htmlspecialchars($row['ten_khoahoc']); ?></span>
                            <span class="amount"><?php echo number_format($row['so_tien'], 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        <div class="details-meta">
                            <span><i class="fa-solid fa-calendar-alt"></i> <?php echo date("H:i, d/m/Y", strtotime($row['ngay_thanhtoan'])); ?></span>
                            <span><i class="fa-solid fa-credit-card"></i> <?php echo htmlspecialchars($row['hinh_thuc']); ?></span>
                        </div>
                    </div>
                    <div class="payment-status">
                        <?php echo get_payment_status_badge($row['trang_thai']); ?>
                    </div>
                </div>
            <?php 
                $index++;
            endwhile; 
            ?>
        <?php else: ?>
            <div class="alert alert-info text-center">Bạn chưa có giao dịch thanh toán nào.</div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Keyframes cho hiệu ứng trượt lên và mờ dần */
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

    .payment-history-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .payment-item {
        display: flex;
        align-items: center;
        gap: 20px;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        
        /* Animation */
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .payment-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow);
    }
    .payment-icon {
        font-size: 24px;
        color: var(--primary-color);
    }
    .payment-details {
        flex-grow: 1;
    }
    .details-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .course-name {
        font-weight: 600;
        font-size: 16px;
    }
    .amount {
        font-weight: 700;
        font-size: 17px;
        color: var(--primary-color-dark);
    }
    .details-meta {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: var(--gray-text);
    }
    .details-meta i {
        margin-right: 5px;
    }
    .payment-status .badge {
        font-size: 13px;
        padding: 6px 10px;
        font-weight: 600;
    }
    /* Custom badge colors */
    .bg-success-soft { background-color: #d4edda; }
    .text-success { color: #155724 !important; }
    .bg-warning-soft { background-color: #fff3cd; }
    .text-warning { color: #856404 !important; }
    .bg-danger-soft { background-color: #f8d7da; }
    .text-danger { color: #721c24 !important; }
</style>