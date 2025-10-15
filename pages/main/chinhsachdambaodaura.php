
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    line-height: 1.6;
    color: #333;
    background-color: #f8f9fa;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}


.logo {
    font-size: 28px;
    font-weight: bold;
    letter-spacing: 1px;
}

/* Hero Section */
.hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0 60px;
    text-align: center;
}

.main-title {
    font-size: 42px;
    margin-bottom: 20px;
    font-weight: 700;
    animation: fadeInUp 0.8s ease;
}

.subtitle {
    font-size: 20px;
    opacity: 0.95;
    animation: fadeInUp 1s ease;
}

/* Key Factors */
.key-factors {
    padding: 60px 0;
    background: white;
}

.factors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.factor-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.factor-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.factor-card .icon {
    font-size: 50px;
    margin-bottom: 20px;
}

.factor-card h3 {
    font-size: 22px;
    font-weight: 600;
}

/* Commitments Section */
.commitments {
    padding: 80px 0;
    background: #f8f9fa;
}

.commitment-item {
    display: flex;
    gap: 30px;
    margin-bottom: 50px;
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.commitment-item:hover {
    transform: translateX(10px);
}

.commitment-number {
    flex-shrink: 0;
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: bold;
}

.commitment-content h2 {
    color: #667eea;
    margin-bottom: 15px;
    font-size: 26px;
}

.commitment-content p {
    font-size: 17px;
    color: #555;
    line-height: 1.8;
}

/* Features Section */
.features {
    padding: 60px 0;
    background: white;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: #667eea;
    color: white;
    transform: scale(1.03);
}

.feature-icon {
    flex-shrink: 0;
    width: 30px;
    height: 30px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.feature-item:hover .feature-icon {
    background: white;
    color: #667eea;
}

/* EMPOWER Section */
.empower-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-header h2 {
    font-size: 38px;
    margin-bottom: 10px;
}

.tagline {
    font-size: 22px;
    margin-bottom: 30px;
    opacity: 0.95;
}

.method-title {
    font-size: 28px;
    margin-bottom: 15px;
    letter-spacing: 2px;
}

.method-desc {
    font-size: 18px;
    opacity: 0.9;
    max-width: 800px;
    margin: 0 auto;
}

.empower-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.empower-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 35px;
    border-radius: 15px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.empower-card:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.empower-letter {
    width: 60px;
    height: 60px;
    background: white;
    color: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 20px;
}

.empower-card h4 {
    font-size: 24px;
    margin-bottom: 15px;
}

.empower-card p {
    font-size: 16px;
    line-height: 1.7;
}

/* Locations Section */
.locations {
    padding: 80px 0;
    background: white;
}

.locations-title {
    text-align: center;
    font-size: 32px;
    margin-bottom: 50px;
    color: #667eea;
}

.locations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.location-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 35px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.location-card:hover {
    transform: translateY(-10px);
}

.location-card h5 {
    font-size: 22px;
    margin-bottom: 15px;
    font-weight: 600;
}

.location-card p {
    font-size: 16px;
    line-height: 1.6;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeInUp 0.8s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-title {
        font-size: 32px;
    }
    
    .subtitle {
        font-size: 18px;
    }
    
    .commitment-item {
        flex-direction: column;
        text-align: center;
    }
    
    .commitment-number {
        margin: 0 auto 20px;
    }
    
    .section-header h2 {
        font-size: 28px;
    }
    
    .locations-title {
        font-size: 24px;
    }
}

@media (max-width: 480px) {
    .main-title {
        font-size: 26px;
    }
    
    .factors-grid,
    .empower-grid,
    .locations-grid {
        grid-template-columns: 1fr;
    }
}

</style>
    

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="main-title fade-in">Chính sách đảm bảo đầu ra tại Fighter</h1>
            <p class="subtitle">Đối với Fighter English, 3 yếu tố quan trọng luôn được đặt lên hàng đầu:</p>
        </div>
    </section>

    <!-- Three Key Factors -->
    <section class="key-factors">
        <div class="container">
            <div class="factors-grid">
                <div class="factor-card" data-aos="fade-up">
                    <div class="icon">📊</div>
                    <h3>Đảm bảo điểm số cam kết</h3>
                </div>
                <div class="factor-card" data-aos="fade-up" data-delay="100">
                    <div class="icon">⏰</div>
                    <h3>Đúng thời hạn</h3>
                </div>
                <div class="factor-card" data-aos="fade-up" data-delay="200">
                    <div class="icon">🌍</div>
                    <h3>Ứng dụng ngôn ngữ vào thực tế</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Commitments Section -->
    <section class="commitments">
        <div class="container">
            <div class="commitment-item">
                <div class="commitment-number">1</div>
                <div class="commitment-content">
                    <h2>Cam kết điểm số IELTS bằng hợp đồng</h2>
                    <p><strong>Điểm số IELTS tại Fighter được cam kết bằng hợp đồng</strong>, theo đúng lộ trình và lượng kiến thức học viên đã học. Mọi rủi ro trong quá trình học và kết quả thi thực tế của học viên đều được Fighter dự trù và quản trị, can thiệp kịp thời giúp học viên đạt kết quả mong muốn.</p>
                </div>
            </div>

            <div class="commitment-item">
                <div class="commitment-number">2</div>
                <div class="commitment-content">
                    <h2>Cam kết đúng thời hạn</h2>
                    <p>Fighter <strong>đảm bảo 100% thời gian cam kết ban đầu</strong>, không kéo dài thời lượng, đảm bảo học viên theo kịp lộ trình để xét tuyển đại học, xét tốt nghiệp, du học, làm hồ sơ cao học, định cư nước ngoài, … như mong muốn.</p>
                </div>
            </div>

            <div class="commitment-item">
                <div class="commitment-number">3</div>
                <div class="commitment-content">
                    <h2>Cam kết ứng dụng được ngôn ngữ trong thực tế</h2>
                    <p>Với phương châm <strong>"Học là phải dùng được"</strong>, kết hợp với phương pháp E.M.P.O.W.E.R, Fighter luôn hướng tới học viên có thể ứng dụng kiến thức ngôn ngữ trong quá trình học tập, làm việc và trong đời sống. Khác với việc "cam kết điểm số" bằng cách chỉ tập trung dạy mẹo làm bài, Fighter đề cao năng lực sử dụng ngôn ngữ trong và ngoài lớp học.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <p>Đầu vào luôn được xác định chính xác.</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <p>Kho bài tập thực hành và luyện đề trên LMS Fighter.</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <p>Kiểm tra định kỳ giữa khoá, cuối kỳ để theo sát thực tế năng lực của học viên.</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <p>Đội ngũ giáo viên, trợ giảng và nhân viên luôn sẵn sàng hỗ trợ.</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <p>Phương pháp giảng dạy đặc biệt, <strong>phát huy điểm mạnh – cải thiện điểm yếu của từng học viên</strong>.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- EMPOWER Method -->
    <section class="empower-section">
        <div class="container">
            <div class="section-header">
                <h2>Phương pháp giảng dạy tại Fighter</h2>
                <p class="tagline">Đúng phương pháp – Trúng mục tiêu</p>
                <h3 class="method-title">PHƯƠNG PHÁP HỌC HIỆN ĐẠI E.M.P.O.W.E.R</h3>
                <p class="method-desc">Trong tất cả các khóa học, học viên luôn là trung tâm, là ưu tiên hàng đầu trong mọi bài dạy.</p>
            </div>

            <div class="empower-grid">
                <div class="empower-card">
                    <div class="empower-letter">E</div>
                    <h4>Engage</h4>
                    <p>Kích thích sự tò mò thông qua <strong>Guided Discovery</strong> và phương pháp học <strong>tương tác</strong>.</p>
                </div>

                <div class="empower-card">
                    <div class="empower-letter">M</div>
                    <h4>Motivate</h4>
                    <p>Thúc đẩy <strong>tính tự chủ</strong> của người học bằng hướng dẫn có cấu trúc.</p>
                </div>

                <div class="empower-card">
                    <div class="empower-letter">P</div>
                    <h4>Practice</h4>
                    <p>Củng cố kiến thức qua <strong>luyện tập nhiều lần</strong> và <strong>tự chỉnh sửa</strong>.</p>
                </div>

                <div class="empower-card">
                    <div class="empower-letter">O</div>
                    <h4>Optimize</h4>
                    <p>Tối ưu hóa hiệu quả học tập với <strong>công nghệ và thực hành</strong> (LMS, phòng máy).</p>
                </div>

                <div class="empower-card">
                    <div class="empower-letter">W</div>
                    <h4>Widen</h4>
                    <p>Mở rộng tư duy với <strong>học tập qua khám phá và phản biện.</strong></p>
                </div>

                <div class="empower-card">
                    <div class="empower-letter">E</div>
                    <h4>Evaluate</h4>
                    <p>Tăng cường <strong>tự đánh giá, phản hồi nhóm</strong>, và <strong>nhận xét lớp học chung cả lớp.</strong></p>
                </div>

                <div class="empower-card">
                    <div class="empower-letter">R</div>
                    <h4>Reflect</h4>
                    <p>Giúp học viên <strong>phân tích tiến bộ</strong> và cải thiện kỹ năng liên tục.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Locations Section -->
    <section class="locations">
        <div class="container">
            <h2 class="locations-title">Gặp chúng mình ở Cơ sở Fighter gần bạn nhất nhé!</h2>
            <div class="locations-grid">
                <div class="location-card">
                    <h5>Quận Phú Nhuận</h5>
                    <p>70 Hoa Cúc, P. 7, Phú Nhuận</p>
                </div>
                <div class="location-card">
                    <h5>Quận Gò Vấp</h5>
                    <p>664 Lê Quang Định, P. 1, Gò Vấp</p>
                </div>
                <div class="location-card">
                    <h5>Quận 10</h5>
                    <p>769 Lê Hồng Phong, P. 12, Q. 10</p>
                </div>
                <div class="location-card">
                    <h5>Quận Tân Phú</h5>
                    <p>53 Gò Dầu, P. Tân Quý, Tân Phú</p>
                </div>
            </div>
        </div>
    </section>

   
<script>
    // Smooth scroll for anchor links
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

// Intersection Observer for scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
            
            // Add staggered animation for cards
            const delay = entry.target.dataset.delay || 0;
            entry.target.style.animationDelay = `${delay}ms`;
        }
    });
}, observerOptions);

