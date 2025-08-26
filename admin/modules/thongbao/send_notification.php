<?php
// file: modules/send_notification.php
include('../../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieu_de = $_POST['tieu_de'];
    $noi_dung = $_POST['noi_dung'];
    $id_khoahoc = $_POST['id_khoahoc'];
    $id_lop = $_POST['id_lop'];

    if ($id_khoahoc === 'all' && $id_lop === 'all') {
        // Gửi thông báo cho tất cả học viên
        $sql_all_students = "SELECT id_hocvien FROM hocvien";
        $result = $conn->query($sql_all_students);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_hocvien = $row['id_hocvien'];
                $sql_insert_notification = "INSERT INTO thongbao (id_hocvien, tieu_de, noi_dung, ngay_tao) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql_insert_notification);
                $stmt->bind_param("iss", $id_hocvien, $tieu_de, $noi_dung);
                $stmt->execute();
            }
            echo "Đã gửi thông báo cho tất cả học viên.";
        } else {
            echo "Không có học viên nào để gửi thông báo.";
        }
    } elseif ($id_lop !== 'all') {
        // Gửi thông báo cho học viên trong lớp học cụ thể
        $sql_students_in_class = "SELECT dk.id_hocvien 
                                  FROM dangkykhoahoc dk 
                                  JOIN lop_hoc lh ON dk.id_lop = lh.id_lop
                                  WHERE dk.id_lop = ?";
        $stmt = $conn->prepare($sql_students_in_class);
        $stmt->bind_param("s", $id_lop);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_hocvien = $row['id_hocvien'];
                $sql_insert_notification = "INSERT INTO thongbao (id_hocvien, tieu_de, noi_dung, ngay_tao) VALUES (?, ?, ?, NOW())";
                $stmt_insert = $conn->prepare($sql_insert_notification);
                $stmt_insert->bind_param("iss", $id_hocvien, $tieu_de, $noi_dung);
                $stmt_insert->execute();
            }
            echo "Đã gửi thông báo cho học viên trong lớp học.";
        } else {
            echo "Không có học viên nào trong lớp học để gửi thông báo.";
        }
    } else {
        // Gửi thông báo cho học viên trong khóa học cụ thể
        $sql_students_in_course = "SELECT dk.id_hocvien 
                                   FROM dangkykhoahoc dk
                                   WHERE dk.id_khoahoc = ?";
        $stmt = $conn->prepare($sql_students_in_course);
        $stmt->bind_param("i", $id_khoahoc);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_hocvien = $row['id_hocvien'];
                $sql_insert_notification = "INSERT INTO thongbao (id_hocvien, tieu_de, noi_dung, ngay_tao) VALUES (?, ?, ?, NOW())";
                $stmt_insert = $conn->prepare($sql_insert_notification);
                $stmt_insert->bind_param("iss", $id_hocvien, $tieu_de, $noi_dung);
                $stmt_insert->execute();
            }
            echo "Đã gửi thông báo cho học viên trong khóa học.";
        } else {
            echo "Không có học viên nào trong khóa học để gửi thông báo.";
        }
    }

    $conn->close();
    header('Location: ../../admin.php?nav=thongbao');
    exit();
}
?>
