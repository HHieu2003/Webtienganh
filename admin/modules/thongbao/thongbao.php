<?php
// Pagination variables
$notifications_per_page = 15;
$current_page = isset($_GET['notif_page']) ? max(1, intval($_GET['notif_page'])) : 1;
$offset = ($current_page - 1) * $notifications_per_page;

// --- LẤY DỮ LIỆU CHO BỘ LỌC VÀ FORM ---
$courses_for_filter = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$classes_for_filter = $conn->query("SELECT id_lop, ten_lop FROM lop_hoc ORDER BY ten_lop");
// Clone result for modal form to avoid seeking data pointer
$classes_for_modal = $conn->query("SELECT id_lop, ten_lop FROM lop_hoc ORDER BY ten_lop");

// --- XỬ LÝ LỌC VÀ TÌM KIẾM ---
$search_term = $_GET['search'] ?? '';
$filter_course = $_GET['filter_course'] ?? 'all';
$filter_class = $_GET['filter_class'] ?? 'all';

// Count query
$sql_count = "
    SELECT COUNT(DISTINCT CONCAT(tb.tieu_de, '_', tb.noi_dung, '_', IFNULL(tb.id_khoahoc, ''), '_', IFNULL(tb.id_lop, ''), '_', tb.ngay_tao)) as total
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
    $sql_count .= " WHERE " . implode(" AND ", $conditions);
}

$stmt_count = $conn->prepare($sql_count);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_notifications = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_notifications / $notifications_per_page);

// Main query with pagination
$sql_notifications = "
    SELECT 
        tb.tieu_de, tb.noi_dung, tb.id_khoahoc, tb.id_lop,
        kh.ten_khoahoc, lh.ten_lop, tb.ngay_tao
    FROM thongbao tb
    LEFT JOIN khoahoc kh ON tb.id_khoahoc = kh.id_khoahoc
    LEFT JOIN lop_hoc lh ON tb.id_lop = lh.id_lop
";

if (!empty($conditions)) {
    $sql_notifications .= " WHERE " . implode(" AND ", $conditions);
}

$sql_notifications .= " GROUP BY tb.tieu_de, tb.noi_dung, tb.id_khoahoc, tb.id_lop, kh.ten_khoahoc, lh.ten_lop, tb.ngay_tao
                        ORDER BY tb.ngay_tao DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql_notifications);
$params[] = $notifications_per_page;
$params[] = $offset;
$types .= "ii";
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
                            <td colspan="5" class="text-center py-4">
                                <i class="fa-solid fa-bell-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">
                                    <?php
                                    if (!empty($search_term) || $filter_course !== 'all' || $filter_class !== 'all') {
                                        echo 'Không tìm thấy thông báo nào phù hợp với bộ lọc';
                                    } else {
                                        echo 'Chưa có thông báo nào trong hệ thống';
                                    }
                                    ?>
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($total_pages > 1): ?>
        <!-- Pagination -->
        <div class="notification-pagination-container">
            <div class="notification-pagination">
                <?php
                $query_params = [];
                if (!empty($search_term)) $query_params[] = 'search=' . urlencode($search_term);
                if ($filter_course !== 'all') $query_params[] = 'filter_course=' . urlencode($filter_course);
                if ($filter_class !== 'all') $query_params[] = 'filter_class=' . urlencode($filter_class);
                $query_string = !empty($query_params) ? '&' . implode('&', $query_params) : '';
                
                // Previous button
                if ($current_page > 1):
                    $prev_link = "./admin.php?nav=thongbao&notif_page=" . ($current_page - 1) . $query_string;
                ?>
                    <a href="<?php echo $prev_link; ?>" class="notification-pagination-btn">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="btn-text">Trước</span>
                    </a>
                <?php else: ?>
                    <span class="notification-pagination-btn disabled">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="btn-text">Trước</span>
                    </span>
                <?php endif; ?>

                <!-- Page numbers -->
                <?php
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);

                if ($start_page > 1):
                    $first_link = "./admin.php?nav=thongbao&notif_page=1" . $query_string;
                ?>
                    <a href="<?php echo $first_link; ?>" class="notification-pagination-number">1</a>
                    <?php if ($start_page > 2): ?>
                        <span class="notification-pagination-dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <?php
                    $page_link = "./admin.php?nav=thongbao&notif_page=" . $i . $query_string;
                    $active_class = ($i == $current_page) ? ' active' : '';
                    ?>
                    <a href="<?php echo $page_link; ?>" class="notification-pagination-number<?php echo $active_class; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                    <?php if ($end_page < $total_pages - 1): ?>
                        <span class="notification-pagination-dots">...</span>
                    <?php endif; ?>
                    <?php $last_link = "./admin.php?nav=thongbao&notif_page=" . $total_pages . $query_string; ?>
                    <a href="<?php echo $last_link; ?>" class="notification-pagination-number"><?php echo $total_pages; ?></a>
                <?php endif; ?>

                <!-- Next button -->
                <?php if ($current_page < $total_pages):
                    $next_link = "./admin.php?nav=thongbao&notif_page=" . ($current_page + 1) . $query_string;
                ?>
                    <a href="<?php echo $next_link; ?>" class="notification-pagination-btn">
                        <span class="btn-text">Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <span class="notification-pagination-btn disabled">
                        <span class="btn-text">Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Pagination info -->
            <div class="notification-pagination-info">
                <?php
                $start_item = $offset + 1;
                $end_item = min($offset + $notifications_per_page, $total_notifications);
                ?>
                Hiển thị <?php echo $start_item; ?>-<?php echo $end_item; ?> / <?php echo $total_notifications; ?> thông báo
            </div>
        </div>
        <?php endif; ?>
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
    
    // Smooth scroll for pagination
    document.querySelectorAll('.notification-pagination-number, .notification-pagination-btn').forEach(link => {
        link.addEventListener('click', function(e) {
            const container = document.querySelector('.card.animated-card');
            if (container) {
                setTimeout(() => {
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        });
    });
</script>

<style>
/* Notification Pagination Styles */
.notification-pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.notification-pagination {
    display: flex;
    gap: 6px;
    align-items: center;
    background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
    padding: 6px 12px;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
}

.notification-pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 9px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
}

.notification-pagination-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-1px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.notification-pagination-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.notification-pagination-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    text-decoration: none;
    border-radius: 50%;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.notification-pagination-number:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-1px) scale(1.05);
}

.notification-pagination-number.active {
    background: white;
    color: #0db33b;
    transform: scale(1.08);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    border-color: white;
}

.notification-pagination-dots {
    color: white;
    padding: 0 4px;
    font-weight: bold;
    opacity: 0.6;
}

.notification-pagination-info {
    background: var(--brand-color-light, #e7f7ec);
    color: var(--brand-color, #0db33b);
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(13, 179, 59, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .notification-pagination-container {
        justify-content: center;
    }
    
    .notification-pagination-btn .btn-text {
        display: none;
    }
    
    .notification-pagination-btn {
        padding: 6px 10px;
    }
    
    .notification-pagination-info {
        order: -1;
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .notification-pagination-number {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
    
    .notification-pagination-btn {
        padding: 5px 8px;
    }
}
</style>