<?php
include('../../../config/config.php'); // Kết nối database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cauhoi = intval($_POST['id_cauhoi']);

    // Kiểm tra xem câu hỏi có tồn tại không
    $sql_check = "SELECT * FROM cauhoi WHERE id_cauhoi = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 'i', $id_cauhoi);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result) === 0) {
        echo json_encode(['success' => false, 'message' => 'Câu hỏi không tồn tại.']);
        exit;
    }

    // Xóa các đáp án liên quan trước
    $sql_delete_answers = "DELETE FROM dapan WHERE id_cauhoi = ?";
    $stmt_delete_answers = mysqli_prepare($conn, $sql_delete_answers);
    mysqli_stmt_bind_param($stmt_delete_answers, 'i', $id_cauhoi);
    mysqli_stmt_execute($stmt_delete_answers);

    // Xóa câu hỏi
    $sql_delete_question = "DELETE FROM cauhoi WHERE id_cauhoi = ?";
    $stmt_delete_question = mysqli_prepare($conn, $sql_delete_question);
    mysqli_stmt_bind_param($stmt_delete_question, 'i', $id_cauhoi);

    if (mysqli_stmt_execute($stmt_delete_question)) {
        echo json_encode(['success' => true, 'message' => 'Xóa câu hỏi thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa câu hỏi.']);
    }
    exit;
}
?>
