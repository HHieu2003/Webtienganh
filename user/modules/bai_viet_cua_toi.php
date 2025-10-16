<?php
// user/modules/bai_viet_cua_toi.php
$id_hocvien = $_SESSION['id_hocvien'];

$sql = "SELECT 
            bv.id_baiviet, bv.tieu_de, bv.ngay_tao, bv.trang_thai, bv.luot_xem,
            COUNT(bl.id_binhluan) AS so_binh_luan
        FROM bai_viet bv
        LEFT JOIN binh_luan bl ON bv.id_baiviet = bl.id_baiviet
        WHERE bv.id_tac_gia = ?
        GROUP BY bv.id_baiviet
        ORDER BY bv.ngay_tao DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

function get_post_status_badge($status)
{
    switch ($status) {
        case 'da_duyet':
            return '<span class="badge bg-success">Đã duyệt</span>';
        case 'cho_duyet':
            return '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
        case 'bi_tu_choi':
            return '<span class="badge bg-danger">Bị từ chối</span>';
        default:
            return '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
    }
}
?>
<div class="content-pane">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2>Bài viết của tôi</h2>
        <a href="?nav=viet_bai" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i> Viết bài mới</a>
    </div>

    <?php if (isset($_SESSION['post_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['post_message_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['post_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['post_message']);
        unset($_SESSION['post_message_type']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th class="text-center">Ngày gửi</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Lượt xem</th>
                    <th class="text-center">Bình luận</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                        <tr id="post-row-<?php echo $row['id_baiviet']; ?>">
                            <td style="max-width: 300px;"><?php echo htmlspecialchars($row['tieu_de']); ?></td>
                            <td class="text-center"><?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></td>
                            <td class="text-center"><?php echo get_post_status_badge($row['trang_thai']); ?></td>
                            <td class="text-center"><?php echo $row['luot_xem']; ?></td>
                            <td class="text-center"><?php echo $row['so_binh_luan']; ?></td>
                            <td class="text-center">
                                <?php if ($row['trang_thai'] == 'da_duyet'): ?>
                                    <a href="../index.php?nav=blog_single&id=<?php echo $row['id_baiviet']; ?>" class="btn btn-sm btn-info text-white" target="_blank" title="Xem bài viết"><i class="fa-solid fa-eye"></i></a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled title="Bài viết chưa được duyệt"><i class="fa-solid fa-eye-slash"></i></button>
                                <?php endif; ?>

                                <!-- NÚT SỬA BÀI VIẾT MỚI -->
                                <a href="?nav=sua_bai_viet&id=<?php echo $row['id_baiviet']; ?>" class="btn btn-sm btn-warning text-white" title="Sửa bài viết"><i class="fa-solid fa-pencil"></i></a>

                                <button class="btn btn-sm btn-danger" onclick="deleteMyPost(<?php echo $row['id_baiviet']; ?>)" title="Xóa bài viết"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Bạn chưa gửi bài viết nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteMyPost(postId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này sẽ xóa vĩnh viễn bài viết và tất cả bình luận liên quan. Bạn không thể khôi phục lại!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('modules/delete_my_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            post_id: postId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const postRow = document.getElementById(`post-row-${postId}`);
                            if (postRow) {
                                postRow.style.transition = 'opacity 0.5s ease';
                                postRow.style.opacity = '0';
                                setTimeout(() => postRow.remove(), 500);
                            }
                            Swal.fire('Đã xóa!', data.message, 'success');
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                    });
            }
        });
    }
</script>