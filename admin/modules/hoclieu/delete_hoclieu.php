<?php
// File: admin/modules/hoclieu/delete_hoclieu.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

// Xác định vai trò người dùng
$is_admin = $_SESSION['is_admin'] ?? false;
$is_teacher = $_SESSION['is_teacher'] ?? false;
$id_giangvien = $_SESSION['id_giangvien'] ?? null;

// Chỉ cho phép admin hoặc giảng viên thực hiện
if (!$is_admin && !$is_teacher) {
    $response['message'] = 'Bạn không có quyền thực hiện hành động này.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_hoclieu = (int)($data['id_hoclieu'] ?? 0);

    if ($id_hoclieu > 0) {
        $conn->begin_transaction();
        try {
            // Lấy đường dẫn file và thông tin chủ sở hữu (nếu là giảng viên)
            $sql_get = "
                SELECT hl.duong_dan_file, lh.id_giangvien
                FROM hoc_lieu hl
                LEFT JOIN lop_hoc lh ON hl.id_lop = lh.id_lop
                WHERE hl.id_hoclieu = ?
            ";
            $stmt_get = $conn->prepare($sql_get);
            $stmt_get->bind_param("i", $id_hoclieu);
            $stmt_get->execute();
            $result = $stmt_get->get_result();
            $material_info = $result->fetch_assoc();
            $stmt_get->close();

            if ($material_info) {
                // KIỂM TRA QUYỀN SỞ HỮU NẾU LÀ GIẢNG VIÊN
                if ($is_teacher && !$is_admin && $material_info['id_giangvien'] != $id_giangvien) {
                    throw new Exception('Bạn không có quyền xóa học liệu không thuộc lớp của mình.');
                }

                // Tiến hành xóa file vật lý
                $file_path_db = $material_info['duong_dan_file'];
                if ($file_path_db) {
                    $full_file_path = '../../../' . $file_path_db;
                    if (file_exists($full_file_path)) {
                        unlink($full_file_path);
                    }
                }
                
                // Xóa bản ghi trong CSDL
                $stmt_delete = $conn->prepare("DELETE FROM hoc_lieu WHERE id_hoclieu = ?");
                $stmt_delete->bind_param("i", $id_hoclieu);
                $stmt_delete->execute();
                $stmt_delete->close();
                
                $conn->commit();
                $response['status'] = 'success';
                $response['message'] = 'Xóa học liệu thành công!';

            } else {
                throw new Exception('Không tìm thấy học liệu để xóa.');
            }
        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = 'Lỗi khi xóa: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
$conn->close();
?>