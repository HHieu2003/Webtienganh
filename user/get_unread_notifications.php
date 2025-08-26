<?php
include('../config/config.php');

if (isset($_GET['id_hocvien'])) {
    $id_hocvien = $_GET['id_hocvien'];

    // Lấy thông báo chưa đọc
    $sql = "SELECT id_thongbao FROM thongbao WHERE id_hocvien = ? AND trang_thai = 'chưa đọc'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result = $stmt->get_result();

    $unreadNotifications = [];
    while ($row = $result->fetch_assoc()) {
        $unreadNotifications[] = $row;
    }

    echo json_encode($unreadNotifications);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Thiếu id_hocvien"]);
}
?>
