<?php
// File: admin/modules/lichhoc/diemso/save_single_comment.php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

// --- Bảo mật: Kiểm tra quyền truy cập ---
$is_admin = $_SESSION['is_admin'] ?? false;
$is_teacher = $_SESSION['is_teacher'] ?? false;
if (!$is_admin && !$is_teacher) {
    $response['message'] = 'Bạn không có quyền thực hiện hành động này.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lop = $_POST['id_lop'] ?? '';
    $id_hocvien = (int)($_POST['id_hocvien'] ?? 0);
    $loai_diem = $_POST['loai_diem'] ?? '';
    $nhan_xet = $_POST['nhan_xet'] ?? '';

    if (empty($id_lop) || $id_hocvien === 0 || empty($loai_diem)) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }

    // --- Bảo mật: Nếu là giảng viên, kiểm tra quyền sở hữu lớp ---
    if ($is_teacher && !$is_admin) {
        $id_giangvien_session = $_SESSION['id_giangvien'];
        $stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
        $stmt_check->bind_param("si", $id_lop, $id_giangvien_session);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows === 0) {
            $response['message'] = 'Lỗi: Bạn không có quyền thao tác trên lớp này.';
            echo json_encode($response);
            exit();
        }
        $stmt_check->close();
    }

    // --- Xử lý lưu vào CSDL ---
    // Sử dụng ON DUPLICATE KEY UPDATE để chèn mới hoặc cập nhật nếu đã có
    $sql = "INSERT INTO diem_so (id_hocvien, id_lop, loai_diem, nhan_xet, ngay_nhap_diem) 
            VALUES (?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE nhan_xet = VALUES(nhan_xet), ngay_nhap_diem = NOW()";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id_hocvien, $id_lop, $loai_diem, $nhan_xet);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Đã lưu nhận xét!';
    } else {
        $response['message'] = 'Lỗi CSDL: ' . $stmt->error;
    }
    $stmt->close();
}

echo json_encode($response);
$conn->close();
?>