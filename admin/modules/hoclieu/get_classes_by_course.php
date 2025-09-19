<?php
// File: admin/modules/hoclieu/get_classes_by_course.php
header('Content-Type: application/json');
include('../../../config/config.php');

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$classes = [];

if ($course_id > 0) {
    $sql = "SELECT id_lop, ten_lop FROM lop_hoc WHERE id_khoahoc = ? ORDER BY ten_lop ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
    $stmt->close();
}

echo json_encode($classes);
$conn->close();
?>