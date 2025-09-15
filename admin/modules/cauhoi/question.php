<?php
// include('../config/config.php');
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Lấy danh sách bài test
$sql = "SELECT bt.id_baitest, bt.ten_baitest, bt.ngay_tao, kh.ten_khoahoc, bt.is_placement_test 
        FROM baitest bt 
        JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
        ORDER BY bt.id_baitest DESC";
$result = $conn->query($sql);

// Lấy danh sách khóa học cho form modal
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc");
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-circle-question me-2"></i>Quản lý Bài Test</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTestModal"><i class="fa-solid fa-plus"></i> Thêm Bài Test</button>
        </div>
    </div>
    <div class="card-body">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            unset($_SESSION['message']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Tên Bài Test</th><th>Thuộc Khóa học</th><th>Ngày Tạo</th><th class="text-center">Loại Test</th><th class="text-center">Hành động</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                            <td><?php echo $row['id_baitest']; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_baitest']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></td>
                            <td class="text-center">
                                <?php if($row['is_placement_test']): ?>
                                    <span class="badge bg-primary">Test đầu vào</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Test thường</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="./admin.php?nav=ds_cauhoi&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-primary btn-sm" title="Quản lý câu hỏi"><i class="fa-solid fa-list-check"></i> Câu hỏi</a>
                                <a href="./admin.php?nav=kqhocvien&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-info btn-sm text-white" title="Xem kết quả"><i class="fa-solid fa-square-poll-vertical"></i> Kết quả</a>
                                <a href="./modules/cauhoi/delete_test.php?id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa bài test này sẽ xóa tất cả câu hỏi, đáp án và kết quả liên quan. Bạn có chắc chắn?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Thêm Bài Test mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="modules/cauhoi/add_test.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên Bài Test <span class="text-danger">*</span></label><input type="text" name="ten_baitest" class="form-control" required></div>
                    <div class="mb-3">
                        <label class="form-label">Thuộc Khóa Học <span class="text-danger">*</span></label>
                        <select name="id_khoahoc" class="form-select" required>
                            <?php mysqli_data_seek($courses, 0); while ($course = $courses->fetch_assoc()): ?>
                                <option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Thời Gian Làm Bài (phút) <span class="text-danger">*</span></label><input type="number" name="thoi_gian" class="form-control" required></div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_placement_test" value="1" id="is_placement_test">
                        <label class="form-check-label" for="is_placement_test">Đánh dấu là bài kiểm tra đầu vào</label>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>