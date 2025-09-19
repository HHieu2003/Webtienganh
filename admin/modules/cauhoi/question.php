<?php
// File: admin/modules/cauhoi/question.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Lấy danh sách bài test và thông tin liên quan
$sql = "SELECT bt.id_baitest, bt.ten_baitest, bt.ngay_tao, bt.loai_baitest, kh.ten_khoahoc, lh.ten_lop
        FROM baitest bt 
        LEFT JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
        LEFT JOIN lop_hoc lh ON bt.id_lop = lh.id_lop
        ORDER BY bt.id_baitest DESC";
$result = $conn->query($sql);

// Lấy danh sách khóa học cho các modal
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$courses_for_edit_modal = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

/**
 * Hàm hiển thị badge cho từng loại bài test.
 * @param string $type Loại bài test từ CSDL.
 * @return string HTML của badge.
 */
function get_test_type_badge($type) {
    switch ($type) {
        case 'dau_vao': return '<span class="badge bg-primary">Test đầu vào</span>';
        case 'dinh_ky': return '<span class="badge bg-info text-dark">Test định kỳ</span>';
        case 'on_tap': return '<span class="badge bg-secondary">Test ôn tập</span>';
        default: return '<span class="badge bg-light text-dark">' . htmlspecialchars($type) . '</span>';
    }
}
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-circle-question me-2"></i>Quản lý Bài Test</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTestModal"><i class="fa-solid fa-plus"></i> Thêm Bài Test</button>
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
                    <tr>
                        <th>ID</th>
                        <th>Tên Bài Test</th>
                        <th>Phạm vi</th>
                        <th class="text-center">Loại Test</th>
                        <th class="text-center">Ngày Tạo</th>
                        <th class="text-center" style="min-width: 180px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                        // Xác định phạm vi của bài test
                        $scope = '<span class="badge bg-secondary">Công khai</span>';
                        if ($row['ten_lop']) {
                            $scope = '<strong>Lớp:</strong> ' . htmlspecialchars($row['ten_lop']);
                        } elseif ($row['ten_khoahoc']) {
                            $scope = '<strong>Khóa:</strong> ' . htmlspecialchars($row['ten_khoahoc']);
                        }
                    ?>
                        <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                            <td><?php echo $row['id_baitest']; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_baitest']); ?></td>
                            <td><?php echo $scope; ?></td>
                            <td class="text-center"><?php echo get_test_type_badge($row['loai_baitest']); ?></td>
                            <td class="text-center"><?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></td>
                            <td class="text-center">
                                <a href="./admin.php?nav=ds_cauhoi&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-primary btn-sm" title="Quản lý câu hỏi"><i class="fa-solid fa-list-check"></i></a>
                                <button onclick="openEditModal(<?php echo $row['id_baitest']; ?>)" class="btn btn-warning btn-sm" title="Sửa bài test"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="./admin.php?nav=kqhocvien&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-info btn-sm text-white" title="Xem kết quả"><i class="fa-solid fa-square-poll-vertical"></i></a>
                                <a href="./modules/cauhoi/delete_test.php?id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa bài test này sẽ xóa tất cả dữ liệu liên quan. Bạn chắc chắn?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Thêm Bài Test mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="modules/cauhoi/add_test.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên Bài Test <span class="text-danger">*</span></label><input type="text" name="ten_baitest" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Loại bài test <span class="text-danger">*</span></label><select name="loai_baitest" class="form-select" required><option value="dau_vao">Kiểm tra đầu vào</option><option value="dinh_ky">Kiểm tra định kỳ</option><option value="on_tap" selected>Bài ôn tập</option></select></div>
                    <div class="mb-3"><label class="form-label">Phạm vi áp dụng</label><select name="id_khoahoc" class="form-select" id="add_id_khoahoc"><option value="">-- Công khai hoặc Chọn khóa học --</option><?php mysqli_data_seek($courses, 0); while ($course = $courses->fetch_assoc()): ?><option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endwhile; ?></select></div>
                    <div class="mb-3" id="add_class_wrapper" style="display:none;"><label class="form-label">Gán cho Lớp học (Tùy chọn)</label><select name="id_lop" class="form-select" id="add_id_lop"><option value="">-- Áp dụng cho toàn khóa học --</option></select></div>
                    <div class="mb-3"><label class="form-label">Thời Gian (phút) <span class="text-danger">*</span></label><input type="number" name="thoi_gian" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Chỉnh sửa Bài Test</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="modules/cauhoi/edit_test.php" method="POST">
                <input type="hidden" name="id_baitest" id="edit_id_baitest">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên Bài Test <span class="text-danger">*</span></label><input type="text" name="ten_baitest" id="edit_ten_baitest" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Loại bài test <span class="text-danger">*</span></label><select name="loai_baitest" id="edit_loai_baitest" class="form-select" required><option value="dau_vao">Kiểm tra đầu vào</option><option value="dinh_ky">Kiểm tra định kỳ</option><option value="on_tap">Bài ôn tập</option></select></div>
                    <div class="mb-3"><label class="form-label">Phạm vi áp dụng</label><select name="id_khoahoc" id="edit_id_khoahoc" class="form-select"><option value="">-- Công khai --</option><?php mysqli_data_seek($courses_for_edit_modal, 0); while ($course = $courses_for_edit_modal->fetch_assoc()): ?><option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endwhile; ?></select></div>
                    <div class="mb-3" id="edit_class_wrapper" style="display:none;"><label class="form-label">Gán cho Lớp học (Tùy chọn)</label><select name="id_lop" class="form-select" id="edit_id_lop"><option value="">-- Toàn khóa học --</option></select></div>
                    <div class="mb-3"><label class="form-label">Thời Gian (phút) <span class="text-danger">*</span></label><input type="number" name="thoi_gian" id="edit_thoi_gian" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>
