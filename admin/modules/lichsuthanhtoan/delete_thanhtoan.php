<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_thanhtoan = $_POST['id_thanhtoan'] ?? null;
    $id_hocvien = $_POST['id_hocvien'] ?? null;


    if ($id_thanhtoan) {
        // Xóa bản ghi thanh toán khỏi cơ sở dữ liệu
        $stmt = $conn->prepare("DELETE FROM lichsu_thanhtoan WHERE id_thanhtoan = ?");
        $stmt->bind_param("i", $id_thanhtoan);

        if ($stmt->execute()) {
            // Thành công
            $_SESSION['success_message'] = "Xóa lịch sử thanh toán thành công!";
        } else {
            // Thất bại
            $_SESSION['error_message'] = "Lỗi khi xóa lịch sử thanh toán: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Không tìm thấy ID thanh toán.";
    }
}

// Chuyển hướng lại trang danh sách lịch sử thanh toán
header("Location: ../../admin.php?nav=thanhtoan");
exit();
?>
