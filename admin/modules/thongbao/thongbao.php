<?php
// --- LẤY DỮ LIỆU CHO BỘ LỌC VÀ FORM ---
$courses_for_filter = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$classes_for_filter = $conn->query("SELECT id_lop, ten_lop FROM lop_hoc ORDER BY ten_lop");
// Clone result for modal form to avoid seeking data pointer
$classes_for_modal = $conn->query("SELECT id_lop, ten_lop FROM lop_hoc ORDER BY ten_lop");

// --- XỬ LÝ LỌC VÀ TÌM KIẾM ---
$search_term = $_GET['search'] ?? '';
$filter_course = $_GET['filter_course'] ?? 'all';
$filter_class = $_GET['filter_class'] ?? 'all';

$sql_notifications = "
    SELECT 
        tb.tieu_de, tb.noi_dung, tb.id_khoahoc, tb.id_lop,
        kh.ten_khoahoc, lh.ten_lop, tb.ngay_tao
    FROM thongbao tb
    LEFT JOIN khoahoc kh ON tb.id_khoahoc = kh.id_khoahoc
    LEFT JOIN lop_hoc lh ON tb.id_lop = lh.id_lop
";

$conditions = [];
$params = [];
$types = "";

if (!empty($search_term)) {
    $conditions[] = "(tb.tieu_de LIKE ? OR tb.noi_dung LIKE ?)";
    $search_param = "%" . $search_term . "%";
    array_push($params, $search_param, $search_param);
    $types .= "ss";
}

if ($filter_class !== 'all') {
    $conditions[] = "tb.id_lop = ?";
    $params[] = $filter_class;
    $types .= "s";
} elseif ($filter_course !== 'all') {
    if ($filter_course === 'to_all_students') {
        $conditions[] = "tb.id_khoahoc IS NULL AND tb.id_lop IS NULL";
    } else {
        $conditions[] = "tb.id_khoahoc = ? AND tb.id_lop IS NULL";
        $params[] = (int)$filter_course;
        $types .= "i";
    }
}

if (!empty($conditions)) {
    $sql_notifications .= " WHERE " . implode(" AND ", $conditions);
}

$sql_notifications .= " GROUP BY tb.tieu_de, tb.noi_dung, tb.id_khoahoc, tb.id_lop, kh.ten_khoahoc, lh.ten_lop, tb.ngay_tao
                        ORDER BY tb.ngay_tao DESC";

