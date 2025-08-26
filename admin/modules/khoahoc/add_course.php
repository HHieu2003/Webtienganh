<?php
include('../config/config.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khoahoc = $_POST['ten_khoahoc'];
    $mo_ta = $_POST['mo_ta'];
    $giang_vien = $_POST['giang_vien'];
    $thoi_gian = $_POST['thoi_gian'];
    $chi_phi = $_POST['chi_phi'];

    // Kiểm tra và xử lý upload hình ảnh
    // Kiểm tra và xử lý upload hình ảnh
    $hinh_anh = '';
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/"; // Thư mục lưu trữ ảnh
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }

        $target_file = $target_dir . basename($_FILES['hinh_anh']['name']);

        // Kiểm tra nếu file là ảnh
        if (getimagesize($_FILES['hinh_anh']['tmp_name'])) {
            if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
                $hinh_anh = 'uploads/' . basename($_FILES['hinh_anh']['name']); // Lưu đường dẫn
            } else {
                die("Lỗi khi lưu file. ");
            }
        } else {
            die("Tệp tải lên không phải là hình ảnh.");
        }
    }
    // else {
    //     if (isset($_FILES['hinh_anh']['error'])) {
    //         die("Lỗi tải file: " . $_FILES['hinh_anh']['error']);
    //     }
    // }


    // Lưu thông tin khóa học vào cơ sở dữ liệu
    $sql = "INSERT INTO khoahoc (ten_khoahoc, mo_ta, giang_vien, thoi_gian, chi_phi, hinh_anh) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssdss', $ten_khoahoc, $mo_ta, $giang_vien, $thoi_gian, $chi_phi, $hinh_anh);
    mysqli_stmt_execute($stmt);

    header('Location: ./admin.php?nav=courses');
}
?>
<div class="container my-2">
    <h2 class="text-center title-color">Thêm Khóa Học</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="ten_khoahoc" class="form-label">Tên Khóa Học:</label>
                <input type="text" name="ten_khoahoc" id="ten_khoahoc" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mo_ta" class="form-label">Mô Tả:</label>
                <textarea name="mo_ta" id="mo_ta" class="form-control" rows="3"></textarea>

            </div>
            <div class="mb-3">
                <label for="giang_vien" class="form-label">Giảng Viên:</label>
                <input type="text" name="giang_vien" id="giang_vien" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="thoi_gian" class="form-label">Thời Gian:</label>
                <input type="text" name="thoi_gian" id="thoi_gian" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="chi_phi" class="form-label">Chi Phí:</label>
                <input type="number"  name="chi_phi" id="chi_phi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="hinh_anh" class="form-label">Hình Ảnh:</label>
                <input type="file" name="hinh_anh" id="hinh_anh" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Thêm</button>
        </form>
   
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
