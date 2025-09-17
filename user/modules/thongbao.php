<?php
// user/modules/thongbao.php

// Giả định $conn và session đã được khởi tạo từ file dashboard.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- Lấy tất cả thông báo của học viên, sắp xếp mới nhất lên đầu ---
$sql_notifications = "
    SELECT 
        tieu_de, 
        noi_dung, 
        ngay_tao,
        trang_thai
    FROM thongbao
    WHERE id_hocvien = ?
    ORDER BY ngay_tao DESC
";

$stmt = $conn->prepare($sql_notifications);
$stmt->bind_param('i', $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

// --- Sau khi đã lấy thông báo, cập nhật trạng thái 'chưa đọc' thành 'đã đọc' ---
$sql_update_status = "UPDATE thongbao SET trang_thai = 'đã đọc' WHERE id_hocvien = ? AND trang_thai = 'chưa đọc'";
$stmt_update = $conn->prepare($sql_update_status);
$stmt_update->bind_param('i', $id_hocvien);
$stmt_update->execute();
$stmt_update->close();

?>

<style>
    .notification-list {
        list-style: none;
        padding: 0;
    }
    .notification-item {
        display: flex;
        gap: 20px;
        padding: 20px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        margin-bottom: 15px;
        background-color: #fff;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }
    .notification-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow);
    }
    .notification-item.unread {
        background-color: #e7f7ec; /* Màu nền cho thông báo chưa đọc */
        border-left: 5px solid var(--primary-color);
    }
    .notification-icon {
        font-size: 24px;
        color: var(--primary-color);
        margin-top: 5px;
    }
    .notification-content h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .notification-content p {
        margin-bottom: 10px;
        color: var(--gray-text);
    }
    .notification-content .time {
        font-size: 13px;
        color: #999;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="content-pane">
    <h2>Tất cả thông báo</h2>

    <ul class="notification-list">
        <?php if ($result->num_rows > 0): 
            $index = 0;
            while ($row = $result->fetch_assoc()):
                // Kiểm tra xem thông báo có phải là chưa đọc không để thêm class CSS
                $is_unread_class = ($row['trang_thai'] === 'chưa đọc') ? 'unread' : '';
        ?>
            <li class="notification-item <?php echo $is_unread_class; ?>" style="animation-delay: <?php echo $index * 100; ?>ms;">
                <div class="notification-icon">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div class="notification-content">
                    <h5><?php echo htmlspecialchars($row['tieu_de']); ?></h5>
                    <p><?php echo htmlspecialchars($row['noi_dung']); ?></p>
                    <span class="time"><i class="fa-solid fa-clock"></i> <?php echo date("H:i, d/m/Y", strtotime($row['ngay_tao'])); ?></span>
                </div>
            </li>
        <?php 
            $index++;
            endwhile; 
        ?>
        <?php else: ?>
            <div class="alert alert-info text-center">Bạn chưa có thông báo nào.</div>
        <?php endif; ?>
    </ul>
</div>