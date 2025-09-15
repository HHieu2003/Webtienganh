<?php
session_start();
include("../config/config.php");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_teacher'])) {
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];
    
    // Sử dụng Prepared Statements để chống SQL Injection
    $stmt = $conn->prepare("SELECT * FROM giangvien WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
        
        // **Quan trọng**: Giả định mật khẩu giảng viên được mã hóa bằng password_hash()
        // Nếu bạn chưa mã hóa, hãy làm ngay để đảm bảo bảo mật.
        if (password_verify($mat_khau, $teacher['mat_khau'])) {
            // Đăng nhập thành công, thiết lập các session quan trọng
            $_SESSION['id_giangvien'] = $teacher['id_giangvien'];
            $_SESSION['teacher_name'] = $teacher['ten_giangvien'];
            $_SESSION['is_teacher'] = true; // Session để nhận diện đây là giảng viên
            
            // Xóa session của admin nếu có để tránh xung đột
            unset($_SESSION['is_admin']);

            header("Location: ../admin/admin.php"); // Chuyển hướng đến trang admin chung
            exit();
        } else {
            $message = "Email hoặc mật khẩu không đúng!";
        }
    } else {
        $message = "Email hoặc mật khẩu không đúng!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Giáo viên - Tiếng Anh Fighter!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        /* CSS được tùy chỉnh cho trang đăng nhập giáo viên (đồng bộ với trang học viên) */
        :root {
            --primary-color: #007bff; /* Thay đổi màu chủ đạo một chút để phân biệt */
            --light-gray: #f3f7f8;
            --dark-text: #333;
            --gray-text: #666;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f0f8ff, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header .logo img {
            height: 60px;
            margin-bottom: 10px;
        }

        .login-header h2 {
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
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        }

        .btn-login {
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
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container" data-aos="zoom-in">
        <div class="login-header">
            <a href="../index.php">
                <div class="logo">
                    <img src="../images/logo2.jpg" alt="Logo">
                </div>
            </a>
            <h2>Đăng nhập Giáo viên</h2>
        </div>

        <form method="post" action="login_teacher.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
            </div>
            
            <?php if (!empty($message)) : ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>
            
            <button type="submit" name="login_teacher" class="btn-login">Đăng nhập</button>
        </form>
        <div class="login-footer">
            <p> <a href="login.php">Quay về trang đăng nhập cho học sinh</a></p>
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