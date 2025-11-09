<?php
// user/modules/hoclieu.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- TỐI ƯU HÓA TRUY VẤN: Lấy tất cả lớp và tài liệu liên quan trong 1 lần gọi ---
$sql_all_data = "
    SELECT 
        lh.id_lop, lh.ten_lop, kh.ten_khoahoc,
        hl.id_hoclieu, hl.tieu_de, hl.loai_file, hl.duong_dan_file, hl.ngay_dang,
        (hl.id_lop IS NULL) as is_course_material -- Cờ để xác định tài liệu chung của khóa học
    FROM dangkykhoahoc dk
    JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    -- Lấy học liệu của lớp HOẶC học liệu chung của khóa học mà lớp đó thuộc về
    LEFT JOIN hoc_lieu hl ON (hl.id_lop = lh.id_lop OR (hl.id_khoahoc = lh.id_khoahoc AND hl.id_lop IS NULL))
    WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan'
    ORDER BY kh.ten_khoahoc, lh.ten_lop, hl.ngay_dang DESC
";
$stmt = $conn->prepare($sql_all_data);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

// --- Nhóm dữ liệu lại theo từng lớp học ---
$classes_with_materials = [];
while ($row = $result->fetch_assoc()) {
    $class_id = $row['id_lop'];
    // Khởi tạo mảng cho lớp nếu chưa có
    if (!isset($classes_with_materials[$class_id])) {
        $classes_with_materials[$class_id] = [
            'id_lop' => $row['id_lop'],
            'ten_lop' => $row['ten_lop'],
            'ten_khoahoc' => $row['ten_khoahoc'],
            'materials' => []
        ];
    }
    // Thêm tài liệu vào lớp (nếu có tài liệu)
    if ($row['id_hoclieu']) {
        $classes_with_materials[$class_id]['materials'][] = $row;
    }
}
$stmt->close();


// Hàm để lấy icon và màu sắc dựa trên loại file
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
            return ['icon' => 'fa-file-powerpoint', 'color' => '#F59E0B'];
        case 'mp4':
        case 'mov':
        case 'avi':
            return ['icon' => 'fa-file-video', 'color' => '#8B5CF6'];
        case 'jpg':
        case 'png':
        case 'jpeg':
        case 'gif':
            return ['icon' => 'fa-file-image', 'color' => '#63B3ED'];
        default:
            return ['icon' => 'fa-file-alt', 'color' => '#6B7280'];
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

    .accordion-item {
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius) !important;
        margin-bottom: 15px;
        box-shadow: var(--shadow);
        transition: box-shadow 0.3s ease;
    }

    .accordion-item:hover {
        box-shadow: var(--shadow-hover);
    }

    .accordion-header .accordion-button {
        border-radius: var(--border-radius) !important;
        font-weight: 600;
        font-size: 18px;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color-light);
        color: var(--primary-color-dark);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 179, 59, 0.25);
    }

    .accordion-body {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .material-card {
        background-color: #fff;
        border-radius: var(--border-radius);
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid var(--border-color);
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
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-material {
        flex-grow: 1;
        font-weight: 500;
    }
</style>
<div class="content-pane">
    <h2 class="mb-4">Học liệu khóa học</h2>

    <?php if (!empty($classes_with_materials)): ?>
        <div class="accordion" id="classesAccordion">
            <?php
            $index = 0;
            foreach ($classes_with_materials as $class_id => $class_data):
                $material_count = count($class_data['materials']);
            ?>
                <div class="accordion-item animated-item" style="animation-delay: <?php echo $index * 100; ?>ms;">
                    <h2 class="accordion-header" id="heading-<?php echo $class_id; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $class_id; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $class_id; ?>">
                            <div class="d-flex justify-content-between w-100 align-items-center pe-3">
                                <span>
                                    <?php echo htmlspecialchars($class_data['ten_lop']); ?>
                                    <small class="text-muted d-block fw-normal"><?php echo htmlspecialchars($class_data['ten_khoahoc']); ?></small>
                                </span>
                                <span class="badge bg-primary rounded-pill"><?php echo $material_count; ?> tài liệu</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-<?php echo $class_id; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $class_id; ?>" data-bs-parent="#classesAccordion">
                        <div class="accordion-body">
                            <?php if ($material_count > 0): ?>
                                <div class="row g-3">
                                    <?php foreach ($class_data['materials'] as $material):
                                        $file_details = get_file_type_details($material['loai_file']);
                                        $file_ext = strtolower($material['loai_file'] ?? '');
                                        $is_viewable = in_array($file_ext, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']);
                                    ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="material-card">
                                                <div class="material-card-header">
                                                    <div class="file-icon" style="background-color: <?php echo $file_details['color']; ?>">
                                                        <i class="fa-solid <?php echo $file_details['icon']; ?>"></i>
                                                    </div>
                                                    <div class="material-info">
                                                        <h5><?php echo htmlspecialchars($material['tieu_de']); ?></h5>
                                                        <p>
                                                            <?php if ($material['is_course_material']) : ?>
                                                                <span class="badge scope-badge bg-info text-dark">Tài liệu chung</span>
                                                            <?php else: ?>
                                                                <span class="badge scope-badge bg-light text-dark">Tài liệu lớp</span>
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
                                <p class="text-center text-muted m-0">Lớp này chưa có tài liệu nào.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
                $index++;
            endforeach;
            ?>
        </div>
    <?php else: ?>
        <div class="alert alert-light text-center">
            <i class="fa-solid fa-school-circle-xmark fa-3x mb-3 text-muted"></i>
            <p class="mb-0">Bạn chưa được xếp vào lớp học nào để xem học liệu.</p>
        </div>
    <?php endif; ?>
</div>

<script>
    function viewMaterial(filePath, fileExt, fileTitle) {
        const modal = new bootstrap.Modal(document.getElementById('fileViewerModal'));
        const modalTitle = document.getElementById('fileViewerModalLabel');
        const modalContent = document.getElementById('fileViewerContent');

        modalTitle.textContent = fileTitle;
        let contentHtml = '';
        const baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname.substring(0, window.location.pathname.indexOf("/user/"));
        const fullPublicUrl = `${baseUrl}/${filePath}`;

        switch (fileExt) {
            case 'pdf':
            case 'txt':
                contentHtml = `<iframe src="../${filePath}" width="100%" height="100%" frameborder="0"></iframe>`;
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                contentHtml = `<img src="../${filePath}" class="img-fluid" style="display: block; margin: auto; max-height: 100%; object-fit: contain;">`;
                break;
            case 'mp4':
            case 'webm':
                contentHtml = `<video controls autoplay style="width: 100%; height: 100%;"><source src="../${filePath}" type="video/${fileExt}"></video>`;
                break;
            case 'doc':
            case 'docx':
            case 'xls':
            case 'xlsx':
            case 'ppt':
            case 'pptx':
                const officeViewerUrl = `https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(fullPublicUrl)}`;
                contentHtml = `<iframe src="${officeViewerUrl}" width="100%" height="100%" frameborder="0"></iframe>
                               <div class="alert alert-warning small p-2 m-2">Lưu ý: Chức năng xem trước file Office hoạt động tốt nhất khi website đã được đưa lên internet.</div>`;
                break;
            default:
                contentHtml = `<div class="p-5 text-center">Định dạng file không hỗ trợ xem trước. Vui lòng tải về.</div>`;
                break;
        }

        modalContent.innerHTML = contentHtml;
        modal.show();
    }
</script>