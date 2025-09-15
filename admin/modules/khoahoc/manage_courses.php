<?php
// include('../config/config.php');

// Xử lý tìm kiếm
$search_term = $_POST['search'] ?? '';
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    // Cập nhật truy vấn SQL để tìm kiếm giảng viên từ bảng giangvien
    $sql_search = " WHERE kh.ten_khoahoc LIKE ? OR gv.ten_giangvien LIKE ?";
    $search_param = "%" . $search_term . "%";
    $params = [$search_param, $search_param];
    $types = "ss";
}

// Cập nhật truy vấn chính để JOIN với bảng giangvien
$sql = "
    SELECT kh.id_khoahoc, kh.ten_khoahoc, kh.thoi_gian, kh.chi_phi, gv.ten_giangvien 
    FROM khoahoc kh
    LEFT JOIN giangvien gv ON kh.id_giangvien = gv.id_giangvien
" . $sql_search . " ORDER BY kh.id_khoahoc DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
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
                <form method="POST" action="./admin.php?nav=courses" class="d-flex me-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm tên khóa học, giảng viên..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <a href="./admin.php?nav=add_course" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm Khóa học</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th style="width: 40%;">Tên Khóa học</th>
                        <th>Giảng viên</th>
                        <th class="text-center">Thời gian (buổi)</th>
                        <th>Học phí (VNĐ)</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr id="course-row-<?php echo $row['id_khoahoc']; ?>" class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                            <td><?php echo $row['id_khoahoc']; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten_giangvien'] ?? 'Chưa có'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['thoi_gian']); ?></td>
                            <td><?php echo number_format($row['chi_phi'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <a href="./admin.php?nav=edit_course&id=<?php echo $row['id_khoahoc']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                                </a>
                                <button onclick="deleteCourse(<?php echo $row['id_khoahoc']; ?>)" class="btn btn-danger btn-sm">
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

<script>
function deleteCourse(courseId) {
    if (confirm("Bạn có chắc chắn muốn xóa khóa học này? Tất cả dữ liệu liên quan (lớp học, đăng ký,...) có thể bị ảnh hưởng.")) {
        const row = document.getElementById(`course-row-${courseId}`);
        row.style.transition = "opacity 0.5s ease-out";
        row.style.opacity = '0';

        setTimeout(() => {
            fetch('./modules/khoahoc/delete_course.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `delete_id=${courseId}`
            })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === "Xóa thành công") {
                    row.remove();
                } else {
                    alert("Lỗi khi xóa: " + result);
                    row.style.opacity = '1'; // Khôi phục nếu xóa thất bại
                }
            })
            .catch(error => {
                console.error('Error:', error);
                row.style.opacity = '1';
            });
        }, 500);
    }
}
</script>