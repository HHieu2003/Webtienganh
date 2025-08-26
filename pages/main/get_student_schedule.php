<?php
include("../../config/config.php");


if (isset($_GET['id_hocvien'])) {
    $id_hocvien = $_GET['id_hocvien'];

    // Truy vấn lịch học của học viên
    $sql = "SELECT 
                kh.ten_khoahoc, 
                kh.giang_vien, 
                lh.ngay_hoc, 
                lh.gio_bat_dau, 
                lh.gio_ket_thuc, 
                lh.phong_hoc, 
                lh.ghi_chu
            FROM dangkykhoahoc dk
            JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
            JOIN lichhoc lh ON lh.id_khoahoc = kh.id_khoahoc
            WHERE dk.id_hocvien = ?
            ORDER BY lh.ngay_hoc ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Lưu từng bản ghi vào mảng $data
    }

    echo json_encode($data);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Thiếu id_hocvien"]);
}
?>
