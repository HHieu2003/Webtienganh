<?php
// Kết nối CSDL và Session đã được khởi tạo từ file dashboard.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để xem kết quả.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// Lấy danh sách kết quả bài kiểm tra của học viên
$sql_results = "
    SELECT 
        bt.ten_baitest, 
        kq.diem, 
        kq.ngay_lam_bai,
        (SELECT COUNT(id_cauhoi) FROM cauhoi WHERE id_baitest = bt.id_baitest) AS total_questions
    FROM ketquabaitest kq
    JOIN baitest bt ON kq.id_baitest = bt.id_baitest
    WHERE kq.id_hocvien = ?
    ORDER BY kq.ngay_lam_bai DESC
";
$stmt = $conn->prepare($sql_results);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

// Hàm để xác định màu sắc của progress bar dựa trên tỷ lệ
function get_progress_bar_class($percentage) {
    if ($percentage >= 80) {
        return 'bg-success';
    } elseif ($percentage >= 50) {
        return 'bg-warning';
    } else {
        return 'bg-danger';
    }
}
?>

<div class="content-pane">
    <h2>Kết quả bài kiểm tra</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle result-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Tên bài kiểm tra</th>
                        <th scope="col" class="text-center">Kết quả</th>
                        <th scope="col" style="width: 25%;">Tỷ lệ đúng</th>
                        <th scope="col" class="text-center">Ngày làm bài</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0; // Biến đếm để tạo hiệu ứng delay
                    while ($row = $result->fetch_assoc()): 
                        $correct_answers = (int)$row['diem'];
                        $total_questions = (int)$row['total_questions'];
                        $percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100) : 0;
                    ?>
                        <tr class="result-row" style="animation-delay: <?php echo $index * 100; ?>ms;">
                            <td>
                                <strong class="d-block"><?php echo htmlspecialchars($row['ten_baitest']); ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold"><?php echo $correct_answers; ?> / <?php echo $total_questions; ?></span>
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar progress-bar-animated <?php echo get_progress_bar_class($percentage); ?>" 
                                         role="progressbar" 
                                         data-final-width="<?php echo $percentage; ?>"
                                         style="width: 0%;" 
                                         aria-valuenow="0" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">0%
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="text-muted"><?php echo date("d/m/Y H:i", strtotime($row['ngay_lam_bai'])); ?></span>
                            </td>
                        </tr>
                    <?php 
                        $index++; // Tăng biến đếm
                    endwhile; 
                    ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Bạn chưa có kết quả bài kiểm tra nào. Hãy làm bài để xem kết quả tại đây!</div>
    <?php endif; ?>
</div>

<style>
    /* 1. Keyframes cho hiệu ứng trượt lên */
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

    .result-table tbody tr {
        opacity: 0; /* Bắt đầu ẩn */
        animation: fadeInUp 0.5s ease-out forwards; /* Áp dụng animation */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Hiệu ứng cho hover */
    }
    
    /* 2. Hiệu ứng Hover */
    .result-table tbody tr:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        cursor: pointer;
        z-index: 2;
        position: relative;
    }

    .table th {
        font-weight: 600;
    }
    .progress-bar {
        font-weight: 600;
        transition: width 1s ease-in-out; /* 3. Hiệu ứng thanh progress chạy */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 3. JavaScript để kích hoạt hiệu ứng thanh tiến trình
    const progressBars = document.querySelectorAll('.progress-bar-animated');

    progressBars.forEach(bar => {
        const finalWidth = bar.getAttribute('data-final-width');
        
        // Dùng setTimeout để đảm bảo animation CSS chạy xong trước khi JS bắt đầu
        setTimeout(() => {
            // Cập nhật chiều rộng của thanh progress
            bar.style.width = finalWidth + '%';
            bar.setAttribute('aria-valuenow', finalWidth);

            // Hiệu ứng số đếm
            let currentWidth = 0;
            const interval = setInterval(() => {
                if (currentWidth >= finalWidth) {
                    clearInterval(interval);
                    // Đảm bảo số cuối cùng chính xác
                    bar.textContent = finalWidth + '%';
                } else {
                    currentWidth++;
                    bar.textContent = currentWidth + '%';
                }
            }, 10); // Tốc độ đếm số
        }, 500); // Bắt đầu chạy sau 500ms
    });
});
</script>