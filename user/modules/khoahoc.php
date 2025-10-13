<?php
// user/modules/khoahoc.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ.");
}
$id_hocvien = $_SESSION['id_hocvien'];

// --- Xử lý bộ lọc ---
$filter = $_GET['filter'] ?? 'all';
$where_clause = '';
// Chỉ hiển thị các khóa học đã được xác nhận thanh toán và đã được xếp lớp
$base_condition = "dk.trang_thai = 'da xac nhan' AND dk.id_lop IS NOT NULL";

switch ($filter) {
    case 'active':
        // Đang học: là các lớp có trạng thái 'dang hoc'
        $where_clause = "AND lh.trang_thai = 'dang hoc'";
        break;
    case 'completed':
        // Đã hoàn thành: là các lớp có trạng thái 'da xong'
        $where_clause = "AND lh.trang_thai = 'da xong'";
        break;
    // 'all' sẽ không thêm điều kiện nào khác
}

// --- CẬP NHẬT CÂU TRUY VẤN: Lấy thêm ten_lop ---
$sql = "
    SELECT 
        dk.id_dangky, 
        dk.id_khoahoc, 
        kh.ten_khoahoc, 
        kh.hinh_anh,
        lh.ten_lop,
        gv.ten_giangvien, 
        dk.ngay_dangky, 
        lh.trang_thai AS trang_thai_lop,
        td.tien_do
    FROM dangkykhoahoc dk
    JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
    LEFT JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien
    LEFT JOIN tien_do_hoc_tap td ON dk.id_hocvien = td.id_hocvien AND kh.id_khoahoc = td.id_khoahoc AND dk.id_lop = td.id_lop
    WHERE dk.id_hocvien = ? AND $base_condition $where_clause
    ORDER BY dk.ngay_dangky DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

// Hàm để tạo badge trạng thái mới
function get_status_badge_new($status) {
    if ($status === 'dang hoc') {
        return '<span class="badge status-badge status-active">Đang học</span>';
    } elseif ($status === 'da xong') {
        return '<span class="badge status-badge status-completed">Đã hoàn thành</span>';
    } else {
        // Fallback cho trường hợp chưa có trạng thái lớp
        return '<span class="badge status-badge status-pending">Chờ cập nhật</span>';
    }
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .filter-buttons {
        background: #fff;
        padding: 10px;
        border-radius: 50px;
        display: inline-flex;
        box-shadow: var(--shadow);
    }
    .filter-buttons .btn {
        border-radius: 50px;
        font-weight: 500;
        border: none;
        padding: 8px 20px;
    }
    .filter-buttons .btn.active {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(13, 179, 59, 0.3);
    }

    .my-course-card {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
        border: 1px solid var(--border-color);
    }
    .my-course-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }
    
    .card-image {
        position: relative;
    }
    .card-image img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
    }
    .card-status {
        position: absolute;
        top: 15px;
        right: 15px;
    }
    .status-badge {
        font-size: 13px;
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 50px;
    }
    .status-active { background-color: #d1e7dd; color: #0f5132; }
    .status-completed { background-color: #e2e3e5; color: #41464b; }
    .status-pending { background-color: #fff3cd; color: #664d03; }

    .card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .card-content h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .card-content .course-meta {
        font-size: 14px;
        color: var(--gray-text);
        margin-bottom: 7px;
        flex-grow: 1; /* Đẩy thanh tiến độ xuống dưới */
    }
    .card-content .course-meta p {
        margin-bottom: 5px;
    }
    .card-content .course-meta i {
        margin-right: 8px;
        color: var(--primary-color);
        width: 16px;
        text-align: center;
    }
    
    .progress-info {
        margin-top: 5px;
    }
    .progress-info .info {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 5px;
        color: var(--gray-text);
    }
    
    .card-actions {
        padding: 20px;
        border-top: 1px solid var(--border-color);
    }
    .btn-primary-custom {
        background-color: var(--primary-color);
        color: #fff;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        text-align: center;
    }
    .btn-primary-custom:hover {
        background-color: var(--primary-color-dark);
        color: #fff;
        transform: translateY(-2px);
    }
</style>
<div class="content-pane">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h2>Khóa học của tôi</h2>
        <div class="filter-buttons mt-3 mt-md-0">
            <a href="?nav=khoahoc&filter=all" class="btn <?php echo ($filter == 'all') ? 'active' : 'btn-light'; ?>">Tất cả</a>
            <a href="?nav=khoahoc&filter=active" class="btn <?php echo ($filter == 'active') ? 'active' : 'btn-light'; ?>">Đang học</a>
            <a href="?nav=khoahoc&filter=completed" class="btn <?php echo ($filter == 'completed') ? 'active' : 'btn-light'; ?>">Đã hoàn thành</a>
        </div>
    </div>

    <div class="course-list-container">
        <?php if ($result->num_rows > 0): ?>
            <div class="row g-4">
                <?php 
                $index = 0;
                while ($row = $result->fetch_assoc()): 
                    $progress = $row['tien_do'] ?? 0;
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="my-course-card" style="animation-delay: <?php echo $index * 100; ?>ms;">
                            <div class="card-image">
                                <a href="dashboard.php?nav=lichhoc&id_khoahoc=<?php echo $row['id_khoahoc']; ?>">
                                    <img src="../<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row['ten_khoahoc']); ?>">
                                </a>
                                <div class="card-status">
                                    <?php echo get_status_badge_new($row['trang_thai_lop']); ?>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($row['ten_khoahoc']); ?></h3>
                                <div class="course-meta">
                                    <p><i class="fa-solid fa-school"></i> <strong>Lớp:</strong> <?php echo htmlspecialchars($row['ten_lop'] ?? 'N/A'); ?></p>
                                    <p><i class="fa-solid fa-chalkboard-user"></i> <strong>GV:</strong> <?php echo htmlspecialchars($row['ten_giangvien'] ?? 'Chưa xếp'); ?></p>
                                </div>
                                
                                <div class="progress-info">
                                    <div class="info">
                                        <span>Tiến độ</span>
                                        <strong><?php echo round($progress); ?>%</strong>
                                    </div>
                                    <div class="progress" style="height: 8px;" role="progressbar" aria-valuenow="<?php echo $progress; ?>">
                                        <div class="progress-bar" style="width: <?php echo $progress; ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-actions">
                                <?php if ($row['trang_thai_lop'] === 'dang hoc'): ?>
                                    <a href="dashboard.php?nav=lichhoc&id_khoahoc=<?php echo $row['id_khoahoc']; ?>" class="btn-primary-custom w-100">Lịch học</a>
                                <?php elseif ($row['trang_thai_lop'] === 'da xong'): ?>
                                    <a href="dashboard.php?nav=bangdiem" class="btn btn-outline-secondary w-100">Xem lại kết quả</a>
                                <?php else: ?>
                                     <span class="text-muted d-block text-center">Chưa có hoạt động</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php 
                    $index++;
                endwhile; 
                ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light text-center mt-4">
                 <i class="fa-solid fa-box-open fa-3x mb-3 text-muted"></i>
                 <p class="mb-0">Không có khóa học nào trong mục này.</p>
            </div>
        <?php endif; ?>
    </div>
</div>