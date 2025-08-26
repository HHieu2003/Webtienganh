<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English</title>
    <link rel="stylesheet" href="./css/icon/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./pages/main.css">
    <link rel="stylesheet" href="user.css">

</head>

<body>

    <?php
    include('../config/config.php');

    session_start();
    ?>
    <div class="wrapper">
        <header>
            <?php
            include('header_user.php');

            ?>
        </header>

        <section>
            <div class="account">
                <div class="account-left">
                    <h3>Trang tài khoản cá nhân</h3>
                    <div class="avatar">
                        <div class="avatar-img">
                            <img src="../images/logo.png" alt="avata">
                        </div>
                    </div>
                    <ul>
                        <li><a href="./dashboard.php?nav=thongtin">Thông tin tài khoản</a></li>
                        <li><a href="./dashboard.php?nav=baomat">Bảo mật</a></li>
                    </ul>
                </div>

                <div class="account-right">
                    <div class="account-row">
                        <?php

                        // Giả định ID học viên từ session
                        $id_hocvien = $_SESSION['id_hocvien'] ?? null; // Thay đổi thành giá trị thực

                        // Truy vấn tổng số khóa học của học viên
                        $sql_total_courses = "SELECT COUNT(*) AS total_courses 
                              FROM dangkykhoahoc 
                              WHERE id_hocvien = ? AND trang_thai = 'da xac nhan'";
                        $stmt_courses = $conn->prepare($sql_total_courses);
                        $stmt_courses->bind_param("i", $id_hocvien);
                        $stmt_courses->execute();
                        $result_courses = $stmt_courses->get_result();
                        $total_courses = $result_courses->fetch_assoc()['total_courses'] ?? 0;

                        // Truy vấn tổng số giao dịch trong lịch sử thanh toán
                        $sql_total_transactions = "SELECT COUNT(*) AS total_transactions 
                                   FROM lichsu_thanhtoan 
                                   WHERE id_hocvien = ?";
                        $stmt_transactions = $conn->prepare($sql_total_transactions);
                        $stmt_transactions->bind_param("i", $id_hocvien);
                        $stmt_transactions->execute();
                        $result_transactions = $stmt_transactions->get_result();
                        $total_transactions = $result_transactions->fetch_assoc()['total_transactions'] ?? 0;


                        // Truy vấn tổng số tiến độ học tập
                        $sql_total_progress = "SELECT COUNT(*) AS total_progress FROM tien_do_hoc_tap WHERE id_hocvien = ?";
                        $stmt_progress = $conn->prepare($sql_total_progress);
                        $stmt_progress->bind_param("i", $id_hocvien);
                        $stmt_progress->execute();
                        $result_progress = $stmt_progress->get_result();
                        $total_progress = $result_progress->fetch_assoc()['total_progress'] ?? 0;

                        // Truy vấn tổng số kết quả kiểm tra
                        $sql_total_tests = "SELECT COUNT(*) AS total_tests FROM ketquabaitest WHERE id_hocvien = ?";
                        $stmt_tests = $conn->prepare($sql_total_tests);
                        $stmt_tests->bind_param("i", $id_hocvien);
                        $stmt_tests->execute();
                        $result_tests = $stmt_tests->get_result();
                        $total_tests = $result_tests->fetch_assoc()['total_tests'] ?? 0;
                        ?>

                        <!-- Khóa học của tôi -->
                        <a href="./dashboard.php?nav=khoahoc" class="account-1">
                            <div class="account-1-item">
                                <h1>Khóa học của tôi</h1>
                                <p><?= htmlspecialchars($total_courses) ?></p>
                            </div>
                        </a>

                        <!-- Tiến độ học tập -->
                        <a href="./dashboard.php?nav=tiendo" class="account-3 account-1">
                            <div class="account-1-item">
                                <h1>Tiến độ học tập</h1>
                                <p><?= htmlspecialchars($total_progress) ?></p>

                            </div>
                        </a>

                        <!-- Lịch sử thanh toán -->
                        <a href="./dashboard.php?nav=lichsuthanhtoan" class="account-2 account-1">
                            <div class="account-1-item">
                                <h1>Lịch sử thanh toán</h1>
                                <p><?= htmlspecialchars($total_transactions) ?></p>
                            </div>
                        </a>
                        <a href="./dashboard.php?nav=ketquakiemtra" class="account-4 account-1">
                            <div class="account-1-item">
                                <h1>Kết quả bài test</h1>
                                <p><?= htmlspecialchars($total_tests) ?></p>

                            </div>
                        </a>

                    </div>

                    <div class="list">
                        <?php
                        include('main.php');
                        ?>
                    </div>
                </div>

            </div>

        </section>
        <footer>
            <?php
            include('footer_user.php');

            ?>
        </footer>
    </div>

</body>

</html>