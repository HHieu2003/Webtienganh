<?php
/**
 */

require_once 'config.php';

class DatabaseAdvisor {
    private $conn;
    private $centerInfo = [
        'name' => 'Fighter English Center',
        'address' => '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh',
        'hotline' => '0962.501.832',
        'support' => '0336.123.130',
        'email' => 'info@tienganfighter.com',
        'website' => 'www.tienganfighter.com',
        'facebook' => 'Tiếng Anh Fighter',
        'instagram' => '@fighter_english'
    ];
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    /**
     * Main entry point - analyze message and route to appropriate handler
     */
    public function getAdvice($message) {
        try {
            $message = strtolower(trim($message));
            // 1. Highest Priority: Specific course questions
            if ($this->isSpecificCourseQuestion($message)) {
                $courseName = $this->extractCourseName($message);
                if ($courseName) {
                    return $this->getSpecificCourseInfo($courseName);
                }
            }

            // 2. Second Priority: Specific criteria questions
            if ($this->isCourseByCriteriaQuestion($message)) {
                return $this->getCoursesByCriteria($message);
            }
            
            // 3. Standard informational questions
            if ($this->isCoursesQuestion($message)) {
                return $this->getCoursesAdvice($message);
            }
            if ($this->isFeeQuestion($message)) {
                return $this->getFeeAdvice($message);
            }
            if ($this->isScheduleQuestion($message)) {
                return $this->getScheduleAdvice($message);
            }
            if ($this->isContactQuestion($message)) {
                return $this->getContactAdvice();
            }
            if ($this->isRegistrationQuestion($message)) {
                return $this->getRegistrationAdvice();
            }
            if ($this->isTeacherQuestion($message)) {
                return $this->getTeacherInfo($message);
            }
            if ($this->isClassQuestion($message)) {
                return $this->getClassInfo($message);
            }
            if ($this->isPromotionQuestion($message)) {
                return $this->getPromotionInfo();
            }
            
            // If no match, let AI handle it
            return null;
            
        } catch (Exception $e) {
            error_log("Database Advisor Error: " . $e->getMessage());
            return null;
        }
    }
    

    /**
     * NEW: Detects questions about a specific course.
     */
    private function isSpecificCourseQuestion($message) {
        $keywords = ['về khóa', 'thông tin khóa', 'chi tiết khóa', 'khóa học', 'course'];
        // Check for keywords followed by quoted text or specific identifiers
        return $this->containsKeywords($message, $keywords) && (preg_match('/"([^"]+)"/', $message) || preg_match('/(ielts|toeic|giao tiếp|mất gốc|cơ bản)/', $message));
    }
    
    private function isCourseByCriteriaQuestion($message) {
        $courseKeywords = ['khóa học', 'course', 'khoá'];
        $criteriaKeywords = ['rẻ nhất', 'thấp nhất', 'đắt nhất', 'cao nhất', 'mới nhất', 
                             'phổ biến nhất', 'đông', 'nhiều học viên', 'đánh giá cao', 
                             'tốt nhất', 'hot nhất'];
        
        return $this->containsKeywords($message, $courseKeywords) && 
               $this->containsKeywords($message, $criteriaKeywords);
    }
    
