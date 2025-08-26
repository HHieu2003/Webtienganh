<?php
include('../../../config/config.php');

// Enable MySQLi exception reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    if (isset($_GET['delete_lop_id'])) {
        $delete_lop_id = $_GET['delete_lop_id'];

        // Kiểm tra xem lớp học có tồn tại không
        $sql_check = "SELECT * FROM lop_hoc WHERE id_lop = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, 's', $delete_lop_id);
        mysqli_stmt_execute($stmt_check);
        $lop = mysqli_stmt_get_result($stmt_check)->fetch_assoc();

        if ($lop) {
            // Xóa lớp học
            $sql_delete = "DELETE FROM lop_hoc WHERE id_lop = ?";
            $stmt_delete = mysqli_prepare($conn, $sql_delete);
            mysqli_stmt_bind_param($stmt_delete, 's', $delete_lop_id);
            if (mysqli_stmt_execute($stmt_delete)) {
                header('Location: ../../admin.php?nav=lichhoc');
                exit;
            } else {
                throw new Exception('Unable to delete the class');
            }
        } else {
            throw new Exception('Class not found');
        }
    }
} catch (Exception $e) {
    // Handle error: display a message or log the error
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
         window.location.href='../../admin.php?nav=lichhoc';
    </script>";
}
?>
