<?php
// Kết nối CSDL đã được include từ admin.php
// include('../config/config.php');

// Xử lý các hành động (Xác nhận/Từ chối/Đã tư vấn)
if (isset($_GET['action'])) {
    if (isset($_GET['id_dangky'])) {
        $id_dangky = (int)$_GET['id_dangky'];
        $action = $_GET['action'];
        $new_status = '';

        if ($action === 'accept') $new_status = 'da xac nhan';
        if ($action === 'reject') $new_status = 'bi tu choi';

        if ($new_status) {
            $stmt = $conn->prepare("UPDATE dangkykhoahoc SET trang_thai = ? WHERE id_dangky = ?");
            $stmt->bind_param("si", $new_status, $id_dangky);
            $stmt->execute();
        }
    }
    if (isset($_GET['id_tuvan'])) {
        $id_tuvan = (int)$_GET['id_tuvan'];
        $stmt = $conn->prepare("UPDATE tuvan SET trang_thai = 'Đã tư vấn' WHERE id_tuvan = ?");
        $stmt->bind_param("i", $id_tuvan);
        $stmt->execute();
    }
    // Chuyển hướng để xóa các tham số action khỏi URL và tải lại trang
    header("Location: ./admin.php?nav=dangkykhoahoc&view=" . ($_GET['view'] ?? 'pending'));
    exit();
}

// Lấy view hiện tại từ URL, mặc định là 'pending' (Chờ xác nhận)
$view = $_GET['view'] ?? 'pending';

// Hàm để tạo badge trạng thái
function get_status_badge($status) {
    switch ($status) {
        case 'da xac nhan': return '<span class="badge bg-success">Đã xác nhận</span>';
        case 'cho xac nhan': return '<span class="badge bg-warning text-dark">Chờ xác nhận</span>';
        case 'da huy': return '<span class="badge bg-secondary">Đã hủy</span>';
        case 'bi tu choi': return '<span class="badge bg-danger">Bị từ chối</span>';
        default: return '<span class="badge bg-light text-dark">' . htmlspecialchars($status) . '</span>';
    }
}
?>

<div class="card animated-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fa-solid fa-circle-check me-2"></i>Quản lý Đăng ký</h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo ($view == 'pending') ? 'active' : ''; ?>" href="./admin.php?nav=dangkykhoahoc&view=pending">Chờ xác nhận</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo ($view == 'all') ? 'active' : ''; ?>" href="./admin.php?nav=dangkykhoahoc&view=all">Tất cả đăng ký</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo ($view == 'consult') ? 'active' : ''; ?>" href="./admin.php?nav=dangkykhoahoc&view=consult">Cần tư vấn</a>
            </li>
        </ul>

        <div class="tab-content pt-3">
            <div class="tab-pane fade show active">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <?php if ($view === 'consult'): ?>
                                <tr><th>Tên Học viên</th><th>Số Điện thoại</th><th>Email</th><th class="text-center">Trạng thái</th></tr>
                            <?php else: ?>
                                <tr><th>Học viên</th><th>Tên Khóa học</th><th class="text-center">Ngày Đăng ký</th><th class="text-center">Trạng thái</th><th class="text-center">Hành động</th></tr>
                            <?php endif; ?>
                        </thead>
                        <tbody>
                            <?php
                            $index = 0;
                            if ($view === 'consult') {
                                $sql = "SELECT id_tuvan, ten_hocvien, so_dien_thoai, email, trang_thai FROM tuvan ORDER BY id_tuvan DESC";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='animated-row' style='animation-delay: " . ($index++ * 50) . "ms;'>";
                                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["so_dien_thoai"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                    echo "<td class='text-center'>";
                                    if ($row['trang_thai'] !== 'Đã tư vấn') {
                                        echo "<a href='./admin.php?nav=dangkykhoahoc&view=consult&id_tuvan=" . $row["id_tuvan"] . "&action=consulted' class='btn btn-sm btn-info'>Xác nhận đã tư vấn</a>";
                                    } else {
                                        echo "<span class='badge bg-success'>Đã tư vấn</span>";
                                    }
                                    echo "</td></tr>";
                                }
                            } else {
                                $sql = "SELECT dk.id_dangky, hv.ten_hocvien, kh.ten_khoahoc, dk.ngay_dangky, dk.trang_thai 
                                        FROM dangkykhoahoc dk
                                        JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                                        JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc";
                                if ($view === 'pending') {
                                    $sql .= " WHERE dk.trang_thai = 'cho xac nhan'";
                                }
                                $sql .= " ORDER BY dk.id_dangky DESC";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='animated-row' style='animation-delay: " . ($index++ * 50) . "ms;'>";
                                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["ten_khoahoc"]) . "</td>";
                                    echo "<td class='text-center'>" . date("d/m/Y", strtotime($row["ngay_dangky"])) . "</td>";
                                    echo "<td class='text-center'>" . get_status_badge($row["trang_thai"]) . "</td>";
                                    echo "<td class='text-center'>";
                                    if ($row['trang_thai'] === 'cho xac nhan') {
                                        echo "<a href='./admin.php?nav=dangkykhoahoc&view=pending&id_dangky=" . $row["id_dangky"] . "&action=accept' class='btn btn-success btn-sm me-1' title='Xác nhận'><i class='fa-solid fa-check'></i></a>";
                                        echo "<a href='./admin.php?nav=dangkykhoahoc&view=pending&id_dangky=" . $row["id_dangky"] . "&action=reject' class='btn btn-warning btn-sm' title='Từ chối'><i class='fa-solid fa-times'></i></a>";
                                    } else {
                                        echo "<form method='POST' action='modules/delete_dangky.php' class='d-inline' onsubmit=\"return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đăng ký này?');\">
                                                <input type='hidden' name='id_dangky' value='" . $row["id_dangky"] . "'>
                                                <button type='submit' class='btn btn-danger btn-sm' title='Xóa'><i class='fa-solid fa-trash'></i></button>
                                              </form>";
                                    }
                                    echo "</td></tr>";
                                }
                            }
                            if ($result->num_rows == 0) {
                                echo "<tr><td colspan='5' class='text-center text-muted py-4'>Không có dữ liệu.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>