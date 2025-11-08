<?php
// File: admin/modules/cauhoi/add_test.php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_baitest = $_POST['ten_baitest'];
    $loai_baitest = $_POST['loai_baitest'];
    $id_khoahoc = (!empty($_POST['id_khoahoc']) && $_POST['id_khoahoc'] !== '' && $_POST['id_khoahoc'] !== '0') ? (int)$_POST['id_khoahoc'] : NULL;
    
    // Xử lý id_lop: chỉ lấy giá trị nếu không rỗng và không phải "0"
    $id_lop = NULL;
    if (isset($_POST['id_lop']) && $_POST['id_lop'] !== '' && $_POST['id_lop'] !== '0') {
        $id_lop = trim($_POST['id_lop']);
    }
    
    $thoi_gian = (int)$_POST['thoi_gian'];

    if (($loai_baitest === 'dinh_ky') && is_null($id_khoahoc)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Bài kiểm tra định kỳ phải được gán cho một khóa học.'];
        header('Location: ../../admin.php?nav=question');
        exit();
    }
    
    // Bỏ logic ép NULL cho test đầu vào - cho phép gán khóa học/lớp học
    // Test đầu vào giờ có thể công khai (NULL) hoặc gán cho khóa học/lớp cụ thể
    
    // Kiểm tra xem id_lop có tồn tại trong bảng lop_hoc không (chỉ khi id_lop không NULL)
    if ($id_lop !== NULL) {
        $check_sql = "SELECT id_lop FROM lop_hoc WHERE id_lop = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('s', $id_lop);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows === 0) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => "Lỗi: Lớp học với ID '{$id_lop}' không tồn tại trong hệ thống. Vui lòng chọn lại lớp học."];
            $check_stmt->close();
            header('Location: ../../admin.php?nav=question');
            exit();
        }
        $check_stmt->close();
    }

    $sql = "INSERT INTO baitest (ten_baitest, loai_baitest, id_khoahoc, id_lop, thoi_gian, ngay_tao) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssiss', $ten_baitest, $loai_baitest, $id_khoahoc, $id_lop, $thoi_gian);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm bài test thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi thêm bài test: ' . $stmt->error];
    }
    header('Location: ../../admin.php?nav=question');
    exit();
}
?>