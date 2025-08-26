<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    .container {
       
        margin: 20px auto;
        text-align: center;
    }

    h2 {
        color: #00b04f;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* Slider Styles */
    .slider {
        position: relative;
        overflow: hidden;
    }

    .slider-track {
        display: flex;
        transition: transform 0.5s ease;
    }

    .review {
        flex: 0 0 23%;
        /* 4 items visible at a time */
        box-sizing: border-box;
        padding: 20px;

        border-radius: 10px;
        margin: 0 10px;
    }

    .review p {
        font-size: 16px;
        color: #333;
    }

    .review .name {
        font-weight: bold;
        margin-top: 10px;
    }

    .review .role {
        font-size: 14px;
        color: #888;
    }

    .stars {
        margin: 10px 0;
        color: #ffaa00;
    }

    /* Arrow Buttons */
    .arrow {
        position: absolute;
        top: 30%;
        transform: translateY(-50%);
        font-size: 24px;
        background: #fff;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .arrow:hover {
        background: #00b04f;
        color: #fff;
    }

    .arrow-left {
        left: 10px;
    }

    .arrow-right {
        right: 10px;
    }
</style>

<div class="container" style=" width: 85%;">
    <h2 class="introduce-title">MỌI NGƯỜI NÓI VỀ TIẾNG ANH FIGHTER</h2>
    <div class="slider">
        <div class="slider-track">
            <!-- Review 1 -->
            <div class="review">
                <p>"Khóa học hay, nhiều kiến thức thực tế, cảm ơn các giảng viên TIẾNG ANH FIGHTER."</p>
                <div class="stars">★★★★★</div>
                <div class="name">Nguyễn Tiến Duy</div>
            </div>
            <!-- Review 2 -->
            <div class="review">
                <p> "Khóa học hay quá anh ơi, trước em xem Youtube toàn học một vài video nhưng không hiểu bản chất, tại sao lại
                    làm như thế. Qua khóa của anh em hiểu được vấn đề rồi, giờ áp dụng vào các hồ sơ của em thấy dễ dàng và cố
                    gắng hơn nhiều. Cảm ơn các anh đã ra khóa học chất như này."</p>
                <div class="stars">★★★★★</div>
                <div class="name">Phạm Thu Hà</div>
            </div>
            <!-- Review 3 -->
            <div class="review">
                <p>"Các giảng viên dạy thực sự hay, dễ tiếp thu kiến thức, cảm ơn những khóa học chất lượng của các bạn TIẾNG ANH FIGHTER!"</p>
                <div class="stars">★★★★★</div>
                <div class="name">Nguyễn Ngọc Thương</div>
            </div>
            <!-- Review 4 -->
            <div class="review">
                <p>"Đáp án dễ hiểu, đầy đủ.  TIẾNG ANH FIGHTER đã giúp tôi đạt kết quả như mong muốn!"</p>
                <div class="stars">★★★★★</div>
                <div class="name">Lan Anh</div>
            </div>
            <!-- Review 5 -->
            <div class="review">
                <p>"Tôi đã học xong trong gần 1 tháng trễ hơn mục tiêu đầu 1 tuần. Thích nhất ở khóa học này là các anh hướng
                    dẫn hỗ trợ rất nhiệt tình. Chắc học vất vả hơn với tôi vì đặt nhiều câu hỏi quá. Ngoài ra có các bạn tư vấn
                    của trung tâm hỏi thăm nhắc học thường xuyên. Gửi lời cảm ơn trung tâm."</p>
                <div class="stars">★★★★★</div>
                <div class="name">Thanh Duy Trần</div>
            </div>
            <!-- Review 6 -->
            <div class="review">
                <p> "Khóa học hay quá anh ơi, trước em xem Youtube toàn học một vài video nhưng không hiểu bản chất, tại sao lại
                    làm như thế. Qua khóa của anh em hiểu được vấn đề rồi, giờ áp dụng vào các hồ sơ của em thấy dễ dàng và cố
                    gắng hơn nhiều. Cảm ơn các anh đã ra khóa học chất như này."</p>
                <div class="stars">★★★★★</div>
                <div class="name">Hoàng Văn Thực</div>
            </div>
        </div>
    </div>
</div>

<script>
    const track = document.querySelector('.slider-track');
    const reviews = document.querySelectorAll('.review');
    const prevButton = document.querySelector('.arrow-left');
    const nextButton = document.querySelector('.arrow-right');

    let slideWidth = reviews[0].clientWidth + 20; // Include margin
    const visibleCount = 4;
    const slideInterval = 3000; // Auto-slide interval (milliseconds)

    // Move to the next slide and reorder the elements
    function slideNext() {
        track.style.transition = 'transform 0.5s ease';
        track.style.transform = `translateX(-${slideWidth}px)`;

        // Wait for the animation to finish, then reorder
        setTimeout(() => {
            track.style.transition = 'none'; // Disable animation
            const firstChild = track.firstElementChild;
            track.appendChild(firstChild); // Move the first child to the end
            track.style.transform = `translateX(0)`; // Reset position
        }, 500);
    }

    // Move to the previous slide and reorder the elements
    function slidePrev() {
        const lastChild = track.lastElementChild;
        track.insertBefore(lastChild, track.firstElementChild); // Move the last child to the beginning
        track.style.transition = 'none'; // Disable animation
        track.style.transform = `translateX(-${slideWidth}px)`; // Start from shifted position

        // Animate back to original position
        setTimeout(() => {
            track.style.transition = 'transform 0.5s ease';
            track.style.transform = `translateX(0)`;
        }, 10);
    }

    // Auto-slide logic
    let autoSlide = setInterval(slideNext, slideInterval);

    // Event Listeners for Buttons
    nextButton.addEventListener('click', () => {
        slideNext();
        resetAutoSlide(); // Reset auto-slide timer
    });

    prevButton.addEventListener('click', () => {
        slidePrev();
        resetAutoSlide(); // Reset auto-slide timer
    });

    // Reset auto-slide timer when user interacts
    function resetAutoSlide() {
        clearInterval(autoSlide);
        autoSlide = setInterval(slideNext, slideInterval);
    }

    // Responsive Update
    window.addEventListener('resize', () => {
        slideWidth = reviews[0].clientWidth + 20; // Recalculate on resize
    });
</script>