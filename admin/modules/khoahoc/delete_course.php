<?php
include('../../../config/config.php');

if (isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];

    // Sử dụng Prepared Statements để chống SQL Injection
    $sql = "DELETE FROM khoahoc WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "Xóa thành công";
    } else {
        // Trả về lỗi chi tiết hơn để JavaScript có thể xử lý
        echo "Lỗi: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Không có ID khóa học được cung cấp.";
}
$conn->close();
?>