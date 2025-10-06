<?php
// File: pages/main/thanhtoan/xuly_dangky.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('../../../config/config.php');

// --- KIỂM TRA ĐIỀU KIỆN BAN ĐẦU ---
if (!isset($_SESSION['id_hocvien'])) {
    die("Lỗi: Bạn cần đăng nhập để thực hiện chức năng này.");
}

$id_hocvien = $_SESSION['id_hocvien'];
$id_khoahoc = isset($_POST['id_khoahoc']) ? (int)$_POST['id_khoahoc'] : 0;
$id_lop = isset($_POST['id_lop']) && !empty($_POST['id_lop']) ? $_POST['id_lop'] : NULL;
$ghi_chu = isset($_POST['ghi_chu']) && !empty($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // =================================================================
    // TÍNH NĂNG MỚI 2: KIỂM TRA LỊCH HỌC TRÙNG (NẾU CHỌN LỚP CỤ THỂ)
    // =================================================================
    if ($id_lop) {
        // Lấy lịch học của lớp mới mà học viên muốn đăng ký
        $sql_new_schedule = "SELECT ngay_hoc, gio_bat_dau, gio_ket_thuc FROM lichhoc WHERE id_lop = ?";
        $stmt_new = $conn->prepare($sql_new_schedule);
        $stmt_new->bind_param("s", $id_lop);
        $stmt_new->execute();
        $new_schedules = $stmt_new->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt_new->close();

        // Lấy lịch học của TẤT CẢ các lớp mà học viên đã đăng ký thành công
        $sql_existing_schedule = "
            SELECT lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc 
            FROM lichhoc lh
            JOIN dangkykhoahoc dk ON lh.id_lop = dk.id_lop
            WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan' AND dk.id_lop IS NOT NULL
        ";
        $stmt_existing = $conn->prepare($sql_existing_schedule);
        $stmt_existing->bind_param("i", $id_hocvien);
        $stmt_existing->execute();
        $existing_schedules = $stmt_existing->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt_existing->close();

        // Thuật toán kiểm tra trùng lặp
        $conflict_found = false;
        foreach ($new_schedules as $new_session) {
            foreach ($existing_schedules as $existing_session) {
                // Chỉ kiểm tra nếu cùng ngày học
                if ($new_session['ngay_hoc'] == $existing_session['ngay_hoc']) {
                    $new_start = strtotime($new_session['gio_bat_dau']);
                    $new_end = strtotime($new_session['gio_ket_thuc']);
                    $existing_start = strtotime($existing_session['gio_bat_dau']);
                    $existing_end = strtotime($existing_session['gio_ket_thuc']);

                    // Điều kiện để 2 khoảng thời gian giao nhau (bị trùng)
                    if ($new_start < $existing_end && $existing_start < $new_end) {
                        $conflict_found = true;
                        break; // Thoát vòng lặp bên trong
                    }
                }
            }
            if ($conflict_found) {
                break; // Thoát vòng lặp bên ngoài
            }
        }
        
        // Nếu phát hiện trùng lặp, báo lỗi và dừng lại
        if ($conflict_found) {
            echo "<script>
                alert('Lỗi: Lịch học của lớp bạn chọn bị trùng với một lớp khác mà bạn đã đăng ký. Vui lòng chọn lớp khác hoặc đăng ký không chọn lớp.');
                window.history.back();
            </script>";
            exit();
        }
    }


    // --- LOGIC CŨ: Xử lý đơn hàng đang chờ hoặc tạo đơn hàng mới ---

    // Kiểm tra xem có đơn hàng nào đang chờ thanh toán cho khóa học này không
    $sql_check_pending = "SELECT id_dangky FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'cho xac nhan'";
    $stmt_check_pending = $conn->prepare($sql_check_pending);
    $stmt_check_pending->bind_param("ii", $id_hocvien, $id_khoahoc);
    $stmt_check_pending->execute();
    $result_pending = $stmt_check_pending->get_result();

    if ($result_pending->num_rows > 0) {
        // Nếu có, cập nhật lại thời gian và thông tin lớp/ghi chú, sau đó chuyển đến thanh toán
        $existing_order = $result_pending->fetch_assoc();
        $existing_dangky_id = $existing_order['id_dangky'];
        $stmt_check_pending->close();
        
        $sql_update_time = "UPDATE dangkykhoahoc SET thoi_gian_tao = NOW(), id_lop = ?, ghi_chu = ? WHERE id_dangky = ?";
        $stmt_update_time = $conn->prepare($sql_update_time);
        $stmt_update_time->bind_param("ssi", $id_lop, $ghi_chu, $existing_dangky_id);
        $stmt_update_time->execute();
        $stmt_update_time->close();

        header("Location: checkout.php?dangky_id=" . $existing_dangky_id);
        exit();
    }
    $stmt_check_pending->close();

    // Nếu không có, tạo một đơn đăng ký mới với trạng thái "chờ xác nhận"
    $ngay_dangky = date('Y-m-d');
    $trang_thai = 'cho xac nhan';
    $sql_insert_dangky = "INSERT INTO dangkykhoahoc (id_hocvien, id_khoahoc, id_lop, ghi_chu, ngay_dangky, trang_thai) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_dangky = $conn->prepare($sql_insert_dangky);
    $stmt_dangky->bind_param("iissss", $id_hocvien, $id_khoahoc, $id_lop, $ghi_chu, $ngay_dangky, $trang_thai);

    if ($stmt_dangky->execute()) {
        $new_dangky_id = $stmt_dangky->insert_id;
        $stmt_dangky->close();
        header("Location: checkout.php?dangky_id=" . $new_dangky_id);
        exit();
    } else {
        die("Có lỗi xảy ra trong quá trình tạo đơn đăng ký: " . $conn->error);
    }
} else {
    header("Location: ../../../index.php");
    exit();
}
?>