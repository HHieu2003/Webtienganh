<?php
// File: sepay_webhook.php
require('../../../config/config.php');
require('../../../config/PHPMailer/src/Exception.php');
require('../../../config/PHPMailer/src/PHPMailer.php');
require('../../../config/PHPMailer/src/SMTP.php');
require('../../../config/sendmail.php');

$data = json_decode(file_get_contents('php://input'));
if(!is_object($data) || !isset($data->content)) { die(); }

$transaction_content = $data->content;
$transfer_amount = $data->transferAmount;
$transfer_type = $data->transferType;

if ($transfer_type !== "in") { die(); }

$regex = '/DKKH(\d+)/i';
preg_match($regex, $transaction_content, $matches);
if (!isset($matches[1]) || !is_numeric($matches[1])) { die(); }
$dangky_id = (int)$matches[1];

// --- CẬP NHẬT TRUY VẤN: Lấy thêm id_lop ---
$sql_find_order = "SELECT dk.id_dangky, dk.id_hocvien, dk.thoi_gian_tao, dk.id_lop,
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

if ($result->num_rows == 0) { die(); }
$order_info = $result->fetch_object();
$stmt_find->close();

// Kiểm tra hết hạn và số tiền (giữ nguyên)
// ...

// --- Bắt đầu Transaction ---
$conn->begin_transaction();
try {
    // Tác vụ 1: Cập nhật trạng thái đơn hàng (giữ nguyên)
    $sql_update_order = "UPDATE dangkykhoahoc SET trang_thai = 'da xac nhan' WHERE id_dangky = ?";
    $stmt_update = $conn->prepare($sql_update_order);
    $stmt_update->bind_param("i", $dangky_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Tác vụ 2: Thêm lịch sử thanh toán (giữ nguyên)
    $payment_date = date('Y-m-d H:i:s');
    $sql_insert_history = "INSERT INTO lichsu_thanhtoan (id_hocvien, id_khoahoc, ngay_thanhtoan, so_tien, hinh_thuc, trang_thai) VALUES (?, ?, ?, ?, 'Chuyển khoản SePay', 'Đã chuyển')";
    $stmt_history = $conn->prepare($sql_insert_history);
    $stmt_history->bind_param("iisd", $order_info->id_hocvien, $order_info->id_khoahoc, $payment_date, $transfer_amount);
    $stmt_history->execute();
    $stmt_history->close();

    // *** TÁC VỤ 3 (MỚI): TỰ ĐỘNG TẠO TIẾN ĐỘ HỌC TẬP ***
    // Chỉ thực hiện khi học viên đã chọn một lớp cụ thể
    if ($order_info->id_lop !== null) {
        // Đếm tổng số buổi học của lớp đó
        $stmt_count_sessions = $conn->prepare("SELECT COUNT(*) as total FROM lichhoc WHERE id_lop = ?");
        $stmt_count_sessions->bind_param("s", $order_info->id_lop);
        $stmt_count_sessions->execute();
        $total_sessions = $stmt_count_sessions->get_result()->fetch_assoc()['total'] ?? 0;
        $stmt_count_sessions->close();
        
        // Thêm bản ghi tiến độ học tập mới
        // Sử dụng INSERT IGNORE để tránh lỗi nếu bản ghi đã tồn tại (phòng trường hợp hi hữu)
        $sql_progress = "INSERT IGNORE INTO tien_do_hoc_tap (id_hocvien, id_khoahoc, tong_so_buoi) VALUES (?, ?, ?)";
        $stmt_progress = $conn->prepare($sql_progress);
        $stmt_progress->bind_param("iii", $order_info->id_hocvien, $order_info->id_khoahoc, $total_sessions);
        $stmt_progress->execute();
        $stmt_progress->close();
    }
    
    // Tác vụ 4: Gửi email xác nhận (giữ nguyên)
    $to = $order_info->email;
    $subject = "Xác nhận thanh toán thành công khóa học: " . $order_info->ten_khoahoc;
    $message_body = "Chào " . $order_info->ten_hocvien . ",\n\nChúng tôi xác nhận đã nhận được thanh toán của bạn cho khóa học '" . $order_info->ten_khoahoc . "'.\nKhóa học của bạn đã được kích hoạt. Vui lòng đăng nhập vào trang cá nhân để xem lịch học và bắt đầu hành trình của mình.\n\nTrân trọng,\nTrung Tâm Tiếng Anh Fighter!";
    sendmail($to, $subject, $message_body); 

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => TRUE]);

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    error_log('SePay Webhook Failed: ' . $exception->getMessage());
    die();
}

$conn->close();
?>