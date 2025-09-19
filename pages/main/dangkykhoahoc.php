<?php
// File: dangkykhoahoc.php
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
    echo "Khóa học không hợp lệ!";
    exit;
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
    <title>Xác nhận Đăng ký Khóa học</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="pages/main/thanhtoan/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="form-container">
    <h2>Xác Nhận Đăng Ký Khóa Học</h2>
    
    <div class="info-section">
        <h3>Thông tin khóa học</h3>
        <p><strong>Tên khóa học:</strong> <?php echo htmlspecialchars($course_name); ?></p>
        <p><strong>Học phí:</strong> <?php echo number_format($course_fee); ?> VND</p>
    </div>

    <div class="info-section">
        <h3>Thông tin của bạn</h3>
        <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($ten_hocvien); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
        
        <?php if ($ghi_chu): ?>
            <p><strong>Ghi chú:</strong> <em class="text-primary"><?php echo nl2br(htmlspecialchars($ghi_chu)); ?></em></p>
            <div class="alert alert-info mt-2 small">Cảm ơn bạn đã để lại nguyện vọng. Chúng tôi sẽ liên hệ để xếp lớp cho bạn trong thời gian sớm nhất!</div>
        <?php endif; ?>
    </div>

  <form method="POST" action="pages/main/thanhtoan/xuly_dangky.php">
    <input type="hidden" name="id_khoahoc" value="<?php echo $id_khoahoc; ?>">
    <input type="hidden" name="id_lop" value="<?php echo $id_lop; ?>">
    <input type="hidden" name="ghi_chu" value="<?php echo htmlspecialchars($ghi_chu ?? ''); ?>">
    <button type="submit" class="btn-submit">Xác nhận và đến trang thanh toán</button>
</form>
</div>

</body>
</html>