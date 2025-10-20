<?php
// File: pages/question/dapan.php (Phiên bản cải tiến thông báo)
set_time_limit(120); // QUAN TRỌNG: Tăng thời gian thực thi script lên 120 giây
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php');

// --- HÀM GỌI API CHẤM ĐIỂM CỦA AI ---
function gradeEssayWithAI($question, $answer) {
    // API Key của bạn (Nên đặt vào biến môi trường hoặc file config riêng)
    $api_key = "AIzaSyCw79baxbVs0yJ8sxHH2PYUKQN3LDR2kQQ"; // Thay thế bằng API key thực tế
    $api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$api_key}";

    // Xây dựng prompt chi tiết cho Gemini
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
          \"score\": <a numerical score between 0.0 and 10.0, rounded to one decimal place>,
          \"feedback\": \"<Provide detailed, constructive feedback **in Vietnamese** here. Start with an overall comment, then give specific points for improvement based on the criteria above. Keep it encouraging and helpful.>\"
        }
    ";

    $request_body = json_encode(['contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]]);

    // Thiết lập cURL
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Cân nhắc bật lại trên production nếu có certificate hợp lệ
    curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Đặt thời gian chờ cho cURL là 90 giây

    // Thực thi và lấy kết quả
    $api_response_raw = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch); // Lấy lỗi cURL (nếu có)
    curl_close($ch);

    // Xử lý lỗi cURL hoặc HTTP
    if ($curl_error) {
        error_log("cURL Error calling Gemini API: " . $curl_error);
        return ['score' => null, 'feedback' => 'Lỗi: Không thể kết nối đến dịch vụ chấm điểm AI (cURL). Vui lòng liên hệ quản trị viên.'];
    }
    if ($http_code !== 200 || !$api_response_raw) {
        error_log("Gemini API HTTP Error: Code {$http_code}, Response: " . substr($api_response_raw, 0, 500));
        return ['score' => null, 'feedback' => "Lỗi: Dịch vụ chấm điểm AI trả về lỗi HTTP {$http_code}. Vui lòng liên hệ quản trị viên."];
    }

    // Xử lý phản hồi từ API
    $api_response = json_decode($api_response_raw, true);

    // Kiểm tra cấu trúc JSON trả về
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Gemini API JSON Decode Error: " . json_last_error_msg() . ", Raw Response: " . substr($api_response_raw, 0, 500));
        return ['score' => null, 'feedback' => 'Lỗi: Phản hồi từ AI không đúng định dạng JSON. Vui lòng liên hệ quản trị viên.'];
    }

    $ai_text_content = $api_response['candidates'][0]['content']['parts'][0]['text'] ?? '';

    // Trích xuất JSON từ text (loại bỏ ```json nếu có)
    $json_part = trim($ai_text_content);
    if (strpos($json_part, '```json') === 0) {
        $json_part = substr($json_part, 7); // Bỏ ```json
        if (($last_backticks = strrpos($json_part, '```')) !== false) {
            $json_part = substr($json_part, 0, $last_backticks); // Bỏ ``` cuối cùng
        }
    }

    $ai_result = json_decode(trim($json_part), true);

    // Kiểm tra kết quả JSON cuối cùng
    if (json_last_error() !== JSON_ERROR_NONE || !isset($ai_result['score']) || !isset($ai_result['feedback'])) {
        error_log("Gemini API Final JSON Error: " . json_last_error_msg() . ", Processed JSON String: " . $json_part);
        return ['score' => null, 'feedback' => 'Lỗi: Kết quả phân tích từ AI không đúng cấu trúc. Vui lòng liên hệ quản trị viên.'];
    }

    // Trả về kết quả hợp lệ
    return [
        'score' => is_numeric($ai_result['score']) ? (float)$ai_result['score'] : null,
        'feedback' => trim($ai_result['feedback'])
    ];
}

// --- LOGIC XỬ LÝ NỘP BÀI ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Chuyển hướng nếu không phải POST
    header('Location: index.php?nav=question');
    exit();
}

$id_baitest = isset($_POST['id_baitest']) ? (int)$_POST['id_baitest'] : 0;
$answers = $_POST['answers'] ?? [];
$id_hocvien = $_SESSION['id_hocvien'] ?? null;

