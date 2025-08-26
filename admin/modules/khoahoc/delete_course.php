<?php
include('../../../config/config.php');


// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Kiểm tra nếu có ID khóa học cần xóa
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Sử dụng chuẩn để bảo vệ khỏi SQL injection
    $delete_id = mysqli_real_escape_string($conn, $delete_id);

    // Xóa khóa học khỏi cơ sở dữ liệu
    $sql = "DELETE FROM khoahoc WHERE id_khoahoc = '$delete_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Xóa thành công"; // Nếu xóa thành công
    } else {
        echo "Lỗi: " . mysqli_error($conn); // Nếu có lỗi khi xóa
    }
} else {
    echo "Không có ID khóa học."; // Nếu không có ID khóa học
}
?>
