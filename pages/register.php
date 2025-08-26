<?php
include("../config/config.php");
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $ten = $_POST['ten'];
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];

    // Kiểm tra email đã tồn tại chưa
    $checkEmail = $conn->prepare("SELECT * FROM hocvien WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        $message = "Email đã được sử dụng!";
    } else {
        // Mã hóa mật khẩu
        //$hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);

        // Thêm người dùng mới vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO hocvien (ten_hocvien, email, mat_khau) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $ten, $email, $mat_khau);

        if ($stmt->execute()) {
            $message = "Đăng ký thành công!";
            echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
        } else {
            $message = "Có lỗi xảy ra. Vui lòng thử lại.";
        }

        $stmt->close();
    }

    $checkEmail->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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

    .form-dk {
        background-color: #ffff;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 20px;
    }

    .form-dk-1 {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px #555;
        width: 500px;
    }

    .form-dk h2 {
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
        <div class="form-dk">
            <div class="form-dk-1">
                <h2>Đăng ký</h2>
                <form  method="post" action="register.php" >
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
                        <input type="password" id="password" name="mat_khau" placeholder="Nhập mật khẩu">
                    </div>
                    <div class="form-outline flex-fill mb-0">
                        <?php if (isset($message)) { ?>
                            <span class="text-danger"><?php echo $message; ?></span>
                        <?php } ?>
                    </div>
                    <button type="submit" name="register" class="btn-register">Đăng ký</button>
                </form>

                <div class="social-login">
                    <p>Đăng ký thông qua mạng xã hội</p>
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