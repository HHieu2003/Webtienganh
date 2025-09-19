<?php
// File: admin/modules/hoclieu/get_hoclieu_info.php
header('Content-Type: application/json');
include('../../../config/config.php');

$response = [];
$id_hoclieu = (int)($_GET['id'] ?? 0);

if ($id_hoclieu > 0) {
    $sql = "SELECT id_hoclieu, tieu_de FROM hoc_lieu WHERE id_hoclieu = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_hoclieu);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $response = $result->fetch_assoc();
        http_response_code(200);
    } else {
        http_response_code(404);
        $response['error'] = "Không tìm thấy học liệu";
    }
    $stmt->close();
} else {
    http_response_code(400);
    $response['error'] = "ID học liệu không hợp lệ.";
}

$conn->close();
echo json_encode($response);
?>