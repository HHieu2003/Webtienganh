<div class="final-blog-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="introduce-title">BLOG & CHIA SẺ KIẾN THỨC</h2>
            <p class="section-subtitle">Cập nhật những phương pháp và tài liệu học tiếng Anh hiệu quả nhất từ cộng đồng.</p>
        </div>

        <div class="row gx-lg-5">
            <div class="col-lg-8">
                <?php
                // --- LOGIC PHP MỚI ĐỂ LẤY BÀI VIẾT ---

                // Biến cho tìm kiếm
                $search_query = isset($_GET['blog_search']) ? trim($_GET['blog_search']) : '';

                // Lấy bài viết nổi bật (bài mới nhất) - chỉ khi không tìm kiếm
                $featured_post = null;
                if (empty($search_query)) {
                    $sql_featured = "SELECT bv.id_baiviet, bv.tieu_de, bv.noi_dung, bv.hinh_anh_tieu_de, bv.ngay_duyet, hv.ten_hocvien 
                                     FROM bai_viet bv
                                     LEFT JOIN hocvien hv ON bv.id_tac_gia = hv.id_hocvien
                                     WHERE bv.trang_thai = 'da_duyet' ORDER BY bv.ngay_duyet DESC LIMIT 1";
                    $result_featured = $conn->query($sql_featured);
                    if ($result_featured->num_rows > 0) {
                        $featured_post = $result_featured->fetch_assoc();
                    }
                }

                // Lấy các bài viết còn lại (hoặc tất cả nếu có tìm kiếm)
                $sql_posts = "SELECT bv.id_baiviet, bv.tieu_de, bv.noi_dung, bv.hinh_anh_tieu_de, bv.ngay_duyet, hv.ten_hocvien 
                              FROM bai_viet bv
                              LEFT JOIN hocvien hv ON bv.id_tac_gia = hv.id_hocvien
                              WHERE bv.trang_thai = 'da_duyet'";
                
                $params = [];
                $types = '';

                // Nếu có bài nổi bật, loại trừ nó khỏi danh sách chính
                if ($featured_post) {
                    $sql_posts .= " AND bv.id_baiviet != ?";
                    $params[] = $featured_post['id_baiviet'];
                    $types .= 'i';
                }

                // Nếu có tìm kiếm
                if (!empty($search_query)) {
                    $sql_posts .= " AND bv.tieu_de LIKE ?";
                    $params[] = '%' . $search_query . '%';
                    $types .= 's';
                }

                $sql_posts .= " ORDER BY bv.ngay_duyet DESC";
                
                $stmt_posts = $conn->prepare($sql_posts);
                if (!empty($params)) {
                    $stmt_posts->bind_param($types, ...$params);
                }
                $stmt_posts->execute();
                $other_posts = $stmt_posts->get_result();

                // Hiển thị bài viết nổi bật
                if ($featured_post) :
                ?>
                    <div class="featured-post-card" data-aos="fade-up">
                        <a href="index.php?nav=blog_single&id=<?php echo $featured_post['id_baiviet']; ?>" class="featured-image-link">
                            <img src="<?php echo htmlspecialchars($featured_post['hinh_anh_tieu_de'] ?? 'https://img.freepik.com/free-photo/learning-education-ideas-insight-intelligence-study-concept_53876-120116.jpg'); ?>" alt="<?php echo htmlspecialchars($featured_post['tieu_de']); ?>">
                        </a>
                        <div class="featured-content">
                            <div class="post-meta">
                                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($featured_post['ten_hocvien'] ?? 'Admin'); ?></span>
                                <span><i class="fas fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($featured_post['ngay_duyet'])); ?></span>
                            </div>
                            <h3 class="featured-title">
                                <a href="index.php?nav=blog_single&id=<?php echo $featured_post['id_baiviet']; ?>"><?php echo htmlspecialchars($featured_post['tieu_de']); ?></a>
                            </h3>
                            <p class="featured-excerpt"><?php echo htmlspecialchars(substr(strip_tags($featured_post['noi_dung']), 0, 150)) . '...'; ?></p>
                            <a href="index.php?nav=blog_single&id=<?php echo $featured_post['id_baiviet']; ?>" class="read-more-btn">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="posts-grid">
                    <?php
                    if ($other_posts->num_rows > 0):
                        $delay = 0;
                        while($post = $other_posts->fetch_assoc()):
                    ?>
                    <div class="post-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <a href="index.php?nav=blog_single&id=<?php echo $post['id_baiviet']; ?>" class="post-image-link">
                            <img src="<?php echo htmlspecialchars($post['hinh_anh_tieu_de'] ?? 'https://img.freepik.com/free-photo/learning-education-ideas-insight-intelligence-study-concept_53876-120116.jpg'); ?>" alt="<?php echo htmlspecialchars($post['tieu_de']); ?>">
                        </a>
                        <div class="post-content">
                            <div class="post-meta">
                                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($post['ten_hocvien'] ?? 'Admin'); ?></span>
                                <span><i class="fas fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($post['ngay_duyet'])); ?></span>
                            </div>
                            <h4 class="post-title">
                                <a href="index.php?nav=blog_single&id=<?php echo $post['id_baiviet']; ?>"><?php echo htmlspecialchars($post['tieu_de']); ?></a>
                            </h4>
                            <p class="post-excerpt"><?php echo htmlspecialchars(substr(strip_tags($post['noi_dung']), 0, 80)) . '...'; ?></p>
                        </div>
                    </div>
                    <?php $delay = ($delay + 100) % 300; endwhile; elseif (!$featured_post): ?>
                        <div class="col-12 text-center mt-4">
                            <p class="alert alert-info">Không tìm thấy bài viết nào.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <?php if (isset($_SESSION['id_hocvien'])): ?>
                    <div class="sidebar-widget" data-aos="fade-left">
                        <a href="user/dashboard.php?nav=viet_bai" class="btn-write-post">
                            <i class="fas fa-pen-to-square"></i>
                            <span>Viết bài chia sẻ kiến thức</span>
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
                        <h4 class="widget-title">Tìm kiếm bài viết</h4>
                        <form method="GET" action="index.php" class="sidebar-search-form">
                            <input type="hidden" name="nav" value="blog">
                            <input type="text" name="blog_search" placeholder="Nhập từ khóa...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="200">
                        <h4 class="widget-title">Chủ đề nổi bật</h4>
                        <ul class="category-list">
                            <li><a href="#">Mẹo học từ vựng <span class="count">12</span></a></li>
                            <li><a href="#">Luyện thi IELTS <span class="count">8</span></a></li>
                            <li><a href="#">Ngữ pháp cơ bản <span class="count">15</span></a></li>
                            <li><a href="#">Tiếng Anh giao tiếp <span class="count">5</span></a></li>
                        </ul>
                    </div>

                    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="300">
                        <h4 class="widget-title">Bài viết gần đây</h4>
                        <ul class="recent-posts-list">
                            <?php
                            $sql_recent = "SELECT id_baiviet, tieu_de, ngay_duyet, hinh_anh_tieu_de FROM bai_viet WHERE trang_thai = 'da_duyet' ORDER BY ngay_duyet DESC LIMIT 4";
                            $result_recent = $conn->query($sql_recent);
                            if($result_recent->num_rows > 0):
                                while($recent_post = $result_recent->fetch_assoc()):
                            ?>
                            <li>
                                <a href="index.php?nav=blog_single&id=<?php echo $recent_post['id_baiviet']; ?>">
                                    <img src="<?php echo htmlspecialchars($recent_post['hinh_anh_tieu_de'] ?? 'https://via.placeholder.com/80'); ?>" alt="<?php echo htmlspecialchars($recent_post['tieu_de']); ?>">
                                    <div class="post-info">
                                        <p class="title"><?php echo htmlspecialchars($recent_post['tieu_de']); ?></p>
                                        <span class="date"><?php echo date("d/m/Y", strtotime($recent_post['ngay_duyet'])); ?></span>
                                    </div>
                                </a>
                            </li>
                            <?php endwhile; endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ==========================================================
   CSS HOÀN TOÀN ĐỘC LẬP CHO TRANG BLOG
   ========================================================== */

