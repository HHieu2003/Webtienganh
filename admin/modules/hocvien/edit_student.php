<?php
include('../../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_hocvien = (int)$_POST['id_hocvien'];
    $ten_hocvien = $_POST['ten_hocvien'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Kiểm tra xem người dùng có nhập mật khẩu mới hay không
    if (!empty($mat_khau)) {
        // Nếu có, mã hóa và cập nhật mật khẩu mới
        $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);
        $sql = "UPDATE hocvien SET ten_hocvien = ?, so_dien_thoai = ?, email = ?, mat_khau = ?, is_admin = ? WHERE id_hocvien = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $ten_hocvien, $so_dien_thoai, $email, $hashedPassword, $is_admin, $id_hocvien);
    } else {
        // Nếu không, chỉ cập nhật các thông tin khác và giữ nguyên mật khẩu cũ
        $sql = "UPDATE hocvien SET ten_hocvien = ?, so_dien_thoai = ?, email = ?, is_admin = ? WHERE id_hocvien = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $ten_hocvien, $so_dien_thoai, $email, $is_admin, $id_hocvien);
    }

    if ($stmt->execute()) {
        header('Location: ../../admin.php?nav=students&status=edit_success');
    } else {
        header('Location: ../../admin.php?nav=students&status=edit_error');
    }
    
    $stmt->close();
    $conn->close();
}
?>