<?php
include('../../../config/config.php');

try {
    // Kích hoạt chế độ báo cáo lỗi dưới dạng ngoại lệ cho MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Xử lý thêm lớp học
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
        $ten_lop = $_POST['ten_lop'];
        $id_khoahoc = $_POST['id_khoahoc'];
        $trang_thai = $_POST['trang_thai'];
        $id_lop = $_POST['id_lop'];
        $giang_vien = $_POST['giang_vien'];


        // Chuẩn bị câu lệnh SQL
        $sql_insert = "INSERT INTO lop_hoc (id_lop, ten_lop, id_khoahoc,giang_vien, trang_thai) 
                       VALUES (?, ?, ?,?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt, 'sssss', $id_lop, $ten_lop, $id_khoahoc, $giang_vien, $trang_thai);

        // Thực thi câu lệnh
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../../admin.php?nav=lichhoc');
            exit(); // Dừng xử lý sau khi chuyển hướng
        }
    }
} catch (mysqli_sql_exception $e) {
    // Hiển thị lỗi bằng alert
    $error_message = $e->getMessage();
    echo "<script>alert('Lỗi: $error_message');</script>";
    header('Location: ../../admin.php?nav=lichhoc');

} finally {
    // Đóng kết nối và giải phóng tài nguyên
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
