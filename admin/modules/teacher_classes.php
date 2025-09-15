<?php
// Giả định $conn và session đã có
$id_giangvien = $_SESSION['id_giangvien'];

$sql = "
    SELECT lh.id_lop, lh.ten_lop, kh.ten_khoahoc, lh.so_luong_hoc_vien, lh.trang_thai
    FROM lop_hoc lh
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE lh.id_giangvien = ?
    ORDER BY kh.ten_khoahoc, lh.ten_lop
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_giangvien);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="card animated-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fa-solid fa-school me-2"></i>Lớp học của tôi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tên Lớp</th>
                        <th>Thuộc Khóa học</th>
                        <th class="text-center">Sĩ số</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0):
                        $index = 0;
                        while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                            <td><?php echo htmlspecialchars($row['ten_lop']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                            <td class="text-center fw-bold"><?php echo $row['so_luong_hoc_vien']; ?></td>
                            <td class="text-center">
                                <?php if ($row['trang_thai'] === 'dang hoc'): ?>
                                    <span class="badge bg-success">Đang học</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Đã xong</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=schedule" class="btn btn-info btn-sm" title="Xem lịch học"><i class="fa-solid fa-calendar-days"></i></a>
                                <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=students" class="btn btn-secondary btn-sm" title="Xem học viên"><i class="fa-solid fa-users"></i></a>
                                <a href="./admin.php?nav=lichhoc&lop_id=<?php echo $row['id_lop']; ?>&view=diemdanh" class="btn btn-primary btn-sm" title="Điểm danh"><i class="fa-solid fa-user-check"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Bạn chưa được phân công lớp học nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>