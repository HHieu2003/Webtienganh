<?php
session_start();
include("../config/config.php");
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Nạp các thư viện PHPMailer
require('../config/PHPMailer/src/Exception.php');
require('../config/PHPMailer/src/PHPMailer.php');
require('../config/PHPMailer/src/SMTP.php');
require('../config/sendmail.php');

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id_hocvien FROM hocvien WHERE email = ? AND is_verified = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Tạo token và thời gian hết hạn (15 phút)
        $token = bin2hex(random_bytes(50));
        $token_expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Cập nhật token vào CSDL
        $update_stmt = $conn->prepare("UPDATE hocvien SET verification_token = ?, token_expiry = ? WHERE email = ?");
        $update_stmt->bind_param("sss", $token, $token_expiry, $email);
        $update_stmt->execute();

        // Gửi email chứa link reset
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $script_path = dirname($_SERVER['PHP_SELF']);
        $base_path = rtrim(str_replace('pages', '', $script_path), '/');
        $reset_link = $protocol . $host . $base_path . "/pages/reset-password.php?token=" . $token;

        $subject = "Yeu cau dat lai mat khau cho tai khoan Tieng Anh Fighter";
        $body = "
            <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
            <p>Vui lòng nhấp vào liên kết dưới đây để tạo mật khẩu mới. Liên kết này sẽ hết hạn sau 15 phút.</p>
            <p><a href='{$reset_link}' style='padding: 10px 15px; background-color: #0db33b; color: white; text-decoration: none; border-radius: 5px;'>Đặt lại mật khẩu</a></p>
            <p>Nếu bạn không yêu cầu điều này, vui lòng bỏ qua email.</p>
        ";

        sendmail($email, $subject, $body);

        $message = "Nếu email của bạn tồn tại trong hệ thống, một liên kết đặt lại mật khẩu đã được gửi đi. Vui lòng kiểm tra hộp thư của bạn.";
        $message_type = 'success';
    } else {
        $message = "Nếu email của bạn tồn tại trong hệ thống, một liên kết đặt lại mật khẩu đã được gửi đi. Vui lòng kiểm tra hộp thư của bạn.";
        $message_type = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - Tiếng Anh Fighter!</title>
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

        .form-footer a {
            color: var(--brand-color);
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <a href="../index.php">
                <div class="logo"><img src="../images/logo2.jpg" alt="Logo"></div>
            </a>
            <h2>Đặt lại mật khẩu</h2>
        </div>
        <form method="post" action="forgot-password.php">
            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            <p class="text-center text-muted">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
            <button type="submit" class="btn-submit">Gửi liên kết</button>
        </form>
        <div class="text-center mt-3 form-footer">
            <a href="login.php">Quay lại trang Đăng nhập</a>
        </div>
    </div>
</body>

</html>