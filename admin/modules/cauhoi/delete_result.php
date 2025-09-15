<?php
include('../../../config/config.php');
session_start();

if (isset($_GET['id_ketqua']) && isset($_GET['id_baitest'])) {
    $id_ketqua = (int)$_GET['id_ketqua'];
    $id_baitest = (int)$_GET['id_baitest'];

    $sql = "DELETE FROM ketquabaitest WHERE id_ketqua = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_ketqua);
    $stmt->execute();
}
// Luôn chuyển hướng về trang kết quả
header("Location: ../../admin.php?nav=kqhocvien&id_baitest=$id_baitest");
exit();
?>