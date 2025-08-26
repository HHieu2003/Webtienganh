<?php
include('../config/config.php');
?>

<div class="container my-3">
    <h1 class="text-center title-color">Quản lý Lớp Học</h1>

    <?php if (isset($_GET['lop_id']) && isset($_GET['view'])): ?>
        <!-- Hiển thị chi tiết của lớp học -->
        <?php
        $lop_id = mysqli_real_escape_string($conn, $_GET['lop_id']);
        $view = $_GET['view'];

        // Lấy thông tin chi tiết lớp học
        $sql_lop = "SELECT lh.id_lop, lh.ten_lop, lh.giang_vien, kh.ten_khoahoc 
                    FROM lop_hoc lh
                    JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc
                    WHERE lh.id_lop = ?";
        $stmt = mysqli_prepare($conn, $sql_lop);
        mysqli_stmt_bind_param($stmt, 's', $lop_id);
        mysqli_stmt_execute($stmt);
        $lop = mysqli_stmt_get_result($stmt)->fetch_assoc();

        if (!$lop) {
            die("Lớp học không tồn tại.");
        }
        ?>
        <h3>Chi tiết Lớp Học: <?= htmlspecialchars($lop['ten_lop']) ?> (Khóa học: <?= htmlspecialchars($lop['ten_khoahoc']) ?>)</h3>

        <div class="mb-3">
            <a href="./admin.php?nav=lichhoc&lop_id=<?= $lop_id ?>&view=students" class="btn btn-secondary">Học viên</a>
            <a href="./admin.php?nav=lichhoc&lop_id=<?= $lop_id ?>&view=schedule" class="btn btn-secondary">Lịch học</a>
            <a href="./admin.php?nav=lichhoc&lop_id=<?= $lop_id ?>&view=diemdanh" class="btn btn-secondary">Điểm danh</a>

            
        </div>

        <?php
        // Hiển thị danh sách học viên hoặc lịch học của lớp
        if ($view === 'students') {
            include('./modules/lichhoc/view_students.php');
        } elseif ($view === 'schedule') {
            include('./modules/lichhoc/view_schedule.php');
        }
        elseif ($view === 'diemdanh') {
            include('./modules/diemdanh/diemdanh.php');
        }
        ?>
    <?php else : ?>
        <!-- Hiển thị danh sách lớp học -->
        <?php
        // Lấy danh sách lớp học và khóa học
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

        $sql = "SELECT lh.id_lop, lh.ten_lop, lh.giang_vien, lh.trang_thai, kh.ten_khoahoc 
                FROM lop_hoc lh
                JOIN khoahoc kh ON lh.id_khoahoc = kh.id_khoahoc";

        // Nếu có từ khóa tìm kiếm, thêm điều kiện vào câu truy vấn
        if (!empty($search)) {
            $sql .= " WHERE lh.ten_lop LIKE '%$search%' OR kh.ten_khoahoc LIKE '%$search%' OR lh.giang_vien LIKE '%$search%'";
        }

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($conn));
        }
        ?>
        <h3>Danh sách Lớp Học</h3>
        <div class="text-end mb-1">

            <!-- Nút thêm lớp học -->

            <button class="btn btn-success my-1" id="btn-add-class">Thêm lớp học</button>

            <form method="GET" action="./admin.php?nav=lichhoc" class="d-inline-block float-start">
                <input type="hidden" name="nav" value="lichhoc">
                <input type="text" name="search" class="form-control d-inline-block w-auto" placeholder="Tìm kiếm lớp học..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>


        <!-- Form thêm lớp học -->
        <div id="form-add-class" style="display: none;">
            <h3>Thêm Lớp Học</h3>
            <form method="POST" action="modules/lichhoc/add_lop.php">
                <div class="mb-3">
                    <label for="ten_lop">ID lớp</label>
                    <input type="text" id="id_lop" name="id_lop" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="ten_lop">Tên Lớp</label>
                    <input type="text" id="ten_lop" name="ten_lop" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="giang_vien">Giảng viên</label>
                    <input type="text" id="giang_vien" name="giang_vien" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="id_khoahoc">Khóa Học</label>
                    <select id="id_khoahoc" name="id_khoahoc" class="form-control" required>
                        <?php
                        $sql_khoahoc = "SELECT id_khoahoc, ten_khoahoc FROM khoahoc";
                        $result_khoahoc = mysqli_query($conn, $sql_khoahoc);
                        while ($row = mysqli_fetch_assoc($result_khoahoc)) {
                            echo "<option value='{$row['id_khoahoc']}'>" . htmlspecialchars($row['ten_khoahoc']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="trang_thai">Trạng Thái</label>
                    <select id="trang_thai" name="trang_thai" class="form-control" required>
                        <option value="dang hoc">Đang học</option>
                        <option value="da xong">Đã xong</option>
                    </select>
                </div>
                <button type="submit" name="add_class" class="my-2 btn btn-primary">Thêm Lớp</button>
            </form>
        </div>



        <!-- hiển thị danh sách lớp học -->
        <?php if (!empty($search)): ?>
            <p class="text-muted">
                Kết quả tìm kiếm cho từ khóa "<strong><?= htmlspecialchars($search) ?></strong>":
                <?= mysqli_num_rows($result) ?> lớp học được tìm thấy.
            </p>
        <?php endif; ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Lớp</th>
                    <th>Tên Lớp</th>
                    <th style="    width: 220px;">Tên Khóa Học</th>
                    <th>Giảng Viên</th>
                    <th>Trạng Thái</th>
                    <th style="width: 300px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_lop']) ?></td>
                        <td><?= htmlspecialchars($row['ten_lop']) ?></td>
                        <td><?= htmlspecialchars($row['ten_khoahoc']) ?></td>
                        <td><?= htmlspecialchars($row['giang_vien']) ?></td>
                        <td id="trang-thai-<?= htmlspecialchars($row['id_lop']) ?>">
                            <?= htmlspecialchars($row['trang_thai'] === 'dang hoc' ? 'Đang học' : 'Đã xong') ?>
                            <button class="btn btn-sm btn-warning ms-2" onclick="editStatus('<?= htmlspecialchars($row['id_lop']) ?>', '<?= $row['trang_thai'] ?>')">Sửa</button>
                        </td>


                        <td>
                            <a href="./admin.php?nav=lichhoc&lop_id=<?= $row['id_lop'] ?>&view=schedule"
                                class="btn btn-primary btn-sm">Xem lịch </a>
                            <a href="./admin.php?nav=lichhoc&lop_id=<?= $row['id_lop'] ?>&view=students"
                                class="btn btn-secondary btn-sm">Học viên</a>
                                <a href="./admin.php?nav=lichhoc&lop_id=<?= $row['id_lop'] ?>&view=diemdanh"
                                class="btn btn-secondary btn-sm">Điểm danh</a>
                            <a href="modules/lichhoc/delete_lop.php?delete_lop_id=<?= $row['id_lop'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa lớp học này?');"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    <?php endif; ?>
</div>

<script>
    document.getElementById('btn-add-class').addEventListener('click', function() {
        const form = document.getElementById('form-add-class');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
<script>
    function editStatus(lopId, currentStatus) {
        const newStatus = currentStatus === 'dang hoc' ? 'da xong' : 'dang hoc'; // Tự chuyển đổi trạng thái
        const confirmText = `Bạn có muốn chuyển trạng thái sang "${newStatus === 'dang hoc' ? 'Đang học' : 'Đã xong'}"?`;

        if (confirm(confirmText)) {
            // Gửi yêu cầu AJAX để cập nhật trạng thái
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "./modules/lichhoc/update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(`id_lop=${lopId}&trang_thai=${newStatus}`);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText.trim() === "success") {
                        // Cập nhật trạng thái mới trên giao diện
                        const statusCell = document.getElementById(`trang-thai-${lopId}`);
                        statusCell.innerHTML = `
                        ${newStatus === 'dang hoc' ? 'Đang học' : 'Đã xong'}
                        <button class="btn btn-sm btn-warning ms-2" onclick="editStatus('${lopId}', '${newStatus}')">Sửa</button>
                    `;
                    } else {
                        alert("Cập nhật trạng thái thất bại: " + xhr.responseText);
                    }
                } else {
                    alert("Lỗi kết nối đến máy chủ!");
                }
            };
        }

        console.log("Đang gửi ID lớp:", lopId, "| Trạng thái mới:", newStatus);
    }
</script>