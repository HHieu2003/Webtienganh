<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['id_lop'];
    $diemDanhData = $_POST['diemdanh'] ?? [];

    $conn->begin_transaction();
    try {
        // Lấy id_khoahoc từ id_lop
        $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
        $stmt_kh->bind_param("s", $id_lop);
        $stmt_kh->execute();
        $id_khoahoc = $stmt_kh->get_result()->fetch_assoc()['id_khoahoc'];
        $stmt_kh->close();

        // Chuẩn bị câu lệnh "INSERT... ON DUPLICATE KEY UPDATE..."
        // Nhờ có UNIQUE KEY ở Bước 1, câu lệnh này sẽ tự động UPDATE nếu bản ghi đã tồn tại
        $stmt_upsert = $conn->prepare(
            "INSERT INTO diem_danh (id_hocvien, id_lop, id_lichhoc, trang_thai, ngay_diemdanh)
             VALUES (?, ?, ?, ?, CURDATE())
             ON DUPLICATE KEY UPDATE trang_thai = VALUES(trang_thai), ngay_diemdanh = CURDATE()"
        );

        // Chuẩn bị câu lệnh cập nhật tiến độ
        $stmt_update_progress = $conn->prepare(
            "UPDATE tien_do_hoc_tap SET so_buoi_da_tham_gia = ? WHERE id_hocvien = ? AND id_khoahoc = ?"
        );
        
        // Chuẩn bị câu lệnh đếm số buổi có mặt
        $stmt_count_present = $conn->prepare(
            "SELECT COUNT(*) as total_present FROM diem_danh WHERE id_hocvien = ? AND id_lop = ? AND trang_thai = 'co mat'"
        );

        // Duyệt qua từng học viên được gửi dữ liệu lên
        foreach ($diemDanhData as $id_hocvien => $buoiHocData) {
            
            // 1. Cập nhật hoặc Thêm mới điểm danh cho từng buổi
            foreach ($buoiHocData as $id_lichhoc => $trang_thai) {
                $stmt_upsert->bind_param("isss", $id_hocvien, $id_lop, $id_lichhoc, $trang_thai);
                $stmt_upsert->execute();
            }

            // 2. Đếm lại tổng số buổi có mặt của học viên trong lớp này từ CSDL để đảm bảo chính xác
            $stmt_count_present->bind_param("is", $id_hocvien, $id_lop);
            $stmt_count_present->execute();
            $soBuoiCoMat = $stmt_count_present->get_result()->fetch_assoc()['total_present'] ?? 0;
            
            // 3. Cập nhật lại tổng số buổi đã tham gia cho học viên đó
            $stmt_update_progress->bind_param("iii", $soBuoiCoMat, $id_hocvien, $id_khoahoc);
            $stmt_update_progress->execute();
        }
        
        $stmt_count_present->close(); // Đóng câu lệnh sau khi dùng xong

        // Hoàn tất giao dịch
        $conn->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Lưu điểm danh thành công!'];

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi lưu điểm danh: ' . $e->getMessage()];
    }

    // Chuyển hướng về trang điểm danh
    header("Location: ../../admin.php?nav=lichhoc&lop_id=$id_lop&view=diemdanh");
    exit();
}
?>