<?php
// File: admin/modules/lichhoc/lophoc/view_classes.php

// Pagination variables
$classes_per_page = 10;
$current_page = isset($_GET['class_page']) ? max(1, intval($_GET['class_page'])) : 1;
$offset = ($current_page - 1) * $classes_per_page;

// Build query with search
$sql_where = "";
$params = [];
$types = "";

if (!empty($search_classes)) {
    $sql_where = " WHERE lh.ten_lop LIKE ? OR kh.ten_khoahoc LIKE ? OR gv.ten_giangvien LIKE ?";
    $search_param = "%" . $search_classes . "%";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

// Count total classes
$sql_count = "SELECT COUNT(*) as total FROM lop_hoc lh JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien" . $sql_where;
$stmt_count = $conn->prepare($sql_count);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_classes = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_classes / $classes_per_page);

// Main query with pagination
$sql = "SELECT lh.id_lop, lh.ten_lop, lh.trang_thai, kh.ten_khoahoc, gv.ten_giangvien FROM lop_hoc lh JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien" . $sql_where . " ORDER BY lh.id_lop DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $params[] = $classes_per_page;
    $params[] = $offset;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $classes_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<div class="card animated-card">
    <div class="card-header"><div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fa-solid fa-school me-2"></i>Quản lý Lớp học</h4>
        <div class="d-flex">
            <form method="GET" action="./admin.php" class="d-flex me-2"><input type="hidden" name="nav" value="lichhoc"><input type="text" name="search_classes" class="form-control" placeholder="Tìm tên lớp, khóa học..." value="<?php echo htmlspecialchars($search_classes); ?>"><button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button></form>
            <a href="modules/lichhoc/lophoc/export_classes.php?search=<?php echo htmlspecialchars($search_classes); ?>" class="btn btn-info text-white me-2"><i class="fa-solid fa-file-excel"></i> Excel</a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClassModal"><i class="fa-solid fa-plus"></i> Thêm Lớp</button>
        </div>
    </div></div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark"><tr><th>ID Lớp</th><th>Tên Lớp</th><th>Khóa học</th><th>Giảng viên</th><th class="text-center">Trạng thái</th><th class="text-center">Hành động</th></tr></thead>
            <tbody>
                <?php if ($result->num_rows > 0): $index = 0; while ($row = $result->fetch_assoc()): ?>
                <tr id="class-row-<?php echo htmlspecialchars($row['id_lop']); ?>" class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                    <td><strong><?php echo htmlspecialchars($row['id_lop']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['ten_lop']); ?></td>
                    <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                    <td><?php echo ($row['ten_giangvien'] ? htmlspecialchars($row['ten_giangvien']) : '<span class="text-muted">Chưa phân công</span>'); ?></td>
                    <td class="text-center"><?php echo ($row['trang_thai'] === 'dang hoc') ? '<span class="badge bg-success">Đang học</span>' : '<span class="badge bg-secondary">Đã xong</span>'; ?></td>
                    <td class="text-center">
                        <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>" class="btn btn-info btn-sm text-white" title="Quản lý chi tiết"><i class="fa-solid fa-arrow-right-to-bracket"></i></a>
                        <button class="btn btn-primary btn-sm" onclick="openEditClassModal('<?php echo htmlspecialchars($row['id_lop']); ?>')" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteClass('<?php echo htmlspecialchars($row['id_lop']); ?>')" title="Xóa"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="fa-solid fa-school fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">
                            <?php 
                            if (!empty($search_classes)) {
                                echo 'Không tìm thấy lớp học nào với từ khóa: <strong>' . htmlspecialchars($search_classes) . '</strong>';
                            } else {
                                echo 'Chưa có lớp học nào trong hệ thống';
                            }
                            ?>
                        </p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
    <!-- Pagination -->
    <div class="lichhoc-pagination-container">
        <div class="lichhoc-pagination">
            <?php
            $search_query = !empty($search_classes) ? '&search_classes=' . urlencode($search_classes) : '';
            
            // Previous button
            if ($current_page > 1):
                $prev_link = "./admin.php?nav=lichhoc&class_page=" . ($current_page - 1) . $search_query;
            ?>
                <a href="<?php echo $prev_link; ?>" class="lichhoc-pagination-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                    <span class="btn-text">Trước</span>
                </a>
            <?php else: ?>
                <span class="lichhoc-pagination-btn disabled">
                    <i class="fa-solid fa-chevron-left"></i>
                    <span class="btn-text">Trước</span>
                </span>
            <?php endif; ?>

            <!-- Page numbers -->
            <?php
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $current_page + 2);

            if ($start_page > 1):
                $first_link = "./admin.php?nav=lichhoc&class_page=1" . $search_query;
            ?>
                <a href="<?php echo $first_link; ?>" class="lichhoc-pagination-number">1</a>
                <?php if ($start_page > 2): ?>
                    <span class="lichhoc-pagination-dots">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php
                $page_link = "./admin.php?nav=lichhoc&class_page=" . $i . $search_query;
                $active_class = ($i == $current_page) ? ' active' : '';
                ?>
                <a href="<?php echo $page_link; ?>" class="lichhoc-pagination-number<?php echo $active_class; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($end_page < $total_pages): ?>
                <?php if ($end_page < $total_pages - 1): ?>
                    <span class="lichhoc-pagination-dots">...</span>
                <?php endif; ?>
                <?php $last_link = "./admin.php?nav=lichhoc&class_page=" . $total_pages . $search_query; ?>
                <a href="<?php echo $last_link; ?>" class="lichhoc-pagination-number"><?php echo $total_pages; ?></a>
            <?php endif; ?>

            <!-- Next button -->
            <?php if ($current_page < $total_pages):
                $next_link = "./admin.php?nav=lichhoc&class_page=" . ($current_page + 1) . $search_query;
            ?>
                <a href="<?php echo $next_link; ?>" class="lichhoc-pagination-btn">
                    <span class="btn-text">Sau</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <span class="lichhoc-pagination-btn disabled">
                    <span class="btn-text">Sau</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            <?php endif; ?>
        </div>

        <!-- Pagination info -->
        <div class="lichhoc-pagination-info">
            <?php
            $start_item = $offset + 1;
            $end_item = min($offset + $classes_per_page, $total_classes);
            ?>
            Hiển thị <?php echo $start_item; ?>-<?php echo $end_item; ?> / <?php echo $total_classes; ?> lớp học
        </div>
    </div>
    <?php endif; ?>
    </div>
