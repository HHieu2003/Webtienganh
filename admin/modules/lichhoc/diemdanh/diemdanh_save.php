<?php
// File: admin/modules/lichhoc/diemdanh/diemdanh_save.php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['id_lop'];
    $diemDanhData = $_POST['diemdanh'] ?? [];

    if (empty($diemDanhData)) {
        $response['message'] = 'Không có dữ liệu điểm danh để lưu.';
        echo json_encode($response);
        exit;
    }

    $conn->begin_transaction();
    try {
        $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
        $stmt_kh->bind_param("s", $id_lop);
        $stmt_kh->execute();
        $id_khoahoc_result = $stmt_kh->get_result();
        if ($id_khoahoc_result->num_rows === 0) {
            throw new Exception("Không tìm thấy khóa học cho lớp này.");
        }
        $id_khoahoc = $id_khoahoc_result->fetch_assoc()['id_khoahoc'];
        $stmt_kh->close();

        $stmt_upsert = $conn->prepare(
            "INSERT INTO diem_danh (id_hocvien, id_lop, id_lichhoc, trang_thai, ngay_diemdanh)
             VALUES (?, ?, ?, ?, CURDATE())
             ON DUPLICATE KEY UPDATE trang_thai = VALUES(trang_thai), ngay_diemdanh = CURDATE()"
        );
        
        $stmt_update_progress = $conn->prepare(
            "UPDATE tien_do_hoc_tap SET so_buoi_da_tham_gia = ? WHERE id_hocvien = ? AND id_khoahoc = ?"
        );
        
        $stmt_count_present = $conn->prepare(
            "SELECT COUNT(*) as total_present FROM diem_danh WHERE id_hocvien = ? AND id_lop = ? AND trang_thai = 'co mat'"
        );

        foreach ($diemDanhData as $id_hocvien => $buoiHocData) {
            foreach ($buoiHocData as $id_lichhoc => $trang_thai) {
                $stmt_upsert->bind_param("isss", $id_hocvien, $id_lop, $id_lichhoc, $trang_thai);
                $stmt_upsert->execute();
            }

            $stmt_count_present->bind_param("is", $id_hocvien, $id_lop);
            $stmt_count_present->execute();
            $soBuoiCoMat = $stmt_count_present->get_result()->fetch_assoc()['total_present'] ?? 0;
            
            $stmt_update_progress->bind_param("iii", $soBuoiCoMat, $id_hocvien, $id_khoahoc);
            $stmt_update_progress->execute();
        }
        
        $stmt_upsert->close();
        $stmt_update_progress->close();
        $stmt_count_present->close();

        $conn->commit();
        $response['status'] = 'success';
        $response['message'] = 'Lưu điểm danh thành công!';

    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = 'Lỗi khi lưu điểm danh: ' . $e->getMessage();
    }
}

echo json_encode($response);
$conn->close();
?>