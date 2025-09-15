<?php
include('../../../config/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cauhoi = (int)($_POST['id_cauhoi'] ?? 0);
    // ON DELETE CASCADE sẽ tự xóa các đáp án liên quan.
    $sql = "DELETE FROM cauhoi WHERE id_cauhoi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_cauhoi);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa câu hỏi.']);
    }
    exit;
}
?>