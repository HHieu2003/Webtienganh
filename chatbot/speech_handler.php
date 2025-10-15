<?php
session_start();
include('../config/config.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'save_speech_session':
                saveSpeechSession($conn, $input);
                break;
            case 'get_speech_history':
                getSpeechHistory($conn, $input['user_id'] ?? null);
                break;
            case 'save_speech_score':
                saveSpeechScore($conn, $input);
                break;
            case 'get_speech_stats':
                getSpeechStats($conn, $input['user_id'] ?? null);
                break;
            case 'get_speech_lessons':
                getSpeechLessons($conn);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    }
}

// Lưu phiên luyện nói
function saveSpeechSession($conn, $data) {
    try {
        $sql = "INSERT INTO speech_sessions (user_id, session_id, lesson_type, target_text, audio_data, duration, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        
        $user_id = $data['user_id'] ?? null;
        $session_id = $data['session_id'] ?? uniqid('speech_');
        $lesson_type = $data['lesson_type'] ?? 'pronunciation';
        $target_text = $data['target_text'] ?? '';
        $audio_data = $data['audio_data'] ?? '';
        $duration = $data['duration'] ?? 0;
        
        $stmt->bind_param("issssi", $user_id, $session_id, $lesson_type, $target_text, $audio_data, $duration);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'session_id' => $session_id]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Lưu điểm số luyện nói
function saveSpeechScore($conn, $data) {
    try {
        $sql = "INSERT INTO speech_scores (session_id, pronunciation_score, fluency_score, accuracy_score, overall_score, feedback, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        
        $session_id = $data['session_id'];
        $pronunciation = $data['pronunciation_score'] ?? 0;
        $fluency = $data['fluency_score'] ?? 0;
        $accuracy = $data['accuracy_score'] ?? 0;
        $overall = $data['overall_score'] ?? 0;
        $feedback = $data['feedback'] ?? '';
        
        $stmt->bind_param("siiiis", $session_id, $pronunciation, $fluency, $accuracy, $overall, $feedback);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Lấy lịch sử luyện nói
function getSpeechHistory($conn, $user_id = null) {
    try {
        $sql = "SELECT ss.*, sc.pronunciation_score, sc.fluency_score, sc.accuracy_score, sc.overall_score, sc.feedback
                FROM speech_sessions ss
                LEFT JOIN speech_scores sc ON ss.session_id = sc.session_id";
        
        if ($user_id) {
            $sql .= " WHERE ss.user_id = ?";
        }
        
        $sql .= " ORDER BY ss.created_at DESC LIMIT 10";
        
        $stmt = $conn->prepare($sql);
        if ($user_id) {
            $stmt->bind_param("i", $user_id);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = [
                'session_id' => $row['session_id'],
                'lesson_type' => $row['lesson_type'],
                'target_text' => $row['target_text'],
                'duration' => $row['duration'],
                'pronunciation_score' => $row['pronunciation_score'],
                'fluency_score' => $row['fluency_score'],
                'accuracy_score' => $row['accuracy_score'],
                'overall_score' => $row['overall_score'],
                'feedback' => $row['feedback'],
                'created_at' => $row['created_at']
            ];
        }
        
        echo json_encode(['success' => true, 'data' => $sessions]);
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Thống kê luyện nói
function getSpeechStats($conn, $user_id = null) {
    try {
        $stats = [];
        
        $base_sql = "SELECT 
                        COUNT(*) as total_sessions,
                        AVG(sc.overall_score) as avg_score,
                        MAX(sc.overall_score) as best_score,
                        SUM(ss.duration) as total_duration
                     FROM speech_sessions ss
                     LEFT JOIN speech_scores sc ON ss.session_id = sc.session_id";
        
        if ($user_id) {
            $base_sql .= " WHERE ss.user_id = ?";
        }
        
        $stmt = $conn->prepare($base_sql);
        if ($user_id) {
            $stmt->bind_param("i", $user_id);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $stats = $result->fetch_assoc();
        
        echo json_encode(['success' => true, 'data' => $stats]);
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Lấy danh sách bài luyện nói
function getSpeechLessons($conn) {
    try {
        $lessons = [
            [
                'id' => 'basic_intro',
                'title' => 'Self Introduction',
                'level' => 'Beginner',
                'text' => '[translate:Hello, my name is John. I am from Vietnam. I am 25 years old. I work as a software engineer. Nice to meet you.]',
                'vietnamese' => 'Xin chào, tên tôi là John. Tôi đến từ Việt Nam. Tôi 25 tuổi. Tôi làm kỹ sư phần mềm. Rất vui được gặp bạn.',
                'focus' => 'Basic pronunciation, clear articulation'
            ],
            [
                'id' => 'weather_talk',
                'title' => 'Weather Conversation',
                'level' => 'Elementary',
                'text' => '[translate:The weather today is really nice. It\'s sunny and warm. Perfect for going to the park. What do you think about the weather?]',
                'vietnamese' => 'Thời tiết hôm nay thật đẹp. Trời nắng và ấm áp. Hoàn hảo để đi công viên. Bạn nghĩ gì về thời tiết?',
                'focus' => 'Intonation, natural flow'
            ],
            [
                'id' => 'job_interview',
                'title' => 'Job Interview Practice',
                'level' => 'Intermediate',
                'text' => '[translate:I have three years of experience in marketing. I am passionate about digital marketing and social media. I believe I can contribute significantly to your team.]',
                'vietnamese' => 'Tôi có 3 năm kinh nghiệm trong marketing. Tôi đam mê marketing số và mạng xã hội. Tôi tin rằng tôi có thể đóng góp đáng kể cho team của bạn.',
                'focus' => 'Professional tone, confidence'
            ],
            [
                'id' => 'restaurant_order',
                'title' => 'Restaurant Ordering',
                'level' => 'Elementary',
                'text' => '[translate:Excuse me, I\'d like to order a chicken sandwich and a coffee, please. Could you make it to-go? Thank you very much.]',
                'vietnamese' => 'Xin lỗi, tôi muốn gọi một sandwich gà và một cà phê. Bạn có thể làm mang đi được không? Cảm ơn bạn rất nhiều.',
                'focus' => 'Polite expressions, clear requests'
            ],
            [
                'id' => 'business_presentation',
                'title' => 'Business Presentation',
                'level' => 'Advanced',
                'text' => '[translate:Our quarterly sales have increased by 25%. This growth is primarily due to our new marketing strategy and improved customer service. We expect continued growth in the next quarter.]',
                'vietnamese' => 'Doanh số quý của chúng ta đã tăng 25%. Sự tăng trưởng này chủ yếu do chiến lược marketing mới và dịch vụ khách hàng được cải thiện. Chúng ta kỳ vọng tiếp tục tăng trưởng trong quý tới.',
                'focus' => 'Business vocabulary, professional delivery'
            ]
        ];
        
        echo json_encode(['success' => true, 'data' => $lessons]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
