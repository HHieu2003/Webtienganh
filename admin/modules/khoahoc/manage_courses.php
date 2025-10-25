<?php
// Pagination variables
$courses_per_page = 10;
$current_page = isset($_GET['course_page']) ? max(1, intval($_GET['course_page'])) : 1;
$offset = ($current_page - 1) * $courses_per_page;

// Xử lý tìm kiếm và lọc
$search_term = $_POST['search'] ?? $_GET['search'] ?? '';
$filter_level = $_GET['filter_level'] ?? '';

$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term) && !empty($filter_level)) {
    // Cả tìm kiếm và lọc
    $sql_search = " WHERE (ten_khoahoc LIKE ? OR cap_do LIKE ?) AND cap_do = ?";
    $search_param = "%" . $search_term . "%";
    $params = [$search_param, $search_param, $filter_level];
    $types = "sss";
} elseif (!empty($search_term)) {
    // Chỉ tìm kiếm
    $sql_search = " WHERE ten_khoahoc LIKE ? OR cap_do LIKE ?";
    $search_param = "%" . $search_term . "%";
    $params = [$search_param, $search_param];
    $types = "ss";
} elseif (!empty($filter_level)) {
    // Chỉ lọc
    $sql_search = " WHERE cap_do = ?";
    $params = [$filter_level];
    $types = "s";
}

// Get all distinct levels for filter
$sql_levels = "SELECT DISTINCT cap_do FROM khoahoc WHERE cap_do IS NOT NULL AND cap_do != '' ORDER BY cap_do";
$levels_result = $conn->query($sql_levels);
$available_levels = [];
while ($level_row = $levels_result->fetch_assoc()) {
    $available_levels[] = $level_row['cap_do'];
}

// Count total courses
$sql_count = "SELECT COUNT(*) as total FROM khoahoc" . $sql_search;
$stmt_count = $conn->prepare($sql_count);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_courses = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_courses / $courses_per_page);

// Main query with pagination
$sql = "
    SELECT id_khoahoc, ten_khoahoc, cap_do, thoi_gian, chi_phi, hinh_anh, danh_gia_tb
    FROM khoahoc
