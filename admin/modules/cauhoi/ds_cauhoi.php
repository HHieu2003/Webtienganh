<?php
include('../config/config.php');
$i = 1;
// Lấy danh sách câu hỏi của bài test
$id_baitest = intval($_GET['id_baitest']); // Lấy ID bài test từ URL
$sql_questions = "SELECT * FROM cauhoi WHERE id_baitest = ?";
$stmt_questions = mysqli_prepare($conn, $sql_questions);
mysqli_stmt_bind_param($stmt_questions, 'i', $id_baitest);
mysqli_stmt_execute($stmt_questions);
$questions = mysqli_stmt_get_result($stmt_questions);
?>

<div class="container my-3">
    <h1 class="text-center title-color">Danh sách Câu Hỏi Trắc Nghiệm</h1>

    <!-- Nút thêm câu hỏi -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        Thêm Câu Hỏi
    </button>

    <!-- Modal thêm câu hỏi -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addQuestionForm" action="./modules/cauhoi/add_question.php?id_baitest = <?php echo $id_baitest; ?> " method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuestionModalLabel">Thêm Câu Hỏi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_baitest" value="<?= $id_baitest ?>">

                        <div class="mb-3">
                            <label for="noi_dung" class="form-label">Nội Dung Câu Hỏi</label>
                            <textarea name="noi_dung_cauhoi" id="noi_dung_cauhoi" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hiển thị danh sách câu hỏi -->

    <?php while ($question = mysqli_fetch_assoc($questions)): ?>
        <div class="card mb-3" id="question-<?= $question['id_cauhoi'] ?>">
            <div class="card-header">
                <strong>Câu <?= $i++;  ?>:</strong> <?= htmlspecialchars($question['noi_dung']) ?>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm float-end delete-question" data-id="<?= $question['id_cauhoi'] ?>">Xóa</a>
            </div>
            <div class="card-body">
                <?php
                // Lấy danh sách đáp án của câu hỏi
                $sql_answers = "SELECT * FROM dapan WHERE id_cauhoi = ?";
                $stmt_answers = mysqli_prepare($conn, $sql_answers);
                mysqli_stmt_bind_param($stmt_answers, 'i', $question['id_cauhoi']);
                mysqli_stmt_execute($stmt_answers);
                $answers = mysqli_stmt_get_result($stmt_answers);
                ?>

                <!-- Hiển thị đáp án -->
                <ul class="list-group" id="answers-<?= $question['id_cauhoi'] ?>">
                    <?php while ($answer = mysqli_fetch_assoc($answers)): ?>
                        <li class="list-group-item <?= $answer['la_dung'] ? 'list-group-item-success' : '' ?>" id="answer-<?= $answer['id_dapan'] ?>">
                            <?= htmlspecialchars($answer['noi_dung_dapan']) ?>
                            <?= $answer['la_dung'] ? '<strong>(Đáp án đúng)</strong>' : '' ?>
                            <div class="float-end">
                                <button class="btn btn-danger btn-sm delete-answer" data-id="<?= $answer['id_dapan'] ?>">Xóa</button>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>



                <!-- Nút thêm đáp án -->
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addAnswerModal-<?= $question['id_cauhoi'] ?>">
                    Thêm Đáp Án
                </button>
            </div>
        </div>
        <!-- Modal thêm đáp án -->
      <!-- Modal thêm đáp án -->
<div class="modal fade" id="addAnswerModal-<?= $question['id_cauhoi'] ?>" tabindex="-1" aria-labelledby="addAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="./modules/cauhoi/add_answer.php" method="POST" class="add-answer-form">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Đáp Án</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_cauhoi" value="<?= $question['id_cauhoi'] ?>">

                    <div class="mb-3">
                        <label for="noi_dung_dapan" class="form-label">Nội Dung Đáp Án</label>
                        <textarea name="noi_dung_dapan" id="noi_dung_dapan" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="la_dung" id="la_dung" class="form-check-input">
                        <label for="la_dung" class="form-check-label">Đây là đáp án đúng</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>

        </div>
    </div>
