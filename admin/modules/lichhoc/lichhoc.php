<?php
// Bắt đầu session nếu chưa có
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy các tham số từ URL
$lop_id = $_GET['lop_id'] ?? null;
$view = $_GET['view'] ?? 'students'; // Mặc định tab đầu tiên là 'students'
$search_classes = $_GET['search_classes'] ?? '';

// Lấy danh sách giảng viên và khóa học cho các form modal
$lecturers = $conn->query("SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien");
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

// Lấy dữ liệu cho Modal "Thêm học viên" nếu đang ở trang chi tiết
$eligible_students = null;
if ($lop_id) {
    // ... (logic lấy học viên đủ điều kiện giữ nguyên)
    $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
    $stmt_kh->bind_param('s', $lop_id);
    $stmt_kh->execute();
    $id_khoahoc_result = $stmt_kh->get_result();
    if ($id_khoahoc_result->num_rows > 0) {
        $id_khoahoc = $id_khoahoc_result->fetch_assoc()['id_khoahoc'];
        $stmt_kh->close();
        $sql_eligible = "SELECT hv.id_hocvien, hv.ten_hocvien FROM dangkykhoahoc dk
                         JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                         WHERE dk.id_khoahoc = ? AND dk.trang_thai = 'da xac nhan' AND dk.id_lop IS NULL";
        $stmt_el = $conn->prepare($sql_eligible);
        $stmt_el->bind_param('i', $id_khoahoc);
        $stmt_el->execute();
        $eligible_students = $stmt_el->get_result();
    }
}
?>

