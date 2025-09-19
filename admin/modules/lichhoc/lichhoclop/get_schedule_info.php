<?php
header('Content-Type: application/json');
include('../../../../config/config.php');

$id_lichhoc = $_GET['id'] ?? 0;

if ($id_lichhoc > 0) {
    $sql = "SELECT * FROM lichhoc WHERE id_lichhoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_lichhoc);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($schedule = $result->fetch_assoc()) {
        echo json_encode($schedule);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Không tìm thấy buổi học.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID không hợp lệ.']);
}
$conn->close();
?>