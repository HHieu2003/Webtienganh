<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if (isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    
    // Do CSDL có ràng buộc ON DELETE SET NULL, chúng ta chỉ cần xóa giảng viên.
    // Các khóa học và lớp học liên quan sẽ tự động cập nhật id_giangvien thành NULL.
    $sql = "DELETE FROM giangvien WHERE id_giangvien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Xóa giảng viên thành công!';
        } else {
            $response['message'] = 'Không tìm thấy giảng viên để xóa.';
        }
    } else {
        $response['message'] = "Lỗi CSDL: " . $stmt->error;
    }
    $stmt->close();
} else {
    $response['message'] = "Không có ID được cung cấp.";
}

$conn->close();
echo json_encode($response);
?>