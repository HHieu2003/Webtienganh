<?php
// Bắt đầu session nếu chưa có để xử lý thông báo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// include('../config/config.php'); // Đã được gọi từ file cha

$id_baitest = (int)($_GET['id_baitest'] ?? 0);
if ($id_baitest === 0) {
    die("ID bài test không hợp lệ.");
}

// Lấy thông tin bài test để hiển thị tiêu đề
$test_info_stmt = $conn->prepare("SELECT ten_baitest FROM baitest WHERE id_baitest = ?");
$test_info_stmt->bind_param("i", $id_baitest);
$test_info_stmt->execute();
$test_info = $test_info_stmt->get_result()->fetch_assoc();
if (!$test_info) {
    die("Không tìm thấy bài test.");
}
$test_info_stmt->close();

// Lấy danh sách câu hỏi của bài test
$questions_stmt = $conn->prepare("SELECT * FROM cauhoi WHERE id_baitest = ? ORDER BY id_cauhoi ASC");
$questions_stmt->bind_param("i", $id_baitest);
$questions_stmt->execute();
$questions = $questions_stmt->get_result();
?>

<div class="d-flex align-items-center mb-3">
    <a href="./admin.php?nav=question" class="btn btn-secondary me-3"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
    <h1 class="title-color mb-0" style="border: none; padding-bottom: 0; margin-bottom: 0;">Quản lý câu hỏi: <?php echo htmlspecialchars($test_info['ten_baitest']); ?></h1>
</div>

<?php
// Hiển thị thông báo thành công hoặc thất bại từ session
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show" role="alert">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    unset($_SESSION['message']);
}
?>

<div class="d-flex justify-content-end align-items-center mb-3 gap-2">
    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importQuestionsModal">
        <i class="fa-solid fa-file-import"></i> Nhập từ File
    </button>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        <i class="fa-solid fa-plus"></i> Thêm câu hỏi mới
    </button>
</div>

<?php 
$question_index = 1;
if ($questions->num_rows > 0):
    while ($question = $questions->fetch_assoc()): 
        $id_cauhoi = $question['id_cauhoi'];
?>
<div class="card mb-3 animated-card" id="question-card-<?php echo $id_cauhoi; ?>">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Câu <?php echo $question_index++; ?>: <?php echo htmlspecialchars($question['noi_dung']); ?></strong>
        <div>
            <button class="btn btn-danger btn-sm" onclick="deleteQuestion(<?php echo $id_cauhoi; ?>)" title="Xóa câu hỏi"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-group" id="answer-list-<?php echo $id_cauhoi; ?>">
            <?php
            // Lấy các đáp án cho câu hỏi hiện tại
            $answers_stmt = $conn->prepare("SELECT * FROM dapan WHERE id_cauhoi = ?");
            $answers_stmt->bind_param("i", $id_cauhoi);
            $answers_stmt->execute();
            $answers = $answers_stmt->get_result();
            while($answer = $answers->fetch_assoc()):
            ?>
            <li id="answer-row-<?php echo $answer['id_dapan']; ?>" class="list-group-item d-flex justify-content-between align-items-center <?php echo $answer['la_dung'] ? 'list-group-item-success' : ''; ?>">
                <?php echo htmlspecialchars($answer['noi_dung_dapan']); ?>
                <?php if($answer['la_dung']) echo '<strong>(Đáp án đúng)</strong>'; ?>
                <button class="btn btn-outline-danger btn-sm" onclick="deleteAnswer(<?php echo $answer['id_dapan']; ?>)"><i class="fa-solid fa-times"></i></button>
            </li>
            <?php endwhile; $answers_stmt->close(); ?>
        </ul>
        <button class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#addAnswerModal" data-question-id="<?php echo $id_cauhoi; ?>">
            Thêm đáp án
        </button>
    </div>
</div>
<?php 
    endwhile; 
else:
?>
    <div class="alert alert-info text-center">Bài test này chưa có câu hỏi nào.</div>
<?php endif; ?>

<div class="modal fade" id="importQuestionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Nhập câu hỏi từ File CSV</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
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
            <div class="modal-header"><h5 class="modal-title">Thêm câu hỏi mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addQuestionForm" method="POST" action="modules/cauhoi/add_question.php">
                <input type="hidden" name="id_baitest" value="<?php echo $id_baitest; ?>">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nội dung câu hỏi</label><textarea name="noi_dung_cauhoi" class="form-control" required></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addAnswerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Thêm đáp án mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addAnswerForm" method="POST" action="modules/cauhoi/add_answer.php">
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
    addAnswerModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const questionId = button.getAttribute('data-question-id');
        const modalQuestionIdInput = addAnswerModal.querySelector('#modal_id_cauhoi');
        modalQuestionIdInput.value = questionId;
    });

    // AJAX cho việc xóa câu hỏi
    window.deleteQuestion = function(questionId) {
        if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này và tất cả đáp án của nó?')) {
            fetch('modules/cauhoi/delete_question.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `id_cauhoi=${questionId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`question-card-${questionId}`).remove();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            });
        }
    }

    // AJAX cho việc xóa đáp án
    window.deleteAnswer = function(answerId) {
        if (confirm('Bạn có chắc chắn muốn xóa đáp án này?')) {
            fetch('modules/cauhoi/delete_answer.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `id_dapan=${answerId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`answer-row-${answerId}`).remove();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            });
        }
    }

    // AJAX cho form thêm đáp án và câu hỏi để không cần tải lại trang
    document.getElementById('addQuestionForm').addEventListener('submit', function(e) { e.preventDefault(); handleFormSubmit(this); });
    document.getElementById('addAnswerForm').addEventListener('submit', function(e) { e.preventDefault(); handleFormSubmit(this); });

    function handleFormSubmit(form) {
        const formData = new FormData(form);
        fetch(form.action, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tải lại trang để cập nhật danh sách
                location.reload(); 
            } else {
                alert('Lỗi: ' + data.message);
            }
        });
    }
});
</script>