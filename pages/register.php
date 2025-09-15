<?php
// Luôn bắt đầu session ở đầu file
session_start();
include("../config/config.php");

$message = '';
$message_type = ''; // Dùng để xác định màu cho thông báo (thành công/lỗi)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $ten = $_POST['ten'];
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];

    // Kiểm tra email đã tồn tại chưa
    $checkEmail = $conn->prepare("SELECT id_hocvien FROM hocvien WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        $message = "Email này đã được sử dụng!";
        $message_type = 'error';
    } else {
        // ================================================================
        // THAY ĐỔI BẢO MẬT QUAN TRỌNG
        // Mã hóa mật khẩu trước khi lưu vào CSDL
        // ================================================================
        $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);

        // Thêm người dùng mới vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO hocvien (ten_hocvien, email, mat_khau) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $ten, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Thay vì dùng alert, ta sẽ hiển thị thông báo thành công và link đăng nhập
            $message = "Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay bây giờ.";
            $message_type = 'success';
            echo "<script> setTimeout(function() {
                window.location.href = 'login.php';
            }, 1000);</script>";
        } else {
            $message = "Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        /* CSS được thiết kế lại, đồng bộ với trang đăng nhập */
        :root {
            --primary-color: #0db33b;
            --light-gray: #f3f7f8;
            --dark-text: #333;
            --gray-text: #666;
            --success-color: #28a745;
            --error-color: #dc3545;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .register-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px; /* Rộng hơn form đăng nhập một chút */
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header .logo img {
            height: 60px;
            margin-bottom: 10px;
        }

        .register-header h2 {
            font-size: 28px;
            color: var(--dark-text);
            font-weight: bold;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--gray-text);
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(13, 179, 59, 0.2);
        }

        .btn-register {
            width: 100%;
            background-color: var(--primary-color);
            color: #fff;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 179, 59, 0.3);
        }

        .register-footer {
            text-align: center;
            margin-top: 25px;
            color: var(--gray-text);
        }
        .register-footer a {
            color: var(--primary-color);
            font-weight: bold;
            text-decoration: none;
        }
        .register-footer a:hover {
            text-decoration: underline;
        }

        /* CSS cho thông báo */
        .message-box {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        .message-box.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="register-container" data-aos="zoom-in">
        <div class="register-header">
            <a href="../index.php">
                <div class="logo">
                    <img src="../images/logo2.jpg" alt="Logo">
                </div>
            </a>
            <h2>Tạo tài khoản mới</h2>
        </div>

        <form method="post" action="register.php">
            <?php if (!empty($message)) : ?>
                <div class="message-box <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Họ và tên</label>
                <input type="text" id="username" name="ten" class="form-control" placeholder="Nhập họ và tên" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="mat_khau" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>
            
            <button type="submit" name="register" class="btn-register">Đăng ký</button>
        </form>

        <div class="register-footer">
            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a></p>
        </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
          duration: 800,
          once: true,
      });
    </script>
</body>
</html>