<?php
include("../../config/config.php");

header('Content-Type: application/json');

if (isset($_GET['id_hocvien'])) {
    $id_hocvien = (int)$_GET['id_hocvien'];

    // Câu lệnh SQL đã được sửa lại cho đúng
    $sql = "SELECT 
                kh.ten_khoahoc, 
                gv.ten_giangvien, 
                lh.ngay_hoc, 
                lh.gio_bat_dau, 
                lh.gio_ket_thuc, 
                lh.phong_hoc, 
                lh.ghi_chu
            FROM dangkykhoahoc dk
            JOIN lop_hoc l ON dk.id_lop = l.id_lop
            JOIN khoahoc kh ON l.id_khoahoc = kh.id_khoahoc
            JOIN lichhoc lh ON lh.id_lop = l.id_lop
            LEFT JOIN giangvien gv ON l.id_giangvien = gv.id_giangvien
            WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan'
            ORDER BY lh.ngay_hoc ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Thiếu id_hocvien"]);
}
?>