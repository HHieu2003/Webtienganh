<?php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_hocvien = (int)($data['student_id'] ?? 0);
    $lop_id = $data['lop_id'] ?? null;

    if ($id_hocvien > 0 && $lop_id) {
        $conn->begin_transaction();
        try {
            // Trigger trong CSDL sẽ tự động xử lý việc giảm sĩ số và xóa tiến độ
            $sql_remove = "UPDATE dangkykhoahoc SET id_lop = NULL WHERE id_hocvien = ? AND id_lop = ?";
            $stmt_remove = $conn->prepare($sql_remove);
            $stmt_remove->bind_param('is', $id_hocvien, $lop_id);
            $stmt_remove->execute();
            
            $conn->commit();
            $response['status'] = 'success';
            $response['message'] = 'Đã xóa học viên khỏi lớp thành công!';
        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = 'Lỗi khi xóa học viên: ' . $e->getMessage();
        }
    }
}
echo json_encode($response);
$conn->close();
?>