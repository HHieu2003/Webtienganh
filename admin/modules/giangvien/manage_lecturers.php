<?php
// PHP logic để lấy dữ liệu (giữ nguyên như cũ)
$search_term = $_POST['search'] ?? $_GET['search'] ?? '';
$sql_search = "";
if (!empty($search_term)) {
    $search_param = "%" . $conn->real_escape_string($search_term) . "%";
    $sql_search = " WHERE ten_giangvien LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?";
}
$sql = "SELECT * FROM giangvien" . $sql_search . " ORDER BY id_giangvien DESC";
$stmt = $conn->prepare($sql);
if (!empty($search_term)) {
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .description-cell { max-width: 350px; }
    .description-truncate { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }
    .actions-cell { white-space: nowrap; min-width: 180px; }
</style>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-chalkboard-user me-2"></i>Quản lý Giảng viên</h4>
            <div class="d-flex">
                <form method="POST" action="./admin.php?nav=lecturers" class="d-flex me-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm giảng viên..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <a href="modules/giangvien/export_lecturers.php" class="btn btn-info text-white me-2">
                    <i class="fa-solid fa-file-excel"></i> Xuất Excel
                </a>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLecturerModal"><i class="fa-solid fa-plus"></i> Thêm Giảng viên</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>ID</th><th  class="text-center">Hình ảnh</th><th>Tên giảng viên</th><th>Email</th><th>Số điện thoại</th><th>Mô tả</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr id="lecturer-row-<?php echo $row['id_giangvien']; ?>" class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                            <td><?php echo $row['id_giangvien']; ?></td>
                            <td><img src="../<?php echo !empty($row['hinh_anh']) ? htmlspecialchars($row['hinh_anh']) : 'images/default-avatar.png'; ?>" alt="avatar" class="rounded-circle" width="50" height="50" style="object-fit: cover;"></td>
                            <td><?php echo htmlspecialchars($row['ten_giangvien']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                            
                            <td class="description-cell" title="<?php echo htmlspecialchars($row['mo_ta']); ?>">
                                <div class="description-truncate">
                                    <?php echo htmlspecialchars($row['mo_ta']); ?>
                                </div>
                            </td>

                            <td class="text-center actions-cell">
                                <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $row['id_giangvien']; ?>)"><i class="fa-solid fa-pen-to-square"></i> Sửa</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteLecturer(<?php echo $row['id_giangvien']; ?>)"><i class="fa-solid fa-trash"></i> Xóa</button>
                            </td>
                        </tr>
                    <?php $index++; endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addLecturerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-user-plus me-2"></i>Thêm Giảng viên mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addLecturerForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="text" class="form-control" name="ten_giangvien" placeholder="Tên giảng viên" required><label>Tên giảng viên *</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="email" class="form-control" name="email" placeholder="Email" required><label>Email *</label></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="tel" class="form-control" name="so_dien_thoai" placeholder="Số điện thoại"><label>Số điện thoại</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="password" class="form-control" name="mat_khau" placeholder="Mật khẩu" required><label>Mật khẩu *</label></div></div>
                    </div>
                    <div class="mb-3"><div class="form-floating"><textarea class="form-control" name="mo_ta" placeholder="Mô tả" style="height: 100px"></textarea><label>Mô tả chuyên môn</label></div></div>
                    <div class="mb-3"><label class="form-label">Hình ảnh đại diện</label><input type="file" class="form-control" name="hinh_anh" accept="image/*"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editLecturerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-user-pen me-2"></i>Chỉnh sửa thông tin Giảng viên</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="editLecturerForm" enctype="multipart/form-data">
                <input type="hidden" id="editLecturerId" name="id_giangvien">
                <input type="hidden" id="editCurrentImage" name="hinh_anh_hien_tai">
                <div class="modal-body">
                     <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="text" id="editTenGiangVien" class="form-control" name="ten_giangvien" placeholder="Tên giảng viên" required><label>Tên giảng viên *</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="email" id="editEmail" class="form-control" name="email" placeholder="Email" required><label>Email *</label></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="tel" id="editSoDienThoai" class="form-control" name="so_dien_thoai" placeholder="Số điện thoại"><label>Số điện thoại</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="password" class="form-control" name="mat_khau" placeholder="Mật khẩu mới"><label>Mật khẩu mới (để trống nếu không đổi)</label></div></div>
                    </div>
                    <div class="mb-3"><div class="form-floating"><textarea id="editMoTa" class="form-control" name="mo_ta" placeholder="Mô tả" style="height: 100px"></textarea><label>Mô tả chuyên môn</label></div></div>
                    <div class="mb-3"><label class="form-label">Tải ảnh đại diện mới</label><input type="file" class="form-control" name="hinh_anh" accept="image/*"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteLecturerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white"><h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i> Xác nhận xóa</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa giảng viên này? Hành động này không thể khôi phục. Các khóa học và lớp học do giảng viên này phụ trách sẽ được cập nhật thành "Chưa phân công".
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteLecturerBtn">Xác nhận xóa</button>
      </div>
    </div>
  </div>
</div>

<script>
let addLecturerModal, editLecturerModal, confirmDeleteLecturerModal;
let lecturerIdToDelete = null;

// Hàm mở modal Sửa
async function openEditModal(lecturerId) {
    try {
        const response = await fetch(`./modules/giangvien/get_lecturer_info.php?id=${lecturerId}`);
        const data = await response.json();
        if (data.error) {
            Swal.fire('Lỗi!', data.error, 'error');
            return;
        }
        document.getElementById('editLecturerId').value = data.id_giangvien;
        document.getElementById('editTenGiangVien').value = data.ten_giangvien;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editSoDienThoai').value = data.so_dien_thoai;
        document.getElementById('editMoTa').value = data.mo_ta;
        document.getElementById('editCurrentImage').value = data.hinh_anh;
        editLecturerModal.show();
    } catch (error) {
        Swal.fire('Lỗi!', 'Không thể lấy dữ liệu giảng viên.', 'error');
    }
}

// Hàm mở modal Xóa
function deleteLecturer(lecturerId) {
    lecturerIdToDelete = lecturerId;
    confirmDeleteLecturerModal.show();
}

document.addEventListener("DOMContentLoaded", function() {
    addLecturerModal = new bootstrap.Modal(document.getElementById('addLecturerModal'));
    editLecturerModal = new bootstrap.Modal(document.getElementById('editLecturerModal'));
    confirmDeleteLecturerModal = new bootstrap.Modal(document.getElementById('confirmDeleteLecturerModal'));

    // Xử lý submit form THÊM
    document.getElementById('addLecturerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('./modules/giangvien/add_lecturer.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                addLecturerModal.hide();
                Swal.fire({ icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else {
                Swal.fire('Lỗi!', data.message, 'error');
            }
        });
    });

    // Xử lý submit form SỬA
    document.getElementById('editLecturerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('./modules/giangvien/edit_lecturer.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                editLecturerModal.hide();
                Swal.fire({ icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else {
                Swal.fire('Lỗi!', data.message, 'error');
            }
        });
    });

    // Xử lý nút xác nhận XÓA
    document.getElementById('confirmDeleteLecturerBtn').addEventListener('click', function() {
        if (lecturerIdToDelete) {
            this.disabled = true;
            this.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Đang xóa...`;
            
            fetch(`./modules/giangvien/delete_lecturer.php`, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `delete_id=${lecturerIdToDelete}`
            })
            .then(response => response.json())
            .then(data => {
                confirmDeleteLecturerModal.hide();
                if (data.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Đã xóa!', text: data.message, timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
                } else {
                    Swal.fire('Lỗi!', data.message, 'error');
                }
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = 'Xác nhận xóa';
                lecturerIdToDelete = null;
            });
        }
    });
});
</script>