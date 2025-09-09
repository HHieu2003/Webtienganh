<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Giả định file config của bạn ở đường dẫn này
require('../../../config/config.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    die('Vui lòng đăng nhập.');
}
$id_hocvien_session = $_SESSION['id_hocvien'];

// Lấy id_dangky từ URL
$dangky_id = isset($_GET["dangky_id"]) && is_numeric($_GET["dangky_id"]) ? (int)$_GET["dangky_id"] : 0;
if (!$dangky_id) {
    die('Không tìm thấy đơn đăng ký hợp lệ.');
}

// Truy vấn thông tin đơn đăng ký và khóa học
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

// --- LOGIC KIỂM TRA VÀ TỰ XÓA KHI TẢI TRANG ---
$thoi_gian_tao = new DateTime($order_details->thoi_gian_tao);
$thoi_gian_hien_tai = new DateTime();
$thoi_gian_het_han = (clone $thoi_gian_tao)->add(new DateInterval('PT5M')); // Thời gian chờ: 1 phút
$is_expired = $thoi_gian_hien_tai > $thoi_gian_het_han;

if ($is_expired && $order_details->trang_thai == 'cho xac nhan') {
    // Nếu đơn hàng hết hạn, xóa vĩnh viễn bản ghi
    $sql_delete = "DELETE FROM dangkykhoahoc WHERE id_dangky = ? AND id_hocvien = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $dangky_id, $id_hocvien_session);
    $stmt_delete->execute();
    $stmt_delete->close();
    $conn->close(); // Đóng kết nối sau khi đã xóa

    // Hiển thị thông báo và dừng lại
    die('<div style="text-align: center; padding: 50px; font-family: sans-serif; color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px auto; max-width: 600px;">
            <h2>Đơn hàng đã hết hạn</h2>
            <p>Phiên thanh toán của bạn đã quá 5 phút và đơn hàng đã bị xóa. Vui lòng thực hiện lại việc đăng ký từ đầu.</p>
            <a href="../../../index.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-top: 15px;">Quay về trang chủ</a>
         </div>');
}
// --- KẾT THÚC LOGIC KIỂM TRA ---

// Đóng kết nối nếu chưa bị đóng ở block trên
if ($conn->ping()) {
    $conn->close();
}

// Nội dung chuyển khoản
$payment_description = "DKKH" . $order_details->id_dangky;
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php if ($order_details->trang_thai == 'da xac nhan') { ?>
                    <div class="p-4 text-center border border-2 border-success rounded">
                        <h2 class="text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                            Thanh toán thành công
                        </h2>
                        <p class="text-center text-success mt-3">Chúng tôi đã nhận được thanh toán của bạn. Khóa học đã được kích hoạt!</p>
                        <a href="../../../index.php" class="btn btn-primary mt-3">Về trang chủ</a>
                    </div>
                <?php } else { ?>
                    <h1>Thanh toán cho đơn đăng ký #<?php echo $dangky_id; ?></h1>
                    <div id="success_pay_box" class="p-4 text-center pt-3 border border-2 border-success rounded mt-4" style="display:none">
                        <h2 class="text-success">Thanh toán thành công</h2>
                        <p class="text-center text-success mt-3">Chúng tôi đã nhận được thanh toán của bạn. Trang sẽ tự động chuyển về trang chủ sau giây lát...</p>
                    </div>

                    <div class="row mt-4" id="checkout_box">
                        <div class="col-12 text-center my-2 p-2 border rounded bg-warning-subtle">
                            <p class="m-0 fw-bold">Vui lòng thanh toán trước khi đơn hàng hết hạn sau:
                                <span id="countdown_timer" class="text-danger"></span>
                                <br>
                                <span class="text-danger">Không thoát trang này khi thanh toán (hệ thống sẽ tự xử lý). Nếu bạn đã thanh toán mà trang chưa chuyển hãy liên hệ với chúng tôi.</span>
                            </p>
                        </div>
                        <div class="col-md-6 border text-center p-3">
                            <p class="fw-bold">Cách 1: Mở app ngân hàng và quét mã QR</p>
                            <div class="my-2">
                                <img src="https://qr.sepay.vn/img?bank=MBBank&acc=0000367206198&template=compact&amount=<?php echo intval($order_details->chi_phi); ?>&des=<?php echo $payment_description; ?>" class="img-fluid">
                                <div id="payment_status_text" class="mt-3">
                                    Trạng thái: <strong>Chờ thanh toán...</strong>
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border p-3">
                            <p class="fw-bold">Cách 2: Chuyển khoản thủ công</p>

                            <div class="text-center">
                                <img src="https://qr.sepay.vn/assets/img/banklogo/MB.png" class="img-fluid" style="max-height:40px">
                                <p class="fw-bold mb-2">Ngân hàng MBBank</p>
                            </div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Chủ tài khoản:</td>
                                        <td><b>Trần Hữu Hiếu</b></td>
                                    </tr>
                                    <tr>
                                        <td>Số TK:</td>
                                        <td><b>0000367206198</b></td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền:</td>
                                        <td><b class="text-danger"><?php echo number_format($order_details->chi_phi); ?>đ</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nội dung:</td>
                                        <td><b><?php echo $payment_description; ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="bg-warning-subtle p-2 rounded"><b>Lưu ý:</b> Vui lòng nhập chính xác nội dung chuyển khoản để hệ thống xác nhận tự động.</p>
                        </div>
                    </div>
                    <div id="expired_box" class="p-4 text-center border border-2 border-danger rounded mt-4" style="display:none">
                        <h2 class="text-danger">Đơn hàng đã hết hạn</h2>
                        <p class="mt-3">Phiên thanh toán đã quá 1 phút và đơn hàng đã bị xóa. Vui lòng quay lại trang chủ và thực hiện đăng ký lại.</p>
                        <a href="../../../index.php" class="btn btn-primary">Quay về trang chủ</a>
                    </div>




                    
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <?php if ($order_details->trang_thai == 'cho xac nhan') { ?>
        <script>
            const expirationTime = new Date("<?php echo $thoi_gian_het_han->format('Y-m-d H:i:s'); ?>").getTime();
            const timerElement = document.getElementById('countdown_timer');
            let countdownInterval;

            function deleteOrder() {
                // Gửi yêu cầu XÓA đơn hàng đến server một cách ngầm
                $.ajax({
                    type: "POST",
                    url: "xoa_donhang.php", // File này bạn đã tạo ở bước trước
                    data: {
                        dangky_id: <?php echo $dangky_id; ?>
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function() {
                        console.log("Lỗi khi gửi yêu cầu xóa đơn hàng.");
                    }
                });
            }

            function startCountdown() {
                countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = expirationTime - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        $("#checkout_box").hide();
                        $("#expired_box").show();
                        payment_status = 'da het han'; // Dừng việc kiểm tra thanh toán
                        deleteOrder(); // Gọi hàm xóa khi hết giờ
                        return;
                    }

                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (timerElement) {
                        timerElement.innerHTML = minutes + " phút " + seconds + " giây";
                    }
                }, 1000);
            }
            startCountdown();

            var payment_status = 'cho xac nhan';

            function check_payment_status() {
                if (payment_status == 'cho xac nhan') {
                    $.ajax({
                        type: "POST",
                        data: {
                            dangky_id: <?php echo $dangky_id; ?>
                        },
                        url: "check_payment_status.php", // File kiểm tra trạng thái
                        dataType: "json",
                        success: function(data) {
                            if (data.payment_status == "da xac nhan") {
                                payment_status = 'da xac nhan';
                                clearInterval(countdownInterval);
                                $("#checkout_box").hide();
                                $("#success_pay_box").show();
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
    <?php } ?>

</body>

</html>