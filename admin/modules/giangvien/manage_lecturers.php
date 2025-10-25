<?php
// Pagination variables
$lecturers_per_page = 15;
$current_page = isset($_GET['lecturer_page']) ? max(1, intval($_GET['lecturer_page'])) : 1;
$offset = ($current_page - 1) * $lecturers_per_page;

// Search term handling
$search_term = $_POST['search'] ?? $_GET['search'] ?? '';
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    $search_param = "%" . $conn->real_escape_string($search_term) . "%";
    $sql_search = " WHERE ten_giangvien LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

// Count total lecturers
$sql_count = "SELECT COUNT(*) as total FROM giangvien" . $sql_search;
$stmt_count = $conn->prepare($sql_count);
if (!empty($search_term)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_lecturers = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_lecturers / $lecturers_per_page);

// Main query with pagination
$sql = "SELECT * FROM giangvien" . $sql_search . " ORDER BY id_giangvien DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if (!empty($search_term)) {
    $params[] = $lecturers_per_page;
    $params[] = $offset;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $lecturers_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .description-cell { max-width: 350px; }
    .description-truncate { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }
    .actions-cell { white-space: nowrap; min-width: 180px; }

    /* Lecturer Pagination Styles */
    .lecturer-pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .lecturer-pagination {
        display: flex;
        gap: 6px;
        align-items: center;
        background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
        padding: 6px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
    }

    .lecturer-pagination-btn {
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

    .lecturer-pagination-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-1px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .lecturer-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .lecturer-pagination-number {
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

    .lecturer-pagination-number:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-1px) scale(1.05);
    }

    .lecturer-pagination-number.active {
        background: white;
        color: #0db33b;
        transform: scale(1.08);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        border-color: white;
    }

    .lecturer-pagination-dots {
        color: white;
        padding: 0 4px;
        font-weight: bold;
        opacity: 0.6;
    }

    .lecturer-pagination-info {
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
        .lecturer-pagination-container {
            justify-content: center;
        }
        
        .lecturer-pagination-btn .btn-text {
            display: none;
        }
        
        .lecturer-pagination-btn {
            padding: 6px 10px;
        }
        
        .lecturer-pagination-info {
            order: -1;
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .lecturer-pagination-number {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
        
        .lecturer-pagination-btn {
            padding: 5px 8px;
        }
    }
</style>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-chalkboard-user me-2"></i>Quản lý Giảng viên</h4>
            <div class="d-flex">
                <form method="POST" action="./admin.php?nav=lecturers" class="d-flex me-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm giảng viên..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <a href="modules/giangvien/export_lecturers.php" class="btn btn-info text-white me-2">
                    <i class="fa-solid fa-file-excel"></i> Xuất Excel
                </a>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLecturerModal"><i class="fa-solid fa-plus"></i> Thêm Giảng viên</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>ID</th><th  class="text-center">Hình ảnh</th><th>Tên giảng viên</th><th>Email</th><th>Số điện thoại</th><th>Mô tả</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0):
                        $index = 0;
                        while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr id="lecturer-row-<?php echo $row['id_giangvien']; ?>" class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                            <td><?php echo $row['id_giangvien']; ?></td>
                            <td><img src="../<?php echo !empty($row['hinh_anh']) ? htmlspecialchars($row['hinh_anh']) : 'images/default-avatar.png'; ?>" alt="avatar" class="rounded-circle" width="50" height="50" style="object-fit: cover;"></td>
                            <td><?php echo htmlspecialchars($row['ten_giangvien']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                            
                            <td class="description-cell" title="<?php echo htmlspecialchars($row['mo_ta']); ?>">
                                <div class="description-truncate">
                                    <?php echo htmlspecialchars($row['mo_ta']); ?>
                                </div>
                            </td>

                            <td class="text-center actions-cell">
                                <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $row['id_giangvien']; ?>)"><i class="fa-solid fa-pen-to-square"></i> Sửa</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteLecturer(<?php echo $row['id_giangvien']; ?>)"><i class="fa-solid fa-trash"></i> Xóa</button>
                            </td>
                        </tr>
                    <?php 
                        $index++;
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fa-solid fa-chalkboard-user fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">
                                    <?php 
                                    if (!empty($search_term)) {
                                        echo 'Không tìm thấy giảng viên nào với từ khóa: <strong>' . htmlspecialchars($search_term) . '</strong>';
                                    } else {
                                        echo 'Chưa có giảng viên nào trong hệ thống';
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
        <div class="lecturer-pagination-container">
            <div class="lecturer-pagination">
                <?php
                $search_query = !empty($search_term) ? '&search=' . urlencode($search_term) : '';
                
                // Previous button
                if ($current_page > 1):
                    $prev_link = "./admin.php?nav=lecturers&lecturer_page=" . ($current_page - 1) . $search_query;
                ?>
                    <a href="<?php echo $prev_link; ?>" class="lecturer-pagination-btn">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="btn-text">Trước</span>
                    </a>
                <?php else: ?>
                    <span class="lecturer-pagination-btn disabled">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="btn-text">Trước</span>
                    </span>
                <?php endif; ?>

                <!-- Page numbers -->
                <?php
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);

                if ($start_page > 1):
                    $first_link = "./admin.php?nav=lecturers&lecturer_page=1" . $search_query;
                ?>
                    <a href="<?php echo $first_link; ?>" class="lecturer-pagination-number">1</a>
                    <?php if ($start_page > 2): ?>
                        <span class="lecturer-pagination-dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <?php
                    $page_link = "./admin.php?nav=lecturers&lecturer_page=" . $i . $search_query;
                    $active_class = ($i == $current_page) ? ' active' : '';
                    ?>
                    <a href="<?php echo $page_link; ?>" class="lecturer-pagination-number<?php echo $active_class; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                    <?php if ($end_page < $total_pages - 1): ?>
                        <span class="lecturer-pagination-dots">...</span>
                    <?php endif; ?>
                    <?php $last_link = "./admin.php?nav=lecturers&lecturer_page=" . $total_pages . $search_query; ?>
                    <a href="<?php echo $last_link; ?>" class="lecturer-pagination-number"><?php echo $total_pages; ?></a>
                <?php endif; ?>

                <!-- Next button -->
                <?php if ($current_page < $total_pages):
                    $next_link = "./admin.php?nav=lecturers&lecturer_page=" . ($current_page + 1) . $search_query;
                ?>
                    <a href="<?php echo $next_link; ?>" class="lecturer-pagination-btn">
                        <span class="btn-text">Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <span class="lecturer-pagination-btn disabled">
                        <span class="btn-text">Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Pagination info -->
            <div class="lecturer-pagination-info">
                <?php
                $start_item = $offset + 1;
                $end_item = min($offset + $lecturers_per_page, $total_lecturers);
                ?>
                Hiển thị <?php echo $start_item; ?>-<?php echo $end_item; ?> / <?php echo $total_lecturers; ?> giảng viên
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="addLecturerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-user-plus me-2"></i>Thêm Giảng viên mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addLecturerForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="text" class="form-control" name="ten_giangvien" placeholder="Tên giảng viên" required><label>Tên giảng viên *</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="email" class="form-control" name="email" placeholder="Email" required><label>Email *</label></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="tel" class="form-control" name="so_dien_thoai" placeholder="Số điện thoại"><label>Số điện thoại</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="password" class="form-control" name="mat_khau" placeholder="Mật khẩu" required><label>Mật khẩu *</label></div></div>
                    </div>
                    <div class="mb-3"><div class="form-floating"><textarea class="form-control" name="mo_ta" placeholder="Mô tả" style="height: 100px"></textarea><label>Mô tả chuyên môn</label></div></div>
                    <div class="mb-3"><label class="form-label">Hình ảnh đại diện</label><input type="file" class="form-control" name="hinh_anh" accept="image/*"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editLecturerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-user-pen me-2"></i>Chỉnh sửa thông tin Giảng viên</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="editLecturerForm" enctype="multipart/form-data">
                <input type="hidden" id="editLecturerId" name="id_giangvien">
                <input type="hidden" id="editCurrentImage" name="hinh_anh_hien_tai">
                <div class="modal-body">
                     <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="text" id="editTenGiangVien" class="form-control" name="ten_giangvien" placeholder="Tên giảng viên" required><label>Tên giảng viên *</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="email" id="editEmail" class="form-control" name="email" placeholder="Email" required><label>Email *</label></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="tel" id="editSoDienThoai" class="form-control" name="so_dien_thoai" placeholder="Số điện thoại"><label>Số điện thoại</label></div></div>
                        <div class="col-md-6 mb-3"><div class="form-floating"><input type="password" class="form-control" name="mat_khau" placeholder="Mật khẩu mới"><label>Mật khẩu mới (để trống nếu không đổi)</label></div></div>
                    </div>
                    <div class="mb-3"><div class="form-floating"><textarea id="editMoTa" class="form-control" name="mo_ta" placeholder="Mô tả" style="height: 100px"></textarea><label>Mô tả chuyên môn</label></div></div>
                    <div class="mb-3"><label class="form-label">Tải ảnh đại diện mới</label><input type="file" class="form-control" name="hinh_anh" accept="image/*"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteLecturerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white"><h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i> Xác nhận xóa</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa giảng viên này? Hành động này không thể khôi phục. Các khóa học và lớp học do giảng viên này phụ trách sẽ được cập nhật thành "Chưa phân công".
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteLecturerBtn">Xác nhận xóa</button>
      </div>
    </div>
  </div>
</div>

<script>
let addLecturerModal, editLecturerModal, confirmDeleteLecturerModal;
let lecturerIdToDelete = null;

// Hàm mở modal Sửa
async function openEditModal(lecturerId) {
    try {
        const response = await fetch(`./modules/giangvien/get_lecturer_info.php?id=${lecturerId}`);
        const data = await response.json();
        if (data.error) {
            Swal.fire('Lỗi!', data.error, 'error');
            return;
        }
        document.getElementById('editLecturerId').value = data.id_giangvien;
        document.getElementById('editTenGiangVien').value = data.ten_giangvien;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editSoDienThoai').value = data.so_dien_thoai;
        document.getElementById('editMoTa').value = data.mo_ta;
        document.getElementById('editCurrentImage').value = data.hinh_anh;
        editLecturerModal.show();
    } catch (error) {
        Swal.fire('Lỗi!', 'Không thể lấy dữ liệu giảng viên.', 'error');
    }
}

// Hàm mở modal Xóa
function deleteLecturer(lecturerId) {
    lecturerIdToDelete = lecturerId;
    confirmDeleteLecturerModal.show();
}

document.addEventListener("DOMContentLoaded", function() {
    addLecturerModal = new bootstrap.Modal(document.getElementById('addLecturerModal'));
    editLecturerModal = new bootstrap.Modal(document.getElementById('editLecturerModal'));
    confirmDeleteLecturerModal = new bootstrap.Modal(document.getElementById('confirmDeleteLecturerModal'));

    // Xử lý submit form THÊM
    document.getElementById('addLecturerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('./modules/giangvien/add_lecturer.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                addLecturerModal.hide();
                Swal.fire({ icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else {
                Swal.fire('Lỗi!', data.message, 'error');
            }
        });
    });

    // Xử lý submit form SỬA
    document.getElementById('editLecturerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('./modules/giangvien/edit_lecturer.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                editLecturerModal.hide();
                Swal.fire({ icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else {
                Swal.fire('Lỗi!', data.message, 'error');
            }
        });
    });

    // Xử lý nút xác nhận XÓA
    document.getElementById('confirmDeleteLecturerBtn').addEventListener('click', function() {
        if (lecturerIdToDelete) {
            this.disabled = true;
            this.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Đang xóa...`;
            
            fetch(`./modules/giangvien/delete_lecturer.php`, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `delete_id=${lecturerIdToDelete}`
            })
            .then(response => response.json())
            .then(data => {
                confirmDeleteLecturerModal.hide();
                if (data.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Đã xóa!', text: data.message, timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
                } else {
                    Swal.fire('Lỗi!', data.message, 'error');
                }
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = 'Xác nhận xóa';
                lecturerIdToDelete = null;
            });
        }
    });

    // Smooth scroll for pagination
    document.querySelectorAll('.lecturer-pagination-number, .lecturer-pagination-btn').forEach(link => {
        link.addEventListener('click', function(e) {
            const container = document.querySelector('.card.animated-card');
            if (container) {
                setTimeout(() => {
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        });
    });
});
</script>