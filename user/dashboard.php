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

// --- Lấy các số liệu thống kê ---
$sql_total_courses = "SELECT COUNT(*) AS total FROM dangkykhoahoc WHERE id_hocvien = ? AND trang_thai = 'da xac nhan'";
$stmt_courses = $conn->prepare($sql_total_courses);
$stmt_courses->bind_param("i", $id_hocvien);
$stmt_courses->execute();
$total_courses = $stmt_courses->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_courses->close();

$sql_total_transactions = "SELECT COUNT(*) AS total FROM lichsu_thanhtoan WHERE id_hocvien = ?";
$stmt_transactions = $conn->prepare($sql_total_transactions);
$stmt_transactions->bind_param("i", $id_hocvien);
$stmt_transactions->execute();
$total_transactions = $stmt_transactions->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_transactions->close();

$sql_total_tests = "SELECT COUNT(*) AS total FROM ketquabaitest WHERE id_hocvien = ?";
$stmt_tests = $conn->prepare($sql_total_tests);
$stmt_tests->bind_param("i", $id_hocvien);
$stmt_tests->execute();
$total_tests = $stmt_tests->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_tests->close();

// Đếm số thông báo chưa đọc để hiển thị badge
$sql_unread_notifications = "SELECT COUNT(*) as total FROM thongbao WHERE id_hocvien = ? AND trang_thai = 'chưa đọc'";
$stmt_unread = $conn->prepare($sql_unread_notifications);
$stmt_unread->bind_param("i", $id_hocvien);
$stmt_unread->execute();
$unread_count = $stmt_unread->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_unread->close();

// --- Xác định nhóm menu nào đang active để mở sẵn ---
$is_account_active = in_array($nav, ['thongtin', 'lichsuthanhtoan']);
$is_learning_active = in_array($nav, ['khoahoc', 'lichhoctuan', 'diemdanh', 'tiendo', 'hoclieu', 'ketquakiemtra']);
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
</head>
<body>
    <div class="wrapper">
        <header>
            <?php include('header_user.php'); ?>
        </header>
        <main>
            <div class="account">
                <aside class="account-left">
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
                        </ul>
                    </nav>
                </aside>

                <div class="account-right">
                  
                    <div class="list">
                        <?php include('main.php'); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div class="modal fade" id="fileViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="fileViewerModalLabel">Nội dung học liệu</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="fileViewerContent" style="padding:0; height: 80vh;"></div></div></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>