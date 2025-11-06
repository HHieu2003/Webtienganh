<?php
// File: pages/question/question.php (Phiên bản cải tiến - Bỏ banner)
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php'); // Đảm bảo đường dẫn này đúng

$hocvien_id = $_SESSION['id_hocvien'] ?? null;
$trinh_do_hocvien = null; // Sẽ được cập nhật sau nếu có

if (!$hocvien_id) {
    // Thay vì echo script, chuyển hướng an toàn hơn nếu header chưa được gửi
    if (!headers_sent()) {
        header('Location: ./pages/login.php?redirect=question');
        exit;
    } else {
        echo "<script>alert('Vui lòng đăng nhập để làm bài kiểm tra!'); window.location.href='./pages/login.php';</script>";
        exit;
    }
}

// --- Lấy thông tin học viên và các bài test ---

// 1. Lấy thông tin và trình độ của học viên
try {
    $stmt_hocvien = $conn->prepare("SELECT trinh_do FROM hocvien WHERE id_hocvien = ?");
    $stmt_hocvien->bind_param("i", $hocvien_id);
    $stmt_hocvien->execute();
    $result_hocvien = $stmt_hocvien->get_result();
    if ($hocvien_data = $result_hocvien->fetch_assoc()) {
        $trinh_do_hocvien = $hocvien_data['trinh_do'];
    }
    $stmt_hocvien->close();
} catch (Exception $e) {
    error_log("Lỗi khi lấy trình độ học viên: " . $e->getMessage());
    // Có thể hiển thị thông báo lỗi thân thiện hơn nếu cần
}


// 2. Lấy bài test đầu vào (nếu có)
$placement_test = null;
try {
    $result_placement = $conn->query("SELECT * FROM baitest WHERE loai_baitest = 'dau_vao' LIMIT 1");
    if ($result_placement) {
        $placement_test = $result_placement->fetch_assoc();
    }
} catch (Exception $e) {
    error_log("Lỗi khi lấy bài test đầu vào: " . $e->getMessage());
}

// 3. Lấy các bài test định kỳ của các khóa học VÀ CÁC LỚP HỌC đã đăng ký
$course_tests = [];
try {
    $sql_course_tests = "
        SELECT DISTINCT bt.*
        FROM baitest bt
        JOIN dangkykhoahoc dk ON (bt.id_khoahoc = dk.id_khoahoc OR bt.id_lop = dk.id_lop)
        WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan' AND bt.loai_baitest = 'dinh_ky'
        ORDER BY bt.ten_baitest ASC
    ";
    $stmt_course_tests = $conn->prepare($sql_course_tests);
    $stmt_course_tests->bind_param("i", $hocvien_id);
    $stmt_course_tests->execute();
    $result_course_tests = $stmt_course_tests->get_result();
    while ($row = $result_course_tests->fetch_assoc()) {
        $course_tests[] = $row;
    }
    $stmt_course_tests->close();
} catch (Exception $e) {
    error_log("Lỗi khi lấy bài test khóa học: " . $e->getMessage());
}

// 4. Lấy các bài test ôn tập công khai với phân trang
$practice_tests = [];
$total_practice_tests = 0;
$total_practice_pages = 1;
$practice_current_page = 1;

try {
    // Pagination settings
    $tests_per_page = 9; // Số bài test ôn tập mỗi trang
    $practice_current_page = isset($_GET['test_page']) ? max(1, intval($_GET['test_page'])) : 1;
    $offset = ($practice_current_page - 1) * $tests_per_page;

    // Count total practice tests
    $count_result = $conn->query("SELECT COUNT(*) as total FROM baitest WHERE loai_baitest = 'on_tap'");
    if ($count_result) {
        $count_row = $count_result->fetch_assoc();
        $total_practice_tests = $count_row['total'];
        $total_practice_pages = ceil($total_practice_tests / $tests_per_page);
    }

    // Fetch practice tests with LIMIT
    $sql_practice = "SELECT * FROM baitest WHERE loai_baitest = 'on_tap' ORDER BY ten_baitest ASC LIMIT ? OFFSET ?";
    $stmt_practice = $conn->prepare($sql_practice);
    $stmt_practice->bind_param("ii", $tests_per_page, $offset);
    $stmt_practice->execute();
    $result_practice_tests = $stmt_practice->get_result();

    if ($result_practice_tests) {
        while ($row = $result_practice_tests->fetch_assoc()) {
            $practice_tests[] = $row;
        }
    }
    $stmt_practice->close();
} catch (Exception $e) {
    error_log("Lỗi khi lấy bài test ôn tập: " . $e->getMessage());
}


