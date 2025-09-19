<?php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $delete_ids = $data['delete_ids'] ?? [];

    if (!empty($delete_ids) && is_array($delete_ids)) {
        $ids_to_delete = array_map('intval', $delete_ids);
        $placeholders = implode(',', array_fill(0, count($ids_to_delete), '?'));
        $types = str_repeat('i', count($ids_to_delete));

        $sql = "DELETE FROM tuvan WHERE id_tuvan IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$ids_to_delete);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Đã xóa thành công ' . $stmt->affected_rows . ' yêu cầu.';
        } else {
            $response['message'] = 'Lỗi khi xóa yêu cầu tư vấn.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Không có mục nào được chọn để xóa.';
    }
}

echo json_encode($response);
$conn->close();
?>