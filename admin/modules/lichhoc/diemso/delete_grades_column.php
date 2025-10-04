<?php
// File: admin/modules/lichhoc/diemso/delete_grades_column.php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

$is_admin = $_SESSION['is_admin'] ?? false;
$is_teacher = $_SESSION['is_teacher'] ?? false;

if (!$is_admin && !$is_teacher) {
    $response['message'] = 'Bạn không có quyền thực hiện hành động này.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_lop = $data['id_lop'] ?? '';
    $loai_diem = $data['loai_diem'] ?? '';

    if (empty($id_lop) || empty($loai_diem)) {
        $response['message'] = 'Dữ liệu không hợp lệ khi yêu cầu xóa.';
        echo json_encode($response);
        exit;
    }

    if ($is_teacher && !$is_admin) {
        $id_giangvien_session = $_SESSION['id_giangvien'];
        $stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
        $stmt_check->bind_param("si", $id_lop, $id_giangvien_session);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows === 0) {
            $response['message'] = 'Lỗi: Bạn không có quyền xóa cột điểm của lớp này.';
            echo json_encode($response);
            exit();
        }
        $stmt_check->close();
    }

    $sql = "DELETE FROM diem_so WHERE id_lop = ? AND loai_diem = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id_lop, $loai_diem);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Xóa cột điểm thành công!';
    } else {
        $response['message'] = 'Lỗi CSDL khi xóa cột điểm.';
    }
    $stmt->close();
}

echo json_encode($response);
$conn->close();
?>