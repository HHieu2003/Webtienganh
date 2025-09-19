<?php
include('../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $tieu_de = $data['tieu_de'] ?? '';
    $id_khoahoc = $data['id_khoahoc'] ?? null;
    $id_lop = $data['id_lop'] ?? null;
    $ngay_tao = $data['ngay_tao'] ?? '';

    $conditions = [];
    $params = [];
    $types = "";

    $conditions[] = "tieu_de = ?";
    $params[] = $tieu_de;
    $types .= "s";

    $conditions[] = "ngay_tao = ?";
    $params[] = $ngay_tao;
    $types .= "s";

    if ($id_lop) {
        $conditions[] = "id_lop = ?";
        $params[] = $id_lop;
        $types .= "s";
    } elseif ($id_khoahoc) {
        $conditions[] = "id_khoahoc = ?";
        $params[] = $id_khoahoc;
        $types .= "i";
    } else {
        $conditions[] = "id_khoahoc IS NULL AND id_lop IS NULL";
    }

    $sql = "DELETE FROM thongbao WHERE " . implode(" AND ", $conditions);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Đã xóa nhóm thông báo thành công!';
    } else {
        $response['message'] = 'Lỗi khi xóa thông báo.';
    }
}

echo json_encode($response);
$conn->close();
?>