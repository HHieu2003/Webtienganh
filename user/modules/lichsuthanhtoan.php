<?php
// user/modules/lichsuthanhtoan.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để xem lịch sử thanh toán.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- Lấy danh sách các tháng/năm có giao dịch để tạo bộ lọc động ---
$sql_months_years = "
    SELECT DISTINCT 
        YEAR(ngay_thanhtoan) as `year`, 
        MONTH(ngay_thanhtoan) as `month`
    FROM lichsu_thanhtoan
    WHERE id_hocvien = ?
    ORDER BY `year` DESC, `month` DESC
";
$stmt_my = $conn->prepare($sql_months_years);
$stmt_my->bind_param("i", $id_hocvien);
$stmt_my->execute();
$result_my = $stmt_my->get_result();
$available_filters = [];
while ($row = $result_my->fetch_assoc()) {
    $available_filters[] = $row;
}
$stmt_my->close();


// --- Xử lý bộ lọc: Mặc định là xem tất cả ---
$is_filtered = isset($_GET['month']) && isset($_GET['year']);
$date_condition = '';

// Lấy giá trị bộ lọc nếu có, nếu không thì dùng tháng/năm hiện tại để hiển thị sẵn trên form
$filter_month = $_GET['month'] ?? date('n');
$filter_year = $_GET['year'] ?? date('Y');

// --- Pagination settings ---
$payments_per_page = 10;
$current_page = isset($_GET['payment_page']) ? max(1, intval($_GET['payment_page'])) : 1;
$offset = ($current_page - 1) * $payments_per_page;

if ($is_filtered) {
    // Chỉ thêm điều kiện lọc ngày tháng nếu người dùng đã chọn tháng và năm
    $start_date = date('Y-m-d', strtotime("{$filter_year}-{$filter_month}-01"));
    $end_date = date('Y-m-t', strtotime($start_date));
    $date_condition = "AND lt.ngay_thanhtoan BETWEEN ? AND ?";
}

// --- Count total payments ---
$sql_count = "
    SELECT COUNT(*) as total
    FROM lichsu_thanhtoan lt
    WHERE lt.id_hocvien = ? $date_condition
";
$stmt_count = $conn->prepare($sql_count);
if ($is_filtered) {
    $stmt_count->bind_param("iss", $id_hocvien, $start_date, $end_date);
} else {
    $stmt_count->bind_param("i", $id_hocvien);
}
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_payments = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_payments / $payments_per_page);


// Lấy lịch sử thanh toán của học viên với phân trang
$sql_payments = "
    SELECT 
        lt.id_thanhtoan,
        lt.ngay_thanhtoan, 
        lt.so_tien, 
        lt.hinh_thuc, 
        lt.trang_thai, 
        kh.ten_khoahoc
    FROM lichsu_thanhtoan lt
    JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
    WHERE lt.id_hocvien = ? $date_condition
    ORDER BY lt.ngay_thanhtoan DESC
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($sql_payments);

