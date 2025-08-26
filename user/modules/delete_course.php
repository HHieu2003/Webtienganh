<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'quanlykhoahoc');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dangky = intval($_POST['id_dangky']);

    // Xóa bản ghi từ bảng dangkykhoahoc
    $sql = "DELETE FROM dangkykhoahoc WHERE id_dangky = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_dangky);

    if ($stmt->execute()) {
        header("Location: ../dashboard.php?message=Xóa thành công");
    } else {
        echo "Xảy ra lỗi: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
