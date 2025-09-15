<?php
// Giả định $conn và session đã có từ file admin.php
$id_giangvien = $_SESSION['id_giangvien'];
$selected_lop_id = $_GET['lop_id'] ?? null;

// Lấy danh sách các lớp học của giảng viên
$sql_classes = "SELECT id_lop, ten_lop FROM lop_hoc WHERE id_giangvien = ? ORDER BY ten_lop";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

// Lấy danh sách học liệu nếu một lớp đã được chọn
$materials = [];
if ($selected_lop_id) {
    $sql_materials = "SELECT id_hoclieu, tieu_de, loai_file, duong_dan_file, ngay_dang FROM hoc_lieu WHERE id_lop = ? ORDER BY ngay_dang DESC";
    $stmt_materials = $conn->prepare($sql_materials);
    $stmt_materials->bind_param("s", $selected_lop_id);
    $stmt_materials->execute();
    $materials = $stmt_materials->get_result();
}
?>

<div class="card animated-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fa-solid fa-file-lines me-2"></i>Quản lý Học liệu</h4>
    </div>
    <div class="card-body">
        <?php
        // Hiển thị thông báo (nếu có)
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show" role="alert">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            unset($_SESSION['message']);
        }
        ?>
        <div class="row">
            <div class="col-md-4 border-end">
                <h5>Chọn lớp học</h5>
                <div class="list-group">
                    <?php while($class = $result_classes->fetch_assoc()): ?>
                        <a href="./admin.php?nav=teacher_materials&lop_id=<?php echo $class['id_lop']; ?>" 
                           class="list-group-item list-group-item-action <?php echo ($selected_lop_id == $class['id_lop']) ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($class['ten_lop']); ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="col-md-8">
                <?php if ($selected_lop_id): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Học liệu của lớp</h5>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                            <i class="fa-solid fa-plus"></i> Thêm học liệu mới
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr><th>Tiêu đề</th><th class="text-center">Loại file</th><th class="text-center">Ngày đăng</th><th class="text-center">Hành động</th></tr>
                            </thead>
                            <tbody>
                                <?php if ($materials->num_rows > 0):
                                    while($material = $materials->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($material['tieu_de']); ?></td>
                                        <td class="text-center"><span class="badge bg-secondary"><?php echo htmlspecialchars($material['loai_file']); ?></span></td>
                                        <td class="text-center"><?php echo date("d/m/Y", strtotime($material['ngay_dang'])); ?></td>
                                        <td class="text-center">
                                            <a href="../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-info btn-sm text-white" title="Tải xuống" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            <a href="modules/delete_material.php?id=<?php echo $material['id_hoclieu']; ?>&lop_id=<?php echo $selected_lop_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa tài liệu này?');" title="Xóa">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; else: ?>
                                    <tr><td colspan="4" class="text-center text-muted py-4">Lớp này chưa có học liệu nào.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center d-flex align-items-center justify-content-center h-100">
                        <p class="mb-0"><i class="fa-solid fa-arrow-left me-2"></i> Vui lòng chọn một lớp học từ danh sách bên trái.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($selected_lop_id): ?>
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Học liệu mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/add_material.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_lop" value="<?php echo $selected_lop_id; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tieu_de" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tệp học liệu <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="hoc_lieu_file" required>
                        <div class="form-text">Hỗ trợ: PDF, DOC, DOCX, PNG, JPG, MP4...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>