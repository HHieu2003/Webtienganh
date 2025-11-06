<?php
// File: pages/question/question_detail.php
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php');

$hocvien_id = $_SESSION['id_hocvien'] ?? null;
if (!$hocvien_id) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='pages/login.php';</script>";
    exit();
}

$id_baitest = isset($_GET['id_baitest']) ? intval($_GET['id_baitest']) : 0;
if (!$id_baitest) {
    echo "<script>alert('ID bài test không hợp lệ!'); window.location.href='index.php?nav=question';</script>";
    exit();
}

// Truy vấn lấy thông tin bài test
$sql_baitest = "SELECT ten_baitest, thoi_gian FROM baitest WHERE baitest.id_baitest = ?";
$stmt_baitest = $conn->prepare($sql_baitest);
$stmt_baitest->bind_param("i", $id_baitest);
$stmt_baitest->execute();
$result_baitest = $stmt_baitest->get_result();
$baitest = $result_baitest->fetch_assoc();

if (!$baitest) {
    echo "<p>Bài test không tồn tại.</p>";
    exit();
}

// --- LOGIC MỚI: Lấy câu hỏi và đáp án riêng biệt ---

// 1. Lấy tất cả câu hỏi (bao gồm cả loại câu hỏi)
$sql_questions = "SELECT id_cauhoi, noi_dung, loai_cauhoi FROM cauhoi WHERE id_baitest = ? ORDER BY id_cauhoi";
$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("i", $id_baitest);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();

$questions_data = [];
$mc_question_ids = []; // Mảng chứa ID các câu hỏi trắc nghiệm
while ($row = $result_questions->fetch_assoc()) {
    $row['answers'] = []; // Khởi tạo mảng đáp án rỗng
    $questions_data[$row['id_cauhoi']] = $row;
    if ($row['loai_cauhoi'] === 'trac_nghiem') {
        $mc_question_ids[] = $row['id_cauhoi'];
    }
}
$stmt_questions->close();

// 2. Nếu có câu hỏi trắc nghiệm, lấy tất cả đáp án của chúng trong 1 truy vấn
if (!empty($mc_question_ids)) {
    $placeholders = implode(',', array_fill(0, count($mc_question_ids), '?'));
    $sql_answers = "SELECT id_dapan, id_cauhoi, noi_dung_dapan FROM dapan WHERE id_cauhoi IN ($placeholders) ORDER BY id_dapan";
    $stmt_answers = $conn->prepare($sql_answers);
    $stmt_answers->bind_param(str_repeat('i', count($mc_question_ids)), ...$mc_question_ids);
    $stmt_answers->execute();
    $result_answers = $stmt_answers->get_result();

    while ($answer_row = $result_answers->fetch_assoc()) {
        $questions_data[$answer_row['id_cauhoi']]['answers'][] = $answer_row;
    }
    $stmt_answers->close();
}
// --- KẾT THÚC LOGIC MỚI ---
?>

