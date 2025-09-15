<?php
$id_khoahoc = $_GET['id'] ?? 0;
if ($id_khoahoc == 0) die("ID khóa học không hợp lệ.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khoahoc = $_POST['ten_khoahoc'];
    $mo_ta = $_POST['mo_ta'];
    
    // Xử lý giá trị NULL
    $id_giangvien = !empty($_POST['id_giangvien']) ? (int)$_POST['id_giangvien'] : NULL;
    $thoi_gian = !empty($_POST['thoi_gian']) ? (int)$_POST['thoi_gian'] : NULL;
    
    $chi_phi = (int)$_POST['chi_phi'];
    $hinh_anh_hien_tai = $_POST['hinh_anh_hien_tai'];
    $hinh_anh_moi = $hinh_anh_hien_tai;

    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['hinh_anh']['name']);
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh_moi = 'uploads/' . basename($_FILES['hinh_anh']['name']);
        }
    }

    $sql_update = "UPDATE khoahoc SET ten_khoahoc=?, mo_ta=?, id_giangvien=?, thoi_gian=?, chi_phi=?, hinh_anh=? WHERE id_khoahoc=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('ssiissi', $ten_khoahoc, $mo_ta, $id_giangvien, $thoi_gian, $chi_phi, $hinh_anh_moi, $id_khoahoc);
    
    if($stmt->execute()){
        header('Location: ./admin.php?nav=courses&status=edit_success');
        exit();
    }
}

// Lấy thông tin khóa học hiện tại và danh sách giảng viên
$sql = "SELECT * FROM khoahoc WHERE id_khoahoc = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_khoahoc);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();
if (!$course) die("Không tìm thấy khóa học.");

$sql_giangvien = "SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien ASC";
$result_giangvien = $conn->query($sql_giangvien);
?>
<div class="container-fluid">
    <h1 class="title-color">Chỉnh sửa Khóa Học</h1>
    <div class="card animated-card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="hinh_anh_hien_tai" value="<?php echo htmlspecialchars($course['hinh_anh']); ?>">
                <div class="mb-3">
                    <label for="ten_khoahoc" class="form-label">Tên Khóa Học: <span class="text-danger">*</span></label>
                    <input type="text" name="ten_khoahoc" id="ten_khoahoc" class="form-control" value="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mo_ta" class="form-label">Mô Tả:</label>
                    <textarea name="mo_ta" id="mo_ta" class="form-control" rows="5"><?php echo htmlspecialchars($course['mo_ta']); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_giangvien" class="form-label">Giảng Viên: (Có thể để trống)</label>
                        <select name="id_giangvien" id="id_giangvien" class="form-select">
                            <option value="">-- Chọn giảng viên --</option>
                            <?php while($gv = $result_giangvien->fetch_assoc()): ?>
                                <option value="<?php echo $gv['id_giangvien']; ?>" <?php if($course['id_giangvien'] == $gv['id_giangvien']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($gv['ten_giangvien']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="thoi_gian" class="form-label">Thời Gian (số buổi): (Có thể để trống)</label>
                        <input type="number" name="thoi_gian" id="thoi_gian" class="form-control" value="<?php echo htmlspecialchars($course['thoi_gian']); ?>">
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <label for="chi_phi" class="form-label">Học phí (VNĐ): <span class="text-danger">*</span></label>
                        <input type="number" name="chi_phi" id="chi_phi" class="form-control" value="<?php echo htmlspecialchars($course['chi_phi']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hinh_anh" class="form-label">Tải ảnh mới (để trống nếu không đổi):</label>
                        <input type="file" name="hinh_anh" id="hinh_anh" class="form-control">
                    </div>
                </div>
                <?php if (!empty($course['hinh_anh'])): ?>
                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại:</label>
                    <img src="../<?php echo htmlspecialchars($course['hinh_anh']); ?>" alt="Hình Ảnh Khóa Học" style="max-width: 200px; height: auto; border-radius: 8px; display: block;">
                </div>
                <?php endif; ?>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Cập nhật</button>
                    <a href="./admin.php?nav=courses" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>