<?php
// Kết nối cơ sở dữ liệu
include('../config/config.php');

// Xử lý thêm lịch học
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_schedule'])) {
    $ngay_hoc = $_POST['ngay_hoc'];
    $gio_bat_dau = $_POST['gio_bat_dau'];
    $gio_ket_thuc = $_POST['gio_ket_thuc'];
    $phong_hoc = $_POST['phong_hoc'];
    $ghi_chu = $_POST['ghi_chu'];

    $sql_insert = "INSERT INTO lichhoc (id_lop, ngay_hoc, gio_bat_dau, gio_ket_thuc, phong_hoc, ghi_chu) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt, 'ssssss', $lop_id, $ngay_hoc, $gio_bat_dau, $gio_ket_thuc, $phong_hoc, $ghi_chu);
    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='alert alert-success'>Thêm lịch học thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
    }
}

// Xử lý sửa lịch học
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_schedule'])) {
    $id_lichhoc = $_POST['id_lichhoc'];
    $ngay_hoc = $_POST['ngay_hoc'];
    $gio_bat_dau = $_POST['gio_bat_dau'];
    $gio_ket_thuc = $_POST['gio_ket_thuc'];
    $phong_hoc = $_POST['phong_hoc'];
    $ghi_chu = $_POST['ghi_chu'];

    $sql_update = "UPDATE lichhoc 
                   SET ngay_hoc = ?, gio_bat_dau = ?, gio_ket_thuc = ?, phong_hoc = ?, ghi_chu = ? 
                   WHERE id_lichhoc = ?";
    $stmt = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt, 'sssssi', $ngay_hoc, $gio_bat_dau, $gio_ket_thuc, $phong_hoc, $ghi_chu, $id_lichhoc);
    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='alert alert-success'>Cập nhật lịch học thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
    }
}

// Xử lý xóa lịch học
if (isset($_GET['delete_id'])) {
    $id_lichhoc = $_GET['delete_id'];

    $sql_delete = "DELETE FROM lichhoc WHERE id_lichhoc = ?";
    $stmt = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt, 'i', $id_lichhoc);
    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='alert alert-success'>Xóa lịch học thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
    }
}

// Lấy danh sách lịch học
$sql_schedule = "SELECT * FROM lichhoc WHERE id_lop = ?";
$stmt = mysqli_prepare($conn, $sql_schedule);
mysqli_stmt_bind_param($stmt, 's', $lop_id);
mysqli_stmt_execute($stmt);
$schedules = mysqli_stmt_get_result($stmt);
?>
    <button class="btn btn-primary my-1" id="btn-add-schedule"><a href="./admin.php?nav=lichhoc&lop_id=<?= $lop_id ?>&view=schedule" style="color: #fff;padding: 10px;">Thêm lịch học </a></button>
<!-- Hiển thị lịch học -->
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Ngày học</th>
            <th>Giờ bắt đầu</th>
            <th>Giờ kết thúc</th>
            <th>Phòng học</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($schedule = mysqli_fetch_assoc($schedules)): ?>
            <tr>
                <td><?= htmlspecialchars($schedule['ngay_hoc']) ?></td>
                <td><?= htmlspecialchars($schedule['gio_bat_dau']) ?></td>
                <td><?= htmlspecialchars($schedule['gio_ket_thuc']) ?></td>
                <td><?= htmlspecialchars($schedule['phong_hoc']) ?></td>
                <td><?= htmlspecialchars($schedule['ghi_chu']) ?></td>
                <td>
                    <a href="./admin.php?nav=lichhoc&view=schedule&lop_id=<?= $lop_id ?>&edit_id=<?= $schedule['id_lichhoc'] ?>" 
                       class="btn btn-warning btn-sm">Sửa</a>
                    <a href="./admin.php?nav=lichhoc&&view=schedule&lop_id=<?= $lop_id ?>&delete_id=<?= $schedule['id_lichhoc'] ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa lịch học này?');">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Form thêm hoặc sửa lịch học -->
<div class="my-3">
    <h3><?= isset($_GET['edit_id']) ? "Sửa lịch học" : "Thêm lịch học" ?></h3>
    <?php
    $edit_data = [];
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM lichhoc WHERE id_lichhoc = ?";
        $stmt_edit = mysqli_prepare($conn, $sql_edit);
        mysqli_stmt_bind_param($stmt_edit, 'i', $edit_id);
        mysqli_stmt_execute($stmt_edit);
        $edit_data = mysqli_stmt_get_result($stmt_edit)->fetch_assoc();
    }
    ?>
    <form method="POST">
        <?php if (isset($edit_data['id_lichhoc'])): ?>
            <input type="hidden" name="id_lichhoc" value="<?= $edit_data['id_lichhoc'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label for="ngay_hoc">Ngày học</label>
            <input type="date" id="ngay_hoc" name="ngay_hoc" class="form-control" 
                   value="<?= $edit_data['ngay_hoc'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="gio_bat_dau">Giờ bắt đầu</label>
            <input type="time" id="gio_bat_dau" name="gio_bat_dau" class="form-control" 
                   value="<?= $edit_data['gio_bat_dau'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="gio_ket_thuc">Giờ kết thúc</label>
            <input type="time" id="gio_ket_thuc" name="gio_ket_thuc" class="form-control" 
                   value="<?= $edit_data['gio_ket_thuc'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="phong_hoc">Phòng học</label>
            <input type="text" id="phong_hoc" name="phong_hoc" class="form-control" 
                   value="<?= $edit_data['phong_hoc'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="ghi_chu">Ghi chú</label>
            <textarea id="ghi_chu" name="ghi_chu" class="form-control"><?= $edit_data['ghi_chu'] ?? '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-success" 
                name="<?= isset($edit_data['id_lichhoc']) ? 'edit_schedule' : 'add_schedule' ?>">
            <?= isset($edit_data['id_lichhoc']) ? "Cập nhật" : "Thêm mới" ?>
        </button>
    </form>
</div>  