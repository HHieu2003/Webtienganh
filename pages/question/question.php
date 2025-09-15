<?php
include('./config/config.php');


// Kiểm tra nếu học viên đã đăng nhập
if (!isset($_SESSION['id_hocvien'])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='./pages/login.php';</script>";
    exit;
}

$hocvien_id = $_SESSION['id_hocvien'];

if ($hocvien_id) {
    $sql_hocvien = "SELECT ten_hocvien, email, so_dien_thoai FROM hocvien WHERE id_hocvien = ?";
    $stmt = $conn->prepare($sql_hocvien);
    $stmt->bind_param("i", $hocvien_id);
    $stmt->execute();
    $stmt->bind_result($ten_hocvien, $email, $phone);
    $stmt->fetch();
    $stmt->close();
}

// Lấy danh sách các khóa học mà học viên đã đăng ký
$sql_courses = "SELECT k.id_khoahoc, k.ten_khoahoc FROM khoahoc k 
                JOIN dangkykhoahoc d ON k.id_khoahoc = d.id_khoahoc 
                WHERE d.id_hocvien = ?";
$stmt = $conn->prepare($sql_courses);
$stmt->bind_param("i", $hocvien_id);
$stmt->execute();
$result_courses = $stmt->get_result();

?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .banner-tests img {
        height: 350px;
        width: 100%;
    }

    .tests {
        max-width: 1200px;
        margin: 0 auto;
    }

    .tests h1 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 20px;
    }

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

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px #555;
        padding: 20px;
        text-align: center;
        border-top: 4px solid #ff704d;
    }

    .card:hover {
        transform: scale(1.05);
    }


    .card:nth-child(3n) {
        border-top-color: #ff6bcb;
        /* Màu cho phần tử thứ 3, 6, 9, ... */
    }

    .card:nth-child(3n+1) {
        border-top-color: #00c58e;
        /* Màu cho phần tử thứ 1, 4, 7, ... */
    }

    .card:nth-child(3n+2) {
        border-top-color: #007bff;
        /* Màu cho phần tử thứ 2, 5, 8, ... */
    }

    .card h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #333;
        text-align: left;
    }

    .card-item {
        display: flex;
        gap: 10px;
        align-items: center;
        font-size: 18px;
    }

    .card p {
        font-size: 20px;
        padding: 0;
        margin: 8px;
    }

    .card .info {
        display: flex;
        justify-content: center;
        gap: 10px;
        font-size: 12px;
        margin-top: 10px;
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

    .submit-btn {
        display: block;
        padding: 10px 20px;
        background-color: #28a745;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100px;
        margin-top: 10px;
    }

    .submit-btn {
        color: white;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    .submit-btn:hover {
        background-color: #e76060;
    }
</style>
<script>
    document.querySelectorAll('.card').forEach((card, index) => {
        const colors = ['#00c58e', '#007bff', '#ff6bcb'];
        card.style.borderTopColor = colors[index % colors.length];
    });
</script>
<div class="banner-tests">
    <img src="https://hocthatnhanh.vn/storage/tracnghiem/chung-chi-hanh-nghe-hoat-dong-xay-dung-htn.jpg" alt="banner" class="img-tracnghiem">
</div>
<section>
    <div class="tests">
        <h1 class="introduce-title">Bài Tập Kiểm Tra</h1>

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab active">Elementary A1</div>
            <div class="tab">Pre-Intermediate A2</div>
            <div class="tab">Intermediate B1</div>
            <div class="tab">Upper-Intermediate B2</div>
            <div class="tab">Advanced C1</div>
            <div class="tab">Proficient C2</div>
        </div>

        <!-- Cards -->
        <div class="cards">
            <?php
            //  $course_id = $course['id_khoahoc'];
            $sql_tests = "SELECT * FROM baitest";
            $stmt_tests = $conn->prepare($sql_tests);
            $stmt_tests->execute();
            $result_tests = $stmt_tests->get_result();

            while ($test = $result_tests->fetch_assoc()):
            ?>
                <div class="cards">
                    <?php
                    // Lấy danh sách bài test
                    $sql_tests = "SELECT * FROM baitest";
                    $stmt_tests = $conn->prepare($sql_tests);
                    $stmt_tests->execute();
                    $result_tests = $stmt_tests->get_result();

                    while ($test = $result_tests->fetch_assoc()):
                        // Lấy số lượng câu hỏi của từng bài test
                        $sql_count_questions = "SELECT COUNT(*) as total_questions FROM cauhoi WHERE id_baitest = ?";
                        $stmt_count = $conn->prepare($sql_count_questions);
                        $stmt_count->bind_param("i", $test['id_baitest']);
                        $stmt_count->execute();
                        $result_count = $stmt_count->get_result();
                        $count_data = $result_count->fetch_assoc();

                        // Lấy thời gian làm bài từ bảng baitest
                        $time_limit = $test['thoi_gian']; // Lưu ý: Thời gian trong cơ sở dữ liệu nên lưu bằng phút
                    ?>
                        <div class="card">
                            <!-- Tên bài test -->
                            <h3><?php echo htmlspecialchars($test['ten_baitest']); ?></h3>

                            <!-- Số lượng câu hỏi -->
                            <div class="card-item">
                                <i class="fa-solid fa-book" style="color: #219900;"></i>
                                <p><?php echo $count_data['total_questions']; ?> câu hỏi</p>
                            </div>

                            <!-- Thời gian làm bài -->
                            <div class="card-item">
                                <i class="fa-solid fa-clock-rotate-left" style="color: #ffd500;"></i>
                                <p><?php echo $time_limit; ?> phút</p>
                            </div>

                            <!-- Tên học viên -->
                            <div class="card-item">
                                <i class="fa-solid fa-user" style="color: #bf082d;"></i>
                                <!-- <p></p> -->
                            </div>

                            <!-- Nút bắt đầu -->
                            <a class="submit-btn" href="index.php?nav=question_detail&id_baitest=<?php echo $test['id_baitest']; ?>">Bắt đầu</a>
                        </div>
                    <?php endwhile; ?>
                </div>


            <?php endwhile; ?>



        </div>
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