</div>

    <?php endwhile; ?>
</div>

<!-- Thêm script xử lý AJAX -->

<!-- thêm dáp án  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-answer-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn chặn reload trang

                const formData = new FormData(this);
                const modalId = this.closest('.modal').id;

                fetch(this.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        // Kiểm tra xem phản hồi có OK không
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json(); // Parse JSON từ phản hồi
                    })
                    .then(data => {
                        console.log('Parsed JSON:', data); // Log dữ liệu JSON trả về
                        if (data.success) {
                            // Cập nhật giao diện nếu thêm thành công
                            const answerList = document.querySelector(`#answers-${data.id_cauhoi}`);
                            if (!answerList) {
                                throw new Error(`Element #answers-${data.id_cauhoi} not found in DOM`);
                            }

                            const newAnswer = document.createElement('li');
                            newAnswer.className = `list-group-item ${data.la_dung ? 'list-group-item-success' : ''}`;
                            newAnswer.innerHTML = `
                                ${data.noi_dung_dapan}
                                ${data.la_dung ? '<strong>(Đáp án đúng)</strong>' : ''}
                                <div class="float-end">
                                    <button class="btn btn-danger btn-sm delete-answer" data-id="${data.id_dapan}" onclick="return confirm('Bạn có chắc chắn muốn xóa đáp án này?')">Xóa</button>
                                </div>
                            `;
                            answerList.appendChild(newAnswer);

                            // Đóng modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                            modal.hide();
                        } else {
                            // Hiển thị lỗi từ server
                            alert('Lỗi: ' + data.message);
                        }
                    })
                    .catch(error => {
                        // Log lỗi nếu xảy ra trong Promise
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>


</script>

<!-- xóa đáp án  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-answer').forEach(button => {
            button.addEventListener('click', function() {
                const idDapan = this.getAttribute('data-id'); // Lấy ID đáp án từ nút xóa

                if (confirm('Bạn có chắc chắn muốn xóa đáp án này?')) {
                    fetch(`modules/cauhoi/delete_answer.php`, {
                            method: 'POST', // Sử dụng POST
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id_dapan=${idDapan}` // Gửi ID đáp án
                        })
                        .then(response => response.json()) // Chuyển đổi phản hồi thành JSON
                        .then(data => {
                            if (data.success) {
                                // Nếu thành công, xóa đáp án khỏi giao diện
                                const answerItem = document.getElementById(`answer-${idDapan}`);
                                if (answerItem) {
                                    answerItem.remove();
                                }
                            } else {
                                alert('Lỗi: ' + data.message); // Hiển thị lỗi từ server
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Không thể xóa đáp án.');
                        });
                }
            });
        });
    });
</script>

<!-- thêm câu hỏi  -->
<script>
    document.querySelector('#addQuestionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload lại trang nếu thêm thành công
                } else {
                    alert('Lỗi: ' + data.message); // Hiển thị lỗi
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Không thể thêm câu hỏi.');
            });
    });
</script>


<!-- xóa câu hỏi  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-question').forEach(button => {
            button.addEventListener('click', function() {
                const idCauhoi = this.getAttribute('data-id'); // Lấy ID câu hỏi từ nút xóa

                if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
                    fetch('./modules/cauhoi/delete_question.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id_cauhoi=${idCauhoi}` // Gửi ID câu hỏi
                        })
                        .then(response => response.json()) // Chuyển đổi phản hồi thành JSON
                        .then(data => {
                            if (data.success) {
                                // Nếu thành công, xóa câu hỏi khỏi giao diện
                                //    location.reload();
                                const questionItem = document.getElementById(`question-${idCauhoi}`);
                                if (questionItem) {
                                    questionItem.remove();
                                }
                            } else {
                                alert('Lỗi: ' + data.message); // Hiển thị lỗi từ server
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Không thể xóa câu hỏi.');
                        });
                }
            });
        });
    });
</script>