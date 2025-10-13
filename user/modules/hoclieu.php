<?php
// user/modules/hoclieu.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ.");
}

$id_hocvien = $_SESSION['id_hocvien'];
$selected_lop_id = $_GET['lop_id'] ?? null;

// Lấy danh sách lớp học của học viên
$sql_classes = "
    SELECT lh.id_lop, lh.ten_lop, kh.ten_khoahoc 
    FROM dangkykhoahoc dk
    JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan' AND dk.id_lop IS NOT NULL
    ORDER BY kh.ten_khoahoc, lh.ten_lop
";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id_hocvien);
$stmt_classes->execute();
$result_classes = $stmt_classes->get_result();

// Lấy danh sách học liệu nếu một lớp đã được chọn
$materials = [];
if ($selected_lop_id) {
    // Lấy cả học liệu của lớp và học liệu chung của khóa học đó
    $sql_materials = "
        SELECT id_hoclieu, tieu_de, loai_file, duong_dan_file, ngay_dang, id_lop
        FROM hoc_lieu 
        WHERE id_lop = ? 
        OR (id_khoahoc = (SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?) AND id_lop IS NULL)
        ORDER BY ngay_dang DESC
    ";
    $stmt_materials = $conn->prepare($sql_materials);
    $stmt_materials->bind_param("ss", $selected_lop_id, $selected_lop_id);
    $stmt_materials->execute();
    $result = $stmt_materials->get_result();
    while ($row = $result->fetch_assoc()) {
        $materials[] = $row;
    }
}

