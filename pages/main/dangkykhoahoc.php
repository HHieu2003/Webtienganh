<?php

$id_hocvien = $_SESSION['id_hocvien'];
if (!$id_hocvien) {
    // Chuyển hướng trước khi in HTML hoặc dữ liệu
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='pages/login.php';</script>";
    exit();
}
require('./config/PHPMailer/src/Exception.php');
require('./config/PHPMailer/src/PHPMailer.php');
require('./config/PHPMailer/src/SMTP.php');
require('./config/sendmail.php');
include('./config/config.php');

$id_khoahoc = $_GET['id_khoahoc'] ?? null;
$ten_hocvien = '';
$email = '';
$phone = '';

// Lấy thông tin học viên từ cơ sở dữ liệu nếu có ID học viên trong session
if ($id_hocvien) {
    $sql_hocvien = "SELECT ten_hocvien, email, so_dien_thoai FROM hocvien WHERE id_hocvien = ?";
    $stmt = $conn->prepare($sql_hocvien);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $stmt->bind_result($ten_hocvien, $email, $phone);
    $stmt->fetch();
    $stmt->close();
}

// Kiểm tra nếu biểu mẫu được gửi
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $ten_hocvien = $_POST['ten_hocvien'] ?? $ten_hocvien;
//     $email = $_POST['email'] ?? $email;
//     $phone = $_POST['sdt'] ?? $phone;

//     // Cập nhật thông tin học viên
//     $sql_update_hocvien = "UPDATE hocvien SET ten_hocvien = ?, email = ?, so_dien_thoai = ? WHERE id_hocvien = ?";
//     $stmt_update = $conn->prepare($sql_update_hocvien);
//     $stmt_update->bind_param("sssi", $ten_hocvien, $email, $phone, $id_hocvien);

//     if ($stmt_update->execute()) {
//         echo "<script>alert('Cập nhật thông tin thành công!');</script>";
//     } else {
//         echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.');</script>";
//     }
//     $stmt_update->close();
// }

// Xử lý đăng ký khóa học
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ngay_dangky = date('Y-m-d');
    $trang_thai = 'cho xac nhan';

    if ($id_hocvien && $id_khoahoc) {
        // Kiểm tra xem học viên đã đăng ký khóa học này chưa
        $sql_check_existing = "SELECT id_dangky FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ?";
        $stmt_check = $conn->prepare($sql_check_existing);
        $stmt_check->bind_param("ii", $id_hocvien, $id_khoahoc);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Học viên đã đăng ký khóa học này rồi
            echo "<script>alert('Bạn đã đăng ký khóa học này rồi.');</script>";
        } else {
            // Thực hiện đăng ký khóa học
            $sql_insert_dangky = "INSERT INTO dangkykhoahoc (id_hocvien, id_khoahoc, ngay_dangky, trang_thai) VALUES (?, ?, ?, ?)";
            $stmt_dangky = $conn->prepare($sql_insert_dangky);
            $stmt_dangky->bind_param("iiss", $id_hocvien, $id_khoahoc, $ngay_dangky, $trang_thai);

            if ($stmt_dangky->execute()) {
                
                $to = $email;

                $subject = "Xác nhận đăng ký khóa học từ Tiếng Anh Fighter";
                $message = "Chào $ten_hocvien,\n\nCảm ơn bạn đã đăng ký khóa học tại trung tâm của chúng tôi. Đăng ký của bạn đang được chờ xác nhận từ quản trị viên.Chúng tôi sẽ liên hệ với bạn trong thời gian tới.\n\nTrân trọng,\nTrung Tâm Ôn Thi Tiếng Anh Fighter!";
                sendmail($to, $subject, $message);
                echo "<script>alert('Đăng ký thành công! Vui lòng kiểm tra email !.');</script>";

                echo "<script>
                window.location.href='./index.php?nav=dangkykhoahoc&course_id=$id_khoahoc';
        </script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.');</script>";

                echo "<script>
        window.location.href='./index.php?nav=dangkykhoahoc&course_id=$id_khoahoc';
        </script>";
            }
            $stmt_dangky->close();
        }

        $stmt_check->close();
    } else {
        echo "<script>alert('Vui lòng đăng nhập và chọn khóa học hợp lệ để tiếp tục.');</script>";

        echo "<script>
window.location.href='./index.php?nav=dangkykhoahoc&course_id=$id_khoahoc';
</script>";
    }
}
// Lấy thông tin khóa học từ cơ sở dữ liệu
$course_name = '';
$course_fee = 0;
if ($id_khoahoc) {
    $sql_course = "SELECT ten_khoahoc, chi_phi FROM khoahoc WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql_course);
    $stmt->bind_param("i", $id_khoahoc);
    $stmt->execute();
    $result_course = $stmt->get_result();

    // Kiểm tra nếu khóa học tồn tại
    if ($result_course->num_rows > 0) {
        $course = $result_course->fetch_assoc();
        $course_name = $course['ten_khoahoc'];
        $course_fee = $course['chi_phi'];
    } else {
        echo "<script>alert('Khóa học không tồn tại!'); window.location.href='index.php';</script>";
        exit;
    }
}
// Xử lý thanh toán khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $payment_status = 'Đã chuyển';  // Trạng thái thanh toán
    $payment_date = date('Y-m-d');  // Ngày thanh toán

    // Insert thông tin thanh toán vào bảng lichsu_thanhtoan
    $sql_insert_payment = "INSERT INTO lichsu_thanhtoan (id_hocvien, id_khoahoc, ngay_thanhtoan, so_tien, hinh_thuc, trang_thai) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_payment = $conn->prepare($sql_insert_payment);
    $stmt_payment->bind_param("iissss", $id_hocvien, $id_khoahoc, $payment_date, $course_fee, $payment_method, $payment_status);
    $stmt_payment->execute();

    $stmt_payment->close();
}



