<?php
// File: admin/modules/lichsuthanhtoan/view_receipt.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../../config/config.php');

if (!isset($_GET['id'])) {
    die("Không tìm thấy thông tin biên lai.");
}
$id_thanhtoan = (int)$_GET['id'];

$sql = "SELECT 
            lt.id_thanhtoan, lt.ngay_thanhtoan, lt.so_tien, lt.hinh_thuc,
            hv.id_hocvien, hv.ten_hocvien, hv.email, hv.so_dien_thoai,
            kh.ten_khoahoc
        FROM lichsu_thanhtoan lt
        JOIN hocvien hv ON lt.id_hocvien = hv.id_hocvien
        JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
        WHERE lt.id_thanhtoan = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_thanhtoan);
$stmt->execute();
$result = $stmt->get_result();
$receipt = $result->fetch_assoc();

if (!$receipt) {
    die("Biên lai không hợp lệ hoặc không tồn tại.");
}

// === PHẦN BẢO MẬT: Đảm bảo chỉ admin hoặc chủ biên lai được xem ===
$is_admin = $_SESSION['is_admin'] ?? false;
$current_user_id = $_SESSION['id_hocvien'] ?? 0; 
$is_owner = ($current_user_id == $receipt['id_hocvien']);

if (!$is_admin && !$is_owner) {
    die("Bạn không có quyền truy cập biên lai này.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Biên lai #<?php echo htmlspecialchars($receipt['id_thanhtoan']); ?> - Tiếng Anh Fighter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #0db33b;
            --light-gray-bg: #f8f9fa;
        }
        body { background-color: var(--light-gray-bg); font-family: Arial, sans-serif; }
        .receipt-wrapper { max-width: 800px; margin: 30px auto; }
        .receipt-actions { text-align: center; margin-bottom: 20px; }
        .receipt-container { background: #fff; border-radius: 8px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); padding: 40px; position: relative; }
        .receipt-header { border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .receipt-header img { max-height: 70px; }
        .receipt-title { font-size: 2.5rem; font-weight: bold; color: #ccc; position: absolute; top: 40px; right: 40px; letter-spacing: 2px; }
        .receipt-paid-stamp {
            position: absolute;
            top: 100px;
            right: 40px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            border: 3px solid var(--primary-color);
            padding: 10px 20px;
            border-radius: 8px;
            transform: rotate(-10deg);
            opacity: 0.8;
        }
        .info-section h5 { font-weight: 600; color: #555; margin-bottom: 15px; }
        .info-section p { margin-bottom: 5px; color: #666; }
        .receipt-table { margin-top: 30px; }
        .receipt-table th { background-color: var(--light-gray-bg); }
        .receipt-table .total-row td { font-size: 1.2rem; font-weight: bold; }
        .receipt-footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 0.9rem; color: #888; }
        
        @media print {
            body { background-color: #fff; }
            .receipt-wrapper { margin: 0; }
            .receipt-actions { display: none; }
            .receipt-container { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <div class="receipt-wrapper">
        <div class="receipt-actions">
            <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print me-2"></i> In hoặc Lưu PDF</button>
            <a href="../../admin.php?nav=thanhtoan" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Quay lại</a>
        </div>
        <div class="receipt-container">
            <div class="receipt-title">BIÊN LAI</div>
            <div class="receipt-header row align-items-center">
                <div class="col-6">
                    <img src="../../../images/logo2.jpg" alt="Logo Trung tâm">
                </div>
                <div class="col-6 text-end">
                    <h4 class="mb-1">Tiếng Anh Fighter!</h4>
                    <p class="text-muted small mb-0">Lê Văn Lương - Thanh Xuân - Hà Nội<br>Hotline: 0962.501.832</p>
                </div>
            </div>

            <div class="receipt-paid-stamp">
                <i class="fas fa-check-circle"></i> ĐÃ THANH TOÁN
            </div>

            <div class="row info-section">
                <div class="col-6">
                    <h5>BIÊN LAI CHO:</h5>
                    <p><strong><?php echo htmlspecialchars($receipt['ten_hocvien']); ?></strong></p>
                    <p><?php echo htmlspecialchars($receipt['email']); ?></p>
                    <p><?php echo htmlspecialchars($receipt['so_dien_thoai']); ?></p>
                </div>
                <div class="col-6 text-end">
                    <h5>THÔNG TIN GIAO DỊCH:</h5>
                    <p><strong>Mã biên lai:</strong> #<?php echo htmlspecialchars($receipt['id_thanhtoan']); ?></p>
                    <p><strong>Ngày thanh toán:</strong> <?php echo date("d/m/Y H:i", strtotime($receipt['ngay_thanhtoan'])); ?></p>
                    <p><strong>Hình thức:</strong> <?php echo htmlspecialchars($receipt['hinh_thuc']); ?></p>
                </div>
            </div>

            <div class="receipt-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mô tả</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Học phí khóa học "<?php echo htmlspecialchars($receipt['ten_khoahoc']); ?>"</td>
                            <td class="text-end"><?php echo number_format($receipt['so_tien'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                        <tr class="total-row">
                            <td class="text-end"><strong>TỔNG CỘNG</strong></td>
                            <td class="text-end text-success"><?php echo number_format($receipt['so_tien'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="receipt-footer">
                <p>Cảm ơn bạn đã tin tưởng và lựa chọn Tiếng Anh Fighter!</p>
            </div>
        </div>
    </div>
</body>
</html>