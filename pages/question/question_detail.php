<?php
include('./config/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baitest = intval($_POST['id_baitest']);
    $answers = $_POST['answers'] ?? []; // Get user answers, default to an empty array
    $score = 0;

    // Validate and calculate the score
    foreach ($answers as $id_cauhoi => $id_dapan) {
        $sql_check_answer = "SELECT la_dung FROM dapan WHERE id_cauhoi = ? AND id_dapan = ?";
        $stmt_check = $conn->prepare($sql_check_answer);
        $stmt_check->bind_param("ii", $id_cauhoi, $id_dapan);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($row = $result_check->fetch_assoc()) {
            if ($row['la_dung']) {
                $score++;
            }
        }
    }

    echo "<script>alert('Bạn đã làm đúng $score câu.'); window.location.href='index.php?nav=question';</script>";
    exit();
}
// Lấy id bài test từ tham số URL
$id_baitest = isset($_GET['id_baitest']) ? intval($_GET['id_baitest']) : 0;

if (!$id_baitest) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='index.php?nav=question';</script>";
    exit();
}

// Truy vấn lấy thông tin bài test
$sql_baitest = "SELECT ten_baitest, COUNT(cauhoi.id_cauhoi) AS tong_cauhoi FROM baitest 
                LEFT JOIN cauhoi ON baitest.id_baitest = cauhoi.id_baitest
                WHERE baitest.id_baitest = ?";
$stmt_baitest = $conn->prepare($sql_baitest);
$stmt_baitest->bind_param("i", $id_baitest);
$stmt_baitest->execute();
$result_baitest = $stmt_baitest->get_result();

if ($baitest = $result_baitest->fetch_assoc()) {
    echo "<div class='container'>";
    echo "<div class='content'>";
    echo "<form method='POST' action='index.php?nav=dapan'>";
    echo "<input type='hidden' name='id_baitest' value='" . htmlspecialchars($id_baitest) . "'>";
    echo "<div class='post-1'>";
    echo "<h1>" . htmlspecialchars($baitest['ten_baitest']) . "</h1>";
    echo "<p class='instruction'>Vui lòng đọc kỹ trước khi làm bài.</p>";
    echo "<div class='quiz'>";
    echo "<p class='question-count'>Tổng số câu hỏi: " . htmlspecialchars($baitest['tong_cauhoi']) . "</p>";

    // Truy vấn lấy câu hỏi của bài test
    $sql_cauhoi = "SELECT id_cauhoi, noi_dung FROM cauhoi WHERE id_baitest = ?";
    $stmt_cauhoi = $conn->prepare($sql_cauhoi);
    $stmt_cauhoi->bind_param("i", $id_baitest);
    $stmt_cauhoi->execute();
    $result_cauhoi = $stmt_cauhoi->get_result();

    $question_number = 1; // Biến đếm câu hỏi
    while ($cauhoi = $result_cauhoi->fetch_assoc()) {
        echo "<div class='question'>";
        echo "<p><strong>Câu $question_number.</strong> " . htmlspecialchars($cauhoi['noi_dung']) . "</p>";
        echo "<div class='answers'>";

        // Truy vấn lấy đáp án của câu hỏi
        $sql_dapan = "SELECT id_dapan, noi_dung_dapan FROM dapan WHERE id_cauhoi = ?";
        $stmt_dapan = $conn->prepare($sql_dapan);
        $stmt_dapan->bind_param("i", $cauhoi['id_cauhoi']);
        $stmt_dapan->execute();
        $result_dapan = $stmt_dapan->get_result();

        while ($dapan = $result_dapan->fetch_assoc()) {
            echo "<label>";
            echo "<input type='radio' name='answers[" . htmlspecialchars($cauhoi['id_cauhoi']) . "]' value='" . htmlspecialchars($dapan['id_dapan']) . "'> ";
            echo htmlspecialchars($dapan['noi_dung_dapan']);
            echo "</label><br>";
        }
        echo "</div>"; // End .answers
        echo "</div>"; // End .question
        $question_number++;
    }

    echo "</div>"; // End .quiz
    echo "<button type='submit' class='submit-btn'>Nộp bài</button>";
    echo "</div>"; // End .post-1
    echo "</form>";
    echo "</div>"; // End .post-1
    echo "</div>"; // End .post-1



} else {
    echo "<p>Bài test không tồn tại.</p>";
}
?>



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
        margin-top: 10px;
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