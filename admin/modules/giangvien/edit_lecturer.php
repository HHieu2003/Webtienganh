<?php
include('../../../config/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_giangvien = (int)$_POST['id_giangvien'];
    $ten_giangvien = $_POST['ten_giangvien'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $mo_ta = $_POST['mo_ta'];
    $mat_khau_moi = $_POST['mat_khau'];
    $hinh_anh_hien_tai = $_POST['hinh_anh_hien_tai'];

    // Xử lý ảnh mới
    $hinh_anh = $hinh_anh_hien_tai;
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../uploads/lecturers/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $file_name = time() . '_' . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh = 'uploads/lecturers/' . $file_name;
        }
    }

    // Cập nhật CSDL
    if (!empty($mat_khau_moi)) {
        // Nếu có mật khẩu mới, mã hóa và cập nhật
        $hashedPassword = password_hash($mat_khau_moi, PASSWORD_DEFAULT);
        $sql = "UPDATE giangvien SET ten_giangvien=?, email=?, so_dien_thoai=?, mat_khau=?, mo_ta=?, hinh_anh=? WHERE id_giangvien=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $ten_giangvien, $email, $so_dien_thoai, $hashedPassword, $mo_ta, $hinh_anh, $id_giangvien);
    } else {
        // Nếu không, giữ nguyên mật khẩu cũ
        $sql = "UPDATE giangvien SET ten_giangvien=?, email=?, so_dien_thoai=?, mo_ta=?, hinh_anh=? WHERE id_giangvien=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $ten_giangvien, $email, $so_dien_thoai, $mo_ta, $hinh_anh, $id_giangvien);
    }
    
    if ($stmt->execute()) {
        header('Location: ../../admin.php?nav=lecturers&status=edit_success');
    } else {
        header('Location: ../../admin.php?nav=lecturers&status=edit_error');
    }
    $stmt->close();
    $conn->close();
}
?>