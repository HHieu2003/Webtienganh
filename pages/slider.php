<div class="slideshow-container">
    <div class="mySlides fadejs" >
    <img src="https://thedragon.edu.vn/wp-content/uploads/2022/10/Banner-tieng-Anh-ielts-min.png" alt="Banner 11" style="width:100%; height:100%">
       
    </div>

    <div class="mySlides fadejs">
        <img src="./images/banner11.png" alt="Banner 2" style="width:100%; height:100%">


    </div>

    <div class="mySlides fadejs">
    <img src="https://thedragon.edu.vn/wp-content/uploads/2022/10/Banner-tieng-Anh-tong-quat-min.png" alt="Banner 4" style="width:100%; height:100%">

    </div>

    <div class="mySlides fadejs">
        <img src="https://i.ytimg.com/vi/H7jQKAM4rsY/maxresdefault.jpg" alt="Banner 3" style="width:100%; 
        height:100%">
    </div>

 

    <div class="list__dot" style="text-align:center">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</div>

<style>
    .mySlides {
        display: none;
        height: 450px;
    }
    .slideshow-container {
        position: relative;
        margin: auto;
        height: 450px;

    }
    .mySlides img{
        object-fit: fill;
    }
    .list__dot {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 5%;
    }
    .dot {
        height: 12px;
        width: 12px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        cursor: pointer;
    }
    .active-dot {
        background-color: #0db33b;
    }
    .fadejs {
        animation-name: fadejs;
        animation-duration: 0.5s;

    }
    @keyframes fadejs {
        from {opacity: 0.4;} 
        to {opacity: 1;}
    }
    @media only screen and (max-width: 768px) {
        .mySlides img {
            height: auto;
        }
    }
</style>

<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        const slides = document.getElementsByClassName("mySlides");
        const dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1;}
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active-dot", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active-dot";
        setTimeout(showSlides, 3000); // Change image every 3 seconds
    }

    // Optional: Manual control for dots
    const dots = document.querySelectorAll(".dot");
    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            showSlide(index);
        });
    });

    function showSlide(n) {
        let i;
        const slides = document.getElementsByClassName("mySlides");
        const dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex = n + 1;
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active-dot", "");
        }
        slides[n].style.display = "block";
        dots[n].className += " active-dot";
    }
</script>  