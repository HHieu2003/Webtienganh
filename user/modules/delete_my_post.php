<?php
session_start();
include('../../config/config.php');
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

// Chỉ xử lý nếu người dùng đã đăng nhập và yêu cầu là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_hocvien'])) {
    $current_user_id = $_SESSION['id_hocvien'];
    
    $data = json_decode(file_get_contents('php://input'), true);
    $post_id = (int)($data['post_id'] ?? 0);

    if ($post_id > 0) {
        // Câu lệnh SQL để xóa, có điều kiện WHERE để đảm bảo người dùng chỉ xóa được bài của mình
        $sql_delete = "DELETE FROM bai_viet WHERE id_baiviet = ? AND id_tac_gia = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ii", $post_id, $current_user_id);
        
        if ($stmt_delete->execute()) {
            // Kiểm tra xem có hàng nào bị ảnh hưởng không
            if ($stmt_delete->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Xóa bài viết thành công!';
            } else {
                $response['message'] = 'Không tìm thấy bài viết hoặc bạn không có quyền xóa.';
            }
        } else {
            $response['message'] = 'Lỗi CSDL: Không thể xóa bài viết.';
        }
    } else {
        $response['message'] = 'ID bài viết không hợp lệ.';
    }
} else {
    $response['message'] = 'Vui lòng đăng nhập để thực hiện hành động này.';
}

echo json_encode($response);
$conn->close();
?>