<?php
// File: dangkykhoahoc.php

// Session và config đã được gọi từ file index.php cha.

// Kiểm tra đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    echo "<script>alert('Vui lòng đăng nhập để đăng ký khóa học!'); window.location.href='pages/login.php';</script>";
    exit();
}

$id_hocvien = $_SESSION['id_hocvien'];
$id_khoahoc = isset($_GET['id_khoahoc']) ? (int)$_GET['id_khoahoc'] : 0;

if (!$id_khoahoc) {
    echo "Khóa học không hợp lệ!";
    exit;
}

// Lấy thông tin học viên và khóa học để hiển thị trên form
$ten_hocvien = '';
$email = '';
$phone = '';
$course_name = '';
$course_fee = 0;

// Lấy thông tin học viên
$sql_hocvien = "SELECT ten_hocvien, email, so_dien_thoai FROM hocvien WHERE id_hocvien = ?";
$stmt_hv = $conn->prepare($sql_hocvien);
$stmt_hv->bind_param("i", $id_hocvien);
$stmt_hv->execute();
$stmt_hv->bind_result($ten_hocvien, $email, $phone);
$stmt_hv->fetch();
$stmt_hv->close();

// Lấy thông tin khóa học
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

<div class="container">
    <h2>Xác Nhận Đăng Ký Khóa Học</h2>
    
    <div class="course-info">
        <h3>Thông tin khóa học</h3>
        <p><strong>Tên khóa học:</strong> <?php echo htmlspecialchars($course_name); ?></p>
        <p><strong>Học phí:</strong> <?php echo number_format($course_fee); ?> VND</p>
    </div>

    <div class="student-info">
        <h3>Thông tin của bạn</h3>
        <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($ten_hocvien); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
    </div>

    <form method="POST" action="pages/main/thanhtoan/xuly_dangky.php">
        <input type="hidden" name="id_khoahoc" value="<?php echo $id_khoahoc; ?>">
        <button type="submit" class="btn-submit">Xác nhận và Thanh toán</button>
    </form>
</div>