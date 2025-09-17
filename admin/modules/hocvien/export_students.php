<?php
// admin/modules/hocvien/export_students.php
include('../../../config/config.php');

// Đặt header để trình duyệt hiểu đây là một file Excel cần tải về
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=danh-sach-hoc-vien.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Lấy toàn bộ dữ liệu học viên
$sql = "SELECT id_hocvien, ten_hocvien, email, so_dien_thoai, is_admin FROM hocvien ORDER BY id_hocvien ASC";
$result = $conn->query($sql);

// Bắt đầu tạo nội dung cho file Excel (dưới dạng bảng HTML)
$output = "<table border='1'>";
$output .= "<thead>
                <tr>
                    <th>ID</th>
                    <th>Tên học viên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Là Admin</th>
                </tr>
            </thead>";
$output .= "<tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $isAdmin = $row['is_admin'] ? 'Có' : 'Không';
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['id_hocvien']) . "</td>
                        <td>" . htmlspecialchars($row['ten_hocvien']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>'" . htmlspecialchars($row['so_dien_thoai']) . "</td>
                        <td>" . $isAdmin . "</td>
                    </tr>";
    }
} else {
    $output .= "<tr><td colspan='5'>Không có dữ liệu.</td></tr>";
}

$output .= "</tbody></table>";

// Xuất nội dung ra file
echo $output;

$conn->close();
exit();
?>