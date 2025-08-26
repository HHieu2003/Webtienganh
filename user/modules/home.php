<?php

$id_hocvien = $_SESSION['id_hocvien']; // Cần đảm bảo session được thiết lập đúng

// Lấy danh sách các khóa học đã đăng ký của học viên
$sql = "
SELECT dk.id_dangky, kh.ten_khoahoc, kh.mo_ta, kh.giang_vien, kh.thoi_gian, kh.chi_phi
FROM dangkykhoahoc dk
JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
WHERE dk.id_hocvien = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

?>

    <div class="container mt-5">
        <h2 class="mb-4 introduce-title">Danh sách các khóa học mới đăng ký</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Tên Khóa Học</th>
                    <th>Giảng Viên</th>
                    <th>Thời Gian</th>
                    <th>Chi Phí</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ten_khoahoc']) ?></td>
                        <td><?= htmlspecialchars($row['giang_vien']) ?></td>
                        <td><?= htmlspecialchars($row['thoi_gian']) ?> buổi</td>
                        <td><?= htmlspecialchars(number_format($row['chi_phi'], 2)) ?> VND</td>
                        <td>
                            <form action="modules/delete_course.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id_dangky" value="<?= $row['id_dangky'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hủy</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<?php
$stmt->close();
$conn->close();
?>