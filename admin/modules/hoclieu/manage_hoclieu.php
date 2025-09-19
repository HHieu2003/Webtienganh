<?php
// File: admin/modules/hoclieu/manage_hoclieu.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$courses_for_modal = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

$selected_course_id = $_GET['course_id'] ?? null;
$selected_lop_id = $_GET['lop_id'] ?? null;
$search_keyword = $_GET['search'] ?? '';

$classes = [];
if ($selected_course_id) {
    $stmt_classes = $conn->prepare("SELECT id_lop, ten_lop FROM lop_hoc WHERE id_khoahoc = ? ORDER BY ten_lop");
    $stmt_classes->bind_param("i", $selected_course_id);
    $stmt_classes->execute();
    $result_classes = $stmt_classes->get_result();
    while ($row = $result_classes->fetch_assoc()) {
        $classes[] = $row;
    }
}

$sql_materials = "
    SELECT 
        hl.id_hoclieu, hl.tieu_de, hl.loai_file, hl.duong_dan_file, hl.ngay_dang,
        lh.ten_lop, 
        kh_main.ten_khoahoc
    FROM hoc_lieu hl
    LEFT JOIN lop_hoc lh ON hl.id_lop = lh.id_lop
    LEFT JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    LEFT JOIN khoahoc kh_main ON kh_main.id_khoahoc = COALESCE(kh.id_khoahoc, hl.id_khoahoc)
";

$conditions = []; $params = []; $types = "";
if (!empty($search_keyword)) {
    $conditions[] = "hl.tieu_de LIKE ?";
    $params[] = "%" . $search_keyword . "%"; $types .= "s";
}
if (!empty($selected_lop_id)) {
    $conditions[] = "hl.id_lop = ?";
    $params[] = $selected_lop_id; $types .= "s";
} elseif (!empty($selected_course_id)) {
    $conditions[] = "kh_main.id_khoahoc = ?";
    $params[] = (int)$selected_course_id; $types .= "i";
}
if (!empty($conditions)) {
    $sql_materials .= " WHERE " . implode(" AND ", $conditions);
}
$sql_materials .= " ORDER BY hl.ngay_dang DESC";

$stmt_materials = $conn->prepare($sql_materials);
if (!empty($params)) {
    $stmt_materials->bind_param($types, ...$params);
}
$stmt_materials->execute();
$result_materials = $stmt_materials->get_result();
$materials = $result_materials->fetch_all(MYSQLI_ASSOC);
?>

