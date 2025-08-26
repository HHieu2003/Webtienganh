<?php
include('../config/config.php');

// Lấy thông tin khóa học cần chỉnh sửa
if (isset($_GET['id'])) {
    $id_khoahoc = $_GET['id'];

    // Truy vấn để lấy thông tin khóa học
    $sql = "SELECT * FROM khoahoc WHERE id_khoahoc = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_khoahoc);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Kiểm tra xem khóa học có tồn tại không
    if (mysqli_num_rows($result) == 0) {
        die("Khóa học không tồn tại.");
    }

    $row = mysqli_fetch_assoc($result);

    // Các giá trị mặc định của khóa học
    $ten_khoahoc = $row['ten_khoahoc'];
    $mo_ta = $row['mo_ta'];
    $giang_vien = $row['giang_vien'];
    $thoi_gian = $row['thoi_gian'];
    $chi_phi = $row['chi_phi'];
    $hinh_anh = $row['hinh_anh'];
}

// Xử lý khi người dùng gửi form chỉnh sửa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khoahoc = $_POST['ten_khoahoc'];
    $mo_ta = $_POST['mo_ta'];
    $giang_vien = $_POST['giang_vien'];
    $thoi_gian = $_POST['thoi_gian'];
    $chi_phi = $_POST['chi_phi'];

    // Kiểm tra và xử lý upload hình ảnh
    $hinh_anh_moi = $hinh_anh; // Giữ lại hình ảnh cũ nếu không có hình ảnh mới
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/"; // Thư mục lưu trữ ảnh
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }

        $target_file = $target_dir . basename($_FILES['hinh_anh']['name']);

        // Kiểm tra nếu file là ảnh
        if (getimagesize($_FILES['hinh_anh']['tmp_name'])) {
            if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
                $hinh_anh_moi = 'uploads/' . basename($_FILES['hinh_anh']['name']); // Lưu đường dẫn
            } else {
                die("Lỗi khi lưu file. Kiểm tra quyền thư mục.");
            }
        } else {
            die("Tệp tải lên không phải là hình ảnh.");
        }
    }

    // Cập nhật thông tin khóa học vào cơ sở dữ liệu
    $sql = "UPDATE khoahoc SET ten_khoahoc = ?, mo_ta = ?, giang_vien = ?, thoi_gian = ?, chi_phi = ?, hinh_anh = ? WHERE id_khoahoc = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssdssi', $ten_khoahoc, $mo_ta, $giang_vien, $thoi_gian, $chi_phi, $hinh_anh_moi, $id_khoahoc);
    mysqli_stmt_execute($stmt);

    header('Location: ./admin.php?nav=courses');
}
?>

<div class="container my-2">
    <h1 class="text-center title-color">Chỉnh sửa Khóa Học</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="ten_khoahoc" class="form-label">Tên Khóa Học:</label>
            <input type="text" name="ten_khoahoc" id="ten_khoahoc" class="form-control" value="<?= htmlspecialchars($ten_khoahoc) ?>" required>
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô Tả:</label>
            <textarea name="mo_ta" id="mo_ta" class="form-control" rows="3"><?= htmlspecialchars($mo_ta) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="giang_vien" class="form-label">Giảng Viên:</label>
            <input type="text" name="giang_vien" id="giang_vien" class="form-control" value="<?= htmlspecialchars($giang_vien) ?>" required>
        </div>
        <div class="mb-3">
            <label for="thoi_gian" class="form-label">Thời Gian:</label>
            <input type="text" name="thoi_gian" id="thoi_gian" class="form-control" value="<?= htmlspecialchars($thoi_gian) ?>" required>
        </div>
        <div class="mb-3">
            <label for="chi_phi" class="form-label">Chi Phí:</label>
            <input type="number" step="0.01" name="chi_phi" id="chi_phi" class="form-control" value="<?= htmlspecialchars($chi_phi) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình Ảnh Hiện Tại:</label>
            <?php if (!empty($hinh_anh)): ?>
                <img src="../<?= htmlspecialchars($hinh_anh) ?>" alt="Hình Ảnh Khóa Học" style="width: 200px; height: auto; margin: 10px 10px 10px 100px">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="hinh_anh" class="form-label">Tải Ảnh Mới:</label>
            <input type="file" name="hinh_anh" id="hinh_anh" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>