<style>
    .quiz-timer-bar {
        position: sticky;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #2c3e50;
        color: white;
        padding: 15px 20px;
        text-align: center;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        font-size: 20px;
        font-weight: bold;
    }

    .quiz-timer-bar i {
        margin-right: 10px;
    }

    .quiz-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .quiz-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #333;
    }

    .quiz-header .instruction {
        color: #777;
        font-size: 15px;
        margin-bottom: 20px;
    }

    .question-block {
        margin-bottom: 30px;
        text-align: left;
    }

    .question-block p {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .answers-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .answers-list label {
        display: block;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 12px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .answers-list label:hover {
        background-color: #e9ecef;
    }

    .answers-list input[type="radio"] {
        margin-right: 10px;
    }

    /* CSS mới cho câu hỏi tự luận */
    .essay-answer-area {
        width: 100%;
        min-height: 200px;
        padding: 15px;
        font-size: 16px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        resize: vertical;
    }

    .essay-answer-area:focus {
        outline: none;
        border-color: #0db33b;
        box-shadow: 0 0 0 0.25rem rgba(13, 179, 59, 0.25);
    }

    .submit-btn {
        display: block;
        width: 100%;
        padding: 12px 20px;
        background-color: #28a745;
        color: white;
        font-size: 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #218838;
    }
</style>

<div class="quiz-timer-bar" id="timer-bar">
    <i class="fa-solid fa-clock"></i>Thời gian còn lại: <span id="time-display"><?php echo htmlspecialchars($baitest['thoi_gian']); ?>:00</span>
</div>

<div class="quiz-container">
    <div class="quiz-header">
        <h1><?php echo htmlspecialchars($baitest['ten_baitest']); ?></h1>
        <p class="instruction">Vui lòng đọc kỹ câu hỏi và chọn/viết câu trả lời. Bài thi sẽ tự động nộp khi hết giờ.</p>
    </div>
    <hr>
    <form id="quizForm" method="POST" action="index.php?nav=dapan">
        <input type="hidden" name="id_baitest" value="<?php echo htmlspecialchars($id_baitest); ?>">
        <?php
        $question_number = 1;
        foreach ($questions_data as $id_cauhoi => $data):
        ?>
            <div class="question-block">
                <p><strong>Câu <?php echo $question_number++; ?>.</strong> <?php echo htmlspecialchars($data['noi_dung']); ?></p>

                <?php if ($data['loai_cauhoi'] === 'trac_nghiem'): ?>
                    <div class="answers-list">
                        <?php foreach ($data['answers'] as $answer): ?>
                            <label>
                                <input type="radio" name="answers[<?php echo htmlspecialchars($id_cauhoi); ?>][id_dapan_chon]" value="<?php echo htmlspecialchars($answer['id_dapan']); ?>" required>
                                <?php echo htmlspecialchars($answer['noi_dung_dapan']); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else: // Đây là câu hỏi tự luận 
                ?>
                    <textarea
                        name="answers[<?php echo htmlspecialchars($id_cauhoi); ?>][tra_loi_tu_luan]"
                        class="essay-answer-area"
                        placeholder="Nhập bài làm của bạn vào đây..."
                        required></textarea>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
        <button type="submit" class="submit-btn">Nộp bài</button>
    </form>
</div>

<script>
    // --- Phần JavaScript giữ nguyên, không cần thay đổi ---
    document.addEventListener("DOMContentLoaded", function() {
        const timeDisplay = document.getElementById('time-display');
        const quizForm = document.getElementById('quizForm');
        const timeInMinutes = <?php echo (int)$baitest['thoi_gian']; ?>;

        const timerKey = `quizTimer_user<?php echo $hocvien_id; ?>_test<?php echo $id_baitest; ?>`;
        const answersKey = `quizAnswers_user<?php echo $hocvien_id; ?>_test<?php echo $id_baitest; ?>`;

        let timerInterval;
        let hasSubmitted = false;

        function saveAnswers() {
            const formData = new FormData(quizForm);
            const answers = {};
            for (let [key, value] of formData.entries()) {
                // Cập nhật logic lưu để hoạt động với cả radio và textarea
                if (key.startsWith('answers[')) {
                    const match = key.match(/answers\[(\d+)\]\[(\w+)\]/);
                    if (match) {
                        const qId = match[1];
                        const field = match[2];
                        if (!answers[qId]) answers[qId] = {};
                        answers[qId][field] = value;
                    }
                }
            }
            sessionStorage.setItem(answersKey, JSON.stringify(answers));
        }

        function loadAnswers() {
            const savedAnswers = JSON.parse(sessionStorage.getItem(answersKey));
            if (savedAnswers) {
                for (const qId in savedAnswers) {
                    for (const field in savedAnswers[qId]) {
                        const value = savedAnswers[qId][field];
                        const input = quizForm.querySelector(`[name="answers[${qId}][${field}]"][value="${value}"]`) || quizForm.querySelector(`[name="answers[${qId}][${field}]"]`);
                        if (input) {
                            if (input.type === 'radio') {
                                input.checked = true;
                            } else {
                                input.value = value;
                            }
                        }
                    }
                }
            }
        }

        quizForm.addEventListener('input', saveAnswers);
        loadAnswers();

        let endTime = sessionStorage.getItem(timerKey);
        if (!endTime) {
            endTime = new Date().getTime() + timeInMinutes * 60 * 1000;
            sessionStorage.setItem(timerKey, endTime);
        }

        function clearStorage() {
            sessionStorage.removeItem(timerKey);
            sessionStorage.removeItem(answersKey);
        }

        function submitForm(isAuto = false) {
            if (hasSubmitted) return;
            hasSubmitted = true;
            window.onbeforeunload = null;
            clearStorage();

            if (isAuto) {
                alert("Đã hết thời gian làm bài! Bài của bạn sẽ được tự động nộp.");
            }
            quizForm.submit();
        }

        function updateTimer() {
            const remainingTime = endTime - new Date().getTime();
            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                timeDisplay.textContent = "00:00";
                submitForm(true);
                return;
            }
            const minutes = Math.floor((remainingTime / 1000) / 60);
            const seconds = Math.floor((remainingTime / 1000) % 60);
            timeDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        timerInterval = setInterval(updateTimer, 1000);
        updateTimer();

        window.onbeforeunload = function(event) {
            if (!hasSubmitted) {
                event.preventDefault();
                return event.returnValue = 'Bạn có chắc chắn muốn rời khỏi trang? Bài làm chưa nộp sẽ bị mất.';
            }
        };

        quizForm.addEventListener('submit', function() {
            hasSubmitted = true;
            window.onbeforeunload = null;
            clearStorage();
        });

        window.addEventListener('unload', function(event) {
            if (!hasSubmitted) {
                const formData = new FormData(quizForm);
                navigator.sendBeacon('index.php?nav=dapan', formData);
                clearStorage();
            }
        });
    });
</script>