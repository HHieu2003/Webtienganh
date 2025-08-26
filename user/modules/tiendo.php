<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiến Độ Học Tập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .progress-circle {
            width: 200px;
            height: 200px;
            margin: 20px auto;
        }
        .progress-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4 text-center">
        <h1 class="text-center text-primary introduce-title">Tiến Độ Học Tập</h1>
        <div id="progress-list" class="row gap-5 ">
            <?php
            // Kết nối CSDL
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "quanlykhoahoc";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("<div class='alert alert-danger'>Kết nối thất bại: " . $conn->connect_error . "</div>");
            }

            // Lấy ID học viên (ví dụ: từ session hoặc URL)
            $id_hocvien = $_SESSION['id_hocvien'];

            if (!$id_hocvien) {
                die("<div class='alert alert-danger'>Không tìm thấy.</div>");
            }

            // Lấy dữ liệu tiến độ học tập
            $sql = "
                SELECT kh.ten_khoahoc, td.tien_do
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
                $progressData[] = $row;
            }

            // Hiển thị tiến độ từng khóa học
            foreach ($progressData as $index => $progress) {
                ?>
                <div class="col-md-5 progress-container border border-secondary-subtle">
                    <h5 class="pt-2"><?= htmlspecialchars($progress['ten_khoahoc']) ?></h5>
                    <canvas id="progress-chart-<?= $index ?>" class="progress-circle"></canvas>
                    <p>Tiến độ: <?= htmlspecialchars($progress['tien_do']) ?>%</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script>
        // Dữ liệu tiến độ từ PHP
        const progressData = <?= json_encode($progressData) ?>;

        // Hiển thị biểu đồ tiến độ
        progressData.forEach((item, index) => {
            const ctx = document.getElementById(`progress-chart-${index}`).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Hoàn thành', 'Chưa hoàn thành'],
                    datasets: [{
                        data: [item.tien_do, 100 - item.tien_do],
                        backgroundColor: ['#4caf50', '#e0e0e0'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw}%`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
