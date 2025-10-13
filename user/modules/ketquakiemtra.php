<?php
// user/modules/ketquakiemtra.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để xem kết quả.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// Lấy danh sách kết quả bài kiểm tra của học viên (thêm id_ketqua)
$sql_results = "
    SELECT 
        kq.id_ketqua,
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
    if ($percentage >= 80) return 'bg-success';
    if ($percentage >= 50) return 'bg-info';
    return 'bg-warning';
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .result-card {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid var(--border-color);
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
        transition: box-shadow 0.3s ease;
    }
    .result-card:hover {
        box-shadow: var(--shadow-hover);
    }
    .result-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 15px;
    }
    .result-header h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    .result-header .date {
        font-size: 14px;
        color: var(--gray-text);
        flex-shrink: 0;
    }
    .result-body {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .result-body .score {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-color-dark);
    }
    .result-body .progress-container {
        flex-grow: 1;
    }
    .progress {
        height: 12px;
        border-radius: 50px;
    }
    .progress-bar {
        border-radius: 50px;
        font-weight: 600;
        font-size: 10px;
        line-height: 12px;
        color: #fff;
        text-align: center;
        transition: width 1.5s ease-in-out; 
    }
</style>

<div class="content-pane">
    <h2 class="mb-4">Kết quả bài kiểm tra</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="results-list">
            <?php 
            $index = 0;
            while ($row = $result->fetch_assoc()): 
                $correct_answers = (int)$row['diem'];
                $total_questions = (int)$row['total_questions'];
                $percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100) : 0;
            ?>
                <div class="result-card" style="animation-delay: <?php echo $index * 100; ?>ms;">
                    <div class="result-header">
                        <h5><?php echo htmlspecialchars($row['ten_baitest']); ?></h5>
                        <span class="date"><?php echo date("d/m/Y H:i", strtotime($row['ngay_lam_bai'])); ?></span>
                    </div>
                    <div class="result-body">
                        <div class="score" title="Số câu đúng"><?php echo $correct_answers; ?>/<?php echo $total_questions; ?></div>
                        <div class="progress-container">
                            <div class="progress" role="progressbar">
                                <div class="progress-bar <?php echo get_progress_bar_class($percentage); ?>" 
                                     data-final-width="<?php echo $percentage; ?>" 
                                     style="width: 0%;"><?php echo $percentage; ?>%
                                </div>
                            </div>
                        </div>
                        <a href="?nav=view_submission&id=<?php echo $row['id_ketqua']; ?>" class="btn btn-outline-primary btn-sm flex-shrink-0">
                            <i class="fa-solid fa-eye"></i> Xem bài làm
                        </a>
                    </div>
                </div>
            <?php 
                $index++;
            endwhile; 
            ?>
        </div>
    <?php else: ?>
        <div class="alert alert-light text-center">
            <i class="fa-solid fa-file-circle-xmark fa-3x mb-3 text-muted"></i>
            <p class="mb-0">Bạn chưa có kết quả bài kiểm tra nào.</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressBars = document.querySelectorAll('.progress-bar');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const finalWidth = bar.getAttribute('data-final-width');
                setTimeout(() => {
                    bar.style.width = finalWidth + '%';
                }, 100);
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.5 });

    progressBars.forEach(bar => {
        observer.observe(bar);
    });
});
</script>