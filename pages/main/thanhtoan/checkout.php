<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Đường dẫn tới file config của bạn
require('../../../config/config.php');

// 1. KIỂM TRA ĐIỀU KIỆN BAN ĐẦU
// Kiểm tra đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    die('Vui lòng đăng nhập.');
}
$id_hocvien_session = $_SESSION['id_hocvien'];

// Lấy và kiểm tra id_dangky từ URL
$dangky_id = isset($_GET["dangky_id"]) && is_numeric($_GET["dangky_id"]) ? (int)$_GET["dangky_id"] : 0;
if (!$dangky_id) {
    die('Không tìm thấy đơn đăng ký hợp lệ.');
}

// 2. LẤY THÔNG TIN ĐƠN HÀNG
// Truy vấn thông tin đơn đăng ký, khóa học
$sql = "SELECT dk.id_dangky, dk.trang_thai, dk.thoi_gian_tao, kh.ten_khoahoc, kh.chi_phi 
        FROM dangkykhoahoc dk 
        JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
        WHERE dk.id_dangky = ? AND dk.id_hocvien = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $dangky_id, $id_hocvien_session);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    $conn->close();
    die('Đơn đăng ký không tồn tại hoặc bạn không có quyền truy cập.');
}
$order_details = $result->fetch_object();
$stmt->close();

