<?php
// PHP logic (đã kiểm tra và giữ nguyên từ lần trước)
$info_message = '';
$info_message_type = '';
$password_message = '';
$password_message_type = '';
$id_hocvien = $_SESSION['id_hocvien'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $_SESSION['user'] = $ten_hocvien;
            } else {
                $info_message = "Lỗi khi cập nhật thông tin.";
                $info_message_type = 'danger';
            }
            $stmt_update->close();
        }
    }
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
$show_password_form = !empty($password_message);
$sql_student = "SELECT ten_hocvien, email, so_dien_thoai FROM hocvien WHERE id_hocvien = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $id_hocvien);
$stmt_student->execute();
$student = $stmt_student->get_result()->fetch_assoc();
$stmt_student->close();
?>

<div class="content-pane">
    <div class="pane-header">
        <h2 id="pane-title">Thông tin tài khoản</h2>
        <button id="toggle-form-btn" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-key"></i> Thay đổi mật khẩu
        </button>
    </div>

    <div id="info-form-container" class="form-container <?php if ($show_password_form) echo 'hidden'; ?>">
        <?php if (!empty($info_message)): ?>
            <div class="alert alert-<?php echo $info_message_type; ?> mb-4"><?php echo $info_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="./dashboard.php?nav=thongtin">
            <div class="form-group">
                <label for="ten_hocvien">Họ và Tên</label>
                <input type="text" name="ten_hocvien" id="ten_hocvien" class="form-control" value="<?php echo htmlspecialchars($student['ten_hocvien']); ?>" required>
            </div>
            <div class="form-group">
                <label for="so_dien_thoai">Số điện thoại</label>
                <input type="tel" name="so_dien_thoai" id="so_dien_thoai" class="form-control" value="<?php echo htmlspecialchars($student['so_dien_thoai']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group">
                    <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" readonly>
                    <span class="input-group-text verified"><i class="fa-solid fa-circle-check"></i> Đã xác thực</span>
                </div>
            </div>
            <button class="btn-save mt-3" type="submit" name="update_info">Lưu thông tin</button>
        </form>
    </div>

    <div id="password-form-container" class="form-container <?php if (!$show_password_form) echo 'hidden'; ?>">
        <?php if (!empty($password_message)): ?>
            <div class="alert alert-<?php echo $password_message_type; ?> mb-4"><?php echo $password_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="./dashboard.php?nav=thongtin">
            <div class="form-group">
                <label for="old_password">Mật khẩu cũ</label>
                <input type="password" name="old_password" id="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Ít nhất 6 ký tự" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button class="btn-save mt-3" type="submit" name="change_password">Đổi mật khẩu</button>
        </form>
    </div>
</div>

<style>
    .pane-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color); }
    .pane-header h2 { margin: 0; padding: 0; border: none; }
    .form-group .input-group .form-control[readonly] { background-color: #e9ecef; cursor: not-allowed; }
    .input-group-text.verified { color: #155724; background-color: #d4edda; border-color: #c3e6cb; font-weight: 500; }
    
    /* CSS cho hiệu ứng chuyển đổi */
    .form-container {
        transition: opacity 0.4s ease-out, transform 0.4s ease-out, max-height 0.5s ease-in-out;
        opacity: 1;
        transform: translateY(0);
        overflow: hidden;
        max-height: 1000px; /* Chiều cao đủ lớn */
    }
    .form-container.hidden {
        opacity: 0;
        transform: translateY(10px);
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const infoContainer = document.getElementById('info-form-container');
    const passwordContainer = document.getElementById('password-form-container');
    const toggleBtn = document.getElementById('toggle-form-btn');
    const paneTitle = document.getElementById('pane-title');
    
    let isShowingPassword = passwordContainer.classList.contains('hidden') ? false : true;

    function updateView() {
        if (isShowingPassword) {
            infoContainer.classList.add('hidden');
            passwordContainer.classList.remove('hidden');
            paneTitle.textContent = 'Thay đổi mật khẩu';
            toggleBtn.innerHTML = '<i class="fa-solid fa-arrow-left"></i> Quay lại thông tin';
        } else {
            infoContainer.classList.remove('hidden');
            passwordContainer.classList.add('hidden');
            paneTitle.textContent = 'Thông tin tài khoản';
            toggleBtn.innerHTML = '<i class="fa-solid fa-key"></i> Thay đổi mật khẩu';
        }
    }

    toggleBtn.addEventListener('click', function() {
        isShowingPassword = !isShowingPassword;
        updateView();
    });

    // Cập nhật view lần đầu khi tải trang
    updateView();
});
</script>