<?php
// user/modules/sua_bai_viet.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để sử dụng chức năng này.");
}

$id_baiviet = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$id_hocvien = $_SESSION['id_hocvien'];

if (!$id_baiviet) {
    die("ID bài viết không hợp lệ.");
}

// Lấy thông tin bài viết, đảm bảo chỉ chủ sở hữu mới có thể sửa
$sql = "SELECT * FROM bai_viet WHERE id_baiviet = ? AND id_tac_gia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_baiviet, $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Không tìm thấy bài viết hoặc bạn không có quyền sửa bài viết này.");
}
?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<div class="content-pane">
    <h2 class="mb-4">Chỉnh sửa bài viết</h2>

    <form action="modules/update_post.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_baiviet" value="<?php echo $post['id_baiviet']; ?>">
        <input type="hidden" name="old_image_path" value="<?php echo htmlspecialchars($post['hinh_anh_tieu_de']); ?>">

        <div class="mb-3">
            <label for="tieu_de" class="form-label"><strong>Tiêu đề bài viết *</strong></label>
            <input type="text" class="form-control" id="tieu_de" name="tieu_de" required value="<?php echo htmlspecialchars($post['tieu_de']); ?>">
        </div>

        <div class="mb-3">
            <label for="hinh_anh_tieu_de" class="form-label"><strong>Ảnh tiêu đề</strong> (để trống nếu không muốn thay đổi)</label>
            <?php if (!empty($post['hinh_anh_tieu_de'])): ?>
                <div class="mb-2">
                    <img src="../<?php echo htmlspecialchars($post['hinh_anh_tieu_de']); ?>" alt="Ảnh hiện tại" style="max-width: 200px; border-radius: 5px;">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="hinh_anh_tieu_de" name="hinh_anh_tieu_de" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="noi_dung" class="form-label"><strong>Nội dung bài viết *</strong></label>
            <textarea name="noi_dung" id="noi_dung" class="form-control"><?php echo htmlspecialchars($post['noi_dung']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Cập nhật bài viết</button>
        <a href="?nav=bai_viet_cua_toi" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<script>
    CKEDITOR.replace('noi_dung', {
        height: 400
    });
</script>