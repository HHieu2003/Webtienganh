<?php
include('../../../config/config.php');
session_start();

if (isset($_GET['student_id']) && isset($_GET['lop_id'])) {
    $id_hocvien = (int)$_GET['student_id'];
    $lop_id = $_GET['lop_id'];

    $conn->begin_transaction();
    try {
        // 1. Gỡ học viên khỏi lớp (đưa về trạng thái chờ xếp lớp)
        $sql_remove = "UPDATE dangkykhoahoc SET id_lop = NULL WHERE id_hocvien = ? AND id_lop = ?";
        $stmt_remove = $conn->prepare($sql_remove);
        $stmt_remove->bind_param('is', $id_hocvien, $lop_id);
        $stmt_remove->execute();

        // 2. Xóa tiến độ học tập và điểm danh liên quan đến lớp này
        $sql_delete_progress = "DELETE FROM tien_do_hoc_tap 
                                WHERE id_hocvien = ? AND id_khoahoc = (SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?)";
        $stmt_progress = $conn->prepare($sql_delete_progress);
        $stmt_progress->bind_param('is', $id_hocvien, $lop_id);
        $stmt_progress->execute();
        
        $sql_delete_attendance = "DELETE FROM diem_danh WHERE id_hocvien = ? AND id_lop = ?";
        $stmt_attendance = $conn->prepare($sql_delete_attendance);
        $stmt_attendance->bind_param('is', $id_hocvien, $lop_id);
        $stmt_attendance->execute();

        $conn->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Đã xóa học viên khỏi lớp thành công!'];

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi xóa học viên: ' . $e->getMessage()];
    }

    header("Location: ../../admin.php?nav=lichhoc&lop_id=$lop_id&view=students");
    exit();
}
?>