<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lichhoc = (int)$_POST['edit_id_lichhoc'];
    $id_lop = $_POST['id_lop'];
    $ngay_hoc = $_POST['ngay_hoc'];
    $gio_bat_dau = $_POST['gio_bat_dau'];
    $gio_ket_thuc = $_POST['gio_ket_thuc'];
    $phong_hoc = $_POST['phong_hoc'];
    $ghi_chu = $_POST['ghi_chu'];

    $sql = "UPDATE lichhoc SET ngay_hoc=?, gio_bat_dau=?, gio_ket_thuc=?, phong_hoc=?, ghi_chu=? WHERE id_lichhoc=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $ngay_hoc, $gio_bat_dau, $gio_ket_thuc, $phong_hoc, $ghi_chu, $id_lichhoc);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Cập nhật buổi học thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi cập nhật buổi học.'];
    }
    header("Location: ../../admin.php?nav=lichhoc&lop_id=$id_lop&view=schedule");
    exit();
}
?>