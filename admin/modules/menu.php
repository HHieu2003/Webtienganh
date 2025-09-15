<?php
// Lấy trang hiện tại từ URL để xác định link active
// Gán giá trị rỗng nếu không có tham số 'nav', tương ứng với trang Dashboard
$current_page = $_GET['nav'] ?? '';
?>

<div class="sidebar-header">
    Admin Fighter!
</div>
<nav class="admin-nav">
    <ul>
        <li>
            <a href="./admin.php" class="<?php echo ($current_page == '') ? 'active' : ''; ?>">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=students" class="<?php echo ($current_page == 'students') ? 'active' : ''; ?>">
                <i class="fa-solid fa-users"></i>
                <span>Học viên</span>
            </a>
        </li>
         <li>
            <a href="./admin.php?nav=lecturers" class="<?php echo ($current_page == 'lecturers') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Giảng viên</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=courses" class="<?php echo ($current_page == 'courses' || $current_page == 'add_course' || $current_page == 'edit_course') ? 'active' : ''; ?>">
                <i class="fa-solid fa-book-open"></i>
                <span>Khóa học</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=lichhoc" class="<?php echo ($current_page == 'lichhoc') ? 'active' : ''; ?>">
                <i class="fa-solid fa-school"></i>
                <span>Lớp học</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=dangkykhoahoc" class="<?php echo ($current_page == 'dangkykhoahoc') ? 'active' : ''; ?>">
                <i class="fa-solid fa-circle-check"></i>
                <span>Xác nhận đăng ký</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=thanhtoan" class="<?php echo ($current_page == 'thanhtoan') ? 'active' : ''; ?>">
                <i class="fa-solid fa-money-check-dollar"></i>
                <span>Lịch sử thanh toán</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=question" class="<?php echo ($current_page == 'question' || strpos($current_page, 'ds_') === 0 || strpos($current_page, 'kq') === 0) ? 'active' : ''; ?>">
                <i class="fa-solid fa-circle-question"></i>
                <span>Câu hỏi & Test</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=thongbao" class="<?php echo ($current_page == 'thongbao') ? 'active' : ''; ?>">
                <i class="fa-solid fa-bell"></i>
                <span>Thông báo</span>
            </a>
        </li>
    </ul>
</nav>