// 3. XỬ LÝ LOGIC HẾT HẠN (NẾU CÓ)
// Chỉ xử lý khi đơn hàng đang chờ xác nhận
if ($order_details->trang_thai == 'cho xac nhan') {
    $thoi_gian_tao = new DateTime($order_details->thoi_gian_tao);
    $thoi_gian_hien_tai = new DateTime();
    $thoi_gian_het_han = (clone $thoi_gian_tao)->add(new DateInterval('PT5M')); // Thời gian chờ: 5 phút
    $is_expired = $thoi_gian_hien_tai > $thoi_gian_het_han;

    if ($is_expired) {
        // Nếu đơn hàng hết hạn, cập nhật trạng thái thành 'da huy'
        $sql_cancel = "UPDATE dangkykhoahoc SET trang_thai = 'da huy' WHERE id_dangky = ? AND id_hocvien = ?";
        $stmt_cancel = $conn->prepare($sql_cancel);
        $stmt_cancel->bind_param("ii", $dangky_id, $id_hocvien_session);
        $stmt_cancel->execute();
        $stmt_cancel->close();
        $conn->close();

        // Hiển thị thông báo và dừng lại
        die('<div style="text-align: center; padding: 50px; font-family: sans-serif; color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px auto; max-width: 600px;">
                <h2>Đơn hàng đã hết hạn</h2>
                <p>Phiên thanh toán của bạn đã quá 5 phút và đơn hàng đã bị hủy. Vui lòng thực hiện lại việc đăng ký từ đầu.</p>
                <a href="../../../index.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-top: 15px;">Quay về trang chủ</a>
             </div>');
    }
}

// Đóng kết nối nếu chưa bị đóng
if ($conn->ping()) {
    $conn->close();
}

// Chuẩn bị nội dung chuyển khoản cho mã QR
$payment_description = "DKKH" . $order_details->id_dangky;
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container my-5 payment-container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <?php if ($order_details->trang_thai == 'da xac nhan'): ?>
                    <div class="status-box success visible">
                        <h2 class="text-success">Thanh toán thành công</h2>
                        <p class="mt-3">Chúng tôi đã nhận được thanh toán của bạn. Khóa học đã được kích hoạt!</p>
                        <a href="../../../index.php" class="btn btn-primary mt-3">Về trang chủ</a>
                    </div>

                <?php elseif ($order_details->trang_thai == 'da huy'): ?>
                     <div class="status-box expired visible">
                        <h2 class="text-danger">Đơn hàng đã bị hủy</h2>
                        <p class="mt-3">Đơn hàng này đã hết hạn thanh toán. Vui lòng tạo đơn hàng mới.</p>
                        <a href="../../../index.php" class="btn btn-primary mt-3">Quay về trang chủ</a>
                    </div>
                
                <?php else: // Trạng thái là 'cho xac nhan' ?>
                   <div class="text-center p-3 mb-4 bg-light border rounded-3">
                        <h1 class="fw-bold h3">Thông tin thanh toán</h1>
                        <p class="lead mb-1">
                            <strong>Khóa học:</strong> <?php echo htmlspecialchars($order_details->ten_khoahoc); ?>
                        </p>
                        <p class="h4 text-danger fw-bold">
                            <?php echo number_format($order_details->chi_phi); ?> VND
                        </p>
                        <p class="small text-muted mb-0">Mã đơn hàng của bạn: #<?php echo htmlspecialchars($dangky_id); ?></p>
                    </div> 
                    <div class="status-box success" id="success_pay_box">
                        <h2 class="text-success">Thanh toán thành công</h2>
                        <p class="mt-3">Chúng tôi đã nhận được thanh toán. Trang sẽ tự động chuyển về trang chủ sau giây lát...</p>
                    </div>

                    <div id="checkout_box">
                        <div class="countdown-box">
                            <p>Vui lòng thanh toán trước khi đơn hàng hết hạn sau:
                                <span id="countdown_timer"></span>
                                <span class="text-danger"> Không thoát trang này khi thanh toán (để hệ thống xử lý khi bạn chuyển tiền). Nếu bạn thanh toán mà trang này chưa chuyển sang thành công hãy liên hệ với chúng tôi.</span>
                            </p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="qr-box">
                                    <h5 class="text-center fw-bold mb-3">Quét mã QR để thanh toán</h5>
                                    <img src="https://qr.sepay.vn/img?bank=MBBank&acc=0000367206198&template=compact&amount=<?php echo intval($order_details->chi_phi); ?>&des=<?php echo urlencode($payment_description); ?>" class="img-fluid">
                                    <div class="text-center mt-3" id="payment_status_text">
                                        Trạng thái: <strong>Chờ thanh toán...</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="manual-box">
                                     <h5 class="text-center fw-bold mb-3">Hoặc chuyển khoản thủ công</h5>
                                     <div class="text-center mb-3">
                                         <img src="https://qr.sepay.vn/assets/img/banklogo/MB.png" class="img-fluid" style="max-height:40px">
                                         <p class="fw-bold mb-0 mt-2">Ngân hàng MBBank</p>
                                     </div>
                                     <table class="table table-bordered">
                                         <tbody>
                                             <tr><td>Chủ tài khoản:</td><td><b>Trần Hữu Hiếu</b></td></tr>
                                             <tr><td>Số TK:</td><td><b>0000367206198</b></td></tr>
                                             <tr><td>Số tiền:</td><td><b class="text-danger"><?php echo number_format($order_details->chi_phi); ?>đ</b></td></tr>
                                             <tr><td>Nội dung:</td><td><b><?php echo htmlspecialchars($payment_description); ?></b></td></tr>
                                         </tbody>
                                     </table>
                                     <p class="bg-warning-subtle p-2 rounded small"><b>Lưu ý:</b> Vui lòng nhập chính xác nội dung chuyển khoản để hệ thống xác nhận tự động.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="status-box expired" id="expired_box">
                        <h2 class="text-danger">Đơn hàng đã hết hạn</h2>
                        <p class="mt-3">Phiên thanh toán đã quá 5 phút và đơn hàng đã bị hủy. Vui lòng đăng ký lại.</p>
                        <a href="../../../index.php" class="btn btn-primary">Quay về trang chủ</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <?php if ($order_details->trang_thai == 'cho xac nhan'): ?>
        <script>
            const expirationTime = new Date("<?php echo $thoi_gian_het_han->format('Y-m-d H:i:s'); ?>").getTime();
            const timerElement = document.getElementById('countdown_timer');
            let countdownInterval;

            function cancelOrder() {
                // Gửi yêu cầu HỦY đơn hàng đến server một cách ngầm
                $.ajax({
                    type: "POST",
                    url: "huy_donhang.php", // File xử lý hủy đơn hàng
                    data: { dangky_id: <?php echo $dangky_id; ?> },
                    dataType: "json",
                    success: function(response) { console.log(response.message); },
                    error: function() { console.log("Lỗi khi gửi yêu cầu hủy đơn hàng."); }
                });
            }

            function startCountdown() {
                countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = expirationTime - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        $("#checkout_box").hide();
                        $("#expired_box").addClass('visible');
                        payment_status = 'da het han';
                        cancelOrder();
                        return;
                    }

                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (timerElement) {
                        timerElement.innerHTML = minutes + " phút " + String(seconds).padStart(2, '0') + " giây";
                    }
                }, 1000);
            }
            startCountdown();

            var payment_status = 'cho xac nhan';

            function check_payment_status() {
                if (payment_status == 'cho xac nhan') {
                    $.ajax({
                        type: "POST",
                        data: { dangky_id: <?php echo $dangky_id; ?> },
                        url: "check_payment_status.php",
                        dataType: "json",
                        success: function(data) {
                            if (data.payment_status == "da xac nhan") {
                                payment_status = 'da xac nhan';
                                clearInterval(countdownInterval);
                                $("#checkout_box").hide();
                                $("#success_pay_box").addClass('visible');
                                setTimeout(function() {
                                    window.location.href = '../../../index.php';
                                }, 3000);
                            }
                        },
                        error: function() {
                            console.log("Lỗi khi kiểm tra trạng thái thanh toán.");
                        }
                    });
                }
            }

            // Kiểm tra trạng thái mỗi 3 giây
            setInterval(check_payment_status, 3000);
        </script>
    <?php endif; ?>

