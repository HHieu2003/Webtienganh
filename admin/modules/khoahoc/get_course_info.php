<?php
header('Content-Type: application/json');
include('../../../config/config.php');

$response = ['error' => 'ID không hợp lệ.'];
$courseId = $_GET['id'] ?? 0;

if ($courseId > 0) {
    $sql = "SELECT id_khoahoc, ten_khoahoc, mo_ta, id_giangvien, thoi_gian, chi_phi, hinh_anh FROM khoahoc WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($course = $result->fetch_assoc()) {
        echo json_encode($course);
        exit;
    } else {
        http_response_code(404);
        $response['error'] = "Không tìm thấy khóa học.";
    }
}

echo json_encode($response);
$conn->close();
?>