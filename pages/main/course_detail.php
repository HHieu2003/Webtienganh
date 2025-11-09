<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// BƯỚC 2: Khởi động session một cách an toàn
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// --- HÀM HỖ TRỢ CHUYỂỂN HƯỚNG ---
if (!function_exists('course_detail_redirect_to_current')) {
    function course_detail_redirect_to_current(string $anchor = ''): void
    {
        $baseUrl = strtok($_SERVER['REQUEST_URI'], '?');
        $queryParams = http_build_query($_GET);
        $fullUrl = $baseUrl . '?' . $queryParams;

        if ($anchor !== '') {
            $fullUrl .= '#' . ltrim($anchor, '#');
        }

        if (!headers_sent()) {
            header('Location: ' . $fullUrl);
            exit;
        }

        echo '<script>window.location.href=' . json_encode($fullUrl) . ';</script>';
        exit;
    }
}


// --- Khởi tạo các biến mặc định ---
$course = null;
$page_error = null;
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$hocvien_id = $_SESSION['id_hocvien'] ?? null;
$is_registered = false;
$registration_status = null;

// Kiểm tra xem học viên đã đăng ký khóa học này chưa
if ($hocvien_id && $course_id > 0) {
    $sql_check_registration = "SELECT trang_thai FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? ORDER BY id_dangky DESC LIMIT 1";
    $stmt_check_registration = $conn->prepare($sql_check_registration);
    $stmt_check_registration->bind_param("ii", $hocvien_id, $course_id);
    $stmt_check_registration->execute();
    $result_check_registration = $stmt_check_registration->get_result();
    if ($result_check_registration->num_rows > 0) {
        $is_registered = true;
        $registration_status = $result_check_registration->fetch_assoc()['trang_thai'];
    }
}

// --- Xử lý POST request NẾU có course_id hợp lệ ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $course_id > 0) {
    // Xử lý xóa đánh giá
    if (isset($_POST['delete_review'])) {
        $review_id = isset($_POST['delete_review_id']) ? (int)$_POST['delete_review_id'] : 0;

        if ($hocvien_id && $review_id > 0) {
            $sql_check_owner = "SELECT id_khoahoc FROM danhgiakhoahoc WHERE id_danhgia = ? AND id_hocvien = ? LIMIT 1";
            $stmt_check_owner = $conn->prepare($sql_check_owner);
            $stmt_check_owner->bind_param("ii", $review_id, $hocvien_id);
            $stmt_check_owner->execute();
            $result_owner = $stmt_check_owner->get_result()->fetch_assoc();

            if ($result_owner && (int)$result_owner['id_khoahoc'] === $course_id) {
                $sql_delete = "DELETE FROM danhgiakhoahoc WHERE id_danhgia = ?";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $review_id);
                if ($stmt_delete->execute()) {
                    $_SESSION['review_message'] = 'Đánh giá của bạn đã được xóa thành công.';
                    $_SESSION['review_message_type'] = 'success';
                } else {
                    $_SESSION['review_message'] = 'Không thể xóa đánh giá lúc này. Vui lòng thử lại sau.';
                    $_SESSION['review_message_type'] = 'danger';
                }
            } else {
                $_SESSION['review_message'] = 'Bạn không có quyền xóa đánh giá này.';
                $_SESSION['review_message_type'] = 'warning';
            }
        } else {
            $_SESSION['review_message'] = 'Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.';
            $_SESSION['review_message_type'] = 'danger';
        }
        $_SESSION['show_reviews_tab'] = true; 
        course_detail_redirect_to_current('');
    }

    // Xử lý gửi đánh giá mới
    if (isset($_POST['submit_rating'])) {
        if (!$hocvien_id) {
            $_SESSION['review_message'] = 'Vui lòng đăng nhập để đánh giá khóa học!';
            $_SESSION['review_message_type'] = 'warning';
            $_SESSION['show_reviews_tab'] = true; 
            course_detail_redirect_to_current('');   
        }
    }

    $diem_danhgia = $_POST['diem_danhgia'] ?? null;
    $nhan_xet = isset($_POST['nhan_xet']) ? trim($_POST['nhan_xet']) : '';

    // Kiểm tra đã đăng ký khóa học chưa
    $sql_check_reg = "SELECT 1 FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'da xac nhan'";
    $stmt_check_reg = $conn->prepare($sql_check_reg);
    $stmt_check_reg->bind_param("ii", $hocvien_id, $course_id);
    $stmt_check_reg->execute();
    if ($stmt_check_reg->get_result()->num_rows === 0) {
        $_SESSION['review_message'] = 'Bạn cần hoàn tất đăng ký khóa học này để có thể đánh giá!';
        $_SESSION['review_message_type'] = 'danger';
        $_SESSION['show_reviews_tab'] = true; 
        course_detail_redirect_to_current('');
    }

    // Kiểm tra đã tồn tại đánh giá chưa
    $sql_check_existing = "SELECT id_danhgia FROM danhgiakhoahoc WHERE id_hocvien = ? AND id_khoahoc = ?";
    $stmt_check_existing = $conn->prepare($sql_check_existing);
    $stmt_check_existing->bind_param("ii", $hocvien_id, $course_id);
    $stmt_check_existing->execute();
    if ($stmt_check_existing->get_result()->num_rows > 0) {
        $_SESSION['review_message'] = 'Bạn đã đánh giá khóa học này rồi!';
        $_SESSION['review_message_type'] = 'warning';
        $_SESSION['show_reviews_tab'] = true; 
        course_detail_redirect_to_current('');
    }

    // Thêm đánh giá mới
    $sql_insert = "INSERT INTO danhgiakhoahoc (id_hocvien, id_khoahoc, diem_danhgia, nhan_xet) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiis", $hocvien_id, $course_id, $diem_danhgia, $nhan_xet);
    if ($stmt_insert->execute()) {
        $_SESSION['review_message'] = 'Cảm ơn bạn đã đánh giá khóa học!';

        $_SESSION['review_message_type'] = 'success';
    } else {
        $_SESSION['review_message'] = 'Đã có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại.';
        $_SESSION['review_message_type'] = 'danger';
    }
    $_SESSION['show_reviews_tab'] = true; 
    course_detail_redirect_to_current('');
}

