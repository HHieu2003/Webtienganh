<?php
// --- XỬ LÝ CÁC HÀNH ĐỘNG (ACCEPT/REJECT/CONSULTED) ---
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
        $action = $_GET['action'];
        if ($action === 'consulted') {
            $stmt = $conn->prepare("UPDATE tuvan SET trang_thai = 'Đã tư vấn' WHERE id_tuvan = ?");
            $stmt->bind_param("i", $id_tuvan);
            $stmt->execute();
        }
    }
    header("Location: ./admin.php?nav=dangkykhoahoc&view=" . ($_GET['view'] ?? 'pending'));
    exit();
}

// --- LẤY CÁC THAM SỐ TỪ URL ---
$view = $_GET['view'] ?? 'pending';
$search_term = $_GET['search'] ?? '';

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
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show" role="alert">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['message']);
        }
        ?>
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
                
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <form method="GET" action="./admin.php" class="d-flex me-2">
                        <input type="hidden" name="nav" value="dangkykhoahoc">
                        <input type="hidden" name="view" value="<?php echo htmlspecialchars($view); ?>">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search_term); ?>">
                        <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    <a href="modules/export_registrations.php?view=<?php echo htmlspecialchars($view); ?>&search=<?php echo htmlspecialchars($search_term); ?>" class="btn btn-info text-white">
                        <i class="fa-solid fa-file-excel"></i> Xuất Excel
                    </a>
                </div>
                
                <?php if ($view === 'consult'): ?>
                <form id="consult-form" action="modules/xacnhandangky/delete_consultation.php" method="POST">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger" id="delete-selected-btn" disabled>
                            <i class="fa-solid fa-trash"></i> Xóa mục đã chọn
                        </button>
                    </div>
                <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <?php if ($view === 'consult'): ?>
                                    <tr>
                                        <th style="width: 5%;"><input class="form-check-input" type="checkbox" id="select-all-checkbox"></th>
                                        <th>Tên Học viên</th><th>Số Điện thoại</th><th>Email</th><th class="text-center">Trạng thái</th><th class="text-center">Hành động</th>
                                    </tr>
                                <?php else: ?>
                                    <tr><th>Học viên</th><th>Tên Khóa học</th><th class="text-center">Ngày Đăng ký</th><th class="text-center">Trạng thái</th><th class="text-center">Hành động</th></tr>
                                <?php endif; ?>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                if ($view === 'consult') {
                                    $sql = "SELECT id_tuvan, ten_hocvien, so_dien_thoai, email, trang_thai FROM tuvan";
                                    if (!empty($search_term)) {
                                        $sql .= " WHERE ten_hocvien LIKE ? OR so_dien_thoai LIKE ? OR email LIKE ?";
                                        $stmt = $conn->prepare($sql);
                                        $search_param = "%" . $search_term . "%";
                                        $stmt->bind_param("sss", $search_param, $search_param, $search_param);
                                    } else {
                                        $sql .= " ORDER BY id_tuvan DESC";
                                        $stmt = $conn->prepare($sql);
                                    }
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr class='animated-row' style='animation-delay: " . ($index++ * 50) . "ms;'>";
                                        echo "<td><input class='form-check-input row-checkbox' type='checkbox' name='delete_ids[]' value='" . $row["id_tuvan"] . "'></td>";
                                        echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["so_dien_thoai"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                        echo "<td class='text-center'>";
                                        if ($row['trang_thai'] !== 'Đã tư vấn') {
                                            echo "<a href='./admin.php?nav=dangkykhoahoc&view=consult&id_tuvan=" . $row["id_tuvan"] . "&action=consulted' class='btn btn-sm btn-info'>Xác nhận đã tư vấn</a>";
                                        } else {
                                            echo "<span class='badge bg-success'>Đã tư vấn</span>";
                                        }
                                        echo "</td>";
                                        echo "<td class='text-center'><button type='button' class='btn btn-danger btn-sm delete-single-btn' data-id='" . $row["id_tuvan"] . "'><i class='fa-solid fa-trash'></i></button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    $sql = "SELECT dk.id_dangky, hv.ten_hocvien, kh.ten_khoahoc, dk.ngay_dangky, dk.trang_thai 
                                            FROM dangkykhoahoc dk
                                            JOIN hocvien hv ON dk.id_hocvien = hv.id_hocvien
                                            JOIN khoahoc kh ON dk.id_khoahoc = kh.id_khoahoc";
                                    $conditions = []; $params = []; $types = "";
                                    if ($view === 'pending') { $conditions[] = "dk.trang_thai = 'cho xac nhan'"; }
                                    if (!empty($search_term)) {
                                        $conditions[] = "(hv.ten_hocvien LIKE ? OR kh.ten_khoahoc LIKE ?)";
                                        $search_param = "%" . $search_term . "%";
                                        $params[] = $search_param; $params[] = $search_param; $types .= "ss";
                                    }
                                    if (count($conditions) > 0) { $sql .= " WHERE " . implode(' AND ', $conditions); }
                                    $sql .= " ORDER BY dk.id_dangky DESC";
                                    $stmt = $conn->prepare($sql);
                                    if (!empty($params)) { $stmt->bind_param($types, ...$params); }
                                    $stmt->execute();
                                    $result = $stmt->get_result();
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
                                            // Form xóa này giờ sẽ không bị lồng trong form khác nữa
                                            echo "<form method='POST' action='modules/xacnhandangky/delete_dangky.php' class='d-inline' onsubmit=\"return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đăng ký này?');\">
                                                    <input type='hidden' name='id_dangky' value='" . $row["id_dangky"] . "'>
                                                    <button type='submit' class='btn btn-danger btn-sm' title='Xóa'><i class='fa-solid fa-trash'></i></button>
                                                  </form>";
                                        }
                                        echo "</td></tr>";
                                    }
                                }

                                if ($result->num_rows == 0) {
                                    $colspan = ($view === 'consult') ? 6 : 5;
                                    echo "<tr><td colspan='$colspan' class='text-center text-muted py-4'>Không có dữ liệu phù hợp.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php if ($view === 'consult'): ?>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if ('<?php echo $view; ?>' === 'consult') {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const deleteSelectedBtn = document.getElementById('delete-selected-btn');
        const consultForm = document.getElementById('consult-form');
        const deleteSingleBtns = document.querySelectorAll('.delete-single-btn');

        function updateDeleteButtonState() {
            const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            deleteSelectedBtn.disabled = !anyChecked;
        }

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => { checkbox.checked = this.checked; });
            updateDeleteButtonState();
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
                updateDeleteButtonState();
            });
        });

        consultForm.addEventListener('submit', function(e) {
            const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            if (!anyChecked) {
                e.preventDefault();
                alert('Vui lòng chọn ít nhất một mục để xóa.');
                return;
            }
            if (!confirm('Bạn có chắc chắn muốn xóa các mục đã chọn?')) {
                e.preventDefault();
            }
        });
        
        deleteSingleBtns.forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
                    rowCheckboxes.forEach(cb => cb.checked = false);
                    const idToDelete = this.getAttribute('data-id');
                    const checkboxToDelete = document.querySelector(`.row-checkbox[value='${idToDelete}']`);
                    if (checkboxToDelete) {
                        checkboxToDelete.checked = true;
                    }
                    consultForm.submit();
                }
            });
        });
        updateDeleteButtonState();
    }
});
</script>