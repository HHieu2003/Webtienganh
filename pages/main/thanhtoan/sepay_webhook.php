<?php
// File: sepay_webhook.php
// Endpoint nhận webhook từ SePay.

// --- Các file cần thiết ---
require('../../../config/config.php');
// Thêm các file PHPMailer và file gửi mail của bạn
require('../../../config/PHPMailer/src/Exception.php');
require('../../../config/PHPMailer/src/PHPMailer.php');
require('../../../config/PHPMailer/src/SMTP.php');
require('../../../config/sendmail.php');


// --- Lấy dữ liệu từ SePay gửi đến ---
$data = json_decode(file_get_contents('php://input'));

// Nếu không có dữ liệu hoặc dữ liệu không hợp lệ, dừng lại
if(!is_object($data) || !isset($data->content)) {
    die();
}


// --- Khởi tạo các biến từ dữ liệu SePay ---
$transaction_content = $data->content;    // Nội dung chuyển khoản (ví dụ: DKKH123)
$transfer_amount = $data->transferAmount;  // Số tiền chuyển
$transfer_type = $data->transferType;      // Loại giao dịch ('in' hoặc 'out')


// --- Bắt đầu xử lý ---
// Chỉ xử lý các giao dịch "tiền vào" (in)
if ($transfer_type !== "in") {
    die();
}

// Dùng biểu thức chính quy (regex) để tách mã đơn đăng ký từ nội dung
// Ví dụ: tìm chuỗi "DKKH" theo sau là các chữ số
$regex = '/DKKH(\d+)/i';
preg_match($regex, $transaction_content, $matches);

// Nếu không tìm thấy mã đơn hàng hợp lệ trong nội dung chuyển khoản thì dừng lại
if (!isset($matches[1]) || !is_numeric($matches[1])) {
    die();
}
$dangky_id = (int)$matches[1];


// --- Xác thực đơn hàng trong Cơ sở dữ liệu ---
// Truy vấn để lấy đầy đủ thông tin đơn hàng, khóa học và học viên
// Chỉ tìm các đơn hàng đang ở trạng thái "chờ xác nhận"
$sql_find_order = "SELECT dk.id_dangky, dk.id_hocvien, dk.thoi_gian_tao,
                          kh.chi_phi, kh.id_khoahoc, kh.ten_khoahoc,
                          hv.ten_hocvien, hv.email
                   FROM dangkykhoahoc dk
                   JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
                   JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                   WHERE dk.id_dangky = ? 
                   AND dk.trang_thai = 'cho xac nhan'";
                   
$stmt_find = $conn->prepare($sql_find_order);
$stmt_find->bind_param("i", $dangky_id);
$stmt_find->execute();
$result = $stmt_find->get_result();

// Nếu không tìm thấy đơn hàng phù hợp (có thể đã được xử lý hoặc không tồn tại)
if ($result->num_rows == 0) {
    die();
}
$order_info = $result->fetch_object();
$stmt_find->close();


// --- KIỂM TRA CÁC ĐIỀU KIỆN ---

// 1. Kiểm tra đơn hàng đã hết hạn chưa (quá 30 phút)
$thoi_gian_tao = new DateTime($order_info->thoi_gian_tao);
$thoi_gian_hien_tai = new DateTime();
$thoi_gian_het_han = (clone $thoi_gian_tao)->add(new DateInterval('PT5M'));

if ($thoi_gian_hien_tai > $thoi_gian_het_han) {
    // Nếu đơn hàng đã hết hạn, không xử lý thanh toán và dừng lại.
    // (Tùy chọn: bạn có thể cập nhật trạng thái đơn hàng thành 'da huy' ở đây)
    die(); 
}

// 2. Kiểm tra số tiền chuyển khoản có khớp với học phí khóa học không
if (intval($transfer_amount) != intval($order_info->chi_phi)) {
    // Nếu số tiền không khớp, dừng lại. 
    // (Bạn nên ghi log lại trường hợp này để kiểm tra thủ công)
    die();
}


// --- Mọi thứ hợp lệ, tiến hành cập nhật ---
// Sử dụng transaction để đảm bảo tất cả các thao tác CSDL đều thành công hoặc thất bại cùng lúc
$conn->begin_transaction();
try {
    // Tác vụ 1: Cập nhật trạng thái đơn hàng thành 'da xac nhan'
    $sql_update_order = "UPDATE dangkykhoahoc SET trang_thai = 'da xac nhan' WHERE id_dangky = ?";
    $stmt_update = $conn->prepare($sql_update_order);
    $stmt_update->bind_param("i", $dangky_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Tác vụ 2: Thêm bản ghi vào lịch sử thanh toán
    $payment_date = date('Y-m-d H:i:s');
    $payment_method = 'Chuyển khoản SePay'; // Ghi nhận phương thức từ webhook
    $payment_status = 'Đã chuyển';
    
    $sql_insert_history = "INSERT INTO lichsu_thanhtoan 
                            (id_hocvien, id_khoahoc, ngay_thanhtoan, so_tien, hinh_thuc, trang_thai) 
                           VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_history = $conn->prepare($sql_insert_history);
    $stmt_history->bind_param(
        "iisdss", 
        $order_info->id_hocvien, 
        $order_info->id_khoahoc, 
        $payment_date, 
        $transfer_amount, 
        $payment_method, 
        $payment_status
    );
    $stmt_history->execute();
    $stmt_history->close();

    // Tác vụ 3: Gửi email xác nhận thanh toán thành công cho học viên
    $to = $order_info->email;
    $subject = "Xác nhận thanh toán thành công khóa học: " . $order_info->ten_khoahoc;
    $message = "Chào " . $order_info->ten_hocvien . ",\n\nChúng tôi xác nhận đã nhận được thanh toán của bạn cho khóa học '" . $order_info->ten_khoahoc . "'.\nKhóa học của bạn đã được kích hoạt. Vui lòng đăng nhập vào website để bắt đầu học.\n\nTrân trọng,\nTrung Tâm Ôn Thi Tiếng Anh Fighter!";
    
    // Gọi hàm sendmail đã được định nghĩa trong file sendmail.php
    sendmail($to, $subject, $message); 

    // Nếu tất cả các tác vụ trên thành công, xác nhận transaction
    $conn->commit();
    echo json_encode(['success' => TRUE]);

} catch (mysqli_sql_exception $exception) {
    // Nếu có bất kỳ lỗi nào xảy ra, hủy bỏ tất cả thay đổi
    $conn->rollback();
    // Ghi lại lỗi để debug (lỗi sẽ được lưu trong file error log của server)
    error_log('SePay Webhook Failed: ' . $exception->getMessage());
    die();
}

// Đóng kết nối CSDL
$conn->close();
?>