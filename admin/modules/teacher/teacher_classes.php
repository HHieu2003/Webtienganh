<?php
// File: admin/modules/teacher/teacher_classes.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- BỔ SUNG: XỬ LÝ TÌM KIẾM ---
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
// --- KẾT THÚC BỔ SUNG ---

// --- CẬP NHẬT CÂU TRUY VẤN ---
$sql = "
    SELECT lh.id_lop, lh.ten_lop, kh.ten_khoahoc, lh.so_luong_hoc_vien, lh.trang_thai
    FROM lop_hoc lh
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE lh.id_giangvien = ?
    $sql_search
    ORDER BY kh.ten_khoahoc, lh.ten_lop
";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
// --- KẾT THÚC CẬP NHẬT ---

$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .class-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 4px solid var(--primary-color);
    }
    .class-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .card-header-custom {
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
    }
    .class-card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-text);
        margin: 0;
    }
    .class-card .card-subtitle {
        font-size: 0.9rem;
        color: var(--gray-text);
    }
    .card-body-custom {
        padding: 25px;
        flex-grow: 1; /* Đẩy footer xuống dưới */
    }
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .info-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: 1rem;
    }
    .info-list li:not(:last-child) {
        border-bottom: 1px dashed #e0e0e0;
    }
    .info-list i {
        margin-right: 10px;
        color: var(--primary-color);
    }
    .card-footer-custom {
        background-color: #f8f9fa;
        padding: 15px 25px;
        border-top: 1px solid #f0f0f0;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .card-footer-custom .btn-group {
        display: flex;
        width: 100%;
    }
    .card-footer-custom .btn {
        flex: 1; /* Các nút có chiều rộng bằng nhau */
    }
</style>
<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
             <h4 class="mb-0"><i class="fa-solid fa-school me-2"></i>Lớp học của tôi</h4>
             
             <form method="GET" action="./admin.php" class="d-flex">
                <input type="hidden" name="nav" value="teacher_classes">
                <input type="text" name="search" class="form-control" placeholder="Tìm tên lớp, khóa học..." value="<?php echo htmlspecialchars($search_term); ?>" style="min-width: 250px;">
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
                ?>
                    <div class="col-lg-4 col-md-6 animated-card" style="animation-delay: <?php echo $index++ * 70; ?>ms;">
                        <div class="class-card">
                            <div class="card-header-custom">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['ten_lop']); ?></h5>
                                <h6 class="card-subtitle text-muted"><?php echo htmlspecialchars($row['ten_khoahoc']); ?></h6>
                            </div>
                            <div class="card-body-custom">
                                <ul class="info-list">
                                    <li>
                                        <span><i class="fa-solid fa-users"></i> Sĩ số</span>
                                        <span class="fw-bold badge bg-primary rounded-pill"><?php echo $row['so_luong_hoc_vien']; ?></span>
                                    </li>
                                    <li>
                                        <span><i class="fa-solid fa-signal"></i> Trạng thái</span>
                                        <?php if ($row['trang_thai'] === 'dang hoc'): ?>
                                            <span class="badge bg-success">Đang học</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Đã xong</span>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer-custom">
                                <div class="btn-group" role="group">
                                    <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=schedule" class="btn btn-outline-info" title="Xem lịch học"><i class="fa-solid fa-calendar-days"></i></a>
                                    <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=students" class="btn btn-outline-secondary" title="Xem học viên"><i class="fa-solid fa-users"></i></a>
                                    <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=diemdanh" class="btn btn-outline-primary" title="Điểm danh"><i class="fa-solid fa-user-check"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <?php if (!empty($search_term)): ?>
                    Không tìm thấy lớp học nào phù hợp với từ khóa "<strong><?php echo htmlspecialchars($search_term); ?></strong>".
                <?php else: ?>
                    Bạn chưa được phân công lớp học nào.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        </div>
</div>