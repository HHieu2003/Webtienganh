<?php
if (!isset($lop_id)) {
    die("Lỗi: Không tìm thấy thông tin lớp học.");
}

// Xử lý tìm kiếm
$search_students = $_GET['search_students'] ?? '';

// Lấy danh sách học viên
$sql_students_in_class = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email, hv.so_dien_thoai
                          FROM dangkykhoahoc dk JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                          WHERE dk.id_lop = ?";
$params = [$lop_id];
$types = "s";

if (!empty($search_students)) {
    $sql_students_in_class .= " AND (hv.ten_hocvien LIKE ? OR hv.email LIKE ?)";
    $search_param = "%" . $search_students . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}
$stmt_students = $conn->prepare($sql_students_in_class);
$stmt_students->bind_param($types, ...$params);
$stmt_students->execute();
$students_in_class = $stmt_students->get_result();
?>

<div class="card mt-4 animated-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách học viên trong lớp</h5>
        <div class="d-flex">
            <form method="GET" action="./admin.php" class="d-flex me-2">
                <input type="hidden" name="nav" value="lichhoc">
                <input type="hidden" name="lop_id" value="<?php echo htmlspecialchars($lop_id); ?>">
                <input type="hidden" name="view" value="students">
                <input type="text" name="search_students" class="form-control" placeholder="Tìm học viên..." value="<?php echo htmlspecialchars($search_students); ?>">
                <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <a href="modules/lichhoc/export_students_in_class.php?lop_id=<?php echo htmlspecialchars($lop_id); ?>&search=<?php echo htmlspecialchars($search_students); ?>" class="btn btn-info text-white me-2">
                <i class="fa-solid fa-file-excel"></i> Xuất Excel
            </a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentToClassModal">
                <i class="fa-solid fa-plus"></i> Thêm học viên
            </button>
        </div>
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
                        <tr><td colspan="5" class="text-center text-muted py-3">Không tìm thấy học viên nào phù hợp.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>