<?php
include('../../config/config.php');
session_start();

if (isset($_GET['id']) && isset($_SESSION['id_giangvien'])) {
    $id_hoclieu = (int)$_GET['id'];
    $lop_id = $_GET['lop_id'];
    
    $stmt = $conn->prepare("SELECT duong_dan_file FROM hoc_lieu WHERE id_hoclieu = ?");
    $stmt->bind_param("i", $id_hoclieu);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $file_path = '../../' . $row['duong_dan_file'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        $delete_stmt = $conn->prepare("DELETE FROM hoc_lieu WHERE id_hoclieu = ?");
        $delete_stmt->bind_param("i", $id_hoclieu);
        if ($delete_stmt->execute()) {
             $_SESSION['message'] = ['type' => 'success', 'text' => 'Xóa học liệu thành công!'];
        }
    }
    
    header('Location: ../admin.php?nav=teacher_materials&lop_id=' . $lop_id);
    exit();
}
?>