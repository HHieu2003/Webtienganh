<div class="modal fade" id="addScheduleModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Thêm buổi học mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form id="addScheduleForm">
        <input type="hidden" name="id_lop" value="<?php echo htmlspecialchars($lop_id ?? ''); ?>">
        <div class="modal-body">
            <div class="form-floating mb-3"><input type="date" name="ngay_hoc" class="form-control" required><label>Ngày học</label></div>
            <div class="row"><div class="col-6 mb-3"><div class="form-floating"><input type="time" name="gio_bat_dau" class="form-control" required><label>Giờ bắt đầu</label></div></div><div class="col-6 mb-3"><div class="form-floating"><input type="time" name="gio_ket_thuc" class="form-control" required><label>Giờ kết thúc</label></div></div></div>
            <div class="form-floating mb-3"><input type="text" name="phong_hoc" class="form-control" placeholder="Phòng học" required><label>Phòng học (hoặc link online)</label></div>
            <div class="form-floating mb-3"><textarea name="ghi_chu" class="form-control" placeholder="Ghi chú"></textarea><label>Ghi chú</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
    </form>
</div></div></div>

<div class="modal fade" id="editScheduleModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Chỉnh sửa buổi học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form id="editScheduleForm">
        <input type="hidden" name="id_lop" value="<?php echo htmlspecialchars($lop_id ?? ''); ?>">
        <input type="hidden" name="edit_id_lichhoc" id="edit_id_lichhoc">
        <div class="modal-body">
            <div class="form-floating mb-3"><input type="date" id="edit_ngay_hoc" name="ngay_hoc" class="form-control" required><label>Ngày học</label></div>
            <div class="row"><div class="col-6 mb-3"><div class="form-floating"><input type="time" id="edit_gio_bat_dau" name="gio_bat_dau" class="form-control" required><label>Giờ bắt đầu</label></div></div><div class="col-6 mb-3"><div class="form-floating"><input type="time" id="edit_gio_ket_thuc" name="gio_ket_thuc" class="form-control" required><label>Giờ kết thúc</label></div></div></div>
            <div class="form-floating mb-3"><input type="text" id="edit_phong_hoc" name="phong_hoc" class="form-control" placeholder="Phòng học" required><label>Phòng học</label></div>
            <div class="form-floating mb-3"><textarea id="edit_ghi_chu" name="ghi_chu" class="form-control" placeholder="Ghi chú"></textarea><label>Ghi chú</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu</button></div>
    </form>
</div></div></div>