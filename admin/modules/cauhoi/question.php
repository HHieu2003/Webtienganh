<?php
include('../config/config.php');

// Lấy danh sách bài test
$sql = "SELECT bt.id_baitest, bt.ten_baitest,  bt.ngay_tao, kh.ten_khoahoc 
        FROM baitest bt 
        JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

// Lấy danh sách khóa học để hiển thị trong dropdown
$sql_khoahoc = "SELECT id_khoahoc, ten_khoahoc FROM khoahoc";
$result_khoahoc = mysqli_query($conn, $sql_khoahoc);
if (!$result_khoahoc) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
?>



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_baitest = mysqli_real_escape_string($conn, $_POST['ten_baitest']);
    $id_khoahoc = mysqli_real_escape_string($conn, $_POST['id_khoahoc']);
    $thoi_gian = (int)$_POST['thoi_gian'];

    // Kiểm tra dữ liệu hợp lệ
    if (empty($ten_baitest) || empty($id_khoahoc) || $thoi_gian <= 0) {
        echo "<div class='alert alert-danger'>Vui lòng nhập đầy đủ thông tin hợp lệ!</div>";
    } else {
        // Thêm bài test vào cơ sở dữ liệu
        $sql_insert = "INSERT INTO baitest (ten_baitest, id_khoahoc,thoi_gian, ngay_tao)
                       VALUES (?, ?,  ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt, 'sii', $ten_baitest, $id_khoahoc,  $thoi_gian);

        if (mysqli_stmt_execute($stmt)) {
            // Chuyển hướng về danh sách bài test sau khi thêm thành công
            header("Location: ./admin.php?nav=question");
            exit();
        } else {
            header("Location: ./admin.php?nav=question");
        }
    }
}

mysqli_close($conn);
?>





<div class="container my-3">
    <h1 class="text-center title-color">Quản lý Bài Test</h1>
    <!-- Nút thêm bài test -->
    <a href="./admin.php?nav=question&action=add" class="btn btn-success mb-3">Thêm Bài Test</a>
    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'delete_success') {
            echo "<div class='alert alert-success'>Xóa bài test thành công!</div>";
        } elseif ($_GET['status'] === 'delete_error' && isset($_GET['message'])) {
            echo "<div class='alert alert-danger'>Lỗi khi xóa bài test: " . htmlspecialchars(urldecode($_GET['message'])) . "</div>";
        }
    }
    ?>

    <?php if (isset($_GET['action'])) : ?>

        <div class="container my-3">
            <h3 class="">Thêm Bài Test</h3>

            <!-- Form thêm bài test -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="ten_baitest">Tên Bài Test</label>
                    <input type="text" name="ten_baitest" id="ten_baitest" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_khoahoc">Chọn Khóa Học</label>
                    <select name="id_khoahoc" id="id_khoahoc" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($result_khoahoc)): ?>
                            <option value="<?= $row['id_khoahoc'] ?>"><?= htmlspecialchars($row['ten_khoahoc']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
              
                <div class="mb-3">
                    <label for="thoi_gian">Thời Gian Làm Bài (phút)</label>
                    <input type="number" name="thoi_gian" id="thoi_gian" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm Bài Test</button>
                <a href="./admin.php?nav=question" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>

    <?php else : ?>

        <!-- Bảng danh sách bài test -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Bài Test</th>
                    <th>Ngày Tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_baitest']) ?></td>
                        <td><?= htmlspecialchars($row['ten_baitest']) ?></td>
                        <td><?= htmlspecialchars($row['ngay_tao']) ?></td>
                        <td style="width: 280px;">
                            <a href="./admin.php?nav=ds_cauhoi&id_baitest=<?= $row['id_baitest'] ?>" class="btn btn-primary btn-sm">Xem câu hỏi </a>
                            <a href="./admin.php?nav=kqhocvien&id_baitest=<?= $row['id_baitest'] ?>" class="btn btn-info btn-sm">Kết quả học Viên</a>
                            <a href="./modules/cauhoi/delete_test.php?id_baitest=<?= $row['id_baitest'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa bài test này?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>