<?php
// File: pages/question/question.php
if (session_status() == PHP_SESSION_NONE) session_start();

$hocvien_id = $_SESSION['id_hocvien'] ?? null;
$trinh_do_hocvien = null;

if (!$hocvien_id) {
    echo "<script>alert('Vui lòng đăng nhập để làm bài kiểm tra!'); window.location.href='./pages/login.php';</script>";
    exit;
}

// --- Lấy thông tin học viên và các bài test ---

// 1. Lấy thông tin và trình độ của học viên
$stmt_hocvien = $conn->prepare("SELECT trinh_do FROM hocvien WHERE id_hocvien = ?");
$stmt_hocvien->bind_param("i", $hocvien_id);
$stmt_hocvien->execute();
$result_hocvien = $stmt_hocvien->get_result();
$hocvien_data = $result_hocvien->fetch_assoc();
$trinh_do_hocvien = $hocvien_data['trinh_do'];
$stmt_hocvien->close();

// 2. Lấy bài test đầu vào (nếu có)
$placement_test = $conn->query("SELECT * FROM baitest WHERE loai_baitest = 'dau_vao' LIMIT 1")->fetch_assoc();


// 3. Lấy các bài test định kỳ của các khóa học VÀ CÁC LỚP HỌC đã đăng ký
$sql_course_tests = "
    SELECT DISTINCT bt.* FROM baitest bt
    JOIN dangkykhoahoc dk ON (bt.id_khoahoc = dk.id_khoahoc OR bt.id_lop = dk.id_lop)
    WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan' AND bt.loai_baitest = 'dinh_ky'
";
$stmt_course_tests = $conn->prepare($sql_course_tests);
$stmt_course_tests->bind_param("i", $hocvien_id);
$stmt_course_tests->execute();
$course_tests = $stmt_course_tests->get_result();

// 4. Lấy các bài test ôn tập công khai
$practice_tests = $conn->query("SELECT * FROM baitest WHERE loai_baitest = 'on_tap'");

// Hàm trợ giúp để render card bài test
function render_test_card($test, $conn)
{
    if (!$test) return;
    $sql_count = "SELECT COUNT(*) as total FROM cauhoi WHERE id_baitest = ?";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param("i", $test['id_baitest']);
    $stmt_count->execute();
    $total_questions = $stmt_count->get_result()->fetch_assoc()['total'] ?? 0;

    echo '
        <div class="card">
            <h3>' . htmlspecialchars($test['ten_baitest']) . '</h3>
            <div class="card-item"><i class="fa-solid fa-book" style="color: #219900;"></i><p>' . $total_questions . ' câu hỏi</p></div>
            <div class="card-item"><i class="fa-solid fa-clock-rotate-left" style="color: #ffd500;"></i><p>' . $test['thoi_gian'] . ' phút</p></div>
            <a class="submit-btn" href="index.php?nav=question_detail&id_baitest=' . $test['id_baitest'] . '">Bắt đầu</a>
        </div>
    ';
}
?>
<link rel="stylesheet" href="pages/question/style.css">

<div class="banner-tests">
    <img src="https://hocthatnhanh.vn/storage/tracnghiem/chung-chi-hanh-nghe-hoat-dong-xay-dung-htn.jpg" alt="banner">
</div>