$stmt = $conn->prepare($sql_notifications);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result_notifications = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fa-solid fa-bell me-2"></i>Quản lý Thông báo</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="./admin.php" class="mb-4 p-3 bg-light border rounded-3">
            <input type="hidden" name="nav" value="thongbao">
            <div class="row g-3 align-items-end">
                <div class="col-md-4"><label class="form-label">Tìm theo tiêu đề / nội dung</label><input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_term); ?>"></div>
                <div class="col-md-3"><label class="form-label">Lọc theo Khóa học</label><select name="filter_course" class="form-select">
                        <option value="all">-- Tất cả Khóa học --</option>
                        <option value="all" <?php if ($filter_course == 'all') echo 'selected'; ?>>Gửi đến tất cả học viên</option><?php while ($course = $courses_for_filter->fetch_assoc()): ?><option value="<?php echo $course['id_khoahoc']; ?>" <?php if ($filter_course == $course['id_khoahoc']) echo 'selected'; ?>><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endwhile; ?>
                    </select></div>
                <div class="col-md-3"><label class="form-label">Lọc theo Lớp học</label><select name="filter_class" class="form-select">
                        <option value="all">-- Tất cả Lớp học --</option><?php while ($class = $classes_for_filter->fetch_assoc()): ?><option value="<?php echo $class['id_lop']; ?>" <?php if ($filter_class == $class['id_lop']) echo 'selected'; ?>><?php echo htmlspecialchars($class['ten_lop']); ?></option><?php endwhile; ?>
                    </select></div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Lọc</button></div>
            </div>
        </form>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sendNotificationModal"><i class="fa-solid fa-paper-plane"></i> Gửi Thông báo mới</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="    min-width: 100px;">Tiêu đề</th>
                        <th style="width: 35%;">Nội dung</th>
                        <th>Gửi đến</th>
                        <th class="text-center">Ngày gửi</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_notifications->num_rows > 0):
                        $index = 0;
                        while ($row = $result_notifications->fetch_assoc()):
                            if ($row['ten_lop']) {
                                $target = "<span class='badge bg-primary'>Lớp: " . htmlspecialchars($row['ten_lop']) . "</span>";
                            } elseif ($row['ten_khoahoc']) {
                                $target = "<span class='badge bg-info text-dark'>Khóa: " . htmlspecialchars($row['ten_khoahoc']) . "</span>";
                            } else {
                                $target = "<span class='badge bg-secondary'>Tất cả học viên</span>";
                            }
                    ?>
                            <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                                <td><?php echo htmlspecialchars($row['tieu_de']); ?></td>
                                <td><?php echo htmlspecialchars(substr(strip_tags($row['noi_dung']), 0, 150)) . (strlen(strip_tags($row['noi_dung'])) > 150 ? '...' : ''); ?></td>
                                <td><?php echo $target; ?></td>
                                <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_tao'])); ?></td>
                                <td class="text-center">
                                    <button class='btn btn-danger btn-sm' onclick="deleteNotification(this)"
                                        data-tieu-de="<?php echo htmlspecialchars($row['tieu_de']); ?>"
                                        data-id-khoahoc="<?php echo $row['id_khoahoc']; ?>"
                                        data-id-lop="<?php echo $row['id_lop']; ?>"
                                        data-ngay-tao="<?php echo $row['ngay_tao']; ?>">
                                        <i class='fa-solid fa-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Không tìm thấy thông báo nào phù hợp.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="sendNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-paper-plane me-2"></i>Soạn và Gửi Thông báo</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="sendNotificationForm">
                <div class="modal-body">
                    <div class="form-floating mb-3"><input type="text" name="tieu_de" class="form-control" placeholder="Tiêu đề" required><label>Tiêu đề *</label></div>
                    <div class="mb-3"><label class="form-label">Nội dung *</label><textarea name="noi_dung" id="noi_dung_editor" class="form-control"></textarea></div>
                    <hr>
                    <label class="form-label fw-bold">Gửi đến:</label>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating"><select name="id_khoahoc" id="select_id_khoahoc" class="form-select">
                                    <option value="all">Tất cả học viên</option><?php mysqli_data_seek($courses_for_filter, 0);
                                                                                while ($row = $courses_for_filter->fetch_assoc()) {
                                                                                    echo "<option value='" . $row['id_khoahoc'] . "'>" . htmlspecialchars($row['ten_khoahoc']) . "</option>";
                                                                                } ?>
                                </select><label>Khóa học</label></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating"><select name="id_lop" id="select_id_lop" class="form-select">
                                    <option value="all">-- Chọn lớp cụ thể (Ưu tiên) --</option><?php while ($row = $classes_for_modal->fetch_assoc()) {
                                                                                                    echo "<option value='" . $row['id_lop'] . "'>" . htmlspecialchars($row['ten_lop']) . "</option>";
                                                                                                } ?>
                                </select><label>Lớp học</label></div>
                        </div>
                    </div>
                    <div class="form-text">Lưu ý: Nếu bạn chọn Lớp học, thông báo sẽ chỉ được gửi đến học viên trong lớp đó, bỏ qua lựa chọn Khóa học.</div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Gửi đi</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    // Khởi tạo CKEditor
    let editor;
    CKEDITOR.replace('noi_dung_editor', {
        height: 250
    });
    editor = CKEDITOR.instances.noi_dung_editor;

    // Hàm xóa thông báo
    function deleteNotification(button) {
        const tieu_de = button.getAttribute('data-tieu-de');
        const id_khoahoc = button.getAttribute('data-id-khoahoc');
        const id_lop = button.getAttribute('data-id-lop');
        const ngay_tao = button.getAttribute('data-ngay-tao');

        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Xóa nhóm thông báo này sẽ xóa tất cả các bản ghi liên quan. Hành động này không thể khôi phục!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Chắc chắn xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./modules/thongbao/delete_notification.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tieu_de,
                            id_khoahoc,
                            id_lop,
                            ngay_tao
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Đã xóa!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    });
            }
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        const sendNotificationModal = new bootstrap.Modal(document.getElementById('sendNotificationModal'));
        const form = document.getElementById('sendNotificationForm');

        // Logic để đảm bảo chỉ chọn được 1 trong 2 (Khóa học hoặc Lớp)
        const selectKhoaHoc = document.getElementById('select_id_khoahoc');
        const selectLop = document.getElementById('select_id_lop');

        selectLop.addEventListener('change', function() {
            if (this.value !== 'all') {
                selectKhoaHoc.value = 'all';
                selectKhoaHoc.disabled = true;
            } else {
                selectKhoaHoc.disabled = false;
            }
        });

        selectKhoaHoc.addEventListener('change', function() {
            if (this.value !== 'all') {
                selectLop.value = 'all';
                selectLop.disabled = true;
            } else {
                selectLop.disabled = false;
            }
        });

        // Xử lý gửi form
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            editor.updateElement(); // Cập nhật dữ liệu từ CKEditor vào textarea
            const formData = new FormData(this);

            // Kích hoạt lại các select bị vô hiệu hóa để gửi dữ liệu đi
            selectKhoaHoc.disabled = false;
            selectLop.disabled = false;

            fetch('./modules/thongbao/send_notification.php', {
                    method: 'POST',
                    body: new FormData(this) // Gửi form data sau khi đã kích hoạt lại
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        sendNotificationModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                });
        });
    });
</script>