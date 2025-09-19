<?php
include('../../../config/config.php');

// Kiểm tra nếu có ID hoc vien cần xóa
if (isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id']; // Chuyển sang kiểu int để an toàn hơn

    // Bắt đầu một transaction
    // Điều này đảm bảo rằng tất cả các lệnh xóa đều thành công, hoặc không có lệnh nào được thực thi cả.
    $conn->begin_transaction();

    try {
        // Mảng các bảng có khóa ngoại tham chiếu đến id_hocvien (và không có ON DELETE CASCADE)
        // Dựa trên file csdl.txt của bạn
        $dependent_tables = [
            'dangkykhoahoc',
            'ketquabaitest',
            'thongbao',
            'danhgiakhoahoc',
            'lichsu_thanhtoan',
            'tien_do_hoc_tap'
            // Các bảng diem_danh và diem_so đã có 'ON DELETE CASCADE' trong CSDL nên không cần xóa ở đây
        ];

        // Vòng lặp để xóa các bản ghi liên quan từ các bảng phụ thuộc
        foreach ($dependent_tables as $table) {
            $sql_delete_dependent = "DELETE FROM $table WHERE id_hocvien = ?";
            $stmt_dependent = $conn->prepare($sql_delete_dependent);
            $stmt_dependent->bind_param("i", $delete_id);
            $stmt_dependent->execute();
            $stmt_dependent->close();
        }

        // Sau khi xóa tất cả các bản ghi phụ thuộc, tiến hành xóa học viên
        $sql_delete_student = "DELETE FROM hocvien WHERE id_hocvien = ?";
        $stmt_student = $conn->prepare($sql_delete_student);
        $stmt_student->bind_param("i", $delete_id);
        $stmt_student->execute();
        $stmt_student->close();

        // Nếu tất cả các lệnh xóa thành công, commit transaction
        $conn->commit();
        echo "Xóa thành công";

    } catch (mysqli_sql_exception $exception) {
        // Nếu có bất kỳ lỗi nào xảy ra, rollback lại tất cả các thay đổi
        $conn->rollback();
        // Ghi lại lỗi hoặc hiển thị thông báo chung
        // "Lỗi khi xóa: " . $exception->getMessage() sẽ cung cấp thông tin chi tiết hơn
        echo "Lỗi: Không thể xóa học viên do có lỗi ràng buộc dữ liệu.";

    }

} else {
    echo "Không có ID được cung cấp.";
}

$conn->close();
?>