// Hàm trợ giúp để render card bài test (Cải tiến)
function render_test_card_v2($test, $conn, $aos_delay = 0)
{
    if (!$test || !isset($test['id_baitest'])) return;

    // Lấy số câu hỏi một cách an toàn
    $total_questions = 0;
    try {
        $sql_count = "SELECT COUNT(*) as total FROM cauhoi WHERE id_baitest = ?";
        $stmt_count = $conn->prepare($sql_count);
        $stmt_count->bind_param("i", $test['id_baitest']);
        $stmt_count->execute();
        $result_count = $stmt_count->get_result();
        if ($row_count = $result_count->fetch_assoc()) {
            $total_questions = $row_count['total'];
        }
        $stmt_count->close();
    } catch (Exception $e) {
        error_log("Lỗi khi đếm câu hỏi cho bài test ID {$test['id_baitest']}: " . $e->getMessage());
    }


    $icon_class = 'fa-solid fa-file-alt'; // Icon mặc định
    $icon_color = '#6c757d'; // Màu mặc định
    $test_type_label = 'Bài kiểm tra'; // Nhãn mặc định

    switch ($test['loai_baitest'] ?? 'on_tap') {
        case 'dau_vao':
            $icon_class = 'fa-solid fa-right-to-bracket';
            $icon_color = '#17a2b8'; // Info color
            $test_type_label = 'Kiểm tra đầu vào';
            break;
        case 'dinh_ky':
            $icon_class = 'fa-solid fa-calendar-check';
            $icon_color = '#ffc107'; // Warning color
            $test_type_label = 'Kiểm tra định kỳ';
            break;
        case 'on_tap':
            $icon_class = 'fa-solid fa-book-open-reader';
            $icon_color = '#28a745'; // Success color
            $test_type_label = 'Ôn tập tự do';
            break;
    }

    echo '
        <div class="test-card-v2" data-aos="fade-up" data-aos-delay="' . $aos_delay . '">
            <div class="test-card-v2__icon" style="background-color: ' . $icon_color . '1a;">
                <i class="' . $icon_class . '" style="color: ' . $icon_color . ';"></i>
            </div>
            <div class="test-card-v2__content">
                <span class="test-card-v2__type">' . htmlspecialchars($test_type_label) . '</span>
                <h3 class="test-card-v2__title">' . htmlspecialchars($test['ten_baitest']) . '</h3>
                <div class="test-card-v2__meta">
                    <span><i class="fa-solid fa-list-check"></i> ' . $total_questions . ' câu hỏi</span>
                    <span><i class="fa-solid fa-clock"></i> ' . htmlspecialchars($test['thoi_gian']) . ' phút</span>
                </div>
            </div>
            <a class="test-card-v2__button" href="index.php?nav=question_detail&id_baitest=' . $test['id_baitest'] . '">
                Bắt đầu làm bài <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    ';
}
?>

