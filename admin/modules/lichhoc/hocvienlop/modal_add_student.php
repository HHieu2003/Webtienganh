<style>
    #student-list-container { max-height: 350px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 8px; padding: 0.5rem; }
    .student-item { display: flex; align-items: center; padding: 0.75rem 1rem; border-radius: 6px; transition: background-color 0.2s ease; }
    .student-item:hover { background-color: #f8f9fa; }
    .student-item input[type="checkbox"] { transform: scale(1.2); margin-right: 1rem; }
    .student-item label { cursor: pointer; width: 100%; }
    .student-item .student-name { font-weight: 500; color: var(--dark-text); }
    .student-item .student-email { font-size: 0.85rem; color: var(--gray-text); }
</style>

<div class="modal fade" id="addStudentToClassModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fa-solid fa-user-plus me-2"></i>Thêm học viên vào lớp</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="addStudentToClassForm">
                <input type="hidden" name="id_lop" value="<?php echo htmlspecialchars($lop_id ?? ''); ?>">
                <div class="modal-body">
                    <?php if ($eligible_students && $eligible_students->num_rows > 0): ?>
                        <div class="mb-3"><input type="text" id="student-search-in-modal" class="form-control" placeholder="🔍 Tìm kiếm học viên trong danh sách..."></div>
                        <div id="student-list-container">
                            <?php foreach ($eligible_students as $student): ?>
                                <div class="student-item" data-name="<?php echo strtolower(htmlspecialchars($student['ten_hocvien'])); ?>">
                                    <input class="form-check-input" type="checkbox" name="id_hocvien_list[]" value="<?php echo $student['id_hocvien']; ?>" id="student-check-<?php echo $student['id_hocvien']; ?>">
                                    <label class="form-check-label" for="student-check-<?php echo $student['id_hocvien']; ?>">
                                        <div class="student-name"><?php echo htmlspecialchars($student['ten_hocvien']); ?></div>
                                        <div class="student-email"><?php echo htmlspecialchars($student['email']); ?></div>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">Không có học viên nào đang chờ xếp lớp cho khóa học này.</div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <?php if ($eligible_students && $eligible_students->num_rows > 0): ?>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-check me-2"></i>Xác nhận thêm</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>