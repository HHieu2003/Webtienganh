<?php
// File: xuly_dangky.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('../../../config/config.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    die("Lỗi: Bạn cần đăng nhập để thực hiện chức năng này.");
}

$id_hocvien = $_SESSION['id_hocvien'];
$id_khoahoc = isset($_POST['id_khoahoc']) ? (int)$_POST['id_khoahoc'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$id_khoahoc) {
        die("Khóa học không hợp lệ.");
    }

    // --- LOGIC MỚI: KIỂM TRA ĐƠN ĐĂNG KÝ "CHỜ XÁC NHẬN" ĐÃ TỒN TẠI CHƯA ---
    $sql_check_pending = "SELECT id_dangky FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'cho xac nhan'";
    $stmt_check_pending = $conn->prepare($sql_check_pending);
    $stmt_check_pending->bind_param("ii", $id_hocvien, $id_khoahoc);
    $stmt_check_pending->execute();
    $result_pending = $stmt_check_pending->get_result();

    if ($result_pending->num_rows > 0) {
        // Nếu đã tồn tại đơn "chờ xác nhận", lấy ID và làm mới thời gian
        $existing_order = $result_pending->fetch_assoc();
        $existing_dangky_id = $existing_order['id_dangky'];
        $stmt_check_pending->close();

        // Cập nhật lại thời gian tạo để gia hạn thêm 5 phút
        $sql_update_time = "UPDATE dangkykhoahoc SET thoi_gian_tao = NOW() WHERE id_dangky = ?";
        $stmt_update_time = $conn->prepare($sql_update_time);
        $stmt_update_time->bind_param("i", $existing_dangky_id);
        $stmt_update_time->execute();
        $stmt_update_time->close();

        // Chuyển hướng đến trang thanh toán của đơn hàng đã có
        header("Location: checkout.php?dangky_id=" . $existing_dangky_id);
        exit();
    }
    $stmt_check_pending->close();
    // --- KẾT THÚC LOGIC MỚI ---


    // Kiểm tra xem đã đăng ký và thanh toán thành công khóa này chưa
    $sql_check_existing = "SELECT id_dangky FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'da xac nhan'";
    $stmt_check = $conn->prepare($sql_check_existing);
    $stmt_check->bind_param("ii", $id_hocvien, $id_khoahoc);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        $stmt_check->close();
        echo "<script>alert('Bạn đã đăng ký và thanh toán thành công khóa học này rồi.'); window.location.href='../../../index.php';</script>";
        exit();
    }
    $stmt_check->close();


    // Nếu không có đơn nào tồn tại, tạo bản ghi đăng ký mới
    $ngay_dangky = date('Y-m-d');
    $trang_thai = 'cho xac nhan';
    $sql_insert_dangky = "INSERT INTO dangkykhoahoc (id_hocvien, id_khoahoc, ngay_dangky, trang_thai) VALUES (?, ?, ?, ?)";
    $stmt_dangky = $conn->prepare($sql_insert_dangky);
    $stmt_dangky->bind_param("iiss", $id_hocvien, $id_khoahoc, $ngay_dangky, $trang_thai);

    if ($stmt_dangky->execute()) {
        $new_dangky_id = $stmt_dangky->insert_id;
        $stmt_dangky->close();
        
        // Chuyển hướng tới trang checkout với mã đơn hàng vừa tạo
        header("Location: checkout.php?dangky_id=" . $new_dangky_id);
        exit();
    } else {
        die("Có lỗi xảy ra trong quá trình tạo đơn đăng ký. Vui lòng thử lại.");
    }
} else {
    header("Location: ../../../index.php");
    exit();
}
?>