<?php
// File: xoa_donhang.php
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

// Xóa vĩnh viễn đơn hàng khỏi CSDL
// Chỉ xóa những đơn hàng đang ở trạng thái 'cho xac nhan'
// và phải thuộc về học viên đang đăng nhập để đảm bảo an toàn
$sql = "DELETE FROM dangkykhoahoc 
        WHERE id_dangky = ? 
        AND id_hocvien = ? 
        AND trang_thai = 'cho xac nhan'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $dangky_id, $id_hocvien);

if ($stmt->execute()) {
    // a_rows > 0 nghĩa là có 1 dòng được xóa thành công
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Đã xóa đơn hàng hết hạn.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Đơn hàng không cần xóa.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi CSDL.']);
}

$stmt->close();
$conn->close();
?>