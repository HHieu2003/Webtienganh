<?php
include('../../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form chỉnh sửa
    $id_hocvien = $_POST['id_hocvien'];
    $ten_hocvien = mysqli_real_escape_string($conn, $_POST['ten_hocvien']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mat_khau = mysqli_real_escape_string($conn, $_POST['mat_khau']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    
    // Mã hóa mật khẩu
   // $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);

    // Cập nhật thông tin học viên vào cơ sở dữ liệu
    $sql = "UPDATE hocvien 
            SET ten_hocvien = '$ten_hocvien', so_dien_thoai = '$so_dien_thoai', email = '$email', mat_khau = '$mat_khau', is_admin = '$is_admin'
            WHERE id_hocvien = $id_hocvien";

    if (mysqli_query($conn, $sql)) {
        header('Location: ../../admin.php?nav=students');

    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>
