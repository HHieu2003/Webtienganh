<?php
include('../../../config/config.php');

// Kiểm tra nếu có dữ liệu POST gửi đến thêm học viên
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form và xử lý để tránh SQL Injection
    $ten_hocvien = mysqli_real_escape_string($conn, $_POST['ten_hocvien']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mat_khau = mysqli_real_escape_string($conn, $_POST['mat_khau']);
    $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT); // Thêm dòng này

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
    $sql_check = "SELECT * FROM hocvien WHERE email = '$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Nếu email đã tồn tại
        echo "<script>
            alert('Email đã tồn tại trong hệ thống!');
            window.location.href='../../admin.php?nav=students';
        </script>";
        exit;
    } else {
        // Thực hiện thêm học viên vào cơ sở dữ liệu
        $sql = "INSERT INTO hocvien (ten_hocvien, so_dien_thoai, email, mat_khau) 
        VALUES ('$ten_hocvien', '$so_dien_thoai', '$email', '$hashedPassword')";
        if (mysqli_query($conn, $sql)) {
            // Nếu thêm thành công, chuyển hướng về trang quản lý học viên
            echo "<script>
                alert('Thêm học viên thành công!');
                window.location.href='../../admin.php?nav=students';
            </script>";
            exit;
        } else {
            // Nếu có lỗi khi thêm
            $error_message = mysqli_error($conn);
            echo "<script>
                alert('Lỗi khi thêm học viên: $error_message');
                window.location.href='../../admin.php?nav=students';
            </script>";
            exit;
        }
    }
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
