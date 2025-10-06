<?php
// user/modules/khoahoc.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ.");
}
$id_hocvien = $_SESSION['id_hocvien'];

// --- Xử lý bộ lọc ---
$filter = $_GET['filter'] ?? 'all';
$where_clause = '';
switch ($filter) {
    case 'active':
        $where_clause = "AND dk.trang_thai = 'da xac nhan'";
        break;
    case 'pending':
        $where_clause = "AND dk.trang_thai = 'cho xac nhan'";
        break;
    case 'cancelled':
        $where_clause = "AND (dk.trang_thai = 'da huy' OR dk.trang_thai = 'bi tu choi')";
        break;
}

// --- CẬP NHẬT CÂU TRUY VẤN ---
// Lấy tên giảng viên từ bảng lop_hoc -> giangvien thay vì từ khoahoc
$sql = "
    SELECT 
        dk.id_dangky, 
        dk.id_khoahoc, 
        kh.ten_khoahoc, 
        kh.hinh_anh,
        gv.ten_giangvien, 
        dk.ngay_dangky, 
        dk.trang_thai, 
        dk.id_lop
    FROM dangkykhoahoc dk
    JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
    LEFT JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien
    WHERE dk.id_hocvien = ? 
    $where_clause
    ORDER BY dk.ngay_dangky DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

// Hàm để tạo badge trạng thái
function get_status_badge($status) {
    switch ($status) {
        case 'da xac nhan':
            return '<span class="badge bg-success">Đang học</span>';
        case 'cho xac nhan':
            return '<span class="badge bg-warning text-dark">Chờ thanh toán</span>';
        case 'da huy':
            return '<span class="badge bg-secondary">Đã hủy</span>';
        case 'bi tu choi':
            return '<span class="badge bg-danger">Bị từ chối</span>';
        default:
            return '<span class="badge bg-light text-dark">' . htmlspecialchars($status) . '</span>';
    }
}
?>

<div class="content-pane">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tất cả khóa học</h2>
        <div class="filter-buttons">
            <a href="?nav=khoahoc&filter=all" class="btn btn-sm <?php echo ($filter == 'all') ? 'btn-primary' : 'btn-outline-primary'; ?>">Tất cả</a>
            <a href="?nav=khoahoc&filter=active" class="btn btn-sm <?php echo ($filter == 'active') ? 'btn-success' : 'btn-outline-success'; ?>">Đang học</a>
            <a href="?nav=khoahoc&filter=pending" class="btn btn-sm <?php echo ($filter == 'pending') ? 'btn-warning' : 'btn-outline-warning'; ?>">Chờ thanh toán</a>
            <a href="?nav=khoahoc&filter=cancelled" class="btn btn-sm <?php echo ($filter == 'cancelled') ? 'btn-outline-secondary' : 'btn-outline-secondary'; ?>">Đã hủy</a>
        </div>
    </div>

    <div class="course-list-container">
        <?php if ($result->num_rows > 0): ?>
            <div class="row g-4">
                <?php 
                $index = 0;
                while ($row = $result->fetch_assoc()): 
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="my-course-card <?php echo ($row['trang_thai'] == 'da huy' || $row['trang_thai'] == 'bi tu choi') ? 'cancelled' : ''; ?>" style="animation-delay: <?php echo $index * 100; ?>ms;">
                            <div class="card-image">
                                <img src="../<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row['ten_khoahoc']); ?>">
                                <div class="card-status">
                                    <?php echo get_status_badge($row['trang_thai']); ?>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($row['ten_khoahoc']); ?></h3>
                                <p class="instructor"><i class="fa-solid fa-chalkboard-user"></i> <?php echo htmlspecialchars($row['ten_giangvien'] ?? 'Chưa xếp lớp'); ?></p>
                                <p class="date"><i class="fa-solid fa-calendar-day"></i> Ngày đăng ký: <?php echo date("d/m/Y", strtotime($row['ngay_dangky'])); ?></p>
                            </div>
                            <div class="card-actions">
                                <?php if ($row['trang_thai'] === 'da xac nhan' && $row['id_lop'] !== null): ?>
                                    <a href="dashboard.php?nav=lichhoc&id_khoahoc=<?php echo $row['id_khoahoc']; ?>" class="btn btn-primary-custom w-100">Xem lịch học</a>
                                <?php elseif ($row['trang_thai'] === 'da xac nhan' && $row['id_lop'] === null): ?>
                                     <span class="text-muted small d-block text-center">Chờ xếp lớp...</span>
                                <?php elseif ($row['trang_thai'] === 'cho xac nhan'): ?>
                                    <a href="../pages/main/thanhtoan/checkout.php?dangky_id=<?php echo $row['id_dangky']; ?>" class="btn btn-success w-100 mb-2">Thanh toán ngay</a>
                                    <a href="modules/cancel_registration.php?id=<?php echo $row['id_dangky']; ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký này?');">Hủy đăng ký</a>
                                <?php else: ?>
                                    <a href="../index.php?nav=course_detail&course_id=<?php echo $row['id_khoahoc']; ?>" class="btn btn-secondary w-100">Đăng ký lại</a>
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
            <div class="alert alert-info text-center">Không có khóa học nào phù hợp với bộ lọc đã chọn.</div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* CSS được giữ nguyên */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .filter-buttons .btn { margin-left: 5px; font-weight: 500; }
    .my-course-card { background-color: #fff; border-radius: var(--border-radius); box-shadow: var(--shadow); display: flex; flex-direction: column; height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; opacity: 0; animation: fadeInUp 0.5s ease-out forwards; }
    .my-course-card:hover { transform: translateY(-5px); }
    .my-course-card.cancelled { opacity: 0.7; animation: none; }
    .my-course-card.cancelled:hover { opacity: 1; }
    .card-image { position: relative; }
    .card-image img { width: 100%; height: 180px; object-fit: cover; border-top-left-radius: var(--border-radius); border-top-right-radius: var(--border-radius); }
    .card-status { position: absolute; top: 15px; right: 15px; }
    .card-content { padding: 20px; flex-grow: 1; }
    .card-content h3 { font-size: 18px; font-weight: 600; margin-bottom: 10px; line-height: 1.4; min-height: 50px; }
    .card-content p { font-size: 14px; color: var(--gray-text); margin-bottom: 8px; }
    .card-content p i { margin-right: 8px; color: var(--primary-color); }
    .card-actions { padding: 0 20px 20px 20px; border-top: 1px solid #f0f0f0; margin-top: auto; padding-top: 20px; }
    .btn-primary-custom { background-color: var(--primary-color); color: #fff; padding: 10px 15px; border-radius: 8px; font-weight: 500; text-decoration: none; display: inline-block; transition: background-color 0.3s ease; text-align: center; }
    .btn-primary-custom:hover { background-color: var(--primary-color-dark); color: #fff; }
</style>