// Gán tham số dựa trên việc có lọc hay không
if ($is_filtered) {
    $stmt->bind_param("issii", $id_hocvien, $start_date, $end_date, $payments_per_page, $offset);
} else {
    $stmt->bind_param("iii", $id_hocvien, $payments_per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Hàm để tạo badge trạng thái
function get_payment_status_badge($status)
{
    // Chuẩn hóa trạng thái về chữ thường để so sánh
    switch (strtolower(trim($status))) {
        case 'Đã thanh toán' :
        case 'Đã hoàn thành' :
            return '<span class="badge status-badge status-success">Thành công</span>';
        case 'Đã hủy':
            return '<span class="badge status-badge status-pending">Đã hủy</span>';
        default:
            return '<span class="badge status-badge status-pending">Đang chờ</span>';
            
    }
}
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .filter-bar {
        background-color: #fff;
        padding: 15px;
        border-radius: var(--border-radius);
        margin-bottom: 25px;
        box-shadow: var(--shadow);
    }

    .transaction-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .transaction-table thead {
        display: none;
    }

    .transaction-row {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .transaction-row:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .transaction-row td {
        padding: 15px 20px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid var(--border-color);
    }

    .transaction-row td:first-child {
        border-top-left-radius: var(--border-radius);
        border-bottom-left-radius: var(--border-radius);
    }

    .transaction-row td:last-child {
        border-top-right-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
    }

    .course-name {
        font-weight: 600;
        font-size: 16px;
        display: block;
    }

    .payment-method {
        font-size: 14px;
        color: var(--gray-text);
    }

    .amount {
        font-weight: 700;
        font-size: 18px;
        color: var(--primary-color-dark);
    }

    .date-time {
        font-size: 14px;
        color: var(--gray-text);
    }

    .status-badge {
        font-size: 13px;
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 50px;
    }

    .status-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #664d03;
    }

    .status-failed {
        background-color: #f8d7da;
        color: #842029;
    }

    /* ---- CSS CHO RESPONSIVE TABLE ---- */
    @media (max-width: 991px) {
        .transaction-table thead {
            display: none;
        }

        .transaction-table,
        .transaction-table tbody,
        .transaction-table tr,
        .transaction-table td {
            display: block;
            width: 100%;
        }

        .transaction-row {
            margin-bottom: 15px;
        }

        .transaction-row td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-bottom: 1px solid var(--border-color);
        }

        .transaction-row td:before {
            content: attr(data-label);
            position: absolute;
            left: 20px;
            width: calc(50% - 40px);
            text-align: left;
            font-weight: 600;
            color: var(--dark-text);
        }

        .transaction-row td:last-child {
            border-bottom: none;
        }
    }

    /* Payment History Pagination Styles */
    .payment-pagination-container {
     
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
    }

    .payment-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #66eabaff 0%, #4ba254ff 100%);
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.25);
        backdrop-filter: blur(10px);
    }

    .payment-pagination-btn {
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
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .payment-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        color: var(--primary-color-dark);
    }

    .payment-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .payment-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0 10px;
    }

    .payment-pagination-number {
        min-width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        border-color: rgba(255,255,255,0.8);
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    .payment-pagination-number.active {
        background: #fff;
        color: var(--primary-color-dark);
        border-color: #fff;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        animation: paymentPagePulse 0.4s ease;
    }

    @keyframes paymentPagePulse {
        0%, 100% { transform: scale(1.15); }
        50% { transform: scale(1.25); }
    }

    .payment-pagination-dots {
        color: rgba(255,255,255,0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .payment-pagination-info {
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

    .payment-pagination-info i {
        font-size: 16px;
    }

    .payment-pagination-info strong {
        color: var(--primary-color-dark);
        font-size: 15px;
    }

    .payment-pagination-info .separator {
        margin: 0 5px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .payment-pagination {
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .payment-pagination-btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .payment-pagination-btn span {
            display: none;
        }

        .payment-pagination-number {
            min-width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .payment-pagination-info {
            font-size: 12px;
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .payment-pagination-numbers {
            gap: 4px;
            margin: 0 5px;
        }

        .payment-pagination-number {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }
</style>
<div class="content-pane">
    <h2 class="mb-4">Lịch Sử Giao Dịch</h2>

    <div class="filter-bar">
        <form class="row g-3 align-items-center">
            <input type="hidden" name="nav" value="lichsuthanhtoan">
            <div class="col-auto">
                <label for="month-filter" class="form-label mb-0"><strong>Lọc theo:</strong></label>
            </div>
            <div class="col-auto">
                <select name="month" id="month-filter" class="form-select">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>" <?php echo ($is_filtered && $m == $filter_month) ? 'selected' : ''; ?>>
                            Tháng <?php echo $m; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="year" id="year-filter" class="form-select">
                    <?php
                    $years = array_unique(array_column($available_filters, 'year'));
                    if (!in_array(date('Y'), $years)) {
                        $years[] = date('Y');
                    }
                    rsort($years);
                    foreach ($years as $year): ?>
                        <option value="<?php echo $year; ?>" <?php echo ($is_filtered && $year == $filter_year) ? 'selected' : ''; ?>>
                            Năm <?php echo $year; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
            <div class="col-auto">
                <a href="?nav=lichsuthanhtoan" class="btn <?php echo !$is_filtered ? 'btn btn-info' : 'btn-outline-secondary'; ?>">Xem tất cả</a>
            </div>
        </form>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Chi tiết</th>
                    <th>Số tiền</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                while ($row = $result->fetch_assoc()):
                    // Biến để kiểm tra trạng thái thành công
                    $is_successful = (strtolower(trim($row['trang_thai'])) === 'Đã thanh toán' || strtolower(trim($row['trang_thai'])) === 'Đã hoàn thành');
                ?>
                    <tr class="transaction-row" style="animation-delay: <?php echo $index * 100; ?>ms;">
                        <td data-label="Chi tiết">
                            <span class="course-name"><?php echo htmlspecialchars($row['ten_khoahoc']); ?></span>
                            <span class="payment-method"><?php echo htmlspecialchars($row['hinh_thuc']); ?></span>
                        </td>
                        <td data-label="Số tiền" class="amount">
                            <?php echo number_format($row['so_tien'], 0, ',', '.'); ?> VNĐ
                        </td>
                        <td data-label="Thời gian" class="date-time">
                            <?php echo date("H:i - d/m/Y", strtotime($row['ngay_thanhtoan'])); ?>
                        </td>
                        <td data-label="Trạng thái">
                            <?php echo get_payment_status_badge($row['trang_thai']); ?>
                        </td>
                        <td data-label="Hành động">
                            <?php if ($is_successful): ?>
                                <a href="../admin/modules/lichsuthanhtoan/view_receipt.php?id=<?php echo $row['id_thanhtoan']; ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fa-solid fa-receipt"></i> Xem biên lai
                                </a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-outline-secondary" disabled title="Chưa có biên lai">
                                    <i class="fa-solid fa-receipt"></i> Chưa có biên lai
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                    $index++;
                endwhile;
                ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <!-- Pagination -->
            <div class="payment-pagination-container">
                <div class="payment-pagination">
                    <!-- Previous Button -->
                    <?php
                    $prev_link = "?nav=lichsuthanhtoan&payment_page=" . max(1, $current_page - 1);
                    if ($is_filtered) {
                        $prev_link .= "&month={$filter_month}&year={$filter_year}";
                    }
                    ?>
                    <a href="<?php echo $prev_link; ?>" 
                       class="payment-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>

                    <!-- Page Numbers -->
                    <div class="payment-pagination-numbers">
                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        if ($start_page > 1) {
                            $first_link = "?nav=lichsuthanhtoan&payment_page=1";
                            if ($is_filtered) $first_link .= "&month={$filter_month}&year={$filter_year}";
                            echo '<a href="' . $first_link . '" class="payment-pagination-number">1</a>';
                            if ($start_page > 2) {
                                echo '<span class="payment-pagination-dots">...</span>';
                            }
                        }

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $page_link = "?nav=lichsuthanhtoan&payment_page={$i}";
                            if ($is_filtered) $page_link .= "&month={$filter_month}&year={$filter_year}";
                            $active_class = ($i == $current_page) ? 'active' : '';
                            echo '<a href="' . $page_link . '" class="payment-pagination-number ' . $active_class . '">' . $i . '</a>';
                        }

                        if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                                echo '<span class="payment-pagination-dots">...</span>';
                            }
                            $last_link = "?nav=lichsuthanhtoan&payment_page={$total_pages}";
                            if ($is_filtered) $last_link .= "&month={$filter_month}&year={$filter_year}";
                            echo '<a href="' . $last_link . '" class="payment-pagination-number">' . $total_pages . '</a>';
                        }
                        ?>
                    </div>

                    <!-- Next Button -->
                    <?php
                    $next_link = "?nav=lichsuthanhtoan&payment_page=" . min($total_pages, $current_page + 1);
                    if ($is_filtered) {
                        $next_link .= "&month={$filter_month}&year={$filter_year}";
                    }
                    ?>
                    <a href="<?php echo $next_link; ?>" 
                       class="payment-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <!-- Pagination Info -->
                <div class="payment-pagination-info">
                    <i class="fas fa-receipt"></i>
                    <span>
                        Hiển thị 
                        <strong><?php echo min($offset + 1, $total_payments); ?></strong>
                        <span class="separator">-</span>
                        <strong><?php echo min($offset + $payments_per_page, $total_payments); ?></strong>
                        <span class="separator">/</span>
                        <strong><?php echo $total_payments; ?></strong>
                        giao dịch
                    </span>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            <i class="fa-solid fa-search fa-2x mb-3"></i>
            <p class="mb-0">Không tìm thấy giao dịch nào phù hợp với bộ lọc đã chọn.</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll to top when clicking payment pagination
    const paymentPaginationLinks = document.querySelectorAll('.payment-pagination-number, .payment-pagination-btn');
    paymentPaginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            setTimeout(() => {
                const contentPane = document.querySelector('.content-pane');
                if (contentPane) {
                    contentPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        });
    });
});
</script>