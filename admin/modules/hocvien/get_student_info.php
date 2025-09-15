
<?php
// Set header để đảm bảo trình duyệt hiểu đây là dữ liệu JSON
header('Content-Type: application/json');
include('../../../config/config.php');

$studentId = $_GET['id'] ?? 0;

// Sử dụng Prepared Statements để chống tấn công SQL Injection
$sql = "SELECT id_hocvien, ten_hocvien, email, so_dien_thoai, is_admin FROM hocvien WHERE id_hocvien = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $student = $result->fetch_assoc();
    echo json_encode($student);
} else {
    // Trả về lỗi nếu không tìm thấy
    http_response_code(404);
    echo json_encode(["error" => "Không tìm thấy học viên."]);
}

$stmt->close();
$conn->close();
?>