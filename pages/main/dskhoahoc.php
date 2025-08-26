<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'quanlykhoahoc');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
mysqli_set_charset($conn, 'utf8');

// Lấy danh sách khóa học từ cơ sở dữ liệu
$sql = "SELECT ten_khoahoc, mo_ta, hinh_anh, id_khoahoc  FROM khoahoc ORDER BY RAND ( )  LIMIT 8";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container">';

    // Hiển thị từng khóa học
    while ($row = $result->fetch_assoc()) {
        echo '<div class="container-item">';

        echo '<a href="./index.php?nav=course_detail&course_id=' . htmlspecialchars($row['id_khoahoc']) . '">';
        echo '<img src="' . htmlspecialchars($row['hinh_anh']) . '" alt="Hình ảnh khóa học">';



        // Hiển thị thông tin khóa học
        echo '<div class="container-item-row">';
        echo '<h5>' . htmlspecialchars($row['ten_khoahoc']) . '</h5>';
        $mota = html_entity_decode($row['mo_ta']);
        echo '<div class="clamp-text default-text">';
        echo html_entity_decode($row['mo_ta']);
        echo '</div>';

        echo '</div>'; // Kết thúc container-item-row
        echo '</a>';

        echo '</div>'; // Kết thúc container-item
    }

    echo '</div>'; // Kết thúc container
} else {
    echo '<p>Không có khóa học nào được tìm thấy.</p>';
}

$conn->close();
?>
<style>
    .container-item-row a{
        text-decoration: none;
    }
    .container-item-row p,
    .container-item-row h1,
    .container-item-row h2,
    .container-item-row h3,
    .container-item-row h4,
    .container-item-row h5,
    .container-item-row h6,
    .container-item-row{
        color: white;
    }
    .default-text ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: justify;
    }

    .default-text p,
    .default-text ul li,

    .default-text h1,
    .default-text h2,
    .default-text h3,
    .default-text h4,
    .default-text h5,
    .default-text h6,
    .default-text strong {
        font-family: inherit;
        /* Sử dụng font mặc định của phần tử cha */
        font-size: 14px;
        /* Sử dụng kích thước mặc định của phần tử cha */
        font-weight: 100;
        color: white;
        /* Sử dụng màu mặc định của phần tử cha */
        padding: 0;
        margin: 0;
        text-align: justify;

    }

    .clamp-text {
    /* max-height: 70px; Chiều cao tối đa cho phần mô tả */
    overflow: hidden; /* Ẩn phần nội dung vượt quá */
    text-overflow: ellipsis; /* Thêm dấu "..." nếu bị cắt */
    line-height: 1.5; /* Khoảng cách giữa các dòng */
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Hiển thị tối đa 4 dòng */
    -webkit-box-orient: vertical; /* Định hướng khối hộp theo chiều dọc */
    word-wrap: break-word; /* Tự động xuống dòng nếu quá dài */
    margin-top: 10px; /* Khoảng cách trên */
    color: #666; /* Màu chữ cho mô tả */
    font-size: 14px; /* Kích thước chữ */


}

</style>