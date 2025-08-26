<!-- file: gui_thongbao.php -->
<?php

include('../config/config.php');
$action = isset($_GET['action']) ? $_GET['action'] : ''; // Kiểm tra trạng thái hành động
?>
<div class="container my-3">
    <h1 class="text-center title-color">Thông báo</h1>

    <?php if ($action === 'send'): ?>
        <!-- Giao diện gửi thông báo -->
        <h3 class="m-4">Gửi Thông Báo Đến Học Viên</h3>
        <form action="./modules/thongbao/send_notification.php" method="POST">
            <div class="form-group">
                <label for="tieu_de">Tiêu đề:</label>
                <input type="text" name="tieu_de" id="tieu_de" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="noi_dung">Nội dung:</label>
                <textarea name="noi_dung" id="noi_dung" class="form-control" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="id_khoahoc">Khóa học:</label>
                <select name="id_khoahoc" id="id_khoahoc" class="form-control" required>
                    <option value="all">Gửi cho tất cả học viên</option>
                    <?php
                    // Tải danh sách khóa học từ cơ sở dữ liệu
                    $sql = "SELECT id_khoahoc, ten_khoahoc FROM khoahoc";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_khoahoc'] . "'>" . $row['ten_khoahoc'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_lop">Lớp học:</label>
                <select name="id_lop" id="id_lop" class="form-control">
                    <option value="all">Gửi cho tất cả lớp</option>
                    <?php
                    // Tải danh sách lớp học từ cơ sở dữ liệu
                    $sql = "SELECT id_lop, ten_lop FROM lop_hoc";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_lop'] . "'>" . $row['ten_lop'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary my-2">Gửi Thông Báo</button>
            <a href="./admin.php?nav=thongbao" class="btn btn-secondary">Quay lại</a>
        </form>

    <?php else: ?>
        <!-- Giao diện danh sách thông báo -->
        <div class="sent-notifications">
            <h3 class="">Danh Sách Thông Báo Đã Gửi</h3>
            <a href="./admin.php?nav=thongbao&action=send" class="btn btn-success mb-3">Gửi Thông Báo</a>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tiêu đề</th>
                        <th style="width: 300px;">Nội dung</th>
                        <th>Khóa học</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Lấy danh sách thông báo không trùng lặp từ cơ sở dữ liệu
                    $sql_notifications = "
        SELECT 
            thongbao.id_thongbao, 
            thongbao.tieu_de, 
            thongbao.noi_dung, 
            khoahoc.ten_khoahoc, 
            thongbao.ngay_tao
        FROM thongbao
        LEFT JOIN khoahoc ON thongbao.id_khoahoc = khoahoc.id_khoahoc
        GROUP BY thongbao.tieu_de, thongbao.noi_dung, khoahoc.ten_khoahoc, thongbao.ngay_tao
        ORDER BY thongbao.ngay_tao DESC";

                    $result_notifications = $conn->query($sql_notifications);

                    if ($result_notifications->num_rows > 0) {
                        while ($row = $result_notifications->fetch_assoc()) {
                            $ten_khoahoc = $row['ten_khoahoc'] ? htmlspecialchars($row['ten_khoahoc']) : 'Tất cả';
                            echo "<tr>
                <td>" . htmlspecialchars($row['tieu_de']) . "</td>
                
                <td>" .  html_entity_decode($row['noi_dung']) . "</td>
      
                <td>" . $ten_khoahoc . "</td>
                <td>" . htmlspecialchars($row['ngay_tao']) . "</td>
                <td>
                    <form action='modules/thongbao/delete_notification.php' method='POST' onsubmit='return confirm(\"Bạn có chắc chắn muốn xóa thông báo này?\");'>
                        <input type='hidden' name='id_thongbao' value='" . $row['id_thongbao'] . "'>
                        <button type='submit' class='btn btn-danger'> <i class='fa-solid fa-trash'></i> </button>
                    </form>
                </td>
            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Chưa có thông báo nào.</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    <?php endif; ?>
</div>


<style>
    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: inline-block;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    button[type="submit"] {
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .sent-notifications {
        margin-top: 30px;
    }
</style>