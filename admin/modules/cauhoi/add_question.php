<?php
include('../../../config/config.php'); // Kết nối database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baitest = intval($_POST['id_baitest']);
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung_cauhoi']);

    if (empty($noi_dung)) {
        echo json_encode(['success' => false, 'message' => 'Nội dung câu hỏi không được để trống.']);
        exit;
    }

    $sql = "INSERT INTO cauhoi (id_baitest, noi_dung) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'is', $id_baitest, $noi_dung);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Thêm câu hỏi thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể thêm câu hỏi.']);
    }
    exit;
}
?>
