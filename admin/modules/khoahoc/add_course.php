<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khoahoc = $_POST['ten_khoahoc'] ?? '';
    $mo_ta = $_POST['mo_ta'] ?? '';
    $id_giangvien = !empty($_POST['id_giangvien']) ? (int)$_POST['id_giangvien'] : NULL;
    $thoi_gian = !empty($_POST['thoi_gian']) ? (int)$_POST['thoi_gian'] : NULL;
    $chi_phi = !empty($_POST['chi_phi']) ? (int)$_POST['chi_phi'] : 0;

    if (empty($ten_khoahoc) || $chi_phi <= 0) {
        $response['message'] = 'Vui lòng điền tên và học phí hợp lệ.';
        echo json_encode($response);
        exit;
    }

    $hinh_anh = NULL;
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh = 'uploads/' . $file_name;
        }
    }

    $sql_insert = "INSERT INTO khoahoc (ten_khoahoc, mo_ta, id_giangvien, thoi_gian, chi_phi, hinh_anh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param('ssiiis', $ten_khoahoc, $mo_ta, $id_giangvien, $thoi_gian, $chi_phi, $hinh_anh);
    
    if($stmt->execute()){
        $response['status'] = 'success';
        $response['message'] = 'Thêm khóa học thành công!';
    } else {
        $response['message'] = 'Lỗi CSDL khi thêm khóa học.';
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>