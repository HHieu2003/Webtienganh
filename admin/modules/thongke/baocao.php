<?php
// File: admin/modules/thongke/baocao.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- XỬ LÝ BỘ LỌC NGÀY THÁNG ---
$show_all = isset($_GET['show']) && $_GET['show'] === 'all';
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-t');
$date_condition = "";
$report_title_date_range = "(Toàn thời gian)";

if (!$show_all) {
    $date_condition = "WHERE lt.ngay_thanhtoan BETWEEN '$start_date' AND '$end_date'";
    $report_title_date_range = "(Từ " . date("d/m/Y", strtotime($start_date)) . " đến " . date("d/m/Y", strtotime($end_date)) . ")";
}

// --- TRUY VẤN DỮ LIỆU ---
$total_revenue = $conn->query("SELECT SUM(so_tien) AS total FROM lichsu_thanhtoan lt $date_condition")->fetch_assoc()['total'] ?? 0;
$total_sales = $conn->query("SELECT COUNT(*) AS total FROM lichsu_thanhtoan lt $date_condition")->fetch_assoc()['total'] ?? 0;
$total_new_students = $conn->query("SELECT COUNT(DISTINCT id_hocvien) AS total FROM lichsu_thanhtoan lt $date_condition")->fetch_assoc()['total'] ?? 0;
$total_active_classes = $conn->query("SELECT COUNT(*) AS total FROM lop_hoc WHERE trang_thai = 'dang hoc'")->fetch_assoc()['total'] ?? 0;

// --- DỮ LIỆU CHO BIỂU ĐỒ ---
$sql_chart = "SELECT DATE(ngay_thanhtoan) as payment_date, SUM(so_tien) as daily_revenue FROM lichsu_thanhtoan " . ($show_all ? "" : "WHERE ngay_thanhtoan BETWEEN ? AND ?") . " GROUP BY DATE(ngay_thanhtoan) ORDER BY payment_date ASC";
$stmt_chart = $conn->prepare($sql_chart);
if (!$show_all) {
    $stmt_chart->bind_param("ss", $start_date, $end_date);
}
$stmt_chart->execute();
$result_chart = $stmt_chart->get_result();
$chart_labels = [];
$chart_data = [];
while ($row = $result_chart->fetch_assoc()) {
    $chart_labels[] = date($show_all ? "m/Y" : "d/m", strtotime($row['payment_date'])); // Hiển thị tháng/năm nếu xem tất cả
    $chart_data[] = $row['daily_revenue'];
}

// --- DỮ LIỆU CHO BẢNG HIỆU QUẢ KHÓA HỌC VỚI PHÂN TRANG ---
$courses_per_page = 10; // Số khóa học mỗi trang
$current_page = isset($_GET['stat_page']) ? max(1, intval($_GET['stat_page'])) : 1;
$offset = ($current_page - 1) * $courses_per_page;

// Count total courses
$count_sql = "SELECT COUNT(*) as total FROM khoahoc";
$total_courses = $conn->query($count_sql)->fetch_assoc()['total'] ?? 0;
$total_pages = ceil($total_courses / $courses_per_page);

// Fetch courses with pagination
$sql_courses_performance = "
    SELECT 
        kh.id_khoahoc, kh.ten_khoahoc, kh.danh_gia_tb,
        COUNT(DISTINCT dk.id_hocvien) as student_count,
        (SELECT COUNT(*) FROM lop_hoc WHERE id_khoahoc = kh.id_khoahoc) as class_count,
        (SELECT IFNULL(SUM(so_tien), 0) FROM lichsu_thanhtoan lt WHERE lt.id_khoahoc = kh.id_khoahoc " . ($show_all ? "" : "AND lt.ngay_thanhtoan BETWEEN '$start_date' AND '$end_date'") . ") as course_revenue
    FROM khoahoc kh
    LEFT JOIN dangkykhoahoc dk ON kh.id_khoahoc = dk.id_khoahoc AND dk.trang_thai = 'da xac nhan'
    GROUP BY kh.id_khoahoc, kh.ten_khoahoc
    ORDER BY course_revenue DESC
    LIMIT $courses_per_page OFFSET $offset