// Observe elements for animation
document.addEventListener('DOMContentLoaded', () => {
    // Animate commitment items
    const commitmentItems = document.querySelectorAll('.commitment-item');
    commitmentItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-50px)';
        item.style.transition = 'all 0.6s ease';
        
        observer.observe(item);
        
        item.classList.add('animate-in');
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 200);
    });

    // Animate EMPOWER cards
    const empowerCards = document.querySelectorAll('.empower-card');
    empowerCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        
        observer.observe(card);
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Animate location cards
    const locationCards = document.querySelectorAll('.location-card');
    locationCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';
        card.style.transition = 'all 0.5s ease';
        
        observer.observe(card);
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }, index * 150);
    });

    // Animate feature items
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        item.style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 100);
    });
});

// Add parallax effect to hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    
    if (hero) {
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Counter animation for numbers
function animateNumber(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Add hover effect sound (optional - commented out)
// document.querySelectorAll('.factor-card, .empower-card, .location-card').forEach(card => {
//     card.addEventListener('mouseenter', () => {
//         // Add sound effect here if needed
//     });
// });

// Mobile menu toggle (if you add navigation later)
function toggleMobileMenu() {
    const menu = document.querySelector('.mobile-menu');
    if (menu) {
        menu.classList.toggle('active');
    }
}

// Lazy loading images (if you add images)
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Add scroll-to-top button functionality
const scrollToTopBtn = document.createElement('button');
scrollToTopBtn.innerHTML = '↑';
scrollToTopBtn.className = 'scroll-to-top';
scrollToTopBtn.style.cssText = `
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-size: 24px;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1000;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
`;

document.body.appendChild(scrollToTopBtn);

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollToTopBtn.style.opacity = '1';
    } else {
        scrollToTopBtn.style.opacity = '0';
    }
});

scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Add active state to cards on click
document.querySelectorAll('.factor-card, .empower-card, .location-card').forEach(card => {
    card.addEventListener('click', function() {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    });
});

console.log('Fighter English website loaded successfully! 🎓');

</script>