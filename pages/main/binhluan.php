<style>
   /* --- CÀI ĐẶT CHUNG --- */
.testimonial-section {
    padding: 80px 0px;
    background: linear-gradient(135deg, #d8faeaff 0%, #90dbeeff 50%rgba(82, 120, 130, 1)90 100%);
    position: relative;
}

.testimonial-section::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.testimonial-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
}



.slider-track {
    display: flex;
}

.review-card {
    flex: 0 0 100%;
    box-sizing: border-box;
    padding: 35px;
    background: #ffffff;
    border-radius: 24px;
    margin: 0 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 3px solid transparent;
    background-clip: padding-box;
    position: relative;
    transition: all 0.4s ease;
}

.review-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 24px;
    padding: 3px;
    background: linear-gradient(135deg, #06b6d4, #10b981);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.review-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 70px rgba(6, 182, 212, 0.25);
}

.review-card:hover::before {
    opacity: 1;
}

.review-card .review-text {
    font-size: 16px;
    color: #475569;
    line-height: 1.85;
    flex-grow: 1;
    font-style: italic;
    position: relative;
    padding-left: 25px;
}

.review-card .review-text::before {
    content: '"';
    position: absolute;
    left: -5px;
    top: -15px;
    font-size: 60px;
    background: linear-gradient(135deg, #06b6d4, #10b981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: bold;
    opacity: 0.2;
}

.review-author {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 2px dashed #cbd5e1;
    text-align: center;
}

.review-author .name {
    font-weight: 700;
    font-size: 18px;
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.review-author .stars {
    margin-top: 10px;
    color: #f59e0b;
    font-size: 20px;
    letter-spacing: 3px;
    filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));
}

