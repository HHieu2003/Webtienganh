<?php
include('../../../config/config.php');

// Kiểm tra phương thức
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
    exit;
}

// Lấy dữ liệu từ request
$noiDungDapan = filter_input(INPUT_POST, 'noi_dung_dapan', FILTER_SANITIZE_STRING);
$idCauHoi = filter_input(INPUT_POST, 'id_cauhoi', FILTER_VALIDATE_INT);
$laDung = isset($_POST['la_dung']) ? 1 : 0;

if (!$noiDungDapan || !$idCauHoi) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
    exit;
}

// Chèn đáp án vào cơ sở dữ liệu
$sql = "INSERT INTO dapan (id_cauhoi, noi_dung_dapan, la_dung) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, 'isi', $idCauHoi, $noiDungDapan, $laDung);

if (mysqli_stmt_execute($stmt)) {
    // Phản hồi thành công
    echo json_encode([
        'success' => true,
        'id_dapan' => mysqli_insert_id($conn),
        'id_cauhoi' => $idCauHoi,
        'noi_dung_dapan' => $noiDungDapan,
        'la_dung' => $laDung
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chèn dữ liệu: ' . mysqli_error($conn)]);
}
exit;
?>
