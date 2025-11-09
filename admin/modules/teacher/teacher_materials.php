<?php
// File: admin/modules/teacher/teacher_materials.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];
$selected_lop_id = $_GET['lop_id'] ?? 'all'; // Mặc định hiển thị tất cả

// Lấy danh sách các lớp học của giảng viên để tạo bộ lọc
$sql_classes = "SELECT id_lop, ten_lop FROM lop_hoc WHERE id_giangvien = ? AND trang_thai = 'dang hoc' ORDER BY ten_lop";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();
$classes_list = $result_classes->fetch_all(MYSQLI_ASSOC);
$stmt_classes->close();

$materials = null;
$is_owner = false;
$selected_class_name = '';
$show_all = ($selected_lop_id === 'all' || $selected_lop_id === '');

if ($show_all) {
    // Hiển thị tất cả học liệu của tất cả lớp học của giảng viên
    $sql_materials = "SELECT hl.id_hoclieu, hl.tieu_de, hl.loai_file, hl.duong_dan_file, hl.ngay_dang, lh.ten_lop 
                      FROM hoc_lieu hl
                      INNER JOIN lop_hoc lh ON hl.id_lop = lh.id_lop
                      WHERE lh.id_giangvien = ? 
                      ORDER BY hl.ngay_dang DESC";
    $stmt_materials = $conn->prepare($sql_materials);
    $stmt_materials->bind_param("i", $id_giangvien);
    $stmt_materials->execute();
    $materials = $stmt_materials->get_result();
    $stmt_materials->close();
} elseif ($selected_lop_id) {
    // Bảo mật: Kiểm tra lớp học có thuộc giảng viên không
    $stmt_check_owner = $conn->prepare("SELECT ten_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
    $stmt_check_owner->bind_param("si", $selected_lop_id, $id_giangvien);
    $stmt_check_owner->execute();
    $result_owner = $stmt_check_owner->get_result();
    if ($class_info = $result_owner->fetch_assoc()) {
        $is_owner = true;
        $selected_class_name = $class_info['ten_lop'];
    }
    $stmt_check_owner->close();

    if ($is_owner) {
        $sql_materials = "SELECT id_hoclieu, tieu_de, loai_file, duong_dan_file, ngay_dang FROM hoc_lieu WHERE id_lop = ? ORDER BY ngay_dang DESC";
        $stmt_materials = $conn->prepare($sql_materials);
        $stmt_materials->bind_param("s", $selected_lop_id);
        $stmt_materials->execute();
        $materials = $stmt_materials->get_result();
        $stmt_materials->close();
    }
}

// Hàm trợ giúp để lấy icon và màu sắc dựa trên loại file
function get_file_type_details($file_type)
{
    $file_type = strtolower($file_type ?? '');
    switch ($file_type) {
        case 'pdf':
            return ['icon' => 'fa-file-pdf', 'color' => '#E53E3E'];
        case 'doc':
        case 'docx':
            return ['icon' => 'fa-file-word', 'color' => '#3B82F6'];
        case 'xls':
        case 'xlsx':
            return ['icon' => 'fa-file-excel', 'color' => '#10B981'];
        case 'ppt':
        case 'pptx':
            return ['icon' => 'fa-file-powerpoint', 'color' => '#D69E2E'];
        case 'mp4':
        case 'mov':
        case 'avi':
            return ['icon' => 'fa-file-video', 'color' => '#8B5CF6'];
        case 'jpg':
        case 'png':
        case 'jpeg':
        case 'gif':
            return ['icon' => 'fa-file-image', 'color' => '#4299E1'];
        default:
            return ['icon' => 'fa-file-alt', 'color' => '#718096'];
    }
}
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .filter-card {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .material-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .material-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
        border-color: var(--brand-color);
    }

    .file-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
        position: relative;
    }

    .file-icon-bg {
        font-size: 5rem;
        opacity: 0.1;
        position: absolute;
    }

    .file-icon-main {
        font-size: 3rem;
        color: #fff;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .material-details {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        text-align: center;
        border-top: 1px solid var(--border-color);
    }

    .material-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 44px;
        /* 2 lines height */
    }

    .material-date {
        font-size: 0.85rem;
        color: var(--gray-text);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .material-actions {
        margin-top: auto;
        display: flex;
        gap: 0.75rem;
    }

    .btn-material {
        flex-grow: 1;
        font-weight: 500;
    }
</style>

<div class="container-fluid">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']['text']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <div class="page-header animated-item">
        <h1 class="title-color mb-0" style="border:none; padding-bottom: 0;">Quản lý Học liệu</h1>
        <?php if ($selected_lop_id && !$show_all && $is_owner): ?>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                <i class="fa-solid fa-plus me-2"></i> Thêm học liệu
            </button>
        <?php endif; ?>
    </div>

    <div class="filter-card animated-item" style="animation-delay: 100ms;">
        <form method="GET" action="./admin.php" class="mb-0">
            <input type="hidden" name="nav" value="teacher_materials">
            <div class="row g-3 align-items-center">
                <label for="class-filter" class="col-lg-3 col-form-label fw-bold">Chọn lớp học để quản lý:</label>
                <div class="col-lg-9">
                    <select name="lop_id" id="class-filter" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?php echo $show_all ? 'selected' : ''; ?>>🌐 Xem toàn bộ học liệu</option>
                        <?php foreach ($classes_list as $class): ?>
                            <option value="<?php echo $class['id_lop']; ?>" <?php echo ($selected_lop_id == $class['id_lop']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['ten_lop']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <?php if ($show_all): ?>
        <!-- Hiển thị toàn bộ học liệu -->
        <?php if ($materials && $materials->num_rows > 0): ?>
            <div class="row g-4">
                <?php
                $index = 0;
                while ($material = $materials->fetch_assoc()):
                    $file_details = get_file_type_details($material['loai_file']);
                ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 animated-item" style="animation-delay: <?php echo $index++ * 70; ?>ms;" id="material-card-<?php echo $material['id_hoclieu']; ?>">
                        <div class="material-card">
                            <div class="file-icon-wrapper" style="background-color: <?php echo $file_details['color']; ?>1A;">
                                <i class="file-icon-bg fa-solid <?php echo $file_details['icon']; ?>" style="color: <?php echo $file_details['color']; ?>;"></i>
                                <div class="file-icon-main" style="background-color: <?php echo $file_details['color']; ?>;">
                                    <i class="fa-solid <?php echo $file_details['icon']; ?>"></i>
                                </div>
                            </div>
                            <div class="material-details">
                                <h5 class="material-title"><?php echo htmlspecialchars($material['tieu_de']); ?></h5>
                                <p class="material-date">
                                    <i class="fa-solid fa-school me-1"></i><?php echo htmlspecialchars($material['ten_lop']); ?><br>
                                    <i class="fa-solid fa-calendar me-1"></i>Ngày đăng: <?php echo date("d/m/Y", strtotime($material['ngay_dang'])); ?>
                                </p>
                                <div class="material-actions">
                                    <a href="../../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-sm btn-primary btn-material" download target="_blank">
                                        <i class="fa-solid fa-download me-2"></i>Tải về
                                    </a>
                                    <button onclick="deleteMaterial(<?php echo $material['id_hoclieu']; ?>)" class="btn btn-sm btn-outline-danger btn-material" title="Xóa">
                                        <i class="fa-solid fa-trash me-2"></i>Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light text-center mt-4 animated-item">
                <i class="fa-solid fa-folder-open fa-3x mb-3 text-muted"></i>
                <p class="mb-0">Bạn chưa có học liệu nào. <br>Hãy chọn một lớp học và bắt đầu thêm học liệu!</p>
            </div>
        <?php endif; ?>
    <?php elseif ($selected_lop_id): ?>
        <?php if ($is_owner): ?>
            <?php if ($materials->num_rows > 0): ?>
                <div class="row g-4">
                    <?php
                    $index = 0;
                    while ($material = $materials->fetch_assoc()):
                        $file_details = get_file_type_details($material['loai_file']);
                    ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 animated-item" style="animation-delay: <?php echo $index++ * 70; ?>ms;" id="material-card-<?php echo $material['id_hoclieu']; ?>">
                            <div class="material-card">
                                <div class="file-icon-wrapper" style="background-color: <?php echo $file_details['color']; ?>1A;">
                                    <i class="file-icon-bg fa-solid <?php echo $file_details['icon']; ?>" style="color: <?php echo $file_details['color']; ?>;"></i>
                                    <div class="file-icon-main" style="background-color: <?php echo $file_details['color']; ?>;">
                                        <i class="fa-solid <?php echo $file_details['icon']; ?>"></i>
                                    </div>
                                </div>
                                <div class="material-details">
                                    <h5 class="material-title"><?php echo htmlspecialchars($material['tieu_de']); ?></h5>
                                    <p class="material-date">Ngày đăng: <?php echo date("d/m/Y", strtotime($material['ngay_dang'])); ?></p>
                                    <div class="material-actions">
                                        <a href="../../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-sm btn-primary btn-material" download target="_blank">
                                            <i class="fa-solid fa-download me-2"></i>Tải về
                                        </a>
                                        <button onclick="deleteMaterial(<?php echo $material['id_hoclieu']; ?>)" class="btn btn-sm btn-outline-danger btn-material" title="Xóa">
                                            <i class="fa-solid fa-trash me-2"></i>Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-light text-center mt-4 animated-item">
                    <i class="fa-solid fa-folder-open fa-3x mb-3 text-muted"></i>
                    <p class="mb-0">Lớp học <strong class="text-success"><?php echo htmlspecialchars($selected_class_name); ?></strong> chưa có học liệu nào. <br>Hãy bắt đầu bằng cách thêm học liệu mới!</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-danger text-center mt-4 animated-item">Bạn không có quyền truy cập học liệu của lớp này.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php if ($selected_lop_id && $is_owner): ?>
    <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Học liệu cho lớp <?php echo htmlspecialchars($selected_class_name); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="modules/teacher/add_material.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_lop" value="<?php echo $selected_lop_id; ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tieu_de" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tệp học liệu <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="hoc_lieu_file" required>
                            <div class="form-text">Hỗ trợ nhiều định dạng: PDF, DOCX, PNG, JPG, MP4...</div>
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
                fetch('./modules/hoclieu/delete_hoclieu.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_hoclieu: materialId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Đã xóa!', data.message, 'success');
                            const card = document.getElementById(`material-card-${materialId}`);
                            if (card) card.remove();
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error'));
            }
        });
    }
</script>