<?php
// File: admin/modules/teacher/teacher_menu.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy trang hiện tại từ URL để xác định link/menu nào đang active
$current_page = $_GET['nav'] ?? '';

// Nhóm các trang con vào từng mục lớn để quản lý trạng thái "active" của menu cha
$teaching_management_pages = [
    'teacher_classes',
    'lichhoc', // Giảng viên cũng truy cập trang này
    'teacher_materials',
    'question',
    'ds_cauhoi_gv',
    'kqhocvien_gv',
     'teacher_schedule' 
];

$is_teaching_management_active = in_array($current_page, $teaching_management_pages);
// === MỚI: Xác định đường dẫn avatar ===
// Giả định rằng bạn lưu đường dẫn ảnh trong session là 'hinh_anh' khi giảng viên đăng nhập
$avatar_path = (isset($_SESSION['hinh_anh']) && !empty($_SESSION['hinh_anh'])) 
                ? '../' . htmlspecialchars($_SESSION['hinh_anh']) 
                : '../images/default-avatar.png'; // Đường dẫn đến avatar mặc định
?>
<style>
    /* Nâng cấp giao diện chung cho menu giảng viên */
    .sidebar-header.teacher-header {
        background-color: var(--brand-color-light);
        padding: 15px 20px;
    }

    .teacher-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .teacher-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid var(--brand-color);
        object-fit: cover;
    }

    .teacher-info .name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--sidebar-text);
        margin: 0;
    }

    .teacher-info .role {
        font-size: 0.8rem;
        color: var(--text-color-light);
    }

    .admin-nav hr {
        margin: 1rem;
        border-color: rgba(0, 0, 0, 0.05);
    }

    /* Responsive cho Sidebar */
    @media (max-width: 768px) {
        .admin-sidebar {
            /* Các style này sẽ được kích hoạt bởi JS của trang admin chính khi ở màn hình nhỏ */
            position: fixed;
            left: -280px;
            /* Ẩn đi mặc định */
            top: 0;
            height: 100%;
            z-index: 1050;
            transition: left 0.3s ease-in-out;
        }

        .admin-sidebar.show {
            left: 0;
            /* Hiện ra khi có class 'show' */
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
            /* Ẩn mặc định */
        }

        .sidebar-overlay.show {
            display: block;
            /* Hiện ra cùng sidebar */
        }
    }
</style>

<div class="sidebar-header teacher-header">
    <div class="teacher-info">
        <img src="../images/logo.png" alt="Avatar">
        <div>
            <p class="name"><?php echo htmlspecialchars($_SESSION['teacher_name']); ?></p>
            <span class="role">Giảng viên</span>
        </div>
    </div>
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
            <a href="#teachingSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo $is_teaching_management_active ? 'true' : 'false'; ?>" class="nav-link-collapse <?php echo $is_teaching_management_active ? '' : 'collapsed'; ?>">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Quản lý Giảng dạy</span>
                <i class="collapse-arrow fa-solid fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse list-unstyled <?php echo $is_teaching_management_active ? 'show' : ''; ?>" id="teachingSubmenu">
                <li>
                    <a href="./admin.php?nav=teacher_classes" class="<?php echo in_array($current_page, ['teacher_classes', 'lichhoc']) ? 'active' : ''; ?>">
                        Lớp học của tôi
                    </a>
                </li>
                <li>
                    <a href="./admin.php?nav=teacher_schedule" class="<?php echo ($current_page == 'teacher_schedule') ? 'active' : ''; ?>">
                        Lịch dạy
                    </a>
                </li>
                <li>
                    <a href="./admin.php?nav=teacher_materials" class="<?php echo ($current_page == 'teacher_materials') ? 'active' : ''; ?>">
                        Học liệu
                    </a>
                </li>
                <li>
                    <a href="./admin.php?nav=question" class="<?php echo in_array($current_page, ['question', 'ds_cauhoi_gv', 'kqhocvien_gv']) ? 'active' : ''; ?>">
                        Quản lý Bài test
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="./admin.php?nav=teacher_notifications" class="<?php echo ($current_page == 'teacher_notifications') ? 'active' : ''; ?>">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Gửi Thông báo</span>
            </a>
        </li>

        <hr>

        <!-- <li>
            <a href="../index.php" target="_blank">
                <i class="fa-solid fa-globe"></i><span>Xem trang web</span>
            </a>
        </li> -->
        <li>
            <a href="modules/logout.php" class="text-danger">
                <i class="fa-solid fa-right-from-bracket"></i><span>Đăng xuất</span>
            </a>
        </li>
    </ul>
</nav>