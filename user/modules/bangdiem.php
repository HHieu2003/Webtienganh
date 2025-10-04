<?php
// File: user/modules/bangdiem.php
if (!isset($_SESSION['id_hocvien'])) { die("Vui lòng đăng nhập."); }

$id_hocvien = $_SESSION['id_hocvien'];

// Lấy tất cả điểm của học viên, gom nhóm theo lớp học
$sql = "
    SELECT 
        ds.loai_diem, ds.diem, ds.nhan_xet,
        lh.ten_lop,
        kh.ten_khoahoc
    FROM diem_so ds
    JOIN lop_hoc lh ON ds.id_lop = lh.id_lop
    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
    WHERE ds.id_hocvien = ?
    ORDER BY kh.ten_khoahoc, lh.ten_lop, ds.loai_diem
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_hocvien);
$stmt->execute();
$result = $stmt->get_result();

$grades_by_class = [];
while ($row = $result->fetch_assoc()) {
    $class_key = $row['ten_lop'] . ' (' . $row['ten_khoahoc'] . ')';
    $grades_by_class[$class_key][] = $row;
}

// Hàm trợ giúp để lấy lớp CSS dựa trên điểm số
function get_score_class($score) {
    if ($score === null || $score === '') return 'score-none';
    if ($score >= 8.5) return 'score-high';
    if ($score >= 7.0) return 'score-good';
    if ($score >= 5.0) return 'score-average';
    return 'score-low';
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .grade-card {
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 25px;
        border-top: 4px solid var(--primary-color);
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .grade-card-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .grade-card-header h5 {
        margin: 0;
        font-weight: 600;
        color: var(--dark-text);
        font-size: 18px;
    }
    
    .grade-list {
        padding: 10px 20px;
    }

    .grade-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        gap: 15px;
    }
    .grade-item:not(:last-child) {
        border-bottom: 1px dashed var(--border-color);
    }

    .grade-info {
        flex-grow: 1;
    }

    .grade-type {
        font-size: 16px;
        font-weight: 500;
        color: var(--dark-text);
        margin-bottom: 5px;
    }

    .grade-comment {
        font-style: italic;
        color: var(--gray-text);
        font-size: 14px;
    }
    .grade-comment i {
        margin-right: 5px;
    }

    .grade-score {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: bold;
        color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Màu sắc cho điểm số */
    .score-high { background: linear-gradient(135deg, #28a745, #218838); } /* Giỏi */
    .score-good { background: linear-gradient(135deg, #17a2b8, #138496); } /* Khá */
    .score-average { background: linear-gradient(135deg, #ffc107, #d39e00); } /* Trung bình */
    .score-low { background: linear-gradient(135deg, #dc3545, #c82333); } /* Yếu */
    .score-none { background: #6c757d; } /* Chưa có điểm */

</style>

<div class="content-pane">
    <h2 class="mb-4">Bảng điểm chi tiết</h2>

    <?php if (!empty($grades_by_class)): 
        $delay_index = 0;
        foreach ($grades_by_class as $class_name => $grades): ?>
        <div class="grade-card" style="animation-delay: <?php echo $delay_index * 100; ?>ms;">
            <div class="grade-card-header">
                <h5><i class="fa-solid fa-school-flag me-2 text-primary"></i><?php echo htmlspecialchars($class_name); ?></h5>
            </div>
            <div class="grade-list">
                <?php foreach ($grades as $grade): ?>
                    <div class="grade-item">
                        <div class="grade-info">
                            <div class="grade-type"><?php echo htmlspecialchars($grade['loai_diem']); ?></div>
                            <?php if(!empty($grade['nhan_xet'])): ?>
                                <div class="grade-comment">

                                    <i class="fa-solid fa-quote-left"></i> <strong> Nhận xét của giảng viên:</strong> <?php echo htmlspecialchars($grade['nhan_xet']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="grade-score <?php echo get_score_class($grade['diem']); ?>">
                            <span><?php echo htmlspecialchars($grade['diem'] ?? '-'); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
            $delay_index++;
        endforeach; 
    ?>
    <?php else: ?>
        <div class="alert alert-info text-center">Bạn chưa có điểm số nào.</div>
    <?php endif; ?>
</div>