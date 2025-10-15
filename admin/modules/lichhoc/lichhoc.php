<?php
// File: admin/modules/lichhoc/lichhoc.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$lop_id = $_GET['lop_id'] ?? null;
$view = $_GET['view'] ?? 'students'; // Mặc định là tab học viên
$search_classes = $_GET['search_classes'] ?? '';

// Xác định link quay lại dựa trên vai trò
$is_teacher = isset($_SESSION['is_teacher']) && $_SESSION['is_teacher'] === true;
$back_link = $is_teacher ? './admin.php?nav=teacher_classes' : './admin.php?nav=lichhoc';


// Lấy danh sách giảng viên và khóa học để dùng cho các modal
$lecturers = $conn->query("SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien");
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

// Lấy thông tin lớp học và số liệu thống kê
$class_info = null;
$student_count = 0;
$schedule_count = 0;
if ($lop_id) {
    $stmt_info = $conn->prepare("
        SELECT 
            lh.ten_lop, 
            kh.ten_khoahoc,
            (SELECT COUNT(*) FROM dangkykhoahoc WHERE id_lop = ?) as student_count,
            (SELECT COUNT(*) FROM lichhoc WHERE id_lop = ?) as schedule_count
        FROM lop_hoc lh
        JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
        WHERE lh.id_lop = ?
    ");
    $stmt_info->bind_param('sss', $lop_id, $lop_id, $lop_id);
    $stmt_info->execute();
    $class_info = $stmt_info->get_result()->fetch_assoc();
    if (!$class_info) die("Lớp học không tồn tại.");
    $student_count = $class_info['student_count'];
    $schedule_count = $class_info['schedule_count'];
    $stmt_info->close();
}
?>
<style>
    .class-management-header {
        background: linear-gradient(135deg, #f5f7fa, #eef2f7);
        padding: 1.5rem 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }
    .class-title-section a {
        flex-shrink: 0;
    }
    .class-title-section h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark-text);
    }
    .class-title-section p {
        color: var(--gray-text);
        margin-bottom: 0;
    }
    .class-stats {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .stat-item .icon {
        font-size: 1.5rem;
        color: var(--brand-color);
    }
    .stat-item .value {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .stat-item .label {
        font-size: 0.85rem;
        color: var(--gray-text);
    }

    .management-nav-tabs {
        background-color: #fff;
        border-radius: 50px;
        padding: 0.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: inline-flex;
    }
    .management-nav-tabs .nav-link {
        color: var(--gray-text);
        font-weight: 500;
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        border: none;
        transition: all 0.3s ease;
    }
    .management-nav-tabs .nav-link.active {
        background-color: var(--brand-color);
        color: #fff;
        box-shadow: 0 4px 10px rgba(13, 179, 59, 0.3);
    }
    
    @media (max-width: 991.98px) {
        .class-management-header {
            text-align: center;
        }
        .class-stats {
            justify-content: center;
            margin-top: 1rem;
        }
        .management-nav-tabs {
            flex-wrap: wrap;
            border-radius: 12px;
        }
    }
</style>

<div class="container-fluid">
    <?php if ($lop_id && $class_info): ?>
        <div class="class-management-header animated-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3 class-title-section">
                     <a href="<?php echo $back_link; ?>" class="btn btn-light border" title="Quay lại">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    
                    <div>
                        <h1><?php echo htmlspecialchars($class_info['ten_lop']); ?></h1>
                        <p><?php echo htmlspecialchars($class_info['ten_khoahoc']); ?></p>
                    </div>
                </div>
                <div class="class-stats">
                    <div class="stat-item">
                        <i class="fa-solid fa-users icon"></i>
                        <div>
                            <div class="value"><?php echo $student_count; ?></div>
                            <div class="label">Học viên</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fa-solid fa-calendar-alt icon"></i>
                        <div>
                            <div class="value"><?php echo $schedule_count; ?></div>
                            <div class="label">Buổi học</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-4 animated-card" style="animation-delay: 100ms;">
            <ul class="nav nav-pills management-nav-tabs" id="managementTabs">
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'students') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=students"><i class="fa-solid fa-users me-2"></i>Học viên</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'schedule') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=schedule"><i class="fa-solid fa-calendar-days me-2"></i>Lịch học</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'grades') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=grades"><i class="fa-solid fa-marker me-2"></i>Điểm số</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($view == 'diemdanh') ? 'active' : ''; ?>" href="./admin.php?nav=lichhoc&lop_id=<?php echo $lop_id; ?>&view=diemdanh"><i class="fa-solid fa-user-check me-2"></i>Điểm danh</a></li>
            </ul>
        </div>

        <?php
            // Các tệp này sẽ được làm mới ở các bước sau
            if ($view === 'students') {
                include(__DIR__ . '/hocvienlop/view_students.php');
            } elseif ($view === 'schedule') {
                include(__DIR__ . '/lichhoclop/view_schedule.php');
            } elseif ($view === 'grades') {
                include(__DIR__ . '/diemso/view_grades.php');
            } elseif ($view === 'diemdanh') {
                include(__DIR__ . '/diemdanh/diemdanh.php');
            }
        ?>

    <?php else: ?>
        <?php include(__DIR__ . '/lophoc/view_classes.php'); ?>
    <?php endif; ?>

    <?php include(__DIR__ . '/lophoc/modals_lophoc.php'); ?>
    <?php if ($lop_id): ?>
        <?php 
            // Cập nhật logic lấy học viên đủ điều kiện cho modal
            $eligible_students = null;
            if ($lop_id) {
                $stmt_kh = $conn->prepare("SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?");
                $stmt_kh->bind_param('s', $lop_id);
                $stmt_kh->execute();
                if($id_khoahoc_res = $stmt_kh->get_result()->fetch_assoc()) {
                    $id_khoahoc = $id_khoahoc_res['id_khoahoc'];
                    $sql_eligible = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email FROM dangkykhoahoc dk JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien WHERE dk.id_khoahoc = ? AND dk.trang_thai = 'da xac nhan' AND dk.id_lop IS NULL";
                    $stmt_el = $conn->prepare($sql_eligible);
                    $stmt_el->bind_param('i', $id_khoahoc);
                    $stmt_el->execute();
                    $eligible_students = $stmt_el->get_result();
                }
            }
        ?>
        <?php include(__DIR__ . '/hocvienlop/modal_add_student.php'); ?>
        <?php include(__DIR__ . '/lichhoclop/modals_lichhoc.php'); ?>
    <?php endif; ?>
