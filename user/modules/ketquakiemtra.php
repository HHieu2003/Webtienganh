<?php
// user/modules/ketquakiemtra.php
if (!isset($_SESSION['id_hocvien'])) {
    die("Vui lòng đăng nhập để xem kết quả.");
}

$id_hocvien = $_SESSION['id_hocvien'];

// --- Pagination settings ---
$results_per_page = 8;
$current_page = isset($_GET['result_page']) ? max(1, intval($_GET['result_page'])) : 1;
$offset = ($current_page - 1) * $results_per_page;

// --- Count total test results ---
$sql_count = "SELECT COUNT(*) as total FROM ketquabaitest WHERE id_hocvien = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $id_hocvien);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_results = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_results / $results_per_page);

// Lấy danh sách kết quả bài kiểm tra của học viên với phân trang
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
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($sql_results);
$stmt->bind_param("iii", $id_hocvien, $results_per_page, $offset);
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

    /* Test Results Pagination Styles - GIỐNG LICHSUTHANHTOAN */
    .result-pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
    }

    .result-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #66eabaff 0%, #4ba254ff 100%);
        padding: 12px 25px;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(13, 179, 59, 0.25);
        backdrop-filter: blur(10px);
    }

    .result-pagination-btn {
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

    .result-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        color: var(--primary-color-dark);
    }

    .result-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .result-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0 10px;
    }

    .result-pagination-number {
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

    .result-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color);
        border-color: rgba(255,255,255,0.8);
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    .result-pagination-number.active {
        background: #fff;
        color: var(--primary-color-dark);
        border-color: #fff;
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        animation: resultPagePulse 0.4s ease;
    }

    @keyframes resultPagePulse {
        0%, 100% { transform: scale(1.15); }
        50% { transform: scale(1.25); }
    }

    .result-pagination-dots {
        color: rgba(255,255,255,0.6);
        font-weight: bold;
        padding: 0 5px;
    }

    .result-pagination-info {
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

    .result-pagination-info i {
        font-size: 16px;
    }

    .result-pagination-info strong {
        color: var(--primary-color-dark);
        font-size: 15px;
    }

    .result-pagination-info .separator {
        margin: 0 5px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .result-pagination {
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .result-pagination-btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .result-pagination-btn span {
            display: none;
        }

        .result-pagination-number {
            min-width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .result-pagination-info {
            font-size: 12px;
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .result-pagination-numbers {
            gap: 4px;
            margin: 0 5px;
        }

        .result-pagination-number {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }
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

        <?php if ($total_pages > 1): ?>
            <!-- Pagination -->
            <div class="result-pagination-container">
                <div class="result-pagination">
                    <!-- Previous Button -->
                    <a href="?nav=ketquakiemtra&result_page=<?php echo max(1, $current_page - 1); ?>" 
                       class="result-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>

                    <!-- Page Numbers -->
                    <div class="result-pagination-numbers">
                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        if ($start_page > 1) {
                            echo '<a href="?nav=ketquakiemtra&result_page=1" class="result-pagination-number">1</a>';
                            if ($start_page > 2) {
                                echo '<span class="result-pagination-dots">...</span>';
                            }
                        }

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $active_class = ($i == $current_page) ? 'active' : '';
                            echo '<a href="?nav=ketquakiemtra&result_page=' . $i . '" class="result-pagination-number ' . $active_class . '">' . $i . '</a>';
                        }

                        if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                                echo '<span class="result-pagination-dots">...</span>';
                            }
                            echo '<a href="?nav=ketquakiemtra&result_page=' . $total_pages . '" class="result-pagination-number">' . $total_pages . '</a>';
                        }
                        ?>
                    </div>

                    <!-- Next Button -->
                    <a href="?nav=ketquakiemtra&result_page=<?php echo min($total_pages, $current_page + 1); ?>" 
                       class="result-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <!-- Pagination Info -->
                <div class="result-pagination-info">
                    <i class="fas fa-clipboard-check"></i>
                    <span>
                        Hiển thị 
                        <strong><?php echo min($offset + 1, $total_results); ?></strong>
                        <span class="separator">-</span>
                        <strong><?php echo min($offset + $results_per_page, $total_results); ?></strong>
                        <span class="separator">/</span>
                        <strong><?php echo $total_results; ?></strong>
                        kết quả
                    </span>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-light text-center">
            <i class="fa-solid fa-file-circle-xmark fa-3x mb-3 text-muted"></i>
            <p class="mb-0">Bạn chưa có kết quả bài kiểm tra nào.</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress bar animation
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

    // Smooth scroll to top when clicking result pagination
    const resultPaginationLinks = document.querySelectorAll('.result-pagination-number, .result-pagination-btn');
    resultPaginationLinks.forEach(link => {
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