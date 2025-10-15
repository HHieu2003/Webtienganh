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


if ($is_filtered) {
    // Chỉ thêm điều kiện lọc ngày tháng nếu người dùng đã chọn tháng và năm
    $start_date = date('Y-m-d', strtotime("{$filter_year}-{$filter_month}-01"));
    $end_date = date('Y-m-t', strtotime($start_date));
    $date_condition = "AND lt.ngay_thanhtoan BETWEEN ? AND ?";
}


// Lấy lịch sử thanh toán của học viên
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
";
$stmt = $conn->prepare($sql_payments);

// Gán tham số dựa trên việc có lọc hay không
if ($is_filtered) {
    $stmt->bind_param("iss", $id_hocvien, $start_date, $end_date);
} else {
    $stmt->bind_param("i", $id_hocvien);
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
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            <i class="fa-solid fa-search fa-2x mb-3"></i>
            <p class="mb-0">Không tìm thấy giao dịch nào phù hợp với bộ lọc đã chọn.</p>
        </div>
    <?php endif; ?>
</div>