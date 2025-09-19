<?php
include('../../../config/config.php');

// Đảm bảo phản hồi luôn là JSON
header('Content-Type: application/json');

// Khởi tạo mảng phản hồi mặc định
$response = ['status' => 'error', 'message' => 'Đã có lỗi xảy ra.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_hocvien = $_POST['ten_hocvien'] ?? '';
    $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
    $email = $_POST['email'] ?? '';
    $mat_khau = $_POST['mat_khau'] ?? '';

    if (empty($ten_hocvien) || empty($email) || empty($mat_khau)) {
        $response['message'] = 'Vui lòng điền đầy đủ các trường bắt buộc.';
        echo json_encode($response);
        exit;
    }

    // Kiểm tra email đã tồn tại chưa bằng Prepared Statement
    $sql_check = "SELECT id_hocvien FROM hocvien WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $response['message'] = 'Email này đã tồn tại trong hệ thống!';
    } else {
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);

        // Thêm học viên mới
        $sql_insert = "INSERT INTO hocvien (ten_hocvien, so_dien_thoai, email, mat_khau) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $ten_hocvien, $so_dien_thoai, $email, $hashedPassword);

        if ($stmt_insert->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Thêm học viên thành công!';
        } else {
            $response['message'] = 'Lỗi CSDL: Không thể thêm học viên.';
        }
        $stmt_insert->close();
    }
    $stmt_check->close();
} else {
    $response['message'] = 'Yêu cầu không hợp lệ.';
}

$conn->close();
// Trả về kết quả dạng JSON
echo json_encode($response);
?>