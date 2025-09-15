<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $id_lop = $_POST['id_lop'];
    $id_hocvien_to_add = (int)$_POST['id_hocvien'];

    // Lấy id_khoahoc từ id_lop
    $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
    $stmt_kh->bind_param('s', $id_lop);
    $stmt_kh->execute();
    $id_khoahoc = $stmt_kh->get_result()->fetch_assoc()['id_khoahoc'];
    $stmt_kh->close();

    // Cập nhật bản ghi đăng ký của học viên để gán họ vào lớp này
    $sql_add = "UPDATE dangkykhoahoc SET id_lop = ? WHERE id_hocvien = ? AND id_khoahoc = ?";
    $stmt_add = $conn->prepare($sql_add);
    $stmt_add->bind_param('sii', $id_lop, $id_hocvien_to_add, $id_khoahoc);

    if ($stmt_add->execute() && $stmt_add->affected_rows > 0) {
        // Thêm bản ghi tiến độ học tập cho học viên
        $total_sessions = $conn->query("SELECT COUNT(*) as total FROM lichhoc WHERE id_lop = '$id_lop'")->fetch_assoc()['total'] ?? 0;
        $sql_progress = "INSERT INTO tien_do_hoc_tap (id_hocvien, id_khoahoc, tong_so_buoi) VALUES (?, ?, ?)";
        $stmt_progress = $conn->prepare($sql_progress);
        $stmt_progress->bind_param("iii", $id_hocvien_to_add, $id_khoahoc, $total_sessions);
        $stmt_progress->execute();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm học viên vào lớp thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Không thể thêm học viên.'];
    }
}
header("Location: ../../admin.php?nav=lichhoc&lop_id=$id_lop&view=students");
exit();
?>