<?php
include('../config/config.php');


if (isset($_POST['id_hocvien'])) {
    $id_hocvien = $_POST['id_hocvien'];

    // Đánh dấu tất cả thông báo là đã đọc
    $sql = "UPDATE thongbao SET trang_thai = 'đã đọc' WHERE id_hocvien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hocvien);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Tất cả thông báo đã được đánh dấu là đã đọc."]);
    } else {
        echo json_encode(["success" => false, "message" => "Không thể đánh dấu thông báo."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Thiếu id_hocvien"]);
}
?>
