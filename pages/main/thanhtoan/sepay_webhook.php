<?php
// File: sepay_webhook.php
require('../../../config/config.php');
require('../../../config/PHPMailer/src/Exception.php');
require('../../../config/PHPMailer/src/PHPMailer.php');
require('../../../config/PHPMailer/src/SMTP.php');
require('../../../config/sendmail.php');

error_reporting(0);

// --- Lấy dữ liệu từ SePay ---
$data = json_decode(file_get_contents('php://input'));
if (!is_object($data) || !isset($data->content)) {
    die();
}

$transaction_content = $data->content;
$transfer_amount = $data->transferAmount;
$transfer_type = $data->transferType;

if ($transfer_type !== "in") {
    die();
}

// --- Lấy ID đăng ký từ nội dung giao dịch ---
$regex = '/DKKH(\d+)/i';
preg_match($regex, $transaction_content, $matches);
if (!isset($matches[1]) || !is_numeric($matches[1])) {
    die();
}
$dangky_id = (int)$matches[1];

// --- Xác thực đơn hàng trong CSDL ---
$sql_find_order = "SELECT dk.id_dangky, dk.id_hocvien,
                          kh.id_khoahoc, kh.chi_phi, kh.ten_khoahoc,
                          hv.ten_hocvien, hv.email
                   FROM dangkykhoahoc dk
                   JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
                   JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                   WHERE dk.id_dangky = ? AND dk.trang_thai = 'cho xac nhan'";

$stmt_find = $conn->prepare($sql_find_order);
$stmt_find->bind_param("i", $dangky_id);
$stmt_find->execute();
$result = $stmt_find->get_result();

if ($result->num_rows == 0) {
    die();
}
$order_info = $result->fetch_object();
$stmt_find->close();

// --- Kiểm tra số tiền ---
if (intval($transfer_amount) != intval($order_info->chi_phi)) {
    die();
}