" . $sql_search . " ORDER BY id_khoahoc DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $params[] = $courses_per_page;
    $params[] = $offset;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $courses_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-2 mb-md-0"><i class="fa-solid fa-book-open me-2"></i>Quản lý Khóa học</h4>
            <div class="d-flex flex-wrap gap-2">
                <form method="GET" action="./admin.php" class="d-flex">
                    <input type="hidden" name="nav" value="courses">
                    <?php if (!empty($filter_level)): ?>
                        <input type="hidden" name="filter_level" value="<?php echo htmlspecialchars($filter_level); ?>">
                    <?php endif; ?>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm tên hoặc cấp độ..." value="<?php echo htmlspecialchars($search_term); ?>" style="min-width: 200px;">
                    <button type="submit" class="btn btn-secondary btn-sm ms-1"><i class="fas fa-search"></i></button>
                </form>

                <!-- Filter Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" id="levelFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-filter me-1"></i>
                        <?php echo !empty($filter_level) ? htmlspecialchars($filter_level) : 'Lọc cấp độ'; ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="levelFilterDropdown">
                        <li>
                            <a class="dropdown-item <?php echo empty($filter_level) ? 'active' : ''; ?>" 
                               href="./admin.php?nav=courses<?php echo !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>">
                                <i class="fa-solid fa-list me-2"></i>Tất cả cấp độ
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <?php foreach ($available_levels as $level): ?>
                            <li>
                                <a class="dropdown-item <?php echo $filter_level === $level ? 'active' : ''; ?>" 
                                   href="./admin.php?nav=courses&filter_level=<?php echo urlencode($level); ?><?php echo !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>">
                                    <?php echo htmlspecialchars($level); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if (!empty($search_term) || !empty($filter_level)): ?>
                    <a href="./admin.php?nav=courses" class="btn btn-warning btn-sm">
                        <i class="fas fa-times"></i> Xóa lọc
                    </a>
                <?php endif; ?>
                
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fa-solid fa-plus me-1"></i> Thêm Khóa Học
                </button>
            </div>
        </div>

        <!-- Filter Statistics -->
        <?php if (!empty($filter_level) || !empty($search_term)): ?>
        <div class="mt-3">
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge bg-light text-dark border">
                    <i class="fa-solid fa-book-open me-1"></i>
                    Tổng: <strong><?php echo $total_courses; ?></strong> khóa học
                </span>
                <?php if (!empty($filter_level)): ?>
                    <span class="badge" style="background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);">
                        <i class="fa-solid fa-filter me-1"></i>
                        Cấp độ: <strong><?php echo htmlspecialchars($filter_level); ?></strong>
                    </span>
                <?php endif; ?>
                <?php if (!empty($search_term)): ?>
                    <span class="badge bg-info">
                        <i class="fa-solid fa-search me-1"></i>
                        Tìm kiếm: <strong><?php echo htmlspecialchars($search_term); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">ID</th>
                      
                        <th>Tên Khóa Học</th>
                        <th>Cấp Độ</th> <th class="text-center">Thời Gian (Buổi)</th>
                        <th class="text-end">Chi Phí (VNĐ)</th>
                        <th class="text-center">Đánh Giá</th>
                        <th class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . $row['id_khoahoc'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['ten_khoahoc']) . "</td>";
                            echo "<td>" . ($row['cap_do'] ? htmlspecialchars($row['cap_do']) : "<span class='text-muted fst-italic'>Chưa có</span>") . "</td>";
                            echo "<td class='text-center'>" . ($row['thoi_gian'] ? htmlspecialchars($row['thoi_gian']) : "<span class='text-muted fst-italic'>0</span>") . "</td>";
                            echo "<td class='text-end'>" . number_format($row['chi_phi'], 0, ',', '.') . "</td>";
                            echo "<td class='text-center'>" . ($row['danh_gia_tb'] !== null ? number_format($row['danh_gia_tb'], 1) . "/5 <i class='fa-solid fa-star text-warning'></i>" : "<span class='text-muted fst-italic'>Chưa có</span>") . "</td>";
                            echo "<td class='text-center'>";
                            echo "<button class='btn btn-warning btn-sm me-1' onclick='editCourse(" . $row['id_khoahoc'] . ")'><i class='fa-solid fa-pen-to-square'></i></button>";
                            echo "<button class='btn btn-danger btn-sm' onclick='deleteCourse(" . $row['id_khoahoc'] . ")'><i class='fa-solid fa-trash-can'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        $empty_message = "Không tìm thấy khóa học nào";
                        if (!empty($search_term) && !empty($filter_level)) {
                            $empty_message .= " với từ khóa '<strong>" . htmlspecialchars($search_term) . "</strong>' và cấp độ '<strong>" . htmlspecialchars($filter_level) . "</strong>'";
                        } elseif (!empty($search_term)) {
                            $empty_message .= " phù hợp với tìm kiếm '<strong>" . htmlspecialchars($search_term) . "</strong>'";
                        } elseif (!empty($filter_level)) {
                            $empty_message .= " ở cấp độ '<strong>" . htmlspecialchars($filter_level) . "</strong>'";
                        }
                        echo "<tr><td colspan='7' class='text-center text-muted py-4'>";
                        echo "<i class='fa-solid fa-book-open fa-3x mb-3 d-block'></i>";
                        echo "<p class='mb-0'>" . $empty_message . "</p>";
                        echo "</td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
        <!-- Pagination -->
        <div class="course-pagination-container">
            <div class="course-pagination">
                <?php
                $query_params = [];
                if (!empty($search_term)) $query_params[] = 'search=' . urlencode($search_term);
                if (!empty($filter_level)) $query_params[] = 'filter_level=' . urlencode($filter_level);
                $query_string = !empty($query_params) ? '&' . implode('&', $query_params) : '';
                
                // Previous button
                if ($current_page > 1):
                    $prev_link = "./admin.php?nav=courses&course_page=" . ($current_page - 1) . $query_string;
                ?>
                    <a href="<?php echo $prev_link; ?>" class="course-pagination-btn">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="btn-text">Trước</span>
                    </a>
                <?php else: ?>
                    <span class="course-pagination-btn disabled">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="btn-text">Trước</span>
                    </span>
                <?php endif; ?>

                <!-- Page numbers -->
                <?php
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);

                if ($start_page > 1):
                    $first_link = "./admin.php?nav=courses&course_page=1" . $query_string;
                ?>
                    <a href="<?php echo $first_link; ?>" class="course-pagination-number">1</a>
                    <?php if ($start_page > 2): ?>
                        <span class="course-pagination-dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <?php
                    $page_link = "./admin.php?nav=courses&course_page=" . $i . $query_string;
                    $active_class = ($i == $current_page) ? ' active' : '';
                    ?>
                    <a href="<?php echo $page_link; ?>" class="course-pagination-number<?php echo $active_class; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                    <?php if ($end_page < $total_pages - 1): ?>
                        <span class="course-pagination-dots">...</span>
                    <?php endif; ?>
                    <?php $last_link = "./admin.php?nav=courses&course_page=" . $total_pages . $query_string; ?>
                    <a href="<?php echo $last_link; ?>" class="course-pagination-number"><?php echo $total_pages; ?></a>
                <?php endif; ?>

                <!-- Next button -->
                <?php if ($current_page < $total_pages):
                    $next_link = "./admin.php?nav=courses&course_page=" . ($current_page + 1) . $query_string;
                ?>
                    <a href="<?php echo $next_link; ?>" class="course-pagination-btn">
                        <span class="btn-text">Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <span class="course-pagination-btn disabled">
                        <span class="btn-text">Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Pagination info -->
            <div class="course-pagination-info">
                <?php
                $start_item = $offset + 1;
                $end_item = min($offset + $courses_per_page, $total_courses);
                ?>
                Hiển thị <?php echo $start_item; ?>-<?php echo $end_item; ?> / <?php echo $total_courses; ?> khóa học
            </div>
        </div>
        <?php endif; ?>
        </div>
