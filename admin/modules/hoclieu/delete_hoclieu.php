<?php
// File: admin/modules/hoclieu/delete_hoclieu.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_hoclieu = (int)($data['id_hoclieu'] ?? 0);

    if ($id_hoclieu > 0) {
        $conn->begin_transaction();
        try {
            // Lấy đường dẫn file để xóa
            $stmt_get = $conn->prepare("SELECT duong_dan_file FROM hoc_lieu WHERE id_hoclieu = ?");
            $stmt_get->bind_param("i", $id_hoclieu);
            $stmt_get->execute();
            $result = $stmt_get->get_result();
            $file_path_db = $result->fetch_assoc()['duong_dan_file'];
            $stmt_get->close();

            if ($file_path_db) {
                $full_file_path = '../../../' . $file_path_db;
                if (file_exists($full_file_path)) {
                    unlink($full_file_path); // Xóa file vật lý
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

        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = 'Lỗi khi xóa: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
$conn->close();
?>