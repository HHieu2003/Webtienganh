<?php
// admin/modules/lichhoc/export_schedule_for_class.php
include('../../../config/config.php');

$lop_id = $_GET['lop_id'] ?? '';
$search_term = $_GET['search'] ?? '';

if (empty($lop_id)) {
    die("Lỗi: Không tìm thấy thông tin lớp học.");
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=lich-hoc-lop-".$lop_id.".xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM lichhoc WHERE id_lop = ?";
$params = [$lop_id];
$types = "s";

if (!empty($search_term)) {
    $sql .= " AND (phong_hoc LIKE ? OR ghi_chu LIKE ?)";
    $search_param = "%" . $search_term . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}
$sql .= " ORDER BY ngay_hoc ASC, gio_bat_dau ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";
$output .= "<thead>
                <tr>
                    <th>Ngày học</th>
                    <th>Giờ bắt đầu</th>
                    <th>Giờ kết thúc</th>
                    <th>Phòng học</th>
                    <th>Ghi chú</th>
                </tr>
            </thead><tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row['ngay_hoc']) . "</td>
                        <td>" . htmlspecialchars($row['gio_bat_dau']) . "</td>
                        <td>" . htmlspecialchars($row['gio_ket_thuc']) . "</td>
                        <td>" . htmlspecialchars($row['phong_hoc']) . "</td>
                        <td>" . htmlspecialchars($row['ghi_chu']) . "</td>
                    </tr>";
    }
}
$output .= "</tbody></table></body></html>";
echo $output;
$conn->close();
exit();
?>