<style>
    /* ==========================================================
   CSS CHO TRANG TRẮC NGHIỆM - PHIÊN BẢN CẢI TIẾN (Bỏ Banner)
   ========================================================== */

    /* --- Biến màu và cài đặt chung --- */
    :root {
        --brand-color: #0db33b;
        --brand-color-dark: #0a8a2c;
        --accent-color: #ffc107;
        /* Vàng */
        --info-color: #17a2b8;
        /* Cyan */
        --warning-color: #ffc107;
        /* Vàng */
        --success-color: #28a745;
        /* Xanh lá */
        --neutral-white: #FFFFFF;
        --neutral-light: #F8F9FA;
        --neutral-gray: #6C757D;
        --text-dark: #212529;
        --border-color: #dee2e6;
        --shadow-soft: 0 8px 25px rgba(0, 0, 0, 0.07);
        --shadow-medium: 0 12px 35px rgba(0, 0, 0, 0.1);
    }

    body {
        background-color: var(--neutral-light);
        /* Nền xám nhạt cho toàn trang */
    }

    /* --- Container chính --- */
    .tests-container-v2 {
        max-width: 1200px;
        margin: 40px auto;
        /* Thêm margin top thay cho banner */
        padding: 0 15px 60px;
        /* Thêm padding dưới */
    }

    /* --- Section Title --- */
    .tests-section-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 40px 0 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
        position: relative;
        text-align: left;
    }

    .tests-section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--brand-color), var(--accent-color));
        border-radius: 2px;
    }

    /* --- Thẻ Bài Test (Card) --- */
    .tests-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .test-card-v2 {
        background: var(--neutral-white);
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
        padding: 25px;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        /* Smooth bounce effect */
        border: 1px solid var(--border-color);
        border-top: 4px solid #6c757d;
        /* Default color */
    }

    /* Border-top colors for variety - 12 beautiful colors */
    .test-card-v2:nth-child(12n+1) {
        border-top-color: #0db33b;
    }

    /* Green */
    .test-card-v2:nth-child(12n+2) {
        border-top-color: #3498db;
    }

    /* Blue */
    .test-card-v2:nth-child(12n+3) {
        border-top-color: #e74c3c;
    }

    /* Red */
    .test-card-v2:nth-child(12n+4) {
        border-top-color: #f39c12;
    }

    /* Orange */
    .test-card-v2:nth-child(12n+5) {
        border-top-color: #9b59b6;
    }

    /* Purple */
    .test-card-v2:nth-child(12n+6) {
        border-top-color: #1abc9c;
    }

    /* Turquoise */
    .test-card-v2:nth-child(12n+7) {
        border-top-color: #e67e22;
    }

    /* Carrot */
    .test-card-v2:nth-child(12n+8) {
        border-top-color: #2ecc71;
    }

    /* Emerald */
    .test-card-v2:nth-child(12n+9) {
        border-top-color: #f1c40f;
    }

    /* Yellow */
    .test-card-v2:nth-child(12n+10) {
        border-top-color: #e91e63;
    }

    /* Pink */
    .test-card-v2:nth-child(12n+11) {
        border-top-color: #00bcd4;
    }

    /* Cyan */
    .test-card-v2:nth-child(12n+12) {
        border-top-color: #ff5722;
    }

    /* Deep Orange */

    .test-card-v2:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-medium);
        border-top-width: 8px;
        /* Tăng độ dày border khi hover (giảm xuống để mượt hơn) */
    }

    .test-card-v2__icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 24px;
    }

    .test-card-v2__content {
        flex-grow: 1;
        /* Đẩy button xuống dưới */
    }

    .test-card-v2__type {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        color: var(--neutral-gray);
        background-color: var(--neutral-light);
        padding: 4px 10px;
        border-radius: 50px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .test-card-v2__title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
        line-height: 1.4;
        min-height: 50px;
        /* Đảm bảo chiều cao tối thiểu */
        /* Giới hạn 2 dòng */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .test-card-v2__meta {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: var(--neutral-gray);
        margin-bottom: 20px;
    }

    .test-card-v2__meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .test-card-v2__meta i {
        color: var(--brand-color);
    }

    .test-card-v2__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        /* Căn giữa nội dung nút */
        gap: 8px;
        padding: 12px 20px;
        background: var(--brand-color);
        color: var(--neutral-white);
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        /* Bỏ gạch chân link */
        transition: all 0.3s ease;
        width: 100%;
        /* Cho nút rộng full */
        margin-top: auto;
        /* Đẩy nút xuống dưới cùng */
    }

    .test-card-v2__button:hover {
        background: var(--brand-color-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.2);
        color: var(--neutral-white);
        /* Đảm bảo màu chữ không đổi khi hover */
    }

    .test-card-v2__button i {
        transition: transform 0.3s ease;
    }

    .test-card-v2__button:hover i {
        transform: translateX(4px);
    }

    /* --- CTA Kiểm tra đầu vào --- */
    .placement-test-cta-v2 {
        background: linear-gradient(135deg, var(--brand-color), var(--brand-color-dark));
        color: var(--neutral-white);
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        margin-bottom: 50px;
        box-shadow: 0 15px 40px rgba(13, 179, 59, 0.25);
        position: relative;
        overflow: hidden;
    }

    .placement-test-cta-v2::before {
        /* Họa tiết nhẹ */
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .placement-test-cta-v2 h2 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 15px;
        position: relative;
    }

    .placement-test-cta-v2 p {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 25px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
    }

    .cta-button-v2 {
        background-color: var(--neutral-white);
        color: var(--brand-color-dark);
        padding: 12px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    .cta-button-v2:hover {
        background-color: #f0f0f0;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .cta-button-v2 i {
        transition: transform 0.3s ease;
    }

    .cta-button-v2:hover i {
        transform: rotate(360deg);
    }

    /* --- Phần "Sẵn sàng" --- */
    .ready-section-v2 {
        background: var(--neutral-white);
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        padding: 40px;
        margin-top: 50px;
        display: flex;
        align-items: center;
        gap: 40px;
        border-left: 5px solid var(--brand-color);
    }

    .ready-content-v2 h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--brand-color-dark);
        margin-bottom: 10px;
    }

    .ready-content-v2 p {
        color: var(--neutral-gray);
        line-height: 1.7;
        margin: 0;
    }

    .exam-buttons-v2 button {
        margin: 5px;
        padding: 10px 25px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: var(--neutral-white);
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .exam-buttons-v2 button.toeic {
        background: #007bff;
    }

    .exam-buttons-v2 button.ielts {
        background: #dc3545;
    }

    .exam-buttons-v2 button.toefl {
        background: #ffc107;
        color: var(--text-dark);
    }

    .exam-buttons-v2 button:hover {
        opacity: 0.85;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .ready-section-v2 {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 767px) {
        .tests-grid {
            grid-template-columns: 1fr;
        }

        /* 1 cột trên mobile */
        .tests-section-title {
            font-size: 24px;
        }

        .placement-test-cta-v2 h2 {
            font-size: 22px;
        }

        .ready-section-v2 {
            padding: 30px;
        }
    }

    /* --- Question Pagination Styles --- */
    .question-pagination-container {
        margin-top: 25px;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .question-pagination {
        display: flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(13, 179, 59, 0.3);
        backdrop-filter: blur(10px);
    }

    .question-pagination-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .question-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        color: #0a8a2c;
    }

    .question-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .question-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 10px;
    }

    .question-pagination-number {
        min-width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .question-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-3px) scale(1.15);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .question-pagination-number.active {
        background: #fff;
        color: #0a8a2c;
        border-color: #fff;
        transform: scale(1.2);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        animation: questionPageActive 0.5s ease;
    }

    @keyframes questionPageActive {

        0%,
        100% {
            transform: scale(1.2);
        }

        50% {
            transform: scale(1.3);
        }
    }

    .question-pagination-dots {
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .question-pagination-info {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 15px 30px;
        background: rgba(13, 179, 59, 0.1);
        border-radius: 30px;
        color: #0db33b;
        font-size: 15px;
        font-weight: 600;
        border: 2px solid rgba(13, 179, 59, 0.2);
    }

    .question-pagination-info i {
        font-size: 18px;
    }

    .question-pagination-info strong {
        color: #0a8a2c;
        font-size: 17px;
    }

    .question-pagination-info .separator {
        margin: 0 5px;
        color: rgba(13, 179, 59, 0.3);
    }

    /* Question Pagination Responsive */
    @media (max-width: 768px) {
        .question-pagination {
            padding: 15px 20px;
            border-radius: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .question-pagination-btn {
            padding: 5px 8px;
            font-size: 14px;
        }

        .question-pagination-btn span {
            display: none;
        }

        .question-pagination-number {
            min-width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .question-pagination-info {
            font-size: 13px;
            padding: 7px 15px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .question-pagination-numbers {
            gap: 5px;
            margin: 0 5px;
        }

        .question-pagination-number {
            min-width: 35px;
            height: 35px;
            font-size: 13px;
        }
    }
</style>

<div class="tests-container-v2"> <?php if ($placement_test && !$trinh_do_hocvien): ?>
        <div class="placement-test-cta-v2" data-aos="zoom-in">
            <h2><i class="fa-solid fa-rocket"></i> Kiểm tra trình độ đầu vào!</h2>
            <p>Xác định năng lực hiện tại của bạn chỉ với bài kiểm tra ngắn. Hệ thống sẽ gợi ý lộ trình học phù hợp nhất dành riêng cho bạn.</p>
            <a href="index.php?nav=question_detail&id_baitest=<?php echo $placement_test['id_baitest']; ?>" class="cta-button-v2">
                <i class="fa-solid fa-play"></i> Làm bài ngay
            </a>
        </div>
    <?php endif; ?>

    <?php if (!empty($course_tests)): ?>
        <h2 class="tests-section-title">Bài kiểm tra khóa học</h2>
        <div class="tests-grid">
            <?php
            $delay = 0;
            foreach ($course_tests as $test) {
                render_test_card_v2($test, $conn, $delay);
                $delay += 100;
            }
            ?>
        </div>
    <?php endif; ?>

    <h2 class="tests-section-title">Bài ôn tập tự do</h2>
    <div class="tests-grid">
        <?php
        if (!empty($practice_tests)) {
            $delay = 0;
            foreach ($practice_tests as $test) {
                render_test_card_v2($test, $conn, $delay);
                $delay += 100;
            }
        } else {
            echo '<p class="text-muted text-center w-100">Chưa có bài ôn tập nào.</p>'; // Thông báo nếu không có bài
        }
        ?>
    </div>

    <!-- Pagination for Practice Tests -->
    <?php if ($total_practice_pages > 1): ?>
        <div class="question-pagination-container" data-aos="fade-up">
            <div class="question-pagination">
                <?php
                // Previous button
                if ($practice_current_page > 1):
                    $prev_page = $practice_current_page - 1;
                ?>
                    <a href="index.php?nav=question&test_page=<?php echo $prev_page; ?>#practice-tests" class="question-pagination-btn question-pagination-prev">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>
                <?php else: ?>
                    <span class="question-pagination-btn question-pagination-prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </span>
                <?php endif; ?>

                <!-- Page numbers -->
                <div class="question-pagination-numbers">
                    <?php
                    $range = 2;
                    $start = max(1, $practice_current_page - $range);
                    $end = min($total_practice_pages, $practice_current_page + $range);

                    // First page
                    if ($start > 1):
                    ?>
                        <a href="index.php?nav=question&test_page=1#practice-tests" class="question-pagination-number">1</a>
                        <?php if ($start > 2): ?>
                            <span class="question-pagination-dots">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <a href="index.php?nav=question&test_page=<?php echo $i; ?>#practice-tests"
                            class="question-pagination-number <?php echo $i == $practice_current_page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Last page -->
                    <?php if ($end < $total_practice_pages): ?>
                        <?php if ($end < $total_practice_pages - 1): ?>
                            <span class="question-pagination-dots">...</span>
                        <?php endif; ?>
                        <a href="index.php?nav=question&test_page=<?php echo $total_practice_pages; ?>#practice-tests" class="question-pagination-number"><?php echo $total_practice_pages; ?></a>
                    <?php endif; ?>
                </div>

                <!-- Next button -->
                <?php
                if ($practice_current_page < $total_practice_pages):
                    $next_page = $practice_current_page + 1;
                ?>
                    <a href="index.php?nav=question&test_page=<?php echo $next_page; ?>#practice-tests" class="question-pagination-btn question-pagination-next">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <span class="question-pagination-btn question-pagination-next disabled">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Page info -->
            <div class="question-pagination-info">
                <i class="fas fa-clipboard-list"></i>
                Trang <strong><?php echo $practice_current_page; ?></strong> / <strong><?php echo $total_practice_pages; ?></strong>
                <span class="separator">•</span>
                Tổng <strong><?php echo $total_practice_tests; ?></strong> bài test
            </div>
        </div>
    <?php endif; ?>

    <div id="practice-tests" class="ready-section-v2" data-aos="fade-up">
        <div class="ready-content-v2">
            <h2><i class="fa-solid fa-shield-halved"></i> Sẵn sàng chinh phục mọi kỳ thi!</h2>
            <p>Nền tảng của chúng tôi cung cấp đầy đủ kiến thức và kỹ năng cần thiết, giúp bạn tự tin đạt điểm cao trong các kỳ thi tiếng Anh quan trọng như TOEIC, IELTS, TOEFL.</p>
        </div>
        <div class="exam-buttons-v2 d-flex flex-wrap justify-content-center">
            <button class="toeic">TOEIC</button>
            <button class="ielts">IELTS</button>
            <button class="toefl">TOEFL</button>
        </div>
    </div>

</div>