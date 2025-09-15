<?php
include('../../../config/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cauhoi = (int)($_POST['id_cauhoi'] ?? 0);
    $noi_dung = trim($_POST['noi_dung_dapan'] ?? '');
    $la_dung = isset($_POST['la_dung']) ? 1 : 0;

    if (empty($noi_dung)) {
        echo json_encode(['success' => false, 'message' => 'Nội dung đáp án không được để trống.']);
        exit;
    }

    $sql = "INSERT INTO dapan (id_cauhoi, noi_dung_dapan, la_dung) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isi', $id_cauhoi, $noi_dung, $la_dung);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi CSDL khi thêm đáp án.']);
    }
    exit;
}
?>