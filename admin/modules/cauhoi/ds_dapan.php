<?php
include('../config/config.php');

// Lấy danh sách đáp án của câu hỏi
$id_cauhoi = intval($_GET['id_cauhoi']);
$sql = "SELECT * FROM dapan WHERE id_cauhoi = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id_cauhoi);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="container my-3">
    <h1 class="text-center title-color">Danh sách Đáp Án</h1>

    <!-- Nút thêm đáp án -->
    <a href="./admin.php?nav=add_answer&id_cauhoi=<?= $id_cauhoi ?>" class="btn btn-success mb-3">Thêm Đáp Án</a>

    <!-- Bảng danh sách đáp án -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nội Dung Đáp Án</th>
                <th>Đáp Án Đúng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_dapan']) ?></td>
                    <td><?= htmlspecialchars($row['noi_dung_dapan']) ?></td>
                    <td><?= htmlspecialchars($row['la_dung'] ? 'Đúng' : 'Sai') ?></td>
                    <td>
                        <a href="./modules/dapan/edit_answer.php?id_dapan=<?= $row['id_dapan'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="./modules/dapan/delete_answer.php?id_dapan=<?= $row['id_dapan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đáp án này?')">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