/* --- Biến màu cục bộ --- */
.final-blog-section {
    --brand-color: #0db33b;
    --brand-color-dark: #0a8a2c;
    --text-dark: #212529;
    --text-light: #6c757d;
    --white: #fff;
    --bg-light: #f8f9fa;
    --border-color: #e9ecef;
    --shadow-soft: 0 8px 25px rgba(0, 0, 0, 0.07);
}

/* --- Section Container --- */
.final-blog-section {
    padding: 60px 0;
    background-color: var(--bg-light);
}

/* --- Card bài viết nổi bật --- */
.final-blog-section .featured-post-card {
    background: var(--white);
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    margin-bottom: 40px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.final-blog-section .featured-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
}
.final-blog-section .featured-image-link {
    display: block;
    overflow: hidden;
}
.final-blog-section .featured-image-link img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.final-blog-section .featured-post-card:hover .featured-image-link img {
    transform: scale(1.05);
}
.final-blog-section .featured-content {
    padding: 30px;
}
.final-blog-section .post-meta {
    font-size: 14px;
    color: var(--text-light);
    margin-bottom: 15px;
}
.final-blog-section .post-meta span {
    margin-right: 20px;
}
.final-blog-section .post-meta i {
    margin-right: 5px;
    color: var(--brand-color);
}
.final-blog-section .featured-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
}
.final-blog-section .featured-title a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.3s ease;
}
.final-blog-section .featured-title a:hover {
    color: var(--brand-color);
}
.final-blog-section .featured-excerpt {
    font-size: 16px;
    color: var(--text-light);
    line-height: 1.7;
    margin-bottom: 20px;
}
.final-blog-section .read-more-btn {
    color: var(--brand-color-dark);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.final-blog-section .read-more-btn i {
    transition: transform 0.3s ease;
}
.final-blog-section .read-more-btn:hover i {
    transform: translateX(5px);
}

/* --- Lưới các bài viết còn lại --- */
.final-blog-section .posts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}
.final-blog-section .post-card {
    background: var(--white);
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: all 0.3s ease;
}
.final-blog-section .post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
}
.final-blog-section .post-image-link {
    display: block;
    overflow: hidden;
}
.final-blog-section .post-image-link img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.final-blog-section .post-card:hover .post-image-link img {
    transform: scale(1.05);
}
.final-blog-section .post-content {
    padding: 20px;
}
.final-blog-section .post-title {
    font-size: 20px;
    font-weight: 600;
    margin-top: 10px;
    margin-bottom: 10px;
}
.final-blog-section .post-title a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.3s ease;
}
.final-blog-section .post-title a:hover {
    color: var(--brand-color);
}
.final-blog-section .post-excerpt {
    font-size: 14px;
    color: var(--text-light);
    height: 42px;
    overflow: hidden;
}

