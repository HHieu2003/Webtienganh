<?php
session_start();
include('../../config/config.php');
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

// Chỉ xử lý nếu người dùng đã đăng nhập và yêu cầu là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_hocvien'])) {
    $current_user_id = $_SESSION['id_hocvien'];
    $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    
    $data = json_decode(file_get_contents('php://input'), true);
    $comment_id = (int)($data['comment_id'] ?? 0);

    if ($comment_id > 0) {
        // Lấy thông tin tác giả của bình luận để kiểm tra quyền
        $sql_check = "SELECT id_hocvien FROM binh_luan WHERE id_binhluan = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $comment_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $comment_author = $result_check->fetch_assoc();
            $author_id = $comment_author['id_hocvien'];

            // Kiểm tra quyền: Hoặc là admin, hoặc là chính chủ của bình luận
            if ($is_admin || $current_user_id == $author_id) {
                // Sử dụng ON DELETE CASCADE, chỉ cần xóa bình luận cha
                $sql_delete = "DELETE FROM binh_luan WHERE id_binhluan = ?";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $comment_id);
                
                if ($stmt_delete->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Xóa bình luận thành công!';
                } else {
                    $response['message'] = 'Lỗi CSDL: Không thể xóa bình luận.';
                }
            } else {
                $response['message'] = 'Bạn không có quyền thực hiện hành động này.';
            }
        } else {
            $response['message'] = 'Bình luận không tồn tại.';
        }
    } else {
        $response['message'] = 'ID bình luận không hợp lệ.';
    }
} else {
    $response['message'] = 'Vui lòng đăng nhập để thực hiện hành động này.';
}

echo json_encode($response);
$conn->close();
?>