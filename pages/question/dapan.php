<?php
// File: pages/question/dapan.php
set_time_limit(120); // QUAN TRỌNG: Tăng thời gian thực thi script lên 120 giây
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php');

// --- HÀM GỌI API CHẤM ĐIỂM CỦA AI ---
function gradeEssayWithAI($question, $answer) {
    $api_key = "AIzaSyBu3OOT0rNIc-1DDdFYW8EJh-s9sNzm_lc"; // API Key của bạn
$api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$api_key}";


    $prompt = "
        You are an expert English teacher evaluating a student's essay.
        The grading scale is from 0 to 10.
        
        Analyze the following essay based on these criteria:
        1.  **Task Achievement (25%)**: Did the student fully answer the question?
        2.  **Coherence and Cohesion (25%)**: Is the essay well-structured with logical flow and linking words?
        3.  **Lexical Resource (25%)**: Did the student use a good range of vocabulary appropriately?
        4.  **Grammatical Range and Accuracy (25%)**: How accurate and varied are the grammatical structures?

        Question: '{$question}'
        Student's Essay: '{$answer}'

        Your response MUST be a JSON object with the following structure, and nothing else:
        {
          \"score\": <a numerical score between 0.0 and 10.0>,
          \"feedback\": \"<Provide detailed, constructive feedback in Vietnamese here. Start with an overall comment, then give specific points for improvement based on the criteria above. Keep it encouraging and helpful.>\"
        }
    ";

    $request_body = json_encode(['contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Đặt thời gian chờ cho cURL là 90 giây

    $api_response_raw = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200 || !$api_response_raw) {
        return ['score' => null, 'feedback' => 'Lỗi: Không thể kết nối đến dịch vụ chấm điểm AI. Vui lòng liên hệ quản trị viên.'];
    }

    $api_response = json_decode($api_response_raw, true);
    $ai_text_content = $api_response['candidates'][0]['content']['parts'][0]['text'] ?? '';
    
    $json_part = trim($ai_text_content);
    if (strpos($json_part, '```json') === 0) {
        $json_part = str_replace('```json', '', $json_part);
        $json_part = str_replace('```', '', $json_part);
    }
    
    $ai_result = json_decode(trim($json_part), true);

    if (json_last_error() !== JSON_ERROR_NONE || !isset($ai_result['score']) || !isset($ai_result['feedback'])) {
        return ['score' => null, 'feedback' => 'Lỗi: Phản hồi từ AI không đúng định dạng. Vui lòng liên hệ quản trị viên.'];
    }

    return [
        'score' => (float)$ai_result['score'],
        'feedback' => trim($ai_result['feedback'])
    ];
}

// --- LOGIC XỬ LÝ NỘP BÀI ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Lỗi: Yêu cầu không hợp lệ!'); window.location.href='index.php?nav=question';</script>";
    exit();
}

// ... (phần còn lại của file giữ nguyên như hướng dẫn trước)
$id_baitest = (int)$_POST['id_baitest'];
$answers = $_POST['answers'] ?? [];
$id_hocvien = $_SESSION['id_hocvien'] ?? null;

if (!$id_hocvien) {
    echo "<script>alert('Lỗi: Phiên đăng nhập không hợp lệ!'); window.location.href='pages/login.php';</script>";
    exit();
}

$conn->begin_transaction();

try {
    // Lấy tất cả câu hỏi và đáp án đúng của bài test
    $sql_questions_info = "
        SELECT c.id_cauhoi, c.noi_dung, c.loai_cauhoi, d.id_dapan 
        FROM cauhoi c 
        LEFT JOIN dapan d ON c.id_cauhoi = d.id_cauhoi AND d.la_dung = 1 
        WHERE c.id_baitest = ?
    ";
    $stmt_info = $conn->prepare($sql_questions_info);
    $stmt_info->bind_param("i", $id_baitest);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    
    $questions_master_data = [];
    $total_mc_questions = 0;
    while ($row = $result_info->fetch_assoc()) {
        $questions_master_data[$row['id_cauhoi']] = $row;
        if ($row['loai_cauhoi'] === 'trac_nghiem') {
            $total_mc_questions++;
        }
    }
    $stmt_info->close();

    // Chấm điểm cho phần trắc nghiệm
    $score = 0;
    foreach ($answers as $question_id => $answer_data) {
        if (isset($answer_data['id_dapan_chon'])) {
            $chosen_answer_id = $answer_data['id_dapan_chon'];
            if (isset($questions_master_data[$question_id]) && $questions_master_data[$question_id]['id_dapan'] == $chosen_answer_id) {
                $score++;
            }
        }
    }

    // Lưu kết quả tổng (chỉ tính điểm trắc nghiệm) vào bảng ketquabaitest
    $sql_save = "INSERT INTO ketquabaitest (id_hocvien, id_baitest, diem, ngay_lam_bai) VALUES (?, ?, ?, NOW())";
    $stmt_save = $conn->prepare($sql_save);
    $stmt_save->bind_param("iid", $id_hocvien, $id_baitest, $score);
    $stmt_save->execute();
    $id_ketqua = $stmt_save->insert_id;
    $stmt_save->close();

    // Chuẩn bị câu lệnh để lưu chi tiết từng câu trả lời
    $sql_save_details = "INSERT INTO dapan_hocvien (id_ketqua, id_cauhoi, id_dapan_chon, tra_loi_tu_luan, diem_tu_luan, nhan_xet_tu_luan, trang_thai_cham) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_details = $conn->prepare($sql_save_details);

    foreach ($answers as $question_id => $answer_data) {
        $id_dapan_chon = null;
        $tra_loi_tu_luan = null;
        $diem_tu_luan = null;
        $nhan_xet_tu_luan = null;
        $trang_thai_cham = 'da_cham'; // Mặc định là đã chấm (cho câu trắc nghiệm)

        if (!isset($questions_master_data[$question_id])) continue;
        
        $question_info = $questions_master_data[$question_id];

        if ($question_info['loai_cauhoi'] === 'trac_nghiem') {
            $id_dapan_chon = isset($answer_data['id_dapan_chon']) ? (int)$answer_data['id_dapan_chon'] : null;
        } else {
            $tra_loi_tu_luan = $answer_data['tra_loi_tu_luan'] ?? '';
            $grading_result = gradeEssayWithAI($question_info['noi_dung'], $tra_loi_tu_luan);
            $diem_tu_luan = $grading_result['score'];
            $nhan_xet_tu_luan = $grading_result['feedback'];
            if ($diem_tu_luan === null) {
                $trang_thai_cham = 'cho_cham'; 
            }
        }
        
        $stmt_details->bind_param("iiisdss", $id_ketqua, $question_id, $id_dapan_chon, $tra_loi_tu_luan, $diem_tu_luan, $nhan_xet_tu_luan, $trang_thai_cham);
        $stmt_details->execute();
    }
    $stmt_details->close();

    $conn->commit();

    echo "<script>
        alert('Bạn đã hoàn thành bài kiểm tra!\\nĐiểm phần trắc nghiệm: " . $score . "/" . $total_mc_questions . ".\\nPhần tự luận (nếu có) đã được chấm tự động. Vui lòng xem chi tiết trong trang cá nhân.');
        window.location.href = 'user/dashboard.php?nav=ketquakiemtra';
    </script>";
    exit();

} catch (Exception $e) {
    $conn->rollback();
    error_log("Lỗi khi nộp bài: " . $e->getMessage());
    echo "<script>alert('Đã có lỗi xảy ra trong quá trình nộp bài. Vui lòng thử lại.'); window.history.back();</script>";
    exit();
}
?>