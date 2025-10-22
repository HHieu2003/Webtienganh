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
                    <span>Sắp xếp</span>
                </label>
                <div class="select-wrapper">
                    <select id="filter-sort" class="filter-select">
                        <option value="">Mặc định</option>
                        <option value="price_asc">💰 Giá: Thấp → Cao</option>
                        <option value="price_desc">💰 Giá: Cao → Thấp</option>
                        <option value="name_asc">📚 Tên: A → Z</option>
                        <option value="name_desc">📚 Tên: Z → A</option>
                        <option value="newest">🆕 Mới nhất</option>
                        <option value="oldest">⏰ Cũ nhất</option>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
            </div>

            <div class="filter-group">
                <label for="filter-price" class="filter-label">
                    <i class="fas fa-tag"></i>
                    <span>Khoảng giá</span>
                </label>
                <div class="select-wrapper">
                    <select id="filter-price" class="filter-select">
                        <option value="">Tất cả mức giá</option>
                        <option value="free">🎁 Miễn phí</option>
                        <option value="under1m">💵 Dưới 1 triệu</option>
                        <option value="1to2m">💴 1-2 triệu</option>
                        <option value="2to3m">💶 2-3 triệu</option>
                        <option value="above3m">💷 Trên 3 triệu</option>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
            </div>

            <div class="filter-group">
                <label for="filter-level" class="filter-label">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Cấp độ</span>
                </label>
                <div class="select-wrapper">
                    <select id="filter-level" class="filter-select">
                        <option value="">Tất cả cấp độ</option>
                        <option value="Beginner">⭐ Beginner (Sơ cấp)</option>
                        <option value="Intermediate">⭐⭐ Intermediate (Trung cấp)</option>
                        <option value="Advanced">⭐⭐⭐ Advanced (Cao cấp)</option>
                        <option value="IELTS">🎯 IELTS</option>
                        <option value="TOEIC">🎯 TOEIC</option>
                        <option value="Business">💼 Business English</option>
                    </select>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
            </div>

            <div class="filter-actions">
                <button class="btn-reset-filter" onclick="resetFilters()">
                    <i class="fas fa-redo-alt"></i>
                    <span>Đặt lại</span>
                </button>
                <div class="filter-count" id="filter-count">
                    <i class="fas fa-check-circle"></i>
                    <span id="result-count">0</span> khóa học
                </div>
            </div>
        </div>
    </div>

    <div class="course-grid" id="course-grid">
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
                $chi_phi_raw = $row['chi_phi']; // Giá gốc không format
                $thoi_gian = $row['thoi_gian'] ?? 0; // Thời lượng
                $cap_do = $row['cap_do'] ?? ''; // Cấp độ
                
                echo '<div class="course-card" 
                          data-aos="fade-up" 
                          data-aos-delay="' . $delay . '"
                          data-price="' . $chi_phi_raw . '"
                          data-duration="' . $thoi_gian . '"
                          data-level="' . htmlspecialchars($cap_do) . '"
                          data-name="' . htmlspecialchars($row["ten_khoahoc"]) . '"
                          data-id="' . $row["id_khoahoc"] . '">     
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
        padding: 40px;
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

    /* Filter Styles - Enhanced Version */
    .filter-container {
        margin-bottom: 40px;
        background: linear-gradient(135deg, #44cc65 0%, #408d68 100%);
        border-radius: 20px;
        padding: 10px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
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
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: filterGlow 8s ease-in-out infinite;
    }

    @keyframes filterGlow {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-30px, -30px); }
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
    }

    .filter-icon {
        font-size: 24px;
        color: #fff;
        animation: filterIconPulse 2s ease-in-out infinite;
    }

    @keyframes filterIconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .filter-title {
        color: #fff;
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .filter-controls {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .filter-label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-label i {
        font-size: 16px;
        opacity: 0.9;
    }

    .select-wrapper {
        position: relative;
    }

    .select-arrow {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .filter-select:focus + .select-arrow {
        transform: translateY(-50%) rotate(180deg);
        color: #764ba2;
    }

    .filter-select {
        width: 100%;
        padding: 14px 40px 14px 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        font-size: 15px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        font-weight: 500;
        color: #333;
    }

    .filter-select:hover {
        background: #fff;
        border-color: rgba(255,255,255,0.6);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .filter-select:focus {
        outline: none;
        border-color: #fff;
        background: #fff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transform: translateY(-3px);
    }

    .filter-select option {
        padding: 10px;
        background: #fff;
        color: #333;
    }

    .filter-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        justify-content: center;
    }

    .btn-reset-filter {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-reset-filter:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255,255,255,0.6);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .btn-reset-filter:active {
        transform: translateY(-1px) scale(1.02);
    }

    .btn-reset-filter i {
        transition: transform 0.6s ease;
    }

    .btn-reset-filter:hover i {
        transform: rotate(360deg);
    }

    .filter-count {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        color: #667eea;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        animation: countFadeIn 0.5s ease;
    }

    @keyframes countFadeIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .filter-count i {
        color: #0db33b;
        font-size: 16px;
    }

    #result-count {
        color: #764ba2;
        font-size: 18px;
        font-weight: 800;
    }

    /* Responsive for filters */
    @media (max-width: 1024px) {
        .filter-controls {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filter-actions {
            grid-column: 1 / -1;
            flex-direction: row;
        }
    }

    @media (max-width: 768px) {
        .filter-container {
            padding: 20px;
            border-radius: 15px;
        }

        .filter-controls {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .filter-title {
            font-size: 20px;
        }

        .filter-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .filter-header {
            flex-direction: column;
            text-align: center;
            gap: 8px;
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
</style>

<script>
    // Course filter functionality with smooth animations
    function applyFilters() {
        const sortValue = document.getElementById('filter-sort').value;
        const priceValue = document.getElementById('filter-price').value;
        const levelValue = document.getElementById('filter-level').value;
        
        // Get all course cards
        const courseCards = Array.from(document.querySelectorAll('.course-card'));
        
        // Filter by price range
        let filteredCards = courseCards.filter(card => {
            const price = parseInt(card.dataset.price);
            
            switch(priceValue) {
                case '':
                    return true;
                case 'free':
                    return price === 0;
                case 'under1m':
                    return price > 0 && price < 1000000;
                case '1to2m':
                    return price >= 1000000 && price < 2000000;
                case '2to3m':
                    return price >= 2000000 && price < 3000000;
                case 'above3m':
                    return price >= 3000000;
                default:
                    return true;
            }
        });
        
        // Filter by level (cấp độ)
        filteredCards = filteredCards.filter(card => {
            const level = card.dataset.level || '';
            
            if (levelValue === '') {
                return true;
            }
            
            // Kiểm tra xem cấp độ có chứa giá trị filter không (case-insensitive)
            return level.toLowerCase().includes(levelValue.toLowerCase());
        });
        
        // Sort courses
        filteredCards.sort((a, b) => {
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
        
        // Update result count with animation
        updateResultCount(filteredCards.length);
        
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
            filteredCards.forEach((card, index) => {
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
            if (filteredCards.length === 0) {
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
            
            // Pulse animation for filter count
            filterCount.style.animation = 'none';
            setTimeout(() => {
                filterCount.style.animation = 'countFadeIn 0.5s ease';
            }, 10);
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
        document.getElementById('filter-price').value = '';
        document.getElementById('filter-level').value = '';
        
        // Apply filters with animation
        setTimeout(() => {
            applyFilters();
        }, 300);
    }
    
    // Add event listeners with smooth transitions
    document.addEventListener('DOMContentLoaded', function() {
        // Initial count
        const totalCourses = document.querySelectorAll('.course-card').length;
        updateResultCount(totalCourses);
        
        // Add change listeners with debounce for smooth performance
        let filterTimeout;
        
        const handleFilterChange = () => {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(applyFilters, 200);
        };
        
        document.getElementById('filter-sort').addEventListener('change', handleFilterChange);
        document.getElementById('filter-price').addEventListener('change', handleFilterChange);
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