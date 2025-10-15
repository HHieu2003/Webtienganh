<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phương pháp E.M.P.O.W.E.R - Vietop English</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>

:root {
    --primary-color: #0066cc;
    --secondary-color: #ff6b35;
    --accent-color: #ffd700;
    --dark-color: #1a1a2e;
    --light-color: #f5f7fa;
    --white: #ffffff;
    --gray: #6c757d;
    --success: #28a745;
    --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

body {
    line-height: 1.6;
    color: var(--dark-color);
    overflow-x: hidden;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}


/* Hero Section */
.hero {
    background: var(--gradient-1);
    color: var(--white);
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.3;
}

.hero-content {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 3.2rem;
    margin-bottom: 1.5rem;
    animation: fadeInDown 1s;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.hero-subtitle {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    opacity: 0.95;
    font-weight: 600;
}

.hero-description {
    font-size: 1.15rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    line-height: 1.8;
}

.empower-badge {
    display: inline-block;
    background: var(--white);
    color: #667eea;
    padding: 1.5rem 4rem;
    font-size: 3rem;
    font-weight: 900;
    border-radius: 60px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    animation: pulse 2s infinite;
    letter-spacing: 3px;
}

.hero-note {
    margin-top: 2rem;
    font-size: 1.1rem;
    font-style: italic;
    opacity: 0.9;
}

/* Certified Section */
.certified {
    padding: 4rem 0;
    background: var(--light-color);
}

.certified-content {
    text-align: center;
}

.section-title {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 3rem;
    position: relative;
    line-height: 1.4;
}

.section-title::after {
    content: '';
    display: block;
    width: 120px;
    height: 4px;
    background: var(--accent-color);
    margin: 1.5rem auto;
    border-radius: 2px;
}

.certified-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.certified-item {
    background: var(--white);
    padding: 2.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s;
}

.certified-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.certified-item p {
    font-size: 1.05rem;
    line-height: 1.8;
}

/* Benefits Section */
.benefits {
    padding: 5rem 0;
    background: var(--white);
}

.section-subtitle {
    text-align: center;
    font-size: 1.2rem;
    max-width: 900px;
    margin: 0 auto 3rem;
    color: var(--gray);
}

.comparison-title {
    text-align: center;
    font-size: 2rem;
    color: var(--dark-color);
    margin: 4rem 0 1rem;
}

.comparison-subtitle {
    text-align: center;
    font-size: 1.1rem;
    color: var(--gray);
    margin-bottom: 3rem;
}

.comparison-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.comparison-card {
    background: var(--light-color);
    padding: 2rem;
    border-radius: 15px;
    border-left: 5px solid var(--primary-color);
    transition: all 0.3s;
}

.comparison-card:hover {
    transform: translateX(10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.old-way {
    color: var(--gray);
    font-size: 0.95rem;
    text-decoration: line-through;
    margin-bottom: 1rem;
}

.arrow {
    color: var(--secondary-color);
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0.5rem 0;
}

.new-way {
    color: var(--dark-color);
    font-size: 1.05rem;
    font-weight: 600;
    line-height: 1.6;
}

/* Skills Section */
.skills {
    padding: 5rem 0;
    background: var(--light-color);
}

.skill-card {
    background: var(--white);
    margin: 3rem 0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.skill-title {
    background: var(--gradient-1);
    color: var(--white);
    padding: 1.5rem 2rem;
    font-size: 1.8rem;
    font-weight: bold;
}

.skill-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 0;
}

.skill-column {
    padding: 2rem;
    border-right: 1px solid var(--light-color);
}

.skill-column:last-child {
    border-right: none;
}

.skill-column.highlight {
    background: linear-gradient(135deg, #f5f7fa 0%, #e3e8ee 100%);
}

.skill-column h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.skill-column ul {
    list-style: none;
    padding-left: 0;
}

.skill-column li {
    padding: 0.7rem 0 0.7rem 1.8rem;
    position: relative;
    font-size: 0.95rem;
    line-height: 1.6;
}

.skill-column li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--success);
    font-weight: bold;
    font-size: 1.2rem;
}

/* Career Skills Section */
.career-skills {
    padding: 5rem 0;
    background: var(--white);
}

.career-table {
    margin-top: 3rem;
    overflow-x: auto;
}

.career-table table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border-radius: 15px;
    overflow: hidden;
}

.career-table thead {
    background: var(--gradient-1);
    color: var(--white);
}

.career-table th {
    padding: 1.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 1.05rem;
}

.career-table td {
    padding: 1.5rem;
    border-bottom: 1px solid var(--light-color);
    font-size: 0.95rem;
    line-height: 1.7;
}

.career-table tbody tr:hover {
    background: var(--light-color);
}

.career-table strong {
    color: var(--primary-color);
}

/* Class Experience Section */
.class-experience {
    padding: 4rem 0;
    background: var(--light-color);
    text-align: center;
}

.class-description {
    max-width: 900px;
    margin: 1.5rem auto;
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--gray);
}

/* Success Stories Section */
.success-stories {
    padding: 5rem 0;
    background: var(--gradient-2);
    color: var(--white);
}

.success-stories .section-title {
    color: var(--white);
}

.success-stories .section-title::after {
    background: var(--white);
}

.success-stories .section-subtitle {
    color: rgba(255,255,255,0.95);
}

.testimonials {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.testimonial-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    padding: 2.5rem;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.3s;
}

.testimonial-card:hover {
    transform: translateY(-10px);
    background: rgba(255,255,255,0.25);
}

.testimonial-card h4 {
    font-size: 1.4rem;
    margin-bottom: 1rem;
    color: var(--white);
}

.testimonial-card p {
    font-size: 1.05rem;
    line-height: 1.7;
    opacity: 0.95;
}

/* FAQ Section */
.faq {
    padding: 5rem 0;
    background: var(--light-color);
}

.faq-list {
    max-width: 900px;
    margin: 3rem auto;
}

.faq-item {
    background: var(--white);
    margin-bottom: 1.5rem;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

.faq-question {
    padding: 1.5rem 2rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--white);
    transition: background 0.3s;
}

.faq-question:hover {
    background: var(--light-color);
}

.faq-question h4 {
    font-size: 1.1rem;
    color: var(--dark-color);
}

.faq-icon {
    font-size: 2rem;
    color: var(--primary-color);
    font-weight: bold;
    transition: transform 0.3s;
}

.faq-item.active .faq-icon {
    transform: rotate(45deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    padding: 0 2rem;
}

.faq-item.active .faq-answer {
    max-height: 500px;
    padding: 1.5rem 2rem;
}

.faq-answer ul {
    list-style: none;
    padding-left: 0;
}

.faq-answer li {
    padding: 0.5rem 0 0.5rem 1.5rem;
    position: relative;
}

.faq-answer li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--primary-color);
    font-size: 1.5rem;
}

