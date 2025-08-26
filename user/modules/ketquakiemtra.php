<?php
if (isset($_GET['nav']) && $_GET['nav'] === 'ketquakiemtra') {
    // Kết nối CSDL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "quanlykhoahoc";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("<div class='alert alert-danger'>Kết nối thất bại: " . $conn->connect_error . "</div>");
    }

    // Giả định ID học viên từ session
    $id_hocvien = $_SESSION['id_hocvien'] ?? 1; // Thay thế bằng ID thực

    // Lấy danh sách kết quả bài kiểm tra
    $sql_results = "
        SELECT bt.ten_baitest, kq.diem, kq.ngay_lam_bai
        FROM ketquabaitest kq
        JOIN baitest bt ON kq.id_baitest = bt.id_baitest
        WHERE kq.id_hocvien = ?
        ORDER BY kq.ngay_lam_bai DESC
    ";
    $stmt = $conn->prepare($sql_results);
    $stmt->bind_param("i", $id_hocvien);
    $stmt->execute();
    $result = $stmt->get_result();

    // Giao diện hiển thị
    echo '<div class="container mt-4">';
    echo '<h1 class="text-primary introduce-title">Kết quả bài kiểm tra</h1>';

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-hover">';
        echo '<thead class="table-dark">';
        echo '<tr>';
        echo '<th>Tên bài kiểm tra</th>';
        echo '<th>Số câu đúng</th>';
        echo '<th>Ngày làm bài</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['ten_baitest']) . '</td>';
            echo '<td>' . htmlspecialchars($row['diem']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ngay_lam_bai']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<div class="alert alert-info">Không có kết quả bài kiểm tra nào được tìm thấy.</div>';
    }

    echo '</div>';
}
?>
