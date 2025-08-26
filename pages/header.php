<?php
$isLoggedIn = isset($_SESSION['id_hocvien']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin']; // Kiểm tra nếu là admin
?>
<style>
    /*----------------header top-----------------*/
    .header-top {
        color: #fff;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #0db33b;
        display: flex;
    }

    .header-top .left,
    .header-top .right {
        display: flex;
        align-items: center;
    }

    .header-top .right a {
        text-decoration: none;
        margin-left: 15px;
        font-size: 17px;
        color: white;
    }

    .header-top a:not(:last-child)::after {
        content: " | ";
        color: white;
        padding-left: 10px;
        font-weight: 900;
    }

    .header-top .right a:hover {
        text-decoration: underline;
    }

    /*--------------header main----------------*/
    /* .header {
        background-color: #f3f7f8;
        color: white;
        padding: 5px 25px;
        font-size: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    } */

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 60px;
        margin-right: 10px;
    }

    .logo-item {
        font-size: 24px;
        color: #0db33b;
        font-weight: bold;
    }

    .logo-row {
        font-size: 14px;
        color: #666;
    }

    /*----------menu---------*/
    .menu {
        margin-left: auto;
        display: flex;
        align-items: center;

    }

    .menu>ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .menu>ul>li {
        position: relative;
        padding: 0px 5px;
    }

    .menu>ul>li>a {
        color: #333;
        text-decoration: none;
        padding: 10px 15px;
        font-size: 17px;
        display: block;
    }

    .menu>ul>li>a:hover {
        color: #0db33b;
    }

    /*------------menu item------------*/
    .menu-item {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        min-width: 150px;
    }

    .menu-item li {
        width: 100%;
    }

    .menu-item li a {
        padding: 10px 15px;
        color: #333;
        display: block;
        text-decoration: none;
        font-size: 14px;
    }

    .menu-item li a:hover {
        background-color: #f3f3f3;
        color: #0db33b;
    }

    .menu>ul>li:hover .menu-item {
        display: block;
    }

    .icon {
        position: relative;
        font-size: 20px;
        color: #333;
        margin-left: 20px;
    }

    /* CSS cho phần bong bóng chat nổi */
    .floating-icons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        z-index: 1000;
        gap: 10px;
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
        background-color: #f7b4f1;
        /* Màu của Messenger */
        font-size: 24px;
    }

    .phone-icon {
        background-color: #2bfc5f;
        font-size: 24px;
    }
</style>
<!-- Header (Navigation Bar) -->

<div class="header-top  ">
    <div class="left">
        Hotline: 0962.501.832 - 0336.123.130
    </div>
    <div class="right fs-5">
        <?php if ($isLoggedIn) : ?>
            <!-- Liên kết đến Dashboard nếu học viên đã đăng nhập -->
            <?php if ($isAdmin) : ?>
                <!-- Liên kết đến trang Admin Dashboard nếu là admin -->
                <a class="" href="./admin/admin.php" style=" font-weight: bold;">Trang Admin</a>
            <?php endif; ?>

            <a class="" href="./user/dashboard.php"> <?php echo $_SESSION['user'];  ?> </a>

            <a class="" href="./user/dashboard.php">Thông tin cá nhân</a>
            <a class="" href="./pages/login.php">Đăng Xuất</a>

        <?php else : ?>
            <!-- Hiển thị nút Đăng nhập và Đăng ký nếu học viên chưa đăng nhập -->

            <a class="" href="./pages/login.php">Đăng Nhập</a>

            <a class="" href="./pages/register.php">Đăng Ký</a>

        <?php endif; ?>

    </div>
