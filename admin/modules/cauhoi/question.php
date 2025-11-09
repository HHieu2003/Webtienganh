<?php
// File: admin/modules/cauhoi/question.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra quyền: Admin hoặc Giảng viên
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$is_teacher = isset($_SESSION['id_giangvien']);
$id_giangvien = $_SESSION['id_giangvien'] ?? null;

// --- Search and Filter parameters ---
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$test_type_filter = isset($_GET['test_type']) ? trim($_GET['test_type']) : '';
$course_filter = isset($_GET['course_id']) && !empty($_GET['course_id']) ? intval($_GET['course_id']) : '';

// --- Pagination settings ---
$tests_per_page = 15;
$current_page = isset($_GET['test_page']) ? max(1, intval($_GET['test_page'])) : 1;
$offset = ($current_page - 1) * $tests_per_page;

// --- Build WHERE conditions for search/filter ---
$where_conditions = [];
$params = [];
$types = "";

if (!empty($search_query)) {
    $where_conditions[] = "bt.ten_baitest LIKE ?";
    $params[] = "%{$search_query}%";
    $types .= "s";
}

if (!empty($test_type_filter)) {
    $where_conditions[] = "bt.loai_baitest = ?";
    $params[] = $test_type_filter;
    $types .= "s";
}

if (!empty($course_filter) && $course_filter !== '') {
    $where_conditions[] = "bt.id_khoahoc = ?";
    $params[] = intval($course_filter);
    $types .= "i";
}

// Nếu là giảng viên (không phải admin), CHỈ hiển thị bài test thuộc lớp mà giảng viên dạy
if ($is_teacher && !$is_admin) {
    $where_conditions[] = "bt.id_lop IN (SELECT id_lop FROM lop_hoc WHERE id_giangvien = ?)";
    $params[] = $id_giangvien;
    $types .= "i";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// --- Count total tests ---
$sql_count = "SELECT COUNT(*) as total FROM baitest bt $where_clause";
if (!empty($params)) {
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param($types, ...$params);
    $stmt_count->execute();
    $count_result = $stmt_count->get_result();
    $total_tests = $count_result->fetch_assoc()['total'];
    $stmt_count->close();
} else {
    $count_result = $conn->query($sql_count);
    $total_tests = $count_result->fetch_assoc()['total'];
}

$total_pages = ceil($total_tests / $tests_per_page);

// Lấy danh sách bài test và thông tin liên quan với pagination
$sql = "SELECT bt.id_baitest, bt.ten_baitest, bt.ngay_tao, bt.loai_baitest, kh.ten_khoahoc, lh.ten_lop
        FROM baitest bt 
        LEFT JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
        LEFT JOIN lop_hoc lh ON bt.id_lop = lh.id_lop
        $where_clause
        ORDER BY bt.id_baitest DESC
        LIMIT ? OFFSET ?";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $params[] = $tests_per_page;
    $params[] = $offset;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql_with_limit = "SELECT bt.id_baitest, bt.ten_baitest, bt.ngay_tao, bt.loai_baitest, kh.ten_khoahoc, lh.ten_lop
            FROM baitest bt 
            LEFT JOIN khoahoc kh ON bt.id_khoahoc = kh.id_khoahoc
            LEFT JOIN lop_hoc lh ON bt.id_lop = lh.id_lop
            ORDER BY bt.id_baitest DESC
            LIMIT {$tests_per_page} OFFSET {$offset}";
    $result = $conn->query($sql_with_limit);
}

// Lấy danh sách khóa học cho các modal
$courses = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$courses_for_edit_modal = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");
$courses_for_filter = $conn->query("SELECT id_khoahoc, ten_khoahoc FROM khoahoc ORDER BY ten_khoahoc");

