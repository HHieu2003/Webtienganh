<?php
session_start();
include("../config/config.php");
date_default_timezone_set('Asia/Ho_Chi_Minh'); // <-- DÒNG QUAN TRỌNG ĐƯỢC THÊM VÀO

$message = '';
$message_type = 'danger';
$token_valid = false;
$token = $_GET['token'] ?? '';

if (!empty($token)) {
    // Kiểm tra token có hợp lệ và còn hạn không
    $stmt = $conn->prepare("SELECT id_hocvien FROM hocvien WHERE verification_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token_valid = true;
    } else {
        $message = "Liên kết không hợp lệ hoặc đã hết hạn. Vui lòng thử lại.";
    }
} else {
    $message = "Không tìm thấy mã token.";
}

// Xử lý khi người dùng submit mật khẩu mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $post_token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "Mật khẩu mới và mật khẩu xác nhận không khớp.";
        $token_valid = true; // Vẫn hiển thị form để người dùng nhập lại
    } elseif (strlen($new_password) < 6) {
        $message = "Mật khẩu phải có ít nhất 6 ký tự.";
        $token_valid = true;
    } else {
        // Cập nhật mật khẩu mới và vô hiệu hóa token
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE hocvien SET mat_khau = ?, verification_token = NULL, token_expiry = NULL WHERE verification_token = ?");
        $update_stmt->bind_param("ss", $hashedPassword, $post_token);

        if ($update_stmt->execute()) {
            $message = "Đặt lại mật khẩu thành công! Bạn sẽ được chuyển đến trang đăng nhập sau 2 giây.";
            $message_type = 'success';
            $token_valid = false; // Ẩn form sau khi thành công
            header("refresh:1;url=login.php");
        } else {
            $message = "Đã có lỗi xảy ra. Vui lòng thử lại.";
            $token_valid = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo Mật Khẩu Mới - Tiếng Anh Fighter!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        :root {
            --brand-color: #0db33b;
            --brand-color-dark: #0a8a2c;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: linear-gradient(-45deg, #e0f7fa, #d1f8e2, #e0f7fa, #ffffff);
            background-size: 400% 400%;
            animation: gradient-animation 15s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header .logo img {
            height: 100px;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .form-header h2 {
            font-size: 26px;
            color: #333;
            font-weight: 700;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(45deg, var(--brand-color), var(--brand-color-dark));
            color: #fff;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <a href="../index.php">
                <div class="logo"><img src="../images/logo2.jpg" alt="Logo"></div>
            </a>
            <h2>Tạo Mật Khẩu Mới</h2>
        </div>

        <?php if (!empty($message)) : ?>
            <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($token_valid): ?>
            <form method="post" action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                </div>
                <button type="submit" name="reset_password" class="btn-submit">Lưu Mật Khẩu</button>
            </form>
        <?php elseif ($message_type !== 'success'): ?>
            <a href="forgot-password.php" class="btn btn-secondary w-100">Yêu cầu liên kết mới</a>
        <?php endif; ?>
    </div>
</body>

</html>