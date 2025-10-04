<?php
// File: admin/modules/lichhoc/lichhoc.php
if (session_status() == PHP_SESSION_NONE) session_start();

$lop_id = $_GET['lop_id'] ?? null;
$view = $_GET['view'] ?? 'students'; 
$search_classes = $_GET['search_classes'] ?? '';

// Lấy danh sách giảng viên và khóa học để dùng cho các modal
$lecturers = $conn->query("SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien");
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

// Lấy danh sách học viên đủ điều kiện để thêm vào lớp (nếu đang xem chi tiết một lớp)
$eligible_students = null;
if ($lop_id) {
    $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
    $stmt_kh->bind_param('s', $lop_id);
    $stmt_kh->execute();
    $id_khoahoc_result = $stmt_kh->get_result();
    if ($id_khoahoc_result->num_rows > 0) {
        $id_khoahoc = $id_khoahoc_result->fetch_assoc()['id_khoahoc'];
        $stmt_kh->close();
        
        // Học viên đã đăng ký khóa học, đã được xác nhận, và chưa được xếp vào lớp nào
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
        // Lấy thông tin lớp học để hiển thị tiêu đề
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
                 <li class="nav-item"><a class="nav-link <?php echo ($view == 'grades') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=grades"><i class="fa-solid fa-marker me-2"></i>Quản lý Điểm số</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'diemdanh') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=diemdanh"><i class="fa-solid fa-user-check me-2"></i>Điểm danh</a></li>
            </ul></div>
            <div class="card-body">
                <?php
                if ($view === 'students') { include(__DIR__ . '/hocvienlop/view_students.php'); } 
                elseif ($view === 'schedule') { include(__DIR__ . '/lichhoclop/view_schedule.php'); } 
                elseif ($view === 'grades') { include(__DIR__ . '/diemso/view_grades.php'); }
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

// Hàm chung để xử lý phản hồi AJAX và hiển thị thông báo
function handleAjaxResponse(response, successCallback) {
    if (response.status === 'success') {
        Swal.fire({ icon: 'success', title: 'Thành công!', text: response.message, timer: 1500, showConfirmButton: false })
        .then(() => { if (successCallback) successCallback(); });
    } else { Swal.fire('Lỗi!', response.message, 'error'); }
}

// ==========================================================
// ===== BỔ SUNG CÁC HÀM JAVASCRIPT CÒN THIẾU TẠI ĐÂY =====
// ==========================================================

/**
 * Mở modal chỉnh sửa thông tin lớp học
 * @param {string} classId - ID của lớp cần sửa
 */
async function openEditClassModal(classId) {
    try {
        const response = await fetch(`./modules/lichhoc/lophoc/get_class_info.php?id=${classId}`);
        const data = await response.json();
        if (data.error) throw new Error(data.error);
        
        document.getElementById('edit_id_lop').value = data.id_lop;
        document.getElementById('edit_ten_lop').value = data.ten_lop;
        document.getElementById('edit_id_giangvien').value = data.id_giangvien || ""; // Xử lý trường hợp giảng viên là NULL
        document.getElementById('edit_trang_thai').value = data.trang_thai;
        
        if(editClassModal) editClassModal.show();
    } catch (error) {
        Swal.fire('Lỗi!', error.message, 'error');
    }
}

/**
 * Xóa một lớp học
 * @param {string} classId - ID của lớp cần xóa
 */
function deleteClass(classId) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Xóa lớp học sẽ xóa tất cả lịch học, điểm danh và các dữ liệu liên quan. Hành động này không thể khôi phục!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Chắc chắn xóa!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/lichhoc/lophoc/delete_lop.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_lop: classId })
            })
            .then(res => res.json())
            .then(data => handleAjaxResponse(data, () => {
                const row = document.getElementById(`class-row-${classId}`);
                if (row) row.remove();
            }));
        }
    });
}

// ==========================================================
// ===== KẾT THÚC PHẦN BỔ SUNG =============================
// ==========================================================


function removeStudent(studentId, lopId, studentName) {
    Swal.fire({
        title: 'Xác nhận xóa',
        text: `Bạn có chắc chắn muốn xóa học viên "${studentName}" khỏi lớp này không?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Chắc chắn xóa!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/lichhoc/hocvienlop/remove_student.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ student_id: studentId, lop_id: lopId })
            })
            .then(res => res.json())
            .then(data => handleAjaxResponse(data, () => {
                const row = document.getElementById(`student-row-${studentId}`);
                if (row) row.remove();
            }));
        }
    });
}

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
    // Khởi tạo các đối tượng modal
    if(document.getElementById('addClassModal')) addClassModal = new bootstrap.Modal(document.getElementById('addClassModal'));
    if(document.getElementById('editClassModal')) editClassModal = new bootstrap.Modal(document.getElementById('editClassModal'));
    if(document.getElementById('addStudentToClassModal')) addStudentModal = new bootstrap.Modal(document.getElementById('addStudentToClassModal'));
    if(document.getElementById('addScheduleModal')) addScheduleModal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
    if(document.getElementById('editScheduleModal')) editScheduleModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));

    // Gán sự kiện submit cho các form AJAX
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

    // Xử lý logic cho modal "Thêm học viên"
    const addStudentModalEl = document.getElementById('addStudentToClassModal');
    if (addStudentModalEl) {
        // ... (Giữ nguyên logic của modal thêm học viên)
    }
});
</script>