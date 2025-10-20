# HỌC CÙNG AI - HỆ THỐNG HỌC TIẾNG ANH VỚI AI

## Tổng quan
Hệ thống học tiếng Anh toàn diện với 8 kỹ năng được hỗ trợ bởi Gemini AI:
- 🎧 **Listening** - Luyện nghe
- 🎤 **Speaking** - Luyện nói  
- 📖 **Reading** - Luyện đọc
- ✍️ **Writing** - Luyện viết
- 📚 **Vocabulary** - Từ vựng
- 📝 **Grammar** - Ngữ pháp
- 🔊 **Pronunciation** - Phát âm
- 💬 **Communication** - Giao tiếp

## Cấu trúc thư mục

```
hoccungai/
├── config.php                      # Cấu hình chính, API key, security
├── api_handler.php                 # Handler xử lý API Gemini chung
├── hoccungai_complete.php          # File giao diện chính
├── hoccungai_complete.css          # CSS cho giao diện
├── hoccungai_complete.js           # JavaScript xử lý tương tác
├── ai_audio.php                    # Xử lý audio (đã có sẵn)
│
├── listening_content_ui.php        # Giao diện Listening
├── listening_api.php               # API xử lý Listening
│
├── speaking_content_ui.php         # Giao diện Speaking
├── speaking_api.php                # API xử lý Speaking
│
├── reading_content_ui.php          # Giao diện Reading
├── reading_api.php                 # API xử lý Reading
│
├── writing_content_ui.php          # Giao diện Writing
├── writing_api.php                 # API xử lý Writing
│
├── vocabulary_content_ui.php       # Giao diện Vocabulary
├── vocabulary_api.php              # API xử lý Vocabulary
│
├── grammar_content_ui.php          # Giao diện Grammar
├── grammar_api.php                 # API xử lý Grammar
│
├── pronunciation_content_ui.php    # Giao diện Pronunciation
├── pronunciation_api.php           # API xử lý Pronunciation
│
├── communication_content_ui.php    # Giao diện Communication
└── communication_api.php           # API xử lý Communication
```

## Cài đặt

### 1. Cấu hình API Key

Mở file `config.php` và thay đổi API key của Gemini AI:

```php
define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY_HERE');
```

### 2. Cấu hình Database

File `hoccungai_complete.php` đã tích hợp với database của bạn qua:
```php
include('./config/config.php');
```

### 3. Quyền truy cập

Đảm bảo thư mục `uploads/audio/` có quyền ghi:
```bash
chmod 755 uploads/audio/
```

## Tính năng chính

### 1. **Listening (Nghe)**
- Tạo bài nghe tự động với AI
- Phát audio bằng Text-to-Speech
- Câu hỏi trắc nghiệm tự động
- Chấm điểm và phản hồi

### 2. **Speaking (Nói)**
- Ghi âm giọng nói qua trình duyệt
- Nhận dạng giọng nói (Speech Recognition)
- Đánh giá phát âm và độ trưng loát
- Phản hồi chi tiết từ AI

### 3. **Reading (Đọc)**
- Tạo đoạn văn đọc hiểu
- Câu hỏi comprehension
- Phân tích đáp án
- Giải thích chi tiết

### 4. **Writing (Viết)**
- Nhiều dạng bài: Essay, Email, Letter, Paragraph
- Kiểm tra ngữ pháp tự động
- Đánh giá theo nhiều tiêu chí
- Gợi ý cải thiện từ vựng

### 5. **Vocabulary (Từ vựng)**
- Bài tập đa dạng: Matching, Fill-blank, Synonym
- Chủ đề phong phú
- Lưu trữ tiến độ học tập

### 6. **Grammar (Ngữ pháp)**
- Các chủ đề ngữ pháp quan trọng
- Câu hỏi có giải thích
- Luyện tập theo cấp độ

### 7. **Pronunciation (Phát âm)**
- Luyện nguyên âm, phụ âm, trọng âm
- So sánh với phát âm chuẩn
- Phản hồi chi tiết

### 8. **Communication (Giao tiếp)**
- Chatbot AI tương tác
- Nhiều tình huống thực tế
- Đánh giá kỹ năng giao tiếp

## Công nghệ sử dụng

