<?php
include('../config/config.php');

// Kiểm tra nếu `id_khoahoc` được truyền qua URL
if (!isset($_GET['id_khoahoc'])) {
    die("Không tìm thấy thông tin khóa học.");
}

$id_khoahoc = (int)$_GET['id_khoahoc'];

// Lấy thông tin lịch học của khóa học
$sql_schedule = "
    SELECT lh.ngay_hoc, lh.gio_bat_dau, lh.gio_ket_thuc, lh.phong_hoc, lh.ghi_chu, l.ten_lop
    FROM lichhoc lh
    JOIN lop_hoc l ON lh.id_lop = l.id_lop
    WHERE l.id_khoahoc = ?
    ORDER BY lh.ngay_hoc ASC, lh.gio_bat_dau ASC
";
$stmt = mysqli_prepare($conn, $sql_schedule);
mysqli_stmt_bind_param($stmt, 'i', $id_khoahoc);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Lấy thông tin khóa học
$sql_course = "SELECT ten_khoahoc FROM khoahoc WHERE id_khoahoc = ?";
$stmt_course = mysqli_prepare($conn, $sql_course);
mysqli_stmt_bind_param($stmt_course, 'i', $id_khoahoc);
mysqli_stmt_execute($stmt_course);
$result_course = mysqli_stmt_get_result($stmt_course);

if ($row_course = mysqli_fetch_assoc($result_course)) {
    $ten_khoahoc = $row_course['ten_khoahoc'];
} else {
    die("Khóa học không tồn tại.");
}
?>
<div class="container my-4">
    <h1 class="text-center introduce-title">Lịch Học</h1>
    <h3 class="fs-5" style="    font-weight: bold;
    margin-bottom: 19px;"><?= htmlspecialchars($ten_khoahoc) ?>:</h3>

    <!-- <div class="text-end my-3">
        <a href="../index.php" class="btn btn-secondary">Quay lại</a>
    </div> -->

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Ngày Học</th>
                    <th>Giờ Bắt Đầu</th>
                    <th>Giờ Kết Thúc</th>
                    <th>Phòng Học</th>
                    <th>Lớp</th>
                    <th>Ghi Chú</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ngay_hoc']) ?></td>
                        <td><?= htmlspecialchars($row['gio_bat_dau']) ?></td>
                        <td><?= htmlspecialchars($row['gio_ket_thuc']) ?></td>
                        <td><?= htmlspecialchars($row['phong_hoc']) ?></td>
                        <td><?= htmlspecialchars($row['ten_lop']) ?></td>
                        <td><?= htmlspecialchars($row['ghi_chu']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">Không có lịch học cho khóa học này.</div>
    <?php endif; ?>
</div>
