<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieu_de = $_POST['tieu_de'];
    $noi_dung = $_POST['noi_dung'];
    $id_khoahoc_form = $_POST['id_khoahoc'];
    $id_lop = $_POST['id_lop'];

    // Lấy thời gian hiện tại một lần duy nhất
    $current_datetime = date('Y-m-d H:i:s');

    $conn->begin_transaction();
    try {
        if ($id_lop !== 'all') {
            // Ưu tiên gửi cho một lớp cụ thể
            $sql = "INSERT INTO thongbao (id_hocvien, tieu_de, noi_dung, ngay_tao, trang_thai)
                    SELECT id_hocvien, ?, ?, ?, 'chưa đọc' 
                    FROM dangkykhoahoc 
                    WHERE id_lop = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $tieu_de, $noi_dung, $current_datetime, $id_lop);

        } elseif ($id_khoahoc_form !== 'all') {
            // Gửi cho một khóa học cụ thể
            $id_khoahoc = (int)$id_khoahoc_form;
            $sql = "INSERT INTO thongbao (id_hocvien, id_khoahoc, tieu_de, noi_dung, ngay_tao, trang_thai)
                    SELECT dk.id_hocvien, ?, ?, ?, ?, 'chưa đọc' 
                    FROM dangkykhoahoc dk 
                    WHERE dk.id_khoahoc = ?";
            $stmt = $conn->prepare($sql);
            // Sửa lại bind_param: id_khoahoc, tieu_de, noi_dung, ngay_tao, id_khoahoc (cho WHERE)
            $stmt->bind_param("isssi", $id_khoahoc, $tieu_de, $noi_dung, $current_datetime, $id_khoahoc);
            
        } else {
            // Gửi cho tất cả học viên
            $sql = "INSERT INTO thongbao (id_hocvien, tieu_de, noi_dung, ngay_tao, trang_thai)
                    SELECT id_hocvien, ?, ?, ?, 'chưa đọc' 
                    FROM hocvien";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $tieu_de, $noi_dung, $current_datetime);
        }

        $stmt->execute();
        $conn->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Đã gửi thông báo thành công!'];

    } catch (Exception $e) {
        $conn->rollback();
        // Ghi lại lỗi chi tiết hơn
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi gửi thông báo: ' . $e->getMessage()];
    }

    header('Location: ../../admin.php?nav=thongbao');
    exit();
}
?>