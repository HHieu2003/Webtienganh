<?php
// admin/modules/lichhoc/export_classes.php
include('../../../config/config.php');

$search_term = $_GET['search'] ?? '';

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=danh-sach-lop-hoc.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT lh.id_lop, lh.ten_lop, lh.trang_thai, kh.ten_khoahoc, gv.ten_giangvien 
        FROM lop_hoc lh 
        JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc 
        LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien";

$params = [];
$types = "";
if (!empty($search_term)) {
    $sql .= " WHERE lh.ten_lop LIKE ? OR kh.ten_khoahoc LIKE ? OR gv.ten_giangvien LIKE ?";
    $search_param = "%" . $search_term . "%";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}
$sql .= " ORDER BY lh.id_lop ASC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";
$output .= "<thead>
                <tr>
                    <th>ID Lớp</th>
                    <th>Tên Lớp</th>
                    <th>Khóa học</th>
                    <th>Giảng viên</th>
                    <th>Trạng thái</th>
                </tr>
            </thead><tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['id_lop']) . "</td>
                        <td>" . htmlspecialchars($row['ten_lop']) . "</td>
                        <td>" . htmlspecialchars($row['ten_khoahoc']) . "</td>
                        <td>" . htmlspecialchars($row['ten_giangvien'] ?? 'Chưa phân công') . "</td>
                        <td>" . ($row['trang_thai'] === 'dang hoc' ? 'Đang học' : 'Đã xong') . "</td>
                    </tr>";
    }
}
$output .= "</tbody></table></body></html>";
echo $output;
$conn->close();
exit();
?>