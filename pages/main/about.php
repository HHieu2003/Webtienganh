
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
        .content .post h3 {
            font-size: 18px;
        }
        .content .post ul li h4 {
            font-size: 15px;
        }
        .content .post img {
            width: auto;
            height: 300px;
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
        .post-info {
            display: flex;
            margin-top: 10px;
            gap:20px;
        }
        .price {
            color: green;
            font-weight: bold;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 14px;
        }

        .rating {
            color: #ff9800;
            font-size: 14px;
        }
        .reasons {
            display: flex;
            justify-content: space-between;
        }
        .reason-item {
            width: 30%;
            background-color: #fff;
            border: 1px solid #d80027;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .reason-item h3 {
            font-size: 18px;
            color: #d80027;
            margin-bottom: 10px;
        }
        .btn-dky {
            text-decoration: none;
            background-color: #0db33b;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            width: 200px;
            height: 30px;
        }

        .gioithieu{
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card-container{
            font-size: 25px;
            font-weight: bold;
            display: flex;
            color: #21c106;
            gap: 20px;
            margin-bottom: 20px;
        }
        .card h2{
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #03680b;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px #aad3b6;
            overflow: hidden;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        .card:hover{
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
        }

        .card-content {
            padding: 20px;
        }

        .card h3 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 0;
        }

        .card p {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        .welcome-img img{
            width: 100%;
            margin: 40px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px #aad3b6;
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

        .advertise{
            position: relative;
            width: 250px;
            height: 480px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-left: 15px;
            margin-top: 30px;
        }
        .advertise:hover{
            transform: scale(1.05);
        }
        .advertise img{
            width: 250px;
            height: 200px;
            border-radius: 5px;
        }
        .advertise-item{
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 300px;
            padding: 15px;
            color: #000;
            box-sizing: border-box;
        }
        .advertise-item h5{
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
           margin-top: 15px !important;
        }
        .advertise-item p {
            font-size: 14px;
            line-height: 1.5;
        }
    </style>

    
            <div class="banner-introduce">
                <img src="https://haninh.edu.vn/wp-content/uploads/2020/03/1-01-1.jpg" alt="anh banner">
            </div>

    <div class="container">
        <div class="content">
            <div class="post">
                <h2>Chào mừng bạn đến với Tiếng Anh Fighter!</h2>
                <p class="meta">
                    Trước khi chúng ta có cơ hội gặp gỡ, cảm ơn bạn đã sẵn lòng tìm hiểu tại đây. Đội ngũ IELTS Fighter rất vui được cùng bạn chia sẻ những câu chuyện đằng sau thương hiệu đáng tự hào. <br><br>

                    Dựa trên 5 giá trị cốt lõi "Tử tế - Lắng nghe - Chia sẻ - Học tập - Kỷ luật"</span>mỗi sản phẩm của chúng tôi đều là tâm huyết của đội ngũ giảng viên cùng với óc sáng tạo và tinh thần đoàn kết.<br><br>                   
                </p>
                <img src="images/khoahoc1.jpg" alt="Dự thảo Thông tư">
                <p>
                    <h3>Lĩnh vực hoạt động:</h3>
                    <ul> 
                        <li><h4>Đào tạo khóa học trực tuyến</h4></li>
                        <li><h4>Đào tạo khóa học offline</h4></li>
                        <li><h4>Sách và một số nội dung liên quan khác</h4></li>
                    </ul>

                    <h3> Liên hệ với chúng tôi: </h3>
                    <ul>
                        <li><h4> Website:</h4></li>
                        <li><h4> Điện thoại: 0962501832</h4></li>
                        <li><h4> Email: nthuphuong2710@gmail.com</h4></li>
                        <li><h4> Địa chỉ: Lê Văn Lương - Thanh Xuân - Hà Nội </h4></li>
                    </ul>
                    Trải qua gần 7 năm thành lập và phát triển, IELTS Fighter tự hào được hàng trăm nghìn học viên tin tưởng lựa chọn đồng hành tại hơn 60 cơ sở luyện thi trên toàn quốc cũng như hệ thống học trực tuyến. <br><br>

                    IELTS Fighter sở hữu đội ngũ 500+ giáo viên chuyên môn cao, nghiệp vụ giỏi, với kinh nghiệm giảng dạy nhiều năm và tinh thần nhiệt huyết trong nghề...<br><br>

                    Hoạt động từ 01/2020 với sứ mệnh"Hội tụ những con người giá trị chia sẻ những công cụ giá trị để bất kỳ ai cũng có thể Học Thật - Làm Nhanh”đã nhanh chóng nhận được sự ủng hộ và có được một chỗ đứng vững chãi trong lòng khách hàng.<br><br>

                    Dựa trên 5 giá trị cốt lõi "Tử tế - Lắng nghe - Chia sẻ - Học tập - Kỷ luật"mỗi sản phẩm của chúng tôi đều là tâm huyết của đội ngũ giảng viên cùng với óc sáng tạo và tinh thần đoàn kết.<br><br>

                    Với phương trâm đặt khách hàng làm trung tâm, chúng tôi luôn không ngừng nâng cao chất lượng sản phẩm dịch vụ bằng cách ứng dụng công nghệ để có thể đáp ứng được mọi nhu cầu ngày càng cao của khách hàng.<br><br>

                    Chính vì vậy Khách hàng sẽ luôn cảm thấy hài lòng khi trải nghiệm các sản phẩm dịch vụ chuyên nghiệp, uy tín và đang ngày một được hoàn thiện hơn nữa của chúng tôi.<br><br>
                </p>
            </div>

             <div class="post">
                <h2>1. Sự hình thành và phát triển của Tiếng Anh Fighter! </h2>
                    <p class="meta">
                        Trải qua 17 năm hình thành và phát triển, Tiếng Anh Fighter! đã nâng tổng số lên hơn 150 chi nhánh đào tạo tại khắp các tỉnh thành trên toàn quốc.
                    </p>
                    <p>
                        <ul>
                            <li> Tiếng Anh Fighter! có đội ngũ 100% giáo viên nước ngoài với trình độ chuyên môn sư phạm cao, tận tâm yêu nghề, cùng hơn 2.000 cán bộ, chuyên viên chuyên nghiệp, nhiệt tình và hệ thống cơ sở vật chất hiện đại. Tính đến nay Tiếng Anh Fighter! đã đón tiếp trên 150.000 lượt học viên mỗi năm và đào tạo thành công hơn 1.000.000 học viên. Hơn 90% học viên quay lại sử dụng dịch vụ đào tạo của chúng tôi đã chứng minh chất lượng đào tạo hiệu quả, cũng chính là giá trị bền vững của Tiếng Anh Fighter!.</li>
                            <li>Hệ thống Tiếng Anh Fighter! là tổ chức giáo dục Anh ngữ uy tín hàng đầu tại Việt Nam với các chương trình học chuẩn quốc tế đáp ứng nhu cầu học tập cho nhiều lứa tuổi. 
                            Với chương trình giáo dục chuẩn quốc tế và quá trình phát triển vượt bậc trong những năm qua, Ocean Edu đã nhận được rất nhiều danh hiệu và giải thưởng cao quý, xứng đáng là thương hiệu trung tâm Anh ngữ tầm cỡ quốc tế tại Việt Nam.</li>
                            <li>17 năm một chặng đường, luôn tiên phong với sứ mệnh "Giúp hàng triệu người Việt Nam giỏi tiếng Anh", Tiếng Anh Fighter! đã trở thành thương hiệu uy tín hàng đầu Việt Nam, tự hào là nơi thắp sáng tiềm năng cho hàng triệu học viên chinh phục giấc mơ công dân toàn cầu.</li>
                        </ul>
                    </p>
             </div>
            <div class="gioithieu">
                <div class="card-container">
                    <div class="card">
                        <h2>Về chúng tôi </h2>
                        <img src="images/khoahoc10.jpg" alt="">
                        <div class="card-content">
                            <h3>Hành trình thắp lửa chiến binh</h3>
                            <p>Chúng tôi đã, đang và mãi đam mê, cống hiến hết mình vì sứ mệnh chắp cánh ước mơ IELTS cho hàng triệu người Việt Nam vươn tầm thế giới...</p>
                        </div>
                    </div>
                    <div class="card">
                        <h2>Phương pháp đào tạo</h2>
                        <img src="images/khoahoc2.jpg" alt="">
                        <div class="card-content">
                            <h3>Học IELTS toàn diện, bứt phá</h3>
                            <p>Phương pháp đào tạo RIPL đề cao trải nghiệm, sự tương tác, thực hành ngôn ngữ liên tục giữa thầy và trò, giúp hơn 300,000 học viên chinh phục tiếng Anh...</p>
                        </div>
                    </div>
                    <div class="card">
                        <h2>Đội ngũ giảng viên</h2>
                        <img src="images/logo2.jpg" alt="">
                        <div class="card-content">
                            <h3>Đồng hành theo đuổi ước mơ</h3>
                            <p>Đội ngũ giáo viên tài năng, nhưng không ngừng cố gắng để trở thành “thần tượng” của học trò, dành tâm huyết để “biến học trò trở thành thần tượng của chính mình”...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post">
                <h2>2. Chương trình học (Khóa học)</h2>
                    <p class="meta">
                        Với sự chú trọng và quan tâm về chất lượng đào tạo, quy chuẩn quy trình từ con người đến cơ sở vật chất cùng với sự hợp tác của mỗi học viên và phụ huynh, Ocean Edu cam kết sẽ đem đến cho các bạn những sản phẩm, dịch vụ giáo dục chất lượng cao nhất.
                    </p>
                    <p>
                        <ul>
                            <li>Tiếng Anh Fighter! xây dựng lộ trình học rõ ràng và lâu dài, cam kết đạt hiệu quả, định hướng một tương lai rộng mở cho mỗi học viên. Mỗi em học sinh từ độ tuổi nhỏ cho đến khi bước vào trung học, đại học, và các cấp độ học cao hơn nữa, đều có được sự trải nghiệm và định hướng phát triển cùng môi trường giáo dục quốc tế, giúp học viên hội nhập trở thành công dân toàn cầu.</li>
                            <li>Các chương trình học tại Tiếng Anh Fighter! đều được biên soạn và liên tục cập nhật theo tiêu chuẩn quốc tế, mang tính thực tiễn cao, phù hợp với từng lứa tuổi, giúp học viên có thể đạt được hiệu quả cao nhất, áp dụng thành thạo trong công việc và cuộc sống.</li>
                            <li>Điểm ưu việt trong chất lượng chương trình học tại Tiếng Anh Fighter! đó là việc áp dụng công nghệ hiện đại và Hệ thống quản lý học tập trực tuyến hàng đầu thế giới là LMS. Đây là công cụ quản lý học viên, giáo trình, kết nối và tăng cường tương tác giữa phụ huynh, giáo viên mọi lục, mọi nơi.</li>
                        </ul>
                    </p>

                    <h2>3. Đội ngũ giáo viên</h2>
                    <p class="meta">
                        Đội ngũ giáo viên của trung tâm Anh ngữ chúng tôi là yếu tố quan trọng tạo nên uy tín và chất lượng giảng dạy. Được tuyển chọn kỹ lưỡng từ các trường đại học danh tiếng trong và ngoài nước, các giáo viên của chúng tôi đều có trình độ chuyên môn cao, sở hữu bằng cấp đáng tin cậy trong lĩnh vực giảng dạy tiếng Anh.
                    </p>
                    <p>
                        <ul>
                            <li>Giáo viên tại trung tâm không chỉ có bằng cấp từ các trường đại học nổi tiếng mà còn có kinh nghiệm dạy học phong phú. Nhiều giáo viên đã từng tham gia vào các chương trình giảng dạy ở nước ngoài, đem lại những kỹ năng và phương pháp giảng dạy tiên tiến. Điều này giúp các học viên tiếp cận với môi trường học tập hiện đại và thú vị.</li>
                            <li>Một trong những yếu tố giúp đội ngũ giáo viên của chúng tôi nổi bật là sự tận tâm và nhiệt huyết trong công việc. Các giáo viên luôn lắng nghe và hiểu được nhu cầu học tập của từng học viên, từ đó điều chỉnh phương pháp giảng dạy sao cho phù hợp nhất. Nhờ đó, nhiều học viên đã đạt được những bước tiến vượt bậc trong học tập.</li>
                            <li>Các câu chuyện thành công từ học viên là minh chứng rõ ràng nhất cho sự đóng góp của đội ngũ giáo viên. Điển hình, nhiều học viên sau khi hoàn thành khóa học tại trung tâm đã đạt được các chứng chỉ quốc tế như IELTS, TOEFL với điểm số cao. Họ không chỉ tiến bộ về mặt ngôn ngữ mà còn tự tin hơn trong giao tiếp và ứng dụng tiếng Anh vào công việc và đời sống hàng ngày.</li>
                            <li>Với sứ mệnh nâng cao chất lượng giảng dạy và giúp học viên đạt được mục tiêu học tập, đội ngũ giáo viên của chúng tôi luôn nỗ lực không ngừng để xây dựng môi trường học tập chất lượng và hiệu quả.</li>
                        </ul>
                    </p>
            </div>

            <div class="welcome-img" align="center">
                <img src="images/anh1.png" alt="">
            </div>
        </div>

        <div class="sidebar">
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

            <div class="advertise">
                <img src="https://www.iphoned.nl/wp-content/uploads/2023/08/iphone-15-pro-max-alle-kleuren.jpg" alt="">
                <div class="advertise-item">
                            <h5>iPhone 15 series gồm các phiên bản nào?</h5>
                            <p>iPhone 15 series 2023 bao gồm tất cả 4 phiên bản là iPhone 15, iPhone 15 Plus, iPhone 15 Pro và iPhone 15 Pro Max. Trong đó hai phiên bản thường là iPhone 15 và 15 Plus sẽ có cấu hình thấp hơn so với hai phiên bản Pro cũng như có đôi chút khác biệt về thiết kế và tính năng camera.</p>
                        </div>                
            </div>
        </div>
    </div>

    <?php 
        include('pages/main/form-dk.php');
    ?>
  
