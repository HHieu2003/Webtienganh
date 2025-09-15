<?php
include('../../../config/config.php');
session_start();

if (isset($_GET['id'])) {
    $id_lichhoc = (int)$_GET['id'];
    $id_lop = $_GET['lop_id'];

    $sql = "DELETE FROM lichhoc WHERE id_lichhoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_lichhoc);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Xóa buổi học thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi xóa buổi học.'];
    }
    header("Location: ../../admin.php?nav=lichhoc&lop_id=$id_lop&view=schedule");
    exit();
}
?>