<?php
// --- LẤY DỮ LIỆU KHÓA HỌC ---
if (isset($_GET['course_id'])) {
    $course_id = (int)$_GET['course_id'];

    $sql_course = "SELECT kh.*, gv.ten_giangvien 
                   FROM khoahoc kh
                   LEFT JOIN giangvien gv ON kh.id_giangvien = gv.id_giangvien
                   WHERE kh.id_khoahoc = ?";
    $stmt = $conn->prepare($sql_course);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result_course = $stmt->get_result();

    if ($result_course->num_rows > 0) {
        $course = $result_course->fetch_assoc();
    } else {
        echo "<script>alert('Khóa học không tồn tại!'); window.location.href='./index.php';</script>";
        exit;
    }

    $sql_avg_rating = "SELECT AVG(diem_danhgia) AS avg_rating, COUNT(*) as total_reviews FROM danhgiakhoahoc WHERE id_khoahoc = ?";
    $stmt_avg = $conn->prepare($sql_avg_rating);
    $stmt_avg->bind_param("i", $course_id);
    $stmt_avg->execute();
    $result_avg_rating = $stmt_avg->get_result()->fetch_assoc();
    $avg_rating = $result_avg_rating['avg_rating'] ? round($result_avg_rating['avg_rating'], 1) : 0;
    $total_reviews = $result_avg_rating['total_reviews'];

    $sql_get_comments = "SELECT dg.nhan_xet, dg.diem_danhgia, hv.ten_hocvien 
                         FROM danhgiakhoahoc dg 
                         JOIN hocvien hv ON dg.id_hocvien = hv.id_hocvien 
                         WHERE dg.id_khoahoc = ? ORDER BY dg.id_danhgia DESC";
    $stmt_comments = $conn->prepare($sql_get_comments);
    $stmt_comments->bind_param("i", $course_id);
    $stmt_comments->execute();
    $result_comments = $stmt_comments->get_result();
} else {
    echo "<script>alert('Không có khóa học được chọn!'); window.location.href='./index.php';</script>";
    exit;
}

