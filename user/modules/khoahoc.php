<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'quanlykhoahoc');
$hocvien_id = $_SESSION['id_hocvien']; // Lấy ID học viên từ session

// Truy vấn danh sách khóa học đã đăng ký
$sql = "SELECT dk.id_khoahoc, kh.ten_khoahoc, kh.giang_vien, dk.ngay_dangky, dk.trang_thai, dk.id_lop
        FROM dangkykhoahoc dk
        JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc
        WHERE dk.id_hocvien = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hocvien_id);
$stmt->execute();
$result = $stmt->get_result();
?>


    <div class="container mt-5">
        <h1 class="text-center mb-4 introduce-title">Danh sách khóa học đã đăng ký</h1>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-6 mb-4" >
                    <div class="card shadow-sm">
                        <div class="card-body " style="height: 155px;">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['ten_khoahoc']); ?></h5>
                            <p class="card-text fs-6">
                                <strong>Giảng viên:</strong> <?php echo htmlspecialchars($row['giang_vien']); ?><br>
                                <strong>Ngày đăng ký:</strong> <?php echo htmlspecialchars($row['ngay_dangky']); ?> <br>
                            <strong>Trạng thái:</strong> 
                            <?php if ($row['trang_thai'] === 'da xac nhan' && $row['id_lop']!==null) { ?>
                                <span class="badge bg-success">Đã xác nhận</span>

                                <a href="dashboard.php?nav=lichhoc&id_khoahoc=<?php echo $row['id_khoahoc']; ?>" class="btn btn-primary btn-xem">Xem lịch học</a>
                                <?php } elseif ($row['trang_thai'] === 'da xac nhan' && $row['id_lop'] ==null) { ?>
                                    <span class="badge bg-success">Đã xác nhận</span>


                            <?php } elseif ($row['trang_thai'] === 'cho xac nhan') { ?>
                                <span class="badge bg-warning">Đang chờ</span>
                            <?php } else { ?>
                                <span class="badge bg-danger">Bị Hủy</span>
                            <?php } ?>
                            </p>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<style>
    .btn-xem{
        bottom: 10%;
    position: absolute;
    right: 5%;
    }
</style>