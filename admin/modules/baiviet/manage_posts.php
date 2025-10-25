<?php
// Lấy các tham số từ URL để lọc, tìm kiếm và sắp xếp
$status = $_GET['status'] ?? 'cho_duyet';
$search_term = trim($_GET['search'] ?? '');
$date_filter = $_GET['date_filter'] ?? 'all';
$sort_by = $_GET['sort_by'] ?? 'ngay_tao_desc';

// Xây dựng câu truy vấn SQL động và an toàn
$sql = "SELECT 
            bv.id_baiviet, bv.tieu_de, bv.ngay_tao, bv.trang_thai, bv.luot_xem, 
            hv.ten_hocvien,
            COUNT(bl.id_binhluan) AS so_binh_luan
        FROM bai_viet bv 
        LEFT JOIN hocvien hv ON bv.id_tac_gia = hv.id_hocvien
        LEFT JOIN binh_luan bl ON bv.id_baiviet = bl.id_baiviet";

$where_clauses = [];
$params = [];
$types = '';

// Lọc theo trạng thái (từ các tab)
if ($status !== 'all') {
    $where_clauses[] = "bv.trang_thai = ?";
    $params[] = $status;
    $types .= 's';
}

// Lọc theo từ khóa tìm kiếm
if (!empty($search_term)) {
    $where_clauses[] = "(bv.tieu_de LIKE ? OR hv.ten_hocvien LIKE ?)";
    $search_like = "%" . $search_term . "%";
    $params[] = $search_like;
    $params[] = $search_like;
    $types .= 'ss';
}