// --- Lấy dữ liệu khóa học để hiển thị (GET request) ---
if ($course_id <= 0) {
    $page_error = 'Không có khóa học nào được chọn. Vui lòng quay lại và thử lại.';
} else {
    $sql_course = "SELECT * FROM khoahoc WHERE id_khoahoc = ?";
    $stmt_course = $conn->prepare($sql_course);
    $stmt_course->bind_param("i", $course_id);
    $stmt_course->execute();
    $result_course = $stmt_course->get_result();

    if ($result_course->num_rows > 0) {
        $course = $result_course->fetch_assoc();

        // Lấy thông tin đánh giá
        $sql_avg_rating = "SELECT AVG(diem_danhgia) AS avg_rating, COUNT(*) as total_reviews FROM danhgiakhoahoc WHERE id_khoahoc = ?";
        $stmt_avg = $conn->prepare($sql_avg_rating);
        $stmt_avg->bind_param("i", $course_id);
        $stmt_avg->execute();
        $result_avg_rating = $stmt_avg->get_result()->fetch_assoc();
        $avg_rating = $result_avg_rating['avg_rating'] ? round($result_avg_rating['avg_rating'], 1) : 0;
        $total_reviews = $result_avg_rating['total_reviews'];

        // Lấy bình luận
        $sql_get_comments = "SELECT dg.id_danhgia, dg.id_hocvien, dg.nhan_xet, dg.diem_danhgia, hv.ten_hocvien 
                             FROM danhgiakhoahoc dg 
                             JOIN hocvien hv ON dg.id_hocvien = hv.id_hocvien 
                             WHERE dg.id_khoahoc = ? ORDER BY dg.id_danhgia DESC";
        $stmt_comments = $conn->prepare($sql_get_comments);
        $stmt_comments->bind_param("i", $course_id);
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();
    } else {
        $page_error = 'Khóa học bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.';
    }
}

// --- Lấy thông báo từ session để hiển thị và xóa nó đi ---
$review_message = $_SESSION['review_message'] ?? '';
$review_message_type = $_SESSION['review_message_type'] ?? '';
if (!empty($review_message)) {
    unset($_SESSION['review_message'], $_SESSION['review_message_type']);
}

// --- Chuẩn bị các biến cho giao diện ---
$feedbackDefinitions = [
    'success' => ['icon' => 'fa-circle-check', 'label' => 'Thành công'],
    'warning' => ['icon' => 'fa-triangle-exclamation', 'label' => 'Chú ý'],
    'danger'  => ['icon' => 'fa-circle-exclamation', 'label' => 'Có lỗi xảy ra'],
    'info'    => ['icon' => 'fa-circle-info', 'label' => 'Thông báo'],
];
$activeFeedbackMeta = $feedbackDefinitions[$review_message_type] ?? $feedbackDefinitions['info'];
if ($course) {
    $isStudentLoggedIn = isset($hocvien_id);
    $currentStudentId = $isStudentLoggedIn ? (int)$hocvien_id : null;
    $courseShortIntro = (isset($course['mo_ta_ngan']) && trim(strip_tags($course['mo_ta_ngan'])) !== '') ? htmlspecialchars(trim(strip_tags($course['mo_ta_ngan']))) : 'Khóa học thiết kế giúp bạn bứt phá khả năng tiếng Anh với lộ trình rõ ràng.';
    $courseDurationText = !empty($course['thoi_gian']) ? htmlspecialchars($course['thoi_gian']) . ' buổi' : 'Đang cập nhật';
    $coursePriceNumeric = isset($course['chi_phi']) ? (float)$course['chi_phi'] : 0;
    $coursePriceText = $coursePriceNumeric > 0 ? number_format($coursePriceNumeric, 0, ',', '.') . ' VNĐ' : 'Liên hệ';
    $courseLevelText = (isset($course['cap_do']) && trim($course['cap_do']) !== '') ? htmlspecialchars($course['cap_do']) : 'Mọi trình độ';
    $courseFormatText = (isset($course['hinh_thuc']) && trim($course['hinh_thuc']) !== '') ? htmlspecialchars($course['hinh_thuc']) : 'Linh hoạt';
    $courseTargetText = (isset($course['doi_tuong']) && trim($course['doi_tuong']) !== '') ? htmlspecialchars($course['doi_tuong']) : 'Mọi học viên';
    $courseHighlights = [
        ['icon' => 'fa-clock', 'label' => 'Thời lượng', 'value' => $courseDurationText],
        ['icon' => 'fa-money-check-dollar', 'label' => 'Học phí', 'value' => $coursePriceText],
        ['icon' => 'fa-user-graduate', 'label' => 'Đối tượng', 'value' => $courseTargetText],
        ['icon' => 'fa-chalkboard-user', 'label' => 'Hình thức', 'value' => $courseFormatText],
    ];
}

