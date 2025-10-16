<?php
/**
 * ============================================================================
 * FIGHTER CHATBOT - DATABASE ADVISOR (COMPLETE VERSION)
 * ============================================================================
 * File: database_advisor.php
 * Description: Advanced database advisor with real data from quanlykhoahoc
 * Version: 3.0 - Complete Edition
 * Author: Fighter English Center
 * Last Update: October 17, 2025
 * ============================================================================
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
            
            // Priority-based routing
            if ($this->isCoursesQuestion($message)) {
                return $this->getCoursesAdvice($message);
            } elseif ($this->isFeeQuestion($message)) {
                return $this->getFeeAdvice($message);
            } elseif ($this->isScheduleQuestion($message)) {
                return $this->getScheduleAdvice($message);
            } elseif ($this->isContactQuestion($message)) {
                return $this->getContactAdvice();
            } elseif ($this->isRegistrationQuestion($message)) {
                return $this->getRegistrationAdvice();
            } elseif ($this->isTeacherQuestion($message)) {
                return $this->getTeacherInfo($message);
            } elseif ($this->isClassQuestion($message)) {
                return $this->getClassInfo($message);
            } elseif ($this->isPromotionQuestion($message)) {
                return $this->getPromotionInfo();
            } else {
                return null; // Let AI handle it
            }
            
        } catch (Exception $e) {
            error_log("Database Advisor Error: " . $e->getMessage());
            return null;
        }
    }
    
    // ========================================================================
    // QUESTION TYPE DETECTION
    // ========================================================================
    
    private function isCoursesQuestion($message) {
        $keywords = ['khóa học', 'course', 'lớp học', 'học gì', 'chương trình', 
                    'khoá', 'môn học', 'học tập', 'khóa nào', 'course nào',
                    'loại khóa', 'khóa học nào', 'tư vấn khóa'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isFeeQuestion($message) {
        $keywords = ['học phí', 'giá', 'cost', 'fee', 'tiền', 'bao nhiêu', 
                    'phí', 'price', 'chi phí', 'đắt', 'rẻ', 'thanh toán'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isScheduleQuestion($message) {
        $keywords = ['lịch học', 'thời gian', 'schedule', 'khi nào', 'giờ học', 
                    'ca học', 'time', 'buổi học', 'học lúc', 'học khi nào'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isContactQuestion($message) {
        $keywords = ['liên hệ', 'contact', 'hotline', 'địa chỉ', 'email', 
                    'phone', 'sdt', 'gọi', 'ở đâu', 'address', 'facebook'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isRegistrationQuestion($message) {
        $keywords = ['đăng ký', 'register', 'sign up', 'enroll', 'tham gia', 
                    'học thử', 'trial', 'ghi danh', 'nhập học'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isTeacherQuestion($message) {
        $keywords = ['giảng viên', 'teacher', 'thầy', 'cô', 'giáo viên', 
                    'instructor', 'mentor'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isClassQuestion($message) {
        $keywords = ['lớp', 'class', 'lớp học', 'lớp nào', 'lớp đang học',
                    'lớp mở', 'lớp có'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function isPromotionQuestion($message) {
        $keywords = ['ưu đãi', 'promotion', 'khuyến mãi', 'giảm giá', 
                    'discount', 'sale', 'offer'];
        return $this->containsKeywords($message, $keywords);
    }
    
    private function containsKeywords($message, $keywords) {
        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
    
    // ========================================================================
    // COURSES ADVICE (ENHANCED)
    // ========================================================================
    
    private function getCoursesAdvice($message) {
        try {
            // Detect user level/interest from message
            $userLevel = $this->detectUserLevel($message);
            $userInterest = $this->detectUserInterest($message);
            
            // Get courses from database
            $sql = "SELECT 
                        k.id_khoahoc,
                        k.ten_khoahoc,
                        k.mo_ta,
                        k.thoi_gian,
                        k.chi_phi,
                        k.danh_gia_tb,
                        COUNT(DISTINCT lh.id_lop) as so_lop,
                        SUM(lh.so_luong_hoc_vien) as tong_hoc_vien
                    FROM khoahoc k
                    LEFT JOIN lop_hoc lh ON k.id_khoahoc = lh.id_khoahoc
                    GROUP BY k.id_khoahoc
                    ORDER BY k.danh_gia_tb DESC, k.id_khoahoc DESC
                    LIMIT 5";
            
            $result = $this->conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $response = "📚 **Các khóa học tại Fighter English Center:**\n\n";
                
                // Personalized greeting based on detection
                if ($userLevel) {
                    $response .= "💡 *Dựa trên trình độ {$userLevel} của bạn, tôi gợi ý:*\n\n";
                } elseif ($userInterest) {
                    $response .= "💡 *Dựa trên mục tiêu {$userInterest} của bạn, tôi gợi ý:*\n\n";
                }
                
                $count = 1;
                while ($course = $result->fetch_assoc()) {
                    $response .= "**{$count}. " . htmlspecialchars($course['ten_khoahoc']) . "**\n";
                    
                    // Description
                    if (!empty($course['mo_ta'])) {
                        $desc = strip_tags($course['mo_ta']);
                        $desc = mb_substr($desc, 0, 150);
                        $response .= "   📝 " . htmlspecialchars($desc) . "...\n";
                    }
                    
                    // Details
                    if ($course['thoi_gian']) {
                        $response .= "   ⏱️ Thời lượng: {$course['thoi_gian']} buổi học\n";
                    }
                    
                    $response .= "   💰 Học phí: " . number_format($course['chi_phi'], 0, ',', '.') . "đ\n";
                    
                    if ($course['danh_gia_tb'] > 0) {
                        $stars = str_repeat('⭐', floor($course['danh_gia_tb']));
                        $response .= "   {$stars} Đánh giá: " . number_format($course['danh_gia_tb'], 1) . "/5\n";
                    }
                    
                    if ($course['so_lop'] > 0) {
                        $response .= "   👥 Có {$course['so_lop']} lớp đang mở\n";
                    }
                    
                    $response .= "\n";
                    $count++;
                }
                
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= "🎯 **Muốn biết thêm chi tiết?**\n";
                $response .= "• Hỏi về khóa học cụ thể\n";
                $response .= "• Hỏi về học phí và ưu đãi\n";
                $response .= "• Gọi ngay: **{$this->centerInfo['hotline']}**\n";
                $response .= "• Hoặc đăng ký học thử miễn phí!";
                
                return $response;
            } else {
                return $this->getStaticCoursesAdvice();
            }
            
        } catch (Exception $e) {
            error_log("Get Courses Error: " . $e->getMessage());
            return $this->getStaticCoursesAdvice();
        }
    }
    
    /**
     * Detect user level from message
     */
    private function detectUserLevel($message) {
        $levels = [
            'mới' => ['mới', 'newbie', 'beginner', 'bắt đầu', 'chưa biết', 'cơ bản'],
            'trung cấp' => ['trung cấp', 'intermediate', 'trung bình', 'đã biết chút'],
            'nâng cao' => ['nâng cao', 'advanced', 'giỏi', 'thành thạo', 'fluent']
        ];
        
        foreach ($levels as $level => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $level;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Detect user interest from message
     */
    private function detectUserInterest($message) {
        $interests = [
            'giao tiếp' => ['giao tiếp', 'nói', 'speaking', 'communication'],
            'thi IELTS' => ['ielts', 'thi', 'exam', 'test'],
            'công việc' => ['công việc', 'work', 'business', 'office'],
            'du học' => ['du học', 'study abroad', 'overseas']
        ];
        
        foreach ($interests as $interest => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $interest;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Static courses advice (fallback)
     */
    private function getStaticCoursesAdvice() {
        return "📚 **Các khóa học phổ biến tại Fighter:**\n\n" .
               "**1. Tiếng Anh Giao Tiếp**\n" .
               "   📝 Học giao tiếp tự tin trong mọi tình huống\n" .
               "   ⏱️ Thời lượng: 40-60 buổi\n" .
               "   💰 Học phí: 2.500.000đ - 4.500.000đ\n" .
               "   ⭐⭐⭐⭐⭐ Đánh giá cao\n\n" .
               
               "**2. Luyện Thi IELTS**\n" .
               "   📝 Cam kết đầu ra 5.0 - 8.0+\n" .
               "   ⏱️ Thời lượng: 50-80 buổi\n" .
               "   💰 Học phí: 3.500.000đ - 6.500.000đ\n" .
               "   ⭐⭐⭐⭐⭐ Tỷ lệ đỗ cao\n\n" .
               
               "**3. Tiếng Anh Thiếu Nhi**\n" .
               "   📝 Cho trẻ 6-12 tuổi, vui học hiệu quả\n" .
               "   ⏱️ Thời lượng: 40-60 buổi\n" .
               "   💰 Học phí: 2.000.000đ - 3.500.000đ\n" .
               "   ⭐⭐⭐⭐⭐ Phụ huynh tin tưởng\n\n" .
               
               "**4. Tiếng Anh Doanh Nghiệp**\n" .
               "   📝 Cho dân văn phòng, giao tiếp công sở\n" .
               "   ⏱️ Thời lượng: 40-50 buổi\n" .
               "   💰 Học phí: 3.000.000đ - 5.000.000đ\n" .
               "   ⭐⭐⭐⭐ Thực tế và hiệu quả\n\n" .
               
               "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
               "🎯 **Tìm khóa học phù hợp?**\n" .
               "📞 Gọi ngay: **{$this->centerInfo['hotline']}**\n" .
               "💬 Hoặc hỏi tôi thêm về từng khóa!";
    }
    
    // ========================================================================
    // FEE ADVICE (ENHANCED)
    // ========================================================================
    
    private function getFeeAdvice($message) {
        try {
            // Try to get specific course if mentioned
            $specificCourse = $this->extractCourseName($message);
            
            if ($specificCourse) {
                return $this->getSpecificCourseFee($specificCourse);
            }
            
            // Get all courses with fees
            $sql = "SELECT 
                        ten_khoahoc,
                        chi_phi,
                        thoi_gian,
                        danh_gia_tb
                    FROM khoahoc
                    ORDER BY chi_phi ASC";
            
            $result = $this->conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $response = "💰 **Bảng giá khóa học Fighter English Center:**\n\n";
                
                while ($course = $result->fetch_assoc()) {
                    $response .= "💵 **" . htmlspecialchars($course['ten_khoahoc']) . "**\n";
                    $response .= "   • Học phí: **" . number_format($course['chi_phi'], 0, ',', '.') . "đ**\n";
                    
                    if ($course['thoi_gian']) {
                        $buoiPerMonth = 12; // Estimate
                        $months = ceil($course['thoi_gian'] / $buoiPerMonth);
                        $feePerMonth = $course['chi_phi'] / $months;
                        $response .= "   • Trung bình: " . number_format($feePerMonth, 0, ',', '.') . "đ/tháng\n";
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
    
    /**
     * Extract course name from message
     */
    private function extractCourseName($message) {
        $courseKeywords = [
            'giao tiếp' => 'giao tiếp',
            'ielts' => 'ielts',
            'thiếu nhi' => 'thiếu nhi',
            'doanh nghiệp' => 'doanh nghiệp',
            'toeic' => 'toeic'
        ];
        
        foreach ($courseKeywords as $keyword => $courseName) {
            if (strpos($message, $keyword) !== false) {
                return $courseName;
            }
        }
        
        return null;
    }
    
    /**
     * Get specific course fee
     */
    private function getSpecificCourseFee($courseName) {
        try {
            $sql = "SELECT 
                        ten_khoahoc,
                        mo_ta,
                        chi_phi,
                        thoi_gian,
                        danh_gia_tb
                    FROM khoahoc
                    WHERE LOWER(ten_khoahoc) LIKE ?
                    LIMIT 1";
            
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%{$courseName}%";
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $course = $result->fetch_assoc();
                
                $response = "💰 **Học phí khóa " . htmlspecialchars($course['ten_khoahoc']) . ":**\n\n";
                
                if (!empty($course['mo_ta'])) {
                    $desc = strip_tags($course['mo_ta']);
                    $desc = mb_substr($desc, 0, 200);
                    $response .= "📝 " . htmlspecialchars($desc) . "...\n\n";
                }
                
                $response .= "💵 **Học phí:** " . number_format($course['chi_phi'], 0, ',', '.') . "đ\n";
                
                if ($course['thoi_gian']) {
                    $response .= "⏱️ **Thời lượng:** {$course['thoi_gian']} buổi học\n";
                    
                    $buoiPerMonth = 12;
                    $months = ceil($course['thoi_gian'] / $buoiPerMonth);
                    $feePerMonth = $course['chi_phi'] / $months;
                    $response .= "📅 **Trung bình:** " . number_format($feePerMonth, 0, ',', '.') . "đ/tháng ({$months} tháng)\n";
                }
                
                if ($course['danh_gia_tb'] > 0) {
                    $stars = str_repeat('⭐', floor($course['danh_gia_tb']));
                    $response .= "{$stars} **Đánh giá:** " . number_format($course['danh_gia_tb'], 1) . "/5\n";
                }
                
                $response .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= $this->getPromotionInfo();
                
                return $response;
            }
            
        } catch (Exception $e) {
            error_log("Get Specific Course Fee Error: " . $e->getMessage());
        }
        
        return $this->getStaticFeeAdvice();
    }
    
    /**
     * Static fee advice (fallback)
     */
    private function getStaticFeeAdvice() {
        return "💰 **Bảng giá khóa học Fighter:**\n\n" .
               "💵 **Tiếng Anh Giao Tiếp:**\n" .
               "   • Cơ bản: 2.500.000đ (3 tháng)\n" .
               "   • Trung cấp: 3.500.000đ (4 tháng)\n" .
               "   • Nâng cao: 4.500.000đ (6 tháng)\n\n" .
               
               "💵 **IELTS:**\n" .
               "   • IELTS 5.0-6.0: 3.500.000đ (4 tháng)\n" .
               "   • IELTS 6.5-7.5: 5.500.000đ (6 tháng)\n" .
               "   • IELTS 8.0+: 6.500.000đ (8 tháng)\n\n" .
               
               "💵 **Tiếng Anh Thiếu Nhi:**\n" .
               "   • Starter (6-8 tuổi): 2.000.000đ (4 tháng)\n" .
               "   • Elementary (9-10 tuổi): 2.500.000đ (5 tháng)\n" .
               "   • Intermediate (11-12 tuổi): 3.500.000đ (6 tháng)\n\n" .
               
               "💵 **Tiếng Anh Doanh Nghiệp:**\n" .
               "   • Business Basic: 3.000.000đ (4 tháng)\n" .
               "   • Business Advanced: 5.000.000đ (6 tháng)\n\n" .
               
               "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
               $this->getPromotionInfo();
    }
    
    // ========================================================================
    // PROMOTION INFO
    // ========================================================================
    
    private function getPromotionInfo() {
        return "🎁 **Ưu đãi đặc biệt:**\n" .
               "   ✅ Giảm 20% học phí cho học viên mới\n" .
               "   ✅ Tặng 2 buổi học thử miễn phí\n" .
               "   ✅ Miễn phí tài liệu học tập (sách + online)\n" .
               "   ✅ Cam kết đầu ra hoặc học lại miễn phí\n" .
               "   ✅ Hỗ trợ trả góp 0% lãi suất\n\n" .
               "📞 **Đăng ký ngay: {$this->centerInfo['hotline']}** để nhận ưu đãi!";
    }
    
    // ========================================================================
    // SCHEDULE ADVICE (ENHANCED)
    // ========================================================================
    
    private function getScheduleAdvice($message) {
        try {
            // Get classes with schedules
            $sql = "SELECT 
                        lh.ten_lop,
                        k.ten_khoahoc,
                        lh.trang_thai,
                        lh.so_luong_hoc_vien,
                        gv.ten_giangvien,
                        GROUP_CONCAT(
                            CONCAT(
                                DATE_FORMAT(lich.ngay_hoc, '%d/%m/%Y'), ' ',
                                TIME_FORMAT(lich.gio_bat_dau, '%H:%i'), '-',
                                TIME_FORMAT(lich.gio_ket_thuc, '%H:%i')
                            ) SEPARATOR ', '
                        ) as lich_hoc
                    FROM lop_hoc lh
                    INNER JOIN khoahoc k ON lh.id_khoahoc = k.id_khoahoc
                    LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien
                    LEFT JOIN lichhoc lich ON lh.id_lop = lich.id_lop
                    WHERE lh.trang_thai = 'dang hoc'
                    GROUP BY lh.id_lop
                    ORDER BY k.ten_khoahoc, lh.ten_lop
                    LIMIT 5";
            
            $result = $this->conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $response = "⏰ **Lịch học các lớp đang mở tại Fighter:**\n\n";
                
                while ($class = $result->fetch_assoc()) {
                    $response .= "📚 **" . htmlspecialchars($class['ten_lop']) . "**\n";
                    $response .= "   • Khóa: " . htmlspecialchars($class['ten_khoahoc']) . "\n";
                    
                    if ($class['ten_giangvien']) {
                        $response .= "   • Giảng viên: " . htmlspecialchars($class['ten_giangvien']) . "\n";
                    }
                    
                    if ($class['lich_hoc']) {
                        $schedules = explode(', ', $class['lich_hoc']);
                        $response .= "   • Lịch học:\n";
                        foreach (array_slice($schedules, 0, 3) as $schedule) {
                            $response .= "     - {$schedule}\n";
                        }
                        if (count($schedules) > 3) {
                            $response .= "     - (và " . (count($schedules) - 3) . " buổi khác...)\n";
                        }
                    }
                    
                    $response .= "   • Sĩ số: {$class['so_luong_hoc_vien']} học viên\n\n";
                }
                
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= $this->getGeneralScheduleInfo();
                
                return $response;
            } else {
                return $this->getStaticScheduleAdvice();
            }
            
        } catch (Exception $e) {
            error_log("Get Schedule Error: " . $e->getMessage());
            return $this->getStaticScheduleAdvice();
        }
    }
    
    /**
     * General schedule information
     */
    private function getGeneralScheduleInfo() {
        return "🕐 **Các ca học linh hoạt:**\n" .
               "   • **Sáng:** 8:00-11:00 (Thứ 2, 4, 6)\n" .
               "   • **Chiều:** 14:00-17:00 (Thứ 3, 5, 7)\n" .
               "   • **Tối:** 19:00-21:00 (Thứ 2-7)\n" .
               "   • **Cuối tuần:** 8:00-12:00, 14:00-18:00\n\n" .
               "💡 **Lưu ý:** Lịch học linh hoạt theo yêu cầu học viên!\n\n" .
               "📞 **Liên hệ {$this->centerInfo['hotline']}** để sắp xếp lịch phù hợp!";
    }
    
    /**
     * Static schedule advice (fallback)
     */
    private function getStaticScheduleAdvice() {
        return "⏰ **Lịch học linh hoạt tại Fighter:**\n\n" .
               "🕐 **Ca học trong ngày:**\n" .
               "   • **Sáng:** 8:00-11:00 (Thứ 2, 4, 6)\n" .
               "   • **Chiều:** 14:00-17:00 (Thứ 3, 5, 7)\n" .
               "   • **Tối:** 19:00-21:00 (Thứ 2-7)\n\n" .
               
               "📅 **Các lịch học phổ biến:**\n" .
               "   • **Lịch 1:** Thứ 2, 4, 6 (Sáng/Tối)\n" .
               "   • **Lịch 2:** Thứ 3, 5, 7 (Chiều/Tối)\n" .
               "   • **Cuối tuần:** Thứ 7, CN (8h-12h, 14h-18h)\n" .
               "   • **Lịch riêng:** Sắp xếp theo yêu cầu (nhóm 3-5 người)\n\n" .
               
               "✨ **Đặc biệt:**\n" .
               "   • Học bù linh hoạt khi vắng\n" .
               "   • Chuyển ca học miễn phí\n" .
               "   • Học online và offline kết hợp\n\n" .
               
               "📞 **Liên hệ {$this->centerInfo['hotline']}** để đăng ký lịch phù hợp!";
    }
    
    // ========================================================================
    // CONTACT ADVICE
    // ========================================================================
    
    private function getContactAdvice() {
        return "📞 **Thông tin liên hệ Fighter English Center:**\n\n" .
               
               "🏢 **Địa chỉ:**\n" .
               "   {$this->centerInfo['address']}\n\n" .
               
               "📱 **Hotline & Zalo:**\n" .
               "   • **Tư vấn:** {$this->centerInfo['hotline']}\n" .
               "   • **Hỗ trợ:** {$this->centerInfo['support']}\n\n" .
               
               "📧 **Email:**\n" .
               "   {$this->centerInfo['email']}\n\n" .
               
               "🌐 **Website:**\n" .
               "   {$this->centerInfo['website']}\n\n" .
               
               "📘 **Mạng xã hội:**\n" .
               "   • Facebook: {$this->centerInfo['facebook']}\n" .
               "   • Instagram: {$this->centerInfo['instagram']}\n\n" .
               
               "⏰ **Giờ làm việc:**\n" .
               "   • Thứ 2 - Thứ 6: 8:00 - 21:00\n" .
               "   • Thứ 7 - Chủ nhật: 8:00 - 18:00\n\n" .
               
               "💬 **Hoặc chat trực tiếp với tôi - tôi luôn sẵn sàng 24/7!**";
    }
    
    // ========================================================================
    // REGISTRATION ADVICE
    // ========================================================================
    
    private function getRegistrationAdvice() {
        return "📝 **Đăng ký học tại Fighter - Dễ dàng & Nhanh chóng!**\n\n" .
               
               "🎯 **3 Bước đăng ký:**\n\n" .
               
               "**Bước 1: Tư vấn & Test đầu vào**\n" .
               "   • Gọi hotline: **{$this->centerInfo['hotline']}**\n" .
               "   • Hoặc chat với tôi để được tư vấn\n" .
               "   • Làm bài test xác định trình độ (miễn phí)\n\n" .
               
               "**Bước 2: Học thử MIỄN PHÍ**\n" .
               "   • Trải nghiệm 2 buổi học thực tế\n" .
               "   • Tìm hiểu phương pháp giảng dạy\n" .
               "   • Gặp gỡ giảng viên và lớp học\n\n" .
               
               "**Bước 3: Nhập học chính thức**\n" .
               "   • Chọn khóa học & lịch phù hợp\n" .
               "   • Thanh toán linh hoạt (tiền mặt/chuyển khoản/trả góp)\n" .
               "   • Nhận tài liệu và bắt đầu học ngay!\n\n" .
               
               "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
               
               "🎁 **Ưu đãi khi đăng ký hôm nay:**\n" .
               "   ✅ Giảm 20% học phí (chỉ còn " . number_format(2500000 * 0.8, 0, ',', '.') . "đ)\n" .
               "   ✅ Tặng tài liệu VIP + Tài khoản học online\n" .
               "   ✅ Miễn phí 2 buổi học thử\n" .
               "   ✅ Cam kết đầu ra hoặc học lại miễn phí\n" .
               "   ✅ Hỗ trợ trả góp 0% lãi suất\n\n" .
               
               "📞 **Đăng ký ngay: {$this->centerInfo['hotline']}**\n" .
               "💬 **Hoặc hỏi tôi thêm chi tiết về quy trình đăng ký!**";
    }
    
    // ========================================================================
    // TEACHER INFO
    // ========================================================================
    
    private function getTeacherInfo($message) {
        try {
            $sql = "SELECT 
                        gv.ten_giangvien,
                        gv.mo_ta,
                        gv.email,
                        COUNT(DISTINCT lh.id_lop) as so_lop,
                        SUM(lh.so_luong_hoc_vien) as tong_hoc_vien
                    FROM giangvien gv
                    LEFT JOIN lop_hoc lh ON gv.id_giangvien = lh.id_giangvien
                    GROUP BY gv.id_giangvien
                    HAVING so_lop > 0
                    ORDER BY so_lop DESC, tong_hoc_vien DESC
                    LIMIT 5";
            
            $result = $this->conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $response = "👨‍🏫 **Đội ngũ giảng viên Fighter:**\n\n";
                
                while ($teacher = $result->fetch_assoc()) {
                    $response .= "🎓 **" . htmlspecialchars($teacher['ten_giangvien']) . "**\n";
                    
                    if (!empty($teacher['mo_ta'])) {
                        $desc = strip_tags($teacher['mo_ta']);
                        $desc = mb_substr($desc, 0, 150);
                        $response .= "   📝 " . htmlspecialchars($desc) . "...\n";
                    }
                    
                    $response .= "   • Đang dạy: {$teacher['so_lop']} lớp\n";
                    $response .= "   • Tổng học viên: {$teacher['tong_hoc_vien']} người\n\n";
                }
                
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= "✨ **Đặc điểm giảng viên Fighter:**\n";
                $response .= "   • 100% giảng viên bản ngữ hoặc IELTS 8.0+\n";
                $response .= "   • Kinh nghiệm giảng dạy 3-10 năm\n";
                $response .= "   • Phương pháp giảng dạy hiện đại, tương tác\n";
                $response .= "   • Tận tâm và nhiệt huyết với học viên\n\n";
                $response .= "📞 **Liên hệ {$this->centerInfo['hotline']}** để biết thêm!";
                
                return $response;
            }
            
        } catch (Exception $e) {
            error_log("Get Teacher Info Error: " . $e->getMessage());
        }
        
        return "👨‍🏫 **Đội ngũ giảng viên Fighter:**\n\n" .
               "✨ **Tiêu chuẩn tuyển chọn:**\n" .
               "   • 100% giảng viên bản ngữ hoặc IELTS 8.0+\n" .
               "   • Bằng cấp chuyên ngành Ngôn ngữ Anh\n" .
               "   • Chứng chỉ giảng dạy quốc tế (TESOL/CELTA)\n" .
               "   • Kinh nghiệm giảng dạy 3-10 năm\n\n" .
               
               "🎓 **Phong cách giảng dạy:**\n" .
               "   • Phương pháp giao tiếp tương tác\n" .
               "   • Sử dụng công nghệ hiện đại\n" .
               "   • Tập trung vào kỹ năng thực tế\n" .
               "   • Tận tâm hỗ trợ từng học viên\n\n" .
               
               "📞 **Đặt lịch gặp giảng viên: {$this->centerInfo['hotline']}**";
    }
    
    // ========================================================================
    // CLASS INFO
    // ========================================================================
    
    private function getClassInfo($message) {
        try {
            $sql = "SELECT 
                        lh.id_lop,
                        lh.ten_lop,
                        k.ten_khoahoc,
                        lh.so_luong_hoc_vien,
                        lh.trang_thai,
                        gv.ten_giangvien,
                        k.chi_phi
                    FROM lop_hoc lh
                    INNER JOIN khoahoc k ON lh.id_khoahoc = k.id_khoahoc
                    LEFT JOIN giangvien gv ON lh.id_giangvien = gv.id_giangvien
                    WHERE lh.trang_thai = 'dang hoc'
                    ORDER BY lh.id_lop DESC
                    LIMIT 8";
            
            $result = $this->conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $response = "📚 **Các lớp đang mở tại Fighter:**\n\n";
                
                while ($class = $result->fetch_assoc()) {
                    $response .= "🏫 **" . htmlspecialchars($class['ten_lop']) . "**\n";
                    $response .= "   • Khóa: " . htmlspecialchars($class['ten_khoahoc']) . "\n";
                    
                    if ($class['ten_giangvien']) {
                        $response .= "   • Giảng viên: " . htmlspecialchars($class['ten_giangvien']) . "\n";
                    }
                    
                    $response .= "   • Sĩ số: {$class['so_luong_hoc_vien']} học viên\n";
                    $response .= "   • Học phí: " . number_format($class['chi_phi'], 0, ',', '.') . "đ\n";
                    $response .= "   • Trạng thái: **Đang học** ✅\n\n";
                }
                
                $response .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                $response .= "📞 **Đăng ký lớp: {$this->centerInfo['hotline']}**\n";
                $response .= "💡 **Hoặc hỏi tôi về lớp cụ thể!**";
                
                return $response;
            }
            
        } catch (Exception $e) {
            error_log("Get Class Info Error: " . $e->getMessage());
        }
        
        return "📚 **Thông tin lớp học tại Fighter:**\n\n" .
               "🎯 **Đặc điểm lớp học:**\n" .
               "   • Sĩ số: 8-12 học viên/lớp\n" .
               "   • Thời lượng: 90-120 phút/buổi\n" .
               "   • Tần suất: 2-3 buổi/tuần\n" .
               "   • Phòng học: Hiện đại, điều hòa\n\n" .
               
               "✨ **Tiện ích:**\n" .
               "   • Wifi miễn phí\n" .
               "   • Tài liệu học tập đầy đủ\n" .
               "   • Máy chiếu, âm thanh hiện đại\n" .
               "   • Không gian học tập chuyên nghiệp\n\n" .
               
               "📞 **Đăng ký học: {$this->centerInfo['hotline']}**";
    }
}
?>
