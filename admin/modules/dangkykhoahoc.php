<?php
// Kết nối cơ sở dữ liệu (thay thế bằng thông tin kết nối thực tế)
include('../config/config.php');

if (isset($_GET['id_dangky']) && isset($_GET['action'])) {
    $idDangKy = intval($_GET['id_dangky']);
    $action = $_GET['action'];

    if ($action === 'accept') {
        // Xác nhận đăng ký
        $query = "UPDATE dangkykhoahoc SET trang_thai = 'da xac nhan' WHERE id_dangky = $idDangKy";
        $conn->query($query);
    } elseif ($action === 'reject') {
        // Từ chối đăng ký
        $query = "UPDATE dangkykhoahoc SET trang_thai = 'bi tu choi' WHERE id_dangky = $idDangKy";
        $conn->query($query);
    }
}
if (isset($_GET['id_tuvan']) && $_GET['action'] === 'accept') {
    $idTuvan = intval($_GET['id_tuvan']);
    $query = "UPDATE tuvan SET trang_thai = 'Đã tư vấn' WHERE id_tuvan = $idTuvan";
    $conn->query($query);
}

?>


<style>
    .container {
        max-width: 1000px;
        margin: 0 auto;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 9px;
        text-align: center;
    }

    th {
        background-color: #343a40;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .button {
        padding: 8px 16px;
        text-decoration: none;
        color: #fff;
        border-radius: 4px;
    }

    .button.accept {
        background-color: #28a745;
    }

    .button.reject {
        background-color: #dc3545;
    }

    .button:hover {
        opacity: 0.9;
    }
</style>

<div class="container">
    <h1 class="title-color">Quản lý Đăng ký Khóa học</h1>
    <a href="./admin.php?nav=dangkykhoahoc" class="btn btn-success mb-3">Cần xác nhận</a>

    <a href="./admin.php?nav=dangkykhoahoc&view=view" class="btn btn-success mb-3">Danh sách đăng ký</a>
    <a href="./admin.php?nav=dangkykhoahoc&view=tu_van" class="btn btn-success mb-3">Danh sách cần tư vấn</a>


    <?php if (isset($_GET['view']) && $_GET['view'] === 'view') : ?>
        <h3 class="">Danh sách Đăng ký Khóa học</h3>
        <table>
            <tr>
                <th>Học viên</th>
                <th style="width: 300px;">Tên Khóa học</th>
                <th>Ngày Đăng ký</th>
                <th>Trạng thái</th>
                <th >Hành động</th>
            </tr>
            <?php
            $sql = "SELECT dangkykhoahoc.id_dangky, hocvien.ten_hocvien, khoahoc.ten_khoahoc, dangkykhoahoc.ngay_dangky, dangkykhoahoc.trang_thai 
            FROM dangkykhoahoc 
            INNER JOIN hocvien ON dangkykhoahoc.id_hocvien = hocvien.id_hocvien
            INNER JOIN khoahoc ON dangkykhoahoc.id_khoahoc = khoahoc.id_khoahoc ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                    echo "<td >" . htmlspecialchars($row["ten_khoahoc"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ngay_dangky"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["trang_thai"]) . "</td>";
                    echo "<td>
                    <form method='POST' action='modules/delete_dangky.php' style='display:inline;'>
                        <input type='hidden' name='id_dangky' value='" . htmlspecialchars($row["id_dangky"]) . "'>
                        <button type='submit' class='btn btn-danger btn-sm px-3' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\");'><i class='fa-solid fa-trash'></i></button>
                    </form>
                  </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có đăng ký nào chờ xác nhận.</td></tr>";
            }
            ?>
        </table>
    <?php elseif (isset($_GET['view']) && $_GET['view'] === 'tu_van') : ?>
        <h3 class="">Danh sách Học viên Cần Tư vấn</h3>
        <table>
            <tr>
                <th>Tên Học viên</th>
                <th>Số Điện thoại</th>
                <th>Email</th>
                <th>Hành động</th>
            </tr>
            <?php
            $sql = "SELECT tuvan.id_tuvan, tuvan.ten_hocvien, tuvan.so_dien_thoai, tuvan.email, tuvan.trang_thai 
                FROM tuvan ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["so_dien_thoai"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>
                    <a href='./admin.php?nav=dangkykhoahoc&view=tu_van&id_tuvan=" . htmlspecialchars($row["id_tuvan"]) . "&action=accept' class='button accept'>" . htmlspecialchars($row["trang_thai"]) . "</a>
                </td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có học viên cần tư vấn.</td></tr>";
            }
            ?>
        </table>



    <?php else: ?>
        <h3 class="">Danh sách khóa học cần xác nhận</h3>
        <table>
            <tr>
                <th>Tên Học viên</th>
                <th style="width: 300px;">Tên Khóa học</th>
                <th>Ngày Đăng ký</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
            <?php
            $sql = "SELECT dangkykhoahoc.id_dangky, hocvien.ten_hocvien, khoahoc.ten_khoahoc, dangkykhoahoc.ngay_dangky, dangkykhoahoc.trang_thai 
                    FROM dangkykhoahoc 
                    INNER JOIN hocvien ON dangkykhoahoc.id_hocvien = hocvien.id_hocvien
                    INNER JOIN khoahoc ON dangkykhoahoc.id_khoahoc = khoahoc.id_khoahoc
                    WHERE dangkykhoahoc.trang_thai = 'cho xac nhan'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ten_khoahoc"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ngay_dangky"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["trang_thai"]) . "</td>";
                    echo "<td>
                            <a href='./admin.php?nav=dangkykhoahoc&id_dangky=" . $row["id_dangky"] . "&action=accept' class='button accept'>Xác nhận</a>
                            <a href='./admin.php?nav=dangkykhoahoc&id_dangky=" . $row["id_dangky"] . "&action=reject' class='button reject'>Từ chối</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có đăng ký nào chờ xác nhận.</td></tr>";
            }
            ?>
        </table>



    <?php endif; ?>

</div>