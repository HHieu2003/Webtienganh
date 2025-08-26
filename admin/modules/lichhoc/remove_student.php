<?php
include('../../../config/config.php');

// Xử lý xóa học viên
if (isset($_GET['delete_student_id'])) {
    $id_hocvien = $_GET['delete_student_id'];
    $lop_id = $_GET['lop_id'];
    // Xóa học viên khỏi lớp học
    $sql_delete = "update dangkykhoahoc SET id_lop = NULL WHERE id_hocvien = ? AND id_lop = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, 'ss', $id_hocvien, $lop_id);

    if (mysqli_stmt_execute($stmt_delete)) {
         // Xóa tiến độ học tập của học viên trong bảng `tien_do_hoc_tap`
         $sql_delete_progress = "DELETE FROM tien_do_hoc_tap WHERE id_hocvien = ? AND id_khoahoc = (
            SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?
        )";
        $stmt_delete_progress = mysqli_prepare($conn, $sql_delete_progress);
        mysqli_stmt_bind_param($stmt_delete_progress, 'ss', $id_hocvien, $lop_id);
        mysqli_stmt_execute($stmt_delete_progress);
    
        header("Location: ../../admin.php?nav=lichhoc&lop_id=$lop_id&view=students");
        
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
    }
}
?>
