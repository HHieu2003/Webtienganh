<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_khoahoc = (int)($_POST['id_khoahoc'] ?? 0);
    $ten_khoahoc = $_POST['ten_khoahoc'] ?? '';
    $mo_ta = $_POST['mo_ta'] ?? '';
    $thoi_gian = !empty($_POST['thoi_gian']) ? (int)$_POST['thoi_gian'] : NULL;
    $chi_phi = (int)($_POST['chi_phi'] ?? 0);
    $hinh_anh_hien_tai = $_POST['hinh_anh_hien_tai'] ?? '';

    if ($id_khoahoc === 0 || empty($ten_khoahoc) || $chi_phi <= 0) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }
    
    $hinh_anh_moi = $hinh_anh_hien_tai;
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../uploads/";
        $target_file = $target_dir . time() . '_' . basename($_FILES['hinh_anh']['name']);
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh_moi = 'uploads/' . time() . '_' . basename($_FILES['hinh_anh']['name']);
        }
    }

    $sql_update = "UPDATE khoahoc SET ten_khoahoc=?, mo_ta=?, thoi_gian=?, chi_phi=?, hinh_anh=? WHERE id_khoahoc=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('ssiisi', $ten_khoahoc, $mo_ta, $thoi_gian, $chi_phi, $hinh_anh_moi, $id_khoahoc);
    
    if($stmt->execute()){
        $response['status'] = 'success';
        $response['message'] = 'Cập nhật khóa học thành công!';
    } else {
        $response['message'] = 'Lỗi CSDL khi cập nhật.';
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>