<?php
// File: admin/modules/teacher/teacher_delete_notification.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_giangvien'])) {
    echo json_encode($response);
    exit();
}

$id_giangvien = $_SESSION['id_giangvien'];
$data = json_decode(file_get_contents('php://input'), true);
$tieu_de = $data['tieu_de'] ?? '';
$id_lop = $data['id_lop'] ?? '';
$ngay_tao = $data['ngay_tao'] ?? '';

if (empty($tieu_de) || empty($id_lop) || empty($ngay_tao)) {
    $response['message'] = 'Dữ liệu không hợp lệ.';
    echo json_encode($response);
    exit;
}

// BẢO MẬT: Xác thực giảng viên có quyền xóa thông báo của lớp này
$stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
$stmt_check->bind_param("si", $id_lop, $id_giangvien);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows === 0) {
    $response['message'] = 'Lỗi: Bạn không có quyền xóa thông báo của lớp học này.';
    echo json_encode($response);
    exit();
}
$stmt_check->close();

// Nếu đã xác thực, tiến hành xóa
$sql = "DELETE FROM thongbao WHERE tieu_de = ? AND id_lop = ? AND ngay_tao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $tieu_de, $id_lop, $ngay_tao);

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Đã xóa nhóm thông báo thành công!';
} else {
    $response['message'] = 'Lỗi CSDL khi xóa thông báo.';
}
$stmt->close();

echo json_encode($response);
$conn->close();
?>