<?php
// File: admin/modules/lichhoc/diemso/view_grades.php
if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");

$hocVienResult = $conn->query("SELECT hv.id_hocvien, hv.ten_hocvien FROM hocvien hv JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien WHERE dk.id_lop = '$lop_id' ORDER BY hv.ten_hocvien ASC");
$hocVien = $hocVienResult->fetch_all(MYSQLI_ASSOC);

$loaiDiemResult = $conn->query("SELECT DISTINCT loai_diem FROM diem_so WHERE id_lop = '$lop_id' ORDER BY loai_diem ASC");
$loaiDiem = $loaiDiemResult->fetch_all(MYSQLI_ASSOC);

$diemSoResult = $conn->query("SELECT id_hocvien, loai_diem, diem, nhan_xet FROM diem_so WHERE id_lop = '$lop_id'");
$diemSoData = [];
while ($row = $diemSoResult->fetch_assoc()) {
    $diemSoData[$row['id_hocvien']][$row['loai_diem']] = ['diem' => $row['diem'], 'nhan_xet' => $row['nhan_xet']];
}
?>
<style>
    .grade-table th, .grade-table td { vertical-align: middle; }
    .grade-table th .delete-column-btn { cursor: pointer; color: #ffc107; font-size: 0.8em; margin-left: 8px; visibility: hidden; }
    .grade-table th:hover .delete-column-btn { visibility: visible; }
    .grade-table th .delete-column-btn:hover { color: #dc3545; }
    .grade-table input { border-radius: 6px; border: 1px solid #ccc; padding: 5px; text-align: center; width: 80px; }
    .grade-table .comment-icon { cursor: pointer; color: #6c757d; }
    .grade-table .comment-icon:hover, .grade-table .comment-icon.has-comment { color: var(--primary-color); }
</style>

<div class="card mt-4 animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bảng điểm lớp</h5>
            <div class="d-flex gap-2">
                <input type="text" id="new-grade-type" class="form-control form-control-sm" placeholder="Nhập tên cột điểm mới..." style="width: 200px;">
                <button id="add-grade-type-btn" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-plus"></i> Thêm cột</button>
                <button type="submit" form="gradesForm" class="btn btn-sm btn-success"><i class="fa-solid fa-save me-2"></i>Lưu Bảng Điểm</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (count($hocVien) > 0): ?>
            <form id="gradesForm">
                <input type="hidden" name="id_lop" value="<?php echo htmlspecialchars($lop_id); ?>">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center grade-table" id="grade-table">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-start" style="width: 250px;">Học viên</th>
                                <?php foreach ($loaiDiem as $ld): ?>
                                    <th data-grade-type="<?php echo htmlspecialchars($ld['loai_diem']); ?>">
                                        <?php echo htmlspecialchars($ld['loai_diem']); ?>
                                        <i class="fa-solid fa-trash-can delete-column-btn" title="Xóa cột điểm này"></i>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hocVien as $hv): ?>
                                <tr data-student-id="<?php echo $hv['id_hocvien']; ?>">
                                    <td class="text-start sticky-col"><strong><?php echo htmlspecialchars($hv['ten_hocvien']); ?></strong></td>
                                    <?php foreach ($loaiDiem as $ld):
                                        $diem = $diemSoData[$hv['id_hocvien']][$ld['loai_diem']]['diem'] ?? '';
                                        $nhan_xet = $diemSoData[$hv['id_hocvien']][$ld['loai_diem']]['nhan_xet'] ?? '';
                                    ?>
                                        <td>
                                            <div class="input-group input-group-sm justify-content-center">
                                                <input type="text" 
                                                       name="grades[<?php echo $hv['id_hocvien']; ?>][<?php echo htmlspecialchars($ld['loai_diem']); ?>][diem]" 
                                                       class="form-control" value="<?php echo htmlspecialchars($diem); ?>">
                                                <button class="btn btn-outline-secondary comment-icon <?php if(!empty($nhan_xet)) echo 'has-comment'; ?>" 
                                                        type="button" title="Thêm/Sửa nhận xét"
                                                        data-student-id="<?php echo $hv['id_hocvien']; ?>"
                                                        data-grade-type="<?php echo htmlspecialchars($ld['loai_diem']); ?>">
                                                    <i class="fa-solid fa-comment"></i>
                                                </button>
                                                <input type="hidden" 
                                                       class="comment-hidden-input"
                                                       id="comment-<?php echo $hv['id_hocvien']; ?>-<?php echo htmlspecialchars(preg_replace('/[^a-zA-Z0-9]/', '_', $ld['loai_diem'])); ?>"
                                                       name="grades[<?php echo $hv['id_hocvien']; ?>][<?php echo htmlspecialchars($ld['loai_diem']); ?>][nhan_xet]" 
                                                       value="<?php echo htmlspecialchars($nhan_xet); ?>">
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
            <div class="alert alert-info text-center">Chưa có học viên nào trong lớp để chấm điểm.</div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="commentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nhận xét</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <textarea id="commentText" class="form-control" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="saveCommentBtn" class="btn btn-primary">Lưu nhận xét</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentCommentInput = null;
    const commentModalEl = document.getElementById('commentModal');
    const commentModal = new bootstrap.Modal(commentModalEl);

    const gradeTable = document.getElementById('grade-table');
    if (gradeTable) {
        gradeTable.addEventListener('click', function(e) {
            const commentBtn = e.target.closest('.comment-icon');
            if (commentBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const studentId = commentBtn.dataset.studentId;
                const gradeType = commentBtn.dataset.gradeType;
                
                // Lưu thông tin vào modal để dùng lúc lưu
                commentModalEl.dataset.studentId = studentId;
                commentModalEl.dataset.gradeType = gradeType;

                const gradeTypeClean = gradeType.replace(/[^a-zA-Z0-9\s]/g, '_').replace(/\s/g, '_');
                currentCommentInput = document.getElementById(`comment-${studentId}-${gradeTypeClean}`);
                document.getElementById('commentText').value = currentCommentInput ? currentCommentInput.value : '';
                commentModal.show();
            }

            const deleteBtn = e.target.closest('.delete-column-btn');
            if (deleteBtn) {
                const headerCell = deleteBtn.closest('th');
                const gradeTypeToDelete = headerCell.dataset.gradeType;
                const colIndex = Array.from(headerCell.parentElement.children).indexOf(headerCell);

                Swal.fire({
                    title: 'Xác nhận xóa cột',
                    text: `Bạn có chắc muốn xóa vĩnh viễn cột điểm "${gradeTypeToDelete}" và tất cả điểm số trong đó không?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Chắc chắn xóa'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('./modules/lichhoc/diemso/delete_grades_column.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id_lop: '<?php echo $lop_id; ?>', loai_diem: gradeTypeToDelete })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                headerCell.remove();
                                document.querySelectorAll('#grade-table tbody tr').forEach(row => {
                                    row.querySelector(`td:nth-child(${colIndex + 1})`).remove();
                                });
                                Swal.fire('Đã xóa!', data.message, 'success');
                            } else { Swal.fire('Lỗi!', data.message, 'error'); }
                        });
                    }
                });
            }
        });
    }

    // *** BẮT ĐẦU NÂNG CẤP: XỬ LÝ LƯU NHẬN XÉT NGAY LẬP TỨC ***
    document.getElementById('saveCommentBtn').addEventListener('click', function() {
        this.disabled = true; // Vô hiệu hóa nút để tránh click nhiều lần
        const studentId = commentModalEl.dataset.studentId;
        const gradeType = commentModalEl.dataset.gradeType;
        const commentText = document.getElementById('commentText').value;
        const lopId = document.querySelector('input[name="id_lop"]').value;

        const formData = new FormData();
        formData.append('id_lop', lopId);
        formData.append('id_hocvien', studentId);
        formData.append('loai_diem', gradeType);
        formData.append('nhan_xet', commentText);

        fetch('./modules/lichhoc/diemso/save_single_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Cập nhật lại giao diện
                const gradeTypeClean = gradeType.replace(/[^a-zA-Z0-9\s]/g, '_').replace(/\s/g, '_');
                currentCommentInput = document.getElementById(`comment-${studentId}-${gradeTypeClean}`);
                if (currentCommentInput) {
                    currentCommentInput.value = commentText;
                    const iconButton = currentCommentInput.closest('.input-group').querySelector('.comment-icon');
                    if (iconButton) {
                        if (commentText.trim() !== '') {
                            iconButton.classList.add('has-comment');
                        } else {
                            iconButton.classList.remove('has-comment');
                        }
                    }
                }
                commentModal.hide();
                // (Tùy chọn) Hiển thị thông báo nhỏ thành công
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                Toast.fire({ icon: 'success', title: 'Đã lưu nhận xét' });

            } else {
                Swal.fire('Lỗi!', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
        })
        .finally(() => {
            this.disabled = false; // Kích hoạt lại nút sau khi hoàn tất
        });
    });
    // *** KẾT THÚC NÂNG CẤP ***
    
    document.getElementById('add-grade-type-btn').addEventListener('click', function() {
        const newGradeTypeInput = document.getElementById('new-grade-type');
        const newGradeType = newGradeTypeInput.value.trim();
        if (newGradeType === '') {
            Swal.fire('Lỗi', 'Vui lòng nhập tên cột điểm mới.', 'error'); return;
        }
        
        const table = document.getElementById('grade-table');
        const headerRow = table.querySelector('thead tr');
        
        if (headerRow.querySelector(`th[data-grade-type="${newGradeType}"]`)) {
            Swal.fire('Lỗi', 'Tên cột điểm này đã tồn tại.', 'error'); return;
        }
        
        const newHeader = document.createElement('th');
        newHeader.dataset.gradeType = newGradeType;
        newHeader.innerHTML = `${newGradeType} <i class="fa-solid fa-trash-can delete-column-btn" title="Xóa cột điểm này"></i>`;
        headerRow.appendChild(newHeader);
        
        table.querySelectorAll('tbody tr').forEach(row => {
            const studentId = row.dataset.studentId; 
            const newCell = document.createElement('td');
            const gradeTypeClean = newGradeType.replace(/[^a-zA-Z0-9\s]/g, '_').replace(/\s/g, '_');
            const safeGradeType = newGradeType.replace(/'/g, "\\'");

            newCell.innerHTML = `
                <div class="input-group input-group-sm justify-content-center">
                    <input type="text" name="grades[${studentId}][${newGradeType}][diem]" class="form-control">
                    <button class="btn btn-outline-secondary comment-icon" type="button" title="Thêm/Sửa nhận xét" data-student-id="${studentId}" data-grade-type="${safeGradeType}">
                        <i class="fa-solid fa-comment"></i>
                    </button>
                    <input type="hidden" class="comment-hidden-input" id="comment-${studentId}-${gradeTypeClean}" name="grades[${studentId}][${newGradeType}][nhan_xet]" value="">
                </div>`;
            row.appendChild(newCell);
        });
        
        newGradeTypeInput.value = '';
    });

    const gradesForm = document.getElementById('gradesForm');
    if (gradesForm) {
        gradesForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new URLSearchParams(new FormData(this)).toString();
            
            fetch('./modules/lichhoc/diemso/save_grades.php', { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData 
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Thành công!', 
                        text: data.message, 
                        timer: 1500, 
                        showConfirmButton: false 
                    }).then(() => {
                        location.reload();
                    });
                } else { Swal.fire('Lỗi!', data.message, 'error'); }
            });
        });
    }
});
</script>