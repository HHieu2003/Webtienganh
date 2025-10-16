<?php
// File: pages/main/binhluan.php
?>

<div class="testimonial-section-v3">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2 class="introduce-title">Học viên nói về Tiếng Anh Fighter</h2>
            <p class="section-subtitle">Niềm tự hào và là động lực lớn nhất của chúng tôi.</p>
        </div>
    </div>
    
    <div class="testimonial-slider-v3-container">
        <div class="testimonial-slider-v3">
            <div class="review-card-v3">
                <i class="fas fa-quote-right quote-icon-v3"></i>
                <p class="review-text-v3">"Khóa học rất thực tế và dễ hiểu. Giảng viên tận tâm và phương pháp học hiện đại đã giúp tôi tiến bộ vượt bậc."</p>
                <div class="review-author-v3">
                    <img src="https://i.pravatar.cc/100?u=duy" alt="Avatar">
                    <div class="author-info-v3">
                        <div class="name">Nguyễn Tiến Duy</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
            </div>
            <div class="review-card-v3">
                <i class="fas fa-quote-right quote-icon-v3"></i>
                <p class="review-text-v3">"Em đã hiểu được bản chất vấn đề thay vì chỉ học vẹt. Cảm ơn trung tâm đã tạo ra một khóa học chất lượng như vậy!"</p>
                <div class="review-author-v3">
                    <img src="https://i.pravatar.cc/100?u=ha" alt="Avatar">
                    <div class="author-info-v3">
                        <div class="name">Phạm Thu Hà</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
            </div>
             <div class="review-card-v3">
                <i class="fas fa-quote-right quote-icon-v3"></i>
                <p class="review-text-v3">"Các giảng viên dạy thực sự hay, dễ tiếp thu kiến thức, cảm ơn những khóa học chất lượng của các bạn TIẾNG ANH FIGHTER!"</p>
                <div class="review-author-v3">
                    <img src="https://i.pravatar.cc/100?u=thuong" alt="Avatar">
                    <div class="author-info-v3">
                        <div class="name">Nguyễn Ngọc Thương</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
            </div>
            <div class="review-card-v3">
                <i class="fas fa-quote-right quote-icon-v3"></i>
                <p class="review-text-v3">"Đáp án dễ hiểu, đầy đủ. TIẾNG ANH FIGHTER đã giúp tôi đạt kết quả như mong muốn!"</p>
                 <div class="review-author-v3">
                    <img src="https://i.pravatar.cc/100?u=lananh" alt="Avatar">
                    <div class="author-info-v3">
                        <div class="name">Lan Anh</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
            </div>
            <div class="review-card-v3">
                <i class="fas fa-quote-right quote-icon-v3"></i>
                <p class="review-text-v3">"Môi trường học tập thân thiện và chuyên nghiệp. Mình đã tự tin hơn rất nhiều trong giao tiếp tiếng Anh."</p>
                <div class="review-author-v3">
                    <img src="https://i.pravatar.cc/100?u=minh" alt="Avatar">
                    <div class="author-info-v3">
                        <div class="name">Trần Quang Minh</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ==========================================================
   CSS NÂNG CẤP CHO SECTION BÌNH LUẬN - V3.0
   ========================================================== */

/* --- Bố cục Section với nền trắng và họa tiết --- */
.testimonial-section-v3 {
    padding: 60px 0;
    position: relative;
    background-color: var(--neutral-white); /* Nền trắng */
    overflow: hidden;
}

.testimonial-section-v3::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: radial-gradient(var(--border-color, #e9ecef) 1px, transparent 1px);
    background-size: 20px 20px;
    opacity: 0.5;
    z-index: 0;
}

.testimonial-section-v3 .container,
.testimonial-section-v3 .testimonial-slider-v3-container {
    position: relative;
    z-index: 1;
}

/* --- Slider Container --- */
.testimonial-slider-v3-container {
    width: 100%;
    overflow: hidden;
    -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
}
.testimonial-slider-v3 {
    display: flex;
    width: max-content;
    animation: scroll-v3 45s linear infinite;
}
@keyframes scroll-v3 {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
}
.testimonial-slider-v3:hover {
    animation-play-state: paused;
}

/* --- Thiết kế Thẻ Bình Luận --- */
.review-card-v3 {
    position: relative;
    width: 300px;
    background: var(--neutral-light); /* Nền xám cực nhạt */
    border-radius: 20px;
    padding: 30px; 
    margin: 20px; /* Tăng margin để bóng đổ đẹp hơn */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: flex; 
    flex-direction: column;
    border: 1px solid var(--border-color, #e9ecef);
}
.review-card-v3:hover {
    transform: translateY(-12px);
    box-shadow: 0 18px 45px rgba(13, 179, 59, 0.12);
}

/* --- Icon Trích Dẫn --- */
.review-card-v3 .quote-icon-v3 {
    position: absolute;
    top: 25px;
    right: 25px;
    font-size: 50px;
    color: var(--border-color, #e9ecef);
    transition: transform 0.4s ease, color 0.4s ease;
}
.review-card-v3:hover .quote-icon-v3 {
    transform: rotate(5deg) scale(1.05);
    color: #e0f2e5; /* Màu xanh lá nhạt hơn khi hover */
}

/* --- Nội dung Bình Luận --- */
.review-text-v3 {
    font-size: 16px; 
    color: var(--text-light, #555);
    line-height: 1.8; 
    flex-grow: 1;
    font-style: italic; 
    position: relative;
    z-index: 1;
    margin-bottom: 20px;
}
.review-author-v3 {
    display: flex; 
    align-items: center;
    gap: 15px; 
    margin-top: auto;
    padding-top: 15px; 
    border-top: 1px solid #ddd;
}
.review-author-v3 img {
    width: 50px; 
    height: 50px;
    border-radius: 50%; 
    object-fit: cover;
    border: 2px solid var(--neutral-white);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.author-info-v3 .name {
    font-weight: 700;
    font-size: 17px;
    color: var(--brand-color-dark);
}
.author-info-v3 .stars { 
    color: var(--accent-color, #ffc107); 
    font-size: 16px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.testimonial-slider-v3');
    if (!slider) return;
    
    // Chỉ nhân bản nếu chưa được nhân bản trước đó
    if (slider.children.length > 0 && slider.getAttribute('data-cloned') !== 'true') {
        const slides = Array.from(slider.children);
        slides.forEach(slide => {
            const clone = slide.cloneNode(true);
            slider.appendChild(clone);
        });
        slider.setAttribute('data-cloned', 'true');
    }
});
</script>