</div>

<style>
/* Course Pagination Styles */
.course-pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.course-pagination {
    display: flex;
    gap: 6px;
    align-items: center;
    background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
    padding: 6px 12px;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
}

.course-pagination-btn {
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

.course-pagination-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-1px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.course-pagination-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.course-pagination-number {
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

.course-pagination-number:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-1px) scale(1.05);
}

.course-pagination-number.active {
    background: white;
    color: #0db33b;
    transform: scale(1.08);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    border-color: white;
}

.course-pagination-dots {
    color: white;
    padding: 0 4px;
    font-weight: bold;
    opacity: 0.6;
}

.course-pagination-info {
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
    .course-pagination-container {
        justify-content: center;
    }
    
    .course-pagination-btn .btn-text {
        display: none;
    }
    
    .course-pagination-btn {
        padding: 6px 10px;
    }
    
    .course-pagination-info {
        order: -1;
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .course-pagination-number {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
    
    .course-pagination-btn {
        padding: 5px 8px;
    }
}
</style>

<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Thêm Khóa Học Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCourseForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="add_ten_khoahoc" class="form-label">Tên Khóa Học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_ten_khoahoc" name="ten_khoahoc" required>
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="add_cap_do" class="form-label">Cấp Độ</label>
                             <input type="text" class="form-control" id="add_cap_do" name="cap_do" placeholder="Ví dụ: Beginner, IELTS 5.0+">
                         </div>
                    </div>
                     <div class="mb-3">
                        <label for="add_mo_ta" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="add_mo_ta" name="mo_ta" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                             <label for="add_thoi_gian" class="form-label">Thời Gian (Số buổi)</label>
                             <input type="number" class="form-control" id="add_thoi_gian" name="thoi_gian" min="0">
                         </div>
                        <div class="col-md-6 mb-3">
                            <label for="add_chi_phi" class="form-label">Chi Phí (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="add_chi_phi" name="chi_phi" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add_hinh_anh" class="form-label">Hình Ảnh</label>
                        <input type="file" class="form-control" id="add_hinh_anh" name="hinh_anh" accept="image/*">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="add_course" class="btn btn-primary">Thêm Khóa Học</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Chỉnh Sửa Khóa Học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_khoahoc" id="edit_id_khoahoc">
                    <input type="hidden" name="hinh_anh_hien_tai" id="edit_hinh_anh_hien_tai">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                             <label for="edit_ten_khoahoc" class="form-label">Tên Khóa Học <span class="text-danger">*</span></label>
                             <input type="text" class="form-control" id="edit_ten_khoahoc" name="ten_khoahoc" required>
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="edit_cap_do" class="form-label">Cấp Độ</label>
                             <input type="text" class="form-control" id="edit_cap_do" name="cap_do">
                         </div>
                     </div>
                    <div class="mb-3">
                        <label for="edit_mo_ta" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="edit_mo_ta" name="mo_ta" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_thoi_gian" class="form-label">Thời Gian (Số buổi)</label>
                            <input type="number" class="form-control" id="edit_thoi_gian" name="thoi_gian" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_chi_phi" class="form-label">Chi Phí (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_chi_phi" name="chi_phi" min="0" required>
                        </div>
            }
        });
    }

    // Smooth scroll for pagination
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.course-pagination-number, .course-pagination-btn').forEach(link => {
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
</script>               <input type="file" class="form-control" id="edit_hinh_anh" name="hinh_anh" accept="image/*">
                        <div class="mt-2">
                            <small>Ảnh hiện tại:</small><br>
                            <img id="current_image" src="" alt="Ảnh khóa học" style="max-width: 150px; height: auto; margin-top: 5px; display: none;">
                            <span id="no_current_image" class="text-muted" style="display: none;">Không có ảnh</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="edit_course" class="btn btn-primary">Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
    let addEditor, editEditor; // Biến toàn cục cho CKEditor instances
    let addCourseModal, editCourseModal; // Biến cho Bootstrap Modals

    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo CKEditor cho textarea thêm mới
        addEditor = CKEDITOR.replace('add_mo_ta');
        // Khởi tạo CKEditor cho textarea sửa (sẽ cập nhật nội dung khi modal mở)
        editEditor = CKEDITOR.replace('edit_mo_ta');

        // Lấy đối tượng modal của Bootstrap
        const addModalEl = document.getElementById('addCourseModal');
        const editModalEl = document.getElementById('editCourseModal');
        if (addModalEl) {
             addCourseModal = new bootstrap.Modal(addModalEl);
        }
        if (editModalEl) {
             editCourseModal = new bootstrap.Modal(editModalEl);

             // Xử lý sự kiện khi modal sửa được hiển thị
             editModalEl.addEventListener('shown.bs.modal', function () {
                 // Lấy nội dung hiện tại của textarea (đã được JS đổ vào từ AJAX)
                 const currentContent = document.getElementById('edit_mo_ta').value;
                 // Set nội dung cho CKEditor
                 if (editEditor) {
                     editEditor.setData(currentContent);
                 }
             });
        }

        // Xử lý submit form thêm mới
        const addForm = document.getElementById('addCourseForm');
        if(addForm) {
            addForm.addEventListener('submit', function(e) {
                e.preventDefault();
                addEditor.updateElement(); // Cập nhật textarea từ CKEditor trước khi gửi
                const formData = new FormData(this);

                fetch('./modules/khoahoc/add_course.php', { // Đường dẫn tới file xử lý PHP
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (addCourseModal) addCourseModal.hide(); // Đóng modal
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: data.message,
                                    timer: 1500, // Tự đóng sau 1.5 giây
                                    showConfirmButton: false
                                })
                                .then(() => {
                                    location.reload(); // Tải lại trang để cập nhật danh sách
                                });
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Lỗi!', 'Có lỗi xảy ra, vui lòng thử lại.', 'error');
                    });
            });
        }


        // Xử lý submit form sửa
        const editForm = document.getElementById('editCourseForm');
         if(editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                editEditor.updateElement(); // Cập nhật textarea từ CKEditor
                const formData = new FormData(this);

                fetch('./modules/khoahoc/edit_course.php', { // Đường dẫn tới file xử lý PHP
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (editCourseModal) editCourseModal.hide();
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                })
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                     .catch(error => {
                         console.error('Error:', error);
                         Swal.fire('Lỗi!', 'Có lỗi xảy ra khi cập nhật.', 'error');
                     });
            });
        }

    }); // End DOMContentLoaded

    // Hàm mở modal sửa và load dữ liệu
    function editCourse(id) {
        fetch(`./modules/khoahoc/get_course_info.php?id=${id}`) // Đường dẫn tới file lấy thông tin
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Lỗi!', data.error, 'error');
                } else {
                    // Đổ dữ liệu vào form sửa
                    document.getElementById('edit_id_khoahoc').value = data.id_khoahoc;
                    document.getElementById('edit_ten_khoahoc').value = data.ten_khoahoc;
                    document.getElementById('edit_cap_do').value = data.cap_do || ''; // Đổ cấp độ
                    document.getElementById('edit_thoi_gian').value = data.thoi_gian || '';
                    document.getElementById('edit_chi_phi').value = data.chi_phi;
                    document.getElementById('edit_hinh_anh_hien_tai').value = data.hinh_anh || '';

                    // Cập nhật giá trị cho textarea ẩn để CKEditor lấy khi modal mở
                     document.getElementById('edit_mo_ta').value = data.mo_ta || '';

                    // Hiển thị ảnh hiện tại
                    const currentImageElement = document.getElementById('current_image');
                    const noCurrentImageElement = document.getElementById('no_current_image');
                    if (data.hinh_anh) {
                        currentImageElement.src = '../' + data.hinh_anh + '?t=' + new Date().getTime(); // Thêm ../ và cache busting
                        currentImageElement.style.display = 'block';
                        noCurrentImageElement.style.display = 'none';
                    } else {
                        currentImageElement.style.display = 'none';
                        noCurrentImageElement.style.display = 'inline';
                    }

                    // Reset trường input file
                    document.getElementById('edit_hinh_anh').value = '';

                    // Mở modal sửa
                    if (editCourseModal) editCourseModal.show();
                     // CKEditor sẽ tự cập nhật nội dung khi modal 'shown.bs.modal'
                }
            })
            .catch(error => {
                console.error('Error fetching course info:', error);
                Swal.fire('Lỗi!', 'Không thể tải thông tin khóa học.', 'error');
            });
    }

    // Hàm xóa khóa học
    function deleteCourse(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Bạn sẽ không thể hoàn tác hành động này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa khóa học!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi yêu cầu xóa bằng Fetch API
                fetch('./modules/khoahoc/delete_course.php', { // Đường dẫn tới file xử lý PHP
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'delete_id=' + id
                    })
                    .then(response => response.text()) // Nhận phản hồi dạng text
                    .then(textData => {
                         // Kiểm tra nội dung phản hồi thay vì JSON status
                         if (textData.includes('Xóa thành công')) {
                            Swal.fire(
                                'Đã xóa!',
                                'Khóa học đã được xóa thành công.',
                                'success'
                            ).then(() => {
                                location.reload(); // Tải lại trang
                            });
                        } else {
                             // Nếu có lỗi, textData sẽ chứa thông báo lỗi từ PHP
                             Swal.fire(
                                'Lỗi!',
                                textData || 'Có lỗi xảy ra khi xóa khóa học.', // Hiển thị lỗi từ PHP hoặc thông báo chung
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Lỗi!', 'Có lỗi xảy ra, vui lòng thử lại.', 'error');
                    });
            }
        });
    }
</script>