/* --- Sidebar --- */
.final-blog-section .blog-sidebar {
    position: -webkit-sticky;
    position: sticky;
    top: 120px;
}
.final-blog-section .sidebar-widget {
    background: var(--white);
    padding: 25px;
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    margin-bottom: 30px;
}
.final-blog-section .widget-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
    position: relative;
}
.final-blog-section .widget-title::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 50px; height: 3px;
    background: var(--brand-color);
    border-radius: 2px;
}

/* Nút viết bài */
.final-blog-section .btn-write-post {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px;
    font-size: 16px;
    font-weight: 600;
    color: var(--white);
    background: linear-gradient(45deg, var(--brand-color-dark), var(--brand-color));
    border: none;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.final-blog-section .btn-write-post:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(13, 179, 59, 0.3);
    color: var(--white);
}

/* Sidebar Search */
.final-blog-section .sidebar-search-form {
    position: relative;
}
.final-blog-section .sidebar-search-form input {
    width: 100%;
    height: 45px;
    border-radius: 50px;
    border: 1px solid var(--border-color);
    padding: 0 50px 0 20px;
}
.final-blog-section .sidebar-search-form button {
    position: absolute;
    right: 5px; top: 5px;
    height: 35px; width: 35px;
    border-radius: 50%;
    border: none;
    background: var(--brand-color);
    color: var(--white);
    cursor: pointer;
}

/* Sidebar Categories */
.final-blog-section .category-list {
    list-style: none;
    padding: 0;
}
.final-blog-section .category-list li a {
    display: flex;
    justify-content: space-between;
    padding: 12px 15px;
    color: var(--text-light);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}
.final-blog-section .category-list li a:hover {
    background: var(--bg-light);
    color: var(--brand-color);
    transform: translateX(5px);
}
.final-blog-section .category-list .count {
    background: #e9ecef;
    padding: 2px 8px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
}

/* Sidebar Recent Posts */
.final-blog-section .recent-posts-list {
    list-style: none;
    padding: 0;
}
.final-blog-section .recent-posts-list li a {
    display: flex;
    gap: 15px;
    align-items: center;
    text-decoration: none;
    padding: 10px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}
.final-blog-section .recent-posts-list li a:hover {
    background: var(--bg-light);
}
.final-blog-section .recent-posts-list img {
    width: 70px;
    height: 70px;
    border-radius: 8px;
    object-fit: cover;
}
.final-blog-section .recent-posts-list .post-info .title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 5px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.final-blog-section .recent-posts-list .post-info .date {
    font-size: 12px;
    color: var(--text-light);
}

/* --- Responsive --- */
@media (max-width: 991px) {
    .final-blog-section .posts-grid { grid-template-columns: 1fr; }
    .final-blog-section .featured-image-link img { height: 300px; }
}
@media (max-width: 576px) {
    .final-blog-section .featured-image-link img { height: 250px; }
    .final-blog-section .featured-title { font-size: 24px; }
}

</style>