### Frontend
- **HTML5** - Cấu trúc
- **CSS3** - Styling với CSS Variables
- **JavaScript (ES6+)** - Xử lý logic
- **Web Speech API** - Nhận dạng giọng nói
- **SpeechSynthesis API** - Text-to-Speech

### Backend
- **PHP 7.4+** - Server-side processing
- **MySQL** - Database
- **Gemini AI API** - AI processing

### Security
- CSRF Token protection
- Input sanitization
- Rate limiting
- Session management

## API Endpoints

### Listening
- `POST listening_api.php?action=generate` - Tạo bài nghe
- `POST listening_api.php?action=check` - Chấm bài

### Speaking
- `POST speaking_api.php?action=get_question` - Lấy câu hỏi
- `POST speaking_api.php?action=analyze` - Phân tích câu trả lời

### Reading
- `POST reading_api.php?action=generate` - Tạo bài đọc
- `POST reading_api.php?action=check` - Chấm bài

### Writing
- `POST writing_api.php?action=get_prompt` - Lấy đề bài
- `POST writing_api.php?action=check` - Kiểm tra bài viết

### Vocabulary
- `POST vocabulary_api.php?action=generate` - Tạo bài tập
- `POST vocabulary_api.php?action=check` - Chấm bài

### Grammar
- `POST grammar_api.php?action=generate` - Tạo bài tập
- `POST grammar_api.php?action=check` - Chấm bài

### Pronunciation
- `POST pronunciation_api.php?action=get_word` - Lấy từ luyện tập
- `POST pronunciation_api.php?action=check` - Kiểm tra phát âm

### Communication
- `POST communication_api.php?action=start` - Bắt đầu hội thoại
- `POST communication_api.php?action=reply` - Trả lời tin nhắn
- `POST communication_api.php?action=feedback` - Lấy đánh giá

## Sử dụng

### Truy cập hệ thống
```
http://your-domain.com/index.php?page=hoccungai_complete
```

### Yêu cầu
- Đăng nhập với tài khoản học viên
- Trình duyệt hỗ trợ: Chrome, Edge, Firefox (mới nhất)
- Microphone (cho tính năng Speaking và Pronunciation)

## Tùy chỉnh

### Thay đổi màu sắc
Chỉnh sửa CSS variables trong `hoccungai_complete.css`:
```css
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    /* ... */
}
```

### Thay đổi rate limit
Trong `config.php`:
```php
define('API_RATE_LIMIT', 100); // requests per hour
```

### Thêm chủ đề mới
Chỉnh sửa các select options trong file `*_content_ui.php`

## Xử lý lỗi thường gặp

### 1. "Invalid CSRF token"
- Refresh trang để lấy token mới
- Kiểm tra session có hoạt động không

### 2. "Rate limit exceeded"
- Đợi 1 giờ hoặc tăng rate limit trong config

### 3. "Trình duyệt không hỗ trợ nhận dạng giọng nói"
- Sử dụng Chrome hoặc Edge
- Cho phép truy cập microphone

### 4. Gemini API error
- Kiểm tra API key
- Kiểm tra quota của API
- Xem log lỗi trong browser console

## Phát triển thêm

### Thêm kỹ năng mới
1. Tạo file `skillname_content_ui.php`
2. Tạo file `skillname_api.php`
3. Thêm tab trong `hoccungai_complete.php`
4. Include file UI trong main.php

### Tích hợp dịch vụ khác
- Google Cloud Speech-to-Text
- AWS Polly
- Azure Cognitive Services

## Performance

- **Caching**: Kết quả AI có thể cache để giảm API calls
- **Lazy loading**: Chỉ load nội dung khi chuyển tab
- **Debouncing**: Giảm số lần gọi API khi typing
- **Progressive enhancement**: Hoạt động cơ bản không cần JavaScript

## Bảo mật

- ✅ CSRF protection
- ✅ Input sanitization
- ✅ Rate limiting
- ✅ Session security
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention

## License

Copyright © 2024. All rights reserved.

## Hỗ trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra browser console
2. Kiểm tra PHP error log
3. Xác nhận API key hợp lệ
4. Kiểm tra kết nối database

## Tác giả

Phát triển bởi: AI Programming Expert
Phiên bản: 3.1
Ngày cập nhật: 2024
