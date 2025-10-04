<?php
// File: admin/modules/teacher_materials.php
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];
$selected_lop_id = $_GET['lop_id'] ?? null;

// Lấy danh sách các lớp học của giảng viên (giữ nguyên)
$sql_classes = "SELECT id_lop, ten_lop FROM lop_hoc WHERE id_giangvien = ? ORDER BY ten_lop";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

$materials = [];
$is_owner = false; // Biến kiểm tra quyền sở hữu

if ($selected_lop_id) {
    // === BẢO MẬT: KIỂM TRA LỚP HỌC CÓ THUỘC GIẢNG VIÊN KHÔNG ===
    $stmt_check_owner = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
    $stmt_check_owner->bind_param("si", $selected_lop_id, $id_giangvien);
    $stmt_check_owner->execute();
    if ($stmt_check_owner->get_result()->num_rows > 0) {
        $is_owner = true;
    }
    $stmt_check_owner->close();
    
    // Chỉ lấy học liệu nếu giảng viên là chủ sở hữu lớp
    if ($is_owner) {
        $sql_materials = "SELECT id_hoclieu, tieu_de, loai_file, duong_dan_file, ngay_dang FROM hoc_lieu WHERE id_lop = ? ORDER BY ngay_dang DESC";
        $stmt_materials = $conn->prepare($sql_materials);
        $stmt_materials->bind_param("s", $selected_lop_id);
        $stmt_materials->execute();
        $materials = $stmt_materials->get_result();
    }
}
?>

<div class="card animated-card">
    <div class="card-header"><h4 class="mb-0"><i class="fa-solid fa-file-lines me-2"></i>Quản lý Học liệu</h4></div>
    <div class="card-body">
        <?php if (isset($_SESSION['message'])) { echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'; unset($_SESSION['message']); } ?>
        <div class="row">
            <div class="col-md-4 border-end">
                <h5>Chọn lớp học của bạn</h5>
                <div class="list-group">
                    <?php while($class = $result_classes->fetch_assoc()): ?>
                        <a href="./admin.php?nav=teacher_materials&lop_id=<?php echo $class['id_lop']; ?>" class="list-group-item list-group-item-action <?php echo ($selected_lop_id == $class['id_lop']) ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($class['ten_lop']); ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-md-8">
                <?php if ($selected_lop_id): ?>
                    <?php if ($is_owner): // Chỉ hiển thị nội dung nếu có quyền ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Học liệu của lớp</h5>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMaterialModal"><i class="fa-solid fa-plus"></i> Thêm học liệu</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light"><tr><th>Tiêu đề</th><th class="text-center">Loại file</th><th class="text-center">Ngày đăng</th><th class="text-center">Hành động</th></tr></thead>
                                <tbody>
                                    <?php if ($materials->num_rows > 0): while($material = $materials->fetch_assoc()): ?>
                                    <tr id="material-row-<?php echo $material['id_hoclieu']; ?>">
                                        <td><?php echo htmlspecialchars($material['tieu_de']); ?></td>
                                        <td class="text-center"><span class="badge bg-secondary"><?php echo htmlspecialchars($material['loai_file']); ?></span></td>
                                        <td class="text-center"><?php echo date("d/m/Y", strtotime($material['ngay_dang'])); ?></td>
                                        <td class="text-center">
                                            <a href="../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-info btn-sm text-white" title="Tải xuống" download><i class="fa-solid fa-download"></i></a>
                                            
                                            <button onclick="deleteMaterial(<?php echo $material['id_hoclieu']; ?>)" class="btn btn-danger btn-sm" title="Xóa">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            </td>
                                    </tr>
                                    <?php endwhile; else: ?>
                                    <tr><td colspan="4" class="text-center text-muted py-4">Lớp này chưa có học liệu nào.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: // Nếu không có quyền, hiển thị thông báo lỗi ?>
                        <div class="alert alert-danger text-center h-100 d-flex align-items-center justify-content-center">
                            <p class="mb-0">Bạn không có quyền truy cập vào học liệu của lớp này.</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center h-100 d-flex align-items-center justify-content-center">
                        <p class="mb-0"><i class="fa-solid fa-arrow-left me-2"></i> Vui lòng chọn một lớp học từ danh sách bên trái.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($selected_lop_id && $is_owner): ?>
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Thêm Học liệu mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="modules/teacher/add_material.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_lop" value="<?php echo $selected_lop_id; ?>">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tiêu đề <span class="text-danger">*</span></label><input type="text" class="form-control" name="tieu_de" required></div>
                    <div class="mb-3"><label class="form-label">Tệp học liệu <span class="text-danger">*</span></label><input type="file" class="form-control" name="hoc_lieu_file" required><div class="form-text">Hỗ trợ: PDF, DOC, DOCX, PNG, JPG, MP4...</div></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Tải lên</button></div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function deleteMaterial(materialId) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Bạn sẽ xóa vĩnh viễn học liệu này!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Chắc chắn xóa!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Sửa đường dẫn fetch để trỏ đến tệp chung của admin
            fetch('./modules/hoclieu/delete_hoclieu.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_hoclieu: materialId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Đã xóa!', data.message, 'success');
                    // Xóa hàng khỏi bảng trên giao diện
                    const row = document.getElementById(`material-row-${materialId}`);
                    if (row) {
                        row.remove();
                    }
                } else {
                    Swal.fire('Lỗi!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
            });
        }
    });
}
</script>