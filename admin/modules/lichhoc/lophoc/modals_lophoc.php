<div class="modal fade" id="addClassModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Thêm Lớp học mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form id="addClassForm">
        <div class="modal-body">
            <div class="form-floating mb-3"><input type="text" name="id_lop" class="form-control" placeholder="ID Lớp" required><label>ID Lớp *</label></div>
            <div class="form-floating mb-3"><input type="text" name="ten_lop" class="form-control" placeholder="Tên Lớp" required><label>Tên Lớp *</label></div>
            <div class="form-floating mb-3"><select name="id_khoahoc" class="form-select" required><?php mysqli_data_seek($courses, 0); while ($course = $courses->fetch_assoc()) { echo "<option value='{$course['id_khoahoc']}'>" . htmlspecialchars($course['ten_khoahoc']) . "</option>"; } ?></select><label>Thuộc Khóa Học *</label></div>
            <div class="form-floating mb-3"><select name="id_giangvien" class="form-select"><option value="">-- Chưa phân công --</option><?php mysqli_data_seek($lecturers, 0); while ($lecturer = $lecturers->fetch_assoc()) { echo "<option value='{$lecturer['id_giangvien']}'>" . htmlspecialchars($lecturer['ten_giangvien']) . "</option>"; } ?></select><label>Phân công Giảng Viên</label></div>
            <div class="form-floating mb-3"><select name="trang_thai" class="form-select"><option value="dang hoc">Đang học</option><option value="da xong">Đã xong</option></select><label>Trạng Thái</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm Lớp</button></div>
    </form>
</div></div></div>

<div class="modal fade" id="editClassModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Chỉnh sửa Lớp học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form id="editClassForm">
        <input type="hidden" name="edit_id_lop" id="edit_id_lop">
        <div class="modal-body">
            <div class="form-floating mb-3"><input type="text" name="edit_ten_lop" id="edit_ten_lop" class="form-control" placeholder="Tên Lớp" required><label>Tên Lớp *</label></div>
            <div class="form-floating mb-3"><select name="edit_id_giangvien" id="edit_id_giangvien" class="form-select"><option value="">-- Chưa phân công --</option><?php mysqli_data_seek($lecturers, 0); while ($lecturer = $lecturers->fetch_assoc()) { echo "<option value='{$lecturer['id_giangvien']}'>" . htmlspecialchars($lecturer['ten_giangvien']) . "</option>"; } ?></select><label>Giảng Viên</label></div>
            <div class="form-floating mb-3"><select name="edit_trang_thai" id="edit_trang_thai" class="form-select"><option value="dang hoc">Đang học</option><option value="da xong">Đã xong</option></select><label>Trạng Thái</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
    </form>
</div></div></div>