<div class="card animated-card">
    <div class="card-header"><h4 class="mb-0"><i class="fa-solid fa-file-alt me-2"></i>Quản lý Học liệu</h4></div>
    <div class="card-body">
        <form method="GET" action="./admin.php" class="filter-section bg-light p-3 rounded-3 mb-4">
            <input type="hidden" name="nav" value="hoclieu">
            <div class="row g-3 align-items-end">
                <div class="col-md-3"><label class="form-label"><strong>Tìm theo tiêu đề</strong></label><input type="text" name="search" class="form-control" placeholder="Nhập từ khóa..." value="<?php echo htmlspecialchars($search_keyword); ?>"></div>
                <div class="col-md-3"><label for="courseFilter" class="form-label"><strong>Lọc theo Khóa học</strong></label><select name="course_id" id="courseFilter" class="form-select"><option value="">-- Tất cả --</option><?php mysqli_data_seek($courses, 0); foreach ($courses as $course) : ?><option value="<?php echo $course['id_khoahoc']; ?>" <?php echo ($selected_course_id == $course['id_khoahoc']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endforeach; ?></select></div>
                <div class="col-md-3"><label for="classFilter" class="form-label"><strong>Lọc theo Lớp học</strong></label><select name="lop_id" id="classFilter" class="form-select" <?php echo empty($classes) ? 'disabled' : ''; ?>><option value="">-- Tất cả --</option><?php foreach ($classes as $class) : ?><option value="<?php echo $class['id_lop']; ?>" <?php echo ($selected_lop_id == $class['id_lop']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['ten_lop']); ?></option><?php endforeach; ?></select></div>
                <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Lọc</button><a href="./admin.php?nav=hoclieu" class="btn btn-secondary w-100">Reset</a></div>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5><?php echo count($materials); ?> kết quả được tìm thấy</h5>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMaterialModal"><i class="fa-solid fa-plus"></i> Thêm học liệu mới</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>Tiêu đề</th><th>Phạm vi</th><th>Khóa học</th><th class="text-center">Loại file</th><th class="text-center">Ngày đăng</th><th class="text-center">Hành động</th></tr></thead>
                <tbody>
                    <?php if (!empty($materials)) : foreach ($materials as $material) : ?>
                        <tr id="material-row-<?php echo $material['id_hoclieu']; ?>">
                            <td><?php echo htmlspecialchars($material['tieu_de']); ?></td>
                            <td>
                                <?php if ($material['ten_lop']) : ?>
                                    <span class="badge bg-primary">Lớp: <?php echo htmlspecialchars($material['ten_lop']); ?></span>
                                <?php else : ?>
                                    <span class="badge bg-info text-dark">Toàn khóa học</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($material['ten_khoahoc']); ?></td>
                            <td class="text-center"><span class="badge bg-secondary"><?php echo htmlspecialchars($material['loai_file']); ?></span></td>
                            <td class="text-center"><?php echo date("d/m/Y", strtotime($material['ngay_dang'])); ?></td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $material['id_hoclieu']; ?>)" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-info btn-sm text-white" title="Tải xuống" download><i class="fa-solid fa-download"></i></a>
                                <button class="btn btn-danger btn-sm" onclick="deleteMaterial(<?php echo $material['id_hoclieu']; ?>)" title="Xóa"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Không tìm thấy học liệu nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Thêm Học liệu mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addMaterialForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Phạm vi tài liệu <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="scope" id="scopeCourse" value="course" checked>
                            <label class="form-check-label" for="scopeCourse">Toàn khóa học</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="scope" id="scopeClass" value="class">
                            <label class="form-check-label" for="scopeClass">Lớp học cụ thể</label>
                        </div>
                    </div>
                    <div class="mb-3"><label class="form-label">Chọn Khóa học <span class="text-danger">*</span></label><select class="form-select" name="id_khoahoc_modal" id="modalCourseSelect" required><option value="" selected disabled>-- Chọn một khóa học --</option><?php mysqli_data_seek($courses_for_modal, 0); while ($course = $courses_for_modal->fetch_assoc()) : ?><option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endwhile; ?></select></div>
                    <div class="mb-3" id="modalClassSelectWrapper" style="display: none;"><label class="form-label">Chọn Lớp học <span class="text-danger">*</span></label><select class="form-select" name="id_lop" id="modalClassSelect"><option value="" selected disabled>-- Vui lòng chọn khóa học trước --</option></select></div>
                    <hr>
                    <div class="mb-3"><label class="form-label">Tiêu đề <span class="text-danger">*</span></label><input type="text" class="form-control" name="tieu_de" required></div>
                    <div class="mb-3"><label class="form-label">Tệp học liệu <span class="text-danger">*</span></label><input type="file" class="form-control" name="hoc_lieu_file" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Tải lên</button></div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editMaterialModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Chỉnh sửa Học liệu</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form id="editMaterialForm"><input type="hidden" name="id_hoclieu" id="edit_id_hoclieu"><div class="modal-body"><div class="mb-3"><label class="form-label">Tiêu đề <span class="text-danger">*</span></label><input type="text" class="form-control" name="tieu_de" id="edit_tieu_de" required></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div></form></div></div></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('courseFilter').addEventListener('change', function() {
        if (this.value) {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('course_id', this.value);
            currentUrl.searchParams.delete('lop_id');
            window.location.href = currentUrl.href;
        }
    });

    const addMaterialModalEl = document.getElementById('addMaterialModal');
    const modalCourseSelect = document.getElementById('modalCourseSelect');
    const modalClassSelect = document.getElementById('modalClassSelect');
    const modalClassWrapper = document.getElementById('modalClassSelectWrapper');
    const scopeRadios = document.querySelectorAll('input[name="scope"]');
    
    addMaterialModalEl.addEventListener('show.bs.modal', function() {
        document.getElementById('addMaterialForm').reset();
        modalClassWrapper.style.display = 'none';
        modalClassSelect.innerHTML = '<option value="" selected disabled>-- Vui lòng chọn khóa học trước --</option>';
        modalClassSelect.disabled = true;
        modalClassSelect.required = false;
    });

    scopeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'class') {
                modalClassWrapper.style.display = 'block';
                modalClassSelect.required = true;
            } else {
                modalClassWrapper.style.display = 'none';
                modalClassSelect.required = false;
                modalClassSelect.value = '';
            }
        });
    });

    modalCourseSelect.addEventListener('change', async function() {
        const courseId = this.value;
        modalClassSelect.disabled = true;
        modalClassSelect.innerHTML = '<option value="">Đang tải...</option>';
        if (courseId) {
            const response = await fetch(`./modules/hoclieu/get_classes_by_course.php?course_id=${courseId}`);
            const classes = await response.json();
            modalClassSelect.innerHTML = '<option value="" selected disabled>-- Chọn một lớp học --</option>';
            if (classes.length > 0) {
                classes.forEach(cls => modalClassSelect.add(new Option(cls.ten_lop, cls.id_lop)));
                modalClassSelect.disabled = false;
            } else {
                modalClassSelect.innerHTML = '<option value="">-- Khóa học này chưa có lớp --</option>';
            }
        }
    });

    document.getElementById('addMaterialForm').addEventListener('submit', function(e) { e.preventDefault(); const formData = new FormData(this); fetch('./modules/hoclieu/add_hoclieu.php', { method: 'POST', body: formData }).then(res => res.json()).then(data => handleAjaxResponse(data, () => location.reload())); });
    document.getElementById('editMaterialForm').addEventListener('submit', function(e) { e.preventDefault(); const formData = new FormData(this); fetch('./modules/hoclieu/edit_hoclieu.php', { method: 'POST', body: formData }).then(res => res.json()).then(data => handleAjaxResponse(data, () => location.reload())); });
});

