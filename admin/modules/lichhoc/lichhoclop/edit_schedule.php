<?php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lichhoc = (int)($_POST['edit_id_lichhoc'] ?? 0);
    $ngay_hoc = $_POST['ngay_hoc'] ?? '';
    $gio_bat_dau = $_POST['gio_bat_dau'] ?? '';
    $gio_ket_thuc = $_POST['gio_ket_thuc'] ?? '';
    $phong_hoc = $_POST['phong_hoc'] ?? '';
    $ghi_chu = $_POST['ghi_chu'] ?? '';

    if($id_lichhoc === 0 || empty($ngay_hoc) || empty($gio_bat_dau) || empty($gio_ket_thuc) || empty($phong_hoc)) {
        $response['message'] = 'Dữ liệu không hợp lệ.';
        echo json_encode($response);
        exit;
    }

    $sql = "UPDATE lichhoc SET ngay_hoc=?, gio_bat_dau=?, gio_ket_thuc=?, phong_hoc=?, ghi_chu=? WHERE id_lichhoc=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $ngay_hoc, $gio_bat_dau, $gio_ket_thuc, $phong_hoc, $ghi_chu, $id_lichhoc);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Cập nhật buổi học thành công!';
    } else {
        $response['message'] = 'Lỗi khi cập nhật buổi học.';
    }
}
echo json_encode($response);
$conn->close();
?>