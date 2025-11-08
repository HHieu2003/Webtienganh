<?php
// File: pages/question/question.php (Phiên bản cải tiến - Bỏ banner)
if (session_status() == PHP_SESSION_NONE) session_start();
include('./config/config.php'); // Đảm bảo đường dẫn này đúng

$hocvien_id = $_SESSION['id_hocvien'] ?? null;
$trinh_do_hocvien = null; // Sẽ được cập nhật sau nếu có

if (!$hocvien_id) {
    // Hiển thị modal thông báo đẹp thay vì alert
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Yêu cầu đăng nhập</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                overflow: hidden;
            }
            
            .login-required-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(10px);
                z-index: 9999;
                animation: fadeIn 0.3s ease-out;
            }
            
            .login-required-modal {
                position: relative;
                background: white;
                border-radius: 24px;
                padding: 50px 40px;
                max-width: 480px;
                width: 90%;
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
                animation: slideUp 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
                text-align: center;
                margin: auto;
            }
            
            .login-required-icon {
                width: 90px;
                height: 90px;
                background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 25px;
                box-shadow: 0 10px 30px rgba(13, 179, 59, 0.3);
                animation: bounceIcon 0.8s ease-out;
            }
            
            .login-required-icon i {
                font-size: 45px;
                color: white;
            }
            
            .login-required-title {
                font-size: 28px;
                font-weight: 700;
                color: #212529;
                margin-bottom: 15px;
            }
            
            .login-required-message {
                font-size: 16px;
                color: #6c757d;
                line-height: 1.6;
                margin-bottom: 30px;
            }
            
            .login-required-buttons {
                display: flex;
                gap: 15px;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .login-btn {
                padding: 14px 35px;
                background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
                color: white;
                border: none;
                border-radius: 50px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 8px 20px rgba(13, 179, 59, 0.3);
            }
            
            .login-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 30px rgba(13, 179, 59, 0.4);
            }
            
            .back-btn {
                padding: 14px 35px;
                background: #f8f9fa;
                color: #6c757d;
                border: 2px solid #dee2e6;
                border-radius: 50px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
            }
            
            .back-btn:hover {
                background: #e9ecef;
                border-color: #adb5bd;
                transform: translateY(-2px);
            }
            
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(50px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes bounceIcon {
                0%, 100% {
                    transform: scale(1);
                }
                25% {
                    transform: scale(0.9);
                }
                50% {
                    transform: scale(1.1);
                }
                75% {
                    transform: scale(0.95);
                }
            }
            
            @media (max-width: 576px) {
                .login-required-modal {
                    padding: 40px 25px;
                }
                
                .login-required-title {
                    font-size: 24px;
                }
                
                .login-required-buttons {
                    flex-direction: column;
                }
                
                .login-btn, .back-btn {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-required-overlay">
            <div class="login-required-modal">
                <div class="login-required-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h2 class="login-required-title">Yêu cầu đăng nhập</h2>
                <p class="login-required-message">
                    Bạn cần đăng nhập để truy cập bài kiểm tra trắc nghiệm.<br>
                    Vui lòng đăng nhập hoặc đăng ký tài khoản để tiếp tục!
                </p>
                <div class="login-required-buttons">
                    <a href="./pages/login.php?redirect=question" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        Đăng nhập ngay
                    </a>
                    <a href="./index.php" class="back-btn">
                        <i class="fas fa-home"></i>
                        Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
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


// 2. Lấy TẤT CẢ bài test đầu vào mà học viên có thể truy cập (với tìm kiếm và lọc)
$placement_tests = [];
$total_placement_tests = 0;

// Lấy tham số tìm kiếm và lọc cho placement tests
$placement_search = isset($_GET['placement_search']) ? trim($_GET['placement_search']) : '';
$placement_filter_time = isset($_GET['placement_filter_time']) ? $_GET['placement_filter_time'] : '';
$placement_sort = isset($_GET['placement_sort']) ? $_GET['placement_sort'] : 'name_asc';

try {
    // Xây dựng điều kiện WHERE cho tìm kiếm và lọc
    $placement_where = [];
    $placement_params = [];
    $placement_types = "";
    
    // Tìm kiếm theo tên
    if (!empty($placement_search)) {
        $placement_where[] = "ten_baitest LIKE ?";
        $placement_params[] = "%{$placement_search}%";
        $placement_types .= "s";
    }
    
    // Lọc theo thời gian
    if (!empty($placement_filter_time)) {
        if ($placement_filter_time === 'short') {
            $placement_where[] = "thoi_gian <= 20";
        } elseif ($placement_filter_time === 'medium') {
            $placement_where[] = "thoi_gian > 20 AND thoi_gian <= 40";
        } elseif ($placement_filter_time === 'long') {
            $placement_where[] = "thoi_gian > 40";
        }
    }
    
    $placement_where_clause = !empty($placement_where) ? 'AND ' . implode(' AND ', $placement_where) : '';
    
    // Sắp xếp
    $placement_order = "ten_baitest ASC";
    switch ($placement_sort) {
        case 'name_desc': $placement_order = "ten_baitest DESC"; break;
        case 'time_asc': $placement_order = "thoi_gian ASC"; break;
        case 'time_desc': $placement_order = "thoi_gian DESC"; break;
        case 'newest': $placement_order = "ngay_tao DESC"; break;
        case 'oldest': $placement_order = "ngay_tao ASC"; break;
    }
    
    // Lấy bài test đầu vào CÔNG KHAI
    $sql_public_placement = "
        SELECT * FROM baitest 
        WHERE loai_baitest = 'dau_vao' 
        AND id_khoahoc IS NULL 
        AND id_lop IS NULL
        {$placement_where_clause}
    ";
    
    // Lấy bài test đầu vào của KHÓA HỌC và LỚP HỌC đã đăng ký
    $sql_registered_placement = "
        SELECT DISTINCT bt.*
        FROM baitest bt
        JOIN dangkykhoahoc dk ON (
            (bt.id_khoahoc = dk.id_khoahoc AND bt.id_lop IS NULL) OR 
            (bt.id_lop = dk.id_lop AND bt.id_lop IS NOT NULL)
        )
        WHERE dk.id_hocvien = ? 
        AND dk.trang_thai = 'da xac nhan' 
        AND bt.loai_baitest = 'dau_vao'
        {$placement_where_clause}
    ";
    
    // Kết hợp 2 query bằng UNION
    $sql_all_placement = "
        ($sql_public_placement)
        UNION
        ($sql_registered_placement)
        ORDER BY {$placement_order}
    ";
    
    $stmt_placement = $conn->prepare($sql_all_placement);
    
    // Bind parameters: 
    // - Nếu có search params: cần bind cho registered query (id_hocvien) + search params cho UNION
    // - Parameters phải được bind 2 lần vì UNION có 2 query
    if (!empty($placement_params)) {
        // For UNION query with search: public query needs params, registered query needs id + params
        // Total params: placement_params (for public) + id_hocvien + placement_params (for registered)
        $all_params = array_merge($placement_params, [$hocvien_id], $placement_params);
        $all_types = $placement_types . "i" . $placement_types;
        $stmt_placement->bind_param($all_types, ...$all_params);
    } else {
        // No search params, only need id_hocvien for registered query
        $stmt_placement->bind_param("i", $hocvien_id);
    }
    
    $stmt_placement->execute();
    $result_placement = $stmt_placement->get_result();
    
    while ($row = $result_placement->fetch_assoc()) {
        $placement_tests[] = $row;
    }
    $total_placement_tests = count($placement_tests);
    $stmt_placement->close();
} catch (Exception $e) {
    error_log("Lỗi khi lấy bài test đầu vào: " . $e->getMessage());
}

// Lấy bài test đầu vào ĐẦU TIÊN để hiển thị CTA (nếu chưa có trình độ)
$placement_test = !empty($placement_tests) ? $placement_tests[0] : null;

// 3. Lấy các bài test ĐỊNH KỲ từ khóa học/lớp học đã đăng ký (với tìm kiếm và lọc)
$periodic_tests = [];
$total_periodic_tests = 0;

// Lấy tham số tìm kiếm và lọc cho periodic tests
$periodic_search = isset($_GET['periodic_search']) ? trim($_GET['periodic_search']) : '';
$periodic_filter_time = isset($_GET['periodic_filter_time']) ? $_GET['periodic_filter_time'] : '';
$periodic_sort = isset($_GET['periodic_sort']) ? $_GET['periodic_sort'] : 'newest';

try {
    // Xây dựng điều kiện WHERE
    $periodic_where = [];
    $periodic_params = [$hocvien_id];
    $periodic_types = "i";
    
    // Tìm kiếm theo tên
    if (!empty($periodic_search)) {
        $periodic_where[] = "bt.ten_baitest LIKE ?";
        $periodic_params[] = "%{$periodic_search}%";
        $periodic_types .= "s";
    }
    
    // Lọc theo thời gian
    if (!empty($periodic_filter_time)) {
        if ($periodic_filter_time === 'short') {
            $periodic_where[] = "bt.thoi_gian <= 20";
        } elseif ($periodic_filter_time === 'medium') {
            $periodic_where[] = "bt.thoi_gian > 20 AND bt.thoi_gian <= 40";
        } elseif ($periodic_filter_time === 'long') {
            $periodic_where[] = "bt.thoi_gian > 40";
        }
    }
    
    $periodic_where_clause = !empty($periodic_where) ? 'AND ' . implode(' AND ', $periodic_where) : '';
    
    // Sắp xếp
    $periodic_order = "bt.ngay_tao DESC, bt.ten_baitest ASC";
    switch ($periodic_sort) {
        case 'name_asc': $periodic_order = "bt.ten_baitest ASC"; break;
        case 'name_desc': $periodic_order = "bt.ten_baitest DESC"; break;
        case 'time_asc': $periodic_order = "bt.thoi_gian ASC"; break;
        case 'time_desc': $periodic_order = "bt.thoi_gian DESC"; break;
        case 'oldest': $periodic_order = "bt.ngay_tao ASC"; break;
    }
    
    $sql_periodic_tests = "
        SELECT DISTINCT bt.*
        FROM baitest bt
        JOIN dangkykhoahoc dk ON (
            (bt.id_khoahoc = dk.id_khoahoc AND bt.id_lop IS NULL) OR 
            (bt.id_lop = dk.id_lop AND bt.id_lop IS NOT NULL)
        )
        WHERE dk.id_hocvien = ? 
        AND dk.trang_thai = 'da xac nhan' 
        AND bt.loai_baitest = 'dinh_ky'
        {$periodic_where_clause}
        ORDER BY {$periodic_order}
    ";
    
    $stmt_periodic = $conn->prepare($sql_periodic_tests);
    $stmt_periodic->bind_param($periodic_types, ...$periodic_params);
    $stmt_periodic->execute();
    $result_periodic = $stmt_periodic->get_result();
    while ($row = $result_periodic->fetch_assoc()) {
        $periodic_tests[] = $row;
    }
    $total_periodic_tests = count($periodic_tests);
    $stmt_periodic->close();
} catch (Exception $e) {
    error_log("Lỗi khi lấy bài test định kỳ: " . $e->getMessage());
}

// 4. Lấy các bài test ÔN TẬP từ khóa học/lớp học đã đăng ký
$course_tests = [];
try {
    $sql_course_tests = "
        SELECT DISTINCT bt.*
        FROM baitest bt
        JOIN dangkykhoahoc dk ON (
            (bt.id_khoahoc = dk.id_khoahoc AND bt.id_lop IS NULL) OR 
            (bt.id_lop = dk.id_lop AND bt.id_lop IS NOT NULL)
        )
        WHERE dk.id_hocvien = ? 
        AND dk.trang_thai = 'da xac nhan' 
        AND bt.loai_baitest = 'on_tap'
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
    error_log("Lỗi khi lấy bài test ôn tập khóa học: " . $e->getMessage());
}

// 5. Lấy các bài test ôn tập CÔNG KHAI (không thuộc khóa học hoặc lớp cụ thể) với phân trang, tìm kiếm và lọc
$practice_tests = [];
$total_practice_tests = 0;
$total_practice_pages = 1;
$practice_current_page = 1;

// Lấy tham số tìm kiếm và lọc
$search_keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_time = isset($_GET['filter_time']) ? $_GET['filter_time'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name_asc';

try {
    // Pagination settings
    $tests_per_page = 9; // Số bài test ôn tập mỗi trang
    $practice_current_page = isset($_GET['test_page']) ? max(1, intval($_GET['test_page'])) : 1;
    $offset = ($practice_current_page - 1) * $tests_per_page;

    // Xây dựng câu truy vấn với điều kiện tìm kiếm và lọc
    // CHỈ LẤY BÀI TEST CÔNG KHAI: loai_baitest = 'on_tap' VÀ không thuộc khóa học/lớp cụ thể
    $where_conditions = ["loai_baitest = 'on_tap'", "id_khoahoc IS NULL", "id_lop IS NULL"];
    $params = [];
    $param_types = "";

    // Tìm kiếm theo tên
    if (!empty($search_keyword)) {
        $where_conditions[] = "ten_baitest LIKE ?";
        $params[] = "%{$search_keyword}%";
        $param_types .= "s";
    }

    // Lọc theo thời gian
    if (!empty($filter_time)) {
        if ($filter_time === 'short') {
            $where_conditions[] = "thoi_gian <= 20";
        } elseif ($filter_time === 'medium') {
            $where_conditions[] = "thoi_gian > 20 AND thoi_gian <= 40";
        } elseif ($filter_time === 'long') {
            $where_conditions[] = "thoi_gian > 40";
        }
    }

    $where_clause = implode(" AND ", $where_conditions);

    // Sắp xếp
    $order_by = "ten_baitest ASC"; // Mặc định
    switch ($sort_by) {
        case 'name_asc':
            $order_by = "ten_baitest ASC";
            break;
        case 'name_desc':
            $order_by = "ten_baitest DESC";
            break;
        case 'time_asc':
            $order_by = "thoi_gian ASC";
            break;
        case 'time_desc':
            $order_by = "thoi_gian DESC";
            break;
        case 'newest':
            $order_by = "ngay_tao DESC";
            break;
        case 'oldest':
            $order_by = "ngay_tao ASC";
            break;
    }

    // Count total practice tests với điều kiện
    $count_sql = "SELECT COUNT(*) as total FROM baitest WHERE {$where_clause}";
    if (!empty($params)) {
        $stmt_count = $conn->prepare($count_sql);
        if (!empty($param_types)) {
            $stmt_count->bind_param($param_types, ...$params);
        }
        $stmt_count->execute();
        $count_result = $stmt_count->get_result();
        if ($count_row = $count_result->fetch_assoc()) {
            $total_practice_tests = $count_row['total'];
        }
        $stmt_count->close();
    } else {
        $count_result = $conn->query($count_sql);
        if ($count_result) {
            $count_row = $count_result->fetch_assoc();
            $total_practice_tests = $count_row['total'];
        }
    }
    
    $total_practice_pages = ceil($total_practice_tests / $tests_per_page);

    // Fetch practice tests với điều kiện
    $sql_practice = "SELECT * FROM baitest WHERE {$where_clause} ORDER BY {$order_by} LIMIT ? OFFSET ?";
    $stmt_practice = $conn->prepare($sql_practice);
    
    // Bind parameters
    $params[] = $tests_per_page;
    $params[] = $offset;
    $param_types .= "ii";
    
    $stmt_practice->bind_param($param_types, ...$params);
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

    /* --- Search and Filter Styles --- */
    .search-filter-container {
        background: var(--neutral-white);
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
    }

    .search-filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    .form-group-search {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group-search label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-group-search label i {
        color: var(--brand-color);
        font-size: 16px;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--neutral-gray);
        font-size: 16px;
    }

    .search-input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: var(--neutral-white);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--brand-color);
        box-shadow: 0 0 0 3px rgba(13, 179, 59, 0.1);
    }

    .filter-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 15px;
        background: var(--neutral-white);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--brand-color);
        box-shadow: 0 0 0 3px rgba(13, 179, 59, 0.1);
    }

    .search-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-search,
    .btn-reset {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-search {
        background: var(--brand-color);
        color: var(--neutral-white);
    }

    .btn-search:hover {
        background: var(--brand-color-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 179, 59, 0.3);
    }

    .btn-reset {
        background: var(--neutral-light);
        color: var(--neutral-gray);
        border: 2px solid var(--border-color);
    }

    .btn-reset:hover {
        background: #e9ecef;
        border-color: var(--neutral-gray);
        transform: translateY(-2px);
    }

    .active-filters {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .active-filters-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--neutral-gray);
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: var(--brand-color);
        color: var(--neutral-white);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .filter-badge i {
        font-size: 12px;
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: var(--neutral-white);
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
    }

    .no-results i {
        font-size: 64px;
        color: var(--neutral-gray);
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .no-results h3 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .no-results p {
        font-size: 16px;
        color: var(--neutral-gray);
    }

    /* Responsive Search Filter */
    @media (max-width: 991px) {
        .search-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .form-group-search:first-child {
            grid-column: 1 / -1;
        }

        .search-buttons {
            grid-column: 1 / -1;
            justify-content: flex-end;
        }
    }

    @media (max-width: 576px) {
        .search-filter-form {
            grid-template-columns: 1fr;
        }

        .search-buttons {
            flex-direction: column;
        }

        .btn-search,
        .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .active-filters {
            justify-content: center;
        }
    }
</style>

<div class="tests-container-v2">
    <!-- Tab Navigation -->
    <div class="test-tabs-navigation" data-aos="fade-down">
        <button class="test-tab-btn active" data-tab="placement" onclick="switchTab('placement')">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Bài kiểm tra đầu vào</span>
            <span class="tab-badge"><?php echo count($placement_tests); ?></span>
        </button>
        <button class="test-tab-btn" data-tab="periodic" onclick="switchTab('periodic')">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Kiểm tra định kỳ</span>
            <span class="tab-badge"><?php echo count($periodic_tests); ?></span>
        </button>
        <button class="test-tab-btn" data-tab="practice" onclick="switchTab('practice')">
            <i class="fa-solid fa-book-open"></i>
            <span>Ôn tập công khai</span>
            <span class="tab-badge"><?php echo $total_practice_tests; ?></span>
        </button>
    </div>

    <!-- Tab Content: Placement Tests -->
    <div class="test-tab-content active" id="placement-tab" data-aos="fade-up">
        <div class="tab-header">
            <h2 class="tab-title">
                <i class="fa-solid fa-clipboard-check"></i> Bài kiểm tra đầu vào
            </h2>
            <p class="tab-description">Kiểm tra trình độ hiện tại của bạn để được phân loại vào lớp phù hợp</p>
        </div>
        
        <!-- Search and Filter Section for Placement Tests -->
        <div class="search-filter-container" data-aos="fade-up">
            <form method="GET" action="index.php" class="search-filter-form">
                <input type="hidden" name="nav" value="question">
                <input type="hidden" name="active_tab" value="placement">
                
                <!-- Search Input -->
                <div class="form-group-search">
                    <label for="placement_search">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" id="placement_search" name="placement_search" 
                               class="search-input" placeholder="Nhập tên bài test..." 
                               value="<?php echo htmlspecialchars($placement_search); ?>">
                    </div>
                </div>

                <!-- Time Filter -->
                <div class="form-group-search">
                    <label for="placement_filter_time">
                        <i class="fas fa-clock"></i>
                        Thời gian
                    </label>
                    <select id="placement_filter_time" name="placement_filter_time" class="filter-select">
                        <option value="">Tất cả</option>
                        <option value="short" <?php echo $placement_filter_time === 'short' ? 'selected' : ''; ?>>Ngắn (≤ 20 phút)</option>
                        <option value="medium" <?php echo $placement_filter_time === 'medium' ? 'selected' : ''; ?>>Trung bình (20-40 phút)</option>
                        <option value="long" <?php echo $placement_filter_time === 'long' ? 'selected' : ''; ?>>Dài (> 40 phút)</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="form-group-search">
                    <label for="placement_sort">
                        <i class="fas fa-sort"></i>
                        Sắp xếp
                    </label>
                    <select id="placement_sort" name="placement_sort" class="filter-select">
                        <option value="name_asc" <?php echo $placement_sort === 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                        <option value="name_desc" <?php echo $placement_sort === 'name_desc' ? 'selected' : ''; ?>>Tên Z-A</option>
                        <option value="time_asc" <?php echo $placement_sort === 'time_asc' ? 'selected' : ''; ?>>Thời gian tăng dần</option>
                        <option value="time_desc" <?php echo $placement_sort === 'time_desc' ? 'selected' : ''; ?>>Thời gian giảm dần</option>
                        <option value="newest" <?php echo $placement_sort === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="oldest" <?php echo $placement_sort === 'oldest' ? 'selected' : ''; ?>>Cũ nhất</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="search-buttons">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                    <a href="index.php?nav=question&active_tab=placement" class="btn-reset">
                        <i class="fas fa-rotate-right"></i>
                        Đặt lại
                    </a>
                </div>
            </form>

            <!-- Active Filters Display -->
            <?php if (!empty($placement_search) || !empty($placement_filter_time) || $placement_sort !== 'name_asc'): ?>
                <div class="active-filters">
                    <span class="active-filters-label">
                        <i class="fas fa-filter"></i>
                        Bộ lọc đang áp dụng:
                    </span>
                    <?php if (!empty($placement_search)): ?>
                        <span class="filter-badge">
                            <i class="fas fa-search"></i>
                            "<?php echo htmlspecialchars($placement_search); ?>"
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($placement_filter_time)): ?>
                        <span class="filter-badge">
                            <i class="fas fa-clock"></i>
                            <?php 
                            echo $placement_filter_time === 'short' ? 'Ngắn (≤20p)' : 
                                ($placement_filter_time === 'medium' ? 'Trung bình (20-40p)' : 'Dài (>40p)'); 
                            ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($placement_sort !== 'name_asc'): ?>
                        <span class="filter-badge">
                            <i class="fas fa-sort"></i>
                            <?php 
                            $sort_labels = [
                                'name_desc' => 'Tên Z-A',
                                'time_asc' => 'Thời gian tăng',
                                'time_desc' => 'Thời gian giảm',
                                'newest' => 'Mới nhất',
                                'oldest' => 'Cũ nhất'
                            ];
                            echo $sort_labels[$placement_sort] ?? '';
                            ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($placement_tests)): ?>
            <div class="tests-grid">
                <?php
                $delay = 0;
                foreach ($placement_tests as $test) {
                    render_test_card_v2($test, $conn, $delay);
                    $delay += 100;
                }
                ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <i class="fa-solid fa-inbox"></i>
                <h3>Không tìm thấy bài test nào</h3>
                <p>Vui lòng thử lại với từ khóa hoặc bộ lọc khác</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tab Content: Periodic Tests -->
    <div class="test-tab-content" id="periodic-tab">
        <div class="tab-header">
            <h2 class="tab-title">
                <i class="fa-solid fa-calendar-check"></i> Bài kiểm tra định kỳ
            </h2>
            <p class="tab-description">Các bài kiểm tra định kỳ từ khóa học và lớp học bạn đã đăng ký</p>
        </div>
        
        <!-- Search and Filter Section for Periodic Tests -->
        <div class="search-filter-container" data-aos="fade-up">
            <form method="GET" action="index.php" class="search-filter-form">
                <input type="hidden" name="nav" value="question">
                <input type="hidden" name="active_tab" value="periodic">
                
                <!-- Search Input -->
                <div class="form-group-search">
                    <label for="periodic_search">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-magnifying-glass"></i>
                        <input type="text" id="periodic_search" name="periodic_search" 
                               class="search-input" placeholder="Nhập tên bài test..." 
                               value="<?php echo htmlspecialchars($periodic_search); ?>">
                    </div>
                </div>

                <!-- Time Filter -->
                <div class="form-group-search">
                    <label for="periodic_filter_time">
                        <i class="fas fa-clock"></i>
                        Thời gian
                    </label>
                    <select id="periodic_filter_time" name="periodic_filter_time" class="filter-select">
                        <option value="">Tất cả</option>
                        <option value="short" <?php echo $periodic_filter_time === 'short' ? 'selected' : ''; ?>>Ngắn (≤ 20 phút)</option>
                        <option value="medium" <?php echo $periodic_filter_time === 'medium' ? 'selected' : ''; ?>>Trung bình (20-40 phút)</option>
                        <option value="long" <?php echo $periodic_filter_time === 'long' ? 'selected' : ''; ?>>Dài (> 40 phút)</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="form-group-search">
                    <label for="periodic_sort">
                        <i class="fas fa-sort"></i>
                        Sắp xếp
                    </label>
                    <select id="periodic_sort" name="periodic_sort" class="filter-select">
                        <option value="newest" <?php echo $periodic_sort === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="oldest" <?php echo $periodic_sort === 'oldest' ? 'selected' : ''; ?>>Cũ nhất</option>
                        <option value="name_asc" <?php echo $periodic_sort === 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                        <option value="name_desc" <?php echo $periodic_sort === 'name_desc' ? 'selected' : ''; ?>>Tên Z-A</option>
                        <option value="time_asc" <?php echo $periodic_sort === 'time_asc' ? 'selected' : ''; ?>>Thời gian tăng dần</option>
                        <option value="time_desc" <?php echo $periodic_sort === 'time_desc' ? 'selected' : ''; ?>>Thời gian giảm dần</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="search-buttons">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                    <a href="index.php?nav=question&active_tab=periodic" class="btn-reset">
                        <i class="fas fa-rotate-right"></i>
                        Đặt lại
                    </a>
                </div>
            </form>

            <!-- Active Filters Display -->
            <?php if (!empty($periodic_search) || !empty($periodic_filter_time) || $periodic_sort !== 'newest'): ?>
                <div class="active-filters">
                    <span class="active-filters-label">
                        <i class="fas fa-filter"></i>
                        Bộ lọc đang áp dụng:
                    </span>
                    <?php if (!empty($periodic_search)): ?>
                        <span class="filter-badge">
                            <i class="fas fa-search"></i>
                            "<?php echo htmlspecialchars($periodic_search); ?>"
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($periodic_filter_time)): ?>
                        <span class="filter-badge">
                            <i class="fas fa-clock"></i>
                            <?php 
                            echo $periodic_filter_time === 'short' ? 'Ngắn (≤20p)' : 
                                ($periodic_filter_time === 'medium' ? 'Trung bình (20-40p)' : 'Dài (>40p)'); 
                            ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($periodic_sort !== 'newest'): ?>
                        <span class="filter-badge">
                            <i class="fas fa-sort"></i>
                            <?php 
                            $sort_labels = [
                                'oldest' => 'Cũ nhất',
                                'name_asc' => 'Tên A-Z',
                                'name_desc' => 'Tên Z-A',
                                'time_asc' => 'Thời gian tăng',
                                'time_desc' => 'Thời gian giảm'
                            ];
                            echo $sort_labels[$periodic_sort] ?? '';
                            ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($periodic_tests)): ?>
            <div class="tests-grid">
                <?php
                $delay = 0;
                foreach ($periodic_tests as $test) {
                    render_test_card_v2($test, $conn, $delay);
                    $delay += 100;
                }
                ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <i class="fa-solid fa-inbox"></i>
                <h3>Không tìm thấy bài test nào</h3>
                <p>Vui lòng thử lại với từ khóa hoặc bộ lọc khác</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tab Content: Practice Tests (Public) -->
    <div class="test-tab-content" id="practice-tab">
        <div class="tab-header">
            <h2 class="tab-title">
                <i class="fa-solid fa-book-open"></i> Bài ôn tập 
            </h2>
            <p class="tab-description">Tự do luyện tập với các bài tập ôn tập</p>
        </div>
        
        <!-- Search and Filter Section -->
        <div class="search-filter-container" data-aos="fade-up">
            <form method="GET" action="index.php" class="search-filter-form">
                <input type="hidden" name="nav" value="question">
                <input type="hidden" name="active_tab" value="practice">
            
            <!-- Search Input -->
            <div class="form-group-search">
                <label for="search">
                    <i class="fas fa-search"></i>
                    Tìm kiếm bài test
                </label>
                <div class="search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        class="search-input" 
                        placeholder="Nhập tên bài test..." 
                        value="<?php echo htmlspecialchars($search_keyword); ?>"
                    >
                </div>
            </div>

            <!-- Time Filter -->
            <div class="form-group-search">
                <label for="filter_time">
                    <i class="fas fa-clock"></i>
                    Thời gian
                </label>
                <select id="filter_time" name="filter_time" class="filter-select">
                    <option value="">Tất cả</option>
                    <option value="short" <?php echo $filter_time === 'short' ? 'selected' : ''; ?>>Ngắn (≤ 20 phút)</option>
                    <option value="medium" <?php echo $filter_time === 'medium' ? 'selected' : ''; ?>>Trung bình (20-40 phút)</option>
                    <option value="long" <?php echo $filter_time === 'long' ? 'selected' : ''; ?>>Dài (> 40 phút)</option>
                </select>
            </div>

            <!-- Sort By -->
            <div class="form-group-search">
                <label for="sort_by">
                    <i class="fas fa-sort"></i>
                    Sắp xếp
                </label>
                <select id="sort_by" name="sort_by" class="filter-select">
                    <option value="name_asc" <?php echo $sort_by === 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                    <option value="name_desc" <?php echo $sort_by === 'name_desc' ? 'selected' : ''; ?>>Tên Z-A</option>
                    <option value="time_asc" <?php echo $sort_by === 'time_asc' ? 'selected' : ''; ?>>Thời gian tăng dần</option>
                    <option value="time_desc" <?php echo $sort_by === 'time_desc' ? 'selected' : ''; ?>>Thời gian giảm dần</option>
                    <option value="newest" <?php echo $sort_by === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                    <option value="oldest" <?php echo $sort_by === 'oldest' ? 'selected' : ''; ?>>Cũ nhất</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="search-buttons">
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i>
                    Tìm kiếm
                </button>
                <a href="index.php?nav=question" class="btn-reset">
                    <i class="fas fa-rotate-right"></i>
                    Đặt lại
                </a>
            </div>
        </form>

        <!-- Active Filters Display -->
        <?php if (!empty($search_keyword) || !empty($filter_time) || $sort_by !== 'name_asc'): ?>
            <div class="active-filters">
                <span class="active-filters-label">
                    <i class="fas fa-filter"></i>
                    Bộ lọc đang áp dụng:
                </span>
                
                <?php if (!empty($search_keyword)): ?>
                    <span class="filter-badge">
                        <i class="fas fa-search"></i>
                        "<?php echo htmlspecialchars($search_keyword); ?>"
                    </span>
                <?php endif; ?>
                
                <?php if (!empty($filter_time)): ?>
                    <span class="filter-badge">
                        <i class="fas fa-clock"></i>
                        <?php 
                            $time_labels = [
                                'short' => 'Ngắn (≤ 20 phút)',
                                'medium' => 'Trung bình (20-40 phút)',
                                'long' => 'Dài (> 40 phút)'
                            ];
                            echo $time_labels[$filter_time] ?? $filter_time;
                        ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($sort_by !== 'name_asc'): ?>
                    <span class="filter-badge">
                        <i class="fas fa-sort"></i>
                        <?php 
                            $sort_labels = [
                                'name_desc' => 'Tên Z-A',
                                'time_asc' => 'Thời gian tăng dần',
                                'time_desc' => 'Thời gian giảm dần',
                                'newest' => 'Mới nhất',
                                'oldest' => 'Cũ nhất'
                            ];
                            echo $sort_labels[$sort_by] ?? 'Tên A-Z';
                        ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Course Practice Tests Section -->
    <?php if (!empty($course_tests)): ?>
        <div class="course-tests-section" data-aos="fade-up">
            <h3 class="subsection-title">
                <i class="fa-solid fa-graduation-cap"></i> Bài ôn tập từ khóa học đã đăng ký
            </h3>
            <div class="tests-grid">
                <?php
                $delay = 0;
                foreach ($course_tests as $test) {
                    render_test_card_v2($test, $conn, $delay);
                    $delay += 100;
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Public Practice Tests Section -->
    <div class="public-tests-section">
        <h3 class="subsection-title">
            <i class="fa-solid fa-earth-americas"></i> Bài tập ôn tập
        </h3>
        
        <div class="tests-grid">
            <?php
            if (!empty($practice_tests)) {
                $delay = 0;
                foreach ($practice_tests as $test) {
                    render_test_card_v2($test, $conn, $delay);
                    $delay += 100;
                }
            } else {
                echo '<div class="no-results" style="grid-column: 1 / -1;">
                        <i class="fas fa-search"></i>
                        <h3>Không tìm thấy bài test nào</h3>
                        <p>Vui lòng thử lại với từ khóa hoặc bộ lọc khác</p>
                      </div>';
            }
            ?>
        </div>

        <!-- Pagination for Practice Tests -->
        <?php if ($total_practice_pages > 1): ?>
            <?php
            // Build query string for pagination
            $pagination_params = [
                'nav' => 'question',
                'active_tab' => 'practice'
            ];
            if (!empty($search_keyword)) {
                $pagination_params['search'] = $search_keyword;
            }
            if (!empty($filter_time)) {
                $pagination_params['filter_time'] = $filter_time;
            }
            if ($sort_by !== 'name_asc') {
                $pagination_params['sort_by'] = $sort_by;
            }
            
            function build_pagination_url($params, $page) {
                $params['test_page'] = $page;
                return 'index.php?' . http_build_query($params) . '#practice-tab';
            }
            ?>
        <div class="question-pagination-container" data-aos="fade-up">
            <div class="question-pagination">
                <?php
                // Previous button
                if ($practice_current_page > 1):
                    $prev_page = $practice_current_page - 1;
                ?>
                    <a href="<?php echo build_pagination_url($pagination_params, $prev_page); ?>" class="question-pagination-btn question-pagination-prev">
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
                        <a href="<?php echo build_pagination_url($pagination_params, 1); ?>" class="question-pagination-number">1</a>
                        <?php if ($start > 2): ?>
                            <span class="question-pagination-dots">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <a href="<?php echo build_pagination_url($pagination_params, $i); ?>"
                            class="question-pagination-number <?php echo $i == $practice_current_page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Last page -->
                    <?php if ($end < $total_practice_pages): ?>
                        <?php if ($end < $total_practice_pages - 1): ?>
                            <span class="question-pagination-dots">...</span>
                        <?php endif; ?>
                        <a href="<?php echo build_pagination_url($pagination_params, $total_practice_pages); ?>" class="question-pagination-number"><?php echo $total_practice_pages; ?></a>
                    <?php endif; ?>
                </div>

                <!-- Next button -->
                <?php
                if ($practice_current_page < $total_practice_pages):
                    $next_page = $practice_current_page + 1;
                ?>
                    <a href="<?php echo build_pagination_url($pagination_params, $next_page); ?>" class="question-pagination-btn question-pagination-next">
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
    </div> <!-- End public-tests-section -->

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
    </div> <!-- End practice-tab -->

</div> <!-- End tests-container-v2 -->

<script>
// Tab switching functionality
function switchTab(tabName) {
    // Update URL with active tab
    const url = new URL(window.location);
    url.searchParams.set('active_tab', tabName);
    window.history.pushState({}, '', url);
    
    // Hide all tab contents
    document.querySelectorAll('.test-tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.test-tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    
    // Scroll to top of tabs
    document.querySelector('.test-tabs-navigation').scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start' 
    });
}

