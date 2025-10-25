<?php
session_start();
include("../config/config.php");

// Nạp các thư viện PHPMailer
require('../config/PHPMailer/src/Exception.php');
require('../config/PHPMailer/src/PHPMailer.php');
require('../config/PHPMailer/src/SMTP.php');
require('../config/sendmail.php'); // File sendmail của bạn

$message = '';
$message_type = ''; // 'success' hoặc 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $ten = $_POST['ten'];
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];

    // Kiểm tra xem email đã tồn tại và đã được xác thực chưa
    $checkEmail = $conn->prepare("SELECT id_hocvien, is_verified FROM hocvien WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    $existing_user = $result->fetch_assoc();

    if ($existing_user && $existing_user['is_verified'] == 1) {
        $message = "Email này đã được sử dụng bởi một tài khoản đã được xác thực!";
        $message_type = 'error';
    } else {
        // Nếu email tồn tại nhưng chưa xác thực, xóa đi để người dùng có thể đăng ký lại
        if ($existing_user) {
            $conn->query("DELETE FROM hocvien WHERE id_hocvien = " . $existing_user['id_hocvien']);
        }

        $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);
        // TẠO MÃ XÁC THỰC GỒM 6 CHỮ SỐ
        $verification_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token_expiry = date('Y-m-d H:i:s', strtotime('+15 minutes')); // Mã chỉ có hiệu lực 15 phút

        $stmt = $conn->prepare("INSERT INTO hocvien (ten_hocvien, email, mat_khau, verification_token, token_expiry, is_verified) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssss", $ten, $email, $hashedPassword, $verification_code, $token_expiry);

        if ($stmt->execute()) {
            // Xác định đường dẫn gốc của website một cách linh động
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script_path = dirname($_SERVER['PHP_SELF']);
            $base_path = rtrim(str_replace('pages', '', $script_path), '/');

            // Link xác thực chứa sẵn email và mã code
            $verification_link = $protocol . $host . $base_path . "/pages/verify.php?email=" . urlencode($email) . "&code=" . $verification_code;

            $subject = "{$verification_code} la ma xac thuc tai khoan Tieng Anh Fighter cua ban";
            $body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <img src='https://sf-static.upanhlaylink.com/img/image_20251025960366f848fb6649ab8450c008fd2e1b.jpg                        ' alt='Tieng Anh Fighter Logo' style='max-height: 60px;'>
                    </div>
                    <h2 style='color: #0db33b; text-align: center;'>Xác thực tài khoản của bạn</h2>
                    <p>Chào mừng bạn đến với Tiếng Anh Fighter!</p>
                    <p>Để hoàn tất đăng ký, vui lòng sử dụng mã xác thực dưới đây. Mã có hiệu lực trong 15 phút.</p>
                    <p style='text-align: center; font-size: 28px; font-weight: bold; color: #0a8a2c; letter-spacing: 5px; background: #f0f0f0; padding: 10px; border-radius: 8px;'>
                        {$verification_code}
                    </p>
                    <p style='text-align: center; margin-top: 20px;'>
                        <a href='{$verification_link}' style='padding: 12px 25px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>Hoặc nhấn vào đây để xác thực ngay</a>
                    </p>
                    <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>
                    <p style='font-size: 0.9em; color: #777;'>Nếu bạn không yêu cầu đăng ký này, vui lòng bỏ qua email này.</p>
                </div>
            ";

            sendmail($email, $subject, $body);

            // Chuyển hướng người dùng đến trang verify để nhập mã
            header("Location: verify.php?email=" . urlencode($email));
            exit();
        } else {
            $message = "Có lỗi xảy ra, vui lòng thử lại.";
            $message_type = 'error';
        }
        $stmt->close();
    }
    $checkEmail->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Tiếng Anh Fighter!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --brand-color: #0db33b;
            --brand-color-dark: #0a8a2c;
            --success-color: #155724;
            --success-bg: #d4edda;
            --error-color: #721c24;
            --error-bg: #f8d7da;
        }

        @keyframes gradient-animation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--brand-color);
            box-shadow: 0 0 0 4px rgba(13, 179, 59, 0.1);
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
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(13, 179, 59, 0.3);
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 17px;
        }

        .form-footer a {
            color: var(--brand-color);
            font-weight: bold;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .message-box {
            text-align: center;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .message-box.success {
            background-color: var(--success-bg);
            color: var(--success-color);
        }

        .message-box.error {
            background-color: var(--error-bg);
            color: var(--error-color);
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <a href="../index.php">
                <div class="logo"><img src="../images/logo2.jpg" alt="Logo"></div>
            </a>
            <h2>Tạo tài khoản mới</h2>
        </div>
        <form method="post" action="register.php">
            <?php if (!empty($message)) : ?>
                <div class="message-box <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="ten" placeholder="Họ và tên của bạn" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Nhập email" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" name="register" class="btn-submit">Đăng ký</button>
        </form>
        <div class="form-footer">
            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a></p>
        </div>
    </div>
</body>

</html>