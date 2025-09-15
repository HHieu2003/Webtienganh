<?php
// Kết nối CSDL đã được include từ file dashboard.php

if (!isset($_SESSION['id_hocvien'])) {
    die("Session không hợp lệ.");
}
$id_hocvien = $_SESSION['id_hocvien'];

// --- Lấy danh sách các đăng ký đang chờ xác nhận (chờ thanh toán) ---
$sql_pending = "
    SELECT dk.id_dangky, kh.ten_khoahoc, dk.ngay_dangky
    FROM dangkykhoahoc dk
    JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
    WHERE dk.id_hocvien = ? AND dk.trang_thai = 'cho xac nhan'
    ORDER BY dk.ngay_dangky DESC
";
$stmt_pending = $conn->prepare($sql_pending);
$stmt_pending->bind_param("i", $id_hocvien);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();


// --- Lấy 3 khóa học gần nhất đã được xác nhận (đang học) ---
$sql_confirmed = "
    SELECT dk.id_khoahoc, kh.ten_khoahoc, kh.hinh_anh, gv.ten_giangvien
    FROM dangkykhoahoc dk
    JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
    LEFT JOIN giangvien gv ON kh.id_giangvien = gv.id_giangvien
    WHERE dk.id_hocvien = ? AND dk.trang_thai = 'da xac nhan'
    ORDER BY dk.ngay_dangky DESC
    LIMIT 3
";
$stmt_confirmed = $conn->prepare($sql_confirmed);
$stmt_confirmed->bind_param("i", $id_hocvien);
$stmt_confirmed->execute();
$result_confirmed = $stmt_confirmed->get_result();

?>

<div class="content-pane">
    <?php if ($result_pending->num_rows > 0): ?>
        <h2 class="mb-4">Đăng ký đang chờ thanh toán</h2>
        <div class="pending-registrations">
            <?php while ($row = $result_pending->fetch_assoc()): ?>
                <div class="pending-card">
                    <div class="pending-icon">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="pending-info">
                        <strong><?php echo htmlspecialchars($row['ten_khoahoc']); ?></strong>
                        <span>Ngày đăng ký: <?php echo date("d/m/Y", strtotime($row['ngay_dangky'])); ?></span>
                    </div>
                    <div class="pending-actions">
                        <a href="../pages/main/thanhtoan/checkout.php?dangky_id=<?php echo $row['id_dangky']; ?>" class="btn btn-success btn-sm">Thanh toán ngay</a>
                        <a href="modules/cancel_registration.php?id=<?php echo $row['id_dangky']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký này?');">Hủy</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <hr class="my-4">
    <?php endif; ?>
    
    <h2 class="mb-4">Khóa học của bạn</h2>
    <?php if ($result_confirmed->num_rows > 0): ?>
        <div class="active-courses-grid">
            <?php while ($row = $result_confirmed->fetch_assoc()): ?>
                <div class="course-card-active">
                    <div class="course-image">
                        <img src="../<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row['ten_khoahoc']); ?>">
                    </div>
                    <div class="course-content">
                        <h5><?php echo htmlspecialchars($row['ten_khoahoc']); ?></h5>
                        <p><i class="fa-solid fa-chalkboard-user"></i> <?php echo htmlspecialchars($row['ten_giangvien'] ?? 'Đang cập nhật'); ?></p>
                        <a href="dashboard.php?nav=lichhoc&id_khoahoc=<?php echo $row['id_khoahoc']; ?>" class="btn btn-primary-custom">Xem lịch học</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-3">
            <a href="dashboard.php?nav=khoahoc" class="view-all-link">Xem tất cả khóa học →</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Bạn chưa có khóa học nào đang hoạt động.</div>
    <?php endif; ?>
</div>

<style>
    /* --- Card chờ thanh toán --- */
    .pending-registrations {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .pending-card {
        display: flex;
        align-items: center;
        gap: 20px;
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
        padding: 15px 20px;
        border-radius: 10px;
    }
    .pending-icon i {
        font-size: 24px;
        color: #856404;
    }
    .pending-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .pending-info strong {
        font-size: 16px;
        color: #333;
    }
    .pending-info span {
        font-size: 14px;
        color: #6c757d;
    }
    .pending-actions {
        display: flex;
        gap: 10px;
    }

    /* --- Card khóa học đang hoạt động --- */
    .active-courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .course-card-active {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .course-card-active:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .course-card-active .course-image img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    .course-card-active .course-content {
        padding: 20px;
    }
    .course-card-active h5 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 10px;
        min-height: 48px; /* Giữ chỗ 2 dòng */
    }
    .course-card-active p {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 15px;
    }
    .btn-primary-custom {
        background-color: var(--primary-color);
        color: #fff;
        padding: 8px 15px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }
    .btn-primary-custom:hover {
        background-color: var(--primary-color-dark);
        color: #fff;
    }
    .view-all-link {
        font-weight: 600;
        color: var(--primary-color);
        text-decoration: none;
    }
</style>