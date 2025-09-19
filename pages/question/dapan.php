<?php
// File: pages/question/dapan.php
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Lỗi: Yêu cầu không hợp lệ!'); window.location.href='index.php?nav=question';</script>";
    exit();
}

$id_baitest = (int)$_POST['id_baitest'];
$answers = $_POST['answers'] ?? [];
$id_hocvien = $_SESSION['id_hocvien'] ?? null;

if (!$id_hocvien) {
    echo "<script>alert('Lỗi: Phiên đăng nhập không hợp lệ!'); window.location.href='pages/login.php';</script>";
    exit();
}

// Lấy đáp án đúng của bài test
$sql_correct = "SELECT c.id_cauhoi, d.id_dapan FROM cauhoi c JOIN dapan d ON c.id_cauhoi = d.id_cauhoi WHERE c.id_baitest = ? AND d.la_dung = 1";
$stmt_correct = $conn->prepare($sql_correct);
$stmt_correct->bind_param("i", $id_baitest);
$stmt_correct->execute();
$result_correct = $stmt_correct->get_result();
$correct_answers = [];
while ($row = $result_correct->fetch_assoc()) {
    $correct_answers[$row['id_cauhoi']] = $row['id_dapan'];
}

// Chấm điểm
$score = 0;
foreach ($answers as $question_id => $answer_id) {
    if (isset($correct_answers[$question_id]) && $correct_answers[$question_id] == $answer_id) {
        $score++;
    }
}

// Lưu kết quả vào bảng ketquabaitest
$sql_save = "INSERT INTO ketquabaitest (id_hocvien, id_baitest, diem, ngay_lam_bai) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE diem = VALUES(diem), ngay_lam_bai = NOW()";
$stmt_save = $conn->prepare($sql_save);
$stmt_save->bind_param("iid", $id_hocvien, $id_baitest, $score);
$stmt_save->execute();
$stmt_save->close();

// **LOGIC MỚI: KIỂM TRA LOẠI BÀI TEST**
$stmt_check_type = $conn->prepare("SELECT loai_baitest FROM baitest WHERE id_baitest = ?");
$stmt_check_type->bind_param("i", $id_baitest);
$stmt_check_type->execute();
$test_type = $stmt_check_type->get_result()->fetch_assoc()['loai_baitest'] ?? null;
$stmt_check_type->close();

if ($test_type === 'dau_vao') {
    $level = 'Cơ bản (A1-A2)'; // Mặc định
    if ($score >= 35) {
        $level = 'Nâng cao (C1-C2)';
    } elseif ($score >= 25) {
        $level = 'Trên Trung cấp (B2)';
    } elseif ($score >= 15) {
        $level = 'Trung cấp (B1)';
    }
    
    $stmt_update_level = $conn->prepare("UPDATE hocvien SET trinh_do = ? WHERE id_hocvien = ?");
    $stmt_update_level->bind_param("si", $level, $id_hocvien);
    $stmt_update_level->execute();
    $stmt_update_level->close();

    echo "<script>
        alert('Chúc mừng bạn đã hoàn thành bài kiểm tra! Trình độ của bạn được xác định là: " . $level . ".\\nHệ thống sẽ gợi ý các khóa học phù hợp trong trang cá nhân.');
        window.location.href = 'user/dashboard.php';
    </script>";
    exit();
} else {
    // Chuyển hướng về trang kết quả trong dashboard cho các loại test khác
     echo "<script>
        alert('Bạn đã hoàn thành bài kiểm tra với số điểm: " . $score . "/" . count($correct_answers) . ".\\nXem chi tiết kết quả trong trang cá nhân của bạn.');
        window.location.href = 'user/dashboard.php?nav=ketquakiemtra';
    </script>";
    exit();
}
?>