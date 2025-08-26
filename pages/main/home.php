<link rel="stylesheet" href="./pages/main.css">
<section>
    <?php
    include('./pages/slider.php');
    ?>
</section>
<?php
        include('pages/main/banner.php');
        ?>
<div>
    <!---------------section container------------>
    <div class="section" style="background-color: white;">
   
        <!-------------khoa hoc tieu bieu------------->
        <h2 class="introduce-title">CÁC KHÓA HỌC TIÊU BIỂU</h2>
   
        <?php
        include('pages/main/dskhoahoc.php');
        ?>


        <div class="container">
            <div class="anh-img" align="center">
                <img src="images/anh2.png" alt="">
            </div>
        </div>
        <?php
        include('pages/main/binhluan.php');
        ?>

        <!---------đối tác--------->
        <!-- <div class="partner">
            <h2 class="introduce-title" >ĐỐI TÁC HÀNG ĐẦU</h2>
            <div class="partner-logo">
                <img src="images/viettinbank.png" alt="VietinBank">
                <img src="images/vpbank.png" alt="VPBAnk">
                <img src="images/Viettel.png" alt="Viettel">
                <img src="images/tpbank.png" alt="TPBank">
                <img src="images/telecom.png" alt="Telecom">
            </div>
        </div> -->
      
        
        <?php
        include('pages/main/form-dk.php');
        ?>

    </div>