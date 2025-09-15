<?php
// PHP logic (giữ nguyên như cũ)
if (!isset($_SESSION['id_hocvien'])) { die("Vui lòng đăng nhập."); }
$id_hocvien = $_SESSION['id_hocvien'];
$sql = "
    SELECT kh.ten_khoahoc, td.tien_do, td.so_buoi_da_tham_gia, td.tong_so_buoi
    FROM tien_do_hoc_tap td
    JOIN khoahoc kh ON td.id_khoahoc = kh.id_khoahoc
    WHERE td.id_hocvien = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();
$progressData = [];
while ($row = $result->fetch_assoc()) {
    $row['tien_do'] = (float)$row['tien_do'];
    $row['so_buoi_da_tham_gia'] = (int)$row['so_buoi_da_tham_gia'];
    $row['tong_so_buoi'] = (int)$row['tong_so_buoi'];
    $progressData[] = $row;
}
$stmt->close();
?>

<div class="content-pane">
    <h2>Tiến độ học tập</h2>
    
    <?php if (!empty($progressData)): ?>
        <div class="row g-4">
            <?php foreach ($progressData as $index => $progress): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="progress-card" id="progress-card-<?php echo $index; ?>" style="animation-delay: <?php echo $index * 100; ?>ms;">
                        <h5 class="course-title"><?php echo htmlspecialchars($progress['ten_khoahoc']); ?></h5>
                        <div class="chart-container">
                            <canvas id="progress-chart-<?php echo $index; ?>"></canvas>
                            <div class="chart-percentage" data-percentage="<?php echo $progress['tien_do']; ?>">0%</div>
                        </div>
                        <div class="progress-stats">
                            Đã tham gia: 
                            <strong><?php echo $progress['so_buoi_da_tham_gia']; ?> / <?php echo $progress['tong_so_buoi']; ?></strong> buổi
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Bạn chưa có dữ liệu tiến độ học tập nào.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* CSS (giữ nguyên như cũ) */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .progress-card { background-color: #fff; border-radius: var(--border-radius); box-shadow: var(--shadow); padding: 25px; text-align: center; height: 100%; opacity: 0; animation: fadeInUp 0.5s ease-out forwards; }
    .course-title { font-size: 18px; font-weight: 600; color: var(--dark-text); margin-bottom: 20px; min-height: 50px; }
    .chart-container { position: relative; width: 180px; height: 180px; margin: 0 auto 20px auto; }
    .chart-percentage { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 32px; font-weight: 700; color: var(--primary-color-dark); }
    .progress-stats { font-size: 15px; color: var(--gray-text); background-color: #f8f9fa; padding: 10px; border-radius: 8px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const progressData = <?php echo json_encode($progressData); ?>;

    progressData.forEach((item, index) => {
        const ctx = document.getElementById(`progress-chart-${index}`).getContext('2d');
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [item.tien_do, 100 - item.tien_do],
                    backgroundColor: ['#0db33b', '#e9ecef'],
                    borderColor: '#fff',
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true,
                cutout: '75%',
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                animation: { animateRotate: true, animateScale: true }
            }
        });

        // *** SỬA LỖI JAVASCRIPT TẠI ĐÂY ***
        const percentageEl = document.querySelector(`#progress-card-${index} .chart-percentage`);
        if (percentageEl) {
            const targetPercentage = parseFloat(percentageEl.getAttribute('data-percentage'));
            let currentPercentage = 0;
            
            const counter = setInterval(() => {
                currentPercentage += 1;
                if (currentPercentage >= targetPercentage) {
                    currentPercentage = targetPercentage;
                    clearInterval(counter);
                }
                percentageEl.textContent = Math.round(currentPercentage) + '%';
            }, 15); // Tốc độ animation
        }
    });
});
</script>