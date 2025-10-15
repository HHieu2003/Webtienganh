<?php
// File: admin/modules/cauhoi/update_grade.php
include('../../../config/config.php');
session_start();
header('Content-Type: application/json');

// --- Bảo mật: Chỉ cho phép Admin hoặc Giảng viên truy cập ---
if (!isset($_SESSION['is_admin']) && !isset($_SESSION['is_teacher'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện hành động này.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.']);
    exit();
}

$dapan_hocvien_id = (int)($_POST['dapan_hocvien_id'] ?? 0);
$score = $_POST['score'] ?? null;
$feedback = trim($_POST['feedback'] ?? '');

if ($dapan_hocvien_id === 0 || $score === null || $feedback === '') {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ.']);
    exit();
}

// Chuyển đổi điểm số sang kiểu float, đảm bảo nó là số
$score = (float)$score;

$sql_update = "UPDATE dapan_hocvien SET diem_tu_luan = ?, nhan_xet_tu_luan = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("dsi", $score, $feedback, $dapan_hocvien_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Cập nhật điểm và nhận xét thành công!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi cập nhật cơ sở dữ liệu.']);
}

$stmt->close();
$conn->close();
?>