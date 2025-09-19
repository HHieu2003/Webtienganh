<?php
// Kết nối CSDL đã được include từ admin.php
include('../config/config.php'); // Chỉ dùng khi chạy file riêng

// --- TRUY VẤN DỮ LIỆU CHO DASHBOARD ---

// 1. Dữ liệu cho các thẻ thống kê
$total_students = $conn->query("SELECT COUNT(*) AS total FROM hocvien")->fetch_assoc()['total'] ?? 0;
$total_courses = $conn->query("SELECT COUNT(*) AS total FROM khoahoc")->fetch_assoc()['total'] ?? 0;
$total_registrations = $conn->query("SELECT COUNT(*) AS total FROM dangkykhoahoc WHERE trang_thai = 'da xac nhan'")->fetch_assoc()['total'] ?? 0;
$pending_registrations = $conn->query("SELECT COUNT(*) AS total FROM dangkykhoahoc WHERE trang_thai = 'cho xac nhan'")->fetch_assoc()['total'] ?? 0;

$total_views = $conn->query("SELECT SUM(so_luot) AS total FROM luot_truy_cap")->fetch_assoc()['total'] ?? 0;


// 2. Dữ liệu cho biểu đồ (Top 5 khóa học đông học viên nhất)
$sql_chart = "
    SELECT k.ten_khoahoc, COUNT(d.id_dangky) AS registration_count
    FROM dangkykhoahoc d
    JOIN khoahoc k ON d.id_khoahoc = k.id_khoahoc
    WHERE d.trang_thai = 'da xac nhan'
    GROUP BY d.id_khoahoc
    ORDER BY registration_count DESC
    LIMIT 5
";
$result_chart = $conn->query($sql_chart);
$chart_labels = [];
$chart_data = [];
while ($row = $result_chart->fetch_assoc()) {
    $chart_labels[] = $row['ten_khoahoc'];
    $chart_data[] = $row['registration_count'];
}

// 3. Dữ liệu cho hoạt động gần đây (5 đăng ký thành công mới nhất)
$sql_recent = "
    SELECT h.ten_hocvien, k.ten_khoahoc, dk.ngay_dangky
    FROM dangkykhoahoc dk
    JOIN hocvien h ON dk.id_hocvien = h.id_hocvien
    JOIN khoahoc k ON dk.id_khoahoc = k.id_khoahoc
    WHERE dk.trang_thai = 'da xac nhan'
    ORDER BY dk.id_dangky DESC
    LIMIT 5
";
$result_recent = $conn->query($sql_recent);
?>

<div class="container-fluid">
    <h1 class="title-color">Dashboard</h1>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card bg-primary animated-card" style="animation-delay: 100ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-users"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Tổng học viên</h5>
                        <p class="card-number" data-target="<?php echo $total_students; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card bg-success animated-card" style="animation-delay: 200ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Tổng khóa học</h5>
                        <p class="card-number" data-target="<?php echo $total_courses; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card bg-info animated-card" style="animation-delay: 300ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-check-to-slot"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Đã bán</h5>
                        <p class="card-number" data-target="<?php echo $total_registrations; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card bg-warning animated-card" style="animation-delay: 400ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Chờ xác nhận</h5>
                        <p class="card-number" data-target="<?php echo $pending_registrations; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card bg-danger animated-card" style="animation-delay: 300ms;">
                <div class="card-body">
                    <div class="card-icon"><i class="fa-solid fa-eye"></i></div>
                    <div class="card-text-content">
                        <h5 class="card-title">Lượt truy cập trang</h5>
                        <p class="card-number" data-target="<?php echo $total_views; ?>">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card animated-card" style="animation-delay: 500ms;">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa-solid fa-chart-bar me-2"></i>Top 5 khóa học phổ biến nhất</h4>
                </div>
                <div class="card-body">
                    <canvas id="popularCoursesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card animated-card" style="animation-delay: 600ms;">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fa-solid fa-bolt me-2"></i>Hoạt động gần đây</h4>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php while ($row = $result_recent->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong class="d-block text-primary"><?php echo htmlspecialchars($row['ten_hocvien']); ?></strong>
                                <small class="text-muted">vừa đăng ký khóa học "<?php echo htmlspecialchars($row['ten_khoahoc']); ?>"</small>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Hiệu ứng đếm số
        const counters = document.querySelectorAll('.card-number');
        const speed = 150;
        counters.forEach(counter => {
            const animate = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = Math.ceil(target / speed);
                if (count < target) {
                    counter.innerText = Math.min(count + increment, target);
                    setTimeout(animate, 10);
                } else {
                    counter.innerText = target;
                }
            };
            setTimeout(animate, 500); // Bắt đầu sau 0.5s
        });

        // 2. Vẽ biểu đồ
        const ctx = document.getElementById('popularCoursesChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($chart_labels); ?>,
                    datasets: [{
                        label: 'Số lượt đăng ký',
                        data: <?php echo json_encode($chart_data); ?>,
                        backgroundColor: 'rgba(13, 179, 59, 0.7)',
                        borderColor: 'rgba(10, 138, 44, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Đảm bảo trục y là số nguyên
                            }
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