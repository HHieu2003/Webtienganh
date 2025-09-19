<?php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu dưới dạng JSON từ body của request
    $data = json_decode(file_get_contents('php://input'), true);
    $delete_ids = $data['delete_ids'] ?? [];

    if (!empty($delete_ids) && is_array($delete_ids)) {
        // Chuyển các ID thành một chuỗi các số nguyên an toàn
        $ids_to_delete = array_map('intval', $delete_ids);
        
        // Tạo chuỗi placeholders '?' cho câu lệnh SQL, ví dụ: (?, ?, ?)
        $placeholders = implode(',', array_fill(0, count($ids_to_delete), '?'));
        
        // Tạo chuỗi types cho bind_param, ví dụ: 'iii' cho 3 ID
        $types = str_repeat('i', count($ids_to_delete));

        $sql = "DELETE FROM lichsu_thanhtoan WHERE id_thanhtoan IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        
        // ...$ids_to_delete là "spread operator" để truyền mảng vào bind_param
        $stmt->bind_param($types, ...$ids_to_delete);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Đã xóa thành công ' . $stmt->affected_rows . ' giao dịch.';
        } else {
            $response['message'] = 'Lỗi CSDL khi xóa giao dịch.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Không có mục nào được chọn để xóa.';
    }
}

$conn->close();
echo json_encode($response);
?>