<?php
// File: admin/modules/cauhoi/get_classes_by_course.php
header('Content-Type: application/json');
include('../../../config/config.php');
session_start();

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$teacher_only = isset($_GET['teacher_only']) && isset($_SESSION['id_giangvien']);
$classes = [];

if ($course_id > 0) {
    $sql = "SELECT id_lop, ten_lop FROM lop_hoc WHERE id_khoahoc = ?";
    $params = [$course_id];
    $types = "i";

    if ($teacher_only) {
        $sql .= " AND id_giangvien = ?";
        $params[] = $_SESSION['id_giangvien'];
        $types .= "i";
    }

    $sql .= " ORDER BY ten_lop ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
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