/* CTA Section */
.cta {
    padding: 5rem 0;
    background: var(--gradient-1);
    color: var(--white);
    text-align: center;
}

.cta h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.cta p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.95;
}

.btn-cta {
    padding: 1rem 3rem;
    background: var(--white);
    color: var(--primary-color);
    border: none;
    border-radius: 50px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.btn-cta:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}


/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hamburger {
        display: flex;
    }
    
   
    .hero-title {
        font-size: 2.2rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .empower-badge {
        font-size: 2rem;
        padding: 1rem 2.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .skill-content {
        grid-template-columns: 1fr;
    }
    
    .skill-column {
        border-right: none;
        border-bottom: 1px solid var(--light-color);
    }
    
    .skill-column:last-child {
        border-bottom: none;
    }
    
    .career-table {
        font-size: 0.85rem;
    }
    
    .comparison-grid {
        grid-template-columns: 1fr;
    }
    
    .testimonials {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .container {
        padding: 0 15px;
    }
    
    .empower-badge {
        font-size: 1.5rem;
        padding: 0.8rem 2rem;
        letter-spacing: 2px;
    }
    
    .section-title {
        font-size: 1.6rem;
    }
}

</style>
<body>
    

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">TRAO QUYỀN & KHAI PHÓNG TIỀM NĂNG</h1>
                <p class="hero-subtitle">Phương pháp học tiếng Anh, IELTS độc quyền tại Vietop</p>
                <p class="hero-description">Giúp bạn chủ động khám phá, luyện – sửa – luyện lại, nhận feedback liên tục và tiến bộ từng buổi. Học để thực sự làm được, không chỉ để thi.</p>
                <div class="hero-badge">
                    <div class="empower-badge">E.M.P.O.W.E.R®</div>
                </div>
                <p class="hero-note">Niềm tin từ học viên. Sự công nhận từ đối tác.</p>
            </div>
        </div>
    </section>

    <!-- Certified Section -->
    <section class="certified">
        <div class="container">
            <div class="certified-content">
                <h2 class="section-title">E.M.P.O.W.E.R® – Phương pháp học Tiếng Anh, IELTS độc quyền bởi Vietop được công nhận Sở Hữu Trí Tuệ</h2>
                <div class="certified-grid">
                    <div class="certified-item">
                        <p><strong>Phát triển bởi đội ngũ giáo viên IELTS 8.0+</strong>, E.M.P.O.W.E.R® ra đời để giải quyết những khó khăn cốt lõi của người học Việt: học thụ động, dễ quên kiến thức, thiếu tự tin khi đi thi.</p>
                    </div>
                    <div class="certified-item">
                        <p><strong>Ứng dụng toàn diện vào 4 kỹ năng</strong>, từ Nghe – Nói – Đọc – Viết, giúp học viên học chủ động, thực hành nhiều vòng, nhận feedback liên tục và tiến bộ từng buổi.</p>
                    </div>
                    <div class="certified-item">
                        <p>Là thành quả nghiên cứu và áp dụng tại Vietop trong nhiều năm, E.M.P.O.W.E.R® đã giúp hàng ngàn học viên bứt phá band điểm, đồng thời được chính thức công nhận <strong>Sở hữu trí tuệ tại Việt Nam</strong> – khẳng định giá trị khác biệt và tính khoa học của phương pháp.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits" id="uu-diem">
        <div class="container">
            <h2 class="section-title">Những ưu điểm vượt trội của E.M.P.O.W.E.R®</h2>
            <p class="section-subtitle">Không còn thụ động ghi chép. <strong>E.M.P.O.W.E.R®</strong> giúp bạn tự khám phá, thực hành, nhận feedback tức thì và thấy rõ sự tiến bộ sau mỗi lần học.</p>
            
            <h3 class="comparison-title">Cách học truyền thống được thay thế bởi phương pháp E.M.P.O.W.E.R® như thế nào?</h3>
            <p class="comparison-subtitle">Phương pháp 8 bước chủ động: Khám phá – Luyện tập – Phản hồi – Tiến bộ rõ rệt sau từng buổi học.</p>

            <div class="comparison-grid">
                <div class="comparison-card">
                    <div class="old-way">Thầy giảng – trò chép</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Học viên chủ động khám phá, tham gia xây dựng bài học 😊</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Ít hoặc không có tương tác</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Tương tác cao qua thảo luận, thực hành liên tục 😘</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Học rập khuôn theo giáo trình cố định</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Học linh hoạt có định hướng, phù hợp từng cá nhân 😍</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Bài tập máy móc, ít thử lại</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Luyện nhiều vòng, tự sửa lỗi và cải thiện dần 😄</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Ít hoặc không ứng dụng công nghệ</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Ứng dụng LMS, Moore, phòng máy chuẩn thi thật 😎</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Chỉ ghi nhớ, lặp lại – Thiếu phản biện</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Đặt câu hỏi, tranh luận, phát triển tư duy phản biện 😊</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Đánh giá dựa trên điểm số cuối kỳ</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Feedback liên tục, tự đánh giá và đánh giá chéo 🙂</div>
                </div>
                <div class="comparison-card">
                    <div class="old-way">Học thụ động, khó tự cải thiện</div>
                    <div class="arrow">→</div>
                    <div class="new-way">Phản tư, điều chỉnh phương pháp học theo tiến bộ bản thân 🤩</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="skills" id="ky-nang">
        <div class="container">
            <h2 class="section-title">E.M.P.O.W.E.R® – Một phương pháp, toàn diện 4 kỹ năng</h2>
            
            <!-- Vocabulary -->
            <div class="skill-card">
                <h3 class="skill-title">Vocabulary (Từ vựng)</h3>
                <div class="skill-content">
                    <div class="skill-column">
                        <h4>Vấn đề</h4>
                        <ul>
                            <li>Vốn từ ít, chỉ biết từ cơ bản.</li>
                            <li>Nhanh quên, khó dùng đúng ngữ cảnh.</li>
                        </ul>
                    </div>
                    <div class="skill-column highlight">
                        <h4>E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Học từ qua hình ảnh, video và tình huống thực tế.</li>
                            <li>LMS + Luyện 4 kỹ năng → Gặp lại từ nhiều lần.</li>
                            <li>Dùng từ trong bài nghe/đọc và áp dụng ngay vào nói/viết.</li>
                        </ul>
                    </div>
                    <div class="skill-column">
                        <h4>Kết quả</h4>
                        <ul>
                            <li>Tăng nhanh vốn từ và nhớ lâu hơn.</li>
                            <li>Biết áp dụng từ đúng ngữ cảnh.</li>
                            <li>Tự tin dùng lại Từ vựng trong giao tiếp và bài thi.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Grammar -->
            <div class="skill-card">
                <h3 class="skill-title">Grammar (Ngữ pháp)</h3>
                <div class="skill-content">
                    <div class="skill-column">
                        <h4>Vấn đề</h4>
                        <ul>
                            <li>Sai cấu trúc cơ bản.</li>
                            <li>Không nắm chắc quy tắc đơn giản.</li>
                        </ul>
                    </div>
                    <div class="skill-column highlight">
                        <h4>E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Khám phá quy tắc qua ví dụ thực tế.</li>
                            <li>Thực hành nhiều vòng trong và ngoài lớp.</li>
                            <li>LMS hỗ trợ luyện thêm + Đặt ngữ pháp vào tình huống Nghe – Nói – Đọc – Viết.</li>
                        </ul>
                    </div>
                    <div class="skill-column">
                        <h4>Kết quả</h4>
                        <ul>
                            <li>Hiểu và dùng đúng cấu trúc đơn giản.</li>
                            <li>Giảm lỗi ngữ pháp phổ biến.</li>
                            <li>Viết và nói câu rõ ràng, dễ hiểu.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Listening -->
            <div class="skill-card">
                <h3 class="skill-title">Listening (Nghe)</h3>
                <div class="skill-content">
                    <div class="skill-column">
                        <h4>Vấn đề</h4>
                        <ul>
                            <li>Từ vựng hạn chế, khó bắt ý chính.</li>
                            <li>Phát âm sai → nghe không chính xác.</li>
                            <li>Không hiểu thông tin nền khi nghe.</li>
                        </ul>
                    </div>
                    <div class="skill-column highlight">
                        <h4>E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Học từ, phát âm qua tình huống, hình ảnh và video trước khi nghe.</li>
                            <li>Thực hành nghe nhiều lần, được sửa lỗi ngay sau bài nghe.</li>
                            <li>LMS hỗ trợ luyện thêm ngoài lớp.</li>
                            <li>Nghe đa dạng tình huống, giọng nói thật (video, audio).</li>
                            <li>Phản chiếu sau mỗi lần nghe để nhận diện lỗi & khắc phục.</li>
                        </ul>
                    </div>
                    <div class="skill-column">
                        <h4>Kết quả</h4>
                        <ul>
                            <li>Hiểu được nội dung cơ bản của bài nghe → Tự tin hơn khi giao tiếp.</li>
                            <li>Có kiến thức nền để nắm bắt ngữ cảnh bài nghe.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Reading -->
            <div class="skill-card">
                <h3 class="skill-title">Reading (Đọc)</h3>
                <div class="skill-content">
                    <div class="skill-column">
                        <h4>Vấn đề</h4>
                        <ul>
                            <li>Thiếu từ vựng và kiến thức nền → đọc không hiểu.</li>
                            <li>Đọc chậm, dịch từng từ, không nắm ý tổng quát.</li>
                        </ul>
                    </div>
                    <div class="skill-column highlight">
                        <h4>E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Gợi hứng thú và xây nền trước khi đọc bằng hình ảnh, câu hỏi.</li>
                            <li>Học phương pháp đọc lấy ý chính và chi tiết.</li>
                            <li>Thực hành + Sửa lỗi sau mỗi bài đọc.</li>
                            <li>LMS hỗ trợ luyện thêm ngoài lớp.</li>
                            <li>Đọc chủ đề thực tế, mở rộng góc nhìn và thảo luận.</li>
                            <li>Phản chiếu mỗi buổi để nhận diện điểm mạnh và điểm cần cải thiện.</li>
                        </ul>
                    </div>
                    <div class="skill-column">
                        <h4>Kết quả</h4>
                        <ul>
                            <li>Cải thiện tốc độ đọc và hiểu trực tiếp bằng tiếng Anh.</li>
                            <li>Hiểu ý chính của các bài đọc ngắn, cơ bản.</li>
                            <li>Tích lũy kiến thức nền để nắm bắt ngữ cảnh bài đọc.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Writing -->
            <div class="skill-card">
                <h3 class="skill-title">Writing (Viết)</h3>
                <div class="skill-content">
                    <div class="skill-column">
                        <h4>Vấn đề</h4>
                        <ul>
                            <li>Viết sai ngữ pháp, cấu trúc câu chưa rõ.</li>
                            <li>Không hiểu đề, thiếu từ vựng diễn đạt.</li>
                        </ul>
                    </div>
                    <div class="skill-column highlight">
                        <h4>E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Xây bối cảnh rõ ràng trước khi viết.</li>
                            <li>Hướng dẫn từng bước: Viết câu đơn giản, bổ sung từ vựng.</li>
                            <li>Thực hành viết nhiều vòng, tự sửa trước khi GV feedback.</li>
                            <li>LMS hỗ trợ bài tập viết thêm ngoài lớp.</li>
                            <li>Viết về chủ đề thực tế để mở rộng góc nhìn.</li>
                            <li>Đánh giá quá trình: Tự đánh giá và đánh giá chéo.</li>
                            <li>Phản chiếu sau mỗi bài để nhận diện lỗi và cách cải thiện.</li>
                        </ul>
                    </div>
                    <div class="skill-column">
                        <h4>Kết quả</h4>
                        <ul>
                            <li>Viết câu rõ ý, đúng ngữ pháp.</li>
                            <li>Hiểu yêu cầu và viết đúng trọng tâm đề.</li>
                            <li>Tăng khả năng tự sửa lỗi, cải thiện theo feedback giáo viên.</li>
                            <li>Hình thành tư duy viết học thuật sớm.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Skills Section -->
    <section class="career-skills">
        <div class="container">
            <h2 class="section-title">Chìa khóa cho học tập & sự nghiệp</h2>
            <p class="section-subtitle">Không chỉ giúp chinh phục IELTS – Tiếng Anh, <strong>E.M.P.O.W.E.R®</strong> còn rèn luyện kỹ năng tự học, tư duy phản biện, giao tiếp và viết học thuật – những năng lực quan trọng trong học tập đại học và môi trường làm việc quốc tế.</p>
            
            <div class="career-table">
                <table>
                    <thead>
                        <tr>
                            <th>Năng lực phát triển</th>
                            <th>Ứng dụng trong học tập</th>
                            <th>Ứng dụng trong công việc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tư duy phản biện và năng lực đánh giá thông tin</strong><br>(Widen Perspectives)</td>
                            <td>Phân tích bài đọc, bài nghe. Nhận diện quan điểm, mâu thuẫn, thông tin sai lệch trong bài thi hoặc tài liệu học thuật.</td>
                            <td>Đánh giá báo cáo, dữ liệu, lập luận. Đưa ra quyết định có phân tích và phản biện khi làm việc nhóm hoặc ra chiến lược.</td>
                        </tr>
                        <tr>
                            <td><strong>Khả năng tự học và tự chủ tiến trình học tập</strong><br>(Engage, Motivate, Evaluate, Reflect)</td>
                            <td>Biết đặt mục tiêu học tập, sử dụng LMS và tài nguyên online để học thêm; tự sửa lỗi và theo dõi sự tiến bộ.</td>
                            <td>Chủ động học kỹ năng mới, làm việc độc lập, theo dõi tiến độ công việc. Không phụ thuộc quá nhiều vào cấp trên.</td>
                        </tr>
                        <tr>
                            <td><strong>Kỹ năng trình bày ý tưởng và thể hiện quan điểm cá nhân</strong><br>(Practice, Evaluate, Reflect)</td>
                            <td>Trình bày quan điểm trong bài viết học thuật hoặc bài nói; đưa ra ví dụ và lập luận rõ ràng.</td>
                            <td>Trình bày ý kiến trong cuộc họp, phản hồi hiệu quả, thuyết trình hoặc bảo vệ ý tưởng trong dự án.</td>
                        </tr>
                        <tr>
                            <td><strong>Mở rộng kiến thức xã hội và góc nhìn đa chiều</strong><br>(Widen Perspectives)</td>
                            <td>Nhận thức các vấn đề xã hội, môi trường, giáo dục, nghề nghiệp thông qua nội dung bài học.</td>
                            <td>Hiểu sự đa dạng trong môi trường làm việc, thích nghi với các góc nhìn khác nhau khi làm việc nhóm hoặc quốc tế.</td>
                        </tr>
                        <tr>
                            <td><strong>Tư duy phát triển – Growth mindset</strong><br>(Practice, Evaluate, Reflect)</td>
                            <td>Chấp nhận phản hồi, không sợ sai, xem lỗi là cơ hội học tập. Duy trì động lực học tập lâu dài.</td>
                            <td>Chủ động cải thiện kỹ năng, thử thách bản thân với vai trò mới, học từ thất bại và sẵn sàng thích nghi với thay đổi.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Class Experience Section -->
    <section class="class-experience">
        <div class="container">
            <h2 class="section-title">Một buổi học với E.M.P.O.W.E.R® diễn ra thế nào?</h2>
            <p class="class-description">Không còn "Nghe giảng – chép bài" như truyền thống, mỗi buổi học theo E.M.P.O.W.E.R® được thiết kế thành <strong>8 bước liên hoàn</strong>: Bắt đầu với phần Lead-in khơi gợi tò mò → Language Focus và Practice nhiều vòng → Exam Practice mô phỏng thi thật → Cuối buổi, học viên tự đánh giá & đánh giá chéo để nhìn rõ tiến bộ.</p>
            <p class="class-description">Nhờ vậy, học viên vừa được rèn kỹ năng, vừa được trao quyền chủ động trong việc học, sửa lỗi và cải thiện band điểm liên tục.</p>
        </div>
    </section>

    <!-- Success Stories Section -->
    <section class="success-stories" id="hoc-vien">
        <div class="container">
            <h2 class="section-title">Vietopies chinh phục IELTS cùng E.M.P.O.W.E.R®</h2>
            <p class="section-subtitle">Mỗi điểm số không chỉ là con số, mà là kết quả của hành trình kiên trì luyện – sửa – luyện lại theo đúng tinh thần <strong>E.M.P.O.W.E.R®</strong>. Với sự dẫn dắt từ giáo viên 8.0+ và môi trường học giàu tương tác, Vietopies đã tự tin làm chủ kỳ thi và đạt band điểm mơ ước.</p>
            
            <div class="testimonials">
                <div class="testimonial-card">
                    <h4>Nguyễn Anh Quốc</h4>
                    <p>Mỗi điểm số là 1 câu chuyện đầy nỗ lực. Với <strong>E.M.P.O.W.E.R®</strong>, học viên không chỉ học để thi, mà học để làm chủ.</p>
                </div>
                <div class="testimonial-card">
                    <h4>Trương Ngọc Hùng</h4>
                    <p>Từng buổi học là một lần được trao quyền: Tự khám phá, thực hành, tự sửa và thấy bản thân tiến bộ rõ rệt.</p>
                </div>
                <div class="testimonial-card">
                    <h4>Nguyễn Khánh Linh</h4>
                    <p>Phương pháp E.M.P.O.W.E.R® giúp tôi tự tin hơn trong việc sử dụng tiếng Anh và đạt điểm số mong muốn.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="container">
            <h2 class="section-title">Các câu hỏi thường gặp</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>E.M.P.O.W.E.R® khác gì với phương pháp học truyền thống?</h4>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <ul>
                            <li>Học viên <strong>chủ động khám phá</strong> thay vì thụ động nghe giảng.</li>
                            <li><strong>Thực hành – tự sửa – luyện lại nhiều vòng</strong> trong mỗi buổi học.</li>
                            <li><strong>Feedback liên tục</strong> từ giáo viên, bạn học & chính bản thân.</li>
                            <li>Ứng dụng <strong>LMS, Moore, phòng máy thi thử</strong> để học & kiểm tra như thi thật.</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Thời lượng thực hành trong một buổi học là bao nhiêu?</h4>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Trung bình <strong>60–70% thời lượng buổi học</strong> dành cho thực hành (thảo luận, luyện đề, sửa lỗi, phản chiếu). Không chỉ nghe giảng, học viên được "trao quyền" để tự học và làm chủ tiến bộ.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Có được thi thử để chuẩn bị cho kỳ thi thật không?</h4>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Có! Học viên được <strong>thi thử phòng máy mô phỏng 100% thi thật</strong>. Sau mỗi bài thi, <strong>nhận feedback chi tiết</strong> về điểm mạnh, điểm cần cải thiện & lộ trình ôn tập tiếp theo.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Học bao lâu thì đạt band điểm mục tiêu?</h4>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>👉 Trung bình <strong>4–6 tháng</strong>, tuỳ theo:</p>
                        <ul>
                            <li>Xuất phát điểm & tốc độ tiếp thu.</li>
                            <li>Thời lượng học (3 buổi/tuần hay 5 buổi/tuần).</li>
                            <li>Mức độ tự học & luyện tập thêm ngoài lớp.</li>
                        </ul>
                        <p><em>Học viên sẽ được kiểm tra đầu vào và nhận lộ trình cá nhân hoá cụ thể.</em></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Thi thử tại Vietop có mất phí không?</h4>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Thi thử tại Vietop English <strong>hoàn toàn miễn phí</strong>. Học viên được tham gia thi thử đầy đủ 4 kỹ năng IELTS, trải nghiệm kỳ thi IELTS chuẩn như thi THẬT, quy trình và đề thi đạt chuẩn IDP và BC, giúp học viên có được sự chuẩn bị tốt nhất trước khi thi IELTS.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Gặp gỡ đội ngũ Cố vấn học tập</h2>
            <p>Giúp bạn hiểu hơn về Vietop và giải đáp bất kỳ thắc mắc nào của bạn.</p>
            <button class="btn-cta">Bắt đầu chat</button>
        </div>
    </section>

</body>
</html>
<script>

// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// FAQ Accordion
const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    
    question.addEventListener('click', () => {
        // Close other items
        faqItems.forEach(otherItem => {
            if (otherItem !== item && otherItem.classList.contains('active')) {
                otherItem.classList.remove('active');
            }
        });
        
        // Toggle current item
        item.classList.toggle('active');
    });
});

