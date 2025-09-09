<?php
// File: xuly_dangky.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Chú ý đường dẫn tới file config, có thể cần ../../
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

    $ngay_dangky = date('Y-m-d');
    $trang_thai = 'cho xac nhan'; // Trạng thái ban đầu

    // Kiểm tra xem đã đăng ký và thanh toán thành công khóa này chưa
    $sql_check_existing = "SELECT id_dangky FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'da xac nhan'";
    $stmt_check = $conn->prepare($sql_check_existing);
    $stmt_check->bind_param("ii", $id_hocvien, $id_khoahoc);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        echo "<script>alert('Bạn đã đăng ký và thanh toán thành công khóa học này rồi.'); window.location.href='../../../index.php';</script>";
        exit();
    }
    $stmt_check->close();

    // Tạo bản ghi đăng ký mới
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