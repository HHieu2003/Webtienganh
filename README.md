# 🎓 FIGHTER - Hệ Thống Quản Lý Khóa Học Tiếng Anh

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> **Hệ thống quản lý khóa học trực tuyến toàn diện** với tích hợp AI Chatbot, học tập thông minh và quản trị đa vai trò.

---

## 📋 Mục Lục

- [Giới Thiệu](#-giới-thiệu)
- [Tính Năng Chính](#-tính-năng-chính)
- [Công Nghệ Sử Dụng](#-công-nghệ-sử-dụng)
- [Cấu Trúc Dự Án](#-cấu-trúc-dự-án)
- [Cài Đặt](#-cài-đặt)
- [Cấu Hình](#-cấu-hình)
- [Hướng Dẫn Sử Dụng](#-hướng-dẫn-sử-dụng)
- [API Documentation](#-api-documentation)
- [Database Schema](#-database-schema)
- [Bảo Mật](#-bảo-mật)
- [Đóng Góp](#-đóng-góp)
- [License](#-license)

---

## 🌟 Giới Thiệu

**FIGHTER** là một hệ thống quản lý khóa học tiếng Anh hiện đại, tích hợp trí tuệ nhân tạo (Gemini AI) và các tính năng học tập thông minh. Hệ thống phục vụ 3 vai trò chính:

- **👨‍🎓 Học viên**: Đăng ký khóa học, học tập, làm bài test, theo dõi tiến độ
- **👨‍🏫 Giảng viên**: Quản lý lớp học, điểm danh, chấm bài, thông báo
- **👨‍💼 Quản trị viên**: Quản lý toàn bộ hệ thống, thống kê, báo cáo

---

## ✨ Tính Năng Chính

### 🎯 Cho Học Viên

#### 📚 Quản Lý Học Tập
- ✅ Đăng ký khóa học trực tuyến
- ✅ Xem lịch học cá nhân
- ✅ Theo dõi tiến độ học tập
- ✅ Xem điểm số và kết quả test
- ✅ Tải xuống học liệu

#### 🤖 Học Tập Thông Minh (AI-Powered)
- ✅ **Chatbot AI Fighter**: Hỗ trợ tư vấn 24/7 với Gemini AI
- ✅ **8 Kỹ Năng Tiếng Anh**:
  - 📖 Reading (Đọc hiểu)
  - ✍️ Writing (Viết)
  - 🎧 Listening (Nghe)
  - 🗣️ Speaking (Nói)
  - 📝 Grammar (Ngữ pháp)
  - 📚 Vocabulary (Từ vựng)
  - 🗨️ Communication (Giao tiếp)
  - 🎤 Pronunciation (Phát âm)

#### 📊 Bài Test & Đánh Giá
- ✅ Làm bài test trực tuyến
- ✅ Chấm điểm tự động
- ✅ Lịch sử làm bài
- ✅ Phân tích kết quả

#### 📱 Tính Năng Khác
- ✅ Dashboard cá nhân
- ✅ Thông báo real-time
- ✅ Blog học tập
- ✅ Bình luận & tương tác

### 👨‍🏫 Cho Giảng Viên

#### 📋 Quản Lý Lớp Học
- ✅ Xem danh sách lớp được phân công
- ✅ Điểm danh học viên
- ✅ Quản lý lịch giảng dạy

#### ✏️ Quản Lý Bài Test
- ✅ Tạo đề thi/câu hỏi
- ✅ Quản lý đề thi theo khóa học
- ✅ Xem kết quả học viên
- ✅ Phân tích thống kê điểm

#### 📢 Giao Tiếp
- ✅ Gửi thông báo tới học viên
- ✅ Nhận phản hồi từ học viên
- ✅ Dashboard thống kê

### 👨‍💼 Cho Quản Trị Viên

#### 👥 Quản Lý Người Dùng
- ✅ Quản lý học viên
- ✅ Quản lý giảng viên
- ✅ Phân quyền tài khoản

#### 📚 Quản Lý Đào Tạo
- ✅ **Khóa học**: CRUD, phân cấp độ (A1-C2)
- ✅ **Lớp học**: Tạo lớp, phân công giảng viên
- ✅ **Học liệu**: Upload tài liệu (PDF, DOC, PPT, video)
- ✅ **Câu hỏi & Test**: Ngân hàng câu hỏi

#### 💼 Quản Lý Vận Hành
- ✅ Xác nhận đăng ký khóa học
- ✅ Quản lý lịch sử thanh toán
- ✅ Gửi thông báo hàng loạt
- ✅ Quản lý bài viết blog

#### 📊 Thống Kê & Báo Cáo
- ✅ Dashboard tổng quan
- ✅ Báo cáo doanh thu
- ✅ Thống kê đăng ký
- ✅ Lượt truy cập website
- ✅ Xuất Excel/PDF

### 🎨 Giao Diện & UX

#### 🌈 Thiết Kế Hiện Đại
- ✅ **Responsive Design**: Tối ưu cho mobile, tablet, desktop
- ✅ **Brand Color**: Green theme (#0db33b)
- ✅ **Smooth Animations**: Fade-in, slide-in effects
- ✅ **Custom Scrollbar**: Thiết kế độc đáo
- ✅ **Dark Mode Ready**: Hỗ trợ chế độ tối

#### 📱 Mobile-First
- ✅ Touch-friendly controls
- ✅ Hamburger menu
- ✅ Swipe gestures
- ✅ Optimized loading

#### ♿ Accessibility
- ✅ ARIA labels
- ✅ Keyboard navigation
- ✅ Screen reader support
- ✅ High contrast mode

---

## 🛠 Công Nghệ Sử Dụng

### Backend

| Công Nghệ | Version | Mô Tả |
|-----------|---------|-------|
| **PHP** | 7.4+ | Server-side scripting |
| **MySQL** | 5.7+ | Relational database |
| **PHPMailer** | 6.x | Email sending |
| **Gemini AI** | 2.0 | AI chatbot & learning |

### Frontend

| Công Nghệ | Version | Mô Tả |
|-----------|---------|-------|
| **HTML5** | - | Markup language |
| **CSS3** | - | Styling |
| **JavaScript** | ES6+ | Client-side scripting |
| **Bootstrap** | 5.3.3 | CSS framework |
| **jQuery** | 3.x | JavaScript library |
| **Font Awesome** | 6.5.1 | Icon library |
| **SweetAlert2** | 11.x | Beautiful alerts |
| **Chart.js** | 4.x | Data visualization |
| **CKEditor** | 4.22.1 | Rich text editor |
| **AOS** | 3.x | Scroll animations |

### DevOps & Tools

| Tool | Mô Tả |
|------|-------|
| **XAMPP** | Local development environment |
| **Git** | Version control |
| **Composer** | PHP dependency manager |

---

## 📁 Cấu Trúc Dự Án

```
dahp2/
│
├── 📂 admin/                     # Khu vực quản trị
│   ├── admin.php                 # Entry point admin
│   ├── css/
│   │   └── admin.css            # Admin styles (700+ lines)
│   ├── modules/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── menu.php             # Admin menu
│   │   ├── home.php             # Dashboard
│   │   ├── hocvien/             # Quản lý học viên
│   │   │   └── manage_students.php
│   │   ├── giangvien/           # Quản lý giảng viên
│   │   │   └── manage_lecturers.php
│   │   ├── khoahoc/             # Quản lý khóa học
│   │   │   ├── manage_courses.php
│   │   │   ├── add_course.php
│   │   │   └── edit_course.php
│   │   ├── lichhoc/             # Quản lý lớp học
│   │   │   ├── lophoc/
│   │   │   ├── diemdanh/
│   │   │   └── diemso/
│   │   ├── hoclieu/             # Quản lý học liệu
│   │   │   └── manage_hoclieu.php
│   │   ├── cauhoi/              # Ngân hàng câu hỏi
│   │   │   └── question.php
│   │   ├── xacnhandangky/       # Xác nhận đăng ký
│   │   │   └── dangkykhoahoc.php
│   │   ├── lichsuthanhtoan/     # Lịch sử thanh toán
│   │   │   └── lichsu_thanhtoan.php
│   │   ├── thongbao/            # Quản lý thông báo
│   │   │   └── thongbao.php
│   │   ├── baiviet/             # Quản lý bài viết
│   │   │   └── manage_posts.php
│   │   ├── thongke/             # Thống kê
│   │   │   └── baocao.php
│   │   └── teacher/             # Khu vực giảng viên
│   │       ├── teacher_menu.php
│   │       ├── teacher_home.php
│   │       ├── teacher_classes.php
│   │       ├── teacher_tests.php
│   │       ├── teacher_schedule.php
│   │       └── teacher_notifications.php
│   └── uploads/                 # Upload files
│
├── 📂 chatbot/                   # AI Chatbot System
│   ├── ChatbotService.php       # Core chatbot service (1030 lines)
│   ├── chatbot_handler.php      # API handler
│   ├── chatbot_widget.php       # Widget UI
│   ├── chatbot.css              # Chatbot styles (800+ lines)
│   ├── chatbot.js               # Frontend logic (900+ lines)
│   ├── database_advisor.php     # DB context gathering
│   └── config.php               # Chatbot configuration
│
├── 📂 config/                    # Cấu hình hệ thống
│   ├── config.php               # Database connection
│   ├── sendmail.php             # Email configuration
│   └── PHPMailer/               # Email library
│
├── 📂 pages/                     # Trang công khai
│   ├── main.php                 # Router chính
│   ├── header.php               # Header template
│   ├── footer.php               # Footer template
│   ├── login.php                # Đăng nhập
│   ├── register.php             # Đăng ký
│   ├── forgot-password.php      # Quên mật khẩu
│   ├── reset-password.php       # Đặt lại mật khẩu
│   ├── verify.php               # Xác thực email
│   ├── main/                    # Các trang chính
│   │   ├── banner.php
│   │   ├── about.php
│   │   ├── khoahoc.php          # Danh sách khóa học
│   │   ├── course_detail.php   # Chi tiết khóa học
│   │   ├── dangkykhoahoc.php   # Đăng ký khóa học
│   │   ├── blog.php
│   │   ├── blog_single.php
│   │   ├── contact.php
│   │   └── lecturers.php        # Giảng viên
│   ├── hoccungai/               # AI Learning Hub
│   │   ├── hoccungai_complete.php
│   │   ├── reading_api.php
│   │   ├── writing_api.php
│   │   ├── listening_api.php
│   │   ├── speaking_api.php
│   │   ├── grammar_api.php
│   │   ├── vocabulary_api.php
│   │   ├── communication_api.php
│   │   ├── pronunciation_api.php
│   │   └── ai_audio.php
│   └── question/                # Hệ thống test
│       ├── question.php
│       └── dapan.php
│
├── 📂 user/                      # Khu vực học viên
│   ├── dashboard.php            # Dashboard học viên
│   ├── header_user.php
│   ├── user.css
│   └── modules/
│       ├── home.php
│       ├── courses.php
│       ├── schedule.php
│       ├── tests.php
│       ├── results.php
│       ├── materials.php
│       ├── notifications.php
│       └── profile.php
│
├── 📂 css/                       # Global styles
│   ├── style.css                # Main stylesheet
│   └── icon/
│       └── fontawesome-free-6.4.2-web/
│
├── 📂 images/                    # Hình ảnh
│   ├── logo.png
│   ├── banner/
│   ├── courses/
│   └── lecturers/
│
├── 📂 uploads/                   # User uploads
│   ├── materials/               # Học liệu
│   ├── posts/                   # Bài viết
│   └── lecturers/               # Ảnh giảng viên
│
├── 📄 index.php                  # Entry point
├── 📄 quanlykhoahoc.sql         # Database schema
├── 📄 README.md                 # This file
└── 📄 .gitignore                # Git ignore

```

---

## 💿 Cài Đặt

### Yêu Cầu Hệ Thống

- **PHP**: >= 7.4
- **MySQL**: >= 5.7
- **Web Server**: Apache 2.4+ (XAMPP recommended)
- **Extensions**: 
  - mysqli
  - pdo
  - json
  - mbstring
  - curl

### Các Bước Cài Đặt

#### 1️⃣ Clone Repository

```bash
# Clone project
git clone https://github.com/HHieu2003/Webtienganh.git

# Di chuyển vào thư mục
cd Webtienganh
```

#### 2️⃣ Cài Đặt XAMPP

1. Tải XAMPP từ [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Cài đặt XAMPP
3. Copy project vào `C:\xampp\htdocs\dahp2`

#### 3️⃣ Tạo Database

```sql
-- Mở phpMyAdmin (http://localhost/phpmyadmin)
-- Tạo database mới
CREATE DATABASE quanlykhoahoc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Import file SQL
-- Chọn database 'quanlykhoahoc'
-- Import file: quanlykhoahoc.sql
```

#### 4️⃣ Cấu Hình Database

Mở file `config/config.php` và cập nhật thông tin:

```php
<?php
$conn = mysqli_connect("localhost", "root", "", "quanlykhoahoc");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
mysqli_query($conn, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
?>
```

#### 5️⃣ Cấu Hình Gemini AI

Mở file `chatbot/config.php` và thêm API key:

```php
define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY_HERE');
```

Lấy API key tại: [https://makersuite.google.com/app/apikey](https://makersuite.google.com/app/apikey)

#### 6️⃣ Cấu Hình Email (Optional)

Mở file `config/sendmail.php`:

```php
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
```

#### 7️⃣ Khởi Động Server

```bash
# Mở XAMPP Control Panel
# Start Apache
# Start MySQL

# Truy cập website
http://localhost/dahp2
```

---

## ⚙️ Cấu Hình

### Tài Khoản Mặc Định

#### Admin
- **Email**: `admin@fighter.com`
- **Password**: `admin123`

#### Giảng Viên
- **Email**: `teacher@fighter.com`
- **Password**: `teacher123`

#### Học Viên
- **Email**: `student@fighter.com`
- **Password**: `student123`

### Cấu Hình Nâng Cao

#### Upload File Limits

Chỉnh sửa `php.ini`:

```ini
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
memory_limit = 256M
```

#### Session Timeout

Trong `config/config.php`:

```php
ini_set('session.gc_maxlifetime', 3600); // 1 hour
session_set_cookie_params(3600);
```

---

## 📖 Hướng Dẫn Sử Dụng

### Cho Học Viên

1. **Đăng ký tài khoản**
   - Truy cập `/pages/register.php`
   - Điền thông tin cá nhân
   - Xác thực email

2. **Đăng ký khóa học**
   - Xem danh sách khóa học
   - Chọn khóa học phù hợp
   - Điền form đăng ký
   - Chờ admin xác nhận

3. **Học tập**
   - Xem lịch học
   - Tải học liệu
   - Làm bài test
   - Chat với AI

### Cho Giảng Viên

1. **Đăng nhập**
   - Sử dụng tài khoản được cấp
   - Truy cập dashboard giảng viên

2. **Quản lý lớp học**
   - Xem lớp được phân công
   - Điểm danh học viên
   - Upload học liệu

3. **Tạo bài test**
   - Vào menu "Câu hỏi & Test"
   - Tạo câu hỏi
   - Gán vào đề thi

### Cho Admin

1. **Quản lý khóa học**
   - Tạo khóa học mới
   - Phân cấp độ (A1-C2)
   - Upload ảnh đại diện

2. **Tạo lớp học**
   - Chọn khóa học
   - Phân công giảng viên
   - Đặt lịch học

3. **Xác nhận đăng ký**
   - Vào "Xác nhận đăng ký"
   - Kiểm tra thông tin
   - Xác nhận/Từ chối

---

## 📝 Changelog

### Version 2.0.0 (2025-10-26)

#### ✨ New Features
- AI Chatbot với Gemini API
- 8 kỹ năng học tiếng Anh với AI
- Responsive design toàn bộ hệ thống
- Custom scrollbar cho admin menu
- Dark mode ready
- Pagination cho tất cả tables (10 items/page)

#### 🎨 UI/UX Improvements
- Green theme (#0db33b)
- Smooth animations
- Better mobile experience
- Enhanced accessibility

#### 🐛 Bug Fixes
- Fixed session timeout issues
- Corrected SQL injection vulnerabilities
- Fixed email sending errors
- Improved error handling

#### 🔧 Technical Updates
- Upgraded to Bootstrap 5.3.3
- Updated CKEditor to 4.22.1
- Migrated to PHP 7.4+
- Database optimization with indexes

### Version 1.0.0 (2024-XX-XX)
- Initial release
- Basic course management
- User registration & login
- Admin dashboard

---

## 📞 Liên Hệ & Hỗ Trợ

### Thông Tin Liên Hệ

- **Website**: [http://localhost/dahp2](http://localhost/dahp2)
- **Email**: support@fighter.com
- **GitHub**: [https://github.com/HHieu2003/Webtienganh](https://github.com/HHieu2003/Webtienganh)

### Báo Lỗi

Nếu bạn phát hiện lỗi, vui lòng:
1. Kiểm tra [Issues](https://github.com/HHieu2003/Webtienganh/issues) xem đã có ai báo chưa
2. Nếu chưa, tạo issue mới với:
   - Mô tả lỗi chi tiết
   - Các bước tái hiện
   - Screenshots (nếu có)
   - Môi trường (OS, PHP version, etc.)

### Hỗ Trợ Kỹ Thuật

Cần trợ giúp? Có nhiều cách:
- 📧 Email: tech-support@fighter.com
- 💬 Discord: [Join our server](#)
- 📖 Documentation: [Read the docs](#)

---

---

## 🙏 Acknowledgments

### Contributors

- **Hữu Hiếu** - *Lead Developer* - [HHieu2003](https://github.com/HHieu2003)

### Libraries & Tools

- [Bootstrap](https://getbootstrap.com/) - Frontend framework
- [Font Awesome](https://fontawesome.com/) - Icon library
- [Chart.js](https://www.chartjs.org/) - Charts
- [SweetAlert2](https://sweetalert2.github.io/) - Beautiful alerts
- [CKEditor](https://ckeditor.com/) - Rich text editor
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) - Email sending
- [Google Gemini](https://ai.google.dev/) - AI chatbot

### Inspiration

Dự án được lấy cảm hứng từ các hệ thống LMS (Learning Management System) hiện đại như Moodle, Canvas, và các nền tảng học tiếng Anh như Duolingo, ELSA Speak.

---

## 🗺️ Roadmap

### Q1 2025
- [ ] Mobile app (React Native)
- [ ] Payment gateway integration
- [ ] Video conferencing (Zoom/Jitsi)
- [ ] Certificate generation

### Q2 2025
- [ ] Advanced analytics dashboard
- [ ] Gamification features
- [ ] Social learning features
- [ ] Multi-language support

### Q3 2025
- [ ] AI-powered adaptive learning
- [ ] Voice recognition for speaking tests
- [ ] Augmented Reality (AR) lessons
- [ ] Blockchain certificates

### Long-term Vision
- Global expansion
- AI teacher assistant
- Virtual classroom (VR)
- Personalized learning paths

---

## ❓ FAQ

### Câu Hỏi Thường Gặp

#### 1. Làm thế nào để thay đổi logo?
Thay thế file `images/logo.png` bằng logo của bạn (khuyến nghị 200x60px, PNG với nền trong suốt).

#### 2. Làm sao để thêm cấp độ khóa học mới?
Sửa enum trong table `khoahoc`:
```sql
ALTER TABLE khoahoc MODIFY cap_do ENUM('A1','A2','B1','B2','C1','C2','Advanced');
```

#### 3. Tôi quên mật khẩu admin, làm sao?
Reset trực tiếp trong database:
```sql
UPDATE hocvien SET mat_khau = '$2y$10$...' WHERE email = 'admin@fighter.com';
-- Hoặc tạo password mới với password_hash()
```

#### 4. Làm thế nào để backup database?
```bash
# Export
mysqldump -u root quanlykhoahoc > backup.sql

# Import
mysql -u root quanlykhoahoc < backup.sql
```

#### 5. Website chạy chậm, làm sao tối ưu?
- Enable caching
- Optimize images
- Add database indexes
- Use CDN
- Enable gzip compression

---

## 📚 Tài Liệu Bổ Sung

### Hướng Dẫn Chi Tiết

- [📖 User Guide](docs/USER_GUIDE.md) - Hướng dẫn cho người dùng
- [👨‍💻 Developer Guide](docs/DEVELOPER_GUIDE.md) - Hướng dẫn cho developer
- [🎨 Design System](docs/DESIGN_SYSTEM.md) - Thiết kế UI/UX
- [🔌 API Reference](docs/API_REFERENCE.md) - Tài liệu API

### Video Tutorials

- [🎥 Installation Guide](https://youtube.com/...)
- [🎥 Admin Tutorial](https://youtube.com/...)
- [🎥 Teacher Tutorial](https://youtube.com/...)
- [🎥 Student Tutorial](https://youtube.com/...)

---

<div align="center">

**Made with ❤️ by FIGHTER Team**

⭐ Star us on GitHub — it motivates us a lot!

[Report Bug](https://github.com/HHieu2003/Webtienganh/issues) · [Request Feature](https://github.com/HHieu2003/Webtienganh/issues) · [Documentation](#)

</div>

---

**Last Updated**: October 26, 2025  
**Version**: 2.0.0  
**Status**: 🟢 Active Development
