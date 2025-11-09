<?php
// user/modules/bai_viet_cua_toi.php
$id_hocvien = $_SESSION['id_hocvien'];

// --- Search and Filter parameters ---
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// --- Pagination settings ---
$posts_per_page = 10;
$current_page = isset($_GET['post_page']) ? max(1, intval($_GET['post_page'])) : 1;
$offset = ($current_page - 1) * $posts_per_page;

// --- Build WHERE conditions ---
$where_conditions = ["bv.id_tac_gia = ?"];
$params = [$id_hocvien];
$types = "i";

if (!empty($search_query)) {
    $where_conditions[] = "bv.tieu_de LIKE ?";
    $params[] = "%{$search_query}%";
    $types .= "s";
}

if (!empty($status_filter)) {
    $where_conditions[] = "bv.trang_thai = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$where_clause = implode(" AND ", $where_conditions);

// --- Count total posts ---
$sql_count = "SELECT COUNT(*) as total FROM bai_viet bv WHERE $where_clause";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param($types, ...$params);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_posts = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_posts / $posts_per_page);

// --- Get posts with pagination ---
$sql = "SELECT 
            bv.id_baiviet, bv.tieu_de, bv.ngay_tao, bv.trang_thai, bv.luot_xem,
            COUNT(bl.id_binhluan) AS so_binh_luan
        FROM bai_viet bv
        LEFT JOIN binh_luan bl ON bv.id_baiviet = bl.id_baiviet
        WHERE $where_clause
        GROUP BY bv.id_baiviet
        ORDER BY bv.ngay_tao DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$params[] = $posts_per_page;
$params[] = $offset;
$types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

function get_post_status_badge($status)
{
    switch ($status) {
        case 'da_duyet':
            return '<span class="badge bg-success">Đã duyệt</span>';
        case 'cho_duyet':
            return '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
        case 'bi_tu_choi':
            return '<span class="badge bg-danger">Bị từ chối</span>';
        default:
            return '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
    }
}
?>

