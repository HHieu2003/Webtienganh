<?php
// File: admin/modules/cauhoi/edit_test.php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baitest = (int)($_POST['id_baitest'] ?? 0);
    $ten_baitest = $_POST['ten_baitest'];
    $loai_baitest = $_POST['loai_baitest'];
    $id_khoahoc = !empty($_POST['id_khoahoc']) ? (int)$_POST['id_khoahoc'] : NULL;
    $thoi_gian = (int)$_POST['thoi_gian'];

    if ($id_baitest === 0) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: ID bài test không hợp lệ.'];
        header('Location: ../../admin.php?nav=question');
        exit();
    }

    if ($loai_baitest === 'dinh_ky' && is_null($id_khoahoc)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Bài kiểm tra định kỳ phải được gán cho một khóa học.'];
        header('Location: ../../admin.php?nav=question');
        exit();
    }
    
    if ($loai_baitest === 'dau_vao') {
        $id_khoahoc = NULL;
    }

    $sql = "UPDATE baitest SET ten_baitest = ?, loai_baitest = ?, id_khoahoc = ?, thoi_gian = ? WHERE id_baitest = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssiii', $ten_baitest, $loai_baitest, $id_khoahoc, $thoi_gian, $id_baitest);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Cập nhật bài test thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi cập nhật bài test: ' . $stmt->error];
    }
}

header('Location: ../../admin.php?nav=question');
exit();
?>