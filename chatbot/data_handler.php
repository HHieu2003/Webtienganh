<?php
session_start();
include('../config/config.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'get_courses':
                getCourseData($conn);
                break;
            case 'get_teachers':
                getTeacherData($conn);
                break;
            case 'get_student_count':
                getStudentStats($conn);
                break;
            case 'get_course_details':
                getCourseDetails($conn, $input['course_id'] ?? null);
                break;
            case 'search_courses':
                searchCourses($conn, $input['keyword'] ?? '');
                break;
            case 'get_schedule':
                getScheduleData($conn, $input['course_id'] ?? null);
                break;
            case 'get_notifications':
                getNotifications($conn);
                break;
            case 'get_website_stats':
                getWebsiteStats($conn);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

// Lấy thông tin các khóa học
function getCourseData($conn) {
    try {
        $sql = "SELECT k.*, 
                       COUNT(DISTINCT dk.id_hocvien) as enrolled_students,
                       AVG(dg.diem_danhgia) as avg_rating,
                       COUNT(DISTINCT lh.id_lop) as total_classes
                FROM khoahoc k 
                LEFT JOIN dangkykhoahoc dk ON k.id_khoahoc = dk.id_khoahoc AND dk.trang_thai = 'da xac nhan'
                LEFT JOIN danhgiakhoahoc dg ON k.id_khoahoc = dg.id_khoahoc
                LEFT JOIN lop_hoc lh ON k.id_khoahoc = lh.id_khoahoc
                GROUP BY k.id_khoahoc
                ORDER BY enrolled_students DESC, k.id_khoahoc DESC";
        
        $result = $conn->query($sql);
        $courses = [];
        
        while ($row = $result->fetch_assoc()) {
            $courses[] = [
                'id' => $row['id_khoahoc'],
                'name' => $row['ten_khoahoc'],
                'description' => $row['mo_ta'],
                'duration' => $row['thoi_gian'],
                'price' => $row['chi_phi'],
                'image' => $row['hinh_anh'],
                'rating' => $row['avg_rating'] ? round($row['avg_rating'], 1) : 0,
                'enrolled' => $row['enrolled_students'],
                'classes' => $row['total_classes']
            ];
        }
        
        echo json_encode(['success' => true, 'data' => $courses]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Lấy thông tin giảng viên
function getTeacherData($conn) {
    try {
        $sql = "SELECT gv.*, 
                       COUNT(DISTINCT lh.id_lop) as total_classes,
                       COUNT(DISTINCT dk.id_hocvien) as total_students
                FROM giangvien gv
                LEFT JOIN lop_hoc lh ON gv.id_giangvien = lh.id_giangvien
                LEFT JOIN dangkykhoahoc dk ON lh.id_lop = dk.id_lop AND dk.trang_thai = 'da xac nhan'
                GROUP BY gv.id_giangvien
                ORDER BY total_classes DESC";
        
        $result = $conn->query($sql);
        $teachers = [];
        
        while ($row = $result->fetch_assoc()) {
            $teachers[] = [
                'id' => $row['id_giangvien'],
                'name' => $row['ten_giangvien'],
                'phone' => $row['so_dien_thoai'],
                'email' => $row['email'],
                'description' => $row['mo_ta'],
                'avatar' => $row['hinh_anh'],
                'total_classes' => $row['total_classes'],
                'total_students' => $row['total_students']
            ];
        }
        
        echo json_encode(['success' => true, 'data' => $teachers]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Thống kê học viên
function getStudentStats($conn) {
    try {
        $sql_total = "SELECT COUNT(*) as total FROM hocvien";
        $sql_active = "SELECT COUNT(DISTINCT dk.id_hocvien) as active 
                       FROM dangkykhoahoc dk 
                       WHERE dk.trang_thai = 'da xac nhan'";
        
        $total_result = $conn->query($sql_total);
        $active_result = $conn->query($sql_active);
        
        $total = $total_result->fetch_assoc()['total'];
        $active = $active_result->fetch_assoc()['active'];
        
        echo json_encode([
            'success' => true, 
            'data' => [
                'total_students' => $total,
                'active_students' => $active,
                'completion_rate' => $total > 0 ? round(($active / $total) * 100, 1) : 0
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Chi tiết khóa học cụ thể
function getCourseDetails($conn, $course_id) {
    if (!$course_id) {
        echo json_encode(['success' => false, 'message' => 'Missing course ID']);
        return;
    }
    
    try {
        $sql = "SELECT k.*, 
                       COUNT(DISTINCT dk.id_hocvien) as enrolled,
                       COUNT(DISTINCT lh.id_lop) as total_classes,
                       AVG(dg.diem_danhgia) as rating,
                       GROUP_CONCAT(DISTINCT gv.ten_giangvien SEPARATOR ', ') as teachers
                FROM khoahoc k
                LEFT JOIN dangkykhoahoc dk ON k.id_khoahoc = dk.id_khoahoc AND dk.trang_thai = 'da xac nhan'
                LEFT JOIN lop_hoc lh ON k.id_khoahoc = lh.id_khoahoc  
                LEFT JOIN danhgiakhoahoc dg ON k.id_khoahoc = dg.id_khoahoc
                LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien
                WHERE k.id_khoahoc = ?
                GROUP BY k.id_khoahoc";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'id' => $row['id_khoahoc'],
                    'name' => $row['ten_khoahoc'],
                    'description' => $row['mo_ta'],
                    'duration' => $row['thoi_gian'],
                    'price' => $row['chi_phi'],
                    'enrolled' => $row['enrolled'],
                    'classes' => $row['total_classes'],
                    'rating' => $row['rating'] ? round($row['rating'], 1) : 0,
                    'teachers' => $row['teachers'] ?: 'Chưa phân công'
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Course not found']);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Tìm kiếm khóa học
function searchCourses($conn, $keyword) {
    try {
        $keyword_param = "%$keyword%";
        $sql = "SELECT k.*, COUNT(DISTINCT dk.id_hocvien) as enrolled
                FROM khoahoc k 
                LEFT JOIN dangkykhoahoc dk ON k.id_khoahoc = dk.id_khoahoc AND dk.trang_thai = 'da xac nhan'
                WHERE k.ten_khoahoc LIKE ? OR k.mo_ta LIKE ?
                GROUP BY k.id_khoahoc
                ORDER BY enrolled DESC
                LIMIT 5";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $keyword_param, $keyword_param);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = [
                'id' => $row['id_khoahoc'],
                'name' => $row['ten_khoahoc'],
                'description' => mb_substr($row['mo_ta'], 0, 100) . '...',
                'price' => $row['chi_phi'],
                'enrolled' => $row['enrolled']
            ];
        }
        
        echo json_encode(['success' => true, 'data' => $courses]);
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Lấy lịch học
function getScheduleData($conn, $course_id = null) {
    try {
        $sql = "SELECT lh.*, k.ten_khoahoc, gv.ten_giangvien, l.ten_lop
                FROM lichhoc lh
                JOIN lop_hoc l ON lh.id_lop = l.id_lop
                JOIN khoahoc k ON l.id_khoahoc = k.id_khoahoc
                LEFT JOIN giangvien gv ON l.id_giangvien = gv.id_giangvien
                WHERE lh.ngay_hoc >= CURDATE()";
        
        if ($course_id) {
            $sql .= " AND k.id_khoahoc = ?";
        }
        $sql .= " ORDER BY lh.ngay_hoc ASC, lh.gio_bat_dau ASC LIMIT 10";
        
        $stmt = $conn->prepare($sql);
        if ($course_id) {
            $stmt->bind_param("i", $course_id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $schedules = [];
        while ($row = $result->fetch_assoc()) {
            $schedules[] = [
                'course' => $row['ten_khoahoc'],
                'class' => $row['ten_lop'],
                'teacher' => $row['ten_giangvien'] ?: 'Chưa phân công',
                'date' => $row['ngay_hoc'],
                'start_time' => $row['gio_bat_dau'],
                'end_time' => $row['gio_ket_thuc'],
                'location' => $row['phong_hoc'] ?: 'Chưa xác định'
            ];
        }
        
        echo json_encode(['success' => true, 'data' => $schedules]);
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Lấy thông báo
function getNotifications($conn) {
    try {
        $sql = "SELECT * FROM thongbao 
                WHERE ngay_tao >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                ORDER BY ngay_tao DESC LIMIT 5";
        $result = $conn->query($sql);
        
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = [
                'id' => $row['id_thongbao'],
                'title' => $row['tieu_de'],
                'content' => $row['noi_dung'],
                'date' => $row['ngay_tao'],
                'auto' => $row['tu_dong']
            ];
        }
        
        echo json_encode(['success' => true, 'data' => $notifications]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Thống kê website
function getWebsiteStats($conn) {
    try {
        $stats = [];
        
        // Tổng lượt truy cập
        $sql = "SELECT SUM(so_luot) as total_visits FROM luot_truy_cap";
        $result = $conn->query($sql);
        $stats['total_visits'] = $result->fetch_assoc()['total_visits'] ?? 0;
        
        // Lượt truy cập hôm nay
        $sql = "SELECT so_luot as today_visits FROM luot_truy_cap WHERE ngay_truy_cap = CURDATE()";
        $result = $conn->query($sql);
        $stats['today_visits'] = $result->fetch_assoc()['today_visits'] ?? 0;
        
        // Tổng khóa học
        $sql = "SELECT COUNT(*) as total_courses FROM khoahoc";
        $result = $conn->query($sql);
        $stats['total_courses'] = $result->fetch_assoc()['total_courses'];
        
        // Tổng học viên
        $sql = "SELECT COUNT(*) as total_students FROM hocvien";  
        $result = $conn->query($sql);
        $stats['total_students'] = $result->fetch_assoc()['total_students'];
        
        // Học viên đang học
        $sql = "SELECT COUNT(DISTINCT id_hocvien) as active_students FROM dangkykhoahoc WHERE trang_thai = 'da xac nhan'";
        $result = $conn->query($sql);
        $stats['active_students'] = $result->fetch_assoc()['active_students'];
        
        // Giảng viên
        $sql = "SELECT COUNT(*) as total_teachers FROM giangvien";
        $result = $conn->query($sql);
        $stats['total_teachers'] = $result->fetch_assoc()['total_teachers'];
        
        // Lớp học đang hoạt động
        $sql = "SELECT COUNT(*) as active_classes FROM lop_hoc WHERE trang_thai = 'dang hoc'";
        $result = $conn->query($sql);
        $stats['active_classes'] = $result->fetch_assoc()['active_classes'];
        
        echo json_encode(['success' => true, 'data' => $stats]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
