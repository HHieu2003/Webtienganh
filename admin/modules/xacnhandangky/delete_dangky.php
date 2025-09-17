<?php
include('../../../config/config.php');
session_start(); // Thêm session_start để có thể gửi thông báo

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_dangky'])) {
    $id_dangky = $_POST['id_dangky'];

    $sql_delete = "DELETE FROM dangkykhoahoc WHERE id_dangky = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id_dangky);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Đã xóa bản ghi đăng ký thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi xóa bản ghi.'];
    }

    $stmt->close();
    $conn->close();
} else {
     $_SESSION['message'] = ['type' => 'danger', 'text' => 'Yêu cầu không hợp lệ.'];
}

// *** SỬA LỖI TẠI ĐÂY: Chuyển hướng về đúng tab "all" ***
header("Location: ../../admin.php?nav=dangkykhoahoc&view=all");
exit();
?>