<?php
// File: admin/modules/cauhoi/ds_cauhoi.php (Giao diện đã được nâng cấp)

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id_baitest = (int)($_GET['id_baitest'] ?? 0);
if ($id_baitest === 0) {
    die("ID bài test không hợp lệ.");
}

// Lấy thông tin bài test
$test_info_stmt = $conn->prepare("SELECT ten_baitest FROM baitest WHERE id_baitest = ?");
$test_info_stmt->bind_param("i", $id_baitest);
$test_info_stmt->execute();
$test_info = $test_info_stmt->get_result()->fetch_assoc();
if (!$test_info) {
    die("Không tìm thấy bài test.");
}
$test_info_stmt->close();

// Lấy danh sách câu hỏi
$questions_stmt = $conn->prepare("SELECT * FROM cauhoi WHERE id_baitest = ? ORDER BY id_cauhoi ASC");
$questions_stmt->bind_param("i", $id_baitest);
$questions_stmt->execute();
$questions = $questions_stmt->get_result();
?>

<style>
    /* --- Keyframes cho hiệu ứng --- */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }

    /* --- Bố cục chính --- */
    .page-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    /* --- Thẻ câu hỏi --- */
    .question-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
        overflow: hidden;
        /* Quan trọng để bo góc hoạt động */
    }

    .question-card-header {
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
    }

    .question-title {
        font-weight: 600;
        color: var(--dark-text);
        margin: 0;
        font-size: 1.0rem;
        text-align: justify;
    }

    /* --- Badge loại câu hỏi --- */
    .question-badge {
        font-size: 0.8rem;
        font-weight: 500;
        padding: 0.3em 0.7em;
        border-radius: 50px;
    }

    .badge-mc {
        /* Trắc nghiệm */
        background-color: #e7f3ff;
        color: #0d6efd;
        text-align: center;
        margin-right: 0.5rem;
    }

    .badge-essay {
        /* Tự luận */
        background-color: #e6f6f4;
        color: #0d9a81;
        margin-right: 0.5rem;

        text-align: center;

    }

    /* --- Danh sách câu trả lời --- */
    .answer-list {
        padding: 1.5rem;
    }

    .answer-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
    }

    .answer-item.correct-answer {
        background-color: var(--brand-color-light);
        border-color: var(--brand-color);
        color: var(--brand-color-dark);
        font-weight: 500;
    }

    .answer-item.correct-answer .correct-indicator {
        font-weight: 600;
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid">
    <div class="page-header animated-item">
        <div class="d-flex align-items-center">
            <a href="./admin.php?nav=question" class="btn btn-light border me-3"><i class="fa-solid fa-arrow-left"></i></a>
            <div>
                <h1 class="title-color mb-0" style="border: none; padding: 0;">Quản lý Câu hỏi</h1>
                <p class="text-muted mb-0">Bài test: <?php echo htmlspecialchars($test_info['ten_baitest']); ?></p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importQuestionsModal">
                <i class="fa-solid fa-file-import"></i> Nhập từ File
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                <i class="fa-solid fa-plus"></i> Thêm câu hỏi
            </button>
        </div>
    </div>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show animated-item" role="alert" style="animation-delay: 100ms;">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        unset($_SESSION['message']);
    }
    ?>

    <?php
    $question_index = 1;
    if ($questions->num_rows > 0):
        mysqli_data_seek($questions, 0); // Reset con trỏ
        while ($question = $questions->fetch_assoc()):
            $id_cauhoi = $question['id_cauhoi'];
            $is_essay_question = ($question['loai_cauhoi'] === 'tu_luan');
    ?>
            <div class="question-card animated-item" id="question-card-<?php echo $id_cauhoi; ?>" style="animation-delay: <?php echo $question_index * 100 + 100; ?>ms;">
                <div class="question-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="question-title">Câu <?php echo $question_index++; ?>: <?php echo htmlspecialchars($question['noi_dung']); ?></h5>
                        <?php if ($is_essay_question): ?>
                            <span class="question-badge badge-essay">Tự luận</span>
                        <?php else: ?>
                            <span class="question-badge badge-mc">Trắc nghiệm</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteQuestion(<?php echo $id_cauhoi; ?>)" title="Xóa câu hỏi">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="answer-list">
                    <?php if ($is_essay_question): ?>
                        <div class="alert alert-light text-center">Đây là câu hỏi tự luận, không có đáp án trắc nghiệm.</div>
                    <?php else: ?>
                        <div id="answer-list-<?php echo $id_cauhoi; ?>">
                            <?php
                            $answers_stmt = $conn->prepare("SELECT * FROM dapan WHERE id_cauhoi = ? ORDER BY id_dapan");
                            $answers_stmt->bind_param("i", $id_cauhoi);
                            $answers_stmt->execute();
                            $answers = $answers_stmt->get_result();
                            while ($answer = $answers->fetch_assoc()):
                            ?>
                                <div id="answer-row-<?php echo $answer['id_dapan']; ?>" class="answer-item <?php echo $answer['la_dung'] ? 'correct-answer' : ''; ?>">
                                    <span class="flex-grow-1"><?php echo htmlspecialchars($answer['noi_dung_dapan']); ?></span>
                                    <?php if ($answer['la_dung']) echo '<span class="correct-indicator"><i class="fa-solid fa-check me-1"></i> Đáp án đúng</span>'; ?>
                                    <button class="btn btn-sm btn-outline-danger ms-2" onclick="deleteAnswer(<?php echo $answer['id_dapan']; ?>)" title="Xóa đáp án">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            <?php endwhile;
                            $answers_stmt->close(); ?>
                        </div>
                        <button class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#addAnswerModal" data-question-id="<?php echo $id_cauhoi; ?>">
                            <i class="fa-solid fa-plus"></i> Thêm đáp án
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        endwhile;
    else:
        ?>
        <div class="alert alert-info text-center animated-item" style="animation-delay: 200ms;">
            <i class="fa-solid fa-folder-open fa-3x mb-3 text-muted"></i>
            <p class="mb-0">Bài test này chưa có câu hỏi nào. Hãy bắt đầu bằng cách thêm câu hỏi mới!</p>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="importQuestionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nhập câu hỏi từ File CSV</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/cauhoi/import_questions.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_baitest_import" value="<?php echo $id_baitest; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tải lên file .csv</label>
                        <input type="file" name="question_file" class="form-control" accept=".csv" required>
                    </div>
                    <div class="alert alert-light">
                        <strong>Lưu ý:</strong> File phải có định dạng CSV UTF-8 và tuân theo đúng cấu trúc cột: <br>
                        `noi_dung_cau_hoi`, `dapan_1`, `dapan_2`, `dapan_3`, `dapan_4`, `dapan_dung (1-4)`
                        <br>
                        <a href="data:text/csv;charset=utf-8,noi_dung_cau_hoi,dapan_1,dapan_2,dapan_3,dapan_4,dapan_dung%20(1-4)%0AWhat%20is%20the%20past%20tense%20of%20%22go%22%3F,went,gone,goes,going,1" download="cau_hoi_mau.csv">Tải file mẫu tại đây</a>.
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Bắt đầu nhập</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm câu hỏi mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addQuestionForm">
                <input type="hidden" name="id_baitest" value="<?php echo $id_baitest; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Loại câu hỏi</label>
                        <select name="loai_cauhoi" class="form-select">
                            <option value="trac_nghiem" selected>Trắc nghiệm</option>
                            <option value="tu_luan">Tự luận (Viết)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung câu hỏi</label>
                        <textarea name="noi_dung_cauhoi" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addAnswerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm đáp án mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addAnswerForm">
                <input type="hidden" name="id_cauhoi" id="modal_id_cauhoi">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nội dung đáp án</label><textarea name="noi_dung_dapan" class="form-control" required></textarea></div>
                    <div class="form-check"><input type="checkbox" name="la_dung" class="form-check-input"><label class="form-check-label">Đây là đáp án đúng</label></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Xử lý khi modal thêm đáp án được mở
        const addAnswerModal = document.getElementById('addAnswerModal');
        if (addAnswerModal) {
            addAnswerModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const questionId = button.getAttribute('data-question-id');
                const modalQuestionIdInput = addAnswerModal.querySelector('#modal_id_cauhoi');
                modalQuestionIdInput.value = questionId;
            });
        }

        // AJAX cho việc xóa câu hỏi
        window.deleteQuestion = function(questionId) {
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Xóa câu hỏi này sẽ xóa tất cả các đáp án liên quan. Hành động này không thể khôi phục!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Chắc chắn xóa!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('modules/cauhoi/delete_question.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id_cauhoi=${questionId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`question-card-${questionId}`).remove();
                                Swal.fire('Đã xóa!', 'Câu hỏi đã được xóa thành công.', 'success');
                            } else {
                                Swal.fire('Lỗi!', data.message, 'error');
                            }
                        });
                }
            });
        }

        // AJAX cho việc xóa đáp án
        window.deleteAnswer = function(answerId) {
            Swal.fire({
                title: 'Xóa đáp án?',
                text: "Bạn có chắc muốn xóa đáp án này không?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('modules/cauhoi/delete_answer.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id_dapan=${answerId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`answer-row-${answerId}`).remove();
                            } else {
                                Swal.fire('Lỗi!', data.message, 'error');
                            }
                        });
                }
            });
        }

        // Cập nhật URL action cho các form
        if (document.getElementById('addQuestionForm')) document.getElementById('addQuestionForm').action = 'modules/cauhoi/add_question.php';
        if (document.getElementById('addAnswerForm')) document.getElementById('addAnswerForm').action = 'modules/cauhoi/add_answer.php';

        // AJAX cho form thêm đáp án và câu hỏi
        function handleFormSubmit(form) {
            const formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                });
        }

        if (document.getElementById('addQuestionForm')) {
            document.getElementById('addQuestionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                handleFormSubmit(this);
            });
        }
        if (document.getElementById('addAnswerForm')) {
            document.getElementById('addAnswerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                handleFormSubmit(this);
            });
        }
    });
</script>