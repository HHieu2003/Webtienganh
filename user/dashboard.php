<?php
session_start();
include('../config/config.php');

if (!isset($_SESSION['id_hocvien'])) {
    header("Location: ../pages/login.php");
    exit();
}

$id_hocvien = $_SESSION['id_hocvien'];
$ten_hocvien = $_SESSION['user'];

// Lấy trang hiện tại để làm active link menu
$nav = $_GET['nav'] ?? 'home';

// --- Lấy tổng số khóa học đã được xác nhận ---
$sql_total_courses = "SELECT COUNT(*) AS total FROM dangkykhoahoc WHERE id_hocvien = ? AND trang_thai = 'da xac nhan'";
$stmt_courses = $conn->prepare($sql_total_courses);
$stmt_courses->bind_param("i", $id_hocvien);
$stmt_courses->execute();
$total_courses = $stmt_courses->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_courses->close();

// --- Lấy tổng số giao dịch thanh toán ---
$sql_total_transactions = "SELECT COUNT(*) AS total FROM lichsu_thanhtoan WHERE id_hocvien = ?";
$stmt_transactions = $conn->prepare($sql_total_transactions);
$stmt_transactions->bind_param("i", $id_hocvien);
$stmt_transactions->execute();
$total_transactions = $stmt_transactions->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_transactions->close();

// --- Lấy tổng số khóa học đang theo dõi tiến độ ---
$sql_total_progress = "SELECT COUNT(*) AS total FROM tien_do_hoc_tap WHERE id_hocvien = ?";
$stmt_progress = $conn->prepare($sql_total_progress);
$stmt_progress->bind_param("i", $id_hocvien);
$stmt_progress->execute();
$total_progress = $stmt_progress->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_progress->close();

// --- Lấy tổng số bài test đã làm ---
$sql_total_tests = "SELECT COUNT(*) AS total FROM ketquabaitest WHERE id_hocvien = ?";
$stmt_tests = $conn->prepare($sql_total_tests);
$stmt_tests->bind_param("i", $id_hocvien);
$stmt_tests->execute();
$total_tests = $stmt_tests->get_result()->fetch_assoc()['total'] ?? 0;
$stmt_tests->close();
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
        /* Keyframes cho hiệu ứng trượt lên và mờ dần */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Áp dụng animation cho các thẻ tóm tắt */
        .summary-card {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
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
                    </div>
                    <nav class="account-nav">
                        <ul>
                            <li><a href="./dashboard.php" class="<?php echo ($nav == 'home' || $nav == '') ? 'active' : ''; ?>"><i class="fa-solid fa-house"></i> Bảng điều khiển</a></li>
                            <li><a href="./dashboard.php?nav=thongtin" class="<?php echo ($nav == 'thongtin') ? 'active' : ''; ?>"><i class="fa-solid fa-user-pen"></i> Thông tin tài khoản</a></li>
                            <li><a href="./dashboard.php?nav=khoahoc" class="<?php echo ($nav == 'khoahoc') ? 'active' : ''; ?>"><i class="fa-solid fa-book"></i> Khóa học của tôi</a></li>
                            <li><a href="./dashboard.php?nav=tiendo" class="<?php echo ($nav == 'tiendo') ? 'active' : ''; ?>"><i class="fa-solid fa-chart-line"></i> Tiến độ học tập</a></li>
                            <li><a href="./dashboard.php?nav=lichsuthanhtoan" class="<?php echo ($nav == 'lichsuthanhtoan') ? 'active' : ''; ?>"><i class="fa-solid fa-file-invoice-dollar"></i> Lịch sử thanh toán</a></li>
                             <li><a href="./dashboard.php?nav=hoclieu" class="<?php echo ($nav == 'hoclieu') ? 'active' : ''; ?>"><i class="fa-solid fa-file-lines"></i> Học liệu</a></li>
                            <li><a href="./dashboard.php?nav=ketquakiemtra" class="<?php echo ($nav == 'ketquakiemtra') ? 'active' : ''; ?>"><i class="fa-solid fa-square-poll-vertical"></i> Kết quả bài test</a></li>
                        </ul>
                    </nav>
                </aside>

                <div class="account-right">
                    <div class="summary-cards">
                        <a href="./dashboard.php?nav=khoahoc" class="summary-card courses" style="animation-delay: 100ms;">
                            <div class="icon"><i class="fa-solid fa-book"></i></div>
                            <div class="info">
                                <h3>Khóa học</h3>
                                <p><?php echo htmlspecialchars($total_courses); ?></p>
                            </div>
                        </a>
                        <!-- <a href="./dashboard.php?nav=tiendo" class="summary-card progress" style="animation-delay: 200ms;">
                            <div class="icon"><i class="fa-solid fa-chart-line"></i></div>
                            <div class="info">
                                <h3>Tiến độ</h3>
                                <p><?php echo htmlspecialchars($total_progress); ?></p>
                            </div>
                        </a> -->
                        <a href="./dashboard.php?nav=lichsuthanhtoan" class="summary-card payment" style="animation-delay: 300ms;">
                            <div class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                            <div class="info">
                                <h3>Giao dịch</h3>
                                <p><?php echo htmlspecialchars($total_transactions); ?></p>
                            </div>
                        </a>
                        <a href="./dashboard.php?nav=ketquakiemtra" class="summary-card tests" style="animation-delay: 400ms;">
                            <div class="icon"><i class="fa-solid fa-square-poll-vertical"></i></div>
                            <div class="info">
                                <h3>Bài test</h3>
                                <p><?php echo htmlspecialchars($total_tests); ?></p>
                            </div>
                        </a>
                    </div>

                    <div class="list">
                        <?php include('main.php'); ?>
                    </div>
                </div>
            </div>
        </main>
        <footer>
           
        </footer>
    </div>
     <div class="modal fade" id="fileViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileViewerModalLabel">Nội dung học liệu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="fileViewerContent" style="padding:0; height: 80vh;">
                    </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        const fileViewerModal = new bootstrap.Modal(document.getElementById('fileViewerModal'));
        const fileViewerContent = document.getElementById('fileViewerContent');
        const fileViewerTitle = document.getElementById('fileViewerModalLabel');

        function viewMaterial(filePath, fileType, fileName) {
            fileViewerContent.innerHTML = ''; // Xóa nội dung cũ
            fileViewerTitle.textContent = fileName; // Cập nhật tiêu đề

            const fullPath = `../${filePath}`; // Tạo đường dẫn tương đối từ thư mục /user/
            const fileExtension = fileType.toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                fileViewerContent.innerHTML = `<img src="${fullPath}" style="width: 100%; height: 100%; object-fit: contain;">`;
            } 
            else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
                fileViewerContent.innerHTML = `<video controls autoplay style="width: 100%; height: 100%;"><source src="${fullPath}" type="video/${fileExtension}"></video>`;
            }
            else if (fileExtension === 'pdf') {
                fileViewerContent.innerHTML = `<iframe src="${fullPath}" style="width: 100%; height: 100%; border: none;"></iframe>`;
            }
            else {
                alert('Định dạng file này không hỗ trợ xem trực tuyến, file sẽ được tải về.');
                window.location.href = fullPath; // Tải về với các định dạng khác
                return;
            }
            
            fileViewerModal.show();
        }
        
        // Dừng video/audio khi modal bị đóng để tránh phát trong nền
        document.getElementById('fileViewerModal').addEventListener('hidden.bs.modal', function () {
            fileViewerContent.innerHTML = '';
        });
    </script>
</body>
</html>