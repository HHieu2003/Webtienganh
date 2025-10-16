<?php
include('../../../config/config.php');
session_start();
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = (int)($data['id'] ?? 0);
    $status = $data['status'] ?? '';

    if ($id > 0 && in_array($status, ['da_duyet', 'bi_tu_choi'])) {
        $ngay_duyet = ($status == 'da_duyet') ? date('Y-m-d H:i:s') : null;
        
        $sql = "UPDATE bai_viet SET trang_thai = ?, ngay_duyet = ? WHERE id_baiviet = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $status, $ngay_duyet, $id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Cập nhật trạng thái thành công!';
        } else {
            $response['message'] = 'Lỗi CSDL khi cập nhật.';
        }
    } else {
        $response['message'] = 'Dữ liệu không hợp lệ.';
    }
} else {
    $response['message'] = 'Không có quyền truy cập.';
}
echo json_encode($response);
$conn->close();
?>