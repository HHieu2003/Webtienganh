<?php
// Lấy trang hiện tại từ URL để xác định link active
$current_page = $_GET['nav'] ?? '';
?>

<div class="sidebar-header">
    Giảng viên
</div>
<nav class="admin-nav">
    <ul>
        <li>
            <a href="./admin.php" class="<?php echo ($current_page == '') ? 'active' : ''; ?>">
                <i class="fa-solid fa-house"></i>
                <span>Bảng điều khiển</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=teacher_classes" class="<?php echo ($current_page == 'teacher_classes') ? 'active' : ''; ?>">
                <i class="fa-solid fa-school"></i>
                <span>Lớp học của tôi</span>
            </a>
        </li>
         <li>
            <a href="./admin.php?nav=teacher_materials" class="<?php echo ($current_page == 'teacher_materials') ? 'active' : ''; ?>">
                <i class="fa-solid fa-file-lines"></i>
                <span>Học liệu</span>
            </a>
        </li>
        </ul>
</nav>