<?php
// File: admin/modules/cauhoi/kqhocvien.php (Giao diện đã được nâng cấp)
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$id_baitest = (int)($_GET['id_baitest'] ?? 0);
if ($id_baitest === 0) die("ID bài test không hợp lệ.");

// Lấy thông tin bài test và tổng số câu hỏi
$stmt_test = $conn->prepare("
    SELECT 
        ten_baitest, 
        (SELECT COUNT(*) FROM cauhoi WHERE id_baitest = ? AND loai_cauhoi = 'trac_nghiem') as total_mc_questions,
        (SELECT COUNT(*) FROM cauhoi WHERE id_baitest = ? AND loai_cauhoi = 'tu_luan') as total_essay_questions
    FROM baitest 
    WHERE id_baitest = ?
");
$stmt_test->bind_param("iii", $id_baitest, $id_baitest, $id_baitest);
$stmt_test->execute();
$test_info = $stmt_test->get_result()->fetch_assoc();
$total_mc_questions = (int)($test_info['total_mc_questions'] ?? 0);
$total_essay_questions = (int)($test_info['total_essay_questions'] ?? 0);
$stmt_test->close();

// Lấy danh sách kết quả
$sql = "SELECT kq.id_ketqua, hv.ten_hocvien, hv.email, kq.diem, kq.ngay_lam_bai
        FROM ketquabaitest kq
        JOIN hocvien hv ON kq.id_hocvien = hv.id_hocvien
        WHERE kq.id_baitest = ? ORDER BY kq.ngay_lam_bai DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_baitest);
$stmt->execute();
$results = $stmt->get_result();