// Lọc theo khoảng thời gian
switch ($date_filter) {
    case 'today':
        $where_clauses[] = "DATE(bv.ngay_tao) = CURDATE()";
        break;
    case 'this_week':
        $where_clauses[] = "YEARWEEK(bv.ngay_tao, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'this_month':
        $where_clauses[] = "YEAR(bv.ngay_tao) = YEAR(CURDATE()) AND MONTH(bv.ngay_tao) = MONTH(CURDATE())";
        break;
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// GROUP BY để hàm COUNT hoạt động đúng
$sql .= " GROUP BY bv.id_baiviet";

// Sắp xếp kết quả
$order_by_options = [
    'ngay_tao_desc' => 'bv.ngay_tao DESC',
    'ngay_tao_asc' => 'bv.ngay_tao ASC',
    'luot_xem_desc' => 'bv.luot_xem DESC',
    'luot_xem_asc' => 'bv.luot_xem ASC',
    'so_binh_luan_desc' => 'so_binh_luan DESC',
    'so_binh_luan_asc' => 'so_binh_luan ASC',
];
$sql .= " ORDER BY " . ($order_by_options[$sort_by] ?? 'bv.ngay_tao DESC');

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

function get_post_status_badge_admin($status) {
    switch ($status) {
        case 'da_duyet': return '<span class="badge bg-success">Đã duyệt</span>';
        case 'cho_duyet': return '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
        case 'bi_tu_choi': return '<span class="badge bg-danger">Bị từ chối</span>';
        default: return '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
    }
}
?>

<div class="card animated-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fa-solid fa-newspaper me-2"></i>Quản lý Bài viết</h4>
        <span class="badge bg-primary rounded-pill"><?php echo $result->num_rows; ?> bài viết</span>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link <?php echo ($status == 'cho_duyet') ? 'active' : ''; ?>" href="?nav=baiviet&status=cho_duyet">Chờ duyệt</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($status == 'da_duyet') ? 'active' : ''; ?>" href="?nav=baiviet&status=da_duyet">Đã duyệt</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($status == 'bi_tu_choi') ? 'active' : ''; ?>" href="?nav=baiviet&status=bi_tu_choi">Bị từ chối</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($status == 'all') ? 'active' : ''; ?>" href="?nav=baiviet&status=all">Tất cả</a></li>
        </ul>
        
        <form method="GET" class="mb-4 p-3 bg-light border rounded">
            <input type="hidden" name="nav" value="baiviet">
            <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Tìm theo tiêu đề / tác giả</label>
                    <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Nhập từ khóa...">
                </div>
                <div class="col-md-3">
                    <label for="date_filter" class="form-label">Lọc theo ngày gửi</label>
                    <select id="date_filter" name="date_filter" class="form-select">
                        <option value="all" <?php echo ($date_filter == 'all') ? 'selected' : ''; ?>>Tất cả thời gian</option>
                        <option value="today" <?php echo ($date_filter == 'today') ? 'selected' : ''; ?>>Hôm nay</option>
                        <option value="this_week" <?php echo ($date_filter == 'this_week') ? 'selected' : ''; ?>>Tuần này</option>
                        <option value="this_month" <?php echo ($date_filter == 'this_month') ? 'selected' : ''; ?>>Tháng này</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort_by" class="form-label">Sắp xếp theo</label>
                    <select id="sort_by" name="sort_by" class="form-select">
                        <option value="ngay_tao_desc" <?php echo ($sort_by == 'ngay_tao_desc') ? 'selected' : ''; ?>>Ngày gửi: Mới nhất</option>
                        <option value="ngay_tao_asc" <?php echo ($sort_by == 'ngay_tao_asc') ? 'selected' : ''; ?>>Ngày gửi: Cũ nhất</option>
                        <option value="luot_xem_desc" <?php echo ($sort_by == 'luot_xem_desc') ? 'selected' : ''; ?>>Lượt xem: Cao đến thấp</option>
                        <option value="luot_xem_asc" <?php echo ($sort_by == 'luot_xem_asc') ? 'selected' : ''; ?>>Lượt xem: Thấp đến cao</option>
                        <option value="so_binh_luan_desc" <?php echo ($sort_by == 'so_binh_luan_desc') ? 'selected' : ''; ?>>Bình luận: Nhiều nhất</option>
                        <option value="so_binh_luan_asc" <?php echo ($sort_by == 'so_binh_luan_asc') ? 'selected' : ''; ?>>Bình luận: Ít nhất</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Lọc</button>
                    <a href="?nav=baiviet&status=<?php echo htmlspecialchars($status); ?>" class="btn btn-secondary w-100 mt-2"><i class="fas fa-times"></i> Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th class="text-center">Ngày gửi</th>
                        <th class="text-center">Lượt xem</th>
                        <th class="text-center">Bình luận</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
                    <tr id="post-row-<?php echo $row['id_baiviet']; ?>">
                        <td><?php echo htmlspecialchars($row['tieu_de']); ?></td>
                        <td><?php echo htmlspecialchars($row['ten_hocvien'] ?? 'N/A'); ?></td>
                        <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_tao'])); ?></td>
                        <td class="text-center"><?php echo $row['luot_xem']; ?></td>
                        <td class="text-center"><?php echo $row['so_binh_luan']; ?></td>
                        <td class="text-center status-cell"><?php echo get_post_status_badge_admin($row['trang_thai']); ?></td>
                        <td class="text-center actions-cell">
                            <a href="../index.php?nav=blog_single&id=<?php echo $row['id_baiviet']; ?>&preview=true" class="btn btn-sm btn-secondary" target="_blank" title="Xem trước"><i class="fa-solid fa-eye"></i></a>
                            <?php if ($row['trang_thai'] !== 'da_duyet'): ?>
                                <button class="btn btn-sm btn-success" onclick="updateStatus(<?php echo $row['id_baiviet']; ?>, 'da_duyet')" title="Duyệt bài"><i class="fa-solid fa-check"></i></button>
                            <?php endif; ?>
                            <?php if ($row['trang_thai'] !== 'bi_tu_choi'): ?>
                                <button class="btn btn-sm btn-warning text-white" onclick="updateStatus(<?php echo $row['id_baiviet']; ?>, 'bi_tu_choi')" title="Từ chối"><i class="fa-solid fa-times"></i></button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-danger" onclick="deletePost(<?php echo $row['id_baiviet']; ?>)" title="Xóa vĩnh viễn"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Không tìm thấy bài viết nào phù hợp.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function handleAjaxResponse(response, callback) {
    if (response.status === 'success') {
        Swal.fire({ 
            icon: 'success', title: 'Thành công!', text: response.message, 
            timer: 1500, showConfirmButton: false 
        }).then(callback);
    } else {
        Swal.fire('Lỗi!', response.message, 'error');
    }
}

