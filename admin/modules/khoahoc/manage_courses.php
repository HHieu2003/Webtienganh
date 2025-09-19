<?php
// Lấy danh sách giảng viên để dùng trong cả 2 modal
$sql_giangvien = "SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien ASC";
$result_giangvien = $conn->query($sql_giangvien);

// Xử lý tìm kiếm
$search_term = $_POST['search'] ?? '';
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    $sql_search = " WHERE kh.ten_khoahoc LIKE ? OR gv.ten_giangvien LIKE ?";
    $search_param = "%" . $search_term . "%";
    $params = [$search_param, $search_param];
    $types = "ss";
}

$sql = "
    SELECT kh.id_khoahoc, kh.ten_khoahoc, kh.thoi_gian, kh.chi_phi, gv.ten_giangvien 
    FROM khoahoc kh
    LEFT JOIN giangvien gv ON kh.id_giangvien = gv.id_giangvien
" . $sql_search . " ORDER BY kh.id_khoahoc DESC";

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
            <h4 class="mb-0"><i class="fa-solid fa-book-open me-2"></i>Quản lý Khóa học</h4>
            <div class="d-flex">
                <form method="POST" action="./admin.php?nav=courses" class="d-flex me-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm tên khóa học, giảng viên..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <button data-bs-toggle="modal" data-bs-target="#addCourseModal" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm Khóa học</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th style="width: 40%;">Tên Khóa học</th>
                        <th>Giảng viên</th>
                        <th class="text-center">Thời gian (buổi)</th>
                        <th>Học phí (VNĐ)</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr id="course-row-<?php echo $row['id_khoahoc']; ?>" class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                            <td><?php echo $row['id_khoahoc']; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten_giangvien'] ?? 'Chưa có'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['thoi_gian']); ?></td>
                            <td><?php echo number_format($row['chi_phi'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <button onclick="openEditModal(<?php echo $row['id_khoahoc']; ?>)" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                                </button>
                                <button onclick="deleteCourse(<?php echo $row['id_khoahoc']; ?>)" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php 
                        $index++;
                    endwhile; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-plus-circle me-2"></i>Thêm Khóa Học Mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addCourseForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="ten_khoahoc" class="form-control" placeholder="Tên Khóa Học" required>
                        <label>Tên Khóa Học *</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="mo_ta" id="add_mo_ta" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><select name="id_giangvien" class="form-select"><option value="">-- Chọn giảng viên --</option><?php mysqli_data_seek($result_giangvien, 0); while($gv = $result_giangvien->fetch_assoc()){ echo "<option value='{$gv['id_giangvien']}'>".htmlspecialchars($gv['ten_giangvien'])."</option>"; } ?></select><label>Giảng Viên</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="number" name="thoi_gian" class="form-control" placeholder="Thời Gian"><label>Thời Gian (số buổi)</label></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="number" name="chi_phi" class="form-control" placeholder="Học phí" required><label>Học phí (VNĐ) *</label></div></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Hình Ảnh</label><input type="file" name="hinh_anh" class="form-control" accept="image/*"></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm Khóa học</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Chỉnh Sửa Khóa Học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="editCourseForm" enctype="multipart/form-data">
                <input type="hidden" name="id_khoahoc" id="edit_id_khoahoc">
                <input type="hidden" name="hinh_anh_hien_tai" id="edit_hinh_anh_hien_tai">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="ten_khoahoc" id="edit_ten_khoahoc" class="form-control" placeholder="Tên Khóa Học" required>
                        <label>Tên Khóa Học *</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="mo_ta" id="edit_mo_ta" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><select name="id_giangvien" id="edit_id_giangvien" class="form-select"><option value="">-- Chọn giảng viên --</option><?php mysqli_data_seek($result_giangvien, 0); while($gv = $result_giangvien->fetch_assoc()){ echo "<option value='{$gv['id_giangvien']}'>".htmlspecialchars($gv['ten_giangvien'])."</option>"; } ?></select><label>Giảng Viên</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="number" name="thoi_gian" id="edit_thoi_gian" class="form-control" placeholder="Thời Gian"><label>Thời Gian (số buổi)</label></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="number" name="chi_phi" id="edit_chi_phi" class="form-control" placeholder="Học phí" required><label>Học phí (VNĐ) *</label></div></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Tải ảnh mới (để trống nếu không đổi)</label><input type="file" name="hinh_anh" class="form-control" accept="image/*"></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>
</div>

<script>
let addCourseModal, editCourseModal;
let addEditor, editEditor;

// Hàm mở modal Sửa
async function openEditModal(courseId) {
    try {
        const response = await fetch(`./modules/khoahoc/get_course_info.php?id=${courseId}`);
        const data = await response.json();
        if (data.error) {
            Swal.fire('Lỗi!', data.error, 'error');
            return;
        }
        document.getElementById('edit_id_khoahoc').value = data.id_khoahoc;
        document.getElementById('edit_ten_khoahoc').value = data.ten_khoahoc;
        document.getElementById('edit_id_giangvien').value = data.id_giangvien || "";
        document.getElementById('edit_thoi_gian').value = data.thoi_gian;
        document.getElementById('edit_chi_phi').value = data.chi_phi;
        document.getElementById('edit_hinh_anh_hien_tai').value = data.hinh_anh;
        
        // Cập nhật nội dung cho CKEditor
        if (editEditor) {
            editEditor.setData(data.mo_ta || '');
        }
        
        editCourseModal.show();
    } catch (error) {
        Swal.fire('Lỗi!', 'Không thể lấy dữ liệu khóa học.', 'error');
    }
}

// Hàm mở modal Xóa (sử dụng SweetAlert)
function deleteCourse(courseId) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Xóa khóa học này sẽ xóa tất cả dữ liệu liên quan (lớp học, đăng ký,...) và không thể khôi phục!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Chắc chắn xóa!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/khoahoc/delete_course.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `delete_id=${courseId}`
            })
            .then(response => response.text())
            .then(res => {
                if (res.trim() === "Xóa thành công") {
                    Swal.fire('Đã xóa!', 'Khóa học đã được xóa thành công.', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Lỗi!', 'Không thể xóa khóa học. ' + res, 'error');
                }
            });
        }
    })
}

document.addEventListener("DOMContentLoaded", function() {
    // Khởi tạo Modal
    addCourseModal = new bootstrap.Modal(document.getElementById('addCourseModal'));
    editCourseModal = new bootstrap.Modal(document.getElementById('editCourseModal'));

    // Khởi tạo CKEditor
    CKEDITOR.replace('add_mo_ta');
    CKEDITOR.replace('edit_mo_ta');
    addEditor = CKEDITOR.instances.add_mo_ta;
    editEditor = CKEDITOR.instances.edit_mo_ta;

    // Xử lý submit form THÊM
    document.getElementById('addCourseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Cập nhật giá trị từ CKEditor vào textarea trước khi gửi
        addEditor.updateElement();
        const formData = new FormData(this);
        
        fetch('./modules/khoahoc/add_course.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                addCourseModal.hide();
                Swal.fire({ icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else { Swal.fire('Lỗi!', data.message, 'error'); }
        });
    });

    // Xử lý submit form SỬA
    document.getElementById('editCourseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Cập nhật giá trị từ CKEditor
        editEditor.updateElement();
        const formData = new FormData(this);

        fetch('./modules/khoahoc/edit_course.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                editCourseModal.hide();
                Swal.fire({ icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else { Swal.fire('Lỗi!', data.message, 'error'); }
        });
    });
});
</script>