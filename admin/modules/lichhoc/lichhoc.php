<?php
// File: admin/modules/lichhoc/lichhoc.php
if (session_status() == PHP_SESSION_NONE) session_start();

$lop_id = $_GET['lop_id'] ?? null;
$view = $_GET['view'] ?? 'students'; 
$search_classes = $_GET['search_classes'] ?? '';

$lecturers = $conn->query("SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien");
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

$eligible_students = null;
if ($lop_id) {
    $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
    $stmt_kh->bind_param('s', $lop_id);
    $stmt_kh->execute();
    $id_khoahoc_result = $stmt_kh->get_result();
    if ($id_khoahoc_result->num_rows > 0) {
        $id_khoahoc = $id_khoahoc_result->fetch_assoc()['id_khoahoc'];
        $stmt_kh->close();
        
        $sql_eligible = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email FROM dangkykhoahoc dk
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
    <?php if ($lop_id): ?>
        <?php
        $sql_lop = "SELECT lh.ten_lop FROM lop_hoc lh WHERE lh.id_lop = ?";
        $stmt_lop = $conn->prepare($sql_lop); $stmt_lop->bind_param('s', $lop_id); $stmt_lop->execute();
        $lop = $stmt_lop->get_result()->fetch_assoc();
        if (!$lop) die("Lớp học không tồn tại.");
        ?>
        <div class="d-flex align-items-center mb-3">
            <a href="./admin.php?nav=lichhoc" class="btn btn-secondary me-3"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            <h1 class="title-color mb-0" style="border: none; padding-bottom: 0; margin-bottom: 0;">Lớp: <?php echo htmlspecialchars($lop['ten_lop']); ?></h1>
        </div>
        
        <div class="card animated-card">
            <div class="card-header"><ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'students') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=students"><i class="fa-solid fa-users me-2"></i>Quản lý Học viên</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'schedule') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=schedule"><i class="fa-solid fa-calendar-days me-2"></i>Quản lý Lịch học</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'diemdanh') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=diemdanh"><i class="fa-solid fa-user-check me-2"></i>Điểm danh</a></li>
            </ul></div>
            <div class="card-body">
                <?php
                if ($view === 'students') { include(__DIR__ . '/hocvienlop/view_students.php'); } 
                elseif ($view === 'schedule') { include(__DIR__ . '/lichhoclop/view_schedule.php'); } 
                elseif ($view === 'diemdanh') { include(__DIR__ . '/diemdanh/diemdanh.php'); }
                ?>
            </div>
        </div>
    <?php else: ?>
        <?php include(__DIR__ . '/lophoc/view_classes.php'); ?>
    <?php endif; ?>

    <?php include(__DIR__ . '/lophoc/modals_lophoc.php'); ?>
    <?php if ($lop_id): ?>
        <?php include(__DIR__ . '/hocvienlop/modal_add_student.php'); ?>
        <?php include(__DIR__ . '/lichhoclop/modals_lichhoc.php'); ?>
    <?php endif; ?>
</div>

<script>
let addClassModal, editClassModal, addStudentModal, addScheduleModal, editScheduleModal;

function handleAjaxResponse(response, successCallback) {
    if (response.status === 'success') {
        Swal.fire({ icon: 'success', title: 'Thành công!', text: response.message, timer: 1500, showConfirmButton: false })
        .then(() => { if (successCallback) successCallback(); });
    } else { Swal.fire('Lỗi!', response.message, 'error'); }
}

async function openEditClassModal(lopId) { /* ... Giữ nguyên ... */ }
function deleteClass(lopId) { /* ... Giữ nguyên ... */ }
function removeStudent(studentId, lopId, studentName) { /* ... Giữ nguyên ... */ }

async function openEditScheduleModal(scheduleId) {
    try {
        const response = await fetch(`./modules/lichhoc/lichhoclop/get_schedule_info.php?id=${scheduleId}`);
        const data = await response.json();
        if (data.error) throw new Error(data.error);
        document.getElementById('edit_id_lichhoc').value = data.id_lichhoc;
        document.getElementById('edit_ngay_hoc').value = data.ngay_hoc;
        document.getElementById('edit_gio_bat_dau').value = data.gio_bat_dau;
        document.getElementById('edit_gio_ket_thuc').value = data.gio_ket_thuc;
        document.getElementById('edit_phong_hoc').value = data.phong_hoc;
        document.getElementById('edit_ghi_chu').value = data.ghi_chu;
        if(editScheduleModal) editScheduleModal.show();
    } catch (error) { Swal.fire('Lỗi!', error.message, 'error'); }
}

function deleteSchedule(scheduleId) {
    Swal.fire({
        title: 'Xóa buổi học?', text: "Bạn có chắc muốn xóa buổi học này?", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Vâng, xóa!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/lichhoc/lichhoclop/delete_schedule.php', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({ id_lichhoc: scheduleId }) })
            .then(res => res.json()).then(data => handleAjaxResponse(data, () => { const row = document.getElementById(`schedule-row-${scheduleId}`); if (row) row.remove(); }));
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    if(document.getElementById('addClassModal')) addClassModal = new bootstrap.Modal(document.getElementById('addClassModal'));
    if(document.getElementById('editClassModal')) editClassModal = new bootstrap.Modal(document.getElementById('editClassModal'));
    if(document.getElementById('addStudentToClassModal')) addStudentModal = new bootstrap.Modal(document.getElementById('addStudentToClassModal'));
    if(document.getElementById('addScheduleModal')) addScheduleModal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
    if(document.getElementById('editScheduleModal')) editScheduleModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));

    const formsToHandle = {
        '#addClassForm': './modules/lichhoc/lophoc/add_lop.php',
        '#editClassForm': './modules/lichhoc/lophoc/edit_class.php',
        '#addScheduleForm': './modules/lichhoc/lichhoclop/add_schedule.php',
        '#editScheduleForm': './modules/lichhoc/lichhoclop/edit_schedule.php'
    };
    for (const [formId, url] of Object.entries(formsToHandle)) {
        const form = document.querySelector(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                fetch(url, { method: 'POST', body: new FormData(this) })
                .then(res => res.json()).then(data => handleAjaxResponse(data, () => location.reload()));
            });
        }
    }

    const addStudentModalEl = document.getElementById('addStudentToClassModal');
    if (addStudentModalEl) {
        const searchInput = addStudentModalEl.querySelector('#student-search-in-modal');
        const studentItems = addStudentModalEl.querySelectorAll('.student-item');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            studentItems.forEach(item => {
                const studentName = item.getAttribute('data-name');
                item.style.display = studentName.includes(searchTerm) ? 'flex' : 'none';
            });
        });
        const addStudentForm = document.getElementById('addStudentToClassForm');
        addStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            if (!formData.has('id_hocvien_list[]')) {
                Swal.fire('Chưa chọn!', 'Bạn cần chọn ít nhất một học viên để thêm vào lớp.', 'warning');
                return;
            }
            fetch('./modules/lichhoc/hocvienlop/add_student_to_class.php', { method: 'POST', body: formData })
            .then(res => res.json()).then(data => handleAjaxResponse(data, () => location.reload()));
        });
        addStudentModalEl.addEventListener('hidden.bs.modal', () => {
            searchInput.value = '';
            studentItems.forEach(item => {
                item.style.display = 'flex';
                item.querySelector('input[type="checkbox"]').checked = false;
            });
        });
    }
});
</script>