<?php
// PHP logic để lấy dữ liệu (giữ nguyên)
$search_term = $_GET['search'] ?? '';
$sql_search = "";
$params = [];
$types = "";

if (!empty($search_term)) {
    $search_param = "%" . $conn->real_escape_string($search_term) . "%";
    $sql_search = " WHERE hv.ten_hocvien LIKE ? OR hv.email LIKE ? OR kh.ten_khoahoc LIKE ?";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

$sql_payments = "
    SELECT lt.id_thanhtoan, lt.ngay_thanhtoan, lt.so_tien, lt.hinh_thuc, lt.trang_thai, 
           kh.ten_khoahoc, hv.ten_hocvien, hv.email
    FROM lichsu_thanhtoan lt
    JOIN khoahoc kh ON lt.id_khoahoc = kh.id_khoahoc
    JOIN hocvien hv ON lt.id_hocvien = hv.id_hocvien
    $sql_search
    ORDER BY lt.ngay_thanhtoan DESC
";

$stmt = $conn->prepare($sql_payments);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result_payments = $stmt->get_result();
?>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-money-check-dollar me-2"></i>Lịch sử thanh toán</h4>
            <div class="d-flex">
                <form method="GET" action="./admin.php" class="d-flex me-2">
                    <input type="hidden" name="nav" value="thanhtoan">
                    <input type="text" name="search" class="form-control" placeholder="Tìm theo tên HV, email, khóa học..." value="<?php echo htmlspecialchars($search_term); ?>" style="min-width: 300px;">
                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <a href="modules/lichsuthanhtoan/export_payments.php" class="btn btn-info text-white"><i class="fa-solid fa-file-excel"></i> Xuất Excel</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3 text-end">
            <button class="btn btn-danger" id="delete-selected-btn" disabled>
                <i class="fa-solid fa-trash-can"></i> Xóa mục đã chọn
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="payments-table">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 5%;"><input class="form-check-input" type="checkbox" id="select-all-checkbox"></th>
                        <th>ID</th>
                        <th>Học viên</th>
                        <th>Khóa học</th>
                        <th class="text-center">Số tiền (VNĐ)</th>
                        <th class="text-center">Hình thức</th>
                        <th class="text-center">Ngày thanh toán</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    if ($result_payments->num_rows > 0):
                        while ($row = $result_payments->fetch_assoc()):
                    ?>
                            <tr class="animated-row" style="animation-delay: <?php echo $index * 50; ?>ms;">
                                <td class="text-center"><input class="form-check-input row-checkbox" type="checkbox" value="<?php echo $row['id_thanhtoan']; ?>"></td>
                                <td><?php echo $row['id_thanhtoan']; ?></td>
                                <td>
                                    <strong class="d-block"><?php echo htmlspecialchars($row['ten_hocvien']); ?></strong>
                                    <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($row['ten_khoahoc']); ?></td>
                                <td class="text-center fw-bold text-success"><?php echo number_format($row['so_tien'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($row['hinh_thuc']); ?></td>
                                <td class="text-center"><?php echo date("d/m/Y H:i", strtotime($row['ngay_thanhtoan'])); ?></td>
                                <td class="text-center d-flex justify-content-around">
                                    <a href="./modules/lichsuthanhtoan/view_receipt.php?id=<?php echo $row['id_thanhtoan']; ?>" target="_blank" class="btn btn-info btn-sm text-white" title="Xem biên lai">
                                        <i class="fa-solid fa-receipt"></i>
                                    </a>

                                    <button class="btn btn-danger btn-sm" onclick="deleteSinglePayment(<?php echo $row['id_thanhtoan']; ?>)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php
                            $index++;
                        endwhile;
                    else:
                        ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Không tìm thấy giao dịch nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Hàm xóa một giao dịch
    function deleteSinglePayment(paymentId) {
        handleDelete([paymentId]); // Gọi hàm xử lý xóa chung với một mảng chứa 1 ID
    }

    // Hàm xử lý logic xóa (dùng cho cả xóa đơn và xóa nhiều)
    function handleDelete(ids) {
        if (ids.length === 0) return;

        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: `Bạn sẽ xóa vĩnh viễn ${ids.length} mục đã chọn. Hành động này không thể khôi phục!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Chắc chắn xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./modules/lichsuthanhtoan/delete_thanhtoan.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            delete_ids: ids
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Đã xóa!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                    });
            }
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const deleteSelectedBtn = document.getElementById('delete-selected-btn');

        function updateDeleteButtonState() {
            const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            deleteSelectedBtn.disabled = !anyChecked;
        }

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
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

        deleteSelectedBtn.addEventListener('click', function() {
            const selectedIds = Array.from(rowCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => parseInt(cb.value));
            handleDelete(selectedIds);
        });

        // Cập nhật trạng thái nút lần đầu khi tải trang
        updateDeleteButtonState();
    });
</script>