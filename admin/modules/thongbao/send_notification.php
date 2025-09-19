<?php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieu_de = $_POST['tieu_de'] ?? '';
    $noi_dung = $_POST['noi_dung'] ?? '';
    $id_khoahoc_form = $_POST['id_khoahoc'] ?? 'all';
    $id_lop_form = $_POST['id_lop'] ?? 'all';
    $current_datetime = date('Y-m-d H:i:s');

    if (empty($tieu_de) || empty($noi_dung)) {
        $response['message'] = 'Tiêu đề và nội dung không được để trống.';
        echo json_encode($response);
        exit;
    }

    $conn->begin_transaction();
    try {
        $id_khoahoc_db = ($id_khoahoc_form !== 'all') ? (int)$id_khoahoc_form : NULL;
        $id_lop_db = ($id_lop_form !== 'all') ? $id_lop_form : NULL;

        if ($id_lop_form !== 'all') {
            // Ưu tiên gửi cho một lớp cụ thể
            $sql = "INSERT INTO thongbao (id_hocvien, id_lop, tieu_de, noi_dung, ngay_tao, trang_thai)
                    SELECT id_hocvien, ?, ?, ?, ?, 'chưa đọc' 
                    FROM dangkykhoahoc 
                    WHERE id_lop = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $id_lop_db, $tieu_de, $noi_dung, $current_datetime, $id_lop_db);

        } elseif ($id_khoahoc_form !== 'all') {
            // Gửi cho một khóa học cụ thể
            $sql = "INSERT INTO thongbao (id_hocvien, id_khoahoc, tieu_de, noi_dung, ngay_tao, trang_thai)
                    SELECT dk.id_hocvien, ?, ?, ?, ?, 'chưa đọc' 
                    FROM dangkykhoahoc dk 
                    WHERE dk.id_khoahoc = ? AND dk.trang_thai = 'da xac nhan'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssi", $id_khoahoc_db, $tieu_de, $noi_dung, $current_datetime, $id_khoahoc_db);
            
        } else {
            // Gửi cho tất cả học viên
            $sql = "INSERT INTO thongbao (id_hocvien, tieu_de, noi_dung, ngay_tao, trang_thai)
                    SELECT id_hocvien, ?, ?, ?, 'chưa đọc' 
                    FROM hocvien WHERE is_admin = 0"; // Chỉ gửi cho học viên, không gửi cho admin
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $tieu_de, $noi_dung, $current_datetime);
        }

        $stmt->execute();
        $conn->commit();
        $response['status'] = 'success';
        $response['message'] = 'Đã gửi thông báo thành công!';

    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = 'Lỗi khi gửi thông báo: ' . $e->getMessage();
    }
    
}

echo json_encode($response);
$conn->close();
?>