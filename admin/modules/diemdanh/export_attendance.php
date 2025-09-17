<?php
// admin/modules/diemdanh/export_attendance.php
include('../../../config/config.php');

$lop_id = $_GET['lop_id'] ?? '';
if (empty($lop_id)) {
    die("Lỗi: Không tìm thấy thông tin lớp học.");
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=diem-danh-lop-".$lop_id.".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Lấy thông tin lớp học và các dữ liệu liên quan
$lichHocResult = $conn->query("SELECT id_lichhoc, ngay_hoc FROM lichhoc WHERE id_lop = '$lop_id' ORDER BY ngay_hoc ASC");
$lichHoc = $lichHocResult->fetch_all(MYSQLI_ASSOC);
$hocVienResult = $conn->query("SELECT hv.id_hocvien, hv.ten_hocvien FROM hocvien hv JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien WHERE dk.id_lop = '$lop_id'");
$hocVien = $hocVienResult->fetch_all(MYSQLI_ASSOC);
$diemDanhResult = $conn->query("SELECT id_hocvien, id_lichhoc, trang_thai FROM diem_danh WHERE id_lop = '$lop_id'");
$diemDanhData = [];
while ($row = $diemDanhResult->fetch_assoc()) {
    $diemDanhData[$row['id_hocvien']][$row['id_lichhoc']] = $row['trang_thai'];
}

$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";
$output .= "<thead><tr><th>Học viên</th>";
foreach ($lichHoc as $lich) {
    $output .= "<th>" . date("d/m/Y", strtotime($lich['ngay_hoc'])) . "</th>";
}
$output .= "</tr></thead><tbody>";

foreach ($hocVien as $hv) {
    $output .= "<tr><td>" . htmlspecialchars($hv['ten_hocvien']) . "</td>";
    foreach ($lichHoc as $lich) {
        $status = $diemDanhData[$hv['id_hocvien']][$lich['id_lichhoc']] ?? 'Vắng';
        if ($status === 'co mat') $status = 'Có mặt';
        if ($status === 'vang') $status = 'Vắng';
        if ($status === 'muon') $status = 'Muộn';
        $output .= "<td>" . $status . "</td>";
    }
    $output .= "</tr>";
}

$output .= "</tbody></table></body></html>";
echo $output;
$conn->close();
exit();
?>