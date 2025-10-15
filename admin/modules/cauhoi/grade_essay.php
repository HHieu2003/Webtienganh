<?php
// File: admin/modules/cauhoi/grade_essay.php
include('../../../config/config.php');
session_start();
header('Content-Type: application/json');

// --- Bảo mật: Chỉ cho phép Admin hoặc Giảng viên truy cập ---
if (!isset($_SESSION['is_admin']) && !isset($_SESSION['is_teacher'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện hành động này.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$dapan_hocvien_id = (int)($data['dapan_hocvien_id'] ?? 0);

if ($dapan_hocvien_id === 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID câu trả lời không hợp lệ.']);
    exit();
}

// 1. Lấy thông tin câu hỏi và câu trả lời từ CSDL
// *** THAY ĐỔI QUAN TRỌNG: ĐÃ BỎ `AND dh.trang_thai_cham = 'cho_cham'` ĐỂ CHO PHÉP CHẤM LẠI ***
$sql_get_data = "
    SELECT c.noi_dung AS question, dh.tra_loi_tu_luan AS answer
    FROM dapan_hocvien dh
    JOIN cauhoi c ON dh.id_cauhoi = c.id_cauhoi
    WHERE dh.id = ?
";
$stmt_get = $conn->prepare($sql_get_data);
$stmt_get->bind_param("i", $dapan_hocvien_id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$submission_data = $result->fetch_assoc();
$stmt_get->close();

if (!$submission_data) {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy bài làm của học viên.']);
    exit();
}

// 2. Xây dựng PROMPT chi tiết cho AI
$prompt = "
    You are an expert English teacher evaluating a student's essay.
    The grading scale is from 0 to 10.
    
    Analyze the following essay based on these criteria:
    1.  **Task Achievement (25%)**: Did the student fully answer the question?
    2.  **Coherence and Cohesion (25%)**: Is the essay well-structured with logical flow and linking words?
    3.  **Lexical Resource (25%)**: Did the student use a good range of vocabulary appropriately?
    4.  **Grammatical Range and Accuracy (25%)**: How accurate and varied are the grammatical structures?

    Question: '{$submission_data['question']}'
    Student's Essay: '{$submission_data['answer']}'

    Your response MUST be a JSON object with the following structure, and nothing else:
    {
      \"score\": <a numerical score between 0.0 and 10.0>,
      \"feedback\": \"<Provide detailed, constructive feedback in Vietnamese here. Start with an overall comment, then give specific points for improvement based on the criteria above. Keep it encouraging and helpful.>\"
    }
";

// 3. Gọi API của Google Gemini
$api_key = "AIzaSyBu3OOT0rNIc-1DDdFYW8EJh-s9sNzm_lc"; // API Key của bạn
$api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$api_key}";

$request_body = json_encode([
    'contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]
]);

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 90);

$api_response_raw = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200 || !$api_response_raw) {
    echo json_encode(['status' => 'error', 'message' => "Lỗi khi gọi API chấm điểm. HTTP Code: {$http_code}"]);
    exit();
}

// 4. Xử lý kết quả từ AI
$api_response = json_decode($api_response_raw, true);
$ai_text_content = $api_response['candidates'][0]['content']['parts'][0]['text'] ?? '';

$json_part = trim($ai_text_content);
if (strpos($json_part, '```json') === 0) {
    $json_part = str_replace('```json', '', $json_part);
    $json_part = str_replace('```', '', $json_part);
}

$ai_result = json_decode(trim($json_part), true);

if (json_last_error() !== JSON_ERROR_NONE || !isset($ai_result['score']) || !isset($ai_result['feedback'])) {
     echo json_encode(['status' => 'error', 'message' => 'Phản hồi từ AI không đúng định dạng JSON.', 'raw_response' => $ai_text_content]);
    exit();
}

$score = (float)$ai_result['score'];
$feedback = trim($ai_result['feedback']);

// 5. Cập nhật kết quả vào CSDL
$sql_update_grade = "
    UPDATE dapan_hocvien
    SET diem_tu_luan = ?, nhan_xet_tu_luan = ?, trang_thai_cham = 'da_cham'
    WHERE id = ?
";
$stmt_update = $conn->prepare($sql_update_grade);
$stmt_update->bind_param("dsi", $score, $feedback, $dapan_hocvien_id);

if ($stmt_update->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Chấm điểm thành công!',
        'score' => $score,
        'feedback' => nl2br(htmlspecialchars($feedback))
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi cập nhật điểm vào cơ sở dữ liệu.']);
}
$stmt_update->close();
$conn->close();
?>