// Initialize tab from URL parameter on page load
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('active_tab') || 'placement';
    switchTab(activeTab);
});
</script>

<style>
/* Tab Navigation Styles */
.test-tabs-navigation {
    display: flex;
    gap: 15px;
    margin-bottom: 40px;
    background: var(--neutral-white);
    padding: 20px;
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    border: 1px solid var(--border-color);
    overflow-x: auto;
    scroll-behavior: smooth;
}

.test-tab-btn {
    flex: 1;
    min-width: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 18px 25px;
    background: var(--neutral-light);
    border: 2px solid transparent;
    border-radius: 12px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    color: var(--neutral-gray);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.test-tab-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(13, 179, 59, 0.1), transparent);
    transition: left 0.5s ease;
}

.test-tab-btn:hover::before {
    left: 100%;
}

.test-tab-btn:hover {
    background: rgba(13, 179, 59, 0.05);
    border-color: var(--brand-color);
    color: var(--brand-color);
    transform: translateY(-2px);
}

.test-tab-btn.active {
    background: linear-gradient(135deg, var(--brand-color), var(--brand-color-dark));
    color: var(--neutral-white);
    border-color: var(--brand-color);
    box-shadow: 0 8px 20px rgba(13, 179, 59, 0.3);
    transform: translateY(-3px);
}

