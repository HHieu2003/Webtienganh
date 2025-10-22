<?php
// Xử lý tìm kiếm
$search_term = $_POST['search'] ?? $_GET['search'] ?? ''; // Ưu tiên POST rồi đến GET
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    // Tìm kiếm theo tên khóa học HOẶC cấp độ
    $sql_search = " WHERE ten_khoahoc LIKE ? OR cap_do LIKE ?";
    $search_param = "%" . $search_term . "%";
    // Cần 2 tham số giống nhau cho LIKE
    $params = [$search_param, $search_param];
    $types = "ss"; // Hai tham số kiểu string
}

// Thêm cột cap_do vào câu SELECT
$sql = "
    SELECT id_khoahoc, ten_khoahoc, cap_do, thoi_gian, chi_phi, hinh_anh, danh_gia_tb
    FROM khoahoc
" . $sql_search . " ORDER BY id_khoahoc DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    // Dùng toán tử `...` (spread operator) để truyền mảng tham số
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-book-open me-2"></i>Quản lý Khóa học</h4>
            <div class="d-flex">
                <form method="GET" action="./admin.php" class="d-flex me-2">
                    <input type="hidden" name="nav" value="courses"> <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm tên hoặc cấp độ..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-secondary btn-sm ms-1"><i class="fas fa-search"></i></button>
                    <?php if (!empty($search_term)): ?>
                         <a href="./admin.php?nav=courses" class="btn btn-warning btn-sm ms-1"><i class="fas fa-times"></i> Xóa tìm</a>
                    <?php endif; ?>
                </form>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fa-solid fa-plus me-1"></i> Thêm Khóa Học
                </button>
            </div>
        </div>
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
                            echo "<td>" . ($row['cap_do'] ? htmlspecialchars($row['cap_do']) : "<span class='text-muted fst-italic'>Chưa có</span>") . "</td>"; // Hiển thị cấp độ
                            echo "<td class='text-center'>" . ($row['thoi_gian'] ? htmlspecialchars($row['thoi_gian']) : "<span class='text-muted fst-italic'>0</span>") . "</td>";
                            echo "<td class='text-end'>" . number_format($row['chi_phi'], 0, ',', '.') . "</td>";
                            echo "<td class='text-center'>" . ($row['danh_gia_tb'] !== null ? number_format($row['danh_gia_tb'], 1) . "/5 <i class='fa-solid fa-star text-warning'></i>" : "<span class='text-muted fst-italic'>Chưa có</span>") . "</td>";
                            echo "<td class='text-center'>";
                            // Nút Sửa: gọi hàm JavaScript editCourse
                            echo "<button class='btn btn-warning btn-sm me-1' onclick='editCourse(" . $row['id_khoahoc'] . ")'><i class='fa-solid fa-pen-to-square'></i></button>";
                            // Nút Xóa: gọi hàm JavaScript deleteCourse
                            echo "<button class='btn btn-danger btn-sm' onclick='deleteCourse(" . $row['id_khoahoc'] . ")'><i class='fa-solid fa-trash-can'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Cập nhật colspan thành 8
                        echo "<tr><td colspan='8' class='text-center text-muted'>Không tìm thấy khóa học nào" . (!empty($search_term) ? " phù hợp với tìm kiếm '" . htmlspecialchars($search_term) . "'" : "") . ".</td></tr>";
                    }
                    $stmt->close();
                    // Không đóng $conn ở đây nếu file này được include vào admin.php
                    ?>
                </tbody>
            </table>
        </div>
        </div>
</div>

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
                    </div>
                    <div class="mb-3">
                        <label for="edit_hinh_anh" class="form-label">Hình Ảnh Mới (Để trống nếu không đổi)</label>
                        <input type="file" class="form-control" id="edit_hinh_anh" name="hinh_anh" accept="image/*">
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