/* --- NÚT ĐIỀU HƯỚNG --- */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 22px;
    background: #ffffff;
    color: #06b6d4;
    border: 3px solid #06b6d4;
    border-radius: 50%;
    width: 55px;
    height: 55px;
    box-shadow: 0 8px 25px rgba(6, 182, 212, 0.25);
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.slider-arrow:hover {
    background: linear-gradient(135deg, #06b6d4, #10b981);
    color: white;
    border-color: transparent;
    transform: translateY(-50%) scale(1.2) rotate(360deg);
    box-shadow: 0 12px 35px rgba(6, 182, 212, 0.4);
}

.arrow-left {
    left: -27px;
}

.arrow-right {
    right: -27px;
}

/* --- RESPONSIVE --- */
@media (min-width: 768px) {
    .review-card { flex-basis: 50%; }
}

@media (min-width: 992px) {
    .review-card { flex-basis: 33.333%; }
}

@media (min-width: 1200px) {
    .review-card { flex-basis: 25%; }
}

@media (max-width: 767px) {
    .slider-arrow { display: none; }
    .testimonial-container { padding: 0; }
    .introduce-title { font-size: 28px; margin-bottom: 30px; }
}


</style>

<div class="testimonial-section">
    <div class="testimonial-container" data-aos="fade-up">
        <h2 class="introduce-title">Mọi người nói về Tiếng Anh Fighter</h2>
        
        <div class="testimonial-slider">
            <div class="slider-track">
                <div class="review-card">
                    <p class="review-text">Khóa học hay, nhiều kiến thức thực tế, cảm ơn các giảng viên TIẾNG ANH FIGHTER.</p>
                    <div class="review-author">
                        <div class="name">Nguyễn Tiến Duy</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <div class="review-card">
                    <p class="review-text">Khóa học hay quá anh ơi, trước em xem Youtube toàn học một vài video nhưng không hiểu bản chất. Qua khóa của anh em hiểu được vấn đề rồi, giờ áp dụng vào các hồ sơ của em thấy dễ dàng hơn nhiều. Cảm ơn các anh đã ra khóa học chất như này.</p>
                    <div class="review-author">
                        <div class="name">Phạm Thu Hà</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <div class="review-card">
                    <p class="review-text">Các giảng viên dạy thực sự hay, dễ tiếp thu kiến thức, cảm ơn những khóa học chất lượng của các bạn TIẾNG ANH FIGHTER!</p>
                    <div class="review-author">
                        <div class="name">Nguyễn Ngọc Thương</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <div class="review-card">
                    <p class="review-text">Đáp án dễ hiểu, đầy đủ. TIẾNG ANH FIGHTER đã giúp tôi đạt kết quả như mong muốn!</p>
                    <div class="review-author">
                        <div class="name">Lan Anh</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <div class="review-card">
                    <p class="review-text">Tôi đã học xong trong gần 1 tháng. Thích nhất ở khóa học này là các anh hướng dẫn hỗ trợ rất nhiệt tình. Ngoài ra có các bạn tư vấn của trung tâm hỏi thăm nhắc học thường xuyên. Gửi lời cảm ơn trung tâm.</p>
                    <div class="review-author">
                        <div class="name">Thanh Duy Trần</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <div class="review-card">
                    <p class="review-text">Khóa học hay quá, em xem Youtube không hiểu bản chất, tại sao lại làm như thế. Qua khóa học em hiểu được vấn đề rồi, giờ áp dụng vào các hồ sơ của em thấy dễ dàng và cố gắng hơn nhiều. Cảm ơn trung tâm đã ra khóa học chất như này.</p>
                    <div class="review-author">
                        <div class="name">Hoàng Văn Thực</div>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
            </div>
        </div>

        <button class="slider-arrow arrow-left" aria-label="Previous review"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="slider-arrow arrow-right" aria-label="Next review"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.slider-track');
    if (!track) return;

    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.arrow-right');
    const prevButton = document.querySelector('.arrow-left');
    const slideWidth = slides[0].getBoundingClientRect().width + 20; // Lấy chiều rộng thực tế + margin
    let currentIndex = 0;
    let isTransitioning = false;
    let autoSlideInterval;

    // --- CÀI ĐẶT ĐỂ TẠO VÒNG LẶP VÔ HẠN ---

    // 1. Nhân bản các slide đầu và cuối
    const cloneCount = slides.length; // Nhân bản tất cả để đảm bảo đủ cho mọi màn hình
    
    // Nhân bản các slide cuối và chèn vào đầu
    for (let i = 0; i < cloneCount; i++) {
        const clone = slides[i].cloneNode(true);
        track.insertBefore(slides[slides.length - 1 - i].cloneNode(true), slides[0]);
    }

    // Nhân bản các slide đầu và chèn vào cuối
    for (let i = 0; i < cloneCount; i++) {
        const clone = slides[i].cloneNode(true);
        track.appendChild(clone);
    }
    
    // 2. Cập nhật vị trí ban đầu để hiển thị các slide gốc
    const initialOffset = -cloneCount * slideWidth;
    track.style.transform = `translateX(${initialOffset}px)`;
    currentIndex = cloneCount;


    // --- CÁC HÀM XỬ LÝ CHUYỂN ĐỘNG ---

    function moveToSlide(index, duration = 500) {
        if (isTransitioning) return;
        isTransitioning = true;
        
        track.style.transition = `transform ${duration}ms ease-in-out`;
        const newPosition = -index * slideWidth;
        track.style.transform = `translateX(${newPosition}px)`;

        currentIndex = index;
    }

    function handleTransitionEnd() {
        isTransitioning = false;
        // Kiểm tra nếu đang ở slide nhân bản cuối cùng
        if (currentIndex >= slides.length + cloneCount) {
            track.style.transition = 'none'; // Tắt hiệu ứng chuyển động
            currentIndex = cloneCount;
            track.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
        }
        // Kiểm tra nếu đang ở slide nhân bản đầu tiên
        if (currentIndex <= 0) {
            track.style.transition = 'none';
            currentIndex = slides.length;
            track.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
        }
    }
    
    // --- TỰ ĐỘNG CHUYỂN SLIDE ---
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            moveToSlide(currentIndex + 1);
        }, 3000); // Tự động chuyển sau mỗi 3 giây
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }
    
    // --- GÁN SỰ KIỆN ---

    nextButton.addEventListener('click', () => {
        moveToSlide(currentIndex + 1);
    });

    prevButton.addEventListener('click', () => {
        moveToSlide(currentIndex - 1);
    });

    track.addEventListener('transitionend', handleTransitionEnd);
    
    // Tạm dừng khi di chuột vào slider
    const sliderContainer = document.querySelector('.testimonial-container');
    sliderContainer.addEventListener('mouseenter', stopAutoSlide);
    sliderContainer.addEventListener('mouseleave', startAutoSlide);

    // Bắt đầu tự động chuyển slide
    startAutoSlide();

    // Cập nhật lại chiều rộng khi thay đổi kích thước cửa sổ
    window.addEventListener('resize', () => {
        const newSlideWidth = slides[0].getBoundingClientRect().width + 20;
        track.style.transition = 'none';
        track.style.transform = `translateX(${-currentIndex * newSlideWidth}px)`;
    });
});
</script>