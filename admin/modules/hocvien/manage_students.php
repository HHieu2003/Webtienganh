<?php
// Pagination variables
$students_per_page = 15;
$current_page = isset($_GET['student_page']) ? max(1, intval($_GET['student_page'])) : 1;
$offset = ($current_page - 1) * $students_per_page;

// Search term handling
$search_term = $_POST['search'] ?? $_GET['search'] ?? '';
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    $search_param = "%" . $conn->real_escape_string($search_term) . "%";
    $sql_search = " WHERE ten_hocvien LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

// Count total students
$sql_count = "SELECT COUNT(*) as total FROM hocvien" . $sql_search;
$stmt_count = $conn->prepare($sql_count);
if (!empty($search_term)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_students = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_students / $students_per_page);

// Main query with pagination
$sql = "SELECT id_hocvien, ten_hocvien, email, so_dien_thoai, is_admin, trinh_do, is_verified FROM hocvien" . $sql_search . " ORDER BY id_hocvien DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if (!empty($search_term)) {
    $params[] = $students_per_page;
    $params[] = $offset;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $students_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fa-solid fa-users me-2"></i>Quản lý Học viên
            </h4>
            <div class="d-flex">
                <form method="POST" action="./admin.php?nav=students" class="d-flex me-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm học viên..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <a href="modules/hocvien/export_students.php" class="btn btn-info text-white me-2">
                    <i class="fa-solid fa-file-excel"></i> Xuất Excel
                </a>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fa-solid fa-plus"></i> Thêm Học viên
                </button>
            </div>
        </div>
    </div>
    <div class="card-body text-center">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên học viên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Trình độ</th>
                        <th class="text-center">Xác minh</th>
                        <th class="text-center">Admin</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0):
                        $index = 0;
                        while ($row = $result->fetch_assoc()):
                    ?>
                            <tr id="student-row-<?php echo $row['id_hocvien']; ?>" class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                                <td><?php echo htmlspecialchars($row['id_hocvien']); ?></td>
                                <td><?php echo htmlspecialchars($row['ten_hocvien']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                                <td><?php echo htmlspecialchars($row['trinh_do'] ?? 'Chưa có'); ?></td>
                                <td class="text-center">
                                    <?php if ($row['is_verified']): ?>
                                        <span class="badge bg-success">
                                            <i class="fa-solid fa-circle-check"></i> Đã xác minh
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fa-solid fa-circle-exclamation"></i> Chưa xác minh
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['is_admin']): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm mb-1" onclick="openEditModal(<?php echo $row['id_hocvien']; ?>)">
                                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteStudent(<?php echo $row['id_hocvien']; ?>)">
                                        <i class="fa-solid fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        <?php
                            $index++;
                        endwhile;
                    else:
                        ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fa-solid fa-users-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">
                                    <?php
                                    if (!empty($search_term)) {
                                        echo 'Không tìm thấy học viên nào với từ khóa: <strong>' . htmlspecialchars($search_term) . '</strong>';
                                    } else {
                                        echo 'Chưa có học viên nào trong hệ thống';
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
            <div class="student-pagination-container">
                <div class="student-pagination">
                    <?php
                    $search_query = !empty($search_term) ? '&search=' . urlencode($search_term) : '';

                    // Previous button
                    if ($current_page > 1):
                        $prev_link = "./admin.php?nav=students&student_page=" . ($current_page - 1) . $search_query;
                    ?>
                        <a href="<?php echo $prev_link; ?>" class="student-pagination-btn">
                            <i class="fa-solid fa-chevron-left"></i>
                            <span class="btn-text">Trước</span>
                        </a>
                    <?php else: ?>
                        <span class="student-pagination-btn disabled">
                            <i class="fa-solid fa-chevron-left"></i>
                            <span class="btn-text">Trước</span>
                        </span>
                    <?php endif; ?>

                    <!-- Page numbers -->
                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);

                    if ($start_page > 1):
                        $first_link = "./admin.php?nav=students&student_page=1" . $search_query;
                    ?>
                        <a href="<?php echo $first_link; ?>" class="student-pagination-number">1</a>
                        <?php if ($start_page > 2): ?>
                            <span class="student-pagination-dots">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <?php
                        $page_link = "./admin.php?nav=students&student_page=" . $i . $search_query;
                        $active_class = ($i == $current_page) ? ' active' : '';
                        ?>
                        <a href="<?php echo $page_link; ?>" class="student-pagination-number<?php echo $active_class; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($end_page < $total_pages): ?>
                        <?php if ($end_page < $total_pages - 1): ?>
                            <span class="student-pagination-dots">...</span>
                        <?php endif; ?>
                        <?php $last_link = "./admin.php?nav=students&student_page=" . $total_pages . $search_query; ?>
                        <a href="<?php echo $last_link; ?>" class="student-pagination-number"><?php echo $total_pages; ?></a>
                    <?php endif; ?>

                    <!-- Next button -->
                    <?php if ($current_page < $total_pages):
                        $next_link = "./admin.php?nav=students&student_page=" . ($current_page + 1) . $search_query;
                    ?>
                        <a href="<?php echo $next_link; ?>" class="student-pagination-btn">
                            <span class="btn-text">Sau</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="student-pagination-btn disabled">
                            <span class="btn-text">Sau</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Pagination info -->
                <div class="student-pagination-info">
                    <?php
                    $start_item = $offset + 1;
                    $end_item = min($offset + $students_per_page, $total_students);
                    ?>
                    Hiển thị <?php echo $start_item; ?>-<?php echo $end_item; ?> / <?php echo $total_students; ?> học viên
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Student Pagination Styles */
    .student-pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .student-pagination {
        display: flex;
        gap: 6px;
        align-items: center;
        background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
        padding: 6px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
    }

    .student-pagination-btn {
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

    .student-pagination-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-1px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .student-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .student-pagination-number {
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

    .student-pagination-number:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-1px) scale(1.05);
    }

    .student-pagination-number.active {
        background: white;
        color: #0db33b;
        transform: scale(1.08);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        border-color: white;
    }

    .student-pagination-dots {
        color: white;
        padding: 0 4px;
        font-weight: bold;
        opacity: 0.6;
    }

    .student-pagination-info {
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
        .student-pagination-container {
            justify-content: center;
        }

        .student-pagination-btn .btn-text {
            display: none;
        }

        .student-pagination-btn {
            padding: 6px 10px;
        }

        .student-pagination-info {
            order: -1;
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .student-pagination-number {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }

        .student-pagination-btn {
            padding: 5px 8px;
        }
    }
</style>

<div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user-plus me-2"></i>Thêm Học Viên Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addStudentForm">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ten_hocvien" name="ten_hocvien" placeholder="Tên học viên" required>
                            <label for="ten_hocvien">Tên học viên</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Số điện thoại">
                            <label for="so_dien_thoai">Số điện thoại</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="mat_khau" name="mat_khau" placeholder="Mật khẩu" required>
                            <label for="mat_khau">Mật khẩu</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user-pen me-2"></i>Chỉnh sửa Học Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editStudentForm">
                <div class="modal-body">
                    <input type="hidden" id="editStudentId" name="id_hocvien" />
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="editStudentName" name="ten_hocvien" placeholder="Tên học viên" required>
                            <label for="editStudentName">Tên học viên</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="editStudentEmail" name="email" placeholder="Email" required>
                            <label for="editStudentEmail">Email</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="editStudentPhone" name="so_dien_thoai" placeholder="Số điện thoại">
                            <label for="editStudentPhone">Số điện thoại</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="editStudentPassword" name="mat_khau" placeholder="Mật khẩu mới">
                            <label for="editStudentPassword">Mật khẩu mới (để trống nếu không đổi)</label>
                        </div>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="editIsVerified" name="is_verified" value="1">
                        <label class="form-check-label" for="editIsVerified">
                            <i class="fa-solid fa-circle-check text-success"></i> Đã xác minh email
                        </label>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="editIsAdmin" name="is_admin" value="1">
                        <label class="form-check-label" for="editIsAdmin">Là Quản trị viên</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8d7da; color: #721c24;">
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="fa-solid fa-triangle-exclamation"></i> Xác nhận hành động
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa vĩnh viễn học viên này? Mọi dữ liệu liên quan sẽ bị xóa và **không thể khôi phục**.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <span id="delete-btn-text">Xác nhận xóa</span>
                    <span id="delete-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    // Biến toàn cục để khởi tạo các modal
    let addStudentModal, editStudentModal, confirmDeleteModal;
    let studentIdToDelete = null;

    // Hàm mở modal Sửa
    function openEditModal(studentId) {
        fetch(`./modules/hocvien/get_student_info.php?id=${studentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Lỗi!', data.error, 'error');
                    return;
                }
                // Điền dữ liệu vào form sửa
                document.getElementById('editStudentId').value = data.id_hocvien;
                document.getElementById('editStudentName').value = data.ten_hocvien;
                document.getElementById('editStudentPhone').value = data.so_dien_thoai;
                document.getElementById('editStudentEmail').value = data.email;
                document.getElementById('editIsVerified').checked = (data.is_verified == 1);
                document.getElementById('editIsAdmin').checked = (data.is_admin == 1);
                document.getElementById('editStudentPassword').value = "";
                editStudentModal.show();
            })
            .catch(error => {
                console.error('Lỗi khi lấy thông tin học viên:', error);
                Swal.fire('Lỗi!', 'Không thể lấy dữ liệu học viên.', 'error');
            });
    }

    // Hàm mở modal Xóa
    function deleteStudent(studentId) {
        studentIdToDelete = studentId;
        confirmDeleteModal.show();
    }

    // Chạy mã sau khi toàn bộ trang đã tải
    document.addEventListener("DOMContentLoaded", function() {

        // Khởi tạo tất cả các đối tượng modal
        addStudentModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
        editStudentModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
        confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

        const addStudentForm = document.getElementById('addStudentForm');
        const editStudentForm = document.getElementById('editStudentForm');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Xử lý sự kiện submit form THÊM
        addStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('./modules/hocvien/add_student.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        addStudentModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Tải lại trang để cập nhật danh sách
                        });
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                });
        });

        // Xử lý sự kiện submit form SỬA
        editStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('./modules/hocvien/edit_student.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        editStudentModal.hide();
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
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                });
        });

        // Xử lý sự kiện click nút "Xác nhận xóa"
        confirmDeleteBtn.addEventListener('click', function() {
            if (studentIdToDelete) {
                const deleteBtnText = document.getElementById('delete-btn-text');
                const deleteSpinner = document.getElementById('delete-spinner');

                // Hiển thị trạng thái đang xóa
                deleteBtnText.textContent = 'Đang xóa...';
                deleteSpinner.style.display = 'inline-block';
                this.disabled = true;

                fetch(`./modules/hocvien/delete_student.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `delete_id=${studentIdToDelete}`
                    })
                    .then(response => response.text())
                    .then(result => {
                        confirmDeleteModal.hide();
                        if (result.trim() === "Xóa thành công") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã xóa!',
                                text: 'Học viên đã được xóa khỏi hệ thống.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Lỗi!', result, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                    })
                    .finally(() => {
                        // Khôi phục nút sau khi xử lý
                        setTimeout(() => {
                            deleteBtnText.textContent = 'Xác nhận xóa';
                            deleteSpinner.style.display = 'none';
                            this.disabled = false;
                            studentIdToDelete = null;
                        }, 500);
                    });
            }
        });

        // Smooth scroll for pagination
        document.querySelectorAll('.student-pagination-number, .student-pagination-btn').forEach(link => {
            link.addEventListener('click', function(e) {
                const container = document.querySelector('.card.animated-card');
                if (container) {
                    setTimeout(() => {
                        container.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            });
        });
    });
</script>