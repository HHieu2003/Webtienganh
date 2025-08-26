<?php
include('../config/config.php');
// Lấy danh sách học viên// Xử lý tìm kiếm nếu có từ khóa tìm kiếm
$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

$sql = "SELECT * FROM hocvien";
if (!empty($search)) {
    $sql .= " WHERE ten_hocvien LIKE '%$search%' OR email LIKE '%$search%' OR so_dien_thoai LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

?>
<div class="container my-3 ">
    <h1 class="text-center title-color">Quản lý Học Viên</h1>
    <div class="text-end mb-3">
        <!-- Thêm Học viên button to trigger the modal -->
        <form method="POST" action="./admin.php?nav=students" class="d-inline-block float-start">
        <input type="text" name="search" class="form-control d-inline-block w-auto" placeholder="Tên học viên muốn tìm...." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
            <button type="submit" class="btn btn-primary" >
            <i class="fa-solid fa-magnifying-glass"></i></button>
        </form> 
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">  Thêm Học viên</button>
    </div>

    <!-- Table displaying the list of students -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên học viên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Mật khẩu</th>
                <th>Admin</th>

                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr id="course-row-<?= $row['id_hocvien'] ?>">
                    <td><?= htmlspecialchars($row['id_hocvien']) ?></td>
                    <td><?= htmlspecialchars($row['ten_hocvien']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['so_dien_thoai']) ?></td>
                    <td><?= htmlspecialchars($row['mat_khau']) ?></td>
                    <td><?= htmlspecialchars($row['is_admin']) ?></td>

                    <td>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editStudentModal" class="btn btn-primary btn-sm" onclick="openEditModal(<?= $row['id_hocvien'] ?>)">Chỉnh sửa</a>

                        <a href="javascript:void(0);" onclick="deleteCourse(<?= $row['id_hocvien'] ?>)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<!-- Modal for adding a new student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Thêm Học Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to add a new student -->
                <form action="modules/hocvien/add_student.php" method="POST">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Tên học viên</label>
                        <input type="text" class="form-control" id="studentName" name="ten_hocvien" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentPhone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="studentPhone" name="so_dien_thoai" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="studentEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentPassword" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="studentPassword" name="mat_khau" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm học viên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal for editing a student -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Chỉnh sửa Học Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to edit student -->
                <form action="./modules/hocvien/edit_student.php" method="POST" id="editStudentForm">
                    <input type="hidden" id="editStudentId" name="id_hocvien" />
                    <div class="mb-3">
                        <label for="editStudentName" class="form-label">Tên học viên</label>
                        <input type="text" class="form-control" id="editStudentName" name="ten_hocvien" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentPhone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="editStudentPhone" name="so_dien_thoai" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editStudentEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentPassword" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="editStudentPassword" name="mat_khau" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentPassword" class="form-label">Admin</label>
                        <input type="checkbox" id="is_admin" name="is_admin" value="1" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- lấy dữ liệu học viên -->
<script>
    // Lắng nghe sự kiện khi modal đóng
    var editStudentModal = document.getElementById('editStudentModal');
    editStudentModal.addEventListener('hidden.bs.modal', function(event) {
        // Xóa lớp phủ thủ công nếu cần
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Loại bỏ lớp phủ nếu tồn tại
        }
    });


    function openEditModal(studentId) {
        // Gửi yêu cầu AJAX để lấy thông tin học viên từ cơ sở dữ liệu
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./modules/hocvien/get_student_info.php?id=" + studentId, true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                var student = JSON.parse(xhr.responseText);

                // Điền dữ liệu vào các trường trong modal
                document.getElementById('editStudentId').value = student.id_hocvien;
                document.getElementById('editStudentName').value = student.ten_hocvien;
                document.getElementById('editStudentPhone').value = student.so_dien_thoai;
                document.getElementById('editStudentEmail').value = student.email;
                document.getElementById('editStudentPassword').value = student.mat_khau; // Optionally hash password before saving

                // Hiển thị modal chỉnh sửa
                var editModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
                editModal.show();
            } else {
                alert("Đã có lỗi khi tải dữ liệu học viên.");
            }
        };
        xhr.send();
    }
</script>




<!-- JavaScript Xử Lý Xóa Học -->
<script>
    function deleteCourse(courseId) {
        if (confirm("Bạn có chắc chắn muốn xóa học viên này?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./modules/hocvien/delete_student.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.send("delete_id=" + courseId);

            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                    if (xhr.responseText.trim() === "Xóa thành công") {
                        document.getElementById('course-row-' + courseId).remove();
                    } else {
                        alert("Đã có lỗi xảy ra khi xóa .");
                    }
                } else {
                    alert("Đã có lỗi xảy ra khi gửi yêu cầu AJAX.");
                }
            };
        }
    }
</script>