";
$courses_performance = $conn->query($sql_courses_performance);
?>

<div class="container-fluid">
    <h1 class="title-color">Báo cáo & Thống kê</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="./admin.php">
                <input type="hidden" name="nav" value="thongke">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label for="start_date" class="form-label">Từ ngày</label><input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $start_date; ?>"></div>
                    <div class="col-md-3"><label for="end_date" class="form-label">Đến ngày</label><input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $end_date; ?>"></div>
                    <div class="col-md-3"><button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter"></i> Lọc theo ngày</button></div>
                    <div class="col-md-3"><a href="./admin.php?nav=thongke&show=all" class="btn btn-secondary w-100"><i class="fa-solid fa-globe"></i> Xem tất cả</a></div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class=" col-md-6 mb-4">
            <div class="card stat-card bg-success animated-card">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Tổng Doanh Thu</h5>
                        <p class="card-number"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</p>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-6 mb-4">
            <div class="card stat-card bg-info animated-card" style="animation-delay: 100ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lượt thanh toán</h5>
                        <p class="card-number"><?php echo $total_sales; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-6 mb-4">
            <div class="card stat-card bg-primary animated-card" style="animation-delay: 200ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-user-plus"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Học viên mới</h5>
                        <p class="card-number"><?php echo $total_new_students; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-6 mb-4">
            <div class="card stat-card bg-secondary animated-card" style="animation-delay: 300ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-school"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lớp đang hoạt động</h5>
                        <p class="card-number"><?php echo $total_active_classes; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 animated-card" style="animation-delay: 400ms;">
        <div class="card-header">
            <h4 class="mb-0"><i class="fa-solid fa-chart-line me-2"></i>Biểu đồ doanh thu (VNĐ) <?php echo $report_title_date_range; ?></h4>
        </div>
        <div class="card-body"><canvas id="revenueChart"></canvas></div>
    </div>

    <div class="card animated-card" style="animation-delay: 500ms;" id="course-stats">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fa-solid fa-book-open-reader me-2"></i>Thống kê hiệu quả khóa học <?php echo $report_title_date_range; ?></h4>
                <a href="modules/thongke/export_baocao.php?<?php echo $show_all ? 'show=all' : "start_date=$start_date&end_date=$end_date"; ?>" class="btn btn-info text-white"><i class="fa-solid fa-file-excel"></i> Xuất Excel</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tên khóa học</th>
                            <th class="text-center">Số học viên</th>
                            <th class="text-center">Số lớp học</th>
                            <th class="text-center">Đánh giá TB</th>
                            <th class="text-center">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $courses_performance->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['ten_khoahoc']); ?></strong></td>
                                <td class="text-center"><?php echo $row['student_count']; ?></td>
                                <td class="text-center"><?php echo $row['class_count']; ?></td>
                                <td class="text-center"><span class="badge bg-warning text-dark"><i class="fa-solid fa-star"></i> <?php echo number_format($row['danh_gia_tb'] ?? 0, 1); ?></span></td>
                                <td class="text-center fw-bold text-success"><?php echo number_format($row['course_revenue'], 0, ',', '.'); ?>đ</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination for Statistics -->
            <?php if ($total_pages > 1):
                // Build query params
                $query_params = "nav=thongke";
                if ($show_all) {
                    $query_params .= "&show=all";
                } else {
                    $query_params .= "&start_date=$start_date&end_date=$end_date";
                }
            ?>
                <div class="admin-stats-pagination-container mt-4">
                    <div class="admin-stats-pagination">
                        <?php
                        // Previous button
                        if ($current_page > 1):
                            $prev_page = $current_page - 1;
                        ?>
                            <a href="admin.php?<?php echo $query_params; ?>&stat_page=<?php echo $prev_page; ?>#course-stats" class="admin-stats-pagination-btn admin-stats-pagination-prev">
                                <i class="fas fa-chevron-left"></i>
                                <span>Trước</span>
                            </a>
                        <?php else: ?>
                            <span class="admin-stats-pagination-btn admin-stats-pagination-prev disabled">
                                <i class="fas fa-chevron-left"></i>
                                <span>Trước</span>
                            </span>
                        <?php endif; ?>

                        <!-- Page numbers -->
                        <div class="admin-stats-pagination-numbers">
                            <?php
                            $range = 2;
                            $start = max(1, $current_page - $range);
                            $end = min($total_pages, $current_page + $range);

                            // First page
                            if ($start > 1):
                            ?>
                                <a href="admin.php?<?php echo $query_params; ?>&stat_page=1#course-stats" class="admin-stats-pagination-number">1</a>
                                <?php if ($start > 2): ?>
                                    <span class="admin-stats-pagination-dots">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <a href="admin.php?<?php echo $query_params; ?>&stat_page=<?php echo $i; ?>#course-stats"
                                    class="admin-stats-pagination-number <?php echo $i == $current_page ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <!-- Last page -->
                            <?php if ($end < $total_pages): ?>
                                <?php if ($end < $total_pages - 1): ?>
                                    <span class="admin-stats-pagination-dots">...</span>
                                <?php endif; ?>
                                <a href="admin.php?<?php echo $query_params; ?>&stat_page=<?php echo $total_pages; ?>#course-stats" class="admin-stats-pagination-number"><?php echo $total_pages; ?></a>
                            <?php endif; ?>
                        </div>

                        <!-- Next button -->
                        <?php
                        if ($current_page < $total_pages):
                            $next_page = $current_page + 1;
                        ?>
                            <a href="admin.php?<?php echo $query_params; ?>&stat_page=<?php echo $next_page; ?>#course-stats" class="admin-stats-pagination-btn admin-stats-pagination-next">
                                <span>Sau</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="admin-stats-pagination-btn admin-stats-pagination-next disabled">
                                <span>Sau</span>
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Page info -->
                    <div class="admin-stats-pagination-info">
                        <i class="fas fa-chart-bar"></i>
                        Trang <strong><?php echo $current_page; ?></strong> / <strong><?php echo $total_pages; ?></strong>
                        <span class="separator">•</span>
                        Tổng <strong><?php echo $total_courses; ?></strong> khóa học
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Admin Statistics Pagination Styles */
    .admin-stats-pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .admin-stats-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
        padding: 6px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
    }

    .admin-stats-pagination-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border: none;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .admin-stats-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        color: #0a8a2c;
    }

    .admin-stats-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .admin-stats-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 0 8px;
    }

    .admin-stats-pagination-number {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .admin-stats-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-1px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .admin-stats-pagination-number.active {
        background: #fff;
        color: #0a8a2c;
        border-color: #fff;
        transform: scale(1.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .admin-stats-pagination-dots {
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        padding: 0 3px;
        font-size: 12px;
    }

    .admin-stats-pagination-info {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: var(--brand-color-light, #e7f7ec);
        border-radius: 20px;
        color: #0db33b;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid rgba(13, 179, 59, 0.2);
    }

    .admin-stats-pagination-info i {
        font-size: 14px;
    }

    .admin-stats-pagination-info strong {
        color: #0a8a2c;
        font-size: 13px;
    }

    .admin-stats-pagination-info .separator {
        margin: 0 4px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-stats-pagination {
            padding: 6px 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .admin-stats-pagination-btn {
            padding: 5px 8px;
            font-size: 12px;
        }

        .admin-stats-pagination-btn span {
            display: none;
        }

        .admin-stats-pagination-number {
            min-width: 30px;
            height: 30px;
            font-size: 12px;
        }

        .admin-stats-pagination-info {
            font-size: 12px;
            padding: 7px 15px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($chart_labels); ?>,
                    datasets: [{
                        label: 'Doanh thu',
                        data: <?php echo json_encode($chart_data); ?>,
                        backgroundColor: 'rgba(13, 179, 59, 0.1)',
                        borderColor: 'rgba(13, 179, 59, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });
</script>