<?php
include('../../../config/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dapan = (int)($_POST['id_dapan'] ?? 0);
    $sql = "DELETE FROM dapan WHERE id_dapan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_dapan);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa đáp án.']);
    }
    exit;
}
?>