<?php
// session_start(); đã được gọi ở file admin.php

// --- LẤY DỮ LIỆU CHO BỘ LỌC VÀ FORM ---
$courses_for_filter = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$classes_for_modal = $conn->query("SELECT id_lop, ten_lop FROM lop_hoc ORDER BY ten_lop");

// --- XỬ LÝ LỌC VÀ TÌM KIẾM ---
$search_term = $_GET['search'] ?? '';
$filter_course = $_GET['filter_course'] ?? 'all';

// Xây dựng câu lệnh SQL động
$sql_notifications = "
    SELECT 
        thongbao.tieu_de, 
        thongbao.noi_dung, 
        thongbao.id_khoahoc,
        khoahoc.ten_khoahoc, 
        thongbao.ngay_tao
    FROM thongbao
    LEFT JOIN khoahoc ON thongbao.id_khoahoc = khoahoc.id_khoahoc
";

$conditions = [];
$params = [];
$types = "";

// Điều kiện tìm kiếm
if (!empty($search_term)) {
    $conditions[] = "(thongbao.tieu_de LIKE ? OR thongbao.noi_dung LIKE ?)";
    $search_param = "%" . $search_term . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

// Điều kiện lọc
if ($filter_course !== 'all') {
    if ($filter_course === 'to_all_students') {
        $conditions[] = "thongbao.id_khoahoc IS NULL";
    } else {
        $conditions[] = "thongbao.id_khoahoc = ?";
        $params[] = (int)$filter_course;
        $types .= "i";
    }
}

if (!empty($conditions)) {
    $sql_notifications .= " WHERE " . implode(" AND ", $conditions);
}

$sql_notifications .= " GROUP BY thongbao.tieu_de, thongbao.noi_dung, thongbao.id_khoahoc, khoahoc.ten_khoahoc, thongbao.ngay_tao
                        ORDER BY thongbao.ngay_tao DESC";

$stmt = $conn->prepare($sql_notifications);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result_notifications = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-bell me-2"></i>Quản lý Thông báo</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sendNotificationModal">
                <i class="fa-solid fa-paper-plane"></i> Gửi Thông báo mới
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show" role="alert">
                    ' . htmlspecialchars($_SESSION['message']['text']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            unset($_SESSION['message']);
        }
        ?>

        <form method="GET" action="./admin.php" class="mb-4">
            <input type="hidden" name="nav" value="thongbao">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label">Tìm theo tiêu đề / nội dung</label>
                    <input type="text" name="search" id="search" class="form-control" value="<?php echo htmlspecialchars($search_term); ?>">
                </div>
                <div class="col-md-5">
                    <label for="filter_course" class="form-label">Lọc theo đối tượng</label>
                    <select name="filter_course" id="filter_course" class="form-select">
                        <option value="all" <?php if($filter_course == 'all') echo 'selected'; ?>>-- Tất cả --</option>
                        <option value="to_all_students" <?php if($filter_course == 'to_all_students') echo 'selected'; ?>>Gửi đến tất cả học viên</option>
                        <?php while ($course = $courses_for_filter->fetch_assoc()): ?>
                            <option value="<?php echo $course['id_khoahoc']; ?>" <?php if($filter_course == $course['id_khoahoc']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($course['ten_khoahoc']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Lọc</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tiêu đề</th><th style="width: 40%;">Nội dung</th><th>Gửi đến</th><th class="text-center">Ngày gửi</th><th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_notifications->num_rows > 0):
                        $index = 0;
                        while ($row = $result_notifications->fetch_assoc()): 
                            $target = $row['ten_khoahoc'] ? htmlspecialchars($row['ten_khoahoc']) : 'Tất cả học viên';
                    ?>
                        <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                            <td><?php echo htmlspecialchars($row['tieu_de']); ?></td>
                            <td><?php echo htmlspecialchars(substr($row['noi_dung'], 0, 150)) . (strlen($row['noi_dung']) > 150 ? '...' : ''); ?></td>
                            <td><span class="badge bg-info text-dark"><?php echo $target; ?></span></td>
                            <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_tao'])); ?></td>
                            <td class="text-center">
                                <form action='modules/thongbao/delete_notification.php' method='POST' onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhóm thông báo này?');">
                                    <input type='hidden' name='tieu_de' value="<?php echo htmlspecialchars($row['tieu_de']); ?>">
                                    <input type='hidden' name='id_khoahoc' value="<?php echo $row['id_khoahoc']; ?>">
                                    <input type='hidden' name='ngay_tao' value="<?php echo $row['ngay_tao']; ?>">
                                    <button type='submit' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Không tìm thấy thông báo nào phù hợp.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="sendNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Soạn và Gửi Thông báo</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="./modules/thongbao/send_notification.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3"><label for="tieu_de" class="form-label">Tiêu đề <span class="text-danger">*</span></label><input type="text" name="tieu_de" class="form-control" required></div>
                    <div class="mb-3"><label for="noi_dung" class="form-label">Nội dung <span class="text-danger">*</span></label><textarea name="noi_dung" id="noi_dung_editor" class="form-control" rows="5"></textarea></div>
                    <hr>
                    <label class="form-label fw-bold">Gửi đến:</label>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Khóa học</label>
                            <select name="id_khoahoc" class="form-select">
                                <option value="all">Tất cả học viên</option>
                                <?php mysqli_data_seek($courses_for_filter, 0); while ($row = $courses_for_filter->fetch_assoc()) { echo "<option value='" . $row['id_khoahoc'] . "'>" . htmlspecialchars($row['ten_khoahoc']) . "</option>"; } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lớp học (Ưu tiên cao hơn)</label>
                            <select name="id_lop" class="form-select">
                                <option value="all">-- Chọn lớp cụ thể --</option>
                                <?php while ($row = $classes_for_modal->fetch_assoc()) { echo "<option value='" . $row['id_lop'] . "'>" . htmlspecialchars($row['ten_lop']) . "</option>"; } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-text">Lưu ý: Nếu bạn chọn một Lớp học, thông báo sẽ chỉ được gửi đến các học viên trong lớp đó.</div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Gửi đi</button></div>
            </form>
        </div>
    </div>
</div>
<script>
    if (document.getElementById('noi_dung_editor')) {
        CKEDITOR.replace('noi_dung_editor');
    }
</script>