function handleAjaxResponse(response, callback) {
    if (response.status === 'success') {
        const addModal = bootstrap.Modal.getInstance(document.getElementById('addMaterialModal')); if(addModal) addModal.hide();
        const editModal = bootstrap.Modal.getInstance(document.getElementById('editMaterialModal')); if(editModal) editModal.hide();
        Swal.fire({ icon: 'success', title: 'Thành công!', text: response.message, timer: 1500, showConfirmButton: false }).then(callback);
    } else { Swal.fire('Lỗi!', response.message, 'error'); }
}

async function openEditModal(materialId) {
    const response = await fetch(`./modules/hoclieu/get_hoclieu_info.php?id=${materialId}`);
    const data = await response.json();
    document.getElementById('edit_id_hoclieu').value = data.id_hoclieu;
    document.getElementById('edit_tieu_de').value = data.tieu_de;
    new bootstrap.Modal(document.getElementById('editMaterialModal')).show();
}

function deleteMaterial(materialId) {
    Swal.fire({ title: 'Bạn có chắc chắn?', text: "Học liệu sẽ bị xóa vĩnh viễn!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Vâng, xóa nó!' }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/hoclieu/delete_hoclieu.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id_hoclieu: materialId }) })
            .then(res => res.json()).then(data => handleAjaxResponse(data, () => document.getElementById(`material-row-${materialId}`).remove()));
        }
    });
}
</script>