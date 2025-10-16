<?php
// user/modules/update_post.php
session_start();
include('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_hocvien'])) {
    $id_hocvien = $_SESSION['id_hocvien'];
    $id_baiviet = (int)($_POST['id_baiviet'] ?? 0);
    $tieu_de = trim($_POST['tieu_de'] ?? '');
    $noi_dung = trim($_POST['noi_dung'] ?? '');
    $old_image_path = $_POST['old_image_path'] ?? '';
    $hinh_anh = $old_image_path;

    if ($id_baiviet === 0 || empty($tieu_de) || empty($noi_dung)) {
        $_SESSION['post_message'] = 'Lỗi: Dữ liệu không hợp lệ.';
        $_SESSION['post_message_type'] = 'danger';
        header('Location: ../dashboard.php?nav=bai_viet_cua_toi');
        exit;
    }

    // Xử lý upload ảnh mới nếu có
    if (isset($_FILES['hinh_anh_tieu_de']) && $_FILES['hinh_anh_tieu_de']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../uploads/posts/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['hinh_anh_tieu_de']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['hinh_anh_tieu_de']['tmp_name'], $target_file)) {
            $hinh_anh = 'uploads/posts/' . $file_name;
            // Xóa ảnh cũ nếu upload ảnh mới thành công và có ảnh cũ
            if (!empty($old_image_path) && file_exists('../../' . $old_image_path)) {
                unlink('../../' . $old_image_path);
            }
        }
    }

    // Cập nhật bài viết và đặt lại trạng thái là 'cho_duyet'
    $sql = "UPDATE bai_viet SET tieu_de = ?, noi_dung = ?, hinh_anh_tieu_de = ?, trang_thai = 'cho_duyet' 
            WHERE id_baiviet = ? AND id_tac_gia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $tieu_de, $noi_dung, $hinh_anh, $id_baiviet, $id_hocvien);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['post_message'] = 'Cập nhật bài viết thành công! Bài viết đã được gửi lại để chờ duyệt.';
            $_SESSION['post_message_type'] = 'success';
        } else {
            $_SESSION['post_message'] = 'Không có thay đổi nào hoặc bạn không có quyền sửa bài viết này.';
            $_SESSION['post_message_type'] = 'warning';
        }
    } else {
        $_SESSION['post_message'] = 'Đã có lỗi xảy ra khi cập nhật. Vui lòng thử lại.';
        $_SESSION['post_message_type'] = 'danger';
    }
    header('Location: ../dashboard.php?nav=bai_viet_cua_toi');
    exit;
} else {
    header('Location: ../../index.php');
    exit;
}
?>