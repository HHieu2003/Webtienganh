<?php
include('../config/config.php');


// Lấy ID bài test từ URL
if (isset($_GET['id_baitest'])) {
    $id_baitest = (int)$_GET['id_baitest'];

    // Truy vấn danh sách học viên đã làm bài test
    $sql = "SELECT 
                kq.id_ketqua,
                hv.ten_hocvien,
                hv.email,
                hv.so_dien_thoai,
                kq.diem,
                kq.ngay_lam_bai
            FROM ketquabaitest kq
            JOIN hocvien hv ON kq.id_hocvien = hv.id_hocvien
            WHERE kq.id_baitest = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_baitest);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die("ID bài test không được cung cấp.");
}
?>



<div class="container my-3">
    <h1 class="text-center title-color">Danh sách Học Viên Làm Bài Test</h1>
    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'delete_success') {
            echo "<div class='alert alert-success'>Xóa kết quả bài test thành công!</div>";
        } elseif ($_GET['status'] === 'delete_error' && isset($_GET['message'])) {
            echo "<div class='alert alert-danger'>Lỗi khi xóa kết quả: " . htmlspecialchars(urldecode($_GET['message'])) . "</div>";
        }
    }
    ?>


    <a href="./admin.php?nav=question" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Kết Quả</th>
                    <th>Tên Học Viên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Số câu đúng</th>
                    <th>Ngày Làm Bài</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_ketqua']) ?></td>
                        <td><?= htmlspecialchars($row['ten_hocvien']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['so_dien_thoai']) ?></td>
                        <td><?= number_format($row['diem'], 2) ?></td>
                        <td><?= htmlspecialchars($row['ngay_lam_bai']) ?></td>
                        <td>
                            <!-- Nút xóa học viên khỏi danh sách bài test -->
                            <a href="./modules/cauhoi/delete_result.php?id_ketqua=<?= $row['id_ketqua'] ?>&id_baitest=<?= $id_baitest ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa kết quả này?')">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Không có học viên nào làm bài test này.</div>
    <?php endif; ?>
</div>