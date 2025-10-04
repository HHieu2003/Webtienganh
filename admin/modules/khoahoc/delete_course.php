<?php
include('../../../config/config.php');

if (isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];

    // Bắt đầu một transaction để đảm bảo tất cả các lệnh xóa đều thành công
    $conn->begin_transaction();

    try {
        // Mảng các bảng có khóa ngoại tham chiếu đến id_khoahoc và cần xóa thủ công
        // Các bảng có 'ON DELETE CASCADE' (như lop_hoc, baitest) sẽ được CSDL tự động xử lý
        $dependent_tables = [
            'danhgiakhoahoc',
            'lichsu_thanhtoan',
            'tien_do_hoc_tap',
            'thongbao',
            'dangkykhoahoc' 
        ];

        // Vòng lặp để xóa các bản ghi liên quan từ các bảng phụ thuộc
        foreach ($dependent_tables as $table) {
            $sql_delete_dependent = "DELETE FROM $table WHERE id_khoahoc = ?";
            $stmt_dependent = $conn->prepare($sql_delete_dependent);
            $stmt_dependent->bind_param("i", $delete_id);
            $stmt_dependent->execute();
            $stmt_dependent->close();
        }

        // Cuối cùng, xóa chính khóa học đó
        // Lưu ý: Các lớp học (lop_hoc) và bài test (baitest) liên quan sẽ tự động bị xóa
        // do đã được thiết lập 'ON DELETE CASCADE' trong CSDL.
        $sql_delete_course = "DELETE FROM khoahoc WHERE id_khoahoc = ?";
        $stmt_course = $conn->prepare($sql_delete_course);
        $stmt_course->bind_param("i", $delete_id);
        $stmt_course->execute();
        $stmt_course->close();

        // Nếu tất cả các lệnh xóa thành công, xác nhận transaction
        $conn->commit();
        echo "Xóa thành công";

    } catch (mysqli_sql_exception $exception) {
        // Nếu có bất kỳ lỗi nào xảy ra, hủy bỏ tất cả các thay đổi
        $conn->rollback();
        
        // Trả về lỗi chi tiết hơn
        echo "Lỗi khi xóa: Không thể xóa khóa học do có lỗi ràng buộc dữ liệu. Chi tiết: " . $exception->getMessage();
    }

} else {
    echo "Không có ID khóa học được cung cấp.";
}

$conn->close();
?>