<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieu_de = $_POST['tieu_de'] ?? '';
    $id_khoahoc_str = $_POST['id_khoahoc'] ?? '';
    $ngay_tao = $_POST['ngay_tao'] ?? '';

    // Xóa tất cả các thông báo có cùng tiêu đề, khóa học và thời gian tạo chính xác
    if ($id_khoahoc_str !== '') { // Gửi đến khóa học cụ thể
        $id_khoahoc = (int)$id_khoahoc_str;
        $sql = "DELETE FROM thongbao WHERE tieu_de = ? AND id_khoahoc = ? AND ngay_tao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $tieu_de, $id_khoahoc, $ngay_tao);
    } else { // Gửi đến tất cả
        $sql = "DELETE FROM thongbao WHERE tieu_de = ? AND id_khoahoc IS NULL AND ngay_tao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $tieu_de, $ngay_tao);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Đã xóa nhóm thông báo thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi xóa thông báo.'];
    }

    header('Location: ../../admin.php?nav=thongbao');
    exit();
}
?>