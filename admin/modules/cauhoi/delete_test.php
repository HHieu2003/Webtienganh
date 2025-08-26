<?php
include('../../../config/config.php');

try {
    // Kiểm tra xem id_baitest có được truyền qua URL không
    if (!isset($_GET['id_baitest'])) {
        throw new Exception("ID bài test không được cung cấp.");
    }

    $id_baitest = (int)$_GET['id_baitest'];

    // Kiểm tra bài test có tồn tại không
    $sql_check = "SELECT id_baitest FROM baitest WHERE id_baitest = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    if (!$stmt_check) {
        throw new Exception("Lỗi khi chuẩn bị truy vấn kiểm tra: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt_check, 'i', $id_baitest);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) === 0) {
        throw new Exception("Bài test không tồn tại hoặc đã bị xóa.");
    }

    // Xóa bài test
    $sql_delete = "DELETE FROM baitest WHERE id_baitest = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    if (!$stmt_delete) {
        throw new Exception("Lỗi khi chuẩn bị truy vấn xóa: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt_delete, 'i', $id_baitest);

    if (mysqli_stmt_execute($stmt_delete)) {
        // Chuyển hướng về danh sách bài test với thông báo thành công
        header("Location: ../../admin.php?nav=question&status=delete_success");
        exit();
    } else {
        throw new Exception("Lỗi khi xóa bài test: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    // Xử lý lỗi và chuyển hướng với thông báo lỗi
    error_log("Lỗi: " . $e->getMessage());
    header("Location: ../../admin.php?nav=question&status=delete_error&message=" . urlencode($e->getMessage()));
    exit();
} finally {
    mysqli_close($conn);
}
?>