// --- XỬ LÝ GỬI ĐÁNH GIÁ ---
$review_message = '';
$review_message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    $diem_danhgia = $_POST['diem_danhgia'];
    $nhan_xet = trim($_POST['nhan_xet']);
    $hocvien_id = $_SESSION['id_hocvien'] ?? null;
    if ($hocvien_id) {
        $sql_check_reg = "SELECT * FROM dangkykhoahoc WHERE id_hocvien = ? AND id_khoahoc = ? AND trang_thai = 'da xac nhan'";
        $stmt_check = $conn->prepare($sql_check_reg);
        $stmt_check->bind_param("ii", $hocvien_id, $course_id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            $sql_check_existing_review = "SELECT id_danhgia FROM danhgiakhoahoc WHERE id_hocvien = ? AND id_khoahoc = ?";
            $stmt_check_review = $conn->prepare($sql_check_existing_review);
            $stmt_check_review->bind_param("ii", $hocvien_id, $course_id);
            $stmt_check_review->execute();
            if ($stmt_check_review->get_result()->num_rows > 0) {
                $review_message = 'Bạn đã đánh giá khóa học này rồi!';
                $review_message_type = 'warning';
            } else {
                $sql_insert = "INSERT INTO danhgiakhoahoc (id_hocvien, id_khoahoc, diem_danhgia, nhan_xet) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("iiis", $hocvien_id, $course_id, $diem_danhgia, $nhan_xet);
                if ($stmt_insert->execute()) {
                    $_SESSION['review_message'] = 'Cảm ơn bạn đã đánh giá khóa học!';
                    $_SESSION['review_message_type'] = 'success';
                    header("Location: " . $_SERVER['REQUEST_URI'] . "#reviews");
                    exit;
                } else {
                    $review_message = 'Đã có lỗi xảy ra. Vui lòng thử lại.';
                    $review_message_type = 'danger';
                }
            }
        } else {
            $review_message = 'Bạn cần hoàn tất đăng ký khóa học này để có thể đánh giá!';
            $review_message_type = 'danger';
        }
    } else {
        $review_message = 'Vui lòng đăng nhập để đánh giá khóa học!';
        $review_message_type = 'danger';
    }
}
if (isset($_SESSION['review_message'])) {
    $review_message = $_SESSION['review_message'];
    $review_message_type = $_SESSION['review_message_type'];
    unset($_SESSION['review_message']);
    unset($_SESSION['review_message_type']);
}
?>
<div class="course-hero-section">
    <div class="background-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="course-main-title"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h1>
                <div class="course-meta-info">
                    <span><i class="fas fa-chalkboard-teacher"></i> Giảng viên: <strong><?php echo htmlspecialchars($course['ten_giangvien'] ?? 'Đang cập nhật'); ?></strong></span>
                    <span><i class="fas fa-star"></i><strong><?php echo $avg_rating; ?></strong> (<?php echo $total_reviews; ?> đánh giá)</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="course-detail-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="course-tabs" data-aos="fade-up">
                    <ul class="nav nav-tabs" id="courseTab" role="tablist">
                        <li class="nav-item" role="presentation"><button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Mô Tả Khóa Học</button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Đánh Giá (<?php echo $total_reviews; ?>)</button></li>
                    </ul>
                    <div class="tab-content" id="courseTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="course-description-content">
                                <div class="course-main-image" data-aos="fade-up"><img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>"></div>
                                <?php echo !empty($course['mo_ta']) ? $course['mo_ta'] : '<p>Nội dung đang được cập nhật...</p>'; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews-section">
                                <h4><?php echo $total_reviews; ?> đánh giá cho khóa học này</h4>
                                <?php if ($result_comments->num_rows > 0): ?>
                                    <?php while ($comment = $result_comments->fetch_assoc()): ?>
                                        <div class="review-item"><img src="https://i.pravatar.cc/100?u=<?php echo urlencode($comment['ten_hocvien']); ?>" alt="avatar"><div class="review-content"><div class="review-header"><strong><?php echo htmlspecialchars($comment['ten_hocvien']); ?></strong><span class="review-stars"><?php for ($i = 0; $i < 5; $i++): ?><i class="fas fa-star <?php echo ($i < $comment['diem_danhgia']) ? 'filled' : ''; ?>"></i><?php endfor; ?></span></div><p><?php echo nl2br(htmlspecialchars($comment['nhan_xet'])); ?></p></div></div>
                                    <?php endwhile; ?>
                                <?php else: ?><p>Chưa có đánh giá nào cho khóa học này.</p><?php endif; ?>
                                <hr>
                                <div class="submit-review-form">
                                    <h5>Gửi đánh giá của bạn</h5>
                                    <?php if (!empty($review_message)): ?><div class="alert alert-<?php echo $review_message_type; ?>"><?php echo $review_message; ?></div><?php endif; ?>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>#reviews">
                                        <div class="form-group mb-3"><label for="diem_danhgia" class="form-label">Đánh giá của bạn *</label><select name="diem_danhgia" id="diem_danhgia" class="form-select" required><option value="5">5 - Tuyệt vời</option><option value="4">4 - Tốt</option><option value="3">3 - Trung bình</option><option value="2">2 - Kém</option><option value="1">1 - Rất kém</option></select></div>
                                        <div class="form-group mb-3"><textarea name="nhan_xet" class="form-control" placeholder="Viết nhận xét của bạn tại đây..." rows="4" required></textarea></div>
                                        <button type="submit" name="submit_rating" class="btn btn-success">Gửi đánh giá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-sticky" data-aos="fade-left" data-aos-delay="200">
                    <div class="course-summary-card">
                        <h4 class="card-title">Thông tin khóa học</h4>
                        <ul class="summary-list">
                            <li><i class="fas fa-tag"></i><strong>Giá:</strong> <span><?php echo number_format($course['chi_phi'], 0, ',', '.'); ?> VNĐ</span></li>
                            <li><i class="fas fa-user-tie"></i><strong>Giảng viên:</strong> <span><?php echo htmlspecialchars($course['ten_giangvien'] ?? 'N/A'); ?></span></li>
                            <li><i class="fas fa-calendar-alt"></i><strong>Thời lượng:</strong> <span><?php echo htmlspecialchars($course['thoi_gian']); ?> buổi</span></li>
                        </ul>
                        <button class="btn-enroll" data-bs-toggle="modal" data-bs-target="#classSelectionModal">Đăng Ký Ngay <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="classSelectionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="classSelectionModalLabel">Đăng ký khóa học</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body" id="classListContainer"></div>
    </div>
  </div>
