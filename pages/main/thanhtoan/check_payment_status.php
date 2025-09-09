<?php
// File: check_payment_status.php
header('Content-Type: application/json');

// Kết nối CSDL
require('../../../config/config.php');
 
// Chỉ cho phép POST và POST có ID đơn hàng
if (!isset($_POST['dangky_id']) || !is_numeric($_POST['dangky_id'])) {
    echo json_encode(['error' => 'Access Denied']);
    exit();
}
 
$dangky_id = (int)$_POST['dangky_id'];

// Kiểm tra trạng thái đơn đăng ký
$sql = "SELECT trang_thai FROM dangkykhoahoc WHERE id_dangky = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dangky_id);
$stmt->execute();
$result = $stmt->get_result();
 
if ($result->num_rows > 0) {
    $order_details = $result->fetch_object();
    // Trả về kết quả trạng thái dạng JSON
    echo json_encode(['payment_status' => $order_details->trang_thai]);
} else {
    // Trả về kết quả không tìm thấy đơn hàng
    echo json_encode(['payment_status' => 'order_not_found']);
}

$stmt->close();
$conn->close();
?>