</div>

<script>
/**
 * Hàm tải danh sách lớp học dựa trên courseId và điền vào select box
 * @param {string} courseId - ID của khóa học
 * @param {HTMLSelectElement} classSelect - Element select của lớp học
 * @param {HTMLElement} classWrapper - Element wrapper của select lớp học
 * @param {string|null} selectedLopId - ID lớp học cần chọn sẵn (nếu có)
 */
async function loadClasses(courseId, classSelect, classWrapper, selectedLopId = null) {
    if (courseId) {
        classWrapper.style.display = 'block';
        classSelect.innerHTML = '<option>Đang tải...</option>';
        try {
            const response = await fetch(`./modules/cauhoi/get_classes_by_course.php?course_id=${courseId}`);
            const classes = await response.json();
            classSelect.innerHTML = '<option value="">-- Áp dụng cho toàn khóa học --</option>';
            classes.forEach(cls => {
                const option = new Option(cls.ten_lop, cls.id_lop);
                if (selectedLopId && cls.id_lop == selectedLopId) {
                    option.selected = true;
                }
                classSelect.add(option);
            });
        } catch (error) {
            classSelect.innerHTML = '<option value="">-- Lỗi tải lớp học --</option>';
            console.error('Fetch error:', error);
        }
    } else {
        classWrapper.style.display = 'none';
        classSelect.innerHTML = '<option value="">-- Áp dụng cho toàn khóa học --</option>';
    }
}

async function openEditModal(testId) {
    try {
        const response = await fetch(`./modules/cauhoi/get_test_info.php?id=${testId}`);
        const data = await response.json();
        if (data.error) {
            Swal.fire('Lỗi!', data.error, 'error');
            return;
        }
        
        // Điền dữ liệu vào form
        document.getElementById('edit_id_baitest').value = data.id_baitest;
        document.getElementById('edit_ten_baitest').value = data.ten_baitest;
        document.getElementById('edit_loai_baitest').value = data.loai_baitest;
        document.getElementById('edit_id_khoahoc').value = data.id_khoahoc || "";
        document.getElementById('edit_thoi_gian').value = data.thoi_gian;
        
        // Tải danh sách lớp tương ứng
        const editCourseSelect = document.getElementById('edit_id_khoahoc');
        const editClassSelect = document.getElementById('edit_id_lop');
        const editClassWrapper = document.getElementById('edit_class_wrapper');
        await loadClasses(data.id_khoahoc, editClassSelect, editClassWrapper, data.id_lop);
        
        const editModal = new bootstrap.Modal(document.getElementById('editTestModal'));
        editModal.show();
    } catch (error) {
        Swal.fire('Lỗi!', 'Không thể lấy dữ liệu bài test.', 'error');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Logic cho modal Thêm mới
    const addCourseSelect = document.getElementById('add_id_khoahoc');
    const addClassWrapper = document.getElementById('add_class_wrapper');
    const addClassSelect = document.getElementById('add_id_lop');
    addCourseSelect.addEventListener('change', () => loadClasses(addCourseSelect.value, addClassSelect, addClassWrapper));

    // Logic cho modal Sửa
    const editCourseSelect = document.getElementById('edit_id_khoahoc');
    const editClassWrapper = document.getElementById('edit_class_wrapper');
    const editClassSelect = document.getElementById('edit_id_lop');
    editCourseSelect.addEventListener('change', () => loadClasses(editCourseSelect.value, editClassSelect, editClassWrapper));
});
</script>