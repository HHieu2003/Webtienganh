<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_khoahoc = (int)($_POST['id_khoahoc'] ?? 0);
    $ten_khoahoc = $_POST['ten_khoahoc'] ?? '';
    $mo_ta = $_POST['mo_ta'] ?? '';
    $cap_do = $_POST['cap_do'] ?? NULL; // Thêm dòng này
    $thoi_gian = !empty($_POST['thoi_gian']) ? (int)$_POST['thoi_gian'] : NULL;
    $chi_phi = (int)($_POST['chi_phi'] ?? 0);
    $hinh_anh_hien_tai = $_POST['hinh_anh_hien_tai'] ?? ''; // Giữ lại tên file ảnh hiện tại

    if ($id_khoahoc === 0 || empty($ten_khoahoc) || $chi_phi <= 0) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }

    $hinh_anh_moi = $hinh_anh_hien_tai; // Mặc định giữ ảnh cũ
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        // Xóa ảnh cũ nếu có và khác ảnh mặc định (nếu bạn có ảnh mặc định)
        if (!empty($hinh_anh_hien_tai) && file_exists($target_dir . basename($hinh_anh_hien_tai))) {
             // Cẩn thận: Chỉ xóa nếu file tồn tại trong thư mục uploads/
             unlink($target_dir . basename($hinh_anh_hien_tai));
        }

        $file_name = time() . '_' . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh_moi = 'uploads/' . $file_name; // Đường dẫn tương đối mới
        } else {
            // Có thể thông báo lỗi nhưng vẫn tiếp tục cập nhật thông tin khác
             $response['warning'] = 'Không thể tải ảnh mới lên, giữ lại ảnh cũ.';
             $hinh_anh_moi = $hinh_anh_hien_tai; // Đảm bảo giữ lại ảnh cũ nếu upload lỗi
        }
    }

    // Cập nhật câu lệnh SQL để bao gồm cap_do
    $sql_update = "UPDATE khoahoc SET ten_khoahoc = ?, mo_ta = ?, cap_do = ?, thoi_gian = ?, chi_phi = ?, hinh_anh = ? WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        // Cập nhật bind_param: Thêm 's' cho cap_do, 'i' cho id_khoahoc cuối cùng
        $stmt->bind_param("sssidsi", $ten_khoahoc, $mo_ta, $cap_do, $thoi_gian, $chi_phi, $hinh_anh_moi, $id_khoahoc);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Cập nhật khóa học thành công!';
             if(isset($response['warning'])) { // Gửi kèm cảnh báo nếu có
                 $response['message'] .= ' ' . $response['warning'];
             }
        } else {
            $response['message'] = 'Lỗi khi cập nhật khóa học: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Lỗi chuẩn bị câu lệnh SQL: ' . $conn->error;
    }
}

$conn->close();
echo json_encode($response);
?>