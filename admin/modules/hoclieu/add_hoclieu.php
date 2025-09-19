<?php
// File: admin/modules/hoclieu/add_hoclieu.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_khoahoc = !empty($_POST['id_khoahoc_modal']) ? (int)$_POST['id_khoahoc_modal'] : null;
    $id_lop = !empty($_POST['id_lop']) ? $_POST['id_lop'] : null;
    $tieu_de = $_POST['tieu_de'] ?? '';

    if (empty($id_khoahoc) || empty($tieu_de)) {
        $response['message'] = 'Vui lòng chọn khóa học và nhập tiêu đề.';
        echo json_encode($response);
        exit;
    }

    if (isset($_FILES['hoc_lieu_file']) && $_FILES['hoc_lieu_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['hoc_lieu_file'];
        $file_name = time() . '_' . basename($file['name']);
        $file_type = strtoupper(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $target_dir = "../../../uploads/materials/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $duong_dan_file = 'uploads/materials/' . $file_name;
            
            // Nếu id_lop được chọn, id_khoahoc trong bảng hoc_lieu sẽ là NULL
            $sql_id_khoahoc = $id_lop ? NULL : $id_khoahoc;

            $sql = "INSERT INTO hoc_lieu (id_khoahoc, id_lop, tieu_de, loai_file, duong_dan_file, ngay_dang) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issss", $sql_id_khoahoc, $id_lop, $tieu_de, $file_type, $duong_dan_file);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Tải lên học liệu thành công!';
            } else {
                $response['message'] = 'Lỗi CSDL khi lưu thông tin.';
                unlink($target_file);
            }
        } else {
             $response['message'] = 'Không thể di chuyển file đã tải lên.';
        }
    } else {
        $response['message'] = 'Có lỗi xảy ra khi tải file lên hoặc không có file nào được chọn.';
    }
}

echo json_encode($response);
$conn->close();
?>