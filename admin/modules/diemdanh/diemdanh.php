<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm danh lớp học</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .scrollable-table {
            overflow-x: auto;
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .form-header {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container p-0">
        <div class="card shadow">
            <div class="card-header text-center ">
                <h3>Điểm danh lớp học</h3>
            </div>
            <div class="card-body">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "quanlykhoahoc";

                // Tạo kết nối
                $conn = new mysqli($servername, $username, $password, $database);

                // Kiểm tra kết nối
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Lấy ID lớp học từ URL
                $id_lop = $_GET['lop_id'] ?? null;

                if (!$id_lop) {
                    die("<div class='alert alert-danger'>Không tìm thấy lớp học.</div>");
                }

                // Lấy thông tin lịch học
                $lichHocResult = $conn->query("
                    SELECT id_lichhoc, ngay_hoc, gio_bat_dau, gio_ket_thuc
                    FROM lichhoc
                    WHERE id_lop = '$id_lop'
                ");
                $lichHoc = $lichHocResult->fetch_all(MYSQLI_ASSOC);

                // Lấy danh sách học viên
                $hocVienResult = $conn->query("
                    SELECT hv.id_hocvien, hv.ten_hocvien
                    FROM hocvien hv
                    JOIN dangkykhoahoc dk ON hv.id_hocvien = dk.id_hocvien
                    WHERE dk.id_lop = '$id_lop'
                ");
                $hocVien = $hocVienResult->fetch_all(MYSQLI_ASSOC);

                // Lấy dữ liệu điểm danh hiện tại
                $diemDanhResult = $conn->query("
                    SELECT id_hocvien, id_lichhoc, trang_thai
                    FROM diem_danh
                    WHERE id_lop = '$id_lop'
                ");
                $diemDanhData = [];
                while ($row = $diemDanhResult->fetch_assoc()) {
                    $diemDanhData[$row['id_hocvien']][$row['id_lichhoc']] = $row['trang_thai'];
                }
                ?>
                <form action="modules/diemdanh/diemdanh_save.php" method="POST">
                    <input type="hidden" name="id_lop" value="<?= $id_lop ?>">
                    <div class="text-end ">
                        <button type="submit" class="btn btn-success">Lưu điểm danh</button>
                     
                    </div>
                    <div class="scrollable-table">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th >Học viên</th>
                                    <?php foreach ($lichHoc as $lich): ?>
                                        <th><?= $lich['ngay_hoc'] ?><br>(<?= $lich['gio_bat_dau'] ?> - <?= $lich['gio_ket_thuc'] ?>)</th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hocVien as $hv): ?>
                                    <tr>
                                        <td><?= $hv['ten_hocvien'] ?></td>
                                        <?php foreach ($lichHoc as $lich): ?>
                                            <?php
                                            $checked = isset($diemDanhData[$hv['id_hocvien']][$lich['id_lichhoc']]) &&
                                                       $diemDanhData[$hv['id_hocvien']][$lich['id_lichhoc']] === 'co mat';
                                            ?>
                                            <td>
                                                <input type="hidden" 
                                                       name="diemdanh[<?= $hv['id_hocvien'] ?>][lichhoc][<?= $lich['id_lichhoc'] ?>]" 
                                                       value="vang">
                                                <input type="checkbox" 
                                                       name="diemdanh[<?= $hv['id_hocvien'] ?>][lichhoc][<?= $lich['id_lichhoc'] ?>]" 
                                                       value="co mat" 
                                                       <?= $checked ? 'checked' : '' ?>>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