.test-tab-btn i {
    font-size: 20px;
    transition: transform 0.3s ease;
}

.test-tab-btn.active i {
    transform: scale(1.1);
}

.test-tab-btn span:not(.tab-badge) {
    display: inline-block;
}

.tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    padding: 0 8px;
    background: rgba(255, 255, 255, 0.3);
    color: var(--neutral-gray);
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.test-tab-btn.active .tab-badge {
    background: rgba(255, 255, 255, 0.25);
    color: var(--neutral-white);
}

/* Tab Content Styles */
.test-tab-content {
    display: none;
    animation: fadeIn 0.5s ease;
}

.test-tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.tab-header {
    text-align: center;
    margin-bottom: 40px;
}

.tab-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.tab-title i {
    color: var(--brand-color);
    font-size: 36px;
}

.tab-description {
    font-size: 16px;
    color: var(--neutral-gray);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Subsection Title */
.subsection-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 40px 0 25px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 12px;
}

.subsection-title i {
    color: var(--brand-color);
    font-size: 24px;
}

.course-tests-section {
    margin-bottom: 50px;
}

.public-tests-section {
    margin-top: 30px;
}

/* Responsive Tab Navigation */
@media (max-width: 991px) {
    .test-tabs-navigation {
        gap: 10px;
        padding: 15px;
    }
    
    .test-tab-btn {
        min-width: 160px;
        padding: 15px 20px;
        font-size: 15px;
    }
    
    .test-tab-btn i {
        font-size: 18px;
    }
    
    .tab-title {
        font-size: 28px;
    }
}

@media (max-width: 767px) {
    .test-tabs-navigation {
        flex-direction: column;
        gap: 12px;
    }
    
    .test-tab-btn {
        min-width: 100%;
        justify-content: flex-start;
    }
    
    .test-tab-btn span:not(.tab-badge) {
        flex: 1;
        text-align: left;
    }
    
    .tab-title {
        font-size: 24px;
        flex-direction: column;
        gap: 10px;
    }
    
    .tab-description {
        font-size: 15px;
    }
    
    .subsection-title {
        font-size: 20px;
        flex-wrap: wrap;
    }
}
</style>