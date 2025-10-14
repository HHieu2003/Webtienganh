<?php
// File: admin/modules/teacher/teacher_classes.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- XỬ LÝ TÌM KIẾM ---
$search_term = $_GET['search'] ?? '';
$sql_search = "";
$params = [$id_giangvien];
$types = "i";

if (!empty($search_term)) {
    $sql_search = " AND (lh.ten_lop LIKE ? OR kh.ten_khoahoc LIKE ?)";
    $search_param = "%" . $search_term . "%";
    array_push($params, $search_param, $search_param);
    $types .= "ss";
}
// --- KẾT THÚC XỬ LÝ TÌM KIẾM ---

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
    <div class="card animated-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                 <h4 class="mb-0"><i class="fa-solid fa-school me-2"></i>Lớp học của tôi</h4>
                 <form method="GET" action="./admin.php" class="d-flex">
                    <input type="hidden" name="nav" value="teacher_classes">
                    <input type="text" name="search" class="form-control" placeholder="Tìm tên lớp, khóa học..." value="<?php echo htmlspecialchars($search_term); ?>" style="min-width: 200px;">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
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
                <div class="alert alert-light text-center">
                    <i class="fa-solid fa-school-circle-xmark fa-3x mb-3 text-muted"></i>
                    <?php if (!empty($search_term)): ?>
                        <p class="mb-0">Không tìm thấy lớp học nào phù hợp với từ khóa "<strong><?php echo htmlspecialchars($search_term); ?></strong>".</p>
                    <?php else: ?>
                        <p class="mb-0">Bạn chưa được phân công lớp học nào.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>