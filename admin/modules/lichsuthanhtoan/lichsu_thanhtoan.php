<?php
// Kết nối CSDL đã được include từ admin.php
// include('../config/config.php');

// Xử lý tìm kiếm
$search_term = $_GET['search'] ?? '';
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    $search_param = "%" . $conn->real_escape_string($search_term) . "%";
    // Tìm kiếm trên nhiều cột
    $sql_search = " WHERE hv.ten_hocvien LIKE ? OR hv.email LIKE ? OR kh.ten_khoahoc LIKE ?";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

// Truy vấn lấy toàn bộ lịch sử thanh toán, JOIN với bảng hocvien và khoahoc
$sql_payments = "
    SELECT 
        lt.id_thanhtoan, 
        lt.ngay_thanhtoan, 
        lt.so_tien, 
        lt.hinh_thuc, 
        lt.trang_thai, 
        kh.ten_khoahoc,
        hv.ten_hocvien,
        hv.email
    FROM lichsu_thanhtoan lt
    JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
    JOIN hocvien hv ON lt.id_hocvien = hv.id_hocvien
    $sql_search
    ORDER BY lt.ngay_thanhtoan DESC
";

$stmt = $conn->prepare($sql_payments);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result_payments = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fa-solid fa-money-check-dollar me-2"></i>Lịch sử thanh toán
            </h4>
            <div class="d-flex">
                <form method="GET" action="./admin.php" class="d-flex me-2">
                    <input type="hidden" name="nav" value="thanhtoan">
                    <input type="text" name="search" class="form-control" placeholder="Tìm theo tên HV, email, khóa học..." value="<?php echo htmlspecialchars($search_term); ?>" style="min-width: 300px;">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                
                <a href="modules/export_payments.php" class="btn btn-info text-white">
                    <i class="fa-solid fa-file-excel"></i> Xuất Excel
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Học viên</th>
                        <th>Khóa học</th>
                        <th class="text-center">Số tiền (VNĐ)</th>
                        <th class="text-center">Hình thức</th>
                        <th class="text-center">Ngày thanh toán</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    if ($result_payments->num_rows > 0):
                        while ($row = $result_payments->fetch_assoc()): 
                    ?>
                        <tr class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                            <td><?php echo $row['id_thanhtoan']; ?></td>
                            <td>
                                <strong class="d-block"><?php echo htmlspecialchars($row['ten_hocvien']); ?></strong>
                                <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                            <td class="text-center fw-bold text-success"><?php echo number_format($row['so_tien'], 0, ',', '.'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['hinh_thuc']); ?></td>
                            <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_thanhtoan'])); ?></td>
                            <td class="text-center">
                                <form method="POST" action="modules/lichsuthanhtoan/delete_thanhtoan.php" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giao dịch này?');">
                                    <input type="hidden" name="id_thanhtoan" value="<?php echo $row['id_thanhtoan']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                        $index++;
                        endwhile; 
                    else:
                    ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Không tìm thấy giao dịch nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>