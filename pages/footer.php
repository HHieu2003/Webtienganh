<style>
    /*-----------footer-----------*/
    .footer {
        border-top: 2px solid #0b9331;
        background-color: #f3f7f8;
        padding: 30px 40px 20px 40px;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
    }

    .footer-content {
        width: 30%;

    }


    .footer-content h4 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #000;
        font-weight: bold;
    }

    .footer-content .logo-footer {
        width: auto;
        height: 150px;
        margin-top: 5px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        border-radius: 10px;
    }

    .footer-content img:hover {
        transform: scale(1.05);
        transition: 0.5s;

    }

    .footer-content p,
    .footer-content a {
        font-size: 14px;
        color: #333;
        text-decoration: none;
        margin: 8px 0px;

    }

    .footer-content,
    .icon {
        font-size: 24px;
        color: #333;
        margin-right: 10px;
        margin-left: 40px;
    }

    .footer {
        font-size: 20px;
        color: #333;
        margin-right: 10px;
    }
    .social-icons{
        margin: 5px;
    }
    .social-icons a {
        font-size: 35px;
        color: #333;
        margin-right: 16px;
        
    }

    .footer .social-icons a:hover {
        color: #007bff;
    }


    /*-----------footer end-------*/
    .footer-bar {
        background-color: #0b9331;
        color: white;
        padding: 20px;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .footer-bar .left,
    .footer-bar .right {
        display: flex;
        align-items: center;
    }

    .footer-bar .right a {
        text-decoration: none;
        margin-left: 15px;
        font-size: 14px;
    }

    .footer-bar a:not(:last-child)::after {
        content: " | ";
        color: white;
        padding-left: 10px;
        font-weight: 900;
    }

    .footer-bar .right a:hover {
        text-decoration: underline;
    }
</style>

<div>
    <!-------footer----->
    <div class="footer">
        <div class="footer-content">
            <h4>TIẾNG ANH FIGHTER!</h4>
            <P><i class="fa-solid fa-location-dot" style="color: #000000;"></i>   Lê Văn Lương - Thanh Xuân - Hà Nội</P>
            <P><i class="fa-solid fa-phone-volume" style="color: #000000;"></i> &nbsp;Hotline: 0962 501 832 - 0336 123 130</P>
            <p>
            <i class="fa-solid fa-envelope" style="color: #000000;"></i> &nbsp;Email: <a href="mailto:nthuphuong2710@gmail.com"> nthuphuong2710@gmail.com</a>
            </p>

            <div class="social-icons" >
                <a href="#"><i class="fa-brands fa-telegram" style="color: #5cb0f0;"></i></a>
                <a href="#"><i class="fa-brands fa-facebook" style="color:rgb(12, 52, 121);"></i></a>
                <a href="https://www.youtube.com/"><i class="fa-brands fa-youtube" style="color:rgb(255, 0, 38);"></i></a>
                <a href=""><i class="fa-brands fa-twitter" style="color:rgb(0, 157, 236);;"></i></a>
            </div>
        </div>
        <div class="footer-content">
            <h4>ĐỒNG HÀNH CÙNG CHÚNG TÔI </h4>
            <img class="logo-footer" src="images/logo.png" alt="">
        </div>
        <div class="footer-content">
            <h4>HỖ TRỢ KHÁCH HÀNG</h4>
            <div class="icon">
                <a href=""></a>
                <a href=""></a>
                <a href=""></a>
            </div>
            <p><a href="./index.php?nav=huongdandangky"> - &nbsp; Hướng dẫn đăng ký khóa học</a></p>
            <p><a href="./index.php?nav=huongdandangky"> - &nbsp; Hướng dẫn đăng ký và đăng nhập</a></p>
            <p><a href="./index.php?nav=huongdandangky"> - &nbsp; Hướng dẫn đổi mật khẩu</a></p>

            <img src="./images/logofooter.png" alt="" style="    width: 222px;
    height: auto;">
        </div>
    </div>
    <!------footer end------>
    <div class="footer-bar">
        <div class="left">
            @ 2024 Tiếng Anh Fighter!
        </div>
        <div class="right">
            <a href="./index.php?nav=about" style="color: #fff;">Giới thiệu</a>
            <a href="./index.php?nav=huongdandangky" style="color: #fff;">Điều khoản dịch vụ</a>
            <a href="./index.php?nav=huongdandangky" style="color: #fff;">Quy định về khóa học</a>
            <a href="./index.php?nav=huongdandangky" style="color: #fff;">Chính sách bảo mật</a>
        </div>
    </div>
</div>