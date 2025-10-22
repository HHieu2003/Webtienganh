<?php
header('Content-Type: application/json');
include('../../../config/config.php'); // Đảm bảo đường dẫn config đúng

$response = ['error' => 'ID không hợp lệ.'];
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Chuyển đổi sang integer

if ($courseId > 0) {
    // Thêm cap_do vào câu lệnh SELECT
    $sql = "SELECT id_khoahoc, ten_khoahoc, mo_ta, cap_do, thoi_gian, chi_phi, hinh_anh FROM khoahoc WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($course = $result->fetch_assoc()) {
            // Không cần gán vào $response['data'], trả về trực tiếp đối tượng course
            echo json_encode($course);
            $stmt->close();
            $conn->close();
            exit; // Kết thúc script sau khi gửi JSON hợp lệ
        } else {
            http_response_code(404); // Set mã lỗi HTTP
            $response['error'] = "Không tìm thấy khóa học.";
        }
        $stmt->close();
    } else {
         $response['error'] = "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
    }
}

// Chỉ echo response lỗi nếu không tìm thấy hoặc ID không hợp lệ
echo json_encode($response);
$conn->close();
?>