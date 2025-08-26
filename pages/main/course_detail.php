<?php
// Kiểm tra nếu có khóa học được chọn
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Truy vấn để lấy thông tin chi tiết khóa học
    $sql_course = "SELECT * FROM khoahoc WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql_course);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result_course = $stmt->get_result();

    // Kiểm tra nếu khóa học tồn tại
    if ($result_course->num_rows > 0) {
        $course = $result_course->fetch_assoc();
    } else {
        echo "<script>alert('Khóa học không tồn tại!'); window.location.href='../../index.php';</script>";
        exit;
    }

    // Truy vấn để tính điểm đánh giá trung bình của khóa học
    $sql_avg_rating = "SELECT AVG(diem_danhgia) AS avg_rating FROM danhgiakhoahoc WHERE id_khoahoc = ?";
    $stmt = $conn->prepare($sql_avg_rating);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result_avg_rating = $stmt->get_result()->fetch_assoc();
    $avg_rating = $result_avg_rating['avg_rating'] ? round($result_avg_rating['avg_rating'], 1) : 'Chưa có đánh giá';

    // Lấy danh sách bình luận
    $sql_get_comments = "SELECT dg.nhan_xet, dg.diem_danhgia,hv.ten_hocvien 
      FROM danhgiakhoahoc dg 
      JOIN hocvien hv ON dg.id_hocvien = hv.id_hocvien 
      WHERE dg.id_khoahoc = ? ";
    $stmt = $conn->prepare($sql_get_comments);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result_comments = $stmt->get_result();
} else {
    echo "<script>alert('Không có khóa học được chọn!'); window.location.href='../../index.php';</script>";
    exit;
}

// Kiểm tra xem học viên đã đăng ký khóa học này chưa
// Xử lý lưu đánh giá
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    $diem_danhgia = $_POST['diem_danhgia'];
    $nhan_xet = $_POST['nhan_xet'];
    $hocvien_id = $_SESSION['id_hocvien'] ?? null;

    // Kiểm tra xem người dùng đã đăng ký khóa học chưa
    if ($hocvien_id) {
        $sql_check_registration = "SELECT * FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ?";
        $stmt = $conn->prepare($sql_check_registration);
        $stmt->bind_param("ii", $hocvien_id, $course_id);
        $stmt->execute();
        $isRegistered = $stmt->get_result()->num_rows > 0;

        if ($isRegistered) {
            // Lưu đánh giá
            $sql_insert_rating = "INSERT INTO danhgiakhoahoc (id_hocvien, id_khoahoc, diem_danhgia, nhan_xet) 
                                  VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert_rating);
            $stmt->bind_param("iiis", $hocvien_id, $course_id, $diem_danhgia, $nhan_xet);
            $stmt->execute();

            echo "<script>; window.location.href='./index.php?nav=course_detail&course_id=$course_id';alert('Cảm ơn bạn đã đánh giá!')</script>";
            exit;
        } else {
            echo "<script>alert('Bạn chưa đăng ký khóa học này!');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng đăng nhập để đánh giá khóa học.');</script>";
    }
}
?>





<?php
// Đóng kết nối
$conn->close();
?>

