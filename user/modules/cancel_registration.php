<?php
// user/modules/cancel_registration.php
session_start();
include('../../config/config.php');

// Kiểm tra đăng nhập và sự tồn tại của id_dangky
if (!isset($_SESSION['id_hocvien']) || !isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit();
}

$id_hocvien = $_SESSION['id_hocvien'];
$id_dangky = (int)$_GET['id'];

// Cập nhật trạng thái thành 'da huy'
// Chỉ cho phép hủy những đăng ký đang ở trạng thái 'cho xac nhan' của chính học viên đó
$sql = "UPDATE dangkykhoahoc 
        SET trang_thai = 'da huy' 
        WHERE id_dangky = ? 
        AND id_hocvien = ? 
        AND trang_thai = 'cho xac nhan'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_dangky, $id_hocvien);

if ($stmt->execute()) {
    // Nếu cập nhật thành công, quay về trang chủ dashboard
    header("Location: ../dashboard.php?message=cancelled_successfully");
} else {
    // Nếu có lỗi, quay về với thông báo lỗi
    header("Location: ../dashboard.php?message=cancel_failed");
}

$stmt->close();
$conn->close();
?>