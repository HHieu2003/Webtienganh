<?php
// File: admin/modules/cauhoi/add_test.php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_baitest = $_POST['ten_baitest'];
    $loai_baitest = $_POST['loai_baitest'];
    $id_khoahoc = !empty($_POST['id_khoahoc']) ? (int)$_POST['id_khoahoc'] : NULL;
    $id_lop = !empty($_POST['id_lop']) ? $_POST['id_lop'] : NULL;
    $thoi_gian = (int)$_POST['thoi_gian'];

    if (($loai_baitest === 'dinh_ky') && is_null($id_khoahoc)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Bài kiểm tra định kỳ phải được gán cho một khóa học.'];
        header('Location: ../../admin.php?nav=question');
        exit();
    }
    
    if ($loai_baitest === 'dau_vao') {
        $id_khoahoc = NULL;
        $id_lop = NULL;
    }

    $sql = "INSERT INTO baitest (ten_baitest, loai_baitest, id_khoahoc, id_lop, thoi_gian, ngay_tao) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisi', $ten_baitest, $loai_baitest, $id_khoahoc, $id_lop, $thoi_gian);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm bài test thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi thêm bài test: ' . $stmt->error];
    }
    header('Location: ../../admin.php?nav=question');
    exit();
}
?>