# 🚀 HƯỚNG DẪN CÀI ĐẶT NHANH

## Bước 1: Cấu hình Gemini API Key

1. Truy cập: https://makersuite.google.com/app/apikey
2. Tạo API key mới (miễn phí)
3. Mở file `config.php` và thay đổi:

```php
define('GEMINI_API_KEY', 'API_KEY_CỦA_BẠN_Ở_ĐÂY');
```

## Bước 2: Kiểm tra cài đặt

1. Mở trình duyệt Chrome hoặc Edge
2. Truy cập: `http://localhost/dahp2/pages/hoccungai/test.html`
3. Nhấn các nút test để kiểm tra:
   - ✓ Config file
   - ✓ Gemini API
   - ✓ Speech Recognition
   - ✓ Text-to-Speech
   - ✓ Tất cả API endpoints

## Bước 3: Truy cập hệ thống

### Cách 1: Qua trang chủ
```
http://localhost/dahp2/index.php?page=hoccungai_complete
```

### Cách 2: Truy cập trực tiếp
```
http://localhost/dahp2/pages/hoccungai/hoccungai_complete.php
```

## Bước 4: Đăng nhập

- Cần đăng nhập với tài khoản học viên để sử dụng
- Nếu chưa có tài khoản, vui lòng đăng ký tại trang chủ

## Yêu cầu hệ thống

### Server
- ✅ PHP 7.4 trở lên
- ✅ MySQL
- ✅ Apache/Nginx
- ✅ Extension: curl, json, session

### Trình duyệt (Client)
- ✅ Chrome 80+ (khuyến nghị)
- ✅ Edge 80+
- ✅ Firefox 75+ (một số tính năng có thể không đầy đủ)

### Kết nối Internet
- ✅ Cần để gọi Gemini API
- ✅ Tốc độ khuyến nghị: 2Mbps trở lên

## Các tính năng chính

| Kỹ năng | Icon | Mô tả |
|---------|------|-------|
| 🎧 Listening | Headphones | Luyện nghe với audio AI |
| 🎤 Speaking | Microphone | Luyện nói với nhận dạng giọng |
| 📖 Reading | Book | Đọc hiểu với câu hỏi tự động |
| ✍️ Writing | Pen | Viết và nhận feedback AI |
| 📚 Vocabulary | Dictionary | Luyện từ vựng theo chủ đề |
| 📝 Grammar | Book | Ngữ pháp với giải thích chi tiết |
| 🔊 Pronunciation | Volume | Phát âm với so sánh chuẩn |
| 💬 Communication | Chat | Chatbot giao tiếp thực tế |

## Khắc phục sự cố

### 1. "Invalid CSRF token"
**Giải pháp:** Refresh trang (F5)

### 2. "Rate limit exceeded"
**Giải pháp:** Đợi 1 giờ hoặc tăng limit trong `config.php`:
```php
define('API_RATE_LIMIT', 200); // tăng lên 200
```

### 3. "Không nhận dạng được giọng nói"
**Nguyên nhân:** Trình duyệt không hỗ trợ hoặc chưa cho phép microphone

**Giải pháp:**
- Sử dụng Chrome hoặc Edge
- Vào Settings → Privacy → Microphone → Cho phép
- Kiểm tra icon microphone trên thanh địa chỉ

### 4. "Failed to generate exercise"
**Nguyên nhân:** API key không hợp lệ hoặc hết quota

**Giải pháp:**
- Kiểm tra API key trong `config.php`
- Truy cập https://makersuite.google.com để xem quota
- Tạo API key mới nếu cần

### 5. Database error
**Kiểm tra:**
- MySQL đang chạy
- Database `quanlykhoahoc` tồn tại
- User có quyền truy cập

## Tips sử dụng

### 💡 Mẹo 1: Tăng độ chính xác Speech Recognition
- Nói rõ ràng, từ tốc
- Sử dụng microphone tốt
- Giảm tiếng ồn xung quanh

### 💡 Mẹo 2: Viết bài hiệu quả
- Viết đủ số từ tối thiểu (50-100 từ)
- Sử dụng cấu trúc rõ ràng
- Kiểm tra chính tả trước khi submit

### 💡 Mẹo 3: Luyện tập đều đặn
- Mỗi ngày 15-30 phút
- Luân phiên các kỹ năng
- Xem lại feedback từ AI

### 💡 Mẹo 4: Tối ưu hiệu suất
- Đóng các tab không cần thiết
- Sử dụng kết nối internet ổn định
- Clear cache định kỳ

## Cấu trúc file đã tạo

```
hoccungai/
├── 📄 config.php              ← CẤU HÌNH CHÍNH (QUAN TRỌNG!)
├── 📄 api_handler.php         ← Xử lý API Gemini
├── 📄 hoccungai_complete.php  ← Trang chính
├── 📄 hoccungai_complete.css  ← Styling
├── 📄 hoccungai_complete.js   ← JavaScript
│
├── 🎧 listening_content_ui.php
├── 🎧 listening_api.php
│
├── 🎤 speaking_content_ui.php
├── 🎤 speaking_api.php
│
├── 📖 reading_content_ui.php
├── 📖 reading_api.php
│
├── ✍️ writing_content_ui.php
├── ✍️ writing_api.php
│
├── 📚 vocabulary_content_ui.php
├── 📚 vocabulary_api.php
│
├── 📝 grammar_content_ui.php
├── 📝 grammar_api.php
│
├── 🔊 pronunciation_content_ui.php
├── 🔊 pronunciation_api.php
│
├── 💬 communication_content_ui.php
├── 💬 communication_api.php
│
├── 📋 README.md               ← Tài liệu đầy đủ
├── 📋 INSTALL.md              ← File này
└── 🧪 test.html               ← Kiểm tra hệ thống
```

## Câu hỏi thường gặp

**Q: Có miễn phí không?**
A: Gemini API có gói miễn phí với giới hạn 60 requests/phút.

**Q: Có cần GPU không?**
A: Không. AI xử lý trên cloud của Google.

**Q: Có hoạt động offline không?**
A: Không. Cần internet để gọi Gemini API.

**Q: Có lưu lịch sử học tập không?**
A: Có, trong `progressTracker` (localStorage) và có thể mở rộng lưu vào database.

**Q: Có hỗ trợ di động không?**
A: Có, giao diện responsive. Tuy nhiên Speech Recognition chỉ tốt trên Chrome mobile.

## Liên hệ hỗ trợ

Nếu gặp vấn đề:
1. Kiểm tra browser console (F12)
2. Xem file log PHP
3. Test từng component riêng biệt
4. Đảm bảo tất cả file đã được tạo đúng

## Chúc bạn học tập hiệu quả! 🎓✨
