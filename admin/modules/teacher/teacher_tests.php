<?php
// File: admin/modules/cauhoi/question.php (Giao diện Hoàn thiện)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra quyền giảng viên
if (!isset($_SESSION['id_giangvien'])) {
    header('Location: ../../index.php');
    exit();
}

$id_giangvien = $_SESSION['id_giangvien'];

// --- XỬ LÝ TÌM KIẾM ---
$search_term = $_GET['search'] ?? '';
$sql_search = "";
$params = [$id_giangvien]; // Luôn có id_giangvien ở đầu
$types = "i";

// Thêm điều kiện tìm kiếm
if (!empty($search_term)) {
    $sql_search = " AND (bt.ten_baitest LIKE ? OR kh.ten_khoahoc LIKE ? OR lh.ten_lop LIKE ?)";
    $search_param = "%" . $search_term . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

// --- Pagination settings ---
$tests_per_page = 10;
$current_page = isset($_GET['test_page']) ? max(1, intval($_GET['test_page'])) : 1;
$offset = ($current_page - 1) * $tests_per_page;

// --- Count total tests ---
$sql_count = "
    SELECT COUNT(*) as total
    FROM baitest bt 
    LEFT JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
    LEFT JOIN lop_hoc lh ON bt.id_lop = lh.id_lop
    WHERE bt.id_lop IN (SELECT id_lop FROM lop_hoc WHERE id_giangvien = ?)
    $sql_search
";

$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param($types, ...$params);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_tests = $count_result->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_tests / $tests_per_page);

// Lấy danh sách bài test và thông tin liên quan với pagination
$sql = "
    SELECT 
        bt.id_baitest, bt.ten_baitest, bt.ngay_tao, bt.loai_baitest, bt.thoi_gian,
        kh.ten_khoahoc, 
        lh.ten_lop,
        (SELECT COUNT(*) FROM cauhoi WHERE id_baitest = bt.id_baitest) as question_count
    FROM baitest bt 
    LEFT JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
    LEFT JOIN lop_hoc lh ON bt.id_lop = lh.id_lop
    WHERE bt.id_lop IN (SELECT id_lop FROM lop_hoc WHERE id_giangvien = ?)
    $sql_search
    ORDER BY bt.id_baitest DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);