<style>
    /* Search & Filter Bar */
    .search-filter-bar {
        background-color: #fff;
        padding: 20px;
        border-radius: var(--border-radius);
        margin-bottom: 25px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
    }

    .search-filter-bar .form-control,
    .search-filter-bar .form-select {
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .search-filter-bar .btn {
        border-radius: 8px;
        padding: 8px 10px;
        font-weight: 600;
    }

    .filter-stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .filter-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: var(--primary-color-light);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: var(--primary-color-dark);
    }

    .filter-stats .stat-item i {
        font-size: 14px;
    }

    .post-pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
        margin-top: 20px;
    }

    .post-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #66eabaff 0%, #4ba254ff 100%);
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.25);
        backdrop-filter: blur(10px);
    }

    .post-pagination-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        border: none;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .post-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: var(--primary-color-dark);
    }

    .post-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .post-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0 10px;
    }

    .post-pagination-number {
        min-width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .post-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .post-pagination-number.active {
        background: #fff;
        color: var(--primary-color-dark);
        border-color: #fff;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        animation: postPagePulse 0.4s ease;
    }

    @keyframes postPagePulse {

        0%,
        100% {
            transform: scale(1.15);
        }

        50% {
            transform: scale(1.25);
        }
    }

    .post-pagination-dots {
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .post-pagination-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        background: var(--primary-color-light);
        border-radius: 25px;
        color: var(--primary-color);
        font-size: 14px;
        font-weight: 600;
        border: 2px solid rgba(13, 179, 59, 0.15);
    }

    .post-pagination-info i {
        font-size: 16px;
    }

    .post-pagination-info strong {
        color: var(--primary-color-dark);
        font-size: 15px;
    }

    .post-pagination-info .separator {
        margin: 0 5px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive for Search & Filter Bar */
    @media (max-width: 991px) {
        .search-filter-bar {
            padding: 15px;
        }

        .search-filter-bar .form-label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .search-filter-bar .btn {
            padding: 8px 15px;
            font-size: 14px;
        }

        .filter-stats {
            gap: 10px;
        }

        .filter-stats .stat-item {
            font-size: 12px;
            padding: 6px 12px;
        }
    }

    @media (max-width: 768px) {
        .search-filter-bar {
            padding: 12px;
        }

        .search-filter-bar .row {
            row-gap: 12px;
        }

        .search-filter-bar .form-label {
            font-size: 13px;
        }

        .search-filter-bar .form-control,
        .search-filter-bar .form-select {
            font-size: 14px;
            padding: 8px 12px;
        }

        .search-filter-bar .btn {
            padding: 10px 12px;
            font-size: 13px;
        }

        .filter-stats {
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
        }

        .filter-stats .stat-item {
            font-size: 11px;
            padding: 5px 10px;
        }

        .filter-stats .stat-item i {
            font-size: 12px;
        }

        /* Table responsive adjustments */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            font-size: 13px;
        }

        .table th,
        .table td {
            padding: 10px 8px;
            white-space: nowrap;
        }

        .table td:first-child {
            max-width: 200px !important;
            white-space: normal;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }

        .post-pagination {
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .post-pagination-btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .post-pagination-btn span {
            display: none;
        }

        .post-pagination-number {
            min-width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .post-pagination-info {
            font-size: 12px;
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .search-filter-bar {
            padding: 10px;
        }

        .search-filter-bar .col-md-5,
        .search-filter-bar .col-md-3,
        .search-filter-bar .col-md-2 {
            width: 100%;
        }

        .search-filter-bar .form-label {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .search-filter-bar .form-control,
        .search-filter-bar .form-select {
            font-size: 13px;
            padding: 8px 10px;
        }

        .search-filter-bar .btn {
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }

        .filter-stats {
            gap: 6px;
        }

        .filter-stats .stat-item {
            font-size: 10px;
            padding: 4px 8px;
        }

        /* Mobile table - stacked view */
        .table thead {
            display: none;
        }

        .table,
        .table tbody,
        .table tr,
        .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table td {
            text-align: right;
            padding: 8px 10px;
            position: relative;
            border: none;
            white-space: normal !important;
        }

        .table td:before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            font-weight: 600;
            color: var(--dark-text);
            text-align: left;
        }

        .table td:first-child {
            max-width: 100% !important;
            padding-top: 12px;
        }

        .table td:last-child {
            padding-bottom: 12px;
        }

        .table td:first-child:before {
            display: block;
            margin-bottom: 5px;
            position: static;
        }

        .btn-sm {
            margin: 2px;
            padding: 6px 10px;
        }

        .post-pagination-numbers {
            gap: 4px;
            margin: 0 5px;
        }

        .post-pagination-number {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }

        .post-pagination-info {
            font-size: 11px;
            padding: 8px 12px;
        }
    }

    @media (max-width: 480px) {
        h2 {
            font-size: 20px;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
        }

        .d-flex.justify-content-between .btn-primary {
            width: 100%;
        }

        .search-filter-bar .btn i {
            margin-right: 4px !important;
        }

        .post-pagination {
            padding: 8px 12px;
        }

        .post-pagination-btn {
            padding: 6px 10px;
            font-size: 12px;
        }
    }
</style>

<div class="content-pane">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2>Bài viết của tôi</h2>
        <a href="?nav=viet_bai" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i> Viết bài mới</a>
    </div>

    <?php if (isset($_SESSION['post_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['post_message_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['post_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['post_message']);
        unset($_SESSION['post_message_type']); ?>
    <?php endif; ?>

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" class="row g-3 align-items-end">
            <input type="hidden" name="nav" value="bai_viet_cua_toi">

            <div class="col-md-5">
                <label for="search" class="form-label"><i class="fas fa-search me-1"></i> Tìm kiếm</label>
                <input type="text" name="search" id="search" class="form-control"
                    placeholder="Nhập tiêu đề bài viết..."
                    value="<?php echo htmlspecialchars($search_query); ?>">
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label"><i class="fas fa-filter me-1"></i> Trạng thái</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="da_duyet" <?php echo ($status_filter === 'da_duyet') ? 'selected' : ''; ?>>Đã duyệt</option>
                    <option value="cho_duyet" <?php echo ($status_filter === 'cho_duyet') ? 'selected' : ''; ?>>Chờ duyệt</option>
                    <option value="bi_tu_choi" <?php echo ($status_filter === 'bi_tu_choi') ? 'selected' : ''; ?>>Bị từ chối</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>

            <div class="col-md-2">
                <a href="?nav=bai_viet_cua_toi" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-1"></i> Đặt lại
                </a>
            </div>
        </form>

        <?php if (!empty($search_query) || !empty($status_filter)): ?>
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
                <?php if (!empty($status_filter)): ?>
                    <span class="stat-item">
                        <i class="fas fa-check-circle"></i>
                        <?php
                        $status_names = [
                            'da_duyet' => 'Đã duyệt',
                            'cho_duyet' => 'Chờ duyệt',
                            'bi_tu_choi' => 'Bị từ chối'
                        ];
                        echo $status_names[$status_filter] ?? $status_filter;
                        ?>
                    </span>
                <?php endif; ?>
                <span class="stat-item">
                    <i class="fas fa-file-alt"></i>
                    <?php echo $total_posts; ?> kết quả
                </span>
            </div>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th class="text-center">Ngày gửi</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Lượt xem</th>
                    <th class="text-center">Bình luận</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                        <tr id="post-row-<?php echo $row['id_baiviet']; ?>">
                            <td data-label="Tiêu đề" style="max-width: 300px;"><?php echo htmlspecialchars($row['tieu_de']); ?></td>
                            <td data-label="Ngày gửi" class="text-center"><?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></td>
                            <td data-label="Trạng thái" class="text-center"><?php echo get_post_status_badge($row['trang_thai']); ?></td>
                            <td data-label="Lượt xem" class="text-center"><?php echo $row['luot_xem']; ?></td>
                            <td data-label="Bình luận" class="text-center"><?php echo $row['so_binh_luan']; ?></td>
                            <td data-label="Hành động" class="text-center">
                                <?php if ($row['trang_thai'] == 'da_duyet'): ?>
                                    <a href="../index.php?nav=blog_single&id=<?php echo $row['id_baiviet']; ?>" class="btn btn-sm btn-info text-white" target="_blank" title="Xem bài viết"><i class="fa-solid fa-eye"></i></a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled title="Bài viết chưa được duyệt"><i class="fa-solid fa-eye-slash"></i></button>
                                <?php endif; ?>

                                <!-- NÚT SỬA BÀI VIẾT MỚI -->
                                <a href="?nav=sua_bai_viet&id=<?php echo $row['id_baiviet']; ?>" class="btn btn-sm btn-warning text-white" title="Sửa bài viết"><i class="fa-solid fa-pencil"></i></a>

                                <button class="btn btn-sm btn-danger" onclick="deleteMyPost(<?php echo $row['id_baiviet']; ?>)" title="Xóa bài viết"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <?php if (!empty($search_query) || !empty($status_filter)): ?>
                                <i class="fa-solid fa-search fa-2x mb-2"></i>
                                <p>Không tìm thấy bài viết nào phù hợp với bộ lọc.</p>
                            <?php else: ?>
                                Bạn chưa gửi bài viết nào.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
        <!-- Pagination -->
        <div class="post-pagination-container">
            <div class="post-pagination">
                <!-- Previous Button -->
                <?php
                $prev_link = "?nav=bai_viet_cua_toi&post_page=" . max(1, $current_page - 1);
                if (!empty($search_query)) $prev_link .= "&search=" . urlencode($search_query);
                if (!empty($status_filter)) $prev_link .= "&status=" . urlencode($status_filter);
                ?>
                <a href="<?php echo $prev_link; ?>"
                    class="post-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                    <i class="fas fa-chevron-left"></i>
                    <span>Trước</span>
                </a>

                <!-- Page Numbers -->
                <div class="post-pagination-numbers">
                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);

                    if ($start_page > 1) {
                        $first_link = "?nav=bai_viet_cua_toi&post_page=1";
                        if (!empty($search_query)) $first_link .= "&search=" . urlencode($search_query);
                        if (!empty($status_filter)) $first_link .= "&status=" . urlencode($status_filter);
                        echo '<a href="' . $first_link . '" class="post-pagination-number">1</a>';
                        if ($start_page > 2) {
                            echo '<span class="post-pagination-dots">...</span>';
                        }
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        $page_link = "?nav=bai_viet_cua_toi&post_page={$i}";
                        if (!empty($search_query)) $page_link .= "&search=" . urlencode($search_query);
                        if (!empty($status_filter)) $page_link .= "&status=" . urlencode($status_filter);
                        $active_class = ($i == $current_page) ? 'active' : '';
                        echo '<a href="' . $page_link . '" class="post-pagination-number ' . $active_class . '">' . $i . '</a>';
                    }

                    if ($end_page < $total_pages) {
                        if ($end_page < $total_pages - 1) {
                            echo '<span class="post-pagination-dots">...</span>';
                        }
                        $last_link = "?nav=bai_viet_cua_toi&post_page={$total_pages}";
                        if (!empty($search_query)) $last_link .= "&search=" . urlencode($search_query);
                        if (!empty($status_filter)) $last_link .= "&status=" . urlencode($status_filter);
                        echo '<a href="' . $last_link . '" class="post-pagination-number">' . $total_pages . '</a>';
                    }
                    ?>
                </div>

                <!-- Next Button -->
                <?php
                $next_link = "?nav=bai_viet_cua_toi&post_page=" . min($total_pages, $current_page + 1);
                if (!empty($search_query)) $next_link .= "&search=" . urlencode($search_query);
                if (!empty($status_filter)) $next_link .= "&status=" . urlencode($status_filter);
                ?>
                <a href="<?php echo $next_link; ?>"
                    class="post-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                    <span>Sau</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            <!-- Pagination Info -->
            <div class="post-pagination-info">
                <i class="fas fa-file-alt"></i>
                <span>
                    Hiển thị
                    <strong><?php echo min($offset + 1, $total_posts); ?></strong>
                    <span class="separator">-</span>
                    <strong><?php echo min($offset + $posts_per_page, $total_posts); ?></strong>
                    <span class="separator">/</span>
                    <strong><?php echo $total_posts; ?></strong>
                    bài viết
                </span>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function deleteMyPost(postId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này sẽ xóa vĩnh viễn bài viết và tất cả bình luận liên quan. Bạn không thể khôi phục lại!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('modules/delete_my_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            post_id: postId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const postRow = document.getElementById(`post-row-${postId}`);
                            if (postRow) {
                                postRow.style.transition = 'opacity 0.5s ease';
                                postRow.style.opacity = '0';
                                setTimeout(() => postRow.remove(), 500);
                            }
                            Swal.fire('Đã xóa!', data.message, 'success');
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                    });
            }
        });
    }

    // Smooth scroll when clicking pagination
    document.addEventListener('DOMContentLoaded', function() {
        const postPaginationLinks = document.querySelectorAll('.post-pagination-number, .post-pagination-btn');
        postPaginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    const contentPane = document.querySelector('.content-pane');
                    if (contentPane) {
                        contentPane.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            });
        });
    });
</script>