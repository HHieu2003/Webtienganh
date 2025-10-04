<?php
// File: dangkykhoahoc.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_hocvien'])) {
    echo "<script>alert('Vui lòng đăng nhập để đăng ký khóa học!'); window.location.href='pages/login.php';</script>";
    exit();
}

// Lấy dữ liệu từ POST
$id_hocvien = $_SESSION['id_hocvien'];
$id_khoahoc = isset($_POST['id_khoahoc']) ? (int)$_POST['id_khoahoc'] : 0;
$id_lop = isset($_POST['id_lop']) ? htmlspecialchars($_POST['id_lop']) : null;
$ghi_chu = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : null;

if (!$id_khoahoc) {
    die("Khóa học không hợp lệ!");
}

// Lấy thông tin học viên và khóa học
$ten_hocvien = ''; $email = ''; $phone = ''; $course_name = ''; $course_fee = 0;

$sql_hocvien = "SELECT ten_hocvien, email, so_dien_thoai FROM hocvien WHERE id_hocvien = ?";
$stmt_hv = $conn->prepare($sql_hocvien);
$stmt_hv->bind_param("i", $id_hocvien);
$stmt_hv->execute();
$stmt_hv->bind_result($ten_hocvien, $email, $phone);
$stmt_hv->fetch();
$stmt_hv->close();

$sql_course = "SELECT ten_khoahoc, chi_phi FROM khoahoc WHERE id_khoahoc = ?";
$stmt_kh = $conn->prepare($sql_course);
$stmt_kh->bind_param("i", $id_khoahoc);
$stmt_kh->execute();
$result_course = $stmt_kh->get_result();

if ($result_course->num_rows > 0) {
    $course = $result_course->fetch_assoc();
    $course_name = $course['ten_khoahoc'];
    $course_fee = $course['chi_phi'];
} else {
    echo "<script>alert('Khóa học không tồn tại!'); window.location.href='index.php';</script>";
    exit;
}
$stmt_kh->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận Đăng ký - Tiếng Anh Fighter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="pages/main/thanhtoan/css/style.css">
</head>
<body>

<div class="form-container">
    <div class="container-inner">
        <div class="info-side">
            <a href="index.php" class="logo-link">
                <img src="images/logo2.jpg" alt="Logo" class="logo">
                <h3>Tiếng Anh Fighter</h3>
            </a>
            <h2>Xác nhận thông tin đăng ký</h2>
            <p class="subtitle">Vui lòng kiểm tra kỹ thông tin khóa học và thông tin cá nhân của bạn trước khi chuyển đến bước thanh toán.</p>

            <div class="info-group">
                <h5 class="group-title"><i class="fa-solid fa-book-open-reader"></i> Thông tin khóa học</h5>
                <p><strong>Khóa học:</strong> <?php echo htmlspecialchars($course_name); ?></p>
                <?php if ($ghi_chu): ?>
                    <p><strong>Ghi chú nguyện vọng:</strong> <em class="text-primary fst-italic">"<?php echo nl2br(htmlspecialchars($ghi_chu)); ?>"</em></p>
                <?php endif; ?>
            </div>

            <div class="info-group">
                <h5 class="group-title"><i class="fa-solid fa-user"></i> Thông tin của bạn</h5>
                <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($ten_hocvien); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
            </div>
        </div>

        <div class="action-side">
            <div class="summary-card">
                <h4>Tóm tắt đơn hàng</h4>
                <div class="summary-item">
                    <span>Tên khóa học</span>
                    <span class="item-value"><?php echo htmlspecialchars($course_name); ?></span>
                </div>
                <hr>
                <div class="summary-item total">
                    <span>Tổng thanh toán</span>
                    <span class="item-value total-price"><?php echo number_format($course_fee); ?> VNĐ</span>
                </div>

                <form method="POST" action="pages/main/thanhtoan/xuly_dangky.php" class="mt-4">
                    <input type="hidden" name="id_khoahoc" value="<?php echo $id_khoahoc; ?>">
                    <input type="hidden" name="id_lop" value="<?php echo $id_lop; ?>">
                    <input type="hidden" name="ghi_chu" value="<?php echo htmlspecialchars($ghi_chu ?? ''); ?>">
                    <button type="submit" class="btn-submit">
                        Xác nhận & Thanh toán <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
                 <div class="text-center mt-3">
                    <a href="javascript:history.back()" class="back-link"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>