// Scroll Animation Observer
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe skill cards
document.querySelectorAll('.skill-card').forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(50px)';
    card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
    observer.observe(card);
});

// Observe comparison cards
document.querySelectorAll('.comparison-card').forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = `opacity 0.5s ease ${index * 0.05}s, transform 0.5s ease ${index * 0.05}s`;
    observer.observe(card);
});

// Observe certified items
document.querySelectorAll('.certified-item').forEach((item, index) => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(30px)';
    item.style.transition = `opacity 0.6s ease ${index * 0.15}s, transform 0.6s ease ${index * 0.15}s`;
    observer.observe(item);
});

// Observe testimonial cards
document.querySelectorAll('.testimonial-card').forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateX(-30px)';
    card.style.transition = `opacity 0.6s ease ${index * 0.2}s, transform 0.6s ease ${index * 0.2}s`;
    observer.observe(card);
});

// Header scroll effect
let lastScroll = 0;
const header = document.querySelector('.header');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll <= 0) {
        header.style.boxShadow = '0 2px 15px rgba(0,0,0,0.1)';
        return;
    }
    
    if (currentScroll > lastScroll && currentScroll > 100) {
        // Scroll down
        header.style.transform = 'translateY(-100%)';
    } else {
        // Scroll up
        header.style.transform = 'translateY(0)';
        header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
    }
    
    lastScroll = currentScroll;
});