// Kiểm tra các giá trị đầu vào cơ bản
if (!$id_hocvien) {
    die("Lỗi: Phiên đăng nhập không hợp lệ!"); // Nên chuyển hướng hoặc hiển thị trang lỗi thân thiện hơn
}
if ($id_baitest <= 0) {
    die("Lỗi: ID bài test không hợp lệ!");
}
if (empty($answers)) {
     die("Lỗi: Không nhận được câu trả lời nào!");
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
    if (!$stmt_info) throw new Exception("Lỗi chuẩn bị câu lệnh lấy thông tin câu hỏi: " . $conn->error);
    $stmt_info->bind_param("i", $id_baitest);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();

    $questions_master_data = [];
    $total_mc_questions = 0; // Số câu trắc nghiệm
    $total_essay_questions = 0; // Số câu tự luận

    while ($row = $result_info->fetch_assoc()) {
        $questions_master_data[$row['id_cauhoi']] = $row;
        if ($row['loai_cauhoi'] === 'trac_nghiem') {
            $total_mc_questions++;
        } else {
             $total_essay_questions++;
        }
    }
    $stmt_info->close();

     // Nếu không có câu hỏi nào cho bài test này
    if (empty($questions_master_data)) {
        throw new Exception("Không tìm thấy câu hỏi nào cho bài test này.");
    }

    // Chấm điểm cho phần trắc nghiệm
    $score = 0; // Chỉ tính điểm trắc nghiệm ở đây
    foreach ($answers as $question_id => $answer_data) {
        // Chỉ xử lý câu trắc nghiệm và câu hỏi tồn tại trong master data
        if (isset($questions_master_data[$question_id]) && $questions_master_data[$question_id]['loai_cauhoi'] === 'trac_nghiem') {
            if (isset($answer_data['id_dapan_chon'])) {
                 $chosen_answer_id = (int)$answer_data['id_dapan_chon'];
                // So sánh đáp án chọn với đáp án đúng trong master data
                if (isset($questions_master_data[$question_id]['id_dapan']) && $questions_master_data[$question_id]['id_dapan'] == $chosen_answer_id) {
                    $score++;
                }
            }
        }
    }

    // Lưu kết quả tổng (chỉ tính điểm trắc nghiệm) vào bảng ketquabaitest
    $sql_save_result = "INSERT INTO ketquabaitest (id_hocvien, id_baitest, diem, ngay_lam_bai) VALUES (?, ?, ?, NOW())";
    $stmt_save_result = $conn->prepare($sql_save_result);
    if (!$stmt_save_result) throw new Exception("Lỗi chuẩn bị câu lệnh lưu kết quả: " . $conn->error);

    // Tính điểm trắc nghiệm trên thang 10 (nếu có câu trắc nghiệm)
    $final_mc_score = ($total_mc_questions > 0) ? round(($score / $total_mc_questions) * 10, 2) : 0;

    $stmt_save_result->bind_param("iid", $id_hocvien, $id_baitest, $final_mc_score); // Lưu điểm trắc nghiệm trên thang 10
    $stmt_save_result->execute();
    $id_ketqua = $stmt_save_result->insert_id; // Lấy ID của kết quả vừa lưu
    if ($id_ketqua <= 0) throw new Exception("Lỗi khi lưu kết quả bài test.");
    $stmt_save_result->close();

    // Chuẩn bị câu lệnh để lưu chi tiết từng câu trả lời
    $sql_save_details = "INSERT INTO dapan_hocvien (id_ketqua, id_cauhoi, id_dapan_chon, tra_loi_tu_luan, diem_tu_luan, nhan_xet_tu_luan, trang_thai_cham) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_details = $conn->prepare($sql_save_details);
    if (!$stmt_details) throw new Exception("Lỗi chuẩn bị câu lệnh lưu chi tiết đáp án: " . $conn->error);

    // Duyệt qua TẤT CẢ câu hỏi trong $questions_master_data để đảm bảo không bỏ sót câu nào
    foreach ($questions_master_data as $question_id => $question_info) {
        $id_dapan_chon = null;
        $tra_loi_tu_luan = null;
        $diem_tu_luan = null;
        $nhan_xet_tu_luan = null;
        $trang_thai_cham = 'da_cham'; // Mặc định cho trắc nghiệm

        $answer_data = $answers[$question_id] ?? null; // Lấy dữ liệu trả lời của học viên cho câu hỏi này

        if ($question_info['loai_cauhoi'] === 'trac_nghiem') {
            // Lấy ID đáp án đã chọn từ dữ liệu gửi lên
            $id_dapan_chon = isset($answer_data['id_dapan_chon']) ? (int)$answer_data['id_dapan_chon'] : null;
        } else { // Câu hỏi tự luận
            // Lấy nội dung trả lời tự luận
            $tra_loi_tu_luan = isset($answer_data['tra_loi_tu_luan']) ? trim($answer_data['tra_loi_tu_luan']) : '';

            // Chỉ gọi API nếu có nội dung trả lời
            if (!empty($tra_loi_tu_luan)) {
                $grading_result = gradeEssayWithAI($question_info['noi_dung'], $tra_loi_tu_luan);
                $diem_tu_luan = $grading_result['score']; // Lấy điểm từ AI (thang 10)
                $nhan_xet_tu_luan = $grading_result['feedback'];
                // Nếu AI không chấm được (trả về null), trạng thái là 'cho_cham'
                if ($diem_tu_luan === null) {
                    $trang_thai_cham = 'cho_cham';
                    $nhan_xet_tu_luan = $nhan_xet_tu_luan ?: 'Lỗi chấm điểm tự động. Chờ giáo viên chấm.'; // Thêm thông báo lỗi vào nhận xét
                }
            } else {
                 // Nếu không trả lời, trạng thái là 'cho_cham' và điểm là null
                $trang_thai_cham = 'cho_cham';
                $nhan_xet_tu_luan = 'Học viên chưa trả lời.';
            }
        }

        // Lưu chi tiết vào CSDL
        $stmt_details->bind_param("iiisdss", $id_ketqua, $question_id, $id_dapan_chon, $tra_loi_tu_luan, $diem_tu_luan, $nhan_xet_tu_luan, $trang_thai_cham);
        if (!$stmt_details->execute()) {
             // Ghi log lỗi chi tiết hơn nếu cần
             error_log("Lỗi khi lưu chi tiết câu hỏi ID {$question_id}: " . $stmt_details->error);
             // Không throw exception ngay, cố gắng lưu các câu khác
        }
    }
    $stmt_details->close();

    $conn->commit();

    // --- HIỂN THỊ THÔNG BÁO SWEETALERT2 KHI THÀNH CÔNG ---
    echo '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Kết quả bài kiểm tra</title>
            <script src="[https://cdn.jsdelivr.net/npm/sweetalert2@11](https://cdn.jsdelivr.net/npm/sweetalert2@11)"></script>
            <style>body { font-family: sans-serif; }</style>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: "Hoàn thành!",
                    html: "Bạn đã hoàn thành bài kiểm tra.<br>' .
                          ($total_mc_questions > 0 ? 'Điểm trắc nghiệm: <strong>' . $score . '/' . $total_mc_questions . ' (' . $final_mc_score . '/10)</strong><br>' : '') .
                          ($total_essay_questions > 0 ? 'Phần tự luận đã được chấm tự động (nếu có).' : '') .
                          '<br>Vui lòng xem chi tiết trong trang cá nhân.",
                    icon: "success",
                    confirmButtonText: "Xem kết quả chi tiết",
                    confirmButtonColor: "#3085d6", // Màu xanh dương
                    allowOutsideClick: false // Không cho đóng khi click bên ngoài
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "user/dashboard.php?nav=ketquakiemtra"; // Đảm bảo đường dẫn này đúng
                    }
                });
            </script>
        </body>
        </html>
    ';
    exit();

} catch (Exception $e) {
    $conn->rollback();
    error_log("Lỗi khi nộp bài test ID {$id_baitest} của học viên ID {$id_hocvien}: " . $e->getMessage());

    // --- HIỂN THỊ THÔNG BÁO SWEETALERT2 KHI CÓ LỖI ---
     echo '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Lỗi nộp bài</title>
            <script src="[https://cdn.jsdelivr.net/npm/sweetalert2@11](https://cdn.jsdelivr.net/npm/sweetalert2@11)"></script>
            <style>body { font-family: sans-serif; }</style>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: "Có lỗi xảy ra!",
                    text: "Đã có lỗi trong quá trình nộp bài. Chi tiết lỗi đã được ghi lại. Vui lòng thử lại sau.",
                    icon: "error",
                    confirmButtonText: "Quay lại",
                    confirmButtonColor: "#d33", // Màu đỏ
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back(); // Quay lại trang trước đó (trang làm bài)
                    }
                });
            </script>
        </body>
        </html>
     ';
    exit();
} finally {
    // Đảm bảo đóng kết nối CSDL ngay cả khi có lỗi
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>