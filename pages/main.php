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
        include("main/course_detail.php");
        break;

    case 'huongdandangky':
        include("main/huongdandangky.php");
        break;

    case 'dangkykhoahoc':
        include("main/dangkykhoahoc.php");
        break;
    
    // --- BẮT ĐẦU THÊM CÁC TRANG MỚI ---
    case 'lecturers':
        include("main/lecturers.php");
        break;

    case 'stories':
        include("main/stories.php");
        break;

    case 'blog':
        include("main/blog.php");
        break;
    
    case 'blog_single':
        include("main/blog_single.php");
        break;

    case 'events':
        include("main/events.php");
        break;

    case 'contact':
        include("main/contact.php");
        break;
    // --- KẾT THÚC THÊM CÁC TRANG MỚI ---

    case 'home':
    default: // Nếu 'nav' không khớp với bất kỳ case nào, sẽ chạy default
        include("main/home.php");
        break;
}
?>