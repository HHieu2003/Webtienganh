<?php
// user/modules/view_test_submission.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập.");
}

$id_hocvien = $_SESSION['id_hocvien'];
$id_ketqua = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id_ketqua) {
    echo "<div class='alert alert-danger'>ID kết quả không hợp lệ.</div>";
    return;
}

// Lấy thông tin cơ bản và xác thực chủ sở hữu
$sql_result_info = "SELECT bt.ten_baitest, kq.diem, kq.id_baitest 
                    FROM ketquabaitest kq
                    JOIN baitest bt ON kq.id_baitest = bt.id_baitest
                    WHERE kq.id_ketqua = ? AND kq.id_hocvien = ?";
$stmt_info = $conn->prepare($sql_result_info);
$stmt_info->bind_param("ii", $id_ketqua, $id_hocvien);
$stmt_info->execute();
$result_info = $stmt_info->get_result()->fetch_assoc();
$stmt_info->close();

if (!$result_info) {
    echo "<div class='alert alert-danger'>Không tìm thấy hoặc bạn không có quyền xem kết quả này.</div>";
    return;
}

$id_baitest = $result_info['id_baitest'];

// Lấy câu trả lời của học viên (bao gồm cả tự luận)
$sql_student_answers = "SELECT id, id_cauhoi, id_dapan_chon, tra_loi_tu_luan, diem_tu_luan, nhan_xet_tu_luan, trang_thai_cham FROM dapan_hocvien WHERE id_ketqua = ?";
$stmt_sa = $conn->prepare($sql_student_answers);
$stmt_sa->bind_param("i", $id_ketqua);
$stmt_sa->execute();
$result_sa = $stmt_sa->get_result();
$student_answers = [];
while ($row = $result_sa->fetch_assoc()) {
    $student_answers[$row['id_cauhoi']] = $row;
}
$stmt_sa->close();

// Lấy toàn bộ câu hỏi và đáp án của bài test
$sql_questions = "
    SELECT c.id_cauhoi, c.noi_dung, c.loai_cauhoi, d.id_dapan, d.noi_dung_dapan, d.la_dung
    FROM cauhoi c
    LEFT JOIN dapan d ON c.id_cauhoi = d.id_cauhoi
    WHERE c.id_baitest = ?
    ORDER BY c.id_cauhoi, d.id_dapan
";
$stmt_q = $conn->prepare($sql_questions);
$stmt_q->bind_param("i", $id_baitest);
$stmt_q->execute();
$result_q = $stmt_q->get_result();
$questions_data = [];
while ($row = $result_q->fetch_assoc()) {
    if (!isset($questions_data[$row['id_cauhoi']])) {
        $questions_data[$row['id_cauhoi']] = [
            'noi_dung' => $row['noi_dung'],
            'loai_cauhoi' => $row['loai_cauhoi'],
            'answers' => []
        ];
    }
    if ($row['id_dapan']) { // Chỉ thêm đáp án nếu có
        $questions_data[$row['id_cauhoi']]['answers'][] = $row;
    }
}
$stmt_q->close();
?>

<style>
    .review-container {
        max-width: 800px;
        margin: auto;
    }

    .question-review-block {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        margin-bottom: 20px;
        padding: 20px;
    }

    .question-review-block p.question-title {
        font-size: 17px;
        font-weight: 600;
    }

    .answer-review-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .answer-review-item {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .answer-review-item .icon {
        font-size: 18px;
    }

    /* Correct Answer */
    .answer-correct {
        background-color: #d1e7dd;
        border-color: #a3cfbb;
        color: #0f5132;
    }

    /* Incorrect Answer (Chosen by student) */
    .answer-incorrect {
        background-color: #f8d7da;
        border-color: #f1aeb5;
        color: #721c24;
        text-decoration: line-through;
    }

    /* CSS cho phần tự luận */
    .essay-submission-box {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }

    .essay-submission-box h6 {
        font-weight: 600;
        color: #555;
    }

    .essay-submission-box .essay-content {
        white-space: pre-wrap;
        /* Giữ nguyên định dạng xuống dòng */
        font-style: italic;
        color: #333;
    }

    .ai-feedback-box {
        margin-top: 15px;
        border-top: 2px dashed #0db33b;
        padding-top: 15px;
    }

    .ai-feedback-box h6 {
        font-weight: 600;
        color: #0a8a2c;
    }
</style>

<div class="content-pane">
    <div class="d-flex align-items-center mb-4">
        <a href="?nav=ketquakiemtra" class="btn btn-outline-secondary me-3"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        <h2 class="mb-0"><?php echo htmlspecialchars($result_info['ten_baitest']); ?></h2>
    </div>

    <div class="review-container">
        <?php
        $question_number = 1;
        foreach ($questions_data as $id_cauhoi => $data): ?>
            <div class="question-review-block">
                <p class="question-title"><strong>Câu <?php echo $question_number++; ?>.</strong> <?php echo htmlspecialchars($data['noi_dung']); ?></p>

                <?php if ($data['loai_cauhoi'] === 'trac_nghiem'): ?>
                    <ul class="answer-review-list">
                        <?php foreach ($data['answers'] as $answer):
                            $student_choice_id = $student_answers[$id_cauhoi]['id_dapan_chon'] ?? null;
                            $is_correct = $answer['la_dung'] == 1;
                            $is_chosen = $student_choice_id == $answer['id_dapan'];

                            $class = '';
                            $icon = '<i class="fa-regular fa-circle icon text-muted"></i>';

                            if ($is_correct) {
                                $class = 'answer-correct';
                                $icon = '<i class="fa-solid fa-check-circle icon"></i>';
                            }
                            if ($is_chosen && !$is_correct) {
                                $class = 'answer-incorrect';
                                $icon = '<i class="fa-solid fa-times-circle icon"></i>';
                            }
                        ?>
                            <li class="answer-review-item <?php echo $class; ?>">
                                <?php echo $icon; ?>
                                <span><?php echo htmlspecialchars($answer['noi_dung_dapan']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: // Đây là câu hỏi tự luận 
                ?>
                    <div class="essay-submission-box">
                        <h6><i class="fa-solid fa-pen-nib me-2"></i>Bài làm của bạn:</h6>
                        <div class="essay-content"><?php echo htmlspecialchars($student_answers[$id_cauhoi]['tra_loi_tu_luan'] ?? 'Bạn chưa trả lời câu hỏi này.'); ?></div>
                    </div>

                    <?php if (isset($student_answers[$id_cauhoi]) && $student_answers[$id_cauhoi]['trang_thai_cham'] === 'da_cham'): ?>
                        <div class="ai-feedback-box">
                            <h6><i class="fa-solid fa-robot me-2"></i>Đánh giá từ AI:</h6>
                            <p><strong>Điểm số:</strong> <span class="badge bg-success fs-6"><?php echo htmlspecialchars($student_answers[$id_cauhoi]['diem_tu_luan']); ?> / 10</span></p>
                            <p><strong>Nhận xét chi tiết:</strong></p>
                            <div><?php echo nl2br(htmlspecialchars($student_answers[$id_cauhoi]['nhan_xet_tu_luan'])); ?></div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mt-3 text-center">
                            Bài làm của bạn đang chờ giảng viên chấm điểm. Vui lòng quay lại sau.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>