function updateStatus(postId, newStatus) {
    const actionText = newStatus === 'da_duyet' ? 'duyệt' : 'từ chối';
    Swal.fire({
        title: `Bạn chắc chắn muốn ${actionText} bài viết này?`,
        icon: 'question', showCancelButton: true, confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33', confirmButtonText: `Vâng, ${actionText}!`, cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/baiviet/update_post_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: postId, status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                handleAjaxResponse(data, () => {
                    const postRow = document.getElementById(`post-row-${postId}`);
                    if (postRow) {
                        postRow.style.transition = 'opacity 0.5s ease';
                        postRow.style.opacity = '0';
                        setTimeout(() => postRow.remove(), 500);
                    }
                });
            })
            .catch(error => Swal.fire('Lỗi kết nối!', 'Không thể gửi yêu cầu đến máy chủ.', 'error'));
        }
    });
}

function deletePost(postId) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa?',
        text: "Hành động này sẽ xóa vĩnh viễn bài viết và không thể khôi phục!",
        icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6', confirmButtonText: 'Vâng, xóa nó!', cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/baiviet/delete_post.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: postId })
            })
            .then(res => res.json())
            .then(data => {
                handleAjaxResponse(data, () => {
                    const postRow = document.getElementById(`post-row-${postId}`);
                    if (postRow) {
                        postRow.style.transition = 'opacity 0.5s ease';
                        postRow.style.opacity = '0';
                        setTimeout(() => postRow.remove(), 500);
                    }
                });
            })
            .catch(error => Swal.fire('Lỗi kết nối!', 'Không thể gửi yêu cầu đến máy chủ.', 'error'));
        }
    });
}
</script>

<style>
/* Responsive Design for manage_posts.php */
@media (max-width: 768px) {
    .card-header .d-flex {
        flex-direction: column;
        gap: 10px;
    }
    
    .card-header .badge {
        align-self: flex-start;
    }
    
    .filter-section .row {
        row-gap: 1rem;
    }
    
    .filter-section .col-md-2 .btn {
        margin-top: 0.5rem;
    }
    
    .filter-section .col-md-2 .btn + .btn {
        margin-top: 0.5rem;
    }
    
    /* Make table scrollable on mobile */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Hide less important columns on mobile */
    .table thead th:nth-child(3),
    .table tbody td:nth-child(3) {
        display: none;
    }
    
    .table thead th:nth-child(4),
    .table tbody td:nth-child(4) {
        display: none;
    }
    
    .table thead th:nth-child(5),
    .table tbody td:nth-child(5) {
        display: none;
    }
    
    /* Stack action buttons vertically */
    .actions-cell {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .actions-cell .btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .card-header h4 {
        font-size: 1rem;
    }
    
    .card-header h4 i {
        font-size: 0.9rem;
    }
    
    .nav-tabs .nav-link {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
    
    .filter-section {
        padding: 1rem !important;
    }
    
    .filter-section label {
        font-size: 0.85rem;
    }
    
    .filter-section .form-control,
    .filter-section .form-select,
    .filter-section .btn {
        font-size: 0.85rem;
    }
    
    .table {
        font-size: 0.85rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 0.5rem 0.25rem;
    }
    
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
}
</style>