<?php
include('../../../config/config.php');
if (isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $sql = "DELETE FROM giangvien WHERE id_giangvien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "Xóa thành công";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Không có ID được cung cấp.";
}
$conn->close();
?>