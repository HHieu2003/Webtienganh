<?php
// File: admin/modules/teacher_main.php
$nav = $_GET['nav'] ?? '';

// Chỉ cho phép truy cập các trang được định nghĩa cho giảng viên
switch ($nav) {
    case 'teacher_classes':
        include("teacher_classes.php");
        break;

    case 'teacher_materials':
        include("teacher_materials.php");
        break;

    // Các trang mà giảng viên cũng có thể truy cập
    case 'lichhoc':
        include("./modules/lichhoc/lichhoc.php");
        break;

    // ================================================================
    // === BỔ SUNG MỚI: ĐIỀU HƯỚNG CHO CÁC CHỨC NĂNG BÀI TEST ===
    // ================================================================
    case 'question': // Trang danh sách bài test của giảng viên
        include("teacher_tests.php");
        break;

    case 'ds_cauhoi_gv': // Trang danh sách câu hỏi (phiên bản của giảng viên)
        include("./modules/cauhoi/ds_cauhoi.php");
        break;

    case 'kqhocvien_gv': // Trang kết quả học viên (phiên bản của giảng viên)
        include("./modules/cauhoi/kqhocvien.php");
        break;
    // ================================================================
    case 'teacher_notifications':
        include("teacher_notifications.php");
        break;
    default: // Trang chủ mặc định của giảng viên
        include("teacher_home.php");
        break;
}