</div>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top p-0 fs-5">

    <div class="container-xxl p-0 my-1 mx-5">
        <a class="navbar-brand" href="./index.php">
            <div class="logo">
                <img src="./images/logo2.jpg" alt="Logo">
                <div>
                    <div class="logo-item">Tiếng Anh Fighter!</div>
                    <div class="logo-row">Learning is an adventure!!!</div>
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="menu  collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?nav=khoahoc">Khóa Học</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?nav=question">Trắc Nghiệm</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./index.php?nav=about">Giới thiệu</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?nav=huongdandangky">Hướng dẫn đăng ký</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./tintuc.php?nav=about">Tin TTức </a>

                </li>

                <li class="nav-item position-relative" id="notification-icon">
                    <a class="nav-link" href="javascript:void(0);" onclick="toggleNotificationList()">
                        <i class="fa-solid fa-bell"></i>
                        <span id="notification-badge" class="badge"></span>
                    </a>
                    <div id="notification-list" class="notification-dropdown">
                        <!-- <h6>Thông báo</h6> -->
                        <ul id="notification-items"></ul>
                    </div>
                </li>

                <!-- Search Icon -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#searchModal">
                        <i class="fa-solid fa-search"></i>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Tìm kiếm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="">
                <form method="GET" action="index.php" style="display: flex;     justify-content: space-between;
    padding: 6px 10px; ">
                    <input type="hidden" name="nav" value="khoahoc">

                    <div class="" style="width: 70%; display: flex;
    padding: 0;">
                        <input type="text" class="" name="search" placeholder="Nhập từ khóa tìm kiếm" style="padding: 5px 5px; margin: auto 0px auto 0px;     width: 100%;border: none;  ">
                    </div>

                    <button type="submit" class="btn " style="background-color: #28a745; color: white">
                        Tìm kiếm

                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">


<!-- <div class="floating-icons">
    <a href="https://www.facebook.com/profile.php?id=100091706867917&mibextid=LQQJ4d target=" _blank" class="messenger-icon" title="Chat với chúng tôi qua Messenger">
        <i class="fa-brands fa-facebook-messenger " style="color: #f448cf;"></i>
    </a>

    <a href="tel:+84123456789" class="phone-icon" title="Gọi điện cho chúng tôi">
        <i class="fa-solid fa-phone fa-shake"></i>
    </a>
</div> -->


<style>
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
        /* Ẩn mặc định */
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

    .notification-dropdown h6 {
        font-size: 16px;
        padding: 10px;
        border-bottom: 1px solid #eee;
        margin: 0;
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
        border-bottom: 1px solid #333;
    }

    .notification-dropdown ul li:last-child {
        border-bottom: none;
    }

    .notification-dropdown ul li:hover {
        background: #f8f9fa;
    }
</style>



<script>
    const idHocVien = <?php echo isset($_SESSION['id_hocvien']) ? $_SESSION['id_hocvien'] : 'null'; ?>;

    // Kiểm tra thông báo chưa đọc
    function checkNotifications() {
        if (!idHocVien) return;

        fetch(`user/get_unread_notifications.php?id_hocvien=${idHocVien}`)
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notification-badge');
                if (data.error || data.length === 0) {
                    badge.style.display = 'none'; // Không có thông báo chưa đọc
                } else {
                    badge.style.display = 'inline-block'; // Hiển thị chấm đỏ
                    badge.textContent = data.length;
                }
            })
            .catch(error => console.error('Lỗi khi kiểm tra thông báo:', error));
    }

    // Lấy tất cả thông báo và đánh dấu đã đọc
    function loadAndMarkNotifications() {
        if (!idHocVien) return;

        // Đánh dấu thông báo là đã đọc
        fetch('user/mark_notifications_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_hocvien=${idHocVien}`
            })
            .then(() => {
                // Tải tất cả thông báo
                fetch(`user/get_all_notifications.php?id_hocvien=${idHocVien}`)
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById('notification-items');
                        const dropdown = document.getElementById('notification-list');

                        notificationList.innerHTML = '';
                        if (data.error || data.length === 0) {
                            notificationList.innerHTML = '<li>Không có thông báo nào.</li>';
                        } else {
                            data.forEach(notification => {
                                const item = document.createElement('li');
                                item.innerHTML = `
                                    <h6 style="font-size:15px; font-weight:bold; padding:4px 0px;">${notification.tieu_de}</h6>
                                    <p >${notification.noi_dung}</p>
                                    <small>${notification.ngay_tao}</small>
                                 <!--  <span style="color: ${notification.trang_thai === 'chưa đọc' ? 'red' : 'green'};"> (${notification.trang_thai}) -->
                                    </span>
                                `;
                                notificationList.appendChild(item);
                            });
                        }

                        dropdown.style.display = 'block'; // Hiển thị danh sách
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
            loadAndMarkNotifications(); // Tải thông báo và đánh dấu là đã đọc
        }
    }

    // Kiểm tra thông báo chưa đọc khi trang tải
    document.addEventListener('DOMContentLoaded', checkNotifications);
</script>