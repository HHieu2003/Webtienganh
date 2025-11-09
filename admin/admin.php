<?php
session_start();
include('../config/config.php');
// Kiểm tra đăng nhập 
if (!isset($_SESSION['is_admin']) && !isset($_SESSION['is_teacher'])) {
    header("Location: ../pages/login.php");
    exit();
}

$is_admin = $_SESSION['is_admin'] ?? false;
$is_teacher = $_SESSION['is_teacher'] ?? false;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_admin ? 'Trang Quản Trị' : 'Trang Giảng viên'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .cke_notifications_area {
        top: 0px !important;
        display: none !important;
    }
</style>

<body>
    <div class="wrapper">
        <aside class="admin-sidebar" id="admin-sidebar">
            <?php
            if ($is_admin) {
                include('modules/menu.php');
            } else {
                include('modules/teacher/teacher_menu.php');
            }
            ?>
        </aside>

        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <main class="admin-main">
            <header class="admin-header">
                <?php include('modules/header.php'); ?>
            </header>

            <section class="admin-content">
                <?php
                if ($is_admin) {
                    include('modules/main.php');
                } else {
                    include('modules/teacher/teacher_main.php');
                }
                ?>
            </section>

            <footer class="admin-footer">
                <?php include('modules/footer.php'); ?>
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('menu-toggle-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');

            function openSidebar() {
                if (sidebar) sidebar.classList.add('show');
                if (overlay) overlay.classList.add('show');
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
            }

            if (openBtn) {
                openBtn.addEventListener('click', openSidebar);
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Detect if menu is scrollable and add fade effect
            const adminNav = document.querySelector('.admin-nav');
            if (adminNav) {
                function checkScrollable() {
                    if (adminNav.scrollHeight > adminNav.clientHeight) {
                        adminNav.classList.add('has-scroll');
                    } else {
                        adminNav.classList.remove('has-scroll');
                    }
                }
                
                // Check on load
                checkScrollable();
                
                // Check on resize
                window.addEventListener('resize', checkScrollable);
                
                // Update fade effect on scroll
                adminNav.addEventListener('scroll', function() {
                    const isAtBottom = adminNav.scrollHeight - adminNav.scrollTop <= adminNav.clientHeight + 10;
                    if (isAtBottom) {
                        adminNav.classList.remove('has-scroll');
                    } else {
                        adminNav.classList.add('has-scroll');
                    }
                });
            }
        });
    </script>
</body>

</html>