/**
 * Hàm hiển thị badge cho từng loại bài test.
 * @param string $type Loại bài test từ CSDL.
 * @return string HTML của badge.
 */
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
    /* Search & Filter Bar */
    .search-filter-bar {
        background-color: #fff;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #dee2e6;
    }

    .search-filter-bar .form-control,
    .search-filter-bar .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .search-filter-bar .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }

    .filter-stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #dee2e6;
    }

    .filter-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: #e7f7ec;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #0a8a2c;
    }

    .filter-stats .stat-item i {
        font-size: 14px;
        color: #0db33b;
    }

    /* Test Pagination Styles */
    .test-pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .test-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #0db33b 0%, #0a8a2c 100%);
        padding: 6px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(13, 179, 59, 0.2);
    }

    .test-pagination-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 9px;
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border: none;
        border-radius: 25px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .test-pagination-btn:hover:not(.disabled) {
        background: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: #0a8a2c;
    }

    .test-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .test-pagination-numbers {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 0 8px;
    }

    .test-pagination-number {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .test-pagination-number:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #0db33b;
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-1px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .test-pagination-number.active {
        background: #fff;
        color: #0a8a2c;
        border-color: #fff;
        transform: scale(1.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    @keyframes testPagePulse {

        0%,
        100% {
            transform: scale(1.08);
        }

        50% {
            transform: scale(1.12);
        }
    }

    .test-pagination-dots {
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        padding: 0 3px;
        font-size: 12px;
    }

    .test-pagination-info {
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

    .test-pagination-info i {
        font-size: 14px;
    }

    .test-pagination-info strong {
        color: #0a8a2c;
        font-size: 13px;
    }

    .test-pagination-info .separator {
        margin: 0 3px;
        color: rgba(13, 179, 59, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-filter-bar {
            padding: 15px;
        }

        .test-pagination {
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .test-pagination-btn {
            padding: 8px 12px;
            font-size: 13px;
        }

        .test-pagination-btn span {
            display: none;
        }

        .test-pagination-number {
            min-width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .test-pagination-info {
            font-size: 12px;
            padding: 10px 18px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .test-pagination-numbers {
            gap: 4px;
            margin: 0 5px;
        }

        .test-pagination-number {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }
</style>

<div class="card animated-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa-solid fa-circle-question me-2"></i>Quản lý Bài Test</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTestModal"><i class="fa-solid fa-plus"></i> Thêm Bài Test</button>
        </div>
    </div>
    <div class="card-body">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message']['type'] . ' alert-dismissible fade show">' . htmlspecialchars($_SESSION['message']['text']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            unset($_SESSION['message']);
        }
        ?>

        <!-- Search & Filter Bar -->
        <div class="search-filter-bar">
            <form method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="nav" value="question">

                <div class="col-md-4">
                    <label for="search" class="form-label"><i class="fas fa-search me-1"></i> Tìm kiếm</label>
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Nhập tên bài test..."
                        value="<?php echo htmlspecialchars($search_query); ?>">
                </div>

                <div class="col-md-3">
                    <label for="test_type" class="form-label"><i class="fas fa-filter me-1"></i> Loại test</label>
                    <select name="test_type" id="test_type" class="form-select">
                        <option value="">Tất cả loại</option>
                        <option value="dau_vao" <?php echo ($test_type_filter == 'dau_vao') ? 'selected' : ''; ?>>Test đầu vào</option>
                        <option value="dinh_ky" <?php echo ($test_type_filter == 'dinh_ky') ? 'selected' : ''; ?>>Test định kỳ</option>
                        <option value="on_tap" <?php echo ($test_type_filter == 'on_tap') ? 'selected' : ''; ?>>Test ôn tập</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="course_id" class="form-label"><i class="fas fa-book me-1"></i> Khóa học</label>
                    <select name="course_id" id="course_id" class="form-select">
                        <option value="">Tất cả khóa học</option>
                        <?php
                        mysqli_data_seek($courses_for_filter, 0);
                        while ($course = $courses_for_filter->fetch_assoc()):
                        ?>
                            <option value="<?php echo $course['id_khoahoc']; ?>" <?php echo ($course_filter == $course['id_khoahoc']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($course['ten_khoahoc']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="col-md-1">
                    <a href="?nav=question" class="btn btn-outline-secondary w-100" title="Đặt lại">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>

            <?php if (!empty($search_query) || !empty($test_type_filter) || !empty($course_filter)): ?>
                <div class="filter-stats">
                    <span class="stat-item">
                        <i class="fas fa-filter"></i>
                        Đang lọc
                    </span>
                    <?php if (!empty($search_query)): ?>
                        <span class="stat-item">
                            <i class="fas fa-search"></i>
                            "<?php echo htmlspecialchars($search_query); ?>"
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($test_type_filter)): ?>
                        <span class="stat-item">
                            <i class="fas fa-clipboard-check"></i>
                            <?php
                            $type_names = ['dau_vao' => 'Test đầu vào', 'dinh_ky' => 'Test định kỳ', 'on_tap' => 'Test ôn tập'];
                            echo $type_names[$test_type_filter] ?? $test_type_filter;
                            ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($course_filter)):
                        mysqli_data_seek($courses_for_filter, 0);
                        while ($course = $courses_for_filter->fetch_assoc()):
                            if ($course['id_khoahoc'] == $course_filter):
                    ?>
                                <span class="stat-item">
                                    <i class="fas fa-book"></i>
                                    <?php echo htmlspecialchars($course['ten_khoahoc']); ?>
                                </span>
                    <?php
                            endif;
                        endwhile;
                    endif;
                    ?>
                    <span class="stat-item">
                        <i class="fas fa-list-check"></i>
                        <?php echo $total_tests; ?> kết quả
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên Bài Test</th>
                            <th>Phạm vi</th>
                            <th class="text-center">Loại Test</th>
                            <th class="text-center">Ngày Tạo</th>
                            <th class="text-center" style="min-width: 180px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        while ($row = $result->fetch_assoc()):
                            // Xác định phạm vi của bài test
                            $scope = '<span class="badge bg-secondary">Công khai</span>';
                            if ($row['ten_lop']) {
                                $scope = '<strong>Lớp:</strong> ' . htmlspecialchars($row['ten_lop']);
                            } elseif ($row['ten_khoahoc']) {
                                $scope = '<strong>Khóa:</strong> ' . htmlspecialchars($row['ten_khoahoc']);
                            }
                        ?>
                            <tr class="animated-row" style="animation-delay: <?php echo $index++ * 50; ?>ms;">
                                <td><?php echo $row['id_baitest']; ?></td>
                                <td><?php echo htmlspecialchars($row['ten_baitest']); ?></td>
                                <td><?php echo $scope; ?></td>
                                <td class="text-center"><?php echo get_test_type_badge($row['loai_baitest']); ?></td>
                                <td class="text-center"><?php echo date("d/m/Y", strtotime($row['ngay_tao'])); ?></td>
                                <td class="text-center">
                                    <a href="./admin.php?nav=ds_cauhoi&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-primary btn-sm" title="Quản lý câu hỏi"><i class="fa-solid fa-list-check"></i></a>
                                    <button onclick="openEditModal(<?php echo $row['id_baitest']; ?>)" class="btn btn-warning btn-sm" title="Sửa bài test"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <a href="./admin.php?nav=kqhocvien&id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-info btn-sm text-white" title="Xem kết quả"><i class="fa-solid fa-square-poll-vertical"></i></a>
                                    <a href="./modules/cauhoi/delete_test.php?id_baitest=<?php echo $row['id_baitest']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa bài test này sẽ xóa tất cả dữ liệu liên quan. Bạn chắc chắn?');" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
                <!-- Pagination -->
                <div class="test-pagination-container">
                    <div class="test-pagination">
                        <!-- Previous Button -->
                        <?php
                        $prev_link = "?nav=question&test_page=" . max(1, $current_page - 1);
                        if (!empty($search_query)) $prev_link .= "&search=" . urlencode($search_query);
                        if (!empty($test_type_filter)) $prev_link .= "&test_type=" . urlencode($test_type_filter);
                        if (!empty($course_filter)) $prev_link .= "&course_id=" . urlencode($course_filter);
                        ?>
                        <a href="<?php echo $prev_link; ?>"
                            class="test-pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                            <i class="fas fa-chevron-left"></i>
                            <span>Trước</span>
                        </a>

                        <!-- Page Numbers -->
                        <div class="test-pagination-numbers">
                            <?php
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($total_pages, $current_page + 2);

                            if ($start_page > 1) {
                                $first_link = "?nav=question&test_page=1";
                                if (!empty($search_query)) $first_link .= "&search=" . urlencode($search_query);
                                if (!empty($test_type_filter)) $first_link .= "&test_type=" . urlencode($test_type_filter);
                                if (!empty($course_filter)) $first_link .= "&course_id=" . urlencode($course_filter);
                                echo '<a href="' . $first_link . '" class="test-pagination-number">1</a>';
                                if ($start_page > 2) {
                                    echo '<span class="test-pagination-dots">...</span>';
                                }
                            }

                            for ($i = $start_page; $i <= $end_page; $i++) {
                                $page_link = "?nav=question&test_page={$i}";
                                if (!empty($search_query)) $page_link .= "&search=" . urlencode($search_query);
                                if (!empty($test_type_filter)) $page_link .= "&test_type=" . urlencode($test_type_filter);
                                if (!empty($course_filter)) $page_link .= "&course_id=" . urlencode($course_filter);
                                $active_class = ($i == $current_page) ? 'active' : '';
                                echo '<a href="' . $page_link . '" class="test-pagination-number ' . $active_class . '">' . $i . '</a>';
                            }

                            if ($end_page < $total_pages) {
                                if ($end_page < $total_pages - 1) {
                                    echo '<span class="test-pagination-dots">...</span>';
                                }
                                $last_link = "?nav=question&test_page={$total_pages}";
                                if (!empty($search_query)) $last_link .= "&search=" . urlencode($search_query);
                                if (!empty($test_type_filter)) $last_link .= "&test_type=" . urlencode($test_type_filter);
                                if (!empty($course_filter)) $last_link .= "&course_id=" . urlencode($course_filter);
                                echo '<a href="' . $last_link . '" class="test-pagination-number">' . $total_pages . '</a>';
                            }
                            ?>
                        </div>

                        <!-- Next Button -->
                        <?php
                        $next_link = "?nav=question&test_page=" . min($total_pages, $current_page + 1);
                        if (!empty($search_query)) $next_link .= "&search=" . urlencode($search_query);
                        if (!empty($test_type_filter)) $next_link .= "&test_type=" . urlencode($test_type_filter);
                        if (!empty($course_filter)) $next_link .= "&course_id=" . urlencode($course_filter);
                        ?>
                        <a href="<?php echo $next_link; ?>"
                            class="test-pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                            <span>Sau</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>

                    <!-- Pagination Info -->
                    <div class="test-pagination-info">
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

        <?php else: ?>
            <div class="alert alert-light text-center py-5">
                <i class="fa-solid fa-clipboard-question fa-3x mb-3 text-muted"></i>
                <h5 class="mb-2">Không tìm thấy bài test</h5>
                <p class="mb-3 text-muted">
                    <?php if (!empty($search_query) || !empty($test_type_filter) || !empty($course_filter)): ?>
                        Không tìm thấy bài test nào phù hợp với bộ lọc.
                    <?php else: ?>
                        Chưa có bài test nào được tạo.
                    <?php endif; ?>
                </p>
                <?php if (!empty($search_query) || !empty($test_type_filter) || !empty($course_filter)): ?>
                    <a href="?nav=question" class="btn btn-outline-primary">
                        <i class="fas fa-redo me-2"></i>Xem tất cả bài test
                    </a>
                <?php else: ?>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTestModal">
                        <i class="fa-solid fa-plus me-2"></i>Tạo bài test đầu tiên
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="addTestModal" tabindex="-1" aria-hidden="true">
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

<div class="modal fade" id="editTestModal" tabindex="-1" aria-hidden="true">
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
    /**
     * Hàm tải danh sách lớp học dựa trên courseId và điền vào select box
     * @param {string} courseId - ID của khóa học
     * @param {HTMLSelectElement} classSelect - Element select của lớp học
     * @param {HTMLElement} classWrapper - Element wrapper của select lớp học
     * @param {string|null} selectedLopId - ID lớp học cần chọn sẵn (nếu có)
     */
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

            // Điền dữ liệu vào form
            document.getElementById('edit_id_baitest').value = data.id_baitest;
            document.getElementById('edit_ten_baitest').value = data.ten_baitest;
            document.getElementById('edit_loai_baitest').value = data.loai_baitest;
            document.getElementById('edit_id_khoahoc').value = data.id_khoahoc || "";
            document.getElementById('edit_thoi_gian').value = data.thoi_gian;

            // Tải danh sách lớp tương ứng
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
        // Logic cho modal Thêm mới
        const addCourseSelect = document.getElementById('add_id_khoahoc');
        const addClassWrapper = document.getElementById('add_class_wrapper');
        const addClassSelect = document.getElementById('add_id_lop');
        addCourseSelect.addEventListener('change', () => loadClasses(addCourseSelect.value, addClassSelect, addClassWrapper));

        // Logic cho modal Sửa
        const editCourseSelect = document.getElementById('edit_id_khoahoc');
        const editClassWrapper = document.getElementById('edit_class_wrapper');
        const editClassSelect = document.getElementById('edit_id_lop');
        editCourseSelect.addEventListener('change', () => loadClasses(editCourseSelect.value, editClassSelect, editClassWrapper));

        // Smooth scroll when clicking pagination
        const testPaginationLinks = document.querySelectorAll('.test-pagination-number, .test-pagination-btn');
        testPaginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 100);
            });
        });
    });
</script>