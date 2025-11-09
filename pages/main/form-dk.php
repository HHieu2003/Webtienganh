<?php
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
        // Sử dụng prepared statements để chống SQL Injection
        $sql_form = "INSERT INTO tuvan (ten_hocvien, so_dien_thoai, email, khung_gio) VALUES (?, ?, ?, ?)";
        $stmt_form = $conn->prepare($sql_form);
        $stmt_form->bind_param("ssss", $ten_hocvien, $so_dien_thoai, $email, $khung_gio);

        if ($stmt_form->execute()) {
            $form_message = "Gửi yêu cầu thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.";
            $form_message_type = 'success';
        } else {
            $form_message = "Lỗi: Không thể gửi yêu cầu. Vui lòng thử lại.";
            $form_message_type = 'error';
        }
        $stmt_form->close();
    }
}
?>

<div class="consult-section-final">
    <div class="consult-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="consult-info-content">
                    <span class="consult-tag">Ưu đãi đặc biệt</span>
                    <h2 class="consult-title">Đăng Ký Tư Vấn Ngay hôm nay!</h2>
                    <p class="consult-description">Để lại thông tin để nhận ngay lộ trình học cá nhân hóa và bộ quà tặng độc quyền từ Tiếng Anh Fighter.</p>

                    <div class="offer-item">
                        <div class="offer-icon"><i class="fas fa-gift"></i></div>
                        <div class="offer-text">
                            <h4>Combo quà tặng độc quyền</h4>
                            <p>Sách, balo, sổ tay và nhiều vật phẩm hấp dẫn.</p>
                        </div>
                    </div>
                    <div class="offer-item">
                        <div class="offer-icon"><i class="fas fa-ticket-alt"></i></div>
                        <div class="offer-text">
                            <h4>Voucher học phí</h4>
                            <p>Ưu đãi học phí lên đến 5.000.000đ cho khóa trọn gói.</p>
                        </div>
                    </div>

                    <div class="offer-item">
                        <div class="offer-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="offer-text">
                            <h4>Lớp học thử miễn phí</h4>
                            <p>Trải nghiệm phương pháp E.M.P.O.W.E.R trong môi trường học hiện đại.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="final-form-wrapper">
                    <h3 class="final-form-title">Nhận tư vấn miễn phí</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>#consult-form" method="post" id="consult-form">

                        <?php if (!empty($form_message)) : ?>
                            <div class="final-alert final-alert-<?php echo $form_message_type; ?>">
                                <?php echo $form_message; ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group mb-3">
                            <input type="text" name="ten_hocvien" class="final-form-control" placeholder="Họ và Tên *" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="tel" name="so_dien_thoai" class="final-form-control" placeholder="Số điện thoại *" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="final-form-control" placeholder="Email của bạn">
                        </div>
                        <div class="form-group mb-3">
                            <select name="khung_gio" class="final-form-control" required>
                                <option value="" disabled selected>Chọn khung giờ tư vấn *</option>
                                <option value="Sáng">Buổi sáng (8:00 - 12:00)</option>
                                <option value="Chiều">Buổi chiều (13:00 - 17:00)</option>
                                <option value="Tối">Buổi tối (18:00 - 21:00)</option>
                            </select>
                        </div>
                        <button type="submit" name="submit_consult" class="final-btn-submit">Gửi Yêu Cầu Ngay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ==========================================================
   CSS HOÀN TOÀN ĐỘC LẬP CHO SECTION FORM TƯ VẤN
   ========================================================== */

    /* --- Biến màu cục bộ --- */
    .consult-section-final {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --accent-color: #ffc107;
        --text-dark: #212529;
        --text-light: #555;
        --bg-light-green: #f0fdf4;
        --white: #fff;
        --success: #155724;
        --success-bg: #d4edda;
        --error: #721c24;
        --error-bg: #f8d7da;
    }

    /* --- Section Container --- */
    .consult-section-final {
        position: relative;
        padding: 80px 0;
        background: linear-gradient(135deg, var(--bg-light-green) 0%, #e7f7ec 100%);
        overflow: hidden;
    }

    /* --- Các hình khối trang trí nền --- */
    .consult-section-final .consult-bg-shapes .shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(13, 179, 59, 0.08);
        animation: float-animation-form 8s ease-in-out infinite alternate;
    }

    .consult-section-final .shape-1 {
        width: 250px;
        height: 250px;
        bottom: -50px;
        left: -50px;
        animation-duration: 9s;
    }

    .consult-section-final .shape-2 {
        width: 180px;
        height: 180px;
        top: -40px;
        right: -40px;
        animation-duration: 7s;
    }

    @keyframes float-animation-form {
        from {
            transform: translateY(0px) rotate(0deg);
        }

        to {
            transform: translateY(25px) rotate(45deg);
        }
    }

    /* --- Cột thông tin ưu đãi bên trái --- */
    .consult-section-final .consult-info-content {
        position: relative;
        z-index: 2;
    }

    .consult-section-final .consult-tag {
        display: inline-block;
        background-color: var(--accent-color);
        color: var(--brand-color-dark);
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .consult-section-final .consult-title {
        font-size: 38px;
        font-weight: 800;
        color: var(--brand-color-dark);
        margin-bottom: 15px;
    }

    .consult-section-final .consult-description {
        font-size: 17px;
        color: var(--text-light);
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .consult-section-final .offer-item {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .consult-section-final .offer-icon {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--brand-color), var(--accent-color));
        color: var(--white);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.3s ease;
        animation: bounce-icon 3s ease-in-out infinite;
    }

    @keyframes bounce-icon {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-8px);
        }

        60% {
            transform: translateY(-4px);
        }
    }

    .consult-section-final .offer-text h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .consult-section-final .offer-text p {
        font-size: 15px;
        color: var(--text-light);
        margin: 0;
    }

    /* --- Cột Form bên phải (Glassmorphism) --- */
    .consult-section-final .final-form-wrapper {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.8);
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 2;
    }

    .consult-section-final .final-form-title {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        color: var(--brand-color-dark);
    }

    .consult-section-final .final-form-control {
        width: 100%;
        height: 55px;
        border-radius: 10px;
        font-size: 16px;
        padding: 0 20px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .consult-section-final .final-form-control:focus {
        outline: none;
        border-color: var(--brand-color);
        box-shadow: 0 0 0 4px rgba(13, 179, 59, 0.15);
        background-color: var(--white);
    }

    .consult-section-final .final-btn-submit {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        font-weight: 700;
        color: var(--white);
        background: linear-gradient(45deg, var(--brand-color-dark), var(--brand-color));
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.3);
    }

    .consult-section-final .final-btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.4);
    }

    .consult-section-final .final-btn-submit:active {
        transform: translateY(-1px);
    }

    /* --- Thông báo lỗi/thành công --- */
    .consult-section-final .final-alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .75rem;
        font-weight: 500;
    }

    .consult-section-final .final-alert-success {
        color: var(--success);
        background-color: var(--success-bg);
        border-color: #c3e6cb;
    }

    .consult-section-final .final-alert-error {
        color: var(--error);
        background-color: var(--error-bg);
        border-color: #f5c6cb;
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .consult-section-final .consult-info-content {
            text-align: center;
            margin-bottom: 40px;
        }

        .consult-section-final .consult-description {
            margin-left: auto;
            margin-right: auto;
        }

        .consult-section-final .offer-item {
            text-align: left;
        }
    }
</style>