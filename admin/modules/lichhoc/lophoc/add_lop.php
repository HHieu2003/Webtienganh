<?php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['id_lop'] ?? '';
    $ten_lop = $_POST['ten_lop'] ?? '';
    $id_khoahoc = $_POST['id_khoahoc'] ?? 0;
    $trang_thai = $_POST['trang_thai'] ?? 'dang hoc';
    $id_giangvien = !empty($_POST['id_giangvien']) ? (int)$_POST['id_giangvien'] : NULL;

    if(empty($id_lop) || empty($ten_lop) || empty($id_khoahoc)) {
        $response['message'] = 'Vui lòng điền đầy đủ các trường bắt buộc.';
        echo json_encode($response);
        exit;
    }

    $check_stmt = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ?");
    $check_stmt->bind_param("s", $id_lop);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        $response['message'] = 'Lỗi: ID lớp học "' . htmlspecialchars($id_lop) . '" đã tồn tại!';
    } else {
        $sql_insert = "INSERT INTO lop_hoc (id_lop, ten_lop, id_khoahoc, id_giangvien, trang_thai) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param('ssiis', $id_lop, $ten_lop, $id_khoahoc, $id_giangvien, $trang_thai);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Thêm lớp học thành công!';
        } else {
            $response['message'] = 'Lỗi khi thêm lớp học: ' . $stmt->error;
        }
    }
}
echo json_encode($response);
$conn->close();
?>