?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .account {
        display: flex;
        max-width: 1200px;
        margin: 20px auto;
        background-color: #ffff;
        border-radius: 8px;
        overflow: hidden;
        gap: 20px;
    }

    .account-left {
        flex: 1;
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
        height: 250px;
        box-shadow: 0 4px 8px #666;
        margin-left: 190px;
    }

    .account-left h3 {
        font-size: 18px;
        color: #0db33b;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .account-left ul {
        list-style: none;
        padding: 0;
    }

    .account-left ul li {
        margin-bottom: 15px;
    }

    .account-left ul li a {
        text-decoration: none;
        color: #0a5131;
        font-size: 16px;
        display: flex;
        align-items: center;
        font-weight: bold;
    }

    .account-right {
        flex: 3;
        background-color: #ffff;
        padding: 20px;
        border-radius: 8px;
        height: 100%;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .account-right h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #0db33b;
    }

    .form-group {
        margin-bottom: 15px;
        width: 500px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-group input[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .form-group textarea {
        height: 80px;
        resize: none;
    }

    .form-group-1 {
        display: flex;
        gap: 10px;
    }

    .form-group .verified {
        color: #28a745;
        font-weight: bold;
    }

    .btn-save {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
    }
    .form-group img{
        width: 60%;
    height: auto;
    }
    .btn-save:hover {
        background-color: #7be998;
    }
</style>



<div class="account">
    <div class="account-left">
        <h3 style="font-weight: bold;">Thông tin khóa học</h3>
        <ul>

            <?php
           

                    echo '
                        <li><a href="#">Tên lớp học: ' . $course_name . '</a></li>
                        <li><a href="#">Giá tiền: ' . $course_fee . ' VND</a></li>
                        ';
           
            ?>

        </ul>
    </div>

    <div class="account-right">
        <h2 style="font-weight: bold;">FORM ĐĂNG KÝ KHÓA HỌC</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="ten_hocvien">Họ và Tên:</label>
                <input type="text" id="ten_hocvien" name="ten_hocvien" placeholder="Họ và Tên" value="<?php echo htmlspecialchars($ten_hocvien); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Điện thoại:</label>
                <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo htmlspecialchars($phone); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>
            </div>

            <div class="form-group">
                <label for="payment_method">Hình thức thanh toán:</label>
                <select class="form-control" id="payment_method" name="payment_method" onchange="updateQRCode()">
                    <option value="Momo">Ví MoMo</option>
                    <option value="Ngân hàng">Chuyển khoản ngân hàng</option>
                </select>
            </div>

            <div class="form-group">
                <label for="qr_code">Mã QR:</label>
                <div id="qr_container">
                    <img id="qr_image" src="images/qr2.jpg" alt="QR Code" readonly>
                </div>
                <span class="verified">Verified ✔</span>
            </div>



            <button type="submit" class="btn-save">Thanh toán</button>

        </form>
    </div>
</div>
<script>
    function updateQRCode() {
        const paymentMethod = document.getElementById('payment_method').value;
        const qrImage = document.getElementById('qr_image');

        // Update the QR code image based on the selected payment method
        if (paymentMethod === 'Momo') {
            qrImage.src = 'images/qr2.jpg';
        } else if (paymentMethod === 'Ngân hàng') {
            qrImage.src = 'images/qr1.png';
        } 
    }
</script>