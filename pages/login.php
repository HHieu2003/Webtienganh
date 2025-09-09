<?php
include("../config/config.php");
// Bắt đầu session
session_start();

// Xóa toàn bộ session
session_unset(); // Xóa tất cả biến session
session_destroy(); // Hủy session

// Chuyển hướng về trang login
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];
    // Kiểm tra email và mật khẩu trong cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT * FROM hocvien WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // if (password_verify($mat_khau, $user['mat_khau'])) {

        if ($mat_khau === $user['mat_khau']) {
            // Thực hiện hành động khi mật khẩu đúng

            // Đăng nhập thành công
            session_start();
            $_SESSION['user'] = $user['ten_hocvien'];
            $_SESSION['email'] = $email;
            $_SESSION['id_hocvien'] = $user['id_hocvien'];
            $_SESSION['is_admin'] = $user['is_admin']; // Lưu trạng thái admin
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Mật khẩu không đúng!";
        }
    } else {
        $message = "Email không tồn tại!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/css/icon/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/icon/fontawesome-free-6.4.2-web/css/all.min.css">

</head>
<style>
    body{
        font-family: 'Times New Roman', Times, serif;
    }
    .header-top {
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        background-color: #f3f7f8;
        display: flex;
    }

    .header-top .left,
    .header-top .right {
        display: flex;
        align-items: center;
    }

    .right a {
        text-decoration: none;
        margin-left: 15px;
        font-size: 16px;
        color: green;
    }

    .right a:not(:last-child)::after {
        content: " | ";
        color: green;
        padding-left: 10px;
        font-weight: 900;
    }

    .right a:hover {
        text-decoration: underline;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 60px;
        margin-right: 10px;
    }

    .logo-item {
        font-size: 24px;
        color: #0db33b;
        font-weight: bold;
    }

    .logo-row {
        font-size: 14px;
        color: #666;
    }



    body {
        width: 100%;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    .footer {
        background-color: #9ee3b0;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .footer-bar {
        background-color: #9ee3b0;
        color: black;
        padding: 15px;
        font-size: 14px;
        justify-content: space-between;
        align-items: center;
    }

    .left {
        align-items: center;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .form-dn {
        background-color: #ffff;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 20px;
    }

    .form-dn-1 {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px #555;
        width: 500px;
    }

    .form-dn h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-register {
        width: 100%;
        background-color: #028e43;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-register:hover {
        background-color: #026633;
    }

    .social-login {
        text-align: center;
        margin-top: 20px;
    }

    .social-login a {
        margin: 0 5px;
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 20px;
        color: #555;
    }

    .social-login-1 {
        display: flex;
        text-align: center;
        margin-top: 20px;
        padding: 5px 170px;
    }

    .social-login a:hover {
        background-color: #bbb;
    }
</style>

<body>
    <div>
        <div class="header-top">
            <div class="left">
                <div class="logo">
                    <a href="../index.php"><img src="../images/logo2.jpg" alt=""></a>
                    <div>
                        <div class="logo-item">Tiếng Anh Fighter!</div>
                        <div class="logo-row">Learning is an adventure!!!</div>
                    </div>
                </div>
            </div>
            <div class="right">
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Đăng Ký</a>
            </div>

        </div>

        <div class="form-dn">
            <div class="form-dn-1">
                <h2>Đăng nhập</h2>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Nhập email" required>

                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="form-outline flex-fill mb-0">
                        <?php if (isset($message)) { ?>
                            <span class="text-danger"><?php echo $message; ?></span>
                        <?php } ?>
                    </div>
                    <button type="submit" name="login" class="btn-register">Đăng nhập</button>
                </form>

                <div class="social-login">
                    <p>Đăng nhập thông qua mạng xã hội</p>
                    <div class="social-login-1">
                        <a href="#" style="background-color: #4267B2; color: white;"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" style="background-color: #DB4437; color: white;"><i class="fa-brands fa-google-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-bar">
                <div class="left">
                    @ 2024 Tiếng Anh Fighter!
                </div>
            </div>
        </div>

</body>

</html>