// Floating animation for EMPOWER badge
const empowerBadge = document.querySelector('.empower-badge');
if (empowerBadge) {
    let direction = 1;
    let position = 0;
    
    setInterval(() => {
        position += direction * 0.3;
        if (position > 8 || position < -8) {
            direction *= -1;
        }
        empowerBadge.style.transform = `translateY(${position}px)`;
    }, 50);
}

// Parallax effect for hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    
    if (hero && scrolled < window.innerHeight) {
        hero.style.transform = `translateY(${scrolled * 0.4}px)`;
        hero.style.opacity = 1 - (scrolled / window.innerHeight) * 0.5;
    }
});

// Table responsive scroll indicator
const careerTable = document.querySelector('.career-table');
if (careerTable) {
    careerTable.addEventListener('scroll', () => {
        if (careerTable.scrollLeft > 0) {
            careerTable.style.boxShadow = 'inset 10px 0 10px -10px rgba(0,0,0,0.2)';
        } else {
            careerTable.style.boxShadow = 'none';
        }
    });
}

// CTA Button click handler
const ctaBtn = document.querySelector('.btn-cta');
if (ctaBtn) {
    ctaBtn.addEventListener('click', () => {
        // Add your chat/contact logic here
        alert('Cảm ơn bạn quan tâm! Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.');
    });
}

// Add ripple effect to buttons
document.querySelectorAll('.btn-contact, .btn-cta').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add CSS for ripple effect dynamically
const style = document.createElement('style');
style.textContent = `
    .btn-contact, .btn-cta {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Console message
console.log('%c🎓 Vietop English - E.M.P.O.W.E.R®', 'color: #0066cc; font-size: 20px; font-weight: bold;');
console.log('%cPhương pháp học IELTS độc quyền - Trao quyền & Khai phóng tiềm năng', 'color: #ff6b35; font-size: 14px;');

// Load animation on page load
window.addEventListener('load', () => {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

</script>