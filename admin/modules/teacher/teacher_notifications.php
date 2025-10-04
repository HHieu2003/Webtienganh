<?php
// File: admin/modules/teacher/teacher_notifications.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- LẤY DANH SÁCH LỚP HỌC CỦA GIẢNG VIÊN ĐỂ DÙNG TRONG MODAL ---
$sql_my_classes = "SELECT id_lop, ten_lop FROM lop_hoc WHERE id_giangvien = ? AND trang_thai = 'dang hoc' ORDER BY ten_lop ASC";
$stmt_classes = $conn->prepare($sql_my_classes);
$stmt_classes->bind_param("i", $id_giangvien);
$stmt_classes->execute();
$my_classes = $stmt_classes->get_result();

// --- LẤY LỊCH SỬ CÁC THÔNG BÁO ĐÃ GỬI CỦA GIẢNG VIÊN ---
$sql_history = "
    SELECT DISTINCT
        tb.tieu_de, 
        tb.ngay_tao, 
        tb.id_lop,
        lh.ten_lop,
        (SELECT COUNT(id_thongbao) FROM thongbao t_count WHERE t_count.id_lop = tb.id_lop AND t_count.ngay_tao = tb.ngay_tao) as student_count,
        MAX(tb.noi_dung) as noi_dung
    FROM thongbao tb
    JOIN lop_hoc lh ON tb.id_lop = lh.id_lop
    WHERE lh.id_giangvien = ?
    GROUP BY tb.tieu_de, tb.ngay_tao, tb.id_lop, lh.ten_lop
    ORDER BY tb.ngay_tao DESC
";
$stmt_history = $conn->prepare($sql_history);
$stmt_history->bind_param("i", $id_giangvien);
$stmt_history->execute();
$history = $stmt_history->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-bell me-2"></i>Lịch sử thông báo đã gửi</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                <i class="fa-solid fa-paper-plane"></i> Soạn Thông báo mới
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 25%;">Tiêu đề</th>
                        <th style="width: 35%;">Nội dung (rút gọn)</th>
                        <th>Gửi đến lớp</th>
                        <th class="text-center">Ngày gửi</th>
                        <th class="text-center">Số HV nhận</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($history->num_rows > 0):
                        $index = 0;
                        while ($row = $history->fetch_assoc()):
                    ?>
                        <tr class="animated-row" id="notification-row-<?php echo md5($row['tieu_de'] . $row['ngay_tao']); ?>">
                            <td><strong><?php echo htmlspecialchars($row['tieu_de']); ?></strong></td>
                            <td><?php echo htmlspecialchars(substr(strip_tags($row['noi_dung']), 0, 100)) . '...'; ?></td>
                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($row['ten_lop']); ?></span></td>
                            <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_tao'])); ?></td>
                            <td class="text-center"><span class="badge bg-secondary"><?php echo $row['student_count']; ?></span></td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" 
                                        onclick="deleteNotification(
                                            '<?php echo htmlspecialchars(addslashes($row['tieu_de'])); ?>', 
                                            '<?php echo htmlspecialchars($row['id_lop']); ?>', 
                                            '<?php echo htmlspecialchars($row['ngay_tao']); ?>',
                                            '<?php echo md5($row['tieu_de'] . $row['ngay_tao']); ?>'
                                        )"
                                        title="Xóa nhóm thông báo này">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile;
                    else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Bạn chưa gửi thông báo nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-paper-plane me-2"></i>Soạn và Gửi Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sendNotificationForm_teacher">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8"><div class="form-floating mb-3"><input type="text" name="tieu_de" class="form-control" placeholder="Tiêu đề thông báo" required><label>Tiêu đề *</label></div></div>
                        <div class="col-md-4"><div class="form-floating mb-3">
                                <select name="id_lop" class="form-select" required>
                                    <option value="" selected disabled>-- Vui lòng chọn lớp --</option>
                                    <?php if ($my_classes->num_rows > 0): mysqli_data_seek($my_classes, 0); while($class = $my_classes->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($class['id_lop']); ?>"><?php echo htmlspecialchars($class['ten_lop']); ?></option>
                                    <?php endwhile; else: ?><option disabled>Bạn chưa có lớp học nào đang hoạt động</option><?php endif; ?>
                                </select><label>Gửi đến lớp *</label>
                        </div></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Nội dung thông báo *</label><textarea name="noi_dung" id="noi_dung_editor_teacher" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" <?php if($my_classes->num_rows == 0) echo 'disabled'; ?>>Gửi đi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ================================================================
    // === SỬA LỖI & HOÀN THIỆN JAVASCRIPT ===
    // ================================================================
    function deleteNotification(tieu_de, id_lop, ngay_tao, row_id) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Xóa nhóm thông báo này sẽ xóa tất cả các bản ghi liên quan và không thể khôi phục!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Chắc chắn xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // SỬA LỖI ĐƯỜNG DẪN: Đường dẫn phải tính từ file admin.php
                fetch('./modules/teacher/teacher_delete_notification.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        tieu_de: tieu_de,
                        id_lop: id_lop,
                        ngay_tao: ngay_tao
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Đã xóa!', data.message, 'success');
                        const row = document.getElementById(`notification-row-${row_id}`);
                        if (row) {
                            row.remove();
                        }
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ để xóa.', 'error');
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let editor;
        const addNotificationModal = new bootstrap.Modal(document.getElementById('addNotificationModal'));
        
        document.getElementById('addNotificationModal').addEventListener('shown.bs.modal', function () {
            if (CKEDITOR.instances.noi_dung_editor_teacher) {
                CKEDITOR.instances.noi_dung_editor_teacher.destroy(true);
            }
            CKEDITOR.replace('noi_dung_editor_teacher', { height: 250 });
            editor = CKEDITOR.instances.noi_dung_editor_teacher;
        });

        const form = document.getElementById('sendNotificationForm_teacher');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (editor) {
                editor.updateElement();
            }

            const formData = new FormData(this);

            // SỬA LỖI ĐƯỜNG DẪN: Đường dẫn phải tính từ file admin.php
            fetch('./modules/thongbao/delete_notification.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    addNotificationModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã gửi!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Lỗi!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ để gửi.', 'error');
            });
        });
    });
</script>