// Hàm để lấy icon và màu sắc dựa trên loại file
function get_file_type_details($file_type) {
    $file_type = strtolower($file_type);
    switch ($file_type) {
        case 'pdf':
            return ['icon' => 'fa-file-pdf', 'color' => '#E53E3E'];
        case 'doc':
        case 'docx':
            return ['icon' => 'fa-file-word', 'color' => '#3B82F6'];
        case 'mp4':
        case 'mov':
        case 'avi':
            return ['icon' => 'fa-file-video', 'color' => '#8B5CF6'];
        case 'jpg':
        case 'png':
        case 'jpeg':
        case 'gif':
            return ['icon' => 'fa-file-image', 'color' => '#10B981'];
        default:
            return ['icon' => 'fa-file-alt', 'color' => '#6B7280'];
    }
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .material-card {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid var(--border-color);
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .material-card-header {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .file-icon {
        font-size: 28px;
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .material-info h5 {
        font-size: 17px;
        font-weight: 600;
        margin: 0 0 5px 0;
    }
    .material-info p {
        font-size: 14px;
        color: var(--gray-text);
        margin: 0;
    }
    .badge.scope-badge {
        font-size: 12px;
        font-weight: 500;
    }

    .material-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
        background-color: #f8f9fa;
        display: flex;
        gap: 10px;
    }
    .btn-material {
        flex-grow: 1;
        font-weight: 500;
    }
    
    /* Responsive cho cột chọn lớp */
    @media (max-width: 767px) {
        .class-list-sidebar {
            border-right: none !important;
            border-bottom: 1px solid var(--border-color);
            padding-right: 0 !important;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
    }
</style>
<div class="content-pane">
    <h2 class="mb-4">Học liệu khóa học</h2>
    <div class="row mt-4">
        <div class="col-md-4 class-list-sidebar">
            <h5 class="mb-3">Chọn lớp học của bạn</h5>
            <?php if ($result_classes->num_rows > 0): ?>
                <div class="list-group">
                    <?php mysqli_data_seek($result_classes, 0); // Reset con trỏ
                          while($class = $result_classes->fetch_assoc()): ?>
                        <a href="./dashboard.php?nav=hoclieu&lop_id=<?php echo $class['id_lop']; ?>" 
                           class="list-group-item list-group-item-action <?php echo ($selected_lop_id == $class['id_lop']) ? 'active' : ''; ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($class['ten_lop']); ?></h6>
                            </div>
                            <small><?php echo htmlspecialchars($class['ten_khoahoc']); ?></small>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-secondary">Bạn chưa tham gia lớp học nào có học liệu.</div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-8">
            <?php if ($selected_lop_id): ?>
                <h5 class="mb-3">Danh sách tài liệu</h5>
                <?php if (!empty($materials)): ?>
                    <div class="row g-3">
                        <?php foreach ($materials as $index => $material): 
                            $file_details = get_file_type_details($material['loai_file']);
                            $file_ext = strtolower($material['loai_file']);
                            $is_viewable = in_array($file_ext, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'txt']);
                        ?>
                            <div class="col-md-6">
                                <div class="material-card" style="animation-delay: <?php echo $index * 100; ?>ms;">
                                    <div class="material-card-header">
                                        <div class="file-icon" style="background-color: <?php echo $file_details['color']; ?>">
                                            <i class="fa-solid <?php echo $file_details['icon']; ?>"></i>
                                        </div>
                                        <div class="material-info">
                                            <h5><?php echo htmlspecialchars($material['tieu_de']); ?></h5>
                                            <p>
                                                <?php if (is_null($material['id_lop'])) : ?>
                                                    <span class="badge scope-badge bg-info text-dark">Tài liệu chung</span>
                                                <?php else: ?>
                                                     <span class="badge scope-badge bg-light text-dark">Lớp: <?php echo htmlspecialchars($class['ten_lop']); ?></span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="material-card-footer">
                                        <?php if ($is_viewable): ?>
                                            <button class="btn btn-sm btn-outline-primary btn-material" 
                                                    onclick="viewMaterial('<?php echo htmlspecialchars($material['duong_dan_file']); ?>', '<?php echo $file_ext; ?>', '<?php echo htmlspecialchars(addslashes($material['tieu_de'])); ?>')">
                                                <i class="fa-solid fa-eye"></i> Xem
                                            </button>
                                        <?php endif; ?>
                                        <a href="../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-sm btn-primary btn-material" download>
                                            <i class="fa-solid fa-download"></i> Tải về
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light text-center">
                        <i class="fa-solid fa-box-open fa-3x mb-3 text-muted"></i>
                        <p class="mb-0">Chưa có tài liệu nào cho lớp học này.</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-light text-center d-flex align-items-center justify-content-center h-100">
                    <p class="mb-0"><i class="fa-solid fa-arrow-left me-2"></i> Vui lòng chọn một lớp học từ danh sách bên trái.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // JavaScript để xử lý việc xem file trong Modal
    function viewMaterial(filePath, fileExt, fileTitle) {
        const modal = new bootstrap.Modal(document.getElementById('fileViewerModal'));
        const modalTitle = document.getElementById('fileViewerModalLabel');
        const modalContent = document.getElementById('fileViewerContent');
        
        modalTitle.textContent = fileTitle;
        let contentHtml = '';
        const fullPath = `../${filePath}`;

        switch (fileExt) {
            case 'pdf':
                contentHtml = `<iframe src="${fullPath}" width="100%" height="100%" frameborder="0"></iframe>`;
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                contentHtml = `<img src="${fullPath}" class="img-fluid" style="display: block; margin: auto; max-height: 100%; object-fit: contain;">`;
                break;
            case 'mp4':
            case 'webm':
                contentHtml = `<video controls autoplay style="width: 100%; height: 100%;"><source src="${fullPath}" type="video/${fileExt}"></video>`;
                break;
            case 'txt':
                 contentHtml = `<iframe src="${fullPath}" width="100%" height="100%" frameborder="0"></iframe>`;
                 break;
            default:
                contentHtml = `<div class="p-5 text-center">Định dạng file không hỗ trợ xem trước. Vui lòng tải về.</div>`;
                break;
        }

        modalContent.innerHTML = contentHtml;
        modal.show();
    }
</script>