<?php
// include('../config/config.php');
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$id_baitest = (int)($_GET['id_baitest'] ?? 0);
if ($id_baitest === 0) die("ID bài test không hợp lệ.");

// Lấy thông tin bài test
$stmt_test = $conn->prepare("SELECT ten_baitest, (SELECT COUNT(*) FROM cauhoi WHERE id_baitest = ?) as total_questions FROM baitest WHERE id_baitest = ?");
$stmt_test->bind_param("ii", $id_baitest, $id_baitest);
$stmt_test->execute();
$test_info = $stmt_test->get_result()->fetch_assoc();
$total_questions = $test_info['total_questions'] ?? 0;

// Lấy danh sách kết quả
$sql = "SELECT kq.id_ketqua, hv.ten_hocvien, hv.email, kq.diem, kq.ngay_lam_bai
        FROM ketquabaitest kq
        JOIN hocvien hv ON kq.id_hocvien = hv.id_hocvien
        WHERE kq.id_baitest = ? ORDER BY kq.diem DESC, kq.ngay_lam_bai DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_baitest);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="d-flex align-items-center mb-3">
    <a href="./admin.php?nav=question" class="btn btn-secondary me-3"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
    <h1 class="title-color mb-0" style="border: none; padding: 0; margin: 0;">Kết quả: <?php echo htmlspecialchars($test_info['ten_baitest']); ?></h1>
</div>

<div class="card animated-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>Tên Học Viên</th><th>Email</th><th class="text-center">Kết quả</th><th class="text-center">Ngày Làm Bài</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ten_hocvien']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="text-center fw-bold"><?php echo (int)$row['diem'] . " / " . $total_questions; ?></td>
                            <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_lam_bai'])); ?></td>
                            <td class="text-center">
                                <a href="./modules/cauhoi/delete_result.php?id_ketqua=<?php echo $row['id_ketqua']; ?>&id_baitest=<?php echo $id_baitest; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa kết quả này?');" title="Xóa kết quả">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Chưa có học viên nào làm bài test này.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>