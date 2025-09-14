<?php
// File: huy_donhang.php
header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Yêu cầu đăng nhập và có id_dangky
if (!isset($_SESSION['id_hocvien']) || !isset($_POST['dangky_id'])) {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
    exit();
}

require('../../../config/config.php');

$id_hocvien = $_SESSION['id_hocvien'];
$dangky_id = (int)$_POST['dangky_id'];

// Cập nhật trạng thái đơn hàng thành 'da huy'
// Chỉ cập nhật những đơn hàng đang ở trạng thái 'cho xac nhan'
$sql = "UPDATE dangkykhoahoc 
        SET trang_thai = 'da huy' 
        WHERE id_dangky = ? 
        AND id_hocvien = ? 
        AND trang_thai = 'cho xac nhan'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $dangky_id, $id_hocvien);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Đã hủy đơn hàng hết hạn.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Đơn hàng không cần hủy.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi CSDL.']);
}

$stmt->close();
$conn->close();
?>