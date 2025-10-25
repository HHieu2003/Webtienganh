<?php
// File: admin/modules/teacher/teacher_classes.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- XỬ LÝ TÌM KIẾM VÀ LỌC ---
$search_term = $_GET['search'] ?? '';
$status_filter = $_GET['status'] ?? '';

$sql_search = "";
$params = [$id_giangvien];
$types = "i";

if (!empty($search_term)) {
    $sql_search .= " AND (lh.ten_lop LIKE ? OR kh.ten_khoahoc LIKE ?)";
    $search_param = "%" . $search_term . "%";
    array_push($params, $search_param, $search_param);
    $types .= "ss";
}

if (!empty($status_filter)) {
    $sql_search .= " AND lh.trang_thai = ?";
    array_push($params, $status_filter);
    $types .= "s";
}
// --- KẾT THÚC XỬ LÝ TÌM KIẾM VÀ LỌC ---

// --- COUNT STATISTICS ---
$count_sql = "
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN lh.trang_thai = 'dang hoc' THEN 1 ELSE 0 END) as active_count,
        SUM(CASE WHEN lh.trang_thai = 'da xong' THEN 1 ELSE 0 END) as completed_count
    FROM lop_hoc lh
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE lh.id_giangvien = ?
";
$stmt_count = $conn->prepare($count_sql);
$stmt_count->bind_param("i", $id_giangvien);
$stmt_count->execute();
$stats = $stmt_count->get_result()->fetch_assoc();
$stmt_count->close();

$sql = "
    SELECT lh.id_lop, lh.ten_lop, kh.ten_khoahoc, lh.so_luong_hoc_vien, lh.trang_thai
    FROM lop_hoc lh
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE lh.id_giangvien = ?
    $sql_search
    ORDER BY lh.trang_thai ASC, kh.ten_khoahoc, lh.ten_lop