<div class="container-fluid">
    <?php if ($lop_id): // --- GIAO DIỆN CHI TIẾT LỚP HỌC (VỚI TABS) --- ?>
        <?php
        $sql_lop = "SELECT lh.ten_lop, kh.ten_khoahoc FROM lop_hoc lh
                    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
                    WHERE lh.id_lop = ?";
        $stmt_lop = $conn->prepare($sql_lop);
        $stmt_lop->bind_param('s', $lop_id);
        $stmt_lop->execute();
        $lop = $stmt_lop->get_result()->fetch_assoc();
        if (!$lop) die("Lớp học không tồn tại.");
        ?>
        <div class="d-flex align-items-center mb-3">
            <a href="./admin.php?nav=lichhoc" class="btn btn-secondary me-3"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            <h1 class="title-color mb-0" style="border: none; padding-bottom: 0; margin-bottom: 0;">Lớp: <?php echo htmlspecialchars($lop['ten_lop']); ?></h1>
        </div>
        
        <div class="card animated-card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($view == 'students') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=students">
                            <i class="fa-solid fa-users"></i> Quản lý Học viên
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($view == 'schedule') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=schedule">
                            <i class="fa-solid fa-calendar-days"></i> Quản lý Lịch học
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($view == 'diemdanh') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=diemdanh">
                            <i class="fa-solid fa-user-check"></i> Điểm danh
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                    unset($_SESSION['message']);
                }
                if ($view === 'students' && file_exists('modules/lichhoc/view_students.php')) {
                    include('modules/lichhoc/view_students.php');
                } elseif ($view === 'schedule' && file_exists('modules/lichhoc/view_schedule.php')) {
                    include('modules/lichhoc/view_schedule.php');
                } elseif ($view === 'diemdanh' && file_exists('modules/diemdanh/diemdanh.php')) {
                    include('modules/diemdanh/diemdanh.php');
                }
                ?>
            </div>
        </div>
    <?php else: // --- GIAO DIỆN DANH SÁCH CÁC LỚP HỌC --- ?>
        <?php
            $sql = "SELECT lh.id_lop, lh.ten_lop, lh.trang_thai, kh.ten_khoahoc, gv.ten_giangvien 
                    FROM lop_hoc lh 
                    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc 
                    LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien";
            $params = [];
            $types = "";
            if (!empty($search_classes)) {
                $sql .= " WHERE lh.ten_lop LIKE ? OR kh.ten_khoahoc LIKE ? OR gv.ten_giangvien LIKE ?";
                $search_param = "%" . $search_classes . "%";
                $params = [$search_param, $search_param, $search_param];
                $types = "sss";
            }
            $sql .= " ORDER BY lh.id_lop ASC";
            $stmt = $conn->prepare($sql);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
        <div class="card animated-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fa-solid fa-school me-2"></i>Quản lý Lớp học</h4>
                    <div class="d-flex">
                        <form method="GET" action="./admin.php" class="d-flex me-2">
                             <input type="hidden" name="nav" value="lichhoc">
                             <input type="text" name="search_classes" class="form-control" placeholder="Tìm tên lớp, khóa học..." value="<?php echo htmlspecialchars($search_classes); ?>">
                             <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                        <a href="modules/lichhoc/export_classes.php?search=<?php echo htmlspecialchars($search_classes); ?>" class="btn btn-info text-white me-2"><i class="fa-solid fa-file-excel"></i> Excel</a>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClassModal"><i class="fa-solid fa-plus"></i> Thêm Lớp</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                    unset($_SESSION['message']);
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr><th>ID Lớp</th><th>Tên Lớp</th><th>Khóa học</th><th>Giảng viên</th><th class="text-center">Trạng thái</th><th class="text-center">Hành động</th></tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0):
                                $index = 0; while ($row = $result->fetch_assoc()): ?>
                                <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                                    <td><strong><?php echo htmlspecialchars($row['id_lop']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['ten_lop']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                                    <td><?php echo ($row['ten_giangvien'] ? htmlspecialchars($row['ten_giangvien']) : '<span class="text-muted">Chưa phân công</span>'); ?></td>
                                    <td class="text-center"><?php echo ($row['trang_thai'] === 'dang hoc') ? '<span class="badge bg-success">Đang học</span>' : '<span class="badge bg-secondary">Đã xong</span>'; ?></td>
                                    <td class="text-center">
                                        <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>" class="btn btn-info btn-sm text-white mb-1" title="Quản lý chi tiết"><i class="fa-solid fa-arrow-right-to-bracket"></i> Chi tiết</a>
                                        <button class="btn btn-primary btn-sm" onclick="openEditModal('<?php echo $row['id_lop']; ?>')" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <a href="modules/lichhoc/delete_lop.php?delete_lop_id=<?php echo $row['id_lop'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa lớp học?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile;
                            else: ?>
                                <tr><td colspan="6" class="text-center text-muted py-3">Không có lớp học nào phù hợp.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Thêm Lớp học mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form method="POST" action="modules/lichhoc/add_lop.php">
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">ID Lớp <span class="text-danger">*</span></label><input type="text" name="id_lop" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Tên Lớp <span class="text-danger">*</span></label><input type="text" name="ten_lop" class="form-control" required></div>
                        <div class="mb-3">
                            <label class="form-label">Thuộc Khóa Học <span class="text-danger">*</span></label>
                            <select name="id_khoahoc" class="form-select" required>
                                <?php mysqli_data_seek($courses, 0); while ($course = $courses->fetch_assoc()) { echo "<option value='{$course['id_khoahoc']}'>" . htmlspecialchars($course['ten_khoahoc']) . "</option>"; } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phân công Giảng Viên</label>
                            <select name="id_giangvien" class="form-select">
                                <option value="">-- Chưa phân công --</option>
                                <?php mysqli_data_seek($lecturers, 0); while ($lecturer = $lecturers->fetch_assoc()) { echo "<option value='{$lecturer['id_giangvien']}'>" . htmlspecialchars($lecturer['ten_giangvien']) . "</option>"; } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select name="trang_thai" class="form-select"><option value="dang hoc">Đang học</option><option value="da xong">Đã xong</option></select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" name="add_class" class="btn btn-primary">Thêm Lớp</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Chỉnh sửa Lớp học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form method="POST" action="modules/lichhoc/edit_class.php">
                    <input type="hidden" name="edit_id_lop" id="edit_id_lop">
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Tên Lớp <span class="text-danger">*</span></label><input type="text" name="edit_ten_lop" id="edit_ten_lop" class="form-control" required></div>
                        <div class="mb-3">
                            <label class="form-label">Phân công Giảng Viên</label>
                            <select name="edit_id_giangvien" id="edit_id_giangvien" class="form-select">
                                <option value="">-- Chưa phân công --</option>
                                <?php mysqli_data_seek($lecturers, 0); while ($lecturer = $lecturers->fetch_assoc()) { echo "<option value='{$lecturer['id_giangvien']}'>" . htmlspecialchars($lecturer['ten_giangvien']) . "</option>"; } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select name="edit_trang_thai" id="edit_trang_thai" class="form-select"><option value="dang hoc">Đang học</option><option value="da xong">Đã xong</option></select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addStudentToClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Thêm học viên vào lớp</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form method="POST" action="modules/lichhoc/add_student_to_class.php">
                    <input type="hidden" name="id_lop" value="<?php echo $lop_id; ?>">
                    <div class="modal-body">
                        <?php if ($eligible_students && $eligible_students->num_rows > 0): ?>
                            <div class="mb-3">
                                <label class="form-label">Chọn học viên:</label>
                                <select name="id_hocvien" class="form-select" required>
                                    <option value="">-- Học viên đã đăng ký, chờ xếp lớp --</option>
                                    <?php foreach ($eligible_students as $student): ?>
                                        <option value="<?php echo $student['id_hocvien']; ?>"><?php echo htmlspecialchars($student['ten_hocvien']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">Không có học viên nào đang chờ xếp lớp cho khóa học này.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <?php if ($eligible_students && $eligible_students->num_rows > 0): ?>
                            <button type="submit" name="add_student" class="btn btn-primary">Thêm vào lớp</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Thêm buổi học mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="modules/lichhoc/add_schedule.php" method="POST">
                    <input type="hidden" name="id_lop" value="<?php echo $lop_id; ?>">
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Ngày học</label><input type="date" name="ngay_hoc" class="form-control" required></div>
                        <div class="row"><div class="col-6 mb-3"><label class="form-label">Giờ bắt đầu</label><input type="time" name="gio_bat_dau" class="form-control" required></div><div class="col-6 mb-3"><label class="form-label">Giờ kết thúc</label><input type="time" name="gio_ket_thuc" class="form-control" required></div></div>
                        <div class="mb-3"><label class="form-label">Phòng học (hoặc link online)</label><input type="text" name="phong_hoc" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Ghi chú</label><textarea name="ghi_chu" class="form-control" rows="2"></textarea></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Chỉnh sửa buổi học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="modules/lichhoc/edit_schedule.php" method="POST">
                    <input type="hidden" name="id_lop" value="<?php echo $lop_id; ?>">
                    <input type="hidden" name="edit_id_lichhoc" id="edit_id_lichhoc">
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Ngày học</label><input type="date" id="edit_ngay_hoc" name="ngay_hoc" class="form-control" required></div>
                        <div class="row"><div class="col-6 mb-3"><label class="form-label">Giờ bắt đầu</label><input type="time" id="edit_gio_bat_dau" name="gio_bat_dau" class="form-control" required></div><div class="col-6 mb-3"><label class="form-label">Giờ kết thúc</label><input type="time" id="edit_gio_ket_thuc" name="gio_ket_thuc" class="form-control" required></div></div>
                        <div class="mb-3"><label class="form-label">Phòng học</label><input type="text" id="edit_phong_hoc" name="phong_hoc" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Ghi chú</label><textarea id="edit_ghi_chu" name="ghi_chu" class="form-control" rows="2"></textarea></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript để mở các Modal (Giữ nguyên không đổi)
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById('editClassModal')) {
            window.editClassModal = new bootstrap.Modal(document.getElementById('editClassModal'));
        }
        if (document.getElementById('editScheduleModal')) {
            window.editScheduleModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));
        }
    });

    async function openEditModal(lopId) {
        try {
            const response = await fetch(`./modules/lichhoc/get_class_info.php?id=${lopId}`);
            const data = await response.json();
            if (data.error) { alert(`Lỗi: ${data.error}`); return; }
            document.getElementById('edit_id_lop').value = data.id_lop;
            document.getElementById('edit_ten_lop').value = data.ten_lop;
            document.getElementById('edit_id_giangvien').value = data.id_giangvien || "";
            document.getElementById('edit_trang_thai').value = data.trang_thai;
            if (window.editClassModal) { window.editClassModal.show(); }
        } catch (error) { console.error('Lỗi:', error); }
    }

    async function openEditScheduleModal(scheduleId) {
        try {
            const response = await fetch(`./modules/lichhoc/get_schedule_info.php?id=${scheduleId}`);
            if (!response.ok) throw new Error('Network response was not ok.');
            const data = await response.json();
            document.getElementById('edit_id_lichhoc').value = data.id_lichhoc;
            document.getElementById('edit_ngay_hoc').value = data.ngay_hoc;
            document.getElementById('edit_gio_bat_dau').value = data.gio_bat_dau;
            document.getElementById('edit_gio_ket_thuc').value = data.gio_ket_thuc;
            document.getElementById('edit_phong_hoc').value = data.phong_hoc;
            document.getElementById('edit_ghi_chu').value = data.ghi_chu;
            if (window.editScheduleModal) { window.editScheduleModal.show(); }
        } catch (error) {
            console.error('Lỗi:', error);
            alert('Không thể lấy dữ liệu buổi học.');
        }
    }
</script>