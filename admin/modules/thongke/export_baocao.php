<?php
// File: admin/modules/thongke/export_baocao.php
include('../../../config/config.php');

$show_all = isset($_GET['show']) && $_GET['show'] === 'all';
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-t');
$report_title_date_range = "(Toàn thời gian)";
$date_condition_for_revenue = "";

if (!$show_all) {
    $report_title_date_range = "(Từ ngày " . date("d/m/Y", strtotime($start_date)) . " đến " . date("d/m/Y", strtotime($end_date)) . ")";
    $date_condition_for_revenue = "AND lt.ngay_thanhtoan BETWEEN '$start_date' AND '$end_date'";
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=bao-cao-hieu-qua-khoa-hoc.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql_courses_performance = "
    SELECT 
        kh.ten_khoahoc,
        kh.danh_gia_tb,
        COUNT(DISTINCT dk.id_hocvien) as student_count,
        (SELECT COUNT(*) FROM lop_hoc WHERE id_khoahoc = kh.id_khoahoc) as class_count,
        (SELECT IFNULL(SUM(so_tien), 0) FROM lichsu_thanhtoan lt WHERE lt.id_khoahoc = kh.id_khoahoc $date_condition_for_revenue) as course_revenue
    FROM khoahoc kh
    LEFT JOIN dangkykhoahoc dk ON kh.id_khoahoc = dk.id_khoahoc AND dk.trang_thai = 'da xac nhan'
    GROUP BY kh.id_khoahoc, kh.ten_khoahoc
    ORDER BY course_revenue DESC
";
$result = $conn->query($sql_courses_performance);

$output = "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\"><head><meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\"></head><body>";
$output .= "<h2>Báo cáo hiệu quả khóa học " . $report_title_date_range . "</h2>";
$output .= "<table border='1'>";
$output .= "<thead><tr><th>Tên khóa học</th><th>Tổng số học viên</th><th>Số lớp học</th><th>Đánh giá TB</th><th>Doanh thu (VNĐ)</th></tr></thead><tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>" . htmlspecialchars($row["ten_khoahoc"]) . "</td>
                        <td>" . $row["student_count"] . "</td>
                        <td>" . $row["class_count"] . "</td>
                        <td>" . number_format($row["danh_gia_tb"] ?? 0, 1) . "</td>
                        <td>" . $row["course_revenue"] . "</td>
                    </tr>";
    }
}
$output .= "</tbody></table></body></html>";
echo $output;

$conn->close();
exit();
?>