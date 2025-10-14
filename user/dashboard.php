<?php
session_start();
include('../config/config.php');

if (!isset($_SESSION['id_hocvien'])) {
    header("Location: ../pages/login.php");
    exit();
}

$id_hocvien = $_SESSION['id_hocvien'];
$ten_hocvien = $_SESSION['user'];
$nav = $_GET['nav'] ?? 'home';

// --- Lấy các số liệu thống kê cho toàn bộ dashboard ---

// Đếm tổng số khóa học đang học
$sql_total_courses = "SELECT COUNT(DISTINCT dk.id_khoahoc) AS total 
                      FROM dangkykhoahoc dk
                      JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
                      WHERE dk.id_hocvien = ? AND lh.trang_thai = 'dang hoc'";
$stmt_courses = $conn->prepare($sql_total_courses);
$stmt_courses->bind_param("i", $id_hocvien);
$stmt_courses->execute();
$total_courses = $stmt_courses->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_courses->close();

// Đếm tổng số bài test đã làm
$sql_total_tests = "SELECT COUNT(*) AS total FROM ketquabaitest WHERE id_hocvien = ?";
$stmt_tests = $conn->prepare($sql_total_tests);
$stmt_tests->bind_param("i", $id_hocvien);
$stmt_tests->execute();
$total_tests = $stmt_tests->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_tests->close();

// Đếm số khóa học đã hoàn thành
$sql_completed = "SELECT COUNT(DISTINCT dk.id_khoahoc) as total
                  FROM dangkykhoahoc dk
                  JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
                  WHERE dk.id_hocvien = ? AND lh.trang_thai = 'da xong'";
$stmt_completed = $conn->prepare($sql_completed);
$stmt_completed->bind_param("i", $id_hocvien);
$stmt_completed->execute();
$completed_courses = $stmt_completed->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_completed->close();

// *** BẮT ĐẦU: LOGIC MỚI ***
// Đếm tổng số buổi học trong tuần này
$today = new DateTime();
$today->setISODate((int)$today->format('Y'), (int)$today->format('W'));
$start_of_week = $today->format('Y-m-d');
$end_of_week = $today->modify('+6 days')->format('Y-m-d');

$sql_classes_this_week = "SELECT COUNT(lh.id_lichhoc) AS total
                          FROM lichhoc lh
                          JOIN dangkykhoahoc dk ON lh.id_lop = dk.id_lop
                          WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan' AND lh.ngay_hoc BETWEEN ? AND ?";
$stmt_week = $conn->prepare($sql_classes_this_week);
$stmt_week->bind_param("iss", $id_hocvien, $start_of_week, $end_of_week);
$stmt_week->execute();
$total_classes_this_week = $stmt_week->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_week->close();

// Lấy thông tin điểm danh gần nhất
$sql_latest_attendance = "SELECT dd.trang_thai, lh.ngay_hoc
                          FROM diem_danh dd
                          JOIN lichhoc lh ON dd.id_lichhoc = lh.id_lichhoc
                          WHERE dd.id_hocvien = ?
                          ORDER BY lh.ngay_hoc DESC, lh.gio_bat_dau DESC
                          LIMIT 1";
$stmt_att = $conn->prepare($sql_latest_attendance);
$stmt_att->bind_param("i", $id_hocvien);
$stmt_att->execute();
$latest_attendance = $stmt_att->get_result()->fetch_assoc();
$stmt_att->close();
// *** KẾT THÚC: LOGIC MỚI ***

// Đếm số thông báo chưa đọc để hiển thị badge
$sql_unread_notifications = "SELECT COUNT(*) as total FROM thongbao WHERE id_hocvien = ? AND trang_thai = 'chưa đọc'";
$stmt_unread = $conn->prepare($sql_unread_notifications);
$stmt_unread->bind_param("i", $id_hocvien);
$stmt_unread->execute();
$unread_count = $stmt_unread->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_unread->close();

