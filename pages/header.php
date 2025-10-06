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
            padding: 3px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0db33b;
        }

        .header-top .right a {
            text-decoration: none;
            margin-left: 15px;
            font-size: 16px;
            color: white;
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
            /* Mặc định ẩn trên desktop */
            font-size: 24px;
            color: #333;
            cursor: pointer;
            margin-left: auto;
            /* Đẩy nút về phía bên phải */
            padding: 5px 10px;
        }

        /* 2. Khung Menu trượt từ bên trái */
        .mobile-nav-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            /* Độ rộng của menu */
            height: 100%;
            background-color: #fff;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
            z-index: 1040;
            /* Nằm trên lớp phủ */
            transform: translateX(-100%);
            /* Ẩn đi về phía bên trái */
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            /* Cho phép cuộn nếu menu quá dài */
        }

        .mobile-nav-panel.show {
            transform: translateX(0);
            /* Hiện ra */
        }

        /* 3. Lớp phủ đen phía sau menu */
        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            /* Nằm dưới menu, trên nội dung trang */
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
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
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .mobile-nav-header .logo-item {
            font-size: 20px;
        }

        #close-mobile-nav {
            font-size: 24px;
            cursor: pointer;
        }

        .mobile-nav-links {
            list-style: none;
            padding: 15px 0;
        }

        .mobile-nav-links li a {
            display: block;
            padding: 12px 20px;
            color: #333;
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid #f0f0f0;
        }

        .mobile-nav-links li a:hover {
            background-color: #f8f9fa;
        }

        .mobile-nav-links .dropdown-toggle::after {
            float: right;
            margin-top: 8px;
        }

        .mobile-nav-links .dropdown-menu {
            position: static;
            display: none;
            border: none;
            box-shadow: none;
            background-color: #f8f9fa;
        }

        .mobile-nav-links .dropdown-menu.show {
            display: block;
        }

        .mobile-nav-links .dropdown-item {
            padding-left: 35px;
        }


        /* Quy tắc Responsive: Áp dụng khi màn hình nhỏ hơn 992px */
        @media (max-width: 991.98px) {
            .desktop-nav {
                display: none;
            }

            /* Ẩn menu desktop */
            .mobile-menu-toggle {
                display: block;
            }

            /* Hiện nút hamburger */
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
                font-size: 20px;
            }
        }

        /* ==========================================================
           CSS CŨ KHÔNG THAY ĐỔI
           ========================================================== */
        .floating-icons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 1000;
        }

        .floating-icons a {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .floating-icons a:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .messenger-icon {
            background-color: #f1e9e9ff;
            font-size: 24px;
        }

        .phone-icon {
            background-color: #2bfc5f;
            font-size: 24px;
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
            <div class="right fs-5">
                <?php if ($isLoggedIn) : ?>
                    <?php if ($isAdmin) : ?>
                        <a href="./admin/admin.php" style="font-weight: bold;">Trang Admin</a>
                    <?php endif; ?>
                    <a href="./user/dashboard.php"> <?php echo htmlspecialchars($_SESSION['user']);  ?> </a>
                    <a href="./user/dashboard.php">Thông tin cá nhân</a>
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
                            <a class="nav-link" href="./index.php">Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#">Về Fighter &nbsp<i class="fas fa-caret-down "></i> </a>
                            
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?nav=about">Giới thiệu</a>
                                <a class="dropdown-item" href="./index.php?nav=lecturers">Đội ngũ giảng viên</a>
                                <a class="dropdown-item" href="./index.php?nav=stories">Câu chuyện thành công</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php?nav=khoahoc">Khóa Học</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#">Học liệu & Thi thử &nbsp<i class="fas fa-caret-down"></i></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?nav=question">Trắc nghiệm Online</a>
                                <a class="dropdown-item" href="./index.php?nav=blog">Blog kiến thức</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php?nav=events">Sự kiện</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php?nav=contact">Liên hệ</a>
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
            <li><a href="./index.php">Trang chủ</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#about-submenu">Về Fighter   </a>
          
                <div id="about-submenu" class="collapse dropdown-menu">
                    <a class="dropdown-item" href="./index.php?nav=about">Giới thiệu</a>
                    <a class="dropdown-item" href="./index.php?nav=lecturers">Đội ngũ giảng viên</a>
                    <a class="dropdown-item" href="./index.php?nav=stories">Câu chuyện thành công</a>
                </div>
            </li>
            <li><a href="./index.php?nav=khoahoc">Khóa Học</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#materials-submenu">Học liệu & Thi thử</a>
                <div id="materials-submenu" class="collapse dropdown-menu">
                    <a class="dropdown-item" href="./index.php?nav=question">Trắc nghiệm Online</a>
                    <a class="dropdown-item" href="./index.php?nav=blog">Blog kiến thức</a>
                </div>
            </li>
            <li><a href="./index.php?nav=events">Sự kiện</a></li>
            <li><a href="./index.php?nav=contact">Liên hệ</a></li>
        </ul>
    </div>
    <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>


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
    <div class="floating-icons">
        <a href="https://www.facebook.com/profile.php?id=100091706867917&mibextid=LQQJ4d" target="_blank" class="messenger-icon" title="Chat với chúng tôi qua Messenger">
            <i class="fa-brands fa-facebook-messenger" style="color:#f448cf;"></i>
        </a>
        <a href="tel:+84123456789" class="phone-icon" title="Gọi điện cho chúng tôi">
            <i class="fa-solid fa-phone fa-shake"></i>
        </a>
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

            function openMobileNav() {
                mobileNavPanel.classList.add('show');
                overlay.classList.add('show');
            }

            function closeMobileNav() {
                mobileNavPanel.classList.remove('show');
                overlay.classList.remove('show');
            }

            openNavBtn.addEventListener('click', openMobileNav);
            closeNavBtn.addEventListener('click', closeMobileNav);
            overlay.addEventListener('click', closeMobileNav);

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
                    if (data.error || data.length === 0) {
                        badge.style.display = 'none';
                    } else {
                        badge.style.display = 'inline-block';
                        badge.textContent = data.length;
                    }
                })
                .catch(error => console.error('Lỗi khi kiểm tra thông báo:', error));
        }

        // Lấy tất cả thông báo và đánh dấu đã đọc
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
                                    <a href="./user/dashboard.php?nav=thongbao"  style="color: black; text-decoration: none;" class="d-block p-2">
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

        // Hiển thị hoặc ẩn danh sách thông báo
        function toggleNotificationList() {
            const dropdown = document.getElementById('notification-list');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                loadAndMarkNotifications();
            }
        }
    </script>
</body>

</html>