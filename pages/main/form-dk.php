<?php
// File này được include từ index.php nên biến $conn đã có sẵn
// require('./config/PHPMailer/src/Exception.php'); // Các file này đã được gọi ở file xử lý chính hoặc nên được quản lý qua autoloader
// require('./config/PHPMailer/src/PHPMailer.php');
// require('./config/PHPMailer/src/SMTP.php');
// require('./config/sendmail.php');

$form_message = '';
$form_message_type = ''; // 'success' hoặc 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_consult'])) {
    // Lấy dữ liệu từ form
    $ten_hocvien = $_POST['ten_hocvien'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $khung_gio = $_POST['khung_gio'];

    if (empty($ten_hocvien) || empty($so_dien_thoai) || empty($khung_gio)) {
        $form_message = "Vui lòng điền đầy đủ thông tin bắt buộc!";
        $form_message_type = 'error';
    } else {
        // ================================================================
        // THAY ĐỔI BẢO MẬT: SỬ DỤNG PREPARED STATEMENTS ĐỂ CHỐNG SQL INJECTION
        // ================================================================
        $sql_form = "INSERT INTO tuvan (ten_hocvien, so_dien_thoai, email, khung_gio) VALUES (?, ?, ?, ?)";
        $stmt_form = $conn->prepare($sql_form);
        // "ssss" nghĩa là 4 biến đều là chuỗi (string)
        $stmt_form->bind_param("ssss", $ten_hocvien, $so_dien_thoai, $email, $khung_gio);

        if ($stmt_form->execute()) {
            $form_message = "Gửi yêu cầu thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.";
            $form_message_type = 'success';
            
            // Gửi email xác nhận
            $to = $email;
            $subject = "Cảm ơn bạn đã đăng ký tư vấn từ Tiếng Anh Fighter";
            $message_body = "Chào " . htmlspecialchars($ten_hocvien) . ",\n\nCảm ơn bạn đã đăng ký nhận tư vấn từ trung tâm của chúng tôi. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.\n\nTrân trọng,\nTrung Tâm Tiếng Anh Fighter!";
            // Giả định hàm sendmail đã được include và cấu hình ở file cha
            // sendmail($to, $subject, $message_body);
        } else {
            $form_message = "Lỗi: Không thể gửi yêu cầu. Vui lòng thử lại.";
            $form_message_type = 'error';
        }
        $stmt_form->close();
    }
}
?>

<div class="consult-section" style=" background-color: #d1f8e2;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="offers-container">
                    <h2 class="introduce-title text-center">Đăng Ký Hôm Nay, Nhận Ngay Ưu Đãi!</h2>
                    <p class="section-subtitle text-center ">30 suất đặc biệt cho những bạn đăng ký sớm nhất trong tháng!</p>
                    <div class="offer-card">
                        <div class="offer-icon">💰</div>
                        <div class="offer-text">
                            <h4>ƯU ĐÃI HỌC PHÍ TỚI 5.000.000₫</h4>
                            <p>Dành cho khóa học trọn gói 7.0+ IELTS cam kết đầu ra.</p>
                        </div>
                    </div>
                    <div class="offer-card">
                        <div class="offer-icon">🎁</div>
                        <div class="offer-text">
                            <h4>COMBO QUÀ TẶNG ĐỘC QUYỀN</h4>
                            <p>Sách luyện thi, balo, sổ tay và nhiều vật phẩm hấp dẫn khác.</p>
                        </div>
                    </div>
                    <div class="offer-card">
                        <div class="offer-icon">🎟️</div>
                        <div class="offer-text">
                            <h4>THẺ HỌC THỬ MIỄN PHÍ</h4>
                            <p>Trải nghiệm lớp học tiêu chuẩn quốc tế theo phương pháp RIPL.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="form-wrapper">
                    <h3 class="form-title introduce-title">Đăng Ký Nhận Tư Vấn Miễn Phí</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>#consult-form" method="post" id="consult-form">
                        
                        <?php if (!empty($form_message)) : ?>
                            <div class="alert <?php echo ($form_message_type === 'success') ? 'alert-success' : 'alert-danger'; ?>">
                                <?php echo $form_message; ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group mb-3">
                            <input type="text" name="ten_hocvien" class="form-control" placeholder="Họ và Tên *" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="tel" name="so_dien_thoai" class="form-control" placeholder="Số điện thoại *" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email của bạn">
                        </div>
                        <div class="form-group mb-3">
                            <select name="khung_gio" class="form-control" required>
                                <option value="" disabled selected>Chọn khung giờ tư vấn *</option>
                                <option value="Sáng">Buổi sáng (8:00 - 12:00)</option>
                                <option value="Chiều">Buổi chiều (13:00 - 17:00)</option>
                                <option value="Tối">Buổi tối (18:00 - 21:00)</option>
                            </select>
                        </div>
                        <button type="submit" name="submit_consult" class="btn-submit-consult">Gửi Yêu Cầu Ngay</button>
                        <p class="form-note">Chúng tôi sẽ liên hệ trong 30 phút (giờ hành chính).</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .consult-section {
        padding: 30px 0;
        background: #fff;
    }

    /* Cột ưu đãi */
    .offers-container {
        padding-right: 20px;
    }
  
    .offer-card {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }
    .offer-card:hover {
        transform: translateX(10px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border-left: 4px solid #0db33b;
    }
    .offer-icon {
        font-size: 32px;
    }
    .offer-text h4 {
        font-size: 18px;
        font-weight: 600;
        color: #0db33b;
        margin-bottom: 5px;
    }
    .offer-text p {
        font-size: 15px;
        color: #555;
        margin-bottom: 0;
    }

    /* Form đăng ký */
    .form-wrapper {
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    .form-title {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 25px;
    }
    .form-control {
        height: 50px;
        border-radius: 8px;
        font-size: 16px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        border-color: #0db33b;
        box-shadow: 0 0 0 3px rgba(13, 179, 59, 0.2);
    }
    .btn-submit-consult {
        width: 100%;
        padding: 14px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        background: linear-gradient(45deg, #0db33b, #28a745);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-submit-consult:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.3);
    }
    .form-note {
        font-size: 13px;
        text-align: center;
        margin-top: 15px;
        color: #888;
    }
</style>