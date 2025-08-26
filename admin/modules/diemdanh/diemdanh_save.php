<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quanlykhoahoc";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$id_lop = $_POST['id_lop'];
$diemDanhData = $_POST['diemdanh'];

// Lấy danh sách toàn bộ lịch học của lớp
$lichHocQuery = $conn->prepare("SELECT id_lichhoc FROM lichhoc WHERE id_lop = ?");
$lichHocQuery->bind_param("s", $id_lop);
$lichHocQuery->execute();
$lichHocResult = $lichHocQuery->get_result();
$allLichHoc = $lichHocResult->fetch_all(MYSQLI_ASSOC);

foreach ($diemDanhData as $id_hocvien => $hocvienData) {
    // Lấy danh sách các lịch học mà học viên được tích "có mặt"
    $checkedLichHoc = isset($hocvienData['lichhoc']) ? $hocvienData['lichhoc'] : [];
    $soBuoiThamGia = count(array_filter($checkedLichHoc, fn($status) => $status === 'co mat'));

    // Duyệt qua toàn bộ lịch học để lưu trạng thái điểm danh
    foreach ($allLichHoc as $lichHoc) {
        $id_lichhoc = $lichHoc['id_lichhoc'];
        $trangThai = isset($checkedLichHoc[$id_lichhoc]) && $checkedLichHoc[$id_lichhoc] === 'co mat' ? 'co mat' : 'vang';

        // Kiểm tra nếu bản ghi đã tồn tại
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM diem_danh WHERE id_hocvien = ? AND id_lop = ? AND id_lichhoc = ?");
        $checkStmt->bind_param("iss", $id_hocvien, $id_lop, $id_lichhoc);
        $checkStmt->execute();
        $checkStmt->bind_result($exists);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($exists > 0) {
            // Nếu đã tồn tại, cập nhật trạng thái
            $updateStmt = $conn->prepare("
                UPDATE diem_danh
                SET trang_thai = ?, ngay_diemdanh = CURRENT_DATE
                WHERE id_hocvien = ? AND id_lop = ? AND id_lichhoc = ?
            ");
            $updateStmt->bind_param("siss", $trangThai, $id_hocvien, $id_lop, $id_lichhoc);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Nếu không tồn tại, chèn mới
            $insertStmt = $conn->prepare("
                INSERT INTO diem_danh (id_hocvien, id_lop, id_lichhoc, trang_thai, ngay_diemdanh)
                VALUES (?, ?, ?, ?, CURRENT_DATE)
            ");
            $insertStmt->bind_param("isss", $id_hocvien, $id_lop, $id_lichhoc, $trangThai);
            $insertStmt->execute();
            $insertStmt->close();
        }
    }

    // Cập nhật số buổi đã tham gia trong bảng `tien_do_hoc_tap`
    $updateProgressStmt = $conn->prepare("
        UPDATE tien_do_hoc_tap
        SET so_buoi_da_tham_gia = ?, ngay_cap_nhat = NOW()
        WHERE id_hocvien = ? AND id_khoahoc = (
            SELECT id_khoahoc FROM lop_hoc WHERE id_lop = ?
        )
    ");
    $updateProgressStmt->bind_param("iis", $soBuoiThamGia, $id_hocvien, $id_lop);
    $updateProgressStmt->execute();
    $updateProgressStmt->close();
}
header('Location: ../../admin.php?nav=lichhoc&view=diemdanh&lop_id='.$id_lop.'');
?>
