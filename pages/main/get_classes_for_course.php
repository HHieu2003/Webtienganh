<?php
header('Content-Type: application/json');
include('../../config/config.php');

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

if ($course_id === 0) {
    echo json_encode(['error' => 'ID khóa học không hợp lệ.']);
    exit;
}

$response = [];

// Lấy danh sách lớp học và thông tin giảng viên
$sql_classes = "SELECT lh.id_lop, lh.ten_lop, lh.so_luong_hoc_vien, gv.ten_giangvien
                FROM lop_hoc lh
                LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien
                WHERE lh.id_khoahoc = ? AND lh.trang_thai = 'dang hoc'";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $course_id);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

$classes = [];
while ($class_row = $result_classes->fetch_assoc()) {
    // Với mỗi lớp, lấy lịch học
    $sql_schedule = "SELECT ngay_hoc, gio_bat_dau, gio_ket_thuc, phong_hoc 
                     FROM lichhoc 
                     WHERE id_lop = ? 
                     ORDER BY ngay_hoc ASC, gio_bat_dau ASC";
    $stmt_schedule = $conn->prepare($sql_schedule);
    $stmt_schedule->bind_param("s", $class_row['id_lop']);
    $stmt_schedule->execute();
    $result_schedule = $stmt_schedule->get_result();
    
    $schedules = [];
    while ($schedule_row = $result_schedule->fetch_assoc()) {
        $schedules[] = $schedule_row;
    }
    
    $class_row['schedules'] = $schedules;
    $classes[] = $class_row;
}

echo json_encode($classes);

$stmt_classes->close();
$conn->close();
?>