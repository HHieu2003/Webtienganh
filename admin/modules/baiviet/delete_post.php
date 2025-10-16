<?php
include('../../../config/config.php');
session_start();
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = (int)($data['id'] ?? 0);

    if ($id > 0) {
        $sql = "DELETE FROM bai_viet WHERE id_baiviet = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Xóa bài viết thành công!';
        } else {
            $response['message'] = 'Lỗi khi xóa bài viết.';
        }
    }
} else {
    $response['message'] = 'Không có quyền truy cập.';
}
echo json_encode($response);
$conn->close();
?>