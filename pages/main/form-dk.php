<?php
require('./config/PHPMailer/src/Exception.php');
require('./config/PHPMailer/src/PHPMailer.php');
require('./config/PHPMailer/src/SMTP.php');
require('./config/sendmail.php');
include('./config/config.php');
// Kiểm tra nếu form được gửi bằng phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và đảm bảo an toàn
    $ten_hocvien = $conn->real_escape_string($_POST['ten_hocvien']);
    $so_dien_thoai = $conn->real_escape_string($_POST['so_dien_thoai']);
    $email = $conn->real_escape_string($_POST['email']);
    $khung_gio = $conn->real_escape_string($_POST['khung_gio']);

    // Kiểm tra nếu các trường bắt buộc không trống
    if (empty($ten_hocvien) || empty($so_dien_thoai) || empty($khung_gio)) {
        echo "Vui lòng điền đầy đủ thông tin bắt buộc!";
    } else {
        // Câu lệnh SQL để chèn dữ liệu vào bảng
        $sql = "INSERT INTO tuvan (ten_hocvien, so_dien_thoai, email, khung_gio) 
                VALUES ('$ten_hocvien', '$so_dien_thoai', '$email', '$khung_gio')";

        // Thực thi câu lệnh SQL
        if ($conn->query($sql) === TRUE) {
            $to = $email;

            $subject = "Cảm ơn bạn đã đăng ký tư vấn từ Tiếng Anh Fighter ";
            $message = "Chào $ten_hocvien ,Cảm ơn bạn đã đăng ký nhận từ vấn từ trung tâm của chúng tôi..Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.\n\nTrân trọng,\nTrung Tâm Ôn Thi Tiếng Anh Fighter!";
            sendmail($to, $subject, $message);
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<style>
    /*------------form-------------*/
    .container-sub-1 {}

    .container-1 {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-left: 20px;
        background-image: url(https://media.gettyimages.com/id/1028211994/vector/learn-english-banner-design.jpg?s=170667a&w=gi&k=20&c=vA5RE-G8nLXAeWjXDTrYbBgg1YPnDCLghcF6gomifeE=);
        background-position: center;
        border-top: 2px solid #a2dd97c2;

    }

    .form {
        width: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        color: #000000;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(to top, rgba(178, 202, 177, 0.8), #ffff);
        padding: 0 10px;
    }

    /*------------form left-------------*/
    .form-container {
        width: 500px;
        padding: 40px 20px;
        text-align: center;
        gap: 40px;
        margin: 0 auto;
        margin-bottom: 40px;
    }

    .form-container p {
        font-size: 14px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    .form-group input,
    .form-group select {
        padding: 10px;
        border-radius: 5px;
        border: none;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .form-group input::placeholder {
        color: #cccccc;
    }

    .form-row {
        gap: 10px;
    }

    .btn-submit {
        background-color: #0db33b;
        color: #ffffff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
    }

    .note {
        font-size: 12px;
        margin-top: 15px;
    }

    /*------------form right-------------*/
    .form-2 {
        flex: 1;
        padding: 150px 100px;
        border-radius: 8px;
        gap: 80px;
        justify-content: center;

    }

    .form-1-item {
        background-color: #fff3e0;
        border-left: 4px solid #fff3e0;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
        width: 450px;
    }

    .form-1-icon {
        font-size: 20px;
        color: #ff8800;
    }

    .form-1-text h4 {
        font-size: 18px;
        margin: 0;
        color: #e53935;
    }

    .form-1-text p {
        font-size: 14px;
        margin: 0;
        color: #666;
    }
</style>

<div>
    <!---------------section container------------>
    <div class="section container-sub-1">
        <div class="container-1">
            <!------------form left------------->
            <div class="form-1" align="center">
                <form class="form" action="" method="post">
                    <div class="form-container">
                        <h2 class="introduce-title">Đăng Ký Ngay Để Nhận Tư Vấn</h2>
                        <p>Thông tin về các khóa học tiếng Anh luôn được chúng tôi cập nhật theo xu hướng, phương pháp, chương trình giảng dạy và nhu cầu cụ thể theo từng đối tượng.</p>
                        <div class="form-item">
                            <div class="form-group">
                                <input type="text" name="ten_hocvien" placeholder="Họ và Tên *" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" name="so_dien_thoai" placeholder="SĐT vd: 0962501832 *" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <select name="khung_gio" required>
                                    <option value="">Chọn khung giờ liên hệ tư vấn *</option>
                                    <option value="Sáng">Buổi sáng</option>
                                    <option value="Chiều">Buổi chiều</option>
                                    <option value="Tối">Buổi tối</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-submit">Gửi yêu cầu</button>
                        </div>
                        <p class="note">Chúng tôi sẽ liên hệ trong vòng 30 phút trong khoảng thời gian 9h - 21h30.</p>
                    </div>
                </form>

            </div>

            <!-----------------form right---------------->
            <div class="form-2">
                <h2 style="color:#fff;    font-size: 35px;">30 Bạn Đăng Ký Đầu Tiên</h2>
                <div class="form-1-item">
                    <div class="form-1-icon">💰</div>
                    <div class="form-1-text">
                        <h4>ƯU ĐÃI HỌC PHÍ 5.000.000₫</h4>
                        <p>Dành cho khóa học trọn gói 7.0+ IELTS cam kết đầu ra.</p>
                    </div>
                </div>
                <div class="form-1-item">
                    <div class="form-1-icon">🎁</div>
                    <div class="form-1-text">
                        <h4>COMBO QUÀ TẶNG ĐỘC QUYỀN</h4>
                        <p>Sách luyện thi IELTS, balo, nón, sổ tay, ...</p>
                    </div>
                </div>
                <div class="form-1-item">
                    <div class="form-1-icon">🆓</div>
                    <div class="form-1-text">
                        <h4>THẺ THAM GIA KHÓA HỌC FREE</h4>
                        <p>Trải nghiệm lớp học IELTS tiêu chuẩn, giảng dạy theo phương pháp RIPL.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>