<?php
include('../../../config/config.php');

// Kiểm tra phương thức HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $id_lop = intval($_POST['id_lop']); // Đảm bảo ID là số nguyên
    $trang_thai = mysqli_real_escape_string($conn, $_POST['trang_thai']); // Tránh SQL Injection

    // Kiểm tra trạng thái hợp lệ
    if ($trang_thai !== 'dang hoc' && $trang_thai !== 'da xong') {
        echo "Trạng thái không hợp lệ.";
        exit;
    }

    // Kiểm tra ID lớp có tồn tại trong bảng không
    $check_sql = "SELECT COUNT(*) AS total FROM lop_hoc WHERE id_lop = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, 'i', $id_lop);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    $row = $result->fetch_assoc();

    if ($row['total'] == 0) {
        echo "ID lớp không tồn tại.";
        exit;
    }

    // Cập nhật trạng thái lớp học cụ thể
    $sql = "UPDATE lop_hoc SET trang_thai = ? WHERE id_lop = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Nếu lệnh chuẩn bị thất bại
    if (!$stmt) {
        echo "Lỗi chuẩn bị câu lệnh: " . mysqli_error($conn);
        exit;
    }

    // Gán giá trị và thực thi câu lệnh SQL
    mysqli_stmt_bind_param($stmt, 'si', $trang_thai, $id_lop);
    if (mysqli_stmt_execute($stmt)) {
        echo "success"; // Phản hồi thành công
    } else {
        echo "Lỗi: " . mysqli_error($conn); // Phản hồi lỗi nếu xảy ra
    }
} else {
    // Nếu phương thức không phải POST, trả về lỗi
    echo "Phương thức không hợp lệ.";
}
?>
