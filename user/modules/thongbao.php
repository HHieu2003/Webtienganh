<?php
// user/modules/thongbao.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ. Vui lòng đăng nhập lại.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- Pagination settings ---
$notifications_per_page = 10;
$current_page = isset($_GET['notif_page']) ? max(1, intval($_GET['notif_page'])) : 1;
$offset = ($current_page - 1) * $notifications_per_page;

// --- Count total notifications ---
$sql_count = "SELECT COUNT(*) as total FROM thongbao WHERE id_hocvien = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param('i', $id_hocvien);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_notifications = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_notifications / $notifications_per_page);

// --- Lấy thông báo của học viên với phân trang ---
$sql_notifications = "
    SELECT 
        tieu_de, 
        noi_dung, 
        ngay_tao,
        trang_thai
    FROM thongbao
    WHERE id_hocvien = ?
    ORDER BY ngay_tao DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql_notifications);
$stmt->bind_param('iii', $id_hocvien, $notifications_per_page, $offset);
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
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    .timeline-item:before {
        /* The dot on the timeline */
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
        padding-left: 55px;
        /* Thẳng hàng với tiêu đề */
    }

    .timeline-item-footer {
        font-size: 13px;
        color: #999;
        padding-left: 55px;
        text-align: right;
    }

    /* Notification Pagination Styles */
    .notif-pagination-container {

        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
    }

    .notif-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #66eabaff 0%, #4ba254ff 100%);
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.25);
        backdrop-filter: blur(10px);
    }

    .notif-pagination-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        border: none;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .notif-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: var(--primary-color-dark);
    }

    .notif-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .notif-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0 10px;
    }

    .notif-pagination-number {
        min-width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .notif-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .notif-pagination-number.active {
        background: #fff;
        color: var(--primary-color-dark);
        border-color: #fff;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        animation: notifPagePulse 0.4s ease;
    }

    @keyframes notifPagePulse {

        0%,
        100% {
            transform: scale(1.15);
        }

        50% {
            transform: scale(1.25);
        }
    }

    .notif-pagination-dots {
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .notif-pagination-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        background: var(--primary-color-light);
        border-radius: 25px;
        color: var(--primary-color);
        font-size: 14px;
        font-weight: 600;
        border: 2px solid rgba(13, 179, 59, 0.15);
    }

    .notif-pagination-info i {
        font-size: 16px;
    }

    .notif-pagination-info strong {
        color: var(--primary-color-dark);
        font-size: 15px;
    }

    .notif-pagination-info .separator {
        margin: 0 5px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notif-pagination {
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .notif-pagination-btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .notif-pagination-btn span {
            display: none;
        }

        .notif-pagination-number {
            min-width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .notif-pagination-info {
            font-size: 12px;
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .notif-pagination-numbers {
            gap: 4px;
            margin: 0 5px;
        }

        .notif-pagination-number {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }
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

    <?php if ($total_pages > 1): ?>
        <!-- Pagination -->
        <div class="notif-pagination-container">
            <div class="notif-pagination">
                <!-- Previous Button -->
                <a href="?nav=thongbao&notif_page=<?php echo max(1, $current_page - 1); ?>"
                    class="notif-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                    <i class="fas fa-chevron-left"></i>
                    <span>Trước</span>
                </a>

                <!-- Page Numbers -->
                <div class="notif-pagination-numbers">
                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);

                    if ($start_page > 1) {
                        echo '<a href="?nav=thongbao&notif_page=1" class="notif-pagination-number">1</a>';
                        if ($start_page > 2) {
                            echo '<span class="notif-pagination-dots">...</span>';
                        }
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        $active_class = ($i == $current_page) ? 'active' : '';
                        echo '<a href="?nav=thongbao&notif_page=' . $i . '" class="notif-pagination-number ' . $active_class . '">' . $i . '</a>';
                    }

                    if ($end_page < $total_pages) {
                        if ($end_page < $total_pages - 1) {
                            echo '<span class="notif-pagination-dots">...</span>';
                        }
                        echo '<a href="?nav=thongbao&notif_page=' . $total_pages . '" class="notif-pagination-number">' . $total_pages . '</a>';
                    }
                    ?>
                </div>

                <!-- Next Button -->
                <a href="?nav=thongbao&notif_page=<?php echo min($total_pages, $current_page + 1); ?>"
                    class="notif-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                    <span>Sau</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            <!-- Pagination Info -->
            <div class="notif-pagination-info">
                <i class="fas fa-bell"></i>
                <span>
                    Hiển thị
                    <strong><?php echo min($offset + 1, $total_notifications); ?></strong>
                    <span class="separator">-</span>
                    <strong><?php echo min($offset + $notifications_per_page, $total_notifications); ?></strong>
                    <span class="separator">/</span>
                    <strong><?php echo $total_notifications; ?></strong>
                    thông báo
                </span>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll to top when clicking notification pagination
        const notifPaginationLinks = document.querySelectorAll('.notif-pagination-number, .notif-pagination-btn');
        notifPaginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    const contentPane = document.querySelector('.content-pane');
                    if (contentPane) {
                        contentPane.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            });
        });
    });
</script>