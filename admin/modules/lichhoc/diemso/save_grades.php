<?php
// File: admin/modules/lichhoc/diemso/save_grades.php
include('../../../../config/config.php');
session_start();

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.'];

$is_admin = $_SESSION['is_admin'] ?? false;
$is_teacher = $_SESSION['is_teacher'] ?? false;

if (!$is_admin && !$is_teacher) {
    $response['message'] = 'Bạn không có quyền thực hiện hành động này.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    parse_str(file_get_contents("php://input"), $post_vars);
    
    $id_lop = $post_vars['id_lop'] ?? '';
    $gradesData = $post_vars['grades'] ?? [];

    if (empty($id_lop) || empty($gradesData)) {
        $response['message'] = 'Không có dữ liệu điểm để lưu.';
        echo json_encode($response);
        exit;
    }

    if ($is_teacher && !$is_admin) {
        $id_giangvien_session = $_SESSION['id_giangvien'];
        $stmt_check = $conn->prepare("SELECT id_lop FROM lop_hoc WHERE id_lop = ? AND id_giangvien = ?");
        $stmt_check->bind_param("si", $id_lop, $id_giangvien_session);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows === 0) {
            $response['message'] = 'Lỗi: Bạn không có quyền chấm điểm cho lớp này.';
            echo json_encode($response);
            exit();
        }
        $stmt_check->close();
    }

    $conn->begin_transaction();
    try {
        $sql_upsert = "INSERT INTO diem_so (id_hocvien, id_lop, loai_diem, diem, nhan_xet, ngay_nhap_diem) 
                       VALUES (?, ?, ?, ?, ?, NOW())
                       ON DUPLICATE KEY UPDATE diem = VALUES(diem), nhan_xet = VALUES(nhan_xet), ngay_nhap_diem = NOW()";
        $stmt_upsert = $conn->prepare($sql_upsert);

        $sql_delete = "DELETE FROM diem_so WHERE id_hocvien = ? AND id_lop = ? AND loai_diem = ?";
        $stmt_delete = $conn->prepare($sql_delete);

        foreach ($gradesData as $id_hocvien => $loaiDiemData) {
            foreach ($loaiDiemData as $loai_diem => $data) {
                $diem_input = $data['diem'] ?? '';
                $nhan_xet = $data['nhan_xet'] ?? '';
                $is_numeric = ($diem_input !== '' && is_numeric($diem_input));

                if ($is_numeric || !empty($nhan_xet)) {
                    $diem = $is_numeric ? (float)$diem_input : null;
                    
                    // *** SỬA LỖI QUAN TRỌNG TẠI ĐÂY ***
                    // Thay đổi "isdss" thành "issds" để `loai_diem` được hiểu là string (s) và `diem` là double (d).
                    $stmt_upsert->bind_param("issds", $id_hocvien, $id_lop, $loai_diem, $diem, $nhan_xet);
                    $stmt_upsert->execute();
                } else {
                    $stmt_delete->bind_param("iss", $id_hocvien, $id_lop, $loai_diem);
                    $stmt_delete->execute();
                }
            }
        }
        
        $conn->commit();
        $response['status'] = 'success';
        $response['message'] = 'Lưu bảng điểm thành công!';

    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = 'Lỗi khi lưu điểm: ' . $e->getMessage();
    }
}

echo json_encode($response);
$conn->close();
?>