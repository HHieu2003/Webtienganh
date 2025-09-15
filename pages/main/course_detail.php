<?php
// File này được include từ index.php nên biến $conn và session đã có sẵn

// --- PHẦN 1: LẤY DỮ LIỆU KHÓA HỌC ---
if (isset($_GET['course_id'])) {
    $course_id = (int)$_GET['course_id'];

    // CẬP NHẬT SQL: JOIN với bảng `giangvien` để lấy tên giảng viên
    $sql_course = "SELECT kh.*, gv.ten_giangvien 
                   FROM khoahoc kh
                   LEFT JOIN giangvien gv ON kh.id_giangvien = gv.id_giangvien
                   WHERE kh.id_khoahoc = ?";
    $stmt = $conn->prepare($sql_course);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result_course = $stmt->get_result();

    if ($result_course->num_rows > 0) {
        $course = $result_course->fetch_assoc();
    } else {
        echo "<script>alert('Khóa học không tồn tại!'); window.location.href='./index.php';</script>";
        exit;
    }

    // Lấy điểm đánh giá trung bình và tổng số lượt đánh giá
    $sql_avg_rating = "SELECT AVG(diem_danhgia) AS avg_rating, COUNT(*) as total_reviews FROM danhgiakhoahoc WHERE id_khoahoc = ?";
    $stmt_avg = $conn->prepare($sql_avg_rating);
    $stmt_avg->bind_param("i", $course_id);
    $stmt_avg->execute();
    $result_avg_rating = $stmt_avg->get_result()->fetch_assoc();
    $avg_rating = $result_avg_rating['avg_rating'] ? round($result_avg_rating['avg_rating'], 1) : 0;
    $total_reviews = $result_avg_rating['total_reviews'];

    // Lấy danh sách bình luận
    $sql_get_comments = "SELECT dg.nhan_xet, dg.diem_danhgia, hv.ten_hocvien 
                         FROM danhgiakhoahoc dg 
                         JOIN hocvien hv ON dg.id_hocvien = hv.id_hocvien 
                         WHERE dg.id_khoahoc = ? ORDER BY dg.id_danhgia DESC";
    $stmt_comments = $conn->prepare($sql_get_comments);
    $stmt_comments->bind_param("i", $course_id);
    $stmt_comments->execute();
    $result_comments = $stmt_comments->get_result();
} else {
    echo "<script>alert('Không có khóa học được chọn!'); window.location.href='./index.php';</script>";
    exit;
}

