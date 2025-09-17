<?php
// admin/modules/giangvien/export_lecturers.php
include('../../../config/config.php');

// Đặt header để trình duyệt hiểu đây là một file Excel cần tải về
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=danh-sach-giang-vien.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Lấy toàn bộ dữ liệu giảng viên
$sql = "SELECT id_giangvien, ten_giangvien, email, so_dien_thoai, mo_ta FROM giangvien ORDER BY id_giangvien ASC";
$result = $conn->query($sql);

// Bắt đầu tạo nội dung cho file Excel (dưới dạng bảng HTML)
// Thêm a <meta> tag to ensure UTF-8 encoding is respected in Excel
$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";
$output .= "<thead>
                <tr>
                    <th>ID</th>
                    <th>Tên giảng viên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Mô tả</th>
                </tr>
            </thead>";
$output .= "<tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['id_giangvien']) . "</td>
                        <td>" . htmlspecialchars($row['ten_giangvien']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>'" . htmlspecialchars($row['so_dien_thoai']) . "</td>
                        <td>" . htmlspecialchars($row['mo_ta']) . "</td>
                    </tr>";
    }
} else {
    $output .= "<tr><td colspan='5'>Không có dữ liệu.</td></tr>";
}

$output .= "</tbody></table></body></html>";

// Xuất nội dung ra file
echo $output;

$conn->close();
exit();
?>