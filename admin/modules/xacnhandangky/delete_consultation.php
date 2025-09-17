<?php
// admin/modules/delete_consultation.php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    $delete_ids = $_POST['delete_ids'];

    // Đảm bảo delete_ids là một mảng
    if (!is_array($delete_ids)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Dữ liệu không hợp lệ.'];
        header("Location: ../admin.php?nav=dangkykhoahoc&view=consult");
        exit();
    }

    // Chuyển các ID thành một chuỗi các số nguyên an toàn
    $ids_to_delete = array_map('intval', $delete_ids);
    $placeholders = implode(',', array_fill(0, count($ids_to_delete), '?'));
    
    if (empty($ids_to_delete)) {
        $_SESSION['message'] = ['type' => 'warning', 'text' => 'Chưa có mục nào được chọn để xóa.'];
        header("Location: ../admin.php?nav=dangkykhoahoc&view=consult");
        exit();
    }

    $sql = "DELETE FROM tuvan WHERE id_tuvan IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    
    // Tạo chuỗi types (ví dụ: 'iii' cho 3 ID)
    $types = str_repeat('i', count($ids_to_delete));
    $stmt->bind_param($types, ...$ids_to_delete);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Đã xóa thành công các yêu cầu tư vấn đã chọn.'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi xóa yêu cầu tư vấn.'];
    }
    
    $stmt->close();
} else {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Yêu cầu không hợp lệ.'];
}

$conn->close();
header("Location: ../../admin.php?nav=dangkykhoahoc&view=consult");
exit();
?>