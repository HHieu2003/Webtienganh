<?php
// PHP logic để lấy dữ liệu và bộ lọc (giữ nguyên)
$view = $_GET['view'] ?? 'pending';
$search_term = $_GET['search'] ?? '';

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
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-circle-check me-2"></i>Quản lý Đăng ký & Tư vấn</h4>
            <div class="d-flex">
                 <form method="GET" action="./admin.php" class="d-flex me-2">
                    <input type="hidden" name="nav" value="dangkykhoahoc">
                    <input type="hidden" name="view" value="<?php echo htmlspecialchars($view); ?>">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <a href="modules/xacnhandangky/export_registrations.php?view=<?php echo htmlspecialchars($view); ?>&search=<?php echo htmlspecialchars($search_term); ?>" class="btn btn-info text-white">
                    <i class="fa-solid fa-file-excel"></i> Xuất Excel
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
            <li class="nav-item"><a class="nav-link <?php echo ($view == 'pending') ? 'active' : ''; ?>" href="./admin.php?nav=dangkykhoahoc&view=pending">Chờ xác nhận</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($view == 'all') ? 'active' : ''; ?>" href="./admin.php?nav=dangkykhoahoc&view=all">Tất cả đăng ký</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($view == 'consult') ? 'active' : ''; ?>" href="./admin.php?nav=dangkykhoahoc&view=consult">Cần tư vấn</a></li>
        </ul>

        <div class="tab-content pt-3">
            <div class="tab-pane fade show active">
                <?php if ($view === 'consult'): ?>
                    <div class="mb-3 text-end">
                        <button class="btn btn-danger" id="delete-selected-btn" disabled>
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
                                // PHP code to fetch consult data
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
                                    echo "<tr id='row-consult-{$row["id_tuvan"]}' class='animated-row' style='animation-delay: " . ($index++ * 50) . "ms;'>";
                                    echo "<td><input class='form-check-input row-checkbox' type='checkbox' value='" . $row["id_tuvan"] . "'></td>";
                                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["so_dien_thoai"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                    echo "<td class='text-center status-cell'>";
                                    if ($row['trang_thai'] !== 'Đã tư vấn') {
                                        echo "<button onclick='updateStatus({$row["id_tuvan"]}, \"consulted\")' class='btn btn-sm btn-info'>Xác nhận đã tư vấn</button>";
                                    } else {
                                        echo "<span class='badge bg-success'>Đã tư vấn</span>";
                                    }
                                    echo "</td>";
                                    echo "<td class='text-center'><button onclick='deleteConsult([{$row["id_tuvan"]}])' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i></button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                // PHP code to fetch registration data
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
                                    echo "<tr id='row-reg-{$row["id_dangky"]}' class='animated-row' style='animation-delay: " . ($index++ * 50) . "ms;'>";
                                    echo "<td>" . htmlspecialchars($row["ten_hocvien"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["ten_khoahoc"]) . "</td>";
                                    echo "<td class='text-center'>" . date("d/m/Y", strtotime($row["ngay_dangky"])) . "</td>";
                                    echo "<td class='text-center status-cell'>" . get_status_badge($row["trang_thai"]) . "</td>";
                                    echo "<td class='text-center actions-cell'>";
                                    if ($row['trang_thai'] === 'cho xac nhan') {
                                        echo "<button onclick='updateStatus({$row["id_dangky"]}, \"accept\")' class='btn btn-success btn-sm me-1' title='Xác nhận'><i class='fa-solid fa-check'></i></button>";
                                        echo "<button onclick='updateStatus({$row["id_dangky"]}, \"reject\")' class='btn btn-warning btn-sm' title='Từ chối'><i class='fa-solid fa-times'></i></button>";
                                    } else {
                                        echo "<button onclick='deleteRegistration({$row["id_dangky"]})' class='btn btn-danger btn-sm' title='Xóa'><i class='fa-solid fa-trash'></i></button>";
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
            </div>
        </div>
    </div>
</div>

<script>
function handleResponse(response, successCallback) {
    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: response.message,
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            if (successCallback) successCallback();
        });
    } else {
        Swal.fire('Lỗi!', response.message, 'error');
    }
}

// Hàm cập nhật trạng thái chung
function updateStatus(id, action) {
    fetch('./modules/xacnhandangky/update_status.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id, action })
    })
    .then(res => res.json())
    .then(data => {
        handleResponse(data, () => {
            let row, statusCell, actionsCell;
            if (action === 'consulted') {
                row = document.getElementById(`row-consult-${id}`);
                if(row) {
                    statusCell = row.querySelector('.status-cell');
                    if(statusCell) statusCell.innerHTML = `<span class="badge bg-success">Đã tư vấn</span>`;
                }
            } else {
                row = document.getElementById(`row-reg-${id}`);
                if(row) {
                    statusCell = row.querySelector('.status-cell');
                    actionsCell = row.querySelector('.actions-cell');
                    if (statusCell) {
                         statusCell.innerHTML = action === 'accept' 
                            ? '<span class="badge bg-success">Đã xác nhận</span>'
                            : '<span class="badge bg-danger">Bị từ chối</span>';
                    }
                    if (actionsCell) {
                         actionsCell.innerHTML = `<button onclick='deleteRegistration(${id})' class='btn btn-danger btn-sm' title='Xóa'><i class='fa-solid fa-trash'></i></button>`;
                    }
                }
            }
        });
    });
}

// Hàm xóa đăng ký
function deleteRegistration(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?', text: "Bạn sẽ xóa vĩnh viễn đăng ký này!", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
        confirmButtonText: 'Vâng, xóa nó!', cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/xacnhandangky/delete_dangky.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id_dangky: id })
            })
            .then(res => res.json())
            .then(data => handleResponse(data, () => document.getElementById(`row-reg-${id}`).remove()));
        }
    });
}

// Hàm xóa yêu cầu tư vấn
function deleteConsult(ids) {
    Swal.fire({
        title: 'Bạn có chắc chắn?', text: `Bạn sẽ xóa vĩnh viễn ${ids.length} mục đã chọn!`, icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
        confirmButtonText: 'Vâng, xóa nó!', cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('./modules/xacnhandangky/delete_consultation.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ delete_ids: ids })
            })
            .then(res => res.json())
            .then(data => handleResponse(data, () => ids.forEach(id => document.getElementById(`row-consult-${id}`).remove())));
        }
    });
}


// Logic cho checkbox (giữ nguyên)
document.addEventListener('DOMContentLoaded', function() {
    if ('<?php echo $view; ?>' === 'consult') {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const deleteSelectedBtn = document.getElementById('delete-selected-btn');

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
                selectAllCheckbox.checked = Array.from(rowCheckboxes).every(cb => cb.checked);
                updateDeleteButtonState();
            });
        });

        deleteSelectedBtn.addEventListener('click', function() {
            const selectedIds = Array.from(rowCheckboxes)
                                    .filter(cb => cb.checked)
                                    .map(cb => parseInt(cb.value));
            deleteConsult(selectedIds);
        });
        
        updateDeleteButtonState();
    }
});
</script>