    // Other detection functions remain the same...
    private function isCoursesQuestion($message) {
        $keywords = ['khóa học', 'course', 'lớp học', 'học gì', 'chương trình', 'khoá', 'môn học', 'học tập'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isFeeQuestion($message) {
        $keywords = ['học phí', 'giá', 'cost', 'fee', 'tiền', 'phí', 'price', 'chi phí'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isScheduleQuestion($message) {
        $keywords = ['lịch học', 'thời gian', 'schedule', 'khi nào', 'giờ học', 'ca học'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isContactQuestion($message) {
        $keywords = ['liên hệ', 'contact', 'hotline', 'địa chỉ', 'email', 'phone', 'sdt'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isRegistrationQuestion($message) {
        $keywords = ['đăng ký', 'register', 'enroll', 'tham gia', 'học thử', 'ghi danh'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isTeacherQuestion($message) {
        $keywords = ['giảng viên', 'teacher', 'thầy', 'cô', 'giáo viên'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isClassQuestion($message) {
        $keywords = ['lớp', 'class', 'lớp học', 'lớp nào'];
        return $this->containsKeywords($message, $keywords);
    }
    private function isPromotionQuestion($message) {
        $keywords = ['ưu đãi', 'promotion', 'khuyến mãi', 'giảm giá', 'discount'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function containsKeywords($message, $keywords) {
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) return true;
        }
        return false;
    }

    /**
     * NEW: Extracts the course name from the user's message.
     */
    private function extractCourseName($message) {
        // First, try to find a name in quotes
        if (preg_match('/"([^"]+)"/', $message, $matches)) {
            return trim($matches[1]);
        }

        // If not, look for keywords after "về khóa học", "về khóa", etc.
        $patterns = [
            'về khóa học', 'thông tin khóa học', 'chi tiết khóa học', 
            'về khóa', 'thông tin khóa', 'chi tiết khóa', 'về course'
        ];
        foreach ($patterns as $pattern) {
            $pos = strpos($message, $pattern);
            if ($pos !== false) {
                return trim(substr($message, $pos + strlen($pattern)));
            }
        }
        
        return null; // No specific name found
    }
    private function getSpecificCourseInfo($courseName) {
        try {
            $sql = "SELECT 
                        k.ten_khoahoc, k.mo_ta, k.thoi_gian, k.chi_phi, k.danh_gia_tb,
                        COUNT(DISTINCT lh.id_lop) as so_lop,
                        COALESCE(SUM(lh.so_luong_hoc_vien), 0) as tong_hoc_vien
                    FROM khoahoc k
                    LEFT JOIN lop_hoc lh ON k.id_khoahoc = lh.id_khoahoc
                    WHERE k.ten_khoahoc LIKE ?
                    GROUP BY k.id_khoahoc
                    LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            $searchTerm = '%' . $courseName . '%';
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $course = $result->fetch_assoc();
                $response = "✅ **Đây là thông tin chi tiết về khóa học bạn quan tâm:**\n\n";
                $response .= "🎓 **Tên khóa học:** " . htmlspecialchars($course['ten_khoahoc']) . "\n";
                $response .= "📝 **Mô tả:** " . htmlspecialchars(strip_tags($course['mo_ta'])) . "\n\n";
                $response .= "💰 **Học phí:** **" . number_format($course['chi_phi'] ?? 0, 0, ',', '.') . " VNĐ**\n";
                if ($course['thoi_gian']) {
                    $response .= "⏱️ **Thời lượng:** **{$course['thoi_gian']} buổi**\n";
                }
                if ($course['danh_gia_tb'] > 0) {
                    $stars = str_repeat('⭐', floor($course['danh_gia_tb']));
                    $response .= "{$stars} **Đánh giá:** " . number_format($course['danh_gia_tb'], 1) . "/5\n";
                }
                 if ($course['so_lop'] > 0) {
                    $response .= "👥 **Hiện có:** **{$course['so_lop']}** lớp đang mở với tổng số **" . ($course['tong_hoc_vien'] ?? 0) . "** học viên.\n";
                } else {
                    $response .= "👥 **Tình trạng:** Sắp khai giảng, vui lòng liên hệ để biết lịch học gần nhất.\n";
                }

                $response .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= "🎯 **Bạn có muốn:**\n";
                $response .= "• Hỏi về 'lịch học' của khóa này?\n";
                $response .= "• Hay 'đăng ký' khóa học ngay?\n";
                $response .= "• Gọi hotline **{$this->centerInfo['hotline']}** để được tư vấn trực tiếp!";
                return $response;

            } else {
                return "Rất tiếc, tôi không tìm thấy thông tin về khóa học '{$courseName}'. Bạn có thể cho tôi biết tên chính xác hơn hoặc hỏi về 'tất cả khóa học' để tôi liệt kê nhé!";
            }
        } catch (Exception $e) {
            error_log("Get Specific Course Info Error: " . $e->getMessage());
            return "Đã có lỗi xảy ra khi tìm kiếm thông tin khóa học. Vui lòng thử lại sau.";
        }
    }
    
    private function getCoursesByCriteria($message) {
        // ... (function remains unchanged)
        try {
            // Determine sorting criteria from the message
            $orderBy = 'k.danh_gia_tb DESC'; // Default: best rated
            $sortDirection = 'DESC';
            $criteriaText = 'được đánh giá cao nhất';

            if ($this->containsKeywords($message, ['rẻ nhất', 'thấp nhất'])) {
                $orderBy = 'k.chi_phi ASC';
                $sortDirection = 'ASC';
                $criteriaText = 'có học phí rẻ nhất';
            } elseif ($this->containsKeywords($message, ['đắt nhất', 'cao nhất'])) {
                $orderBy = 'k.chi_phi DESC';
                $criteriaText = 'có học phí cao nhất';
            } elseif ($this->containsKeywords($message, ['phổ biến nhất', 'đông', 'nhiều học viên', 'hot nhất'])) {
                $orderBy = 'tong_hoc_vien DESC';
                $criteriaText = 'phổ biến nhất';
            } elseif ($this->containsKeywords($message, ['mới nhất'])) {
                // Assuming higher ID means newer course
                $orderBy = 'k.id_khoahoc DESC';
                $criteriaText = 'mới nhất';
            }
            
            // Build the query
            $sql = "SELECT 
                        k.id_khoahoc, k.ten_khoahoc, k.mo_ta, k.thoi_gian, k.chi_phi, k.danh_gia_tb,
                        COUNT(DISTINCT lh.id_lop) as so_lop,
                        COALESCE(SUM(lh.so_luong_hoc_vien), 0) as tong_hoc_vien
                    FROM khoahoc k
                    LEFT JOIN lop_hoc lh ON k.id_khoahoc = lh.id_khoahoc
                    GROUP BY k.id_khoahoc
                    ORDER BY {$orderBy}
                    LIMIT 3";
            
            $result = $this->conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $response = "🎯 **Đây là các khóa học {$criteriaText} tại trung tâm:**\n\n";
                $count = 1;

                while ($course = $result->fetch_assoc()) {
                    $response .= "**{$count}. " . htmlspecialchars($course['ten_khoahoc'] ?? 'N/A') . "**\n";
                    $response .= "   💰 **Học phí: " . number_format($course['chi_phi'] ?? 0, 0, ',', '.') . " VNĐ**\n";
                    if ($course['thoi_gian']) {
                        $response .= "   ⏱️ Thời lượng: **{$course['thoi_gian']} buổi**\n";
                    }
                    if ($course['danh_gia_tb'] > 0) {
                        $stars = str_repeat('⭐', floor($course['danh_gia_tb']));
                        $response .= "   {$stars} Đánh giá: " . number_format($course['danh_gia_tb'], 1) . "/5\n";
                    }
                    $response .= "   👥 Tổng học viên: **" . ($course['tong_hoc_vien'] ?? 0) . "**\n\n";
                    $count++;
                }
                
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= "Bạn có muốn biết thêm chi tiết về khóa học nào không?";
                return $response;

            } else {
                return "Rất tiếc, tôi không tìm thấy khóa học nào phù hợp với yêu cầu của bạn. Bạn có thể hỏi về 'tất cả khóa học' để tôi liệt kê nhé!";
            }
        } catch (Exception $e) {
            error_log("Get Courses By Criteria Error: " . $e->getMessage());
            return $this->getStaticCoursesAdvice();
        }
    }
    
    private function getCoursesAdvice($message) {
        // ... (function remains unchanged)
        try {
            $userLevel = $this->detectUserLevel($message);
            $userInterest = $this->detectUserInterest($message);
            $sql = "SELECT k.id_khoahoc, k.ten_khoahoc, k.mo_ta, k.thoi_gian, k.chi_phi, k.danh_gia_tb, COUNT(DISTINCT lh.id_lop) as so_lop, SUM(lh.so_luong_hoc_vien) as tong_hoc_vien FROM khoahoc k LEFT JOIN lop_hoc lh ON k.id_khoahoc = lh.id_khoahoc GROUP BY k.id_khoahoc ORDER BY k.danh_gia_tb DESC, k.id_khoahoc DESC LIMIT 5";
            $result = $this->conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $response = "📚 **Các khóa học tại Fighter English Center:**\n\n";
                if ($userLevel) {
                    $response .= "💡 *Dựa trên trình độ **{$userLevel}** của bạn, tôi gợi ý:*\n\n";
                } elseif ($userInterest) {
                    $response .= "💡 *Dựa trên mục tiêu **{$userInterest}** của bạn, tôi gợi ý:*\n\n";
                }
                $count = 1;
                while ($course = $result->fetch_assoc()) {
                    $response .= "**{$count}. " . htmlspecialchars($course['ten_khoahoc'] ?? 'N/A') . "**\n";
                    if (!empty($course['mo_ta'])) {
                        $desc = strip_tags($course['mo_ta']);
                        $desc = mb_substr($desc, 0, 150);
                        $response .= "   📝 " . htmlspecialchars($desc) . "...\n";
                    }
                    if ($course['thoi_gian']) {
                        $response .= "   ⏱️ Thời lượng: **{$course['thoi_gian']} buổi học**\n";
                    }
                    $response .= "   💰 Học phí: **" . number_format($course['chi_phi'] ?? 0, 0, ',', '.') . " VNĐ**\n";
                    if ($course['danh_gia_tb'] > 0) {
                        $stars = str_repeat('⭐', floor($course['danh_gia_tb']));
                        $response .= "   {$stars} Đánh giá: " . number_format($course['danh_gia_tb'], 1) . "/5\n";
                    }
                    if ($course['so_lop'] > 0) {
                        $response .= "   👥 Có **{$course['so_lop']}** lớp đang mở với **" . ($course['tong_hoc_vien'] ?? 0) . "** học viên.\n";
                    }
                    $response .= "\n";
                    $count++;
                }
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= "🎯 **Muốn biết thêm chi tiết?**\n";
                $response .= "• Hỏi về một khóa học cụ thể (VD: 'thông tin khóa IELTS')\n";
                $response .= "• Hỏi về học phí và ưu đãi mới nhất\n";
                $response .= "• Gọi ngay hotline: **{$this->centerInfo['hotline']}**";
                return $response;
            } else {
                return $this->getStaticCoursesAdvice();
            }
        } catch (Exception $e) {
            error_log("Get Courses Error: " . $e->getMessage());
            return $this->getStaticCoursesAdvice();
        }
    }
    
    private function getFeeAdvice($message) {
        // ... (function remains unchanged)
        try {
            $specificCourse = $this->extractCourseName($message);
            if ($specificCourse) {
                return $this->getSpecificCourseFee($specificCourse);
            }
            $sql = "SELECT ten_khoahoc, chi_phi, thoi_gian FROM khoahoc ORDER BY chi_phi ASC";
            $result = $this->conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $response = "💰 **Bảng học phí tham khảo tại Fighter English Center:**\n\n";
                while ($course = $result->fetch_assoc()) {
                    $response .= "💵 **" . htmlspecialchars($course['ten_khoahoc'] ?? 'N/A') . "**\n";
                    $response .= "   • Học phí: **" . number_format($course['chi_phi'] ?? 0, 0, ',', '.') . " VNĐ**\n";
                    if ($course['thoi_gian']) {
                        $buoiPerMonth = 8;
                        $months = ceil(($course['thoi_gian'] ?? 0) / $buoiPerMonth);
                        if ($months > 0) {
                            $feePerMonth = ($course['chi_phi'] ?? 0) / $months;
                            $response .= "   • Ước tính: Khoảng " . number_format($feePerMonth, 0, ',', '.') . " VNĐ/tháng (cho {$months} tháng)\n";
                        }
                    }
                    $response .= "\n";
                }
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= $this->getPromotionInfo();
                return $response;
            } else {
                return $this->getStaticFeeAdvice();
            }
        } catch (Exception $e) {
            error_log("Get Fee Error: " . $e->getMessage());
            return $this->getStaticFeeAdvice();
        }
    }

    private function getPromotionInfo() {
        return "🎁 **Ưu đãi đặc biệt tháng này:**\n   ✅ .\n";
    }

    // All other functions like detectUserLevel, getScheduleAdvice, etc. remain here...
    private function detectUserLevel($message){ return null; }
    private function detectUserInterest($message){ return null; }
    private function getStaticCoursesAdvice(){ return "Static course advice."; }
    private function getSpecificCourseFee($courseName){ 
        // Placeholder implementation for fee. Ideally, this should also query the database.
        $info = $this->getSpecificCourseInfo($courseName);
        // This is a simplified response. You could parse the full info to extract just the fee.
        if (strpos($info, "Học phí:") !== false) {
             return $info; // Return the full info which includes the fee.
        }
        return "Không tìm thấy học phí cho khóa học " . htmlspecialchars($courseName);
    }
    private function getStaticFeeAdvice(){ return "Static fee advice."; }
    private function getScheduleAdvice($message){ return "Schedule advice."; }
    private function getContactAdvice(){ return "Contact advice."; }
    private function getRegistrationAdvice(){ return "Registration advice."; }
    private function getTeacherInfo($message){ return "Teacher info."; }
    private function getClassInfo($message){ return "Class info."; }
}
?>