<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_giangvien = $_POST['ten_giangvien'] ?? '';
    $email = $_POST['email'] ?? '';
    $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
    $mat_khau = $_POST['mat_khau'] ?? '';
    $mo_ta = $_POST['mo_ta'] ?? '';

    if (empty($ten_giangvien) || empty($email) || empty($mat_khau)) {
        $response['message'] = 'Vui lòng điền đầy đủ các trường bắt buộc.';
        echo json_encode($response);
        exit;
    }

    // Kiểm tra email đã tồn tại
    $checkEmail = $conn->prepare("SELECT id_giangvien FROM giangvien WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    if ($checkEmail->get_result()->num_rows > 0) {
        $response['message'] = "Email này đã được sử dụng!";
        echo json_encode($response);
        exit;
    }
    $checkEmail->close();

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);

    // Xử lý upload hình ảnh
    $hinh_anh = NULL;
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../uploads/lecturers/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $file_name = time() . '_' . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh = 'uploads/lecturers/' . $file_name;
        }
    }

    $sql = "INSERT INTO giangvien (ten_giangvien, email, so_dien_thoai, mat_khau, mo_ta, hinh_anh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $ten_giangvien, $email, $so_dien_thoai, $hashedPassword, $mo_ta, $hinh_anh);
    
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Thêm giảng viên thành công!';
    } else {
        $response['message'] = 'Lỗi CSDL khi thêm giảng viên.';
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>