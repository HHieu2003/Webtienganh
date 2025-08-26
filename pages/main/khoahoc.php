<div class="course-section">
    <h2 class="introduce-title">KHÓA HỌC HIỆN CÓ</h2>

    <div class="course-grid">
        <?php
        // Lấy từ khóa tìm kiếm từ GET request
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Truy vấn để lấy thông tin khóa học
        $sql = "SELECT * FROM khoahoc";
        if (!empty($search)) {
            $sql .= " WHERE ten_khoahoc LIKE ? OR giang_vien LIKE ?";
        }

        $stmt = $conn->prepare($sql);
        if (!empty($search)) {
            $like_search = '%' . $search . '%';
            $stmt->bind_param("ss", $like_search, $like_search);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Hiển thị thông tin khóa học
            while ($row = $result->fetch_assoc()) {
               $chiphi = number_format($row['chi_phi'], 0, ',', '.');
                echo '<div class="course-card">     
                                    <div class="badge new">New</div>
                                    <img src="' . $row["hinh_anh"] . '" class="course-image" alt="' . $row["ten_khoahoc"] . '">
                                    <div class="course-details">
                                        <div class="course-title">' . $row["ten_khoahoc"] . '</div>
                                        <div class="course-instructor">' . $row["giang_vien"] . ' </div>
                                        <div class="course-info">
                                            <span class="price">' . $chiphi . ' VNĐ</span>
                                            <span class="rating">★★★★★</span>
                                        </div>
                                    </div>
                                    <div align="center">
                                        <a type="submit" class="btn-giohang" href="./index.php?nav=course_detail&course_id=' . $row["id_khoahoc"] . '">Chi Tiết</a>
                                    </div>  
                               </div>';
            }
        } else {
            echo '<p class="text-center">Không tìm thấy khóa học nào phù hợp.</p>';
        }
        ?>
    </div>
</div>

<style>
    /* Phần chính - Layout khóa học */
    .course-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .course-grid {
        flex-wrap: wrap;
        display: flex;
        gap: 20px;
    }

    .course-card {
        width: 23%;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s;
        padding-bottom: 12px;
    }

    .course-card:hover {
        transform: translateY(-5px);
    }

    .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 5px 10px;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        border-radius: 4px;
    }

    .badge.new {
        background-color: red;
    }

    /* Ảnh khóa học */
    .course-image {
        width: 100%;
        height: 180px; /* Hạn chế chiều cao tối đa */
        object-fit: contain; /* Không làm biến dạng ảnh */
        background-color: #f5f5f5; /* Nền xám nhạt cho hình ảnh nhỏ */
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        transition: transform 0.3s, filter 0.3s;
    }

    .course-image:hover {
        transform: scale(1.05); /* Phóng to nhẹ khi hover */
        filter: brightness(1.1); /* Làm sáng hơn khi hover */
    }

    /* Nội dung khóa học */
    .course-details {
        padding: 15px;
    }

    .course-title {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin: 5px 0;
        -webkit-line-clamp: 1;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .course-instructor {
        font-size: 14px;
        color: #555;
    }

    .course-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
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
        font-size: 14px;
    }

    .btn-giohang {
        background-color: #0db33b;
        color: #ffffff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
    }
</style>
