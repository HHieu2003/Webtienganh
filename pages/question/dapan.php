<?php
// session_start() đã được gọi từ index.php
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
$sql_save = "INSERT INTO ketquabaitest (id_hocvien, id_baitest, diem, ngay_lam_bai) VALUES (?, ?, ?, NOW())";
$stmt_save = $conn->prepare($sql_save);
$stmt_save->bind_param("iid", $id_hocvien, $id_baitest, $score);
$stmt_save->execute();

// **LOGIC MỚI: KIỂM TRA VÀ PHÂN LOẠI TRÌNH ĐỘ**
$stmt_check_placement = $conn->prepare("SELECT is_placement_test FROM baitest WHERE id_baitest = ?");
$stmt_check_placement->bind_param("i", $id_baitest);
$stmt_check_placement->execute();
$is_placement_test = $stmt_check_placement->get_result()->fetch_assoc()['is_placement_test'] ?? 0;

if ($is_placement_test) {
    // Định nghĩa các ngưỡng điểm để phân loại
    $level = 'Chưa xác định';
    if ($score <= 10) {
        $level = 'Cơ bản (A1-A2)';
    } elseif ($score <= 20) {
        $level = 'Trung cấp (B1)';
    } elseif ($score <= 30) {
        $level = 'Trên Trung cấp (B2)';
    } else {
        $level = 'Nâng cao (C1-C2)';
    }

    // Cập nhật trình độ cho học viên
    $stmt_update_level = $conn->prepare("UPDATE hocvien SET trinh_do = ? WHERE id_hocvien = ?");
    $stmt_update_level->bind_param("si", $level, $id_hocvien);
    $stmt_update_level->execute();

    // Chuyển hướng về trang cá nhân với thông báo đặc biệt
    echo "<script>
        alert('Chúc mừng bạn đã hoàn thành bài kiểm tra! Trình độ của bạn là: " . $level . ". Hệ thống sẽ gợi ý các khóa học phù hợp trong trang cá nhân.');
        window.location.href = 'user/dashboard.php';
    </script>";
    exit();
}

// Nếu không phải bài test đầu vào, hiển thị đáp án như cũ
// ... (Toàn bộ phần code HTML hiển thị đáp án chi tiết của bạn giữ nguyên) ...
?>