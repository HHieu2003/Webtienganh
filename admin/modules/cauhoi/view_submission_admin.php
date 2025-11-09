<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Bảo mật: Chỉ admin hoặc giảng viên mới được truy cập
if (!isset($_SESSION['is_admin']) && !isset($_SESSION['is_teacher'])) {
    die("Bạn không có quyền truy cập trang này.");
}

// Lấy ID kết quả từ URL
$id_ketqua = isset($_GET['id_ketqua']) ? (int)$_GET['id_ketqua'] : 0;
if (!$id_ketqua) {
    echo "<div class='alert alert-danger'>ID kết quả không hợp lệ.</div>";
    return;
}

// Lấy thông tin cơ bản của bài làm
$sql_result_info = "
    SELECT 
        bt.ten_baitest, 
        kq.id_baitest, 
        hv.ten_hocvien, 
        kq.diem, 
        kq.ngay_lam_bai,
        (SELECT COUNT(*) FROM cauhoi WHERE id_baitest = bt.id_baitest AND loai_cauhoi = 'trac_nghiem') as total_mc,
        (SELECT COUNT(*) FROM cauhoi WHERE id_baitest = bt.id_baitest AND loai_cauhoi = 'tu_luan') as total_essay
    FROM ketquabaitest kq
    JOIN baitest bt ON kq.id_baitest = bt.id_baitest
    JOIN hocvien hv ON kq.id_hocvien = hv.id_hocvien
    WHERE kq.id_ketqua = ?
";
$stmt_info = $conn->prepare($sql_result_info);
$stmt_info->bind_param("i", $id_ketqua);
$stmt_info->execute();
$result_info = $stmt_info->get_result()->fetch_assoc();
$stmt_info->close();

if (!$result_info) {
    echo "<div class='alert alert-danger'>Không tìm thấy kết quả bài làm.</div>";
    return;
}

$id_baitest = $result_info['id_baitest'];

// Lấy câu trả lời của học viên
$sql_student_answers = "SELECT * FROM dapan_hocvien WHERE id_ketqua = ?";
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
    if ($row['id_dapan']) {
        $questions_data[$row['id_cauhoi']]['answers'][] = $row;
    }
}
$stmt_q->close();
?>

<style>
    .review-summary-card {
        background-color: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
    }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .summary-header h2 {
        font-weight: 600;
        font-size: 1.5rem;
        margin: 0;
    }

    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        text-align: center;
    }

    .stat-item h6 {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .stat-item p {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--brand-color-dark);
        margin: 0;
    }

    .accordion-item {
        border: 1px solid var(--border-color);
        border-radius: 8px !important;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .accordion-button {
        font-weight: 600;
        padding: 15px 20px;
        text-align: justify;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--brand-color-light);
        color: var(--brand-color-dark);
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-button::after {
        flex-shrink: 0;
        width: 1.25rem;
        height: 1.25rem;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230a8a2c'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .answer-review-item {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .answer-review-item .icon {
        font-size: 18px;
    }

    .answer-correct {
        background-color: #d1e7dd;
        border-color: #a3cfbb;
        color: #0f5132;
    }

    .answer-incorrect {
        background-color: #f8d7da;
        border-color: #f1aeb5;
        color: #721c24;
    }

    .answer-chosen-correct {
        border: 2px solid #198754;
    }

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
        color: #333;
    }

    .ai-feedback-box {
        margin-top: 15px;
        border-top: 2px dashed var(--brand-color);
        padding-top: 15px;
    }

    .ai-feedback-box h6 {
        font-weight: 600;
        color: var(--brand-color-dark);
    }
</style>