";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animated-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }

    /* Search & Filter Bar */
    .search-filter-bar {
        background-color: #fff;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #dee2e6;
    }

    .search-filter-bar .form-control,
    .search-filter-bar .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .search-filter-bar .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }

    .filter-stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #dee2e6;
    }

    .filter-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: #e7f7ec;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #0a8a2c;
    }

    .filter-stats .stat-item i {
        font-size: 14px;
        color: #0db33b;
    }

    .filter-stats .stat-item.active-filter {
        background: #0db33b;
        color: white;
    }

    .filter-stats .stat-item.active-filter i {
        color: white;
    }

    /* Giao diện thẻ lớp học mới */
    .class-card-new {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }
    .class-card-new:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: var(--brand-color);
    }

    /* Dải màu trạng thái */
    .class-card-new::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background-color: var(--brand-color); /* Màu xanh cho lớp "Đang học" */
    }
    .class-card-new.status-completed::before {
        background-color: #6c757d; /* Màu xám cho lớp "Đã xong" */
    }

    .card-content-wrapper {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title-new {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark-text);
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-subtitle-new {
        font-size: 0.9rem;
        color: var(--gray-text);
        margin-bottom: 20px;
    }

    .class-stats {
        display: flex;
        justify-content: space-around;
        text-align: center;
        margin-bottom: 20px;
        padding: 15px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }
    .stat-item .stat-value {
        font-size: 1.0rem;
        font-weight: 600;
        color: var(--brand-color-dark);
    }
    .stat-item .stat-label {
        font-size: 0.7rem;
        color: var(--gray-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card-footer-actions {
        margin-top: auto; /* Đẩy footer xuống dưới cùng */
        padding-top: 20px;
    }
    .card-footer-actions .btn-group {
        width: 100%;
    }
    .card-footer-actions .btn {
        flex: 1; /* Chia đều không gian cho các nút */
        padding: 10px 5px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* CSS cho responsive */
    @media (max-width: 576px) {
        .card-content-wrapper { padding: 20px; }
        .card-title-new { font-size: 1.1rem; }
        .stat-item .stat-value { font-size: 1.25rem; }
        .card-footer-actions .btn { font-size: 0.8rem; }
        .d-flex.flex-wrap.gap-2 { justify-content: center !important; }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="title-color mb-0" style="border:none; padding-bottom: 0;"><i class="fa-solid fa-school me-2"></i>Lớp học của tôi</h1>
    </div>

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" class="row g-3 align-items-end">
            <input type="hidden" name="nav" value="teacher_classes">
            
            <div class="col-md-5">
                <label for="search" class="form-label"><i class="fas fa-search me-1"></i> Tìm kiếm</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Nhập tên lớp hoặc khóa học..." 
                       value="<?php echo htmlspecialchars($search_term); ?>">
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label"><i class="fas fa-filter me-1"></i> Trạng thái</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="dang hoc" <?php echo ($status_filter == 'dang hoc') ? 'selected' : ''; ?>>Đang dạy</option>
                    <option value="da xong" <?php echo ($status_filter == 'da xong') ? 'selected' : ''; ?>>Đã hoàn thành</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>

            <div class="col-md-2">
                <a href="?nav=teacher_classes" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-1"></i> Đặt lại
                </a>
            </div>
        </form>

        <!-- Filter Stats -->
        <div class="filter-stats">
            <span class="stat-item">
                <i class="fas fa-school"></i>
                Tổng: <?php echo $stats['total']; ?> lớp
            </span>
            <span class="stat-item">
                <i class="fas fa-chalkboard-teacher"></i>
                Đang dạy: <?php echo $stats['active_count']; ?>
            </span>
            <span class="stat-item">
                <i class="fas fa-check-circle"></i>
                Hoàn thành: <?php echo $stats['completed_count']; ?>
            </span>
            <?php if (!empty($search_term)): ?>
                <span class="stat-item active-filter">
                    <i class="fas fa-search"></i>
                    "<?php echo htmlspecialchars($search_term); ?>"
                </span>
            <?php endif; ?>
            <?php if (!empty($status_filter)): ?>
                <span class="stat-item active-filter">
                    <i class="fas fa-filter"></i>
                    <?php echo ($status_filter == 'dang hoc') ? 'Đang dạy' : 'Đã hoàn thành'; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="card animated-card">
        <div class="card-body">
            
            <?php if ($result->num_rows > 0): ?>
                <div class="row g-4">
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                        $status_class = ($row['trang_thai'] === 'da xong') ? 'status-completed' : '';
                    ?>
                        <div class="col-lg-4 col-md-6 animated-item" style="animation-delay: <?php echo $index++ * 70; ?>ms;">
                            <div class="class-card-new <?php echo $status_class; ?>">
                                <div class="card-content-wrapper">
                                    <div>
                                        <h5 class="card-title-new"><?php echo htmlspecialchars($row['ten_lop']); ?></h5>
                                        <h6 class="card-subtitle-new text-muted"><?php echo htmlspecialchars($row['ten_khoahoc']); ?></h6>
                                    </div>

                                    <div class="class-stats">
                                        <div class="stat-item">
                                            <div class="stat-label">Học viên</div>
                                            <div class="stat-value"><?php echo $row['so_luong_hoc_vien']; ?></div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-label">Trạng thái</div>
                                            <div class="stat-value">
                                                <?php if ($row['trang_thai'] === 'dang hoc'): ?>
                                                    <span class="text-success">Đang dạy</span>
                                                <?php else: ?>
                                                    <span class="text-secondary">Đã xong</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer-actions">
                                        <div class="btn-group" role="group">
                                            <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=schedule" class="btn btn-outline-primary" title="Quản lý Lịch học"><i class="fa-solid fa-calendar-days me-1"></i> <br> Lịch học</a>
                                            <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=students" class="btn btn-outline-secondary" title="Danh sách Học viên"><i class="fa-solid fa-users me-1"></i> <br> Học viên</a>
                                            <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=diemdanh" class="btn btn-outline-info" title="Điểm danh"><i class="fa-solid fa-user-check me-1"></i>  <br>Điểm danh</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-light text-center py-5">
                    <i class="fa-solid fa-school-circle-xmark fa-3x mb-3 text-muted"></i>
                    <h5 class="mb-2">Không tìm thấy lớp học</h5>
                    <p class="mb-3 text-muted">
                        <?php 
                        if (!empty($search_term) && !empty($status_filter)): 
                            $status_text = ($status_filter == 'dang hoc') ? 'đang dạy' : 'đã hoàn thành';
                        ?>
                            Không tìm thấy lớp học nào với từ khóa "<strong><?php echo htmlspecialchars($search_term); ?></strong>" ở trạng thái <strong><?php echo $status_text; ?></strong>.
                        <?php elseif (!empty($search_term)): ?>
                            Không tìm thấy lớp học nào với từ khóa "<strong><?php echo htmlspecialchars($search_term); ?></strong>".
                        <?php elseif (!empty($status_filter)): 
                            $status_text = ($status_filter == 'dang hoc') ? 'đang dạy' : 'đã hoàn thành';
                        ?>
                            Bạn không có lớp học nào ở trạng thái <strong><?php echo $status_text; ?></strong>.
                        <?php else: ?>
                            Bạn chưa được phân công lớp học nào.
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($search_term) || !empty($status_filter)): ?>
                        <a href="?nav=teacher_classes" class="btn btn-outline-primary">
                            <i class="fas fa-redo me-2"></i>Xem tất cả lớp học
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>