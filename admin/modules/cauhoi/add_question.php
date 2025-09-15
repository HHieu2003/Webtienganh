<?php
include('../../../config/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baitest = (int)($_POST['id_baitest'] ?? 0);
    $noi_dung = trim($_POST['noi_dung_cauhoi'] ?? '');

    if (empty($noi_dung)) {
        echo json_encode(['success' => false, 'message' => 'Nội dung câu hỏi không được để trống.']);
        exit;
    }

    $sql = "INSERT INTO cauhoi (id_baitest, noi_dung) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $id_baitest, $noi_dung);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi CSDL khi thêm câu hỏi.']);
    }
    exit;
}
?>