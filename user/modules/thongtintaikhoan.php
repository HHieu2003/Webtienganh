<?php
// user/modules/thongtintaikhoan.php
$info_message = '';
$info_message_type = '';
$password_message = '';
$password_message_type = '';
$avatar_message = '';
$avatar_message_type = '';
$id_hocvien = $_SESSION['id_hocvien'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xử lý upload ảnh đại diện
    if (isset($_POST['update_avatar']) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB
        $file = $_FILES['avatar'];

        if (!in_array($file['type'], $allowed_types)) {
            $avatar_message = "Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WEBP)!";
            $avatar_message_type = 'danger';
        } elseif ($file['size'] > $max_size) {
            $avatar_message = "Kích thước file không được vượt quá 5MB!";
            $avatar_message_type = 'danger';
        } else {
            // Đường dẫn upload (từ user/modules/ lên root rồi vào uploads/students/)
            $target_dir = "../uploads/students/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_name = time() . '_' . basename($file['name']);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Xóa ảnh cũ nếu có
                $sql_old = "SELECT hinh_anh FROM hocvien WHERE id_hocvien = ?";
                $stmt_old = $conn->prepare($sql_old);
                $stmt_old->bind_param("i", $id_hocvien);
                $stmt_old->execute();
                $result_old = $stmt_old->get_result();
                if ($row_old = $result_old->fetch_assoc()) {
                    if (!empty($row_old['hinh_anh'])) {
                        $old_file = "../" . $row_old['hinh_anh'];
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                }
                $stmt_old->close();

                // Lưu đường dẫn vào database (tương đối từ root)
                $hinh_anh = 'uploads/students/' . $file_name;
                $sql_avatar = "UPDATE hocvien SET hinh_anh = ? WHERE id_hocvien = ?";
                $stmt_avatar = $conn->prepare($sql_avatar);
                $stmt_avatar->bind_param("si", $hinh_anh, $id_hocvien);

                if ($stmt_avatar->execute()) {
                    $avatar_message = "Cập nhật ảnh đại diện thành công!";
                    $avatar_message_type = 'success';
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = './dashboard.php?nav=thongtin';
                        }, 1500);
                    </script>";
                } else {
                    $avatar_message = "Lỗi khi lưu ảnh vào database: " . $conn->error;
                    $avatar_message_type = 'danger';
                }
                $stmt_avatar->close();
            } else {
                $avatar_message = "Lỗi khi upload file!";
                $avatar_message_type = 'danger';
            }
        }
    } elseif (isset($_POST['update_avatar'])) {
        $avatar_message = "Vui lòng chọn file ảnh!";
        $avatar_message_type = 'danger';
    }

    // Xử lý cập nhật thông tin cá nhân
    if (isset($_POST['update_info'])) {
        $ten_hocvien = trim($_POST['ten_hocvien']);
        $so_dien_thoai = trim($_POST['so_dien_thoai']);
        if (empty($ten_hocvien) || empty($so_dien_thoai)) {
            $info_message = "Tên và số điện thoại không được để trống.";
            $info_message_type = 'danger';
        } elseif (!preg_match('/^[0-9]{10,11}$/', $so_dien_thoai)) {
            $info_message = "Số điện thoại không hợp lệ.";
            $info_message_type = 'danger';
        } else {
            $sql_update = "UPDATE hocvien SET ten_hocvien = ?, so_dien_thoai = ? WHERE id_hocvien = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('ssi', $ten_hocvien, $so_dien_thoai, $id_hocvien);
            if ($stmt_update->execute()) {
                $info_message = "Cập nhật thông tin thành công!";
                $info_message_type = 'success';
                $_SESSION['user'] = $ten_hocvien; // Cập nhật lại session name
            } else {
                $info_message = "Lỗi khi cập nhật thông tin.";
                $info_message_type = 'danger';
            }
            $stmt_update->close();
        }
    }
    // Xử lý đổi mật khẩu
    if (isset($_POST['change_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        if ($new_password !== $confirm_password) {
            $password_message = "Mật khẩu mới và mật khẩu xác nhận không khớp!";
            $password_message_type = 'danger';
        } elseif (strlen($new_password) < 6) {
            $password_message = "Mật khẩu mới phải có ít nhất 6 ký tự.";
            $password_message_type = 'danger';
        } else {
            $sql_pw = "SELECT mat_khau FROM hocvien WHERE id_hocvien = ?";
            $stmt_pw = $conn->prepare($sql_pw);
            $stmt_pw->bind_param("i", $id_hocvien);
            $stmt_pw->execute();
            $result_pw = $stmt_pw->get_result();
            if ($row = $result_pw->fetch_assoc()) {
                if (password_verify($old_password, $row['mat_khau'])) {
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql_update_pw = "UPDATE hocvien SET mat_khau = ? WHERE id_hocvien = ?";
                    $stmt_update_pw = $conn->prepare($sql_update_pw);
                    $stmt_update_pw->bind_param("si", $hashed_new_password, $id_hocvien);
                    if ($stmt_update_pw->execute()) {
                        $password_message = "Thay đổi mật khẩu thành công!";
                        $password_message_type = 'success';
                    } else {
                        $password_message = "Lỗi khi cập nhật mật khẩu.";
                        $password_message_type = 'danger';
                    }
                    $stmt_update_pw->close();
                } else {
                    $password_message = "Mật khẩu cũ không chính xác!";
                    $password_message_type = 'danger';
                }
            }
            $stmt_pw->close();
        }
    }
}

