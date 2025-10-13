<style>
    /* --- CÀI ĐẶT CHUNG --- */
    .testimonial-section {
        padding: 20px 0;
        background-color: #f8f9fa; /* Màu nền sáng hơn */
    }

    .testimonial-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        position: relative; /* Cần cho việc định vị các nút */
    }


    /* --- SLIDER --- */
    .testimonial-slider {
        overflow: hidden; /* Quan trọng: Ẩn các slide thừa */
    }

    .slider-track {
        display: flex;
        /* transition-timing-function được đặt trong JS để kiểm soát tốt hơn */
    }

    .review-card {
        flex: 0 0 100%; /* Mặc định cho mobile, sẽ được ghi đè */
        box-sizing: border-box;
        padding: 25px;
        background-color: #fff;
        border-radius: 15px;
        margin: 0 10px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;
        height: 100%; /* Giúp các card có chiều cao bằng nhau */
        border: 1px solid #eee;
    }

    .review-card .review-text {
        font-size: 16px;
        color: #555;
        line-height: 1.7;
        flex-grow: 1; /* Đẩy phần tên xuống dưới */
        font-style: italic;
    }
    .review-card .review-text::before {
        content: '“';
        font-size: 24px;
        color: #0db33b;
        font-weight: bold;
        margin-right: 5px;
    }

    .review-author {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px dashed #e0e0e0;
        text-align: center;
    }

    .review-author .name {
        font-weight: 600;
        font-size: 17px;
        color: #333;
    }

    .review-author .stars {
        margin-top: 5px;
        color: #ffc107; /* Màu vàng cho sao */
    }

    /* --- NÚT ĐIỀU HƯỚNG --- */
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        background: #fff;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .slider-arrow:hover {
        background: #0db33b;
        color: #fff;
        transform: translateY(-50%) scale(1.1);
    }

    .arrow-left {
        left: -20px;
    }

    .arrow-right {
        right: -20px;
    }
    
    /* --- RESPONSIVE --- */
    
    /* Màn hình máy tính bảng */
    @media (min-width: 768px) {
        .review-card {
            flex-basis: 50%; /* 2 items trên hàng */
        }
    }

    /* Màn hình máy tính nhỏ */
    @media (min-width: 992px) {
        .review-card {
            flex-basis: 33.333%; /* 3 items trên hàng */
        }
    }
    
    /* Màn hình máy tính lớn */
    @media (min-width: 1200px) {
        .review-card {
            flex-basis: 25%; /* 4 items trên hàng */
        }
    }
    
    /* Ẩn nút điều hướng trên điện thoại để tiết kiệm không gian */
    @media (max-width: 767px) {
        .slider-arrow {
            display: none;
        }
        .testimonial-container {
            padding: 0;
        }
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