<style>
    br {
    display: none; /* Ẩn tất cả thẻ <br> */
        }

    .container {
        display: flex;
        flex-direction: row;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: white;
    }

    .content {
        flex: 3;
        padding-right: 20px;
    }

    .content .post {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        background-color: #fdfdfd;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .content .post h2 {
        font-size: 25px;
        font-weight: bold;
        color: #21c106;
        margin-bottom: 20px;
    }

    .content .post img {
        width: 90%;
        height: 300px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .content .post p {
        margin-bottom: 15px;
        gap: 20px;
    }

    .content .post .meta {
        color: #888;
        font-size: 15px;
        margin-bottom: 18px;
    }

    .post-info {
        gap: 20px;
    }

    .price {
        color: green;
        font-weight: bold;
    }

    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
    }

    .rating {
        color: #ff9800;
        font-size: 20px;
    }

    .reasons {
        display: flex;
        justify-content: space-between;
    }

    .reason-item {
        width: 30%;
        background-color: #fff;
        border: 1px solid #d80027;
        padding: 20px;
        margin: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .reason-item h3 {
        font-size: 18px;
        color: #d80027;
        margin-bottom: 10px;
    }

    .btn-dky {
        text-decoration: none;
        background-color: #0db33b;
        color: #ffffff;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        font-size: 17px;
        cursor: pointer;
        -webkit-appearance: none;
        font-weight: 600;
    }
    .btn-dky:hover {
        opacity: 0.7;
    }
    .sidebar {
        flex: 1;
        background-color: #f3f7f8;
        padding: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        height: 1200px;
    }

    .search-box {
        gap: 10px;
        margin-left: 15px;
    }

    .search-box input {
        margin: 0;
        padding: 3px;
        font-size: 16px;
        width: 200px;
        height: 20px
    }

    .search-button {
        margin: 0;
        padding: 3px;
        font-size: 16px;
        width: 40px;
        height: 30px;
        background-color: #0db33b;
        border: none;
        border-radius: 5px;
    }

    .khoahoc-item {
        margin-top: 30px;
        display: flex;
        margin-bottom: 15px;
        gap: 10px;
        align-items: center;
    }

    .khoahoc-item img {
        width: 70px;
        height: 70px;
        border-radius: 5px;
        object-fit: fill;
    }

    .khoahoc-item p {
        font-size: 14px;
        color: #333;
        margin: 0;
    }
</style>

<div class="container">
    <div class="content">
        <div class="post">
            <h2>Thông tin chi tiết khoá học: <?php echo $course['ten_khoahoc']; ?></h2>
            <div style="display: flex;     justify-content: space-between;    padding: 1px 23px;">

                <?php if ($course['hinh_anh']): ?>
                    <div>

                        <img src="<?php echo $course['hinh_anh']; ?>" class="course-image" alt="Hình ảnh khóa học">
                    </div>
                <?php endif; ?>
                <div style="padding: 20px; height: 100%; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h5>

                        Giảng Viên: <?php echo $course['giang_vien']; ?>
                    </h5>
                    <div class="post-info">
                        <h5>
                            Giá:
                            <span class="price"> <?php echo number_format($course['chi_phi'], 0, ',', '.'); ?> VND</span>

                        </h5>

                        <span class="rating">
                            <p><strong>Đánh giá:</strong> <?php echo $avg_rating; ?> .</p>
                        </span>
                    </div>
                    <div>
                        <a type="submit" class="btn-dky" href="./index.php?nav=dangkykhoahoc&id_khoahoc=<?= htmlspecialchars($course['id_khoahoc']) ?>">Đăng Ký Ngay</a>

                    </div>
                </div>

            </div>

        </div>
        <div class="post">
            <h2>Mô tả khóa học:</h2>
            <p>
                <?php echo nl2br($course['mo_ta']); ?>
            </p>

        </div>
        <div class="post">
            <h2>Lý do nên chọn khóa học</h2>
            <div class="reasons">
                <div class="reason-item">
                    <h3>MÔ HÌNH TIẾNG ANH TOÀN DIỆN</h3>
                    <p>Tiên phong dạy toàn diện 4 kỹ năng Nghe – Nói Đọc – Viết...</p>
                </div>
                <div class="reason-item">
                    <h3>CHẤT LƯỢNG GIẢNG DẠY TỐT</h3>
                    <p>Phương pháp giảng dạy Flipped Learning...</p>
                </div>
                <div class="reason-item">
                    <h3>ĐỘI NGŨ GIẢNG VIÊN CHUYÊN NGHIỆP</h3>
                    <p>Sở hữu nhiều năm kinh nghiệm...</p>
                </div>
                <div class="reason-item">
                    <h3>MÔI TRƯỜNG HỌC LÝ TƯỞNG</h3>
                    <p>Môi trường học lý tưởng, sĩ số lớp chỉ từ 13 – 17 học viên/lớp...</p>
                </div>
                <div class="reason-item">
                    <h3>HỖ TRỢ TẬN TÌNH 24/7</h3>
                    <p>Đội ngũ CSKH luôn sẵn sàng giúp bạn 24/7...</p>
                </div>
            </div>
        </div>

        <style>
            .container-comment {
                width: 100%;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 20px;
            }

            .comment2 {
                display: flex;
                margin-bottom: 15px;
                align-items: flex-start;
            }

            .comment2 img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                margin-right: 10px;
            }

            .comment-content {
                background-color: #f1f1f1;
                border-radius: 5px;
                padding: 10px;
                width: 100%;
            }

            .comment-content p {
                margin: 5px 0;
            }
        </style>

        <!----------------comment------------->

        <div class="container-comment">
            <h3>Đánh giá khóa học:</h3>
            <p><strong>Điểm trung bình:</strong> <?php echo $avg_rating; ?>/5</p>

            <!-- Form gửi đánh giá -->
            <form method="POST">
                <label for="diem_danhgia">Chọn điểm đánh giá (1-5):</label>
                <select name="diem_danhgia" id="diem_danhgia" required>
                    <option value="5">5 - Tuyệt vời</option>
                    <option value="4">4 - Tốt</option>
                    <option value="3">3 - Trung bình</option>
                    <option value="2">2 - Kém</option>
                    <option value="1">1 - Rất kém</option>
                </select>

                <textarea name="nhan_xet" placeholder="Nhập nhận xét của bạn..." rows="3" style="width: 100%; margin-top: 10px;" required></textarea>
                <button type="submit" name="submit_rating" class="btn-dky" style="margin-top: 10px; -webkit-appearance: none; width: auto; height:auto;">Gửi đánh giá</button>
            </form>

            <!-- Danh sách đánh giá -->

            <div class="comment-list" style="margin-top: 20px;">
                <h4 class="my-2">Danh sách bình luận:</h4>

                <?php while ($comment = $result_comments->fetch_assoc()): ?>
                    <div class="comment2" style="margin-bottom: 15px; display: flex;">
                        <img src="https://via.placeholder.com/40" alt="User avatar" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <div class="comment-content" style="background-color: #f1f1f1; border-radius: 5px; padding: 10px; width: 100%;">
                            <p><strong><?php echo htmlspecialchars($comment['ten_hocvien']); ?></strong> - <?php echo htmlspecialchars($comment['diem_danhgia']); ?>/5</p>
                            <p><?php echo htmlspecialchars($comment['nhan_xet']); ?></p>
                            <div class="comment-footer">
                                <a><i class="fa-solid fa-thumbs-up"></i> </a>
                                <a> Phản hồi</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>





    </div>

    <div class="sidebar" style="height: 100%;">
        <div class="search">
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm..." style="    padding: 13px 5px;">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                </button>
            </div>
            <div class="search-icon"></div>
        </div>

        <div class="khoahoc">
            <div class="khoahoc-item">
                <img src="images/anh1.png" alt="Image">
                <p>Cách Đánh Trọng Âm Tiếng Anh Đơn Giản Và Dễ Nhớ (Kèm Bài Tập)</p>
            </div>
            <div class="khoahoc-item">
                <img src="images/logo.png" alt="Image">
                <p>MẸO HAY PHÂN BIỆT A - AN - THE ĐỂ KHÔNG CÒN NHẦM LẪN</p>
            </div>
            <div class="khoahoc-item">
                <img src="images/logo2.jpg" alt="Image">
                <p>SO SÁNH NHẤT VÀ SO SÁNH HƠN TRONG TIẾNG ANH...</p>
            </div>
        </div>
    </div>
</div>