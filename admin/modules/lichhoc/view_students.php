<?php
include('../config/config.php');

$lop_id = $_GET['lop_id'] ?? $_POST['id_lop'] ?? null;
if (!$lop_id) {
    die("Lỗi: Không tìm thấy thông tin lớp học.");
}

// Lấy danh sách học viên trong lớp
$sql_students = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email, hv.so_dien_thoai
                 FROM dangkykhoahoc dk
                 JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                 WHERE dk.id_lop = ?";
$stmt = mysqli_prepare($conn, $sql_students);
mysqli_stmt_bind_param($stmt, 's', $lop_id);
mysqli_stmt_execute($stmt);
$students = mysqli_stmt_get_result($stmt);

// Lấy id_khoahoc của lớp học
$sql_khoahoc = "SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?";
$stmt_khoahoc = mysqli_prepare($conn, $sql_khoahoc);
mysqli_stmt_bind_param($stmt_khoahoc, 's', $lop_id);
mysqli_stmt_execute($stmt_khoahoc);
$result_khoahoc = mysqli_stmt_get_result($stmt_khoahoc);
if ($result_khoahoc && $row_khoahoc = mysqli_fetch_assoc($result_khoahoc)) {
    $id_khoahoc = $row_khoahoc['id_khoahoc'];
} else {
    die("Lỗi: Không tìm thấy khóa học.");
}

// Xử lý thêm học viên
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $id_hocvien = $_POST['id_hocvien'];

    // Kiểm tra học viên đã đăng ký lớp học chưa
    $sql_check = "SELECT * FROM dangkykhoahoc 
                  WHERE id_hocvien = ? AND id_khoahoc = ? AND id_lop IS NULL AND trang_thai = 'da xac nhan'";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 'ii', $id_hocvien, $id_khoahoc);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Thêm học viên vào lớp
        $sql_add = "UPDATE dangkykhoahoc 
                    SET id_lop = ? 
                    WHERE id_hocvien = ? AND id_khoahoc = ? AND id_lop IS NULL";
        $stmt_add = mysqli_prepare($conn, $sql_add);
        mysqli_stmt_bind_param($stmt_add, 'sii', $lop_id, $id_hocvien, $id_khoahoc);

        if (mysqli_stmt_execute($stmt_add)) {
            // Lấy tổng số buổi học của lớp
            $sql_total_sessions = "SELECT COUNT(*) AS total_sessions 
                                   FROM lichhoc 
                                   WHERE id_lop = ?";
            $stmt_total_sessions = mysqli_prepare($conn, $sql_total_sessions);
            mysqli_stmt_bind_param($stmt_total_sessions, 's', $lop_id);
            mysqli_stmt_execute($stmt_total_sessions);
            $result_total_sessions = mysqli_stmt_get_result($stmt_total_sessions);
            $total_sessions = 0;

            if ($row_sessions = mysqli_fetch_assoc($result_total_sessions)) {
                $total_sessions = $row_sessions['total_sessions'];
            }

            // Thêm học viên vào bảng tien_do_hoc_tap
            $sql_progress = "INSERT INTO tien_do_hoc_tap (id_hocvien, id_khoahoc, tien_do, so_buoi_da_tham_gia, tong_so_buoi)
                             VALUES (?, ?, 0, 0, ?)";
            $stmt_progress = mysqli_prepare($conn, $sql_progress);
            mysqli_stmt_bind_param($stmt_progress, 'iii', $id_hocvien, $id_khoahoc, $total_sessions);

            if (mysqli_stmt_execute($stmt_progress)) {
                echo "<div class='alert alert-success'>Thêm học viên thành công và đã cập nhật tiến độ!</div>";
            } else {
                echo "<div class='alert alert-warning'>Thêm học viên thành công nhưng không thể cập nhật tiến độ: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi thêm học viên: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Học viên không thuộc khóa học này hoặc đã có lớp!</div>";
    }
}
?>


<!-- Nút thêm học viên -->
<button class="btn btn-primary my-3" id="btn-add-student">Thêm học viên</button>


<!-- Form thêm học viên -->
<div id="form-add-student" style="display: none;">
    <h3>Thêm Học Viên</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="id_hocvien">Chọn Học Viên</label>
            <select id="id_hocvien" name="id_hocvien" class="form-control" required>
                <?php
                // Lấy danh sách học viên đủ điều kiện:
                // - Đã đăng ký khóa học (dangkykhoahoc.id_khoahoc = lop_hoc.id_khoahoc)
                // - Thanh toán thành công
                $sql_eligible_students = "
                    SELECT DISTINCT hv.id_hocvien, hv.ten_hocvien
                    FROM hocvien hv
                    INNER JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien
                    WHERE dk.id_khoahoc = (
                        SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?
                    )
                    AND dk.trang_thai = 'da xac nhan'
                    AND dk.id_hocvien NOT IN (
                        SELECT id_hocvien FROM dangkykhoahoc WHERE id_lop = ?
                    )
                ";
                $stmt_eligible = mysqli_prepare($conn, $sql_eligible_students);
                mysqli_stmt_bind_param($stmt_eligible, 'ss', $lop_id, $lop_id);
                mysqli_stmt_execute($stmt_eligible);
                $eligible_students = mysqli_stmt_get_result($stmt_eligible);

                while ($student = mysqli_fetch_assoc($eligible_students)) {
                    echo "<option value='{$student['id_hocvien']}'>" . htmlspecialchars($student['ten_hocvien']) . "</option>";
                }
                ?>
            </select>
        </div>
        <input type="hidden" name="id_lop" value="<?= htmlspecialchars($lop_id) ?>">
        <button type="submit" name="add_student" class="btn btn-success">Thêm Học Viên</button>
    </form>
</div>
<!-- Hiển thị danh sách học viên -->
<table class="table table-bordered table-hove">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên Học Viên</th>
            <th>Email</th>
            <th>Số điện thoại</th>

            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($student = mysqli_fetch_assoc($students)): ?>
            <tr>
                <td><?= htmlspecialchars($student['id_hocvien']) ?></td>
                <td><?= htmlspecialchars($student['ten_hocvien']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td><?= htmlspecialchars($student['so_dien_thoai']) ?></td>

                <td>
                    <a href="modules/lichhoc/remove_student.php?lop_id=<?= $lop_id ?>&delete_student_id=<?= $student['id_hocvien'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa học viên này?');"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>




<script>
    // Hiển thị/ẩn form thêm học viên
    document.getElementById('btn-add-student').addEventListener('click', function() {
        const form = document.getElementById('form-add-student');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>