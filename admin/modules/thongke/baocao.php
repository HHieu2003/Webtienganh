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
$chart_labels = []; $chart_data = [];
while ($row = $result_chart->fetch_assoc()) {
    $chart_labels[] = date($show_all ? "m/Y" : "d/m", strtotime($row['payment_date'])); // Hiển thị tháng/năm nếu xem tất cả
    $chart_data[] = $row['daily_revenue'];
}

// --- DỮ LIỆU CHO BẢNG HIỆU QUẢ KHÓA HỌC ---
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
        <div class=" col-md-6 mb-4"><div class="card stat-card bg-success animated-card"><div class="card-body"><div class="card-icon"><i class="fa-solid fa-sack-dollar"></i></div><div class="card-text-content"><h5 class="card-title">Tổng Doanh Thu</h5><p class="card-number"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</p></div></div></div></div>
        <div class=" col-md-6 mb-4"><div class="card stat-card bg-info animated-card" style="animation-delay: 100ms;"><div class="card-body"><div class="card-icon"><i class="fa-solid fa-cart-shopping"></i></div><div class="card-text-content"><h5 class="card-title">Lượt thanh toán</h5><p class="card-number"><?php echo $total_sales; ?></p></div></div></div></div>
        <div class=" col-md-6 mb-4"><div class="card stat-card bg-primary animated-card" style="animation-delay: 200ms;"><div class="card-body"><div class="card-icon"><i class="fa-solid fa-user-plus"></i></div><div class="card-text-content"><h5 class="card-title">Học viên mới</h5><p class="card-number"><?php echo $total_new_students; ?></p></div></div></div></div>
        <div class=" col-md-6 mb-4"><div class="card stat-card bg-secondary animated-card" style="animation-delay: 300ms;"><div class="card-body"><div class="card-icon"><i class="fa-solid fa-school"></i></div><div class="card-text-content"><h5 class="card-title">Lớp đang hoạt động</h5><p class="card-number"><?php echo $total_active_classes; ?></p></div></div></div></div>
    </div>

    <div class="card mb-4 animated-card" style="animation-delay: 400ms;">
        <div class="card-header"><h4 class="mb-0"><i class="fa-solid fa-chart-line me-2"></i>Biểu đồ doanh thu (VNĐ) <?php echo $report_title_date_range; ?></h4></div>
        <div class="card-body"><canvas id="revenueChart"></canvas></div>
    </div>

    <div class="card animated-card" style="animation-delay: 500ms;">
        <div class="card-header"><div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-book-open-reader me-2"></i>Thống kê hiệu quả khóa học <?php echo $report_title_date_range; ?></h4>
            <a href="modules/thongke/export_baocao.php?<?php echo $show_all ? 'show=all' : "start_date=$start_date&end_date=$end_date"; ?>" class="btn btn-info text-white"><i class="fa-solid fa-file-excel"></i> Xuất Excel</a>
        </div></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark"><tr><th>Tên khóa học</th><th class="text-center">Số học viên</th><th class="text-center">Số lớp học</th><th class="text-center">Đánh giá TB</th><th class="text-center">Doanh thu</th></tr></thead>
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
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (ctx) { new Chart(ctx, { type: 'line', data: { labels: <?php echo json_encode($chart_labels); ?>, datasets: [{ label: 'Doanh thu', data: <?php echo json_encode($chart_data); ?>, backgroundColor: 'rgba(13, 179, 59, 0.1)', borderColor: 'rgba(13, 179, 59, 1)', borderWidth: 2, fill: true, tension: 0.4 }] }, options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } } }); }
});
</script>