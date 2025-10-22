<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khoahoc = $_POST['ten_khoahoc'] ?? '';
    $mo_ta = $_POST['mo_ta'] ?? '';
    $cap_do = $_POST['cap_do'] ?? NULL; // Thêm dòng này để lấy cấp độ
    $thoi_gian = !empty($_POST['thoi_gian']) ? (int)$_POST['thoi_gian'] : NULL;
    $chi_phi = !empty($_POST['chi_phi']) ? (int)$_POST['chi_phi'] : 0;

    if (empty($ten_khoahoc) || $chi_phi <= 0) {
        $response['message'] = 'Vui lòng điền tên và học phí hợp lệ.';
        echo json_encode($response);
        exit;
    }

    $hinh_anh = NULL;
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../uploads/"; // Đảm bảo thư mục uploads tồn tại và có quyền ghi
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            // Lưu đường dẫn tương đối từ thư mục gốc của web, không phải từ file PHP này
            $hinh_anh = 'uploads/' . $file_name;
        } else {
             $response['message'] = 'Không thể tải ảnh lên.';
             // Không exit ở đây, có thể khóa học không cần ảnh
        }
    }

    // Cập nhật câu lệnh SQL để bao gồm cap_do
    $sql_insert = "INSERT INTO khoahoc (ten_khoahoc, mo_ta, cap_do, thoi_gian, chi_phi, hinh_anh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);

    if ($stmt) {
        // Cập nhật bind_param: s = string, i = integer. Thêm 's' cho cap_do
        $stmt->bind_param("sssids", $ten_khoahoc, $mo_ta, $cap_do, $thoi_gian, $chi_phi, $hinh_anh);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Thêm khóa học thành công!';
        } else {
            $response['message'] = 'Lỗi khi thêm khóa học: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Lỗi chuẩn bị câu lệnh SQL: ' . $conn->error;
    }
}

$conn->close();
echo json_encode($response);
?>