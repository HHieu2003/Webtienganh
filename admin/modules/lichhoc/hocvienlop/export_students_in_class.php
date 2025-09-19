<?php
// File: admin/modules/lichhoc/hocvienlop/export_students_in_class.php
include('../../../../config/config.php');

$lop_id = $_GET['lop_id'] ?? '';
$search_term = $_GET['search'] ?? '';

if (empty($lop_id)) {
    die("Lỗi: Không tìm thấy thông tin lớp học.");
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=danh-sach-hoc-vien-lop-".$lop_id.".xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email, hv.so_dien_thoai
        FROM dangkykhoahoc dk 
        JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
        WHERE dk.id_lop = ?";
$params = [$lop_id];
$types = "s";

if (!empty($search_term)) {
    $sql .= " AND (hv.ten_hocvien LIKE ? OR hv.email LIKE ?)";
    $search_param = "%" . $search_term . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";
$output .= "<thead>
                <tr>
                    <th>ID Học viên</th>
                    <th>Tên Học viên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                </tr>
            </thead><tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['id_hocvien']) . "</td>
                        <td>" . htmlspecialchars($row['ten_hocvien']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>'" . htmlspecialchars($row['so_dien_thoai']) . "</td>
                    </tr>";
    }
}
$output .= "</tbody></table></body></html>";
echo $output;
$conn->close();
exit();
?>