
    <style>
        .banner-introduce img{
            height: 350px;
            width: 100%;
        }
        .container {
            display: flex;
            flex-direction: row;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
        }
        .content {
            flex: 3;
            padding-right: 20px;
        }
        .content .post {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #fdfdfd;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .content .post h2 {
            font-size: 25px;
            font-weight: bold;
            color: #21c106;
            margin-bottom: 20px;
        }
        .content .post img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .content .post p {
            margin-bottom: 15px;
            gap:20px;
        }
        .content .post .meta {
            color: #444;
            font-size: 15px;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            flex: 1;
            background-color: #f3f7f8;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            height: 1200px;
        }
        .search-box{
            gap: 10px;
            margin-left: 15px;
        }
        .search-box input{
            margin: 0;            
            padding: 3px;
            font-size: 16px;
            width: 200px;
            height: 20px
        }
        .search-button {
            margin: 0;            
            padding: 3px;
            font-size: 16px;
            width: 40px;
            height: 30px;
            background-color: #0db33b;
            border: none;
            border-radius: 5px;
        }  
        .khoahoc-item {
            margin-top: 30px;
            display: flex;
            margin-bottom: 15px;
            gap: 10px;
            align-items: center;
        }
        .khoahoc-item img {
            width: 70px;
            height: 70px;
            border-radius: 5px;
            object-fit: fill;
        }
        .khoahoc-item p {
            font-size: 14px;
            color: #333;
            margin: 0;
        }
    </style>

    <div class="container">
        <div class="content">
            <div class="post">
                <h2>Hướng dẫn đăng ký khóa học</h2>
                <h5>
                Truy cập vào web và chọn đến Khóa học bạn cần đăng ký<br><br>               
                </h5>
                <img src="images/huongdan.png" alt="ảnh hướng dẫn">
         
                <h5>Chọn và click vào Khóa học muốn đăng ký</h5>
                <h5>Sau đó khi hiện lên phần thông tin khóa học hãy click vào nút đăng ký ngay.</h5>
                <br>

                <img src="images/huongdan2.png" alt="ảnh hướng dẫn"> 
                <br>
                <br>
                <h5>Sau khi ấn vào nút đăng ký ngay sẽ hiện chi phí bạn cần thanh toán , tên khóa học bạn đã chọn và thông tin cá nhân của bạn. Bạn hãy chọn hình thức thanh toán và thanh toán khóa học theo hình thức bạn đã chọn rồi ấn vào nút thanh toán.</h5>
                <br>

                <img src="images/huongdan3.png" alt="ảnh hướng dẫn"> 
                <br>
                <br>

                <h5>Ngay sau đó có thông báo Hoàn thành đăng ký các bạn sẽ nhận được email về tài khoản đăng nhập trên website.</h5>
                
            </div>
            
        </div>

        <div class="sidebar" style="height: 100%;">
            <div class="search">
                <div class="search-box">
                    <input type="text" placeholder="Tìm kiếm..."  style="    padding: 13px 5px;">
                    <button type="submit" class="search-button">
                        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                    </button>
                </div>
                <div class="search-icon"></div>
            </div>

            <div class="khoahoc">
                <div class="khoahoc-item">
                    <img src="images/anh1.png" alt="Image">
                    <p>Cách Đánh Trọng Âm Tiếng Anh Đơn Giản Và Dễ Nhớ (Kèm Bài Tập)</p>
                </div>
                <div class="khoahoc-item">
                    <img src="images/logo.png" alt="Image">
                    <p>MẸO HAY PHÂN BIỆT A - AN - THE ĐỂ KHÔNG CÒN NHẦM LẪN</p>
                </div>
                <div class="khoahoc-item">
                    <img src="images/logo2.jpg" alt="Image">
                    <p>SO SÁNH NHẤT VÀ SO SÁNH HƠN TRONG TIẾNG ANH...</p>
                </div>
            </div>
        </div>
    </div>

    <?php 
    include('form-dk.php');
    ?>