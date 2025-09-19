<?php
// File: admin/modules/lichhoc/lophoc/view_classes.php
$sql = "SELECT lh.id_lop, lh.ten_lop, lh.trang_thai, kh.ten_khoahoc, gv.ten_giangvien FROM lop_hoc lh JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien";
$params = []; $types = "";
if (!empty($search_classes)) {
    $sql .= " WHERE lh.ten_lop LIKE ? OR kh.ten_khoahoc LIKE ? OR gv.ten_giangvien LIKE ?";
    $search_param = "%" . $search_classes . "%";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}
$sql .= " ORDER BY lh.id_lop ASC";
$stmt = $conn->prepare($sql);
if (!empty($params)) $stmt->bind_param($types, ...$params);
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
                <tr><td colspan="6" class="text-center text-muted py-3">Không có lớp học nào phù hợp.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div></div>
</div>