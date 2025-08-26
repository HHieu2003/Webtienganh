<?php
include('../../../config/config.php');

// Ghi log để kiểm tra phương thức và dữ liệu
error_log("Phương thức HTTP: " . $_SERVER['REQUEST_METHOD']);
error_log("Dữ liệu nhận: " . file_get_contents("php://input"));

// Kiểm tra phương thức HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
    exit;
}

// Lấy ID đáp án từ request
$id_dapan = intval($_POST['id_dapan']);
error_log("ID đáp án nhận được: " . $id_dapan);

if (!$id_dapan) {
    echo json_encode(['success' => false, 'message' => 'ID đáp án không hợp lệ.']);
    exit;
}

// Thực hiện xóa đáp án trong cơ sở dữ liệu
$sql = "DELETE FROM dapan WHERE id_dapan = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    error_log("Lỗi khi chuẩn bị truy vấn: " . mysqli_error($conn));
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $id_dapan);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
    error_log("Xóa đáp án thành công: ID $id_dapan");
} else {
    error_log("Lỗi khi thực thi truy vấn: " . mysqli_error($conn));
    echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa đáp án: ' . mysqli_error($conn)]);
}
exit;
?>