<?php
include('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_dangky'])) {
    $id_dangky = $_POST['id_dangky'];

    // Chuẩn bị câu lệnh xóa
    $sql_delete = "DELETE FROM dangkykhoahoc WHERE id_dangky = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id_dangky);

    if ($stmt->execute()) {
        // Chuyển hướng sau khi xóa thành công
        header("Location: ../admin.php?nav=dangkykhoahoc&view=view");
    } else {
        // Thông báo lỗi nếu xóa thất bại
        echo "Lỗi: Không thể xóa bản ghi.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Nếu truy cập trực tiếp mà không thông qua POST
    header("Location: ../admin.php?nav=dangkykhoahoc&view=view");

    exit();
}
?>
