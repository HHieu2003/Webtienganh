<?php
// File: admin/modules/lichhoc/diemdanh/diemdanh.php

if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");

// Lấy dữ liệu cần thiết (giữ nguyên)
$lichHocResult = $conn->query("SELECT id_lichhoc, ngay_hoc FROM lichhoc WHERE id_lop = '$lop_id' ORDER BY ngay_hoc ASC");
$lichHoc = $lichHocResult->fetch_all(MYSQLI_ASSOC);

$hocVienResult = $conn->query("SELECT hv.id_hocvien, hv.ten_hocvien , hv.email FROM hocvien hv JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien WHERE dk.id_lop = '$lop_id'");
$hocVien = $hocVienResult->fetch_all(MYSQLI_ASSOC);

$diemDanhResult = $conn->query("SELECT id_hocvien, id_lichhoc, trang_thai FROM diem_danh WHERE id_lop = '$lop_id'");
$diemDanhData = [];
while ($row = $diemDanhResult->fetch_assoc()) {
    $diemDanhData[$row['id_hocvien']][$row['id_lichhoc']] = $row['trang_thai'];
}
?>

<div class="card mt-4 animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bảng điểm danh</h5>
            <div class="d-flex align-items-center">
                <input type="text" id="student-search-input" class="form-control me-2" placeholder="Tìm tên học viên...">
                <a href="modules/lichhoc/diemdanh/export_attendance.php?lop_id=<?php echo htmlspecialchars($lop_id); ?>" class="text-nowrap btn btn-info text-white me-2">
                    <i class="fa-solid fa-file-excel"></i> Xuất Excel
                </a>
                <button type="submit" form="attendanceForm" class="btn btn-success text-nowrap">
                    <i class="fa-solid fa-save me-2"></i>Lưu điểm danh
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (count($lichHoc) > 0 && count($hocVien) > 0): ?>
            <form id="attendanceForm">
                <input type="hidden" name="id_lop" value="<?php echo $lop_id; ?>">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="attendance-table">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start sticky-col">Học viên</th>
                                <?php foreach ($lichHoc as $lich): ?>
                                    <th>
                                        <?php echo date("d/m", strtotime($lich['ngay_hoc'])); ?>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-light btn-sm check-all mb-1" data-col="<?php echo $lich['id_lichhoc']; ?>">All</button>
                                            <button type="button" class="btn btn-outline-light btn-sm uncheck-all" data-col="<?php echo $lich['id_lichhoc']; ?>">None</button>
                                        </div>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hocVien as $hv): ?>
                                <tr class="student-row">
                                    <td class="text-start student-name sticky-col">
                                        <strong class="d-block"> <?php echo htmlspecialchars($hv['ten_hocvien']); ?>
                                        </strong>
                                        <small class="text-muted"> <?php echo htmlspecialchars($hv['email']); ?>
                                        </small>

                                    </td>
                                    <?php foreach ($lichHoc as $lich):
                                        $status = $diemDanhData[$hv['id_hocvien']][$lich['id_lichhoc']] ?? 'vang';
                                        $is_present = ($status === 'co mat');
                                    ?>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input type="hidden" name="diemdanh[<?php echo $hv['id_hocvien']; ?>][<?php echo $lich['id_lichhoc']; ?>]" value="vang">
                                                <input type="checkbox" class="form-check-input attendance-check"
                                                    name="diemdanh[<?php echo $hv['id_hocvien']; ?>][<?php echo $lich['id_lichhoc']; ?>]"
                                                    value="co mat"
                                                    data-col="<?php echo $lich['id_lichhoc']; ?>"
                                                    <?php echo $is_present ? 'checked' : ''; ?>>
                                            </div>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">Lớp học này chưa có lịch học hoặc chưa có học viên.</div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Style để giữ cột đầu tiên cố định khi cuộn ngang */
    .table-responsive {
        max-height: 70vh;
    }

    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: #fff;
        /* Cần màu nền để che nội dung bên dưới */
    }

    .table-hover .student-row:hover .sticky-col {
        background-color: #f1f1f1;
        /* Đổi màu nền khi hover */
    }

    thead .sticky-col {
        background-color: #212529;
        /* Màu nền của thead */
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('attendance-table');
        if (!table) return;

        // Logic cho các nút All/None
        table.querySelectorAll('.check-all').forEach(button => {
            button.addEventListener('click', () => {
                const colId = button.getAttribute('data-col');
                table.querySelectorAll(`.attendance-check[data-col="${colId}"]`).forEach(checkbox => {
                    checkbox.checked = true;
                });
            });
        });
        table.querySelectorAll('.uncheck-all').forEach(button => {
            button.addEventListener('click', () => {
                const colId = button.getAttribute('data-col');
                table.querySelectorAll(`.attendance-check[data-col="${colId}"]`).forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
        });

        // Logic tìm kiếm
        const searchInput = document.getElementById('student-search-input');
        const studentRows = document.querySelectorAll('.student-row');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            studentRows.forEach(row => {
                const studentName = row.querySelector('.student-name').textContent.toLowerCase();
                row.style.display = studentName.includes(searchTerm) ? '' : 'none';
            });
        });

        // Xử lý submit form bằng AJAX
        const attendanceForm = document.getElementById('attendanceForm');
        attendanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('./modules/lichhoc/diemdanh/diemdanh_save.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                });
        });
    });
</script>