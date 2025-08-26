<?php
include('../config/config.php');

if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để xem lịch sử thanh toán.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// Lấy lịch sử thanh toán của học viên
$sql_payments = "
    SELECT lt.ngay_thanhtoan, lt.so_tien, lt.hinh_thuc, lt.trang_thai, kh.ten_khoahoc
    FROM lichsu_thanhtoan lt
    JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
    WHERE lt.id_hocvien = ?
    ORDER BY lt.ngay_thanhtoan DESC
";
$stmt = $conn->prepare($sql_payments);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Thanh Toán</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center text-primary introduce-title">Lịch Sử Thanh Toán</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Ngày Thanh Toán</th>
                    <th>Số Tiền (VND)</th>
                    <th>Hình Thức</th>
                    <!-- <th>Trạng Thái</th> -->
                    <th>Khóa Học</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ngay_thanhtoan']) ?></td>
                        <td><?= number_format($row['so_tien'], 0, ',', '.') ?> VND</td>
                        <td><?= htmlspecialchars($row['hinh_thuc']) ?></td>
                        <!-- <td> -->
                            <!-- <?php if ($row['trang_thai'] === 'thanh cong'): ?>
                                <span class="badge bg-success">Thành Công</span>
                            <?php elseif ($row['trang_thai'] === 'dang cho'): ?>
                                <span class="badge bg-warning">Đang Chờ</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Thất Bại</span>
                            <?php endif; ?> -->
                        <!-- </td> -->
                        <td><?= htmlspecialchars($row['ten_khoahoc']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">Bạn chưa có giao dịch thanh toán nào.</div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
