-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 07:36 PM
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
(1, 38, 'TOEIC-4S-01-25', 'Bài kiểm tra ngữ pháp tiếng Anh cơ bản', 'on_tap', 1, '2024-12-15 21:43:36'),
(2, NULL, NULL, 'Kiểm tra từ vựng tiếng Anh', 'on_tap', 30, '2024-12-15 22:12:02'),
(4, NULL, NULL, 'Kiểm tra thành ngữ tiếng Anh', 'on_tap', 40, '2024-12-15 22:17:52'),
(6, NULL, NULL, 'Kiểm tra các thì trong tiếng Anh', 'on_tap', 30, '2024-12-15 23:56:23'),
(7, NULL, NULL, 'Test Từ Vựng Tiếng Anh - Nâng Cao', 'on_tap', 20, '2024-12-15 23:58:08'),
(9, NULL, NULL, 'Kiểm tra từ trái nghĩa tiếng Anh', 'on_tap', 60, '2024-12-16 00:12:11'),
(54, NULL, NULL, 'Ngữ Pháp Cơ Bản', 'on_tap', 30, '2025-11-07 04:52:40'),
(58, NULL, NULL, 'Đọc Hiểu Cơ Bản', 'on_tap', 35, '2025-11-07 04:52:41'),
(60, NULL, NULL, 'Từ Vựng Chủ Đề Gia Đình', 'on_tap', 20, '2025-11-07 04:52:42'),
(61, NULL, NULL, 'Câu Bị Động', 'dinh_ky', 25, '2025-11-07 04:52:42'),
(63, NULL, NULL, 'Từ Vựng Giao Tiếp', 'on_tap', 25, '2025-11-07 04:56:22'),
(64, NULL, NULL, 'Thì Động Từ', 'dinh_ky', 30, '2025-11-07 04:56:22'),
(65, NULL, NULL, 'Giới Từ', 'on_tap', 20, '2025-11-07 04:56:23'),
(68, 38, 'TOEIC-4S-01-25', 'Từ Vựng Chủ Đề Gia Đình', 'on_tap', 20, '2025-11-07 04:56:23'),
(70, NULL, NULL, 'So Sánh Tính Từ', 'on_tap', 20, '2025-11-07 04:56:23'),
(71, NULL, NULL, 'Bài kiểm tra đầu vào', 'dau_vao', 20, '2025-11-07 04:56:24'),
(72, NULL, NULL, 'Viết Đoạn Văn Giới Thiệu Bản Thân', 'on_tap', 45, '2025-11-07 05:03:56'),
(73, NULL, NULL, 'Viết Email Giao Tiếp', 'on_tap', 40, '2025-11-07 05:03:56'),
(74, NULL, NULL, 'Viết Về Sở Thích', 'dinh_ky', 40, '2025-11-07 05:03:57'),
(75, NULL, NULL, 'Viết Về Trải Nghiệm', 'on_tap', 45, '2025-11-07 05:03:57'),
(76, NULL, NULL, 'Viết Về Kế Hoạch Tương Lai', 'on_tap', 40, '2025-11-07 05:03:57'),
(77, NULL, NULL, 'Viết Thư Phàn Nàn', 'dinh_ky', 45, '2025-11-07 05:03:57'),
(78, 36, NULL, 'Viết Bài Luận Ý Kiến', 'on_tap', 50, '2025-11-07 05:03:57'),
(79, NULL, NULL, 'Viết Về Môi Trường', 'on_tap', 45, '2025-11-07 05:03:57'),
(90, NULL, NULL, 'T', 'dau_vao', 11, '2025-11-10 01:06:26');

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
(2, 'Mẹo hiểu bài đọc IELTS cho người mới: Làm sao đọc nhanh và dễ hơn?', '<p>Với những bạn mới bắt đầu học IELTS, phần Reading lu&ocirc;n l&agrave; một trong những kỹ năng khiến người học cảm thấy &ldquo;kh&oacute; nuốt&rdquo; nhất. Văn bản d&agrave;i, từ vựng lạ, cấu tr&uacute;c phức tạp, chưa kể thời gian l&agrave;m b&agrave;i chỉ g&oacute;i gọn trong 60 ph&uacute;t cho 3 đoạn văn v&agrave; 40 c&acirc;u hỏi.</p>\r\n\r\n<p>Vậy l&agrave;m thế n&agrave;o để&nbsp;<strong>&aacute;p dụng những mẹo hiểu b&agrave;i đọc IELTS cho người mới</strong>&nbsp;một c&aacute;ch hiệu quả? C&oacute; c&aacute;ch n&agrave;o để luyện đọc dễ hiểu hơn ngay từ đầu, kể cả khi bạn chưa c&oacute; vốn từ vựng lớn?</p>\r\n\r\n<p>Trong b&agrave;i viết n&agrave;y, bạn sẽ t&igrave;m thấy những&nbsp;<strong>chiến lược đơn giản, dễ luyện v&agrave; cực kỳ thực tế</strong>&nbsp;để cải thiện khả năng đọc hiểu chỉ sau một thời gian ngắn luyện tập.</p>\r\n\r\n<h2><strong>1. C&oacute; mẹo hiểu b&agrave;i đọc IELTS cho người mới n&agrave;o đơn giản kh&ocirc;ng?</strong></h2>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><a href=\"https://vietop.edu.vn/blog/meo-hieu-bai-doc-ielts-cho-nguoi-moi/\">C&oacute; mẹo hiểu b&agrave;i đọc IELTS cho người mới n&agrave;o đơn giản kh&ocirc;ng?</a><br />\r\n			<strong>C&acirc;u trả lời</strong>:&nbsp;<strong>Người mới học n&ecirc;n bắt đầu bằng việc:</strong><br />\r\n			&ndash; L&agrave;m quen với bố cục b&agrave;i thi<br />\r\n			&ndash; Đọc ti&ecirc;u đề v&agrave; đoạn mở đầu thật kỹ<br />\r\n			&ndash; L&agrave;m quen với kỹ thuật đọc lướt &ndash; đọc qu&eacute;t.<br />\r\n			&ndash; Gạch từ kh&oacute;a quan trọng trong c&acirc;u hỏi<br />\r\n			&ndash; Tập trung v&agrave;o &yacute; ch&iacute;nh thay v&igrave; dịch từng từ.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Kh&ocirc;ng cần &ldquo;cao si&ecirc;u&rdquo;, chỉ cần bạn luyện đ&uacute;ng c&aacute;ch, việc đọc hiểu sẽ trở n&ecirc;n dễ d&agrave;ng hơn rất nhiều.</p>\r\n\r\n<h2><strong>2. V&igrave; sao người mới học thường gặp kh&oacute; khăn với b&agrave;i đọc Reading?</strong></h2>\r\n\r\n<p>Trước khi đi v&agrave;o chi tiết c&aacute;c mẹo cải thiện, h&atilde;y c&ugrave;ng nh&igrave;n lại một số l&yacute; do khiến phần&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/reading/\" target=\"_blank\">IELTS Reading</a>&nbsp;trở th&agrave;nh &ldquo;&aacute;c mộng&rdquo; với người mới học. Hiểu được nguy&ecirc;n nh&acirc;n sẽ gi&uacute;p bạn tr&aacute;nh được những sai lầm phổ biến v&agrave; học đ&uacute;ng hướng từ đầu.</p>\r\n\r\n<h3><strong>2.1. Văn bản d&agrave;i, nội dung học thuật</strong></h3>\r\n\r\n<p>Một b&agrave;i Reading IELTS thường d&agrave;i gần 900 từ, chia th&agrave;nh ba đoạn v&agrave; đề cập đến c&aacute;c chủ đề đa dạng như khoa học, gi&aacute;o dục, m&ocirc;i trường, lịch sử&hellip; Kh&ocirc;ng chỉ cần hiểu nội dung, bạn c&ograve;n phải xử l&yacute; th&ocirc;ng tin trong thời gian giới hạn, chưa kể &aacute;p lực thi khiến nhiều bạn bị &ldquo;đuối&rdquo; từ đoạn 2 trở đi.</p>\r\n\r\n<h3><strong>2.2. Th&oacute;i quen dịch từng d&ograve;ng</strong></h3>\r\n\r\n<p>C&aacute;ch học phổ biến nhưng thiếu hiệu quả: đọc từng d&ograve;ng &rarr; dịch sang tiếng Việt &rarr; cố gắng hiểu &rarr; quay lại b&agrave;i đọc &rarr; qu&ecirc;n mất nội dung c&acirc;u hỏi. Việc dịch s&aacute;t nghĩa từng từ như vậy kh&ocirc;ng chỉ l&agrave;m chậm tiến độ m&agrave; c&ograve;n khiến bạn rối v&agrave; mệt mỏi.</p>\r\n\r\n<h3><strong>3.3. Kh&ocirc;ng biết đ&acirc;u l&agrave; th&ocirc;ng tin ch&iacute;nh cần t&igrave;m</strong></h3>\r\n\r\n<p>Đọc m&agrave; kh&ocirc;ng c&oacute; &ldquo;mục ti&ecirc;u&rdquo; dễ khiến bạn đọc ho&agrave;i m&agrave; kh&ocirc;ng biết m&igrave;nh đang t&igrave;m g&igrave;. Đặc biệt l&agrave; dạng c&acirc;u hỏi&nbsp;<a href=\"https://vietop.edu.vn/blog/true-false-not-given-ielts-reading/\" target=\"_blank\">True/False/Not Given</a>&nbsp;&ndash; nếu kh&ocirc;ng x&aacute;c định đ&uacute;ng từ kh&oacute;a v&agrave; nội dung ch&iacute;nh, bạn sẽ mất rất nhiều thời gian v&ocirc; &iacute;ch.</p>\r\n\r\n<h2><strong>3. Mẹo hiểu b&agrave;i đọc IELTS cho người mới: Dễ &aacute;p dụng, dễ tiến bộ</strong></h2>\r\n\r\n<p>Biết được những kh&oacute; khăn rồi, giờ l&agrave; l&uacute;c bạn cần những giải ph&aacute;p cụ thể. Dưới đ&acirc;y l&agrave; những mẹo đơn giản nhưng cực kỳ hiệu quả d&agrave;nh ri&ecirc;ng cho người mới, gi&uacute;p bạn đọc hiểu tốt hơn m&agrave; kh&ocirc;ng cần qu&aacute; giỏi tiếng Anh ngay từ đầu.</p>\r\n\r\n<p><img alt=\"Những mẹo hiểu bài đọc IELTS cho người mới\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/04/meo-hieu-bai-doc-ielts-cho-nguoi-moi.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>Những mẹo hiểu b&agrave;i đọc IELTS cho người mới</p>\r\n\r\n<h3><strong>3.1. Đọc đoạn mở đầu để nắm chủ đề</strong></h3>\r\n\r\n<p>Kh&ocirc;ng cần học l&yacute; thuyết d&agrave;i d&ograve;ng, bạn c&oacute; thể bắt đầu bằng:</p>\r\n\r\n<ul>\r\n	<li>Đọc ti&ecirc;u đề v&agrave; c&acirc;u đầu đoạn để x&aacute;c định nội dung ch&iacute;nh</li>\r\n	<li>D&ograve; t&ecirc;n ri&ecirc;ng, số liệu, cụm từ viết hoa &ndash; những thứ dễ nhận diện bằng mắt</li>\r\n	<li>Đọc c&acirc;u hỏi song song với b&agrave;i &rarr; x&aacute;c định đoạn cần đọc kỹ hơn</li>\r\n</ul>\r\n\r\n<p>Luyện mỗi ng&agrave;y bằng 1 b&agrave;i b&aacute;o ngắn từ CNN, BBC, hoặc một đoạn blog c&oacute; nội dung học thuật l&agrave; đủ.</p>\r\n\r\n<h3><strong>3.2. L&agrave;m quen với kỹ thuật đọc lướt v&agrave; đọc qu&eacute;t</strong></h3>\r\n\r\n<p>C&acirc;u hỏi lu&ocirc;n được viết trước, c&oacute; nghĩa l&agrave; bạn biết m&igrave;nh cần t&igrave;m g&igrave; &ndash; giống như cầm bản đồ trước khi đi t&igrave;m kho b&aacute;u. Gạch từ kh&oacute;a (v&iacute; dụ: years, names, effects, causes&hellip;) rồi quay lại b&agrave;i đọc, bạn sẽ tiết kiệm được &iacute;t nhất 30% thời gian so với việc đọc d&agrave;n trải.</p>\r\n\r\n<h3><strong>3.3. Kh&ocirc;ng cần hiểu từng từ &ndash; tập trung v&agrave;o c&acirc;u chứa th&ocirc;ng tin</strong></h3>\r\n\r\n<p>Khi gặp từ lạ:</p>\r\n\r\n<ul>\r\n	<li>Đừng dừng lại</li>\r\n	<li>Nh&igrave;n c&acirc;u xung quanh</li>\r\n	<li>Dựa v&agrave;o c&aacute;c cụm từ bạn biết để đo&aacute;n ngữ cảnh</li>\r\n</ul>\r\n\r\n<p>Tập trung v&agrave;o c&acirc;u c&oacute; chứa t&ecirc;n người, số liệu, mốc thời gian &ndash; thường l&agrave; nơi chứa đ&aacute;p &aacute;n của nhiều dạng c&acirc;u hỏi.</p>\r\n\r\n<h3><strong>3.4. L&agrave;m phần dễ trước, đừng bị cuốn v&agrave;o 1 c&acirc;u</strong></h3>\r\n\r\n<p>Chiến thuật &ldquo;đ&aacute;nh nhanh r&uacute;t gọn&rdquo;: L&agrave;m Gap Fill hoặc&nbsp;<a href=\"https://vietop.edu.vn/blog/multiple-choice-ielts-reading/\" target=\"_blank\">Multiple Choice</a>&nbsp;trước &rarr; quay lại c&aacute;c dạng Matching sau. Đừng để 1 c&acirc;u l&agrave;m mất 3 ph&uacute;t của bạn &ndash; điểm số sẽ kh&ocirc;ng đến từ sự &ldquo;cố chấp&rdquo;.</p>\r\n\r\n<h2><strong>4. C&aacute;ch luyện đọc mỗi ng&agrave;y cho người mới học IELTS Reading</strong></h2>\r\n\r\n<p>&Aacute;p dụng mẹo l&agrave; một chuyện, nhưng nếu kh&ocirc;ng luyện tập đều đặn th&igrave; kết quả sẽ kh&ocirc;ng bền vững. Phần n&agrave;y sẽ hướng dẫn bạn c&aacute;ch x&acirc;y dựng th&oacute;i quen luyện đọc mỗi ng&agrave;y một c&aacute;ch dễ d&agrave;ng, hiệu quả v&agrave; ph&ugrave; hợp với người mới bắt đầu.</p>\r\n\r\n<h3><strong>4.1. Mỗi ng&agrave;y đọc 1 đoạn ngắn c&oacute; chủ đề quen thuộc</strong></h3>\r\n\r\n<p>Đừng &eacute;p m&igrave;nh đọc b&agrave;i thi mẫu nếu chưa sẵn s&agrave;ng. H&atilde;y bắt đầu với:</p>\r\n\r\n<ul>\r\n	<li>B&agrave;i đọc về chủ đề bạn y&ecirc;u th&iacute;ch (du lịch, c&ocirc;ng nghệ, ẩm thực&hellip;)</li>\r\n	<li>B&agrave;i ngắn 200&ndash;300 từ, đọc trong 5&ndash;7 ph&uacute;t</li>\r\n	<li>Ghi lại 1 c&acirc;u t&oacute;m tắt nội dung</li>\r\n</ul>\r\n\r\n<h3><strong>4.2. Đặt thời gian cho mỗi lần đọc</strong></h3>\r\n\r\n<p>Tự giới hạn thời gian sẽ r&egrave;n khả năng tập trung. V&iacute; dụ:</p>\r\n\r\n<ul>\r\n	<li>5 ph&uacute;t để đọc hiểu</li>\r\n	<li>2 ph&uacute;t trả lời 3 c&acirc;u hỏi</li>\r\n	<li>1 ph&uacute;t kiểm tra lại</li>\r\n</ul>\r\n\r\n<p>Sau đ&oacute; ghi lại thời gian thực tế v&agrave; so s&aacute;nh với mục ti&ecirc;u.</p>\r\n\r\n<h3>4.3. Học từ theo cụm &ndash; kh&ocirc;ng học đơn lẻ</h3>\r\n\r\n<p>Tập ghi ch&uacute; theo dạng:</p>\r\n\r\n<ul>\r\n	<li>Environment &rarr; global warming, air pollution, renewable energy</li>\r\n	<li>Health &rarr; balanced diet, mental health, life expectancy</li>\r\n</ul>\r\n\r\n<p>Bạn sẽ thấy khả năng &ldquo;nhận diện từ kh&oacute;a&rdquo; v&agrave; &ldquo;hiểu mạch văn&rdquo; tăng r&otilde; rệt.</p>\r\n\r\n<h3><strong>4.4. Tự hỏi v&agrave; trả lời sau khi đọc xong</strong></h3>\r\n\r\n<p>Đọc xong đừng gấp s&aacute;ch. H&atilde;y hỏi:</p>\r\n\r\n<ul>\r\n	<li>M&igrave;nh hiểu g&igrave;?</li>\r\n	<li>C&oacute; từ n&agrave;o m&igrave;nh đo&aacute;n đ&uacute;ng nghĩa kh&ocirc;ng?</li>\r\n	<li>C&acirc;u hỏi n&agrave;o khiến m&igrave;nh tốn nhiều thời gian nhất?</li>\r\n</ul>\r\n\r\n<p>Việc n&agrave;y gi&uacute;p bạn hiểu b&agrave;i đọc s&acirc;u hơn v&agrave; cải thiện từng ng&agrave;y.</p>\r\n\r\n<h2><strong>5. Những lỗi người mới hay mắc khi luyện đọc IELTS</strong></h2>\r\n\r\n<p>D&ugrave; bạn c&oacute; mẹo hay c&aacute;ch luyện tốt đến đ&acirc;u, vẫn cần tr&aacute;nh những sai lầm dễ mắc phải. Dưới đ&acirc;y l&agrave; những lỗi phổ biến m&agrave; người học thường gặp &ndash; nhận diện v&agrave; khắc phục sớm sẽ gi&uacute;p bạn r&uacute;t ngắn thời gian luyện thi đ&aacute;ng kể.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Lỗi</strong></td>\r\n			<td><strong>Hậu quả</strong></td>\r\n			<td><strong>Giải ph&aacute;p</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td>Dịch từng d&ograve;ng</td>\r\n			<td>Rối &yacute;, chậm</td>\r\n			<td>Tập skim + scan</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Kh&ocirc;ng đọc c&acirc;u hỏi trước</td>\r\n			<td>Kh&ocirc;ng biết t&igrave;m g&igrave;</td>\r\n			<td>Đọc c&acirc;u hỏi trước b&agrave;i</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Gặp từ lạ l&agrave; hoang mang</td>\r\n			<td>Bỏ dở giữa chừng</td>\r\n			<td>Đo&aacute;n nghĩa theo ngữ cảnh</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Kh&ocirc;ng luyện thường xuy&ecirc;n</td>\r\n			<td>Dậm ch&acirc;n tại chỗ</td>\r\n			<td>Mỗi ng&agrave;y đọc &iacute;t nhất 1 đoạn</td>\r\n		</tr>\r\n		<tr>\r\n			<td>L&agrave;m hết 40 c&acirc;u mỗi lần</td>\r\n			<td>Dễ nản, kh&ocirc;ng tiến bộ</td>\r\n			<td>Chia nhỏ b&agrave;i &ndash; luyện từng dạng một</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2><strong>6. Kết luận</strong></h2>\r\n\r\n<p><strong>Mẹo hiểu b&agrave;i đọc IELTS cho người mới</strong>&nbsp;đến từ việc&nbsp;<strong>luyện tập c&oacute; chiến lược v&agrave; đ&uacute;ng tr&igrave;nh độ</strong>. Bạn kh&ocirc;ng cần hiểu hết, kh&ocirc;ng cần từ vựng &ldquo;cao si&ecirc;u&rdquo;, chỉ cần một kế hoạch r&otilde; r&agrave;ng v&agrave; quyết t&acirc;m duy tr&igrave; đều đặn mỗi ng&agrave;y.</p>\r\n\r\n<p>IELTS kh&ocirc;ng phải l&agrave; chặng đua tốc độ m&agrave; l&agrave; h&agrave;nh tr&igrave;nh bền bỉ. Đừng vội &ndash; h&atilde;y bắt đầu với những b&agrave;i đọc bạn thấy dễ hiểu nhất. Sau một th&aacute;ng, bạn sẽ ngạc nhi&ecirc;n với sự tiến bộ của ch&iacute;nh m&igrave;nh.</p>', 'uploads/posts/1760568520_thumbnail-meo-hieu-bai-doc-ielts-cho-nguoi-moi.jpg', 1, '2025-10-15 22:48:40', '2025-10-16 00:48:46', 'da_duyet', 2),
(7, 'Lộ trình luyện IELTS cho người thích tự học: Hướng dẫn từng bước, dễ áp dụng tại nhà', '<p>Nhiều người nghĩ rằng luyện IELTS hiệu quả phải học ở trung t&acirc;m, c&oacute; gi&aacute;o vi&ecirc;n k&egrave;m cặp hoặc tham gia lớp nh&oacute;m. Thực tế, rất nhiều bạn đ&atilde; chinh phục th&agrave;nh c&ocirc;ng IELTS chỉ nhờ phương ph&aacute;p tự học hợp l&yacute;, khoa học v&agrave; chủ động khai th&aacute;c tối đa c&aacute;c t&agrave;i nguy&ecirc;n miễn ph&iacute; tr&ecirc;n mạng.&nbsp;</p>\r\n\r\n<p>Chọn tự học kh&ocirc;ng chỉ l&agrave; giải ph&aacute;p cho người bận rộn m&agrave; c&ograve;n l&agrave; hướng đi gi&uacute;p bạn r&egrave;n luyện t&iacute;nh kỷ luật v&agrave; khả năng tự lập &ndash; hai yếu tố quan trọng để chinh phục mọi mục ti&ecirc;u trong cuộc sống, kh&ocirc;ng chỉ IELTS.&nbsp;</p>\r\n\r\n<p>B&agrave;i viết n&agrave;y sẽ đồng h&agrave;nh c&ugrave;ng bạn x&acirc;y dựng lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học, gi&uacute;p bạn tự thiết lập mục ti&ecirc;u, chọn nguồn t&agrave;i liệu chuẩn v&agrave; duy tr&igrave; động lực suốt h&agrave;nh tr&igrave;nh m&agrave; kh&ocirc;ng cảm thấy &ldquo;lạc tr&ocirc;i&rdquo; hay qu&aacute; tải.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Nội dung quan trọng</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td>&ndash; Luyện IELTS cho người th&iacute;ch tự học l&agrave; giải ph&aacute;p d&agrave;nh ri&ecirc;ng cho những ai muốn chủ động về thời gian, tiết kiệm chi ph&iacute; v&agrave; kiểm so&aacute;t lộ tr&igrave;nh học theo &yacute; m&igrave;nh.<br />\r\n			&ndash; Trọng t&acirc;m của lộ tr&igrave;nh n&agrave;y l&agrave; kỹ năng tự thiết lập mục ti&ecirc;u, tự kiểm tra tiến độ, v&agrave; biết c&aacute;ch tận dụng t&agrave;i liệu online chất lượng, thay v&igrave; phụ thuộc v&agrave;o lớp học hay gi&aacute;o tr&igrave;nh truyền thống.<br />\r\n			&ndash; B&agrave;i viết hướng dẫn c&aacute;ch x&acirc;y dựng kế hoạch luyện từng kỹ năng v&agrave; duy tr&igrave; động lực tự học l&acirc;u d&agrave;i.<br />\r\n			&ndash; Tr&aacute;nh c&aacute;c sai lầm như học lan man, kh&ocirc;ng đ&aacute;nh gi&aacute; đ&uacute;ng năng lực thực tế, hoặc kh&ocirc;ng duy tr&igrave; được th&oacute;i quen luyện tập đều đặn.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2><strong>1. V&igrave; sao lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học lại ph&ugrave; hợp với nhiều bạn trẻ hiện nay?</strong></h2>\r\n\r\n<p>Ng&agrave;y nay,&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/\" target=\"_blank\">tự học IELTS</a>&nbsp;kh&ocirc;ng chỉ gi&uacute;p tiết kiệm chi ph&iacute; m&agrave; c&ograve;n mang lại sự linh hoạt tối đa cho những người bận rộn, th&iacute;ch chủ động điều chỉnh tiến độ v&agrave; phương ph&aacute;p theo c&aacute; nh&acirc;n.&nbsp;</p>\r\n\r\n<p>Sự ph&aacute;t triển của c&aacute;c nền tảng học online, cộng đồng học tập, v&agrave; kho t&agrave;i liệu miễn ph&iacute; đ&atilde; biến việc tự học từ &ldquo;bất đắc dĩ&rdquo; th&agrave;nh một xu hướng được nhiều bạn trẻ lựa chọn v&agrave; theo đuổi l&acirc;u d&agrave;i.</p>\r\n\r\n<p>Khi tự học, bạn ho&agrave;n to&agrave;n kiểm so&aacute;t được thời gian, chủ động lựa chọn phương ph&aacute;p ph&ugrave; hợp với bản th&acirc;n, đồng thời r&egrave;n luyện kỹ năng tự lập v&agrave; tự đ&aacute;nh gi&aacute; tiến bộ &ndash; những yếu tố rất quan trọng trong qu&aacute; tr&igrave;nh chinh phục IELTS.</p>\r\n\r\n<p><strong>V&iacute; dụ:&nbsp;</strong>Bạn chỉ c&oacute; thể học v&agrave;o buổi tối sau khi đi l&agrave;m hoặc học xong ở trường? Với phương ph&aacute;p luyện IELTS cho người th&iacute;ch tự học, bạn dễ d&agrave;ng chia nhỏ thời gian, học linh hoạt từng kỹ năng v&agrave;o c&aacute;c khung giờ ph&ugrave; hợp thay v&igrave; phải &ldquo;cố định&rdquo; lịch đến lớp.</p>\r\n\r\n<p>Tuy nhi&ecirc;n, để tự học đạt kết quả tốt, điều đầu ti&ecirc;n bạn cần l&agrave;m l&agrave; x&aacute;c định đ&uacute;ng mục ti&ecirc;u v&agrave; l&ecirc;n kế hoạch r&otilde; r&agrave;ng từ ban đầu. H&atilde;y c&ugrave;ng m&igrave;nh đi tới bước tiếp theo &ndash; x&acirc;y dựng nền m&oacute;ng vững chắc cho h&agrave;nh tr&igrave;nh tự học của bạn.</p>\r\n\r\n<h2><strong>2. X&aacute;c định mục ti&ecirc;u r&otilde; r&agrave;ng trước khi bắt đầu lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học</strong></h2>\r\n\r\n<p>Để việc luyện IELTS cho người th&iacute;ch tự học kh&ocirc;ng bị &ldquo;rơi v&agrave;o trạng th&aacute;i học cho c&oacute;&rdquo;, bạn cần x&aacute;c định r&otilde; mục ti&ecirc;u &ndash; cả về band điểm, thời gian, kỹ năng cần ưu ti&ecirc;n v&agrave; l&yacute; do thực sự muốn đạt IELTS.</p>\r\n\r\n<p>Khi bắt đầu tự học, rất dễ rơi v&agrave;o cảm gi&aacute;c &ldquo;lạc hướng&rdquo; hoặc mất động lực giữa chừng nếu bạn kh&ocirc;ng c&oacute; đ&iacute;ch đến r&otilde; r&agrave;ng. Do đ&oacute;, bước x&aacute;c định mục ti&ecirc;u n&agrave;y đ&oacute;ng vai tr&ograve; then chốt gi&uacute;p bạn duy tr&igrave; tinh thần v&agrave; kiểm so&aacute;t tiến độ mỗi ng&agrave;y.</p>\r\n\r\n<p><img alt=\"Xác định mục tiêu rõ ràng trước khi bắt đầu lộ trình luyện IELTS cho người thích tự học\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/07/xac-dinh-muc-tieu-ro-rang-truoc-khi-bat-dau-lo-trinh-luyen-ielts-cho-nguoi-thich-tu-hoc.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>X&aacute;c định mục ti&ecirc;u r&otilde; r&agrave;ng trước khi bắt đầu lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học</p>\r\n\r\n<p><strong>C&aacute;c bước x&aacute;c định mục ti&ecirc;u c&aacute; nh&acirc;n:</strong></p>\r\n\r\n<ul>\r\n	<li><strong>Đ&aacute;nh gi&aacute; năng lực hiện tại</strong>&nbsp;qua b&agrave;i&nbsp;<a href=\"https://vietop.edu.vn/thi-thu-ielts/\" target=\"_blank\">thi thử online</a>&nbsp;(c&oacute; thể chọn c&aacute;c đề Cambridge, hoặc mock test miễn ph&iacute; tr&ecirc;n c&aacute;c website uy t&iacute;n).</li>\r\n	<li><strong>Đặt mục ti&ecirc;u cụ thể</strong>: cần đạt overall bao nhi&ecirc;u? Kỹ năng yếu nhất l&agrave; g&igrave;?</li>\r\n	<li><strong>X&aacute;c định thời gian luyện</strong>: học trong bao l&acirc;u? Mỗi tuần/mỗi ng&agrave;y học được bao nhi&ecirc;u tiếng?</li>\r\n	<li><strong>Viết ra l&yacute; do c&aacute; nh&acirc;n</strong>: học IELTS để x&eacute;t tốt nghiệp, du học, xin việc hay n&acirc;ng cao kỹ năng giao tiếp?</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:&nbsp;</strong>Bạn đặt mục ti&ecirc;u &ldquo;Từ band 5.5 l&ecirc;n 6.5 trong 4 th&aacute;ng&rdquo;, ưu ti&ecirc;n n&acirc;ng&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/speaking/\" target=\"_blank\">Speaking</a>&nbsp;v&agrave;&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/writing/\" target=\"_blank\">Writing</a>&nbsp;v&igrave; đ&acirc;y l&agrave; kỹ năng yếu nhất. L&yacute; do: cần IELTS 6.5 để x&eacute;t tốt nghiệp v&agrave; tăng cơ hội học bổng.</p>\r\n\r\n<p>Khi đ&atilde; x&aacute;c định xong mục ti&ecirc;u, bạn sẽ c&oacute; nền tảng vững chắc để x&acirc;y dựng lộ tr&igrave;nh v&agrave; lựa chọn phương ph&aacute;p học ph&ugrave; hợp. Tiếp theo, h&atilde;y c&ugrave;ng m&igrave;nh t&igrave;m hiểu c&aacute;ch chia nhỏ lộ tr&igrave;nh để đảm bảo từng kỹ năng đều được ph&aacute;t triển đồng đều.</p>\r\n\r\n<h2><strong>3. X&acirc;y dựng lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học: Chia nhỏ mục ti&ecirc;u, ưu ti&ecirc;n thực h&agrave;nh đều</strong></h2>\r\n\r\n<p>Lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học hiệu quả nhất l&agrave; khi được chia nhỏ th&agrave;nh từng giai đoạn ngắn, tập trung luyện đều c&aacute;c kỹ năng v&agrave; lu&ocirc;n kiểm so&aacute;t tiến độ học.</p>\r\n\r\n<p>Bạn kh&ocirc;ng n&ecirc;n để h&agrave;nh tr&igrave;nh tự học trở th&agrave;nh &ldquo;cuộc đua marathon&rdquo; thiếu điểm dừng; h&atilde;y ph&acirc;n nhỏ th&agrave;nh từng chặng, với mục ti&ecirc;u ngắn hạn r&otilde; r&agrave;ng để vừa học vừa &ldquo;thưởng&rdquo; cho bản th&acirc;n khi đạt được từng cột mốc.</p>\r\n\r\n<p><img alt=\"Xây dựng lộ trình luyện IELTS cho người thích tự học\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/07/xay-dung-lo-trinh-luyen-ielts-cho-nguoi-thich-tu-hoc.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>X&acirc;y dựng lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học</p>\r\n\r\n<h3><strong>3.1. Giai đoạn 1: Đ&aacute;nh gi&aacute; năng lực, l&agrave;m quen với cấu tr&uacute;c đề thi</strong></h3>\r\n\r\n<p>Trước khi &ldquo;lao v&agrave;o&rdquo; học từng kỹ năng, h&atilde;y d&agrave;nh 3&ndash;5 ng&agrave;y để l&agrave;m đề thi mẫu, đọc kỹ từng dạng b&agrave;i v&agrave; nhận diện điểm mạnh/ yếu của m&igrave;nh.</p>\r\n\r\n<p>Việc l&agrave;m quen với cấu tr&uacute;c đề v&agrave; nhận diện c&aacute;c lỗi c&aacute; nh&acirc;n gi&uacute;p bạn tr&aacute;nh l&atilde;ng ph&iacute; thời gian v&agrave;o những điểm mạnh vốn c&oacute;, đồng thời dồn sức khắc phục c&aacute;c điểm yếu c&ograve;n tồn tại.</p>\r\n\r\n<p><strong>Những việc n&ecirc;n l&agrave;m:</strong></p>\r\n\r\n<ul>\r\n	<li>L&agrave;m 1 đề full 4 kỹ năng, bấm giờ như thi thật.</li>\r\n	<li>Đọc kỹ giải th&iacute;ch đ&aacute;p &aacute;n, so s&aacute;nh với b&agrave;i mẫu.</li>\r\n	<li>Ghi ch&uacute; lại c&aacute;c lỗi thường gặp, dạng b&agrave;i m&igrave;nh hay sai nhất.</li>\r\n</ul>\r\n\r\n<p>Giai đoạn n&agrave;y gi&uacute;p bạn nh&igrave;n nhận ra những chỗ bạn yếu nhất, từ đ&oacute;, gi&uacute;p bạn biết được những chỗ cần ưu ti&ecirc;n luyện tập.</p>\r\n\r\n<h3><strong>3.2. Giai đoạn 2: Chia nhỏ từng kỹ năng, luyện theo topic v&agrave; dạng b&agrave;i</strong></h3>\r\n\r\n<p>Từng tuần, bạn n&ecirc;n tập trung cải thiện từng kỹ năng một, kết hợp xen kẽ để tr&aacute;nh nh&agrave;m ch&aacute;n. Việc lu&acirc;n phi&ecirc;n giữa c&aacute;c kỹ năng kh&ocirc;ng chỉ gi&uacute;p bạn duy tr&igrave; cảm hứng, m&agrave; c&ograve;n ph&aacute;t triển to&agrave;n diện c&aacute;c năng lực cần thiết cho kỳ thi thật.</p>\r\n\r\n<p><strong>V&iacute; dụ:</strong></p>\r\n\r\n<ul>\r\n	<li><strong>Listening:</strong>&nbsp;Mỗi ng&agrave;y nghe 1 đoạn Cambridge, ch&eacute;p ch&iacute;nh tả, luyện nghe chi tiết &ndash; tổng hợp c&aacute;c dạng đề thường gặp.</li>\r\n	<li><strong>Reading:</strong>&nbsp;Đọc 1 b&agrave;i/ ng&agrave;y, highlight keyword, luyện&nbsp;<a href=\"https://vietop.edu.vn/blog/ky-nang-scanning-va-skimming-trong-ielts-reading/\" target=\"_blank\">scanning/ skimming</a>, ghi ch&uacute;&nbsp;<a href=\"https://vietop.edu.vn/blog/paraphrasing-in-ielts-reading/\" target=\"_blank\">paraphrase</a>&nbsp;thường gặp.</li>\r\n	<li><strong>Speaking:</strong>&nbsp;Tự ghi &acirc;m trả lời c&acirc;u hỏi theo chủ đề, nghe lại, so s&aacute;nh với c&acirc;u trả lời mẫu, luyện &ldquo;shadowing&rdquo; n&acirc;ng ph&aacute;t &acirc;m.</li>\r\n	<li><strong>Writing:</strong>&nbsp;Ph&acirc;n t&iacute;ch đề, đọc b&agrave;i mẫu, luyện viết outline &ndash; mở b&agrave;i, overview (<a href=\"https://vietop.edu.vn/ielts-writing-sample/ielts-writing-task-1-academic/\" target=\"_blank\">Task 1</a>), bố cục luận điểm r&otilde; r&agrave;ng (<a href=\"https://vietop.edu.vn/ielts-writing-sample/ielts-writing-task-2-academic/\" target=\"_blank\">Task 2</a>).</li>\r\n</ul>\r\n\r\n<p>Mỗi tuần, n&ecirc;n c&oacute; 1&ndash;2 buổi tự kiểm tra tiến độ, đối chiếu với mục ti&ecirc;u ban đầu. Việc kiểm tra đều đặn sẽ gi&uacute;p bạn kịp thời điều chỉnh chiến lược nếu ph&aacute;t hiện phần n&agrave;o đang chững lại hoặc tiến bộ chậm.</p>\r\n\r\n<h3><strong>3.3. Giai đoạn 3: Thực h&agrave;nh đề thật, tự chấm v&agrave; sửa lỗi</strong></h3>\r\n\r\n<p>Khi đ&atilde; luyện vững kỹ năng, h&atilde;y tập trung l&agrave;m đề full, m&ocirc; phỏng ph&ograve;ng thi thật để kiểm tra tiến bộ v&agrave; r&egrave;n t&acirc;m l&yacute; vững.</p>\r\n\r\n<p>Đ&acirc;y l&agrave; l&uacute;c bạn cần thử th&aacute;ch bản th&acirc;n để kiểm tra lại hiệu quả tự học v&agrave; l&agrave;m quen với &aacute;p lực thời gian, tr&aacute;nh bị ngợp trong ph&ograve;ng thi thật.</p>\r\n\r\n<p><strong>Mẹo tự học n&acirc;ng điểm:</strong></p>\r\n\r\n<ul>\r\n	<li>L&agrave;m đề Cambridge, bấm giờ, kh&ocirc;ng tra cứu từ điển trong qu&aacute; tr&igrave;nh l&agrave;m b&agrave;i.</li>\r\n	<li>Sau khi l&agrave;m xong, đối chiếu đ&aacute;p &aacute;n, ghi ch&uacute; lỗi, đặc biệt lưu &yacute; lỗi lặp đi lặp lại.</li>\r\n	<li>Tự sửa b&agrave;i Speaking/ Writing: d&ugrave;ng app AI, website chấm b&agrave;i online hoặc nhờ bạn học sửa ch&eacute;o.</li>\r\n	<li>Lập bảng checklist lỗi c&aacute; nh&acirc;n, &ocirc;n lại h&agrave;ng tuần để xử l&yacute; kỹ c&aacute;c lỗi nhỏ.</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:&nbsp;</strong>Sau khi l&agrave;m 3 đề Writing Task 1, bạn nhận ra m&igrave;nh mi&ecirc;u tả số liệu tr&ecirc;n biểu đồ đường chưa r&otilde; r&agrave;ng, hoặc d&ugrave;ng sai cấu tr&uacute;c so s&aacute;nh &ndash; h&atilde;y ghi ch&uacute; lại v&agrave; luyện lại chỉ phần đ&oacute; trong 2&ndash;3 ng&agrave;y.</p>\r\n\r\n<p>Bạn đừng qu&ecirc;n rằng, mỗi lần tự l&agrave;m đề v&agrave; sửa lỗi l&agrave; một lần bạn tiến gần hơn tới band điểm mơ ước. Khi đ&atilde; &ldquo;vượt qua&rdquo; c&aacute;c lỗi cũ, bạn sẽ cảm nhận r&otilde; sự tiến bộ trong kỹ năng l&agrave;m b&agrave;i lẫn t&acirc;m l&yacute; ph&ograve;ng thi.</p>\r\n\r\n<h2><strong>4. C&aacute;ch duy tr&igrave; động lực trong lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học</strong></h2>\r\n\r\n<p>Một trong những th&aacute;ch thức lớn nhất của việc luyện IELTS cho người th&iacute;ch tự học l&agrave; duy tr&igrave; th&oacute;i quen đều đặn v&agrave; giữ vững động lực khi kh&ocirc;ng c&oacute; ai nhắc nhở.</p>\r\n\r\n<p>Nhiều bạn &ldquo;tuột mood&rdquo; sau v&agrave;i tuần học nếu kh&ocirc;ng tạo được th&oacute;i quen hoặc kh&ocirc;ng nh&igrave;n thấy kết quả r&otilde; r&agrave;ng. V&igrave; vậy, việc x&acirc;y dựng c&aacute;c chiến lược duy tr&igrave; động lực l&agrave; yếu tố sống c&ograve;n gi&uacute;p bạn bền bỉ đi đến đ&iacute;ch.</p>\r\n\r\n<p><img alt=\"Cách duy trì động lực trong lộ trình luyện IELTS cho người thích tự học\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/07/cach-duy-tri-dong-luc-trong-lo-trinh-luyen-ielts-cho-nguoi-thich-tu-hoc-1.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>C&aacute;ch duy tr&igrave; động lực trong lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học</p>\r\n\r\n<p><strong>C&aacute;ch duy tr&igrave; động lực hiệu quả:</strong></p>\r\n\r\n<ul>\r\n	<li>Đặt lịch học cố định trong ng&agrave;y (d&ugrave; chỉ 30&ndash;60 ph&uacute;t), tạo th&agrave;nh th&oacute;i quen.</li>\r\n	<li>Ghi ch&uacute; lại th&agrave;nh t&iacute;ch nhỏ mỗi ng&agrave;y (v&iacute; dụ: nghe hiểu th&ecirc;m 5 từ mới, ho&agrave;n th&agrave;nh 1 b&agrave;i Reading đ&uacute;ng 80%).</li>\r\n	<li>Khen thưởng bản th&acirc;n khi đạt mục ti&ecirc;u tuần/ th&aacute;ng (tự thưởng, đi chơi, mua s&aacute;ch&hellip;).</li>\r\n	<li>T&igrave;m bạn học &ndash; c&ugrave;ng chia sẻ lộ tr&igrave;nh, so s&aacute;nh tiến độ, tạo &aacute;p lực t&iacute;ch cực.</li>\r\n</ul>\r\n\r\n<p>Chỉ cần duy tr&igrave; được th&oacute;i quen n&agrave;y v&agrave;i tuần đầu, bạn sẽ tự tạo &ldquo;qu&aacute;n t&iacute;nh&rdquo; t&iacute;ch cực cho h&agrave;nh tr&igrave;nh chinh phục IELTS bằng tự học.</p>\r\n\r\n<p>Xem th&ecirc;m:</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://vietop.edu.vn/blog/hoc-y-nen-thi-ielts-hay-toeic/\" target=\"_blank\">Học Y n&ecirc;n thi IELTS hay TOEIC? Giải đ&aacute;p cho sinh vi&ecirc;n v&agrave; người l&agrave;m ng&agrave;nh Y</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/hoc-it-nen-hoc-toeic-hay-ielts/\" target=\"_blank\">Giải đ&aacute;p: &ldquo;Học IT n&ecirc;n học TOEIC hay IELTS&rdquo; để tối ưu cơ hội việc l&agrave;m hiện nay</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/lo-trinh-ielts-7-0-cap-toc-cho-sinh-vien-nam-cuoi/\" target=\"_blank\">Lộ tr&igrave;nh IELTS 7.0 cấp tốc cho sinh vi&ecirc;n năm cuối: 3 th&aacute;ng bứt ph&aacute; về đ&iacute;ch</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/lo-trinh-ielts-8-0-cho-nguoi-di-lam/\" target=\"_blank\">Lộ tr&igrave;nh IELTS 8.0 cho người đi l&agrave;m: Kế hoạch 8 th&aacute;ng đạt mục ti&ecirc;u band 8</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/lo-trinh-ielts-6-5-cho-nguoi-mat-goc/\" target=\"_blank\">Lộ tr&igrave;nh IELTS 6.5 cho người mất gốc trong 8 th&aacute;ng: Chi tiết từng tuần tự học tại nh&agrave;</a></li>\r\n</ul>\r\n\r\n<h2><strong>5. Những lỗi phổ biến cần tr&aacute;nh khi luyện IELTS cho người th&iacute;ch tự học</strong></h2>\r\n\r\n<p>D&ugrave; tự học gi&uacute;p chủ động nhưng cũng dễ &ldquo;mắc bẫy&rdquo; khiến điểm kh&ocirc;ng tăng, thậm ch&iacute; c&ograve;n l&agrave;m bạn bị mất động lực. Nhiều bạn &ldquo;vấp&rdquo; phải c&aacute;c lỗi quen thuộc m&agrave; kh&ocirc;ng nhận ra, khiến c&ocirc;ng sức bỏ ra kh&ocirc;ng tương xứng với kết quả.</p>\r\n\r\n<p>Để lộ tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học c&oacute; hiệu quả tốt nhất, bạn h&atilde;y chủ động ph&ograve;ng tr&aacute;nh những sai lầm dưới đ&acirc;y:</p>\r\n\r\n<p><strong>Lỗi thường gặp:</strong></p>\r\n\r\n<ul>\r\n	<li>Học lan man, kh&ocirc;ng c&oacute; mục ti&ecirc;u r&otilde; r&agrave;ng, chỉ l&agrave;m b&agrave;i &ldquo;cho xong&rdquo;.</li>\r\n	<li>Lưu qu&aacute; nhiều t&agrave;i liệu, kh&ocirc;ng luyện kỹ bất kỳ nguồn n&agrave;o.</li>\r\n	<li>Kh&ocirc;ng kiểm tra, đ&aacute;nh gi&aacute; lại tiến độ học n&ecirc;n kh&ocirc;ng biết m&igrave;nh đ&atilde; tiến bộ hay chưa.</li>\r\n	<li>Ngại sửa lỗi hoặc lười tự chấm b&agrave;i Writing/ Speaking, dẫn đến lặp lại lỗi cũ.</li>\r\n	<li>Dễ bỏ cuộc khi gặp kh&oacute; hoặc thấy điểm kh&ocirc;ng tăng ngay.</li>\r\n</ul>\r\n\r\n<p><strong>Mẹo khắc phục:</strong></p>\r\n\r\n<p>Lu&ocirc;n nh&igrave;n lại những mục ti&ecirc;u ban đầu m&agrave; bạn đ&atilde; đặt ra, chia nhỏ lộ tr&igrave;nh, thường xuy&ecirc;n tự kiểm tra v&agrave; điều chỉnh kế hoạch. Đừng ngại nhờ cộng đồng g&oacute;p &yacute; hoặc đổi phương ph&aacute;p nếu cảm thấy kh&ocirc;ng hiệu quả.</p>\r\n\r\n<p>Chủ động sửa lỗi v&agrave; điều chỉnh sẽ gi&uacute;p bạn duy tr&igrave; được &ldquo;sức bền&rdquo; trong h&agrave;nh tr&igrave;nh luyện IELTS cho người th&iacute;ch tự học, chạm tới band điểm mong muốn một c&aacute;ch chắc chắn hơn.</p>', 'uploads/posts/1761288373_thumbnail-luyen-ielts-cho-nguoi-thich-tu-hoc.jpg', 1, '2025-10-24 06:46:13', '2025-10-24 08:46:24', 'da_duyet', 2);
INSERT INTO `bai_viet` (`id_baiviet`, `tieu_de`, `noi_dung`, `hinh_anh_tieu_de`, `id_tac_gia`, `ngay_tao`, `ngay_duyet`, `trang_thai`, `luot_xem`) VALUES
(8, 'Làm sao để tăng điểm IELTS từ 6.0 lên 7.0 trong 3 tháng?', '<p>Việc tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 l&agrave; mục ti&ecirc;u phổ biến với nhiều người học &mdash; đặc biệt l&agrave; những ai cần điểm để du học, định cư hoặc n&acirc;ng hồ sơ tuyển dụng. Tuy nhi&ecirc;n, kh&ocirc;ng &iacute;t người rơi v&agrave;o t&igrave;nh trạng học m&atilde;i kh&ocirc;ng l&ecirc;n band, hoặc dậm ch&acirc;n ở 6.0 d&ugrave; đ&atilde; cố gắng rất nhiều.</p>\r\n\r\n<p>B&agrave;i viết n&agrave;y sẽ cung cấp cho bạn&nbsp;<strong>lộ tr&igrave;nh 3 th&aacute;ng</strong>&nbsp;để tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 một c&aacute;ch thực tế v&agrave; c&oacute; chiến lược. Bao gồm: ph&acirc;n t&iacute;ch sự kh&aacute;c biệt giữa hai band điểm, c&aacute;ch nhận diện kỹ năng yếu, phương ph&aacute;p luyện tập cụ thể từng th&aacute;ng, lỗi thường gặp v&agrave; c&aacute;ch sửa, cũng như c&aacute;ch duy tr&igrave; động lực học trong suốt h&agrave;nh tr&igrave;nh.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Nội dung quan trọng</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>&ndash; Tăng từ 6.0 l&ecirc;n 7.0 l&agrave; một bước &ldquo;vượt dốc&rdquo;</strong>: Đ&ograve;i hỏi bạn thay đổi c&aacute;ch học, ưu ti&ecirc;n chất lượng v&agrave; tư duy học thuật.<br />\r\n			<strong>&ndash; Cần chuẩn bị g&igrave; trước khi bắt đầu?</strong><br />\r\n			+ X&aacute;c định mục ti&ecirc;u r&otilde; r&agrave;ng, thời gian học thực tế mỗi tuần, v&agrave; kỹ năng yếu nhất.<br />\r\n			<strong>&ndash; Gợi &yacute; lộ tr&igrave;nh 4 giai đoạn linh hoạt</strong><br />\r\n			+ Giai đoạn 1: Kiểm tra đầu v&agrave;o v&agrave; x&aacute;c định lỗi thường gặp<br />\r\n			+ Giai đoạn 2: Luyện từng kỹ năng theo tuần<br />\r\n			+ Giai đoạn 3: Luyện đề t&iacute;ch hợp, m&ocirc; phỏng thi thật<br />\r\n			+ Giai đoạn 4: Ổn định t&acirc;m l&yacute; v&agrave; giữ phong độ trước ng&agrave;y thi<br />\r\n			<strong>&ndash; Những lỗi khiến bạn m&atilde;i ở band 6.0 (v&agrave; c&aacute;ch xử l&yacute;)</strong><br />\r\n			+ L&agrave;m đề nhưng kh&ocirc;ng sửa &rarr; lặp lại lỗi<br />\r\n			+ Writing thiếu lập luận r&otilde; r&agrave;ng, v&iacute; dụ ngh&egrave;o<br />\r\n			+ Kh&ocirc;ng nhận diện được paraphrase trong Reading &amp; Listening<br />\r\n			+ Speaking ngắn, lặp từ, kh&ocirc;ng mở rộng<br />\r\n			<strong>&ndash; Duy tr&igrave; động lực khi học d&agrave;i hạn</strong><br />\r\n			+ Tập trung v&agrave;o qu&aacute; tr&igrave;nh thay v&igrave; điểm số<br />\r\n			+ Thiết lập lịch học cố định v&agrave; theo d&otilde;i tiến độ<br />\r\n			+ Đặt mục ti&ecirc;u nhỏ, cụ thể v&agrave; c&oacute; hệ thống phản hồi<br />\r\n			+ Nếu cần, c&oacute; thể học theo lộ tr&igrave;nh tại Vietop để kh&ocirc;ng học một m&igrave;nh<br />\r\n			<strong>&ndash; N&acirc;ng cấp kỹ năng nền để đạt tư duy band 7.0</strong><br />\r\n			+ Reading: Hiểu s&acirc;u hơn, ph&acirc;n t&iacute;ch logic đoạn văn<br />\r\n			+ Listening: Nghe chủ động, nhận diện cấu tr&uacute;c v&agrave; bẫy n&oacute;i<br />\r\n			+ Writing: Viết c&oacute; chiều s&acirc;u, d&ugrave;ng cấu tr&uacute;c học thuật<br />\r\n			+ Speaking: Mở rộng &yacute;, tr&aacute;nh lặp, diễn đạt tự nhi&ecirc;n hơn</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2><strong>1. Band 6.0 v&agrave; Band 7.0 kh&aacute;c nhau như thế n&agrave;o?</strong></h2>\r\n\r\n<p>Để tăng điểm IELTS từ 6.0 l&ecirc;n 7.0, bạn cần hiểu r&otilde; điều g&igrave; khiến một th&iacute; sinh dừng lại ở band 6.0, v&agrave; điều g&igrave; tạo n&ecirc;n sự kh&aacute;c biệt ở band 7.0.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Kỹ năng</strong></td>\r\n			<td><strong>Band 6.0</strong></td>\r\n			<td><strong>Band 7.0</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong><a href=\"https://vietop.edu.vn/tu-hoc-ielts/reading/\" target=\"_blank\">Reading</a></strong></td>\r\n			<td>Hiểu được th&ocirc;ng tin ch&iacute;nh nhưng dễ sai chi tiết, chưa vững trong việc nhận diện c&aacute;c c&aacute;ch paraphrase của đề</td>\r\n			<td>Hiểu r&otilde; c&aacute;c &yacute; ch&iacute;nh v&agrave; c&aacute;c &yacute; nhỏ, nhận diện tốt từ vựng học thuật v&agrave; c&aacute;c c&aacute;ch paraphrase của đề</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong><a href=\"https://vietop.edu.vn/tu-hoc-ielts/listening/\" target=\"_blank\">Listening</a></strong></td>\r\n			<td>Nghe hiểu được nội dung chung nhưng dễ bỏ s&oacute;t chi tiết hoặc từ nối logic</td>\r\n			<td>Nghe kỹ, note được keyword, nắm mạch b&agrave;i r&otilde; r&agrave;ng</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong><a href=\"https://vietop.edu.vn/tu-hoc-ielts/writing/\" target=\"_blank\">Writing</a></strong></td>\r\n			<td>Viết đ&uacute;ng đề nhưng chưa chặt chẽ, từ vựng v&agrave; ngữ ph&aacute;p c&ograve;n đơn giản</td>\r\n			<td>Triển khai &yacute; r&otilde; r&agrave;ng, kết nối mượt, d&ugrave;ng ngữ ph&aacute;p linh hoạt</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong><a href=\"https://vietop.edu.vn/tu-hoc-ielts/speaking/\" target=\"_blank\">Speaking</a></strong></td>\r\n			<td>C&oacute; thể giao tiếp nhưng trả lời ngắn, thiếu chiều s&acirc;u</td>\r\n			<td>Tr&igrave;nh b&agrave;y r&otilde; r&agrave;ng, mở rộng hợp l&yacute;, từ vựng đa dạng hơn</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><strong>T&oacute;m lại</strong>: Để tăng điểm IELTS từ 6.0 l&ecirc;n 7.0, bạn kh&ocirc;ng cần học lại từ đầu, m&agrave; bạn cần n&acirc;ng cấp khả năng ph&acirc;n t&iacute;ch, diễn đạt logic v&agrave; phản xạ ng&ocirc;n ngữ.</p>\r\n\r\n<h2><strong>2. Lộ tr&igrave;nh 3 th&aacute;ng tăng điểm IELTS từ 6.0 l&ecirc;n 7.0</strong></h2>\r\n\r\n<p>Kh&ocirc;ng phải ai cũng c&oacute; thể học theo lịch cố định từng th&aacute;ng. Với những bạn c&oacute; lịch học thay đổi, l&agrave;m việc giờ h&agrave;nh ch&iacute;nh hoặc chỉ c&oacute; thể học v&agrave;o buổi tối, lộ tr&igrave;nh chia theo giai đoạn sẽ linh hoạt v&agrave; dễ duy tr&igrave; hơn. Dưới đ&acirc;y l&agrave; m&ocirc; h&igrave;nh học được nhiều học vi&ecirc;n &aacute;p dụng th&agrave;nh c&ocirc;ng khi muốn tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 một c&aacute;ch b&agrave;i bản, kh&ocirc;ng đốt sức.</p>\r\n\r\n<p><img alt=\"Lộ trình 3 tháng tăng điểm IELTS từ 6.0 lên 7.0\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/05/lo-trinh-3-thang-tang-diem-ielts-tu-6-0-len-7-0.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>Lộ tr&igrave;nh 3 th&aacute;ng tăng điểm IELTS từ 6.0 l&ecirc;n 7.0</p>\r\n\r\n<h3><strong>2.1. Giai đoạn 1: Khởi động &amp; đ&aacute;nh gi&aacute; (1 tuần)</strong></h3>\r\n\r\n<p>Đ&acirc;y l&agrave; tuần quan trọng để bạn x&aacute;c định xuất ph&aacute;t điểm thực sự của m&igrave;nh. Nhiều người đ&aacute;nh gi&aacute; sai năng lực hiện tại dẫn đến học sai hướng &mdash; điều n&agrave;y khiến bạn mất th&ecirc;m v&agrave;i tuần m&agrave; kh&ocirc;ng thấy tiến bộ.</p>\r\n\r\n<p><strong>Việc cần l&agrave;m:</strong></p>\r\n\r\n<ul>\r\n	<li>L&agrave;m 1 đề thi đủ 4 kỹ năng &rarr; c&oacute; thể d&ugrave;ng đề Cambridge 16&ndash;18</li>\r\n	<li>Ghi lại điểm từng kỹ năng, v&agrave; nhận x&eacute;t kh&aacute;ch quan (v&iacute; dụ: thiếu từ nối trong Writing, mất &yacute; ch&iacute;nh khi nghe Section 3&hellip;)</li>\r\n	<li>Tự trả lời: M&igrave;nh đang yếu kỹ năng n&agrave;o nhất? Dạng b&agrave;i n&agrave;o hay sai nhất?</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:</strong>&nbsp;Nếu bạn chỉ đạt 5.5 ở kỹ năng Listening v&agrave; thường sai c&aacute;c c&acirc;u dạng&nbsp;<a href=\"https://vietop.edu.vn/blog/cach-lam-dang-bai-multiple-choice/\" target=\"_blank\">Multiple Choice</a>, đ&acirc;y sẽ l&agrave; phần cần tập trung trong giai đoạn 2.</p>\r\n\r\n<h3><strong>2.2. Giai đoạn 2: Học theo kỹ năng (4&ndash;5 tuần)</strong></h3>\r\n\r\n<p>Khi đ&atilde; quen với cấu tr&uacute;c đề v&agrave; dạng b&agrave;i, đ&acirc;y l&agrave; l&uacute;c bạn bắt đầu luyện đề thật với tư duy chiến lược. Kh&ocirc;ng phải l&agrave;m c&agrave;ng nhiều c&agrave;ng tốt &mdash; m&agrave; l&agrave; l&agrave;m đ&uacute;ng, ph&acirc;n t&iacute;ch kỹ, v&agrave; r&uacute;t ra b&agrave;i học sau mỗi đề.</p>\r\n\r\n<p>Mỗi tuần bạn tập trung chuy&ecirc;n s&acirc;u v&agrave;o 1 kỹ năng. Việc học đơn tuyến gi&uacute;p n&atilde;o bộ xử l&yacute; v&agrave; cải thiện hiệu quả hơn, đặc biệt khi cần tăng từ 6.0 l&ecirc;n 7.0 &mdash; vốn l&agrave; đoạn &ldquo;nước r&uacute;t&rdquo; quan trọng.</p>\r\n\r\n<p><strong>Tuần 1 &ndash; Reading:</strong></p>\r\n\r\n<ul>\r\n	<li>Học lại c&aacute;ch skim &amp; scan hiệu quả</li>\r\n	<li>Luyện dạng&nbsp;<a href=\"https://vietop.edu.vn/blog/true-false-not-given-ielts-reading/\" target=\"_blank\">T/F/NG</a>,&nbsp;<a href=\"https://vietop.edu.vn/blog/matching-headings-ielts-reading/\" target=\"_blank\">Matching Headings</a></li>\r\n	<li>L&agrave;m 3 b&agrave;i Reading &rarr; ph&acirc;n t&iacute;ch lỗi, thống k&ecirc; từ vựng paraphrase</li>\r\n</ul>\r\n\r\n<p><strong>Tuần 2 &ndash; Listening:</strong></p>\r\n\r\n<ul>\r\n	<li>Nghe 1 b&agrave;i/ ng&agrave;y &rarr; ghi keyword &rarr; đối chiếu transcript</li>\r\n	<li>Tập trung Section 3&ndash;4 (nơi dễ mất điểm nhất)</li>\r\n	<li>Tổng hợp dạng c&acirc;u hỏi hay sai: MCQ,&nbsp;<a href=\"https://vietop.edu.vn/blog/ielts-listening-form-completion/\" target=\"_blank\">form completion</a>&hellip;</li>\r\n</ul>\r\n\r\n<p><strong>Tuần 3 &ndash; Writing:</strong></p>\r\n\r\n<ul>\r\n	<li>&Ocirc;n lại bố cục b&agrave;i Task 2 (Intro &rarr; 2 body &rarr; conclusion)</li>\r\n	<li>Viết 2 b&agrave;i/tuần, tự chấm theo ti&ecirc;u ch&iacute; public band descriptors</li>\r\n	<li>Ghi ch&eacute;p lại lỗi c&aacute; nh&acirc;n (ngữ ph&aacute;p, từ lặp, thiếu v&iacute; dụ)</li>\r\n</ul>\r\n\r\n<p><strong>Tuần 4 &ndash; Speaking:</strong></p>\r\n\r\n<ul>\r\n	<li>Chọn 5 topic phổ biến &rarr; luyện Part 2 + 3</li>\r\n	<li>Ghi &acirc;m &rarr; nghe lại &rarr; sửa lỗi d&ugrave;ng từ + c&aacute;ch triển khai</li>\r\n	<li>Luyện cụm mở đầu (framing), chuyển &yacute;, v&agrave; mở rộng</li>\r\n</ul>\r\n\r\n<p><strong>Tuần 5 (nếu c&oacute;):</strong></p>\r\n\r\n<ul>\r\n	<li>&Ocirc;n lại lỗi phổ biến đ&atilde; ghi trong 4 tuần</li>\r\n	<li>L&agrave;m 1 đề tổng hợp nhẹ để kiểm tra độ tiến bộ</li>\r\n</ul>\r\n\r\n<h3><strong>2.3. Giai đoạn 3: T&iacute;ch hợp &amp; luyện đề (3 tuần)</strong></h3>\r\n\r\n<p>Sau khi đ&atilde; luyện tập từng kỹ năng ri&ecirc;ng lẻ, đ&acirc;y l&agrave; l&uacute;c bạn cần gh&eacute;p c&aacute;c kỹ năng lại để m&ocirc; phỏng &aacute;p lực thi thật v&agrave; ph&aacute;t hiện điểm yếu c&ograve;n s&oacute;t.</p>\r\n\r\n<p><strong>Việc cần l&agrave;m:</strong></p>\r\n\r\n<ul>\r\n	<li>Mỗi tuần thi thử 1 đề đủ 4 kỹ năng</li>\r\n	<li>Thời gian l&agrave;m b&agrave;i s&aacute;t với thực tế</li>\r\n	<li>Sau mỗi đề &rarr; ph&acirc;n t&iacute;ch kỹ c&aacute;c c&acirc;u sai, điểm chưa chắc</li>\r\n	<li>Với Writing: So s&aacute;nh b&agrave;i viết với b&agrave;i mẫu band 7+ &rarr; t&igrave;m điểm kh&aacute;c biệt</li>\r\n</ul>\r\n\r\n<p>V&iacute; dụ: Bạn viết &ldquo;I think technology is good&rdquo; &rarr; trong b&agrave;i mẫu l&agrave; &ldquo;Technological advances have significantly enhanced human productivity.&rdquo;<br />\r\n&rarr; Thiếu academic tone &rarr; cần n&acirc;ng cấp vốn từ học thuật + cấu tr&uacute;c</p>\r\n\r\n<h3><strong>2.4. Giai đoạn 4: Chuẩn bị t&acirc;m l&yacute; thi (1 tuần)</strong></h3>\r\n\r\n<p>Tuần cuối kh&ocirc;ng n&ecirc;n nhồi nh&eacute;t kiến thức. Đ&acirc;y l&agrave; thời điểm để bạn giữ tinh thần ổn định, kiểm so&aacute;t thời gian v&agrave; chuẩn bị trạng th&aacute;i tốt nhất cho ng&agrave;y thi.</p>\r\n\r\n<p><strong>Việc n&ecirc;n l&agrave;m:</strong></p>\r\n\r\n<ul>\r\n	<li>Mỗi ng&agrave;y luyện 1 kỹ năng nhẹ &rarr; kh&ocirc;ng qu&aacute; &aacute;p lực</li>\r\n	<li>L&agrave;m lại đề cũ &rarr; kiểm tra xem lỗi cũ c&ograve;n lặp lại kh&ocirc;ng</li>\r\n	<li>Ngủ đủ giấc, ăn uống ổn định, giảm stress</li>\r\n</ul>\r\n\r\n<p><strong>Gợi &yacute;:&nbsp;</strong>D&agrave;nh ri&ecirc;ng 1 buổi để l&agrave;m Speaking mock test với bạn học hoặc gi&aacute;o vi&ecirc;n. Trong buổi n&agrave;y, bạn c&oacute; thể vừa l&agrave;m mock test (trả lời c&aacute;c c&acirc;u hỏi trong b&agrave;i thi) hoặc bạn c&oacute; thể tr&ograve; chuyện bằng tiếng Anh một c&aacute;ch nhẹ nh&agrave;ng với bạn học hoặc gi&aacute;o vi&ecirc;n của bạn.</p>\r\n\r\n<p>=&gt; Lộ tr&igrave;nh học linh hoạt gi&uacute;p bạn kh&ocirc;ng bị qu&aacute; tải m&agrave; vẫn đảm bảo hiệu quả. Với c&aacute;ch tiếp cận từng kỹ năng một c&aacute;ch tập trung, sau đ&oacute; gh&eacute;p lại v&agrave; m&ocirc; phỏng thực tế, bạn ho&agrave;n to&agrave;n c&oacute; thể&nbsp;<strong>tăng điểm IELTS từ 6.0 l&ecirc;n 7.0</strong>&nbsp;trong 3 th&aacute;ng &mdash; kể cả khi lịch học của bạn kh&ocirc;ng cố định.</p>\r\n\r\n<h2><strong>3. Những lỗi thường khiến bạn m&atilde;i kẹt ở band 6.0</strong></h2>\r\n\r\n<p>Nhiều người luyện thi rất chăm, l&agrave;m đề li&ecirc;n tục, nhưng band điểm vẫn dừng lại ở 6.0. Kh&ocirc;ng phải v&igrave; thiếu năng lực &mdash; m&agrave; v&igrave;&nbsp;<strong>học chưa đ&uacute;ng c&aacute;ch hoặc mắc lại những lỗi cơ bản</strong>&nbsp;m&agrave; kh&ocirc;ng nhận ra.</p>\r\n\r\n<p>Dưới đ&acirc;y l&agrave; những lỗi phổ biến nhất m&agrave; người học thường gặp tr&ecirc;n h&agrave;nh tr&igrave;nh tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 &mdash; v&agrave; c&aacute;ch xử l&yacute; dứt điểm để kh&ocirc;ng mắc lại lần sau.</p>\r\n\r\n<h3><strong>3.1. L&agrave;m đề li&ecirc;n tục nhưng kh&ocirc;ng sửa b&agrave;i</strong></h3>\r\n\r\n<p>Bạn l&agrave;m 2&ndash;3 đề Reading mỗi tuần, hoặc l&agrave;m b&agrave;i Listening hằng ng&agrave;y, nhưng kh&ocirc;ng bao giờ ghi lại lỗi sai. Hậu quả l&agrave; bạn&nbsp;<strong>lặp lại sai lầm cũ</strong>, kh&ocirc;ng cải thiện kỹ năng nhận diện bẫy, v&agrave; band điểm bị &ldquo;kẹt cứng&rdquo;.</p>\r\n\r\n<p><strong>Biểu hiện thường thấy:</strong></p>\r\n\r\n<ul>\r\n	<li>Sai những c&acirc;u giống nhau qua nhiều đề</li>\r\n	<li>Kh&ocirc;ng nhớ tại sao m&igrave;nh chọn đ&aacute;p &aacute;n đ&oacute;</li>\r\n	<li>L&agrave;m đề xong l&agrave;&hellip; qu&ecirc;n lu&ocirc;n</li>\r\n</ul>\r\n\r\n<p><strong>Giải ph&aacute;p:</strong></p>\r\n\r\n<ul>\r\n	<li>Mỗi lần l&agrave;m đề &rarr; d&agrave;nh &iacute;t nhất 15 ph&uacute;t để sửa chi tiết</li>\r\n	<li>Ghi ch&uacute; từng c&acirc;u sai: sai v&igrave; l&yacute; do g&igrave; (từ vựng? bẫy paraphrase? hiểu sai c&acirc;u hỏi?)</li>\r\n	<li>Lập sổ tay lỗi c&aacute; nh&acirc;n theo dạng c&acirc;u hỏi hoặc dạng b&agrave;i</li>\r\n</ul>\r\n\r\n<h3><strong>3.2. Writing kh&ocirc;ng c&oacute; lập luận r&otilde; r&agrave;ng, thiếu v&iacute; dụ</strong></h3>\r\n\r\n<p>B&agrave;i viết c&oacute; vẻ đủ độ d&agrave;i, đ&uacute;ng bố cục, nhưng&nbsp;<strong>&yacute; kh&ocirc;ng r&otilde; r&agrave;ng</strong>, hoặc đưa ra &yacute; m&agrave; kh&ocirc;ng giải th&iacute;ch hay chứng minh cụ thể. Điều n&agrave;y khiến b&agrave;i viết &ldquo;c&oacute; vẻ ổn&rdquo; nhưng gi&aacute;m khảo kh&ocirc;ng thể cho điểm cao v&igrave; thiếu logic.</p>\r\n\r\n<p><strong>V&iacute; dụ lỗi thường gặp:</strong></p>\r\n\r\n<p>&ldquo;Education is important so the government should spend more on it.&rdquo;<br />\r\n&rarr; Kh&ocirc;ng r&otilde; tại sao &ldquo;important&rdquo;, cũng kh&ocirc;ng c&oacute; v&iacute; dụ cụ thể.</p>\r\n\r\n<p><strong>Giải ph&aacute;p:</strong></p>\r\n\r\n<ul>\r\n	<li>Mỗi đoạn văn th&acirc;n b&agrave;i cần c&oacute; một cấu tr&uacute;c, v&iacute; dụ: Point (<em>luận điểm</em>) &ndash; Explain (<em>giải th&iacute;ch</em>) &ndash; Example (<em>v&iacute; dụ</em>) &ndash; Link (<em>li&ecirc;n kết lại với luận điểm</em>)</li>\r\n	<li>Tập viết đoạn văn body theo mẫu n&agrave;y &rarr; kiểm tra lại flow logic</li>\r\n</ul>\r\n\r\n<p>Sửa theo hướng band 7.0:<br />\r\n&ldquo;Investing in education is essential because it directly impacts a country&rsquo;s long-term economic growth. For example, countries like Finland and South Korea have seen improvements in innovation after increasing public funding for education.&rdquo;</p>\r\n\r\n<p>(<em>Đầu tư v&agrave;o gi&aacute;o dục l&agrave; một việc cần thiết v&igrave; n&oacute; ảnh hưởng trực tiếp tới sự ph&aacute;t triển kinh tế l&acirc;u d&agrave;i của một quốc gia. V&iacute; dụ, c&aacute;c nước như Phần Lan v&agrave; H&agrave;n Quốc đ&atilde; c&oacute; sự ph&aacute;t triển trong sự s&aacute;ng tạo sau khi tăng chi ti&ecirc;u cho gi&aacute;o dục.</em>)</p>\r\n\r\n<p>=&gt; Cấu tr&uacute;c r&otilde; r&agrave;ng, c&oacute; lập luận v&agrave; v&iacute; dụ x&aacute;c thực &rarr; tăng điểm r&otilde; rệt ở ti&ecirc;u ch&iacute; Task Response v&agrave;&nbsp;<a href=\"https://vietop.edu.vn/blog/coherence-va-cohesion-trong-ielts-writing/\" target=\"_blank\">Coherence</a>.</p>\r\n\r\n<h3><strong>3.3. Nhận diện Paraphrase k&eacute;m, dễ bị &ldquo;bẫy&rdquo; trong Reading v&agrave; Listening</strong></h3>\r\n\r\n<p>Bạn hiểu từ gốc trong c&acirc;u hỏi, nhưng kh&ocirc;ng nhận ra khi n&oacute; xuất hiện dưới dạng&nbsp;<a href=\"https://vietop.edu.vn/blog/paraphrasing-in-ielts-reading/\">p</a><a href=\"https://vietop.edu.vn/blog/paraphrasing-in-ielts-reading/\" target=\"_blank\">a</a><a href=\"https://vietop.edu.vn/blog/paraphrasing-in-ielts-reading/\">raphrase</a>&nbsp;trong b&agrave;i &rarr; dẫn đến chọn sai đ&aacute;p &aacute;n.</p>\r\n\r\n<p><strong>V&iacute; dụ lỗi phổ biến:</strong></p>\r\n\r\n<ul>\r\n	<li>C&acirc;u hỏi: &ldquo;The process was completed in 1987.&rdquo;</li>\r\n	<li>B&agrave;i đọc: &ldquo;By the end of the 1980s, the final phase had concluded.&rdquo;<br />\r\n	&rarr; Kh&ocirc;ng nhận ra đ&acirc;y l&agrave; paraphrase &rarr; chọn sai</li>\r\n</ul>\r\n\r\n<p><strong>Giải ph&aacute;p:&nbsp;</strong></p>\r\n\r\n<ul>\r\n	<li>Mỗi khi l&agrave;m đề Reading/ Listening &rarr; highlight từ bị paraphrase</li>\r\n	<li>Sử dụng từ điển từ đồng nghĩa/ tr&aacute;i nghĩa khi luyện đề/ l&agrave;m b&agrave;i tập</li>\r\n</ul>\r\n\r\n<h3><strong>3.4. Speaking lặp từ, n&oacute;i ngắn, thiếu mở rộng</strong></h3>\r\n\r\n<p>Bạn c&oacute; thể trả lời được c&acirc;u hỏi, nhưng dừng lại qu&aacute; nhanh hoặc chỉ d&ugrave;ng từ đơn giản lặp đi lặp lại khiến b&agrave;i n&oacute;i thiếu chiều s&acirc;u v&agrave; kh&ocirc;ng c&oacute; điểm nhấn.</p>\r\n\r\n<p><strong>V&iacute; dụ trả lời band 6.0:</strong></p>\r\n\r\n<ul>\r\n	<li>Q: &ldquo;Do you prefer traveling alone or with others?&rdquo;&nbsp;<em>(Bạn th&iacute;ch đi du lịch một m&igrave;nh hơn hay th&iacute;ch đi với nhiều người kh&aacute;c hơn?)</em></li>\r\n	<li>A: &ldquo;I like traveling with others. It&rsquo;s more fun. I enjoy it.&rdquo;&nbsp;<em>(T&ocirc;i th&iacute;ch đi với những người kh&aacute;c hơn. N&oacute; vui hơn. T&ocirc;i th&iacute;ch vậy.)</em></li>\r\n</ul>\r\n\r\n<p><strong>Giải ph&aacute;p:</strong></p>\r\n\r\n<ul>\r\n	<li>Luyện cụm mở rộng c&acirc;u trả lời: &ldquo;The reason why&hellip; is that&hellip;&rdquo;, &ldquo;One example is&hellip;&rdquo;</li>\r\n	<li>Ghi &acirc;m b&agrave;i n&oacute;i, nghe lại &rarr; đ&aacute;nh dấu từ lặp + chỗ cần th&ecirc;m &yacute;</li>\r\n	<li>D&ugrave;ng flashcard cụm từ học thuật để đa dạng h&oacute;a vốn từ</li>\r\n</ul>\r\n\r\n<p>C&acirc;u trả lời band 7.0:<br />\r\n&ldquo;I prefer traveling with others because it creates shared memories and makes the experience more enjoyable. For example, my recent trip to Dalat with friends was filled with laughter and spontaneity, which I might not have had alone.&rdquo;&nbsp;</p>\r\n\r\n<p><em>(T&ocirc;i th&iacute;ch đi du lịch với nh&oacute;m hơn v&igrave; n&oacute; tạo ra những kỷ niệm chung v&agrave; l&agrave;m cho trải nghiệm đ&oacute; vui hơn. V&iacute; dụ, chuyến đi Đ&agrave; Lạt gần đ&acirc;y của t&ocirc;i với nh&oacute;m bạn tr&agrave;n đầy tiếng cười v&agrave; những l&uacute;c bất ngờ, c&aacute;i m&agrave; t&ocirc;i c&oacute; thể kh&ocirc;ng c&oacute; nếu t&ocirc;i đi một m&igrave;nh.)</em></p>\r\n\r\n<h2><strong>4. L&agrave;m sao duy tr&igrave; động lực học đều trong suốt h&agrave;nh tr&igrave;nh 3 th&aacute;ng?</strong></h2>\r\n\r\n<p>Một trong những l&yacute; do khiến nhiều người kh&ocirc;ng thể tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 kh&ocirc;ng nằm ở năng lực, m&agrave; ở&nbsp;<strong>sự thiếu ki&ecirc;n định</strong>. Họ bắt đầu rất quyết t&acirc;m, học dồn dập, nhưng sau 2&ndash;3 tuần lại mệt mỏi, ch&aacute;n nản, hoặc bỏ dở v&igrave; kh&ocirc;ng thấy tiến bộ ngay.</p>\r\n\r\n<p>Việc duy tr&igrave; được&nbsp;<strong>nhịp học đều, ổn định trong nhiều tuần</strong>&nbsp;l&agrave; yếu tố quyết định trong việc bạn c&oacute; đạt được band 7.0 hay kh&ocirc;ng. Dưới đ&acirc;y l&agrave; c&aacute;ch gi&uacute;p bạn giữ được tinh thần học đều m&agrave; kh&ocirc;ng kiệt sức:</p>\r\n\r\n<p><img alt=\"Cách duy trì động lực học đều trong hành trình 3 tháng\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/05/cach-duy-tri-dong-luc-hoc-deu-trong-suot-hanh-trinh-3-thang.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>C&aacute;ch duy tr&igrave; động lực học đều trong h&agrave;nh tr&igrave;nh 3 th&aacute;ng</p>\r\n\r\n<h3><strong>4.1. Tập trung v&agrave;o qu&aacute; tr&igrave;nh, kh&ocirc;ng phải điểm số</strong></h3>\r\n\r\n<p>Đừng kiểm tra điểm từng tuần v&agrave; lo lắng nếu chưa thấy tăng. Thay v&agrave;o đ&oacute;, h&atilde;y hỏi:</p>\r\n\r\n<ul>\r\n	<li>M&igrave;nh h&ocirc;m nay luyện được bao nhi&ecirc;u ph&uacute;t thật sự tập trung?</li>\r\n	<li>M&igrave;nh c&oacute; ph&aacute;t hiện lỗi n&agrave;o mới chưa?</li>\r\n	<li>M&igrave;nh đ&atilde; sửa lỗi sai cũ chưa?</li>\r\n</ul>\r\n\r\n<p>=&gt; Tiến bộ bền vững đến từ việc sửa lỗi + luyện tập đều, kh&ocirc;ng phải l&agrave; một con điểm cao trong 1 c&aacute;i đề cụ thể n&agrave;o đ&oacute;.</p>\r\n\r\n<h3><strong>4.2. Thiết lập khung giờ học cố định</strong></h3>\r\n\r\n<p>Thay v&igrave; đợi &ldquo;rảnh th&igrave; học&rdquo;, bạn n&ecirc;n cố định lịch học th&agrave;nh&nbsp;<strong>th&oacute;i quen giống việc ăn &ndash; ngủ</strong>. V&iacute; dụ:</p>\r\n\r\n<ul>\r\n	<li>Thứ 2 &ndash; 4 &ndash; 6: Listening + Speaking</li>\r\n	<li>Thứ 3 &ndash; 5: Reading + từ vựng</li>\r\n	<li>Thứ 7: Viết 1 b&agrave;i&nbsp;<a href=\"https://vietop.edu.vn/ielts-writing-sample/ielts-writing-task-2-academic/\" target=\"_blank\">Task 2</a>&nbsp;+ l&agrave;m 1 đề tổng hợp</li>\r\n</ul>\r\n\r\n<p>=&gt; Khi học c&oacute; giờ giấc r&otilde; r&agrave;ng, n&atilde;o bộ sẽ h&igrave;nh th&agrave;nh th&oacute;i quen, từ đ&oacute;, giảm xu hướng tr&igrave; ho&atilde;n.</p>\r\n\r\n<h3><strong>4.3. Theo d&otilde;i tiến độ bằng checklist c&aacute; nh&acirc;n</strong></h3>\r\n\r\n<p>Tạo bảng đơn giản gồm:</p>\r\n\r\n<ul>\r\n	<li>T&ecirc;n kỹ năng</li>\r\n	<li>Dạng b&agrave;i cần luyện</li>\r\n	<li>Cột đ&aacute;nh dấu: Đ&atilde; l&agrave;m &ndash; Đ&atilde; sửa &ndash; C&ograve;n lỗi g&igrave;?</li>\r\n</ul>\r\n\r\n<p>V&agrave; mỗi khi bạn xong một việc trong checklist, bạn đ&aacute;nh &ldquo;check&rdquo; xong việc đ&oacute;. Cảm gi&aacute;c đ&aacute;nh dấu một việc g&igrave; đ&oacute; l&agrave; xong sẽ gi&uacute;p bạn c&oacute; động lực tiếp tục.</p>\r\n\r\n<h3><strong>4.4. Đặt mục ti&ecirc;u cụ thể, thực tế, đo được</strong></h3>\r\n\r\n<p>Thay v&igrave; đặt mục ti&ecirc;u mơ hồ kiểu &ldquo;phải giỏi l&ecirc;n&rdquo;, h&atilde;y đặt c&aacute;c mục ti&ecirc;u như:</p>\r\n\r\n<ul>\r\n	<li>Viết 1 b&agrave;i Writing kh&ocirc;ng lỗi ngữ ph&aacute;p mỗi tuần</li>\r\n	<li>L&agrave;m đ&uacute;ng &ge;30/40 c&acirc;u Reading trong đề Cambridge 16 Test 2</li>\r\n	<li>N&oacute;i&nbsp;<a href=\"https://vietop.edu.vn/ielts-speaking-sample/ielts-speaking-part-2/\" target=\"_blank\">Speaking Part 2</a>&nbsp;đủ 2 ph&uacute;t kh&ocirc;ng bị khựng</li>\r\n</ul>\r\n\r\n<p>=&gt; Mục ti&ecirc;u r&otilde; r&agrave;ng = dễ đo tiến bộ = dễ c&oacute; động lực duy tr&igrave;.</p>\r\n\r\n<p>Kh&ocirc;ng c&oacute; động lực n&agrave;o tồn tại nếu bạn cứ học qu&aacute; tải rồi nản. Muốn tăng điểm IELTS từ 6.0 l&ecirc;n 7.0, bạn cần tạo được&nbsp;<strong>guồng học vừa sức, duy tr&igrave; đều đặn v&agrave; nh&igrave;n thấy sự cải thiện r&otilde; r&agrave;ng mỗi tuần</strong>.</p>\r\n\r\n<p>Nếu bạn vẫn thấy m&igrave;nh dễ mất tinh thần, h&atilde;y học theo nh&oacute;m, t&igrave;m người học c&ugrave;ng, hoặc nhận phản hồi định kỳ từ gi&aacute;o vi&ecirc;n/ mentor &mdash; v&igrave; đ&ocirc;i khi, chỉ một lời g&oacute;p &yacute; đ&uacute;ng l&uacute;c cũng đủ để bạn đi tiếp.</p>\r\n\r\n<p>Hoặc bạn c&oacute; thể tham gia kh&oacute;a học<a href=\"https://vietop.edu.vn/khoa-hoc/khoa-hoc-ielts-7-0/\">&nbsp;IELTS 7.0+ tại Vietop</a>, nơi bạn sẽ được hướng dẫn s&aacute;t sao theo lộ tr&igrave;nh c&aacute; nh&acirc;n ho&aacute;, c&oacute; gi&aacute;o vi&ecirc;n theo d&otilde;i tiến độ h&agrave;ng tuần, hỗ trợ sửa b&agrave;i kỹ năng, v&agrave; đặc biệt l&agrave; m&ocirc;i trường học gi&uacute;p bạn giữ được động lực bền vững đến ng&agrave;y thi.</p>\r\n\r\n<h2><strong>5. N&acirc;ng cấp kỹ năng nền để đạt IELTS band 7.0</strong></h2>\r\n\r\n<p>Đạt được band 6.0 chứng tỏ bạn đ&atilde; c&oacute; nền tảng giao tiếp tiếng Anh tương đối ổn định. Tuy nhi&ecirc;n, để tăng điểm IELTS từ 6.0 l&ecirc;n 7.0, bạn cần&nbsp;<strong>n&acirc;ng cấp tư duy học thuật</strong>, kh&ocirc;ng chỉ học mẹo l&agrave;m b&agrave;i hay ghi nhớ cấu tr&uacute;c.</p>\r\n\r\n<p>Điểm số cao hơn đ&ograve;i hỏi bạn hiểu s&acirc;u hơn, phản xạ nhanh hơn v&agrave; sử dụng ng&ocirc;n ngữ linh hoạt hơn trong cả 4 kỹ năng. Dưới đ&acirc;y l&agrave; c&aacute;ch bạn c&oacute; thể cải thiện từng kỹ năng từ &ldquo;đủ d&ugrave;ng&rdquo; sang &ldquo;c&oacute; chiều s&acirc;u&rdquo;:</p>\r\n\r\n<h3><strong>5.1. Reading &ndash; Tăng khả năng ph&acirc;n t&iacute;ch &amp; phản xạ nhận diện paraphrase</strong></h3>\r\n\r\n<p>Để tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 trong phần Reading, bạn cần vượt qua mức &ldquo;đọc để trả lời c&acirc;u hỏi&rdquo; v&agrave; luyện khả năng&nbsp;<strong>nhận diện &yacute; ch&iacute;nh, từ đồng nghĩa v&agrave; cấu tr&uacute;c ngữ nghĩa s&acirc;u hơn</strong>. Dưới đ&acirc;y l&agrave; c&aacute;c bước gi&uacute;p bạn l&agrave;m điều đ&oacute;:</p>\r\n\r\n<ul>\r\n	<li>Đừng chỉ &ldquo;skim &ndash; scan&rdquo; để t&igrave;m từ giống trong c&acirc;u hỏi. Band 7.0 y&ecirc;u cầu bạn hiểu &yacute; ngầm, logic đoạn văn, v&agrave; c&aacute;c mối quan hệ nh&acirc;n &ndash; quả, so s&aacute;nh, đối lập.</li>\r\n	<li>Luyện đọc theo chủ đề học thuật (science, society, environment&hellip;) để l&agrave;m quen từ vựng học thuật.</li>\r\n	<li>Mỗi tuần n&ecirc;n chọn 1 b&agrave;i đọc kh&oacute; &rarr; ph&acirc;n t&iacute;ch từng đoạn: main idea, chức năng đoạn, từ đồng nghĩa với c&acirc;u hỏi.</li>\r\n</ul>\r\n\r\n<p>V&iacute; dụ: &ldquo;a steady decline&rdquo; c&oacute; thể paraphrase th&agrave;nh &ldquo;a gradual decrease&rdquo; &rarr; nếu bạn kh&ocirc;ng nhận ra, rất dễ chọn sai trong c&acirc;u hỏi T/F/NG.</p>\r\n\r\n<h3><strong>5.2. Listening &ndash; Luyện bắt từ kh&oacute;a v&agrave; hiểu r&otilde; được nội dung b&agrave;i nghe</strong></h3>\r\n\r\n<p>IELTS Listening ở band 6.0 thường dừng lại ở việc &ldquo;nghe được nhưng kh&ocirc;ng chắc&rdquo;, c&ograve;n ở band 7.0 trở l&ecirc;n, bạn phải hiểu&nbsp;<strong>c&aacute;ch tổ chức th&ocirc;ng tin v&agrave; từ vựng được che giấu dưới dạng paraphrase</strong>. H&atilde;y &aacute;p dụng c&aacute;c phương ph&aacute;p sau để n&acirc;ng tầm kỹ năng nghe của bạn:</p>\r\n\r\n<ul>\r\n	<li>Tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 ở Listening phụ thuộc v&agrave;o việc&nbsp;<strong>nghe chủ động</strong>, kh&ocirc;ng phải &ldquo;nghe đo&aacute;n&rdquo;.</li>\r\n	<li>Tập trung luyện Section 3&ndash;4: nhiều bẫy paraphrase, tốc độ n&oacute;i nhanh, chứa quan điểm ngầm.</li>\r\n	<li>Nghe lại với transcript &rarr; highlight từ nối logic (however, in contrast, what I mean is&hellip;) để hiểu c&aacute;ch chuyển &yacute;.</li>\r\n</ul>\r\n\r\n<p>Mẹo: Khi bạn nghe &ldquo;The first option is cheaper, but I&rsquo;d say the second is more practical.&rdquo; &rarr; Nếu chỉ nghe từ &ldquo;cheaper&rdquo; m&agrave; kh&ocirc;ng để &yacute; phần sau, bạn sẽ chọn sai.</p>\r\n\r\n<h3><strong>5.3. Writing &ndash; Ph&aacute;t triển luận điểm sắc b&eacute;n v&agrave; ngữ ph&aacute;p linh hoạt</strong></h3>\r\n\r\n<p>IELTS Writing l&agrave; kỹ năng nhiều th&iacute; sinh &ldquo;ng&aacute;n&rdquo; nhất khi muốn tăng điểm IELTS từ 6.0 l&ecirc;n 7.0. Tuy nhi&ecirc;n, nếu bạn tập trung v&agrave;o việc&nbsp;<strong>viết c&oacute; chiều s&acirc;u v&agrave; kiểm so&aacute;t ngữ ph&aacute;p n&acirc;ng cao</strong>, th&igrave; Writing ch&iacute;nh l&agrave; phần dễ &ldquo;ăn điểm&rdquo; nhất. Dưới đ&acirc;y l&agrave; c&aacute;ch để đạt điều đ&oacute;:</p>\r\n\r\n<ul>\r\n	<li>Tập viết theo sơ đồ Point &ndash; Explain &ndash; Example &ndash; link để đoạn văn c&oacute; chiều s&acirc;u.</li>\r\n	<li>D&ugrave;ng đa dạng cấu tr&uacute;c c&acirc;u: mệnh đề quan hệ, bị động, c&acirc;u điều kiện, li&ecirc;n từ học thuật.</li>\r\n	<li>Tr&aacute;nh viết &ldquo;c&ocirc;ng thức&rdquo; v&agrave; những mẫu văn qu&aacute; chung chung (e.g. &ldquo;Nowadays, many people think that&hellip;&rdquo;).</li>\r\n</ul>\r\n\r\n<p>So s&aacute;nh:</p>\r\n\r\n<ul>\r\n	<li>Band 6.0: &ldquo;I think technology is important for education.&rdquo;</li>\r\n	<li>Band 7.0: &ldquo;Technological integration in classrooms can enhance student engagement and access to global knowledge.&rdquo;</li>\r\n</ul>', 'uploads/posts/1761288476_thumbnail-tang-diem-ielts-tu-6-0-len-7-0.jpg', 1, '2025-10-24 06:47:56', '2025-10-24 08:48:02', 'da_duyet', 2),
(9, 'Lộ trình luyện IELTS qua phim ảnh: Học tiếng Anh tự nhiên, tăng band điểm thật', '<p>Kh&ocirc;ng phải ngẫu nhi&ecirc;n m&agrave; lộ tr&igrave;nh luyện IELTS cho người học tiếng Anh qua phim ảnh trở th&agrave;nh &ldquo;trend&rdquo; với c&aacute;c bạn trẻ. Kh&aacute;c với kiểu học truyền thống, việc học tiếng Anh qua phim vừa tạo hứng th&uacute;, vừa gi&uacute;p bạn tiếp x&uacute;c với tiếng Anh thực tế &ndash; s&aacute;t với c&aacute;c t&igrave;nh huống giao tiếp đời thường.</p>\r\n\r\n<p>Đặc biệt, với những bạn ngại học qua gi&aacute;o tr&igrave;nh, dễ ch&aacute;n với b&agrave;i tập kh&ocirc; khan, th&igrave; lộ tr&igrave;nh luyện IELTS qua phim ảnh l&agrave; c&aacute;ch biến mỗi buổi luyện th&agrave;nh một trải nghiệm th&uacute; vị, dễ nhớ v&agrave; kh&oacute; bỏ dở. Bạn sẽ dễ d&agrave;ng bắt gặp cụm từ, ngữ điệu, mẫu c&acirc;u được &ldquo;t&aacute;i chế&rdquo; rất nhiều trong c&aacute;c đề thi Listening, Speaking thực tế.</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Nội dung quan trọng</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>&ndash;&nbsp;</strong>Lộ tr&igrave;nh luyện IELTS qua phim ảnh l&agrave; giải ph&aacute;p &ldquo;hai trong một&rdquo; d&agrave;nh cho những ai vừa muốn n&acirc;ng band IELTS vừa muốn giữ cảm hứng học từ phim, series, hoặc YouTube.<br />\r\n			&ndash; Tập trung khai th&aacute;c lợi thế học qua phim: tăng phản xạ nghe &ndash; n&oacute;i thực tế, mở rộng vốn từ, ghi nhớ cấu tr&uacute;c &ldquo;đời thường&rdquo;, v&agrave; luyện ph&aacute;t &acirc;m tự nhi&ecirc;n hơn so với s&aacute;ch vở.<br />\r\n			&ndash; Lộ tr&igrave;nh chia r&otilde; từng tuần, từng kỹ năng: luyện Listening với tr&iacute;ch đoạn phim, Speaking qua shadowing nh&acirc;n vật, Reading qua transcript v&agrave; phụ đề, Writing từ cảm hứng nội dung phim.<br />\r\n			&ndash; Tr&aacute;nh học &ldquo;thụ động&rdquo; kiểu chỉ xem cho vui m&agrave; kh&ocirc;ng ghi ch&uacute; từ vựng, kh&ocirc;ng luyện lại, hoặc kh&ocirc;ng kết nối nội dung phim với dạng b&agrave;i thi IELTS thực tế.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2><strong>1. C&aacute;ch chọn phim, series, hoặc k&ecirc;nh YouTube ph&ugrave; hợp để bắt đầu lộ tr&igrave;nh luyện IELTS</strong></h2>\r\n\r\n<p>Để khởi đầu lộ tr&igrave;nh luyện IELTS qua phim ảnh, quan trọng nhất l&agrave; chọn nguồn phim đ&uacute;ng tr&igrave;nh độ, ph&ugrave; hợp với mục ti&ecirc;u IELTS của bạn v&agrave; c&oacute; nội dung hấp dẫn để duy tr&igrave; động lực.</p>\r\n\r\n<p><img alt=\"Cách chọn phim, series, hoặc kênh YouTube phù hợp để bắt đầu lộ trình luyện IELTS \" src=\"https://vietop.edu.vn/wp-content/uploads/2025/07/cach-chon-phim-series-hoac-kenh-youtube-phu-hop-de-bat-dau-lo-trinh-luyen-ielts.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>C&aacute;ch chọn phim, series, hoặc k&ecirc;nh YouTube ph&ugrave; hợp để bắt đầu lộ tr&igrave;nh luyện IELTS</p>\r\n\r\n<p><strong>C&aacute;ch chọn phim/ k&ecirc;nh ph&ugrave; hợp:</strong></p>\r\n\r\n<ul>\r\n	<li>Ưu ti&ecirc;n phim, series c&oacute; phụ đề Anh &ndash; Việt (v&iacute; dụ: &ldquo;Friends&rdquo;, &ldquo;The Crown&rdquo;, &ldquo;Brooklyn Nine-Nine&rdquo;, &ldquo;Modern Family&rdquo;, &ldquo;The Social Dilemma&rdquo;&hellip;)</li>\r\n	<li>Tr&aacute;nh chọn phim fantasy, h&agrave;nh động qu&aacute; &ldquo;nặng&rdquo; hoặc sử dụng slang&nbsp;<em>(từ l&oacute;ng)</em>/ dialect&nbsp;<em>(giọng địa phương)</em>&nbsp;qu&aacute; nhiều, v&igrave; rất kh&oacute; nghe khi bạn chưa quen việc nghe tiếng Anh</li>\r\n	<li>K&ecirc;nh YouTube/ Netflix c&oacute; phụ đề chuẩn, nội dung đa dạng về chủ đề học thuật (TED-Ed, BBC Earth, Vox, v.v.)</li>\r\n	<li>B&aacute;m s&aacute;t chủ đề IELTS thường gặp: cuộc sống h&agrave;ng ng&agrave;y, gi&aacute;o dục, gia đ&igrave;nh, bạn b&egrave;, c&ocirc;ng việc, m&ocirc;i trường.</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:&nbsp;</strong>Bạn mới bắt đầu luyện Listening n&ecirc;n chọn c&aacute;c series sitcom c&oacute; tốc độ n&oacute;i chậm, từ vựng quen thuộc như &ldquo;Friends&rdquo; hoặc &ldquo;Brooklyn Nine-Nine&rdquo;, sau đ&oacute; n&acirc;ng dần l&ecirc;n c&aacute;c phim học thuật, documentary.</p>\r\n\r\n<h2><strong>2. X&acirc;y dựng lộ tr&igrave;nh luyện IELTS qua phim ảnh theo tuần &ndash; từng kỹ năng, từng mục ti&ecirc;u</strong></h2>\r\n\r\n<p>Để bạn c&oacute; thể tiến bộ r&otilde; rệt, v&agrave; kh&ocirc;ng thấy nản, bạn n&ecirc;n chia nhỏ lộ tr&igrave;nh luyện IELTS qua phim ảnh th&agrave;nh từng tuần, mỗi tuần tập trung ph&aacute;t triển một kỹ năng trọng t&acirc;m, kết hợp vừa giải tr&iacute; &ndash; vừa luyện thi thực chiến.</p>\r\n\r\n<p><img alt=\"Lộ trình luyện IELTS qua phim ảnh theo tuần\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/07/xay-dung-lo-trinh-luyen-ielts-qua-phim-anh-theo-tuan.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>Lộ tr&igrave;nh luyện IELTS qua phim ảnh theo tuần</p>\r\n\r\n<h3><strong>2.1. Tuần 1&ndash;2: Luyện Listening &ndash; tăng phản xạ nghe tự nhi&ecirc;n</strong></h3>\r\n\r\n<p>Trong 2 tuần đầu, mục ti&ecirc;u lớn nhất l&agrave; &ldquo;l&agrave;m quen tai&rdquo; với tiếng Anh tự nhi&ecirc;n, luyện nghe keyword, v&agrave; học c&aacute;ch nhận diện ph&aacute;t &acirc;m &ndash; ngữ điệu s&aacute;t thực tế.</p>\r\n\r\n<p><strong>C&aacute;c hoạt động n&ecirc;n l&agrave;m:</strong></p>\r\n\r\n<ul>\r\n	<li>Xem phim với phụ đề Anh, mỗi ng&agrave;y 1 đoạn 3&ndash;5 ph&uacute;t, tua lại nhiều lần đến khi nghe hiểu to&agrave;n bộ.</li>\r\n	<li>Gạch ch&acirc;n keyword, cụm từ, ph&aacute;t &acirc;m kh&oacute; trong transcript/phụ đề.</li>\r\n	<li>Luyện &ldquo;dictation&rdquo;: viết lại c&acirc;u nghe được, đối chiếu phụ đề, highlight lỗi m&igrave;nh hay sai.</li>\r\n	<li>Ch&uacute; &yacute; c&aacute;c &ldquo;real-life linking sounds&rdquo;&nbsp;<em>(từ nối được sử dụng trong giao tiếp thật)</em>, c&aacute;ch nuốt &acirc;m, nối &acirc;m, nhấn nh&aacute; giống trong đề&nbsp;<a href=\"https://vietop.edu.vn/tu-hoc-ielts/listening/\" target=\"_blank\">IELTS Listening</a>.</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:</strong></p>\r\n\r\n<p>Xem đoạn phim &ldquo;Modern Family&rdquo;, nghe c&acirc;u &ldquo;What are you up to?&rdquo; &ndash; note lại cấu tr&uacute;c, nghe lặp lại cho quen tai, sau đ&oacute; tự đặt 2&ndash;3 c&acirc;u d&ugrave;ng cấu tr&uacute;c n&agrave;y.</p>\r\n\r\n<p><strong>Sau 2 tuần</strong>, bạn sẽ thấy nghe phim &ldquo;dễ&rdquo; hơn, phản xạ nhận diện keyword, accent tốt hơn, kh&ocirc;ng c&ograve;n hoang mang khi nghe đề thật.</p>\r\n\r\n<h3><strong>2.2. Tuần 3: Luyện Speaking &ndash; shadowing v&agrave; bắt chước ngữ điệu nh&acirc;n vật</strong></h3>\r\n\r\n<p>Tuần 3 l&agrave; l&uacute;c bạn tận dụng phim để luyện Speaking, tăng phản xạ v&agrave; bắt chước ngữ điệu tự nhi&ecirc;n của người bản xứ. Đ&acirc;y l&agrave; bước chuyển gi&uacute;p Speaking kh&ocirc;ng c&ograve;n &ldquo;ngượng&rdquo;, giảm lỗi accent Việt, tăng sự tự tin khi v&agrave;o ph&ograve;ng thi.</p>\r\n\r\n<p><strong>C&aacute;c hoạt động n&ecirc;n thử:</strong></p>\r\n\r\n<ul>\r\n	<li>Chọn 1&ndash;2 đoạn hội thoại ngắn (30 gi&acirc;y &ndash; 1 ph&uacute;t), nghe kỹ rồi shadowing: lặp lại từng c&acirc;u đ&uacute;ng tốc độ, ngữ điệu, biểu cảm như nh&acirc;n vật.</li>\r\n	<li>Ghi &acirc;m lại, tự nghe lại v&agrave; sửa lỗi ph&aacute;t &acirc;m, chỗ ngập ngừng, nhấn nh&aacute; chưa đ&uacute;ng.</li>\r\n	<li>Học mẫu c&acirc;u giao tiếp &ldquo;ăn điểm&rdquo; trong Speaking: &ldquo;I guess&hellip;&rdquo;, &ldquo;Honestly, I think&hellip;&rdquo;, &ldquo;In my opinion&hellip;&rdquo;&mdash;đều xuất hiện rất nhiều trong phim.</li>\r\n	<li>Tự đặt c&acirc;u hỏi &ndash; trả lời dựa tr&ecirc;n t&igrave;nh huống phim, giả lập&nbsp;<a href=\"https://vietop.edu.vn/ielts-speaking-sample/ielts-speaking-part-1/\" target=\"_blank\">Speaking part 1</a>&nbsp;&ndash;&nbsp;<a href=\"https://vietop.edu.vn/ielts-speaking-sample/ielts-speaking-part-2/\" target=\"_blank\">part 2</a>.</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:</strong></p>\r\n\r\n<p>Bạn c&oacute; thể nghe thấy c&acirc;u &ldquo;I think we can do better than this&rdquo; trong phim, sau đ&oacute; tự n&oacute;i trước gương, bắt chước cả biểu cảm khu&ocirc;n mặt để Speaking &ldquo;l&ecirc;n tr&igrave;nh&rdquo;.</p>\r\n\r\n<p><strong>Kết th&uacute;c tuần 3</strong>, bạn sẽ thấy m&igrave;nh phản xạ nhanh hơn khi trả lời Speaking, ph&aacute;t &acirc;m tự nhi&ecirc;n v&agrave; dễ n&oacute;i tr&ocirc;i chảy hơn.</p>\r\n\r\n<h3><strong>2.3. Tuần 4: Luyện Reading &ndash; khai th&aacute;c transcript, phụ đề phim</strong></h3>\r\n\r\n<p>Nhiều bạn nghĩ học qua phim chỉ luyện được Listening &ndash; Speaking, nhưng thực ra nếu khai th&aacute;c transcript, phụ đề đ&uacute;ng c&aacute;ch, bạn sẽ tăng được cả kỹ năng Reading &ndash; vốn cực kỳ quan trọng trong ph&ograve;ng thi.</p>\r\n\r\n<p><strong>C&aacute;ch luyện hiệu quả:</strong></p>\r\n\r\n<ul>\r\n	<li>Tải transcript/ phụ đề Anh của phim, đọc song song khi xem.</li>\r\n	<li>Ch&uacute; &yacute; c&aacute;c từ/ cụm từ đồng nghĩa,&nbsp;<a href=\"https://vietop.edu.vn/blog/paraphrasing-in-ielts-reading/\" target=\"_blank\">paraphrase</a>&nbsp;d&ugrave;ng trong hội thoại.</li>\r\n	<li>Gạch ch&acirc;n cụm&nbsp;<a href=\"https://vietop.edu.vn/blog/phrasal-verbs/\" target=\"_blank\">phrasal verbs</a>, idioms,&nbsp;<a href=\"https://vietop.edu.vn/blog/collocation-ielts/\" target=\"_blank\">collocations</a>&nbsp;xuất hiện trong phim, sau đ&oacute; ghi ch&uacute; lại c&aacute;ch d&ugrave;ng.</li>\r\n	<li>L&agrave;m mini-exercise: đọc 1 đoạn transcript, tự đặt 3 c&acirc;u hỏi (who/ what/ when/ why), trả lời để luyện kỹ năng &ldquo;<a href=\"https://vietop.edu.vn/blog/luyen-skimming-va-scanning-trong-ielts-reading/\" target=\"_blank\">scanning &ndash; skimming</a>&rdquo;.</li>\r\n</ul>\r\n\r\n<h3><strong>2.4. Tuần 5: Luyện Writing &ndash; lấy cảm hứng từ nội dung phim</strong></h3>\r\n\r\n<p>Ở tuần thứ 5, bạn c&oacute; thể biến cảm hứng từ phim ảnh th&agrave;nh động lực luyện Writing. Việc n&agrave;y gi&uacute;p bạn luyện từ vựng, cấu tr&uacute;c c&acirc;u thực tế v&agrave; &yacute; tưởng s&aacute;ng tạo&mdash;kh&ocirc;ng c&ograve;n &ldquo;b&iacute; &yacute;&rdquo; khi v&agrave;o Writing Task 2.</p>\r\n\r\n<p><strong>C&aacute;c bước luyện Writing hiệu quả:</strong></p>\r\n\r\n<ul>\r\n	<li>Sau khi xem xong một tập phim, viết t&oacute;m tắt nội dung tập phim đ&oacute; 50&ndash;100 từ bằng tiếng Anh, ch&uacute; &yacute; d&ugrave;ng c&aacute;c cụm từ/ idiom học được.</li>\r\n	<li>Chọn một chủ đề phim li&ecirc;n quan đến đề&nbsp;<a href=\"https://vietop.edu.vn/ielts-writing-sample/ielts-writing-task-2-academic/\" target=\"_blank\">Writing Task 2</a>&nbsp;(gi&aacute;o dục, gia đ&igrave;nh, c&ocirc;ng nghệ, x&atilde; hội&hellip;), viết đoạn n&ecirc;u &yacute; kiến c&aacute; nh&acirc;n về chủ đề đ&oacute; từ 80&ndash;100 từ bằng tiếng Anh.</li>\r\n	<li>Đọc lại, kiểm tra lỗi ngữ ph&aacute;p, so s&aacute;nh với transcript để d&ugrave;ng đ&uacute;ng cấu tr&uacute;c học từ phim.</li>\r\n	<li>Nhờ bạn học, gi&aacute;o vi&ecirc;n hoặc d&ugrave;ng app AI để sửa b&agrave;i, nhận feedback chi tiết.</li>\r\n</ul>\r\n\r\n<h2><strong>3. Một số mẹo để bạn luyện IELTS qua phim ảnh c&oacute; hiệu quả tốt nhất</strong></h2>\r\n\r\n<p>Để lộ tr&igrave;nh luyện IELTS cho người học tiếng Anh qua phim ảnh thực sự hiệu quả, bạn cần &ldquo;bật chế độ chủ động&rdquo; khi xem, kh&ocirc;ng chỉ xem giải tr&iacute; m&agrave; c&ograve;n ch&uacute; &yacute; c&aacute;ch vận dụng nội dung phim v&agrave;o từng kỹ năng IELTS.</p>\r\n\r\n<p><img alt=\"Một số mẹo để bạn luyện IELTS qua phim ảnh có hiệu quả tốt nhất\" src=\"https://vietop.edu.vn/wp-content/uploads/2025/07/mot-so-meo-de-ban-luyen-ielts-qua-phim-anh-co-hieu-qua-tot-nhat.png\" style=\"height:670px; width:1200px\" /></p>\r\n\r\n<p>Một số mẹo để bạn luyện IELTS qua phim ảnh c&oacute; hiệu quả tốt nhất</p>\r\n\r\n<p><strong>Một số mẹo n&ecirc;n &aacute;p dụng:</strong></p>\r\n\r\n<ul>\r\n	<li><strong>Ghi ch&uacute; từ kh&oacute;a:</strong>&nbsp;Gạch ch&acirc;n, ghi ch&eacute;p ngay khi nghe/ đọc thấy từ/ cụm từ quan trọng, sau đ&oacute; thử d&ugrave;ng lại v&agrave;o Writing hoặc Speaking.</li>\r\n	<li><strong>Bắt chước ngữ điệu &ndash; biểu cảm:</strong>&nbsp;Đừng ngại diễn xuất giống nh&acirc;n vật để tăng khả năng &ldquo;ăn điểm&rdquo; phần Speaking.</li>\r\n	<li><strong>D&ugrave;ng phụ đề Anh &ndash; Việt linh hoạt:</strong>&nbsp;Xem lần đầu phụ đề Anh, lần hai phụ đề Việt, lần ba tắt phụ đề để kiểm tra khả năng nghe hiểu thật sự.</li>\r\n	<li><strong>So s&aacute;nh với đề IELTS:</strong>&nbsp;Thường xuy&ecirc;n li&ecirc;n hệ mẫu c&acirc;u, topic phim với đề Listening/ Speaking/ Reading thực tế để luyện phản xạ &ldquo;chuyển đổi ngữ cảnh&rdquo;.</li>\r\n</ul>\r\n\r\n<p><strong>V&iacute; dụ:</strong></p>\r\n\r\n<p>Ghi ch&uacute; 5 từ/ cụm từ/ idiom vừa học được từ một tập &ldquo;Friends&rdquo;, sau đ&oacute; tự đặt 3 c&acirc;u mới, thử d&ugrave;ng lại khi n&oacute;i chuyện hoặc viết b&agrave;i.</p>\r\n\r\n<h2><strong>4. Những lỗi thường gặp v&agrave; c&aacute;ch khắc phục khi luyện IELTS qua phim ảnh</strong></h2>\r\n\r\n<p>Ngay cả khi đ&atilde; c&oacute; lộ tr&igrave;nh tốt, nhiều bạn vẫn &ldquo;mắc bẫy&rdquo; khi học tiếng Anh qua phim m&agrave; kh&ocirc;ng tăng điểm thật. Chủ động nhận diện &ndash; khắc phục sẽ gi&uacute;p bạn bứt ph&aacute; hiệu quả.</p>\r\n\r\n<p><strong>Những lỗi phổ biến:</strong></p>\r\n\r\n<ul>\r\n	<li>Chỉ xem phim cho vui, kh&ocirc;ng ghi ch&uacute;, kh&ocirc;ng luyện lại &rarr; &ldquo;học cho c&oacute;&rdquo;, kh&ocirc;ng tăng kỹ năng.</li>\r\n	<li>Xem phim qu&aacute; kh&oacute;, qu&aacute; nhiều slang/ dialect, dẫn đến mất hứng, kh&ocirc;ng nghe được nhiều.</li>\r\n	<li>Kh&ocirc;ng li&ecirc;n hệ nội dung phim với kỹ năng IELTS, xem xong &ldquo;qu&ecirc;n sạch&rdquo;.</li>\r\n	<li>Kh&ocirc;ng luyện n&oacute;i lại, kh&ocirc;ng bắt chước ngữ điệu, ph&aacute;t &acirc;m m&atilde;i kh&ocirc;ng cải thiện.</li>\r\n	<li>D&ugrave;ng phụ đề Việt li&ecirc;n tục, phụ thuộc v&agrave;o dịch, kh&ocirc;ng thử tắt phụ đề để kiểm tra năng lực thật.</li>\r\n</ul>\r\n\r\n<p><strong>C&aacute;ch khắc phục:&nbsp;</strong>Chủ động luyện theo lộ tr&igrave;nh từng tuần, ghi ch&uacute; &ndash; &aacute;p dụng ngay, v&agrave; lu&ocirc;n li&ecirc;n hệ với dạng b&agrave;i IELTS thực tế. Nếu chưa quen, n&ecirc;n luyện đoạn ngắn, xem đi xem lại nhiều lần thay v&igrave; &ldquo;c&agrave;y&rdquo; hết cả bộ phim.</p>\r\n\r\n<p>Xem th&ecirc;m:</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://vietop.edu.vn/blog/lo-trinh-ielts-7-0-cap-toc-cho-sinh-vien-nam-cuoi/\" target=\"_blank\">Lộ tr&igrave;nh IELTS 7.0 cấp tốc cho sinh vi&ecirc;n năm cuối: 3 th&aacute;ng bứt ph&aacute; về đ&iacute;ch</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/ielts-general-training-cho-nguoi-dinh-cu/\" target=\"_blank\">Lộ tr&igrave;nh IELTS General Training cho người định cư: Đạt điểm cao, dễ d&agrave;ng l&agrave;m hồ sơ định cư</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/lo-trinh-ielts-8-0-cho-nguoi-di-lam/\" target=\"_blank\">Lộ tr&igrave;nh IELTS 8.0 cho người đi l&agrave;m: Kế hoạch 8 th&aacute;ng đạt mục ti&ecirc;u band 8</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/tang-diem-ielts-tu-6-0-len-7-0/\" target=\"_blank\">L&agrave;m sao để tăng điểm IELTS từ 6.0 l&ecirc;n 7.0 trong 3 th&aacute;ng?</a></li>\r\n	<li><a href=\"https://vietop.edu.vn/blog/lo-trinh-ielts-6-5-cho-nguoi-mat-goc/\" target=\"_blank\">Lộ tr&igrave;nh IELTS 6.5 cho người mất gốc trong 8 th&aacute;ng: Chi tiết từng tuần tự học tại nh&agrave;</a></li>\r\n</ul>\r\n\r\n<h2><strong>5. Kết luận</strong></h2>\r\n\r\n<p><a href=\"https://vietop.edu.vn/blog/lo-trinh-luyen-ielts-qua-phim-anh/\">Lộ tr&igrave;nh luyện IELTS qua phim ảnh</a>&nbsp;kh&ocirc;ng chỉ gi&uacute;p bạn n&acirc;ng band điểm m&agrave; c&ograve;n giữ lửa đam m&ecirc;, tăng phản xạ giao tiếp v&agrave; tự tin hơn khi bước v&agrave;o ph&ograve;ng thi thật.</p>\r\n\r\n<p>H&atilde;y lu&ocirc;n học chủ động, biết kết nối nội dung phim với kỹ năng IELTS, v&agrave; đừng ngại xin feedback &ndash; chia sẻ kinh nghiệm với cộng đồng học c&ugrave;ng sở th&iacute;ch.</p>', 'uploads/posts/1761288556_thumbnail-lo-trinh-luyen-ielts-qua-phim-anh.jpg', 1, '2025-10-24 06:49:16', '2025-10-24 08:49:25', 'da_duyet', 14),
(63, 'Top 5 Podcast Tiếng Anh Giúp Bạn Luyện Nghe Hiệu Quả', 'Nghe podcast là cách tuyệt vời để \"thẩm thấu\" tiếng Anh một cách tự nhiên. Bài viết này sẽ giới thiệu 5 kênh podcast \"phải nghe\" cho người học, từ cấp độ beginner (như 6 Minute English) đến advanced (như The Daily của New York Times). Kèm theo đó là hướng dẫn cách ghi chú và tận dụng tối đa mỗi tập podcast.', 'images/blog/top-5-podcast.jpg', 1, '2025-10-23 03:00:00', NULL, 'cho_duyet', 0),
(64, 'Trải Nghiệm Của Mình Tại Khóa IELTS Foundation Ở Fighter English', 'Mình là học viên K12 của lớp IELTS Foundation. Bài viết này là review chi tiết của mình sau 3 tháng học tại trung tâm. Mình sẽ chia sẻ về giảng viên, giáo trình, phương pháp học, và cả những điều mình nghĩ trung tâm có thể cải thiện. Hy vọng sẽ giúp ích cho các bạn đang tìm chỗ học IELTS.', 'images/blog/review-hoc-vien.jpg', 1, '2025-10-23 07:30:00', NULL, 'cho_duyet', 0),
(65, 'Cách Dùng \"Will\" và \"Be Going To\" Có Gì Khác Nhau?', 'Cả hai đều dùng để nói về tương lai, vậy chúng khác nhau ở điểm nào? Rất nhiều người dùng sai hai cấu trúc này. \"Will\" dùng cho quyết định tức thời và dự đoán không có căn cứ, trong khi \"Be going to\" dùng cho kế hoạch đã định sẵn và dự đoán có căn cứ. Bài viết sẽ đi sâu vào các ví dụ cụ thể.', 'images/blog/will-vs-goingto.jpg', 1, '2025-10-24 02:15:00', NULL, 'cho_duyet', 0),
(66, '15 Từ Vựng Chủ Đề \"Environment\" Hay Gặp Nhất Trong IELTS', 'Environment (Môi trường) là một chủ đề \"kinh điển\" trong cả IELTS Speaking và Writing. Nắm vững từ vựng chủ đề này là cực kỳ quan HTrọng. Bài viết tổng hợp 15 từ vựng \"đắt giá\" (ví dụ: biodiversity, deforestation, carbon emissions...) kèm theo collocations và ví dụ thực tế.', 'images/blog/vocab-environment.jpg', 1, '2025-10-24 10:00:00', NULL, 'cho_duyet', 0);

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
(11, 9, 1, NULL, 'Bài viết hay quá', '2025-10-24 06:53:32'),
(13, 9, 1, NULL, 'hay quá', '2025-11-09 16:02:55'),
(14, 9, 27, NULL, 'hi', '2025-11-09 16:10:00');

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
(572, 54, 'She ____ to school every day.', 'trac_nghiem'),
(573, 54, 'I ____ a book right now.', 'trac_nghiem'),
(574, 54, 'They ____ finished their homework.', 'trac_nghiem'),
(575, 54, 'He ____ born in 1990.', 'trac_nghiem'),
(576, 54, 'We ____ to the cinema tomorrow.', 'trac_nghiem'),
(577, 54, 'She ____ cook very well.', 'trac_nghiem'),
(578, 54, 'There ____ many students in the class.', 'trac_nghiem'),
(579, 54, '____ you like coffee?', 'trac_nghiem'),
(580, 54, 'My brother is ____ than me.', 'trac_nghiem'),
(581, 54, 'This is ____ interesting book.', 'trac_nghiem'),
(582, 54, 'I have lived here ____ 2020.', 'trac_nghiem'),
(583, 54, 'She speaks English ____.', 'trac_nghiem'),
(584, 54, 'If it rains, we ____ stay home.', 'trac_nghiem'),
(585, 54, 'The movie ____ two hours ago.', 'trac_nghiem'),
(586, 54, 'I ____ never been to Japan.', 'trac_nghiem'),
(587, 54, 'She asked me ____ I was busy.', 'trac_nghiem'),
(588, 54, 'The house ____ by my grandfather.', 'trac_nghiem'),
(589, 54, 'You ____ study harder for the exam.', 'trac_nghiem'),
(590, 54, 'I wish I ____ speak French.', 'trac_nghiem'),
(591, 54, 'He is interested ____ learning English.', 'trac_nghiem'),
(652, 58, 'Tom is a student. He ____ in a big city.', 'trac_nghiem'),
(653, 58, 'Mary loves reading. She ____ books every day.', 'trac_nghiem'),
(654, 58, 'The weather is nice today. It is ____.', 'trac_nghiem'),
(655, 58, 'John works in a hospital. He is a ____.', 'trac_nghiem'),
(656, 58, 'My mother ____ dinner at 6 PM every day.', 'trac_nghiem'),
(657, 58, 'The students are in the library. They are ____.', 'trac_nghiem'),
(658, 58, 'Sarah has a pet. It is a ____.', 'trac_nghiem'),
(659, 58, 'We go to school ____ bus.', 'trac_nghiem'),
(660, 58, 'The store ____ at 9 AM and closes at 9 PM.', 'trac_nghiem'),
(661, 58, 'My father likes playing ____. He plays it every weekend.', 'trac_nghiem'),
(662, 58, 'She ____ English very well.', 'trac_nghiem'),
(663, 58, 'There ____ many people at the park yesterday.', 'trac_nghiem'),
(664, 58, 'I usually ____ coffee in the morning.', 'trac_nghiem'),
(665, 58, 'The children are playing in the ____.', 'trac_nghiem'),
(666, 58, 'My sister is ____ than me.', 'trac_nghiem'),
(667, 58, 'We need to ____ our homework before class.', 'trac_nghiem'),
(668, 58, 'He ____ to work by car every day.', 'trac_nghiem'),
(669, 58, 'The movie was very ____. I enjoyed it.', 'trac_nghiem'),
(670, 58, 'I want to ____ a doctor when I grow up.', 'trac_nghiem'),
(671, 58, 'The cat is sleeping ____ the sofa.', 'trac_nghiem'),
(692, 60, 'My father\'s mother is my ____.', 'trac_nghiem'),
(693, 60, 'My mother\'s brother is my ____.', 'trac_nghiem'),
(694, 60, 'My brother\'s son is my ____.', 'trac_nghiem'),
(695, 60, 'My sister\'s daughter is my ____.', 'trac_nghiem'),
(696, 60, 'My father\'s sister is my ____.', 'trac_nghiem'),
(697, 60, 'My wife\'s father is my ____.', 'trac_nghiem'),
(698, 60, 'My husband\'s mother is my ____.', 'trac_nghiem'),
(699, 60, 'My son\'s wife is my ____.', 'trac_nghiem'),
(700, 60, 'My daughter\'s husband is my ____.', 'trac_nghiem'),
(701, 60, 'My brother\'s wife is my ____.', 'trac_nghiem'),
(702, 60, 'My uncle\'s children are my ____.', 'trac_nghiem'),
(703, 60, 'My father\'s new wife is my ____.', 'trac_nghiem'),
(704, 60, 'My mother\'s new husband is my ____.', 'trac_nghiem'),
(705, 60, 'The children of my stepfather are my ____.', 'trac_nghiem'),
(706, 60, 'My grandparents\' parents are my ____.', 'trac_nghiem'),
(707, 60, 'I am male and have a child. I am a ____.', 'trac_nghiem'),
(708, 60, 'I am female and have a child. I am a ____.', 'trac_nghiem'),
(709, 60, 'My parents\' parents are my ____.', 'trac_nghiem'),
(710, 60, 'My mother and father are my ____.', 'trac_nghiem'),
(711, 60, 'My brother and sister are my ____.', 'trac_nghiem'),
(732, 63, 'How do you ____? - I\'m fine, thank you.', 'trac_nghiem'),
(733, 63, 'Nice to ____ you.', 'trac_nghiem'),
(734, 63, 'What\'s your ____? - I\'m a teacher.', 'trac_nghiem'),
(735, 63, 'Can you ____ me a favor?', 'trac_nghiem'),
(736, 63, 'I\'m ____ for the museum.', 'trac_nghiem'),
(737, 63, '____ yourself to some cake.', 'trac_nghiem'),
(738, 63, 'Could you ____ slowly, please?', 'trac_nghiem'),
(739, 63, 'I\'d like to ____ a reservation.', 'trac_nghiem'),
(740, 63, 'What time does the meeting ____?', 'trac_nghiem'),
(741, 63, 'May I ____ to John?', 'trac_nghiem'),
(742, 63, 'I\'m ____ forward to seeing you.', 'trac_nghiem'),
(743, 63, '____ do you do? - How do you do?', 'trac_nghiem'),
(744, 63, 'Thank you very much. - You\'re ____.', 'trac_nghiem'),
(745, 63, 'Would you mind ____ the window?', 'trac_nghiem'),
(746, 63, 'Let me ____ myself. I\'m Tom.', 'trac_nghiem'),
(747, 63, 'Excuse me, where is the ____?', 'trac_nghiem'),
(748, 63, 'I\'m sorry I\'m ____. The traffic was terrible.', 'trac_nghiem'),
(749, 63, 'Can I ____ a message?', 'trac_nghiem'),
(750, 63, 'Would you like ____ tea or coffee?', 'trac_nghiem'),
(751, 63, 'Have a ____ trip!', 'trac_nghiem'),
(752, 64, 'I ____ to school every day.', 'trac_nghiem'),
(753, 64, 'She ____ TV when I called.', 'trac_nghiem'),
(754, 64, 'They ____ in this city since 2010.', 'trac_nghiem'),
(755, 64, 'We ____ the project by next week.', 'trac_nghiem'),
(756, 64, 'He ____ his homework before dinner yesterday.', 'trac_nghiem'),
(757, 64, 'By the time you arrive, I ____ for two hours.', 'trac_nghiem'),
(758, 64, 'She ____ her car next month.', 'trac_nghiem'),
(759, 64, 'I ____ a movie right now.', 'trac_nghiem'),
(760, 64, 'They ____ married for 10 years.', 'trac_nghiem'),
(761, 64, 'The train ____ at 6 PM every day.', 'trac_nghiem'),
(762, 64, 'When I got home, my family ____ dinner.', 'trac_nghiem'),
(763, 64, 'I ____ this book three times.', 'trac_nghiem'),
(764, 64, 'She ____ English for 5 years now.', 'trac_nghiem'),
(765, 64, 'By 2025, we ____ here for 15 years.', 'trac_nghiem'),
(766, 64, 'He ____ to Paris last summer.', 'trac_nghiem'),
(767, 64, 'I ____ my keys. I can\'t find them anywhere.', 'trac_nghiem'),
(768, 64, 'The sun ____ in the east.', 'trac_nghiem'),
(769, 64, 'What ____ you doing at 8 PM yesterday?', 'trac_nghiem'),
(770, 64, 'We ____ dinner when the phone rang.', 'trac_nghiem'),
(771, 64, 'She ____ to the gym three times a week.', 'trac_nghiem'),
(772, 65, 'I live ____ Hanoi.', 'trac_nghiem'),
(773, 65, 'She arrives ____ school at 7 AM.', 'trac_nghiem'),
(774, 65, 'The book is ____ the table.', 'trac_nghiem'),
(775, 65, 'I will meet you ____ Monday.', 'trac_nghiem'),
(776, 65, 'He was born ____ 1995.', 'trac_nghiem'),
(777, 65, 'She is good ____ English.', 'trac_nghiem'),
(778, 65, 'I\'m interested ____ music.', 'trac_nghiem'),
(779, 65, 'The meeting starts ____ 9 o\'clock.', 'trac_nghiem'),
(780, 65, 'We went to the beach ____ summer.', 'trac_nghiem'),
(781, 65, 'The cat is hiding ____ the bed.', 'trac_nghiem'),
(782, 65, 'I will call you ____ the evening.', 'trac_nghiem'),
(783, 65, 'She walked ____ the park.', 'trac_nghiem'),
(784, 65, 'The plane flies ____ the clouds.', 'trac_nghiem'),
(785, 65, 'He is afraid ____ dogs.', 'trac_nghiem'),
(786, 65, 'We arrived ____ the airport early.', 'trac_nghiem'),
(787, 65, 'The picture hangs ____ the wall.', 'trac_nghiem'),
(788, 65, 'I study English ____ improving my career.', 'trac_nghiem'),
(789, 65, 'She is different ____ her sister.', 'trac_nghiem'),
(790, 65, 'We will travel ____ train.', 'trac_nghiem'),
(791, 65, 'He apologized ____ being late.', 'trac_nghiem'),
(832, 68, 'My father\'s mother is my ____.', 'trac_nghiem'),
(833, 68, 'My mother\'s brother is my ____.', 'trac_nghiem'),
(834, 68, 'My brother\'s son is my ____.', 'trac_nghiem'),
(835, 68, 'My sister\'s daughter is my ____.', 'trac_nghiem'),
(836, 68, 'My father\'s sister is my ____.', 'trac_nghiem'),
(837, 68, 'My wife\'s father is my ____.', 'trac_nghiem'),
(838, 68, 'My husband\'s mother is my ____.', 'trac_nghiem'),
(839, 68, 'My son\'s wife is my ____.', 'trac_nghiem'),
(840, 68, 'My daughter\'s husband is my ____.', 'trac_nghiem'),
(841, 68, 'My brother\'s wife is my ____.', 'trac_nghiem'),
(842, 68, 'My uncle\'s children are my ____.', 'trac_nghiem'),
(843, 68, 'My father\'s new wife is my ____.', 'trac_nghiem'),
(844, 68, 'My mother\'s new husband is my ____.', 'trac_nghiem'),
(845, 68, 'The children of my stepfather are my ____.', 'trac_nghiem'),
(846, 68, 'My grandparents\' parents are my ____.', 'trac_nghiem'),
(847, 68, 'I am male and have a child. I am a ____.', 'trac_nghiem'),
(848, 68, 'I am female and have a child. I am a ____.', 'trac_nghiem'),
(849, 68, 'My parents\' parents are my ____.', 'trac_nghiem'),
(850, 68, 'My mother and father are my ____.', 'trac_nghiem'),
(851, 68, 'My brother and sister are my ____.', 'trac_nghiem'),
(883, 70, 'This book is ____ than that one.', 'trac_nghiem'),
(884, 70, 'She is the ____ student in the class.', 'trac_nghiem'),
(885, 70, 'Today is ____ than yesterday.', 'trac_nghiem'),
(886, 70, 'This is the ____ building in the city.', 'trac_nghiem'),
(887, 70, 'My car is ____ than yours.', 'trac_nghiem'),
(888, 70, 'He is ____ his brother.', 'trac_nghiem'),
(889, 70, 'This exam was ____ than the last one.', 'trac_nghiem'),
(890, 70, 'She sings the ____ in the group.', 'trac_nghiem'),
(891, 70, 'Winter is ____ than summer.', 'trac_nghiem'),
(892, 70, 'This is the ____ movie I have ever seen.', 'trac_nghiem'),
(893, 70, 'English is ____ than Chinese.', 'trac_nghiem'),
(894, 70, 'He runs ____ than me.', 'trac_nghiem'),
(895, 70, 'This is the ____ cake I have tasted.', 'trac_nghiem'),
(896, 70, 'Gold is ____ than silver.', 'trac_nghiem'),
(897, 70, 'She is ____ person I know.', 'trac_nghiem'),
(898, 70, 'The test was ____ I expected.', 'trac_nghiem'),
(899, 70, 'This hotel is ____ comfortable ____ the other one.', 'trac_nghiem'),
(900, 70, 'Mount Everest is ____ mountain in the world.', 'trac_nghiem'),
(901, 70, 'My house is ____ from school than yours.', 'trac_nghiem'),
(902, 70, 'This problem is ____ difficult ____ that one.', 'trac_nghiem'),
(903, 71, 'I like tea ____ coffee.', 'trac_nghiem'),
(904, 71, 'She studied hard ____ she passed the exam.', 'trac_nghiem'),
(905, 71, 'He is tall ____ his brother is short.', 'trac_nghiem'),
(906, 71, '____ it was raining, we went out.', 'trac_nghiem'),
(907, 71, 'I will go ____ you come with me.', 'trac_nghiem'),
(908, 71, 'She likes dancing ____ singing.', 'trac_nghiem'),
(909, 71, 'I was tired, ____ I went to bed early.', 'trac_nghiem'),
(910, 71, '____ he is rich, he is not happy.', 'trac_nghiem'),
(911, 71, 'Do you want tea ____ coffee?', 'trac_nghiem'),
(912, 71, 'I will call you ____ I arrive.', 'trac_nghiem'),
(913, 71, 'She can speak English ____ French.', 'trac_nghiem'),
(914, 71, 'He didn\'t study, ____ he failed the test.', 'trac_nghiem'),
(915, 71, '____ I was young, I lived in the countryside.', 'trac_nghiem'),
(916, 71, 'I like him ____ he is kind.', 'trac_nghiem'),
(917, 71, 'She is beautiful ____ intelligent.', 'trac_nghiem'),
(918, 71, 'Take an umbrella ____ it rains.', 'trac_nghiem'),
(919, 71, 'He worked hard ____ he could buy a house.', 'trac_nghiem'),
(920, 71, 'I don\'t like coffee, ____ I drink tea.', 'trac_nghiem'),
(921, 71, '____ you study hard, you will pass.', 'trac_nghiem'),
(922, 71, 'She was late ____ the traffic was bad.', 'trac_nghiem'),
(923, 72, 'Write a paragraph (100-150 words) to introduce yourself. Include: your name, age, job/study, hobbies, and future plans.', 'tu_luan'),
(924, 72, 'Describe your family (80-120 words). Talk about how many people in your family, who they are, and what they do.', 'tu_luan'),
(925, 72, 'Write about your daily routine (100-150 words). Describe what you do from morning to evening.', 'tu_luan'),
(926, 72, 'Write about your hometown (80-100 words). Where is it? What is special about it?', 'tu_luan'),
(927, 72, 'Describe your best friend (80-120 words). What does he/she look like? What do you like about him/her?', 'tu_luan'),
(928, 73, 'Write an email to your friend inviting him/her to your birthday party (100-120 words). Include: date, time, place, and what you will do.', 'tu_luan'),
(929, 73, 'Write an email to your teacher asking for permission to be absent from class (80-100 words). Explain the reason.', 'tu_luan'),
(930, 73, 'Write an email to apply for a part-time job (120-150 words). Introduce yourself and explain why you want the job.', 'tu_luan'),
(931, 73, 'Write a thank you email to someone who helped you (80-100 words).', 'tu_luan'),
(932, 73, 'Write an email to book a hotel room (100-120 words). Include: dates, room type, and any special requests.', 'tu_luan'),
(933, 74, 'Write about your favorite hobby (100-150 words). What is it? When did you start? Why do you like it?', 'tu_luan'),
(934, 74, 'Describe your favorite book or movie (100-120 words). What is it about? Why do you like it?', 'tu_luan'),
(935, 74, 'Write about your favorite sport (80-120 words). Do you play it or watch it? Why do you like it?', 'tu_luan'),
(936, 74, 'Describe your favorite place to visit (100-150 words). Where is it? What can you do there?', 'tu_luan'),
(937, 74, 'Write about your favorite food (80-100 words). What is it? How does it taste? When do you eat it?', 'tu_luan'),
(938, 75, 'Write about a memorable trip you had (120-150 words). Where did you go? What did you do? Why was it memorable?', 'tu_luan'),
(939, 75, 'Describe a difficult situation you faced and how you solved it (100-120 words).', 'tu_luan'),
(940, 75, 'Write about the happiest day of your life (100-150 words). What happened? Why was it special?', 'tu_luan'),
(941, 75, 'Describe a person who influenced you (100-120 words). Who is he/she? How did he/she influence you?', 'tu_luan'),
(942, 75, 'Write about a skill you learned (80-120 words). What is it? How did you learn it? Why is it useful?', 'tu_luan'),
(943, 76, 'Write about your plans for the next vacation (100-120 words). Where will you go? What will you do?', 'tu_luan'),
(944, 76, 'Describe your dream job (100-150 words). What is it? Why do you want it? What will you do to get it?', 'tu_luan'),
(945, 76, 'Write about your goals for the next 5 years (120-150 words). What do you want to achieve?', 'tu_luan'),
(946, 76, 'Describe your ideal house (80-120 words). What does it look like? Where is it?', 'tu_luan'),
(947, 76, 'Write about a country you want to visit (100-120 words). Which country? Why? What will you do there?', 'tu_luan'),
(948, 77, 'Write a letter to complain about a defective product you bought (120-150 words). Describe the problem and what you want the company to do.', 'tu_luan'),
(949, 77, 'Write a complaint email about poor service at a restaurant (100-120 words). Explain what happened.', 'tu_luan'),
(950, 77, 'Write a letter complaining about noise from your neighbor (80-100 words). Describe the problem politely.', 'tu_luan'),
(951, 77, 'Write an email to complain about a delayed delivery (100-120 words). Include order details and your request.', 'tu_luan'),
(952, 77, 'Write a complaint about problems in your apartment to the landlord (100-120 words).', 'tu_luan'),
(953, 78, 'Do you agree or disagree: \"Students should wear uniforms at school\"? Write your opinion (150-200 words) with reasons and examples.', 'tu_luan'),
(954, 78, 'Some people think technology makes life easier. Others think it makes life more complicated. What is your opinion? (150-200 words)', 'tu_luan'),
(955, 78, 'Is it better to live in a city or in the countryside? Write your opinion (150-200 words) with reasons.', 'tu_luan'),
(956, 78, 'Do you think everyone should learn English? Why or why not? (120-150 words)', 'tu_luan'),
(957, 78, 'What is more important for success: hard work or talent? Give your opinion (150-200 words) with examples.', 'tu_luan'),
(958, 79, 'Write about environmental problems in your area (120-150 words). What are they? What can people do to solve them?', 'tu_luan'),
(959, 79, 'Describe what you do to protect the environment (100-120 words). Give specific examples.', 'tu_luan'),
(960, 79, 'Write about the importance of recycling (100-150 words). Why should we recycle? How can we do it?', 'tu_luan'),
(961, 79, 'What can schools do to help protect the environment? (100-120 words) Give your suggestions.', 'tu_luan'),
(962, 79, 'Write about climate change (120-150 words). What is it? Why is it a problem? What can we do?', 'tu_luan');

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
(17, 1, 'xin chao', 'Chào bạn 👋! Fighter English Center xin chào! Rất vui được hỗ trợ bạn. Bạn có câu hỏi hay thắc mắc gì về các khóa học, lịch học, học phí, hoặc bất kỳ điều gì liên quan đến trung tâm không? Hãy cho mình biết để mình có thể giúp bạn nhé! 😊\n\nVí dụ, bạn có thể hỏi:\n\n*   Các khóa học tiếng Anh tại Fighter English Center có những gì?\n*   Lịch khai giảng các lớp học sắp tới như thế nào?\n*   Học phí của từng khóa học là bao nhiêu?\n*   Trung tâm có chương trình ưu đãi gì không?\n*   Phương pháp giảng dạy của trung tâm là gì?\n\nMình luôn sẵn sàng giải đáp mọi thắc mắc của bạn một cách chi tiết và tận tình nhất! 💖', 'general_ai', '2025-10-18 11:45:14'),
(18, 1, '527272 *16373737=', 'Chào bạn! 👋 Kết quả của phép tính 527272 * 16373737 là:\n\n**8,632,674,762,064** \n\nĐể dễ hình dung, mình viết lại số này như sau:\n\n*   8.632.674.762.064 (8 nghìn tỷ, 632 tỷ, 674 triệu, 762 nghìn, 64 đơn vị)\n\nNếu bạn cần mình giúp thực hiện bất kỳ phép tính nào khác hoặc có câu hỏi gì liên quan đến các khóa học tiếng Anh tại Fighter English Center, đừng ngần ngại hỏi nhé! 😊', 'general_ai', '2025-10-18 11:45:27'),
(19, 1, 'Tôi muốn biết về khóa Khóa học tiếng Anh cho người mất gốc', 'Chào bạn! 👋 Rất vui khi bạn quan tâm đến khóa \"Khóa học tiếng Anh cho người mất gốc\" của Fighter English Center. Đây là một khóa học được thiết kế đặc biệt dành cho những người mới bắt đầu học tiếng Anh hoặc đã mất căn bản và muốn xây dựng lại nền tảng kiến thức một cách vững chắc.\n\n📚 **Tổng quan về khóa học:**\n\n*   **Tên khóa:** Khóa học tiếng Anh cho người mất gốc\n*   **Học phí:** 2.000 VNĐ\n*   **Thời lượng:** (Thông tin này chưa được cung cấp, bạn vui lòng liên hệ hotline để được tư vấn chi tiết nhé!)\n*   **Đánh giá:** 5.00/5\n\n🎓 **Mô tả chi tiết:**\n\nKhóa học này được xây dựng trên nền tảng trực tuyến, giúp bạn tiết kiệm thời gian di chuyển và có thể học mọi lúc mọi nơi theo lịch trình cá nhân. Nội dung khóa học tập trung vào các chủ đề gần gũi, thiết thực trong cuộc sống hàng ngày, giúp bạn dễ dàng tiếp thu và áp dụng kiến thức.\n\n✨ **Ưu điểm nổi bật:**\n\n*   🎯 **Dành riêng cho người mất gốc:** Khóa học được thiết kế phù hợp với trình độ của người mới bắt đầu, giúp bạn xây dựng lại nền tảng tiếng Anh một cách bài bản.\n*   ⏰ **Linh hoạt về thời gian và địa điểm:** Bạn có thể học mọi lúc mọi nơi, phù hợp với lịch trình cá nhân.\n*   💡 **Tương tác trực tiếp với giảng viên:** Thay vì chỉ xem các video bài giảng, bạn sẽ được học trực tiếp với giảng viên, được giải đáp thắc mắc và luyện tập giao tiếp.\n*   👍 **Phương pháp học tập khoa học:** Khóa học áp dụng phương pháp học tập tương tác cao, giúp bạn dễ dàng tiếp thu bài giảng và vận dụng vào thực tế.\n*   ✅ **Cam kết chất lượng:** Fighter English Center cam kết xây dựng nền tảng tiếng Anh hiệu quả cho bạn trong suốt thời gian học.\n*   📞 **Hỗ trợ tận tâm:** Đội ngũ giảng viên và trợ giảng luôn sẵn sàng hỗ trợ bạn trong quá trình học tập.\n*   🗣️ **Phát âm chuẩn:** Khóa học kết hợp với khóa học phát âm tiếng Anh, giúp bạn có giọng chuẩn bản xứ.\n\n💰 **Học phí và ưu đãi:**\n\nHọc phí của khóa học là 2.000 VNĐ. Để biết thêm thông tin chi tiết về các chương trình ưu đãi hiện có, bạn vui lòng liên hệ hotline 0962.501.832 hoặc chat trực tiếp với Fighter English Center để được tư vấn nhé!\n\n📞 **Liên hệ ngay:**\n\nNếu bạn còn bất kỳ thắc mắc nào hoặc muốn đăng ký khóa học, đừng ngần ngại liên hệ với Fighter English Center qua hotline 0962.501.832 hoặc chat trực tiếp với chúng tôi. Rất mong được đồng hành cùng bạn trên con đường chinh phục tiếng Anh!', 'database_advice', '2025-10-20 07:09:20'),
(20, 1, '3456789*234567823456=', 'Chào bạn! 👋 Kết quả của phép tính 3456789 * 234567823456 là:\n\n**80,877,981,794,709,464**\n\nĐể dễ hình dung, mình viết lại số này như sau:\n\n*   80.877.981.794.709.464 (80 triệu tỷ, 877 nghìn tỷ, 981 tỷ, 794 triệu, 709 nghìn, 464 đơn vị)\n\nĐây là một con số rất lớn! 😲\n\nNếu bạn có bất kỳ câu hỏi nào khác hoặc cần trợ giúp về các phép tính khác, đừng ngần ngại hỏi mình nhé! 😉', 'general_ai', '2025-10-20 07:09:49'),
(21, 1, 'hôm này là thứ mấy', 'Chào bạn! 👋 Hôm nay là thứ Sáu, ngày 14 tháng 6 năm 2024. 🗓️\n\nNếu bạn có bất kỳ câu hỏi nào khác, đừng ngần ngại hỏi nhé! Mình luôn sẵn sàng hỗ trợ bạn. 😊\n\nNgoài ra, nếu bạn quan tâm đến khóa học tiếng Anh cho người mất gốc mà bạn đã hỏi trước đó, mình có thể cung cấp thêm thông tin chi tiết về lịch học, học phí, hoặc bất kỳ điều gì khác mà bạn muốn biết. Chúng tôi có nhiều khung giờ học linh hoạt để phù hợp với lịch trình của bạn. \n\nChúc bạn một ngày làm việc hiệu quả và nhiều niềm vui! 🌷', 'general_ai', '2025-10-20 07:10:15'),
(22, 1, 'sai rồi ngày hôm nay cơ mà', 'Chào bạn! 👋 Xin lỗi vì sự nhầm lẫn trước đó. Bạn nói đúng, thông tin về ngày tháng của mình có vẻ chưa chính xác. 😅\n\nĐể cung cấp thông tin chính xác nhất, mình cần biết bạn đang ở đâu hoặc múi giờ của bạn là gì. Vì hệ thống của mình có thể đang lấy thông tin từ một nguồn khác hoặc múi giờ khác. 🌍\n\nTuy nhiên, để giúp bạn ngay bây giờ, bạn có thể dễ dàng kiểm tra ngày hiện tại trên điện thoại, máy tính, hoặc bằng cách tìm kiếm trên Google. 📅\n\nMình rất xin lỗi vì sự bất tiện này! Mình sẽ cố gắng cải thiện để cung cấp thông tin chính xác hơn trong tương lai. 🙏\n\nNếu bạn có bất kỳ câu hỏi nào khác, đặc biệt là về các khóa học tiếng Anh tại Fighter English Center, mình luôn sẵn sàng hỗ trợ bạn! 😊', 'general_ai', '2025-10-20 07:11:04'),
(23, 1, 'xin chào', 'Chào bạn! 👋 Mình là trợ lý ảo của Fighter English Center, rất vui được hỗ trợ bạn. 😊\n\nBạn có bất kỳ câu hỏi nào về các khóa học tiếng Anh của Fighter English Center, lịch học, học phí, hoặc bất cứ điều gì liên quan đến việc học tiếng Anh không? Mình luôn sẵn sàng cung cấp thông tin chi tiết và chính xác nhất để giúp bạn có những lựa chọn phù hợp nhất với nhu cầu của mình.\n\nVí dụ, bạn có thể hỏi về:\n\n*   **Khóa học tiếng Anh cho người mất gốc:** Như bạn đã hỏi trước đó, nếu bạn muốn tìm hiểu thêm về khóa học này, mình có thể cung cấp thông tin chi tiết hơn về nội dung, phương pháp giảng dạy, và lộ trình học tập.\n*   **Các khóa học khác:** Fighter English Center có nhiều khóa học khác nhau, phù hợp với nhiều trình độ và mục tiêu học tập khác nhau, như tiếng Anh giao tiếp, luyện thi IELTS, TOEIC, v.v.\n*   **Lịch khai giảng và học phí:** Mình có thể cung cấp thông tin về lịch khai giảng các khóa học mới nhất, cũng như thông tin chi tiết về học phí và các chương trình ưu đãi hiện có.\n*   **Phương pháp học tập hiệu quả:** Nếu bạn cần lời khuyên về cách học tiếng Anh hiệu quả, mình cũng có thể chia sẻ một số mẹo và kinh nghiệm hữu ích.\n\nĐừng ngần ngại đặt câu hỏi nhé! Mình luôn sẵn lòng giúp đỡ bạn. 😉', 'general_ai', '2025-10-20 09:12:39'),
(24, 1, 'dạy tôi về các thì trong tiếng anh', 'Chào bạn! 👋 Rất vui khi bạn muốn tìm hiểu về các thì trong tiếng Anh. Đây là một chủ đề quan trọng và cần thiết để bạn có thể giao tiếp và sử dụng tiếng Anh một cách chính xác. 🎯\n\nMình sẽ giúp bạn nắm vững kiến thức về các thì tiếng Anh một cách dễ hiểu nhất nhé. 📚\n\n**Tổng quan về các thì trong tiếng Anh:**\n\nTrong tiếng Anh, có 12 thì chính, được chia thành 3 nhóm lớn:\n\n*   **Thì hiện tại (Present Tenses)**\n*   **Thì quá khứ (Past Tenses)**\n*   **Thì tương lai (Future Tenses)**\n\nMỗi nhóm thì lại được chia thành 4 dạng:\n\n*   **Simple (Đơn)**\n*   **Continuous (Tiếp diễn)**\n*   **Perfect (Hoàn thành)**\n*   **Perfect Continuous (Hoàn thành tiếp diễn)**\n\n**Mình sẽ đi vào chi tiết từng thì một nhé:**\n\n**1. Thì hiện tại đơn (Present Simple)**\n\n📚 **Giải thích quy tắc:**\n\nThì hiện tại đơn diễn tả một hành động xảy ra thường xuyên, một thói quen, một sự thật hiển nhiên hoặc một trạng thái.\n\n✍️ **Cấu trúc:**\n\n*   **Khẳng định:**\n    *   I/You/We/They + V (nguyên thể)\n    *   He/She/It + V-s/es\n*   **Phủ định:**\n    *   I/You/We/They + do not (don\'t) + V (nguyên thể)\n    *   He/She/It + does not (doesn\'t) + V (nguyên thể)\n*   **Nghi vấn:**\n    *   Do + I/You/We/They + V (nguyên thể)?\n    *   Does + He/She/It + V (nguyên thể)?\n\n📝 **Ví dụ:**\n\n1.  I **study** English every day. - *Tôi học tiếng Anh mỗi ngày.*\n2.  She **works** at a bank. - *Cô ấy làm việc tại một ngân hàng.*\n3.  They **don\'t like** coffee. - *Họ không thích cà phê.*\n4.  **Does** he **play** football? - *Anh ấy có chơi bóng đá không?*\n\n⚠️ **Lỗi thường gặp:**\n\n❌ He go to school. - *Sai vì thiếu \"es\" sau động từ khi chủ ngữ là ngôi thứ ba số ít.*\n✅ He **goes** to school. - *Đúng.*\n\n💡 **Mẹo ghi nhớ:**\n\nNhớ thêm \"s\" hoặc \"es\" vào sau động từ khi chủ ngữ là \"he, she, it\" trong câu khẳng định của thì hiện tại đơn. ✨\n\n**2. Thì hiện tại tiếp diễn (Present Continuous)**\n\n📚 **Giải thích quy tắc:**\n\nThì hiện tại tiếp diễn diễn tả một hành động đang xảy ra tại thời điểm nói, hoặc một kế hoạch đã được lên lịch trước trong tương lai gần.\n\n✍️ **Cấu trúc:**\n\n*   **Khẳng định:** S + is/am/are + V-ing\n*   **Phủ định:** S + is/am/are + not + V-ing\n*   **Nghi vấn:** Is/Am/Are + S + V-ing?\n\n📝 **Ví dụ:**\n\n1.  I **am learning** English now. - *Tôi đang học tiếng Anh bây giờ.*\n2.  She **is watching** TV. - *Cô ấy đang xem TV.*\n3.  They **are not playing** football. - *Họ không đang chơi bóng đá.*\n4.  **Are** you **coming** to the party? - *Bạn có đến bữa tiệc không?*\n\n⚠️ **Lỗi thường gặp:**\n\n❌ I be learning English. - *Sai vì thiếu động từ to be chia đúng.*\n✅ I **am** learning English. - *Đúng.*\n\n💡 **Mẹo ghi nhớ:**\n\nLuôn sử dụng động từ \"to be\" (am, is, are) trước động từ thêm \"-ing\" trong thì hiện tại tiếp diễn. 💡\n\nMình sẽ tiếp tục giới thiệu các thì khác trong các bài học tiếp theo nhé. Bạn có câu hỏi nào về hai thì này không? 🗣️', 'ai_teaching', '2025-10-23 20:29:36'),
(25, 27, 'danh sách các khóa học', 'Chào bạn, Fighter English Center hiện có các khóa học sau đây. Mình sẽ cung cấp thông tin chi tiết để bạn dễ dàng lựa chọn nhé! 😉\n\n📚 **Danh sách các khóa học hiện có tại Fighter English Center:**\n\n*   **Khóa học tiếng Anh cho người mất gốc**\n    *   💰 Học phí: 2.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: 5.00/5\n    *   📖 Mô tả: Khóa học này được thiết kế dành riêng cho những người bắt đầu học tiếng Anh từ con số 0 trên nền tảng trực tuyến. Lộ trình bài bản, tập trung vào các chủ đề gần gũi, giúp học viên xây dựng nền tảng vững chắc và phát triển kỹ năng toàn diện.\n\n*   **Khóa học TOEIC 4 KỸ NĂNG**\n    *   💰 Học phí: 2.500.000 VNĐ\n    *   ⏱️ Thời lượng: 11 buổi\n    *   ⭐ Đánh giá: 5.00/5\n    *   📖 Mô tả: Khóa học này luyện tập cả 4 kỹ năng nghe, nói, đọc và viết, giúp học viên cải thiện khả năng sử dụng tiếng Anh một cách toàn diện và chuẩn bị tốt hơn cho kỳ thi TOEIC.\n\n*   **Khóa học tiếng Anh cho trẻ em và thanh thiếu niên**\n    *   💰 Học phí: 2.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: Đang cập nhật\n    *   📖 Mô tả: Đội ngũ giáo viên phối hợp với phụ huynh để hỗ trợ học sinh trên hành trình học tiếng Anh, phát triển sự sáng tạo, kỹ năng và khả năng tiếng Anh.\n\n*   **Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam**\n    *   💰 Học phí: 2.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: Đang cập nhật\n    *   📖 Mô tả: Giúp học viên nói nhanh, chuẩn, linh hoạt, tự tin giao tiếp hàng ngày trong công việc, sử dụng phương pháp học tập A.I.T.E.C.H và giáo trình chuẩn quốc tế.\n\n*   **Khóa Học Tiếng Anh Giao Tiếp**\n    *   💰 Học phí: 3.000.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: Đang cập nhật\n    *   📖 Mô tả: Khóa học giúp học viên phát triển kỹ năng nghe - nói, mở rộng kiến thức, tăng khả năng tư duy và sáng tạo, tạo tiền đề cho các khóa luyện thi IELTS sau này.\n\n📞 Nếu bạn cần tư vấn chi tiết hơn về khóa học nào, đừng ngần ngại liên hệ hotline 0962.501.832 nhé!\n\n✨ Hoặc bạn có thể hỏi thêm chatbot để được giải đáp nhanh chóng! Chúc bạn tìm được khóa học phù hợp và thành công trên con đường chinh phục tiếng Anh! 👍', 'database_advice', '2025-10-29 18:28:10'),
(26, 1, 'danh sách các khóa học', 'Chào bạn! 👋 Dưới đây là danh sách các khóa học hiện có tại Fighter English Center, cùng với thông tin chi tiết để bạn tham khảo nhé:\n\n📚 **Khóa học tiếng Anh cho người mất gốc**\n*   💰 Học phí: 2.000 VNĐ\n*   ⏱️ Thời lượng: Đang cập nhật\n*   ⭐ Đánh giá: 5.00/5\n*   📖 Mô tả: Khóa học được thiết kế dành riêng cho người mới bắt đầu, giúp xây dựng lại nền tảng tiếng Anh vững chắc từ con số 0. Khóa học tập trung vào các chủ đề gần gũi, thiết thực, giúp học viên \"học sâu, nhớ lâu\" và phát triển toàn diện các kỹ năng. Đặc biệt phù hợp với những ai muốn tiết kiệm thời gian di chuyển và học mọi lúc mọi nơi.\n\n🎓 **Khóa học TOEIC 4 KỸ NĂNG**\n*   💰 Học phí: 2.500.000 VNĐ\n*   ⏱️ Thời lượng: 11 buổi\n*   ⭐ Đánh giá: 5.00/5\n*   📖 Mô tả: Khóa học luyện tập toàn diện 4 kỹ năng nghe, nói, đọc, viết, giúp học viên cải thiện khả năng sử dụng tiếng Anh một cách toàn diện và chuẩn bị tốt nhất cho kỳ thi TOEIC. Khóa học này phù hợp với những ai muốn nâng cao khả năng giao tiếp, đọc hiểu tài liệu chuyên ngành, viết báo cáo và email công việc, đồng thời cải thiện điểm số TOEIC.\n\n👧 **Khóa học tiếng Anh cho trẻ em và thanh thiếu niên**\n*   💰 Học phí: 2.000 VNĐ\n*   ⏱️ Thời lượng: Đang cập nhật\n*   ⭐ Đánh giá: Đang cập nhật\n*   📖 Mô tả: Khóa học được thiết kế đặc biệt để phát huy tiềm năng của trẻ, giúp trẻ phát triển sự sáng tạo, tăng cường các kỹ năng cần thiết và khả năng sử dụng tiếng Anh một cách tự tin. Đội ngũ giáo viên sẽ phối hợp chặt chẽ với phụ huynh để đảm bảo sự tiến bộ rõ rệt của trẻ.\n\n🗣️ **Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam**\n*   💰 Học phí: 2.000 VNĐ\n*   ⏱️ Thời lượng: Đang cập nhật\n*   ⭐ Đánh giá: Đang cập nhật\n*   📖 Mô tả: Khóa học giúp bạn nói tiếng Anh nhanh, chuẩn, linh hoạt trong mọi tình huống, tự tin giao tiếp với đối tác nước ngoài và làm chủ các tình huống giao tiếp hàng ngày trong công việc. Phương pháp học tập A.I.T.E.C.H tập trung vào giao tiếp và học viên, giúp nâng cao kỹ năng phản xạ và chỉnh sửa phát âm chuẩn quốc tế.\n\n💬 **Khóa Học Tiếng Anh Giao Tiếp**\n*   💰 Học phí: 3.000.000 VNĐ\n*   ⏱️ Thời lượng: Đang cập nhật\n*   ⭐ Đánh giá: Đang cập nhật\n*   📖 Mô tả: Khóa học giúp học viên phát triển các kỹ năng tiếng Anh phù hợp với mục tiêu học tập, nghề nghiệp và cá nhân. Đặc biệt phù hợp với những ai có ý định du học hoặc định cư, giúp bạn giao tiếp trôi chảy và tự tin hơn trong mọi tình huống.\n\n✨ **Lời khuyên:**\n\n*   Nếu bạn mới bắt đầu, khóa \"Tiếng Anh cho người mất gốc\" là lựa chọn tuyệt vời.\n*   Nếu bạn muốn luyện thi TOEIC, khóa \"TOEIC 4 Kỹ Năng\" sẽ giúp bạn đạt điểm cao.\n*   Nếu bạn muốn cải thiện khả năng giao tiếp, hãy chọn khóa \"Tiếng Anh Giao Tiếp\" hoặc \"Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\".\n\n📞 Để được tư vấn chi tiết hơn và lựa chọn khóa học phù hợp nhất, bạn có thể liên hệ hotline 0962.501.832 hoặc tiếp tục trao đổi với mình nhé! Mình luôn sẵn sàng hỗ trợ bạn. 👍', 'database_advice', '2025-11-05 12:26:47'),
(27, 0, 'hãy cho tôi xem tất cả danh sách các khóa học', 'Chào bạn, Fighter English Center rất vui được cung cấp danh sách các khóa học hiện có của trung tâm ạ! Dưới đây là thông tin chi tiết về từng khóa học để bạn tham khảo và lựa chọn nhé:\n\n📚 **Danh sách các khóa học tại Fighter English Center** 📚\n\n*   **Khóa học tiếng Anh cho người mất gốc**\n    *   💰 Học phí: 2.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: 5.00/5\n    *   📖 Mô tả: Khóa học được thiết kế dành riêng cho người mới bắt đầu, giúp xây dựng lại nền tảng tiếng Anh vững chắc. Bạn sẽ được học online, tương tác trực tiếp với giảng viên, và có lộ trình bài bản để phát triển toàn diện các kỹ năng.\n\n*   **Khóa học TOEIC 4 KỸ NĂNG**\n    *   💰 Học phí: 2.500.000 VNĐ\n    *   ⏱️ Thời lượng: 11 buổi\n    *   ⭐ Đánh giá: 5.00/5\n    *   📖 Mô tả: Khóa học này tập trung vào cả 4 kỹ năng nghe, nói, đọc, viết, giúp bạn cải thiện khả năng sử dụng tiếng Anh một cách toàn diện và chuẩn bị tốt nhất cho kỳ thi TOEIC.\n\n*   **Khóa học tiếng Anh cho trẻ em và thanh thiếu niên**\n    *   💰 Học phí: 2.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: Đang cập nhật\n    *   📖 Mô tả: Khóa học giúp trẻ phát triển sự sáng tạo, tăng cường các kỹ năng và khả năng tiếng Anh, ngôn ngữ chung của thế giới.\n\n*   **Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam**\n    *   💰 Học phí: 2.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: Đang cập nhật\n    *   📖 Mô tả: Khóa học giúp bạn nói nhanh, chuẩn, linh hoạt trong mọi tình huống, tự tin giao tiếp hàng ngày và trong công việc.\n\n*   **Khóa Học Tiếng Anh Giao Tiếp**\n    *   💰 Học phí: 3.000.000 VNĐ\n    *   ⏱️ Thời lượng: Đang cập nhật\n    *   ⭐ Đánh giá: Đang cập nhật\n    *   📖 Mô tả: Khóa học giúp bạn phát triển kỹ năng nghe-nói tối đa, mở rộng kiến thức và tăng khả năng tư duy, sáng tạo.\n\n✨ **Lời khuyên:**\n\n*   💡 Hãy xem xét mục tiêu học tập và trình độ hiện tại của bạn để chọn khóa học phù hợp nhất.\n*   👍 Đọc kỹ mô tả chi tiết của từng khóa học để hiểu rõ hơn về nội dung và phương pháp giảng dạy.\n*   ✅ Nếu bạn còn bất kỳ câu hỏi nào hoặc muốn được tư vấn cụ thể hơn, đừng ngần ngại liên hệ hotline của Fighter English Center theo số 0962.501.832. Hoặc bạn có thể hỏi thêm chatbot để được hỗ trợ nhanh chóng nhé!\n\nChúc bạn tìm được khóa học ưng ý và có những trải nghiệm học tập thật hiệu quả tại Fighter English Center! 🎯', 'database_advice', '2025-11-09 16:08:34');

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
(115, 1, 42, '2025-10-16', 'cho xac nhan', '2025-10-23 20:28:40', 'IELTS-0-7-01-25', NULL),
(116, 1, 36, '2025-10-25', 'da xac nhan', '2025-10-25 16:06:41', 'COM-1V1-01-25', NULL),
(118, 27, 42, '2025-10-29', 'da xac nhan', '2025-10-29 16:26:53', 'IELTS-0-7-01-25', NULL),
(120, 48, 41, '2025-11-06', 'da xac nhan', '2025-11-06 21:49:05', 'TOEIC-DE-02-25', NULL),
(123, 1, 43, '2025-11-09', 'cho xac nhan', '2025-11-09 16:30:26', NULL, NULL),
(125, 1, 44, '2025-11-09', 'da xac nhan', '2025-11-09 17:44:42', NULL, NULL);

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
(6, 1, 38, 5, 'Khóa học này dạy dễ hiểu quá.'),
(7, 1, 32, 5, 'Cô giáo dạy rất nhiệt tình dễ hiểu.');

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
(1532, 572, 54, 'go', 0),
(1533, 572, 54, 'goes', 1),
(1534, 572, 54, 'going', 0),
(1535, 572, 54, 'went', 0),
(1536, 573, 54, 'read', 0),
(1537, 573, 54, 'am reading', 1),
(1538, 573, 54, 'reads', 0),
(1539, 573, 54, 'have read', 0),
(1540, 574, 54, 'has', 0),
(1541, 574, 54, 'have', 1),
(1542, 574, 54, 'had', 0),
(1543, 574, 54, 'having', 0),
(1544, 575, 54, 'is', 0),
(1545, 575, 54, 'was', 1),
(1546, 575, 54, 'were', 0),
(1547, 575, 54, 'has been', 0),
(1548, 576, 54, 'go', 0),
(1549, 576, 54, 'will go', 1),
(1550, 576, 54, 'went', 0),
(1551, 576, 54, 'going', 0),
(1552, 577, 54, 'can', 1),
(1553, 577, 54, 'could', 0),
(1554, 577, 54, 'should', 0),
(1555, 578, 54, 'is', 0),
(1556, 578, 54, 'are', 1),
(1557, 578, 54, 'was', 0),
(1558, 578, 54, 'were', 0),
(1559, 579, 54, 'Do', 1),
(1560, 579, 54, 'Does', 0),
(1561, 579, 54, 'Did', 0),
(1562, 579, 54, 'Are', 0),
(1563, 580, 54, 'tall', 0),
(1564, 580, 54, 'taller', 1),
(1565, 580, 54, 'tallest', 0),
(1566, 580, 54, 'more tall', 0),
(1567, 581, 54, 'a', 0),
(1568, 581, 54, 'an', 1),
(1569, 581, 54, 'the', 0),
(1570, 582, 54, 'in', 0),
(1571, 582, 54, 'since', 1),
(1572, 582, 54, 'for', 0),
(1573, 582, 54, 'at', 0),
(1574, 583, 54, 'good', 0),
(1575, 583, 54, 'well', 1),
(1576, 583, 54, 'better', 0),
(1577, 583, 54, 'best', 0),
(1578, 584, 54, 'will', 1),
(1579, 584, 54, 'would', 0),
(1580, 584, 54, 'can', 0),
(1581, 585, 54, 'starts', 0),
(1582, 585, 54, 'started', 1),
(1583, 585, 54, 'has started', 0),
(1584, 585, 54, 'starting', 0),
(1585, 586, 54, 'has', 0),
(1586, 586, 54, 'have', 1),
(1587, 586, 54, 'had', 0),
(1588, 586, 54, 'having', 0),
(1589, 587, 54, 'that', 0),
(1590, 587, 54, 'if', 1),
(1591, 587, 54, 'what', 0),
(1592, 587, 54, 'which', 0),
(1593, 588, 54, 'built', 0),
(1594, 588, 54, 'was built', 1),
(1595, 588, 54, 'is built', 0),
(1596, 589, 54, 'must', 0),
(1597, 589, 54, 'should', 1),
(1598, 589, 54, 'can', 0),
(1599, 589, 54, 'may', 0),
(1600, 590, 54, 'can', 0),
(1601, 590, 54, 'could', 1),
(1602, 590, 54, 'will', 0),
(1603, 591, 54, 'at', 0),
(1604, 591, 54, 'in', 1),
(1605, 591, 54, 'on', 0),
(1606, 591, 54, 'of', 0),
(1823, 652, 58, 'live', 0),
(1824, 652, 58, 'lives', 1),
(1825, 652, 58, 'living', 0),
(1826, 653, 58, 'read', 0),
(1827, 653, 58, 'reads', 1),
(1828, 653, 58, 'reading', 0),
(1829, 653, 58, 'to read', 0),
(1830, 654, 58, 'rainy', 0),
(1831, 654, 58, 'sunny', 1),
(1832, 654, 58, 'cold', 0),
(1833, 654, 58, 'snowy', 0),
(1834, 655, 58, 'teacher', 0),
(1835, 655, 58, 'doctor', 1),
(1836, 655, 58, 'engineer', 0),
(1837, 656, 58, 'cook', 0),
(1838, 656, 58, 'cooks', 1),
(1839, 656, 58, 'cooking', 0),
(1840, 656, 58, 'cooked', 0),
(1841, 657, 58, 'playing', 0),
(1842, 657, 58, 'studying', 1),
(1843, 657, 58, 'sleeping', 0),
(1844, 658, 58, 'bird', 0),
(1845, 658, 58, 'cat', 1),
(1846, 658, 58, 'fish', 0),
(1847, 658, 58, 'rabbit', 0),
(1848, 659, 58, 'on', 0),
(1849, 659, 58, 'by', 1),
(1850, 659, 58, 'in', 0),
(1851, 660, 58, 'open', 0),
(1852, 660, 58, 'opens', 1),
(1853, 660, 58, 'opening', 0),
(1854, 660, 58, 'opened', 0),
(1855, 661, 58, 'basketball', 0),
(1856, 661, 58, 'football', 1),
(1857, 661, 58, 'tennis', 0),
(1858, 662, 58, 'speak', 0),
(1859, 662, 58, 'speaks', 1),
(1860, 662, 58, 'speaking', 0),
(1861, 662, 58, 'spoke', 0),
(1862, 663, 58, 'is', 0),
(1863, 663, 58, 'were', 1),
(1864, 663, 58, 'was', 0),
(1865, 664, 58, 'drink', 1),
(1866, 664, 58, 'drinks', 0),
(1867, 664, 58, 'drinking', 0),
(1868, 664, 58, 'drank', 0),
(1869, 665, 58, 'classroom', 0),
(1870, 665, 58, 'playground', 1),
(1871, 665, 58, 'library', 0),
(1872, 666, 58, 'young', 0),
(1873, 666, 58, 'younger', 1),
(1874, 666, 58, 'youngest', 0),
(1875, 666, 58, 'more young', 0),
(1876, 667, 58, 'make', 0),
(1877, 667, 58, 'do', 1),
(1878, 667, 58, 'finish', 0),
(1879, 668, 58, 'go', 0),
(1880, 668, 58, 'goes', 1),
(1881, 668, 58, 'going', 0),
(1882, 668, 58, 'went', 0),
(1883, 669, 58, 'boring', 0),
(1884, 669, 58, 'interesting', 1),
(1885, 669, 58, 'tired', 0),
(1886, 670, 58, 'do', 0),
(1887, 670, 58, 'be', 1),
(1888, 670, 58, 'make', 0),
(1889, 670, 58, 'become', 0),
(1890, 671, 58, 'in', 0),
(1891, 671, 58, 'on', 1),
(1892, 671, 58, 'at', 0),
(1893, 671, 58, 'under', 0),
(1965, 692, 60, 'aunt', 0),
(1966, 692, 60, 'grandmother', 1),
(1967, 692, 60, 'mother', 0),
(1968, 692, 60, 'sister', 0),
(1969, 693, 60, 'cousin', 0),
(1970, 693, 60, 'uncle', 1),
(1971, 693, 60, 'nephew', 0),
(1972, 694, 60, 'cousin', 0),
(1973, 694, 60, 'nephew', 1),
(1974, 694, 60, 'niece', 0),
(1975, 694, 60, 'son', 0),
(1976, 695, 60, 'daughter', 0),
(1977, 695, 60, 'niece', 1),
(1978, 695, 60, 'cousin', 0),
(1979, 695, 60, 'nephew', 0),
(1980, 696, 60, 'grandmother', 0),
(1981, 696, 60, 'aunt', 1),
(1982, 696, 60, 'cousin', 0),
(1983, 697, 60, 'uncle', 0),
(1984, 697, 60, 'father-in-law', 1),
(1985, 697, 60, 'stepfather', 0),
(1986, 697, 60, 'grandfather', 0),
(1987, 698, 60, 'aunt', 0),
(1988, 698, 60, 'mother-in-law', 1),
(1989, 698, 60, 'stepmother', 0),
(1990, 699, 60, 'niece', 0),
(1991, 699, 60, 'daughter-in-law', 1),
(1992, 699, 60, 'sister-in-law', 0),
(1993, 699, 60, 'cousin', 0),
(1994, 700, 60, 'nephew', 0),
(1995, 700, 60, 'son-in-law', 1),
(1996, 700, 60, 'brother-in-law', 0),
(1997, 701, 60, 'cousin', 0),
(1998, 701, 60, 'sister-in-law', 1),
(1999, 701, 60, 'aunt', 0),
(2000, 701, 60, 'niece', 0),
(2001, 702, 60, 'nephews', 0),
(2002, 702, 60, 'cousins', 1),
(2003, 702, 60, 'siblings', 0),
(2004, 703, 60, 'aunt', 0),
(2005, 703, 60, 'stepmother', 1),
(2006, 703, 60, 'mother-in-law', 0),
(2007, 703, 60, 'grandmother', 0),
(2008, 704, 60, 'uncle', 0),
(2009, 704, 60, 'stepfather', 1),
(2010, 704, 60, 'father-in-law', 0),
(2011, 705, 60, 'cousins', 0),
(2012, 705, 60, 'stepsiblings', 1),
(2013, 705, 60, 'half-siblings', 0),
(2014, 705, 60, 'siblings', 0),
(2015, 706, 60, 'ancestors', 0),
(2016, 706, 60, 'great-grandparents', 1),
(2017, 706, 60, 'grandparents', 0),
(2018, 707, 60, 'son', 0),
(2019, 707, 60, 'father', 1),
(2020, 707, 60, 'brother', 0),
(2021, 707, 60, 'uncle', 0),
(2022, 708, 60, 'daughter', 0),
(2023, 708, 60, 'mother', 1),
(2024, 708, 60, 'sister', 0),
(2025, 709, 60, 'parents', 0),
(2026, 709, 60, 'grandparents', 1),
(2027, 709, 60, 'ancestors', 0),
(2028, 709, 60, 'relatives', 0),
(2029, 710, 60, 'grandparents', 0),
(2030, 710, 60, 'parents', 1),
(2031, 710, 60, 'relatives', 0),
(2032, 711, 60, 'parents', 0),
(2033, 711, 60, 'siblings', 1),
(2034, 711, 60, 'cousins', 0),
(2035, 711, 60, 'relatives', 0),
(2111, 732, 63, 'make', 0),
(2112, 732, 63, 'do', 1),
(2113, 732, 63, 'go', 0),
(2114, 732, 63, 'are', 0),
(2115, 733, 63, 'see', 0),
(2116, 733, 63, 'meet', 1),
(2117, 733, 63, 'know', 0),
(2118, 734, 63, 'work', 0),
(2119, 734, 63, 'job', 1),
(2120, 734, 63, 'career', 0),
(2121, 734, 63, 'profession', 0),
(2122, 735, 63, 'make', 0),
(2123, 735, 63, 'do', 1),
(2124, 735, 63, 'give', 0),
(2125, 735, 63, 'help', 0),
(2126, 736, 63, 'searching', 0),
(2127, 736, 63, 'looking', 1),
(2128, 736, 63, 'finding', 0),
(2129, 737, 63, 'Take', 0),
(2130, 737, 63, 'Help', 1),
(2131, 737, 63, 'Make', 0),
(2132, 737, 63, 'Eat', 0),
(2133, 738, 63, 'talk', 0),
(2134, 738, 63, 'speak', 1),
(2135, 738, 63, 'say', 0),
(2136, 738, 63, 'tell', 0),
(2137, 739, 63, 'do', 0),
(2138, 739, 63, 'make', 1),
(2139, 739, 63, 'get', 0),
(2140, 740, 63, 'begin', 0),
(2141, 740, 63, 'start', 1),
(2142, 740, 63, 'open', 0),
(2143, 740, 63, 'finish', 0),
(2144, 741, 63, 'talk', 0),
(2145, 741, 63, 'speak', 1),
(2146, 741, 63, 'say', 0),
(2147, 741, 63, 'call', 0),
(2148, 742, 63, 'seeing', 0),
(2149, 742, 63, 'looking', 1),
(2150, 742, 63, 'watching', 0),
(2151, 743, 63, 'What', 0),
(2152, 743, 63, 'How', 1),
(2153, 743, 63, 'Who', 0),
(2154, 743, 63, 'Why', 0),
(2155, 744, 63, 'fine', 0),
(2156, 744, 63, 'welcome', 1),
(2157, 744, 63, 'good', 0),
(2158, 744, 63, 'nice', 0),
(2159, 745, 63, 'open', 0),
(2160, 745, 63, 'opening', 1),
(2161, 745, 63, 'to open', 0),
(2162, 746, 63, 'tell', 0),
(2163, 746, 63, 'introduce', 1),
(2164, 746, 63, 'say', 0),
(2165, 746, 63, 'speak', 0),
(2166, 747, 63, 'toilet', 1),
(2167, 747, 63, 'station', 0),
(2168, 747, 63, 'airport', 0),
(2169, 748, 63, 'early', 0),
(2170, 748, 63, 'late', 1),
(2171, 748, 63, 'soon', 0),
(2172, 748, 63, 'fast', 0),
(2173, 749, 63, 'give', 0),
(2174, 749, 63, 'leave', 1),
(2175, 749, 63, 'take', 0),
(2176, 749, 63, 'send', 0),
(2177, 750, 63, 'some', 1),
(2178, 750, 63, 'any', 0),
(2179, 750, 63, 'a', 0),
(2180, 751, 63, 'good', 0),
(2181, 751, 63, 'safe', 1),
(2182, 751, 63, 'nice', 0),
(2183, 751, 63, 'happy', 0),
(2184, 752, 64, 'go', 1),
(2185, 752, 64, 'goes', 0),
(2186, 752, 64, 'went', 0),
(2187, 752, 64, 'going', 0),
(2188, 753, 64, 'watches', 0),
(2189, 753, 64, 'was watching', 1),
(2190, 753, 64, 'watched', 0),
(2191, 754, 64, 'live', 0),
(2192, 754, 64, 'have lived', 1),
(2193, 754, 64, 'lived', 0),
(2194, 754, 64, 'are living', 0),
(2195, 755, 64, 'finish', 0),
(2196, 755, 64, 'will have finished', 1),
(2197, 755, 64, 'are finishing', 0),
(2198, 755, 64, 'finished', 0),
(2199, 756, 64, 'finished', 0),
(2200, 756, 64, 'had finished', 1),
(2201, 756, 64, 'has finished', 0),
(2202, 757, 64, 'wait', 0),
(2203, 757, 64, 'will have been waiting', 1),
(2204, 757, 64, 'have waited', 0),
(2205, 757, 64, 'am waiting', 0),
(2206, 758, 64, 'sells', 0),
(2207, 758, 64, 'will sell', 1),
(2208, 758, 64, 'is selling', 0),
(2209, 759, 64, 'watch', 0),
(2210, 759, 64, 'am watching', 1),
(2211, 759, 64, 'watched', 0),
(2212, 759, 64, 'have watched', 0),
(2213, 760, 64, 'are', 0),
(2214, 760, 64, 'have been', 1),
(2215, 760, 64, 'were', 0),
(2216, 760, 64, 'had been', 0),
(2217, 761, 64, 'leave', 0),
(2218, 761, 64, 'leaves', 1),
(2219, 761, 64, 'left', 0),
(2220, 762, 64, 'has', 0),
(2221, 762, 64, 'was having', 1),
(2222, 762, 64, 'had', 0),
(2223, 762, 64, 'is having', 0),
(2224, 763, 64, 'read', 0),
(2225, 763, 64, 'have read', 1),
(2226, 763, 64, 'am reading', 0),
(2227, 764, 64, 'studies', 0),
(2228, 764, 64, 'has been studying', 1),
(2229, 764, 64, 'studied', 0),
(2230, 764, 64, 'is studying', 0),
(2231, 765, 64, 'live', 0),
(2232, 765, 64, 'will have lived', 1),
(2233, 765, 64, 'have lived', 0),
(2234, 766, 64, 'goes', 0),
(2235, 766, 64, 'went', 1),
(2236, 766, 64, 'has gone', 0),
(2237, 766, 64, 'was going', 0),
(2238, 767, 64, 'lost', 0),
(2239, 767, 64, 'have lost', 1),
(2240, 767, 64, 'lose', 0),
(2241, 768, 64, 'rise', 0),
(2242, 768, 64, 'rises', 1),
(2243, 768, 64, 'rose', 0),
(2244, 768, 64, 'is rising', 0),
(2245, 769, 64, 'are', 0),
(2246, 769, 64, 'were', 1),
(2247, 769, 64, 'was', 0),
(2248, 770, 64, 'have', 0),
(2249, 770, 64, 'were having', 1),
(2250, 770, 64, 'had', 0),
(2251, 770, 64, 'had had', 0),
(2252, 771, 64, 'go', 0),
(2253, 771, 64, 'goes', 1),
(2254, 771, 64, 'went', 0),
(2255, 771, 64, 'is going', 0),
(2256, 772, 65, 'at', 0),
(2257, 772, 65, 'in', 1),
(2258, 772, 65, 'on', 0),
(2259, 773, 65, 'in', 0),
(2260, 773, 65, 'at', 1),
(2261, 773, 65, 'on', 0),
(2262, 773, 65, 'to', 0),
(2263, 774, 65, 'in', 0),
(2264, 774, 65, 'on', 1),
(2265, 774, 65, 'at', 0),
(2266, 774, 65, 'under', 0),
(2267, 775, 65, 'in', 0),
(2268, 775, 65, 'on', 1),
(2269, 775, 65, 'at', 0),
(2270, 776, 65, 'on', 0),
(2271, 776, 65, 'in', 1),
(2272, 776, 65, 'at', 0),
(2273, 776, 65, 'from', 0),
(2274, 777, 65, 'in', 0),
(2275, 777, 65, 'at', 1),
(2276, 777, 65, 'on', 0),
(2277, 778, 65, 'at', 0),
(2278, 778, 65, 'in', 1),
(2279, 778, 65, 'on', 0),
(2280, 778, 65, 'for', 0),
(2281, 779, 65, 'in', 0),
(2282, 779, 65, 'at', 1),
(2283, 779, 65, 'on', 0),
(2284, 780, 65, 'at', 0),
(2285, 780, 65, 'in', 1),
(2286, 780, 65, 'on', 0),
(2287, 780, 65, 'by', 0),
(2288, 781, 65, 'on', 0),
(2289, 781, 65, 'under', 1),
(2290, 781, 65, 'above', 0),
(2291, 782, 65, 'at', 0),
(2292, 782, 65, 'in', 1),
(2293, 782, 65, 'on', 0),
(2294, 782, 65, 'by', 0),
(2295, 783, 65, 'across', 0),
(2296, 783, 65, 'through', 1),
(2297, 783, 65, 'over', 0),
(2298, 784, 65, 'under', 0),
(2299, 784, 65, 'above', 1),
(2300, 784, 65, 'between', 0),
(2301, 784, 65, 'beside', 0),
(2302, 785, 65, 'with', 0),
(2303, 785, 65, 'of', 1),
(2304, 785, 65, 'for', 0),
(2305, 786, 65, 'in', 0),
(2306, 786, 65, 'at', 1),
(2307, 786, 65, 'to', 0),
(2308, 786, 65, 'on', 0),
(2309, 787, 65, 'in', 0),
(2310, 787, 65, 'on', 1),
(2311, 787, 65, 'at', 0),
(2312, 788, 65, 'to', 0),
(2313, 788, 65, 'for', 1),
(2314, 788, 65, 'in', 0),
(2315, 788, 65, 'on', 0),
(2316, 789, 65, 'with', 0),
(2317, 789, 65, 'from', 1),
(2318, 789, 65, 'to', 0),
(2319, 790, 65, 'on', 0),
(2320, 790, 65, 'by', 1),
(2321, 790, 65, 'with', 0),
(2322, 790, 65, 'in', 0),
(2323, 791, 65, 'to', 0),
(2324, 791, 65, 'for', 1),
(2325, 791, 65, 'about', 0),
(2326, 791, 65, 'of', 0),
(2469, 832, 68, 'aunt', 0),
(2470, 832, 68, 'grandmother', 1),
(2471, 832, 68, 'mother', 0),
(2472, 832, 68, 'sister', 0),
(2473, 833, 68, 'cousin', 0),
(2474, 833, 68, 'uncle', 1),
(2475, 833, 68, 'nephew', 0),
(2476, 834, 68, 'cousin', 0),
(2477, 834, 68, 'nephew', 1),
(2478, 834, 68, 'niece', 0),
(2479, 834, 68, 'son', 0),
(2480, 835, 68, 'daughter', 0),
(2481, 835, 68, 'niece', 1),
(2482, 835, 68, 'cousin', 0),
(2483, 835, 68, 'nephew', 0),
(2484, 836, 68, 'grandmother', 0),
(2485, 836, 68, 'aunt', 1),
(2486, 836, 68, 'cousin', 0),
(2487, 837, 68, 'uncle', 0),
(2488, 837, 68, 'father-in-law', 1),
(2489, 837, 68, 'stepfather', 0),
(2490, 837, 68, 'grandfather', 0),
(2491, 838, 68, 'aunt', 0),
(2492, 838, 68, 'mother-in-law', 1),
(2493, 838, 68, 'stepmother', 0),
(2494, 839, 68, 'niece', 0),
(2495, 839, 68, 'daughter-in-law', 1),
(2496, 839, 68, 'sister-in-law', 0),
(2497, 839, 68, 'cousin', 0),
(2498, 840, 68, 'nephew', 0),
(2499, 840, 68, 'son-in-law', 1),
(2500, 840, 68, 'brother-in-law', 0),
(2501, 841, 68, 'cousin', 0),
(2502, 841, 68, 'sister-in-law', 1),
(2503, 841, 68, 'aunt', 0),
(2504, 841, 68, 'niece', 0),
(2505, 842, 68, 'nephews', 0),
(2506, 842, 68, 'cousins', 1),
(2507, 842, 68, 'siblings', 0),
(2508, 843, 68, 'aunt', 0),
(2509, 843, 68, 'stepmother', 1),
(2510, 843, 68, 'mother-in-law', 0),
(2511, 843, 68, 'grandmother', 0),
(2512, 844, 68, 'uncle', 0),
(2513, 844, 68, 'stepfather', 1),
(2514, 844, 68, 'father-in-law', 0),
(2515, 845, 68, 'cousins', 0),
(2516, 845, 68, 'stepsiblings', 1),
(2517, 845, 68, 'half-siblings', 0),
(2518, 845, 68, 'siblings', 0),
(2519, 846, 68, 'ancestors', 0),
(2520, 846, 68, 'great-grandparents', 1),
(2521, 846, 68, 'grandparents', 0),
(2522, 847, 68, 'son', 0),
(2523, 847, 68, 'father', 1),
(2524, 847, 68, 'brother', 0),
(2525, 847, 68, 'uncle', 0),
(2526, 848, 68, 'daughter', 0),
(2527, 848, 68, 'mother', 1),
(2528, 848, 68, 'sister', 0),
(2529, 849, 68, 'parents', 0),
(2530, 849, 68, 'grandparents', 1),
(2531, 849, 68, 'ancestors', 0),
(2532, 849, 68, 'relatives', 0),
(2533, 850, 68, 'grandparents', 0),
(2534, 850, 68, 'parents', 1),
(2535, 850, 68, 'relatives', 0),
(2536, 851, 68, 'parents', 0),
(2537, 851, 68, 'siblings', 1),
(2538, 851, 68, 'cousins', 0),
(2539, 851, 68, 'relatives', 0),
(2611, 883, 70, 'interesting', 0),
(2612, 883, 70, 'more interesting', 1),
(2613, 883, 70, 'most interesting', 0),
(2614, 884, 70, 'smart', 0),
(2615, 884, 70, 'smartest', 1),
(2616, 884, 70, 'smarter', 0),
(2617, 884, 70, 'more smart', 0),
(2618, 885, 70, 'hot', 0),
(2619, 885, 70, 'hotter', 1),
(2620, 885, 70, 'hottest', 0),
(2621, 885, 70, 'more hot', 0),
(2622, 886, 70, 'tall', 0),
(2623, 886, 70, 'tallest', 1),
(2624, 886, 70, 'taller', 0),
(2625, 887, 70, 'expensive', 0),
(2626, 887, 70, 'more expensive', 1),
(2627, 887, 70, 'most expensive', 0),
(2628, 887, 70, 'expensiver', 0),
(2629, 888, 70, 'tall as', 0),
(2630, 888, 70, 'as tall as', 1),
(2631, 888, 70, 'taller than', 0),
(2632, 889, 70, 'difficult', 0),
(2633, 889, 70, 'more difficult', 1),
(2634, 889, 70, 'most difficult', 0),
(2635, 889, 70, 'difficulter', 0),
(2636, 890, 70, 'beautiful', 0),
(2637, 890, 70, 'most beautifully', 1),
(2638, 890, 70, 'more beautifully', 0),
(2639, 891, 70, 'cold', 0),
(2640, 891, 70, 'colder', 1),
(2641, 891, 70, 'coldest', 0),
(2642, 891, 70, 'more cold', 0),
(2643, 892, 70, 'good', 0),
(2644, 892, 70, 'best', 1),
(2645, 892, 70, 'better', 0),
(2646, 893, 70, 'easy', 0),
(2647, 893, 70, 'easier', 1),
(2648, 893, 70, 'easiest', 0),
(2649, 893, 70, 'more easy', 0),
(2650, 894, 70, 'fast', 0),
(2651, 894, 70, 'faster', 1),
(2652, 894, 70, 'fastest', 0),
(2653, 895, 70, 'delicious', 0),
(2654, 895, 70, 'most delicious', 1),
(2655, 895, 70, 'more delicious', 0),
(2656, 895, 70, 'deliciouser', 0),
(2657, 896, 70, 'valuable', 0),
(2658, 896, 70, 'more valuable', 1),
(2659, 896, 70, 'most valuable', 0),
(2660, 897, 70, 'kind', 0),
(2661, 897, 70, 'the kindest', 1),
(2662, 897, 70, 'kinder', 0),
(2663, 897, 70, 'more kind', 0),
(2664, 898, 70, 'easier than', 0),
(2665, 898, 70, 'easier as', 1),
(2666, 898, 70, 'easy than', 0),
(2667, 899, 70, 'as - than', 0),
(2668, 899, 70, 'as - as', 1),
(2669, 899, 70, 'more - than', 0),
(2670, 899, 70, 'than - as', 0),
(2671, 900, 70, 'high', 0),
(2672, 900, 70, 'the highest', 1),
(2673, 900, 70, 'higher', 0),
(2674, 901, 70, 'far', 0),
(2675, 901, 70, 'farther', 1),
(2676, 901, 70, 'farthest', 0),
(2677, 901, 70, 'more far', 0),
(2678, 902, 70, 'more - than', 0),
(2679, 902, 70, 'as - as', 1),
(2680, 902, 70, 'so - as', 0),
(2681, 902, 70, 'as - than', 0),
(2682, 903, 71, 'but', 0),
(2683, 903, 71, 'and', 1),
(2684, 903, 71, 'or', 0),
(2685, 904, 71, 'because', 0),
(2686, 904, 71, 'so', 1),
(2687, 904, 71, 'but', 0),
(2688, 904, 71, 'although', 0),
(2689, 905, 71, 'and', 0),
(2690, 905, 71, 'but', 1),
(2691, 905, 71, 'so', 0),
(2692, 905, 71, 'or', 0),
(2693, 906, 71, 'Because', 0),
(2694, 906, 71, 'Although', 1),
(2695, 906, 71, 'So', 0),
(2696, 907, 71, 'but', 0),
(2697, 907, 71, 'if', 1),
(2698, 907, 71, 'because', 0),
(2699, 907, 71, 'so', 0),
(2700, 908, 71, 'but', 0),
(2701, 908, 71, 'and', 1),
(2702, 908, 71, 'or', 0),
(2703, 909, 71, 'because', 0),
(2704, 909, 71, 'so', 1),
(2705, 909, 71, 'but', 0),
(2706, 909, 71, 'and', 0),
(2707, 910, 71, 'Because', 0),
(2708, 910, 71, 'Although', 1),
(2709, 910, 71, 'So', 0),
(2710, 911, 71, 'and', 0),
(2711, 911, 71, 'or', 1),
(2712, 911, 71, 'but', 0),
(2713, 911, 71, 'so', 0),
(2714, 912, 71, 'while', 0),
(2715, 912, 71, 'when', 1),
(2716, 912, 71, 'because', 0),
(2717, 913, 71, 'but', 0),
(2718, 913, 71, 'and', 1),
(2719, 913, 71, 'or', 0),
(2720, 913, 71, 'so', 0),
(2721, 914, 71, 'because', 0),
(2722, 914, 71, 'so', 1),
(2723, 914, 71, 'but', 0),
(2724, 915, 71, 'While', 0),
(2725, 915, 71, 'When', 1),
(2726, 915, 71, 'Because', 0),
(2727, 915, 71, 'Although', 0),
(2728, 916, 71, 'so', 0),
(2729, 916, 71, 'because', 1),
(2730, 916, 71, 'but', 0),
(2731, 917, 71, 'but', 0),
(2732, 917, 71, 'and', 1),
(2733, 917, 71, 'or', 0),
(2734, 917, 71, 'so', 0),
(2735, 918, 71, 'if', 0),
(2736, 918, 71, 'in case', 1),
(2737, 918, 71, 'because', 0),
(2738, 918, 71, 'although', 0),
(2739, 919, 71, 'because', 0),
(2740, 919, 71, 'so that', 1),
(2741, 919, 71, 'but', 0),
(2742, 920, 71, 'because', 0),
(2743, 920, 71, 'so', 1),
(2744, 920, 71, 'but', 0),
(2745, 920, 71, 'and', 0),
(2746, 921, 71, 'When', 0),
(2747, 921, 71, 'If', 1),
(2748, 921, 71, 'Because', 0),
(2749, 922, 71, 'so', 0),
(2750, 922, 71, 'because', 1),
(2751, 922, 71, 'but', 0),
(2752, 922, 71, 'although', 0);

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
(184, 51, 973, 2754, NULL, NULL, NULL, 'da_cham'),
(185, 52, 974, 2755, NULL, NULL, NULL, 'da_cham'),
(186, 53, 974, 2755, NULL, NULL, NULL, 'da_cham'),
(187, 54, 974, 2755, NULL, NULL, NULL, 'da_cham'),
(188, 55, 973, 2753, NULL, NULL, NULL, 'da_cham'),
(189, 56, 973, 2753, NULL, NULL, NULL, 'da_cham'),
(190, 57, 974, 2755, NULL, NULL, NULL, 'da_cham'),
(191, 58, 974, 2755, NULL, NULL, NULL, 'da_cham'),
(192, 59, 974, 2755, NULL, NULL, NULL, 'da_cham'),
(193, 60, 974, 2755, NULL, NULL, NULL, 'da_cham');

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
(18, 1, 'TOEIC-4S-01-25', 23, 'co mat', '2025-10-24', NULL),
(19, 1, 'TOEIC-4S-01-25', 24, 'co mat', '2025-10-24', NULL),
(20, 1, 'TOEIC-4S-01-25', 25, 'co mat', '2025-10-24', NULL),
(21, 1, 'TOEIC-4S-01-25', 132, 'co mat', '2025-10-24', NULL),
(22, 1, 'TOEIC-4S-01-25', 133, 'co mat', '2025-10-24', NULL),
(23, 1, 'TOEIC-4S-01-25', 134, 'vang', '2025-10-24', NULL),
(24, 1, 'TOEIC-4S-01-25', 135, 'vang', '2025-10-24', NULL),
(25, 1, 'TOEIC-4S-01-25', 136, 'vang', '2025-10-24', NULL),
(26, 1, 'TOEIC-4S-01-25', 137, 'vang', '2025-10-24', NULL),
(27, 1, 'TOEIC-4S-01-25', 138, 'vang', '2025-10-24', NULL),
(28, 1, 'TOEIC-4S-01-25', 139, 'vang', '2025-10-24', NULL),
(29, 1, 'TOEIC-4S-01-25', 140, 'vang', '2025-10-24', NULL),
(30, 1, 'TOEIC-4S-01-25', 141, 'vang', '2025-10-24', NULL);

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
(1, 'Hoa', '033361243', '$2y$10$80CAXdjjYKc92cNOKIgKO.SECOLE7xkNpBFnXgqmCnljyuKfMQd3S', 'hoa@gmail.com', 'Chuyên gia luyện thi IELTS với 8 năm kinh nghiệm. Đạt 8.5 IELTS Overall. Phương pháp giảng dạy tập trung vào chiến lược làm bài và phát triển tư duy ngôn ngữ.', 'uploads/lecturers/1757966537_Binh-Ba-du-lich-2-8797-1649732806.jpg'),
(2, 'Nguyễn Trần Anh Ngọc', '012345465', '$2y$10$BZK736oz63N1tMeWY7DLnePQf/R4pwMcc4pdP8pF4NdQtFFwAjEma', 'hieutran170626@gmail.com', 'Chuyên gia luyện thi IELTS với 8 năm kinh nghiệm. Đạt 8.5 IELTS Overall. Phương pháp giảng dạy tập trung vào chiến lược làm bài và phát triển tư duy ngôn ngữ.', 'uploads/lecturers/1757966912_dia-diem-du-lich-30-4-mien-nam-2-1713866323.jpg'),
(3, 'Lê Thị Mai Anh', '0987654321', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'maianh.le@teacher.edu.vn', 'Chuyên gia luyện thi IELTS với 8 năm kinh nghiệm. Đạt 8.5 IELTS Overall. Phương pháp giảng dạy tập trung vào chiến lược làm bài và phát triển tư duy ngôn ngữ.', 'uploads/lecturers/1762463638_dia-diem-du-lich-30-4-mien-nam-7-1713866336.jpg'),
(4, 'Nguyễn Minh Tuấn', '0912345678', '$2y$10$Tc.QQmpKCIMdWcHcmVc0q.AI0I2WbLVPOqQ4u2fp08cpgZiVxXzOS', 'tuan.nguyen@teacher.edu.vn', 'Giảng viên chuyên sâu về TOEIC Listening & Reading, đạt 990/990. Có nhiều học viên đạt mục tiêu 750+.', 'uploads/lecturers/1762463656_ha-giang-thang-6-1.jpg'),
(5, 'Trần Thu Hà', '0905112233', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'hathu.tran@teacher.edu.vn', 'Với 5 năm kinh nghiệm giảng dạy tiếng Anh giao tiếp và tiếng Anh thương mại. Giúp học viên tự tin sử dụng tiếng Anh trong môi trường công sở.', 'uploads/lecturers/1762463682_dia-diem-du-lich-30-4-mien-nam-2-1713866323.jpg'),
(6, 'Phạm Hoàng Long', '0334567890', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', 'long.pham@teacher.edu.vn', 'Giảng viên tận tâm chuyên dạy các lớp mất gốc và tiếng Anh cho người mới bắt đầu. Phương pháp dạy chậm, chắc và tạo động lực cho học viên.', 'uploads/lecturers/1762463667_du-lich-mien-trung-1.webp'),
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
  `is_admin` tinyint(1) DEFAULT 0,
  `hinh_anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hocvien`
--

INSERT INTO `hocvien` (`id_hocvien`, `ten_hocvien`, `email`, `so_dien_thoai`, `mat_khau`, `trinh_do`, `verification_token`, `token_expiry`, `is_verified`, `is_admin`, `hinh_anh`) VALUES
(1, 'Trần Hữu Hiếu', 'hieutran170626@gmail.com', '0337123222', '$2y$10$fEdaEvMOF2hbGUNc6snnZe0SYdXw5ipunvybYlV2BKgfDO6qvKiza', 'Cơ bản (A1-A2)', NULL, NULL, 1, 0, 'uploads/students/1762704206_du-lich-mien-trung-4.webp'),
(26, 'Hieu Huu', 'hieutran170619@gmail.com', '0123456789', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 0, NULL),
(27, 'Admin1', 'T123456@gmail.com', '0123456781', '$2y$10$cTnTEQ2WdJNCGwiiYkOKsug1lvvBaSFjHZsajC3TPIfw3IPXvp4HG', 'Sơ cấp (A1)', NULL, NULL, 1, 1, 'uploads/students/1762665211_du-lich-mien-trung-7.webp'),
(29, 'Nguyễn Văn A ', 'A123456@gmail.com', '0332343454', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 0, NULL),
(30, 'Thu Phương ', 'Tp123456@gmail.com', '0387254814', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 0, NULL),
(31, 'Nguyễn Hải ', 'NugyenHai1@gmail.com', '0866264811', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 0, NULL),
(32, 'Nguyễn Ngọc Lâm', 'Lamngoc23@gmail.com', '0382648264', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 0, NULL),
(33, 'Hiền', 'admin@gmail.com', '0974928364', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, NULL, NULL, 1, 1, NULL),
(37, 'Plee', 'nthuphuong2710@gmail.com', '084535274', '$2y$10$PmdVCiif//irfQpXD51c.u1JSThDU1vQBvX0I1W/8WVFN33dTuRIi', NULL, NULL, NULL, 1, 1, NULL),
(41, 'Trần Hữu Hiếu', 'hieutran@gmail.com', '0375635352', '$2y$10$0wGRYQUSBNJs01QXHijQvePn.Hmh2gauF/tFNsZTKeIINbvdZtLv.', NULL, NULL, NULL, 1, 0, NULL),
(42, 'Trần Hữu Hiếu', 'hieutran17@gmail.com', '0485636483', '$2y$10$QeFNKr065e.75rq0F0e1HOXK6rUgUQQ6igY7W3zXuLF1acw/6vLhe', NULL, NULL, NULL, 1, 1, NULL),
(43, 'Trần Hữu Hiếu', 'hieutran1706111126@gmail.com', '0485637483', '$2y$10$FSFFVTaHNGbmecbHb0ju3eEulKdnb9EAQfNw1NBOwZ86pQE7rcMB6', NULL, NULL, NULL, 1, 0, NULL),
(47, 'Trần Hữu Hiếu', 'hieutran170618@gmail.com', '0374656383', '$2y$10$gMsGzwsH2klPxCZ0h4LThOdF.O.7xv6AWiynnBrVayLMBzrPCJIKS', NULL, '292448', '2025-10-14 23:48:28', 1, 0, NULL),
(48, 'Trần Hữu', 'hieutran170623@gmail.com', '0868999888', '$2y$10$v8bQK13FtZoJl6oPR39BVOyzQvm2pHDN9qFaUUbThAWivowECOj3G', NULL, NULL, NULL, 1, 0, NULL);

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
(62, 32, NULL, 'Tài liệu tham khảo', 'JPG', 'uploads/materials/1762708735_ba-na-hills-da-nang-1_1718101696.jpg', '2025-11-09 17:18:55'),
(63, 38, NULL, 'Tài liệu tham khảo 2 ', 'MP3', 'uploads/materials/1762709322_Peanut Butter & Jelly - Kids Songs - Super Simple Songs.mp3', '2025-11-09 17:28:42'),
(67, 32, NULL, 'Tài liệu tham khảo 3', 'MP4', 'uploads/materials/1762710847_Do You Like Broccoli Ice Cream- - Food Song for Kids! - Super Simple Songs.mp4', '2025-11-09 17:54:07'),
(68, NULL, 'BASIC-01-25', 'Tài liệu ngữ pháp ', 'JPG', 'uploads/materials/1762711132_z7165630523051_55fde7a3e8f4157e98419c412b260570.jpg', '2025-11-09 17:58:52');

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
(51, NULL, 27, NULL, 10.00, '2025-11-09 02:43:50'),
(52, NULL, 27, NULL, 10.00, '2025-11-09 02:45:08'),
(53, NULL, 27, NULL, 10.00, '2025-11-09 02:45:33'),
(54, NULL, 27, NULL, 10.00, '2025-11-09 02:45:42'),
(55, NULL, 27, NULL, 0.00, '2025-11-09 02:45:47'),
(56, NULL, 27, NULL, 0.00, '2025-11-09 02:47:43'),
(57, NULL, 27, NULL, 10.00, '2025-11-09 02:48:55'),
(58, NULL, 27, NULL, 10.00, '2025-11-09 02:55:11'),
(59, NULL, 27, NULL, 10.00, '2025-11-09 02:55:37'),
(60, NULL, 27, NULL, 10.00, '2025-11-09 02:56:01');

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
  `danh_gia_tb` decimal(3,2) DEFAULT NULL,
  `cap_do` varchar(50) DEFAULT NULL COMMENT 'Cấp độ của khóa học (Beginner, Intermediate, IELTS 5.0+,...)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khoahoc`
--

INSERT INTO `khoahoc` (`id_khoahoc`, `ten_khoahoc`, `mo_ta`, `thoi_gian`, `chi_phi`, `hinh_anh`, `danh_gia_tb`, `cap_do`) VALUES
(32, 'Khóa học tiếng Anh cho người mất gốc', '<p>Kh&oacute;a học tiếng anh online cho người mất gốc l&agrave; kh&oacute;a học được thiết kế d&agrave;nh ri&ecirc;ng cho những người bắt đầu học tiếng Anh từ con số 0 tr&ecirc;n nền tảng trực tuyến. Những học vi&ecirc;n bị mất căn bản &amp; cần x&acirc;y dựng lại nền tảng kiến thức Anh ngữ từ đầu v&agrave; tiết kiệm thời gian di chuyển đến trung t&acirc;m th&igrave; c&oacute; thể tham khảo kh&oacute;a học n&agrave;y nh&eacute;!<br />\r\nLộ tr&igrave;nh kh&oacute;a học được x&acirc;y dựng b&agrave;i bản, tập trung v&agrave;o những chủ đề gần gũi, thiết thực trong đời sống. Ngo&agrave;i ra, kh&oacute;a học hướng tới yếu tố &ldquo;học s&acirc;u, nhớ l&acirc;u&rdquo;, ph&aacute;t triển kỹ năng tập trung gi&uacute;p người học tiếng Anh từ &ldquo;zero&rdquo; th&agrave;nh &ldquo;hero&rdquo;.</p>\r\n\r\n<h3>Ưu điểm của kh&oacute;a tiếng Anh online cho người mất gốc:</h3>\r\n\r\n<ul>\r\n	<li>Được thiết kế d&agrave;nh ri&ecirc;ng cho người mất gốc tiếng Anh tr&ecirc;n nền tảng học online</li>\r\n	<li>Học bất bất cứ nơi đ&acirc;u, bất cứ thời gian n&agrave;o theo lịch rảnh của bản th&acirc;n</li>\r\n	<li>Học trực tiếp với giảng vi&ecirc;n thay v&igrave; c&aacute;c chuỗi video</li>\r\n	<li>Được m&ocirc; phỏng giống 100% so với c&aacute;c lớp học offline tại trung t&acirc;m</li>\r\n	<li>Slide b&agrave;i giảng trực quan, thiết thực, đi s&acirc;u v&agrave;o ph&acirc;n t&iacute;ch &amp; cải thiện từng kỹ năng cho người học</li>\r\n	<li>Phương ph&aacute;p học tập khoa học, mang t&iacute;nh tương t&aacute;c cao giữa gi&aacute;o vi&ecirc;n &amp; học vi&ecirc;n trong suốt qu&aacute; tr&igrave;nh học tập trực tuyến, gi&uacute;p học vi&ecirc;n dễ tiếp thu b&agrave;i giảng &amp; vận dụng nhanh ch&oacute;ng v&agrave;o thực tế</li>\r\n	<li>Cam kết x&acirc;y dựng nền tảng tiếng Anh hiệu quả trong suốt thời gian học online</li>\r\n	<li>Ứng dụng c&ocirc;ng nghệ khoa học v&agrave;o giảng dạy, gi&uacute;p học vi&ecirc;n trải nghiệm học online đạt chuẩn quốc tế</li>\r\n	<li>Đội ngũ gi&aacute;o vi&ecirc;n Việt &amp; bản xứ giỏi, tận t&acirc;m, được đ&agrave;o tạo chuy&ecirc;n s&acirc;u về giảng dạy</li>\r\n	<li>Hệ thống đăng k&yacute; lịch học online c&ocirc;ng nghệ hiện đại với 10 khung giờ linh hoạt mỗi ng&agrave;y</li>\r\n	<li>Kết hợp với kh&oacute;a học ph&aacute;t &acirc;m tiếng Anh cho học vi&ecirc;n giọng chuẩn bản xứ cực kỳ chi tiết</li>\r\n</ul>\r\n\r\n<p>Kh&oacute;a học tiếng Anh giao tiếp Online cho người mất gốc sẽ gi&uacute;p học vi&ecirc;n điều chỉnh ph&aacute;t &acirc;m chuẩn theo bản phi&ecirc;n &acirc;m quốc tế từ Gi&aacute;o vi&ecirc;n người Việt &amp; bản ngữ. Học ph&aacute;t &acirc;m từng bước từ ph&aacute;t &acirc;m từ đơn, đến ph&aacute;t &acirc;m chuẩn nguy&ecirc;n c&acirc;u &amp; ph&aacute;t &acirc;m hay k&egrave;m ngữ điệu tự nhi&ecirc;n. Học vi&ecirc;n cũng được ph&aacute;t triển kỹ năng nghe (Listening) trong suốt qu&aacute; tr&igrave;nh học tiếng Anh trực tuyến.</p>\r\n', 12, 2000, 'uploads/img1.jpg', 5.00, 'Beginner'),
(35, 'Khóa học tiếng Anh cho trẻ em và thanh thiếu niên', '<p>Đội ngũ gi&aacute;o vi&ecirc;n sẽ phối hợp với qu&yacute; phụ huynh để đảm bảo c&aacute;c em học sinh được hỗ trợ trong từng bước h&agrave;nh tr&igrave;nh học tiếng Anh. Cũng như qu&yacute; phụ huynh, ch&uacute;ng t&ocirc;i hiểu được tiềm năng của trẻ v&agrave; mong muốn gi&uacute;p trẻ đạt được tiến bộ r&otilde; rệt.&nbsp;</p>\r\n\r\n<p>Chứng kiến sự trưởng th&agrave;nh về học lực v&agrave; sự tự tin của trẻ. Th&ocirc;ng qua c&aacute;c kh&oacute;a học, trẻ sẽ ph&aacute;t triển sự s&aacute;ng tạo, tăng cường c&aacute;c kỹ năng gi&uacute;p th&agrave;nh c&ocirc;ng v&agrave; khả năng tiếng Anh - ng&ocirc;n ngữ chung của thế giới.</p>\r\n\r\n<h2><strong>Ph&aacute;t huy sự tự tin v&agrave; truyền cảm hứng s&aacute;ng tạo&nbsp;</strong></h2>\r\n', 15, 2000, 'uploads/anh_email_hs_0.avif', NULL, 'Beginner'),
(36, 'Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam', '<p>N&oacute;i nhanh, n&oacute;i chuẩn, n&oacute;i linh hoạt theo từng ngữ cảnh, tự tin bắt chuyện với đối t&aacute;c nước ngo&agrave;i, l&agrave;m chủ giao tiếp hang ng&agrave;y trong c&ocirc;ng việc.</p>\r\n\r\n<p><strong>1. Phương ph&aacute;p học tập A.I.T.E.C.H</strong></p>\r\n\r\n<ul>\r\n	<li>Lấy giao tiếp l&agrave;m cốt l&otilde;i</li>\r\n	<li>Lấy học vi&ecirc;n l&agrave;m trọng t&acirc;m</li>\r\n	<li>Tập trung n&acirc;ng cao về kỹ năng giao tiếp v&agrave; thực h&agrave;nh phản xạ nghe n&oacute;i tự nhi&ecirc;n, chỉnh sửa ph&aacute;t &acirc;m chuẩn quốc tế, &aacute;p dụng c&aacute;c t&igrave;nh huống giao tiếp gắn liền với cuộc sống v&agrave; c&ocirc;ng việc h&agrave;ng ng&agrave;y gi&uacute;p chị r&egrave;n kỹ năng tư duy thẳng ho&agrave;n to&agrave;n bằng tiếng Anh.</li>\r\n</ul>\r\n\r\n<p><strong>2. Gi&aacute;o tr&igrave;nh chuẩn 100% quốc tế v&agrave; được Hội đồng chuy&ecirc;n m&ocirc;n thiết kế c&aacute; nh&acirc;n ho&aacute; ph&ugrave; hợp theo từng mục ti&ecirc;u, tr&igrave;nh độ của học vi&ecirc;n</strong></p>\r\n\r\n<p>Dựa tr&ecirc;n mong muốn học tập của học vi&ecirc;n th&igrave; Hội đồng chuy&ecirc;n m&ocirc;n sẽ x&acirc;y dựng gi&aacute;o tr&igrave;nh tiếng Anh ph&ugrave; hợp. Chương tr&igrave;nh c&oacute; 3 loại gi&aacute;o tr&igrave;nh:</p>\r\n\r\n<ul>\r\n	<li><strong>Gi&aacute;o tr&igrave;nh cho c&aacute;c b&eacute; Kids theo ti&ecirc;u chuẩn của Cambridge:</strong>&nbsp;Tất cả c&aacute;c chương tr&igrave;nh học đều được thiết kế đa phương tiện gồm: H&igrave;nh ảnh, &acirc;m thanh, video, c&acirc;u chuyện sinh động, nh&acirc;n vật hoạt h&igrave;nh đồng h&agrave;nh trong to&agrave;n bộ qu&aacute; tr&igrave;nh học. C&aacute;c chủ đề từ vựng, ngữ ph&aacute;p được thiết kế xen kẽ c&aacute;c t&igrave;nh huống giao tiếp đời sống, học tập. Ngo&agrave;i ra con được học kết hợp c&aacute;c bộ m&ocirc;n khoa học thưởng thức v&agrave; b&agrave;i học đạo đức x&atilde; hội, gi&uacute;p con ph&aacute;t triển to&agrave;n diện Kỹ năng giao tiếp, kỹ năng mềm v&agrave; kỹ năng tư duy.</li>\r\n	<li><strong>GT th&ocirc;ng dụng GE:</strong>&nbsp;X&acirc;y dựng c&aacute;c t&igrave;nh huống giao tiếp trong cuộc sống hằng ng&agrave;y, giao tiếp bạn b&egrave;; định cư; du lịch&hellip;</li>\r\n	<li><strong>MBE &ndash; tiếng anh giao tiếp trong m&ocirc;i trường c&ocirc;ng sở:</strong>&nbsp;kinh doanh; họp h&agrave;nh; b&aacute;o c&aacute;o; thuyết tr&igrave;nh, đ&agrave;m ph&aacute;n.</li>\r\n</ul>\r\n\r\n<p><strong>3. Anh/ Chị đăng k&yacute; theo lịch học cố định ph&ugrave; hợp:</strong></p>\r\n\r\n<ul>\r\n	<li>Từ 8h &ndash; 23h, từ thứ 2-thứ 6 (nghỉ t7-cn)</li>\r\n	<li>Luyện n&oacute;i phản xạ tối thiểu 30 ph&uacute;t/buổi; 3 &ndash; 5 buổi/tuần</li>\r\n</ul>\r\n\r\n<p><strong>4. Hai gi&aacute;o vi&ecirc;n đồng h&agrave;nh xuy&ecirc;n suốt qu&aacute; tr&igrave;nh học: Với kho&aacute; học n&agrave;y th&igrave; học vi&ecirc;n sẽ được học 100% gi&aacute;o vi&ecirc;n Việt Nam</strong></p>\r\n\r\n<p><strong>Gi&aacute;o vi&ecirc;n cố định 1 k&egrave;m 1:</strong></p>\r\n\r\n<ul>\r\n	<li>Với kho&aacute; học n&agrave;y th&igrave; học vi&ecirc;n sẽ được học 100% gi&aacute;o vi&ecirc;n Việt Nam với đầy đủ chứng chỉ sư phạm, chứng chỉ tiếng Anh hoặc c&aacute;c chứng chỉ kh&aacute;c tương đương v&agrave; &iacute;t nhất hai năm kinh nghiệm giảng dạy</li>\r\n	<li>Được đ&agrave;o tạo theo quy chuẩn 5 bước về kỹ năng giảng dạy v&agrave; chuy&ecirc;n m&ocirc;n sư phạm bởi hội đồng chuy&ecirc;n gia h&agrave;ng đầu về ng&ocirc;n ngữ:( Phỏng vấn &ndash; Dạy thử &ndash; QC &ndash; Nhận lớp &ndash; Đ&aacute;nh gi&aacute;)</li>\r\n	<li>\r\n	<p><strong>Cố vấn học tập v&agrave; hội đồng QC:</strong></p>\r\n	</li>\r\n	<li>Sẽ đồng h&agrave;nh c&ugrave;ng học vi&ecirc;n theo s&aacute;t lộ tr&igrave;nh học tập về: lịch học; chất lượng gi&aacute;o vi&ecirc;n; chất lượng buổi học</li>\r\n	<li>Học vi&ecirc;n sẽ li&ecirc;n hệ Cố vấn học tập qua nh&oacute;m chat học tập zalo</li>\r\n</ul>\r\n\r\n<p><strong>5. Hệ thống Gi&aacute;o dục trực tuyến độc quyền LMS ( Learning Management Systerm) 5 trong 1:</strong></p>\r\n\r\n<ul>\r\n	<li>Tương t&aacute;c đa chiều</li>\r\n	<li>L&agrave;m b&agrave;i tập trực tuyến.</li>\r\n	<li>T&iacute;ch hợp t&agrave;i liệu bổ trợ.</li>\r\n	<li>Kiểm so&aacute;t b&aacute;o c&aacute;o tiến bộ định kỳ : định kỳ hệ thống sẽ thống k&ecirc; b&aacute;o c&aacute;o kết quả học tập của chị</li>\r\n	<li>Lưu trữ buổi học trực tuyến tự động: lưu lại tr&ecirc;n t&agrave;i khoản học tập để chị xem lại khi cần &ocirc;n tập; đ&aacute;nh gi&aacute; về qu&aacute; tr&igrave;nh học của m&igrave;nh v&agrave; chất lượng dịch vụ học tập của nh&agrave; trường</li>\r\n</ul>\r\n\r\n<p><strong>6. Cam kết ho&agrave;n học ph&iacute; đ&agrave;o tạo 100% nếu kh&ocirc;ng đạt được điểm số cam kết theo hợp đồng gi&aacute;o dục:</strong></p>\r\n\r\n<ul>\r\n	<li>Cam kết chất lượng được thể hiện bằng điểm số GSE-về năng lực giao tiếp nghe n&oacute;i theo chuẩn quốc tế tr&ecirc;n tổng điểm 90</li>\r\n	<li>Cam kết sẽ thể hiện bằng văn bản: Hợp đồng gi&aacute;o dục.</li>\r\n</ul>\r\n', 12, 2000, 'uploads/1kem1.jpg', NULL, 'Advanced'),
(37, 'Khóa Học Tiếng Anh Giao Tiếp', '<p>Tiếng Anh l&agrave; một trong những ng&ocirc;n ngữ phổ biến khắp thế giới. Với khả năng tiếng Anh tốt, bạn c&oacute; thể giao tiếp với khoảng 1/6 d&acirc;n số tr&ecirc;n thế giới, mở ra những c&aacute;nh cửa cơ hội trong cuộc sống v&agrave; đặc biệt sẽ gi&uacute;p &iacute;ch cho c&ocirc;ng việc của bạn rất nhiều.</p>\r\n\r\n<p>Nhận thấy tầm quan trọng của tiếng Anh trong x&atilde; hội to&agrave;n cầu h&oacute;a hiện nay, Thi&ecirc;n T&uacute; Academy đ&atilde; tổ chức c&aacute;c kh&oacute;a học Tiếng Anh Giao Tiếp với &ldquo;<em>Học ph&iacute; Việt Nam &ndash; Chất lượng to&agrave;n cầu</em>&rdquo;. Kh&oacute;a học nhằm gi&uacute;p học vi&ecirc;n ph&aacute;t triển c&aacute;c kỹ năng tiếng Anh ph&ugrave; hợp với mục ti&ecirc;u học tập, nghề nghiệp v&agrave; cả mục ti&ecirc;u c&aacute; nh&acirc;n. Đặc biệt l&agrave; đối với những ai c&oacute; &yacute; định đi du học hay định cư,&hellip;khả năng giao tiếp tiếng Anh tốt đ&atilde; gi&uacute;p c&aacute;c bạn đi được đến hơn 1/3 chặng đường.</p>\r\n\r\n<p><img alt=\"\" src=\"https://thientu-academy.com/wp-content/uploads/2020/10/like.png\" style=\"height:64px; width:64px\" /></p>\r\n\r\n<p>Lợi &Iacute;ch Kh&oacute;a Học</p>\r\n\r\n<p>1. Ph&aacute;t triển kỹ năng nghe &ndash; n&oacute;i một c&aacute;ch tối đa</p>\r\n\r\n<p>2. Mở rộng kiến thức ngo&agrave;i s&aacute;ch gi&aacute;o khoa</p>\r\n\r\n<p>3. Tăng khả năng tư duy, học hỏi, s&aacute;ng tạo</p>\r\n\r\n<p>4. Kỹ năng n&oacute;i tr&ocirc;i chảy v&agrave; tự tin hơn trong giao tiếp</p>\r\n\r\n<p>5. Tạo tiền đề cho c&aacute;c kh&oacute;a học luyện thi IELTS sau n&agrave;y</p>\r\n\r\n<p>6. Hoạt động nh&oacute;m li&ecirc;n tục v&agrave; đa dạng h&igrave;nh thức</p>\r\n\r\n<p>7. Phục vụ nhu cầu đi du học &amp; định cư cho tương lai</p>\r\n\r\n<p><img alt=\"\" src=\"https://thientu-academy.com/wp-content/uploads/2020/10/book-1.png\" style=\"height:64px; width:64px\" /></p>\r\n\r\n<h3>Điều Kiện Đầu V&agrave;o</h3>\r\n\r\n<h3>Độ tuổi:</h3>\r\n\r\n<ul>\r\n	<li>Từ 7 tuổi trở l&ecirc;n</li>\r\n</ul>\r\n\r\n<h3>Tr&igrave;nh độ học vấn:</h3>\r\n\r\n<ul>\r\n	<li>Kh&ocirc;ng y&ecirc;u cầu</li>\r\n</ul>\r\n\r\n<h3>Tr&igrave;nh độ ngoại ngữ:</h3>\r\n\r\n<ul>\r\n	<li>Ho&agrave;n th&agrave;nh b&agrave;i kiểm tra đầu v&agrave;o của trung t&acirc;m (nếu cần)</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n', 15, 3000000, 'uploads/sGRAe3NTTS.jpg', NULL, 'Beginner'),
(38, ' Khóa học TOEIC 4 KỸ NĂNG', '<p>Kh&oacute;a học TOEIC 4 kỹ năng bao gồm luyện tập cả 4 kỹ năng nghe, n&oacute;i, đọc v&agrave; viết, nhằm gi&uacute;p học vi&ecirc;n cải thiện khả năng sử dụng tiếng Anh một c&aacute;ch to&agrave;n diện v&agrave; chuẩn bị tốt hơn cho kỳ thi TOEIC. Kh&oacute;a học n&agrave;y c&oacute; thể gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng giao tiếp tiếng Anh, đọc hiểu c&aacute;c t&agrave;i liệu chuy&ecirc;n ng&agrave;nh, viết b&aacute;o c&aacute;o v&agrave; email c&ocirc;ng việc, v&agrave; cải thiện điểm số TOEIC của m&igrave;nh.</p>\r\n\r\n<h2>1. Giới thiệu về kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p><a href=\"https://edusa.vn/toeic-4-ky-nang-bao-nhieu-tien/\">Kh&oacute;a học TOEIC 4 kỹ năng</a>&nbsp;(TOEIC 4 Skills) l&agrave; một kh&oacute;a học tiếng Anh tổng qu&aacute;t, tập trung v&agrave;o cải thiện cả bốn kỹ năng ng&ocirc;n ngữ tiếng Anh, bao gồm Nghe, N&oacute;i, Đọc v&agrave; Viết. Kh&oacute;a học n&agrave;y gi&uacute;p người học x&acirc;y dựng nền tảng ng&ocirc;n ngữ tiếng Anh vững chắc để chuẩn bị cho kỳ thi TOEIC hoặc c&aacute;c kỳ thi tương tự. Trong kh&oacute;a học, học vi&ecirc;n sẽ được trang bị vốn từ vựng phong ph&uacute;, kỹ năng ph&aacute;t &acirc;m, luyện nghe hiểu, n&acirc;ng cao kỹ năng viết v&agrave; n&oacute;i tiếng Anh th&ocirc;ng qua c&aacute;c b&agrave;i tập v&agrave; c&aacute;c hoạt động tương t&aacute;c. Kh&oacute;a học n&agrave;y th&iacute;ch hợp cho những người muốn n&acirc;ng cao tr&igrave;nh độ tiếng Anh chung v&agrave; sẵn s&agrave;ng đạt được điểm số cao trong kỳ thi TOEIC.</p>\r\n\r\n<p><strong>C&oacute; thể bạn quan t&acirc;m:&nbsp;<a href=\"https://edusa.vn/luyen-thi-toeic-cap-toc-online/\">Kh&oacute;a luyện thi toeic cấp tốc online trải nghiệm Học thật &ndash; thi thật</a></strong></p>\r\n\r\n<p><strong>C&oacute; thể bạn quan t&acirc;m:</strong>&nbsp;<a href=\"https://edusa.vn/khoa-hoc-toeic-4-ky-nang-online/\"><strong>Chi tiết về kh&oacute;a học TOEIC 4 kỹ năng Online</strong></a></p>\r\n\r\n<h2>2. Tại sao n&ecirc;n học kh&oacute;a học TOEIC 4 kỹ năng?</h2>\r\n\r\n<p>Kh&oacute;a học TOEIC 4 kỹ năng l&agrave; một kh&oacute;a học tiếng Anh được thiết kế để gi&uacute;p học vi&ecirc;n cải thiện 4 kỹ năng quan trọng: nghe, đọc, n&oacute;i v&agrave; viết, để c&oacute; thể đạt được kết quả cao trong kỳ thi TOEIC. Tại sao n&ecirc;n học kh&oacute;a học TOEIC 4 kỹ năng? Dưới đ&acirc;y l&agrave; một số l&yacute; do quan trọng:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Tăng khả năng giao tiếp bằng tiếng Anh: Kh&oacute;a học TOEIC 4 kỹ năng sẽ gi&uacute;p bạn n&acirc;ng cao kỹ năng nghe v&agrave; n&oacute;i của m&igrave;nh, gi&uacute;p bạn tự tin hơn khi giao tiếp bằng tiếng Anh. Bạn sẽ c&oacute; cơ hội luyện tập kỹ năng nghe v&agrave; ph&aacute;t &acirc;m trong m&ocirc;i trường học tập chuy&ecirc;n nghiệp v&agrave; thuận lợi.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cải thiện kỹ năng đọc hiểu: Trong kh&oacute;a học n&agrave;y, bạn sẽ được đ&agrave;o tạo để c&oacute; thể đọc hiểu c&aacute;c đoạn văn bản học thuật v&agrave; kinh doanh bằng tiếng Anh. Điều n&agrave;y sẽ gi&uacute;p bạn n&acirc;ng cao khả năng đọc hiểu v&agrave; giải quyết c&aacute;c vấn đề li&ecirc;n quan đến c&ocirc;ng việc hoặc học tập.</p>\r\n	</li>\r\n	<li>\r\n	<p>N&acirc;ng cao kỹ năng viết: Kỹ năng viết lu&ocirc;n l&agrave; một trong những kỹ năng kh&oacute; nhất trong tiếng Anh. Tuy nhi&ecirc;n, kh&oacute;a học TOEIC 4 kỹ năng sẽ gi&uacute;p bạn n&acirc;ng cao kỹ năng viết v&agrave; cung cấp c&aacute;c kỹ thuật để viết đ&uacute;ng, đủ v&agrave; r&otilde; r&agrave;ng.</p>\r\n	</li>\r\n	<li>\r\n	<p>Đ&aacute;p ứng y&ecirc;u cầu của thị trường lao động: Nếu bạn muốn th&agrave;nh c&ocirc;ng trong sự nghiệp, việc c&oacute; một chứng chỉ TOEIC với điểm số cao rất quan trọng. Với kết quả cao trong kỳ thi TOEIC, bạn sẽ c&oacute; nhiều cơ hội hơn để t&igrave;m kiếm việc l&agrave;m tốt hơn v&agrave; c&oacute; thu nhập cao hơn.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cập nhật kiến thức tiếng Anh mới nhất: Với kh&oacute;a học TOEIC 4 kỹ năng, bạn sẽ được cập nhật c&aacute;c kiến thức mới nhất trong lĩnh vực tiếng Anh học thuật v&agrave; kinh doanh. Bạn sẽ học c&aacute;c từ vựng v&agrave; thuật ngữ mới, v&agrave; n&acirc;ng cao kỹ năng sử dụng ng&ocirc;n ngữ chuy&ecirc;n ng&agrave;nh.</p>\r\n	</li>\r\n</ol>\r\n\r\n<h2>3. C&aacute;c phương ph&aacute;p v&agrave; kỹ thuật luyện thi TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Luyện thi TOEIC 4 kỹ năng l&agrave; qu&aacute; tr&igrave;nh r&egrave;n luyện v&agrave; n&acirc;ng cao kỹ năng ng&ocirc;n ngữ Anh cần thiết để đạt được điểm số cao trong kỳ thi TOEIC. Kh&oacute;a học n&agrave;y tập trung v&agrave;o 4 kỹ năng ch&iacute;nh bao gồm: Nghe, Đọc, N&oacute;i v&agrave; Viết. Dưới đ&acirc;y l&agrave; một số phương ph&aacute;p v&agrave; kỹ thuật hiệu quả trong việc luyện thi TOEIC 4 kỹ năng.</p>\r\n\r\n<p>Nghe:</p>\r\n\r\n<p>Học c&aacute;c từ vựng chuy&ecirc;n ng&agrave;nh: Tập trung v&agrave;o ngữ ph&aacute;p v&agrave; từ vựng chuy&ecirc;n ng&agrave;nh thường được sử dụng trong c&aacute;c cuộc giao tiếp trong ng&agrave;nh của bạn. Điều n&agrave;y gi&uacute;p bạn dễ d&agrave;ng hiểu được c&aacute;c c&acirc;u hỏi v&agrave; nội dung chủ đề trong đề thi TOEIC.<br />\r\nLuyện nghe nhiều: H&atilde;y luyện nghe tiếng Anh một c&aacute;ch chủ động, bằng c&aacute;ch nghe c&aacute;c bản tin, phim, chương tr&igrave;nh thực tế hoặc c&aacute;c b&agrave;i giảng học thuật li&ecirc;n quan đến ng&agrave;nh của bạn.<br />\r\nL&agrave;m b&agrave;i tập nghe: L&agrave;m c&aacute;c b&agrave;i tập nghe từ c&aacute;c t&agrave;i liệu luyện thi TOEIC để củng cố kỹ năng nghe của bạn.</p>\r\n\r\n<p>Đọc:</p>\r\n\r\n<p>Học từ vựng v&agrave; ngữ ph&aacute;p cần thiết: Tập trung v&agrave;o học c&aacute;c từ vựng v&agrave; ngữ ph&aacute;p li&ecirc;n quan đến chuy&ecirc;n ng&agrave;nh của bạn, gi&uacute;p bạn dễ d&agrave;ng hiểu được c&aacute;c c&acirc;u hỏi v&agrave; c&aacute;c nội dung chủ đề trong đề thi.<br />\r\nĐọc nhiều: Đọc c&aacute;c b&aacute;o, tạp ch&iacute; v&agrave; s&aacute;ch về chuy&ecirc;n ng&agrave;nh của bạn. Điều n&agrave;y gi&uacute;p bạn l&agrave;m quen với c&aacute;c từ vựng v&agrave; thuật ngữ chuy&ecirc;n m&ocirc;n.<br />\r\nL&agrave;m b&agrave;i tập đọc: L&agrave;m c&aacute;c b&agrave;i tập đọc từ c&aacute;c t&agrave;i liệu luyện thi TOEIC để củng cố kỹ năng đọc của bạn.</p>\r\n\r\n<p>N&oacute;i:</p>\r\n\r\n<p>Luyện n&oacute;i thường xuy&ecirc;n: H&atilde;y t&igrave;m kiếm cơ hội để n&oacute;i tiếng Anh với bạn b&egrave;, đồng nghiệp hoặc tham gia c&aacute;c lớp học n&oacute;i tiếng Anh.<br />\r\nThực h&agrave;nh c&acirc;u trả lời đ&uacute;ng dạng: Tập trung v&agrave;o c&aacute;c c&acirc;u hỏi phổ biến trong đề thi TOEIC, nghi&ecirc;n cứu v&agrave; thực h&agrave;nh c&acirc;u trả lời đ&uacute;ng dạng để củng cố kỹ năng n&oacute;i của bạn.</p>\r\n\r\n<p>Luyện ngữ ph&aacute;p v&agrave; từ vựng đồng thời: Kh&ocirc;ng thể thiếu việc học ngữ ph&aacute;p v&agrave; từ vựng trong qu&aacute; tr&igrave;nh luyện thi TOEIC. Tuy nhi&ecirc;n, để tối ưu h&oacute;a qu&aacute; tr&igrave;nh học, bạn n&ecirc;n học ngữ ph&aacute;p v&agrave; từ vựng đồng thời với c&aacute;c kỹ năng kh&aacute;c như đọc hiểu, nghe v&agrave; n&oacute;i. Việc n&agrave;y gi&uacute;p bạn ph&aacute;t triển vốn từ vựng v&agrave; khả năng sử dụng ngữ ph&aacute;p trong c&aacute;c b&agrave;i thi TOEIC.</p>\r\n\r\n<p><br />\r\nTập trung v&agrave;o phần nghe: Phần nghe trong kỳ thi TOEIC chiếm tỷ lệ điểm kh&aacute; cao, do đ&oacute; việc tập trung luyện nghe l&agrave; rất quan trọng. Bạn c&oacute; thể luyện nghe qua c&aacute;c b&agrave;i nghe tr&ecirc;n mạng hoặc qua c&aacute;c t&agrave;i liệu luyện thi TOEIC. Bạn n&ecirc;n luyện nghe tr&ecirc;n nhiều chủ đề kh&aacute;c nhau để cải thiện khả năng nghe của m&igrave;nh.</p>\r\n\r\n<p><br />\r\nTổ chức thời gian hợp l&yacute;: Khi luyện thi TOEIC 4 kỹ năng, bạn cần phải biết c&aacute;ch ph&acirc;n bổ thời gian hợp l&yacute; cho c&aacute;c kỹ năng kh&aacute;c nhau. Bạn n&ecirc;n sử dụng một lịch tr&igrave;nh học tập để luyện tập mỗi kỹ năng theo từng phần nhỏ trong ng&agrave;y.</p>\r\n\r\n<p><br />\r\nThi thử TOEIC: Thi thử TOEIC l&agrave; c&aacute;ch tốt nhất để kiểm tra khả năng v&agrave; đo lường tiến độ luyện tập của m&igrave;nh. Thi thử gi&uacute;p bạn l&agrave;m quen với cấu tr&uacute;c đề thi, c&aacute;ch đọc v&agrave; hiểu c&acirc;u hỏi, từ đ&oacute; gi&uacute;p bạn tự tin hơn khi bước v&agrave;o kỳ thi thật.</p>\r\n\r\n<p><br />\r\nTham gia lớp học TOEIC: Nếu bạn muốn c&oacute; kết quả tốt nhất trong kỳ thi TOEIC, h&atilde;y tham gia lớp học TOEIC. Lớp học TOEIC cung cấp kiến thức chuy&ecirc;n s&acirc;u, gi&uacute;p bạn hiểu r&otilde; hơn về cấu tr&uacute;c đề thi TOEIC cũng như phương ph&aacute;p giải đề thi. B&ecirc;n cạnh đ&oacute;, lớp học c&ograve;n gi&uacute;p bạn r&egrave;n luyện kỹ năng nghe, n&oacute;i, đọc v&agrave; viết.</p>\r\n\r\n<h2>4. C&aacute;c lưu &yacute; v&agrave; ch&uacute; &yacute; khi học kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Khi học kh&oacute;a học TOEIC 4 kỹ năng, bạn cần lưu &yacute; một số điểm sau để đạt hiệu quả tốt nhất:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>X&aacute;c định mục ti&ecirc;u học tập r&otilde; r&agrave;ng: Bạn n&ecirc;n đặt ra mục ti&ecirc;u cụ thể cho m&igrave;nh về điểm số TOEIC m&agrave; muốn đạt được v&agrave; l&ecirc;n kế hoạch học tập cho ph&ugrave; hợp với mục ti&ecirc;u đ&oacute;.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tập trung v&agrave;o 4 kỹ năng: Bạn cần học đồng thời 4 kỹ năng l&agrave; Nghe, N&oacute;i, Đọc v&agrave; Viết, thay v&igrave; tập trung qu&aacute; nhiều v&agrave;o một kỹ năng cụ thể.</p>\r\n	</li>\r\n	<li>\r\n	<p>Sử dụng t&agrave;i liệu học tập chất lượng: Chọn lựa t&agrave;i liệu học tập ph&ugrave; hợp v&agrave; c&oacute; chất lượng tốt sẽ gi&uacute;p bạn tiết kiệm thời gian v&agrave; đạt được kết quả tốt nhất.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tham gia lớp học trực tuyến: Việc tham gia lớp học trực tuyến gi&uacute;p bạn tiết kiệm được thời gian di chuyển, c&oacute; cơ hội học tập v&agrave; tương t&aacute;c với c&aacute;c giảng vi&ecirc;n v&agrave; học vi&ecirc;n kh&aacute;c.</p>\r\n	</li>\r\n	<li>\r\n	<p>Thực h&agrave;nh thường xuy&ecirc;n: Thực h&agrave;nh l&agrave; c&aacute;ch tốt nhất để n&acirc;ng cao kỹ năng của bạn. Bạn cần l&ecirc;n kế hoạch thực h&agrave;nh thường xuy&ecirc;n để r&egrave;n luyện khả năng sử dụng tiếng Anh một c&aacute;ch th&agrave;nh thạo.</p>\r\n	</li>\r\n	<li>\r\n	<p>Đ&aacute;nh gi&aacute; tiến độ học tập: Bạn cần đ&aacute;nh gi&aacute; tiến độ học tập thường xuy&ecirc;n để biết m&igrave;nh đang ở đ&acirc;u v&agrave; cần cải thiện điểm g&igrave; để đạt được mục ti&ecirc;u của m&igrave;nh.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tự tin v&agrave; ki&ecirc;n nhẫn: Cuối c&ugrave;ng, bạn cần tự tin v&agrave; ki&ecirc;n nhẫn trong qu&aacute; tr&igrave;nh học tập. Đ&ocirc;i khi bạn c&oacute; thể gặp kh&oacute; khăn v&agrave; thất vọng, nhưng h&atilde;y ki&ecirc;n tr&igrave; v&agrave; kh&ocirc;ng bỏ cuộc. Sự cố gắng v&agrave; nỗ lực sẽ mang lại kết quả tốt cho bạn.</p>\r\n	</li>\r\n</ol>\r\n\r\n<blockquote>\r\n<p><strong>&gt;&gt;&gt;&gt; Tham khảo th&ecirc;m :&nbsp;<a href=\"https://edusa.vn/khoa-hoc-toeic/\">Kh&oacute;a luyện thi TOEIC 4 kỹ năng tại Edusa&nbsp;</a></strong></p>\r\n</blockquote>\r\n\r\n<h2>5. B&agrave;i tập v&agrave; đề thi mẫu trong kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Trong kh&oacute;a học TOEIC 4 kỹ năng, c&aacute;c b&agrave;i tập v&agrave; đề thi mẫu được thiết kế để gi&uacute;p học vi&ecirc;n củng cố kiến thức v&agrave; kỹ năng của m&igrave;nh trong 4 kỹ năng Nghe, Đọc, N&oacute;i v&agrave; Viết, c&ugrave;ng với c&aacute;c kỹ năng li&ecirc;n quan như Từ vựng, Ngữ ph&aacute;p v&agrave; Ph&aacute;t &acirc;m.</p>\r\n\r\n<p>Dưới đ&acirc;y l&agrave; một số v&iacute; dụ về c&aacute;c b&agrave;i tập v&agrave; đề thi mẫu trong kh&oacute;a học TOEIC 4 kỹ năng:</p>\r\n\r\n<p>B&agrave;i tập Nghe: Học vi&ecirc;n sẽ được luyện nghe qua c&aacute;c b&agrave;i tập nghe, đối thoại, bản tin, c&aacute;c cuộc phỏng vấn, c&aacute;c b&agrave;i diễn thuyết v&agrave; c&aacute;c b&agrave;i đọc giả tưởng. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng lắng nghe v&agrave; hiểu r&otilde; &yacute; nghĩa của c&aacute;c từ, c&acirc;u v&agrave; đoạn văn.&nbsp;</p>\r\n\r\n<p>B&agrave;i tập Đọc: Học vi&ecirc;n sẽ được đọc c&aacute;c b&agrave;i b&aacute;o, đoạn văn, thư từ v&agrave; c&aacute;c t&agrave;i liệu kh&aacute;c li&ecirc;n quan đến kinh doanh, t&agrave;i ch&iacute;nh, kế to&aacute;n v&agrave; quản l&yacute;. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n ph&aacute;t triển khả năng đọc hiểu, t&igrave;m kiếm th&ocirc;ng tin v&agrave; đưa ra nhận x&eacute;t.</p>\r\n\r\n<p>B&agrave;i tập N&oacute;i: Học vi&ecirc;n sẽ được luyện n&oacute;i qua c&aacute;c b&agrave;i tập, đối thoại v&agrave; c&aacute;c b&agrave;i thuyết tr&igrave;nh. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng diễn đạt, ph&aacute;t &acirc;m v&agrave; sử dụng ng&ocirc;n ngữ ch&iacute;nh x&aacute;c.</p>\r\n\r\n<p>B&agrave;i tập Viết: Học vi&ecirc;n sẽ được luyện viết qua c&aacute;c b&agrave;i tập, b&agrave;i luận v&agrave; c&aacute;c b&aacute;o c&aacute;o. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n ph&aacute;t triển khả năng viết đ&uacute;ng ch&iacute;nh tả, sử dụng ngữ ph&aacute;p v&agrave; từ vựng ch&iacute;nh x&aacute;c.</p>\r\n\r\n<p>Đề thi mẫu: C&aacute;c đề thi mẫu được thiết kế để gi&uacute;p học vi&ecirc;n l&agrave;m quen với định dạng, thang điểm v&agrave; kiểu c&acirc;u hỏi của kỳ thi TOEIC. Học vi&ecirc;n c&oacute; thể sử dụng c&aacute;c đề thi mẫu để đ&aacute;nh gi&aacute; khả năng của m&igrave;nh v&agrave; củng cố kiến thức trước khi tham gia kỳ thi thực tế.</p>\r\n', 11, 2500000, 'uploads/khoahoc10.jpg', 5.00, 'TOEIC'),
(39, 'Khóa học IELTS – Foundation', '<p>Kh&oacute;a học được thiết kế d&agrave;nh cho c&aacute;c bạn cần được củng cố kiến thức nền tảng về ngữ ph&aacute;p, từ vựng, cấu tr&uacute;c c&acirc;u,&hellip; để bắt đầu l&agrave;m quen v&agrave; hiểu về cấu tr&uacute;c của b&agrave;i thi IELTS. Những chủ đề trong kh&oacute;a học n&agrave;y thường sẽ l&agrave; những chủ đề đơn giản, gần gũi trong cuộc sống h&agrave;ng ng&agrave;y.</p>\r\n\r\n<ul>\r\n	<li><strong>Mục ti&ecirc;u đầu ra:</strong>&nbsp;Band 4.5</li>\r\n	<li><strong>Gi&aacute;o tr&igrave;nh:</strong>&nbsp;Mindset For IELTS &ndash; Foundation của Đại học Cambridge c&ugrave;ng với c&aacute;c t&agrave;i liệu độc quyền của c&aacute;c Thầy C&ocirc; gi&agrave;u kinh nghiệm bi&ecirc;n soạn.</li>\r\n</ul>\r\n\r\n<p><strong>Kiến Thức Cần Đạt Được</strong></p>\r\n\r\n<p>Sau khi ho&agrave;n th&agrave;nh kh&oacute;a học, mục ti&ecirc;u học vi&ecirc;n cần đạt được như sau:</p>\r\n\r\n<ul>\r\n	<li>Reading: Tiếp cận với c&aacute;c dạng b&agrave;i của IELTS Reading kết hợp với phần b&agrave;i tập để luyện tập.</li>\r\n	<li>Listening: Cung cấp kiến thức ph&aacute;t triển kỹ năng nghe cơ bản rồi l&agrave;m quen dần với c&aacute;c dạng b&agrave;i của IETLS Listening.</li>\r\n	<li>&nbsp;Speaking: L&agrave;m quen với IELTS Speaking v&agrave; cung cấp lượng từ vựng academic dễ học &amp; kh&aacute; bổ &iacute;ch cho c&aacute;c bạn mới học.</li>\r\n	<li>Writing: Học về Writing gi&uacute;p c&aacute;c bạn ph&acirc;n biệt v&agrave; nắm r&otilde; việc kh&aacute;c nhau giữa writing trong đời thường &amp; writing học thuật thế n&agrave;o. Bước đầu gi&uacute;p c&aacute;c bạn hiểu về IELTS Writing Task 1 &amp; Task 2</li>\r\n</ul>\r\n', 22, 3301000, 'uploads/O21fPqavCk.jpg', NULL, 'Advanced'),
(40, 'Khóa học Tiếng Anh luyện thi IELTS', '<p>L&agrave; chuy&ecirc;n gia to&agrave;n cầu về giảng dạy tiếng Anh, Hội đồng Anh l&agrave; lựa chọn ho&agrave;n hảo để bạn tận dụng triệt để c&aacute;c cơ hội học tập v&agrave; th&agrave;nh c&ocirc;ng trong tương lai. Ch&uacute;ng t&ocirc;i tự h&agrave;o l&agrave; tổ chức duy nhất đồng thời cung cấp kh&oacute;a học tiếng Anh luyện thi v&agrave; kỳ thi IELTS; nơi gi&uacute;p bạn tối ưu điểm thi IELTS bạn mong muốn.</p>\r\n\r\n<p>Kh&oacute;a tiếng Anh luyện thi IELTS v&agrave; c&aacute;c nguồn học liệu trực tuyến của ch&uacute;ng t&ocirc;i sẽ gi&uacute;p bạn tối ưu điểm thi IELTS v&agrave; chuẩn bị nền tảng tốt nhất bật mở c&aacute;nh cửa tương lai.</p>\r\n\r\n<h2>Cải thiện kỹ năng tiếng Anh v&agrave; th&agrave;nh c&ocirc;ng với c&aacute;c cơ hội học tập trong tương lai.</h2>\r\n', 20, 1500000, 'uploads/630x354-70-target-score-viet.avif', NULL, 'IELTS'),
(41, 'KHÓA HỌC TOEIC GIẢI ĐỀ ', '<p>C&oacute; thể n&oacute;i trải qua hơn 30 năm h&igrave;nh th&agrave;nh v&agrave; ph&aacute;t triển, b&agrave;i thi TOEIC Listening and Reading đ&atilde; v&agrave; đang được chấp nhận. C&aacute;c ti&ecirc;u chuẩn n&agrave;y gi&uacute;p đ&aacute;nh gi&aacute; hai kỹ năng nghe hiểu v&agrave; đọc hiểu tiếng Anh trong m&ocirc;i trường l&agrave;m việc quốc tế cũng như đ&aacute;nh gi&aacute; điểm đầu ra của sinh vi&ecirc;n.</p>\r\n\r\n<p>Kỹ năng nghe hiểu l&agrave; v&ocirc; c&ugrave;ng quan trọng v&igrave; n&oacute; được sử dụng rộng r&atilde;i trong giao tiếp trực tiếp hoặc qua điện thoại, trong c&aacute;c cuộc họp, hội nghị trực tuyến ng&agrave;y nay. C&ograve;n đối với kỹ năng đọc hiểu rất cần thiết với c&aacute;c loại thư từ, email, b&aacute;o c&aacute;o v&agrave; tất cả những giao tiếp bằng văn bản m&agrave; cần tiếng Anh.</p>\r\n\r\n<p>Sau khi tham dự b&agrave;i thi TOEIC, th&iacute; sinh sẽ nhận được một phiếu điểm v&agrave; bằng chứng chỉ c&oacute; hiệu lực trong v&ograve;ng 2 năm. Phiếu điểm sẽ c&oacute; đầy đủ điểm của mỗi phần thi. Ngo&agrave;i ra, bản b&aacute;o c&aacute;o kết quả c&ograve;n đ&aacute;nh gi&aacute; mức độ th&agrave;nh thạo của th&iacute; sinh trong từng kỹ năng cụ thể thể hiện sự ho&agrave;n thiện trong từng kỹ năng của th&iacute; sinh.</p>\r\n\r\n<p>Tin chắc chắn một điều rằng bất kỳ ai cũng muốn c&oacute; được một con điểm khủng cho chứng chỉ TOEIC của m&igrave;nh. V&agrave; để l&agrave;m được điều đ&oacute; th&igrave; kh&ocirc;ng chỉ dừng lại ở việc học TOEIC căn bản v&agrave; c&oacute; được số điểm cơ bản đủ để ra trường hay xin việc tại c&ocirc;ng ty. Mục ti&ecirc;u của bạn lu&ocirc;n phải cao hơn nữa th&igrave; số điểm của bạn mới kh&ocirc;ng ngừng tăng l&ecirc;n.</p>\r\n\r\n<p>Kh&oacute;a học TOEIC giải đề tại TAEC</p>\r\n\r\n<h3>1. Đối tượng tham gia:</h3>\r\n\r\n<p>C&aacute;c bạn muốn cải thiện điểm thi TOEIC, muốn nắm vững cấu tr&uacute;c, phương ph&aacute;p l&agrave;m b&agrave;i sao cho nhanh ch&oacute;ng v&agrave; hiệu quả nhất, nhất l&agrave; c&aacute;c mẹo v&agrave; tư duy tr&aacute;nh bẫy đề thi. Nhất l&agrave; kh&oacute;a học TOEIC giải đề cực kỳ phụ hợp cho c&aacute;c bạn chuẩn bị sắp đến thời gian thi v&agrave; c&aacute;c bạn đ&atilde; ho&agrave;n th&agrave;nh kh&oacute;a học TOEIC căn bản.</p>\r\n\r\n<h3>2. Mục ti&ecirc;u đầu ra của kho&aacute; học TOEIC giải đề:</h3>\r\n\r\n<p>Gi&uacute;p học vi&ecirc;n c&oacute; thể tăng từ 100 đến 200 điểm TOEIC so với khả năng ban đầu. Cũng như phụ thuộc rất nhiều v&agrave;o việc lựa chọn kh&oacute;a học giải đề bao nhi&ecirc;u th&aacute;ng.</p>\r\n\r\n<p>Tại TAEC cung cấp 6 kho&aacute; học giải đề tương ứng từ 1 cho đến 6 th&aacute;ng với mức học ph&iacute; kh&aacute;c nhau cũng như thời lượng kh&aacute;c nhau.</p>\r\n', 15, 900000, 'uploads/15698350626-400x250.jpeg', NULL, ''),
(42, 'Khóa học IELTS từ 0-7+ kèm chấm chữa giáo viên bản ngữ', '<p>Kh&oacute;a học IELTS Fundamentals: Grammar and Vocabulary for IELTS hướng đến đối tượng c&aacute;c bạn đang ở tr&igrave;nh độ sơ cấp (tương đương A1-A2) v&agrave; c&oacute; mong muốn thi IELTS trong tương lai. Mục ti&ecirc;u kh&oacute;a học l&agrave; x&acirc;y dựng cho c&aacute;c bạn nền m&oacute;ng từ vựng v&agrave; ngữ ph&aacute;p để đạt điểm tối thiểu 4.0 sau 3-4 th&aacute;ng học đ&uacute;ng lộ tr&igrave;nh.</p>\r\n\r\n<p>Phần Từ vựng gồm hơn 1.800 từ&nbsp;được chia th&agrave;nh 20 chủ đề kh&aacute;c nhau như nghệ thuật, văn học, lịch sử, khảo cổ, khoa học, đời sống ... l&agrave; những chủ điểm chắc chắn sẽ xuất hiện khi đi thi. Mỗi chủ đề bao gồm b&ocirc; flashcards gồm đầy đủ nghĩa Anh-Việt/ Anh-Anh&nbsp;h&igrave;nh ảnh, phi&ecirc;n &acirc;m, ph&aacute;t &acirc;m, c&acirc;u v&iacute; dụ. Phần &ocirc;n tập flashcards của STUDY4 được thiết kế theo phương ph&aacute;p Spaced repetition (học lặp lại ngắt qu&atilde;ng) gi&uacute;p bạn tối ưu h&oacute;a thời gian v&agrave; hiệu quả &ocirc;n tập: chỉ &ocirc;n những từ sắp qu&ecirc;n v&agrave; bỏ qua những từ đ&atilde; nhớ. Gi&uacute;p bạn ho&agrave;n to&agrave;n c&oacute; thể học trọn 1.800 từ n&agrave;y trong 2.5-3 th&aacute;ng (~75 ng&agrave;y). Ngo&agrave;i ra, kh&oacute;a học cung cấp rất nhiều c&aacute;c dạng b&agrave;i tập mini-game&nbsp;kh&aacute;c nhau để bạn luyện tập từ vựng như t&igrave;m cặp, nghe điền từ, nghe chọn từ đ&uacute;ng, ch&iacute;nh tả, trắc nghiệm.</p>\r\n\r\n<p>Phần Ngữ ph&aacute;p gồm b&agrave;i giảng chi tiết 29 chủ điểm ngữ ph&aacute;p quan trọng nhất trong kỳ thi IELTS. B&ecirc;n cạnh đ&oacute;, kh&oacute;a học cung c&acirc;p th&ecirc;m c&aacute;c dạng b&agrave;i tập luyện chuy&ecirc;n s&acirc;u ngữ ph&aacute;p kết hợp c&aacute;c kỹ năng như nghe, đọc, viết gi&uacute;p bạn thực h&agrave;nh h&agrave;ng ng&agrave;y ngữ ph&aacute;p hiệu quả.</p>\r\n\r\n<h2>Bạn sẽ đạt được g&igrave; sau kho&aacute; học?</h2>\r\n\r\n<p>1️⃣ C&oacute; nền tảng ngữ ph&aacute;p trung cấp B1-B2</p>\r\n\r\n<p>2️⃣ X&acirc;y dựng vốn từ vựng học thuật, l&agrave;m&nbsp;nền m&oacute;ng để đọc/nghe hiểu&nbsp;c&aacute;c chủ điểm chắc chắn sẽ xuất hiện trong 2 phần thi Listening v&agrave; Reading</p>\r\n\r\n<p>3️⃣ L&agrave;m chủ tốc độ v&agrave; c&aacute;c ngữ điệu&nbsp;kh&aacute;c nhau trong phần thi IELTS Listening</p>\r\n\r\n<p>4️⃣ Nắm trọn 4000 từ vựng 99% sẽ xuất hiện trong IELTS</p>\r\n\r\n<p>5️⃣&nbsp;Nắm chắc chiến thuật v&agrave; phương ph&aacute;p&nbsp;l&agrave;m c&aacute;c dạng c&acirc;u hỏi trong IELTS Listening v&agrave; Reading</p>\r\n\r\n<p>6️⃣&nbsp;Luyện tập ph&aacute;t &acirc;m, từ vựng, ngữ ph&aacute;p v&agrave; thực h&agrave;nh luyện n&oacute;i c&aacute;c chủ đề thường gặp v&agrave; forecast trong&nbsp;IELTS Speaking</p>\r\n\r\n<p>Để đạt được điểm số cao trong hai phần thi&nbsp;IELTS Speaking v&agrave; Writing l&agrave;&nbsp;rất kh&oacute;.&nbsp;Bất chấp mọi nỗ lực của bạn, bạn vẫn đạt được kh&ocirc;ng thể vượt qua band 6.5!&nbsp;😩 Bạn cố gắng học thật chăm chỉ, tập viết v&agrave; n&oacute;i thật nhiều&nbsp;nhưng điểm số của bạn vẫn vậy.&nbsp;Dường như kh&ocirc;ng c&oacute; g&igrave; c&oacute; thể đẩy bạn l&ecirc;n đến band 7 v&agrave; 8. Tại sao?</p>\r\n\r\n<p>Sau khi l&agrave;m b&agrave;i, bạn cần phải được chấm chữa v&agrave; nhận x&eacute;t để&nbsp;biết lỗi sai của m&igrave;nh ở đ&acirc;u v&agrave; c&aacute;ch khắc phục chuẩn x&aacute;c. C&oacute; như vậy bạn mới c&oacute; thể cải thiện được tr&igrave;nh độ.</p>\r\n\r\n<p>Kh&oacute;a học chấm chữa&nbsp;IELTS Writing &amp; Speaking được x&acirc;y dựng nhằm gi&uacute;p c&aacute;c bạn hiểu r&otilde; c&aacute;ch l&agrave;m, khắc phục điểm yếu, học c&aacute;ch h&agrave;nh văn v&agrave; cải thiện nhanh ch&oacute;ng hai kỹ năng kh&oacute; nhằn nhất trong kỳ thi IELTS. Tất cả c&aacute;c b&agrave;i l&agrave;m (gồm b&agrave;i luận&nbsp;v&agrave; thu &acirc;m b&agrave;i n&oacute;i) đều được&nbsp;chấm chữa v&agrave; cho điểm chi tiết bởi đội ngũ gi&aacute;o vi&ecirc;n gi&agrave;u kinh nghiệm v&agrave; tr&igrave;nh độ chuy&ecirc;n m&ocirc;n cao của STUDY4. Khi đăng k&yacute; kh&oacute;a học, bạn sẽ được:</p>\r\n\r\n<ul>\r\n	<li>Chấm chữa đầy đủ từ vựng, ngữ ph&aacute;p, li&ecirc;n kết, nội dung</li>\r\n	<li>Ph&acirc;n t&iacute;ch chi tiết v&agrave; lời khuy&ecirc;n để cải thiện</li>\r\n	<li>Phiếu nhận x&eacute;t&nbsp;v&agrave; chấm điểm chuẩn form&nbsp;IELTS</li>\r\n	<li>Nhận điểm từ 1-3 ng&agrave;y&nbsp;sau khi nộp (trừ cuối tuần v&agrave; ng&agrave;y nghỉ lễ)</li>\r\n</ul>\r\n', 15, 2500000, 'uploads/ielts_band_0_7.webp', NULL, 'Advanced'),
(43, 'Khóa học IELTS online 4 kỹ năng', '<p><strong>Luyện thi IELTS ch&iacute;nh l&agrave; một trận chiến đ&ograve;i hỏi sự nỗ lực, ki&ecirc;n tr&igrave; của mỗi người để tiếp thu v&agrave; đạt được band điểm cao như mong muốn.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Kh&oacute;a học gồm:</p>\r\n\r\n<ul>\r\n	<li>Kỹ năng Listening</li>\r\n	<li>Kỹ năng Reading</li>\r\n	<li>Kỹ năng Speaking</li>\r\n	<li>Kỹ năng Writing</li>\r\n	<li>Ebook &Yacute; tưởng Writing</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li><strong>BỘ TỪ VỰNG 1</strong>: D&agrave;nh ri&ecirc;ng để l&agrave;m 5 dạng biểu đồ l&agrave; Line graph, Bar chart, Pie chart, Table v&agrave; Mixed charts.</li>\r\n	<li><strong>BỘ TỪ VỰNG 2</strong>: D&agrave;nh ri&ecirc;ng để l&agrave;m Process</li>\r\n	<li><strong>BỘ TỪ VỰNG 3</strong>: D&agrave;nh ri&ecirc;ng để l&agrave;m Map</li>\r\n</ul>\r\n\r\n<p>Ngo&agrave;i ra trong qu&aacute; tr&igrave;nh học c&aacute;c b&agrave;i Task 1 của kh&oacute;a, m&igrave;nh c&ograve;n c&oacute; th&ecirc;m từ vựng cho rất nhiều chủ đề như:</p>\r\n\r\n<ul>\r\n	<li>Kh&iacute; thải (Emissions)</li>\r\n	<li>Ti&ecirc;u thụ (Consumption)</li>\r\n	<li>D&acirc;n số v&agrave; độ tuổi (Age structure)</li>\r\n	<li>Tỷ lệ &hellip; (c&aacute;c diễn đạt số liệu phần trăm)</li>\r\n	<li>Đăng k&yacute; học (Student enrolments)</li>\r\n	<li>Chi ti&ecirc;u (Spending on something)</li>\r\n	<li>Năng lượng (Energy use)</li>\r\n	<li>Tho&aacute;i h&oacute;a đất (Land degradation)</li>\r\n</ul>\r\n\r\n<p>Trong qu&aacute; tr&igrave;nh học c&aacute;c viết từng dạng, thực h&agrave;nh từng b&agrave;i, m&igrave;nh c&ograve;n t&iacute;ch lũy được những từ vựng cho c&aacute;c chủ đề kh&aacute;c nhau:</p>\r\n\r\n<ul>\r\n	<li>N&oacute;ng l&ecirc;n to&agrave;n cầu (Global warming)</li>\r\n	<li>Tội phạm (Crime)</li>\r\n	<li>Chi ti&ecirc;u ch&iacute;nh phủ (Government Spending)</li>\r\n	<li>Gi&aacute;o dục (Education) &rarr; C&oacute; hai b&agrave;i về Gi&aacute;o dục n&agrave;y, nhưng tiểu chủ đề (chủ đề ch&iacute;nh của đề b&agrave;i) l&agrave; ho&agrave;n to&agrave;n kh&aacute;c nhau.</li>\r\n	<li>M&ocirc;i trường (Environment)</li>\r\n	<li>Sống một m&igrave;nh (Living alone)</li>\r\n	<li>Du lịch (Tourism)</li>\r\n	<li>Nghi&ecirc;n cứu lịch sử của một t&ograve;a nh&agrave; (Researching the history of a house)</li>\r\n	<li>Việc sở hữu nh&agrave; v&agrave; việc thu&ecirc; nh&agrave; (Owning a home or renting one)</li>\r\n</ul>\r\n', 16, 2800000, 'uploads/khoahoc8.jpg', NULL, 'Intermediate'),
(44, 'Khóa học tiếng Anh cho người mới bắt đầu', '<p>Kh&oacute;a học tiếng Anh cho người mới bắt đầu l&agrave; một kh&oacute;a học d&agrave;nh cho những người mất gốc hoặc những người đ&atilde; học một &iacute;t nhưng muốn củng cố v&agrave; mở rộng kiến thức của m&igrave;nh. Dưới đ&acirc;y l&agrave; một số th&ocirc;ng tin cơ bản về kh&oacute;a học n&agrave;y:</p>\r\n\r\n<p>Mục ti&ecirc;u của kh&oacute;a học:</p>\r\n\r\n<ul>\r\n	<li>X&acirc;y dựng nền tảng vững chắc về ngữ ph&aacute;p, từ vựng v&agrave; kỹ năng nghe, n&oacute;i, đọc, viết tiếng Anh.</li>\r\n	<li>Ph&aacute;t triển khả năng giao tiếp h&agrave;ng ng&agrave;y v&agrave; tham gia v&agrave;o c&aacute;c t&igrave;nh huống th&ocirc;ng thường trong cuộc sống.</li>\r\n</ul>\r\n\r\n<p>Nội dung của kh&oacute;a học:</p>\r\n\r\n<ul>\r\n	<li>Học vi&ecirc;n sẽ học v&agrave; thực h&agrave;nh c&aacute;c cấu tr&uacute;c ngữ ph&aacute;p cơ bản, c&ugrave;ng với từ vựng li&ecirc;n quan, nhằm x&acirc;y dựng nền tảng ng&ocirc;n ngữ.</li>\r\n	<li>Luyện nghe qua c&aacute;c b&agrave;i nghe với tốc độ v&agrave; độ kh&oacute; tăng dần, từ ngắn đến d&agrave;i, gi&uacute;p cải thiện khả năng nghe hiểu v&agrave; phản xạ ng&ocirc;n ngữ.</li>\r\n	<li>Thực h&agrave;nh giao tiếp qua c&aacute;c b&agrave;i tập v&agrave; hoạt động nh&oacute;m, gi&uacute;p r&egrave;n kỹ năng diễn đạt v&agrave; tương t&aacute;c trong c&aacute;c t&igrave;nh huống h&agrave;ng ng&agrave;y.</li>\r\n	<li>Luyện viết qua c&aacute;c b&agrave;i tập tạo c&acirc;u, viết đoạn văn ngắn v&agrave; thực h&agrave;nh viết email, th&ocirc;ng điệp giao tiếp cơ bản.</li>\r\n</ul>\r\n', 10, 2000, 'uploads/khoahoc1.jpg', NULL, 'Beginner'),
(81, 'Giao Tiếp B1 – Nói & Nghe', '<p><strong>Ph&aacute;t triển phản xạ nghe n&oacute;i v&agrave; tự tin giao tiếp.</strong></p>\r\n\r\n<ul>\r\n	<li>&nbsp; Shadowing &amp; chunk speaking, role-play t&igrave;nh huống c&ocirc;ng việc</li>\r\n	<li>&nbsp; Nghe podcasts, ghi ch&uacute; &yacute; ch&iacute;nh &amp; chi tiết</li>\r\n	<li>Ngữ ph&aacute;p: present perfect, conditional, relative clauses<br />\r\n	&nbsp;</li>\r\n</ul>\r\n', 23, 3000, 'uploads/1762711345_photo-1522199755839-a2bacb67c546.avif', NULL, 'Intermediate');

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
(23, 'TOEIC-4S-01-25', '2025-09-27', '08:00:00', '09:30:00', 'Phòng C301', ''),
(24, 'TOEIC-4S-01-25', '2025-11-24', '08:00:00', '09:30:00', 'Phòng C301', ''),
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
(139, 'TOEIC-4S-01-25', '2025-11-14', '16:00:00', '17:30:00', 'Phòng C301', 'http://localhost:3000/dahp2/admin/admin.php?nav=lichhoc&lop_id=TOEIC-4S-01-25&view=schedule'),
(140, 'TOEIC-4S-01-25', '2025-11-17', '08:00:00', '09:30:00', 'Phòng C301', ''),
(141, 'TOEIC-4S-01-25', '2025-11-22', '08:00:00', '09:30:00', 'Phòng C301', ''),
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
(80, 1, 32, '2025-10-14 23:05:47', 2000.00, 'Chuyển khoản SePay', 'Đã hoàn thành'),
(81, 1, 36, '2025-10-25 18:08:20', 2000.00, 'Chuyển khoản SePay', 'Đã hoàn thành'),
(82, 48, 41, '2025-11-06 00:00:00', 900000.00, 'Tiền mặt', 'Đã thanh toán'),
(85, 1, 44, '2025-11-09 17:58:08', 2000.00, 'Chuyển khoản SePay', 'Đã hoàn thành'),
(86, 1, 44, '2025-11-09 18:45:29', 2000.00, 'Chuyển khoản SePay', 'Đã hoàn thành');

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
('COM-1V1-01-25', 36, 'Lớp Giao tiếp 1-1 (Lịch linh hoạt)', 3, 1, 'dang hoc'),
('COM-BASIC-01-25', 37, 'Lớp Giao tiếp cơ bản Tối T2-T4', 3, 0, 'dang hoc'),
('COM-BASIC-02-25', 37, 'Lớp Giao tiếp cơ bản Tối T3-T5', 6, 0, 'dang hoc'),
('IELTS-0-7-01-25', 42, 'Lớp IELTS 0-7+ Tối T3-T5', 1, 1, 'dang hoc'),
('IELTS-4S-01-25', 43, 'Lớp IELTS Online 4 Kỹ năng Chiều T2-T4', 6, 0, 'dang hoc'),
('IELTS-4S-02-25', 43, 'Lớp IELTS Online 4 Kỹ năng Tối T3-T5', 1, 0, 'dang hoc'),
('IELTS-F-01-25', 39, 'Lớp IELTS Foundation Tối T2-T4', 1, 0, 'dang hoc'),
('IELTS-F-02-25', 39, 'Lớp IELTS Foundation Chiều T3-T5', 6, 0, 'dang hoc'),
('IELTS-PREP-01-25', 40, 'Lớp Luyện thi IELTS Sáng T3-T5-T7', 1, 0, 'dang hoc'),
('IELTS-PREP-02-25', 40, 'Lớp Luyện thi IELTS Cuối tuần (Chiều T7-CN)', 5, 0, 'dang hoc'),
('KIDS-01-25', 35, 'Lớp Thiếu niên Chiều T3-T5', 5, 1, 'dang hoc'),
('KIDS-02-25', 35, 'Lớp Thiếu nhi Cuối tuần (Sáng T7)', 5, 0, 'dang hoc'),
('Te1', 38, 'Test', 5, 0, 'dang hoc'),
('TOEIC-4S-01-25', 38, 'Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6', 2, 1, 'dang hoc'),
('TOEIC-4S-02-25', 38, 'Lớp TOEIC 4 Kỹ năng Tối T3-T5', 2, 0, 'dang hoc'),
('TOEIC-DE-01-25', 41, 'Lớp Giải đề TOEIC Tối T2-T4-T6', 2, 0, 'dang hoc'),
('TOEIC-DE-02-25', 41, 'Lớp Giải đề TOEIC Sáng Cuối tuần', 2, 1, 'dang hoc');

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
(78, '2025-10-16', 14),
(92, '2025-10-17', 7),
(99, '2025-10-18', 3),
(102, '2025-10-20', 12),
(114, '2025-10-22', 1),
(115, '2025-10-24', 2),
(117, '2025-10-25', 7),
(124, '2025-10-28', 13),
(137, '2025-10-29', 4),
(141, '2025-11-03', 3),
(144, '2025-11-05', 3),
(147, '2025-11-06', 4),
(151, '2025-11-07', 9),
(160, '2025-11-08', 5),
(165, '2025-11-09', 9);

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
(11, NULL, NULL, 'TOEIC-4S-01-25', 'Giảng viên đã upload tài liệu TOEIC Listening Part 1-4 và Reading Part 5-7 lên hệ thống. Học viên vui lòng truy cập mục \"Học liệu\" để tải về và in trước buổi học. Tài liệu bao gồm: \n- TOEIC Listening Strategies.pdf\n- TOEIC Reading Grammar.pdf\n- Practice Test 1-5.pdf', '2025-10-02 17:15:44', NULL, 'Tài liệu học tập đã được cập nhật', 'da doc'),
(12, NULL, NULL, 'TOEIC-4S-01-25', 'Lớp sẽ có bài kiểm tra định kỳ vào ngày 10/10/2025 (Thứ 6). Nội dung kiểm tra: Listening Part 1, 2 và Reading Part 5. Thời gian: 45 phút. Học viên vui lòng ôn tập kỹ các dạng bài đã học và làm đầy đủ bài tập về nhà. Bài kiểm tra chiếm 20% điểm tổng kết.', '2025-10-04 17:15:44', NULL, 'Bài kiểm tra định kỳ - Tuần 2', 'chua doc'),
(13, NULL, NULL, 'TOEIC-4S-01-25', 'Do giảng viên có công tác, lịch học tuần từ 20-27/10 sẽ được điều chỉnh như sau:\n- Thứ 2, 20/10: Học bình thường 08:00-09:30\n- Thứ 4, 22/10: NGHỈ (Bù vào Chủ Nhật 27/10, 14:00-15:30)\n- Thứ 6, 24/10: Học bình thường 08:00-09:30\n\nMong học viên sắp xếp thời gian phù hợp.', '2025-10-06 17:15:44', NULL, 'Thay đổi lịch học tuần 20-27/10', 'chua doc'),
(14, NULL, NULL, 'TOEIC-4S-01-25', 'Giảng viên chia sẻ:\n1. Nghe: Luyện nghe 30 phút/ngày với podcast tiếng Anh\n2. Đọc: Đọc báo tiếng Anh business/economics mỗi ngày\n3. Từ vựng: Học 20 từ mới/ngày theo chủ đề\n4. Làm bài tập: Hoàn thành tối thiểu 1 practice test/tuần\n5. Quản lý thời gian: Luôn giới hạn thời gian khi làm bài\n\nChúc các bạn học tốt!', '2025-10-08 17:15:44', NULL, 'Tips học TOEIC hiệu quả từ giảng viên', 'da doc'),
(15, NULL, NULL, 'TOEIC-4S-01-25', 'Kỳ thi giữa kỳ sẽ diễn ra vào Thứ 7, ngày 25/10/2025 tại Phòng C301.\n- Thời gian: 09:00-11:00 (120 phút)\n- Hình thức: Full TOEIC Test (Listening 100 câu + Reading 100 câu)\n- Học viên mang theo: CMND/CCCD, bút chì 2B, tẩy\n- Không sử dụng tài liệu, điện thoại\n\nĐể chuẩn bị tốt, làm Practice Test 3-5 trước khi thi.', '2025-10-10 17:15:44', NULL, 'Thông báo thi giữa kỳ - 25/10/2025', 'chua doc');

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
(39, 1, 38, 'TOEIC-4S-01-25', 38.46, 5, 0, '2025-11-09 15:30:08'),
(40, 1, 32, 'BASIC-01-25', 0.00, 0, 18, '2025-10-14 21:05:47'),
(41, 1, 36, 'COM-1V1-01-25', 0.00, 0, 11, '2025-10-25 16:08:20'),
(42, 27, 42, 'IELTS-0-7-01-25', 0.00, 0, 13, '2025-10-29 16:27:24'),
(45, 48, 41, 'TOEIC-DE-02-25', 0.00, 0, 13, '2025-11-06 21:53:34');

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
(12, 'Dương Minh Khang', '0367890123', 'khang.duongminh@gmail.com', 'Tối (19h-21h)', 'Đã tư vấn'),
(17, 'Trần Hữu', '0336', 'hieutran170626@gmail.com', 'Chiều', 'Chưa liên hệ'),
(18, 'hieu', '12345678', 'hieutran170626@gmail.com', 'Sáng', 'Chưa liên hệ');

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
  MODIFY `id_baitest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `id_baiviet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id_binhluan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cauhoi`
--
ALTER TABLE `cauhoi`
  MODIFY `id_cauhoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=976;

--
-- AUTO_INCREMENT for table `chat_history`
--
ALTER TABLE `chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `dangkykhoahoc`
--
ALTER TABLE `dangkykhoahoc`
  MODIFY `id_dangky` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `danhgiakhoahoc`
--
ALTER TABLE `danhgiakhoahoc`
  MODIFY `id_danhgia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dapan`
--
ALTER TABLE `dapan`
  MODIFY `id_dapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2756;

--
-- AUTO_INCREMENT for table `dapan_hocvien`
--
ALTER TABLE `dapan_hocvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `diem_danh`
--
ALTER TABLE `diem_danh`
  MODIFY `id_diemdanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  MODIFY `id_hocvien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `hoc_lieu`
--
ALTER TABLE `hoc_lieu`
  MODIFY `id_hoclieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `ketquabaitest`
--
ALTER TABLE `ketquabaitest`
  MODIFY `id_ketqua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `id_khoahoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `lichhoc`
--
ALTER TABLE `lichhoc`
  MODIFY `id_lichhoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `lichsu_thanhtoan`
--
ALTER TABLE `lichsu_thanhtoan`
  MODIFY `id_thanhtoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `luot_truy_cap`
--
ALTER TABLE `luot_truy_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id_thongbao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tien_do_hoc_tap`
--
ALTER TABLE `tien_do_hoc_tap`
  MODIFY `id_tien_do` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tuvan`
--
ALTER TABLE `tuvan`
  MODIFY `id_tuvan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
