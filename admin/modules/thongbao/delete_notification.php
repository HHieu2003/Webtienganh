<?php
// file: modules/delete_notification.php
include('../../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_thongbao'])) {
    $id_thongbao = intval($_POST['id_thongbao']); // Ép kiểu an toàn

    $sql = "DELETE FROM thongbao WHERE id_thongbao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_thongbao);

    if ($stmt->execute()) {
        echo "Xóa thông báo thành công.";
    } else {
        echo "Lỗi khi xóa thông báo.";
    }

    $stmt->close();
    $conn->close();

    // Chuyển hướng về trang chính
    header('Location: ../../admin.php?nav=thongbao');
    exit();
}
?>
