<?php
// Giả định $conn và session đã được khởi tạo từ file dashboard.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];
$selected_lop_id = $_GET['lop_id'] ?? null;

// Lấy danh sách các lớp học mà học viên đang tham gia và có id_lop
$sql_classes = "
    SELECT 
        lh.id_lop, 
        lh.ten_lop, 
        kh.ten_khoahoc 
    FROM dangkykhoahoc dk
    JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE 
        dk.id_hocvien = ? 
        AND dk.trang_thai = 'da xac nhan' 
        AND dk.id_lop IS NOT NULL
    ORDER BY kh.ten_khoahoc, lh.ten_lop
";
$stmt_classes = $conn->prepare($sql_classes);
$stmt_classes->bind_param("i", $id_hocvien);
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

<div class="content-pane">
    <h2>Học liệu của bạn</h2>
    <div class="row mt-4">
        <div class="col-md-4 border-end">
            <h5 class="mb-3">Chọn lớp học để xem tài liệu</h5>
            <?php if ($result_classes->num_rows > 0): ?>
                <div class="list-group">
                    <?php while($class = $result_classes->fetch_assoc()): ?>
                        <a href="./dashboard.php?nav=hoclieu&lop_id=<?php echo $class['id_lop']; ?>" 
                           class="list-group-item list-group-item-action <?php echo ($selected_lop_id == $class['id_lop']) ? 'active' : ''; ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?php echo htmlspecialchars($class['ten_lop']); ?></h6>
                            </div>
                            <small class="text-muted"><?php echo htmlspecialchars($class['ten_khoahoc']); ?></small>
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
                <?php if ($materials->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while($material = $materials->fetch_assoc()): 
                            $file_ext = strtolower($material['loai_file']);
                            $is_viewable = in_array($file_ext, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm']);
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="d-block"><?php echo htmlspecialchars($material['tieu_de']); ?></strong>
                                    <small class="text-muted">
                                        Loại: <?php echo htmlspecialchars($material['loai_file']); ?> | Ngày đăng: <?php echo date("d/m/Y", strtotime($material['ngay_dang'])); ?>
                                    </small>
                                </div>
                                <div class="btn-group" role="group">
                                    <?php if ($is_viewable): ?>
                                        <button class="btn btn-info btn-sm text-white" 
                                                onclick="viewMaterial('<?php echo htmlspecialchars($material['duong_dan_file']); ?>', '<?php echo $file_ext; ?>', '<?php echo htmlspecialchars(addslashes($material['tieu_de'])); ?>')">
                                            <i class="fa-solid fa-eye"></i> Xem
                                        </button>
                                    <?php endif; ?>
                                    <a href="../<?php echo htmlspecialchars($material['duong_dan_file']); ?>" class="btn btn-primary btn-sm" download>
                                        <i class="fa-solid fa-download"></i> Tải về
                                    </a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-info text-center">Lớp học này hiện chưa có tài liệu nào.</div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-light text-center d-flex align-items-center justify-content-center h-100">
                    <p class="mb-0"><i class="fa-solid fa-arrow-left me-2"></i> Vui lòng chọn một lớp học từ danh sách bên trái để xem học liệu.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>