<?php
include('../../../config/config.php');

// Lấy ID học viên từ query string
$studentId = $_GET['id'];

// Truy vấn thông tin học viên từ cơ sở dữ liệu
$sql = "SELECT * FROM hocvien WHERE id_hocvien = $studentId";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
    // Trả về dữ liệu học viên dưới dạng JSON
    echo json_encode($student);
} else {
    echo json_encode(["error" => "Không tìm thấy học viên."]);
}
?>