</div>

<style>
/* Lichhoc Pagination Styles */
.lichhoc-pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.lichhoc-pagination {
    display: flex;
    gap: 6px;
    align-items: center;
    background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
    padding: 6px 12px;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
}

.lichhoc-pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 9px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
}

.lichhoc-pagination-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-1px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.lichhoc-pagination-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.lichhoc-pagination-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    text-decoration: none;
    border-radius: 50%;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.lichhoc-pagination-number:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-1px) scale(1.05);
}

.lichhoc-pagination-number.active {
    background: white;
    color: #0db33b;
    transform: scale(1.08);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    border-color: white;
}

.lichhoc-pagination-dots {
    color: white;
    padding: 0 4px;
    font-weight: bold;
    opacity: 0.6;
}

.lichhoc-pagination-info {
    background: var(--brand-color-light, #e7f7ec);
    color: var(--brand-color, #0db33b);
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(13, 179, 59, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .lichhoc-pagination-container {
        justify-content: center;
    }
    
    .lichhoc-pagination-btn .btn-text {
        display: none;
    }
    
    .lichhoc-pagination-btn {
        padding: 6px 10px;
    }
    
    .lichhoc-pagination-info {
        order: -1;
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .lichhoc-pagination-number {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
    
    .lichhoc-pagination-btn {
        padding: 5px 8px;
    }
}
</style>