// Hàm trợ giúp cho progress bar
function get_progress_bar_class($percentage) {
    if ($percentage >= 80) return 'bg-success';
    if ($percentage >= 50) return 'bg-warning';
    return 'bg-danger';
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animated-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .result-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        margin-bottom: 0.6rem; /* Giảm khoảng cách giữa các card */
        overflow: hidden; /* Quan trọng cho bo góc */
    }
    .result-card-main {
        padding: 0.9rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap; /* Cho phép wrap trên mobile */
    }
    .student-info {
        flex-grow: 1;
    }
    .student-info .name {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--dark-text);
    }
    .student-info .email {
        font-size: 0.85rem;
        color: var(--gray-text);
    }
    .mc-score-section {
        flex-shrink: 0;
        min-width: 200px;
    }
    .mc-score-section .score {
        font-weight: 600;
        font-size: 1.25rem;
    }
    .progress {
        height: 8px;
        border-radius: 8px;
    }
    .progress-bar {
        transition: width 1s ease-in-out;
    }
    .result-actions {
        display: flex;
        gap: 1.1rem;
        align-items: center;
    }
    .essay-toggle-btn {
        background-color: transparent;
        border: 1px solid var(--border-color);
        color: var(--gray-text);
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .essay-toggle-btn:hover {
        background-color: var(--brand-color-light);
        color: var(--brand-color-dark);
    }
    .essay-toggle-btn .toggle-icon {
        transition: transform 0.3s ease;
    }
    .essay-toggle-btn:not(.collapsed) .toggle-icon {
        transform: rotate(180deg);
    }
    .essay-details {
        background-color: #f8f9fa;
        padding: 1.5rem;
    }
    .essay-section {
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
    }
    .essay-answer {
        background: #fdfdfd;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        white-space: pre-wrap;
    }
    .ai-feedback { margin-top: 1rem; }
    .feedback-textarea { min-height: 120px; font-size: 14px; }
</style>

<div class="container-fluid">
    <div class="d-flex align-items-center mb-4 animated-item">
        <a href="./admin.php?nav=question" class="btn btn-light border me-3"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h1 class="title-color mb-0" style="border: none; padding: 0;">Kết quả Bài test</h1>
            <p class="text-muted mb-0"><?php echo htmlspecialchars($test_info['ten_baitest']); ?></p>
        </div>
    </div>

    <?php if ($results->num_rows > 0):
        $index = 0;
        while ($row = $results->fetch_assoc()):
            $id_ketqua = $row['id_ketqua'];
            $percentage = $total_mc_questions > 0 ? round(((int)$row['diem'] / $total_mc_questions) * 100) : 0;
            
            $stmt_essays_count = $conn->prepare("SELECT COUNT(*) as count FROM dapan_hocvien dh JOIN cauhoi c ON dh.id_cauhoi = c.id_cauhoi WHERE dh.id_ketqua = ? AND c.loai_cauhoi = 'tu_luan'");
            $stmt_essays_count->bind_param("i", $id_ketqua);
            $stmt_essays_count->execute();
            $essay_count = $stmt_essays_count->get_result()->fetch_assoc()['count'];
            $stmt_essays_count->close();
    ?>
    <div class="result-card animated-item" style="animation-delay: <?php echo $index++ * 100; ?>ms;">
        <div class="result-card-main">
            <div class="student-info">
                <div class="name"><?php echo htmlspecialchars($row['ten_hocvien']); ?></div>
                <div class="email"><?php echo htmlspecialchars($row['email']); ?></div>
                <small class="text-muted">Nộp bài: <?php echo date("d/m/Y H:i", strtotime($row['ngay_lam_bai'])); ?></small>
            </div>

            <div class="mc-score-section">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-bold">Trắc nghiệm</span>
                    <span class="score text-primary"><?php echo (int)$row['diem'] . "/" . $total_mc_questions; ?></span>
                </div>
                <div class="progress" role="progressbar">
                    <div class="progress-bar <?php echo get_progress_bar_class($percentage); ?>" data-width="<?php echo $percentage; ?>" style="width: 0%"></div>
                </div>
            </div>

            <div class="result-actions">
                <?php if($essay_count > 0): ?>
                <button class="btn btn-sm essay-toggle-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#essays-<?php echo $id_ketqua; ?>">
                    Tự luận     
                    <i class="fa-solid fa-chevron-down toggle-icon ms-1"></i>
                </button>
                <?php endif; ?>
                <a href="./admin.php?nav=view_submission_admin&id_ketqua=<?php echo $id_ketqua; ?>" class="btn btn-sm btn-outline-secondary" title="Xem chi tiết"><i class="fa-solid fa-eye"></i></a>
                <a href="./modules/cauhoi/delete_result.php?id_ketqua=<?php echo $id_ketqua; ?>&id_baitest=<?php echo $id_baitest; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa kết quả này?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
            </div>
        </div>

        <?php if($essay_count > 0): ?>
        <div class="collapse essay-details" id="essays-<?php echo $id_ketqua; ?>">
            <?php
            $sql_essays = "SELECT dh.id, c.noi_dung, dh.tra_loi_tu_luan, dh.trang_thai_cham, dh.diem_tu_luan, dh.nhan_xet_tu_luan FROM dapan_hocvien dh JOIN cauhoi c ON dh.id_cauhoi = c.id_cauhoi WHERE dh.id_ketqua = ? AND c.loai_cauhoi = 'tu_luan'";
            $stmt_essays = $conn->prepare($sql_essays);
            $stmt_essays->bind_param("i", $id_ketqua);
            $stmt_essays->execute();
            $essays = $stmt_essays->get_result();
            while ($essay = $essays->fetch_assoc()):
                $dapan_hocvien_id = $essay['id'];
            ?>
            <div class='essay-section' id='essay-section-<?php echo $dapan_hocvien_id; ?>'>
                <h6><strong>Đề bài:</strong> <?php echo htmlspecialchars($essay['noi_dung']); ?></h6>
                <p class="mb-1"><strong>Bài làm của học viên:</strong></p>
                <div class='essay-answer'><?php echo nl2br(htmlspecialchars($essay['tra_loi_tu_luan'])); ?></div>
                <div class='mt-3' id='grading-status-<?php echo $dapan_hocvien_id; ?>'>
                    <?php if ($essay['trang_thai_cham'] == 'da_cham' && $essay['diem_tu_luan'] !== null): ?>
                    <div class='ai-feedback'>
                        <form onsubmit='updateGrade(event, <?php echo $dapan_hocvien_id; ?>)'>
                            <div class='row align-items-center g-2 mb-2'>
                                <div class='col-auto'><strong>Điểm:</strong></div>
                                <div class='col-auto'><input type='number' step='0.1' min='0' max='10' class='form-control form-control-sm' name='score' value='<?php echo htmlspecialchars($essay['diem_tu_luan']); ?>' style='width: 80px;'></div>
                                <div class='col-auto'>/ 10</div>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'><strong>Nhận xét:</strong></label>
                                <textarea class='form-control form-control-sm feedback-textarea' name='feedback'><?php echo htmlspecialchars($essay['nhan_xet_tu_luan']); ?></textarea>
                            </div>
                            <div class='d-flex gap-2'>
                                <button type='submit' class='btn btn-success btn-sm'><i class='fa-solid fa-save'></i> Lưu</button>
                                <button type='button' class='btn btn-primary btn-sm' onclick='gradeEssay(<?php echo $dapan_hocvien_id; ?>)'><i class='fa-solid fa-robot'></i> Chấm lại</button>
                            </div>
                        </form>
                    </div>
                    <?php else: ?>
                    <button class='btn btn-warning btn-sm' onclick='gradeEssay(<?php echo $dapan_hocvien_id; ?>)'><i class='fa-solid fa-robot'></i> Chấm bài bằng AI</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; $stmt_essays->close(); ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endwhile; else: ?>
    <div class="alert alert-light text-center animated-item">
        <i class="fa-solid fa-file-circle-xmark fa-3x mb-3 text-muted"></i>
        <p class="mb-0">Chưa có học viên nào làm bài test này.</p>
    </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Hiệu ứng thanh tiến trình khi cuộn tới ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressBar = entry.target;
                    const finalWidth = progressBar.getAttribute('data-width');
                    progressBar.style.width = finalWidth + '%';
                    observer.unobserve(progressBar);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.progress-bar').forEach(bar => {
            observer.observe(bar);
        });
    });

    async function gradeEssay(dapanHocvienId) {
        const statusDiv = document.getElementById(`grading-status-${dapanHocvienId}`);
        const originalButtonHTML = statusDiv.innerHTML;
        statusDiv.innerHTML = `<button class="btn btn-secondary btn-sm" disabled><span class="spinner-border spinner-border-sm"></span> AI đang chấm...</button>`;

        try {
            const response = await fetch('modules/cauhoi/grade_essay.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ dapan_hocvien_id: dapanHocvienId })
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            if (data.status === 'success') {
                const newFormHTML = `
                <div class='ai-feedback'>
                    <form onsubmit='updateGrade(event, ${dapanHocvienId})'>
                        <div class='row align-items-center g-2 mb-2'>
                            <div class='col-auto'><strong>Điểm:</strong></div>
                            <div class='col-auto'><input type='number' step='0.1' min='0' max='10' class='form-control form-control-sm' name='score' value='${data.score}' style='width: 80px;'></div>
                            <div class='col-auto'>/ 10</div>
                        </div>
                        <div class='mb-2'>
                            <label class='form-label'><strong>Nhận xét:</strong></label>
                            <textarea class='form-control form-control-sm feedback-textarea' name='feedback'>${data.feedback.replace(/<br\s*\/?>/ig, "\\n")}</textarea>
                        </div>
                        <div class='d-flex gap-2'>
                            <button type='submit' class='btn btn-success btn-sm'><i class='fa-solid fa-save'></i> Lưu</button>
                            <button type='button' class='btn btn-primary btn-sm' onclick='gradeEssay(${dapanHocvienId})'><i class='fa-solid fa-robot'></i> Chấm lại</button>
                        </div>
                    </form>
                </div>`;
                statusDiv.innerHTML = newFormHTML;
                Swal.fire('Hoàn thành!', 'AI đã chấm điểm xong.', 'success');
            } else {
                Swal.fire('Lỗi!', data.message || 'Có lỗi xảy ra.', 'error');
                statusDiv.innerHTML = originalButtonHTML;
            }
        } catch (error) {
            console.error('Fetch error:', error);
            Swal.fire('Lỗi Mạng!', 'Không thể kết nối đến máy chủ.', 'error');
            statusDiv.innerHTML = originalButtonHTML;
        }
    }

    async function updateGrade(event, dapanHocvienId) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        formData.append('dapan_hocvien_id', dapanHocvienId);

        const saveButton = form.querySelector('button[type="submit"]');
        saveButton.disabled = true;
        saveButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Đang lưu...`;

        try {
            const response = await fetch('modules/cauhoi/update_grade.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.status === 'success') {
                Swal.fire({icon: 'success', title: 'Thành công!', text: data.message, timer: 1500, showConfirmButton: false});
            } else {
                Swal.fire('Lỗi!', data.message, 'error');
            }
        } catch (error) {
            Swal.fire('Lỗi Mạng!', 'Không thể kết nối đến máy chủ.', 'error');
        } finally {
            saveButton.disabled = false;
            saveButton.innerHTML = `<i class='fa-solid fa-save'></i> Lưu`;
        }
    }
</script>
