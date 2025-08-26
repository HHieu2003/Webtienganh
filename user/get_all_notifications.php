<?php
include('../config/config.php');

if (isset($_GET['id_hocvien'])) {
    $id_hocvien = $_GET['id_hocvien'];

    // Truy vấn lấy tất cả thông báo, ưu tiên chưa đọc
    $sql = "SELECT id_thongbao, tieu_de, noi_dung, trang_thai, ngay_tao 
            FROM thongbao 
            WHERE id_hocvien = ?
            ORDER BY trang_thai ASC, ngay_tao DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    echo json_encode($notifications);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Thiếu id_hocvien"]);
}
?>