</div>
<style>
/* ... (GIỮ NGUYÊN CSS CŨ CỦA BẠN) ... */
.course-hero-section{padding:60px 0;background:linear-gradient(135deg,#0db33b,#28a745);color:#fff}.course-main-title{font-size:42px;font-weight:700;margin-bottom:15px}.course-meta-info{display:flex;gap:25px;font-size:16px;opacity:.9}.course-meta-info i{margin-right:8px}.course-detail-container{margin:40px auto}.course-main-image{margin-bottom:30px;position:relative}.course-main-image img{width:100%;max-width: 500px; height:auto;border-radius:15px;box-shadow:0 10px 30px rgba(0,0,0,.1);transition:transform .3s ease}.course-main-image:hover img{transform:scale(1.03)}.course-tabs .nav-tabs{border-bottom:2px solid #eee}.course-tabs .nav-link{border:none;padding:15px 25px;font-size:18px;font-weight:600;color:#666;border-bottom:3px solid transparent;transition:all .3s ease}.course-tabs .nav-link.active{color:#0db33b;border-bottom-color:#0db33b;background-color:transparent}.tab-content{padding:30px;border:1px solid #eee;border-top:none;border-radius:0 0 15px 15px}.course-description-content{font-size:16px;line-height:1.8;color:#555}.reviews-section h4{font-weight:600;margin-bottom:20px}.review-item{display:flex;gap:15px;margin-bottom:25px;padding-bottom:25px;border-bottom:1px solid #f0f0f0}.review-item:last-child{border-bottom:none}.review-item img{width:50px;height:50px;border-radius:50%}.review-header{display:flex;justify-content:space-between;align-items:center; flex-wrap: wrap;}.review-stars i{color:#ccc}.review-stars i.filled{color:#ffc107}.review-content p{margin:5px 0 0 0;color:#555}.submit-review-form h5{font-weight:600;margin-bottom:15px}.submit-review-form .form-control,.submit-review-form .form-select{border-radius:8px}.submit-review-form .btn{border-radius:8px;font-weight:600}.sidebar-sticky{position:-webkit-sticky;position:sticky;top:100px}.course-summary-card{background-color:#fff;padding:30px;border-radius:15px;box-shadow:0 8px 35px rgba(0,0,0,.08);border:1px solid #eee}.card-title{font-size:22px;font-weight:600;margin-bottom:20px;text-align:center}.summary-list{list-style:none;padding:0;margin-bottom:25px}.summary-list li{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px dashed #eee}.summary-list li i{color:#0db33b;margin-right:10px}.summary-list li span{color:#555}.btn-enroll{display:block;width:100%;text-align:center;color:#fff;padding:14px;border-radius:8px;font-size:18px;font-weight:bold;text-decoration:none;background:linear-gradient(45deg,#ff416c,#ff4b2b);transition:all .3s ease; border: none;}.btn-enroll:hover{transform:translateY(-3px);box-shadow:0 5px 15px rgba(255,65,108,.4);color:#fff}.btn-enroll i{margin-left:5px;transition:transform .3s ease}.btn-enroll:hover i{transform:translateX(5px)}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}@keyframes slideInUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}.modal-content{border:none;border-radius:15px}.modal-header{background-color:#f8f9fa;border-bottom:1px solid #dee2e6}.modal-title{font-weight:600;color:#333}.modal-body{background-color:#f8f9fa;padding:25px}.class-item{background-color:#fff;border-radius:12px;padding:20px;margin-bottom:15px;box-shadow:0 4px 15px rgba(0,0,0,.05);border:1px solid #e9ecef;animation:slideInUp .5s ease-out forwards;opacity:0}.class-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}.class-header h6{font-size:18px;font-weight:600;color:#0db33b;margin:0}.class-meta{display:flex;gap:20px;font-size:14px;color:#6c757d}.class-actions .btn{font-size:14px;font-weight:500}.schedule-accordion .accordion-button{background-color:#f8f9fa;color:#333;font-weight:500}.schedule-accordion .accordion-button:not(.collapsed){background-color:#e7f7ec;color:#0a8a2c;box-shadow:none}.schedule-accordion .accordion-body{padding:0}.schedule-list{list-style:none;padding:0;margin:0;max-height:200px;overflow-y:auto}.schedule-list li{padding:10px 15px;border-bottom:1px solid #f0f0f0;font-size:14px;display:flex;justify-content:space-between; flex-wrap: wrap; gap: 10px;}.schedule-list li:last-child{border-bottom:none}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const classSelectionModal = document.getElementById('classSelectionModal');
    const classListContainer = document.getElementById('classListContainer');
    const modalTitle = document.getElementById('classSelectionModalLabel');
    const courseId = <?php echo $course_id; ?>;

    classSelectionModal.addEventListener('show.bs.modal', async function () {
        modalTitle.textContent = 'Đang tải thông tin...';
        classListContainer.innerHTML = `<div class="text-center p-5"><div class="spinner-border text-success" role="status"></div></div>`;
        
        try {
            const response = await fetch(`./pages/main/get_classes_for_course.php?course_id=${courseId}`);
            const classes = await response.json();
            
            let finalHtml = '';
            
            if (classes.length > 0) {
                modalTitle.textContent = 'Chọn Lớp Học Hoặc Để Lại Nguyện Vọng';
                let classListHtml = '<h5>Các lớp học đang có sẵn:</h5>';
                classes.forEach((classItem, index) => {
                    let scheduleHtml = '<p class="p-3 text-muted small">Chưa có lịch học chi tiết.</p>';
                    if (classItem.schedules && classItem.schedules.length > 0) {
                        scheduleHtml = '<ul class="schedule-list">';
                        classItem.schedules.forEach(schedule => {
                            const date = new Date(schedule.ngay_hoc).toLocaleDateString('vi-VN');
                            scheduleHtml += `<li><span><i class="fas fa-calendar-day text-success"></i> ${date}</span><span><i class="fas fa-clock text-success"></i> ${schedule.gio_bat_dau.substr(0,5)} - ${schedule.gio_ket_thuc.substr(0,5)}</span><span><i class="fas fa-map-marker-alt text-success"></i> ${schedule.phong_hoc}</span></li>`;
                        });
                        scheduleHtml += '</ul>';
                    }
                    classListHtml += `
                        <div class="class-item" style="animation-delay: ${index * 100}ms">
                             <form action="./index.php?nav=dangkykhoahoc" method="POST">
                                <input type="hidden" name="id_khoahoc" value="${courseId}">
                                <input type="hidden" name="id_lop" value="${classItem.id_lop}">
                                <div class="class-header">
                                    <h6>${classItem.ten_lop}</h6>
                                    <div class="class-actions">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#schedule-${classItem.id_lop}">Xem lịch</button>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Chọn lớp này</button>
                                    </div>
                                </div>
                            </form>
                            <div class="class-meta mt-2">
                                <span><i class="fas fa-user-tie"></i> GV: ${classItem.ten_giangvien || 'N/A'}</span>
                                <span><i class="fas fa-users"></i> Sĩ số: ${classItem.so_luong_hoc_vien}</span>
                            </div>
                            <div class="collapse mt-3" id="schedule-${classItem.id_lop}">
                                <div class="card card-body" style="padding: 0;">${scheduleHtml}</div>
                            </div>
                        </div>`;
                });
                finalHtml += classListHtml;
                finalHtml += '<hr class="my-4">';
            } else {
                 modalTitle.textContent = 'Đăng ký trước và để lại nguyện vọng';
            }

            // --- LUÔN HIỂN THỊ PHẦN GHI CHÚ ---
            const noteFormHtml = `
                <div class="mt-3">
                    <h5>${classes.length > 0 ? 'Hoặc không tìm thấy lớp phù hợp?' : ''} Đăng ký và để lại nguyện vọng</h5>
                    <div class="alert alert-info small">Nếu bạn đăng ký theo cách này, chúng tôi sẽ liên hệ để xếp lớp cho bạn sau.</div>
                    <form action="./index.php?nav=dangkykhoahoc" method="POST">
                        <input type="hidden" name="id_khoahoc" value="${courseId}">
                        <div class="mb-3">
                            <label for="ghi_chu" class="form-label"><strong>Ghi chú nguyện vọng</strong></label>
                            <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="4" placeholder="VD: Em có thể học vào các buổi tối T2-T4-T6."></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Đăng ký với ghi chú</button>
                        </div>
                    </form>
                </div>
            `;
            finalHtml += noteFormHtml;
            classListContainer.innerHTML = finalHtml;

        } catch (error) {
            console.error('Lỗi khi tải danh sách lớp:', error);
            classListContainer.innerHTML = '<div class="alert alert-danger text-center">Đã xảy ra lỗi khi tải dữ liệu.</div>';
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