// Lấy thông tin mới nhất của học viên để hiển thị
$sql_student = "SELECT ten_hocvien, email, so_dien_thoai FROM hocvien WHERE id_hocvien = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $id_hocvien);
$stmt_student->execute();
$student = $stmt_student->get_result()->fetch_assoc();
$stmt_student->close();
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-card {
        background-color: #fff;
        padding: 25px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        height: 100%;
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .form-card-header {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .form-card-header h5 {
        font-weight: 600;
        font-size: 18px;
        color: var(--dark-text);
        margin: 0;
    }

    .form-card-header i {
        color: var(--primary-color);
    }

    .input-group-text.verified {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        font-weight: 500;
    }

    .btn-save {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        background-color: var(--primary-color);
        border: none;
        color: #fff;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        background-color: var(--primary-color-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.3);
    }

    @media (max-width: 500px) {
        .input-group-text:last-child {}
    }
</style>
<div class="content-pane">
    <h2 class="mb-4">Cài đặt tài khoản</h2>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-card" style="animation-delay: 100ms;">
                <div class="form-card-header">
                    <h5><i class="fa-solid fa-user-pen me-2"></i>Thông tin cá nhân</h5>
                </div>

                <!-- Phần ảnh đại diện -->
                <div class="text-center mb-4 pt-3">
                    <label class="form-label fw-bold">Ảnh đại diện</label>
                    <?php
                    $sql_avatar = "SELECT hinh_anh FROM hocvien WHERE id_hocvien = ?";
                    $stmt_avatar = $conn->prepare($sql_avatar);
                    $stmt_avatar->bind_param("i", $id_hocvien);
                    $stmt_avatar->execute();
                    $result_avatar = $stmt_avatar->get_result();
                    $student_avatar = '../images/logo.png';
                    if ($row_avatar = $result_avatar->fetch_assoc()) {
                        if (!empty($row_avatar['hinh_anh'])) {
                            $student_avatar = "../" . $row_avatar['hinh_anh'];
                        }
                    }
                    $stmt_avatar->close();
                    ?>
                    <div class="mb-3">
                        <img id="avatar-preview"
                            src="<?php echo htmlspecialchars($student_avatar); ?>"
                            alt="Avatar"
                            class="img-thumbnail rounded-circle mb-2"
                            style="width: 150px; height: 150px; object-fit: cover;"
                            onerror="this.src='../images/logo.png';">
                    </div>
                    <form method="POST" action="./dashboard.php?nav=thongtin" enctype="multipart/form-data" class="mb-3">
                        <input type="file"
                            name="avatar"
                            id="avatar"
                            class="form-control mb-2"
                            accept="image/*"
                            onchange="previewAvatar(this)">
                        <button type="submit" name="update_avatar" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-upload me-1"></i>Cập nhật ảnh
                        </button>
                    </form>
                    <?php if (!empty($avatar_message)): ?>
                        <div class="alert alert-<?php echo $avatar_message_type; ?> py-2 px-3 small">
                            <?php echo $avatar_message; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($info_message)): ?>
                    <div class="alert alert-<?php echo $info_message_type; ?> mb-4"><?php echo $info_message; ?></div>
                <?php endif; ?>

                <form method="POST" action="./dashboard.php?nav=thongtin">
                    <div class="mb-3">
                        <label for="ten_hocvien" class="form-label">Họ và Tên</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="ten_hocvien" id="ten_hocvien" class="form-control" value="<?php echo htmlspecialchars($student['ten_hocvien']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" name="so_dien_thoai" id="so_dien_thoai" class="form-control" value="<?php echo htmlspecialchars($student['so_dien_thoai']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" readonly>
                            <span class="input-group-text verified"><i class="fa-solid fa-circle-check"></i> Đã xác thực</span>
                        </div>
                    </div>
                    <button class="btn-save" type="submit" name="update_info">Lưu thông tin</button>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-card" style="animation-delay: 200ms;">
                <div class="form-card-header">
                    <h5><i class="fa-solid fa-key me-2"></i>Bảo mật & Mật khẩu</h5>
                </div>

                <?php if (!empty($password_message)): ?>
                    <div class="alert alert-<?php echo $password_message_type; ?> mb-4"><?php echo $password_message; ?></div>
                <?php endif; ?>

                <form method="POST" action="./dashboard.php?nav=thongtin">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Mật khẩu cũ</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock-open"></i></span>
                            <input type="password" name="old_password" id="old_password" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Ít nhất 6 ký tự" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>
                    </div>
                    <button class="btn-save" type="submit" name="change_password">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>