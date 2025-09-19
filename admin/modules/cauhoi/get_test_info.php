<?php
// File: admin/modules/cauhoi/get_test_info.php
header('Content-Type: application/json');
include('../../../config/config.php');

$response = ['error' => 'ID không hợp lệ.'];
$test_id = $_GET['id'] ?? 0;

if ($test_id > 0) {
    $sql = "SELECT id_baitest, ten_baitest, loai_baitest, id_khoahoc, thoi_gian FROM baitest WHERE id_baitest = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($test = $result->fetch_assoc()) {
        echo json_encode($test);
        exit;
    } else {
        http_response_code(404);
        $response['error'] = "Không tìm thấy bài test.";
    }
}

echo json_encode($response);
$conn->close();
?>