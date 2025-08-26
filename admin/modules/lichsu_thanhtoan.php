<?php
include('../config/config.php');

// Lấy danh sách học viên
$sql_hocvien = "SELECT id_hocvien, ten_hocvien, email,so_dien_thoai FROM hocvien";
$result_hocvien = mysqli_query($conn, $sql_hocvien);

if (!$result_hocvien) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

// Lấy lịch sử thanh toán của một học viên nếu được yêu cầu
$lich_su_thanhtoan = [];
if (isset($_GET['id_hocvien'])) {
    $id_hocvien = $_GET['id_hocvien'];

    $sql_thanhtoan = "SELECT lt.id_thanhtoan, lt.ngay_thanhtoan, lt.so_tien, lt.hinh_thuc, lt.trang_thai, kh.ten_khoahoc
                      FROM lichsu_thanhtoan lt
                      JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
                      WHERE lt.id_hocvien = ?
                      ORDER BY lt.ngay_thanhtoan DESC";
    $stmt = mysqli_prepare($conn, $sql_thanhtoan);
    mysqli_stmt_bind_param($stmt, 'i', $id_hocvien);
    mysqli_stmt_execute($stmt);
    $lich_su_thanhtoan = mysqli_stmt_get_result($stmt);
}
?>

<div class="container my-3">
    <h1 class="text-center title-color">Lịch sử thanh toán</h1>
    
    <?php if(isset($_GET['nav']) && !isset($_GET['id_hocvien'])) : ?>
    
    <!-- Form tìm kiếm -->
    <form method="GET" action="./admin.php" class="mb-3" style="width: 25%;">
        <input type="hidden" name="nav" value="thanhtoan">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm học viên..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button class="btn btn-primary ms-2" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>

    <!-- Danh sách học viên -->
    <h3>Danh sách học viên</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên học viên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Truy vấn danh sách học viên (có hỗ trợ tìm kiếm)
            $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
            $sql_hocvien = "SELECT id_hocvien, ten_hocvien, email, so_dien_thoai 
                            FROM hocvien 
                            WHERE ten_hocvien LIKE ? 
                               OR email LIKE ? 
                               OR so_dien_thoai LIKE ?";
            $stmt = mysqli_prepare($conn, $sql_hocvien);
            mysqli_stmt_bind_param($stmt, 'sss', $search, $search, $search);
            mysqli_stmt_execute($stmt);
            $result_hocvien = mysqli_stmt_get_result($stmt);

            // Hiển thị kết quả
            while ($hocvien = mysqli_fetch_assoc($result_hocvien)): ?>
                <tr>
                    <td><?= htmlspecialchars($hocvien['id_hocvien']) ?></td>
                    <td><?= htmlspecialchars($hocvien['ten_hocvien']) ?></td>
                    <td><?= htmlspecialchars($hocvien['email']) ?></td>
                    <td><?= htmlspecialchars($hocvien['so_dien_thoai']) ?></td>
                    <td style="text-align: center;">
                        <a href="./admin.php?nav=thanhtoan&id_hocvien=<?= $hocvien['id_hocvien'] ?>" 
                           class="btn btn-primary btn-sm">Xem lịch sử</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


    <!-- Lịch sử thanh toán -->
    <?php elseif (isset($_GET['id_hocvien']) && mysqli_num_rows($lich_su_thanhtoan) > 0): ?>
        <h3>Lịch sử thanh toán của học viên:
            <?php
             $sql_course = "SELECT * FROM hocvien WHERE id_hocvien = ?";
             $stmt = $conn->prepare($sql_course);
             $stmt->bind_param("i", $_GET['id_hocvien']);
             $stmt->execute();
             $result_course = $stmt->get_result();
         
             // Kiểm tra nếu khóa học tồn tại
             if ($result_course->num_rows > 0) {
                 $course = $result_course->fetch_assoc();
             }
             ?>
            <?php echo $course['ten_hocvien']; ?>

             
        </h3>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID </th>
                    <th>Khóa học</th>
                    <th>Ngày</th>
                    <th>Số tiền</th>
                    <th>Hình thức</th>
                    <th>Trạng thái</th>
                    <th></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ( $thanhtoan = mysqli_fetch_assoc($lich_su_thanhtoan)): ?>
                    <tr>
                        <td><?= htmlspecialchars($thanhtoan['id_thanhtoan']) ?></td>
                        <td><?= htmlspecialchars($thanhtoan['ten_khoahoc']) ?></td>
                        <td><?= htmlspecialchars($thanhtoan['ngay_thanhtoan']) ?></td>
                        <td><?= number_format($thanhtoan['so_tien'], 2) ?> VND</td>
                        <td><?= htmlspecialchars($thanhtoan['hinh_thuc']) ?></td>
                        <td><?= htmlspecialchars($thanhtoan['trang_thai']) ?></td>
                        <td>
                    <!-- Nút xóa -->
                    <form method="POST" action="modules/delete_thanhtoan.php" style="display:inline;">
                        <input type="hidden" name="id_thanhtoan" value="<?= $thanhtoan['id_thanhtoan']?>">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                    </form>
                </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif (isset($_GET['id_hocvien'])): ?>
        <h3>Lịch sử thanh toán của học viên:
            <?= htmlspecialchars($_GET['id_hocvien']) ?>

        </h3>
        <p>Không có lịch sử thanh toán nào được tìm thấy.</p>
    <?php endif; ?>
</div> 