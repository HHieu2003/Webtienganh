<?php
// Lấy trang hiện tại từ URL
$current_page = $_GET['nav'] ?? '';

// --- LOGIC MỚI ĐỂ XÁC ĐỊNH NHÓM NÀO ĐANG ACTIVE ---
// Mảng chứa các trang con của từng nhóm
$user_management_pages = ['students', 'lecturers'];
$training_management_pages = ['courses', 'add_course', 'edit_course', 'lichhoc', 'hoclieu', 'question', 'ds_cauhoi', 'ds_dapan', 'kqhocvien'];
$operations_pages = ['dangkykhoahoc', 'thanhtoan', 'thongbao'];

// Kiểm tra xem trang hiện tại thuộc nhóm nào để mở sẵn menu
$is_user_management_active = in_array($current_page, $user_management_pages);
$is_training_management_active = in_array($current_page, $training_management_pages);
$is_operations_active = in_array($current_page, $operations_pages);
?>

<div class="sidebar-header">
    Admin Fighter!
</div>
<nav class="admin-nav">
    <ul>
        <li>
            <a href="./admin.php" class="<?php echo ($current_page == '') ? 'active' : ''; ?>">
                <i class="fa-solid fa-house"></i><span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="./admin.php?nav=thongke" class="<?php echo ($current_page == 'thongke') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie"></i><span>Báo cáo & Thống kê</span>
            </a>
        </li>

        <li>
            <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo $is_user_management_active ? 'true' : 'false'; ?>" class="nav-link-collapse <?php echo $is_user_management_active ? '' : 'collapsed'; ?>">
                <i class="fa-solid fa-users-gear"></i>
                <span>Quản lý người dùng</span>
                <i class="collapse-arrow fa-solid fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse list-unstyled <?php echo $is_user_management_active ? 'show' : ''; ?>" id="userSubmenu">
                <li><a href="./admin.php?nav=students" class="<?php echo ($current_page == 'students') ? 'active' : ''; ?>">Học viên</a></li>
                <li><a href="./admin.php?nav=lecturers" class="<?php echo ($current_page == 'lecturers') ? 'active' : ''; ?>">Giảng viên</a></li>
            </ul>
        </li>

        <li>
            <a href="#trainingSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo $is_training_management_active ? 'true' : 'false'; ?>" class="nav-link-collapse <?php echo $is_training_management_active ? '' : 'collapsed'; ?>">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Quản lý đào tạo</span>
                <i class="collapse-arrow fa-solid fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse list-unstyled <?php echo $is_training_management_active ? 'show' : ''; ?>" id="trainingSubmenu">
                <li><a href="./admin.php?nav=courses" class="<?php echo in_array($current_page, ['courses', 'add_course', 'edit_course']) ? 'active' : ''; ?>">Khóa học</a></li>
                <li><a href="./admin.php?nav=lichhoc" class="<?php echo ($current_page == 'lichhoc') ? 'active' : ''; ?>">Lớp học</a></li>
                <li><a href="./admin.php?nav=hoclieu" class="<?php echo ($current_page == 'hoclieu') ? 'active' : ''; ?>">Học liệu</a></li>
                <li><a href="./admin.php?nav=question" class="<?php echo in_array($current_page, ['question', 'ds_cauhoi', 'ds_dapan', 'kqhocvien']) ? 'active' : ''; ?>">Câu hỏi & Test</a></li>
            </ul>
        </li>
        
        <li>
            <a href="#operationsSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo $is_operations_active ? 'true' : 'false'; ?>" class="nav-link-collapse <?php echo $is_operations_active ? '' : 'collapsed'; ?>">
                <i class="fa-solid fa-server"></i>
                <span>Vận hành</span>
                <i class="collapse-arrow fa-solid fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse list-unstyled <?php echo $is_operations_active ? 'show' : ''; ?>" id="operationsSubmenu">
                <li><a href="./admin.php?nav=dangkykhoahoc" class="<?php echo ($current_page == 'dangkykhoahoc') ? 'active' : ''; ?>">Xác nhận đăng ký</a></li>
                <li><a href="./admin.php?nav=thanhtoan" class="<?php echo ($current_page == 'thanhtoan') ? 'active' : ''; ?>">Lịch sử thanh toán</a></li>
                <li><a href="./admin.php?nav=thongbao" class="<?php echo ($current_page == 'thongbao') ? 'active' : ''; ?>">Thông báo</a></li>
            </ul>

             <hr style="background-color: rgba(255,255,255,0.2);">
        <li>
            <a href="../index.php" target="_blank">
                <i class="fa-solid fa-globe"></i><span>Về Trang Chủ</span>
            </a>
        </li>
        </li>
    </ul>
</nav>