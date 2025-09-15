<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $id_lop = $_POST['id_lop'];
    $ten_lop = $_POST['ten_lop'];
    $id_khoahoc = $_POST['id_khoahoc'];
    $trang_thai = $_POST['trang_thai'];
    
    // Lấy id_giangvien, có thể là NULL nếu không chọn
    $id_giangvien = !empty($_POST['id_giangvien']) ? (int)$_POST['id_giangvien'] : NULL;

    // Kiểm tra ID lớp đã tồn tại chưa
    $check_stmt = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ?");
    $check_stmt->bind_param("s", $id_lop);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: ID lớp học "' . $id_lop . '" đã tồn tại!'];
    } else {
        $sql_insert = "INSERT INTO lop_hoc (id_lop, ten_lop, id_khoahoc, id_giangvien, trang_thai) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param('ssiis', $id_lop, $ten_lop, $id_khoahoc, $id_giangvien, $trang_thai);

        if ($stmt->execute()) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm lớp học thành công!'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi thêm lớp học: ' . $stmt->error];
        }
    }
}
header('Location: ../../admin.php?nav=lichhoc');
exit();
?>