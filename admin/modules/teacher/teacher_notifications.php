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
        MAX(tb.noi_dung) as noi_dung,
        tb.ngay_tao,
        tb.id_lop,
        lh.ten_lop,
        (SELECT COUNT(DISTINCT id_hocvien) FROM thongbao t_count WHERE t_count.id_lop = tb.id_lop AND t_count.tieu_de = tb.tieu_de AND t_count.ngay_tao = tb.ngay_tao) as student_count
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

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animated-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .notification-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .notification-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    .card-header-custom {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title-custom {
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
        color: var(--brand-color-dark);
    }
    .card-body-custom {
        padding: 20px;
        flex-grow: 1;
        font-size: 0.95rem;
        color: #555;
    }
    .card-body-custom .content-preview {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 60px;
    }
    .card-footer-custom {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-color-light);
    }
    .meta-item i {
        color: var(--brand-color);
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="title-color mb-0" style="border:none; padding-bottom: 0;">Quản lý Thông báo</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
            <i class="fa-solid fa-paper-plane me-2"></i> Soạn Thông báo mới
        </button>
    </div>

    <?php if ($history->num_rows > 0): ?>
        <div class="row g-4">
            <?php 
            $index = 0;
            while ($row = $history->fetch_assoc()): 
                $unique_id = md5($row['tieu_de'] . $row['ngay_tao'] . $row['id_lop']);
            ?>
                <div class="col-lg-4 col-md-6 animated-item" style="animation-delay: <?php echo $index++ * 70; ?>ms;" id="notification-card-<?php echo $unique_id; ?>">
                    <div class="notification-card">
                        <div class="card-header-custom">
                            <h5 class="card-title-custom"><?php echo htmlspecialchars($row['tieu_de']); ?></h5>
                            <button class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteNotification(
                                        '<?php echo htmlspecialchars(addslashes($row['tieu_de'])); ?>', 
                                        '<?php echo htmlspecialchars($row['id_lop']); ?>', 
                                        '<?php echo htmlspecialchars($row['ngay_tao']); ?>',
                                        '<?php echo $unique_id; ?>'
                                    )"
                                    title="Xóa nhóm thông báo này">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                        <div class="card-body-custom">
                            <div class="content-preview"><?php echo strip_tags($row['noi_dung']); ?></div>
                        </div>
                        <div class="card-footer-custom">
                            <span class="meta-item"><i class="fa-solid fa-school"></i> <strong><?php echo htmlspecialchars($row['ten_lop']); ?></strong></span>
                            <span class="meta-item"><i class="fa-solid fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-light text-center">
            <i class="fa-solid fa-bell-slash fa-3x mb-3 text-muted"></i>
            <p class="mb-0">Bạn chưa gửi thông báo nào.</p>
        </div>
    <?php endif; ?>
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
                    <div class="row g-3">
                        <div class="col-md-7">
                            <div class="form-floating">
                                <input type="text" name="tieu_de" class="form-control" placeholder="Tiêu đề thông báo" required>
                                <label>Tiêu đề *</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select name="id_lop" class="form-select" required>
                                    <option value="" selected disabled>-- Vui lòng chọn lớp --</option>
                                    <?php if ($my_classes->num_rows > 0): mysqli_data_seek($my_classes, 0); while($class = $my_classes->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($class['id_lop']); ?>"><?php echo htmlspecialchars($class['ten_lop']); ?></option>
                                    <?php endwhile; else: ?><option disabled>Bạn chưa có lớp học nào đang hoạt động</option><?php endif; ?>
                                </select>
                                <label>Gửi đến lớp *</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Nội dung thông báo *</label>
                        <textarea name="noi_dung" id="noi_dung_editor_teacher" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="submit-notification-btn" <?php if($my_classes->num_rows == 0) echo 'disabled'; ?>>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Gửi đi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteNotification(tieu_de, id_lop, ngay_tao, card_id) {
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
                fetch('./modules/teacher/teacher_delete_notification.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tieu_de, id_lop, ngay_tao })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Đã xóa!', data.message, 'success');
                        const card = document.getElementById(`notification-card-${card_id}`);
                        if (card) {
                            card.remove();
                        }
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                })
                .catch(error => Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error'));
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let editor;
        const addNotificationModal = new bootstrap.Modal(document.getElementById('addNotificationModal'));
        const form = document.getElementById('sendNotificationForm_teacher');
        const submitBtn = document.getElementById('submit-notification-btn');
        const spinner = submitBtn.querySelector('.spinner-border');
        
        document.getElementById('addNotificationModal').addEventListener('shown.bs.modal', function () {
            if (CKEDITOR.instances.noi_dung_editor_teacher) {
                CKEDITOR.instances.noi_dung_editor_teacher.destroy(true);
            }
            CKEDITOR.replace('noi_dung_editor_teacher', { height: 250 });
            editor = CKEDITOR.instances.noi_dung_editor_teacher;
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (editor) editor.updateElement();
            
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');

            const formData = new FormData(this);

            fetch('./modules/teacher/teacher_send_notification.php', {
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
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Lỗi!', data.message, 'error');
                }
            })
            .catch(error => Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error'))
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            });
        });
    });
</script>