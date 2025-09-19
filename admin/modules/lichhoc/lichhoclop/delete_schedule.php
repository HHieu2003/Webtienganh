<?php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_lichhoc = (int)($data['id_lichhoc'] ?? 0);

    if ($id_lichhoc > 0) {
        $sql = "DELETE FROM lichhoc WHERE id_lichhoc = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_lichhoc);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Xóa buổi học thành công!';
        } else {
            $response['message'] = 'Lỗi khi xóa buổi học.';
        }
    }
}
echo json_encode($response);
$conn->close();
?>