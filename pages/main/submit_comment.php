<?php
session_start();
include('../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_hocvien'])) {
    $id_hocvien = $_SESSION['id_hocvien'];
    $id_baiviet = (int)($_POST['id_baiviet'] ?? 0);
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $noi_dung = trim($_POST['noi_dung'] ?? '');

    if ($id_baiviet > 0 && !empty($noi_dung)) {
        $sql = "INSERT INTO binh_luan (id_baiviet, id_hocvien, parent_id, noi_dung) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $id_baiviet, $id_hocvien, $parent_id, $noi_dung);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Bình luận thành công!';
        } else {
            $response['message'] = 'Lỗi khi gửi bình luận.';
        }
    } else {
        $response['message'] = 'Nội dung không được để trống.';
    }
} else {
    $response['message'] = 'Vui lòng đăng nhập để bình luận.';
}

echo json_encode($response);
$conn->close();
?>