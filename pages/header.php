<?php
$isLoggedIn = isset($_SESSION['id_hocvien']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin']; // Kiểm tra nếu là admin
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiếng Anh Fighter!</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./pages/main.css">

    <style>
        /* ==========================================================
           PHẦN CSS CHUNG
           ========================================================== */
        .fixed-header-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            background-color: #f8f9fa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-top {
            color: #fff;
            padding: 5px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0db33b;
        }

        .header-top .right a {
            text-decoration: none;
            margin-left: 15px;
            font-size: 16px;
            color: #ffffffff;
            font-weight: 600;
        }

        .header-top .right a+a::before {
            content: "|";
            color: white;
            padding-right: 15px;
            font-weight: 500;
        }

        .header-top .right a:hover {
            text-decoration: underline;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 55px;
            margin-right: 10px;
        }

        .logo-item {
            font-size: 20px;
            color: #0db33b;
            font-weight: bold;
        }

        .logo-row {
            font-size: 13px;
            color: #666;
        }

        .navbar-container {
            width: 100%;
            display: flex;
            align-items: center;
        }

        /* ==========================================================
           CSS CHO MENU TRÊN MÀN HÌNH LỚN (DESKTOP)
           ========================================================== */
        .desktop-nav {
            margin-left: auto;
        }

        .desktop-nav .navbar-nav .nav-item .nav-link {
            font-weight: 500;
            position: relative;
            padding: 10px 15px;
            font-size: 18px;
            color: #333;
            transition: color 0.2s ease;
        }

        .navbar-nav .nav-item .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #498b5bff;
            transition: all 0.2s ease-in-out;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-item .nav-link:hover::after {
            width: 80%;
        }

        .desktop-nav .navbar-nav .nav-item .nav-link:hover {
            color: #0db33b !important;
        }

        /* Dropdown Desktop */
        .desktop-nav .navbar-nav .nav-item.dropdown .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            min-width: 220px;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
        }

        .desktop-nav .navbar-nav .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #e7f7ec;
            color: #0db33b;
        }

        /* ==========================================================
           BẮT ĐẦU: CSS CHO MENU RESPONSIVE (MOBILE)
           ========================================================== */

        /* 1. Nút Hamburger (chỉ hiện trên mobile) */
        .mobile-menu-toggle {
            display: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            margin-left: auto;
            padding: 5px 10px;
            transition: transform 0.3s ease;
        }

        .mobile-menu-toggle:active {
            transform: scale(0.95);
        }

        /* 2. Khung Menu trượt từ bên trái */
        .mobile-nav-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.15);
            z-index: 1040;
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .mobile-nav-panel::-webkit-scrollbar {
            width: 5px;
        }

        .mobile-nav-panel::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .mobile-nav-panel::-webkit-scrollbar-thumb {
            background: #0db33b;
            border-radius: 10px;
        }

        .mobile-nav-panel.show {
            transform: translateX(0);
        }

        /* 3. Lớp phủ đen phía sau menu */
        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1035;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .mobile-nav-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* 4. Tùy chỉnh nội dung bên trong menu mobile */
        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #0db33b 0%, #0a8f2e 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-nav-header .logo-item {
            font-size: 22px;
            font-weight: bold;
            color: #381111;
        }

        #close-mobile-nav {
            font-size: 28px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        #close-mobile-nav:hover {
            transform: rotate(90deg);
        }

        .mobile-nav-links {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }

        /* Styling cho mỗi link menu */
        .mobile-nav-links li {
            border-bottom: 1px solid #e9ecef;
        }

        .mobile-nav-links li a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            color: #333;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .mobile-nav-links li a:hover {
            background: linear-gradient(90deg, #e7f7ec 0%, transparent 100%);
            color: #0db33b;
            padding-left: 25px;
        }

        /* Icon mũi tên cho dropdown */
        .mobile-nav-links .dropdown-toggle-icon {
            transition: transform 0.3s ease;
            font-size: 14px;
            color: #666;
        }

        .mobile-nav-links .dropdown-toggle-icon.active {
            transform: rotate(180deg);
            color: #0db33b;
        }

        /* Submenu - Ẩn mặc định */
        .mobile-nav-links .dropdown-menu {
            max-height: 0;
            overflow: hidden;
            background-color: #f8f9fa;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.3s ease,
                padding 0.3s ease;
            opacity: 0;
            padding: 0;
            border: none;
            box-shadow: none;
        }

        /* Submenu - Khi mở */
        .mobile-nav-links .dropdown-menu.show {
            max-height: 300px;
            opacity: 1;
            padding: 5px 0;
        }

        /* Styling cho các item trong submenu */
        .mobile-nav-links .dropdown-item {
            padding: 12px 20px 12px 40px;
            color: #555;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .mobile-nav-links .dropdown-item::before {
            content: '•';
            position: absolute;
            left: 25px;
            color: #0db33b;
            font-weight: bold;
        }

        .mobile-nav-links .dropdown-item:hover {
            background-color: #e7f7ec;
            color: #0db33b;
            border-left-color: #0db33b;
            padding-left: 45px;
        }

        /* ========================================================== 
           PHẦN MỚI: ACTION ICONS (NOTIFICATION & SEARCH) CHO MOBILE
           ========================================================== */
        .mobile-action-icons {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(90deg, #f8f9fa 0%, #e9ecef 100%);
            border-top: 2px solid #0db33b;
            margin-top: auto;
        }

        .mobile-action-icons .action-icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
            position: relative;
        }

        .mobile-action-icons .action-icon-item:hover {
            background-color: #e7f7ec;
            transform: translateY(-2px);
        }

        .mobile-action-icons .action-icon-item i {
            font-size: 22px;
            color: #0db33b;
            transition: transform 0.3s ease;
        }

        .mobile-action-icons .action-icon-item:hover i {
            transform: scale(1.1);
        }

        .mobile-action-icons .action-icon-item span {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        /* Badge cho notification mobile */
        .mobile-action-icons .badge {
            position: absolute;
            top: 5px;
            right: 15px;
            padding: 3px 6px;
            border-radius: 50%;
            font-size: 10px;
            background-color: #dc3545;
            color: white;
            display: none;
        }

        /* Notification dropdown trong mobile */
        .mobile-notification-dropdown {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            max-height: 70vh;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 1050;
            display: none;
            overflow: hidden;
        }

        .mobile-notification-dropdown.show {
            display: block;
        }

        .mobile-notification-header {
            background: linear-gradient(135deg, #0db33b 0%, #0a8f2e 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-notification-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .mobile-notification-header .close-notification {
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .mobile-notification-header .close-notification:hover {
            transform: rotate(90deg);
        }

        .mobile-notification-body {
            max-height: calc(70vh - 60px);
            overflow-y: auto;
        }

        .mobile-notification-body ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-notification-body ul li {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .mobile-notification-body ul li:last-child {
            border-bottom: none;
        }

        .mobile-notification-body ul li:hover {
            background-color: #f8f9fa;
        }

        /* Quy tắc Responsive: Áp dụng khi màn hình nhỏ hơn 992px */
        @media (max-width: 991.98px) {
            .desktop-nav {
                display: none;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .header-top {
                font-size: 14px;
                flex-direction: column;
                gap: 10px;
                padding: 10px;
            }

            .logo img {
                height: 50px;
            }

            .logo-item {
                font-size: 18px;
            }

            .mobile-nav-panel {
                width: 280px;
                display: flex;
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .mobile-nav-panel {
                width: 65%;
            }
              .header-top .right a {
            font-size: 14px;
            margin-left: 0px;
        }

        .header-top .left {
            display: none;
        }
        }


        .badge {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 3px 4px;
            border-radius: 50%;
            font-size: 12px;
            background-color: #dc3545;
            color: white;
            display: none;
        }

        .notification-dropdown {
            position: absolute;
            top: 40px;
            right: 0;
            width: 300px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
        }

        #notification-items p {
            font-size: 13px;
            margin: 0;
        }

        #notification-items small {
            font-size: 13px;
        }

        .notification-dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 300px;
            overflow-y: auto;
        }

        .notification-dropdown ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .notification-dropdown ul li:last-child {
            border-bottom: none;
        }

        .notification-dropdown ul li:hover {
            background: #f8f9fa;
        }

      
    </style>
</head>

<body>
    <div class="fixed-header-container">
        <div class="header-top">
            <div class="left">
                Hotline: 0962.501.832 - 0336.123.130
            </div>
            <div class="right">
                <?php if ($isLoggedIn) : ?>
                    <?php if ($isAdmin) : ?>
                        <a href="./admin/admin.php" style="font-weight: bold;">Trang Admin</a>
                    <?php endif; ?>
                    <a href="./user/dashboard.php"> <?php echo htmlspecialchars($_SESSION['user']);  ?> </a>
                    <a href="./user/dashboard.php">Trang Cá Nhân</a>
                    <a href="./pages/logout.php">Đăng Xuất</a>
                <?php else : ?>
                    <a href="./pages/login.php">Đăng Nhập</a>
                    <a href="./pages/register.php">Đăng Ký</a>
                <?php endif; ?>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-0 fs-5">
            <div class="container-xxl p-0 my-1 mx-5 navbar-container">
                <a class="navbar-brand" href="./index.php">
                    <div class="logo">
                        <img src="./images/logo2.jpg" alt="Logo">
                        <div>
                            <div class="logo-item">Tiếng Anh Fighter!</div>
                            <div class="logo-row">Learning is an adventure!!!</div>
                        </div>
                    </div>
                </a>

                <div class="desktop-nav d-none d-lg-block">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php">Trang Chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#">Về Fighter &nbsp<i class="fas fa-caret-down "></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?nav=about">Giới Thiệu</a>
                                <a class="dropdown-item" href="./index.php?nav=lecturers">Đội Ngũ Giảng Viên</a>
                                <a class="dropdown-item" href="./index.php?nav=phuongphaphoc">Phương Pháp E.M.P.O.W.E.R</a>
                                <a class="dropdown-item" href="./index.php?nav=huongdandambaodaura">Chính Sách Đảm Bảo Đầu Ra</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php?nav=khoahoc">Khóa Học</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#">Học Tập & Rèn Luyện &nbsp<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?nav=question">Trắc Nghiệm Online</a>
                                <a class="dropdown-item" href="./index.php?nav=hoccungai">Học Cùng AI</a>
                                <a class="dropdown-item" href="./index.php?nav=events">Sự Kiện</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php?nav=blog">Blog Kiến Thức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php?nav=contact">Liên Hệ</a>
                        </li>
                        <li class="nav-item position-relative" id="notification-icon-desktop">
                            <a class="nav-link" href="javascript:void(0);" onclick="toggleNotificationList()">
                                <i class="fa-solid fa-bell"></i>
                                <span id="notification-badge" class="badge"></span>
                            </a>
                            <div id="notification-list" class="notification-dropdown">
                                <ul id="notification-items"></ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#searchModal">
                                <i class="fa-solid fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mobile-menu-toggle d-lg-none" id="open-mobile-nav">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </nav>
    </div>

    <div class="mobile-nav-panel" id="mobile-nav-panel">
        <div class="mobile-nav-header">
            <span class="logo-item">Menu</span>
            <i class="fa-solid fa-times" id="close-mobile-nav"></i>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="./index.php">Trang Chủ</a></li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-target="about-submenu">
                    Về Fighter
                </a>
                <div id="about-submenu" class="dropdown-menu">
                    <a class="dropdown-item" href="./index.php?nav=about">Giới Thiệu</a>
                    <a class="dropdown-item" href="./index.php?nav=lecturers">Đội Ngũ Giảng Viên</a>
                    <a class="dropdown-item" href="./index.php?nav=phuongphaphoc">Phương Pháp E.M.P.O.W.E.R</a>
                    <a class="dropdown-item" href="./index.php?nav=huongdandambaodaura">Chính Sách Đảm Bảo Đầu Ra</a>
                </div>
            </li>
            <li><a href="./index.php?nav=khoahoc">Khóa Học</a></li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-target="materials-submenu">
                    Học Tập & Rèn Luyện
                </a>
                <div id="materials-submenu" class="dropdown-menu">
                    <a class="dropdown-item" href="./index.php?nav=question">Trắc Nghiệm Online</a>
                    <a class="dropdown-item" href="./index.php?nav=hoccungai">Học Cùng AI</a>
                    <a class="dropdown-item" href="./index.php?nav=events">Sự Kiện</a>
                </div>
            </li>
            <li><a href="./index.php?nav=blog">Blog Kiến Thức</a></li>
            <li><a href="./index.php?nav=contact">Liên Hệ</a></li>
        </ul>

        <div class="mobile-action-icons">
            <div class="action-icon-item" onclick="toggleMobileNotification()">
                <i class="fa-solid fa-bell"></i>
                <span>Thông Báo</span>
                <span id="notification-badge-mobile" class="badge"></span>
            </div>
            <div class="action-icon-item" data-toggle="modal" data-target="#searchModal" onclick="closeMobileNav()">
                <i class="fa-solid fa-search"></i>
                <span>Tìm Kiếm</span>
            </div>
        </div>
    </div>
    <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>

    <div class="mobile-notification-dropdown" id="mobile-notification-dropdown">
        <div class="mobile-notification-header">
            <h5>Thông Báo</h5>
            <i class="fa-solid fa-times close-notification" onclick="closeMobileNotification()"></i>
        </div>
        <div class="mobile-notification-body">
            <ul id="mobile-notification-items"></ul>
        </div>
    </div>

    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="GET" action="index.php" style="display: flex; justify-content: space-between; padding: 6px 10px;">
                    <input type="hidden" name="nav" value="khoahoc">
                    <div style="width: 70%; display: flex; padding: 0;">
                        <input type="text" class="form-control" name="search" placeholder="Nhập từ khóa tìm kiếm" style="border: none; box-shadow: none;">
                    </div>
                    <button type="submit" class="btn" style="background-color: #28a745; color: white">
                        Tìm kiếm
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });

        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================================
            // SCRIPT ĐỂ FIX LỖI HEADER CHE MẤT NỘI DUNG
            // ==========================================================
            function setBodyPadding() {
                const header = document.querySelector('.fixed-header-container');
                if (header) {
                    document.body.style.paddingTop = header.offsetHeight + 'px';
                }
            }
            setBodyPadding();
            window.addEventListener('resize', setBodyPadding);

            // ==========================================================
            // BẮT ĐẦU: SCRIPT CHO MENU MOBILE
            // ==========================================================
            const openNavBtn = document.getElementById('open-mobile-nav');
            const closeNavBtn = document.getElementById('close-mobile-nav');
            const mobileNavPanel = document.getElementById('mobile-nav-panel');
            const overlay = document.getElementById('mobile-nav-overlay');

            window.openMobileNav = function() {
                mobileNavPanel.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            window.closeMobileNav = function() {
                mobileNavPanel.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            openNavBtn.addEventListener('click', openMobileNav);
            closeNavBtn.addEventListener('click', closeMobileNav);
            overlay.addEventListener('click', closeMobileNav);

            // ==========================================================
            // SCRIPT CHO DROPDOWN MOBILE - ACCORDION EFFECT
            // ==========================================================
            const dropdownToggles = document.querySelectorAll('.mobile-nav-links .dropdown-toggle');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const targetMenu = document.getElementById(targetId);
                    const icon = this.querySelector('.dropdown-toggle-icon');

                    targetMenu.classList.toggle('show');
                    icon.classList.toggle('active');
                });
            });

            // ==========================================================
            // SCRIPT CHO THÔNG BÁO
            // ==========================================================
            checkNotifications();
        });

        const idHocVien = <?php echo isset($_SESSION['id_hocvien']) ? $_SESSION['id_hocvien'] : 'null'; ?>;

        // Kiểm tra thông báo chưa đọc
        function checkNotifications() {
            if (!idHocVien) return;
            fetch(`user/get_unread_notifications.php?id_hocvien=${idHocVien}`)
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    const badgeMobile = document.getElementById('notification-badge-mobile');

                    if (data.error || data.length === 0) {
                        if (badge) badge.style.display = 'none';
                        if (badgeMobile) badgeMobile.style.display = 'none';
                    } else {
                        if (badge) {
                            badge.style.display = 'inline-block';
                            badge.textContent = data.length;
                        }
                        if (badgeMobile) {
                            badgeMobile.style.display = 'inline-block';
                            badgeMobile.textContent = data.length;
                        }
                    }
                })
                .catch(error => console.error('Lỗi khi kiểm tra thông báo:', error));
        }

        // Lấy tất cả thông báo và đánh dấu đã đọc (Desktop)
        function loadAndMarkNotifications() {
            if (!idHocVien) return;
            fetch('user/mark_notifications_read.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_hocvien=${idHocVien}`
                })
                .then(() => {
                    fetch(`user/get_all_notifications.php?id_hocvien=${idHocVien}`)
                        .then(response => response.json())
                        .then(data => {
                            const notificationList = document.getElementById('notification-items');
                            const dropdown = document.getElementById('notification-list');
                            notificationList.innerHTML = '';

                            if (data.error || data.length === 0) {
                                notificationList.innerHTML = '<li><div class="p-2 text-center text-muted">Không có thông báo nào.</div></li>';
                            } else {
                                data.forEach(notification => {
                                    const item = document.createElement('li');
                                    item.innerHTML = `
                                    <a href="./user/dashboard.php?nav=thongbao" style="color: black; text-decoration: none;" class="d-block p-2">
                                        <h6 style="font-size:15px; font-weight:bold; margin-bottom: 4px;">${notification.tieu_de}</h6>
                                        <p style="font-size: 14px; margin-bottom: 4px;">${notification.noi_dung}</p>
                                        <small class="text-muted">${notification.ngay_tao}</small>
                                    </a>`;
                                    notificationList.appendChild(item);
                                });
                            }
                            dropdown.style.display = 'block';
                        })
                        .catch(error => console.error('Lỗi khi tải thông báo:', error));
                })
                .catch(error => console.error('Lỗi khi đánh dấu thông báo:', error));
        }

        // Hiển thị hoặc ẩn danh sách thông báo (Desktop)
        function toggleNotificationList() {
            const dropdown = document.getElementById('notification-list');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                loadAndMarkNotifications();
            }
        }
        function toggleMobileNotification() {
            const dropdown = document.getElementById('mobile-notification-dropdown');
            const overlay = document.getElementById('mobile-nav-overlay');

            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            } else {
                loadMobileNotifications();
                dropdown.classList.add('show');
                // Giữ overlay hiển thị
            }
        }

        function closeMobileNotification() {
            const dropdown = document.getElementById('mobile-notification-dropdown');
            const overlay = document.getElementById('mobile-nav-overlay');
            dropdown.classList.remove('show');
            // Chỉ ẩn overlay nếu menu mobile cũng đã đóng
            const mobileNav = document.getElementById('mobile-nav-panel');
            if (!mobileNav.classList.contains('show')) {
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        }

        function loadMobileNotifications() {
            if (!idHocVien) return;

            fetch('user/mark_notifications_read.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_hocvien=${idHocVien}`
                })
                .then(() => {
                    fetch(`user/get_all_notifications.php?id_hocvien=${idHocVien}`)
                        .then(response => response.json())
                        .then(data => {
                            const notificationList = document.getElementById('mobile-notification-items');
                            notificationList.innerHTML = '';

                            if (data.error || data.length === 0) {
                                notificationList.innerHTML = '<li><div class="p-3 text-center text-muted">Không có thông báo nào.</div></li>';
                            } else {
                                data.forEach(notification => {
                                    const item = document.createElement('li');
                                    item.innerHTML = `
                                    <a href="./user/dashboard.php?nav=thongbao" style="color: black; text-decoration: none;" class="d-block">
                                        <h6 style="font-size:15px; font-weight:bold; margin-bottom: 4px;">${notification.tieu_de}</h6>
                                        <p style="font-size: 14px; margin-bottom: 4px;">${notification.noi_dung}</p>
                                        <small class="text-muted">${notification.ngay_tao}</small>
                                    </a>`;
                                    notificationList.appendChild(item);
                                });
                            }

                            // Cập nhật badge sau khi đánh dấu đã đọc
                            const badge = document.getElementById('notification-badge');
                            const badgeMobile = document.getElementById('notification-badge-mobile');
                            if (badge) badge.style.display = 'none';
                            if (badgeMobile) badgeMobile.style.display = 'none';
                        })
                        .catch(error => console.error('Lỗi khi tải thông báo:', error));
                })
                .catch(error => console.error('Lỗi khi đánh dấu thông báo:', error));
        }

        // Đóng notification dropdown khi click vào overlay
        document.getElementById('mobile-nav-overlay').addEventListener('click', function() {
            closeMobileNotification();
        });
    </script>
</body>

</html>