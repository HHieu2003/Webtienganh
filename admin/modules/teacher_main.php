<?php
$nav = $_GET['nav'] ?? '';

// Chỉ cho phép truy cập các trang được định nghĩa cho giảng viên
switch ($nav) {
    case 'teacher_classes':
        include("teacher_classes.php");
        break;
        
    // Các case cho chức năng tương lai
    // case 'teacher_materials':
    //     include("teacher_materials.php");
    //     break;
    // case 'teacher_grades':
    //     include("teacher_grades.php");
    //     break;

    // Các trang mà giảng viên cũng có thể truy cập (nếu có)
    case 'lichhoc': // Giảng viên cần xem chi tiết lớp học
        include("lichhoc/lichhoc.php");
        break;
    case 'teacher_materials':
        include("teacher_materials.php");
        break;

    default: // Trang chủ mặc định của giảng viên
        include("teacher_home.php");
        break;
}
?>