// --- PHẦN 2: XỬ LÝ GỬI ĐÁNH GIÁ ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    $diem_danhgia = $_POST['diem_danhgia'];
    $nhan_xet = $_POST['nhan_xet'];
    $hocvien_id = $_SESSION['id_hocvien'] ?? null;
    $message = '';

    if ($hocvien_id) {
        // Kiểm tra xem đã đăng ký chưa
        $sql_check_reg = "SELECT * FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ?";
        $stmt_check = $conn->prepare($sql_check_reg);
        $stmt_check->bind_param("ii", $hocvien_id, $course_id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            // Lưu đánh giá
            $sql_insert = "INSERT INTO danhgiakhoahoc (id_hocvien, id_khoahoc, diem_danhgia, nhan_xet) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iiis", $hocvien_id, $course_id, $diem_danhgia, $nhan_xet);
            $stmt_insert->execute();
            echo "<script>alert('Cảm ơn bạn đã đánh giá!'); window.location.href=window.location.href;</script>";
            exit;
        } else {
            $message = 'Bạn cần đăng ký khóa học để có thể đánh giá!';
        }
    } else {
        $message = 'Vui lòng đăng nhập để đánh giá khóa học!';
    }
    if ($message) echo "<script>alert('" . addslashes($message) . "');</script>";
}
?>
<div class="course-hero-section">
    <div class="background-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="course-main-title"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h1>
                <div class="course-meta-info">
                    <span><i class="fas fa-chalkboard-teacher"></i> Giảng viên: <strong><?php echo htmlspecialchars($course['ten_giangvien'] ?? 'Đang cập nhật'); ?></strong></span>
                    <span>
                        <i class="fas fa-star"></i>
                        <strong><?php echo $avg_rating; ?></strong>
                        (<?php echo $total_reviews; ?> đánh giá)
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="course-detail-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="course-tabs" data-aos="fade-up">
                    <ul class="nav nav-tabs" id="courseTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-toggle="tab" data-target="#description" type="button" role="tab">Mô Tả Khóa Học</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-toggle="tab" data-target="#reviews" type="button" role="tab">Đánh Giá (<?php echo $total_reviews; ?>)</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="courseTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="course-description-content">
                                <div class="course-main-image" data-aos="fade-up">
                                    <img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>">
                                </div>
                                <?php echo !empty($course['mo_ta']) ? $course['mo_ta'] : '<p>Nội dung đang được cập nhật...</p>'; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews-section">
                                <h4><?php echo $total_reviews; ?> đánh giá cho khóa học này</h4>
                                <?php if ($result_comments->num_rows > 0): ?>
                                    <?php while ($comment = $result_comments->fetch_assoc()): ?>
                                        <div class="review-item">
                                            <img src="https://i.pravatar.cc/100?u=<?php echo urlencode($comment['ten_hocvien']); ?>" alt="avatar">
                                            <div class="review-content">
                                                <div class="review-header">
                                                    <strong><?php echo htmlspecialchars($comment['ten_hocvien']); ?></strong>
                                                    <span class="review-stars">
                                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                                            <i class="fas fa-star <?php echo ($i < $comment['diem_danhgia']) ? 'filled' : ''; ?>"></i>
                                                        <?php endfor; ?>
                                                    </span>
                                                </div>
                                                <p><?php echo htmlspecialchars($comment['nhan_xet']); ?></p>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p>Chưa có đánh giá nào cho khóa học này.</p>
                                <?php endif; ?>

                                <hr>
                                <div class="submit-review-form">
                                    <h5>Gửi đánh giá của bạn</h5>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="diem_danhgia">Đánh giá của bạn *</label>
                                            <select name="diem_danhgia" id="diem_danhgia" class="form-control" required>
                                                <option value="5">5 - Tuyệt vời</option>
                                                <option value="4">4 - Tốt</option>
                                                <option value="3">3 - Trung bình</option>
                                                <option value="2">2 - Kém</option>
                                                <option value="1">1 - Rất kém</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="nhan_xet" class="form-control" placeholder="Viết nhận xét của bạn tại đây..." rows="4" required></textarea>
                                        </div>
                                        <button type="submit" name="submit_rating" class="btn btn-success">Gửi đánh giá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-sticky" data-aos="fade-left" data-aos-delay="200">
                    <div class="course-summary-card">
                        <h4 class="card-title">Thông tin khóa học</h4>
                        <ul class="summary-list">
                            <li><i class="fas fa-tag"></i><strong>Giá:</strong> <span><?php echo number_format($course['chi_phi'], 0, ',', '.'); ?> VNĐ</span></li>
                            <li><i class="fas fa-user-tie"></i><strong>Giảng viên:</strong> <span><?php echo htmlspecialchars($course['ten_giangvien'] ?? 'N/A'); ?></span></li>
                            <li><i class="fas fa-calendar-alt"></i><strong>Khai giảng:</strong> <span><?php echo date('d/m/Y', strtotime($course['thoi_gian'])); ?></span></li>
                        </ul>
                        <a href="./index.php?nav=dangkykhoahoc&id_khoahoc=<?php echo $course['id_khoahoc']; ?>" class="btn-enroll">Đăng Ký Ngay <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ... (CSS cho các phần khác đã có) ... */
    .course-hero-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #0db33b, #28a745);
        color: #fff;
    }

    .course-main-title {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .course-meta-info {
        display: flex;
        gap: 25px;
        font-size: 16px;
        opacity: 0.9;
    }

    .course-meta-info i {
        margin-right: 8px;
    }

    /* Bố cục chính */
    .course-detail-container {
        margin: 40px auto;
    }

    .course-main-image {
        margin-bottom: 30px;
        position: relative;
    }

    .course-main-image img {
        width: 50%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .course-main-image:hover img {
        transform: scale(1.03);
    }

    /* Viền gradient phát sáng */
    .course-main-image::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 18px;
        background: conic-gradient(from 90deg, #84fab0, #8fd3f4, #d4a4f2, #f78ca0, #84fab0);
        z-index: -1;
        filter: blur(5px);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .course-main-image:hover::after {
        opacity: 0.8;
    }


    /* Hệ thống Tabs */
    .course-tabs .nav-tabs {
        border-bottom: 2px solid #eee;
    }

    .course-tabs .nav-link {
        border: none;
        padding: 15px 25px;
        font-size: 18px;
        font-weight: 600;
        color: #666;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .course-tabs .nav-link.active {
        color: #0db33b;
        border-bottom-color: #0db33b;
        background-color: transparent;
    }

    .tab-content {
        padding: 30px;
        border: 1px solid #eee;
        border-top: none;
        border-radius: 0 0 15px 15px;
    }

    .course-description-content {
        font-size: 16px;
        line-height: 1.8;
        color: #555;
    }

    /* Khu vực đánh giá */
    .reviews-section h4 {
        font-weight: 600;
        margin-bottom: 20px;
    }

    .review-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-item img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .review-stars i {
        color: #ccc;
    }

    .review-stars i.filled {
        color: #ffc107;
    }

    .review-content p {
        margin: 5px 0 0 0;
        color: #555;
    }

    .submit-review-form h5 {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .submit-review-form .form-control {
        border-radius: 8px;
    }

    .submit-review-form .btn {
        border-radius: 8px;
        font-weight: 600;
    }

    /* Sidebar */
    .sidebar-sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 100px;
    }

    .course-summary-card {
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    .card-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
    }

    .summary-list {
        list-style: none;
        padding: 0;
        margin-bottom: 25px;
    }

    .summary-list li {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #eee;
    }

    .summary-list li i {
        color: #0db33b;
        margin-right: 10px;
    }

    .summary-list li span {
        color: #555;
    }

    .btn-enroll {
        display: block;
        width: 100%;
        text-align: center;
        color: #fff;
        padding: 14px;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
        background: linear-gradient(45deg, #ff416c, #ff4b2b);
        transition: all 0.3s ease;
    }

    .btn-enroll:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 65, 108, 0.4);
        color: #fff;
    }

    .btn-enroll i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .btn-enroll:hover i {
        transform: translateX(5px);
    }
</style>