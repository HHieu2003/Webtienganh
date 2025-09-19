<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Đã có lỗi xảy ra.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_hocvien = (int)($_POST['id_hocvien'] ?? 0);
    $ten_hocvien = $_POST['ten_hocvien'] ?? '';
    $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
    $email = $_POST['email'] ?? '';
    $mat_khau = $_POST['mat_khau'] ?? '';
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    if (empty($ten_hocvien) || empty($email) || $id_hocvien === 0) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }
    
    // Kiểm tra email có bị trùng với người khác không
    $sql_check_email = "SELECT id_hocvien FROM hocvien WHERE email = ? AND id_hocvien != ?";
    $stmt_check = $conn->prepare($sql_check_email);
    $stmt_check->bind_param("si", $email, $id_hocvien);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        $response['message'] = 'Email này đã được sử dụng bởi một tài khoản khác.';
        echo json_encode($response);
        exit;
    }
    $stmt_check->close();

    // Kiểm tra xem có nhập mật khẩu mới không
    if (!empty($mat_khau)) {
        $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);
        $sql = "UPDATE hocvien SET ten_hocvien = ?, so_dien_thoai = ?, email = ?, mat_khau = ?, is_admin = ? WHERE id_hocvien = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $ten_hocvien, $so_dien_thoai, $email, $hashedPassword, $is_admin, $id_hocvien);
    } else {
        $sql = "UPDATE hocvien SET ten_hocvien = ?, so_dien_thoai = ?, email = ?, is_admin = ? WHERE id_hocvien = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $ten_hocvien, $so_dien_thoai, $email, $is_admin, $id_hocvien);
    }

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Cập nhật thông tin thành công!';
    } else {
        $response['message'] = 'Lỗi CSDL khi cập nhật.';
    }
    
    $stmt->close();
} else {
     $response['message'] = 'Yêu cầu không hợp lệ.';
}

$conn->close();
echo json_encode($response);
?>