$params[] = $tests_per_page;
$params[] = $offset;
$types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Lấy danh sách khóa học mà giảng viên đang dạy
$courses = $conn->query("
    SELECT DISTINCT kh.id_khoahoc, kh.ten_khoahoc 
    FROM khoahoc kh
    INNER JOIN lop_hoc lh ON kh.id_khoahoc = lh.id_khoahoc
    WHERE lh.id_giangvien = {$id_giangvien}
    ORDER BY kh.ten_khoahoc
");

$courses_for_edit_modal = $conn->query("
    SELECT DISTINCT kh.id_khoahoc, kh.ten_khoahoc 
    FROM khoahoc kh
    INNER JOIN lop_hoc lh ON kh.id_khoahoc = lh.id_khoahoc
    WHERE lh.id_giangvien = {$id_giangvien}
    ORDER BY kh.ten_khoahoc
");

function get_test_type_badge($type)
{
    switch ($type) {
        case 'dau_vao':
            return '<span class="badge bg-primary">Test đầu vào</span>';
        case 'dinh_ky':
            return '<span class="badge bg-info text-dark">Test định kỳ</span>';
        case 'on_tap':
            return '<span class="badge bg-secondary">Test ôn tập</span>';
        default:
            return '<span class="badge bg-light text-dark">' . htmlspecialchars($type) . '</span>';
    }
}
?>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .test-list-container {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow: hidden;
        /* Quan trọng để bo góc hoạt động */
    }

    .table-header-custom {
        background-color: #e7f7ec;
        /* Màu nền xanh lá rất nhạt cho tiêu đề */
        color: #0a8a2c;
        /* Màu chữ xanh lá đậm */
        font-weight: 600;
        border-bottom: 2px solid var(--brand-color);
    }

    .table-header-custom th {
        padding: 1rem 1.5rem;
        white-space: nowrap;
        /* Ngăn tiêu đề xuống dòng */
    }

    /* Chiều rộng cột cố định trên desktop */
    .test-table {
        table-layout: fixed;
        /* Bắt buộc các cột tuân theo chiều rộng đã định */
        width: 100%;
    }

    .test-table .name-col {
        width: 25%;
    }

    .test-table .scope-col {
        width: 15%;
    }

    .test-table .type-col {
        width: 10%;
    }

    .test-table .q-col {
        width: 10%;
    }

    .test-table .time-col {
        width: 10%;
    }

    .test-table .actions-col {
        width: 10%;
        min-width: 180px;
    }


    .test-table tbody tr {
        transition: background-color 0.2s ease-in-out;
    }

    /* Màu sắc xen kẽ cho các dòng */
    .test-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .test-table tbody tr:hover {
        background-color: #e9ecef;
        /* Màu đậm hơn khi hover */
    }

    .test-table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        word-break: break-word;
        /* Chống vỡ layout nếu tên quá dài */
    }

    .test-name {
        font-weight: 600;
        color: var(--dark-text);
        display: block;
    }

    .test-scope {
        font-size: 0.85rem;
        color: var(--gray-text);
    }

    .actions-cell .btn {
        margin: 0 2px;
    }

    /* --- CSS Responsive Table -> Card --- */
    @media (max-width: 1200px) {

        /* Áp dụng sớm hơn để có trải nghiệm tốt hơn */
        .test-list-container {
            background-color: transparent;
            box-shadow: none;
        }

        .table-responsive {
            display: none;
            /* Ẩn bảng trên mobile */
        }

        .mobile-card-list {
            display: block !important;
            /* Hiện danh sách card trên mobile */
        }

        .test-card-mobile {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .test-card-mobile:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-mobile-header {
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .card-mobile-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .card-mobile-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .card-mobile-row .label {
            color: var(--gray-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-mobile-row .value {
            font-weight: 500;
            text-align: right;
        }

        .card-mobile-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }
    }

    /* Teacher Test Pagination Styles */
    .teacher-test-pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        padding: 20px 0;
    }

    .teacher-test-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
        padding: 6px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
    }

    .teacher-test-pagination-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border: none;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .teacher-test-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        color: #0a8a2c;
    }

    .teacher-test-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .teacher-test-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 0 8px;
    }

    .teacher-test-pagination-number {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .teacher-test-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border-color: rgba(255,255,255,0.8);
        transform: translateY(-1px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .teacher-test-pagination-number.active {
        background: #fff;
        color: #0a8a2c;
        border-color: #fff;
        transform: scale(1.08);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .teacher-test-pagination-dots {
        color: rgba(255,255,255,0.6);
        font-weight: bold;
        padding: 0 3px;
        font-size: 12px;
    }

    .teacher-test-pagination-info {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: var(--brand-color-light, #e7f7ec);
        border-radius: 20px;
        color: #0db33b;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid rgba(13, 179, 59, 0.2);
    }

    .teacher-test-pagination-info i {
        font-size: 14px;
    }

    .teacher-test-pagination-info strong {
        color: #0a8a2c;
        font-size: 13px;
    }

    .teacher-test-pagination-info .separator {
        margin: 0 3px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .teacher-test-pagination {
            padding: 6px 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .teacher-test-pagination-btn {
            padding: 5px 8px;
            font-size: 12px;
        }

        .teacher-test-pagination-btn span {
            display: none;
        }

        .teacher-test-pagination-number {
            min-width: 30px;
            height: 30px;
            font-size: 12px;
        }

        .teacher-test-pagination-info {
            font-size: 12px;
            padding: 7px 15px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }
</style>
<div class="container-fluid">
    <div class="page-header animated-card">
        <h1 class="title-color mb-0" style="border:none; padding: 0;">Quản lý Bài Test</h1>
        <div class="d-flex align-items-center gap-2">
            <form method="GET" action="./admin.php" class="d-flex">
                <input type="hidden" name="nav" value="question">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài test..." value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTestModal">
                <i class="fa-solid fa-plus"></i> Thêm
            </button>
        </div>
    </div>

    <hr>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show animated-card">
            <?php echo htmlspecialchars($_SESSION['message']['text']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="test-list-container animated-card mt-4">
        <div class="table-responsive">
            <table class="table test-table table-hover align-middle mb-0 table-bordered ">
                <thead class="table-header-custom table-info">
                    <tr>
                        <th class="name-col">Tên Bài Test</th>
                        <th class="scope-col">Phạm vi</th>
                        <th class="text-center type-col">Loại</th>
                        <th class="text-center q-col">Câu hỏi</th>
                        <th class="text-center time-col">Thời gian</th>
                        <th class="text-center actions-col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0):
                        mysqli_data_seek($result, 0); // Reset con trỏ
                        while ($row = $result->fetch_assoc()):
                            $scope_text = 'Công khai';
                            if ($row['ten_lop']) {
                                $scope_text = 'Lớp: ' . htmlspecialchars($row['ten_lop']);
                            } elseif ($row['ten_khoahoc']) {
                                $scope_text = 'Khóa: ' . htmlspecialchars($row['ten_khoahoc']);
                            }
                    ?>
                            <tr>
                                <td>
                                    <span class="test-name"><?php echo htmlspecialchars($row['ten_baitest']); ?></span>
                                    <span class="test-scope fst-italic">Ngày tạo: <?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></span>
                                </td>
                                <td class="test-scope"><?php echo $scope_text; ?></td>
                                <td class="text-center"><?php echo get_test_type_badge($row['loai_baitest']); ?></td>
                                <td class="text-center fw-bold"><?php echo $row['question_count']; ?></td>
                                <td class="text-center fw-bold"><?php echo $row['thoi_gian']; ?>'</td>
                                <td class="text-center actions-cell">
                                    <a href="./admin.php?nav=ds_cauhoi_gv&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-outline-primary btn-sm" title="Câu hỏi"><i class="fa-solid fa-list-check"></i></a>
                                    <a href="./admin.php?nav=kqhocvien_gv&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-outline-info btn-sm" title="Kết quả"><i class="fa-solid fa-square-poll-vertical"></i></a>
                                    <button onclick="openEditModal(<?php echo $row['id_baitest']; ?>)" class="btn btn-outline-warning btn-sm" title="Sửa"><i class="fa-solid fa-pen"></i></button>
                                    <a href="./modules/cauhoi/delete_test.php?id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa bài test này và tất cả dữ liệu liên quan không?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                    <?php endwhile;
                    endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mobile-card-list d-none">
            <?php if ($result->num_rows > 0):
                mysqli_data_seek($result, 0);
                $index = 0;
                while ($row = $result->fetch_assoc()):
                    $scope_text = 'Công khai';
                    if ($row['ten_lop']) {
                        $scope_text = 'Lớp: ' . htmlspecialchars($row['ten_lop']);
                    } elseif ($row['ten_khoahoc']) {
                        $scope_text = 'Khóa: ' . htmlspecialchars($row['ten_khoahoc']);
                    }
            ?>
                    <div class="test-card-mobile" style="animation-delay: <?php echo $index++ * 70; ?>ms;">
                        <div class="card-mobile-header">
                            <div>
                                <h6 class="card-mobile-title"><?php echo htmlspecialchars($row['ten_baitest']); ?></h6>
                                <span class="test-scope"><?php echo $scope_text; ?></span>
                            </div>
                            <a href="./modules/cauhoi/delete_test.php?id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa bài test này?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                        </div>
                        <div class="card-mobile-body">
                            <div class="card-mobile-row"><span class="label"><i class="fa-solid fa-tags text-muted"></i> Loại Test</span> <span class="value"><?php echo get_test_type_badge($row['loai_baitest']); ?></span></div>
                            <div class="card-mobile-row"><span class="label"><i class="fa-solid fa-list-ol text-muted"></i> Số câu hỏi</span> <span class="value fw-bold"><?php echo $row['question_count']; ?></span></div>
                            <div class="card-mobile-row"><span class="label"><i class="fa-solid fa-clock text-muted"></i> Thời gian</span> <span class="value fw-bold"><?php echo $row['thoi_gian']; ?> phút</span></div>
                        </div>
                        <div class="card-mobile-footer">
                            <div class="btn-group w-100">
                                <a href="./admin.php?nav=ds_cauhoi_gv&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-list-check"></i> Câu hỏi</a>
                                <a href="./admin.php?nav=kqhocvien_gv&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-square-poll-vertical"></i> Kết quả</a>
                                <button onclick="openEditModal(<?php echo $row['id_baitest']; ?>)" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pen"></i> Sửa</button>
                            </div>
                        </div>
                    </div>
            <?php endwhile;
            endif; ?>
        </div>

        <?php if ($result->num_rows == 0): ?>
            <div class="text-center p-5">
                <i class="fa-solid fa-folder-open fa-3x mb-3 text-muted"></i>
                <p class="mb-0 text-muted">
                    <?php if (!empty($search_term)): ?>
                        Không tìm thấy bài test nào với từ khóa "<strong><?php echo htmlspecialchars($search_term); ?></strong>".
                    <?php else: ?>
                        Không tìm thấy bài test nào.
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if ($total_pages > 1): ?>
            <!-- Pagination -->
            <div class="teacher-test-pagination-container">
                <div class="teacher-test-pagination">
                    <!-- Previous Button -->
                    <?php
                    $prev_link = "?nav=question&test_page=" . max(1, $current_page - 1);
                    if (!empty($search_term)) $prev_link .= "&search=" . urlencode($search_term);
                    ?>
                    <a href="<?php echo $prev_link; ?>" 
                       class="teacher-test-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                        <i class="fas fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>

                    <!-- Page Numbers -->
                    <div class="teacher-test-pagination-numbers">
                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        if ($start_page > 1) {
                            $first_link = "?nav=question&test_page=1";
                            if (!empty($search_term)) $first_link .= "&search=" . urlencode($search_term);
                            echo '<a href="' . $first_link . '" class="teacher-test-pagination-number">1</a>';
                            if ($start_page > 2) {
                                echo '<span class="teacher-test-pagination-dots">...</span>';
                            }
                        }

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $page_link = "?nav=question&test_page={$i}";
                            if (!empty($search_term)) $page_link .= "&search=" . urlencode($search_term);
                            $active_class = ($i == $current_page) ? 'active' : '';
                            echo '<a href="' . $page_link . '" class="teacher-test-pagination-number ' . $active_class . '">' . $i . '</a>';
                        }

                        if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                                echo '<span class="teacher-test-pagination-dots">...</span>';
                            }
                            $last_link = "?nav=question&test_page={$total_pages}";
                            if (!empty($search_term)) $last_link .= "&search=" . urlencode($search_term);
                            echo '<a href="' . $last_link . '" class="teacher-test-pagination-number">' . $total_pages . '</a>';
                        }
                        ?>
                    </div>

                    <!-- Next Button -->
                    <?php
                    $next_link = "?nav=question&test_page=" . min($total_pages, $current_page + 1);
                    if (!empty($search_term)) $next_link .= "&search=" . urlencode($search_term);
                    ?>
                    <a href="<?php echo $next_link; ?>" 
                       class="teacher-test-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                        <span>Sau</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <!-- Pagination Info -->
                <div class="teacher-test-pagination-info">
                    <i class="fas fa-clipboard-check"></i>
                    <span>
                        Hiển thị 
                        <strong><?php echo min($offset + 1, $total_tests); ?></strong>
                        <span class="separator">-</span>
                        <strong><?php echo min($offset + $tests_per_page, $total_tests); ?></strong>
                        <span class="separator">/</span>
                        <strong><?php echo $total_tests; ?></strong>
                        bài test
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="addTestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Bài Test mới</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/cauhoi/add_test.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên Bài Test <span class="text-danger">*</span></label><input type="text" name="ten_baitest" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Loại bài test <span class="text-danger">*</span></label><select name="loai_baitest" class="form-select" required>
                            <option value="dau_vao">Kiểm tra đầu vào</option>
                            <option value="dinh_ky">Kiểm tra định kỳ</option>
                            <option value="on_tap" selected>Bài ôn tập</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label">Phạm vi áp dụng</label><select name="id_khoahoc" class="form-select" id="add_id_khoahoc">
                            <option value="">-- Công khai hoặc Chọn khóa học --</option><?php mysqli_data_seek($courses, 0);
                                                                                        while ($course = $courses->fetch_assoc()): ?><option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endwhile; ?>
                        </select></div>
                    <div class="mb-3" id="add_class_wrapper" style="display:none;"><label class="form-label">Gán cho Lớp học (Tùy chọn)</label><select name="id_lop" class="form-select" id="add_id_lop">
                            <option value="">-- Áp dụng cho toàn khóa học --</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label">Thời Gian (phút) <span class="text-danger">*</span></label><input type="number" name="thoi_gian" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Thêm</button></div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editTestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa Bài Test</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/cauhoi/edit_test.php" method="POST">
                <input type="hidden" name="id_baitest" id="edit_id_baitest">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Tên Bài Test <span class="text-danger">*</span></label><input type="text" name="ten_baitest" id="edit_ten_baitest" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Loại bài test <span class="text-danger">*</span></label><select name="loai_baitest" id="edit_loai_baitest" class="form-select" required>
                            <option value="dau_vao">Kiểm tra đầu vào</option>
                            <option value="dinh_ky">Kiểm tra định kỳ</option>
                            <option value="on_tap">Bài ôn tập</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label">Phạm vi áp dụng</label><select name="id_khoahoc" id="edit_id_khoahoc" class="form-select">
                            <option value="">-- Công khai --</option><?php mysqli_data_seek($courses_for_edit_modal, 0);
                                                                        while ($course = $courses_for_edit_modal->fetch_assoc()): ?><option value="<?php echo $course['id_khoahoc']; ?>"><?php echo htmlspecialchars($course['ten_khoahoc']); ?></option><?php endwhile; ?>
                        </select></div>
                    <div class="mb-3" id="edit_class_wrapper" style="display:none;"><label class="form-label">Gán cho Lớp học (Tùy chọn)</label><select name="id_lop" class="form-select" id="edit_id_lop">
                            <option value="">-- Toàn khóa học --</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label">Thời Gian (phút) <span class="text-danger">*</span></label><input type="number" name="thoi_gian" id="edit_thoi_gian" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button><button type="submit" class="btn btn-primary">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>
</div>
<script>
    async function loadClasses(courseId, classSelect, classWrapper, selectedLopId = null) {
        if (courseId) {
            classWrapper.style.display = 'block';
            classSelect.innerHTML = '<option>Đang tải...</option>';
            try {
                const response = await fetch(`./modules/cauhoi/get_classes_by_course.php?course_id=${courseId}`);
                const classes = await response.json();
                classSelect.innerHTML = '<option value="">-- Áp dụng cho toàn khóa học --</option>';
                classes.forEach(cls => {
                    const option = new Option(cls.ten_lop, cls.id_lop);
                    if (selectedLopId && cls.id_lop == selectedLopId) {
                        option.selected = true;
                    }
                    classSelect.add(option);
                });
            } catch (error) {
                classSelect.innerHTML = '<option value="">-- Lỗi tải lớp học --</option>';
                console.error('Fetch error:', error);
            }
        } else {
            classWrapper.style.display = 'none';
            classSelect.innerHTML = '<option value="">-- Áp dụng cho toàn khóa học --</option>';
        }
    }

    async function openEditModal(testId) {
        try {
            const response = await fetch(`./modules/cauhoi/get_test_info.php?id=${testId}`);
            const data = await response.json();
            if (data.error) {
                Swal.fire('Lỗi!', data.error, 'error');
                return;
            }

            document.getElementById('edit_id_baitest').value = data.id_baitest;
            document.getElementById('edit_ten_baitest').value = data.ten_baitest;
            document.getElementById('edit_loai_baitest').value = data.loai_baitest;
            document.getElementById('edit_id_khoahoc').value = data.id_khoahoc || "";
            document.getElementById('edit_thoi_gian').value = data.thoi_gian;

            const editCourseSelect = document.getElementById('edit_id_khoahoc');
            const editClassSelect = document.getElementById('edit_id_lop');
            const editClassWrapper = document.getElementById('edit_class_wrapper');
            await loadClasses(data.id_khoahoc, editClassSelect, editClassWrapper, data.id_lop);

            const editModal = new bootstrap.Modal(document.getElementById('editTestModal'));
            editModal.show();
        } catch (error) {
            Swal.fire('Lỗi!', 'Không thể lấy dữ liệu bài test.', 'error');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const addCourseSelect = document.getElementById('add_id_khoahoc');
        const addClassWrapper = document.getElementById('add_class_wrapper');
        const addClassSelect = document.getElementById('add_id_lop');
        addCourseSelect.addEventListener('change', () => loadClasses(addCourseSelect.value, addClassSelect, addClassWrapper));

        const editCourseSelect = document.getElementById('edit_id_khoahoc');
        const editClassWrapper = document.getElementById('edit_class_wrapper');
        const editClassSelect = document.getElementById('edit_id_lop');
        editCourseSelect.addEventListener('change', () => loadClasses(editCourseSelect.value, editClassSelect, editClassWrapper));

        // Smooth scroll for pagination
        document.querySelectorAll('.teacher-test-pagination-number, .teacher-test-pagination-btn').forEach(link => {
            link.addEventListener('click', function(e) {
                const container = document.querySelector('.teacher-test-container') || document.querySelector('.row.mt-3');
                if (container) {
                    setTimeout(() => {
                        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            });
        });
    });
</script>