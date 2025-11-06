<?php
include('../../../config/config.php');

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $id = (int)($data['id'] ?? 0);

    if ($id > 0 && !empty($action)) {
        $conn->begin_transaction();
        try {
            if ($action === 'accept') {
                // 1. Lấy thông tin đăng ký để thêm vào lịch sử thanh toán
                $get_info_sql = "
                    SELECT dk.id_hocvien, dk.id_khoahoc, k.chi_phi 
                    FROM dangkykhoahoc dk
                    JOIN khoahoc k ON dk.id_khoahoc = k.id_khoahoc
                    WHERE dk.id_dangky = ? AND dk.trang_thai = 'cho xac nhan'
                ";
                $stmt_info = $conn->prepare($get_info_sql);
                $stmt_info->bind_param("i", $id);
                $stmt_info->execute();
                $result_info = $stmt_info->get_result();
                
                if ($result_info->num_rows > 0) {
                    $info = $result_info->fetch_assoc();
                    $id_hocvien = $info['id_hocvien'];
                    $id_khoahoc = $info['id_khoahoc'];
                    $chi_phi = $info['chi_phi'];
                    
                    // 2. Cập nhật trạng thái đăng ký
                    $stmt = $conn->prepare("UPDATE dangkykhoahoc SET trang_thai = 'da xac nhan' WHERE id_dangky = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    
                    // 3. Thêm vào lịch sử thanh toán
                    $ngay_thanhtoan = date('Y-m-d'); // Ngày hiện tại
                    $hinh_thuc = 'Tiền mặt';
                    $trang_thai = 'Đã thanh toán';
                    
                    $stmt_payment = $conn->prepare("
                        INSERT INTO lichsu_thanhtoan (id_hocvien, id_khoahoc, ngay_thanhtoan, so_tien, hinh_thuc, trang_thai) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $stmt_payment->bind_param("iisdss", $id_hocvien, $id_khoahoc, $ngay_thanhtoan, $chi_phi, $hinh_thuc, $trang_thai);
                    $stmt_payment->execute();
                    $stmt_payment->close();
                    
                    $response['message'] = 'Xác nhận đăng ký và ghi nhận thanh toán thành công!';
                } else {
                    throw new Exception("Không tìm thấy thông tin đăng ký hoặc đã được xử lý.");
                }
                
                $stmt_info->close();
            } elseif ($action === 'reject') {
                $stmt = $conn->prepare("UPDATE dangkykhoahoc SET trang_thai = 'bi tu choi' WHERE id_dangky = ? AND trang_thai = 'cho xac nhan'");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $response['message'] = 'Đã từ chối đơn đăng ký.';
            } elseif ($action === 'consulted') {
                $stmt = $conn->prepare("UPDATE tuvan SET trang_thai = 'Đã tư vấn' WHERE id_tuvan = ? AND trang_thai != 'Đã tư vấn'");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $response['message'] = 'Đã xác nhận tư vấn.';
            } else {
                 $response['message'] = 'Hành động không được hỗ trợ.';
                 echo json_encode($response);
                 exit;
            }

            if ($stmt->affected_rows > 0) {
                 $conn->commit();
                 $response['status'] = 'success';
            } else {
                 $conn->rollback();
                 $response['message'] = 'Không có gì thay đổi. Trạng thái có thể đã được cập nhật trước đó.';
            }
            $stmt->close();

        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
$conn->close();
?>