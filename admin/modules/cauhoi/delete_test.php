<?php
include('../../../config/config.php');
session_start();

if (isset($_GET['id_baitest'])) {
    $id_baitest = (int)$_GET['id_baitest'];
    // Do có ràng buộc khóa ngoại ON DELETE CASCADE,
    // khi xóa bài test, CSDL sẽ tự động xóa các câu hỏi, đáp án, kết quả liên quan.
    $sql = "DELETE FROM baitest WHERE id_baitest = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_baitest);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Xóa bài test thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi xóa bài test.'];
    }
}
header('Location: ../../admin.php?nav=question');
exit();
?>