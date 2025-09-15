<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_baitest = $_POST['ten_baitest'];
    $id_khoahoc = (int)$_POST['id_khoahoc'];
    $thoi_gian = (int)$_POST['thoi_gian'];
    $is_placement_test = isset($_POST['is_placement_test']) ? 1 : 0;

    $sql = "INSERT INTO baitest (ten_baitest, id_khoahoc, thoi_gian, is_placement_test, ngay_tao) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('siis', $ten_baitest, $id_khoahoc, $thoi_gian, $is_placement_test);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm bài test thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi thêm bài test.'];
    }
    header('Location: ../../admin.php?nav=question');
    exit();
}
?>