</body>
</html>
<style >
    /* --- Import Font từ Google --- */
@import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap');

/* --- Biến màu và Style tổng thể --- */
:root {
    --primary-color: #007bff;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --light-gray: #f8f9fa;
    --gray: #6c757d;
    --dark: #343a40;
    --white: #ffffff;
    --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    --border-radius: 12px;
}

body {
    font-family: 'Be Vietnam Pro', sans-serif;
    background-color: var(--light-gray);
    color: var(--dark);
}

/* --- Hiệu ứng xuất hiện chung --- */
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

/* --- Style cho trang dangkykhoahoc.php --- */
.form-container {
    max-width: 700px;
    margin: 40px auto;
    padding: 40px;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    animation: fadeIn 0.8s ease-out;
}

.form-container h2 {
    text-align: center;
    color: var(--dark);
    margin-bottom: 30px;
    font-weight: 700;
}

.info-section {
    margin-bottom: 30px;
    padding: 20px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

.info-section h3 {
    font-size: 1.2em;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 15px;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 10px;
}

.info-section p {
    margin-bottom: 10px;
    font-size: 1em;
    color: var(--gray);
}

.info-section p strong {
    color: var(--dark);
    min-width: 150px;
    display: inline-block;
}

.btn-submit {
    display: block;
    width: 100%;
    padding: 15px;
    font-size: 1.1em;
    font-weight: 700;
    color: var(--white);
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 20px rgba(0, 123, 255, 0.3);
}

/* --- Style cho trang checkout.php --- */
.payment-container {
    animation: fadeIn 0.8s ease-out;
}

.countdown-box {
    padding: 20px;
    margin-bottom: 20px;
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: var(--border-radius);
    text-align: center;
}

.countdown-box p {
    margin: 0;
    font-weight: 500;
    color: #856404;
}

#countdown_timer {
    font-size: 1.5em;
    font-weight: 700;
    color: var(--danger-color);
    display: block;
    margin-top: 5px;
}

.qr-box, .manual-box {
    padding: 30px;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    height: 100%;
}

.qr-box img {
    max-width: 250px;
    margin: 0 auto;
    display: block;
}

/* --- Style cho các hộp thông báo (Success, Expired) --- */
.status-box {
    padding: 40px;
    border-radius: var(--border-radius);
    text-align: center;
    /* Hiệu ứng chuyển động */
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    display: none; /* Ẩn ban đầu */
}

.status-box.visible {
    display: block;
    opacity: 1;
    transform: scale(1);
}

.status-box.success {
    background-color: #e9f7ef;
    border: 1px solid #a6d9b8;
}

.status-box.expired {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}
</style>