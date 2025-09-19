<?php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['id_lop'] ?? '';
    $id_hocvien_list = $_POST['id_hocvien_list'] ?? [];
    
    if (empty($id_lop) || empty($id_hocvien_list)) {
        $response['message'] = 'Vui lòng chọn lớp và ít nhất một học viên.';
        echo json_encode($response);
        exit;
    }

    $conn->begin_transaction();
    $success_count = 0; $error_count = 0;
    try {
        $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
        $stmt_kh->bind_param('s', $id_lop);
        $stmt_kh->execute();
        $id_khoahoc_result = $stmt_kh->get_result();

        if ($id_khoahoc_result->num_rows === 0) throw new Exception("Lớp học không tồn tại.");
        $id_khoahoc = $id_khoahoc_result->fetch_assoc()['id_khoahoc'];
        $stmt_kh->close();
        
        foreach ($id_hocvien_list as $id_hocvien_to_add) {
            $id_hocvien_to_add = (int)$id_hocvien_to_add;
            $sql_add = "UPDATE dangkykhoahoc SET id_lop = ? WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'da xac nhan' AND id_lop IS NULL";
            $stmt_add = $conn->prepare($sql_add);
            $stmt_add->bind_param('sii', $id_lop, $id_hocvien_to_add, $id_khoahoc);
            $stmt_add->execute();
            if ($stmt_add->affected_rows > 0) $success_count++;
            else $error_count++;
            $stmt_add->close();
        }
        $conn->commit();
        $response['status'] = 'success';
        $response['message'] = "Thêm thành công $success_count học viên. Có $error_count học viên không thể thêm (có thể đã ở trong lớp khác).";
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = 'Lỗi hệ thống: ' . $e->getMessage();
    }
}
echo json_encode($response);
$conn->close();
?>