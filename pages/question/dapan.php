<?php
// File: pages/question/dapan.php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(120); // Tăng thời gian thực thi script lên 120 giây
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php');

// --- HÀM GỌI API CHẤM ĐIỂM CỦA AI ---
function gradeEssayWithAI($question, $answer)
{
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
    // Lấy thông tin bài test để kiểm tra loại bài test
    $sql_baitest_info = "SELECT loai_baitest FROM baitest WHERE id_baitest = ?";
    $stmt_baitest_info = $conn->prepare($sql_baitest_info);
    if (!$stmt_baitest_info) throw new Exception("Lỗi chuẩn bị câu lệnh lấy thông tin bài test: " . $conn->error);
    $stmt_baitest_info->bind_param("i", $id_baitest);
    $stmt_baitest_info->execute();
    $result_baitest_info = $stmt_baitest_info->get_result();
    $baitest_info = $result_baitest_info->fetch_assoc();
    $stmt_baitest_info->close();

    $loai_baitest = $baitest_info['loai_baitest'] ?? 'on_tap';
    $is_placement_test = ($loai_baitest === 'dau_vao'); // Kiểm tra có phải test đầu vào không

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

    // Tính điểm trắc nghiệm trên thang 10 (nếu có câu trắc nghiệm)
    $final_mc_score = ($total_mc_questions > 0) ? round(($score / $total_mc_questions) * 10, 2) : 0;

    // Biến để tính tổng điểm tự luận (dùng để tính điểm trung bình)
    $total_essay_score = 0;
    $essay_count_graded = 0; // Số bài tự luận đã được chấm điểm

    // Lưu kết quả tổng (chỉ tính điểm trắc nghiệm) vào bảng ketquabaitest
    $sql_save_result = "INSERT INTO ketquabaitest (id_hocvien, id_baitest, diem, ngay_lam_bai) VALUES (?, ?, ?, NOW())";
    $stmt_save_result = $conn->prepare($sql_save_result);
    if (!$stmt_save_result) throw new Exception("Lỗi chuẩn bị câu lệnh lưu kết quả: " . $conn->error);

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

                // Cộng điểm tự luận để tính trung bình
                if ($diem_tu_luan !== null) {
                    $total_essay_score += $diem_tu_luan;
                    $essay_count_graded++;
                }

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

    // --- PHÂN LOẠI TRÌNH ĐỘ CHO TEST ĐẦU VÀO ---
    $final_total_score = 0; // Khởi tạo biến mặc định
    $trinh_do = ''; // Khởi tạo biến mặc định

    if ($is_placement_test) {
        // Tính điểm trung bình tự luận (nếu có)
        $avg_essay_score = ($essay_count_graded > 0) ? round($total_essay_score / $essay_count_graded, 2) : 0;

        // Tính điểm tổng kết:
        // - Nếu có cả trắc nghiệm và tự luận: lấy trung bình
        // - Nếu chỉ có trắc nghiệm: lấy điểm trắc nghiệm
        // - Nếu chỉ có tự luận: lấy điểm tự luận
        if ($total_mc_questions > 0 && $essay_count_graded > 0) {
            // Có cả 2 loại: trung bình cộng
            $final_total_score = round(($final_mc_score + $avg_essay_score) / 2, 2);
        } elseif ($total_mc_questions > 0) {
            // Chỉ có trắc nghiệm
            $final_total_score = $final_mc_score;
        } elseif ($essay_count_graded > 0) {
            // Chỉ có tự luận
            $final_total_score = $avg_essay_score;
        }

        // Phân loại trình độ dựa trên điểm tổng
        if ($final_total_score >= 8.5) {
            $trinh_do = 'Nâng cao (C1-C2)';
        } elseif ($final_total_score >= 7.0) {
            $trinh_do = 'Trung cấp cao (B2)';
        } elseif ($final_total_score >= 5.5) {
            $trinh_do = 'Trung cấp (B1)';
        } elseif ($final_total_score >= 4.0) {
            $trinh_do = 'Sơ cấp cao (A2)';
        } else {
            $trinh_do = 'Sơ cấp (A1)';
        }

        // Cập nhật trình độ vào bảng hocvien
        $sql_update_level = "UPDATE hocvien SET trinh_do = ? WHERE id_hocvien = ?";
        $stmt_update_level = $conn->prepare($sql_update_level);
        if (!$stmt_update_level) throw new Exception("Lỗi chuẩn bị câu lệnh cập nhật trình độ: " . $conn->error);
        $stmt_update_level->bind_param("si", $trinh_do, $id_hocvien);
        $stmt_update_level->execute();
        $stmt_update_level->close();
    }
    // --- KẾT THÚC PHÂN LOẠI TRÌNH ĐỘ ---

    $conn->commit();

    // --- HIỂN THỊ THÔNG BÁO SWEETALERT2 KHI THÀNH CÔNG ---
    // Chuẩn bị thông báo cho test đầu vào
    $placement_message = '';
    if ($is_placement_test && !empty($trinh_do)) {
        $placement_message = "<div style='margin-top: 15px; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;'>
            <h4 style='margin: 0 0 10px 0; font-size: 18px;'><i class='fas fa-award'></i> Kết quả phân loại trình độ</h4>
            <p style='margin: 5px 0; font-size: 16px;'><strong>Điểm tổng kết:</strong> " . htmlspecialchars($final_total_score) . "/10</p>
            <p style='margin: 5px 0; font-size: 18px; font-weight: bold;'><strong>Trình độ của bạn:</strong> " . htmlspecialchars($trinh_do) . "</p>
            <p style='margin: 10px 0 0 0; font-size: 14px; opacity: 0.9;'>Trình độ này sẽ được lưu vào hồ sơ của bạn để gợi ý khóa học phù hợp.</p>
        </div>";
    }

    $mc_score_message = ($total_mc_questions > 0) ? "Điểm trắc nghiệm: <strong>" . htmlspecialchars($score) . "/" . htmlspecialchars($total_mc_questions) . " (" . htmlspecialchars($final_mc_score) . "/10)</strong><br>" : '';
    $essay_message = ($total_essay_questions > 0) ? "Phần tự luận đã được chấm tự động (nếu có).<br>" : '';

    // Tạo message hoàn chỉnh
    $full_message = "Bạn đã hoàn thành bài kiểm tra.<br>" . $mc_score_message . $essay_message . $placement_message . "<br><br>Vui lòng xem chi tiết trong trang cá nhân.";

?>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <title>Kết quả bài kiểm tra</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                font-family: sans-serif;
            }
        </style>
    </head>

    <body>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Hoàn thành!",
                    html: <?php echo json_encode($full_message, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>,
                    icon: "success",
                    confirmButtonText: "Xem chi tiết",
                    confirmButtonColor: "#3085d6",
                    allowOutsideClick: false,
                    width: "600px"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/user/dashboard.php?nav=ketquakiemtra";
                    }
                });
            });
        </script>
    </body>

    </html>
<?php
    exit();
} catch (Exception $e) {
    $conn->rollback();
    error_log("Lỗi khi nộp bài test ID {$id_baitest} của học viên ID {$id_hocvien}: " . $e->getMessage());

    // --- HIỂN THỊ THÔNG BÁO SWEETALERT2 KHI CÓ LỖI ---
?>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <title>Lỗi nộp bài</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body {
                font-family: sans-serif;
            }
        </style>
    </head>

    <body>
        <script>
            Swal.fire({
                title: "Có lỗi xảy ra!",
                text: "Đã có lỗi trong quá trình nộp bài: <?php echo htmlspecialchars($e->getMessage()); ?>",
                icon: "error",
                confirmButtonText: "Quay lại",
                confirmButtonColor: "#d33",
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>
    </body>

    </html>
<?php
    exit();
} finally {
    // Đảm bảo đóng kết nối CSDL ngay cả khi có lỗi
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>