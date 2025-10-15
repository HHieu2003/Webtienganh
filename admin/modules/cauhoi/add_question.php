<?php
include('../../../config/config.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baitest = (int)($_POST['id_baitest'] ?? 0);
    $noi_dung = trim($_POST['noi_dung_cauhoi'] ?? '');
    // Lấy thêm loại câu hỏi từ form
    $loai_cauhoi = $_POST['loai_cauhoi'] ?? 'trac_nghiem'; 

    if (empty($noi_dung)) {
        echo json_encode(['success' => false, 'message' => 'Nội dung câu hỏi không được để trống.']);
        exit;
    }

    // Cập nhật câu lệnh SQL để chèn thêm 'loai_cauhoi'
    $sql = "INSERT INTO cauhoi (id_baitest, noi_dung, loai_cauhoi) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Thêm 's' (string) cho loai_cauhoi và bind biến vào
    $stmt->bind_param('iss', $id_baitest, $noi_dung, $loai_cauhoi);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi CSDL khi thêm câu hỏi.']);
    }
    exit;
}
?>