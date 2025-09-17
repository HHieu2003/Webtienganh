<?php
if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");

// Xử lý tìm kiếm
$search_schedule = $_GET['search_schedule'] ?? '';

// Lấy danh sách lịch học của lớp
$sql_schedule = "SELECT * FROM lichhoc WHERE id_lop = ?";
$params = [$lop_id];
$types = "s";
if (!empty($search_schedule)) {
    $sql_schedule .= " AND (phong_hoc LIKE ? OR ghi_chu LIKE ?)";
    $search_param = "%" . $search_schedule . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}
$sql_schedule .= " ORDER BY ngay_hoc ASC, gio_bat_dau ASC";
$stmt = $conn->prepare($sql_schedule);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$schedules = $stmt->get_result();
?>

<div class="card mt-4 animated-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách các buổi học</h5>
        <div class="d-flex">
            <form method="GET" action="./admin.php" class="d-flex me-2">
                <input type="hidden" name="nav" value="lichhoc">
                <input type="hidden" name="lop_id" value="<?php echo htmlspecialchars($lop_id); ?>">
                <input type="hidden" name="view" value="schedule">
                <input type="text" name="search_schedule" class="form-control" placeholder="Tìm phòng/ghi chú..." value="<?php echo htmlspecialchars($search_schedule); ?>">
                <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <a href="modules/lichhoc/export_schedule_for_class.php?lop_id=<?php echo htmlspecialchars($lop_id); ?>&search=<?php echo htmlspecialchars($search_schedule); ?>" class="btn btn-info text-white me-2">
                <i class="fa-solid fa-file-excel"></i> Xuất Excel
            </a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                <i class="fa-solid fa-plus"></i> Thêm buổi học
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>Ngày học</th><th>Thời gian</th><th>Phòng học</th><th>Ghi chú</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php if ($schedules->num_rows > 0):
                        while ($schedule = $schedules->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo date("d/m/Y", strtotime($schedule['ngay_hoc'])); ?></strong></td>
                            <td><?php echo date("H:i", strtotime($schedule['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($schedule['gio_ket_thuc'])); ?></td>
                            <td><?php echo htmlspecialchars($schedule['phong_hoc']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['ghi_chu']); ?></td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="openEditScheduleModal(<?php echo $schedule['id_lichhoc']; ?>)"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="modules/lichhoc/delete_schedule.php?id=<?php echo $schedule['id_lichhoc']; ?>&lop_id=<?php echo $lop_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa buổi học này?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Không có buổi học nào phù hợp.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>