<?php
// File: admin/modules/lichhoc/diemdanh/diemdanh.php
if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");

$lichHocResult = $conn->query("SELECT id_lichhoc, ngay_hoc FROM lichhoc WHERE id_lop = '$lop_id' ORDER BY ngay_hoc ASC");
$lichHoc = $lichHocResult->fetch_all(MYSQLI_ASSOC);

$hocVienResult = $conn->query("SELECT hv.id_hocvien, hv.ten_hocvien, hv.email FROM hocvien hv JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien WHERE dk.id_lop = '$lop_id'");
$hocVien = $hocVienResult->fetch_all(MYSQLI_ASSOC);

$diemDanhResult = $conn->query("SELECT id_hocvien, id_lichhoc, trang_thai FROM diem_danh WHERE id_lop = '$lop_id'");
$diemDanhData = [];
while ($row = $diemDanhResult->fetch_assoc()) {
    $diemDanhData[$row['id_hocvien']][$row['id_lichhoc']] = $row['trang_thai'];
}
?>
<style>
    .attendance-table-wrapper {
        overflow-x: auto;
        max-height: 75vh;
        border: 1px solid var(--border-color);
        border-radius: 8px;
    }

    .attendance-table th,
    .attendance-table td {
        vertical-align: middle;
        text-align: center;
        min-width: 105px;
    }

    .attendance-table th:first-child,
    .attendance-table td:first-child {
        min-width: 200px;
        text-align: left;
    }

    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: #fff;
    }

    thead .sticky-col {
        background-color: #212529;
    }

    .attendance-table tbody tr:hover .sticky-col {
        background-color: #f1f1f1;
    }

    .check-all-group .btn {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
    }

    /* Custom Checkbox for Attendance */
    .attendance-check-cell {
        padding: 0.5rem !important;
    }

    .attendance-check {
        display: grid;
        place-content: center;
        width: 1.5em;
        height: 1.5em;
        border-radius: 4px;
        border: 2px solid #ced4da;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .attendance-check::before {
        content: "";
        width: 0.8em;
        height: 0.8em;
        transform: scale(0);
        transition: transform 0.2s ease;
        box-shadow: inset 1em 1em var(--brand-color);
        clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    }

    input[type="checkbox"]:checked+.attendance-check {
        border-color: var(--brand-color);
    }

    input[type="checkbox"]:checked+.attendance-check::before {
        transform: scale(1);
    }

    input[type="checkbox"] {
        display: none;
    }

    @media (max-width: 767.98px) {

        .attendance-table th:first-child,
        .attendance-table td:first-child {
            min-width: 100px;
            /* Giảm chiều rộng tối thiểu của cột học viên */
            font-size: 0.65rem;
            /* Giảm cỡ chữ để vừa vặn hơn */
        }

        .attendance-table th,
        .attendance-table td {
            vertical-align: middle;
            min-width: 50px;
            font-size: 10px;
        }

        .check-all-group .btn {
            font-size: 0.45rem;
            padding: 0.1rem 0.3rem;
        }

        .text-muted {
            font-size: 7px;
        }
    }

    @media (min-width: 1200px) {
        .card-sub-diemdanh {
            max-width: 986px;
        }
    }
</style>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Bảng điểm danh</h5>
            <div class="d-flex align-items-center gap-2">
                <input type="text" id="student-search-input" class="form-control form-control-sm" placeholder="Tìm tên học viên...">
                <a href="modules/lichhoc/diemdanh/export_attendance.php?lop_id=<?php echo htmlspecialchars($lop_id); ?>" class="btn btn-sm btn-info text-white text-nowrap"><i class="fa-solid fa-file-excel"></i> Xuất Excel</a>
                <button type="submit" form="attendanceForm" class="btn btn-sm btn-success text-nowrap"><i class="fa-solid fa-save me-2"></i>Lưu</button>
            </div>
        </div>
    </div>
    <div class="card-body card-sub-diemdanh">
        <?php if (count($lichHoc) > 0 && count($hocVien) > 0): ?>
            <form id="attendanceForm">
                <input type="hidden" name="id_lop" value="<?php echo $lop_id; ?>">
                <div class="attendance-table-wrapper">
                    <table class="table table-bordered table-hover attendance-table" id="attendance-table">
                        <thead class="table-info">
                            <tr>
                                <th class="text-start">Học viên</th>
                                <?php foreach ($lichHoc as $lich): ?>
                                    <th>
                                        <?php echo date("d/m", strtotime($lich['ngay_hoc'])); ?>
                                        <div class="mt-1 btn-group btn-group-sm check-all-group">
                                            <button type="button" class="btn btn-outline-dark" title="Check All" onclick="toggleColumn(<?php echo $lich['id_lichhoc']; ?>, true)">All</button>
                                            <button type="button" class="btn btn-outline-dark" title="Uncheck All" onclick="toggleColumn(<?php echo $lich['id_lichhoc']; ?>, false)">None</button>
                                        </div>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hocVien as $hv): ?>
                                <tr class="student-row">
                                    <td class="text-start student-name sticky-col"><strong><?php echo htmlspecialchars($hv['ten_hocvien']); ?></strong>
                                        <br>
                                        <small class="text-muted"> <?php echo htmlspecialchars($hv['email']); ?>
                                        </small>
                                    </td>
                                    <?php foreach ($lichHoc as $lich):
                                        $status = $diemDanhData[$hv['id_hocvien']][$lich['id_lichhoc']] ?? 'vang';
                                        $is_present = ($status === 'co mat');
                                        $checkbox_id = "check-{$hv['id_hocvien']}-{$lich['id_lichhoc']}";
                                    ?>
                                        <td class="attendance-check-cell">
                                            <input type="hidden" name="diemdanh[<?php echo $hv['id_hocvien']; ?>][<?php echo $lich['id_lichhoc']; ?>]" value="vang">
                                            <input type="checkbox" id="<?php echo $checkbox_id; ?>"
                                                name="diemdanh[<?php echo $hv['id_hocvien']; ?>][<?php echo $lich['id_lichhoc']; ?>]"
                                                value="co mat" data-col="<?php echo $lich['id_lichhoc']; ?>"
                                                <?php echo $is_present ? 'checked' : ''; ?>>
                                            <label for="<?php echo $checkbox_id; ?>" class="attendance-check"></label>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-light text-center">Lớp học này chưa có lịch học hoặc chưa có học viên.</div>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleColumn(colId, checkState) {
        document.querySelectorAll(`.attendance-table input[data-col="${colId}"]`).forEach(checkbox => {
            checkbox.checked = checkState;
        });
    }
</script>

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