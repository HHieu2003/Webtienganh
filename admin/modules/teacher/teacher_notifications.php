<?php
// File: admin/modules/teacher/teacher_notifications.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- Search and Filter parameters ---
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$class_filter = isset($_GET['class_id']) && !empty($_GET['class_id']) ? intval($_GET['class_id']) : '';

// --- Pagination settings ---
$notifications_per_page = 12;
$current_page = isset($_GET['notif_page']) ? max(1, intval($_GET['notif_page'])) : 1;
$offset = ($current_page - 1) * $notifications_per_page;

// --- LẤY DANH SÁCH LỚP HỌC CỦA GIẢNG VIÊN ĐỂ DÙNG TRONG MODAL VÀ FILTER ---
$sql_my_classes = "
    SELECT 
        lh.id_lop, 
        lh.ten_lop,
        COUNT(DISTINCT CONCAT(tb.tieu_de, '_', tb.ngay_tao)) as notification_count
    FROM lop_hoc lh
    LEFT JOIN thongbao tb ON lh.id_lop = tb.id_lop
    WHERE lh.id_giangvien = ? AND lh.trang_thai = 'dang hoc'
    GROUP BY lh.id_lop, lh.ten_lop
    ORDER BY notification_count DESC, lh.ten_lop ASC
";
$stmt_classes = $conn->prepare($sql_my_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$my_classes = $stmt_classes->get_result();

// --- Build WHERE conditions for search/filter ---
$where_conditions = ["lh.id_giangvien = ?"];
$params = [$id_giangvien];
$types = "i";

if (!empty($search_query)) {
    $where_conditions[] = "tb.tieu_de LIKE ?";
    $params[] = "%{$search_query}%";
    $types .= "s";
}

if (!empty($class_filter) && $class_filter !== '') {
    $where_conditions[] = "tb.id_lop = ?";
    $params[] = intval($class_filter);
    $types .= "i";
}

$where_clause = implode(" AND ", $where_conditions);

// --- Count total notifications ---
$sql_count = "
    SELECT COUNT(DISTINCT tb.tieu_de, tb.ngay_tao, tb.id_lop) as total
    FROM thongbao tb
    JOIN lop_hoc lh ON tb.id_lop = lh.id_lop
    WHERE $where_clause
";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param($types, ...$params);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_notifications = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_notifications / $notifications_per_page);

// --- LẤY LỊCH SỬ CÁC THÔNG BÁO ĐÃ GỬI CỦA GIẢNG VIÊN VỚI PAGINATION ---
$sql_history = "
    SELECT DISTINCT
        tb.tieu_de,
        MAX(tb.noi_dung) as noi_dung,
        tb.ngay_tao,
        tb.id_lop,
        lh.ten_lop,
        (SELECT COUNT(DISTINCT id_hocvien) FROM thongbao t_count WHERE t_count.id_lop = tb.id_lop AND t_count.tieu_de = tb.tieu_de AND t_count.ngay_tao = tb.ngay_tao) as student_count
    FROM thongbao tb
    JOIN lop_hoc lh ON tb.id_lop = lh.id_lop
    WHERE $where_clause
    GROUP BY tb.tieu_de, tb.ngay_tao, tb.id_lop, lh.ten_lop
    ORDER BY tb.ngay_tao DESC
    LIMIT ? OFFSET ?
";
$stmt_history = $conn->prepare($sql_history);
$params[] = $notifications_per_page;
$params[] = $offset;
$types .= "ii";
$stmt_history->bind_param($types, ...$params);
$stmt_history->execute();
$history = $stmt_history->get_result();

// Debug: Uncomment để kiểm tra
// echo "<!-- DEBUG: class_filter = '" . htmlspecialchars($class_filter) . "', type = " . gettype($class_filter) . " -->";
// echo "<!-- DEBUG: WHERE = " . htmlspecialchars($where_clause) . " -->";
// echo "<!-- DEBUG: total_notifications = " . $total_notifications . " -->";
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
    .notification-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .notification-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    .card-header-custom {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title-custom {
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
        color: var(--brand-color-dark);
    }
    .card-body-custom {
        padding: 20px;
        flex-grow: 1;
        font-size: 0.95rem;
        color: #555;
    }
    .card-body-custom .content-preview {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 60px;
    }
    .card-footer-custom {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-color-light);
    }
    .meta-item i {
        color: var(--brand-color);
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

    .search-filter-bar .form-select option {
        padding: 8px;
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
        background: #e8f5e9;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #2e7d32;
    }

    .filter-stats .stat-item i {
        font-size: 14px;
    }

    /* Teacher Notification Pagination Styles */
    .teacher-notif-pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
        margin-top: 30px;
    }

    .teacher-notif-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #66eabaff 0%, #4ba254ff 100%);
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.25);
        backdrop-filter: blur(10px);
    }

    .teacher-notif-pagination-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border: none;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .teacher-notif-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        color: #0a8a2c;
    }

    .teacher-notif-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .teacher-notif-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0 10px;
    }

    .teacher-notif-pagination-number {
        min-width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .teacher-notif-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border-color: rgba(255,255,255,0.8);
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    .teacher-notif-pagination-number.active {
        background: #fff;
        color: #0a8a2c;
        border-color: #fff;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        animation: teacherNotifPagePulse 0.4s ease;
    }

    @keyframes teacherNotifPagePulse {
        0%, 100% { transform: scale(1.15); }
        50% { transform: scale(1.25); }
    }

    .teacher-notif-pagination-dots {
        color: rgba(255,255,255,0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .teacher-notif-pagination-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        background: #e8f5e9;
        border-radius: 25px;
        color: #0db33b;
        font-size: 14px;
        font-weight: 600;
        border: 2px solid rgba(13, 179, 59, 0.15);
    }

    .teacher-notif-pagination-info i {
        font-size: 16px;
    }

    .teacher-notif-pagination-info strong {
        color: #0a8a2c;
        font-size: 15px;
    }

    .teacher-notif-pagination-info .separator {
        margin: 0 5px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-filter-bar {
            padding: 15px;
        }

        .teacher-notif-pagination {
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .teacher-notif-pagination-btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .teacher-notif-pagination-btn span {
            display: none;
        }

        .teacher-notif-pagination-number {
            min-width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .teacher-notif-pagination-info {
            font-size: 12px;
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .teacher-notif-pagination-numbers {
            gap: 4px;
            margin: 0 5px;
        }

        .teacher-notif-pagination-number {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="title-color mb-0" style="border:none; padding-bottom: 0;">Quản lý Thông báo</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
            <i class="fa-solid fa-paper-plane me-2"></i> Soạn Thông báo mới
        </button>
    </div>

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" class="row g-3 align-items-end">
            <input type="hidden" name="nav" value="teacher_notifications">
            
            <div class="col-md-5">
                <label for="search" class="form-label"><i class="fas fa-search me-1"></i> Tìm kiếm</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Nhập tiêu đề thông báo..." 
                       value="<?php echo htmlspecialchars($search_query); ?>">
            </div>

            <div class="col-md-3">
                <label for="class_id" class="form-label"><i class="fas fa-filter me-1"></i> Lọc theo lớp</label>
                <select name="class_id" id="class_id" class="form-select">
                    <option value="">Tất cả lớp học</option>
                    <?php 
                    mysqli_data_seek($my_classes, 0);
                    while($class = $my_classes->fetch_assoc()): 
                        $notification_status = $class['notification_count'] > 0 
                            ? '(' . $class['notification_count'] . ' thông báo)' 
                            : '(Không có thông báo)';
                    ?>
                        <option value="<?php echo $class['id_lop']; ?>" <?php echo ($class_filter == $class['id_lop']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($class['ten_lop']) . ' ' . $notification_status; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>

            <div class="col-md-2">
                <a href="?nav=teacher_notifications" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-1"></i> Đặt lại
                </a>
            </div>
        </form>

        <?php if (!empty($search_query) || !empty($class_filter)): ?>
            <div class="filter-stats">
                <span class="stat-item">
                    <i class="fas fa-filter"></i>
                    Đang lọc
                </span>
                <?php if (!empty($search_query)): ?>
                    <span class="stat-item">
                        <i class="fas fa-search"></i>
                        "<?php echo htmlspecialchars($search_query); ?>"
                    </span>
                <?php endif; ?>
                <?php if (!empty($class_filter)): 
                    mysqli_data_seek($my_classes, 0);
                    $class_found = false;
                    while($class = $my_classes->fetch_assoc()): 
                        if(intval($class['id_lop']) == intval($class_filter)):
                            $class_found = true;
                ?>
                    <span class="stat-item">
                        <i class="fas fa-school"></i>
                        <?php echo htmlspecialchars($class['ten_lop']); ?>
                    </span>
                <?php 
                        endif;
                    endwhile;
                endif; 
                ?>
                <span class="stat-item">
                    <i class="fas fa-bell"></i>
                    <?php echo $total_notifications; ?> kết quả
                </span>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($history->num_rows > 0): ?>
        <div class="row g-4">
            <?php 
            $index = 0;
            while ($row = $history->fetch_assoc()): 
                $unique_id = md5($row['tieu_de'] . $row['ngay_tao'] . $row['id_lop']);
            ?>
                <div class="col-lg-4 col-md-6 animated-item" style="animation-delay: <?php echo $index++ * 70; ?>ms;" id="notification-card-<?php echo $unique_id; ?>">
                    <div class="notification-card">
                        <div class="card-header-custom">
                            <h5 class="card-title-custom"><?php echo htmlspecialchars($row['tieu_de']); ?></h5>
                            <button class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteNotification(
                                        '<?php echo htmlspecialchars(addslashes($row['tieu_de'])); ?>', 
                                        '<?php echo htmlspecialchars($row['id_lop']); ?>', 
                                        '<?php echo htmlspecialchars($row['ngay_tao']); ?>',
                                        '<?php echo $unique_id; ?>'
                                    )"
                                    title="Xóa nhóm thông báo này">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                        <div class="card-body-custom">
                            <div class="content-preview"><?php echo strip_tags($row['noi_dung']); ?></div>
                        </div>
                        <div class="card-footer-custom">
                            <span class="meta-item"><i class="fa-solid fa-school"></i> <strong><?php echo htmlspecialchars($row['ten_lop']); ?></strong></span>
                            <span class="meta-item"><i class="fa-solid fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <!-- Pagination -->
            <div class="teacher-notif-pagination-container">
                <div class="teacher-notif-pagination">
                    <!-- Previous Button -->
                    <?php
                    $prev_link = "?nav=teacher_notifications&notif_page=" . max(1, $current_page - 1);
                    if (!empty($search_query)) $prev_link .= "&search=" . urlencode($search_query);
                    if (!empty($class_filter)) $prev_link .= "&class_id=" . urlencode($class_filter);
                    ?>
                    <a href="<?php echo $prev_link; ?>" 
                       class="teacher-notif-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>

                    <!-- Page Numbers -->
                    <div class="teacher-notif-pagination-numbers">
                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        if ($start_page > 1) {
                            $first_link = "?nav=teacher_notifications&notif_page=1";
                            if (!empty($search_query)) $first_link .= "&search=" . urlencode($search_query);
                            if (!empty($class_filter)) $first_link .= "&class_id=" . urlencode($class_filter);
                            echo '<a href="' . $first_link . '" class="teacher-notif-pagination-number">1</a>';
                            if ($start_page > 2) {
                                echo '<span class="teacher-notif-pagination-dots">...</span>';
                            }
                        }

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $page_link = "?nav=teacher_notifications&notif_page={$i}";
                            if (!empty($search_query)) $page_link .= "&search=" . urlencode($search_query);
                            if (!empty($class_filter)) $page_link .= "&class_id=" . urlencode($class_filter);
                            $active_class = ($i == $current_page) ? 'active' : '';
                            echo '<a href="' . $page_link . '" class="teacher-notif-pagination-number ' . $active_class . '">' . $i . '</a>';
                        }

                        if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                                echo '<span class="teacher-notif-pagination-dots">...</span>';
                            }
                            $last_link = "?nav=teacher_notifications&notif_page={$total_pages}";
                            if (!empty($search_query)) $last_link .= "&search=" . urlencode($search_query);
                            if (!empty($class_filter)) $last_link .= "&class_id=" . urlencode($class_filter);
                            echo '<a href="' . $last_link . '" class="teacher-notif-pagination-number">' . $total_pages . '</a>';
                        }
                        ?>
                    </div>

                    <!-- Next Button -->
                    <?php
                    $next_link = "?nav=teacher_notifications&notif_page=" . min($total_pages, $current_page + 1);
                    if (!empty($search_query)) $next_link .= "&search=" . urlencode($search_query);
                    if (!empty($class_filter)) $next_link .= "&class_id=" . urlencode($class_filter);
                    ?>
                    <a href="<?php echo $next_link; ?>" 
                       class="teacher-notif-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <!-- Pagination Info -->
                <div class="teacher-notif-pagination-info">
                    <i class="fas fa-bell"></i>
                    <span>
                        Hiển thị 
                        <strong><?php echo min($offset + 1, $total_notifications); ?></strong>
                        <span class="separator">-</span>
                        <strong><?php echo min($offset + $notifications_per_page, $total_notifications); ?></strong>
                        <span class="separator">/</span>
                        <strong><?php echo $total_notifications; ?></strong>
                        thông báo
                    </span>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-light text-center py-5">
            <i class="fa-solid fa-bell-slash fa-3x mb-3 text-muted"></i>
            <h5 class="mb-2">Không tìm thấy thông báo</h5>
            <p class="mb-3 text-muted">
                <?php 
                if (!empty($search_query) && !empty($class_filter)): 
                    // Lấy tên lớp
                    mysqli_data_seek($my_classes, 0);
                    $class_name = '';
                    while($class = $my_classes->fetch_assoc()): 
                        if(intval($class['id_lop']) == intval($class_filter)):
                            $class_name = $class['ten_lop'];
                            break;
                        endif;
                    endwhile;
                ?>
                    Không tìm thấy thông báo nào với tiêu đề "<strong><?php echo htmlspecialchars($search_query); ?></strong>" trong lớp "<strong><?php echo htmlspecialchars($class_name); ?></strong>".
                <?php elseif (!empty($search_query)): ?>
                    Không tìm thấy thông báo nào với tiêu đề "<strong><?php echo htmlspecialchars($search_query); ?></strong>".
                <?php elseif (!empty($class_filter)): 
                    // Lấy tên lớp
                    mysqli_data_seek($my_classes, 0);
                    $class_name = '';
                    while($class = $my_classes->fetch_assoc()): 
                        if(intval($class['id_lop']) == intval($class_filter)):
                            $class_name = $class['ten_lop'];
                            break;
                        endif;
                    endwhile;
                ?>
                    Lớp "<strong><?php echo htmlspecialchars($class_name); ?></strong>" chưa có thông báo nào.
                <?php else: ?>
                    Bạn chưa gửi thông báo nào cho học viên.
                <?php endif; ?>
            </p>
            <?php if (!empty($search_query) || !empty($class_filter)): ?>
                <a href="?nav=teacher_notifications" class="btn btn-outline-primary">
                    <i class="fas fa-redo me-2"></i>Xem tất cả thông báo
                </a>
            <?php else: ?>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                    <i class="fa-solid fa-paper-plane me-2"></i>Soạn thông báo đầu tiên
                </button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="addNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-paper-plane me-2"></i>Soạn và Gửi Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sendNotificationForm_teacher">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <div class="form-floating">
                                <input type="text" name="tieu_de" class="form-control" placeholder="Tiêu đề thông báo" required>
                                <label>Tiêu đề *</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select name="id_lop" class="form-select" required>
                                    <option value="" selected disabled>-- Vui lòng chọn lớp --</option>
                                    <?php if ($my_classes->num_rows > 0): mysqli_data_seek($my_classes, 0); while($class = $my_classes->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($class['id_lop']); ?>"><?php echo htmlspecialchars($class['ten_lop']); ?></option>
                                    <?php endwhile; else: ?><option disabled>Bạn chưa có lớp học nào đang hoạt động</option><?php endif; ?>
                                </select>
                                <label>Gửi đến lớp *</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Nội dung thông báo *</label>
                        <textarea name="noi_dung" id="noi_dung_editor_teacher" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="submit-notification-btn" <?php if($my_classes->num_rows == 0) echo 'disabled'; ?>>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Gửi đi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteNotification(tieu_de, id_lop, ngay_tao, card_id) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Xóa nhóm thông báo này sẽ xóa tất cả các bản ghi liên quan và không thể khôi phục!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Chắc chắn xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./modules/teacher/teacher_delete_notification.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tieu_de, id_lop, ngay_tao })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Đã xóa!', data.message, 'success');
                        const card = document.getElementById(`notification-card-${card_id}`);
                        if (card) {
                            card.remove();
                        }
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                })
                .catch(error => Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error'));
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let editor;
        const addNotificationModal = new bootstrap.Modal(document.getElementById('addNotificationModal'));
        const form = document.getElementById('sendNotificationForm_teacher');
        const submitBtn = document.getElementById('submit-notification-btn');
        const spinner = submitBtn.querySelector('.spinner-border');
        
        document.getElementById('addNotificationModal').addEventListener('shown.bs.modal', function () {
            if (CKEDITOR.instances.noi_dung_editor_teacher) {
                CKEDITOR.instances.noi_dung_editor_teacher.destroy(true);
            }
            CKEDITOR.replace('noi_dung_editor_teacher', { height: 250 });
            editor = CKEDITOR.instances.noi_dung_editor_teacher;
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (editor) editor.updateElement();
            
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');

            const formData = new FormData(this);

            fetch('./modules/teacher/teacher_send_notification.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    addNotificationModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã gửi!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Lỗi!', data.message, 'error');
                }
            })
            .catch(error => Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error'))
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            });
        });

        // Smooth scroll when clicking pagination
        const teacherNotifPaginationLinks = document.querySelectorAll('.teacher-notif-pagination-number, .teacher-notif-pagination-btn');
        teacherNotifPaginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 100);
            });
        });
    });
</script>