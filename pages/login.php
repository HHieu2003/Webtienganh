<?php
// Luôn bắt đầu session ở đầu file
session_start();
include("../config/config.php");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];

    // Sử dụng Prepared Statements để chống SQL Injection
    $stmt = $conn->prepare("SELECT * FROM hocvien WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($mat_khau, $user['mat_khau'])) {
            $_SESSION['user'] = $user['ten_hocvien'];
            $_SESSION['email'] = $email;
            $_SESSION['id_hocvien'] = $user['id_hocvien'];
            $_SESSION['is_admin'] = $user['is_admin'];

            header("Location: ../index.php");
            exit();
        } else {
            $message = "Email hoặc mật khẩu không đúng!";
        }
    } else {
        $message = "Email hoặc mật khẩu không đúng!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Tiếng Anh Fighter!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --brand-color: #0db33b;
            --brand-color-dark: #0a8a2c;
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

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <a href="../index.php">
                <div class="logo"><img src="../images/logo2.jpg" alt="Logo"></div>
            </a>
            <h2>Đăng nhập tài khoản</h2>
        </div>

        <form method="post" action="login.php">
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
            </div>

            <?php if (!empty($message)) : ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <button type="submit" name="login" class="btn-submit">Đăng nhập</button>
        </form>

        <div class="form-footer">
            <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
            <p style="margin-top: 10px;"><a href="login_teacher.php" style="font-size: 16px">Đăng nhập dành cho giáo viên</a></p>
        </div>
    </div>
</body>

</html>