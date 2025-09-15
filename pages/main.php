<?php
// Lấy giá trị của 'nav' từ URL, nếu không có thì mặc định là 'home'
$nav = $_GET['nav'] ?? 'home';

// Sử dụng switch-case để code dễ đọc và bảo trì hơn
switch ($nav) {
    case 'khoahoc':
        include("main/khoahoc.php");
        break;
    
    case 'dskhoahoc':
        include("main/dskhoahoc.php");
        break;

    case 'about':
        include("main/about.php");
        break;

    case 'question':
        include("question/question.php");
        break;

    case 'dapan':
        include("question/dapan.php");
        break;

    case 'question_detail':
        include("question/question_detail.php");
        break;

    case 'course_detail':
        // Sửa lại đường dẫn cho chính xác
        include("main/course_detail.php");
        break;

    case 'huongdandangky':
        // Sửa lại đường dẫn cho chính xác
        include("main/huongdandangky.php");
        break;

    case 'dangkykhoahoc':
        // Sửa lại đường dẫn cho chính xác
        include("main/dangkykhoahoc.php");
        break;

    case 'home':
    default: // Nếu 'nav' không khớp với bất kỳ case nào, sẽ chạy default
        include("main/home.php");
        break;
}
?>