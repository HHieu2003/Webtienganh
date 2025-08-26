<?php
include('./config/config.php');

// Check for submitted data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Bạn chưa nộp bài!'); window.location.href='index.php?nav=question';</script>";
    exit();
}
// Check for submitted data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Bạn chưa nộp bài!'); window.location.href='index.php?nav=question';</script>";
    exit();
}

$id_baitest = intval($_POST['id_baitest']);
$answers = $_POST['answers'] ?? [];

// Fetch questions and correct answers
$sql_cauhoi = "SELECT cauhoi.id_cauhoi, cauhoi.noi_dung, dapan.id_dapan AS correct_id, dapan.noi_dung_dapan AS correct_answer
               FROM cauhoi
               JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi AND dapan.la_dung = 1
               WHERE cauhoi.id_baitest = ?";
$stmt_cauhoi = $conn->prepare($sql_cauhoi);
$stmt_cauhoi->bind_param("i", $id_baitest);
$stmt_cauhoi->execute();
$result_cauhoi = $stmt_cauhoi->get_result();

$questions = [];
while ($row = $result_cauhoi->fetch_assoc()) {
    $questions[$row['id_cauhoi']] = $row;
}

// ID học viên giả định (lấy từ session trong thực tế)
$id_hocvien = $_SESSION['id_hocvien'] ?? 1;

// Tính điểm
$score = 0;
$total_questions = count($questions);

foreach ($questions as $id_cauhoi => $question) {
    $user_answer_id = $answers[$id_cauhoi] ?? null;
    if ($user_answer_id && $user_answer_id == $question['correct_id']) {
        $score++;
    }
}

// Lưu kết quả vào bảng `ketquabaitest`
$sql_save_result = "INSERT INTO ketquabaitest (id_hocvien, id_baitest, diem, ngay_lam_bai)
                    VALUES (?, ?, ?, NOW())";
$stmt_save_result = $conn->prepare($sql_save_result);
$stmt_save_result->bind_param("iii", $id_hocvien, $id_baitest, $score);

if ($stmt_save_result->execute()) {
    echo "<script>alert('Bạn đã làm đúng $score/$total_questions câu. Kết quả đã được lưu!');</script>";
} else {
    echo "<script>alert('Đã xảy ra lỗi khi lưu kết quả: " . $conn->error . "'); window.location.href='index.php?nav=question';</script>";
}

echo "<div class='container'>";
echo "<div class='content'>";
// Display the result
echo "<div class='post-1'>";
echo "<h1>Kết quả bài kiểm tra</h1>";
echo "<div class='quiz'>";

$question_number = 1;

foreach ($questions as $id_cauhoi => $question) {
    echo "<div class='question'>";
    echo "<p><strong>Câu $question_number.</strong> " . htmlspecialchars($question['noi_dung']) . "</p>";
    echo "<p class='correct-answer'>Đáp án đúng: " . htmlspecialchars($question['correct_answer']) . "</p>";

    $user_answer_id = $answers[$id_cauhoi] ?? null;
    if ($user_answer_id) {
        // Fetch user's answer content
        $sql_user_answer = "SELECT noi_dung_dapan FROM dapan WHERE id_dapan = ?";
        $stmt_user_answer = $conn->prepare($sql_user_answer);
        $stmt_user_answer->bind_param("i", $user_answer_id);
        $stmt_user_answer->execute();
        $result_user_answer = $stmt_user_answer->get_result();

        if ($user_answer = $result_user_answer->fetch_assoc()) {
            echo "<p class='user-answer'>Bạn đã chọn: " . htmlspecialchars($user_answer['noi_dung_dapan']) . "</p>";
        }

        if ($user_answer_id == $question['correct_id']) {
         
            echo "<p class='result correct'>Kết quả: Đúng</p>";
        } else {
            echo "<p class='result incorrect'>Kết quả: Sai</p>";
        }
    } else {
        echo "<p class='result missing'>Kết quả: Không trả lời</p>";
    }
    echo "</div>"; // End .question
    $question_number++;
}

echo "<p class='final-score'>Bạn đã làm đúng: $score câu</p>";
echo "</div>"; // End .quiz
echo "</div>"; // End .post-1
echo "</div>"; // End .post-1
echo "</div>"; // End .post-1

?>
<style>
    .correct {
        color: green;
    }

    .incorrect {
        color: red;
    }

    .missing {
        color: orange;
    }

    .final-score {
        font-size: 20px;
        font-weight: bold;
        color: blue;
        text-align: center;
    }
</style>
<style>
    .container {
        display: flex;
        flex-direction: row;
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        text-align: center;
    }

    .content {
        flex: 3;
        padding-right: 20px;
    }

    .post-1 {
        border: 1px solid #ddd;
        padding: 25px;
        margin-bottom: 20px;
        border-radius: 5px;
        background-color: #fdfdfd;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .post-1 p {
        font-size: 20px;
    }

    .breadcrumb {
        margin-bottom: 15px;
        font-size: 14px;
        color: #555;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    h1 {
        font-size: 25px;
        margin-bottom: 10px;
        color: #333;
        font-weight: bold;
    }

    .instruction {
        color: #777;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .quiz .question-count {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }

    .question {
        margin-bottom: 20px;
        text-align: left;
        margin-left: 40px;
        margin-top: 50px;
    }

    .answers {
        margin-top: 10px;
    }

    label {
        font-size: 18px;
        color: #000;
    }

    .submit-btn {
        display: block;
        width: 100%;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        width: 150px;
        margin-left: 300px;
    }

    .submit-btn:hover {
        background-color: #e76060;
    }

    .post p {
        margin-bottom: 15px;
        gap: 20px;
    }
</style>