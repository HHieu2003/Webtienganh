<?php
// user/modules/thongbao.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
$notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// --- Sau khi đã lấy thông báo, cập nhật trạng thái 'chưa đọc' thành 'đã đọc' ---
$sql_update_status = "UPDATE thongbao SET trang_thai = 'đã đọc' WHERE id_hocvien = ? AND trang_thai = 'chưa đọc'";
$stmt_update = $conn->prepare($sql_update_status);
$stmt_update->bind_param('i', $id_hocvien);
$stmt_update->execute();
$stmt_update->close();

// --- Logic để nhóm thông báo theo ngày ---
$grouped_notifications = [];
foreach ($notifications as $notification) {
    $date = new DateTime($notification['ngay_tao']);
    $today = new DateTime('today');
    $yesterday = new DateTime('yesterday');

    if ($date->format('Y-m-d') === $today->format('Y-m-d')) {
        $key = 'Hôm nay';
    } elseif ($date->format('Y-m-d') === $yesterday->format('Y-m-d')) {
        $key = 'Hôm qua';
    } else {
        $key = $date->format('d/m/Y');
    }
    $grouped_notifications[$key][] = $notification;
}
?>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .timeline {
        position: relative;
        padding-left: 40px;
        list-style: none;
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 15px;
        height: 100%;
        width: 3px;
        background: var(--border-color);
    }

    .timeline-group {
        margin-bottom: 30px;
        opacity: 0;
        animation: fadeIn 0.6s ease-out forwards;
    }

    .timeline-group-header {
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 15px;
        background-color: var(--light-gray-bg);
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        border: 1px solid var(--border-color);
        position: relative;
        left: -20px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 15px;
        background: #fff;
        border-radius: var(--border-radius);
        padding: 20px;
        border: 1px solid var(--border-color);
        transition: box-shadow 0.3s ease;
    }
    .timeline-item:hover {
        box-shadow: var(--shadow);
    }

    .timeline-item:before { /* The dot on the timeline */
        content: '';
        position: absolute;
        top: 25px;
        left: -33px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #fff;
        border: 4px solid var(--primary-color);
    }
    
    /* Làm nổi bật thông báo chưa đọc */
    .timeline-item.unread {
        background-color: var(--primary-color-light);
        border-left: 4px solid var(--primary-color);
    }
    .timeline-item.unread:before {
        background-color: var(--primary-color);
    }

    .timeline-item-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
    }

    .timeline-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-color-light);
        color: var(--primary-color);
        font-size: 18px;
    }

    .timeline-item-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .timeline-item-content {
        color: var(--gray-text);
        margin-bottom: 10px;
        padding-left: 55px; /* Thẳng hàng với tiêu đề */
    }
    
    .timeline-item-footer {
        font-size: 13px;
        color: #999;
        padding-left: 55px;
        text-align: right;
    }
</style>
<div class="content-pane">
    <h2 class="mb-4">Hộp thư thông báo</h2>

    <?php if (!empty($grouped_notifications)): ?>
        <ul class="timeline">
            <?php 
            $delay_index = 0;
            foreach ($grouped_notifications as $date_group => $notifications_in_group): 
            ?>
                <li class="timeline-group" style="animation-delay: <?php echo $delay_index * 150; ?>ms;">
                    <div class="timeline-group-header"><?php echo $date_group; ?></div>
                    <?php foreach ($notifications_in_group as $notification): 
                        // Kiểm tra xem thông báo có phải là chưa đọc không để thêm class CSS
                        $is_unread_class = ($notification['trang_thai'] === 'chưa đọc') ? 'unread' : '';
                    ?>
                        <div class="timeline-item <?php echo $is_unread_class; ?>">
                            <div class="timeline-item-header">
                                <div class="timeline-item-icon">
                                    <i class="fa-solid fa-bell"></i>
                                </div>
                                <h5 class="timeline-item-title"><?php echo htmlspecialchars($notification['tieu_de']); ?></h5>
                            </div>
                            <p class="timeline-item-content"><?php echo nl2br(htmlspecialchars($notification['noi_dung'])); ?></p>
                            <div class="timeline-item-footer">
                                <i class="fa-solid fa-clock"></i> <?php echo date("H:i", strtotime($notification['ngay_tao'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </li>
            <?php 
                $delay_index++;
            endforeach; 
            ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-info text-center">
             <i class="fa-solid fa-bell-slash fa-2x mb-3"></i>
             <p class="mb-0">Bạn chưa có thông báo nào.</p>
        </div>
    <?php endif; ?>
</div>