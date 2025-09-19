<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $id = (int)($data['id'] ?? 0);

    if ($id > 0 && !empty($action)) {
        $conn->begin_transaction();
        try {
            if ($action === 'accept') {
                $stmt = $conn->prepare("UPDATE dangkykhoahoc SET trang_thai = 'da xac nhan' WHERE id_dangky = ? AND trang_thai = 'cho xac nhan'");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $response['message'] = 'Xác nhận đăng ký thành công!';
            } elseif ($action === 'reject') {
                $stmt = $conn->prepare("UPDATE dangkykhoahoc SET trang_thai = 'bi tu choi' WHERE id_dangky = ? AND trang_thai = 'cho xac nhan'");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $response['message'] = 'Đã từ chối đơn đăng ký.';
            } elseif ($action === 'consulted') {
                $stmt = $conn->prepare("UPDATE tuvan SET trang_thai = 'Đã tư vấn' WHERE id_tuvan = ? AND trang_thai != 'Đã tư vấn'");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $response['message'] = 'Đã xác nhận tư vấn.';
            } else {
                 $response['message'] = 'Hành động không được hỗ trợ.';
                 echo json_encode($response);
                 exit;
            }

            if ($stmt->affected_rows > 0) {
                 $conn->commit();
                 $response['status'] = 'success';
            } else {
                 $conn->rollback();
                 $response['message'] = 'Không có gì thay đổi. Trạng thái có thể đã được cập nhật trước đó.';
            }
            $stmt->close();

        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
$conn->close();
?>