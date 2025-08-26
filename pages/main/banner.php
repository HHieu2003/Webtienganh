<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .container-banner {
        background-color: #0b9331;
        padding: 20px 60px 50px 60px;
        margin: 0px auto;
        color: #fff;
    }

    .custom-img {
        max-width: 90%;
        /* Tăng kích thước hình */
        height: 210px;
        filter: hue-rotate(231deg);
    }

    .highlight-text {
        font-weight: bold;
        color: #FFCC00;
    }

    .text-container {
            position: relative;
            height: 7vh; /* Chiều cao khối văn bản */
            text-align: center;
            overflow: hidden;
            margin: 0px 60px;
        }

        .lead {
        position: absolute;
        top: 0;
        left: 100%; /* Bắt đầu ngoài khung nhìn bên phải */
        right: -100%; /* Vượt ra ngoài bên trái */
        opacity: 0; /* Ẩn đoạn văn */
        transition: transform 1s ease-in-out, opacity 1s ease-in-out; /* Hiệu ứng chuyển động */
    }

    .lead.active {
        left: 0; /* Vị trí chính giữa khung nhìn */
        right: 0;
        opacity: 1; /* Hiện đoạn văn */
        transform: translateX(0); /* Không dịch chuyển */
    }

    .lead.inactive {
        transform: translateX(-100%); /* Lướt sang bên trái khi ẩn */
        opacity: 0;
    }

</style>

<div class="container-banner text-center ">
    <!-- Title Section -->
    <h1 class="mb-4 introduce-title" style="color: white;">TRIẾT LÝ GIÁO DỤC CỐT LÕI</h1>
    <div class="text-container">
        <p class="lead px-3 fs-6 active" id="text1">
            Chào mừng bạn đến với Tiếng Anh Fighter – nơi khởi đầu hành trình chinh phục tiếng Anh một cách thú vị và hiệu quả! Chúng tôi tin rằng "Learning is an adventure" – học tập chính là một cuộc phiêu lưu kỳ thú, và chúng tôi ở đây để đồng hành cùng bạn!
        </p>
        <p class="lead px-3 fs-6" id="text2">
            Tiếng Anh Fighter cam kết giúp học sinh sử dụng thành thạo khả năng tiếng Anh của mình. Chúng tôi thiết kế một chương trình giảng dạy toàn diện nhằm phát triển trình độ “Tiếng Anh quốc tế” cho học sinh, giúp các em có thể giao tiếp hiệu quả trên toàn thế giới!
        </p>
    </div>



    <!-- 2 Column Section -->
    <div class="row mt-5 mx-5 px-5 fs-5 g-2 ">
        <!-- Left Column -->
        <div class="col-md-5 mx-auto ">
            <div class="d-flex justify-content-center">
                <img src="https://vn.winningenglishschool.com/wp-content/uploads/2024/08/icon-1.png"
                    alt="Systematic Learning" class="img-fluid custom-img">
            </div>
            <p class="mt-3">Phương pháp học tập có hệ thống làm giảm độ phức tạp của kiến thức</p>
        </div>

        <!-- Right Column -->
        <div class="col-md-5 mx-auto">
            <div class="d-flex justify-content-center">
                <img src="https://vn.winningenglishschool.com/wp-content/uploads/2024/08/icon-1-1.png"
                    alt="Light Bulb Idea" class="img-fluid custom-img">
            </div>
            <p class="mt-3">Dạy ít hơn, học nhiều hơn <br> + Công thức học MMS</p>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JavaScript chuyển văn bản -->
<script>
    const texts = document.querySelectorAll('.lead'); // Lấy tất cả các đoạn văn
    let currentIndex = 0;

    setInterval(() => {
        // Ẩn đoạn văn hiện tại
        texts[currentIndex].classList.remove('active');
        texts[currentIndex].classList.add('inactive');

        // Tính toán chỉ số của đoạn văn tiếp theo
        const nextIndex = (currentIndex + 1) % texts.length;

        // Hiển thị đoạn văn tiếp theo
        texts[nextIndex].classList.remove('inactive');
        texts[nextIndex].classList.add('active');

        // Cập nhật chỉ số hiện tại
        currentIndex = nextIndex;
    }, 7000); // Chuyển đoạn văn mỗi 4 giây
</script>
