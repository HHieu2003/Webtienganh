<?php
// PHP logic để lấy dữ liệu (giữ nguyên như phiên bản trước)
$search_term = $_POST['search'] ?? $_GET['search'] ?? '';
$sql_search = "";
if (!empty($search_term)) {
    $search_param = "%" . $conn->real_escape_string($search_term) . "%";
    $sql_search = " WHERE ten_hocvien LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?";
}
$sql = "SELECT * FROM hocvien" . $sql_search . " ORDER BY id_hocvien DESC";
$stmt = $conn->prepare($sql);
if (!empty($search_term)) {
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
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
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fa-solid fa-plus"></i> Thêm Học viên
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th><th>Tên học viên</th><th>Email</th><th>Số điện thoại</th><th>Admin</th><th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr id="student-row-<?php echo $row['id_hocvien']; ?>" class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                            <td><?php echo htmlspecialchars($row['id_hocvien']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten_hocvien']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                            <td>
                                <?php if ($row['is_admin']): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $row['id_hocvien']; ?>)">
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Thêm Học Viên Mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="modules/hocvien/add_student.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên học viên</label><input type="text" class="form-control" name="ten_hocvien" required></div>
                    <div class="mb-3"><label class="form-label">Số điện thoại</label><input type="text" class="form-control" name="so_dien_thoai" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Mật khẩu</label><input type="password" class="form-control" name="mat_khau" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Chỉnh sửa Học Viên</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="./modules/hocvien/edit_student.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="editStudentId" name="id_hocvien" />
                    <div class="mb-3"><label class="form-label">Tên học viên</label><input type="text" class="form-control" id="editStudentName" name="ten_hocvien" required></div>
                    <div class="mb-3"><label class="form-label">Số điện thoại</label><input type="text" class="form-control" id="editStudentPhone" name="so_dien_thoai" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" id="editStudentEmail" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Mật khẩu mới (để trống nếu không đổi)</label><input type="password" class="form-control" id="editStudentPassword" name="mat_khau"></div>
                    <div class="mb-3 form-check"><input type="checkbox" class="form-check-input" id="editIsAdmin" name="is_admin" value="1"><label class="form-check-label" for="editIsAdmin">Là Quản trị viên</label></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>
</div>

<script>
// Đảm bảo script chạy sau khi toàn bộ trang đã tải
document.addEventListener("DOMContentLoaded", function() {
    
    // Khởi tạo đối tượng modal một lần duy nhất
    const editModalElement = document.getElementById('editStudentModal');
    if (editModalElement) {
        // Biến toàn cục để dễ truy cập
        window.editStudentModal = new bootstrap.Modal(editModalElement);
    }

});

// Đưa hàm ra phạm vi toàn cục để onclick có thể gọi được
function openEditModal(studentId) {
    console.log("Opening modal for student ID:", studentId);
    
    fetch(`./modules/hocvien/get_student_info.php?id=${studentId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            // Điền dữ liệu vào form
            document.getElementById('editStudentId').value = data.id_hocvien;
            document.getElementById('editStudentName').value = data.ten_hocvien;
            document.getElementById('editStudentPhone').value = data.so_dien_thoai;
            document.getElementById('editStudentEmail').value = data.email;
            document.getElementById('editIsAdmin').checked = (data.is_admin == 1);
            document.getElementById('editStudentPassword').value = "";
            
            // Hiển thị modal
            if (window.editStudentModal) {
                window.editStudentModal.show();
            }
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin học viên:', error);
            alert('Đã xảy ra lỗi. Vui lòng kiểm tra console (F12) để biết thêm chi tiết.');
        });
}

function deleteStudent(studentId) {
    if (confirm("Bạn có chắc chắn muốn xóa học viên này?")) {
        const row = document.getElementById(`student-row-${studentId}`);
        row.style.transition = "opacity 0.5s ease-out";
        row.style.opacity = '0';

        setTimeout(() => {
            fetch(`./modules/hocvien/delete_student.php`, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `delete_id=${studentId}`
            })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === "Xóa thành công") {
                    row.remove();
                } else {
                    alert("Lỗi khi xóa: " + result);
                    row.style.opacity = '1';
                }
            });
        }, 500);
    }
}
</script>