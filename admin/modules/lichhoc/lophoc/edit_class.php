<?php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['edit_id_lop'] ?? '';
    $ten_lop = $_POST['edit_ten_lop'] ?? '';
    $id_giangvien = !empty($_POST['edit_id_giangvien']) ? (int)$_POST['edit_id_giangvien'] : NULL;
    $trang_thai = $_POST['edit_trang_thai'] ?? 'dang hoc';

    if(empty($id_lop) || empty($ten_lop)) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }

    $sql = "UPDATE lop_hoc SET ten_lop = ?, id_giangvien = ?, trang_thai = ? WHERE id_lop = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $ten_lop, $id_giangvien, $trang_thai, $id_lop);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Cập nhật lớp học thành công!';
    } else {
        $response['message'] = 'Lỗi khi cập nhật lớp học.';
    }
    $stmt->close();
}
echo json_encode($response);
$conn->close();
?>