<?php
// user/modules/submit_post.php
session_start();
include('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_hocvien'])) {
    $id_tac_gia = $_SESSION['id_hocvien'];
    $tieu_de = trim($_POST['tieu_de'] ?? '');
    $noi_dung = trim($_POST['noi_dung'] ?? '');
    $hinh_anh = null;

    if (empty($tieu_de) || empty($noi_dung)) {
        $_SESSION['post_message'] = 'Lỗi: Tiêu đề và nội dung không được để trống.';
        $_SESSION['post_message_type'] = 'danger';
        header('Location: ../dashboard.php?nav=viet_bai');
        exit;
    }

    // Xử lý file upload
    if (isset($_FILES['hinh_anh_tieu_de']) && $_FILES['hinh_anh_tieu_de']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../uploads/posts/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['hinh_anh_tieu_de']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh_tieu_de']['tmp_name'], $target_file)) {
            $hinh_anh = 'uploads/posts/' . $file_name;
        }
    }

    $sql = "INSERT INTO bai_viet (tieu_de, noi_dung, hinh_anh_tieu_de, id_tac_gia, trang_thai) VALUES (?, ?, ?, ?, 'cho_duyet')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $tieu_de, $noi_dung, $hinh_anh, $id_tac_gia);

    if ($stmt->execute()) {
        $_SESSION['post_message'] = 'Gửi bài thành công! Bài viết của bạn đang chờ quản trị viên duyệt.';
        $_SESSION['post_message_type'] = 'success';
        header('Location: ../dashboard.php?nav=bai_viet_cua_toi');
    } else {
        $_SESSION['post_message'] = 'Đã có lỗi xảy ra. Vui lòng thử lại.';
        $_SESSION['post_message_type'] = 'danger';
        header('Location: ../dashboard.php?nav=viet_bai');
    }
    exit;
} else {
    header('Location: ../../index.php');
    exit;
}
?>