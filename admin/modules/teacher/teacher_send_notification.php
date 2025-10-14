<?php
// File: admin/modules/teacher/teacher_send_notification.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_giangvien'])) {
    echo json_encode($response);
    exit();
}

$id_giangvien = $_SESSION['id_giangvien'];
$id_lop = $_POST['id_lop'] ?? '';
$tieu_de = trim($_POST['tieu_de'] ?? '');
$noi_dung = trim($_POST['noi_dung'] ?? '');

if (empty($id_lop) || empty($tieu_de) || empty($noi_dung)) {
    $response['message'] = 'Vui lòng chọn lớp, nhập tiêu đề và nội dung thông báo.';
    echo json_encode($response);
    exit;
}

// BẢO MẬT: Xác thực giảng viên có quyền gửi thông báo cho lớp này
$stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
$stmt_check->bind_param("si", $id_lop, $id_giangvien);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows === 0) {
    $response['message'] = 'Lỗi: Bạn không có quyền gửi thông báo cho lớp học này.';
    echo json_encode($response);
    exit();
}
$stmt_check->close();

$conn->begin_transaction();
try {
    // Chèn thông báo cho tất cả học viên thuộc lớp đã chọn
    $sql_insert = "
        INSERT INTO thongbao (id_hocvien, id_lop, tieu_de, noi_dung, ngay_tao, trang_thai)
        SELECT id_hocvien, ?, ?, ?, NOW(), 'chưa đọc' 
        FROM dangkykhoahoc 
        WHERE id_lop = ?
    ";
    
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssss", $id_lop, $tieu_de, $noi_dung, $id_lop);
    $stmt->execute();
    
    $affected_rows = $stmt->affected_rows;
    $conn->commit();
    
    $response['status'] = 'success';
    $response['message'] = 'Đã gửi thông báo đến ' . $affected_rows . ' học viên thành công!';

} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = 'Lỗi hệ thống khi gửi thông báo: ' . $e->getMessage();
}

echo json_encode($response);
$conn->close();
?>