// =================================================================
// PHẦN 3: HIỂN THỊ GIAO DIỆN (HTML, CSS, JAVASCRIPT)
// =================================================================
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course ? htmlspecialchars($course['ten_khoahoc']) : 'Chi Tiết Khóa Học'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --course-primary: #0db33b;
            --course-primary-dark: #0a8a2c;
            --course-secondary: #056549;
            --course-bg: #f4f7f5;
            --course-muted: #6b7a72;
            --course-surface: #ffffff;
            --course-border: rgba(9, 77, 54, 0.1);
        }


        .course-detail-page {
            background: var(--course-bg);
        }

        .course-hero {
            position: relative;
            padding: 90px 0 70px;
            overflow: hidden;
            background: linear-gradient(145deg, #e8f8f0 0%, #c7ecd9 55%, #f8fffb 100%);
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 20%, rgba(13, 179, 59, 0.08), transparent 60%), radial-gradient(circle at 80% 0%, rgba(5, 101, 73, 0.12), transparent 55%);
            opacity: 0.9;
            pointer-events: none;
        }

        .course-hero__info {
            position: relative;
            z-index: 2;
            color: var(--course-secondary);
        }

        .course-hero__badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.75);
            color: var(--course-secondary);
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 12px 30px rgba(13, 179, 59, 0.15);
            margin-bottom: 18px;
        }

        .course-hero__title {
            font-size: clamp(2.4rem, 3vw, 3.4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 16px;
            color: #024429;
        }

        .course-hero__subtitle {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--course-muted);
            max-width: 560px;
            margin-bottom: 28px;
        }

        .course-hero__meta {
            list-style: none;
            padding: 0;
            margin: 0 0 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .course-hero__meta li {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.85);
            color: var(--course-secondary);
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(4, 68, 47, 0.1);
        }

        .course-hero__meta i {
            color: var(--course-primary);
        }

        .course-hero__cta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }

        .btn-enroll {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 14px;
            border: none;
            background: linear-gradient(135deg, var(--course-primary) 0%, var(--course-primary-dark) 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 15px 30px rgba(13, 179, 59, 0.3);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-enroll i {
            transition: transform 0.25s ease;
        }

        .btn-enroll:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 32px rgba(13, 179, 59, 0.35);
            color: #fff;
        }

        .btn-enroll:hover i {
            transform: translateX(5px);
        }

        .course-hero__outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 22px;
            border-radius: 14px;
            font-weight: 600;
            color: var(--course-secondary);
            background: rgba(255, 255, 255, 0.75);
            box-shadow: 0 12px 24px rgba(4, 68, 47, 0.08);
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .course-hero__outline:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(4, 68, 47, 0.12);
            color: var(--course-secondary);
        }

        .course-hero__visual {
            position: relative;
            z-index: 2;
        }

        .course-hero__grid>[class*='col-'] {
            margin-bottom: 40px;
        }

        @media (min-width: 992px) {
            .course-hero__grid>[class*='col-'] {
                margin-bottom: 0;
            }
        }

        .course-hero__image {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            background: linear-gradient(160deg, rgba(4, 68, 47, 0.1), rgba(4, 68, 47, 0.25));
            padding: 16px;
            box-shadow: 0 25px 60px rgba(8, 63, 42, 0.25);
        }

        .course-hero__image img {
            width: 100%;
            display: block;
            border-radius: 20px;
            object-fit: cover;
            aspect-ratio: 4/3;
        }

        .course-hero__floating-card {
            position: absolute;
            bottom: 24px;
            left: 24px;
            padding: 18px 20px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(6px);
            box-shadow: 0 20px 40px rgba(4, 68, 47, 0.2);
            display: grid;
            gap: 6px;
            max-width: 220px;
        }

        .floating-card__label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--course-primary-dark);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .floating-card__score {
            font-size: 1.1rem;
            font-weight: 700;
            color: #024429;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .floating-card__score i {
            color: #ffb400;
        }

        .floating-card__reviews {
            font-size: 0.85rem;
            color: var(--course-muted);
            margin: 0;
        }

        .floating-card__price {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--course-secondary);
        }

        .course-highlights {
            padding: 50px 0;
            margin-top: -40px;
        }

        .course-highlights__row>[class*='col-'] {
            margin-bottom: 24px;
        }

        @media (min-width: 992px) {
            .course-highlights__row>[class*='col-'] {
                margin-bottom: 0;
            }
        }

        .highlight-card {
            background: var(--course-surface);
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--course-border);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .highlight-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(13, 179, 59, 0.07), transparent 65%);
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .highlight-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 50px rgba(13, 179, 59, 0.15);
        }

        .highlight-card:hover::after {
            opacity: 1;
        }

        .highlight-card__icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(13, 179, 59, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--course-primary);
            font-size: 1.2rem;
            margin-bottom: 14px;
        }

        .highlight-card__label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--course-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .highlight-card__value {
            font-size: 1.05rem;
            font-weight: 700;
            color: #024429;
            margin: 0;
            line-height: 1.6;
        }

        .course-main-section {
            padding: 30px 0 90px;
        }

        .course-main-row>[class*='col-'] {
            margin-bottom: 40px;
        }

        @media (min-width: 992px) {
            .course-main-row>[class*='col-'] {
                margin-bottom: 0;
            }
        }

        .course-tabs {
            background: var(--course-surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--course-border);
        }

        .course-tabs__nav {
            border-bottom: 1px solid rgba(4, 68, 47, 0.12);
            margin-bottom: 24px;
            gap: 12px;
        }

        .course-tabs__nav .nav-link {
            border: none;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            color: var(--course-muted);
            background: transparent;
            transition: all 0.2s ease;
        }

        .course-tabs__nav .nav-link.active,
        .course-tabs__nav .nav-link:hover {
            background: rgba(13, 179, 59, 0.12);
            color: var(--course-secondary);
        }

        .course-tabs__content .tab-pane {
            animation: fadeSlideUp 0.4s ease;
        }

        .course-description {
            font-size: 1rem;
            line-height: 1.9;
            color: #3d4b44;
            text-align: justify;
        }

        .reviews-section {
            display: grid;
            gap: 32px;
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 20px;
        }

        .reviews-score {
            background: rgba(13, 179, 59, 0.08);
            border-radius: 18px;
            padding: 18px 24px;
            display: inline-flex;
            align-items: center;
            gap: 18px;
            color: var(--course-secondary);
        }

        .reviews-score .score-value {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1;
            color: #024429;
        }

        .score-stars {
            display: flex;
            gap: 6px;
            font-size: 1.05rem;
        }

        .score-stars .is-active {
            color: #ffb400;
        }

        .reviews-list {
            display: grid;
            gap: 20px;
        }

        .review-card {
            display: flex;
            gap: 18px;
            padding: 22px;
            border-radius: 20px;
            background: #f9fdfb;
            border: 1px solid rgba(13, 179, 59, 0.12);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        }

        .review-card__avatar img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(13, 179, 59, 0.3);
        }

        .review-card__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
        }

        .review-card__header h6 {
            margin: 0;
            font-weight: 700;
            color: #024429;
        }

        .review-card__stars {
            display: flex;
            gap: 4px;
            color: #d9e2dd;
            font-size: 0.95rem;
        }

        .review-card__stars .is-active {
            color: #ffb400;
        }

        .review-card__content {
            margin: 0;
            color: #3d4b44;
            line-height: 1.7;
        }

        .review-card__actions {
            margin-top: 14px;
        }

        .review-card__delete {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            color: #c0392b;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s ease;
        }

        .review-card__delete:hover {
            color: #922b21;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            border-radius: 20px;
            background: rgba(13, 179, 59, 0.08);
            color: var(--course-secondary);
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 14px;
            display: block;
        }

        .review-form {
            position: relative;
            border-radius: 24px;
            background: #f5fbf7;
            padding: 28px;
            border: 1px solid rgba(13, 179, 59, 0.15);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.05);
        }

        .review-form__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .review-form__header h5 {
            margin: 0;
            font-weight: 700;
            color: #024429;
        }

        .review-form__status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--course-secondary);
            background: rgba(13, 179, 59, 0.15);
            padding: 6px 14px;
            border-radius: 999px;
        }

        .review-form__hint {
            font-size: 0.95rem;
            color: var(--course-muted);
            margin-bottom: 18px;
        }

        .review-form.is-locked::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(245, 251, 247, 0.75);
            border-radius: inherit;
            pointer-events: none;
        }

        .review-form__locked-message {
            margin-top: 18px;
            font-size: 0.95rem;
            color: var(--course-secondary);
        }

        .review-form__locked-message a {
            color: var(--course-primary-dark);
            font-weight: 600;
            text-decoration: underline;
        }

        .review-form textarea {
            resize: vertical;
            min-height: 140px;
        }

        .form-select,
        .review-form .form-control {
            border-radius: 12px;
            border: 1px solid rgba(13, 179, 59, 0.2);
            padding: 0.75rem 0.9rem;
            box-shadow: none;
            color: #3d4b44;
        }

        .form-select:focus,
        .review-form .form-control:focus {
            border-color: var(--course-primary);
            box-shadow: 0 0 0 0.2rem rgba(13, 179, 59, 0.12);
        }

        .form-label {
            font-weight: 600;
            color: #024429;
            margin-bottom: 6px;
        }

        .sidebar-sticky {
            position: sticky;
            top: 110px;
        }

        .course-summary-card {
            background: var(--course-surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--course-border);
            display: grid;
            gap: 24px;
        }

        .course-summary-card .btn-enroll {
            width: 100%;
        }

        .course-summary-card__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .course-summary-card__title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #024429;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .course-summary-card__price {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--course-secondary);
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 16px;
        }

        .summary-list li {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed rgba(13, 179, 59, 0.15);
            color: #3d4b44;
            font-weight: 600;
        }

        .summary-list li:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .summary-list i {
            color: var(--course-primary);
            font-size: 1.1rem;
        }

        .summary-list span {
            color: var(--course-muted);
            font-weight: 500;
        }

        .summary-list strong {
            color: #024429;
        }

        .course-summary-card__note {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: rgba(13, 179, 59, 0.08);
            border-radius: 16px;
            padding: 16px;
            color: var(--course-secondary);
        }

        .course-summary-card__note i {
            font-size: 1.2rem;
        }

        .modal-content {
            border-radius: 22px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: #f1fbf6;
            border-bottom: 1px solid rgba(13, 179, 59, 0.12);
        }

        .modal-title {
            font-weight: 700;
            color: #024429;
        }

        .modal-body {
            background: #f8fbf9;
            padding: 28px;
        }

        .class-item {
            background: var(--course-surface);
            border-radius: 18px;
            padding: 22px;
            border: 1px solid rgba(13, 179, 59, 0.12);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.05);
            margin-bottom: 18px;
            animation: slideInUp 0.5s ease forwards;
            opacity: 0;
        }

        .class-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .class-header h6 {
            margin: 0;
            font-weight: 700;
            color: var(--course-secondary);
        }

        .class-actions .btn {
            border-radius: 10px;
            font-weight: 600;
        }

        .class-meta {
            display: flex;
            gap: 18px;
            color: var(--course-muted);
            font-size: 0.95rem;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .schedule-list {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 220px;
            overflow-y: auto;
        }

        .schedule-list li {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(13, 179, 59, 0.08);
            font-size: 0.95rem;
            flex-wrap: wrap;
        }

        .schedule-list li:last-child {
            border-bottom: none;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 991.98px) {
            .course-hero {
                padding: 70px 0 60px;
            }

            .course-hero__meta li {
                width: 100%;
            }

            .course-highlights {
                margin-top: -20px;
            }

            .course-tabs {
                padding: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .course-hero__meta {
                flex-direction: column;
            }

            .course-hero__floating-card {
                position: static;
                margin-top: 18px;
            }

            .course-hero__image {
                padding: 12px;
            }

            .course-tabs {
                padding: 20px;
            }

            .course-summary-card {
                padding: 24px;
            }
        }
    </style>
</head>

<body>

    <?php if ($page_error): ?>
        <div class="container py-5 my-5">
            <div class="text-center" style="padding: 60px 20px; background: #fff; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.05);">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 4rem; color: #dc3545;"></i>
                <h1 class="mt-4" style="color: #333;">Đã có lỗi xảy ra</h1>
                <p class="lead" style="max-width: 600px; margin: 1rem auto; color: #666;"><?php echo htmlspecialchars($page_error); ?></p>
                <a href="./index.php" class="btn btn-success mt-3" style="padding: 12px 25px; font-weight: bold;">
                    <i class="fa-solid fa-home"></i> Quay về trang chủ
                </a>
            </div>
        </div>
    <?php elseif ($course): ?>
        <div class="course-detail-page">
            <section class="course-hero">
                <div class="hero-pattern"></div>
                <div class="container">
                    <div class="row align-items-center course-hero__grid">
                        <div class="col-lg-7 mb-5 mb-lg-0">
                            <div class="course-hero__info">
                                <span class="course-hero__badge"><i class="fa-solid fa-fire"></i> Khóa học nổi bật</span>
                                <h1 class="course-hero__title"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h1>
                                <p class="course-hero__subtitle"><?php echo $courseShortIntro; ?></p>
                                <ul class="course-hero__meta">
                                    <li><i class="fa-solid fa-star"></i><strong><?php echo $avg_rating; ?></strong> (<?php echo $total_reviews; ?> đánh giá)</li>
                                    <li><i class="fa-solid fa-clock"></i><?php echo $courseDurationText; ?></li>
                                    <li><i class="fa-solid fa-layer-group"></i><?php echo $courseLevelText; ?></li>
                                </ul>
                                <div class="course-hero__cta">
                                    <button class="btn-enroll" data-bs-toggle="modal" data-bs-target="#classSelectionModal">Đăng ký ngay <i class="fa-solid fa-arrow-right"></i></button>
                                    <a href="#course-content" class="course-hero__outline"><i class="fa-solid fa-circle-play"></i> Xem nội dung</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="course-hero__visual">
                                <div class="course-hero__image">
                                    <img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>">
                                    <div class="course-hero__floating-card">
                                        <span class="floating-card__label">Tự tin bứt phá</span>
                                        <div class="floating-card__score"><i class="fa-solid fa-star"></i><?php echo $avg_rating; ?> / 5</div>
                                        <p class="floating-card__reviews"><?php echo $total_reviews; ?> học viên đánh giá</p>
                                        <span class="floating-card__price"><?php echo $coursePriceText; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="course-highlights" id="course-content">
                <div class="container">
                    <div class="row course-highlights__row">
                        <?php foreach ($courseHighlights as $highlight): ?>
                            <div class="col-sm-6 col-lg-3">
                                <div class="highlight-card">
                                    <div class="highlight-card__icon"><i class="fa-solid <?php echo $highlight['icon']; ?>"></i></div>
                                    <p class="highlight-card__label"><?php echo $highlight['label']; ?></p>
                                    <p class="highlight-card__value"><?php echo $highlight['value']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="course-main-section">
                <div class="container">
                    <div class="row course-main-row">
                        <div class="col-lg-8 mb-5 mb-lg-0">
                            <div class="course-tabs">
                                <ul class="nav nav-tabs course-tabs__nav" id="courseTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Mô tả khóa học</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Đánh giá (<?php echo $total_reviews; ?>)</button>
                                    </li>
                                </ul>
                                <div class="tab-content course-tabs__content" id="courseTabContent">
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="course-description">
                                            <?php echo !empty($course['mo_ta']) ? $course['mo_ta'] : '<p>Nội dung đang được cập nhật...</p>'; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                                        <div class="reviews-section">
                                            <div class="reviews-header">
                                                <div class="reviews-score">
                                                    <span class="score-value"><?php echo $avg_rating; ?></span>
                                                    <div class="score-stars">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <i class="fa-solid fa-star <?php echo $i <= round($avg_rating) ? 'is-active' : ''; ?>"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <p><?php echo $total_reviews; ?> đánh giá</p>
                                                </div>
                                            </div>

                                            <?php if ($result_comments && $result_comments->num_rows > 0): ?>
                                                <div class="reviews-list">
                                                    <?php while ($comment = $result_comments->fetch_assoc()): ?>
                                                        <article class="review-card">
                                                            <div class="review-card__avatar">
                                                                <img src="https://i.pravatar.cc/120?u=<?php echo urlencode($comment['ten_hocvien']); ?>" alt="Ảnh đại diện">
                                                            </div>
                                                            <div class="review-card__body">
                                                                <div class="review-card__header">
                                                                    <h6><?php echo htmlspecialchars($comment['ten_hocvien']); ?></h6>
                                                                    <div class="review-card__stars">
                                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                            <i class="fa-solid fa-star <?php echo $i <= (int)$comment['diem_danhgia'] ? 'is-active' : ''; ?>"></i>
                                                                        <?php endfor; ?>
                                                                    </div>
                                                                </div>
                                                                <p class="review-card__content"><?php echo nl2br(htmlspecialchars($comment['nhan_xet'])); ?></p>
                                                                <?php if ($currentStudentId && (int)$comment['id_hocvien'] === $currentStudentId): ?>
                                                                    <form method="POST" class="review-card__actions" onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?');">
                                                                        <input type="hidden" name="delete_review" value="1">
                                                                        <input type="hidden" name="delete_review_id" value="<?php echo (int)$comment['id_danhgia']; ?>">
                                                                        <button type="submit" class="review-card__delete"><i class="fa-solid fa-trash-can"></i> Xóa</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </div>
                                                        </article>
                                                    <?php endwhile; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="empty-state">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    <p>Chưa có đánh giá nào. Hãy là người đầu tiên chia sẻ trải nghiệm!</p>
                                                </div>
                                            <?php endif; ?>

                                            <div class="review-form <?php echo $isStudentLoggedIn ? '' : 'is-locked'; ?>">
                                                <div class="review-form__header">
                                                    <h5>Gửi đánh giá của bạn</h5>
                                                    <?php if (!$isStudentLoggedIn): ?>
                                                        <span class="review-form__status"><i class="fa-solid fa-lock"></i> Chưa đăng nhập</span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="review-form__hint"><?php echo $isStudentLoggedIn ? 'Hãy chia sẻ cảm nhận chân thực để giúp các học viên khác.' : 'Vui lòng đăng nhập để gửi đánh giá.'; ?></p>
                                                <form method="POST" action="">
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-3">
                                                            <label for="diem_danhgia" class="form-label">Điểm đánh giá *</label>
                                                            <select name="diem_danhgia" id="diem_danhgia" class="form-select" <?php echo $isStudentLoggedIn ? '' : 'disabled'; ?> required>
                                                                <option value="5">5 - Tuyệt vời</option>
                                                                <option value="4">4 - Rất tốt</option>
                                                                <option value="3">3 - Tốt</option>
                                                                <option value="2">2 - Tạm ổn</option>
                                                                <option value="1">1 - Cần cải thiện</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="nhan_xet" class="form-label">Nhận xét chi tiết *</label>
                                                            <textarea name="nhan_xet" id="nhan_xet" class="form-control" rows="4" placeholder="Viết cảm nhận của bạn..." <?php echo $isStudentLoggedIn ? '' : 'disabled'; ?> required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="text-end mt-3">
                                                        <button type="submit" name="submit_rating" class="btn btn-success" <?php echo $isStudentLoggedIn ? '' : 'disabled'; ?>>Gửi đánh giá</button>
                                                    </div>
                                                </form>
                                                <?php if (!$isStudentLoggedIn): ?>
                                                    <div class="review-form__locked-message">
                                                        <p><i class="fa-solid fa-circle-info"></i> Bạn cần <a href="./pages/login.php">đăng nhập</a> để gửi đánh giá.</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="sidebar-sticky">
                                <div class="course-summary-card">
                                    <div class="course-summary-card__header">
                                        <span class="course-summary-card__title">Thông tin</span>
                                        <span class="course-summary-card__price"><?php echo $coursePriceText; ?></span>
                                    </div>
                                    <ul class="summary-list">
                                        <li><i class="fa-solid fa-hourglass-half"></i><span>Thời lượng</span><strong><?php echo $courseDurationText; ?></strong></li>
                                        <li><i class="fa-solid fa-layer-group"></i><span>Cấp độ</span><strong><?php echo $courseLevelText; ?></strong></li>
                                        <li><i class="fa-solid fa-chalkboard-user"></i><span>Hình thức</span><strong><?php echo $courseFormatText; ?></strong></li>
                                    </ul>
                                    <button class="btn-enroll" data-bs-toggle="modal" data-bs-target="#classSelectionModal">Đăng ký ngay <i class="fa-solid fa-arrow-right"></i></button>
                                    <div class="course-summary-card__note">
                                        <i class="fa-solid fa-shield-heart"></i>
                                        <p>Cam kết đồng hành cùng học viên với lộ trình học cá nhân hóa và hỗ trợ 24/7.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="modal fade" id="classSelectionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="classSelectionModalLabel">Đăng ký khóa học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="classListContainer"></div>
                </div>
            </div>
        </div>

        <!-- Modal Thông báo trạng thái đăng ký -->
        <?php if ($is_registered): ?>
        <div class="modal fade" id="registrationStatusModal" tabindex="-1" aria-labelledby="registrationStatusModalLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border: none; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, 
                        <?php 
                            if ($registration_status === 'da xac nhan') {
                                echo 'rgba(13, 179, 59, 0.1), rgba(13, 179, 59, 0.05)';
                            } elseif ($registration_status === 'cho xac nhan') {
                                echo 'rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.05)';
                            } else {
                                echo 'rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05)';
                            }
                        ?>); padding: 24px;">
                        <div class="d-flex align-items-center w-100">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: <?php 
                                echo $registration_status === 'da xac nhan' ? 'rgba(13, 179, 59, 0.15)' : 
                                     ($registration_status === 'cho xac nhan' ? 'rgba(13, 110, 253, 0.15)' : 'rgba(255, 193, 7, 0.15)'); 
                            ?>;">
                                <i class="fa-solid fa-<?php 
                                    echo $registration_status === 'da xac nhan' ? 'circle-check' : 
                                         ($registration_status === 'cho xac nhan' ? 'clock' : 'triangle-exclamation'); 
                                ?>" style="font-size: 1.8rem; color: <?php 
                                    echo $registration_status === 'da xac nhan' ? '#0db33b' : 
                                         ($registration_status === 'cho xac nhan' ? '#0d6efd' : '#ffc107'); 
                                ?>;"></i>
                            </div>
                            <h5 class="modal-title mb-0" id="registrationStatusModalLabel" style="color: #024429; font-weight: 700;">
                                <?php 
                                    if ($registration_status === 'da xac nhan') {
                                        echo 'Thông báo đăng ký thành công';
                                    } elseif ($registration_status === 'cho xac nhan') {
                                        echo 'Đăng ký đang chờ xác nhận';
                                    } else {
                                        echo 'Thông báo đăng ký đã hủy';
                                    }
                                ?>
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 32px; background: #f8fbf9;">
                        <div class="text-center mb-3">
                            <h6 style="font-size: 1.15rem; font-weight: 700; color: #024429; margin-bottom: 12px;">
                                <?php 
                                    if ($registration_status === 'da xac nhan') {
                                        echo 'Bạn đã đăng ký khóa học này!';
                                    } elseif ($registration_status === 'cho xac nhan') {
                                        echo 'Đăng ký của bạn đang chờ xác nhận!';
                                    } else {
                                        echo 'Đăng ký của bạn đã bị hủy!';
                                    }
                                ?>
                            </h6>
                            <p style="color: #6b7a72; line-height: 1.7; margin: 0;">
                                <?php 
                                    if ($registration_status === 'da xac nhan') {
                                        echo 'Bạn có thể xem thông tin lớp học và lịch học trong trang cá nhân. Hãy chuẩn bị sẵn sàng để bắt đầu hành trình học tập của mình!';
                                    } elseif ($registration_status === 'cho xac nhan') {
                                        echo 'Nếu bạn dã thanh toán chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận thông tin lớp học. Nếu bạn chưa thanh toán hãy đăng ký lại. ';
                                    } else {
                                        echo 'Bạn có thể đăng ký lại nếu muốn tiếp tục học khóa học này. Chúng tôi luôn sẵn sàng đồng hành cùng bạn!';
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <?php if ($registration_status === 'da xac nhan'): ?>
                                <a href="../../user/dashboard.php" class="btn btn-success" style="border-radius: 12px; padding: 10px 24px; font-weight: 600;">
                                    <i class="fa-solid fa-user"></i> Xem trang cá nhân
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 12px; padding: 10px 24px; font-weight: 600;">
                                Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if (!empty($review_message)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 'danger' của Bootstrap tương ứng với 'error' của SweetAlert2
                const iconType = '<?php echo $review_message_type; ?>' === 'danger' ? 'error' : '<?php echo $review_message_type; ?>';

                Swal.fire({
                    title: '<?php echo $activeFeedbackMeta['label']; ?>',
                    text: '<?php echo addslashes(htmlspecialchars($review_message)); ?>',
                    icon: iconType,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0db33b' // Màu nút cho hợp với theme
                });
            });
        </script>
    <?php endif; ?>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-show registration status modal if student is registered
            <?php if ($is_registered): ?>
            const registrationStatusModalEl = document.getElementById('registrationStatusModal');
            if (registrationStatusModalEl) {
                const registrationModal = new bootstrap.Modal(registrationStatusModalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
                
                // Show modal
                registrationModal.show();
                
                // Add manual event listeners for close buttons
                const closeButtons = registrationStatusModalEl.querySelectorAll('[data-bs-dismiss="modal"]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        registrationModal.hide();
                    });
                });
                
                // Close on backdrop click
                registrationStatusModalEl.addEventListener('click', function(e) {
                    if (e.target === registrationStatusModalEl) {
                        registrationModal.hide();
                    }
                });
                
                // Close on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && registrationStatusModalEl.classList.contains('show')) {
                        registrationModal.hide();
                    }
                });
            }
            <?php endif; ?>

            // Auto-activate reviews tab if hash is #reviews
            if (window.location.hash === '#reviews') {
                const reviewsTab = document.getElementById('reviews-tab');
                if (reviewsTab) {
                    new bootstrap.Tab(reviewsTab).show();
                }
            }

            // Logic for Class Selection Modal (giữ nguyên)
            const classSelectionModal = document.getElementById('classSelectionModal');
            if (classSelectionModal) {
                const classListContainer = document.getElementById('classListContainer');
                const modalTitle = document.getElementById('classSelectionModalLabel');
                const courseId = <?php echo $course_id ?? 'null'; ?>;

                classSelectionModal.addEventListener('show.bs.modal', async function() {
                    if (!courseId) return;

                    modalTitle.textContent = 'Đang tải thông tin...';
                    classListContainer.innerHTML = `<div class="text-center p-5"><div class="spinner-border text-success" role="status"></div></div>`;

                    try {
                        const response = await fetch(`./pages/main/get_classes_for_course.php?course_id=${courseId}`);
                        if (!response.ok) throw new Error(`Lỗi mạng: ${response.status}`);
                        const classes = await response.json();

                        let finalHtml = '';

                        if (Array.isArray(classes) && classes.length > 0) {
                            modalTitle.textContent = 'Chọn Lớp Học Hoặc Để Lại Nguyện Vọng';
                            let classListHtml = '<h5>Các lớp học đang có sẵn:</h5>';
                            classes.forEach((classItem, index) => {
                                let scheduleHtml = '<p class="p-3 text-muted small">Chưa có lịch học chi tiết.</p>';
                                if (classItem.schedules && classItem.schedules.length > 0) {
                                    scheduleHtml = '<ul class="schedule-list">';
                                    classItem.schedules.forEach(schedule => {
                                        const date = new Date(schedule.ngay_hoc).toLocaleDateString('vi-VN');
                                        scheduleHtml += `<li><span><i class="fas fa-calendar-day text-success"></i> ${date}</span><span><i class="fas fa-clock text-success"></i> ${schedule.gio_bat_dau.substr(0,5)} - ${schedule.gio_ket_thuc.substr(0,5)}</span><span><i class="fas fa-map-marker-alt text-success"></i> ${schedule.phong_hoc}</span></li>`;
                                    });
                                    scheduleHtml += '</ul>';
                                }
                                classListHtml += `
                            <div class="class-item" style="animation-delay: ${index * 100}ms">
                                    <form action="./index.php?nav=dangkykhoahoc" method="POST">
                                        <input type="hidden" name="id_khoahoc" value="${courseId}">
                                        <input type="hidden" name="id_lop" value="${classItem.id_lop}">
                                        <div class="class-header">
                                            <h6>${classItem.ten_lop}</h6>
                                            <div class="class-actions">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#schedule-${classItem.id_lop}">Xem lịch</button>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Chọn lớp này</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="class-meta mt-2">
                                        <span><i class="fas fa-user-tie"></i> GV: ${classItem.ten_giangvien || 'N/A'}</span>
                                        <span><i class="fas fa-users"></i> Sĩ số: ${classItem.so_luong_hoc_vien}</span>
                                    </div>
                                    <div class="collapse mt-3" id="schedule-${classItem.id_lop}">
                                        <div class="card card-body" style="padding: 0;">${scheduleHtml}</div>
                                    </div>
                                </div>`;
                            });
                            finalHtml += classListHtml;
                            finalHtml += '<hr class="my-4">';
                        } else {
                            modalTitle.textContent = 'Đăng ký trước và để lại nguyện vọng';
                        }

                        const noteFormHtml = `
                    <div class="mt-3">
                        <h5>${classes.length > 0 ? 'Hoặc không tìm thấy lớp phù hợp?' : ''} Đăng ký và để lại nguyện vọng</h5>
                        <div class="alert alert-info small">Nếu bạn đăng ký theo cách này, chúng tôi sẽ liên hệ để xếp lớp cho bạn sau.</div>
                        <form action="./index.php?nav=dangkykhoahoc" method="POST">
                            <input type="hidden" name="id_khoahoc" value="${courseId}">
                            <div class="mb-3">
                                <label for="ghi_chu" class="form-label"><strong>Ghi chú nguyện vọng</strong></label>
                                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="4" placeholder="VD: Em có thể học vào các buổi tối T2-T4-T6."></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Đăng ký với ghi chú</button>
                            </div>
                        </form>
                    </div>`;
                        finalHtml += noteFormHtml;
                        classListContainer.innerHTML = finalHtml;

                    } catch (error) {
                        console.error('Lỗi khi tải danh sách lớp:', error);
                        classListContainer.innerHTML = '<div class="alert alert-danger text-center">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại sau.</div>';
                    }
                });
            }
        });
    </script>

</body>

</html>