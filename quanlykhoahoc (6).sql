-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2025 at 08:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlykhoahoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `baitest`
--

CREATE TABLE `baitest` (
  `id_baitest` int(11) NOT NULL,
  `id_khoahoc` int(11) DEFAULT NULL,
  `id_lop` varchar(50) DEFAULT NULL,
  `ten_baitest` varchar(100) DEFAULT NULL,
  `loai_baitest` enum('dau_vao','dinh_ky','on_tap') NOT NULL DEFAULT 'on_tap',
  `thoi_gian` int(11) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `baitest`
--

INSERT INTO `baitest` (`id_baitest`, `id_khoahoc`, `id_lop`, `ten_baitest`, `loai_baitest`, `thoi_gian`, `ngay_tao`) VALUES
(1, 36, NULL, 'English Grammar Basics Test', 'on_tap', 1, '2024-12-15 21:43:36'),
(2, 37, NULL, 'English Vocabulary Test', 'on_tap', 30, '2024-12-15 22:12:02'),
(3, 39, NULL, 'English Grammar Test', 'on_tap', 45, '2024-12-15 22:14:55'),
(4, 43, NULL, 'English Idioms Test', 'on_tap', 40, '2024-12-15 22:17:52'),
(6, 32, NULL, 'English Tenses Test', 'on_tap', 30, '2024-12-15 23:56:23'),
(7, 42, NULL, 'English Vocabulary Test - Advanced', 'on_tap', 20, '2024-12-15 23:58:08'),
(9, 32, NULL, 'English Antonyms Test', 'dinh_ky', 60, '2024-12-16 00:12:11'),
(37, NULL, NULL, 'Discuss both views and give your opinion', 'on_tap', 16, '2025-10-15 01:11:40'),
(41, NULL, NULL, 'Write a short paragraph (about 100–120 words) about your favorite hobby.', 'on_tap', 60, '2025-10-16 20:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet`
--

CREATE TABLE `bai_viet` (
  `id_baiviet` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` longtext NOT NULL,
  `hinh_anh_tieu_de` varchar(255) DEFAULT NULL,
  `id_tac_gia` int(11) DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ngay_duyet` datetime DEFAULT NULL,
  `trang_thai` enum('cho_duyet','da_duyet','bi_tu_choi') DEFAULT 'cho_duyet',
  `luot_xem` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bai_viet`
--

INSERT INTO `bai_viet` (`id_baiviet`, `tieu_de`, `noi_dung`, `hinh_anh_tieu_de`, `id_tac_gia`, `ngay_tao`, `ngay_duyet`, `trang_thai`, `luot_xem`) VALUES
(1, 'Nói nhanh hay chậm trong IELTS Speaking thì dễ đạt điểm cao hơn?', '<p>Nhiều bạn khi luyện thi IELTS Speaking thường băn khoăn:&nbsp;<strong>&ldquo;M&igrave;nh n&ecirc;n n&oacute;i nhanh hay chậm trong IELTS Speaking để được chấm điểm cao?&rdquo;</strong>&nbsp;C&oacute; người nghĩ rằng n&oacute;i nhanh chứng tỏ sự tr&ocirc;i chảy, người kh&aacute;c lại sợ rằng n&oacute;i nhanh dễ bị vấp, n&oacute;i kh&ocirc;ng r&otilde;.</p>\r\n\r\n<p>Vậy sự thật l&agrave; g&igrave;? Tốc độ n&oacute;i c&oacute; ảnh hưởng đến điểm số trong kỳ thi IELTS hay kh&ocirc;ng? V&agrave; nếu c&oacute;, bạn n&ecirc;n điều chỉnh thế n&agrave;o để vừa&nbsp;<strong>tr&ocirc;i chảy</strong>,&nbsp;<strong>tự nhi&ecirc;n</strong>, m&agrave; vẫn&nbsp;<strong>dễ hiểu v&agrave; r&otilde; r&agrave;ng</strong>?</p>\r\n\r\n<p>Trong b&agrave;i viết n&agrave;y, bạn sẽ t&igrave;m được c&acirc;u trả lời đầy đủ &ndash; dựa tr&ecirc;n ti&ecirc;u ch&iacute; chấm điểm thực tế của IELTS v&agrave; g&oacute;c nh&igrave;n từ ch&iacute;nh c&aacute;c gi&aacute;m khảo Speaking.</p>\r\n\r\n<h2><strong>1. N&oacute;i nhanh hay chậm trong IELTS Speaking để đạt điểm cao?</strong></h2>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><a href=\"https://vietop.edu.vn/blog/noi-nhanh-hay-cham-trong-ielts-speaking/\">N&oacute;i nhanh hay chậm trong IELTS Speaking để đạt điểm cao?</a><br />\r\n			<strong>C&acirc;u trả lời</strong>: N&oacute;i qu&aacute; nhanh hoặc qu&aacute; chậm đều kh&ocirc;ng tốt. Điều quan trọng l&agrave; bạn kiểm so&aacute;t được tốc độ n&oacute;i sao cho người nghe hiểu, b&agrave;i n&oacute;i mạch lạc, kh&ocirc;ng bị ngắt qu&atilde;ng hoặc vấp từ qu&aacute; nhiều.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>V&igrave; thế,&nbsp;<strong>n&oacute;i r&otilde; r&agrave;ng, c&oacute; nhịp điệu tự nhi&ecirc;n v&agrave; diễn đạt tr&ocirc;i chảy</strong>&nbsp;lu&ocirc;n l&agrave; lựa chọn tối ưu, hơn l&agrave; cố &ldquo;bắn&rdquo; thật nhanh để tạo ấn tượng.</p>\r\n\r\n<h2><strong>2. Tốc độ n&oacute;i c&oacute; nằm trong ti&ecirc;u ch&iacute; chấm điểm IELTS Speaking kh&ocirc;ng?</strong></h2>\r\n\r\n<p>Để trả lời ch&iacute;nh x&aacute;c c&acirc;u hỏi &ldquo;n&oacute;i nhanh hay chậm trong&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/speaking/\" target=\"_blank\">IELTS Speaking</a>&nbsp;c&oacute; gi&uacute;p tăng điểm kh&ocirc;ng?&rdquo;, bạn cần hiểu r&otilde;&nbsp;<strong>gi&aacute;m khảo IELTS đ&aacute;nh gi&aacute; b&agrave;i n&oacute;i dựa tr&ecirc;n những ti&ecirc;u ch&iacute; n&agrave;o</strong>. Liệu tốc độ n&oacute;i c&oacute; thật sự được t&iacute;nh điểm? Hay n&oacute; chỉ l&agrave; yếu tố phụ?</p>\r\n\r\n<h3><strong>2.1. Tốc độ n&oacute;i kh&ocirc;ng phải l&agrave; ti&ecirc;u ch&iacute; ri&ecirc;ng biệt</strong></h3>\r\n\r\n<p>Trong 4 ti&ecirc;u ch&iacute; chấm điểm IELTS Speaking (<a href=\"https://vietop.edu.vn/blog/tieu-chi-cham-diem-fluency-cohesive-devices/\" target=\"_blank\">Fluency &amp; Coherence</a>,&nbsp;<a href=\"https://vietop.edu.vn/blog/tieu-chi-cham-diem-lexical-resource-vocab/\" target=\"_blank\">Lexical Resource</a>, Grammatical Range &amp; Accuracy, Pronunciation),&nbsp;<strong>kh&ocirc;ng c&oacute; ti&ecirc;u ch&iacute; n&agrave;o đ&aacute;nh gi&aacute; tốc độ n&oacute;i một c&aacute;ch ri&ecirc;ng biệt</strong>.&nbsp;</p>\r\n\r\n<h3><strong>2.2. Nhưng tốc độ n&oacute;i c&oacute; ảnh hưởng đến cảm nhận về sự tr&ocirc;i chảy trong b&agrave;i n&oacute;i của bạn</strong></h3>\r\n\r\n<p>Tốc độ n&oacute;i&nbsp;<strong>ảnh hưởng đến c&aacute;ch bạn được đ&aacute;nh gi&aacute; ở Fluency &amp; Coherence v&agrave; Pronunciation</strong>. V&iacute; dụ:</p>\r\n\r\n<ul>\r\n	<li>N&oacute;i qu&aacute; nhanh &rarr; dễ mất mạch, thiếu ngắt c&acirc;u &rarr; kh&oacute; hiểu</li>\r\n	<li>N&oacute;i qu&aacute; chậm &rarr; tạo cảm gi&aacute;c ngập ngừng, thiếu tự nhi&ecirc;n</li>\r\n</ul>\r\n\r\n<p>Điều gi&aacute;m khảo muốn thấy l&agrave;&nbsp;<strong>bạn n&oacute;i một c&aacute;ch tr&ocirc;i chảy, mạch lạc, r&otilde; r&agrave;ng,&nbsp;</strong>kh&ocirc;ng qu&aacute; nhanh, kh&ocirc;ng qu&aacute; chậm.</p>\r\n\r\n<h2><strong>3. Khi n&agrave;o n&ecirc;n n&oacute;i nhanh, khi n&agrave;o n&ecirc;n n&oacute;i chậm trong IELTS Speaking?</strong></h2>\r\n\r\n<p>Kh&ocirc;ng c&oacute; tốc độ n&oacute;i &ldquo;chuẩn&rdquo; n&agrave;o d&agrave;nh cho tất cả mọi người. T&ugrave;y v&agrave;o khả năng kiểm so&aacute;t v&agrave; mức độ tự tin m&agrave; bạn c&oacute; thể điều chỉnh tốc độ n&oacute;i sao cho hợp l&yacute;. Dưới đ&acirc;y l&agrave; những t&igrave;nh huống cụ thể để bạn c&acirc;n nhắc.</p>\r\n\r\n<h3><strong>3.1. N&oacute;i nhanh &ndash; khi bạn đang tự nhi&ecirc;n v&agrave; kiểm so&aacute;t tốt mạch n&oacute;i</strong></h3>\r\n\r\n<p>Nếu bạn đang n&oacute;i về chủ đề quen thuộc, c&oacute; &yacute; tưởng r&otilde; r&agrave;ng, th&igrave; tốc độ n&oacute;i c&oacute; thể&nbsp;<strong>nhanh hơn một ch&uacute;t</strong>&nbsp;&ndash;&nbsp;<strong>miễn l&agrave; vẫn r&otilde; r&agrave;ng v&agrave; mạch lạc.</strong></p>\r\n\r\n<p>V&iacute; dụ: Khi kể về trải nghiệm c&aacute; nh&acirc;n &rarr; bạn hứng th&uacute; &rarr; tốc độ n&oacute;i tăng l&ecirc;n một c&aacute;ch tự nhi&ecirc;n &rarr; điều n&agrave;y ho&agrave;n to&agrave;n OK.</p>\r\n\r\n<h3><strong>3.2. N&oacute;i chậm &ndash; khi bạn cần thời gian suy nghĩ</strong></h3>\r\n\r\n<p>N&oacute;i chậm kh&ocirc;ng c&oacute; nghĩa l&agrave; bạn &ldquo;ngập ngừng&rdquo;, kh&ocirc;ng c&oacute; nghĩa l&agrave; bạn n&oacute;i ra từng từ một với một khoảng nghỉ d&agrave;i giữa c&aacute;c từ. Bạn c&oacute; thể:</p>\r\n\r\n<ul>\r\n	<li><strong>Ngừng ngắn</strong>&nbsp;giữa c&aacute;c &yacute;</li>\r\n	<li>D&ugrave;ng c&aacute;c cụm &ldquo;c&acirc;u giờ&rdquo; như:&nbsp;<em>Well, actually&hellip;</em>,&nbsp;<em>Let me think&hellip;</em>,&nbsp;<em>That&rsquo;s an interesting question&hellip;</em></li>\r\n</ul>\r\n\r\n<p>C&aacute;ch n&agrave;y gi&uacute;p bạn giữ sự tự nhi&ecirc;n v&agrave; tr&aacute;nh n&oacute;i sai ngữ ph&aacute;p.</p>\r\n\r\n<h2><strong>4. L&agrave;m sao để kiểm so&aacute;t tốc độ n&oacute;i trong IELTS Speaking?</strong></h2>\r\n\r\n<p>Việc n&oacute;i qu&aacute; nhanh hay qu&aacute; chậm thường đến từ th&oacute;i quen hoặc thiếu luyện tập. Phần n&agrave;y sẽ hướng dẫn bạn những c&aacute;ch luyện hiệu quả gi&uacute;p giữ tốc độ n&oacute;i vừa phải, r&otilde; r&agrave;ng v&agrave; dễ hiểu hơn trong phần thi Speaking.</p>\r\n\r\n<p><img alt=\"Cách kiểm soát tốc độ nói trong IELTS Speaking\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/04/cach-kiem-soat-toc-do-noi-trong-ielts-speaking.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>C&aacute;ch kiểm so&aacute;t tốc độ n&oacute;i trong IELTS Speaking</p>\r\n\r\n<h3><strong>4.1. Ghi &acirc;m &ndash; nghe lại &ndash; điều chỉnh</strong></h3>\r\n\r\n<p>Khi luyện Speaking, bạn n&ecirc;n:</p>\r\n\r\n<ul>\r\n	<li>Ghi &acirc;m c&acirc;u trả lời</li>\r\n	<li>Nghe lại: C&oacute; bị vấp kh&ocirc;ng? N&oacute;i qu&aacute; nhanh ở đ&acirc;u? C&oacute; chỗ n&agrave;o n&oacute;i kh&ocirc;ng r&otilde;?</li>\r\n</ul>\r\n\r\n<p>Việc nghe lại ch&iacute;nh m&igrave;nh gi&uacute;p bạn nhận ra điểm cần cải thiện dễ d&agrave;ng hơn.</p>\r\n\r\n<h3><strong>4.2. Luyện &ldquo;giữ nhịp n&oacute;i&rdquo; &ndash; kh&ocirc;ng tăng tốc bất ngờ</strong></h3>\r\n\r\n<p>Bạn c&oacute; thể thử b&agrave;i tập sau:</p>\r\n\r\n<ul>\r\n	<li>Chọn một topic đơn giản</li>\r\n	<li>N&oacute;i trong 2 ph&uacute;t với&nbsp;<strong>nhịp n&oacute;i đều đặn</strong>, kh&ocirc;ng tăng tốc</li>\r\n	<li>Ch&uacute; &yacute;: ngắt c&acirc;u đ&uacute;ng l&uacute;c, l&ecirc;n &ndash; xuống giọng tự nhi&ecirc;n</li>\r\n</ul>\r\n\r\n<p>Sau đ&oacute;, thử lại với c&ugrave;ng nội dung nhưng n&oacute;i nhanh hơn &rarr; so s&aacute;nh mức độ r&otilde; r&agrave;ng v&agrave; dễ hiểu.</p>\r\n\r\n<h3><strong>4.3. D&ugrave;ng c&aacute;c từ nối để l&agrave;m chậm nhịp n&oacute;i một c&aacute;ch tự nhi&ecirc;n</strong></h3>\r\n\r\n<p>D&ugrave;ng c&aacute;c từ nối như:</p>\r\n\r\n<ul>\r\n	<li><em>Firstly, secondly</em></li>\r\n	<li><em>For example&hellip;</em></li>\r\n	<li><em>In my opinion&hellip;</em></li>\r\n	<li><em>On the other hand&hellip;</em></li>\r\n</ul>\r\n\r\n<p>Những cụm n&agrave;y gi&uacute;p bạn&nbsp;<strong>chuyển &yacute; mượt</strong>, k&eacute;o d&agrave;i thời gian m&agrave; vẫn tự nhi&ecirc;n, gi&uacute;p tốc độ n&oacute;i chậm lại m&agrave; kh&ocirc;ng bị gượng &eacute;p.</p>\r\n\r\n<h2><strong>5. Những lỗi phổ biến khi cố &ldquo;n&oacute;i nhanh&rdquo; để g&acirc;y ấn tượng</strong></h2>\r\n\r\n<p>Kh&ocirc;ng &iacute;t th&iacute; sinh nghĩ rằng n&oacute;i nhanh sẽ tạo ấn tượng tốt với gi&aacute;m khảo. Nhưng nếu kh&ocirc;ng kiểm so&aacute;t được, bạn rất dễ rơi v&agrave;o những lỗi khiến điểm số bị ảnh hưởng nghi&ecirc;m trọng. H&atilde;y xem bạn c&oacute; đang mắc lỗi n&agrave;o dưới đ&acirc;y kh&ocirc;ng nh&eacute;.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Lỗi</strong></td>\r\n			<td><strong>Hậu quả</strong></td>\r\n			<td><strong>C&aacute;ch khắc phục</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td>N&oacute;i qu&aacute; nhanh để thể hiện sự tr&ocirc;i chảy</td>\r\n			<td>Vấp từ, mất mạch</td>\r\n			<td>Giữ tốc độ vừa phải, n&oacute;i mạch lạc</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Kh&ocirc;ng ngắt c&acirc;u</td>\r\n			<td>B&agrave;i n&oacute;i kh&oacute; hiểu, mất điểm Pronunciation</td>\r\n			<td>Dừng nhẹ sau mỗi &yacute;, ngắt nhịp đ&uacute;ng l&uacute;c</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Nuốt &acirc;m hoặc n&oacute;i kh&ocirc;ng r&otilde;</td>\r\n			<td>Gi&aacute;m khảo kh&ocirc;ng nghe được &rarr; mất điểm</td>\r\n			<td>Ph&aacute;t &acirc;m r&otilde; r&agrave;ng, kh&ocirc;ng hi sinh ph&aacute;t &acirc;m v&igrave; tốc độ</td>\r\n		</tr>\r\n		<tr>\r\n			<td>D&ugrave;ng từ nối loạn xạ để k&eacute;o d&agrave;i thời gian</td>\r\n			<td>B&agrave;i n&oacute;i thiếu tự nhi&ecirc;n</td>\r\n			<td>D&ugrave;ng từ nối đ&uacute;ng ngữ cảnh, kh&ocirc;ng lạm dụng</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2><strong>6. Kết luận</strong></h2>\r\n\r\n<p><strong>N&oacute;i nhanh hay chậm trong IELTS Speaking</strong>&nbsp;kh&ocirc;ng quan trọng bằng việc&nbsp;<strong>bạn c&oacute; đang n&oacute;i tự nhi&ecirc;n, r&otilde; r&agrave;ng v&agrave; tr&ocirc;i chảy hay kh&ocirc;ng</strong>. Tốt nhất l&agrave; h&atilde;y luyện c&aacute;ch kiểm so&aacute;t tốc độ, ngắt &yacute; hợp l&yacute; v&agrave; sử dụng từ nối một c&aacute;ch linh hoạt &ndash; đ&oacute; mới l&agrave; &ldquo;tốc độ th&ocirc;ng minh&rdquo; trong mắt gi&aacute;m khảo.</p>\r\n\r\n<p>Nếu bạn đang luyện Speaking v&agrave; vẫn chưa biết m&igrave;nh n&ecirc;n n&oacute;i như thế n&agrave;o l&agrave; hợp l&yacute;, h&atilde;y tham khảo th&ecirc;m c&aacute;c b&agrave;i viết trong&nbsp;<a href=\"https://vietop.edu.vn/blog/hoi-dap/\" target=\"_blank\"><strong>chuy&ecirc;n mục</strong>&nbsp;<strong>Hỏi &ndash; Đ&aacute;p</strong></a>. V&agrave; nếu bạn c&oacute; c&acirc;u hỏi ri&ecirc;ng cần giải đ&aacute;p, đừng ngần ngại nhấn v&agrave;o n&uacute;t&nbsp;<strong>&ldquo;Đặt c&acirc;u hỏi&rdquo;</strong>&nbsp;để đội ngũ để&nbsp;hỗ trợ bạn nhanh nhất!</p>', 'uploads/posts/1760565788_thumbnail-noi-nhanh-hay-cham-trong-ielts-speaking.jpg', 1, '2025-10-15 22:03:08', '2025-10-16 00:58:30', 'da_duyet', 30),
(2, 'Mẹo hiểu bài đọc IELTS cho người mới: Làm sao đọc nhanh và dễ hơn?', '<p>Với những bạn mới bắt đầu học IELTS, phần Reading lu&ocirc;n l&agrave; một trong những kỹ năng khiến người học cảm thấy &ldquo;kh&oacute; nuốt&rdquo; nhất. Văn bản d&agrave;i, từ vựng lạ, cấu tr&uacute;c phức tạp, chưa kể thời gian l&agrave;m b&agrave;i chỉ g&oacute;i gọn trong 60 ph&uacute;t cho 3 đoạn văn v&agrave; 40 c&acirc;u hỏi.</p>\r\n\r\n<p>Vậy l&agrave;m thế n&agrave;o để&nbsp;<strong>&aacute;p dụng những mẹo hiểu b&agrave;i đọc IELTS cho người mới</strong>&nbsp;một c&aacute;ch hiệu quả? C&oacute; c&aacute;ch n&agrave;o để luyện đọc dễ hiểu hơn ngay từ đầu, kể cả khi bạn chưa c&oacute; vốn từ vựng lớn?</p>\r\n\r\n<p>Trong b&agrave;i viết n&agrave;y, bạn sẽ t&igrave;m thấy những&nbsp;<strong>chiến lược đơn giản, dễ luyện v&agrave; cực kỳ thực tế</strong>&nbsp;để cải thiện khả năng đọc hiểu chỉ sau một thời gian ngắn luyện tập.</p>\r\n\r\n<h2><strong>1. C&oacute; mẹo hiểu b&agrave;i đọc IELTS cho người mới n&agrave;o đơn giản kh&ocirc;ng?</strong></h2>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><a href=\"https://vietop.edu.vn/blog/meo-hieu-bai-doc-ielts-cho-nguoi-moi/\">C&oacute; mẹo hiểu b&agrave;i đọc IELTS cho người mới n&agrave;o đơn giản kh&ocirc;ng?</a><br />\r\n			<strong>C&acirc;u trả lời</strong>:&nbsp;<strong>Người mới học n&ecirc;n bắt đầu bằng việc:</strong><br />\r\n			&ndash; L&agrave;m quen với bố cục b&agrave;i thi<br />\r\n			&ndash; Đọc ti&ecirc;u đề v&agrave; đoạn mở đầu thật kỹ<br />\r\n			&ndash; L&agrave;m quen với kỹ thuật đọc lướt &ndash; đọc qu&eacute;t.<br />\r\n			&ndash; Gạch từ kh&oacute;a quan trọng trong c&acirc;u hỏi<br />\r\n			&ndash; Tập trung v&agrave;o &yacute; ch&iacute;nh thay v&igrave; dịch từng từ.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Kh&ocirc;ng cần &ldquo;cao si&ecirc;u&rdquo;, chỉ cần bạn luyện đ&uacute;ng c&aacute;ch, việc đọc hiểu sẽ trở n&ecirc;n dễ d&agrave;ng hơn rất nhiều.</p>\r\n\r\n<h2><strong>2. V&igrave; sao người mới học thường gặp kh&oacute; khăn với b&agrave;i đọc Reading?</strong></h2>\r\n\r\n<p>Trước khi đi v&agrave;o chi tiết c&aacute;c mẹo cải thiện, h&atilde;y c&ugrave;ng nh&igrave;n lại một số l&yacute; do khiến phần&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/reading/\" target=\"_blank\">IELTS Reading</a>&nbsp;trở th&agrave;nh &ldquo;&aacute;c mộng&rdquo; với người mới học. Hiểu được nguy&ecirc;n nh&acirc;n sẽ gi&uacute;p bạn tr&aacute;nh được những sai lầm phổ biến v&agrave; học đ&uacute;ng hướng từ đầu.</p>\r\n\r\n<h3><strong>2.1. Văn bản d&agrave;i, nội dung học thuật</strong></h3>\r\n\r\n<p>Một b&agrave;i Reading IELTS thường d&agrave;i gần 900 từ, chia th&agrave;nh ba đoạn v&agrave; đề cập đến c&aacute;c chủ đề đa dạng như khoa học, gi&aacute;o dục, m&ocirc;i trường, lịch sử&hellip; Kh&ocirc;ng chỉ cần hiểu nội dung, bạn c&ograve;n phải xử l&yacute; th&ocirc;ng tin trong thời gian giới hạn, chưa kể &aacute;p lực thi khiến nhiều bạn bị &ldquo;đuối&rdquo; từ đoạn 2 trở đi.</p>\r\n\r\n<h3><strong>2.2. Th&oacute;i quen dịch từng d&ograve;ng</strong></h3>\r\n\r\n<p>C&aacute;ch học phổ biến nhưng thiếu hiệu quả: đọc từng d&ograve;ng &rarr; dịch sang tiếng Việt &rarr; cố gắng hiểu &rarr; quay lại b&agrave;i đọc &rarr; qu&ecirc;n mất nội dung c&acirc;u hỏi. Việc dịch s&aacute;t nghĩa từng từ như vậy kh&ocirc;ng chỉ l&agrave;m chậm tiến độ m&agrave; c&ograve;n khiến bạn rối v&agrave; mệt mỏi.</p>\r\n\r\n<h3><strong>3.3. Kh&ocirc;ng biết đ&acirc;u l&agrave; th&ocirc;ng tin ch&iacute;nh cần t&igrave;m</strong></h3>\r\n\r\n<p>Đọc m&agrave; kh&ocirc;ng c&oacute; &ldquo;mục ti&ecirc;u&rdquo; dễ khiến bạn đọc ho&agrave;i m&agrave; kh&ocirc;ng biết m&igrave;nh đang t&igrave;m g&igrave;. Đặc biệt l&agrave; dạng c&acirc;u hỏi&nbsp;<a href=\"https://vietop.edu.vn/blog/true-false-not-given-ielts-reading/\" target=\"_blank\">True/False/Not Given</a>&nbsp;&ndash; nếu kh&ocirc;ng x&aacute;c định đ&uacute;ng từ kh&oacute;a v&agrave; nội dung ch&iacute;nh, bạn sẽ mất rất nhiều thời gian v&ocirc; &iacute;ch.</p>\r\n\r\n<h2><strong>3. Mẹo hiểu b&agrave;i đọc IELTS cho người mới: Dễ &aacute;p dụng, dễ tiến bộ</strong></h2>\r\n\r\n<p>Biết được những kh&oacute; khăn rồi, giờ l&agrave; l&uacute;c bạn cần những giải ph&aacute;p cụ thể. Dưới đ&acirc;y l&agrave; những mẹo đơn giản nhưng cực kỳ hiệu quả d&agrave;nh ri&ecirc;ng cho người mới, gi&uacute;p bạn đọc hiểu tốt hơn m&agrave; kh&ocirc;ng cần qu&aacute; giỏi tiếng Anh ngay từ đầu.</p>\r\n\r\n<p><img alt=\"Những mẹo hiểu bài đọc IELTS cho người mới\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/04/meo-hieu-bai-doc-ielts-cho-nguoi-moi.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>Những mẹo hiểu b&agrave;i đọc IELTS cho người mới</p>\r\n\r\n<h3><strong>3.1. Đọc đoạn mở đầu để nắm chủ đề</strong></h3>\r\n\r\n<p>Kh&ocirc;ng cần học l&yacute; thuyết d&agrave;i d&ograve;ng, bạn c&oacute; thể bắt đầu bằng:</p>\r\n\r\n<ul>\r\n	<li>Đọc ti&ecirc;u đề v&agrave; c&acirc;u đầu đoạn để x&aacute;c định nội dung ch&iacute;nh</li>\r\n	<li>D&ograve; t&ecirc;n ri&ecirc;ng, số liệu, cụm từ viết hoa &ndash; những thứ dễ nhận diện bằng mắt</li>\r\n	<li>Đọc c&acirc;u hỏi song song với b&agrave;i &rarr; x&aacute;c định đoạn cần đọc kỹ hơn</li>\r\n</ul>\r\n\r\n<p>Luyện mỗi ng&agrave;y bằng 1 b&agrave;i b&aacute;o ngắn từ CNN, BBC, hoặc một đoạn blog c&oacute; nội dung học thuật l&agrave; đủ.</p>\r\n\r\n<h3><strong>3.2. L&agrave;m quen với kỹ thuật đọc lướt v&agrave; đọc qu&eacute;t</strong></h3>\r\n\r\n<p>C&acirc;u hỏi lu&ocirc;n được viết trước, c&oacute; nghĩa l&agrave; bạn biết m&igrave;nh cần t&igrave;m g&igrave; &ndash; giống như cầm bản đồ trước khi đi t&igrave;m kho b&aacute;u. Gạch từ kh&oacute;a (v&iacute; dụ: years, names, effects, causes&hellip;) rồi quay lại b&agrave;i đọc, bạn sẽ tiết kiệm được &iacute;t nhất 30% thời gian so với việc đọc d&agrave;n trải.</p>\r\n\r\n<h3><strong>3.3. Kh&ocirc;ng cần hiểu từng từ &ndash; tập trung v&agrave;o c&acirc;u chứa th&ocirc;ng tin</strong></h3>\r\n\r\n<p>Khi gặp từ lạ:</p>\r\n\r\n<ul>\r\n	<li>Đừng dừng lại</li>\r\n	<li>Nh&igrave;n c&acirc;u xung quanh</li>\r\n	<li>Dựa v&agrave;o c&aacute;c cụm từ bạn biết để đo&aacute;n ngữ cảnh</li>\r\n</ul>\r\n\r\n<p>Tập trung v&agrave;o c&acirc;u c&oacute; chứa t&ecirc;n người, số liệu, mốc thời gian &ndash; thường l&agrave; nơi chứa đ&aacute;p &aacute;n của nhiều dạng c&acirc;u hỏi.</p>\r\n\r\n<h3><strong>3.4. L&agrave;m phần dễ trước, đừng bị cuốn v&agrave;o 1 c&acirc;u</strong></h3>\r\n\r\n<p>Chiến thuật &ldquo;đ&aacute;nh nhanh r&uacute;t gọn&rdquo;: L&agrave;m Gap Fill hoặc&nbsp;<a href=\"https://vietop.edu.vn/blog/multiple-choice-ielts-reading/\" target=\"_blank\">Multiple Choice</a>&nbsp;trước &rarr; quay lại c&aacute;c dạng Matching sau. Đừng để 1 c&acirc;u l&agrave;m mất 3 ph&uacute;t của bạn &ndash; điểm số sẽ kh&ocirc;ng đến từ sự &ldquo;cố chấp&rdquo;.</p>\r\n\r\n<h2><strong>4. C&aacute;ch luyện đọc mỗi ng&agrave;y cho người mới học IELTS Reading</strong></h2>\r\n\r\n<p>&Aacute;p dụng mẹo l&agrave; một chuyện, nhưng nếu kh&ocirc;ng luyện tập đều đặn th&igrave; kết quả sẽ kh&ocirc;ng bền vững. Phần n&agrave;y sẽ hướng dẫn bạn c&aacute;ch x&acirc;y dựng th&oacute;i quen luyện đọc mỗi ng&agrave;y một c&aacute;ch dễ d&agrave;ng, hiệu quả v&agrave; ph&ugrave; hợp với người mới bắt đầu.</p>\r\n\r\n<h3><strong>4.1. Mỗi ng&agrave;y đọc 1 đoạn ngắn c&oacute; chủ đề quen thuộc</strong></h3>\r\n\r\n<p>Đừng &eacute;p m&igrave;nh đọc b&agrave;i thi mẫu nếu chưa sẵn s&agrave;ng. H&atilde;y bắt đầu với:</p>\r\n\r\n<ul>\r\n	<li>B&agrave;i đọc về chủ đề bạn y&ecirc;u th&iacute;ch (du lịch, c&ocirc;ng nghệ, ẩm thực&hellip;)</li>\r\n	<li>B&agrave;i ngắn 200&ndash;300 từ, đọc trong 5&ndash;7 ph&uacute;t</li>\r\n	<li>Ghi lại 1 c&acirc;u t&oacute;m tắt nội dung</li>\r\n</ul>\r\n\r\n<h3><strong>4.2. Đặt thời gian cho mỗi lần đọc</strong></h3>\r\n\r\n<p>Tự giới hạn thời gian sẽ r&egrave;n khả năng tập trung. V&iacute; dụ:</p>\r\n\r\n<ul>\r\n	<li>5 ph&uacute;t để đọc hiểu</li>\r\n	<li>2 ph&uacute;t trả lời 3 c&acirc;u hỏi</li>\r\n	<li>1 ph&uacute;t kiểm tra lại</li>\r\n</ul>\r\n\r\n<p>Sau đ&oacute; ghi lại thời gian thực tế v&agrave; so s&aacute;nh với mục ti&ecirc;u.</p>\r\n\r\n<h3>4.3. Học từ theo cụm &ndash; kh&ocirc;ng học đơn lẻ</h3>\r\n\r\n<p>Tập ghi ch&uacute; theo dạng:</p>\r\n\r\n<ul>\r\n	<li>Environment &rarr; global warming, air pollution, renewable energy</li>\r\n	<li>Health &rarr; balanced diet, mental health, life expectancy</li>\r\n</ul>\r\n\r\n<p>Bạn sẽ thấy khả năng &ldquo;nhận diện từ kh&oacute;a&rdquo; v&agrave; &ldquo;hiểu mạch văn&rdquo; tăng r&otilde; rệt.</p>\r\n\r\n<h3><strong>4.4. Tự hỏi v&agrave; trả lời sau khi đọc xong</strong></h3>\r\n\r\n<p>Đọc xong đừng gấp s&aacute;ch. H&atilde;y hỏi:</p>\r\n\r\n<ul>\r\n	<li>M&igrave;nh hiểu g&igrave;?</li>\r\n	<li>C&oacute; từ n&agrave;o m&igrave;nh đo&aacute;n đ&uacute;ng nghĩa kh&ocirc;ng?</li>\r\n	<li>C&acirc;u hỏi n&agrave;o khiến m&igrave;nh tốn nhiều thời gian nhất?</li>\r\n</ul>\r\n\r\n<p>Việc n&agrave;y gi&uacute;p bạn hiểu b&agrave;i đọc s&acirc;u hơn v&agrave; cải thiện từng ng&agrave;y.</p>\r\n\r\n<h2><strong>5. Những lỗi người mới hay mắc khi luyện đọc IELTS</strong></h2>\r\n\r\n<p>D&ugrave; bạn c&oacute; mẹo hay c&aacute;ch luyện tốt đến đ&acirc;u, vẫn cần tr&aacute;nh những sai lầm dễ mắc phải. Dưới đ&acirc;y l&agrave; những lỗi phổ biến m&agrave; người học thường gặp &ndash; nhận diện v&agrave; khắc phục sớm sẽ gi&uacute;p bạn r&uacute;t ngắn thời gian luyện thi đ&aacute;ng kể.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Lỗi</strong></td>\r\n			<td><strong>Hậu quả</strong></td>\r\n			<td><strong>Giải ph&aacute;p</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td>Dịch từng d&ograve;ng</td>\r\n			<td>Rối &yacute;, chậm</td>\r\n			<td>Tập skim + scan</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Kh&ocirc;ng đọc c&acirc;u hỏi trước</td>\r\n			<td>Kh&ocirc;ng biết t&igrave;m g&igrave;</td>\r\n			<td>Đọc c&acirc;u hỏi trước b&agrave;i</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Gặp từ lạ l&agrave; hoang mang</td>\r\n			<td>Bỏ dở giữa chừng</td>\r\n			<td>Đo&aacute;n nghĩa theo ngữ cảnh</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Kh&ocirc;ng luyện thường xuy&ecirc;n</td>\r\n			<td>Dậm ch&acirc;n tại chỗ</td>\r\n			<td>Mỗi ng&agrave;y đọc &iacute;t nhất 1 đoạn</td>\r\n		</tr>\r\n		<tr>\r\n			<td>L&agrave;m hết 40 c&acirc;u mỗi lần</td>\r\n			<td>Dễ nản, kh&ocirc;ng tiến bộ</td>\r\n			<td>Chia nhỏ b&agrave;i &ndash; luyện từng dạng một</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2><strong>6. Kết luận</strong></h2>\r\n\r\n<p><strong>Mẹo hiểu b&agrave;i đọc IELTS cho người mới</strong>&nbsp;đến từ việc&nbsp;<strong>luyện tập c&oacute; chiến lược v&agrave; đ&uacute;ng tr&igrave;nh độ</strong>. Bạn kh&ocirc;ng cần hiểu hết, kh&ocirc;ng cần từ vựng &ldquo;cao si&ecirc;u&rdquo;, chỉ cần một kế hoạch r&otilde; r&agrave;ng v&agrave; quyết t&acirc;m duy tr&igrave; đều đặn mỗi ng&agrave;y.</p>\r\n\r\n<p>IELTS kh&ocirc;ng phải l&agrave; chặng đua tốc độ m&agrave; l&agrave; h&agrave;nh tr&igrave;nh bền bỉ. Đừng vội &ndash; h&atilde;y bắt đầu với những b&agrave;i đọc bạn thấy dễ hiểu nhất. Sau một th&aacute;ng, bạn sẽ ngạc nhi&ecirc;n với sự tiến bộ của ch&iacute;nh m&igrave;nh.</p>', 'uploads/posts/1760568520_thumbnail-meo-hieu-bai-doc-ielts-cho-nguoi-moi.jpg', 1, '2025-10-15 22:48:40', '2025-10-16 00:48:46', 'da_duyet', 1),
(6, 'qqq', '<p>qq</p>', NULL, 1, '2025-10-16 08:54:57', NULL, 'bi_tu_choi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `binh_luan`
--

CREATE TABLE `binh_luan` (
  `id_binhluan` int(11) NOT NULL,
  `id_baiviet` int(11) NOT NULL,
  `id_hocvien` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'ID của bình luận cha',
  `noi_dung` text NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `binh_luan`
--

INSERT INTO `binh_luan` (`id_binhluan`, `id_baiviet`, `id_hocvien`, `parent_id`, `noi_dung`, `ngay_tao`) VALUES
(10, 1, 1, NULL, 'ddd', '2025-10-15 22:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `cauhoi`
--

CREATE TABLE `cauhoi` (
  `id_cauhoi` int(11) NOT NULL,
  `id_baitest` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `loai_cauhoi` enum('trac_nghiem','tu_luan') NOT NULL DEFAULT 'trac_nghiem'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cauhoi`
--

INSERT INTO `cauhoi` (`id_cauhoi`, `id_baitest`, `noi_dung`, `loai_cauhoi`) VALUES
(1, 1, 'What is the past tense of \"go\"?', 'trac_nghiem'),
(2, 1, 'Which word is a synonym of \"happy\"?', 'trac_nghiem'),
(3, 1, 'What is the plural of \"child\"?', 'trac_nghiem'),
(4, 1, 'What is the correct article for \"apple\"?', 'trac_nghiem'),
(5, 1, 'Which sentence is grammatically correct?', 'trac_nghiem'),
(6, 1, 'What is the comparative form of \"good\"?', 'trac_nghiem'),
(7, 1, 'Which word is a verb?', 'trac_nghiem'),
(8, 1, 'What is the antonym of \"hot\"?', 'trac_nghiem'),
(9, 1, 'What is the capital letter of \"a\"?', 'trac_nghiem'),
(10, 1, 'Which word is a noun?', 'trac_nghiem'),
(11, 1, 'What is the correct spelling?', 'trac_nghiem'),
(12, 1, 'What is the base form of \"studied\"?', 'trac_nghiem'),
(20, 1, 'What is the correct form of \"they\" in present tense?', 'trac_nghiem'),
(60, 2, 'What is the synonym of \"happy\"?', 'trac_nghiem'),
(61, 2, 'What is the antonym of \"big\"?', 'trac_nghiem'),
(62, 2, 'Which word is a noun?', 'trac_nghiem'),
(63, 2, 'Which word means \"to move quickly\"?', 'trac_nghiem'),
(64, 2, 'What is the plural of \"child\"?', 'trac_nghiem'),
(65, 2, 'Which word is a verb?', 'trac_nghiem'),
(66, 2, 'What is the synonym of \"angry\"?', 'trac_nghiem'),
(67, 2, 'What is the antonym of \"fast\"?', 'trac_nghiem'),
(68, 2, 'Which word is an adjective?', 'trac_nghiem'),
(69, 2, 'Which word is related to weather?', 'trac_nghiem'),
(70, 2, 'Which word is a preposition?', 'trac_nghiem'),
(71, 2, 'What is the past tense of \"run\"?', 'trac_nghiem'),
(72, 2, 'What is the meaning of \"benevolent\"?', 'trac_nghiem'),
(73, 2, 'Which word means \"large in size\"?', 'trac_nghiem'),
(74, 2, 'What is the synonym of \"cold\"?', 'trac_nghiem'),
(75, 2, 'What is the antonym of \"hard\"?', 'trac_nghiem'),
(76, 2, 'What is the meaning of \"serene\"?', 'trac_nghiem'),
(77, 2, 'Which word is a conjunction?', 'trac_nghiem'),
(78, 2, 'Which word is an interjection?', 'trac_nghiem'),
(79, 2, 'What is the meaning of \"precipitation\"?', 'trac_nghiem'),
(80, 2, 'What is the synonym of \"hot\"?', 'trac_nghiem'),
(81, 2, 'What is the meaning of \"diligent\"?', 'trac_nghiem'),
(82, 2, 'Which word is an article?', 'trac_nghiem'),
(83, 2, 'What is the synonym of \"beautiful\"?', 'trac_nghiem'),
(84, 2, 'What is the antonym of \"happy\"?', 'trac_nghiem'),
(100, 3, 'What is the correct article for \"apple\"?', 'trac_nghiem'),
(101, 3, 'Which word is a pronoun?', 'trac_nghiem'),
(102, 3, 'What is the past tense of \"go\"?', 'trac_nghiem'),
(103, 3, 'Which word is an adverb?', 'trac_nghiem'),
(104, 3, 'What is the plural of \"mouse\"?', 'trac_nghiem'),
(105, 3, 'Which sentence uses the correct tense?', 'trac_nghiem'),
(106, 3, 'What is the synonym of \"quickly\"?', 'trac_nghiem'),
(107, 3, 'Which word is an interjection?', 'trac_nghiem'),
(108, 3, 'What is the antonym of \"good\"?', 'trac_nghiem'),
(109, 3, 'Which is the correct spelling?', 'trac_nghiem'),
(110, 3, 'Which word is a conjunction?', 'trac_nghiem'),
(111, 3, 'What is the correct preposition for time?', 'trac_nghiem'),
(112, 3, 'What is the meaning of \"generous\"?', 'trac_nghiem'),
(113, 3, 'Which word is related to transportation?', 'trac_nghiem'),
(114, 3, 'Which sentence is grammatically correct?', 'trac_nghiem'),
(115, 3, 'What is the plural of \"person\"?', 'trac_nghiem'),
(116, 3, 'Which word is an adjective?', 'trac_nghiem'),
(117, 3, 'What is the synonym of \"small\"?', 'trac_nghiem'),
(118, 3, 'Which word is a noun?', 'trac_nghiem'),
(119, 3, 'What is the meaning of \"optimistic\"?', 'trac_nghiem'),
(120, 3, 'Which word is a verb?', 'trac_nghiem'),
(121, 3, 'What is the antonym of \"early\"?', 'trac_nghiem'),
(122, 3, 'Which word is related to education?', 'trac_nghiem'),
(123, 3, 'What is the synonym of \"beautiful\"?', 'trac_nghiem'),
(124, 3, 'What is the antonym of \"clean\"?', 'trac_nghiem'),
(125, 3, 'Which word means \"large in size\"?', 'trac_nghiem'),
(126, 3, 'What is the meaning of \"compassionate\"?', 'trac_nghiem'),
(127, 3, 'Which sentence uses passive voice?', 'trac_nghiem'),
(128, 3, 'What is the antonym of \"strong\"?', 'trac_nghiem'),
(129, 3, 'Which word is an article?', 'trac_nghiem'),
(150, 4, 'What does \"a piece of cake\" mean?', 'trac_nghiem'),
(151, 4, 'What does \"spill the beans\" mean?', 'trac_nghiem'),
(152, 4, 'What does \"break the ice\" mean?', 'trac_nghiem'),
(153, 4, 'What does \"hit the nail on the head\" mean?', 'trac_nghiem'),
(154, 4, 'What does \"cost an arm and a leg\" mean?', 'trac_nghiem'),
(155, 4, 'What does \"once in a blue moon\" mean?', 'trac_nghiem'),
(156, 4, 'What does \"burn the midnight oil\" mean?', 'trac_nghiem'),
(157, 4, 'What does \"cry over spilt milk\" mean?', 'trac_nghiem'),
(158, 4, 'What does \"bite the bullet\" mean?', 'trac_nghiem'),
(159, 4, 'What does \"let the cat out of the bag\" mean?', 'trac_nghiem'),
(160, 4, 'What does \"kick the bucket\" mean?', 'trac_nghiem'),
(161, 4, 'What does \"under the weather\" mean?', 'trac_nghiem'),
(162, 4, 'What does \"hit the sack\" mean?', 'trac_nghiem'),
(163, 4, 'What does \"add fuel to the fire\" mean?', 'trac_nghiem'),
(164, 4, 'What does \"kill two birds with one stone\" mean?', 'trac_nghiem'),
(165, 4, 'What does \"burn bridges\" mean?', 'trac_nghiem'),
(166, 4, 'What does \"on cloud nine\" mean?', 'trac_nghiem'),
(167, 4, 'What does \"when pigs fly\" mean?', 'trac_nghiem'),
(168, 4, 'What does \"raining cats and dogs\" mean?', 'trac_nghiem'),
(169, 4, 'What does \"pull someone’s leg\" mean?', 'trac_nghiem'),
(170, 4, 'What does \"the ball is in your court\" mean?', 'trac_nghiem'),
(171, 4, 'What does \"beat around the bush\" mean?', 'trac_nghiem'),
(172, 4, 'What does \"get out of hand\" mean?', 'trac_nghiem'),
(173, 4, 'What does \"call it a day\" mean?', 'trac_nghiem'),
(174, 4, 'What does \"cut corners\" mean?', 'trac_nghiem'),
(250, 6, 'Which tense is used for actions happening now?', 'trac_nghiem'),
(251, 6, 'What is the past tense of \"eat\"?', 'trac_nghiem'),
(252, 6, 'Which tense is used for future plans?', 'trac_nghiem'),
(253, 6, 'What is the present participle of \"run\"?', 'trac_nghiem'),
(254, 6, 'What tense is used to describe habits?', 'trac_nghiem'),
(255, 6, 'Which tense is used for completed actions?', 'trac_nghiem'),
(256, 6, 'What is the correct form of \"be\" in past tense?', 'trac_nghiem'),
(257, 6, 'What is the past tense of \"go\"?', 'trac_nghiem'),
(258, 6, 'Which tense is used to describe ongoing actions in the past?', 'trac_nghiem'),
(259, 6, 'What is the correct future form of \"will\"?', 'trac_nghiem'),
(260, 6, 'Which tense is used for actions happening at a specific time in the future?', 'trac_nghiem'),
(261, 6, 'What is the present perfect form of \"write\"?', 'trac_nghiem'),
(262, 6, 'What is the base form of \"was\"?', 'trac_nghiem'),
(263, 6, 'Which tense describes actions that were interrupted in the past?', 'trac_nghiem'),
(264, 6, 'Which tense uses \"has been\" + verb-ing?', 'trac_nghiem'),
(300, 7, 'What is the meaning of \"ubiquitous\"?', 'trac_nghiem'),
(301, 7, 'What is the synonym of \"meticulous\"?', 'trac_nghiem'),
(302, 7, 'What is the antonym of \"ambiguous\"?', 'trac_nghiem'),
(303, 7, 'What does \"ephemeral\" mean?', 'trac_nghiem'),
(304, 7, 'What is the synonym of \"benevolent\"?', 'trac_nghiem'),
(305, 7, 'What does \"incessant\" mean?', 'trac_nghiem'),
(306, 7, 'What is the antonym of \"diligent\"?', 'trac_nghiem'),
(307, 7, 'What does \"alleviate\" mean?', 'trac_nghiem'),
(308, 7, 'What is the meaning of \"precipice\"?', 'trac_nghiem'),
(309, 7, 'What does \"loquacious\" mean?', 'trac_nghiem'),
(400, 9, 'What is the antonym of \"happy\"?', 'trac_nghiem'),
(401, 9, 'What is the antonym of \"angry\"?', 'trac_nghiem'),
(402, 9, 'What is the antonym of \"big\"?', 'trac_nghiem'),
(403, 9, 'What is the antonym of \"small\"?', 'trac_nghiem'),
(404, 9, 'What is the antonym of \"fast\"?', 'trac_nghiem'),
(405, 9, 'What is the antonym of \"slow\"?', 'trac_nghiem'),
(406, 9, 'What is the antonym of \"kind\"?', 'trac_nghiem'),
(407, 9, 'What is the antonym of \"funny\"?', 'trac_nghiem'),
(408, 9, 'What is the antonym of \"bright\"?', 'trac_nghiem'),
(409, 9, 'What is the antonym of \"dark\"?', 'trac_nghiem'),
(410, 9, 'What is the antonym of \"strong\"?', 'trac_nghiem'),
(411, 9, 'What is the antonym of \"weak\"?', 'trac_nghiem'),
(412, 9, 'What is the antonym of \"hot\"?', 'trac_nghiem'),
(413, 9, 'What is the antonym of \"cold\"?', 'trac_nghiem'),
(414, 9, 'What is the antonym of \"rich\"?', 'trac_nghiem'),
(415, 9, 'What is the antonym of \"poor\"?', 'trac_nghiem'),
(416, 9, 'What is the antonym of \"clean\"?', 'trac_nghiem'),
(417, 9, 'What is the antonym of \"dirty\"?', 'trac_nghiem'),
(418, 9, 'What is the antonym of \"safe\"?', 'trac_nghiem'),
(419, 9, 'What is the antonym of \"dangerous\"?', 'trac_nghiem'),
(420, 9, 'What is the antonym of \"easy\"?', 'trac_nghiem'),
(421, 9, 'What is the antonym of \"hard\"?', 'trac_nghiem'),
(422, 9, 'What is the antonym of \"new\"?', 'trac_nghiem'),
(423, 9, 'What is the antonym of \"old\"?', 'trac_nghiem'),
(424, 9, 'What is the antonym of \"beautiful\"?', 'trac_nghiem'),
(425, 9, 'What is the antonym of \"ugly\"?', 'trac_nghiem'),
(426, 9, 'What is the antonym of \"quick\"?', 'trac_nghiem'),
(427, 9, 'What is the antonym of \"lazy\"?', 'trac_nghiem'),
(428, 9, 'What is the antonym of \"bright\"?', 'trac_nghiem'),
(429, 9, 'What is the antonym of \"sharp\"?', 'trac_nghiem'),
(430, 9, 'What is the antonym of \"soft\"?', 'trac_nghiem'),
(431, 9, 'What is the antonym of \"hard\"?', 'trac_nghiem'),
(432, 9, 'What is the antonym of \"strong\"?', 'trac_nghiem'),
(433, 9, 'What is the antonym of \"weak\"?', 'trac_nghiem'),
(434, 9, 'What is the antonym of \"simple\"?', 'trac_nghiem'),
(435, 9, 'What is the antonym of \"complex\"?', 'trac_nghiem'),
(436, 9, 'What is the antonym of \"tall\"?', 'trac_nghiem'),
(437, 9, 'What is the antonym of \"short\"?', 'trac_nghiem'),
(438, 9, 'What is the antonym of \"bright\"?', 'trac_nghiem'),
(439, 9, 'What is the antonym of \"dim\"?', 'trac_nghiem'),
(440, 9, 'What is the antonym of \"full\"?', 'trac_nghiem'),
(441, 9, 'What is the antonym of \"empty\"?', 'trac_nghiem'),
(442, 9, 'What is the antonym of \"clear\"?', 'trac_nghiem'),
(443, 9, 'What is the antonym of \"vague\"?', 'trac_nghiem'),
(444, 9, 'What is the antonym of \"light\"?', 'trac_nghiem'),
(461, 1, 'Some people think that learning English should focus on grammar, while others believe that communication skills are more important. Discuss both views and give your own opinion', 'tu_luan'),
(462, 37, 'Some people think that learning English should focus on grammar, while others believe that communication skills are more important. Discuss both views and give your own opinion', 'tu_luan'),
(463, 37, 'Many people believe that technology has made our lives easier, while others think it has made life more complicated. Discuss both views and give your opinion', 'tu_luan'),
(464, 37, 'What is the past tense of \"go\"?', 'trac_nghiem'),
(465, 37, 'Which word is a synonym of \"happy\"?', 'trac_nghiem'),
(466, 37, 'She is the woman ___ won the prize.', 'trac_nghiem'),
(469, 41, 'Write a short paragraph (about 100–120 words) about your favorite hobby', 'tu_luan'),
(471, 41, 'Write a paragraph (about 100–120 words) about your daily routine.', 'tu_luan');

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

CREATE TABLE `chat_history` (
  `id` int(11) NOT NULL,
  `id_hocvien` int(11) DEFAULT 0 COMMENT 'ID học viên (0 = guest)',
  `user_message` text NOT NULL COMMENT 'Tin nhắn của user',
  `bot_response` text NOT NULL COMMENT 'Phản hồi của bot',
  `chat_type` varchar(50) DEFAULT 'general' COMMENT 'Loại chat: ai_teaching, database_advice, hybrid, general',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lịch sử chat với AI chatbot';

--
-- Dumping data for table `chat_history`
--

INSERT INTO `chat_history` (`id`, `id_hocvien`, `user_message`, `bot_response`, `chat_type`, `created_at`) VALUES
(1, 1, 'xịn chào', 'Chào bạn! 👋 Mình là giáo viên AI của Fighter English Center, rất vui được hỗ trợ bạn học tiếng Anh. Bạn có câu hỏi gì không? Mình luôn sẵn sàng giải đáp một cách chi tiết và dễ hiểu nhất! 😉\n\n📚 **Giải đáp**:\n\n\"Xịn chào\" là một cách chào hỏi rất thân thiện và gần gũi trong tiếng Việt. Mình hiểu bạn muốn một lời chào tương tự trong tiếng Anh phải không? Dưới đây là một vài gợi ý nhé:\n\n*   **Hi!** (Chào!): Đây là cách chào đơn giản và phổ biến nhất.\n*   **Hey!** (Này!): Tương tự như \"Hi\", nhưng informal hơn một chút.\n*   **Hello!** (Xin chào!): Trang trọng hơn \"Hi\" và \"Hey\".\n*   **What\'s up?** (Có gì mới không?): Một cách chào hỏi rất casual, thường dùng với bạn bè.\n*   **How\'s it going?** (Dạo này thế nào?): Tương tự như \"What\'s up?\", hỏi thăm tình hình.\n\n📝 **Ví dụ**:\n\n*   \"Hi John, how are you?\" (Chào John, bạn khỏe không?)\n*   \"Hey Mary, what\'s up?\" (Này Mary, có gì mới không?)\n*   \"Hello everyone, welcome to the class!\" (Xin chào mọi người, chào mừng đến lớp học!)\n*   \"What\'s up, dude? Long time no see!\" (Có gì mới không, ông bạn? Lâu rồi không gặp!)\n*   \"How\'s it going, Sarah? Are you ready for the exam?\" (Dạo này thế nào, Sarah? Bạn đã sẵn sàng cho kỳ thi chưa?)\n\n💡 **Lưu ý**:\n\n*   Chọn cách chào phù hợp với ngữ cảnh và đối tượng giao tiếp. Ví dụ, \"Hello\" thích hợp hơn khi gặp người lớn tuổi hoặc trong môi trường trang trọng.\n*   Có thể kết hợp các lời chào khác nhau để tạo sự đa dạng.\n\n🎯 **Khuyến nghị**:\n\n*   Thực hành sử dụng các lời chào khác nhau trong các tình huống giao tiếp hàng ngày.\n*   Lắng nghe cách người bản xứ chào hỏi để học hỏi thêm những cách diễn đạt tự nhiên.\n*   Đừng ngại thử nghiệm và tìm ra phong cách chào hỏi phù hợp với bản thân!\n\nChúc bạn học tốt và có những cuộc trò chuyện tiếng Anh thật thú vị! ✨ Nếu bạn có bất kỳ câu hỏi nào khác, đừng ngần ngại hỏi mình nhé! ✅\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!', 'ai_teaching', '2025-10-16 18:16:06'),
(2, 1, 'các thì trong tiếng anh', 'Chào bạn học viên của Fighter English Center! Mình là giáo viên AI rất vui được giúp bạn tổng quan về các thì trong tiếng Anh nhé. Chúng ta cùng bắt đầu thôi! 💪\n\n📚 **Giải thích quy tắc**\n\nTrong tiếng Anh, \"thì\" (tense) cho biết thời điểm và trạng thái của hành động. Hiểu rõ các thì giúp bạn diễn đạt chính xác và tự tin hơn. Có 12 thì chính, chia thành 3 nhóm lớn: Quá khứ (Past), Hiện tại (Present), và Tương lai (Future). Mỗi nhóm lại có các dạng đơn (Simple), tiếp diễn (Continuous), hoàn thành (Perfect), và hoàn thành tiếp diễn (Perfect Continuous).\n\n✍️ **Cấu trúc**:\n\n*   **Thì đơn (Simple)**: Diễn tả hành động chung chung, thói quen, hoặc sự thật hiển nhiên.\n*   **Thì tiếp diễn (Continuous)**: Diễn tả hành động đang xảy ra tại một thời điểm cụ thể.\n*   **Thì hoàn thành (Perfect)**: Diễn tả hành động đã hoàn thành trước một thời điểm nào đó.\n*   **Thì hoàn thành tiếp diễn (Perfect Continuous)**: Diễn tả hành động đã xảy ra trong một khoảng thời gian và vẫn tiếp diễn đến hiện tại hoặc một thời điểm khác.\n\n📝 **Ví dụ**:\n\n*   **Hiện tại đơn (Simple Present)**:\n    *   She **reads** books every day. (Cô ấy đọc sách mỗi ngày.) - Thói quen\n*   **Hiện tại tiếp diễn (Present Continuous)**:\n    *   They **are playing** football now. (Bây giờ họ đang chơi bóng đá.) - Đang xảy ra\n*   **Quá khứ đơn (Simple Past)**:\n    *   I **visited** Paris last year. (Tôi đã thăm Paris năm ngoái.) - Đã xảy ra và kết thúc\n*   **Tương lai đơn (Simple Future)**:\n    *   He **will travel** to Japan next month. (Anh ấy sẽ đi du lịch Nhật Bản vào tháng tới.) - Sẽ xảy ra\n\n⚠️ **Lưu ý**:\n\n*   **Sự hòa hợp thì (Tense agreement)**: Đảm bảo các thì trong câu phức phải phù hợp với nhau về mặt thời gian.\n    *   Ví dụ: Sai: I **will go** to the store after I **finished** my homework.\n    *   Sửa: I **will go** to the store after I **finish** my homework. (Tôi sẽ đi đến cửa hàng sau khi tôi hoàn thành bài tập về nhà.)\n*   **Dấu hiệu nhận biết**: Mỗi thì thường có các trạng từ hoặc cụm từ chỉ thời gian đặc trưng.\n    *   Ví dụ: \"yesterday\" (hôm qua) thường đi với thì quá khứ đơn.\n\n💡 **Mẹo**:\n\n*   **Học theo sơ đồ tư duy**: Vẽ sơ đồ các thì, liên kết chúng với các mốc thời gian và ví dụ cụ thể.\n*   **Luyện tập thường xuyên**: Làm bài tập, viết nhật ký bằng tiếng Anh, hoặc tham gia các câu lạc bộ tiếng Anh để thực hành sử dụng các thì.\n*   **Sử dụng ứng dụng và trang web học tiếng Anh**: Có rất nhiều tài liệu và bài tập trực tuyến giúp bạn ôn luyện và kiểm tra kiến thức về các thì.\n\nChúc bạn học tốt và chinh phục thành công các thì trong tiếng Anh! Nếu có bất kỳ câu hỏi nào khác, đừng ngần ngại hỏi mình nhé! 😊\n\n🎯 **Muốn luyện tập thêm?** Hỏi tôi về bài tập hoặc ví dụ khác!', 'ai_teaching', '2025-10-16 18:17:05'),
(3, 1, 'Khóa học cho người mới', 'Chào bạn học viên mới của Fighter English Center! Mình là giáo viên AI của trung tâm, rất vui được hỗ trợ bạn trên hành trình chinh phục tiếng Anh! 😊\n\n📚 **Giải đáp**: Khóa học cho người mới bắt đầu tại Fighter English Center được thiết kế đặc biệt để giúp bạn xây dựng nền tảng vững chắc từ con số 0. Khóa học tập trung vào:\n\n*   **Phát âm cơ bản**: Học cách phát âm chuẩn các âm trong tiếng Anh, giúp bạn tự tin hơn khi giao tiếp. 🗣️\n*   **Từ vựng thông dụng**: Xây dựng vốn từ vựng cơ bản về các chủ đề quen thuộc trong cuộc sống hàng ngày. 📝\n*   **Ngữ pháp nền tảng**: Làm quen với các cấu trúc ngữ pháp đơn giản, giúp bạn hiểu và sử dụng câu một cách chính xác. ✅\n*   **Kỹ năng nghe - nói**: Luyện tập nghe các đoạn hội thoại ngắn và thực hành nói các câu đơn giản để tăng khả năng giao tiếp. 👂\n*   **Tương tác thực tế**: Tham gia các hoạt động nhóm, trò chơi và bài tập thực hành để áp dụng kiến thức đã học. 🤝\n\n📝 **Ví dụ**:\n\n*   **Phát âm**: Học cách phát âm âm /æ/ trong từ \"cat\" (con mèo).\n    *   Ví dụ: \"The cat is black.\" (Con mèo màu đen.)\n*   **Từ vựng**: Học các từ chỉ màu sắc (colors) như \"red\" (đỏ), \"blue\" (xanh lam), \"green\" (xanh lá cây).\n    *   Ví dụ: \"The sky is blue.\" (Bầu trời màu xanh lam.)\n*   **Ngữ pháp**: Học cấu trúc câu đơn giản \"I am...\" (Tôi là...).\n    *   Ví dụ: \"I am a student.\" (Tôi là một học sinh.)\n*   **Hội thoại**:\n    *   A: \"Hello, what is your name?\" (Xin chào, bạn tên là gì?)\n    *   B: \"My name is Linh. What is your name?\" (Tên tôi là Linh. Bạn tên là gì?)\n\n💡 **Lưu ý**:\n\n*   **Kiên trì**: Học tiếng Anh cần thời gian và sự kiên trì. Đừng nản lòng nếu bạn gặp khó khăn. 💪\n*   **Luyện tập thường xuyên**: Dành thời gian luyện tập mỗi ngày, ngay cả khi chỉ là 15-20 phút. ⏳\n*   **Tạo môi trường học tập**: Nghe nhạc tiếng Anh, xem phim có phụ đề, đọc truyện tranh tiếng Anh... để tạo môi trường học tập thú vị. 🎧 🎬 📚\n*   **Đừng sợ sai**: Sai lầm là một phần của quá trình học tập. Hãy sửa chữa và học hỏi từ những sai lầm đó. ❌\n\n🎯 **Khuyến nghị**:\n\n*   **Tham gia đầy đủ các buổi học**: Đừng bỏ lỡ bất kỳ buổi học nào để đảm bảo bạn không bị mất kiến thức.\n*   **Hoàn thành bài tập về nhà**: Làm bài tập về nhà giúp bạn củng cố kiến thức và rèn luyện kỹ năng.\n*   **Chủ động hỏi khi có thắc mắc**: Đừng ngại hỏi giáo viên hoặc trợ giảng nếu bạn có bất kỳ câu hỏi nào.\n*   **Kết nối với các bạn học khác**: Học cùng bạn bè giúp bạn có thêm động lực và cơ hội thực hành.\n\nChúc bạn có một khóa học thật hiệu quả và thú vị tại Fighter English Center! ✨\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!', 'ai_teaching', '2025-10-16 18:17:29'),
(4, 1, 'How to learn English effectively?', 'Chào bạn! 👋 Mình là giáo viên AI của Fighter English Center, rất vui được chia sẻ với bạn về cách học tiếng Anh hiệu quả nhé!\n\n📚 **Giải đáp**: Để học tiếng Anh hiệu quả, bạn cần kết hợp nhiều phương pháp và tạo ra một lộ trình học tập phù hợp với bản thân. Dưới đây là một số gợi ý:\n\n1.  **Xác định mục tiêu rõ ràng**: 🎯\n    *   Why do you want to learn English? (Bạn học tiếng Anh để làm gì?)\n    *   Ví dụ: Để giao tiếp với người nước ngoài, để xem phim không cần phụ đề, để phục vụ công việc...\n    *   Khi có mục tiêu, bạn sẽ có động lực hơn đó! ✨\n\n2.  **Học từ vựng theo ngữ cảnh**: 📝\n    *   Đừng chỉ học từ đơn lẻ, hãy học cả cụm từ, thành ngữ.\n    *   Ví dụ: Thay vì chỉ học \"happy\" (vui vẻ), hãy học \"happy birthday\" (chúc mừng sinh nhật) hoặc \"happy to help\" (rất vui được giúp đỡ).\n    *   Context giúp bạn nhớ từ vựng lâu hơn và biết cách sử dụng chúng chính xác hơn.\n\n3.  **Luyện tập ngữ pháp thường xuyên**: ✅\n    *   Hiểu rõ các cấu trúc ngữ pháp cơ bản.\n    *   Làm bài tập ngữ pháp để củng cố kiến thức.\n    *   Ví dụ: Học về thì hiện tại đơn (present simple) và luyện tập đặt câu với các động từ thường dùng.\n\n4.  **Nghe và nói tiếng Anh mỗi ngày**: 🗣️\n    *   Nghe podcast, xem phim, nghe nhạc bằng tiếng Anh.\n    *   Tìm bạn bè để luyện nói tiếng Anh cùng.\n    *   Đừng ngại mắc lỗi! ❌ Sai lầm là một phần của quá trình học tập.\n    *   Ví dụ: Nghe podcast về du lịch và cố gắng tóm tắt lại nội dung bằng tiếng Anh.\n\n5.  **Đọc và viết tiếng Anh thường xuyên**: 📚\n    *   Đọc sách, báo, truyện bằng tiếng Anh.\n    *   Viết nhật ký, email, hoặc các bài luận ngắn bằng tiếng Anh.\n    *   Ví dụ: Đọc một bài báo ngắn về tin tức thế giới và viết lại những ý chính bằng tiếng Anh.\n\n6.  **Tìm kiếm nguồn học liệu phù hợp**: 💡\n    *   Sách giáo trình, ứng dụng học tiếng Anh, website học tiếng Anh...\n    *   Ví dụ: Sử dụng ứng dụng Duolingo để học từ vựng và ngữ pháp, hoặc xem video trên YouTube của các kênh dạy tiếng Anh.\n\n📝 **Ví dụ**:\n\n*   \"I want to learn English to travel the world.\" (Tôi muốn học tiếng Anh để đi du lịch thế giới.)\n*   \"She is happy to help you with your homework.\" (Cô ấy rất vui được giúp bạn làm bài tập về nhà.)\n*   \"I listen to English podcasts every day to improve my listening skills.\" (Tôi nghe podcast tiếng Anh mỗi ngày để cải thiện kỹ năng nghe.)\n\n💡 **Lưu ý**:\n\n*   Hãy kiên trì và đừng bỏ cuộc!\n*   Tìm một người bạn đồng hành để cùng nhau học tập.\n*   Tạo ra một môi trường học tập thoải mái và vui vẻ.\n\n🎯 **Khuyến nghị**:\n\n*   Bắt đầu với những điều cơ bản và từ từ nâng cao trình độ.\n*   Đặt ra những mục tiêu nhỏ và ăn mừng khi đạt được chúng.\n*   Tìm niềm vui trong việc học tiếng Anh!\n\nChúc bạn học tốt! Fighting! 💪\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!', 'ai_teaching', '2025-10-16 18:25:02'),
(5, 1, 'Thông tin liên hệ', '📞 **Thông tin liên hệ Fighter English Center:**\n\n🏢 **Địa chỉ:**\n   123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh\n\n📱 **Hotline & Zalo:**\n   • **Tư vấn:** 0962.501.832\n   • **Hỗ trợ:** 0336.123.130\n\n📧 **Email:**\n   info@tienganfighter.com\n\n🌐 **Website:**\n   www.tienganfighter.com\n\n📘 **Mạng xã hội:**\n   • Facebook: Tiếng Anh Fighter\n   • Instagram: @fighter_english\n\n⏰ **Giờ làm việc:**\n   • Thứ 2 - Thứ 6: 8:00 - 21:00\n   • Thứ 7 - Chủ nhật: 8:00 - 18:00\n\n💬 **Hoặc chat trực tiếp với tôi - tôi luôn sẵn sàng 24/7!**', 'database_advice', '2025-10-16 18:31:18'),
(6, 1, 'Học phí các khóa học', '📚 **Các khóa học tại Fighter English Center:**\n\n**1.  Khóa học TOEIC 4 KỸ NĂNG**\n   📝 Kh&amp;oacute;a học TOEIC 4 kỹ năng bao gồm luyện tập cả 4 kỹ năng nghe, n&amp;oacute;i, đọc v&amp;agrave; viết, nhằm gi&amp;uacute;p học vi&amp;ecirc;n cải thiện khả năn...\n   💰 Học phí: 2.500.000đ\n   ⭐⭐⭐⭐⭐ Đánh giá: 5.0/5\n   👥 Có 2 lớp đang mở\n\n**2. Khóa học tiếng Anh cho người mất gốc**\n   📝 Kh&amp;oacute;a học tiếng anh online cho người mất gốc l&amp;agrave; kh&amp;oacute;a học được thiết kế d&amp;agrave;nh ri&amp;ecirc;ng cho những người bắt đầu học tiếng A...\n   💰 Học phí: 2.000đ\n   ⭐⭐⭐⭐⭐ Đánh giá: 5.0/5\n   👥 Có 2 lớp đang mở\n\n**3. Khóa học tiếng Anh cho người mới bắt đầu**\n   📝 Kh&amp;oacute;a học tiếng Anh cho người mới bắt đầu l&amp;agrave; một kh&amp;oacute;a học d&amp;agrave;nh cho những người mất gốc hoặc những người đ&amp;atilde; học một &amp;...\n   ⏱️ Thời lượng: 1 buổi học\n   💰 Học phí: 2.000đ\n   👥 Có 2 lớp đang mở\n\n**4. Khóa học IELTS online 4 kỹ năng**\n   📝 Luyện thi IELTS ch&amp;iacute;nh l&amp;agrave; một trận chiến đ&amp;ograve;i hỏi sự nỗ lực, ki&amp;ecirc;n tr&amp;igrave; của mỗi người để tiếp thu v&amp;agrave; đạt được ban...\n   ⏱️ Thời lượng: 16 buổi học\n   💰 Học phí: 2.800.000đ\n   👥 Có 2 lớp đang mở\n\n**5. Khóa học IELTS từ 0-7+ kèm chấm chữa giáo viên bản ngữ**\n   📝 Kh&amp;oacute;a học IELTS Fundamentals: Grammar and Vocabulary for IELTS hướng đến đối tượng c&amp;aacute;c bạn đang ở tr&amp;igrave;nh độ sơ cấp (tương đương A1-...\n   💰 Học phí: 2.500.000đ\n   👥 Có 1 lớp đang mở\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n🎯 **Muốn biết thêm chi tiết?**\n• Hỏi về khóa học cụ thể\n• Hỏi về học phí và ưu đãi\n• Gọi ngay: **0962.501.832**\n• Hoặc đăng ký học thử miễn phí!', 'database_advice', '2025-10-16 18:31:23'),
(7, 1, 'Tư vấn khóa học phù hợp cho tôi', 'Chào bạn học viên thân mến! Mình là trợ lý ảo từ Fighter English Center, rất vui được tư vấn cho bạn về các khóa học phù hợp nhé! 😊\n\n📚 **Giải đáp**: Để tư vấn khóa học phù hợp nhất, mình cần một vài thông tin về trình độ hiện tại và mục tiêu học tập của bạn. Dưới đây là một số khóa học phổ biến tại Fighter English Center và đối tượng phù hợp:\n\n*   **Khóa học cho người mới bắt đầu (Beginner/Elementary):**\n    *   Đối tượng: Người chưa có kiến thức nền tảng về tiếng Anh hoặc kiến thức rất cơ bản.\n    *   Mục tiêu: Xây dựng nền tảng vững chắc về từ vựng, ngữ pháp cơ bản, luyện phát âm và giao tiếp đơn giản.\n    *   Ví dụ: Học các thì cơ bản (hiện tại đơn, quá khứ đơn, tương lai đơn), các chủ đề quen thuộc (gia đình, bạn bè, công việc).\n*   **Khóa học tiếng Anh giao tiếp (Communication):**\n    *   Đối tượng: Người có kiến thức nền tảng nhưng muốn cải thiện khả năng giao tiếp tự tin và trôi chảy.\n    *   Mục tiêu: Luyện tập phản xạ, mở rộng vốn từ vựng và ngữ pháp, học các mẫu câu giao tiếp thông dụng.\n    *   Ví dụ: Tham gia các hoạt động role-play, thảo luận nhóm, thuyết trình ngắn.\n*   **Khóa học luyện thi IELTS/TOEIC:**\n    *   Đối tượng: Người có mục tiêu đạt chứng chỉ IELTS/TOEIC để phục vụ học tập, công việc hoặc định cư.\n    *   Mục tiêu: Nắm vững cấu trúc bài thi, luyện các kỹ năng làm bài (Listening, Reading, Writing, Speaking), làm quen với các dạng đề thi.\n    *   Ví dụ: Luyện tập viết essay IELTS, luyện nghe các bài TOEIC part 3&4.\n*   **Khóa học tiếng Anh chuyên ngành (Business English, IT English,...):**\n    *   Đối tượng: Người muốn nâng cao khả năng sử dụng tiếng Anh trong lĩnh vực chuyên môn của mình.\n    *   Mục tiêu: Học từ vựng, ngữ pháp và các kỹ năng giao tiếp liên quan đến ngành nghề cụ thể.\n    *   Ví dụ: Học cách viết email chuyên nghiệp, thuyết trình dự án bằng tiếng Anh.\n\n📝 **Ví dụ**:\n\n*   Nếu bạn hoàn toàn mới bắt đầu, bạn có thể nói: \"I\'m a beginner. I don\'t know anything about English.\" (Tôi là người mới bắt đầu. Tôi không biết gì về tiếng Anh cả.)\n*   Nếu bạn muốn cải thiện khả năng giao tiếp, bạn có thể nói: \"I want to improve my speaking skills so I can communicate with foreigners.\" (Tôi muốn cải thiện kỹ năng nói để có thể giao tiếp với người nước ngoài.)\n*   Nếu bạn muốn luyện thi IELTS, bạn có thể nói: \"I want to take the IELTS exam to study abroad.\" (Tôi muốn thi IELTS để đi du học.)\n\n💡 **Lưu ý**: Để xác định trình độ chính xác, bạn có thể làm bài kiểm tra đầu vào tại Fighter English Center. Bài kiểm tra này sẽ giúp đánh giá các kỹ năng của bạn và đưa ra lộ trình học phù hợp.\n\n🎯 **Khuyến nghị**:\n\n*   Hãy xác định rõ mục tiêu học tập của bạn: Bạn muốn học tiếng Anh để làm gì? (giao tiếp, học tập, công việc,...)\n*   Tìm hiểu kỹ về các khóa học tại Fighter English Center và so sánh với mục tiêu của bạn.\n*   Đừng ngần ngại liên hệ với trung tâm để được tư vấn chi tiết hơn.\n\nChúc bạn tìm được khóa học phù hợp và đạt được thành công trên con đường chinh phục tiếng Anh! 💪\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!', 'ai_teaching', '2025-10-16 18:31:39'),
(8, 1, 'danh sách các khóa học', 'Chào bạn học viên Fighter English Center! Mình là giáo viên AI chuyên nghiệp của trung tâm, rất vui được hỗ trợ bạn tìm hiểu về các khóa học nhé! 😊\n\n📚 **Giải đáp**: Dưới đây là danh sách các khóa học mà Fighter English Center cung cấp, được thiết kế để đáp ứng nhu cầu học tập đa dạng của học viên:\n\n1.  **Khóa học Tiếng Anh cho Người Mới Bắt Đầu (English for Beginners)**\n\n    *   Mục tiêu: Xây dựng nền tảng tiếng Anh vững chắc, làm quen với các kiến thức cơ bản về ngữ pháp, từ vựng và phát âm.\n    *   Đối tượng: Người chưa từng học tiếng Anh hoặc mất gốc.\n2.  **Khóa học Tiếng Anh Giao Tiếp (Communicative English)**\n\n    *   Mục tiêu: Phát triển kỹ năng nghe, nói, giúp học viên tự tin giao tiếp trong các tình huống hàng ngày.\n    *   Đối tượng: Người có kiến thức tiếng Anh cơ bản, muốn cải thiện khả năng giao tiếp.\n3.  **Khóa học Luyện Thi IELTS/TOEFL**\n\n    *   Mục tiêu: Trang bị kiến thức, kỹ năng và chiến thuật làm bài thi IELTS/TOEFL, giúp học viên đạt điểm số mong muốn.\n    *   Đối tượng: Người có nhu cầu du học, làm việc hoặc định cư ở nước ngoài.\n4.  **Khóa học Tiếng Anh Thương Mại (Business English)**\n\n    *   Mục tiêu: Nâng cao khả năng sử dụng tiếng Anh trong môi trường làm việc, giúp học viên tự tin giao tiếp và làm việc hiệu quả với đối tác quốc tế.\n    *   Đối tượng: Người đi làm, sinh viên chuyên ngành kinh tế, quản trị kinh doanh.\n5.  **Khóa học Tiếng Anh Trẻ Em (English for Kids)**\n\n    *   Mục tiêu: Tạo môi trường học tập vui vẻ, giúp trẻ em làm quen với tiếng Anh một cách tự nhiên và hiệu quả.\n    *   Đối tượng: Trẻ em từ 4-12 tuổi.\n6.  **Khóa học Tiếng Anh Online 1 kèm 1 (1-on-1 Online English)**\n\n    *   Mục tiêu: Cá nhân hóa lộ trình học tập, tập trung vào điểm yếu của học viên và giúp họ tiến bộ nhanh chóng.\n    *   Đối tượng: Tất cả các đối tượng học viên có nhu cầu học tiếng Anh một cách chuyên sâu và linh hoạt.\n\n📝 **Ví dụ**:\n\n*   \"I\'m taking the **Communicative English** course to improve my speaking skills.\" (Tôi đang tham gia khóa học Tiếng Anh Giao Tiếp để cải thiện kỹ năng nói của mình.)\n*   \"She enrolled in the **IELTS preparation course** to study abroad.\" (Cô ấy đăng ký khóa học luyện thi IELTS để đi du học.)\n*   \"My son loves the **English for Kids** program at Fighter English Center.\" (Con trai tôi rất thích chương trình Tiếng Anh Trẻ Em tại Fighter English Center.)\n\n💡 **Lưu ý**:\n\n*   Các khóa học có thể có nhiều cấp độ khác nhau, phù hợp với trình độ của từng học viên.\n*   Bạn nên liên hệ trực tiếp với trung tâm để được tư vấn chi tiết và kiểm tra trình độ trước khi đăng ký khóa học.\n\n🎯 **Khuyến nghị**:\n\n*   Hãy xác định rõ mục tiêu học tập của bạn để chọn khóa học phù hợp nhất.\n*   Tham gia các buổi học thử để trải nghiệm phương pháp giảng dạy và môi trường học tập tại Fighter English Center.\n*   Đừng ngần ngại đặt câu hỏi cho giáo viên và nhân viên tư vấn để được giải đáp mọi thắc mắc.\n\nChúc bạn học tập hiệu quả và đạt được những thành công trong việc chinh phục tiếng Anh! ✨📚\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!', 'ai_teaching', '2025-10-16 18:32:16'),
(9, 1, 'tất cả các khóa học mà website mình có', 'Chào bạn học viên Fighter English Center! Mình là giáo viên AI rất vui được hỗ trợ bạn tìm hiểu về các khóa học tại trung tâm. Dưới đây là thông tin chi tiết về các khóa học hiện có, được thiết kế để đáp ứng nhu cầu học tập đa dạng của học viên:\n\n📚 **Giải đáp**: Các khóa học tại Fighter English Center được chia thành nhiều cấp độ và mục tiêu khác nhau, bao gồm:\n\n*   **Khóa học tiếng Anh tổng quát (General English):**\n    *   Dành cho mọi trình độ từBeginner đến Advanced.\n    *   Tập trung phát triển toàn diện 4 kỹ năng: Nghe, Nói, Đọc, Viết.\n*   **Khóa học tiếng Anh giao tiếp (Communication English):**\n    *   Chú trọng luyện tập kỹ năng giao tiếp tự tin và hiệu quả trong các tình huống thực tế.\n    *   Phù hợp với người muốn cải thiện khả năng giao tiếp trong công việc và cuộc sống hàng ngày.\n*   **Khóa học luyện thi IELTS/TOEIC:**\n    *   Cung cấp kiến thức và kỹ năng cần thiết để đạt điểm cao trong các kỳ thi quốc tế.\n    *   Luyện tập các dạng bài thi, chiến thuật làm bài và mẹo đạt điểm tối ưu.\n*   **Khóa học tiếng Anh cho trẻ em (Kids English):**\n    *   Dành cho trẻ em từ 4-12 tuổi.\n    *   Phương pháp giảng dạy sinh động, kết hợp trò chơi và hoạt động tương tác giúp trẻ học tiếng Anh một cách tự nhiên và hứng thú.\n*   **Khóa học tiếng Anh trực tuyến (Online English):**\n    *   Linh hoạt về thời gian và địa điểm học tập.\n    *   Học viên có thể học mọi lúc mọi nơi thông qua các nền tảng trực tuyến.\n*   **Khóa học tiếng Anh doanh nghiệp (Business English):**\n    *   Dành cho các doanh nghiệp muốn nâng cao trình độ tiếng Anh cho nhân viên.\n    *   Nội dung học tập được thiết kế theo yêu cầu của từng doanh nghiệp.\n\n📝 **Ví dụ**:\n\n*   **General English:** \"I am taking a general English course to improve my overall language skills.\" (Tôi đang tham gia một khóa học tiếng Anh tổng quát để cải thiện các kỹ năng ngôn ngữ của mình.)\n*   **Communication English:** \"She enrolled in a communication English class to become more fluent in speaking.\" (Cô ấy đăng ký một lớp tiếng Anh giao tiếp để trở nên trôi chảy hơn trong việc nói.)\n*   **IELTS:** \"He is preparing for the IELTS exam with a specialized course.\" (Anh ấy đang chuẩn bị cho kỳ thi IELTS với một khóa học chuyên biệt.)\n*   **Kids English:** \"My daughter loves her kids English lessons because they are fun and interactive.\" (Con gái tôi thích các bài học tiếng Anh trẻ em của mình vì chúng rất vui và có tính tương tác cao.)\n\n💡 **Lưu ý**: Để biết thêm thông tin chi tiết về nội dung, học phí và lịch khai giảng của từng khóa học, bạn vui lòng truy cập trang web của Fighter English Center hoặc liên hệ trực tiếp với bộ phận tư vấn nhé!\n\n🎯 **Khuyến nghị**:\n\n*   Hãy xác định rõ mục tiêu học tập của bạn để chọn khóa học phù hợp nhất.\n*   Tham khảo ý kiến của các tư vấn viên để được tư vấn và hỗ trợ tốt nhất.\n*   Đừng ngần ngại đặt câu hỏi nếu bạn có bất kỳ thắc mắc nào về các khóa học.\n\nChúc bạn có những trải nghiệm học tập thật hiệu quả và thú vị tại Fighter English Center! ✨\n\n🎯 **Có câu hỏi nào khác không?** Cứ thoải mái hỏi tôi nhé!', 'ai_teaching', '2025-10-16 18:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `dangkykhoahoc`
--

CREATE TABLE `dangkykhoahoc` (
  `id_dangky` int(11) NOT NULL,
  `id_hocvien` int(11) DEFAULT NULL,
  `id_khoahoc` int(11) DEFAULT NULL,
  `ngay_dangky` date DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT NULL,
  `thoi_gian_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_lop` varchar(50) DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL COMMENT 'Ghi chú của học viên khi đăng ký không có lớp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dangkykhoahoc`
--

INSERT INTO `dangkykhoahoc` (`id_dangky`, `id_hocvien`, `id_khoahoc`, `ngay_dangky`, `trang_thai`, `thoi_gian_tao`, `id_lop`, `ghi_chu`) VALUES
(110, 1, 32, '2025-10-06', 'bi tu choi', '2025-10-06 11:57:20', NULL, NULL),
(111, 27, 32, '2025-10-13', 'da xac nhan', '2025-10-13 17:07:26', 'BASIC-01-25', NULL),
(112, 27, 35, '2025-10-13', 'da xac nhan', '2025-10-13 20:19:50', 'KIDS-01-25', NULL),
(113, 1, 38, '2025-10-14', 'da xac nhan', '2025-10-14 09:28:22', 'TOEIC-4S-01-25', NULL),
(114, 1, 32, '2025-10-14', 'da xac nhan', '2025-10-14 21:05:27', 'BASIC-01-25', NULL),
(115, 1, 42, '2025-10-16', 'cho xac nhan', '2025-10-16 18:22:10', 'IELTS-0-7-01-25', NULL);

--
-- Triggers `dangkykhoahoc`
--
DELIMITER $$
CREATE TRIGGER `after_dangkykhoahoc_update_final` AFTER UPDATE ON `dangkykhoahoc` FOR EACH ROW BEGIN
    -- Kịch bản 1: Học viên được xác nhận VÀ xếp vào một lớp CÙNG LÚC.
    IF OLD.trang_thai != 'da xac nhan' AND NEW.trang_thai = 'da xac nhan' AND NEW.id_lop IS NOT NULL THEN
        UPDATE lop_hoc SET so_luong_hoc_vien = so_luong_hoc_vien + 1 WHERE id_lop = NEW.id_lop;
        SET @total_sessions = (SELECT COUNT(*) FROM lichhoc WHERE id_lop = NEW.id_lop);
        INSERT INTO tien_do_hoc_tap (id_hocvien, id_khoahoc, id_lop, tong_so_buoi, so_buoi_da_tham_gia, tien_do)
        VALUES (NEW.id_hocvien, NEW.id_khoahoc, NEW.id_lop, @total_sessions, 0, 0);
    END IF;

    -- Kịch bản 2: Admin quản lý học viên ĐÃ ĐƯỢC XÁC NHẬN từ trước.
    IF OLD.trang_thai = 'da xac nhan' AND NEW.trang_thai = 'da xac nhan' THEN
        
        -- A. Admin THÊM học viên đang chờ vào một lớp (LOGIC MỚI ĐƯỢC BỔ SUNG).
        IF OLD.id_lop IS NULL AND NEW.id_lop IS NOT NULL THEN
            UPDATE lop_hoc SET so_luong_hoc_vien = so_luong_hoc_vien + 1 WHERE id_lop = NEW.id_lop;
            SET @total_sessions = (SELECT COUNT(*) FROM lichhoc WHERE id_lop = NEW.id_lop);
            INSERT INTO tien_do_hoc_tap (id_hocvien, id_khoahoc, id_lop, tong_so_buoi, so_buoi_da_tham_gia, tien_do)
            VALUES (NEW.id_hocvien, NEW.id_khoahoc, NEW.id_lop, @total_sessions, 0, 0);
        END IF;

        -- B. Admin XÓA học viên khỏi lớp (id_lop chuyển về NULL).
        IF OLD.id_lop IS NOT NULL AND NEW.id_lop IS NULL THEN
            UPDATE lop_hoc SET so_luong_hoc_vien = so_luong_hoc_vien - 1 WHERE id_lop = OLD.id_lop;
            DELETE FROM tien_do_hoc_tap WHERE id_hocvien = OLD.id_hocvien AND id_lop = OLD.id_lop;
        END IF;
        
        -- C. Admin CHUYỂN học viên từ lớp A sang lớp B.
        IF OLD.id_lop IS NOT NULL AND NEW.id_lop IS NOT NULL AND OLD.id_lop != NEW.id_lop THEN
            UPDATE lop_hoc SET so_luong_hoc_vien = so_luong_hoc_vien - 1 WHERE id_lop = OLD.id_lop;
            UPDATE lop_hoc SET so_luong_hoc_vien = so_luong_hoc_vien + 1 WHERE id_lop = NEW.id_lop;
            DELETE FROM tien_do_hoc_tap WHERE id_hocvien = OLD.id_hocvien AND id_lop = OLD.id_lop;
            SET @new_total_sessions = (SELECT COUNT(*) FROM lichhoc WHERE id_lop = NEW.id_lop);
            INSERT INTO tien_do_hoc_tap (id_hocvien, id_khoahoc, id_lop, tong_so_buoi, so_buoi_da_tham_gia, tien_do)
            VALUES (NEW.id_hocvien, NEW.id_khoahoc, NEW.id_lop, @new_total_sessions, 0, 0);
        END IF;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `danhgiakhoahoc`
--

CREATE TABLE `danhgiakhoahoc` (
  `id_danhgia` int(11) NOT NULL,
  `id_hocvien` int(11) DEFAULT NULL,
  `id_khoahoc` int(11) DEFAULT NULL,
  `diem_danhgia` int(11) DEFAULT NULL CHECK (`diem_danhgia` between 1 and 5),
  `nhan_xet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhgiakhoahoc`
--

INSERT INTO `danhgiakhoahoc` (`id_danhgia`, `id_hocvien`, `id_khoahoc`, `diem_danhgia`, `nhan_xet`) VALUES
(6, 1, 38, 5, 'aaa'),
(7, 1, 32, 5, 'aa');

--
-- Triggers `danhgiakhoahoc`
--
DELIMITER $$
CREATE TRIGGER `capnhat_danh_gia_tb_delete` AFTER DELETE ON `danhgiakhoahoc` FOR EACH ROW BEGIN
    DECLARE tb DECIMAL(3,2);
    SELECT IFNULL(AVG(diem_danhgia), NULL) INTO tb
    FROM danhgiakhoahoc
    WHERE id_khoahoc = OLD.id_khoahoc;

    UPDATE khoahoc
    SET danh_gia_tb = tb
    WHERE id_khoahoc = OLD.id_khoahoc;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `capnhat_danh_gia_tb_insert_update` AFTER INSERT ON `danhgiakhoahoc` FOR EACH ROW BEGIN
    DECLARE tb DECIMAL(3,2);
    SELECT IFNULL(AVG(diem_danhgia), NULL) INTO tb
    FROM danhgiakhoahoc
    WHERE id_khoahoc = NEW.id_khoahoc;

    UPDATE khoahoc
    SET danh_gia_tb = tb
    WHERE id_khoahoc = NEW.id_khoahoc;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dapan`
--

CREATE TABLE `dapan` (
  `id_dapan` int(11) NOT NULL,
  `id_cauhoi` int(11) DEFAULT NULL,
  `id_baitest` int(11) DEFAULT NULL,
  `noi_dung_dapan` varchar(255) DEFAULT NULL,
  `la_dung` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dapan`
--

INSERT INTO `dapan` (`id_dapan`, `id_cauhoi`, `id_baitest`, `noi_dung_dapan`, `la_dung`) VALUES
(1, 1, 1, 'went', 1),
(2, 1, 1, 'goes', 0),
(3, 1, 1, 'gone', 0),
(4, 2, 1, 'joyful', 1),
(5, 2, 1, 'angry', 0),
(6, 2, 1, 'sad', 0),
(7, 3, 1, 'children', 1),
(8, 3, 1, 'childs', 0),
(9, 3, 1, 'childes', 0),
(10, 4, 1, 'an', 1),
(11, 4, 1, 'a', 0),
(12, 4, 1, 'the', 0),
(13, 5, 1, 'She runs every morning.', 1),
(14, 5, 1, 'She run every morning.', 0),
(15, 5, 1, 'She running every morning.', 0),
(16, 6, 1, 'better', 1),
(17, 6, 1, 'best', 0),
(18, 6, 1, 'goodest', 0),
(19, 7, 1, 'run', 1),
(20, 7, 1, 'beautiful', 0),
(21, 7, 1, 'big', 0),
(22, 8, 1, 'cold', 1),
(23, 8, 1, 'warm', 0),
(24, 8, 1, 'hot', 0),
(25, 9, 1, 'A', 1),
(26, 9, 1, 'a', 0),
(27, 9, 1, 'AA', 0),
(28, 10, 1, 'book', 1),
(29, 10, 1, 'run', 0),
(30, 10, 1, 'happy', 0),
(31, 11, 1, 'beautiful', 1),
(32, 11, 1, 'beautyful', 0),
(33, 11, 1, 'beutiful', 0),
(34, 12, 1, 'study', 1),
(35, 12, 1, 'studying', 0),
(36, 12, 1, 'studied', 0),
(58, 20, 1, 'they are', 1),
(59, 20, 1, 'they were', 0),
(60, 20, 1, 'they have', 0),
(300, 60, NULL, 'Joyful', 1),
(301, 60, NULL, 'Sad', 0),
(302, 60, NULL, 'Quick', 0),
(303, 61, NULL, 'Small', 1),
(304, 61, NULL, 'Tiny', 0),
(305, 61, NULL, 'Happy', 0),
(306, 62, NULL, 'Table', 1),
(307, 62, NULL, 'Quickly', 0),
(308, 62, NULL, 'Run', 0),
(309, 63, NULL, 'Run', 1),
(310, 63, NULL, 'Table', 0),
(311, 63, NULL, 'Happy', 0),
(312, 64, NULL, 'Children', 1),
(313, 64, NULL, 'Childs', 0),
(314, 64, NULL, 'Childrens', 0),
(315, 65, NULL, 'Jump', 1),
(316, 65, NULL, 'Joyful', 0),
(317, 65, NULL, 'House', 0),
(318, 66, NULL, 'Mad', 1),
(319, 66, NULL, 'Joyful', 0),
(320, 66, NULL, 'Quick', 0),
(321, 67, NULL, 'Slow', 1),
(322, 67, NULL, 'Quick', 0),
(323, 67, NULL, 'Fast', 0),
(324, 68, NULL, 'Beautiful', 1),
(325, 68, NULL, 'Run', 0),
(326, 68, NULL, 'Jump', 0),
(327, 69, NULL, 'Rain', 1),
(328, 69, NULL, 'Run', 0),
(329, 69, NULL, 'House', 0),
(330, 70, NULL, 'On', 1),
(331, 70, NULL, 'Jump', 0),
(332, 70, NULL, 'Beautiful', 0),
(333, 71, NULL, 'Ran', 1),
(334, 71, NULL, 'Running', 0),
(335, 71, NULL, 'Runs', 0),
(336, 72, NULL, 'Kind', 1),
(337, 72, NULL, 'Happy', 0),
(338, 72, NULL, 'Mad', 0),
(339, 73, NULL, 'Huge', 1),
(340, 73, NULL, 'Quick', 0),
(341, 73, NULL, 'Happy', 0),
(342, 74, NULL, 'Freezing', 1),
(343, 74, NULL, 'Hot', 0),
(344, 74, NULL, 'Mad', 0),
(345, 75, NULL, 'Soft', 1),
(346, 75, NULL, 'Hard', 0),
(347, 75, NULL, 'Rough', 0),
(348, 76, NULL, 'Calm', 1),
(349, 76, NULL, 'Mad', 0),
(350, 76, NULL, 'Quick', 0),
(351, 77, NULL, 'And', 1),
(352, 77, NULL, 'On', 0),
(353, 77, NULL, 'Jump', 0),
(354, 78, NULL, 'Wow', 1),
(355, 78, NULL, 'Run', 0),
(356, 78, NULL, 'Beautiful', 0),
(357, 79, NULL, 'Rainfall', 1),
(358, 79, NULL, 'House', 0),
(359, 79, NULL, 'Run', 0),
(360, 80, NULL, 'Warm', 1),
(361, 80, NULL, 'Cold', 0),
(362, 80, NULL, 'Mad', 0),
(363, 81, NULL, 'Hardworking', 1),
(364, 81, NULL, 'Lazy', 0),
(365, 81, NULL, 'Mad', 0),
(366, 82, NULL, 'The', 1),
(367, 82, NULL, 'Beautiful', 0),
(368, 82, NULL, 'Rain', 0),
(369, 83, NULL, 'Pretty', 1),
(370, 83, NULL, 'Rough', 0),
(371, 83, NULL, 'Mad', 0),
(372, 84, NULL, 'Sad', 1),
(373, 84, NULL, 'Happy', 0),
(374, 84, NULL, 'Quick', 0),
(400, 100, NULL, 'An', 1),
(401, 100, NULL, 'A', 0),
(402, 100, NULL, 'The', 0),
(403, 101, NULL, 'She', 1),
(404, 101, NULL, 'Apple', 0),
(405, 101, NULL, 'Quickly', 0),
(406, 102, NULL, 'Went', 1),
(407, 102, NULL, 'Goes', 0),
(408, 102, NULL, 'Gone', 0),
(409, 103, NULL, 'Quickly', 1),
(410, 103, NULL, 'Run', 0),
(411, 103, NULL, 'House', 0),
(412, 104, NULL, 'Mice', 1),
(413, 104, NULL, 'Mouse', 0),
(414, 104, NULL, 'Mouses', 0),
(415, 105, NULL, 'I am eating lunch.', 1),
(416, 105, NULL, 'I eats lunch.', 0),
(417, 105, NULL, 'I eaten lunch.', 0),
(418, 106, NULL, 'Swiftly', 1),
(419, 106, NULL, 'Slowly', 0),
(420, 106, NULL, 'Happy', 0),
(421, 107, NULL, 'Wow', 1),
(422, 107, NULL, 'Run', 0),
(423, 107, NULL, 'Beautiful', 0),
(424, 108, NULL, 'Bad', 1),
(425, 108, NULL, 'Great', 0),
(426, 108, NULL, 'Amazing', 0),
(427, 109, NULL, 'Receive', 1),
(428, 109, NULL, 'Recieve', 0),
(429, 109, NULL, 'Recive', 0),
(430, 110, NULL, 'And', 1),
(431, 110, NULL, 'On', 0),
(432, 110, NULL, 'Table', 0),
(433, 111, NULL, 'At', 1),
(434, 111, NULL, 'In', 0),
(435, 111, NULL, 'To', 0),
(436, 112, NULL, 'Kind', 1),
(437, 112, NULL, 'Sad', 0),
(438, 112, NULL, 'Quick', 0),
(439, 113, NULL, 'Car', 1),
(440, 113, NULL, 'House', 0),
(441, 113, NULL, 'Table', 0),
(442, 114, NULL, 'She is reading a book.', 1),
(443, 114, NULL, 'She read a book.', 0),
(444, 114, NULL, 'She reads a booked.', 0),
(445, 115, NULL, 'People', 1),
(446, 115, NULL, 'Persons', 0),
(447, 115, NULL, 'Peoples', 0),
(448, 116, NULL, 'Beautiful', 1),
(449, 116, NULL, 'Run', 0),
(450, 116, NULL, 'Car', 0),
(451, 117, NULL, 'Tiny', 1),
(452, 117, NULL, 'Big', 0),
(453, 117, NULL, 'Quick', 0),
(454, 118, NULL, 'Table', 1),
(455, 118, NULL, 'Quickly', 0),
(456, 118, NULL, 'Happy', 0),
(457, 119, NULL, 'Hopeful', 1),
(458, 119, NULL, 'Sad', 0),
(459, 119, NULL, 'Fast', 0),
(460, 120, NULL, 'Jump', 1),
(461, 120, NULL, 'Table', 0),
(462, 120, NULL, 'Joyful', 0),
(463, 121, NULL, 'Late', 1),
(464, 121, NULL, 'Early', 0),
(465, 121, NULL, 'Soon', 0),
(466, 122, NULL, 'School', 1),
(467, 122, NULL, 'Happy', 0),
(468, 122, NULL, 'Run', 0),
(469, 123, NULL, 'Pretty', 1),
(470, 123, NULL, 'Mad', 0),
(471, 123, NULL, 'Fast', 0),
(472, 124, NULL, 'Dirty', 1),
(473, 124, NULL, 'Clean', 0),
(474, 124, NULL, 'Quick', 0),
(475, 125, NULL, 'Huge', 1),
(476, 125, NULL, 'Fast', 0),
(477, 125, NULL, 'Small', 0),
(478, 126, NULL, 'Caring', 1),
(479, 126, NULL, 'Angry', 0),
(480, 126, NULL, 'Slow', 0),
(481, 127, NULL, 'The book was read by her.', 1),
(482, 127, NULL, 'She reads the book.', 0),
(483, 127, NULL, 'The book read by her.', 0),
(484, 128, NULL, 'Weak', 1),
(485, 128, NULL, 'Strong', 0),
(486, 128, NULL, 'Happy', 0),
(487, 129, NULL, 'The', 1),
(488, 129, NULL, 'Beautiful', 0),
(489, 129, NULL, 'Quick', 0),
(500, 150, NULL, 'Something very easy', 1),
(501, 150, NULL, 'A delicious cake', 0),
(502, 150, NULL, 'A piece of art', 0),
(503, 150, NULL, 'A challenging task', 0),
(504, 151, NULL, 'Reveal a secret', 1),
(505, 151, NULL, 'Make a mess', 0),
(506, 151, NULL, 'Start cooking', 0),
(507, 151, NULL, 'Hide something', 0),
(508, 152, NULL, 'Start a conversation', 1),
(509, 152, NULL, 'Destroy something', 0),
(510, 152, NULL, 'Freeze water', 0),
(511, 152, NULL, 'Make someone cry', 0),
(512, 153, NULL, 'Describe something exactly', 1),
(513, 153, NULL, 'Hammer a nail', 0),
(514, 153, NULL, 'Hit someone', 0),
(515, 153, NULL, 'Break something', 0),
(516, 154, NULL, 'Very expensive', 1),
(517, 154, NULL, 'Very cheap', 0),
(518, 154, NULL, 'A painful experience', 0),
(519, 154, NULL, 'A difficult decision', 0),
(520, 155, NULL, 'Rarely', 1),
(521, 155, NULL, 'Frequently', 0),
(522, 155, NULL, 'Always', 0),
(523, 155, NULL, 'Never', 0),
(524, 156, NULL, 'Work late at night', 1),
(525, 156, NULL, 'Start a fire', 0),
(526, 156, NULL, 'Burn something', 0),
(527, 156, NULL, 'Relax at home', 0),
(528, 157, NULL, 'Regret something you can’t change', 1),
(529, 157, NULL, 'Clean a mess', 0),
(530, 157, NULL, 'Cry loudly', 0),
(531, 157, NULL, 'Drink milk', 0),
(532, 158, NULL, 'Face a difficult situation', 1),
(533, 158, NULL, 'Eat something', 0),
(534, 158, NULL, 'Break something', 0),
(535, 158, NULL, 'Bite someone', 0),
(536, 159, NULL, 'Reveal a secret', 1),
(537, 159, NULL, 'Catch a cat', 0),
(538, 159, NULL, 'Open a bag', 0),
(539, 159, NULL, 'Let something go', 0),
(540, 160, NULL, 'Die', 1),
(541, 160, NULL, 'Kick something', 0),
(542, 160, NULL, 'Start a game', 0),
(543, 160, NULL, 'Travel', 0),
(544, 161, NULL, 'Feeling ill', 1),
(545, 161, NULL, 'Under pressure', 0),
(546, 161, NULL, 'In the rain', 0),
(547, 161, NULL, 'Feeling happy', 0),
(548, 162, NULL, 'Go to sleep', 1),
(549, 162, NULL, 'Hit something', 0),
(550, 162, NULL, 'Rest on a sack', 0),
(551, 162, NULL, 'Go to work', 0),
(552, 163, NULL, 'Make a bad situation worse', 1),
(553, 163, NULL, 'Start a fire', 0),
(554, 163, NULL, 'Help someone', 0),
(555, 163, NULL, 'Cool something down', 0),
(556, 164, NULL, 'Solve two problems at once', 1),
(557, 164, NULL, 'Kill birds', 0),
(558, 164, NULL, 'Travel far', 0),
(559, 164, NULL, 'Do two tasks separately', 0),
(560, 165, NULL, 'Destroy a relationship', 1),
(561, 165, NULL, 'Build something', 0),
(562, 165, NULL, 'Cross a bridge', 0),
(563, 165, NULL, 'Forget something', 0),
(564, 166, NULL, 'Very happy', 1),
(565, 166, NULL, 'In the sky', 0),
(566, 166, NULL, 'Very sad', 0),
(567, 166, NULL, 'Very confused', 0),
(568, 167, NULL, 'Never', 1),
(569, 167, NULL, 'Always', 0),
(570, 167, NULL, 'Rarely', 0),
(571, 167, NULL, 'Sometimes', 0),
(572, 168, NULL, 'Raining heavily', 1),
(573, 168, NULL, 'Rain mixed with animals', 0),
(574, 168, NULL, 'Animal storm', 0),
(575, 168, NULL, 'Sunny weather', 0),
(576, 169, NULL, 'Joke with someone', 1),
(577, 169, NULL, 'Pull someone literally', 0),
(578, 169, NULL, 'Help someone', 0),
(579, 169, NULL, 'Argue with someone', 0),
(580, 170, NULL, 'It’s your decision', 1),
(581, 170, NULL, 'Play sports', 0),
(582, 170, NULL, 'Pass the ball', 0),
(583, 170, NULL, 'Help someone', 0),
(584, 171, NULL, 'Avoid the main topic', 1),
(585, 171, NULL, 'Cut a bush', 0),
(586, 171, NULL, 'Explain directly', 0),
(587, 171, NULL, 'Talk about sports', 0),
(588, 172, NULL, 'Lose control', 1),
(589, 172, NULL, 'Exit a room', 0),
(590, 172, NULL, 'Help someone', 0),
(591, 172, NULL, 'Handle well', 0),
(592, 173, NULL, 'Stop working for the day', 1),
(593, 173, NULL, 'Call someone', 0),
(594, 173, NULL, 'Continue working', 0),
(595, 173, NULL, 'Start a new task', 0),
(596, 174, NULL, 'Do something poorly to save time', 1),
(597, 174, NULL, 'Make something longer', 0),
(598, 174, NULL, 'Be creative', 0),
(599, 174, NULL, 'Cut with scissors', 0),
(700, 250, NULL, 'Present Continuous', 1),
(701, 250, NULL, 'Past Simple', 0),
(702, 250, NULL, 'Future Perfect', 0),
(703, 250, NULL, 'Present Perfect', 0),
(704, 251, NULL, 'Ate', 1),
(705, 251, NULL, 'Eaten', 0),
(706, 251, NULL, 'Eating', 0),
(707, 251, NULL, 'Eat', 0),
(708, 252, NULL, 'Future Simple', 1),
(709, 252, NULL, 'Past Perfect', 0),
(710, 252, NULL, 'Present Perfect', 0),
(711, 252, NULL, 'Future Continuous', 0),
(712, 253, NULL, 'Running', 1),
(713, 253, NULL, 'Ran', 0),
(714, 253, NULL, 'Runs', 0),
(715, 253, NULL, 'Run', 0),
(716, 254, NULL, 'Present Simple', 1),
(717, 254, NULL, 'Past Simple', 0),
(718, 254, NULL, 'Future Simple', 0),
(719, 254, NULL, 'Present Continuous', 0),
(720, 255, NULL, 'Past Simple', 1),
(721, 255, NULL, 'Present Simple', 0),
(722, 255, NULL, 'Future Simple', 0),
(723, 255, NULL, 'Present Continuous', 0),
(724, 256, NULL, 'Was/Were', 1),
(725, 256, NULL, 'Is/Are', 0),
(726, 256, NULL, 'Be', 0),
(727, 256, NULL, 'Being', 0),
(728, 257, NULL, 'Went', 1),
(729, 257, NULL, 'Goes', 0),
(730, 257, NULL, 'Gone', 0),
(731, 257, NULL, 'Going', 0),
(732, 258, NULL, 'Past Continuous', 1),
(733, 258, NULL, 'Past Simple', 0),
(734, 258, NULL, 'Future Continuous', 0),
(735, 258, NULL, 'Present Continuous', 0),
(736, 259, NULL, 'Will', 1),
(737, 259, NULL, 'Shall', 0),
(738, 259, NULL, 'Would', 0),
(739, 259, NULL, 'Can', 0),
(740, 260, NULL, 'Future Continuous', 1),
(741, 260, NULL, 'Present Simple', 0),
(742, 260, NULL, 'Past Perfect', 0),
(743, 260, NULL, 'Future Perfect', 0),
(744, 261, NULL, 'Has written', 1),
(745, 261, NULL, 'Writing', 0),
(746, 261, NULL, 'Wrote', 0),
(747, 261, NULL, 'Writes', 0),
(748, 262, NULL, 'Be', 1),
(749, 262, NULL, 'Was', 0),
(750, 262, NULL, 'Been', 0),
(751, 262, NULL, 'Being', 0),
(752, 263, NULL, 'Past Continuous', 1),
(753, 263, NULL, 'Past Perfect', 0),
(754, 263, NULL, 'Present Perfect', 0),
(755, 263, NULL, 'Future Perfect', 0),
(756, 264, NULL, 'Present Perfect Continuous', 1),
(757, 264, NULL, 'Past Continuous', 0),
(758, 264, NULL, 'Future Continuous', 0),
(759, 264, NULL, 'Present Simple', 0),
(800, 300, NULL, 'Present everywhere', 1),
(801, 300, NULL, 'Rare', 0),
(802, 300, NULL, 'Difficult to find', 0),
(803, 300, NULL, 'Unique', 0),
(804, 301, NULL, 'Thorough', 1),
(805, 301, NULL, 'Careless', 0),
(806, 301, NULL, 'Quick', 0),
(807, 301, NULL, 'Lazy', 0),
(808, 302, NULL, 'Clear', 1),
(809, 302, NULL, 'Vague', 0),
(810, 302, NULL, 'Uncertain', 0),
(811, 302, NULL, 'Dubious', 0),
(812, 303, NULL, 'Short-lived', 1),
(813, 303, NULL, 'Eternal', 0),
(814, 303, NULL, 'Permanent', 0),
(815, 303, NULL, 'Constant', 0),
(816, 304, NULL, 'Kind', 1),
(817, 304, NULL, 'Selfish', 0),
(818, 304, NULL, 'Cruel', 0),
(819, 304, NULL, 'Indifferent', 0),
(820, 305, NULL, 'Unceasing', 1),
(821, 305, NULL, 'Occasional', 0),
(822, 305, NULL, 'Rare', 0),
(823, 305, NULL, 'Irregular', 0),
(824, 306, NULL, 'Lazy', 1),
(825, 306, NULL, 'Hardworking', 0),
(826, 306, NULL, 'Dedicated', 0),
(827, 306, NULL, 'Committed', 0),
(828, 307, NULL, 'Reduce pain or difficulty', 1),
(829, 307, NULL, 'Worsen a situation', 0),
(830, 307, NULL, 'Create problems', 0),
(831, 307, NULL, 'Ignore', 0),
(832, 308, NULL, 'A steep cliff', 1),
(833, 308, NULL, 'A flat surface', 0),
(834, 308, NULL, 'A small hill', 0),
(835, 308, NULL, 'A narrow path', 0),
(836, 309, NULL, 'Talkative', 1),
(837, 309, NULL, 'Quiet', 0),
(838, 309, NULL, 'Reserved', 0),
(839, 309, NULL, 'Shy', 0),
(1000, 400, NULL, 'Sad', 1),
(1001, 400, NULL, 'Angry', 0),
(1002, 400, NULL, 'Bright', 0),
(1003, 400, NULL, 'Weak', 0),
(1004, 401, NULL, 'Calm', 1),
(1005, 401, NULL, 'Happy', 0),
(1006, 401, NULL, 'Cold', 0),
(1007, 401, NULL, 'Big', 0),
(1008, 402, NULL, 'Small', 1),
(1009, 402, NULL, 'Large', 0),
(1010, 402, NULL, 'Old', 0),
(1011, 402, NULL, 'Slow', 0),
(1012, 403, NULL, 'Large', 1),
(1013, 403, NULL, 'Tiny', 0),
(1014, 403, NULL, 'Bright', 0),
(1015, 403, NULL, 'Fast', 0),
(1016, 404, NULL, 'Slow', 1),
(1017, 404, NULL, 'Quick', 0),
(1018, 404, NULL, 'Hard', 0),
(1019, 404, NULL, 'Weak', 0),
(1020, 405, NULL, 'Fast', 1),
(1021, 405, NULL, 'Dull', 0),
(1022, 405, NULL, 'Old', 0),
(1023, 405, NULL, 'Strong', 0),
(1024, 406, NULL, 'Cruel', 1),
(1025, 406, NULL, 'Generous', 0),
(1026, 406, NULL, 'Kind', 0),
(1027, 406, NULL, 'Lazy', 0),
(1028, 407, NULL, 'Serious', 1),
(1029, 407, NULL, 'Funny', 0),
(1030, 407, NULL, 'Loud', 0),
(1031, 407, NULL, 'Cold', 0),
(1032, 408, NULL, 'Dim', 1),
(1033, 408, NULL, 'Bright', 0),
(1034, 408, NULL, 'Clear', 0),
(1035, 408, NULL, 'Rich', 0),
(1036, 409, NULL, 'Bright', 1),
(1037, 409, NULL, 'Dark', 0),
(1038, 409, NULL, 'Dull', 0),
(1039, 409, NULL, 'Strong', 0),
(1040, 410, NULL, 'Weak', 1),
(1041, 410, NULL, 'Strong', 0),
(1042, 410, NULL, 'Big', 0),
(1043, 410, NULL, 'Rich', 0),
(1044, 411, NULL, 'Strong', 1),
(1045, 411, NULL, 'Weak', 0),
(1046, 411, NULL, 'Soft', 0),
(1047, 411, NULL, 'Hard', 0),
(1048, 412, NULL, 'Cold', 1),
(1049, 412, NULL, 'Hot', 0),
(1050, 412, NULL, 'Bright', 0),
(1051, 412, NULL, 'Hard', 0),
(1052, 413, NULL, 'Hot', 1),
(1053, 413, NULL, 'Warm', 0),
(1054, 413, NULL, 'Cold', 0),
(1055, 413, NULL, 'Bright', 0),
(1056, 414, NULL, 'Poor', 1),
(1057, 414, NULL, 'Rich', 0),
(1058, 414, NULL, 'Weak', 0),
(1059, 414, NULL, 'Bright', 0),
(1060, 415, NULL, 'Rich', 1),
(1061, 415, NULL, 'Strong', 0),
(1062, 415, NULL, 'Cold', 0),
(1063, 415, NULL, 'Fast', 0),
(1064, 416, NULL, 'Dirty', 1),
(1065, 416, NULL, 'Clean', 0),
(1066, 416, NULL, 'Soft', 0),
(1067, 416, NULL, 'Bright', 0),
(1068, 417, NULL, 'Clean', 1),
(1069, 417, NULL, 'Dirty', 0),
(1070, 417, NULL, 'Weak', 0),
(1071, 417, NULL, 'Hot', 0),
(1072, 418, NULL, 'Dangerous', 1),
(1073, 418, NULL, 'Safe', 0),
(1074, 418, NULL, 'Quick', 0),
(1075, 418, NULL, 'Strong', 0),
(1076, 419, NULL, 'Safe', 1),
(1077, 419, NULL, 'Dangerous', 0),
(1078, 419, NULL, 'Weak', 0),
(1079, 419, NULL, 'Rich', 0),
(1080, 420, NULL, 'Difficult', 1),
(1081, 420, NULL, 'Easy', 0),
(1082, 420, NULL, 'Fast', 0),
(1083, 420, NULL, 'Cold', 0),
(1084, 421, NULL, 'Easy', 1),
(1085, 421, NULL, 'Hard', 0),
(1086, 421, NULL, 'Strong', 0),
(1087, 421, NULL, 'Soft', 0),
(1088, 422, NULL, 'Old', 1),
(1089, 422, NULL, 'New', 0),
(1090, 422, NULL, 'Bright', 0),
(1091, 422, NULL, 'Quick', 0),
(1092, 423, NULL, 'New', 1),
(1093, 423, NULL, 'Old', 0),
(1094, 423, NULL, 'Fast', 0),
(1095, 423, NULL, 'Strong', 0),
(1096, 424, NULL, 'Ugly', 1),
(1097, 424, NULL, 'Beautiful', 0),
(1098, 424, NULL, 'Weak', 0),
(1099, 424, NULL, 'Bright', 0),
(1100, 425, NULL, 'Beautiful', 1),
(1101, 425, NULL, 'Ugly', 0),
(1102, 425, NULL, 'Cold', 0),
(1103, 425, NULL, 'Fast', 0),
(1104, 426, NULL, 'Slow', 1),
(1105, 426, NULL, 'Quick', 0),
(1106, 426, NULL, 'Strong', 0),
(1107, 426, NULL, 'Hot', 0),
(1108, 427, NULL, 'Active', 1),
(1109, 427, NULL, 'Lazy', 0),
(1110, 427, NULL, 'Weak', 0),
(1111, 427, NULL, 'Bright', 0),
(1112, 428, NULL, 'Dim', 1),
(1113, 428, NULL, 'Bright', 0),
(1114, 428, NULL, 'Strong', 0),
(1115, 428, NULL, 'Cold', 0),
(1116, 429, NULL, 'Blunt', 1),
(1117, 429, NULL, 'Sharp', 0),
(1118, 429, NULL, 'Strong', 0),
(1119, 429, NULL, 'Weak', 0),
(1120, 430, NULL, 'Hard', 1),
(1121, 430, NULL, 'Soft', 0),
(1122, 430, NULL, 'Quick', 0),
(1123, 430, NULL, 'Bright', 0),
(1124, 431, NULL, 'Soft', 1),
(1125, 431, NULL, 'Hard', 0),
(1126, 431, NULL, 'Cold', 0),
(1127, 431, NULL, 'Bright', 0),
(1128, 432, NULL, 'Weak', 1),
(1129, 432, NULL, 'Strong', 0),
(1130, 432, NULL, 'Dim', 0),
(1131, 432, NULL, 'Fast', 0),
(1132, 433, NULL, 'Strong', 1),
(1133, 433, NULL, 'Weak', 0),
(1134, 433, NULL, 'Cold', 0),
(1135, 433, NULL, 'Bright', 0),
(1136, 434, NULL, 'Complex', 1),
(1137, 434, NULL, 'Simple', 0),
(1138, 434, NULL, 'Quick', 0),
(1139, 434, NULL, 'Rich', 0),
(1140, 435, NULL, 'Simple', 1),
(1141, 435, NULL, 'Complex', 0),
(1142, 435, NULL, 'Fast', 0),
(1143, 435, NULL, 'Weak', 0),
(1144, 436, NULL, 'Short', 1),
(1145, 436, NULL, 'Tall', 0),
(1146, 436, NULL, 'Dim', 0),
(1147, 436, NULL, 'Cold', 0),
(1148, 437, NULL, 'Tall', 1),
(1149, 437, NULL, 'Short', 0),
(1150, 437, NULL, 'Bright', 0),
(1151, 437, NULL, 'Rich', 0),
(1152, 438, NULL, 'Dim', 1),
(1153, 438, NULL, 'Bright', 0),
(1154, 438, NULL, 'Strong', 0),
(1155, 438, NULL, 'Cold', 0),
(1156, 439, NULL, 'Bright', 1),
(1157, 439, NULL, 'Dim', 0),
(1158, 439, NULL, 'Rich', 0),
(1159, 439, NULL, 'Quick', 0),
(1160, 440, NULL, 'Empty', 1),
(1161, 440, NULL, 'Full', 0),
(1162, 440, NULL, 'Weak', 0),
(1163, 440, NULL, 'Bright', 0),
(1164, 441, NULL, 'Full', 1),
(1165, 441, NULL, 'Empty', 0),
(1166, 441, NULL, 'Dim', 0),
(1167, 441, NULL, 'Cold', 0),
(1168, 442, NULL, 'Vague', 1),
(1169, 442, NULL, 'Clear', 0),
(1170, 442, NULL, 'Fast', 0),
(1171, 442, NULL, 'Strong', 0),
(1172, 443, NULL, 'Clear', 1),
(1173, 443, NULL, 'Vague', 0),
(1174, 443, NULL, 'Rich', 0),
(1175, 443, NULL, 'Bright', 0),
(1176, 444, NULL, 'Dark', 1),
(1177, 444, NULL, 'Light', 0),
(1178, 444, NULL, 'Weak', 0),
(1179, 444, NULL, 'Strong', 0),
(1229, 464, NULL, 'went', 1),
(1230, 464, NULL, 'gone', 0),
(1231, 464, NULL, 'goes', 0),
(1232, 464, NULL, 'going', 0),
(1233, 465, NULL, 'angry', 0),
(1234, 465, NULL, 'sad', 0),
(1235, 465, NULL, 'joyful', 1),
(1236, 465, NULL, 'tired', 0),
(1237, 466, NULL, 'who', 1),
(1238, 466, NULL, 'which', 0),
(1239, 466, NULL, 'whom', 0),
(1240, 466, NULL, 'whose', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dapan_hocvien`
--

CREATE TABLE `dapan_hocvien` (
  `id` int(11) NOT NULL,
  `id_ketqua` int(11) NOT NULL,
  `id_cauhoi` int(11) NOT NULL,
  `id_dapan_chon` int(11) DEFAULT NULL,
  `tra_loi_tu_luan` text DEFAULT NULL COMMENT 'Nội dung bài làm của học viên',
  `diem_tu_luan` decimal(5,2) DEFAULT NULL COMMENT 'Điểm AI chấm',
  `nhan_xet_tu_luan` text DEFAULT NULL COMMENT 'Nhận xét chi tiết từ AI',
  `trang_thai_cham` enum('da_cham','cho_cham','dang_cham') NOT NULL DEFAULT 'da_cham' COMMENT 'Trạng thái chấm bài tự luận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dapan_hocvien`
--

INSERT INTO `dapan_hocvien` (`id`, `id_ketqua`, `id_cauhoi`, `id_dapan_chon`, `tra_loi_tu_luan`, `diem_tu_luan`, `nhan_xet_tu_luan`, `trang_thai_cham`) VALUES
(1, 15, 300, 800, NULL, NULL, NULL, 'da_cham'),
(2, 15, 301, 806, NULL, NULL, NULL, 'da_cham'),
(3, 15, 302, 811, NULL, NULL, NULL, 'da_cham'),
(4, 15, 303, 812, NULL, NULL, NULL, 'da_cham'),
(5, 15, 304, 819, NULL, NULL, NULL, 'da_cham'),
(6, 15, 305, 823, NULL, NULL, NULL, 'da_cham'),
(7, 15, 306, 825, NULL, NULL, NULL, 'da_cham'),
(8, 15, 307, 830, NULL, NULL, NULL, 'da_cham'),
(9, 15, 308, 833, NULL, NULL, NULL, 'da_cham'),
(10, 15, 309, 838, NULL, NULL, NULL, 'da_cham'),
(11, 17, 458, NULL, ',llllllllllll', NULL, NULL, 'cho_cham'),
(12, 18, 458, NULL, ',llllllllllll', NULL, NULL, 'cho_cham'),
(13, 19, 458, NULL, '', NULL, NULL, 'cho_cham'),
(21, 27, 1, 1, NULL, NULL, NULL, 'da_cham'),
(22, 27, 2, 6, NULL, NULL, NULL, 'da_cham'),
(23, 27, 3, 7, NULL, NULL, NULL, 'da_cham'),
(24, 27, 4, 10, NULL, NULL, NULL, 'da_cham'),
(25, 27, 5, 13, NULL, NULL, NULL, 'da_cham'),
(26, 27, 6, 17, NULL, NULL, NULL, 'da_cham'),
(27, 27, 7, 21, NULL, NULL, NULL, 'da_cham'),
(28, 27, 8, 22, NULL, NULL, NULL, 'da_cham'),
(29, 27, 9, 27, NULL, NULL, NULL, 'da_cham'),
(30, 27, 10, 28, NULL, NULL, NULL, 'da_cham'),
(31, 27, 11, 32, NULL, NULL, NULL, 'da_cham'),
(32, 27, 12, 35, NULL, NULL, NULL, 'da_cham'),
(33, 27, 20, 59, NULL, NULL, NULL, 'da_cham'),
(34, 27, 461, NULL, 'Learning English effectively is an important goal for many students around the world. While some people believe that grammar is the key to mastering the language, others argue that communication skills play a more important role. Both perspectives have their own reasons.\r\n\r\nOn the one hand, focusing on grammar helps learners build a strong foundation in the language. Grammar provides structure and clarity, which allows students to express their ideas accurately. For example, knowing how to use tenses correctly helps learners avoid misunderstandings and sound more professional in academic or work settings. In addition, grammar is often a key part of language exams, so mastering it can help students achieve better results.\r\n\r\nOn the other hand, communication skills are essential for using English in real-life situations. Being able to speak and listen confidently allows learners to connect with others and build relationships. In many cases, people can still understand each other even with small grammar mistakes, but if a person cannot communicate fluently, the conversation may fail. Therefore, developing speaking and listening skills is crucial for practical use.\r\n\r\nIn my opinion, both grammar and communication are important, but communication should be prioritized. Good communication skills give learners the confidence to use the language daily, and grammar can be improved gradually through practice. The main purpose of learning a language is to communicate, not just to memorize rules.', 8.00, 'Bài viết của bạn rất tốt! Bạn đã trả lời đầy đủ các yêu cầu của đề bài, trình bày rõ ràng cả hai quan điểm và đưa ra ý kiến cá nhân một cách thuyết phục. Bố cục bài viết mạch lạc, có sử dụng các từ nối (linking words) để liên kết các ý. Tuy nhiên, vẫn còn một số điểm có thể cải thiện để bài viết hoàn thiện hơn nữa.\n\n**Task Achievement (25%):** Bạn đã đáp ứng đầy đủ yêu cầu của đề bài, thảo luận cả hai quan điểm và đưa ra ý kiến cá nhân rõ ràng. Tuy nhiên, bạn có thể làm sâu sắc hơn bằng cách đưa ra các ví dụ cụ thể hơn để minh họa cho từng quan điểm.\n\n**Coherence and Cohesion (25%):** Bài viết có cấu trúc tốt và dễ theo dõi. Các đoạn văn được liên kết với nhau bằng các từ nối phù hợp. Tuy nhiên, bạn có thể đa dạng hóa hơn nữa các từ nối và cụm từ chuyển ý để bài viết trôi chảy hơn.\n\n**Lexical Resource (25%):** Bạn đã sử dụng từ vựng khá tốt và phù hợp với chủ đề. Tuy nhiên, để nâng cao điểm số, bạn có thể sử dụng nhiều từ vựng chuyên sâu hơn và tránh lặp lại các từ ngữ quen thuộc. Hãy thử sử dụng từ điển đồng nghĩa để tìm các lựa chọn thay thế.\n\n**Grammatical Range and Accuracy (25%):** Ngữ pháp của bạn khá chính xác và đa dạng. Tuy nhiên, vẫn còn một vài lỗi nhỏ. Hãy cẩn thận kiểm tra lại các lỗi chính tả và ngữ pháp trước khi nộp bài. Cố gắng sử dụng nhiều cấu trúc câu phức tạp hơn (ví dụ: câu bị động, mệnh đề quan hệ) để thể hiện khả năng sử dụng ngữ pháp linh hoạt.', 'da_cham'),
(47, 33, 469, NULL, '', 0.00, 'Bài viết hiện tại trống rỗng, nên không thể đánh giá bất kỳ tiêu chí nào. Để có thể chấm điểm và đưa ra phản hồi hữu ích, em cần viết một đoạn văn theo yêu cầu đề bài (khoảng 100-120 từ về sở thích yêu thích của em). \n\nKhi em viết xong, hãy tập trung vào những điểm sau:\n\n*   **Task Achievement:** Hãy đảm bảo đoạn văn của em trả lời đầy đủ câu hỏi, mô tả rõ ràng sở thích yêu thích của em là gì và tại sao em thích nó.\n*   **Coherence and Cohesion:** Sắp xếp các ý một cách logic và sử dụng các từ nối (ví dụ: \'because\', \'therefore\', \'however\', \'in addition\') để tạo sự mạch lạc giữa các câu.\n*   **Lexical Resource:** Sử dụng vốn từ vựng phong phú và phù hợp với chủ đề sở thích. Cố gắng tránh lặp lại từ ngữ.\n*   **Grammatical Range and Accuracy:** Sử dụng nhiều cấu trúc ngữ pháp khác nhau (ví dụ: câu đơn, câu phức, câu bị động) và đảm bảo chúng chính xác về mặt ngữ pháp. Kiểm tra kỹ lỗi chính tả và ngữ pháp trước khi nộp bài.\n\nĐừng ngại thử sức và viết bài nhé! Chúc em thành công.', 'da_cham'),
(48, 34, 469, NULL, 'My favorite hobby is reading books. I usually read every evening after finishing my homework. Reading helps me relax and learn new things at the same time. I enjoy many kinds of books, but my favorite are adventure stories because they are exciting and full of surprises. Sometimes, I also read English books to improve my vocabulary. Reading not only entertains me but also makes me more creative and helps me think deeply. I believe that reading is a great way to spend my free time.', 8.50, 'Bài viết của em rất tốt! Em đã hoàn thành yêu cầu của đề bài một cách đầy đủ và rõ ràng. Bố cục bài viết mạch lạc, ý tứ liền mạch và ngôn ngữ sử dụng phù hợp. Tuy nhiên, vẫn còn một vài điểm có thể cải thiện để bài viết hay hơn nữa.\n\n**Task Achievement:** Em đã trả lời đầy đủ câu hỏi, nêu rõ sở thích và lý do yêu thích nó. (Hoàn thành tốt)\n\n**Coherence and Cohesion:** Bài viết có bố cục rõ ràng, sử dụng các liên từ (\"and\", \"but\", \"because\", \"also\") khá hiệu quả để liên kết các câu. Tuy nhiên, em có thể sử dụng các cụm từ liên kết đa dạng hơn để bài viết trôi chảy hơn, ví dụ như \"Furthermore\", \"In addition\", \"Moreover\".\n\n**Lexical Resource:** Vốn từ vựng của em khá ổn, sử dụng từ ngữ phù hợp với chủ đề. Tuy nhiên, để nâng cao điểm, em có thể sử dụng các từ đồng nghĩa hoặc cụm từ diễn đạt hay hơn thay vì lặp lại một số từ (\"reading\", \"books\"). Ví dụ, thay vì \"Reading helps me relax\", em có thể viết \"Engaging with literature allows me to unwind\".\n\n**Grammatical Range and Accuracy:** Ngữ pháp của em khá chính xác. Tuy nhiên, để đạt điểm cao hơn, em nên thử sử dụng các cấu trúc câu phức tạp hơn (ví dụ, mệnh đề quan hệ, câu điều kiện) một cách tự nhiên và chính xác. Ví dụ, thay vì \"Reading not only entertains me but also makes me more creative\", em có thể viết \"Not only does reading entertain me, but it also fosters creativity\".\n\nTiếp tục phát huy và cố gắng sử dụng nhiều cấu trúc ngữ pháp và từ vựng phong phú hơn nữa trong các bài viết sau nhé!', 'da_cham'),
(49, 34, 471, NULL, 'Every day, I wake up at 6 a.m. and get ready for school. I have breakfast with my family and then ride my bike to school. My classes start at 7 a.m. and finish at 11:30 a.m. After school, I have lunch and take a short nap. In the afternoon, I usually do my homework or help my parents with housework. Sometimes, I play sports with my friends. In the evening, I have dinner, watch TV, and review my lessons. I go to bed at around 10 p.m. I enjoy my daily routine because it keeps me healthy, active, and organized.', 8.50, 'Bài viết của em khá tốt! Em đã trả lời đầy đủ câu hỏi và diễn tả được một ngày của mình một cách rõ ràng. Nhìn chung, bài viết mạch lạc, sử dụng từ vựng phù hợp và ngữ pháp tương đối chính xác. Tuy nhiên, vẫn còn một vài điểm có thể cải thiện để bài viết hay hơn nữa.\n\n**Task Achievement:** Em đã hoàn thành yêu cầu đề bài về nội dung và độ dài. Không có vấn đề gì ở phần này.\n\n**Coherence and Cohesion:** Bài viết có cấu trúc rõ ràng, các ý được sắp xếp theo trình tự thời gian hợp lý. Các liên từ như \'and\', \'then\', \'after\', \'in the evening\' được sử dụng tốt để liên kết các câu. Tuy nhiên, em có thể sử dụng các liên từ đa dạng hơn để tăng tính mạch lạc, ví dụ: \'Furthermore\', \'Moreover\', \'However\'.\n\n**Lexical Resource:** Từ vựng em sử dụng phù hợp với chủ đề và trình độ. Tuy nhiên, để bài viết sinh động hơn, em có thể thay thế một số từ đơn giản bằng những từ đồng nghĩa phức tạp hơn. Ví dụ, thay vì \'I enjoy my daily routine\', em có thể viết \'I find my daily routine fulfilling\' hoặc \'I appreciate the structure of my daily routine\'.\n\n**Grammatical Range and Accuracy:** Ngữ pháp của em khá chính xác. Tuy nhiên, em nên cố gắng sử dụng nhiều cấu trúc câu phức tạp hơn thay vì chỉ sử dụng các câu đơn. Ví dụ, thay vì \'I have dinner, watch TV, and review my lessons\', em có thể viết \'After having dinner, I usually watch TV and spend some time reviewing my lessons\'. Em cũng nên kiểm tra lại các lỗi chính tả và ngữ pháp nhỏ trước khi nộp bài.', 'da_cham');

-- --------------------------------------------------------

--
-- Table structure for table `diem_danh`
--

CREATE TABLE `diem_danh` (
  `id_diemdanh` int(11) NOT NULL,
  `id_hocvien` int(11) NOT NULL,
  `id_lop` varchar(50) NOT NULL,
  `id_lichhoc` int(11) NOT NULL,
  `trang_thai` enum('co mat','vang','muon') DEFAULT 'co mat',
  `ngay_diemdanh` date DEFAULT curdate(),
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diem_danh`
--

INSERT INTO `diem_danh` (`id_diemdanh`, `id_hocvien`, `id_lop`, `id_lichhoc`, `trang_thai`, `ngay_diemdanh`, `ghi_chu`) VALUES
(1, 27, 'BASIC-01-25', 266, 'co mat', '2025-10-14', NULL),
(2, 27, 'BASIC-01-25', 4, 'co mat', '2025-10-14', NULL),
(3, 27, 'BASIC-01-25', 5, 'co mat', '2025-10-14', NULL),
(4, 27, 'BASIC-01-25', 6, 'vang', '2025-10-14', NULL),
(5, 27, 'BASIC-01-25', 265, 'vang', '2025-10-14', NULL),
(6, 27, 'BASIC-01-25', 62, 'vang', '2025-10-14', NULL),
(7, 27, 'BASIC-01-25', 264, 'vang', '2025-10-14', NULL),
(8, 27, 'BASIC-01-25', 271, 'vang', '2025-10-14', NULL),
(9, 27, 'BASIC-01-25', 63, 'vang', '2025-10-14', NULL),
(10, 27, 'BASIC-01-25', 64, 'vang', '2025-10-14', NULL),
(11, 27, 'BASIC-01-25', 65, 'vang', '2025-10-14', NULL),
(12, 27, 'BASIC-01-25', 66, 'vang', '2025-10-14', NULL),
(13, 27, 'BASIC-01-25', 269, 'vang', '2025-10-14', NULL),
(14, 27, 'BASIC-01-25', 67, 'vang', '2025-10-14', NULL),
(15, 27, 'BASIC-01-25', 68, 'vang', '2025-10-14', NULL),
(16, 27, 'BASIC-01-25', 69, 'vang', '2025-10-14', NULL),
(17, 27, 'BASIC-01-25', 70, 'vang', '2025-10-14', NULL),
(18, 1, 'TOEIC-4S-01-25', 23, 'co mat', '2025-10-14', NULL),
(19, 1, 'TOEIC-4S-01-25', 24, 'vang', '2025-10-14', NULL),
(20, 1, 'TOEIC-4S-01-25', 25, 'vang', '2025-10-14', NULL),
(21, 1, 'TOEIC-4S-01-25', 132, 'vang', '2025-10-14', NULL),
(22, 1, 'TOEIC-4S-01-25', 133, 'vang', '2025-10-14', NULL),
(23, 1, 'TOEIC-4S-01-25', 134, 'vang', '2025-10-14', NULL),
(24, 1, 'TOEIC-4S-01-25', 135, 'vang', '2025-10-14', NULL),
(25, 1, 'TOEIC-4S-01-25', 136, 'vang', '2025-10-14', NULL),
(26, 1, 'TOEIC-4S-01-25', 137, 'vang', '2025-10-14', NULL),
(27, 1, 'TOEIC-4S-01-25', 138, 'vang', '2025-10-14', NULL),
(28, 1, 'TOEIC-4S-01-25', 139, 'vang', '2025-10-14', NULL),
(29, 1, 'TOEIC-4S-01-25', 140, 'vang', '2025-10-14', NULL),
(30, 1, 'TOEIC-4S-01-25', 141, 'vang', '2025-10-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `diem_so`
--

CREATE TABLE `diem_so` (
  `id_diem` int(11) NOT NULL,
  `id_hocvien` int(11) NOT NULL,
  `id_lop` varchar(50) NOT NULL,
  `diem` decimal(4,2) NOT NULL,
  `loai_diem` varchar(100) DEFAULT NULL COMMENT 'Ví dụ: Giữa kỳ, Cuối kỳ, Bài tập lớn',
  `ngay_nhap_diem` timestamp NOT NULL DEFAULT current_timestamp(),
  `nhan_xet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diem_so`
--

INSERT INTO `diem_so` (`id_diem`, `id_hocvien`, `id_lop`, `diem`, `loai_diem`, `ngay_nhap_diem`, `nhan_xet`) VALUES
(154, 27, 'BASIC-01-25', 1.00, 'HK1', '2025-10-13 20:41:53', 'tốt'),
(156, 1, 'TOEIC-4S-01-25', 1.00, 'H1', '2025-10-14 11:04:05', '');

-- --------------------------------------------------------

--
-- Table structure for table `giangvien`
--

CREATE TABLE `giangvien` (
  `id_giangvien` int(11) NOT NULL,
  `ten_giangvien` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL COMMENT 'Mô tả chuyên môn, kinh nghiệm của giảng viên',
  `hinh_anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `giangvien`
--

INSERT INTO `giangvien` (`id_giangvien`, `ten_giangvien`, `so_dien_thoai`, `mat_khau`, `email`, `mo_ta`, `hinh_anh`) VALUES
(1, 'Hoa', '033361243', '$2y$10$zNwr7ECEph9/HAfXOaz.dOwpDVXZGHnNRqD.nm9rrV.8WbQLlIMdC', 'hoa@gmail.com', 'hoas hoc', 'uploads/lecturers/1757966537_Binh-Ba-du-lich-2-8797-1649732806.jpg'),
(2, 'Nguyễn Trần Anh Ngọc', '012345465', '$2y$10$BZK736oz63N1tMeWY7DLnePQf/R4pwMcc4pdP8pF4NdQtFFwAjEma', 'hieutran170626@gmail.com', 'thạc sĩ', 'uploads/lecturers/1757966912_dia-diem-du-lich-30-4-mien-nam-2-1713866323.jpg'),
(3, 'Lê Thị Mai Anh', '0987654321', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'maianh.le@teacher.edu.vn', 'Chuyên gia luyện thi IELTS với 8 năm kinh nghiệm. Đạt 8.5 IELTS Overall. Phương pháp giảng dạy tập trung vào chiến lược làm bài và phát triển tư duy ngôn ngữ.', 'uploads/gv_maianh.jpg'),
(4, 'Nguyễn Minh Tuấn', '0912345678', '$2y$10$Tc.QQmpKCIMdWcHcmVc0q.AI0I2WbLVPOqQ4u2fp08cpgZiVxXzOS', 'tuan.nguyen@teacher.edu.vn', 'Giảng viên chuyên sâu về TOEIC Listening & Reading, đạt 990/990. Có nhiều học viên đạt mục tiêu 750+.', 'uploads/gv_tuan.jpg'),
(5, 'Trần Thu Hà', '0905112233', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'hathu.tran@teacher.edu.vn', 'Với 5 năm kinh nghiệm giảng dạy tiếng Anh giao tiếp và tiếng Anh thương mại. Giúp học viên tự tin sử dụng tiếng Anh trong môi trường công sở.', 'uploads/gv_ha.png'),
(6, 'Phạm Hoàng Long', '0334567890', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'long.pham@teacher.edu.vn', 'Giảng viên tận tâm chuyên dạy các lớp mất gốc và tiếng Anh cho người mới bắt đầu. Phương pháp dạy chậm, chắc và tạo động lực cho học viên.', 'uploads/gv_long.jpg'),
(7, 'Jessica Miller', '0778123456', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'jessica.miller@teacher.edu.vn', 'Giáo viên bản ngữ đến từ Anh. Chuyên luyện phát âm, ngữ điệu và kỹ năng Speaking. Giúp học viên nói tiếng Anh tự nhiên như người bản xứ.', 'uploads/lecturers/1759750180_du-lich-mien-trung-7.webp'),
(8, 'Vũ Bích Ngọc', '0868999888', '$2y$10$rZ.k0e9yWoPQFo7BWkakjeRn6NyZ0cNcOE6X0/j.UlfUgQaowgmqC', 'ngoc.vu@teacher.edu.vn', 'Thạc sĩ Ngôn ngữ Anh. Có thế mạnh về hệ thống hóa kiến thức ngữ pháp phức tạp một cách dễ hiểu. Phụ trách các khóa học nền tảng và luyện thi chuyên sâu.Thạc sĩ Ngôn ngữ Anh. Có thế mạnh về hệ thống hóa kiến thức ngữ pháp phức tạp một cách dễ hiểu. Phụ trách các khóa học nền tảng và luyện thi chuyên sâu.Thạc sĩ Ngôn ngữ Anh. Có thế mạnh về hệ thống hóa kiến thức ngữ pháp phức tạp một cách dễ hiểu. Phụ trách các khóa học nền tảng và luyện thi chuyên sâu.Thạc sĩ Ngôn ngữ Anh. Có thế mạnh về hệ thống hóa kiến thức ngữ pháp phức tạp một cách dễ hiểu. Phụ trách các khóa học nền tảng và luyện thi chuyên sâu.', 'uploads/lecturers/1758180640_khu-du-lich-trang-an.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hocvien`
--

CREATE TABLE `hocvien` (
  `id_hocvien` int(11) NOT NULL,
  `ten_hocvien` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `trinh_do` varchar(50) DEFAULT NULL COMMENT 'Trình độ được phân loại sau bài test',
  `verification_token` varchar(255) DEFAULT NULL COMMENT 'Mã token để xác thực email',
  `token_expiry` datetime DEFAULT NULL COMMENT 'Thời gian hết hạn của token',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Chưa xác thực, 1: Đã xác thực',
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hocvien`
--

INSERT INTO `hocvien` (`id_hocvien`, `ten_hocvien`, `email`, `so_dien_thoai`, `mat_khau`, `trinh_do`, `verification_token`, `token_expiry`, `is_verified`, `is_admin`) VALUES
(1, 'Trần Hữu Hiếu', 'hieutran170626@gmail.com', '0337123222', '$2y$10$fEdaEvMOF2hbGUNc6snnZe0SYdXw5ipunvybYlV2BKgfDO6qvKiza', 'Cơ bản (A1-A2)', NULL, NULL, 1, 1),
(26, 'Hieu Huu', 'hieutran170619@gmail.com', '0123456789', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 0, 0),
(27, 'Test 1', 'T123456@gmail.com', '0123456781', '$2y$10$cTnTEQ2WdJNCGwiiYkOKsug1lvvBaSFjHZsajC3TPIfw3IPXvp4HG', NULL, NULL, NULL, 1, 0),
(29, 'Nguyễn Văn A ', 'A123456@gmail.com', '0332343454', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 0),
(30, 'Thu Phương ', 'Tp123456@gmail.com', '0387254814', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 0, 0),
(31, 'Nguyễn Hải ', 'NugyenHai1@gmail.com', '0866264811', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 0, 0),
(32, 'Nguyễn Ngọc Lâm', 'Lamngoc23@gmail.com', '0382648264', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 0, 0),
(33, 'Hiền', 'admin', '0974928364', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 0, 1),
(37, 'Plee', 'nthuphuong2710@gmail.com', '111123', '$2y$10$PmdVCiif//irfQpXD51c.u1JSThDU1vQBvX0I1W/8WVFN33dTuRIi', NULL, NULL, NULL, 0, 1),
(41, 'Trần Hữu Hiếu', 'hieutran@gmail.com', '1234567', '$2y$10$dMy3VA66k4xMkhKTBvpEM.tI5QiSTPwYTRcfRnzBJhaltk2tJ6CRe', NULL, NULL, NULL, 0, 0),
(42, 'Trần Hữu Hiếu', 'hieutran17@gmail.com', '12345678', '$2y$10$QeFNKr065e.75rq0F0e1HOXK6rUgUQQ6igY7W3zXuLF1acw/6vLhe', NULL, NULL, NULL, 0, 1),
(43, 'Trần Hữu Hiếu', 'hieutran1706111126@gmail.com', '123456', '$2y$10$FSFFVTaHNGbmecbHb0ju3eEulKdnb9EAQfNw1NBOwZ86pQE7rcMB6', NULL, NULL, NULL, 1, 0),
(47, 'hieu', 'hieutran170618@gmail.com', NULL, '$2y$10$TQYhL4F8vjtQRKs02jObgOo1wCERCOIUijRcr5F/Lda7k.Q1TEvge', NULL, '292448', '2025-10-14 23:48:28', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hoc_lieu`
--

CREATE TABLE `hoc_lieu` (
  `id_hoclieu` int(11) NOT NULL,
  `id_khoahoc` int(11) DEFAULT NULL,
  `id_lop` varchar(50) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `loai_file` varchar(50) DEFAULT NULL COMMENT 'ví dụ: PDF, Video, Link, DOCX',
  `duong_dan_file` varchar(255) DEFAULT NULL,
  `ngay_dang` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoc_lieu`
--

INSERT INTO `hoc_lieu` (`id_hoclieu`, `id_khoahoc`, `id_lop`, `tieu_de`, `loai_file`, `duong_dan_file`, `ngay_dang`) VALUES
(13, NULL, 'BASIC-01-25', 'Anh', 'JFIF', 'uploads/materials/1759393844_147fc92a-ba00-4431-b275-974efff1c43b.jfif', '2025-10-02 08:30:44'),
(14, 32, 'BASIC-01-25', 'Bài 1: Alphabet và Phát âm cơ bản', 'JFIF', 'uploads/materials/1759393844_147fc92a-ba00-4431-b275-974efff1c43b.jfif', '2025-10-13 20:25:17'),
(15, 32, 'BASIC-01-25', 'Bài 2: Các thì cơ bản trong tiếng Anh', 'JFIF', 'uploads/materials/1759393844_147fc92a-ba00-4431-b275-974efff1c43b.jfif', '2025-10-13 20:25:17'),
(16, 32, 'BASIC-01-25', 'Video: Cách giới thiệu bản thân', 'Video', 'uploads/materials/basic_01_introduce.mp4', '2025-10-13 20:25:17'),
(17, 32, 'BASIC-01-25', 'Bài 3: Từ vựng về gia đình', 'PDF', 'uploads/materials/basic_01_family.pdf', '2025-10-13 20:25:17'),
(18, 32, 'BASIC-01-25', 'Bài 4: Ngữ pháp - To be động từ', 'DOCX', 'uploads/materials/basic_01_tobe.docx', '2025-10-13 20:25:17'),
(19, 32, 'BASIC-01-25', 'Audio: Luyện nghe hội thoại cơ bản', 'Audio', 'uploads/materials/basic_01_listening.mp3', '2025-10-13 20:25:17'),
(20, 32, 'BASIC-01-25', 'Bài 5: Từ vựng về màu sắc và số đếm', 'PDF', 'uploads/materials/basic_01_colors_numbers.pdf', '2025-10-13 20:25:17'),
(21, 32, 'BASIC-01-25', 'Bài tập: Ôn tập Unit 1-5', 'PDF', 'uploads/materials/basic_01_exercises.pdf', '2025-10-13 20:25:17'),
(22, 32, 'BASIC-01-25', 'Link học thêm: British Council', 'Link', 'https://learnenglish.britishcouncil.org/grammar/beginner-to-pre-intermediate', '2025-10-13 20:25:17'),
(23, 32, 'BASIC-01-25', 'Bài 6: Câu hỏi Wh- Questions', 'PDF', 'uploads/materials/basic_01_wh_questions.pdf', '2025-10-13 20:25:17'),
(24, 32, 'BASIC-02-25', 'Bài 1: Alphabet và Phát âm', 'PDF', 'uploads/materials/basic_02_alphabet.pdf', '2025-10-13 20:25:17'),
(25, 32, 'BASIC-02-25', 'Video: Các cụm từ giao tiếp hàng ngày', 'Video', 'uploads/materials/basic_02_daily_phrases.mp4', '2025-10-13 20:25:17'),
(26, 32, 'BASIC-02-25', 'Bài 2: Present Simple Tense', 'PDF', 'uploads/materials/basic_02_present_simple.pdf', '2025-10-13 20:25:17'),
(27, 32, 'BASIC-02-25', 'Bài tập: Ngữ pháp cơ bản', 'DOCX', 'uploads/materials/basic_02_grammar_ex.docx', '2025-10-13 20:25:17'),
(28, 32, 'BASIC-02-25', 'Từ vựng: Đồ vật trong nhà', 'PDF', 'uploads/materials/basic_02_household.pdf', '2025-10-13 20:25:17'),
(29, 37, 'COM-BASIC-01-25', 'Unit 1: Greetings and Introductions', 'PDF', 'uploads/materials/com_basic_01_unit1.pdf', '2025-10-13 20:25:17'),
(30, 37, 'COM-BASIC-01-25', 'Video: How to introduce yourself', 'Video', 'uploads/materials/com_basic_01_intro.mp4', '2025-10-13 20:25:17'),
(31, 37, 'COM-BASIC-01-25', 'Unit 2: Daily Conversations', 'PDF', 'uploads/materials/com_basic_01_unit2.pdf', '2025-10-13 20:25:17'),
(32, 37, 'COM-BASIC-01-25', 'Audio: Listening Practice - Part 1', 'Audio', 'uploads/materials/com_basic_01_audio.mp3', '2025-10-13 20:25:17'),
(33, 37, 'COM-BASIC-01-25', 'Bài tập giao tiếp thực hành', 'DOCX', 'uploads/materials/com_basic_01_practice.docx', '2025-10-13 20:25:17'),
(34, 37, 'COM-BASIC-01-25', 'Từ vựng: Expressions for Daily Life', 'PDF', 'uploads/materials/com_basic_01_vocab.pdf', '2025-10-13 20:25:17'),
(35, 38, 'TOEIC-4S-01-25', 'TOEIC Listening Part 1: Photos', 'PDF', 'uploads/materials/toeic_4s_listening_part1.pdf', '2025-10-13 20:25:17'),
(36, 38, 'TOEIC-4S-01-25', 'TOEIC Reading Part 5: Grammar', 'PDF', 'uploads/materials/toeic_4s_reading_part5.pdf', '2025-10-13 20:25:17'),
(37, 38, 'TOEIC-4S-01-25', 'Video: TOEIC Tips and Strategies', 'Video', 'uploads/materials/toeic_4s_tips.mp4', '2025-10-13 20:25:17'),
(38, 38, 'TOEIC-4S-01-25', 'Practice Test - Full Test 1', 'PDF', 'uploads/materials/toeic_4s_test1.pdf', '2025-10-13 20:25:17'),
(39, 38, 'TOEIC-4S-01-25', 'Từ vựng TOEIC: Business Vocabulary', 'DOCX', 'uploads/materials/toeic_4s_vocab.docx', '2025-10-13 20:25:17'),
(41, 39, 'IELTS-F-01-25', 'IELTS Foundation: Introduction', 'PDF', 'uploads/materials/ielts_f_intro.pdf', '2025-10-13 20:25:17'),
(42, 39, 'IELTS-F-01-25', 'Grammar for IELTS: Unit 1', 'PDF', 'uploads/materials/ielts_f_grammar1.pdf', '2025-10-13 20:25:17'),
(43, 39, 'IELTS-F-01-25', 'Video: IELTS Writing Task 1 Overview', 'Video', 'uploads/materials/ielts_f_writing.mp4', '2025-10-13 20:25:17'),
(44, 39, 'IELTS-F-01-25', 'Vocabulary: Academic Word List', 'DOCX', 'uploads/materials/ielts_f_vocab.docx', '2025-10-13 20:25:17'),
(45, 39, 'IELTS-F-01-25', 'Link: IELTS Practice Online', 'Link', 'https://ielts.org/take-a-test/preparation-resources', '2025-10-13 20:25:17'),
(46, 35, 'KIDS-01-25', 'Bài 1: Animals - Con vật', 'PDF', 'uploads/materials/kids_01_animals.pdf', '2025-10-13 20:25:17'),
(47, 35, 'KIDS-01-25', 'Video: ABC Song', 'Video', 'uploads/materials/kids_01_abc_song.mp4', '2025-10-13 20:25:17'),
(48, 35, 'KIDS-01-25', 'Bài 2: Colors and Shapes', 'PDF', 'uploads/materials/kids_01_colors.pdf', '2025-10-13 20:25:17'),
(49, 35, 'KIDS-01-25', 'Game: Matching Words', 'Link', 'https://www.cambridge.org/elt/games', '2025-10-13 20:25:17'),
(50, 35, 'KIDS-01-25', 'Worksheet: Practice Exercises', 'DOCX', 'uploads/materials/kids_01_worksheet.docx', '2025-10-13 20:25:17'),
(51, 42, 'IELTS-0-7-01-25', 'IELTS Roadmap 0-7: Overview', 'PDF', 'uploads/materials/ielts_07_overview.pdf', '2025-10-13 20:25:17'),
(52, 42, 'IELTS-0-7-01-25', 'Listening Skills: Essential Strategies', 'PDF', 'uploads/materials/ielts_07_listening.pdf', '2025-10-13 20:25:17'),
(53, 42, 'IELTS-0-7-01-25', 'Video: Speaking Part 2 Techniques', 'Video', 'uploads/materials/ielts_07_speaking.mp4', '2025-10-13 20:25:17'),
(54, 42, 'IELTS-0-7-01-25', 'Reading: Skimming and Scanning', 'DOCX', 'uploads/materials/ielts_07_reading.docx', '2025-10-13 20:25:17'),
(55, 42, 'IELTS-0-7-01-25', 'Writing Task 2: Sample Essays', 'PDF', 'uploads/materials/ielts_07_essays.pdf', '2025-10-13 20:25:17'),
(56, 42, 'IELTS-0-7-01-25', 'Full Practice Test', 'PDF', 'uploads/materials/ielts_07_fulltest.pdf', '2025-10-13 20:25:17'),
(57, 38, NULL, 'té', 'JPG', 'uploads/materials/1760387370_Binh-Ba-du-lich-2-8797-1649732806.jpg', '2025-10-13 20:29:30'),
(58, 32, NULL, 'té', 'WEBP', 'uploads/materials/1760387813_du-lich-mien-trung-7.webp', '2025-10-13 20:36:53'),
(59, 32, NULL, 'téaaa', 'PDF', 'uploads/materials/1760387976_hdh-full.pdf', '2025-10-13 20:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `ketquabaitest`
--

CREATE TABLE `ketquabaitest` (
  `id_ketqua` int(11) NOT NULL,
  `id_cauhoi` int(11) DEFAULT NULL,
  `id_hocvien` int(11) DEFAULT NULL,
  `id_baitest` int(11) DEFAULT NULL,
  `diem` decimal(10,2) DEFAULT NULL,
  `ngay_lam_bai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ketquabaitest`
--

INSERT INTO `ketquabaitest` (`id_ketqua`, `id_cauhoi`, `id_hocvien`, `id_baitest`, `diem`, `ngay_lam_bai`) VALUES
(12, NULL, 1, 9, 3.00, '2025-10-02 15:37:00'),
(13, NULL, 1, 2, 0.00, '2025-10-11 02:41:02'),
(14, NULL, 27, 1, 10.00, '2025-10-14 03:35:34'),
(15, NULL, 27, 7, 2.00, '2025-10-14 03:52:19'),
(16, NULL, 1, 2, 0.00, '2025-10-14 20:06:07'),
(17, NULL, 1, NULL, 0.00, '2025-10-14 20:06:16'),
(18, NULL, 1, NULL, 0.00, '2025-10-14 20:06:37'),
(19, NULL, 1, NULL, 0.00, '2025-10-14 20:07:15'),
(27, NULL, 1, 1, 6.00, '2025-10-15 01:08:53'),
(33, NULL, 1, 41, 0.00, '2025-10-16 20:13:51'),
(34, NULL, 1, 41, 0.00, '2025-10-16 20:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `khoahoc`
--

CREATE TABLE `khoahoc` (
  `id_khoahoc` int(11) NOT NULL,
  `ten_khoahoc` varchar(100) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `thoi_gian` int(11) DEFAULT NULL COMMENT 'Thời lượng khóa học (tính bằng số buổi)',
  `chi_phi` int(11) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `danh_gia_tb` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khoahoc`
--

INSERT INTO `khoahoc` (`id_khoahoc`, `ten_khoahoc`, `mo_ta`, `thoi_gian`, `chi_phi`, `hinh_anh`, `danh_gia_tb`) VALUES
(32, 'Khóa học tiếng Anh cho người mất gốc', '<p>Kh&oacute;a học tiếng anh online cho người mất gốc l&agrave; kh&oacute;a học được thiết kế d&agrave;nh ri&ecirc;ng cho những người bắt đầu học tiếng Anh từ con số 0 tr&ecirc;n nền tảng trực tuyến. Những học vi&ecirc;n bị mất căn bản &amp; cần x&acirc;y dựng lại nền tảng kiến thức Anh ngữ từ đầu v&agrave; tiết kiệm thời gian di chuyển đến trung t&acirc;m th&igrave; c&oacute; thể tham khảo kh&oacute;a học n&agrave;y nh&eacute;!<br />\r\nLộ tr&igrave;nh kh&oacute;a học được x&acirc;y dựng b&agrave;i bản, tập trung v&agrave;o những chủ đề gần gũi, thiết thực trong đời sống. Ngo&agrave;i ra, kh&oacute;a học hướng tới yếu tố &ldquo;học s&acirc;u, nhớ l&acirc;u&rdquo;, ph&aacute;t triển kỹ năng tập trung gi&uacute;p người học tiếng Anh từ &ldquo;zero&rdquo; th&agrave;nh &ldquo;hero&rdquo;.</p>\r\n\r\n<h3>Ưu điểm của kh&oacute;a tiếng Anh online cho người mất gốc:</h3>\r\n\r\n<ul>\r\n	<li>Được thiết kế d&agrave;nh ri&ecirc;ng cho người mất gốc tiếng Anh tr&ecirc;n nền tảng học online</li>\r\n	<li>Học bất bất cứ nơi đ&acirc;u, bất cứ thời gian n&agrave;o theo lịch rảnh của bản th&acirc;n</li>\r\n	<li>Học trực tiếp với giảng vi&ecirc;n thay v&igrave; c&aacute;c chuỗi video</li>\r\n	<li>Được m&ocirc; phỏng giống 100% so với c&aacute;c lớp học offline tại trung t&acirc;m</li>\r\n	<li>Slide b&agrave;i giảng trực quan, thiết thực, đi s&acirc;u v&agrave;o ph&acirc;n t&iacute;ch &amp; cải thiện từng kỹ năng cho người học</li>\r\n	<li>Phương ph&aacute;p học tập khoa học, mang t&iacute;nh tương t&aacute;c cao giữa gi&aacute;o vi&ecirc;n &amp; học vi&ecirc;n trong suốt qu&aacute; tr&igrave;nh học tập trực tuyến, gi&uacute;p học vi&ecirc;n dễ tiếp thu b&agrave;i giảng &amp; vận dụng nhanh ch&oacute;ng v&agrave;o thực tế</li>\r\n	<li>Cam kết x&acirc;y dựng nền tảng tiếng Anh hiệu quả trong suốt thời gian học online</li>\r\n	<li>Ứng dụng c&ocirc;ng nghệ khoa học v&agrave;o giảng dạy, gi&uacute;p học vi&ecirc;n trải nghiệm học online đạt chuẩn quốc tế</li>\r\n	<li>Đội ngũ gi&aacute;o vi&ecirc;n Việt &amp; bản xứ giỏi, tận t&acirc;m, được đ&agrave;o tạo chuy&ecirc;n s&acirc;u về giảng dạy</li>\r\n	<li>Hệ thống đăng k&yacute; lịch học online c&ocirc;ng nghệ hiện đại với 10 khung giờ linh hoạt mỗi ng&agrave;y</li>\r\n	<li>Kết hợp với kh&oacute;a học ph&aacute;t &acirc;m tiếng Anh cho học vi&ecirc;n giọng chuẩn bản xứ cực kỳ chi tiết</li>\r\n</ul>\r\n\r\n<p>Kh&oacute;a học tiếng Anh giao tiếp Online cho người mất gốc sẽ gi&uacute;p học vi&ecirc;n điều chỉnh ph&aacute;t &acirc;m chuẩn theo bản phi&ecirc;n &acirc;m quốc tế từ Gi&aacute;o vi&ecirc;n người Việt &amp; bản ngữ. Học ph&aacute;t &acirc;m từng bước từ ph&aacute;t &acirc;m từ đơn, đến ph&aacute;t &acirc;m chuẩn nguy&ecirc;n c&acirc;u &amp; ph&aacute;t &acirc;m hay k&egrave;m ngữ điệu tự nhi&ecirc;n. Học vi&ecirc;n cũng được ph&aacute;t triển kỹ năng nghe (Listening) trong suốt qu&aacute; tr&igrave;nh học tiếng Anh trực tuyến.</p>\r\n', NULL, 2000, 'uploads/img1.jpg', 5.00),
(35, 'Khóa học tiếng Anh cho trẻ em và thanh thiếu niên', '<p>Đội ngũ gi&aacute;o vi&ecirc;n sẽ phối hợp với qu&yacute; phụ huynh để đảm bảo c&aacute;c em học sinh được hỗ trợ trong từng bước h&agrave;nh tr&igrave;nh học tiếng Anh. Cũng như qu&yacute; phụ huynh, ch&uacute;ng t&ocirc;i hiểu được tiềm năng của trẻ v&agrave; mong muốn gi&uacute;p trẻ đạt được tiến bộ r&otilde; rệt.&nbsp;</p>\r\n\r\n<p>Chứng kiến sự trưởng th&agrave;nh về học lực v&agrave; sự tự tin của trẻ. Th&ocirc;ng qua c&aacute;c kh&oacute;a học, trẻ sẽ ph&aacute;t triển sự s&aacute;ng tạo, tăng cường c&aacute;c kỹ năng gi&uacute;p th&agrave;nh c&ocirc;ng v&agrave; khả năng tiếng Anh - ng&ocirc;n ngữ chung của thế giới.</p>\r\n\r\n<h2><strong>Ph&aacute;t huy sự tự tin v&agrave; truyền cảm hứng s&aacute;ng tạo&nbsp;</strong></h2>\r\n', NULL, 2000, 'uploads/anh_email_hs_0.avif', NULL),
(36, 'Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam', '<p>N&oacute;i nhanh, n&oacute;i chuẩn, n&oacute;i linh hoạt theo từng ngữ cảnh, tự tin bắt chuyện với đối t&aacute;c nước ngo&agrave;i, l&agrave;m chủ giao tiếp hang ng&agrave;y trong c&ocirc;ng việc.</p>\r\n\r\n<p><strong>1. Phương ph&aacute;p học tập A.I.T.E.C.H</strong></p>\r\n\r\n<ul>\r\n	<li>Lấy giao tiếp l&agrave;m cốt l&otilde;i</li>\r\n	<li>Lấy học vi&ecirc;n l&agrave;m trọng t&acirc;m</li>\r\n	<li>Tập trung n&acirc;ng cao về kỹ năng giao tiếp v&agrave; thực h&agrave;nh phản xạ nghe n&oacute;i tự nhi&ecirc;n, chỉnh sửa ph&aacute;t &acirc;m chuẩn quốc tế, &aacute;p dụng c&aacute;c t&igrave;nh huống giao tiếp gắn liền với cuộc sống v&agrave; c&ocirc;ng việc h&agrave;ng ng&agrave;y gi&uacute;p chị r&egrave;n kỹ năng tư duy thẳng ho&agrave;n to&agrave;n bằng tiếng Anh.</li>\r\n</ul>\r\n\r\n<p><strong>2. Gi&aacute;o tr&igrave;nh chuẩn 100% quốc tế v&agrave; được Hội đồng chuy&ecirc;n m&ocirc;n thiết kế c&aacute; nh&acirc;n ho&aacute; ph&ugrave; hợp theo từng mục ti&ecirc;u, tr&igrave;nh độ của học vi&ecirc;n</strong></p>\r\n\r\n<p>Dựa tr&ecirc;n mong muốn học tập của học vi&ecirc;n th&igrave; Hội đồng chuy&ecirc;n m&ocirc;n sẽ x&acirc;y dựng gi&aacute;o tr&igrave;nh tiếng Anh ph&ugrave; hợp. Chương tr&igrave;nh c&oacute; 3 loại gi&aacute;o tr&igrave;nh:</p>\r\n\r\n<ul>\r\n	<li><strong>Gi&aacute;o tr&igrave;nh cho c&aacute;c b&eacute; Kids theo ti&ecirc;u chuẩn của Cambridge:</strong>&nbsp;Tất cả c&aacute;c chương tr&igrave;nh học đều được thiết kế đa phương tiện gồm: H&igrave;nh ảnh, &acirc;m thanh, video, c&acirc;u chuyện sinh động, nh&acirc;n vật hoạt h&igrave;nh đồng h&agrave;nh trong to&agrave;n bộ qu&aacute; tr&igrave;nh học. C&aacute;c chủ đề từ vựng, ngữ ph&aacute;p được thiết kế xen kẽ c&aacute;c t&igrave;nh huống giao tiếp đời sống, học tập. Ngo&agrave;i ra con được học kết hợp c&aacute;c bộ m&ocirc;n khoa học thưởng thức v&agrave; b&agrave;i học đạo đức x&atilde; hội, gi&uacute;p con ph&aacute;t triển to&agrave;n diện Kỹ năng giao tiếp, kỹ năng mềm v&agrave; kỹ năng tư duy.</li>\r\n	<li><strong>GT th&ocirc;ng dụng GE:</strong>&nbsp;X&acirc;y dựng c&aacute;c t&igrave;nh huống giao tiếp trong cuộc sống hằng ng&agrave;y, giao tiếp bạn b&egrave;; định cư; du lịch&hellip;</li>\r\n	<li><strong>MBE &ndash; tiếng anh giao tiếp trong m&ocirc;i trường c&ocirc;ng sở:</strong>&nbsp;kinh doanh; họp h&agrave;nh; b&aacute;o c&aacute;o; thuyết tr&igrave;nh, đ&agrave;m ph&aacute;n.</li>\r\n</ul>\r\n\r\n<p><strong>3. Anh/ Chị đăng k&yacute; theo lịch học cố định ph&ugrave; hợp:</strong></p>\r\n\r\n<ul>\r\n	<li>Từ 8h &ndash; 23h, từ thứ 2-thứ 6 (nghỉ t7-cn)</li>\r\n	<li>Luyện n&oacute;i phản xạ tối thiểu 30 ph&uacute;t/buổi; 3 &ndash; 5 buổi/tuần</li>\r\n</ul>\r\n\r\n<p><strong>4. Hai gi&aacute;o vi&ecirc;n đồng h&agrave;nh xuy&ecirc;n suốt qu&aacute; tr&igrave;nh học: Với kho&aacute; học n&agrave;y th&igrave; học vi&ecirc;n sẽ được học 100% gi&aacute;o vi&ecirc;n Việt Nam</strong></p>\r\n\r\n<p><strong>Gi&aacute;o vi&ecirc;n cố định 1 k&egrave;m 1:</strong></p>\r\n\r\n<ul>\r\n	<li>Với kho&aacute; học n&agrave;y th&igrave; học vi&ecirc;n sẽ được học 100% gi&aacute;o vi&ecirc;n Việt Nam với đầy đủ chứng chỉ sư phạm, chứng chỉ tiếng Anh hoặc c&aacute;c chứng chỉ kh&aacute;c tương đương v&agrave; &iacute;t nhất hai năm kinh nghiệm giảng dạy</li>\r\n	<li>Được đ&agrave;o tạo theo quy chuẩn 5 bước về kỹ năng giảng dạy v&agrave; chuy&ecirc;n m&ocirc;n sư phạm bởi hội đồng chuy&ecirc;n gia h&agrave;ng đầu về ng&ocirc;n ngữ:( Phỏng vấn &ndash; Dạy thử &ndash; QC &ndash; Nhận lớp &ndash; Đ&aacute;nh gi&aacute;)</li>\r\n	<li>\r\n	<p><strong>Cố vấn học tập v&agrave; hội đồng QC:</strong></p>\r\n	</li>\r\n	<li>Sẽ đồng h&agrave;nh c&ugrave;ng học vi&ecirc;n theo s&aacute;t lộ tr&igrave;nh học tập về: lịch học; chất lượng gi&aacute;o vi&ecirc;n; chất lượng buổi học</li>\r\n	<li>Học vi&ecirc;n sẽ li&ecirc;n hệ Cố vấn học tập qua nh&oacute;m chat học tập zalo</li>\r\n</ul>\r\n\r\n<p><strong>5. Hệ thống Gi&aacute;o dục trực tuyến độc quyền LMS ( Learning Management Systerm) 5 trong 1:</strong></p>\r\n\r\n<ul>\r\n	<li>Tương t&aacute;c đa chiều</li>\r\n	<li>L&agrave;m b&agrave;i tập trực tuyến.</li>\r\n	<li>T&iacute;ch hợp t&agrave;i liệu bổ trợ.</li>\r\n	<li>Kiểm so&aacute;t b&aacute;o c&aacute;o tiến bộ định kỳ : định kỳ hệ thống sẽ thống k&ecirc; b&aacute;o c&aacute;o kết quả học tập của chị</li>\r\n	<li>Lưu trữ buổi học trực tuyến tự động: lưu lại tr&ecirc;n t&agrave;i khoản học tập để chị xem lại khi cần &ocirc;n tập; đ&aacute;nh gi&aacute; về qu&aacute; tr&igrave;nh học của m&igrave;nh v&agrave; chất lượng dịch vụ học tập của nh&agrave; trường</li>\r\n</ul>\r\n\r\n<p><strong>6. Cam kết ho&agrave;n học ph&iacute; đ&agrave;o tạo 100% nếu kh&ocirc;ng đạt được điểm số cam kết theo hợp đồng gi&aacute;o dục:</strong></p>\r\n\r\n<ul>\r\n	<li>Cam kết chất lượng được thể hiện bằng điểm số GSE-về năng lực giao tiếp nghe n&oacute;i theo chuẩn quốc tế tr&ecirc;n tổng điểm 90</li>\r\n	<li>Cam kết sẽ thể hiện bằng văn bản: Hợp đồng gi&aacute;o dục.</li>\r\n</ul>\r\n', NULL, 2000, 'uploads/1kem1.jpg', NULL),
(37, 'Khóa Học Tiếng Anh Giao Tiếp', '<p>Tiếng Anh l&agrave; một trong những ng&ocirc;n ngữ phổ biến khắp thế giới. Với khả năng tiếng Anh tốt, bạn c&oacute; thể giao tiếp với khoảng 1/6 d&acirc;n số tr&ecirc;n thế giới, mở ra những c&aacute;nh cửa cơ hội trong cuộc sống v&agrave; đặc biệt sẽ gi&uacute;p &iacute;ch cho c&ocirc;ng việc của bạn rất nhiều.</p>\r\n\r\n<p>Nhận thấy tầm quan trọng của tiếng Anh trong x&atilde; hội to&agrave;n cầu h&oacute;a hiện nay, Thi&ecirc;n T&uacute; Academy đ&atilde; tổ chức c&aacute;c kh&oacute;a học Tiếng Anh Giao Tiếp với &ldquo;<em>Học ph&iacute; Việt Nam &ndash; Chất lượng to&agrave;n cầu</em>&rdquo;. Kh&oacute;a học nhằm gi&uacute;p học vi&ecirc;n ph&aacute;t triển c&aacute;c kỹ năng tiếng Anh ph&ugrave; hợp với mục ti&ecirc;u học tập, nghề nghiệp v&agrave; cả mục ti&ecirc;u c&aacute; nh&acirc;n. Đặc biệt l&agrave; đối với những ai c&oacute; &yacute; định đi du học hay định cư,&hellip;khả năng giao tiếp tiếng Anh tốt đ&atilde; gi&uacute;p c&aacute;c bạn đi được đến hơn 1/3 chặng đường.</p>\r\n\r\n<p><img alt=\"\" src=\"https://thientu-academy.com/wp-content/uploads/2020/10/like.png\" style=\"height:64px; width:64px\" /></p>\r\n\r\n<p>Lợi &Iacute;ch Kh&oacute;a Học</p>\r\n\r\n<p>1. Ph&aacute;t triển kỹ năng nghe &ndash; n&oacute;i một c&aacute;ch tối đa</p>\r\n\r\n<p>2. Mở rộng kiến thức ngo&agrave;i s&aacute;ch gi&aacute;o khoa</p>\r\n\r\n<p>3. Tăng khả năng tư duy, học hỏi, s&aacute;ng tạo</p>\r\n\r\n<p>4. Kỹ năng n&oacute;i tr&ocirc;i chảy v&agrave; tự tin hơn trong giao tiếp</p>\r\n\r\n<p>5. Tạo tiền đề cho c&aacute;c kh&oacute;a học luyện thi IELTS sau n&agrave;y</p>\r\n\r\n<p>6. Hoạt động nh&oacute;m li&ecirc;n tục v&agrave; đa dạng h&igrave;nh thức</p>\r\n\r\n<p>7. Phục vụ nhu cầu đi du học &amp; định cư cho tương lai</p>\r\n\r\n<p><img alt=\"\" src=\"https://thientu-academy.com/wp-content/uploads/2020/10/book-1.png\" style=\"height:64px; width:64px\" /></p>\r\n\r\n<h3>Điều Kiện Đầu V&agrave;o</h3>\r\n\r\n<h3>Độ tuổi:</h3>\r\n\r\n<ul>\r\n	<li>Từ 7 tuổi trở l&ecirc;n</li>\r\n</ul>\r\n\r\n<h3>Tr&igrave;nh độ học vấn:</h3>\r\n\r\n<ul>\r\n	<li>Kh&ocirc;ng y&ecirc;u cầu</li>\r\n</ul>\r\n\r\n<h3>Tr&igrave;nh độ ngoại ngữ:</h3>\r\n\r\n<ul>\r\n	<li>Ho&agrave;n th&agrave;nh b&agrave;i kiểm tra đầu v&agrave;o của trung t&acirc;m (nếu cần)</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n', NULL, 3000000, 'uploads/sGRAe3NTTS.jpg', NULL),
(38, ' Khóa học TOEIC 4 KỸ NĂNG', '<p>Kh&oacute;a học TOEIC 4 kỹ năng bao gồm luyện tập cả 4 kỹ năng nghe, n&oacute;i, đọc v&agrave; viết, nhằm gi&uacute;p học vi&ecirc;n cải thiện khả năng sử dụng tiếng Anh một c&aacute;ch to&agrave;n diện v&agrave; chuẩn bị tốt hơn cho kỳ thi TOEIC. Kh&oacute;a học n&agrave;y c&oacute; thể gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng giao tiếp tiếng Anh, đọc hiểu c&aacute;c t&agrave;i liệu chuy&ecirc;n ng&agrave;nh, viết b&aacute;o c&aacute;o v&agrave; email c&ocirc;ng việc, v&agrave; cải thiện điểm số TOEIC của m&igrave;nh.</p>\r\n\r\n<h2>1. Giới thiệu về kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p><a href=\"https://edusa.vn/toeic-4-ky-nang-bao-nhieu-tien/\">Kh&oacute;a học TOEIC 4 kỹ năng</a>&nbsp;(TOEIC 4 Skills) l&agrave; một kh&oacute;a học tiếng Anh tổng qu&aacute;t, tập trung v&agrave;o cải thiện cả bốn kỹ năng ng&ocirc;n ngữ tiếng Anh, bao gồm Nghe, N&oacute;i, Đọc v&agrave; Viết. Kh&oacute;a học n&agrave;y gi&uacute;p người học x&acirc;y dựng nền tảng ng&ocirc;n ngữ tiếng Anh vững chắc để chuẩn bị cho kỳ thi TOEIC hoặc c&aacute;c kỳ thi tương tự. Trong kh&oacute;a học, học vi&ecirc;n sẽ được trang bị vốn từ vựng phong ph&uacute;, kỹ năng ph&aacute;t &acirc;m, luyện nghe hiểu, n&acirc;ng cao kỹ năng viết v&agrave; n&oacute;i tiếng Anh th&ocirc;ng qua c&aacute;c b&agrave;i tập v&agrave; c&aacute;c hoạt động tương t&aacute;c. Kh&oacute;a học n&agrave;y th&iacute;ch hợp cho những người muốn n&acirc;ng cao tr&igrave;nh độ tiếng Anh chung v&agrave; sẵn s&agrave;ng đạt được điểm số cao trong kỳ thi TOEIC.</p>\r\n\r\n<p><strong>C&oacute; thể bạn quan t&acirc;m:&nbsp;<a href=\"https://edusa.vn/luyen-thi-toeic-cap-toc-online/\">Kh&oacute;a luyện thi toeic cấp tốc online trải nghiệm Học thật &ndash; thi thật</a></strong></p>\r\n\r\n<p><strong>C&oacute; thể bạn quan t&acirc;m:</strong>&nbsp;<a href=\"https://edusa.vn/khoa-hoc-toeic-4-ky-nang-online/\"><strong>Chi tiết về kh&oacute;a học TOEIC 4 kỹ năng Online</strong></a></p>\r\n\r\n<h2>2. Tại sao n&ecirc;n học kh&oacute;a học TOEIC 4 kỹ năng?</h2>\r\n\r\n<p>Kh&oacute;a học TOEIC 4 kỹ năng l&agrave; một kh&oacute;a học tiếng Anh được thiết kế để gi&uacute;p học vi&ecirc;n cải thiện 4 kỹ năng quan trọng: nghe, đọc, n&oacute;i v&agrave; viết, để c&oacute; thể đạt được kết quả cao trong kỳ thi TOEIC. Tại sao n&ecirc;n học kh&oacute;a học TOEIC 4 kỹ năng? Dưới đ&acirc;y l&agrave; một số l&yacute; do quan trọng:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Tăng khả năng giao tiếp bằng tiếng Anh: Kh&oacute;a học TOEIC 4 kỹ năng sẽ gi&uacute;p bạn n&acirc;ng cao kỹ năng nghe v&agrave; n&oacute;i của m&igrave;nh, gi&uacute;p bạn tự tin hơn khi giao tiếp bằng tiếng Anh. Bạn sẽ c&oacute; cơ hội luyện tập kỹ năng nghe v&agrave; ph&aacute;t &acirc;m trong m&ocirc;i trường học tập chuy&ecirc;n nghiệp v&agrave; thuận lợi.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cải thiện kỹ năng đọc hiểu: Trong kh&oacute;a học n&agrave;y, bạn sẽ được đ&agrave;o tạo để c&oacute; thể đọc hiểu c&aacute;c đoạn văn bản học thuật v&agrave; kinh doanh bằng tiếng Anh. Điều n&agrave;y sẽ gi&uacute;p bạn n&acirc;ng cao khả năng đọc hiểu v&agrave; giải quyết c&aacute;c vấn đề li&ecirc;n quan đến c&ocirc;ng việc hoặc học tập.</p>\r\n	</li>\r\n	<li>\r\n	<p>N&acirc;ng cao kỹ năng viết: Kỹ năng viết lu&ocirc;n l&agrave; một trong những kỹ năng kh&oacute; nhất trong tiếng Anh. Tuy nhi&ecirc;n, kh&oacute;a học TOEIC 4 kỹ năng sẽ gi&uacute;p bạn n&acirc;ng cao kỹ năng viết v&agrave; cung cấp c&aacute;c kỹ thuật để viết đ&uacute;ng, đủ v&agrave; r&otilde; r&agrave;ng.</p>\r\n	</li>\r\n	<li>\r\n	<p>Đ&aacute;p ứng y&ecirc;u cầu của thị trường lao động: Nếu bạn muốn th&agrave;nh c&ocirc;ng trong sự nghiệp, việc c&oacute; một chứng chỉ TOEIC với điểm số cao rất quan trọng. Với kết quả cao trong kỳ thi TOEIC, bạn sẽ c&oacute; nhiều cơ hội hơn để t&igrave;m kiếm việc l&agrave;m tốt hơn v&agrave; c&oacute; thu nhập cao hơn.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cập nhật kiến thức tiếng Anh mới nhất: Với kh&oacute;a học TOEIC 4 kỹ năng, bạn sẽ được cập nhật c&aacute;c kiến thức mới nhất trong lĩnh vực tiếng Anh học thuật v&agrave; kinh doanh. Bạn sẽ học c&aacute;c từ vựng v&agrave; thuật ngữ mới, v&agrave; n&acirc;ng cao kỹ năng sử dụng ng&ocirc;n ngữ chuy&ecirc;n ng&agrave;nh.</p>\r\n	</li>\r\n</ol>\r\n\r\n<h2>3. C&aacute;c phương ph&aacute;p v&agrave; kỹ thuật luyện thi TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Luyện thi TOEIC 4 kỹ năng l&agrave; qu&aacute; tr&igrave;nh r&egrave;n luyện v&agrave; n&acirc;ng cao kỹ năng ng&ocirc;n ngữ Anh cần thiết để đạt được điểm số cao trong kỳ thi TOEIC. Kh&oacute;a học n&agrave;y tập trung v&agrave;o 4 kỹ năng ch&iacute;nh bao gồm: Nghe, Đọc, N&oacute;i v&agrave; Viết. Dưới đ&acirc;y l&agrave; một số phương ph&aacute;p v&agrave; kỹ thuật hiệu quả trong việc luyện thi TOEIC 4 kỹ năng.</p>\r\n\r\n<p>Nghe:</p>\r\n\r\n<p>Học c&aacute;c từ vựng chuy&ecirc;n ng&agrave;nh: Tập trung v&agrave;o ngữ ph&aacute;p v&agrave; từ vựng chuy&ecirc;n ng&agrave;nh thường được sử dụng trong c&aacute;c cuộc giao tiếp trong ng&agrave;nh của bạn. Điều n&agrave;y gi&uacute;p bạn dễ d&agrave;ng hiểu được c&aacute;c c&acirc;u hỏi v&agrave; nội dung chủ đề trong đề thi TOEIC.<br />\r\nLuyện nghe nhiều: H&atilde;y luyện nghe tiếng Anh một c&aacute;ch chủ động, bằng c&aacute;ch nghe c&aacute;c bản tin, phim, chương tr&igrave;nh thực tế hoặc c&aacute;c b&agrave;i giảng học thuật li&ecirc;n quan đến ng&agrave;nh của bạn.<br />\r\nL&agrave;m b&agrave;i tập nghe: L&agrave;m c&aacute;c b&agrave;i tập nghe từ c&aacute;c t&agrave;i liệu luyện thi TOEIC để củng cố kỹ năng nghe của bạn.</p>\r\n\r\n<p>Đọc:</p>\r\n\r\n<p>Học từ vựng v&agrave; ngữ ph&aacute;p cần thiết: Tập trung v&agrave;o học c&aacute;c từ vựng v&agrave; ngữ ph&aacute;p li&ecirc;n quan đến chuy&ecirc;n ng&agrave;nh của bạn, gi&uacute;p bạn dễ d&agrave;ng hiểu được c&aacute;c c&acirc;u hỏi v&agrave; c&aacute;c nội dung chủ đề trong đề thi.<br />\r\nĐọc nhiều: Đọc c&aacute;c b&aacute;o, tạp ch&iacute; v&agrave; s&aacute;ch về chuy&ecirc;n ng&agrave;nh của bạn. Điều n&agrave;y gi&uacute;p bạn l&agrave;m quen với c&aacute;c từ vựng v&agrave; thuật ngữ chuy&ecirc;n m&ocirc;n.<br />\r\nL&agrave;m b&agrave;i tập đọc: L&agrave;m c&aacute;c b&agrave;i tập đọc từ c&aacute;c t&agrave;i liệu luyện thi TOEIC để củng cố kỹ năng đọc của bạn.</p>\r\n\r\n<p>N&oacute;i:</p>\r\n\r\n<p>Luyện n&oacute;i thường xuy&ecirc;n: H&atilde;y t&igrave;m kiếm cơ hội để n&oacute;i tiếng Anh với bạn b&egrave;, đồng nghiệp hoặc tham gia c&aacute;c lớp học n&oacute;i tiếng Anh.<br />\r\nThực h&agrave;nh c&acirc;u trả lời đ&uacute;ng dạng: Tập trung v&agrave;o c&aacute;c c&acirc;u hỏi phổ biến trong đề thi TOEIC, nghi&ecirc;n cứu v&agrave; thực h&agrave;nh c&acirc;u trả lời đ&uacute;ng dạng để củng cố kỹ năng n&oacute;i của bạn.</p>\r\n\r\n<p>Luyện ngữ ph&aacute;p v&agrave; từ vựng đồng thời: Kh&ocirc;ng thể thiếu việc học ngữ ph&aacute;p v&agrave; từ vựng trong qu&aacute; tr&igrave;nh luyện thi TOEIC. Tuy nhi&ecirc;n, để tối ưu h&oacute;a qu&aacute; tr&igrave;nh học, bạn n&ecirc;n học ngữ ph&aacute;p v&agrave; từ vựng đồng thời với c&aacute;c kỹ năng kh&aacute;c như đọc hiểu, nghe v&agrave; n&oacute;i. Việc n&agrave;y gi&uacute;p bạn ph&aacute;t triển vốn từ vựng v&agrave; khả năng sử dụng ngữ ph&aacute;p trong c&aacute;c b&agrave;i thi TOEIC.</p>\r\n\r\n<p><br />\r\nTập trung v&agrave;o phần nghe: Phần nghe trong kỳ thi TOEIC chiếm tỷ lệ điểm kh&aacute; cao, do đ&oacute; việc tập trung luyện nghe l&agrave; rất quan trọng. Bạn c&oacute; thể luyện nghe qua c&aacute;c b&agrave;i nghe tr&ecirc;n mạng hoặc qua c&aacute;c t&agrave;i liệu luyện thi TOEIC. Bạn n&ecirc;n luyện nghe tr&ecirc;n nhiều chủ đề kh&aacute;c nhau để cải thiện khả năng nghe của m&igrave;nh.</p>\r\n\r\n<p><br />\r\nTổ chức thời gian hợp l&yacute;: Khi luyện thi TOEIC 4 kỹ năng, bạn cần phải biết c&aacute;ch ph&acirc;n bổ thời gian hợp l&yacute; cho c&aacute;c kỹ năng kh&aacute;c nhau. Bạn n&ecirc;n sử dụng một lịch tr&igrave;nh học tập để luyện tập mỗi kỹ năng theo từng phần nhỏ trong ng&agrave;y.</p>\r\n\r\n<p><br />\r\nThi thử TOEIC: Thi thử TOEIC l&agrave; c&aacute;ch tốt nhất để kiểm tra khả năng v&agrave; đo lường tiến độ luyện tập của m&igrave;nh. Thi thử gi&uacute;p bạn l&agrave;m quen với cấu tr&uacute;c đề thi, c&aacute;ch đọc v&agrave; hiểu c&acirc;u hỏi, từ đ&oacute; gi&uacute;p bạn tự tin hơn khi bước v&agrave;o kỳ thi thật.</p>\r\n\r\n<p><br />\r\nTham gia lớp học TOEIC: Nếu bạn muốn c&oacute; kết quả tốt nhất trong kỳ thi TOEIC, h&atilde;y tham gia lớp học TOEIC. Lớp học TOEIC cung cấp kiến thức chuy&ecirc;n s&acirc;u, gi&uacute;p bạn hiểu r&otilde; hơn về cấu tr&uacute;c đề thi TOEIC cũng như phương ph&aacute;p giải đề thi. B&ecirc;n cạnh đ&oacute;, lớp học c&ograve;n gi&uacute;p bạn r&egrave;n luyện kỹ năng nghe, n&oacute;i, đọc v&agrave; viết.</p>\r\n\r\n<h2>4. C&aacute;c lưu &yacute; v&agrave; ch&uacute; &yacute; khi học kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Khi học kh&oacute;a học TOEIC 4 kỹ năng, bạn cần lưu &yacute; một số điểm sau để đạt hiệu quả tốt nhất:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>X&aacute;c định mục ti&ecirc;u học tập r&otilde; r&agrave;ng: Bạn n&ecirc;n đặt ra mục ti&ecirc;u cụ thể cho m&igrave;nh về điểm số TOEIC m&agrave; muốn đạt được v&agrave; l&ecirc;n kế hoạch học tập cho ph&ugrave; hợp với mục ti&ecirc;u đ&oacute;.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tập trung v&agrave;o 4 kỹ năng: Bạn cần học đồng thời 4 kỹ năng l&agrave; Nghe, N&oacute;i, Đọc v&agrave; Viết, thay v&igrave; tập trung qu&aacute; nhiều v&agrave;o một kỹ năng cụ thể.</p>\r\n	</li>\r\n	<li>\r\n	<p>Sử dụng t&agrave;i liệu học tập chất lượng: Chọn lựa t&agrave;i liệu học tập ph&ugrave; hợp v&agrave; c&oacute; chất lượng tốt sẽ gi&uacute;p bạn tiết kiệm thời gian v&agrave; đạt được kết quả tốt nhất.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tham gia lớp học trực tuyến: Việc tham gia lớp học trực tuyến gi&uacute;p bạn tiết kiệm được thời gian di chuyển, c&oacute; cơ hội học tập v&agrave; tương t&aacute;c với c&aacute;c giảng vi&ecirc;n v&agrave; học vi&ecirc;n kh&aacute;c.</p>\r\n	</li>\r\n	<li>\r\n	<p>Thực h&agrave;nh thường xuy&ecirc;n: Thực h&agrave;nh l&agrave; c&aacute;ch tốt nhất để n&acirc;ng cao kỹ năng của bạn. Bạn cần l&ecirc;n kế hoạch thực h&agrave;nh thường xuy&ecirc;n để r&egrave;n luyện khả năng sử dụng tiếng Anh một c&aacute;ch th&agrave;nh thạo.</p>\r\n	</li>\r\n	<li>\r\n	<p>Đ&aacute;nh gi&aacute; tiến độ học tập: Bạn cần đ&aacute;nh gi&aacute; tiến độ học tập thường xuy&ecirc;n để biết m&igrave;nh đang ở đ&acirc;u v&agrave; cần cải thiện điểm g&igrave; để đạt được mục ti&ecirc;u của m&igrave;nh.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tự tin v&agrave; ki&ecirc;n nhẫn: Cuối c&ugrave;ng, bạn cần tự tin v&agrave; ki&ecirc;n nhẫn trong qu&aacute; tr&igrave;nh học tập. Đ&ocirc;i khi bạn c&oacute; thể gặp kh&oacute; khăn v&agrave; thất vọng, nhưng h&atilde;y ki&ecirc;n tr&igrave; v&agrave; kh&ocirc;ng bỏ cuộc. Sự cố gắng v&agrave; nỗ lực sẽ mang lại kết quả tốt cho bạn.</p>\r\n	</li>\r\n</ol>\r\n\r\n<blockquote>\r\n<p><strong>&gt;&gt;&gt;&gt; Tham khảo th&ecirc;m :&nbsp;<a href=\"https://edusa.vn/khoa-hoc-toeic/\">Kh&oacute;a luyện thi TOEIC 4 kỹ năng tại Edusa&nbsp;</a></strong></p>\r\n</blockquote>\r\n\r\n<h2>5. B&agrave;i tập v&agrave; đề thi mẫu trong kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Trong kh&oacute;a học TOEIC 4 kỹ năng, c&aacute;c b&agrave;i tập v&agrave; đề thi mẫu được thiết kế để gi&uacute;p học vi&ecirc;n củng cố kiến thức v&agrave; kỹ năng của m&igrave;nh trong 4 kỹ năng Nghe, Đọc, N&oacute;i v&agrave; Viết, c&ugrave;ng với c&aacute;c kỹ năng li&ecirc;n quan như Từ vựng, Ngữ ph&aacute;p v&agrave; Ph&aacute;t &acirc;m.</p>\r\n\r\n<p>Dưới đ&acirc;y l&agrave; một số v&iacute; dụ về c&aacute;c b&agrave;i tập v&agrave; đề thi mẫu trong kh&oacute;a học TOEIC 4 kỹ năng:</p>\r\n\r\n<p>B&agrave;i tập Nghe: Học vi&ecirc;n sẽ được luyện nghe qua c&aacute;c b&agrave;i tập nghe, đối thoại, bản tin, c&aacute;c cuộc phỏng vấn, c&aacute;c b&agrave;i diễn thuyết v&agrave; c&aacute;c b&agrave;i đọc giả tưởng. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng lắng nghe v&agrave; hiểu r&otilde; &yacute; nghĩa của c&aacute;c từ, c&acirc;u v&agrave; đoạn văn.&nbsp;</p>\r\n\r\n<p>B&agrave;i tập Đọc: Học vi&ecirc;n sẽ được đọc c&aacute;c b&agrave;i b&aacute;o, đoạn văn, thư từ v&agrave; c&aacute;c t&agrave;i liệu kh&aacute;c li&ecirc;n quan đến kinh doanh, t&agrave;i ch&iacute;nh, kế to&aacute;n v&agrave; quản l&yacute;. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n ph&aacute;t triển khả năng đọc hiểu, t&igrave;m kiếm th&ocirc;ng tin v&agrave; đưa ra nhận x&eacute;t.</p>\r\n\r\n<p>B&agrave;i tập N&oacute;i: Học vi&ecirc;n sẽ được luyện n&oacute;i qua c&aacute;c b&agrave;i tập, đối thoại v&agrave; c&aacute;c b&agrave;i thuyết tr&igrave;nh. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng diễn đạt, ph&aacute;t &acirc;m v&agrave; sử dụng ng&ocirc;n ngữ ch&iacute;nh x&aacute;c.</p>\r\n\r\n<p>B&agrave;i tập Viết: Học vi&ecirc;n sẽ được luyện viết qua c&aacute;c b&agrave;i tập, b&agrave;i luận v&agrave; c&aacute;c b&aacute;o c&aacute;o. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n ph&aacute;t triển khả năng viết đ&uacute;ng ch&iacute;nh tả, sử dụng ngữ ph&aacute;p v&agrave; từ vựng ch&iacute;nh x&aacute;c.</p>\r\n\r\n<p>Đề thi mẫu: C&aacute;c đề thi mẫu được thiết kế để gi&uacute;p học vi&ecirc;n l&agrave;m quen với định dạng, thang điểm v&agrave; kiểu c&acirc;u hỏi của kỳ thi TOEIC. Học vi&ecirc;n c&oacute; thể sử dụng c&aacute;c đề thi mẫu để đ&aacute;nh gi&aacute; khả năng của m&igrave;nh v&agrave; củng cố kiến thức trước khi tham gia kỳ thi thực tế.</p>\r\n', NULL, 2500000, 'uploads/khoahoc10.jpg', 5.00),
(39, 'Khóa học IELTS – Foundation', '<p>Kh&oacute;a học được thiết kế d&agrave;nh cho c&aacute;c bạn cần được củng cố kiến thức nền tảng về ngữ ph&aacute;p, từ vựng, cấu tr&uacute;c c&acirc;u,&hellip; để bắt đầu l&agrave;m quen v&agrave; hiểu về cấu tr&uacute;c của b&agrave;i thi IELTS. Những chủ đề trong kh&oacute;a học n&agrave;y thường sẽ l&agrave; những chủ đề đơn giản, gần gũi trong cuộc sống h&agrave;ng ng&agrave;y.</p>\r\n\r\n<ul>\r\n	<li><strong>Mục ti&ecirc;u đầu ra:</strong>&nbsp;Band 4.5</li>\r\n	<li><strong>Gi&aacute;o tr&igrave;nh:</strong>&nbsp;Mindset For IELTS &ndash; Foundation của Đại học Cambridge c&ugrave;ng với c&aacute;c t&agrave;i liệu độc quyền của c&aacute;c Thầy C&ocirc; gi&agrave;u kinh nghiệm bi&ecirc;n soạn.</li>\r\n</ul>\r\n\r\n<p><strong>Kiến Thức Cần Đạt Được</strong></p>\r\n\r\n<p>Sau khi ho&agrave;n th&agrave;nh kh&oacute;a học, mục ti&ecirc;u học vi&ecirc;n cần đạt được như sau:</p>\r\n\r\n<ul>\r\n	<li>Reading: Tiếp cận với c&aacute;c dạng b&agrave;i của IELTS Reading kết hợp với phần b&agrave;i tập để luyện tập.</li>\r\n	<li>Listening: Cung cấp kiến thức ph&aacute;t triển kỹ năng nghe cơ bản rồi l&agrave;m quen dần với c&aacute;c dạng b&agrave;i của IETLS Listening.</li>\r\n	<li>&nbsp;Speaking: L&agrave;m quen với IELTS Speaking v&agrave; cung cấp lượng từ vựng academic dễ học &amp; kh&aacute; bổ &iacute;ch cho c&aacute;c bạn mới học.</li>\r\n	<li>Writing: Học về Writing gi&uacute;p c&aacute;c bạn ph&acirc;n biệt v&agrave; nắm r&otilde; việc kh&aacute;c nhau giữa writing trong đời thường &amp; writing học thuật thế n&agrave;o. Bước đầu gi&uacute;p c&aacute;c bạn hiểu về IELTS Writing Task 1 &amp; Task 2</li>\r\n</ul>\r\n', 0, 3301000, 'uploads/O21fPqavCk.jpg', NULL),
(40, 'Khóa học Tiếng Anh luyện thi IELTS', '<p>L&agrave; chuy&ecirc;n gia to&agrave;n cầu về giảng dạy tiếng Anh, Hội đồng Anh l&agrave; lựa chọn ho&agrave;n hảo để bạn tận dụng triệt để c&aacute;c cơ hội học tập v&agrave; th&agrave;nh c&ocirc;ng trong tương lai. Ch&uacute;ng t&ocirc;i tự h&agrave;o l&agrave; tổ chức duy nhất đồng thời cung cấp kh&oacute;a học tiếng Anh luyện thi v&agrave; kỳ thi IELTS; nơi gi&uacute;p bạn tối ưu điểm thi IELTS bạn mong muốn.</p>\r\n\r\n<p>Kh&oacute;a tiếng Anh luyện thi IELTS v&agrave; c&aacute;c nguồn học liệu trực tuyến của ch&uacute;ng t&ocirc;i sẽ gi&uacute;p bạn tối ưu điểm thi IELTS v&agrave; chuẩn bị nền tảng tốt nhất bật mở c&aacute;nh cửa tương lai.</p>\r\n\r\n<h2>Cải thiện kỹ năng tiếng Anh v&agrave; th&agrave;nh c&ocirc;ng với c&aacute;c cơ hội học tập trong tương lai.</h2>\r\n', 0, 1500000, 'uploads/630x354-70-target-score-viet.avif', NULL),
(41, 'KHÓA HỌC TOEIC GIẢI ĐỀ ', '<p>C&oacute; thể n&oacute;i trải qua hơn 30 năm h&igrave;nh th&agrave;nh v&agrave; ph&aacute;t triển, b&agrave;i thi TOEIC Listening and Reading đ&atilde; v&agrave; đang được chấp nhận. C&aacute;c ti&ecirc;u chuẩn n&agrave;y gi&uacute;p đ&aacute;nh gi&aacute; hai kỹ năng nghe hiểu v&agrave; đọc hiểu tiếng Anh trong m&ocirc;i trường l&agrave;m việc quốc tế cũng như đ&aacute;nh gi&aacute; điểm đầu ra của sinh vi&ecirc;n.</p>\r\n\r\n<p>Kỹ năng nghe hiểu l&agrave; v&ocirc; c&ugrave;ng quan trọng v&igrave; n&oacute; được sử dụng rộng r&atilde;i trong giao tiếp trực tiếp hoặc qua điện thoại, trong c&aacute;c cuộc họp, hội nghị trực tuyến ng&agrave;y nay. C&ograve;n đối với kỹ năng đọc hiểu rất cần thiết với c&aacute;c loại thư từ, email, b&aacute;o c&aacute;o v&agrave; tất cả những giao tiếp bằng văn bản m&agrave; cần tiếng Anh.</p>\r\n\r\n<p>Sau khi tham dự b&agrave;i thi TOEIC, th&iacute; sinh sẽ nhận được một phiếu điểm v&agrave; bằng chứng chỉ c&oacute; hiệu lực trong v&ograve;ng 2 năm. Phiếu điểm sẽ c&oacute; đầy đủ điểm của mỗi phần thi. Ngo&agrave;i ra, bản b&aacute;o c&aacute;o kết quả c&ograve;n đ&aacute;nh gi&aacute; mức độ th&agrave;nh thạo của th&iacute; sinh trong từng kỹ năng cụ thể thể hiện sự ho&agrave;n thiện trong từng kỹ năng của th&iacute; sinh.</p>\r\n\r\n<p>Tin chắc chắn một điều rằng bất kỳ ai cũng muốn c&oacute; được một con điểm khủng cho chứng chỉ TOEIC của m&igrave;nh. V&agrave; để l&agrave;m được điều đ&oacute; th&igrave; kh&ocirc;ng chỉ dừng lại ở việc học TOEIC căn bản v&agrave; c&oacute; được số điểm cơ bản đủ để ra trường hay xin việc tại c&ocirc;ng ty. Mục ti&ecirc;u của bạn lu&ocirc;n phải cao hơn nữa th&igrave; số điểm của bạn mới kh&ocirc;ng ngừng tăng l&ecirc;n.</p>\r\n\r\n<p>Kh&oacute;a học TOEIC giải đề tại TAEC</p>\r\n\r\n<h3>1. Đối tượng tham gia:</h3>\r\n\r\n<p>C&aacute;c bạn muốn cải thiện điểm thi TOEIC, muốn nắm vững cấu tr&uacute;c, phương ph&aacute;p l&agrave;m b&agrave;i sao cho nhanh ch&oacute;ng v&agrave; hiệu quả nhất, nhất l&agrave; c&aacute;c mẹo v&agrave; tư duy tr&aacute;nh bẫy đề thi. Nhất l&agrave; kh&oacute;a học TOEIC giải đề cực kỳ phụ hợp cho c&aacute;c bạn chuẩn bị sắp đến thời gian thi v&agrave; c&aacute;c bạn đ&atilde; ho&agrave;n th&agrave;nh kh&oacute;a học TOEIC căn bản.</p>\r\n\r\n<h3>2. Mục ti&ecirc;u đầu ra của kho&aacute; học TOEIC giải đề:</h3>\r\n\r\n<p>Gi&uacute;p học vi&ecirc;n c&oacute; thể tăng từ 100 đến 200 điểm TOEIC so với khả năng ban đầu. Cũng như phụ thuộc rất nhiều v&agrave;o việc lựa chọn kh&oacute;a học giải đề bao nhi&ecirc;u th&aacute;ng.</p>\r\n\r\n<p>Tại TAEC cung cấp 6 kho&aacute; học giải đề tương ứng từ 1 cho đến 6 th&aacute;ng với mức học ph&iacute; kh&aacute;c nhau cũng như thời lượng kh&aacute;c nhau.</p>\r\n', 0, 900000, 'uploads/15698350626-400x250.jpeg', NULL),
(42, 'Khóa học IELTS từ 0-7+ kèm chấm chữa giáo viên bản ngữ', '<p>Kh&oacute;a học IELTS Fundamentals: Grammar and Vocabulary for IELTS hướng đến đối tượng c&aacute;c bạn đang ở tr&igrave;nh độ sơ cấp (tương đương A1-A2) v&agrave; c&oacute; mong muốn thi IELTS trong tương lai. Mục ti&ecirc;u kh&oacute;a học l&agrave; x&acirc;y dựng cho c&aacute;c bạn nền m&oacute;ng từ vựng v&agrave; ngữ ph&aacute;p để đạt điểm tối thiểu 4.0 sau 3-4 th&aacute;ng học đ&uacute;ng lộ tr&igrave;nh.</p>\r\n\r\n<p>Phần Từ vựng gồm hơn 1.800 từ&nbsp;được chia th&agrave;nh 20 chủ đề kh&aacute;c nhau như nghệ thuật, văn học, lịch sử, khảo cổ, khoa học, đời sống ... l&agrave; những chủ điểm chắc chắn sẽ xuất hiện khi đi thi. Mỗi chủ đề bao gồm b&ocirc; flashcards gồm đầy đủ nghĩa Anh-Việt/ Anh-Anh&nbsp;h&igrave;nh ảnh, phi&ecirc;n &acirc;m, ph&aacute;t &acirc;m, c&acirc;u v&iacute; dụ. Phần &ocirc;n tập flashcards của STUDY4 được thiết kế theo phương ph&aacute;p Spaced repetition (học lặp lại ngắt qu&atilde;ng) gi&uacute;p bạn tối ưu h&oacute;a thời gian v&agrave; hiệu quả &ocirc;n tập: chỉ &ocirc;n những từ sắp qu&ecirc;n v&agrave; bỏ qua những từ đ&atilde; nhớ. Gi&uacute;p bạn ho&agrave;n to&agrave;n c&oacute; thể học trọn 1.800 từ n&agrave;y trong 2.5-3 th&aacute;ng (~75 ng&agrave;y). Ngo&agrave;i ra, kh&oacute;a học cung cấp rất nhiều c&aacute;c dạng b&agrave;i tập mini-game&nbsp;kh&aacute;c nhau để bạn luyện tập từ vựng như t&igrave;m cặp, nghe điền từ, nghe chọn từ đ&uacute;ng, ch&iacute;nh tả, trắc nghiệm.</p>\r\n\r\n<p>Phần Ngữ ph&aacute;p gồm b&agrave;i giảng chi tiết 29 chủ điểm ngữ ph&aacute;p quan trọng nhất trong kỳ thi IELTS. B&ecirc;n cạnh đ&oacute;, kh&oacute;a học cung c&acirc;p th&ecirc;m c&aacute;c dạng b&agrave;i tập luyện chuy&ecirc;n s&acirc;u ngữ ph&aacute;p kết hợp c&aacute;c kỹ năng như nghe, đọc, viết gi&uacute;p bạn thực h&agrave;nh h&agrave;ng ng&agrave;y ngữ ph&aacute;p hiệu quả.</p>\r\n\r\n<h2>Bạn sẽ đạt được g&igrave; sau kho&aacute; học?</h2>\r\n\r\n<p>1️⃣ C&oacute; nền tảng ngữ ph&aacute;p trung cấp B1-B2</p>\r\n\r\n<p>2️⃣ X&acirc;y dựng vốn từ vựng học thuật, l&agrave;m&nbsp;nền m&oacute;ng để đọc/nghe hiểu&nbsp;c&aacute;c chủ điểm chắc chắn sẽ xuất hiện trong 2 phần thi Listening v&agrave; Reading</p>\r\n\r\n<p>3️⃣ L&agrave;m chủ tốc độ v&agrave; c&aacute;c ngữ điệu&nbsp;kh&aacute;c nhau trong phần thi IELTS Listening</p>\r\n\r\n<p>4️⃣ Nắm trọn 4000 từ vựng 99% sẽ xuất hiện trong IELTS</p>\r\n\r\n<p>5️⃣&nbsp;Nắm chắc chiến thuật v&agrave; phương ph&aacute;p&nbsp;l&agrave;m c&aacute;c dạng c&acirc;u hỏi trong IELTS Listening v&agrave; Reading</p>\r\n\r\n<p>6️⃣&nbsp;Luyện tập ph&aacute;t &acirc;m, từ vựng, ngữ ph&aacute;p v&agrave; thực h&agrave;nh luyện n&oacute;i c&aacute;c chủ đề thường gặp v&agrave; forecast trong&nbsp;IELTS Speaking</p>\r\n\r\n<p>Để đạt được điểm số cao trong hai phần thi&nbsp;IELTS Speaking v&agrave; Writing l&agrave;&nbsp;rất kh&oacute;.&nbsp;Bất chấp mọi nỗ lực của bạn, bạn vẫn đạt được kh&ocirc;ng thể vượt qua band 6.5!&nbsp;😩 Bạn cố gắng học thật chăm chỉ, tập viết v&agrave; n&oacute;i thật nhiều&nbsp;nhưng điểm số của bạn vẫn vậy.&nbsp;Dường như kh&ocirc;ng c&oacute; g&igrave; c&oacute; thể đẩy bạn l&ecirc;n đến band 7 v&agrave; 8. Tại sao?</p>\r\n\r\n<p>Sau khi l&agrave;m b&agrave;i, bạn cần phải được chấm chữa v&agrave; nhận x&eacute;t để&nbsp;biết lỗi sai của m&igrave;nh ở đ&acirc;u v&agrave; c&aacute;ch khắc phục chuẩn x&aacute;c. C&oacute; như vậy bạn mới c&oacute; thể cải thiện được tr&igrave;nh độ.</p>\r\n\r\n<p>Kh&oacute;a học chấm chữa&nbsp;IELTS Writing &amp; Speaking được x&acirc;y dựng nhằm gi&uacute;p c&aacute;c bạn hiểu r&otilde; c&aacute;ch l&agrave;m, khắc phục điểm yếu, học c&aacute;ch h&agrave;nh văn v&agrave; cải thiện nhanh ch&oacute;ng hai kỹ năng kh&oacute; nhằn nhất trong kỳ thi IELTS. Tất cả c&aacute;c b&agrave;i l&agrave;m (gồm b&agrave;i luận&nbsp;v&agrave; thu &acirc;m b&agrave;i n&oacute;i) đều được&nbsp;chấm chữa v&agrave; cho điểm chi tiết bởi đội ngũ gi&aacute;o vi&ecirc;n gi&agrave;u kinh nghiệm v&agrave; tr&igrave;nh độ chuy&ecirc;n m&ocirc;n cao của STUDY4. Khi đăng k&yacute; kh&oacute;a học, bạn sẽ được:</p>\r\n\r\n<ul>\r\n	<li>Chấm chữa đầy đủ từ vựng, ngữ ph&aacute;p, li&ecirc;n kết, nội dung</li>\r\n	<li>Ph&acirc;n t&iacute;ch chi tiết v&agrave; lời khuy&ecirc;n để cải thiện</li>\r\n	<li>Phiếu nhận x&eacute;t&nbsp;v&agrave; chấm điểm chuẩn form&nbsp;IELTS</li>\r\n	<li>Nhận điểm từ 1-3 ng&agrave;y&nbsp;sau khi nộp (trừ cuối tuần v&agrave; ng&agrave;y nghỉ lễ)</li>\r\n</ul>\r\n', 0, 2500000, 'uploads/ielts_band_0_7.webp', NULL),
(43, 'Khóa học IELTS online 4 kỹ năng', '<p><strong>Luyện thi IELTS ch&iacute;nh l&agrave; một trận chiến đ&ograve;i hỏi sự nỗ lực, ki&ecirc;n tr&igrave; của mỗi người để tiếp thu v&agrave; đạt được band điểm cao như mong muốn.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Kh&oacute;a học gồm:</p>\r\n\r\n<ul>\r\n	<li>Kỹ năng Listening</li>\r\n	<li>Kỹ năng Reading</li>\r\n	<li>Kỹ năng Speaking</li>\r\n	<li>Kỹ năng Writing</li>\r\n	<li>Ebook &Yacute; tưởng Writing</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li><strong>BỘ TỪ VỰNG 1</strong>: D&agrave;nh ri&ecirc;ng để l&agrave;m 5 dạng biểu đồ l&agrave; Line graph, Bar chart, Pie chart, Table v&agrave; Mixed charts.</li>\r\n	<li><strong>BỘ TỪ VỰNG 2</strong>: D&agrave;nh ri&ecirc;ng để l&agrave;m Process</li>\r\n	<li><strong>BỘ TỪ VỰNG 3</strong>: D&agrave;nh ri&ecirc;ng để l&agrave;m Map</li>\r\n</ul>\r\n\r\n<p>Ngo&agrave;i ra trong qu&aacute; tr&igrave;nh học c&aacute;c b&agrave;i Task 1 của kh&oacute;a, m&igrave;nh c&ograve;n c&oacute; th&ecirc;m từ vựng cho rất nhiều chủ đề như:</p>\r\n\r\n<ul>\r\n	<li>Kh&iacute; thải (Emissions)</li>\r\n	<li>Ti&ecirc;u thụ (Consumption)</li>\r\n	<li>D&acirc;n số v&agrave; độ tuổi (Age structure)</li>\r\n	<li>Tỷ lệ &hellip; (c&aacute;c diễn đạt số liệu phần trăm)</li>\r\n	<li>Đăng k&yacute; học (Student enrolments)</li>\r\n	<li>Chi ti&ecirc;u (Spending on something)</li>\r\n	<li>Năng lượng (Energy use)</li>\r\n	<li>Tho&aacute;i h&oacute;a đất (Land degradation)</li>\r\n</ul>\r\n\r\n<p>Trong qu&aacute; tr&igrave;nh học c&aacute;c viết từng dạng, thực h&agrave;nh từng b&agrave;i, m&igrave;nh c&ograve;n t&iacute;ch lũy được những từ vựng cho c&aacute;c chủ đề kh&aacute;c nhau:</p>\r\n\r\n<ul>\r\n	<li>N&oacute;ng l&ecirc;n to&agrave;n cầu (Global warming)</li>\r\n	<li>Tội phạm (Crime)</li>\r\n	<li>Chi ti&ecirc;u ch&iacute;nh phủ (Government Spending)</li>\r\n	<li>Gi&aacute;o dục (Education) &rarr; C&oacute; hai b&agrave;i về Gi&aacute;o dục n&agrave;y, nhưng tiểu chủ đề (chủ đề ch&iacute;nh của đề b&agrave;i) l&agrave; ho&agrave;n to&agrave;n kh&aacute;c nhau.</li>\r\n	<li>M&ocirc;i trường (Environment)</li>\r\n	<li>Sống một m&igrave;nh (Living alone)</li>\r\n	<li>Du lịch (Tourism)</li>\r\n	<li>Nghi&ecirc;n cứu lịch sử của một t&ograve;a nh&agrave; (Researching the history of a house)</li>\r\n	<li>Việc sở hữu nh&agrave; v&agrave; việc thu&ecirc; nh&agrave; (Owning a home or renting one)</li>\r\n</ul>\r\n', 16, 2800000, 'uploads/khoahoc8.jpg', NULL),
(44, 'Khóa học tiếng Anh cho người mới bắt đầu', '<p>Kh&oacute;a học tiếng Anh cho người mới bắt đầu l&agrave; một kh&oacute;a học d&agrave;nh cho những người mất gốc hoặc những người đ&atilde; học một &iacute;t nhưng muốn củng cố v&agrave; mở rộng kiến thức của m&igrave;nh. Dưới đ&acirc;y l&agrave; một số th&ocirc;ng tin cơ bản về kh&oacute;a học n&agrave;y:</p>\r\n\r\n<p>Mục ti&ecirc;u của kh&oacute;a học:</p>\r\n\r\n<ul>\r\n	<li>X&acirc;y dựng nền tảng vững chắc về ngữ ph&aacute;p, từ vựng v&agrave; kỹ năng nghe, n&oacute;i, đọc, viết tiếng Anh.</li>\r\n	<li>Ph&aacute;t triển khả năng giao tiếp h&agrave;ng ng&agrave;y v&agrave; tham gia v&agrave;o c&aacute;c t&igrave;nh huống th&ocirc;ng thường trong cuộc sống.</li>\r\n</ul>\r\n\r\n<p>Nội dung của kh&oacute;a học:</p>\r\n\r\n<ul>\r\n	<li>Học vi&ecirc;n sẽ học v&agrave; thực h&agrave;nh c&aacute;c cấu tr&uacute;c ngữ ph&aacute;p cơ bản, c&ugrave;ng với từ vựng li&ecirc;n quan, nhằm x&acirc;y dựng nền tảng ng&ocirc;n ngữ.</li>\r\n	<li>Luyện nghe qua c&aacute;c b&agrave;i nghe với tốc độ v&agrave; độ kh&oacute; tăng dần, từ ngắn đến d&agrave;i, gi&uacute;p cải thiện khả năng nghe hiểu v&agrave; phản xạ ng&ocirc;n ngữ.</li>\r\n	<li>Thực h&agrave;nh giao tiếp qua c&aacute;c b&agrave;i tập v&agrave; hoạt động nh&oacute;m, gi&uacute;p r&egrave;n kỹ năng diễn đạt v&agrave; tương t&aacute;c trong c&aacute;c t&igrave;nh huống h&agrave;ng ng&agrave;y.</li>\r\n	<li>Luyện viết qua c&aacute;c b&agrave;i tập tạo c&acirc;u, viết đoạn văn ngắn v&agrave; thực h&agrave;nh viết email, th&ocirc;ng điệp giao tiếp cơ bản.</li>\r\n</ul>\r\n', 1, 2000, 'uploads/khoahoc1.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lichhoc`
--

CREATE TABLE `lichhoc` (
  `id_lichhoc` int(11) NOT NULL,
  `id_lop` varchar(50) NOT NULL,
  `ngay_hoc` date NOT NULL,
  `gio_bat_dau` time NOT NULL,
  `gio_ket_thuc` time NOT NULL,
  `phong_hoc` varchar(100) DEFAULT NULL COMMENT 'Tên phòng học hoặc link học Online',
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichhoc`
--

INSERT INTO `lichhoc` (`id_lichhoc`, `id_lop`, `ngay_hoc`, `gio_bat_dau`, `gio_ket_thuc`, `phong_hoc`, `ghi_chu`) VALUES
(4, 'BASIC-01-25', '2025-09-22', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(5, 'BASIC-01-25', '2025-09-24', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(6, 'BASIC-01-25', '2025-09-26', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(7, 'BASIC-02-25', '2025-09-23', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(8, 'BASIC-02-25', '2025-09-25', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(9, 'BASIC-02-25', '2025-09-27', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(10, 'KIDS-01-25', '2025-09-23', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(11, 'KIDS-01-25', '2025-09-25', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(12, 'KIDS-01-25', '2025-09-30', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(13, 'KIDS-02-25', '2025-09-20', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(14, 'KIDS-02-25', '2025-09-27', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(15, 'KIDS-02-25', '2025-10-04', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(16, 'COM-1V1-01-25', '2025-09-22', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(17, 'COM-BASIC-01-25', '2025-09-22', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(18, 'COM-BASIC-01-25', '2025-09-24', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(19, 'COM-BASIC-01-25', '2025-09-29', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(20, 'COM-BASIC-02-25', '2025-09-23', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(21, 'COM-BASIC-02-25', '2025-09-25', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(22, 'COM-BASIC-02-25', '2025-09-30', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(23, 'TOEIC-4S-01-25', '2025-09-22', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(24, 'TOEIC-4S-01-25', '2025-09-24', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(25, 'TOEIC-4S-01-25', '2025-09-26', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(26, 'TOEIC-4S-02-25', '2025-09-23', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(27, 'TOEIC-4S-02-25', '2025-09-25', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(28, 'TOEIC-4S-02-25', '2025-09-30', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(29, 'IELTS-F-01-25', '2025-09-22', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(30, 'IELTS-F-01-25', '2025-09-24', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(31, 'IELTS-F-01-25', '2025-09-29', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(32, 'IELTS-F-02-25', '2025-09-23', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(33, 'IELTS-F-02-25', '2025-09-25', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(34, 'IELTS-F-02-25', '2025-09-30', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(35, 'IELTS-PREP-01-25', '2025-09-23', '08:30:00', '10:30:00', 'Link Zoom', 'localhost:3000/dahp2/admin/admin.php?nav=lichhoc&lop_id=IELTS-PREP-01-25&view=schedule'),
(36, 'IELTS-PREP-01-25', '2025-09-25', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(37, 'IELTS-PREP-01-25', '2025-09-27', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(38, 'IELTS-PREP-02-25', '2025-09-27', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(39, 'IELTS-PREP-02-25', '2025-09-28', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(40, 'IELTS-PREP-02-25', '2025-10-04', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(41, 'TOEIC-DE-01-25', '2025-09-22', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(42, 'TOEIC-DE-01-25', '2025-09-24', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(43, 'TOEIC-DE-01-25', '2025-09-26', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(44, 'TOEIC-DE-02-25', '2025-09-27', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(45, 'TOEIC-DE-02-25', '2025-09-28', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(46, 'TOEIC-DE-02-25', '2025-10-04', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(47, 'IELTS-0-7-01-25', '2025-09-23', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(48, 'IELTS-0-7-01-25', '2025-09-25', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(49, 'IELTS-0-7-01-25', '2025-09-30', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(50, 'IELTS-4S-01-25', '2025-09-22', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(51, 'IELTS-4S-01-25', '2025-09-24', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(52, 'IELTS-4S-01-25', '2025-09-29', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(53, 'IELTS-4S-02-25', '2025-09-23', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(54, 'IELTS-4S-02-25', '2025-09-25', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(55, 'IELTS-4S-02-25', '2025-09-30', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(56, 'BEGINNER-01-25', '2025-09-22', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(57, 'BEGINNER-01-25', '2025-09-24', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(58, 'BEGINNER-01-25', '2025-09-29', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(59, 'BEGINNER-02-25', '2025-09-23', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(60, 'BEGINNER-02-25', '2025-09-25', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(61, 'BEGINNER-02-25', '2025-09-27', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(62, 'BASIC-01-25', '2025-09-29', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(63, 'BASIC-01-25', '2025-10-01', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(64, 'BASIC-01-25', '2025-10-03', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(65, 'BASIC-01-25', '2025-10-06', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(66, 'BASIC-01-25', '2025-10-08', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(67, 'BASIC-01-25', '2025-10-10', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(68, 'BASIC-01-25', '2025-10-13', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(69, 'BASIC-01-25', '2025-10-15', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(70, 'BASIC-01-25', '2025-10-17', '19:00:00', '20:30:00', 'Phòng A101', NULL),
(72, 'BASIC-02-25', '2025-09-30', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(73, 'BASIC-02-25', '2025-10-02', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(74, 'BASIC-02-25', '2025-10-04', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(75, 'BASIC-02-25', '2025-10-07', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(76, 'BASIC-02-25', '2025-10-09', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(77, 'BASIC-02-25', '2025-10-11', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(78, 'BASIC-02-25', '2025-10-14', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(79, 'BASIC-02-25', '2025-10-16', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(80, 'BASIC-02-25', '2025-10-18', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(81, 'BASIC-02-25', '2025-10-21', '08:30:00', '10:00:00', 'Link Google Meet', NULL),
(82, 'KIDS-01-25', '2025-10-02', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(83, 'KIDS-01-25', '2025-10-07', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(84, 'KIDS-01-25', '2025-10-09', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(85, 'KIDS-01-25', '2025-10-14', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(86, 'KIDS-01-25', '2025-10-16', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(87, 'KIDS-01-25', '2025-10-21', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(88, 'KIDS-01-25', '2025-10-23', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(89, 'KIDS-01-25', '2025-10-28', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(90, 'KIDS-01-25', '2025-10-30', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(91, 'KIDS-01-25', '2025-11-04', '16:00:00', '17:30:00', 'Phòng B202', NULL),
(92, 'KIDS-02-25', '2025-10-11', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(93, 'KIDS-02-25', '2025-10-18', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(94, 'KIDS-02-25', '2025-10-25', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(95, 'KIDS-02-25', '2025-11-01', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(96, 'KIDS-02-25', '2025-11-08', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(97, 'KIDS-02-25', '2025-11-15', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(98, 'KIDS-02-25', '2025-11-22', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(99, 'KIDS-02-25', '2025-11-29', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(100, 'KIDS-02-25', '2025-12-06', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(101, 'KIDS-02-25', '2025-12-13', '09:00:00', '11:00:00', 'Phòng B203', NULL),
(102, 'COM-1V1-01-25', '2025-09-29', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(103, 'COM-1V1-01-25', '2025-10-06', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(104, 'COM-1V1-01-25', '2025-10-13', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(105, 'COM-1V1-01-25', '2025-10-20', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(106, 'COM-1V1-01-25', '2025-10-27', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(107, 'COM-1V1-01-25', '2025-11-03', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(108, 'COM-1V1-01-25', '2025-11-10', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(109, 'COM-1V1-01-25', '2025-11-17', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(110, 'COM-1V1-01-25', '2025-11-24', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(111, 'COM-1V1-01-25', '2025-12-01', '10:00:00', '11:00:00', 'Link Zoom', NULL),
(112, 'COM-BASIC-01-25', '2025-10-01', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(113, 'COM-BASIC-01-25', '2025-10-06', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(114, 'COM-BASIC-01-25', '2025-10-08', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(115, 'COM-BASIC-01-25', '2025-10-13', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(116, 'COM-BASIC-01-25', '2025-10-15', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(117, 'COM-BASIC-01-25', '2025-10-20', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(118, 'COM-BASIC-01-25', '2025-10-22', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(119, 'COM-BASIC-01-25', '2025-10-27', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(120, 'COM-BASIC-01-25', '2025-10-29', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(121, 'COM-BASIC-01-25', '2025-11-03', '18:30:00', '20:00:00', 'Phòng A102', NULL),
(122, 'COM-BASIC-02-25', '2025-10-02', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(123, 'COM-BASIC-02-25', '2025-10-07', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(124, 'COM-BASIC-02-25', '2025-10-09', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(125, 'COM-BASIC-02-25', '2025-10-14', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(126, 'COM-BASIC-02-25', '2025-10-16', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(127, 'COM-BASIC-02-25', '2025-10-21', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(128, 'COM-BASIC-02-25', '2025-10-23', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(129, 'COM-BASIC-02-25', '2025-10-28', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(130, 'COM-BASIC-02-25', '2025-10-30', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(131, 'COM-BASIC-02-25', '2025-11-04', '19:30:00', '21:00:00', 'Link Zoom', NULL),
(132, 'TOEIC-4S-01-25', '2025-09-29', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(133, 'TOEIC-4S-01-25', '2025-10-01', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(134, 'TOEIC-4S-01-25', '2025-10-03', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(135, 'TOEIC-4S-01-25', '2025-10-06', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(136, 'TOEIC-4S-01-25', '2025-10-08', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(137, 'TOEIC-4S-01-25', '2025-10-10', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(138, 'TOEIC-4S-01-25', '2025-10-13', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(139, 'TOEIC-4S-01-25', '2025-10-14', '16:00:00', '17:30:00', 'Phòng C301', 'http://localhost:3000/dahp2/admin/admin.php?nav=lichhoc&lop_id=TOEIC-4S-01-25&view=schedule'),
(140, 'TOEIC-4S-01-25', '2025-10-17', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(141, 'TOEIC-4S-01-25', '2025-10-20', '08:00:00', '09:30:00', 'Phòng C301', NULL),
(142, 'TOEIC-4S-02-25', '2025-10-02', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(143, 'TOEIC-4S-02-25', '2025-10-07', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(144, 'TOEIC-4S-02-25', '2025-10-09', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(145, 'TOEIC-4S-02-25', '2025-10-14', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(146, 'TOEIC-4S-02-25', '2025-10-16', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(147, 'TOEIC-4S-02-25', '2025-10-21', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(148, 'TOEIC-4S-02-25', '2025-10-23', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(149, 'TOEIC-4S-02-25', '2025-10-28', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(150, 'TOEIC-4S-02-25', '2025-10-30', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(151, 'TOEIC-4S-02-25', '2025-11-04', '19:00:00', '20:30:00', 'Link Microsoft Teams', NULL),
(152, 'IELTS-F-01-25', '2025-10-01', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(153, 'IELTS-F-01-25', '2025-10-06', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(154, 'IELTS-F-01-25', '2025-10-08', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(155, 'IELTS-F-01-25', '2025-10-13', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(156, 'IELTS-F-01-25', '2025-10-15', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(157, 'IELTS-F-01-25', '2025-10-20', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(158, 'IELTS-F-01-25', '2025-10-22', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(159, 'IELTS-F-01-25', '2025-10-27', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(160, 'IELTS-F-01-25', '2025-10-29', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(161, 'IELTS-F-01-25', '2025-11-03', '19:00:00', '21:00:00', 'Phòng D401', NULL),
(162, 'IELTS-F-02-25', '2025-10-02', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(163, 'IELTS-F-02-25', '2025-10-07', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(164, 'IELTS-F-02-25', '2025-10-09', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(165, 'IELTS-F-02-25', '2025-10-14', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(166, 'IELTS-F-02-25', '2025-10-16', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(167, 'IELTS-F-02-25', '2025-10-21', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(168, 'IELTS-F-02-25', '2025-10-23', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(169, 'IELTS-F-02-25', '2025-10-28', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(170, 'IELTS-F-02-25', '2025-10-30', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(171, 'IELTS-F-02-25', '2025-11-04', '14:00:00', '16:00:00', 'Phòng D402', NULL),
(172, 'IELTS-PREP-01-25', '2025-09-30', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(173, 'IELTS-PREP-01-25', '2025-10-02', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(174, 'IELTS-PREP-01-25', '2025-10-04', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(175, 'IELTS-PREP-01-25', '2025-10-07', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(176, 'IELTS-PREP-01-25', '2025-10-09', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(177, 'IELTS-PREP-01-25', '2025-10-11', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(178, 'IELTS-PREP-01-25', '2025-10-14', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(179, 'IELTS-PREP-01-25', '2025-10-16', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(180, 'IELTS-PREP-01-25', '2025-10-18', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(181, 'IELTS-PREP-01-25', '2025-10-21', '08:30:00', '10:30:00', 'Link Zoom', NULL),
(182, 'IELTS-PREP-02-25', '2025-10-05', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(183, 'IELTS-PREP-02-25', '2025-10-11', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(184, 'IELTS-PREP-02-25', '2025-10-12', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(185, 'IELTS-PREP-02-25', '2025-10-18', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(186, 'IELTS-PREP-02-25', '2025-10-19', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(187, 'IELTS-PREP-02-25', '2025-10-25', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(188, 'IELTS-PREP-02-25', '2025-10-26', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(189, 'IELTS-PREP-02-25', '2025-11-01', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(190, 'IELTS-PREP-02-25', '2025-11-02', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(191, 'IELTS-PREP-02-25', '2025-11-08', '14:00:00', '16:00:00', 'Phòng D403', NULL),
(192, 'TOEIC-DE-01-25', '2025-09-29', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(193, 'TOEIC-DE-01-25', '2025-10-01', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(194, 'TOEIC-DE-01-25', '2025-10-03', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(195, 'TOEIC-DE-01-25', '2025-10-06', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(196, 'TOEIC-DE-01-25', '2025-10-08', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(197, 'TOEIC-DE-01-25', '2025-10-10', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(198, 'TOEIC-DE-01-25', '2025-10-13', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(199, 'TOEIC-DE-01-25', '2025-10-15', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(200, 'TOEIC-DE-01-25', '2025-10-17', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(201, 'TOEIC-DE-01-25', '2025-10-20', '19:30:00', '21:00:00', 'Phòng C302', NULL),
(202, 'TOEIC-DE-02-25', '2025-10-05', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(203, 'TOEIC-DE-02-25', '2025-10-11', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(204, 'TOEIC-DE-02-25', '2025-10-12', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(205, 'TOEIC-DE-02-25', '2025-10-18', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(206, 'TOEIC-DE-02-25', '2025-10-19', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(207, 'TOEIC-DE-02-25', '2025-10-25', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(208, 'TOEIC-DE-02-25', '2025-10-26', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(209, 'TOEIC-DE-02-25', '2025-11-01', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(210, 'TOEIC-DE-02-25', '2025-11-02', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(211, 'TOEIC-DE-02-25', '2025-11-08', '09:00:00', '11:00:00', 'Link Google Meet', NULL),
(212, 'IELTS-0-7-01-25', '2025-10-02', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(213, 'IELTS-0-7-01-25', '2025-10-07', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(214, 'IELTS-0-7-01-25', '2025-10-09', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(215, 'IELTS-0-7-01-25', '2025-10-14', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(216, 'IELTS-0-7-01-25', '2025-10-16', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(217, 'IELTS-0-7-01-25', '2025-10-21', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(218, 'IELTS-0-7-01-25', '2025-10-23', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(219, 'IELTS-0-7-01-25', '2025-10-28', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(220, 'IELTS-0-7-01-25', '2025-10-30', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(221, 'IELTS-0-7-01-25', '2025-11-04', '18:00:00', '20:00:00', 'Phòng E501', NULL),
(222, 'IELTS-4S-01-25', '2025-10-01', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(223, 'IELTS-4S-01-25', '2025-10-06', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(224, 'IELTS-4S-01-25', '2025-10-08', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(225, 'IELTS-4S-01-25', '2025-10-13', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(226, 'IELTS-4S-01-25', '2025-10-15', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(227, 'IELTS-4S-01-25', '2025-10-20', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(228, 'IELTS-4S-01-25', '2025-10-22', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(229, 'IELTS-4S-01-25', '2025-10-27', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(230, 'IELTS-4S-01-25', '2025-10-29', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(231, 'IELTS-4S-01-25', '2025-11-03', '14:30:00', '16:30:00', 'Link Zoom', NULL),
(232, 'IELTS-4S-02-25', '2025-10-02', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(233, 'IELTS-4S-02-25', '2025-10-07', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(234, 'IELTS-4S-02-25', '2025-10-09', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(235, 'IELTS-4S-02-25', '2025-10-14', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(236, 'IELTS-4S-02-25', '2025-10-16', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(237, 'IELTS-4S-02-25', '2025-10-21', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(238, 'IELTS-4S-02-25', '2025-10-23', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(239, 'IELTS-4S-02-25', '2025-10-28', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(240, 'IELTS-4S-02-25', '2025-10-30', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(241, 'IELTS-4S-02-25', '2025-11-04', '19:00:00', '21:00:00', 'Phòng E502', NULL),
(242, 'BEGINNER-01-25', '2025-10-01', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(243, 'BEGINNER-01-25', '2025-10-06', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(244, 'BEGINNER-01-25', '2025-10-08', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(245, 'BEGINNER-01-25', '2025-10-13', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(246, 'BEGINNER-01-25', '2025-10-15', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(247, 'BEGINNER-01-25', '2025-10-20', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(248, 'BEGINNER-01-25', '2025-10-22', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(249, 'BEGINNER-01-25', '2025-10-27', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(250, 'BEGINNER-01-25', '2025-10-29', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(251, 'BEGINNER-01-25', '2025-11-03', '09:00:00', '10:30:00', 'Phòng A103', NULL),
(252, 'BEGINNER-02-25', '2025-09-30', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(253, 'BEGINNER-02-25', '2025-10-02', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(254, 'BEGINNER-02-25', '2025-10-04', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(255, 'BEGINNER-02-25', '2025-10-07', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(256, 'BEGINNER-02-25', '2025-10-09', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(257, 'BEGINNER-02-25', '2025-10-11', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(258, 'BEGINNER-02-25', '2025-10-14', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(259, 'BEGINNER-02-25', '2025-10-16', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(260, 'BEGINNER-02-25', '2025-10-18', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(261, 'BEGINNER-02-25', '2025-10-21', '19:30:00', '21:00:00', 'Link Google Meet', NULL),
(264, 'BASIC-01-25', '2025-09-30', '09:11:00', '00:11:00', 'Phòng A101', ''),
(265, 'BASIC-01-25', '2025-09-27', '18:09:00', '21:12:00', 'Phòng A101', ''),
(266, 'BASIC-01-25', '2025-09-19', '16:09:00', '18:09:00', 'Phòng A101', ''),
(269, 'BASIC-01-25', '2025-10-08', '18:37:00', '23:37:00', 'Phòng A101', ''),
(271, 'BASIC-01-25', '2025-10-01', '02:45:00', '04:43:00', 'Phòng A101', ''),
(272, 'BASIC-01-25', '2025-10-14', '04:30:00', '05:30:00', 'Link Zoom', 'http://localhost:3000/dahp2/admin/admin.php?nav=lichhoc&lop_id=BASIC-01-25&view=schedule');

--
-- Triggers `lichhoc`
--
DELIMITER $$
CREATE TRIGGER `after_insert_lichhoc` AFTER INSERT ON `lichhoc` FOR EACH ROW BEGIN
    -- Khai báo các biến để lưu thông tin
    DECLARE v_khoahoc_id INT;
    DECLARE v_ten_lop VARCHAR(100);

    -- Lấy id_khoahoc và ten_lop từ lớp vừa được thêm lịch học
    SELECT id_khoahoc, ten_lop INTO v_khoahoc_id, v_ten_lop
    FROM lop_hoc
    WHERE id_lop = NEW.id_lop;

    -- Chèn thông báo cho mỗi học viên trong lớp đó
    -- Câu lệnh INSERT này đã được BỔ SUNG thêm cột 'id_lop'
    INSERT INTO thongbao (id_hocvien, id_khoahoc, id_lop, noi_dung, ngay_tao, tu_dong, tieu_de)
    SELECT
        dk.id_hocvien,
        v_khoahoc_id,
        NEW.id_lop,  -- << DÒNG QUAN TRỌNG ĐƯỢC THÊM VÀO
        CONCAT('Lớp "', v_ten_lop, '" của bạn có lịch học mới vào ngày: ', DATE_FORMAT(NEW.ngay_hoc, '%d/%m/%Y'), '.'),
        NOW(),
        TRUE,
        'Thông báo lịch học mới'
    FROM dangkykhoahoc dk
    WHERE dk.id_lop = NEW.id_lop;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tong_so_buoi_after_delete` AFTER DELETE ON `lichhoc` FOR EACH ROW BEGIN
    UPDATE tien_do_hoc_tap td
    SET tong_so_buoi = (
        SELECT COUNT(*)
        FROM lichhoc lh
        WHERE lh.id_lop = OLD.id_lop
    )
    WHERE td.id_khoahoc = (
        SELECT id_khoahoc
        FROM lop_hoc
        WHERE id_lop = OLD.id_lop
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tong_so_buoi_after_insert` AFTER INSERT ON `lichhoc` FOR EACH ROW BEGIN
    UPDATE tien_do_hoc_tap td
    SET tong_so_buoi = (
        SELECT COUNT(*)
        FROM lichhoc lh
        WHERE lh.id_lop = NEW.id_lop
    )
    WHERE td.id_khoahoc = (
        SELECT id_khoahoc
        FROM lop_hoc
        WHERE id_lop = NEW.id_lop
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lichsu_thanhtoan`
--

CREATE TABLE `lichsu_thanhtoan` (
  `id_thanhtoan` int(11) NOT NULL,
  `id_hocvien` int(11) DEFAULT NULL,
  `id_khoahoc` int(11) DEFAULT NULL,
  `ngay_thanhtoan` datetime DEFAULT NULL,
  `so_tien` decimal(10,2) DEFAULT NULL,
  `hinh_thuc` varchar(50) DEFAULT NULL,
  `trang_thai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichsu_thanhtoan`
--

INSERT INTO `lichsu_thanhtoan` (`id_thanhtoan`, `id_hocvien`, `id_khoahoc`, `ngay_thanhtoan`, `so_tien`, `hinh_thuc`, `trang_thai`) VALUES
(50, 27, 32, '2024-01-15 00:00:00', 2000000.00, 'Chuyển khoản', 'Đã thanh toán'),
(51, 27, 36, '2024-02-10 00:00:00', 2500000.00, 'Tiền mặt', 'Đã thanh toán'),
(52, 27, 37, '2024-02-25 00:00:00', 3000000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(53, 27, 38, '2024-03-05 00:00:00', 2500000.00, 'Chuyển khoản', 'Đã thanh toán'),
(54, 27, 39, '2024-03-20 00:00:00', 3301000.00, 'Tiền mặt', 'Đã thanh toán'),
(55, 27, 40, '2024-04-12 00:00:00', 3000000.00, 'Chuyển khoản', 'Đã thanh toán'),
(56, 27, 41, '2024-04-28 00:00:00', 900000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(57, 27, 42, '2024-05-10 00:00:00', 3500000.00, 'Tiền mặt', 'Đã thanh toán'),
(58, 27, 43, '2024-05-22 00:00:00', 2800000.00, 'Chuyển khoản', 'Đã thanh toán'),
(59, 27, 44, '2024-06-05 00:00:00', 2000000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(60, 27, 32, '2024-06-18 00:00:00', 2000000.00, 'Tiền mặt', 'Đã thanh toán'),
(61, 27, 35, '2024-07-01 00:00:00', 2000000.00, 'Chuyển khoản', 'Đã thanh toán'),
(62, 27, 36, '2024-07-15 00:00:00', 2500000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(63, 27, 37, '2024-07-28 00:00:00', 3000000.00, 'Tiền mặt', 'Đã thanh toán'),
(64, 27, 38, '2024-08-10 00:00:00', 2500000.00, 'Chuyển khoản', 'Đã thanh toán'),
(65, 27, 39, '2024-08-25 00:00:00', 3301000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(66, 27, 40, '2024-09-05 00:00:00', 3000000.00, 'Tiền mặt', 'Đã thanh toán'),
(67, 27, 41, '2024-09-18 00:00:00', 900000.00, 'Chuyển khoản', 'Đã thanh toán'),
(68, 27, 42, '2024-09-30 00:00:00', 3500000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(69, 27, 43, '2024-10-10 00:00:00', 2800000.00, 'Tiền mặt', 'Đã thanh toán'),
(70, 27, 44, '2024-10-22 00:00:00', 2000000.00, 'Chuyển khoản', 'Đang xử lý'),
(71, 27, 32, '2024-11-01 00:00:00', 2000000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(72, 27, 35, '2024-11-12 00:00:00', 2000000.00, 'Tiền mặt', 'Đã thanh toán'),
(73, 27, 36, '2024-11-25 00:00:00', 2500000.00, 'Chuyển khoản', 'Đã thanh toán'),
(74, 27, 37, '2024-12-05 00:00:00', 3000000.00, 'Thẻ tín dụng', 'Đã thanh toán'),
(75, 27, 38, '2024-12-18 00:00:00', 2500000.00, 'Tiền mặt', 'Đã thanh toán'),
(76, 27, 39, '2025-01-05 00:00:00', 3301000.00, 'Chuyển khoản', 'Đã thanh toán'),
(77, 27, 40, '2025-01-20 00:00:00', 3000000.00, 'Thẻ tín dụng', 'Đang xử lý'),
(78, 27, 41, '2025-02-01 00:00:00', 900000.00, 'Tiền mặt', 'Đã thanh toán'),
(79, 27, 42, '2025-02-15 00:00:00', 3500000.00, 'Chuyển khoản', 'Đã thanh toán'),
(80, 1, 32, '2025-10-14 23:05:47', 2000.00, 'Chuyển khoản SePay', 'Đã hoàn thành');

-- --------------------------------------------------------

--
-- Table structure for table `lop_hoc`
--

CREATE TABLE `lop_hoc` (
  `id_lop` varchar(50) NOT NULL,
  `id_khoahoc` int(11) NOT NULL,
  `ten_lop` varchar(100) NOT NULL,
  `id_giangvien` int(11) DEFAULT NULL COMMENT 'Giảng viên trực tiếp đứng lớp',
  `so_luong_hoc_vien` int(11) DEFAULT 0,
  `trang_thai` enum('dang hoc','da xong') DEFAULT 'dang hoc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lop_hoc`
--

INSERT INTO `lop_hoc` (`id_lop`, `id_khoahoc`, `ten_lop`, `id_giangvien`, `so_luong_hoc_vien`, `trang_thai`) VALUES
('BASIC-01-25', 32, 'Lớp mất gốc Tối T2-T4-T6', 1, 2, 'dang hoc'),
('BASIC-02-25', 32, 'Lớp mất gốc Sáng T3-T5-T7', 2, 0, 'dang hoc'),
('BEGINNER-01-25', 44, 'Lớp Người mới bắt đầu Sáng T2-T4', 4, 0, 'dang hoc'),
('BEGINNER-02-25', 44, 'Lớp Người mới bắt đầu Tối T3-T5-T7', 4, 0, 'dang hoc'),
('COM-1V1-01-25', 36, 'Lớp Giao tiếp 1-1 (Lịch linh hoạt)', 3, 0, 'dang hoc'),
('COM-BASIC-01-25', 37, 'Lớp Giao tiếp cơ bản Tối T2-T4', 3, 0, 'dang hoc'),
('COM-BASIC-02-25', 37, 'Lớp Giao tiếp cơ bản Tối T3-T5', 6, 0, 'dang hoc'),
('IELTS-0-7-01-25', 42, 'Lớp IELTS 0-7+ Tối T3-T5', 1, 0, 'dang hoc'),
('IELTS-4S-01-25', 43, 'Lớp IELTS Online 4 Kỹ năng Chiều T2-T4', 6, 0, 'dang hoc'),
('IELTS-4S-02-25', 43, 'Lớp IELTS Online 4 Kỹ năng Tối T3-T5', 1, 0, 'dang hoc'),
('IELTS-F-01-25', 39, 'Lớp IELTS Foundation Tối T2-T4', 1, 0, 'dang hoc'),
('IELTS-F-02-25', 39, 'Lớp IELTS Foundation Chiều T3-T5', 6, 0, 'dang hoc'),
('IELTS-PREP-01-25', 40, 'Lớp Luyện thi IELTS Sáng T3-T5-T7', 1, 0, 'dang hoc'),
('IELTS-PREP-02-25', 40, 'Lớp Luyện thi IELTS Cuối tuần (Chiều T7-CN)', 5, 0, 'dang hoc'),
('KIDS-01-25', 35, 'Lớp Thiếu niên Chiều T3-T5', 5, 1, 'dang hoc'),
('KIDS-02-25', 35, 'Lớp Thiếu nhi Cuối tuần (Sáng T7)', 5, 0, 'dang hoc'),
('TOEIC-4S-01-25', 38, 'Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6', 2, 1, 'dang hoc'),
('TOEIC-4S-02-25', 38, 'Lớp TOEIC 4 Kỹ năng Tối T3-T5', 2, 0, 'dang hoc'),
('TOEIC-DE-01-25', 41, 'Lớp Giải đề TOEIC Tối T2-T4-T6', 2, 0, 'dang hoc'),
('TOEIC-DE-02-25', 41, 'Lớp Giải đề TOEIC Sáng Cuối tuần', 2, 0, 'dang hoc');

-- --------------------------------------------------------

--
-- Table structure for table `luot_truy_cap`
--

CREATE TABLE `luot_truy_cap` (
  `id` int(11) NOT NULL,
  `ngay_truy_cap` date NOT NULL,
  `so_luot` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `luot_truy_cap`
--

INSERT INTO `luot_truy_cap` (`id`, `ngay_truy_cap`, `so_luot`) VALUES
(1, '2025-09-19', 6),
(7, '2025-09-20', 1),
(8, '2025-09-23', 3),
(11, '2025-09-26', 4),
(15, '2025-10-01', 10),
(25, '2025-10-02', 9),
(34, '2025-10-03', 1),
(35, '2025-10-06', 8),
(43, '2025-10-08', 1),
(44, '2025-10-10', 1),
(45, '2025-10-13', 8),
(53, '2025-10-14', 16),
(69, '2025-10-15', 9),
(78, '2025-10-16', 12);

-- --------------------------------------------------------

--
-- Table structure for table `thongbao`
--

CREATE TABLE `thongbao` (
  `id_thongbao` int(11) NOT NULL,
  `id_hocvien` int(11) DEFAULT NULL,
  `id_khoahoc` int(11) DEFAULT NULL,
  `id_lop` varchar(50) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL,
  `tu_dong` tinyint(1) DEFAULT NULL,
  `tieu_de` text DEFAULT NULL,
  `trang_thai` varchar(50) NOT NULL DEFAULT 'chưa đọc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thongbao`
--

INSERT INTO `thongbao` (`id_thongbao`, `id_hocvien`, `id_khoahoc`, `id_lop`, `noi_dung`, `ngay_tao`, `tu_dong`, `tieu_de`, `trang_thai`) VALUES
(1, 27, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 01/10/2025.', '2025-10-14 00:43:27', 1, 'Thông báo lịch học mới', 'đã đọc'),
(2, 27, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 14/10/2025.', '2025-10-14 04:30:57', 1, 'Thông báo lịch học mới', 'đã đọc'),
(8, 27, NULL, 'BASIC-01-25', '<p>ssss</p>', '2025-10-14 17:13:45', NULL, 'sss', 'đã đọc'),
(11, NULL, NULL, 'TOEIC-4S-01-25', 'Giảng viên đã upload tài liệu TOEIC Listening Part 1-4 và Reading Part 5-7 lên hệ thống. Học viên vui lòng truy cập mục \"Học liệu\" để tải về và in trước buổi học. Tài liệu bao gồm: \n- TOEIC Listening Strategies.pdf\n- TOEIC Reading Grammar.pdf\n- Practice Test 1-5.pdf', '2025-10-02 17:15:44', NULL, 'Tài liệu học tập đã được cập nhật', 'da doc'),
(12, NULL, NULL, 'TOEIC-4S-01-25', 'Lớp sẽ có bài kiểm tra định kỳ vào ngày 10/10/2025 (Thứ 6). Nội dung kiểm tra: Listening Part 1, 2 và Reading Part 5. Thời gian: 45 phút. Học viên vui lòng ôn tập kỹ các dạng bài đã học và làm đầy đủ bài tập về nhà. Bài kiểm tra chiếm 20% điểm tổng kết.', '2025-10-04 17:15:44', NULL, 'Bài kiểm tra định kỳ - Tuần 2', 'chua doc'),
(13, NULL, NULL, 'TOEIC-4S-01-25', 'Do giảng viên có công tác, lịch học tuần từ 20-27/10 sẽ được điều chỉnh như sau:\n- Thứ 2, 20/10: Học bình thường 08:00-09:30\n- Thứ 4, 22/10: NGHỈ (Bù vào Chủ Nhật 27/10, 14:00-15:30)\n- Thứ 6, 24/10: Học bình thường 08:00-09:30\n\nMong học viên sắp xếp thời gian phù hợp.', '2025-10-06 17:15:44', NULL, 'Thay đổi lịch học tuần 20-27/10', 'chua doc'),
(14, NULL, NULL, 'TOEIC-4S-01-25', 'Giảng viên chia sẻ:\n1. Nghe: Luyện nghe 30 phút/ngày với podcast tiếng Anh\n2. Đọc: Đọc báo tiếng Anh business/economics mỗi ngày\n3. Từ vựng: Học 20 từ mới/ngày theo chủ đề\n4. Làm bài tập: Hoàn thành tối thiểu 1 practice test/tuần\n5. Quản lý thời gian: Luôn giới hạn thời gian khi làm bài\n\nChúc các bạn học tốt!', '2025-10-08 17:15:44', NULL, 'Tips học TOEIC hiệu quả từ giảng viên', 'da doc'),
(15, NULL, NULL, 'TOEIC-4S-01-25', 'Kỳ thi giữa kỳ sẽ diễn ra vào Thứ 7, ngày 25/10/2025 tại Phòng C301.\n- Thời gian: 09:00-11:00 (120 phút)\n- Hình thức: Full TOEIC Test (Listening 100 câu + Reading 100 câu)\n- Học viên mang theo: CMND/CCCD, bút chì 2B, tẩy\n- Không sử dụng tài liệu, điện thoại\n\nĐể chuẩn bị tốt, làm Practice Test 3-5 trước khi thi.', '2025-10-10 17:15:44', NULL, 'Thông báo thi giữa kỳ - 25/10/2025', 'chua doc'),
(16, NULL, NULL, 'TOEIC-4S-01-25', 'Kết quả bài kiểm tra định kỳ ngày 10/10 đã được chấm và cập nhật vào hệ thống. Điểm trung bình lớp: 156/200 điểm. Học viên có thể xem chi tiết điểm và nhận xét của giảng viên trong mục \"Kết quả kiểm tra\". Những bạn đạt điểm dưới 140 vui lòng gặp giảng viên sau giờ học để được tư vấn cải thiện.', '2025-10-11 17:15:44', NULL, 'Kết quả bài kiểm tra định kỳ - Tuần 2', 'da doc'),
(17, NULL, NULL, 'TOEIC-4S-01-25', 'Nhắc nhở học viên: Buổi học bù cho buổi nghỉ ngày 22/10 sẽ diễn ra vào Chủ Nhật, 27/10/2025 từ 14:00-15:30 tại Phòng C301. Nội dung: TOEIC Reading Part 6 & 7 - Double Passages. Học viên chuẩn bị bài tập Part 7 trong sách và đọc trước các tips làm bài nhanh.', '2025-10-12 17:15:44', NULL, 'Buổi học bù - Chủ Nhật 27/10/2025', 'chua doc');

-- --------------------------------------------------------

--
-- Table structure for table `tien_do_hoc_tap`
--

CREATE TABLE `tien_do_hoc_tap` (
  `id_tien_do` int(11) NOT NULL,
  `id_hocvien` int(11) NOT NULL,
  `id_khoahoc` int(11) NOT NULL,
  `id_lop` varchar(50) NOT NULL,
  `tien_do` decimal(5,2) DEFAULT 0.00,
  `so_buoi_da_tham_gia` int(11) DEFAULT 0,
  `tong_so_buoi` int(11) DEFAULT 0,
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tien_do_hoc_tap`
--

INSERT INTO `tien_do_hoc_tap` (`id_tien_do`, `id_hocvien`, `id_khoahoc`, `id_lop`, `tien_do`, `so_buoi_da_tham_gia`, `tong_so_buoi`, `ngay_cap_nhat`) VALUES
(36, 27, 32, 'BASIC-01-25', 17.65, 3, 18, '2025-10-13 21:30:57'),
(37, 27, 35, 'KIDS-01-25', 0.00, 0, 13, '2025-10-13 20:19:57'),
(39, 1, 38, 'TOEIC-4S-01-25', 0.00, 0, 13, '2025-10-14 10:37:56'),
(40, 1, 32, 'BASIC-01-25', 0.00, 0, 18, '2025-10-14 21:05:47');

--
-- Triggers `tien_do_hoc_tap`
--
DELIMITER $$
CREATE TRIGGER `trg_update_tien_do` BEFORE UPDATE ON `tien_do_hoc_tap` FOR EACH ROW BEGIN
    IF NEW.so_buoi_da_tham_gia != OLD.so_buoi_da_tham_gia THEN
        IF NEW.tong_so_buoi > 0 THEN
            SET NEW.tien_do = (NEW.so_buoi_da_tham_gia / NEW.tong_so_buoi) * 100;
        ELSE
            SET NEW.tien_do = 0;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tuvan`
--

CREATE TABLE `tuvan` (
  `id_tuvan` int(11) NOT NULL,
  `ten_hocvien` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `khung_gio` varchar(20) DEFAULT NULL,
  `trang_thai` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Chưa liên hệ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tuvan`
--

INSERT INTO `tuvan` (`id_tuvan`, `ten_hocvien`, `so_dien_thoai`, `email`, `khung_gio`, `trang_thai`) VALUES
(5, 'Phạm Thị Thu Thảo', '0334445566', 'thaopham.ht@outlook.com', 'Giờ hành chính', 'Đã tư vấn'),
(6, 'Hoàng Đức Trung', '0778889900', 'trunghd@gmail.com', 'Sáng (9h-11h)', 'Đã tư vấn'),
(7, 'Vũ Hải Yến', '0868123456', 'yen.vu.hai@gmail.com', 'Chiều (15h-17h)', 'Không liên lạc được'),
(8, 'Đặng Tuấn Kiệt', '0945678901', 'kiet.dang.tuan@yahoo.com', 'Tối (19h-21h)', 'Chưa liên hệ'),
(9, 'Bùi Phương Linh', '0356789123', 'phuonglinh.bui@gmail.com', 'Giờ hành chính', 'Đã liên hệ'),
(10, 'Hồ Anh Quân', '0789012345', 'anhquan.ho@outlook.com', 'Sáng (9h-11h)', 'Chưa liên hệ'),
(11, 'Ngô Gia Hân', '0934567890', 'giahan.ngo@gmail.com', 'Chiều (15h-17h)', 'Đã tư vấn'),
(12, 'Dương Minh Khang', '0367890123', 'khang.duongminh@gmail.com', 'Tối (19h-21h)', 'Đã tư vấn');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baitest`
--
ALTER TABLE `baitest`
  ADD PRIMARY KEY (`id_baitest`),
  ADD KEY `id_khoahoc` (`id_khoahoc`),
  ADD KEY `id_lop` (`id_lop`);

--
-- Indexes for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`id_baiviet`),
  ADD KEY `id_tac_gia` (`id_tac_gia`);

--
-- Indexes for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`id_binhluan`),
  ADD KEY `id_baiviet` (`id_baiviet`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD PRIMARY KEY (`id_cauhoi`),
  ADD KEY `id_baitest` (`id_baitest`);

--
-- Indexes for table `chat_history`
--
ALTER TABLE `chat_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_hocvien` (`id_hocvien`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_chat_type` (`chat_type`);

--
-- Indexes for table `dangkykhoahoc`
--
ALTER TABLE `dangkykhoahoc`
  ADD PRIMARY KEY (`id_dangky`),
  ADD KEY `id_lop` (`id_lop`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `id_khoahoc` (`id_khoahoc`);

--
-- Indexes for table `danhgiakhoahoc`
--
ALTER TABLE `danhgiakhoahoc`
  ADD PRIMARY KEY (`id_danhgia`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `id_khoahoc` (`id_khoahoc`);

--
-- Indexes for table `dapan`
--
ALTER TABLE `dapan`
  ADD PRIMARY KEY (`id_dapan`),
  ADD KEY `id_cauhoi` (`id_cauhoi`),
  ADD KEY `id_baitest` (`id_baitest`);

--
-- Indexes for table `dapan_hocvien`
--
ALTER TABLE `dapan_hocvien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ketqua` (`id_ketqua`),
  ADD KEY `id_cauhoi` (`id_cauhoi`);

--
-- Indexes for table `diem_danh`
--
ALTER TABLE `diem_danh`
  ADD PRIMARY KEY (`id_diemdanh`),
  ADD UNIQUE KEY `unique_attendance` (`id_hocvien`,`id_lop`,`id_lichhoc`),
  ADD KEY `id_lop` (`id_lop`),
  ADD KEY `id_lichhoc` (`id_lichhoc`);

--
-- Indexes for table `diem_so`
--
ALTER TABLE `diem_so`
  ADD PRIMARY KEY (`id_diem`),
  ADD UNIQUE KEY `unique_grade` (`id_hocvien`,`id_lop`,`loai_diem`),
  ADD KEY `id_lop` (`id_lop`);

--
-- Indexes for table `giangvien`
--
ALTER TABLE `giangvien`
  ADD PRIMARY KEY (`id_giangvien`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hocvien`
--
ALTER TABLE `hocvien`
  ADD PRIMARY KEY (`id_hocvien`);

--
-- Indexes for table `hoc_lieu`
--
ALTER TABLE `hoc_lieu`
  ADD PRIMARY KEY (`id_hoclieu`),
  ADD KEY `id_lop` (`id_lop`),
  ADD KEY `id_khoahoc` (`id_khoahoc`);

--
-- Indexes for table `ketquabaitest`
--
ALTER TABLE `ketquabaitest`
  ADD PRIMARY KEY (`id_ketqua`),
  ADD KEY `id_cauhoi` (`id_cauhoi`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `id_baitest` (`id_baitest`);

--
-- Indexes for table `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`id_khoahoc`);

--
-- Indexes for table `lichhoc`
--
ALTER TABLE `lichhoc`
  ADD PRIMARY KEY (`id_lichhoc`),
  ADD KEY `id_lop` (`id_lop`);

--
-- Indexes for table `lichsu_thanhtoan`
--
ALTER TABLE `lichsu_thanhtoan`
  ADD PRIMARY KEY (`id_thanhtoan`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `id_khoahoc` (`id_khoahoc`);

--
-- Indexes for table `lop_hoc`
--
ALTER TABLE `lop_hoc`
  ADD PRIMARY KEY (`id_lop`),
  ADD KEY `id_khoahoc` (`id_khoahoc`),
  ADD KEY `id_giangvien` (`id_giangvien`);

--
-- Indexes for table `luot_truy_cap`
--
ALTER TABLE `luot_truy_cap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ngay_truy_cap` (`ngay_truy_cap`);

--
-- Indexes for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id_thongbao`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `id_khoahoc` (`id_khoahoc`),
  ADD KEY `id_lop` (`id_lop`);

--
-- Indexes for table `tien_do_hoc_tap`
--
ALTER TABLE `tien_do_hoc_tap`
  ADD PRIMARY KEY (`id_tien_do`),
  ADD KEY `id_hocvien` (`id_hocvien`),
  ADD KEY `id_khoahoc` (`id_khoahoc`),
  ADD KEY `id_lop` (`id_lop`);

--
-- Indexes for table `tuvan`
--
ALTER TABLE `tuvan`
  ADD PRIMARY KEY (`id_tuvan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baitest`
--
ALTER TABLE `baitest`
  MODIFY `id_baitest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `id_baiviet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id_binhluan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cauhoi`
--
ALTER TABLE `cauhoi`
  MODIFY `id_cauhoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=472;

--
-- AUTO_INCREMENT for table `chat_history`
--
ALTER TABLE `chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dangkykhoahoc`
--
ALTER TABLE `dangkykhoahoc`
  MODIFY `id_dangky` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `danhgiakhoahoc`
--
ALTER TABLE `danhgiakhoahoc`
  MODIFY `id_danhgia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dapan`
--
ALTER TABLE `dapan`
  MODIFY `id_dapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1241;

--
-- AUTO_INCREMENT for table `dapan_hocvien`
--
ALTER TABLE `dapan_hocvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `diem_danh`
--
ALTER TABLE `diem_danh`
  MODIFY `id_diemdanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `diem_so`
--
ALTER TABLE `diem_so`
  MODIFY `id_diem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `giangvien`
--
ALTER TABLE `giangvien`
  MODIFY `id_giangvien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hocvien`
--
ALTER TABLE `hocvien`
  MODIFY `id_hocvien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `hoc_lieu`
--
ALTER TABLE `hoc_lieu`
  MODIFY `id_hoclieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `ketquabaitest`
--
ALTER TABLE `ketquabaitest`
  MODIFY `id_ketqua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `id_khoahoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `lichhoc`
--
ALTER TABLE `lichhoc`
  MODIFY `id_lichhoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `lichsu_thanhtoan`
--
ALTER TABLE `lichsu_thanhtoan`
  MODIFY `id_thanhtoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `luot_truy_cap`
--
ALTER TABLE `luot_truy_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id_thongbao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tien_do_hoc_tap`
--
ALTER TABLE `tien_do_hoc_tap`
  MODIFY `id_tien_do` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tuvan`
--
ALTER TABLE `tuvan`
  MODIFY `id_tuvan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baitest`
--
ALTER TABLE `baitest`
  ADD CONSTRAINT `baitest_ibfk_1` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`) ON DELETE CASCADE,
  ADD CONSTRAINT `baitest_ibfk_2` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE CASCADE;

--
-- Constraints for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `bai_viet_ibfk_1` FOREIGN KEY (`id_tac_gia`) REFERENCES `hocvien` (`id_hocvien`) ON DELETE SET NULL;

--
-- Constraints for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`id_baiviet`) REFERENCES `bai_viet` (`id_baiviet`) ON DELETE CASCADE,
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`) ON DELETE SET NULL,
  ADD CONSTRAINT `binh_luan_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `binh_luan` (`id_binhluan`) ON DELETE CASCADE;

--
-- Constraints for table `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD CONSTRAINT `cauhoi_ibfk_1` FOREIGN KEY (`id_baitest`) REFERENCES `baitest` (`id_baitest`) ON DELETE CASCADE;

--
-- Constraints for table `dangkykhoahoc`
--
ALTER TABLE `dangkykhoahoc`
  ADD CONSTRAINT `dangkykhoahoc_ibfk_1` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE SET NULL,
  ADD CONSTRAINT `dangkykhoahoc_ibfk_2` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`),
  ADD CONSTRAINT `dangkykhoahoc_ibfk_3` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`);

--
-- Constraints for table `danhgiakhoahoc`
--
ALTER TABLE `danhgiakhoahoc`
  ADD CONSTRAINT `danhgiakhoahoc_ibfk_1` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`),
  ADD CONSTRAINT `danhgiakhoahoc_ibfk_2` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`);

--
-- Constraints for table `dapan`
--
ALTER TABLE `dapan`
  ADD CONSTRAINT `dapan_ibfk_1` FOREIGN KEY (`id_cauhoi`) REFERENCES `cauhoi` (`id_cauhoi`) ON DELETE CASCADE,
  ADD CONSTRAINT `dapan_ibfk_2` FOREIGN KEY (`id_baitest`) REFERENCES `baitest` (`id_baitest`);

--
-- Constraints for table `dapan_hocvien`
--
ALTER TABLE `dapan_hocvien`
  ADD CONSTRAINT `dapan_hocvien_ibfk_1` FOREIGN KEY (`id_ketqua`) REFERENCES `ketquabaitest` (`id_ketqua`) ON DELETE CASCADE;

--
-- Constraints for table `diem_danh`
--
ALTER TABLE `diem_danh`
  ADD CONSTRAINT `diem_danh_ibfk_1` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`) ON DELETE CASCADE,
  ADD CONSTRAINT `diem_danh_ibfk_2` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE CASCADE,
  ADD CONSTRAINT `diem_danh_ibfk_3` FOREIGN KEY (`id_lichhoc`) REFERENCES `lichhoc` (`id_lichhoc`) ON DELETE CASCADE;

--
-- Constraints for table `diem_so`
--
ALTER TABLE `diem_so`
  ADD CONSTRAINT `diem_so_ibfk_1` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`) ON DELETE CASCADE,
  ADD CONSTRAINT `diem_so_ibfk_2` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE CASCADE;

--
-- Constraints for table `hoc_lieu`
--
ALTER TABLE `hoc_lieu`
  ADD CONSTRAINT `hoc_lieu_ibfk_1` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE CASCADE,
  ADD CONSTRAINT `hoc_lieu_ibfk_2` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`) ON DELETE CASCADE;

--
-- Constraints for table `ketquabaitest`
--
ALTER TABLE `ketquabaitest`
  ADD CONSTRAINT `ketquabaitest_ibfk_1` FOREIGN KEY (`id_cauhoi`) REFERENCES `cauhoi` (`id_cauhoi`),
  ADD CONSTRAINT `ketquabaitest_ibfk_2` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`),
  ADD CONSTRAINT `ketquabaitest_ibfk_3` FOREIGN KEY (`id_baitest`) REFERENCES `baitest` (`id_baitest`) ON DELETE SET NULL;

--
-- Constraints for table `lichhoc`
--
ALTER TABLE `lichhoc`
  ADD CONSTRAINT `lichhoc_ibfk_1` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE CASCADE;

--
-- Constraints for table `lichsu_thanhtoan`
--
ALTER TABLE `lichsu_thanhtoan`
  ADD CONSTRAINT `lichsu_thanhtoan_ibfk_1` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`),
  ADD CONSTRAINT `lichsu_thanhtoan_ibfk_2` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`);

--
-- Constraints for table `lop_hoc`
--
ALTER TABLE `lop_hoc`
  ADD CONSTRAINT `lop_hoc_ibfk_1` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`) ON DELETE CASCADE,
  ADD CONSTRAINT `lop_hoc_ibfk_2` FOREIGN KEY (`id_giangvien`) REFERENCES `giangvien` (`id_giangvien`) ON DELETE SET NULL;

--
-- Constraints for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD CONSTRAINT `thongbao_ibfk_1` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`),
  ADD CONSTRAINT `thongbao_ibfk_2` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`),
  ADD CONSTRAINT `thongbao_ibfk_3` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE SET NULL;

--
-- Constraints for table `tien_do_hoc_tap`
--
ALTER TABLE `tien_do_hoc_tap`
  ADD CONSTRAINT `tien_do_hoc_tap_ibfk_1` FOREIGN KEY (`id_hocvien`) REFERENCES `hocvien` (`id_hocvien`),
  ADD CONSTRAINT `tien_do_hoc_tap_ibfk_2` FOREIGN KEY (`id_khoahoc`) REFERENCES `khoahoc` (`id_khoahoc`),
  ADD CONSTRAINT `tien_do_hoc_tap_ibfk_3` FOREIGN KEY (`id_lop`) REFERENCES `lop_hoc` (`id_lop`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
