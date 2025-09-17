

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>headerDK</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .header-top{
            padding: 5px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background-color: #f3f7f8; 
            display: flex;
            border-bottom: 2px solid #60d02f;
        }
        .header-top .left, .header-top .right {
            display: flex;
            align-items: center;
        }
        .right a {
            text-decoration: none;
            margin-left: 15px;
            font-size: 15px;
       color: #298f29;
                font-weight: 700;
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
        .logo-item{
            font-size: 24px;
            color: #0db33b;
            font-weight: bold;
        }
        .logo-row{
            font-size: 14px;
            color: #666;
        }
            /* CSS cho phần bong bóng chat nổi */
     .floating-icons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 1000;
            gap: 10px;
        }

        .floating-icons a {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .floating-icons a:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .messenger-icon {
            background-color: #f7b4f1; /* Màu của Messenger */
            font-size: 24px;
        }

        .phone-icon {
            background-color: #2bfc5f;
            font-size: 24px;
        }
    </style>
</head>
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
            <a class="" href="dashboard.php"> <?php echo $_SESSION['user'];  ?> </a>

                <a href="dashboard.php">Tài khoản</a>
                <a href="../index.php">Đăng Xuất</a>
            </div>
            
            <div class="floating-icons">
                <!-- Biểu tượng Messenger -->
                <a href="https://www.facebook.com/profile.php?id=100091706867917&mibextid=LQQJ4d target="_blank" class="messenger-icon" title="Chat với chúng tôi qua Messenger">
                <i class="fa-brands fa-facebook-messenger" style="color: #f448cf;"></i>
                </a>
            
                <!-- Biểu tượng điện thoại -->
                <a href="tel:+84123456789" class="phone-icon" title="Gọi điện cho chúng tôi">
                    <i class="fa-solid fa-phone"></i>
                </a>
            </div>
        </div>
    </div>
</body>
</html>