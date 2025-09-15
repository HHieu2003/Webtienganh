<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['edit_id_lop'];
    $ten_lop = $_POST['edit_ten_lop'];
    $id_giangvien = !empty($_POST['edit_id_giangvien']) ? (int)$_POST['edit_id_giangvien'] : NULL;
    $trang_thai = $_POST['edit_trang_thai'];

    $sql = "UPDATE lop_hoc SET ten_lop = ?, id_giangvien = ?, trang_thai = ? WHERE id_lop = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $ten_lop, $id_giangvien, $trang_thai, $id_lop);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Cập nhật lớp học thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi cập nhật lớp học.'];
    }
    $stmt->close();
    $conn->close();
}
header('Location: ../../admin.php?nav=lichhoc');
exit();
?>