<?php
// File: admin/modules/teacher_tests.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['is_teacher']) || !$_SESSION['is_teacher']) die("Truy cập bị từ chối.");

$id_giangvien = $_SESSION['id_giangvien'];

// --- LẤY DANH SÁCH BÀI TEST LIÊN QUAN ĐẾN GIẢNG VIÊN ---
// Một bài test được coi là liên quan nếu:
// 1. Nó được gán cho lớp học mà giảng viên này dạy.
// 2. Nó được gán cho khóa học mà giảng viên này có lớp dạy trong đó.
$sql = "
    SELECT DISTINCT bt.id_baitest, bt.ten_baitest, bt.ngay_tao, bt.loai_baitest, kh.ten_khoahoc, lh.ten_lop
    FROM baitest bt 
    LEFT JOIN lop_hoc lh ON bt.id_lop = lh.id_lop
    LEFT JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
    WHERE lh.id_giangvien = ? 
       OR kh.id_khoahoc IN (SELECT DISTINCT id_khoahoc FROM lop_hoc WHERE id_giangvien = ?)
    ORDER BY bt.id_baitest DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_giangvien, $id_giangvien);
$stmt->execute();
$result = $stmt->get_result();

// --- LẤY DỮ LIỆU CHO MODAL: Chỉ lấy các khóa học/lớp học mà giảng viên này dạy ---
$courses = $conn->query("SELECT DISTINCT kh.id_khoahoc, kh.ten_khoahoc FROM khoahoc kh JOIN lop_hoc lh ON kh.id_khoahoc = lh.id_khoahoc WHERE lh.id_giangvien = $id_giangvien ORDER BY kh.ten_khoahoc");

// Hàm hiển thị badge (giữ nguyên)
function get_test_type_badge_gv($type) {
    switch ($type) {
        case 'dinh_ky': return '<span class="badge bg-info text-dark">Test định kỳ</span>';
        case 'on_tap': return '<span class="badge bg-secondary">Test ôn tập</span>';
        default: return '<span class="badge bg-light text-dark">' . htmlspecialchars($type) . '</span>';
    }
}
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-circle-question me-2"></i>Bài Test Của Tôi</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTestModal"><i class="fa-solid fa-plus"></i> Tạo Bài Test Mới</button>
        </div>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['message'])) { echo '<div class="alert alert-'.$_SESSION['message']['type'].' alert-dismissible fade show">'.htmlspecialchars($_SESSION['message']['text']).'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'; unset($_SESSION['message']); } ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>Tên Bài Test</th><th>Phạm vi</th><th class="text-center">Loại</th><th class="text-center">Ngày Tạo</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): 
                            $scope = '<span class="badge bg-secondary">Chung</span>';
                            if ($row['ten_lop']) { $scope = '<strong>Lớp:</strong> ' . htmlspecialchars($row['ten_lop']); } 
                            elseif ($row['ten_khoahoc']) { $scope = '<strong>Khóa:</strong> ' . htmlspecialchars($row['ten_khoahoc']); }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ten_baitest']); ?></td>
                            <td><?php echo $scope; ?></td>
                            <td class="text-center"><?php echo get_test_type_badge_gv($row['loai_baitest']); ?></td>
                            <td class="text-center"><?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></td>
                            <td class="text-center">
                                <a href="./admin.php?nav=ds_cauhoi_gv&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-primary btn-sm" title="Quản lý câu hỏi"><i class="fa-solid fa-list-check"></i></a>
                                <a href="./admin.php?nav=kqhocvien_gv&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-info btn-sm text-white" title="Xem kết quả"><i class="fa-solid fa-square-poll-vertical"></i></a>
                                 <a href="./modules/cauhoi/delete_test.php?id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa bài test này sẽ xóa tất cả dữ liệu liên quan. Bạn chắc chắn?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Bạn chưa tạo hoặc được giao bài test nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Tạo Bài Test mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="modules/cauhoi/add_test.php" method="POST">
                <input type="hidden" name="is_teacher" value="1"> <?php // Thêm cờ để file backend nhận diện ?>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên Bài Test *</label><input type="text" name="ten_baitest" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Loại bài test *</label><select name="loai_baitest" class="form-select" required><option value="dinh_ky">Kiểm tra định kỳ</option><option value="on_tap" selected>Bài ôn tập</option></select></div>
                    <div class="mb-3"><label class="form-label">Áp dụng cho Khóa học *</label>
                        <select name="id_khoahoc" class="form-select" id="add_id_khoahoc_gv" required>
                            <option value="">-- Chọn khóa học --</option>
                            <?php mysqli_data_seek($courses, 0); while ($course = $courses->fetch_assoc()): ?>
                                <option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Hoặc Lớp học cụ thể (Tùy chọn)</label>
                        <select name="id_lop" class="form-select" id="add_id_lop_gv">
                            <option value="">-- Áp dụng cho toàn khóa học --</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Thời Gian (phút) *</label><input type="number" name="thoi_gian" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Tạo</button></div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addCourseSelect = document.getElementById('add_id_khoahoc_gv');
    const addClassSelect = document.getElementById('add_id_lop_gv');

    addCourseSelect.addEventListener('change', async function() {
        const courseId = this.value;
        addClassSelect.innerHTML = '<option value="">Đang tải...</option>';
        if (courseId) {
            // Lấy danh sách lớp DỰA TRÊN KHÓA HỌC và GIẢNG VIÊN
            const response = await fetch(`./modules/cauhoi/get_classes_by_course.php?course_id=${courseId}&teacher_only=1`);
            const classes = await response.json();
            
            addClassSelect.innerHTML = '<option value="">-- Áp dụng cho toàn khóa học --</option>';
            if (classes.length > 0) {
                classes.forEach(cls => addClassSelect.add(new Option(cls.ten_lop, cls.id_lop)));
            } else {
                addClassSelect.innerHTML = '<option value="">-- Không có lớp nào của bạn trong khóa này --</option>';
            }
        } else {
             addClassSelect.innerHTML = '<option value="">-- Vui lòng chọn khóa học trước --</option>';
        }
    });
});
</script>