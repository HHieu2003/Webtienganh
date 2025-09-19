<?php
// File: admin/modules/hoclieu/edit_hoclieu.php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hoclieu = (int)($_POST['id_hoclieu'] ?? 0);
    $tieu_de = trim($_POST['tieu_de'] ?? '');

    if ($id_hoclieu === 0 || empty($tieu_de)) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }

    $sql = "UPDATE hoc_lieu SET tieu_de = ? WHERE id_hoclieu = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $tieu_de, $id_hoclieu);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Cập nhật tiêu đề thành công!';
    } else {
        $response['message'] = 'Lỗi CSDL khi cập nhật.';
    }
    $stmt->close();
}

echo json_encode($response);
$conn->close();
?>