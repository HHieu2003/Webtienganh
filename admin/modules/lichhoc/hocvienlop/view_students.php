<?php
// File: admin/modules/lichhoc/hocvienlop/view_students.php
if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");
$search_students = $_GET['search_students'] ?? '';

// Lấy danh sách học viên
$sql_students_in_class = "SELECT hv.id_hocvien, hv.ten_hocvien, hv.email, hv.so_dien_thoai FROM dangkykhoahoc dk JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien WHERE dk.id_lop = ?";
$params = [$lop_id]; $types = "s";
if (!empty($search_students)) {
    $sql_students_in_class .= " AND (hv.ten_hocvien LIKE ? OR hv.email LIKE ?)";
    $search_param = "%" . $search_students . "%";
    array_push($params, $search_param, $search_param); $types .= "ss";
}
$stmt_students = $conn->prepare($sql_students_in_class);
$stmt_students->bind_param($types, ...$params);
$stmt_students->execute();
$students_in_class = $stmt_students->get_result();
?>
<style>
    .student-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
    }
    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        border: 3px solid var(--brand-color-light);
    }
    .student-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--dark-text);
        margin-bottom: 0.25rem;
    }
    .student-email {
        font-size: 0.85rem;
        color: var(--gray-text);
        margin-bottom: 1rem;
    }
    .remove-student-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .student-card:hover .remove-student-btn {
        opacity: 1;
    }
</style>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Danh sách học viên (<?php echo $students_in_class->num_rows; ?>)</h5>
            <div class="d-flex">
                <form method="GET" action="./admin.php" class="d-flex me-2">
                    <input type="hidden" name="nav" value="lichhoc"><input type="hidden" name="lop_id" value="<?php echo htmlspecialchars($lop_id); ?>"><input type="hidden" name="view" value="students">
                    <input type="text" name="search_students" class="form-control" placeholder="Tìm học viên..." value="<?php echo htmlspecialchars($search_students); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <a href="modules/lichhoc/hocvienlop/export_students_in_class.php?lop_id=<?php echo htmlspecialchars($lop_id); ?>" class="btn btn-info text-white me-2" title="Xuất Excel"><i class="fa-solid fa-file-excel"></i></a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentToClassModal"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if ($students_in_class->num_rows > 0): ?>
            <div class="row g-4">
                <?php 
                $index = 0;
                while ($student = $students_in_class->fetch_assoc()): 
                ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 animated-item" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                        <div class="student-card">
                             <button onclick="removeStudent(<?php echo $student['id_hocvien']; ?>, '<?php echo $lop_id; ?>', '<?php echo htmlspecialchars(addslashes($student['ten_hocvien'])); ?>')" class="btn btn-sm btn-outline-danger rounded-circle remove-student-btn" title="Xóa học viên khỏi lớp"><i class="fa-solid fa-times"></i></button>
                            <img src="../images/logo.png" alt="Avatar" class="student-avatar">
                            <h6 class="student-name"><?php echo htmlspecialchars($student['ten_hocvien']); ?></h6>
                            <p class="student-email"><?php echo htmlspecialchars($student['email']); ?></p>
                            <a href="tel:<?php echo htmlspecialchars($student['so_dien_thoai']); ?>" class="btn btn-sm btn-outline-success w-100">
                                <i class="fa-solid fa-phone me-2"></i><?php echo htmlspecialchars($student['so_dien_thoai']); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light text-center">Chưa có học viên nào trong lớp.</div>
        <?php endif; ?>
    </div>
</div>