<section class="tests-container">
    <?php if ($placement_test && !$trinh_do_hocvien): ?>
        <div class="placement-test-cta">
            <h2>Kiểm tra trình độ của bạn!</h2>
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab active">Elementary A1</div>
                <div class="tab">Pre-Intermediate A2</div>
                <div class="tab">Intermediate B1</div>
                <div class="tab">Upper-Intermediate B2</div>
                <div class="tab">Advanced C1</div>
                <div class="tab">Proficient C2</div>
            </div>

            <p>Làm bài kiểm tra đầu vào miễn phí để hệ thống xác định trình độ và gợi ý cho bạn những khóa học phù hợp nhất.</p>
            <a href="index.php?nav=question_detail&id_baitest=<?php echo $placement_test['id_baitest']; ?>" class="cta-button">Làm bài ngay</a>
        </div>
    <?php endif; ?>

    <?php if ($course_tests->num_rows > 0): ?>
        <h1 class="introduce-title">Bài kiểm tra của khóa học</h1>
        <div class="cards">
            <?php while ($test = $course_tests->fetch_assoc()) {
                render_test_card($test, $conn);
            } ?>
        </div>
    <?php endif; ?>

    <h1 class="introduce-title">Bài ôn tập tự do</h1>
    <div class="cards">
        <?php while ($test = $practice_tests->fetch_assoc()) {
            render_test_card($test, $conn);
        } ?>
    </div>

    <div class="ready-section">
        <div class="ready-content">
            <h2>Sẵn sàng cho kỳ thi!</h2>
            <p>Nền tảng học tập của chúng tôi sẽ giúp bạn xây dựng một nền tảng kiến thức tiếng Anh vững chắc để chuẩn bị tốt cho các bài kiểm tra.</p>
        </div>
        <div class="exam-buttons">
            <button>TOEIC</button>
            <button>IELTS</button>
            <button>TOEFL</button>
        </div>
    </div>

</section>

<style>


    .tabs {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        gap: 10px;
    }

    .tab {
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        background-color: #f1f1f1;
        font-size: 14px;
        color: #333;
        transition: all 0.3s ease;
    }

    .tab:hover {
        background-color: #ff704d;
    }

    .tab.active {
        background-color: #ff704d;
        color: #fff;
    }


    .ready-section {
        display: flex;
        padding: 30px 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px #444;
        margin: 30px;
        gap: 40px;
        align-items: center;
    }

    .ready-content {
        width: 600px;
        margin-left: 50px;
    }

    .ready-content h2 {
        color: #0db33b;
    }

    .exam-buttons {
        margin-top: 10px;
    }

    .exam-buttons button {
        margin: 5px;
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        color: #fff;
        background-color: #007bff;
        transition: all 0.3s ease;
    }

    .exam-buttons button:nth-child(2) {
        background-color: #ff704d;
    }

    .exam-buttons button:nth-child(3) {
        background-color: #00c58e;
    }

    .exam-buttons button:hover {
        opacity: 0.8;
    }


    /* File: pages/question/style.css */
    .tests-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
    }

    .banner-tests img {
        height: 350px;
        width: 100%;
        object-fit: cover;
    }

    .placement-test-cta {
        background: linear-gradient(135deg, #0db33b, #28a745);
        color: #fff;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(13, 179, 59, 0.3);
    }

    .placement-test-cta h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .placement-test-cta p {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 25px;
    }

    .cta-button {
        background-color: #fff;
        color: #0db33b;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        background-color: #f0f0f0;
        transform: translateY(-3px);
    }

    .introduce-title {
        text-align: center;
        position: relative;
        padding-bottom: 15px;
        margin: 40px 0 30px;
        color: #333;
    }

    .introduce-title:after {
        content: "";
        background: #0db33b;
        bottom: 0;
        display: block;
        height: 3px;
        left: 50%;
        transform: translateX(-50%);
        position: absolute;
        width: 70px;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 25px;
        text-align: left;
        border-top: 5px solid;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .card:nth-child(3n+1) {
        border-top-color: #00c58e;
    }

    .card:nth-child(3n+2) {
        border-top-color: #007bff;
    }

    .card:nth-child(3n) {
        border-top-color: #ff6bcb;
    }

    .card h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
        min-height: 44px;
    }

    .card-item {
        display: flex;
        gap: 12px;
        align-items: center;
        font-size: 15px;
        margin-bottom: 10px;
        color: #555;
    }

    .card-item i {
        width: 20px;
        text-align: center;
    }

    .card-item p {
        margin: 0;
    }

    .submit-btn {
        display: block;
        padding: 10px 20px;
        background-color: #129e24ff;
        font-size: 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 15px;
        color: white;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #5a6268;
    }
</style>