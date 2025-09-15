<?php
// Giả định $conn và $lop_id đã có từ file lichhoc.php
if (!isset($lop_id)) {
    die("Lỗi: Không tìm thấy thông tin lớp học.");
}

// Lấy danh sách học viên hiện có trong lớp để hiển thị
$sql_students_in_class = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email, hv.so_dien_thoai
                          FROM dangkykhoahoc dk JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                          WHERE dk.id_lop = ?";
$stmt_students = $conn->prepare($sql_students_in_class);
$stmt_students->bind_param('s', $lop_id);
$stmt_students->execute();
$students_in_class = $stmt_students->get_result();
?>

<div class="card mt-4 animated-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách học viên trong lớp</h5>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentToClassModal">
            <i class="fa-solid fa-plus"></i> Thêm học viên vào lớp
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>ID</th><th>Tên Học Viên</th><th>Email</th><th>Số điện thoại</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php if ($students_in_class->num_rows > 0):
                        while ($student = $students_in_class->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $student['id_hocvien']; ?></td>
                            <td><?php echo htmlspecialchars($student['ten_hocvien']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['so_dien_thoai']); ?></td>
                            <td class="text-center">
                                <a href="modules/lichhoc/remove_student.php?lop_id=<?php echo $lop_id; ?>&student_id=<?php echo $student['id_hocvien']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa học viên này khỏi lớp?');">
                                   <i class="fa-solid fa-user-minus"></i> Xóa khỏi lớp
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Chưa có học viên nào trong lớp này.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>