<?php
// user/modules/viet_bai.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để sử dụng chức năng này.");
}
?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<div class="content-pane">
    <h2 class="mb-4">Viết bài chia sẻ kiến thức</h2>

    <?php if (isset($_SESSION['post_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['post_message_type']; ?>">
            <?php echo $_SESSION['post_message']; ?>
        </div>
        <?php unset($_SESSION['post_message']); unset($_SESSION['post_message_type']); ?>
    <?php endif; ?>

    <form action="modules/submit_post.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tieu_de" class="form-label"><strong>Tiêu đề bài viết *</strong></label>
            <input type="text" class="form-control" id="tieu_de" name="tieu_de" required>
        </div>
        <div class="mb-3">
            <label for="hinh_anh_tieu_de" class="form-label"><strong>Ảnh tiêu đề</strong> (giúp bài viết hấp dẫn hơn)</label>
            <input type="file" class="form-control" id="hinh_anh_tieu_de" name="hinh_anh_tieu_de" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="noi_dung" class="form-label"><strong>Nội dung bài viết *</strong></label>
            <textarea name="noi_dung" id="noi_dung" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Gửi bài để duyệt</button>
    </form>
</div>

<script>
    CKEDITOR.replace('noi_dung', {
        height: 400
    });
</script>