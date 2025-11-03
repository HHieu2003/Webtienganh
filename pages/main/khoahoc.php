<?php
// File này được include từ index.php nên biến $conn đã có sẵn.
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get all distinct levels from database for filter dropdown - PHẢI LẤY TRƯỚC KHI DÙNG
$sql_levels = "SELECT DISTINCT cap_do FROM khoahoc WHERE cap_do IS NOT NULL AND cap_do != '' ORDER BY cap_do";
$levels_result = $conn->query($sql_levels);
$available_levels = [];
while ($level_row = $levels_result->fetch_assoc()) {
    $available_levels[] = $level_row['cap_do'];
}

// Pagination settings
$items_per_page = 12; // Số khóa học mỗi trang
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $items_per_page;

// Count total courses for pagination
$count_sql = "SELECT COUNT(*) as total FROM khoahoc";
if (!empty($search)) {
    $count_sql .= " WHERE ten_khoahoc LIKE ?";
}

$count_stmt = $conn->prepare($count_sql);
if (!empty($search)) {
    $like_search = '%' . $search . '%';
    $count_stmt->bind_param("s", $like_search);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_courses = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_courses / $items_per_page);

// Fetch ALL courses for client-side filtering
$sql = "SELECT * FROM khoahoc";
if (!empty($search)) {
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
?>

<div class="course-section section-p20">
    <div class="section-header" data-aos="fade-down">
        <h2 class="introduce-title">TẤT CẢ KHÓA HỌC</h2>
        <p class="section-subtitle">Khám phá các khóa học được thiết kế dành riêng cho bạn</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-container" data-aos="fade-up" data-aos-duration="800">
        <div class="filter-controls">
            <div class="filter-group">
                <label for="filter-sort" class="filter-label">
                    <i class="fas fa-sort-amount-down"></i>
                    Sắp xếp
                </label>
                <div class="select-wrapper">
                    <select id="filter-sort" class="filter-select">
                        <option value="">Mặc định</option>
                        <option value="price_asc">Giá: Thấp → Cao</option>
                        <option value="price_desc">Giá: Cao → Thấp</option>
                        <option value="name_asc">Tên: A → Z</option>
                        <option value="name_desc">Tên: Z → A</option>
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
            </div>

            <div class="filter-group">
                <label for="filter-level" class="filter-label">
                    <i class="fas fa-layer-group"></i>
                    Cấp độ
                </label>
                <div class="select-wrapper">
                    <select id="filter-level" class="filter-select">
                        <option value="">Tất cả cấp độ</option>
                        <?php foreach ($available_levels as $level): ?>
                            <option value="<?php echo htmlspecialchars($level); ?>">
                                <?php echo htmlspecialchars($level); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
            </div>

            <button class="btn-reset-filter" onclick="resetFilters()">
                <i class="fas fa-redo-alt"></i>
                Đặt lại
            </button>

            <div class="filter-count" id="filter-count">
                <i class="fas fa-book-open"></i>
                <span id="result-count">0</span> khóa học
            </div>
        </div>
    </div>

    <div class="course-grid" id="course-grid">
        <?php
        if ($result->num_rows > 0) {
            $delay = 0; // Biến để tạo hiệu ứng xuất hiện nối tiếp
            $index = 0;
            while ($row = $result->fetch_assoc()) {
                $chiphi = number_format($row['chi_phi'], 0, ',', '.');
                $chi_phi_raw = $row['chi_phi']; // Giá gốc không format
                $thoi_gian = $row['thoi_gian'] ?? 0; // Thời lượng
                $cap_do = $row['cap_do'] ?? ''; // Cấp độ
                
                // Chỉ hiển thị khóa học trong trang hiện tại khi CHƯA filter
                $display_style = '';
                if ($index < $offset || $index >= $offset + $items_per_page) {
                    $display_style = 'style="display: none;"';
                }
                
                echo '<div class="course-card" 
                          data-aos="fade-up" 
                          data-aos-delay="' . $delay . '"
                          data-price="' . $chi_phi_raw . '"
                          data-duration="' . $thoi_gian . '"
                          data-level="' . htmlspecialchars($cap_do) . '"
                          data-name="' . htmlspecialchars($row["ten_khoahoc"]) . '"
                          data-id="' . $row["id_khoahoc"] . '"
                          data-index="' . $index . '"
                          ' . $display_style . '>     
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
                $index++;
            }
        } else {
            echo '<p class="text-center col-12">Không tìm thấy khóa học nào phù hợp.</p>';
        }
        ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination-container" data-aos="fade-up">
        <div class="pagination">
            <?php
            // Previous button
            if ($current_page > 1):
                $prev_page = $current_page - 1;
                $prev_url = "index.php?nav=khoahoc&page=$prev_page";
                if (!empty($search)) {
                    $prev_url .= "&search=" . urlencode($search);
                }
            ?>
                <a href="<?php echo $prev_url; ?>" class="pagination-btn pagination-prev">
                    <i class="fas fa-chevron-left"></i>
                    <span>Trước</span>
                </a>
            <?php else: ?>
                <span class="pagination-btn pagination-prev disabled">
                    <i class="fas fa-chevron-left"></i>
                    <span>Trước</span>
                </span>
            <?php endif; ?>

            <!-- Page numbers -->
            <div class="pagination-numbers">
                <?php
                $range = 2; // Show 2 pages before and after current page
                $start = max(1, $current_page - $range);
                $end = min($total_pages, $current_page + $range);

                // First page
                if ($start > 1):
                    $url = "index.php?nav=khoahoc&page=1";
                    if (!empty($search)) $url .= "&search=" . urlencode($search);
                ?>
                    <a href="<?php echo $url; ?>" class="pagination-number">1</a>
                    <?php if ($start > 2): ?>
                        <span class="pagination-dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): 
                    $url = "index.php?nav=khoahoc&page=$i";
                    if (!empty($search)) $url .= "&search=" . urlencode($search);
                ?>
                    <a href="<?php echo $url; ?>" 
                       class="pagination-number <?php echo $i == $current_page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <!-- Last page -->
                <?php if ($end < $total_pages): ?>
                    <?php if ($end < $total_pages - 1): ?>
                        <span class="pagination-dots">...</span>
                    <?php endif; ?>
                    <?php
                    $url = "index.php?nav=khoahoc&page=$total_pages";
                    if (!empty($search)) $url .= "&search=" . urlencode($search);
                    ?>
                    <a href="<?php echo $url; ?>" class="pagination-number"><?php echo $total_pages; ?></a>
                <?php endif; ?>
            </div>

            <!-- Next button -->
            <?php
            if ($current_page < $total_pages):
                $next_page = $current_page + 1;
                $next_url = "index.php?nav=khoahoc&page=$next_page";
                if (!empty($search)) {
                    $next_url .= "&search=" . urlencode($search);
                }
            ?>
                <a href="<?php echo $next_url; ?>" class="pagination-btn pagination-next">
                    <span>Sau</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <span class="pagination-btn pagination-next disabled">
                    <span>Sau</span>
                    <i class="fas fa-chevron-right"></i>
                </span>
            <?php endif; ?>
        </div>

        <!-- Page info -->
        <div class="pagination-info">
            <i class="fas fa-info-circle"></i>
            Trang <strong><?php echo $current_page; ?></strong> / <strong><?php echo $total_pages; ?></strong>
            <span class="separator">•</span>
            Tổng <strong><?php echo $total_courses; ?></strong> khóa học
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    /* CSS được thiết kế lại hoàn toàn */
    .course-section {
        max-width: 1200px;
        margin: 0px auto;
        padding-top: 40px;
        padding-bottom: 10px;
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

    /* Filter Styles - Compact & Modern Version */
    .filter-container {
        margin-bottom: 30px;
        background: linear-gradient(135deg, #23b54c 0%, #1ebd98 100%);
        border-radius: 16px;
        padding: 13px 25px;
        box-shadow: 0 8px 30px rgba(13, 179, 59, 0.25);
        position: relative;
        overflow: hidden;
    }

    .filter-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: filterGlow 8s ease-in-out infinite;
    }

    @keyframes filterGlow {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-30px, -30px); }
    }

    .filter-controls {
        display: grid;
        grid-template-columns: 1fr 1fr auto auto;
        gap: 15px;
        align-items: end;
        position: relative;
        z-index: 1;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.3px;
    }

    .filter-label i {
        font-size: 14px;
        opacity: 0.95;
    }

    .select-wrapper {
        position: relative;
    }

    .select-arrow {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #0db33b;
        pointer-events: none;
        transition: all 0.3s ease;
        font-size: 12px;
    }

    .filter-select:focus + .select-arrow {
        transform: translateY(-50%) rotate(180deg);
        color: #0a9430;
    }

    .filter-select {
        width: 100%;
        padding: 10px 32px 10px 12px;
        border: 2px solid rgba(255,255,255,0.25);
        border-radius: 10px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        font-weight: 500;
        color: #333;
    }

    .filter-select:hover {
        background: #fff;
        border-color: rgba(255,255,255,0.5);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .filter-select:focus {
        outline: none;
        border-color: #fff;
        background: #fff;
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .filter-select option {
        padding: 8px;
        background: #fff;
        color: #333;
        font-size: 14px;
    }

    .btn-reset-filter {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        height: 42px;
    }

    .btn-reset-filter:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255,255,255,0.5);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    .btn-reset-filter:active {
        transform: translateY(0px);
    }

    .btn-reset-filter i {
        transition: transform 0.5s ease;
        font-size: 13px;
    }

    .btn-reset-filter:hover i {
        transform: rotate(360deg);
    }

    .filter-count {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        color: #0db33b;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        white-space: nowrap;
        height: 42px;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .filter-count i {
        font-size: 14px;
    }

    #result-count {
        color: #0a9430;
        font-size: 16px;
        font-weight: 800;
    }

    /* Responsive for filters */
    @media (max-width: 1024px) {
        .filter-controls {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .btn-reset-filter,
        .filter-count {
            grid-column: span 1;
        }
    }

    @media (max-width: 768px) {
        .filter-container {
            padding: 18px 20px;
            border-radius: 14px;
        }

        .filter-controls {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .filter-select {
            font-size: 13px;
            padding: 9px 30px 9px 11px;
        }

        .btn-reset-filter,
        .filter-count {
            font-size: 13px;
            padding: 9px 15px;
            height: 38px;
        }
    }

    @media (max-width: 576px) {
        .filter-container {
            padding: 15px 18px;
        }

        .filter-label {
            font-size: 12px;
        }

        .filter-select {
            font-size: 13px;
        }
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
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 12px;
        color: #fff;
        font-size: 13px;
        font-weight: bold;
        border-radius: 5px;
        background-color: #dc3545;
        z-index: 2;
    }

    .course-details {
        padding: 15px;
        flex-grow: 1;
    }

    .course-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.4;
        min-height: 45px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .course-card:hover .course-title a {
        color: #0db33b;
    }

    .course-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
        margin-top: 10px;
    }

    .price {
        color: #0db33b;
        font-weight: bold;
        font-size: 18px;
    }

    .rating {
        color: #ffc107;
        font-size: 14px;
    }

    .course-card-footer {
        padding: 0 15px 15px 15px;
    }

    .btn-view-detail {
        display: block;
        width: 100%;
        text-align: center;
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
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
    @media (max-width: 1200px) {
        .course-card {
            width: calc(33.333% - 14px);
        }
    }

    @media (max-width: 768px) {
        .course-card {
            width: calc(50% - 10px);
        }
    }

    @media (max-width: 576px) {
        .course-card {
            width: 100%;
        }
    }
    
    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px 20px;
        font-size: 18px;
        color: #666;
    }

    /* Pagination Styles */
    .pagination-container {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, #66eabaff 0%, #4ba254ff 100%);
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        backdrop-filter: blur(10px);
    }

    .pagination-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.95);
        color: #667eea;
        border: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: #764ba2;
    }

    .pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-numbers {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 10px;
    }

    .pagination-number {
        min-width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #667eea;
        border-color: rgba(255,255,255,0.8);
        transform: translateY(-3px) scale(1.15);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .pagination-number.active {
        background: #fff;
        color: #764ba2;
        border-color: #fff;
        transform: scale(1.2);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: pageActive 0.5s ease;
    }

    @keyframes pageActive {
        0%, 100% { transform: scale(1.2); }
        50% { transform: scale(1.3); }
    }

    .pagination-dots {
        color: rgba(255,255,255,0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 15px 30px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 30px;
        color: #667eea;
        font-size: 15px;
        font-weight: 600;
        border: 2px solid rgba(102, 126, 234, 0.2);
    }

    .pagination-info i {
        font-size: 18px;
    }

    .pagination-info strong {
        color: #764ba2;
        font-size: 17px;
    }

    .pagination-info .separator {
        margin: 0 5px;
        color: rgba(102, 126, 234, 0.3);
    }

    /* Pagination Responsive */
    @media (max-width: 768px) {
        .pagination {
            padding: 15px 20px;
            border-radius: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination-btn {
            padding: 5px 8px;
            font-size: 14px;
        }

        .pagination-btn span {
            display: none;
        }

        .pagination-number {
            min-width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .pagination-info {
            font-size: 13px;
            padding: 7px 15px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .pagination-numbers {
            gap: 5px;
            margin: 0 5px;
        }

        .pagination-number {
            min-width: 35px;
            height: 35px;
            font-size: 13px;
        }
    }
</style>

<script>
    // Course filter functionality with pagination
    let isFiltering = false;
    let currentFilterPage = 1;
    const itemsPerPage = 12;
    let filteredCourses = [];
    
    function applyFilters(page = 1) {
        const sortValue = document.getElementById('filter-sort').value;
        const levelValue = document.getElementById('filter-level').value;
        
        // Đánh dấu đang filter
        isFiltering = (sortValue !== '' || levelValue !== '');
        currentFilterPage = page;
        
        // Get all course cards
        const courseCards = Array.from(document.querySelectorAll('.course-card'));
        
        // Filter by level (cấp độ)
        filteredCourses = courseCards.filter(card => {
            const level = card.dataset.level || '';
            
            if (levelValue === '') {
                return true;
            }
            
            // Kiểm tra xem cấp độ có chứa giá trị filter không (case-insensitive)
            return level.toLowerCase().includes(levelValue.toLowerCase());
        });
        
        // Sort courses
        filteredCourses.sort((a, b) => {
            switch(sortValue) {
                case 'price_asc':
                    return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                case 'price_desc':
                    return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                case 'name_asc':
                    return a.dataset.name.localeCompare(b.dataset.name, 'vi');
                case 'name_desc':
                    return b.dataset.name.localeCompare(a.dataset.name, 'vi');
                case 'newest':
                    return parseInt(b.dataset.id) - parseInt(a.dataset.id);
                case 'oldest':
                    return parseInt(a.dataset.id) - parseInt(b.dataset.id);
                default:
                    return 0;
            }
        });
        
        // Calculate pagination
        const totalFiltered = filteredCourses.length;
        const totalPages = Math.ceil(totalFiltered / itemsPerPage);
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const coursesToShow = filteredCourses.slice(startIndex, endIndex);
        
        // Update result count
        updateResultCount(totalFiltered);
        
        // Update pagination
        updateFilterPagination(totalPages, page, totalFiltered);
        
        // Fade out all cards first
        courseCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            card.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        });
        
        // Show filtered and sorted cards with staggered animation
        const courseGrid = document.querySelector('.course-grid');
        
        setTimeout(() => {
            coursesToShow.forEach((card, index) => {
                card.style.display = 'block';
                courseGrid.appendChild(card); // Re-append to maintain sort order
                
                // Staggered fade in effect
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                    card.setAttribute('data-aos-delay', index * 50);
                }, index * 50);
            });
        }, 350);
        
        // Show/hide no results message
        setTimeout(() => {
            const noResults = document.getElementById('no-results-message');
            if (totalFiltered === 0) {
                if (!noResults) {
                    const message = document.createElement('div');
                    message.id = 'no-results-message';
                    message.className = 'no-results';
                    message.innerHTML = `
                        <i class="fas fa-search" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                        <p style="margin: 0; font-size: 20px; font-weight: 600;">Không tìm thấy khóa học phù hợp</p>
                        <p style="margin: 10px 0 0 0; color: #999;">Vui lòng thử điều chỉnh bộ lọc của bạn</p>
                    `;
                    message.style.opacity = '0';
                    courseGrid.appendChild(message);
                    
                    setTimeout(() => {
                        message.style.transition = 'opacity 0.5s ease';
                        message.style.opacity = '1';
                    }, 100);
                }
            } else {
                if (noResults) {
                    noResults.style.opacity = '0';
                    setTimeout(() => noResults.remove(), 300);
                }
            }
        }, 400);
        
        // Refresh AOS animations if available
        setTimeout(() => {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }, 800);
    }
    
    function updateFilterPagination(totalPages, currentPage, totalItems) {
        let paginationContainer = document.querySelector('.pagination-container');
        
        if (!paginationContainer) {
            paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.setAttribute('data-aos', 'fade-up');
            document.querySelector('.course-grid').parentElement.appendChild(paginationContainer);
        }
        
        if (isFiltering && totalPages > 1) {
            // Show pagination with filter results
            paginationContainer.style.display = 'flex';
            paginationContainer.style.opacity = '1';
            paginationContainer.style.transform = 'translateY(0)';
            
            let paginationHTML = '<div class="pagination">';
            
            // Previous button
            if (currentPage > 1) {
                paginationHTML += `
                    <a href="javascript:void(0)" onclick="applyFilters(${currentPage - 1}); scrollToTop();" class="pagination-btn pagination-prev">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>
                `;
            } else {
                paginationHTML += `
                    <span class="pagination-btn pagination-prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </span>
                `;
            }
            
            // Page numbers
            paginationHTML += '<div class="pagination-numbers">';
            
            const range = 2;
            const start = Math.max(1, currentPage - range);
            const end = Math.min(totalPages, currentPage + range);
            
            // First page
            if (start > 1) {
                paginationHTML += `<a href="javascript:void(0)" onclick="applyFilters(1); scrollToTop();" class="pagination-number">1</a>`;
                if (start > 2) {
                    paginationHTML += '<span class="pagination-dots">...</span>';
                }
            }
            
            // Page numbers in range
            for (let i = start; i <= end; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                paginationHTML += `<a href="javascript:void(0)" onclick="applyFilters(${i}); scrollToTop();" class="pagination-number ${activeClass}">${i}</a>`;
            }
            
            // Last page
            if (end < totalPages) {
                if (end < totalPages - 1) {
                    paginationHTML += '<span class="pagination-dots">...</span>';
                }
                paginationHTML += `<a href="javascript:void(0)" onclick="applyFilters(${totalPages}); scrollToTop();" class="pagination-number">${totalPages}</a>`;
            }
            
            paginationHTML += '</div>';
            
            // Next button
            if (currentPage < totalPages) {
                paginationHTML += `
                    <a href="javascript:void(0)" onclick="applyFilters(${currentPage + 1}); scrollToTop();" class="pagination-btn pagination-next">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                `;
            } else {
                paginationHTML += `
                    <span class="pagination-btn pagination-next disabled">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                `;
            }
            
            paginationHTML += '</div>';
            
            // Page info
            paginationHTML += `
                <div class="pagination-info">
                    <i class="fas fa-info-circle"></i>
                    Trang <strong>${currentPage}</strong> / <strong>${totalPages}</strong>
                    <span class="separator">•</span>
                    Tổng <strong>${totalItems}</strong> khóa học
                </div>
            `;
            
            paginationContainer.innerHTML = paginationHTML;
        } else if (!isFiltering) {
            // Show original pagination (reload page to reset)
            paginationContainer.style.display = 'flex';
            paginationContainer.style.opacity = '1';
            paginationContainer.style.transform = 'translateY(0)';
        } else {
            // Hide pagination if only 1 page or less
            paginationContainer.style.display = 'none';
        }
    }
    
    function scrollToTop() {
        const courseSection = document.querySelector('.course-section');
        if (courseSection) {
            courseSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    
    // Update result count with animation
    function updateResultCount(count) {
        const countElement = document.getElementById('result-count');
        const filterCount = document.getElementById('filter-count');
        
        if (countElement && filterCount) {
            // Animate count change
            countElement.style.transform = 'scale(1.3)';
            countElement.style.transition = 'transform 0.3s ease';
            
            setTimeout(() => {
                countElement.textContent = count;
                countElement.style.transform = 'scale(1)';
            }, 150);
        }
    }
    
    function resetFilters() {
        // Add rotation animation to button
        const resetBtn = document.querySelector('.btn-reset-filter i');
        if (resetBtn) {
            resetBtn.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                resetBtn.style.transform = 'rotate(0deg)';
            }, 600);
        }
        
        // Reset all filters
        document.getElementById('filter-sort').value = '';
        document.getElementById('filter-level').value = '';
        
        // Đánh dấu không còn filter
        isFiltering = false;
        currentFilterPage = 1;
        
        // Reload page to restore original state
        window.location.href = 'index.php?nav=khoahoc';
    }
    
    // Add event listeners with smooth transitions
    document.addEventListener('DOMContentLoaded', function() {
        // Initial count - đếm số khóa học đang hiển thị
        const visibleCourses = document.querySelectorAll('.course-card[style*="display: block"], .course-card:not([style*="display: none"])');
        const totalCourses = visibleCourses.length;
        updateResultCount(totalCourses);
        
        // Smooth scroll to top when clicking pagination
        const paginationLinks = document.querySelectorAll('.pagination-number, .pagination-btn');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    scrollToTop();
                }, 100);
            });
        });
        
        // Add change listeners with debounce for smooth performance
        let filterTimeout;
        
        const handleFilterChange = () => {
            clearTimeout(filterTimeout);
            currentFilterPage = 1; // Reset to page 1 when filter changes
            filterTimeout = setTimeout(() => applyFilters(1), 200);
        };
        
        document.getElementById('filter-sort').addEventListener('change', handleFilterChange);
        document.getElementById('filter-level').addEventListener('change', handleFilterChange);
        
        // Add visual feedback on select focus
        const selects = document.querySelectorAll('.filter-select');
        selects.forEach(select => {
            select.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            });
            
            select.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    });
</script>