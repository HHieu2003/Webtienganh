<?php
// admin/modules/export_payments.php
include('../../../config/config.php');

// Đặt header để trình duyệt hiểu đây là một file Excel cần tải về
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=lich-su-thanh-toan.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Lấy toàn bộ lịch sử thanh toán
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
    ORDER BY lt.ngay_thanhtoan DESC
";
$result = $conn->query($sql_payments);

// Bắt đầu tạo nội dung cho file Excel
$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";
$output .= "<thead>
                <tr>
                    <th>ID Thanh toán</th>
                    <th>Tên học viên</th>
                    <th>Email</th>
                    <th>Tên khóa học</th>
                    <th>Số tiền (VNĐ)</th>
                    <th>Hình thức</th>
                    <th>Trạng thái</th>
                    <th>Ngày thanh toán</th>
                </tr>
            </thead>";
$output .= "<tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['id_thanhtoan']) . "</td>
                        <td>" . htmlspecialchars($row['ten_hocvien']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['ten_khoahoc']) . "</td>
                        <td>" . htmlspecialchars($row['so_tien']) . "</td>
                        <td>" . htmlspecialchars($row['hinh_thuc']) . "</td>
                        <td>" . htmlspecialchars($row['trang_thai']) . "</td>
                        <td>" . htmlspecialchars($row['ngay_thanhtoan']) . "</td>
                    </tr>";
    }
} else {
    $output .= "<tr><td colspan='8'>Không có dữ liệu.</td></tr>";
}

$output .= "</tbody></table></body></html>";

// Xuất nội dung ra file
echo $output;

$conn->close();
exit();
?>