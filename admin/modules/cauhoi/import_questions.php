<?php
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['question_file'])) {
    $id_baitest = (int)$_POST['id_baitest_import'];
    $file = $_FILES['question_file'];

    // Kiểm tra file có phải là CSV không
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (strtolower($file_extension) !== 'csv') {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi: Vui lòng chỉ tải lên file có định dạng .csv'];
        header("Location: ../../admin.php?nav=ds_cauhoi&id_baitest=$id_baitest");
        exit();
    }

    $file_handle = fopen($file['tmp_name'], 'r');
    
    // Bỏ qua dòng tiêu đề đầu tiên
    fgetcsv($file_handle);

    $conn->begin_transaction();
    try {
        $sql_question = "INSERT INTO cauhoi (id_baitest, noi_dung) VALUES (?, ?)";
        $stmt_question = $conn->prepare($sql_question);

        $sql_answer = "INSERT INTO dapan (id_cauhoi, noi_dung_dapan, la_dung) VALUES (?, ?, ?)";
        $stmt_answer = $conn->prepare($sql_answer);

        while (($row = fgetcsv($file_handle, 1000, ",")) !== FALSE) {
            // Lấy dữ liệu từ các cột
            $noi_dung_cau_hoi = $row[0] ?? '';
            $dapan_1 = $row[1] ?? '';
            $dapan_2 = $row[2] ?? '';
            $dapan_3 = $row[3] ?? '';
            $dapan_4 = $row[4] ?? '';
            $dapan_dung_index = (int)($row[5] ?? 0);

            if (empty($noi_dung_cau_hoi)) continue; // Bỏ qua dòng trống

            // 1. Thêm câu hỏi vào CSDL
            $stmt_question->bind_param("is", $id_baitest, $noi_dung_cau_hoi);
            $stmt_question->execute();
            $id_cauhoi_moi = $stmt_question->insert_id;

            // 2. Thêm các đáp án
            $answers = [$dapan_1, $dapan_2, $dapan_3, $dapan_4];
            foreach ($answers as $index => $answer_text) {
                if (!empty($answer_text)) {
                    $la_dung = (($index + 1) == $dapan_dung_index) ? 1 : 0;
                    $stmt_answer->bind_param("isi", $id_cauhoi_moi, $answer_text, $la_dung);
                    $stmt_answer->execute();
                }
            }
        }

        $conn->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Nhập câu hỏi từ file thành công!'];

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Lỗi khi nhập file: ' . $e->getMessage()];
    }

    fclose($file_handle);
    header("Location: ../../admin.php?nav=ds_cauhoi&id_baitest=$id_baitest");
    exit();
}
?>