// === BẮT ĐẦU GIAO DỊCH CSDL ===
$conn->begin_transaction();
try {
    // Tác vụ 1: Cập nhật trạng thái đơn hàng. TRIGGER SẼ TỰ ĐỘNG XỬ LÝ VIỆC XẾP LỚP VÀ TẠO TIẾN ĐỘ.
    $sql_update_order = "UPDATE dangkykhoahoc SET trang_thai = 'da xac nhan' WHERE id_dangky = ?";
    $stmt_update = $conn->prepare($sql_update_order);
    $stmt_update->bind_param("i", $dangky_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Tác vụ 2: Thêm bản ghi vào lịch sử thanh toán
    $payment_date = date('Y-m-d H:i:s');
    $sql_insert_history = "INSERT INTO lichsu_thanhtoan (id_hocvien, id_khoahoc, ngay_thanhtoan, so_tien, hinh_thuc, trang_thai) VALUES (?, ?, ?, ?, 'Chuyển khoản SePay', 'Đã hoàn thành')";
    $stmt_history = $conn->prepare($sql_insert_history);
    $stmt_history->bind_param("iisd", $order_info->id_hocvien, $order_info->id_khoahoc, $payment_date, $transfer_amount);
    $stmt_history->execute();
    $stmt_history->close();

    // Tác vụ 3: Gửi email xác nhận
    $to = $order_info->email;
    $subject = "✅ Xác nhận thanh toán thành công - " . $order_info->ten_khoahoc;
    
    // Định dạng số tiền
    $formatted_amount = number_format($transfer_amount, 0, ',', '.') . ' VNĐ';
    
    // Tạo nội dung HTML đẹp mắt
    $message_body = '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Xác nhận thanh toán</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f7f5;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f7f5; padding: 40px 20px;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        
                        <!-- Header với gradient xanh lá -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%); padding: 40px 30px; text-align: center;">
                                <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">
                                    🎉 Thanh toán thành công!
                                </h1>
                            </td>
                        </tr>
                        
                        <!-- Nội dung chính -->
                        <tr>
                            <td style="padding: 40px 30px;">
                                <p style="margin: 0 0 20px; font-size: 16px; color: #333; line-height: 1.6;">
                                    Xin chào <strong style="color: #0db33b;">' . htmlspecialchars($order_info->ten_hocvien) . '</strong>,
                                </p>
                                
                                <p style="margin: 0 0 25px; font-size: 16px; color: #555; line-height: 1.8;">
                                    Chúng tôi xác nhận đã nhận được thanh toán của bạn cho khóa học. Cảm ơn bạn đã tin tưởng và lựa chọn 
                                    <strong>Trung Tâm Tiếng Anh Fighter</strong>!
                                </p>
                                
                                <!-- Thông tin đơn hàng -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fbf9; border-radius: 12px; margin: 25px 0; border: 2px solid #e0f2e6;">
                                    <tr>
                                        <td style="padding: 25px;">
                                            <h3 style="margin: 0 0 15px; color: #0a8a2c; font-size: 18px; border-bottom: 2px solid #0db33b; padding-bottom: 10px;">
                                                📋 Thông tin đơn hàng
                                            </h3>
                                            
                                            <table width="100%" cellpadding="8" cellspacing="0" style="font-size: 15px;">
                                                <tr>
                                                    <td style="color: #666; padding: 8px 0;">Mã đơn hàng:</td>
                                                    <td style="color: #333; font-weight: bold; text-align: right;">#DKKH' . $dangky_id . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #666; padding: 8px 0;">Khóa học:</td>
                                                    <td style="color: #333; font-weight: bold; text-align: right;">' . htmlspecialchars($order_info->ten_khoahoc) . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #666; padding: 8px 0;">Số tiền thanh toán:</td>
                                                    <td style="color: #0db33b; font-weight: bold; font-size: 18px; text-align: right;">' . $formatted_amount . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #666; padding: 8px 0;">Ngày thanh toán:</td>
                                                    <td style="color: #333; font-weight: bold; text-align: right;">' . date('d/m/Y H:i') . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #666; padding: 8px 0;">Trạng thái:</td>
                                                    <td style="text-align: right;">
                                                        <span style="background-color: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 13px;">
                                                            ✓ Đã xác nhận
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Hướng dẫn tiếp theo -->
                                <div style="background: linear-gradient(135deg, #e8f8f0 0%, #c7ecd9 100%); border-radius: 12px; padding: 25px; margin: 25px 0;">
                                    <h3 style="margin: 0 0 15px; color: #0a8a2c; font-size: 18px;">
                                        🚀 Bước tiếp theo
                                    </h3>
                                    <ul style="margin: 0; padding-left: 20px; color: #555; line-height: 1.8;">
                                        <li style="margin-bottom: 10px;">Đăng nhập vào trang cá nhân để xem lịch học chi tiết</li>
                                        <li style="margin-bottom: 10px;">Kiểm tra thông tin lớp học và giáo viên phụ trách</li>
                                        <li style="margin-bottom: 10px;">Chuẩn bị tài liệu và sẵn sàng cho buổi học đầu tiên</li>
                                        <li>Tham gia group học viên để kết nối và trao đổi</li>
                                    </ul>
                                </div>
                                
                                <!-- Nút CTA -->
                                
                                <p style="margin: 25px 0 0; font-size: 15px; color: #666; line-height: 1.6;">
                                    Nếu bạn cần hỗ trợ, vui lòng liên hệ với chúng tôi qua:<br>
                                    📧 Email: <a href="mailto:support@fighter.edu.vn" style="color: #0db33b; text-decoration: none;">support@fighter.edu.vn</a><br>
                                    📞 Hotline: <strong style="color: #0db33b;">1900 xxxx</strong>
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background-color: #f8fbf9; padding: 30px; text-align: center; border-top: 1px solid #e0f2e6;">
                                <p style="margin: 0 0 10px; font-size: 16px; color: #333; font-weight: bold;">
                                    Trung Tâm Tiếng Anh Fighter
                                </p>
                                <p style="margin: 0; font-size: 14px; color: #666; line-height: 1.6;">
                                    Đồng hành cùng bạn trên hành trình chinh phục tiếng Anh<br>
                                   
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ';
    
    sendmail($to, $subject, $message_body);

    // Nếu tất cả các tác vụ trên thành công, xác nhận transaction
    $conn->commit();
    echo json_encode(['success' => TRUE]);
} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    error_log('SePay Webhook Transaction Failed: ' . $exception->getMessage());
    die();
}

$conn->close();
