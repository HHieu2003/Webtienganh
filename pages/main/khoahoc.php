<div class="course-section">
    <div class="section-header" data-aos="fade-down">
        <h2 class="introduce-title">TẤT CẢ KHÓA HỌC</h2>
        <p class="section-subtitle">Khám phá các khóa học được thiết kế dành riêng cho bạn</p>
    </div>

    <div class="course-grid">
        <?php
        // File này được include từ index.php nên biến $conn đã có sẵn.
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Đã loại bỏ JOIN với bảng giangvien
        $sql = "SELECT * FROM khoahoc";
        
        if (!empty($search)) {
            // Chỉ tìm kiếm theo tên khóa học
            $sql .= " WHERE ten_khoahoc LIKE ?";
        }
        $sql .= " ORDER BY id_khoahoc DESC";

        $stmt = $conn->prepare($sql);
        if (!empty($search)) {
            $like_search = '%' . $search . '%';
            $stmt->bind_param("s", $like_search);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $delay = 0; // Biến để tạo hiệu ứng xuất hiện nối tiếp
            while ($row = $result->fetch_assoc()) {
               $chiphi = number_format($row['chi_phi'], 0, ',', '.');
                echo '<div class="course-card" data-aos="fade-up" data-aos-delay="' . $delay . '">     
                        <div class="course-image-container">
                            <a href="./index.php?nav=course_detail&course_id=' . $row["id_khoahoc"] . '">
                                <img src="' . htmlspecialchars($row["hinh_anh"]) . '" class="course-image" alt="' . htmlspecialchars($row["ten_khoahoc"]) . '">
                            </a>
                            <div class="badge new">New</div>
                        </div>
                        <div class="course-details">
                            <h3 class="course-title">
                                <a href="./index.php?nav=course_detail&course_id=' . $row["id_khoahoc"] . '">' . htmlspecialchars($row["ten_khoahoc"]) . '</a>
                            </h3>
                            <div class="course-info">
                                <span class="price">' . $chiphi . ' VNĐ</span>
                                <span class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="course-card-footer">
                            <a class="btn-view-detail" href="./index.php?nav=course_detail&course_id=' . $row["id_khoahoc"] . '">Xem Chi Tiết</a>
                        </div>  
                   </div>';
                $delay += 50; 
            }
        } else {
            echo '<p class="text-center col-12">Không tìm thấy khóa học nào phù hợp.</p>';
        }
        ?>
    </div>
</div>

<style>
    /* CSS được thiết kế lại hoàn toàn */
    .course-section {
        max-width: 1200px;
        margin: 0px auto;
        padding: 20px;
        min-height: 418px;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .introduce-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .section-subtitle {
        font-size: 18px;
        color: #666;
    }

    .course-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; 
    }

    .course-card {
        width: calc(25% - 15px);
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;
        transition: all 0.4s ease;
        border: 1px solid #eee;
    }

    .course-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 15px 40px rgba(255, 0, 140, 0.2);
        border-color: #0db33b;
    }

    .course-image-container {
        position: relative;
        overflow: hidden;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .course-image {
        width: 100%;
        height: 180px; 
        object-fit: cover;
        transition: transform 0.4s ease, filter 0.4s ease;
    }
    
    .course-card:hover .course-image {
        transform: scale(1.1);
        filter: brightness(1.05);
    }

    .badge {
        position: absolute; top: 15px; left: 15px; padding: 6px 12px;
        color: #fff; font-size: 13px; font-weight: bold; border-radius: 5px;
        background-color: #dc3545; z-index: 2;
    }

    .course-details {
        padding: 15px; 
        flex-grow: 1;
    }

    .course-title {
        font-size: 16px; 
        font-weight: 600; color: #333; margin-bottom: 10px;
        line-height: 1.4; min-height: 45px; 
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .course-title a { color: inherit; text-decoration: none; transition: color 0.3s ease; }
    .course-card:hover .course-title a { color: #0db33b; }

    .course-info {
        display: flex; justify-content: space-between; align-items: center;
        padding-top: 10px; border-top: 1px solid #f0f0f0; margin-top: 10px;
    }

    .price { color: #0db33b; font-weight: bold; font-size: 18px; }
    .rating { color: #ffc107; font-size: 14px; }
    
    .course-card-footer { padding: 0 15px 15px 15px; }

    .btn-view-detail {
        display: block; width: 100%; text-align: center;
        color: #fff;
        padding: 12px; border: none; border-radius: 8px;
        font-size: 16px; font-weight: bold; cursor: pointer;
        text-decoration: none;
        position: relative; 
        z-index: 1;
        overflow: hidden; 
        transition: color 0.4s ease;
    }

    .btn-view-detail::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #28a745, #0db33b, #84fab0);
        z-index: -1;
        transition: transform 0.4s ease;
        transform-origin: top left;
        transform: scaleX(0);
    }

    .btn-view-detail {
        background-color: #f0f0f0; 
        color: #333;
    }

    .btn-view-detail:hover::before {
        transform: scaleX(1);
    }
    
    .btn-view-detail:hover {
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 1200px) { .course-card { width: calc(33.333% - 14px); } }
    @media (max-width: 768px) { .course-card { width: calc(50% - 10px); } }
    @media (max-width: 576px) { .course-card { width: 100%; } }
</style>