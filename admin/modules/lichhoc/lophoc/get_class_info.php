<?php
header('Content-Type: application/json');
include('../../../../config/config.php');

$lop_id = $_GET['id'] ?? '';

if (!empty($lop_id)) {
    $sql = "SELECT id_lop, ten_lop, id_khoahoc, id_giangvien, trang_thai FROM lop_hoc WHERE id_lop = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lop_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($class = $result->fetch_assoc()) {
        echo json_encode($class);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Không tìm thấy lớp học.']);
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID lớp không hợp lệ.']);
}
$conn->close();
?>