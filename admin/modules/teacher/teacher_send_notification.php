<?php
// File: admin/modules/teacher_send_notification.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

// --- KIỂM TRA ĐIỀU KIỆN BAN ĐẦU ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_giangvien'])) {
    echo json_encode($response);
    exit();
}

$id_giangvien = $_SESSION['id_giangvien'];
$id_lop = $_POST['id_lop'] ?? '';
$tieu_de = $_POST['tieu_de'] ?? '';
$noi_dung = $_POST['noi_dung'] ?? '';

// --- VALIDATE DỮ LIỆU ---
if (empty($id_lop) || empty($tieu_de) || empty($noi_dung)) {
    $response['message'] = 'Vui lòng chọn lớp, nhập tiêu đề và nội dung thông báo.';
    echo json_encode($response);
    exit;
}

// ================================================================
// === BẢO MẬT: XÁC THỰC GIẢNG VIÊN CÓ QUYỀN GỬI THÔNG BÁO CHO LỚP NÀY ===
// ================================================================
$stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
$stmt_check->bind_param("si", $id_lop, $id_giangvien);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows === 0) {
    $response['message'] = 'Lỗi: Bạn không có quyền gửi thông báo cho lớp học này.';
    echo json_encode($response);
    exit();
}
$stmt_check->close();
// ================================================================

$conn->begin_transaction();
try {
    // Câu lệnh SQL để chèn thông báo cho tất cả học viên thuộc lớp đã chọn
    $sql_insert = "
        INSERT INTO thongbao (id_hocvien, id_lop, tieu_de, noi_dung, ngay_tao, trang_thai)
        SELECT id_hocvien, ?, ?, ?, NOW(), 'chưa đọc' 
        FROM dangkykhoahoc 
        WHERE id_lop = ?
    ";
    
    $stmt = $conn->prepare($sql_insert);
    // Gán 4 giá trị vào các dấu ?
    $stmt->bind_param("ssss", $id_lop, $tieu_de, $noi_dung, $id_lop);

    $stmt->execute();
    
    $conn->commit();
    $response['status'] = 'success';
    $response['message'] = 'Đã gửi thông báo đến ' . $stmt->affected_rows . ' học viên thành công!';

} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = 'Lỗi hệ thống khi gửi thông báo: ' . $e->getMessage();
}

echo json_encode($response);
$conn->close();
?>