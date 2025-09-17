<?php
// admin/modules/export_registrations.php
include('../../../config/config.php');

// Lấy các tham số từ URL
$view = $_GET['view'] ?? 'pending';
$search_term = $_GET['search'] ?? '';

// Đặt header cho file Excel
$filename = "danh-sach-dang-ky.xls";
if ($view === 'consult') {
    $filename = "danh-sach-tu-van.xls";
}
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

// Bắt đầu tạo nội dung Excel
$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
$output .= "<head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head>";
$output .= "<body><table border='1'>";

if ($view === 'consult') {
    // --- Xuất dữ liệu cho tab "Cần tư vấn" ---
    $output .= "<thead><tr><th>Tên Học viên</th><th>Số Điện thoại</th><th>Email</th><th>Trạng thái</th></tr></thead><tbody>";

    $sql = "SELECT id_tuvan, ten_hocvien, so_dien_thoai, email, trang_thai FROM tuvan";
    if (!empty($search_term)) {
        $sql .= " WHERE ten_hocvien LIKE ? OR so_dien_thoai LIKE ? OR email LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%" . $search_term . "%";
        $stmt->bind_param("sss", $search_param, $search_param, $search_param);
    } else {
        $stmt = $conn->prepare($sql);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>
                        <td>'" . htmlspecialchars($row["so_dien_thoai"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["trang_thai"]) . "</td>
                    </tr>";
    }

} else {
    // --- Xuất dữ liệu cho tab "Chờ xác nhận" và "Tất cả" ---
    $output .= "<thead><tr><th>Học viên</th><th>Tên Khóa học</th><th>Ngày Đăng ký</th><th>Trạng thái</th></tr></thead><tbody>";
    
    $sql = "SELECT dk.id_dangky, hv.ten_hocvien, kh.ten_khoahoc, dk.ngay_dangky, dk.trang_thai 
            FROM dangkykhoahoc dk
            JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
            JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc";
    
    $conditions = [];
    $params = [];
    $types = "";

    if ($view === 'pending') {
        $conditions[] = "dk.trang_thai = 'cho xac nhan'";
    }

    if (!empty($search_term)) {
        $conditions[] = "(hv.ten_hocvien LIKE ? OR kh.ten_khoahoc LIKE ?)";
        $search_param = "%" . $search_term . "%";
        $params[] = $search_param;
        $params[] = $search_param;
        $types .= "ss";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY dk.id_dangky DESC";

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>
                        <td>" . htmlspecialchars($row["ten_khoahoc"]) . "</td>
                        <td>" . htmlspecialchars(date("d/m/Y", strtotime($row["ngay_dangky"]))) . "</td>
                        <td>" . htmlspecialchars($row["trang_thai"]) . "</td>
                    </tr>";
    }
}

$output .= "</tbody></table></body></html>";
echo $output;

$conn->close();
exit();
?>