<div class="container-fluid">
    <a href="?nav=kqhocvien&id_baitest=<?php echo $id_baitest; ?>" class="btn btn-light border mb-4"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách kết quả</a>

    <div class="review-summary-card animated-card">
        <div class="summary-header">
            <div>
                <h2><?php echo htmlspecialchars($result_info['ten_baitest']); ?></h2>
                <p class="text-muted">Bài làm của học viên: <strong><?php echo htmlspecialchars($result_info['ten_hocvien']); ?></strong></p>
            </div>
            <a href="?nav=kqhocvien_gv&id_baitest=<?php echo $id_baitest; ?>" class="btn btn-outline-primary btn-sm align-self-start">Xem các kết quả khác</a>
        </div>
        <div class="summary-stats">
            <div class="stat-item">
                <h6>ĐIỂM TRẮC NGHIỆM</h6>
                <p><?php echo (int)$result_info['diem'] . " / " . $result_info['total_mc']; ?></p>
            </div>
            <div class="stat-item">
                <h6>SỐ CÂU TỰ LUẬN</h6>
                <p><?php echo $result_info['total_essay']; ?></p>
            </div>
            <div class="stat-item">
                <h6>NGÀY LÀM BÀI</h6>
                <p style="font-size: 1.2rem;"><?php echo date("d/m/Y", strtotime($result_info['ngay_lam_bai'])); ?></p>
            </div>
        </div>
    </div>

    <div class="accordion" id="questionsAccordion">
        <?php
        $question_number = 1;
        foreach ($questions_data as $id_cauhoi => $data): ?>
            <div class="accordion-item animated-card" style="animation-delay: <?php echo $question_number * 50; ?>ms;">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-q<?php echo $id_cauhoi; ?>">
                        Câu <?php echo $question_number++; ?>: <?php echo htmlspecialchars($data['noi_dung']); ?>
                    </button>
                </h2>
                <div id="collapse-q<?php echo $id_cauhoi; ?>" class="accordion-collapse collapse show" data-bs-parent="#questionsAccordion">
                    <div class="accordion-body">
                        <?php if ($data['loai_cauhoi'] === 'trac_nghiem'): ?>
                            <div>
                                <?php foreach ($data['answers'] as $answer):
                                    $student_choice_id = $student_answers[$id_cauhoi]['id_dapan_chon'] ?? null;
                                    $is_correct_answer = $answer['la_dung'] == 1;
                                    $is_student_choice = $student_choice_id == $answer['id_dapan'];

                                    $class = '';
                                    $icon = '<i class="fa-regular fa-circle icon text-muted"></i>';

                                    if ($is_correct_answer) {
                                        $class = 'answer-correct';
                                        $icon = '<i class="fa-solid fa-check-circle icon"></i>';
                                    }
                                    if ($is_student_choice && !$is_correct_answer) {
                                        $class = 'answer-incorrect';
                                        $icon = '<i class="fa-solid fa-times-circle icon"></i>';
                                    }
                                    if ($is_student_choice && $is_correct_answer) {
                                        $class .= ' answer-chosen-correct';
                                    }
                                ?>
                                    <div class="answer-review-item <?php echo $class; ?>">
                                        <?php echo $icon; ?>
                                        <span><?php echo htmlspecialchars($answer['noi_dung_dapan']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: // Đây là câu hỏi tự luận 
                        ?>
                            <div class="essay-submission-box">
                                <h6><i class="fa-solid fa-pen-nib me-2"></i>Bài làm của học viên:</h6>
                                <div class="essay-content"><?php echo htmlspecialchars($student_answers[$id_cauhoi]['tra_loi_tu_luan'] ?? 'Học viên chưa trả lời câu hỏi này.'); ?></div>
                            </div>

                            <?php if (isset($student_answers[$id_cauhoi]) && $student_answers[$id_cauhoi]['trang_thai_cham'] === 'da_cham'): ?>
                                <div class="ai-feedback-box">
                                    <h6><i class="fa-solid fa-robot me-2"></i>Đánh giá từ AI:</h6>
                                    <p><strong>Điểm số:</strong> <span class="badge bg-success fs-6"><?php echo htmlspecialchars($student_answers[$id_cauhoi]['diem_tu_luan']); ?> / 10</span></p>
                                    <p class="mb-1"><strong>Nhận xét chi tiết:</strong></p>
                                    <div class="p-2 bg-white rounded border"><?php echo nl2br(htmlspecialchars($student_answers[$id_cauhoi]['nhan_xet_tu_luan'])); ?></div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning mt-3 text-center">
                                    Bài làm này chưa được chấm điểm.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>