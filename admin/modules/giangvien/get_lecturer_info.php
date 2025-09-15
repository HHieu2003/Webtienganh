<?php
// Luôn đặt header ở đầu file
header('Content-Type: application/json');
include('../../../config/config.php');

// Tắt báo lỗi notice để không làm hỏng cấu trúc JSON
error_reporting(0);

$response = [];
$lecturerId = $_GET['id'] ?? 0;

if ($lecturerId > 0) {
    $sql = "SELECT id_giangvien, ten_giangvien, email, so_dien_thoai, mo_ta, hinh_anh FROM giangvien WHERE id_giangvien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $response = $result->fetch_assoc();
        http_response_code(200); // OK
    } else {
        http_response_code(404); // Not Found
        $response['error'] = "Không tìm thấy giảng viên với ID: " . $lecturerId;
    }
    $stmt->close();
} else {
    http_response_code(400); // Bad Request
    $response['error'] = "ID giảng viên không hợp lệ.";
}

$conn->close();
echo json_encode($response);
?>