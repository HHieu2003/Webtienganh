<?php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_dangky = (int)($data['id_dangky'] ?? 0);

    if ($id_dangky > 0) {
        $sql_delete = "DELETE FROM dangkykhoahoc WHERE id_dangky = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $id_dangky);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Đã xóa bản ghi đăng ký thành công!';
        } else {
            $response['message'] = 'Lỗi khi xóa bản ghi.';
        }
        $stmt->close();
    }
}

echo json_encode($response);
$conn->close();
?>