</div>
<script>
    let addClassModal, editClassModal, addStudentModal, addScheduleModal, editScheduleModal;

    // Hàm chung để xử lý phản hồi AJAX và hiển thị thông báo
    function handleAjaxResponse(response, successCallback) {
        if (response.status === 'success') {
            Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                })
                .then(() => {
                    if (successCallback) successCallback();
                });
        } else {
            Swal.fire('Lỗi!', response.message, 'error');
        }
    }

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
            document.getElementById('edit_id_giangvien').value = data.id_giangvien || "";
            document.getElementById('edit_trang_thai').value = data.trang_thai;

            if (editClassModal) editClassModal.show();
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
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_lop: classId
                        })
                    })
                    .then(res => res.json())
                    .then(data => handleAjaxResponse(data, () => {
                        const row = document.getElementById(`class-row-${classId}`);
                        if (row) row.remove();
                    }));
            }
        });
    }

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
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            student_id: studentId,
                            lop_id: lopId
                        })
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
            if (editScheduleModal) editScheduleModal.show();
        } catch (error) {
            Swal.fire('Lỗi!', error.message, 'error');
        }
    }

    function deleteSchedule(scheduleId) {
        Swal.fire({
            title: 'Xóa buổi học?',
            text: "Bạn có chắc muốn xóa buổi học này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Vâng, xóa!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./modules/lichhoc/lichhoclop/delete_schedule.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_lichhoc: scheduleId
                        })
                    })
                    .then(res => res.json()).then(data => handleAjaxResponse(data, () => {
                        const row = document.getElementById(`schedule-row-${scheduleId}`);
                        if (row) row.remove();
                    }));
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Khởi tạo các đối tượng modal
        if (document.getElementById('addClassModal')) addClassModal = new bootstrap.Modal(document.getElementById('addClassModal'));
        if (document.getElementById('editClassModal')) editClassModal = new bootstrap.Modal(document.getElementById('editClassModal'));
        if (document.getElementById('addStudentToClassModal')) addStudentModal = new bootstrap.Modal(document.getElementById('addStudentToClassModal'));
        if (document.getElementById('addScheduleModal')) addScheduleModal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
        if (document.getElementById('editScheduleModal')) editScheduleModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));

        // Gán sự kiện submit cho các form AJAX
        const formsToHandle = {
            '#addClassForm': './modules/lichhoc/lophoc/add_lop.php',
            '#editClassForm': './modules/lichhoc/lophoc/edit_class.php',
            '#addStudentToClassForm': './modules/lichhoc/hocvienlop/add_student_to_class.php',
            '#addScheduleForm': './modules/lichhoc/lichhoclop/add_schedule.php',
            '#editScheduleForm': './modules/lichhoc/lichhoclop/edit_schedule.php'
        };

        for (const [formId, url] of Object.entries(formsToHandle)) {
            const form = document.querySelector(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetch(url, {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(res => res.json()).then(data => handleAjaxResponse(data, () => location.reload()));
                });
            }
        }

        // Xử lý logic tìm kiếm cho modal "Thêm học viên"
        const addStudentModalEl = document.getElementById('addStudentToClassModal');
        if (addStudentModalEl) {
            const searchInput = document.getElementById('student-search-in-modal');
            const studentItems = addStudentModalEl.querySelectorAll('.student-item');

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    studentItems.forEach(item => {
                        const studentName = item.dataset.name;
                        if (studentName.includes(searchTerm)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        }
    });
</script>