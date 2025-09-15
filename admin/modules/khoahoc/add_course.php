<?php
// Lấy danh sách giảng viên để hiển thị trong dropdown
$sql_giangvien = "SELECT id_giangvien, ten_giangvien FROM giangvien ORDER BY ten_giangvien ASC";
$result_giangvien = $conn->query($sql_giangvien);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khoahoc = $_POST['ten_khoahoc'];
    $mo_ta = $_POST['mo_ta'];
    
    // Xử lý giá trị NULL cho giảng viên và thời gian
    $id_giangvien = !empty($_POST['id_giangvien']) ? (int)$_POST['id_giangvien'] : NULL;
    $thoi_gian = !empty($_POST['thoi_gian']) ? (int)$_POST['thoi_gian'] : NULL;
    
    $chi_phi = (int)$_POST['chi_phi'];
    
    // Xử lý upload hình ảnh
    $hinh_anh = NULL;
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES['hinh_anh']['name']);
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh = 'uploads/' . basename($_FILES['hinh_anh']['name']);
        }
    }

    $sql_insert = "INSERT INTO khoahoc (ten_khoahoc, mo_ta, id_giangvien, thoi_gian, chi_phi, hinh_anh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    // 's' cho string, 'i' cho integer, 'd' cho double, 'b' cho blob
    $stmt->bind_param('ssiiis', $ten_khoahoc, $mo_ta, $id_giangvien, $thoi_gian, $chi_phi, $hinh_anh);
    
    if($stmt->execute()){
        header('Location: ./admin.php?nav=courses&status=add_success');
        exit();
    }
}
?>
<div class="container-fluid">
    <h1 class="title-color">Thêm Khóa Học Mới</h1>
    <div class="card animated-card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="ten_khoahoc" class="form-label">Tên Khóa Học: <span class="text-danger">*</span></label>
                    <input type="text" name="ten_khoahoc" id="ten_khoahoc" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="mo_ta" class="form-label">Mô Tả:</label>
                    <textarea name="mo_ta" id="mo_ta" class="form-control" rows="5"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_giangvien" class="form-label">Giảng Viên: (Có thể để trống)</label>
                        <select name="id_giangvien" id="id_giangvien" class="form-select">
                            <option value="">-- Chọn giảng viên --</option>
                            <?php while($gv = $result_giangvien->fetch_assoc()): ?>
                                <option value="<?php echo $gv['id_giangvien']; ?>"><?php echo htmlspecialchars($gv['ten_giangvien']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="thoi_gian" class="form-label">Thời Gian (số buổi): (Có thể để trống)</label>
                        <input type="number" name="thoi_gian" id="thoi_gian" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="chi_phi" class="form-label">Học phí (VNĐ): <span class="text-danger">*</span></label>
                        <input type="number" name="chi_phi" id="chi_phi" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hinh_anh" class="form-label">Hình Ảnh:</label>
                        <input type="file" name="hinh_anh" id="hinh_anh" class="form-control">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm Khóa học</button>
                    <a href="./admin.php?nav=courses" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>