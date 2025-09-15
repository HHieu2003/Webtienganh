<?php
include('../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_giangvien'])) {
    $id_lop = $_POST['id_lop'];
    $tieu_de = $_POST['tieu_de'];
    
    if (isset($_FILES['hoc_lieu_file']) && $_FILES['hoc_lieu_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['hoc_lieu_file'];
        $file_name = time() . '_' . basename($file['name']);
        $file_type = strtoupper(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $target_dir = "../../uploads/materials/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $duong_dan_file = 'uploads/materials/' . $file_name;
            
            $sql = "INSERT INTO hoc_lieu (id_lop, tieu_de, loai_file, duong_dan_file, ngay_dang) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $id_lop, $tieu_de, $file_type, $duong_dan_file);
            if ($stmt->execute()) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Tải lên học liệu thành công!'];
            }
        }
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Có lỗi xảy ra khi tải file lên.'];
    }
    
    header('Location: ../admin.php?nav=teacher_materials&lop_id=' . $id_lop);
    exit();
}
?>