// --- Xác định nhóm menu nào đang active để mở sẵn ---
$is_account_active = in_array($nav, ['thongtin', 'lichsuthanhtoan']);
$is_learning_active = in_array($nav, ['khoahoc', 'lichhoctuan', 'diemdanh', 'tiendo', 'hoclieu', 'ketquakiemtra', 'bangdiem']);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân - Tiếng Anh Fighter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="user.css">

    <style>
        body {
            background-color: var(--light-gray-bg);
            display: flex;
        }

        .wrapper {
            display: flex;
            width: 100%;
            position: relative;
        }

        .account-left {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: var(--white-bg);
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
            border-right: 1px solid var(--border-color);
            transition: transform 0.3s ease-in-out;
            z-index: 1045;
            display: flex;
            flex-direction: column;
        }

        .account-sidebar-content {
            padding: 20px 15px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .close-sidebar-btn {
            display: none;
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 24px;
            color: #888;
        }

        main {
            width: 100%;
            padding-left: 280px;
            transition: padding-left 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .dashboard-header {
            background-color: var(--white-bg);
            padding: 0 25px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left .logo {
            display: none;
        }

        .header-left .header-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-text);
        }

        .menu-toggle {
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            display: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-link {
            font-size: 20px;
            color: var(--gray-text);
            position: relative;
        }

        .header-link .notification-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--danger-color, #dc3545);
            color: white;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .user-name {
            font-weight: 500;
        }

        .account-right {
            padding: 30px;
            flex-grow: 1;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        @media (max-width: 991.98px) {
            .account-left {
                transform: translateX(-100%);
            }

            body.sidebar-toggled .account-left {
                transform: translateX(0);
            }

            main {
                padding-left: 0;
            }

            .menu-toggle,
            .close-sidebar-btn {
                display: block;
            }

            .header-left .logo {
                display: flex;
                height: 40px;
            }

            .header-left .logo img {
                height: 100%;
            }

            .header-left .header-title {
                display: none;
            }

            body.sidebar-toggled .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <aside class="account-left">
            <button class="close-sidebar-btn" id="close-sidebar-btn"><i class="fa-solid fa-times"></i></button>
            <div class="account-sidebar-content">
                <div class="account-header">
                    <div class="avatar">
                        <img src="../images/logo.png" alt="Avatar">
                    </div>
                    <h3><?php echo htmlspecialchars($ten_hocvien); ?></h3>
                    <p class="account-level">Học viên</p>
                </div>
                <nav class="account-nav">
                    <ul>
                        <li><a href="./dashboard.php" class="nav-link-top <?php echo ($nav == 'home' || $nav == '') ? 'active' : ''; ?>"><i class="fa-solid fa-house"></i> Bảng điều khiển</a></li>
                        <li><a href="./dashboard.php?nav=thongbao" class="nav-link-top <?php echo ($nav == 'thongbao') ? 'active' : ''; ?>"><i class="fa-solid fa-bell"></i> Thông báo <?php if ($unread_count > 0) echo "<span class='badge bg-danger ms-auto'>$unread_count</span>"; ?></a></li>
                        <li class="nav-item">
                            <a class="nav-link-collapse <?php echo $is_account_active ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#accountSubmenu" role="button" aria-expanded="<?php echo $is_account_active ? 'true' : 'false'; ?>">
                                <i class="fa-solid fa-user-gear"></i> Quản lý tài khoản <i class="collapse-arrow fa-solid fa-chevron-down"></i>
                            </a>
                            <ul class="collapse list-unstyled <?php echo $is_account_active ? 'show' : ''; ?>" id="accountSubmenu">
                                <li><a href="./dashboard.php?nav=thongtin" class="<?php echo ($nav == 'thongtin') ? 'active' : ''; ?>">Thông tin cá nhân</a></li>
                                <li><a href="./dashboard.php?nav=lichsuthanhtoan" class="<?php echo ($nav == 'lichsuthanhtoan') ? 'active' : ''; ?>">Lịch sử giao dịch</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-collapse <?php echo $is_learning_active ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#learningSubmenu" role="button" aria-expanded="<?php echo $is_learning_active ? 'true' : 'false'; ?>">
                                <i class="fa-solid fa-graduation-cap"></i> Góc học tập <i class="collapse-arrow fa-solid fa-chevron-down"></i>
                            </a>
                            <ul class="collapse list-unstyled <?php echo $is_learning_active ? 'show' : ''; ?>" id="learningSubmenu">
                                <li><a href="./dashboard.php?nav=khoahoc" class="<?php echo ($nav == 'khoahoc') ? 'active' : ''; ?>">Khóa học của tôi</a></li>
                                <li><a href="./dashboard.php?nav=lichhoctuan" class="<?php echo ($nav == 'lichhoctuan') ? 'active' : ''; ?>">Lịch học</a></li>
                                <li><a href="./dashboard.php?nav=diemdanh" class="<?php echo ($nav == 'diemdanh') ? 'active' : ''; ?>">Xem điểm danh</a></li>
                                <li><a href="./dashboard.php?nav=tiendo" class="<?php echo ($nav == 'tiendo') ? 'active' : ''; ?>">Tiến độ học tập</a></li>
                                <li><a href="./dashboard.php?nav=hoclieu" class="<?php echo ($nav == 'hoclieu') ? 'active' : ''; ?>">Học liệu</a></li>
                                <li><a href="./dashboard.php?nav=ketquakiemtra" class="<?php echo ($nav == 'ketquakiemtra') ? 'active' : ''; ?>">Kết quả bài test</a></li>
                                <li><a href="./dashboard.php?nav=bangdiem" class="<?php echo ($nav == 'bangdiem') ? 'active' : ''; ?>">Bảng điểm & Nhận xét</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="../pages/logout.php" class="nav-link-top text-danger"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <main>
            <?php include('header_user.php'); ?>
            <div class="account-right">
                <?php include('main.php'); ?>
            </div>
        </main>
    </div>

    <div class="modal fade" id="fileViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileViewerModalLabel">Nội dung học liệu</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="fileViewerContent" style="padding:0; height: 80vh;"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggleBtn = document.getElementById('menu-toggle-btn');
            const closeSidebarBtn = document.getElementById('close-sidebar-btn');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const body = document.body;

            function openSidebar() {
                body.classList.add('sidebar-toggled');
            }

            function closeSidebar() {
                body.classList.remove('sidebar-toggled');
            }

            menuToggleBtn.addEventListener('click', openSidebar);
            closeSidebarBtn.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);

            const navLinks = document.querySelectorAll('.account-nav a');
            navLinks.forEach(link => {
                if (!link.classList.contains('nav-link-collapse')) {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 992) {
                            closeSidebar();
                        }
                    });
                }
            });

            function adjustSidebar() {
                if (window.innerWidth >= 992) {
                    body.classList.add('sidebar-toggled');
                } else {
                    body.classList.remove('sidebar-toggled');
                }
            }
            adjustSidebar();
            window.addEventListener('resize', adjustSidebar);
        });
    </script>
</body>

</html>