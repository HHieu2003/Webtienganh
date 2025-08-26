    <?php
    include('../config/config.php');

    // Lấy từ khóa tìm kiếm từ form
    $search = isset($_POST['search']) ? $_POST['search'] : '';


    // Cập nhật truy vấn SQL để tìm kiếm khóa học theo tên hoặc giảng viên
    $sql = "SELECT * FROM khoahoc WHERE ten_khoahoc LIKE ? OR giang_vien LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    $search_term = "%" . $search . "%"; // Tạo từ khóa tìm kiếm
    mysqli_stmt_bind_param($stmt, 'ss', $search_term, $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
    ?>

    <div class="container my-3">
        <h1 class="text-center title-color">Quản lý Khóa học</h1>
        <div class="text-end mb-3">
            <form method="POST" action="./admin.php?nav=courses" class="d-inline-block float-start">
    
                <input type="text" name="search" class="form-control d-inline-block w-auto" placeholder="Tên khóa học..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                
                <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <a href="./admin.php?nav=add_course" class="btn btn-success"> Thêm Khóa học</a>
        </div>
        <!-- Form Tìm Kiếm -->
        

        <!-- Bảng Khóa Học -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th style="width: 300px;">Tên Khóa học</th>
                    <!-- <th>Hình ảnh</th> -->
                    <th>Giảng viên</th>
                    <th>Thời gian</th>
                    <th>Chi phí</th>
                    <th style="display: flex;">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr id="course-row-<?= $row['id_khoahoc'] ?>">
                        <td><?= htmlspecialchars($row['id_khoahoc']) ?></td>
                        <td><?= htmlspecialchars($row['ten_khoahoc']) ?></td>
                    
                        <td><?= htmlspecialchars($row['giang_vien']) ?></td>
                        <td><?= htmlspecialchars($row['thoi_gian']) ?> Buổi</td>
                        <td><?= htmlspecialchars($row['chi_phi']) ?> vnđ</td>
                        <td>
                            <a href="./admin.php?nav=edit_course&id=<?= $row['id_khoahoc'] ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                            <a href="javascript:void(0);" onclick="deleteCourse(<?= $row['id_khoahoc'] ?>)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>

    <!-- JavaScript Xử Lý Xóa Khóa Học -->
    <script>
        function deleteCourse(courseId) {
            if (confirm("Bạn có chắc chắn muốn xóa khóa học này?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "./modules/khoahoc/delete_course.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.send("delete_id=" + courseId);

                xhr.onload = function() {
                    if (xhr.status == 200) {
                        console.log(xhr.responseText);
                        if (xhr.responseText.trim() === "Xóa thành công") {
                            document.getElementById('course-row-' + courseId).remove();
                        } else {
                            alert("Đã có lỗi xảy ra khi xóa khóa học.");
                        }
                    } else {
                        alert("Đã có lỗi xảy ra khi gửi yêu cầu AJAX.");
                    }
                };
            }
        }
    </script>
