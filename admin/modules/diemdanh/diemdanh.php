<?php
// Giả định $conn và $lop_id đã có từ file lichhoc.php
if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");

// Lấy thông tin lịch học của lớp
$lichHocResult = $conn->query("SELECT id_lichhoc, ngay_hoc FROM lichhoc WHERE id_lop = '$lop_id' ORDER BY ngay_hoc ASC");
$lichHoc = $lichHocResult->fetch_all(MYSQLI_ASSOC);

// Lấy danh sách học viên của lớp
$hocVienResult = $conn->query("SELECT hv.id_hocvien, hv.ten_hocvien FROM hocvien hv JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien WHERE dk.id_lop = '$lop_id'");
$hocVien = $hocVienResult->fetch_all(MYSQLI_ASSOC);

// Lấy dữ liệu điểm danh hiện tại
$diemDanhResult = $conn->query("SELECT id_hocvien, id_lichhoc, trang_thai FROM diem_danh WHERE id_lop = '$lop_id'");
$diemDanhData = [];
while ($row = $diemDanhResult->fetch_assoc()) {
    $diemDanhData[$row['id_hocvien']][$row['id_lichhoc']] = $row['trang_thai'];
}
?>

<div class="card mt-4 animated-card">
    <form action="modules/diemdanh/diemdanh_save.php" method="POST">
        <input type="hidden" name="id_lop" value="<?php echo $lop_id; ?>">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bảng điểm danh</h5>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-save me-2"></i>Lưu điểm danh</button>
        </div>
        <div class="card-body">
            <?php if (count($lichHoc) > 0 && count($hocVien) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="attendance-table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Học viên</th>
                            <?php foreach ($lichHoc as $lich): ?>
                                <th>
                                    <?php echo date("d/m", strtotime($lich['ngay_hoc'])); ?>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-outline-success btn-sm check-all" data-col="<?php echo $lich['id_lichhoc']; ?>">All</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm uncheck-all" data-col="<?php echo $lich['id_lichhoc']; ?>">None</button>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hocVien as $hv): ?>
                            <tr>
                                <td class="text-start fw-bold"><?php echo htmlspecialchars($hv['ten_hocvien']); ?></td>
                                <?php foreach ($lichHoc as $lich): ?>
                                    <?php
                                    $status = $diemDanhData[$hv['id_hocvien']][$lich['id_lichhoc']] ?? 'vang'; // Mặc định là vắng
                                    $is_present = ($status === 'co mat');
                                    ?>
                                    <td>
                                        <input type="hidden" name="diemdanh[<?php echo $hv['id_hocvien']; ?>][<?php echo $lich['id_lichhoc']; ?>]" value="vang">
                                        <input type="checkbox" class="form-check-input attendance-check" 
                                               name="diemdanh[<?php echo $hv['id_hocvien']; ?>][<?php echo $lich['id_lichhoc']; ?>]" 
                                               value="co mat" 
                                               data-col="<?php echo $lich['id_lichhoc']; ?>"
                                               <?php echo $is_present ? 'checked' : ''; ?>>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">Lớp học này chưa có lịch học hoặc chưa có học viên. Vui lòng thêm lịch học và học viên trước khi điểm danh.</div>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('attendance-table');
    if (!table) return;

    // Xử lý nút "Check All"
    table.querySelectorAll('.check-all').forEach(button => {
        button.addEventListener('click', function() {
            const colId = this.getAttribute('data-col');
            table.querySelectorAll(`.attendance-check[data-col="${colId}"]`).forEach(checkbox => {
                checkbox.checked = true;
            });
        });
    });

    // Xử lý nút "Uncheck All"
    table.querySelectorAll('.uncheck-all').forEach(button => {
        button.addEventListener('click', function() {
            const colId = this.getAttribute('data-col');
            table.querySelectorAll(`.attendance-check[data-col="${colId}"]`).forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    });
});
</script>