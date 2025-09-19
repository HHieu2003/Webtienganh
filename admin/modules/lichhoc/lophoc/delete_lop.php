<?php
include('../../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $delete_lop_id = $data['id_lop'] ?? null;

    if ($delete_lop_id) {
        $sql = "DELETE FROM lop_hoc WHERE id_lop = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $delete_lop_id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Xóa lớp học thành công!';
        } else {
            $response['message'] = 'Lỗi khi xóa lớp học. Lớp có thể vẫn còn dữ liệu quan trọng.';
        }
    }
}
echo json_encode($response);
$conn->close();
?>