<?php
// File: admin/modules/add_material.php
include('../../../config/config.php');
session_start();

// --- KIỂM TRA ĐIỀU KIỆN BAN ĐẦU ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_giangvien'])) {
    // Nếu không phải POST request hoặc giảng viên chưa đăng nhập, chuyển hướng
    header('Location: ../admin.php?nav=teacher_materials');
    exit();
}

$id_giangvien = $_SESSION['id_giangvien'];
$id_lop = $_POST['id_lop'] ?? null;
$tieu_de = $_POST['tieu_de'] ?? '';

// --- KIỂM TRA DỮ LIỆU ĐẦU VÀO ---
if (empty($id_lop) || empty($tieu_de) || !isset($_FILES['hoc_lieu_file']) || $_FILES['hoc_lieu_file']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Vui lòng điền đầy đủ thông tin và chọn file.'];
    header('Location: ../admin.php?nav=teacher_materials&lop_id=' . $id_lop);
    exit();
}

// ================================================================
// === BỔ SUNG BẢO MẬT: XÁC THỰC GIẢNG VIÊN CÓ QUYỀN VỚI LỚP HỌC NÀY KHÔNG ===
// ================================================================
$stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
$stmt_check->bind_param("si", $id_lop, $id_giangvien);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check->num_rows === 0) {
    // Nếu không có kết quả, tức giảng viên không sở hữu lớp này
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Bạn không có quyền thêm học liệu cho lớp này.'];
    header('Location: ../admin.php?nav=teacher_materials');
    exit();
}
$stmt_check->close();
// ================================================================

// --- XỬ LÝ TẢI FILE LÊN ---
$file = $_FILES['hoc_lieu_file'];
$file_name = time() . '_' . basename($file['name']);
$file_type = strtoupper(pathinfo($file_name, PATHINFO_EXTENSION));
$target_dir = "../../uploads/materials/";

if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

$target_file = $target_dir . $file_name;

if (move_uploaded_file($file['tmp_name'], $target_file)) {
    $duong_dan_file = 'uploads/materials/' . $file_name;
    
    $sql = "INSERT INTO hoc_lieu (id_lop, tieu_de, loai_file, duong_dan_file, ngay_dang) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $id_lop, $tieu_de, $file_type, $duong_dan_file);
    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Tải lên học liệu thành công!'];
    } else {
        // Nếu lỗi DB, xóa file đã tải lên
        unlink($target_file);
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi CSDL khi lưu thông tin.'];
    }
    $stmt->close();
} else {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Có lỗi xảy ra khi tải file lên.'];
}

// Chuyển hướng về trang học liệu của lớp đó
header('Location: ../../admin.php?nav=teacher_materials&lop_id=' . $id_lop);
exit();
?>