-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2025 at 02:59 PM
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
(9, 32, NULL, 'English Antonyms Test', 'dinh_ky', 60, '2024-12-16 00:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `cauhoi`
--

CREATE TABLE `cauhoi` (
  `id_cauhoi` int(11) NOT NULL,
  `id_baitest` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cauhoi`
--

INSERT INTO `cauhoi` (`id_cauhoi`, `id_baitest`, `noi_dung`) VALUES
(1, 1, 'What is the past tense of \"go\"?'),
(2, 1, 'Which word is a synonym of \"happy\"?'),
(3, 1, 'What is the plural of \"child\"?'),
(4, 1, 'What is the correct article for \"apple\"?'),
(5, 1, 'Which sentence is grammatically correct?'),
(6, 1, 'What is the comparative form of \"good\"?'),
(7, 1, 'Which word is a verb?'),
(8, 1, 'What is the antonym of \"hot\"?'),
(9, 1, 'What is the capital letter of \"a\"?'),
(10, 1, 'Which word is a noun?'),
(11, 1, 'What is the correct spelling?'),
(12, 1, 'What is the base form of \"studied\"?'),
(20, 1, 'What is the correct form of \"they\" in present tense?'),
(60, 2, 'What is the synonym of \"happy\"?'),
(61, 2, 'What is the antonym of \"big\"?'),
(62, 2, 'Which word is a noun?'),
(63, 2, 'Which word means \"to move quickly\"?'),
(64, 2, 'What is the plural of \"child\"?'),
(65, 2, 'Which word is a verb?'),
(66, 2, 'What is the synonym of \"angry\"?'),
(67, 2, 'What is the antonym of \"fast\"?'),
(68, 2, 'Which word is an adjective?'),
(69, 2, 'Which word is related to weather?'),
(70, 2, 'Which word is a preposition?'),
(71, 2, 'What is the past tense of \"run\"?'),
(72, 2, 'What is the meaning of \"benevolent\"?'),
(73, 2, 'Which word means \"large in size\"?'),
(74, 2, 'What is the synonym of \"cold\"?'),
(75, 2, 'What is the antonym of \"hard\"?'),
(76, 2, 'What is the meaning of \"serene\"?'),
(77, 2, 'Which word is a conjunction?'),
(78, 2, 'Which word is an interjection?'),
(79, 2, 'What is the meaning of \"precipitation\"?'),
(80, 2, 'What is the synonym of \"hot\"?'),
(81, 2, 'What is the meaning of \"diligent\"?'),
(82, 2, 'Which word is an article?'),
(83, 2, 'What is the synonym of \"beautiful\"?'),
(84, 2, 'What is the antonym of \"happy\"?'),
(100, 3, 'What is the correct article for \"apple\"?'),
(101, 3, 'Which word is a pronoun?'),
(102, 3, 'What is the past tense of \"go\"?'),
(103, 3, 'Which word is an adverb?'),
(104, 3, 'What is the plural of \"mouse\"?'),
(105, 3, 'Which sentence uses the correct tense?'),
(106, 3, 'What is the synonym of \"quickly\"?'),
(107, 3, 'Which word is an interjection?'),
(108, 3, 'What is the antonym of \"good\"?'),
(109, 3, 'Which is the correct spelling?'),
(110, 3, 'Which word is a conjunction?'),
(111, 3, 'What is the correct preposition for time?'),
(112, 3, 'What is the meaning of \"generous\"?'),
(113, 3, 'Which word is related to transportation?'),
(114, 3, 'Which sentence is grammatically correct?'),
(115, 3, 'What is the plural of \"person\"?'),
(116, 3, 'Which word is an adjective?'),
(117, 3, 'What is the synonym of \"small\"?'),
(118, 3, 'Which word is a noun?'),
(119, 3, 'What is the meaning of \"optimistic\"?'),
(120, 3, 'Which word is a verb?'),
(121, 3, 'What is the antonym of \"early\"?'),
(122, 3, 'Which word is related to education?'),
(123, 3, 'What is the synonym of \"beautiful\"?'),
(124, 3, 'What is the antonym of \"clean\"?'),
(125, 3, 'Which word means \"large in size\"?'),
(126, 3, 'What is the meaning of \"compassionate\"?'),
(127, 3, 'Which sentence uses passive voice?'),
(128, 3, 'What is the antonym of \"strong\"?'),
(129, 3, 'Which word is an article?'),
(150, 4, 'What does \"a piece of cake\" mean?'),
(151, 4, 'What does \"spill the beans\" mean?'),
(152, 4, 'What does \"break the ice\" mean?'),
(153, 4, 'What does \"hit the nail on the head\" mean?'),
(154, 4, 'What does \"cost an arm and a leg\" mean?'),
(155, 4, 'What does \"once in a blue moon\" mean?'),
(156, 4, 'What does \"burn the midnight oil\" mean?'),
(157, 4, 'What does \"cry over spilt milk\" mean?'),
(158, 4, 'What does \"bite the bullet\" mean?'),
(159, 4, 'What does \"let the cat out of the bag\" mean?'),
(160, 4, 'What does \"kick the bucket\" mean?'),
(161, 4, 'What does \"under the weather\" mean?'),
(162, 4, 'What does \"hit the sack\" mean?'),
(163, 4, 'What does \"add fuel to the fire\" mean?'),
(164, 4, 'What does \"kill two birds with one stone\" mean?'),
(165, 4, 'What does \"burn bridges\" mean?'),
(166, 4, 'What does \"on cloud nine\" mean?'),
(167, 4, 'What does \"when pigs fly\" mean?'),
(168, 4, 'What does \"raining cats and dogs\" mean?'),
(169, 4, 'What does \"pull someone’s leg\" mean?'),
(170, 4, 'What does \"the ball is in your court\" mean?'),
(171, 4, 'What does \"beat around the bush\" mean?'),
(172, 4, 'What does \"get out of hand\" mean?'),
(173, 4, 'What does \"call it a day\" mean?'),
(174, 4, 'What does \"cut corners\" mean?'),
(250, 6, 'Which tense is used for actions happening now?'),
(251, 6, 'What is the past tense of \"eat\"?'),
(252, 6, 'Which tense is used for future plans?'),
(253, 6, 'What is the present participle of \"run\"?'),
(254, 6, 'What tense is used to describe habits?'),
(255, 6, 'Which tense is used for completed actions?'),
(256, 6, 'What is the correct form of \"be\" in past tense?'),
(257, 6, 'What is the past tense of \"go\"?'),
(258, 6, 'Which tense is used to describe ongoing actions in the past?'),
(259, 6, 'What is the correct future form of \"will\"?'),
(260, 6, 'Which tense is used for actions happening at a specific time in the future?'),
(261, 6, 'What is the present perfect form of \"write\"?'),
(262, 6, 'What is the base form of \"was\"?'),
(263, 6, 'Which tense describes actions that were interrupted in the past?'),
(264, 6, 'Which tense uses \"has been\" + verb-ing?'),
(300, 7, 'What is the meaning of \"ubiquitous\"?'),
(301, 7, 'What is the synonym of \"meticulous\"?'),
(302, 7, 'What is the antonym of \"ambiguous\"?'),
(303, 7, 'What does \"ephemeral\" mean?'),
(304, 7, 'What is the synonym of \"benevolent\"?'),
(305, 7, 'What does \"incessant\" mean?'),
(306, 7, 'What is the antonym of \"diligent\"?'),
(307, 7, 'What does \"alleviate\" mean?'),
(308, 7, 'What is the meaning of \"precipice\"?'),
(309, 7, 'What does \"loquacious\" mean?'),
(400, 9, 'What is the antonym of \"happy\"?'),
(401, 9, 'What is the antonym of \"angry\"?'),
(402, 9, 'What is the antonym of \"big\"?'),
(403, 9, 'What is the antonym of \"small\"?'),
(404, 9, 'What is the antonym of \"fast\"?'),
(405, 9, 'What is the antonym of \"slow\"?'),
(406, 9, 'What is the antonym of \"kind\"?'),
(407, 9, 'What is the antonym of \"funny\"?'),
(408, 9, 'What is the antonym of \"bright\"?'),
(409, 9, 'What is the antonym of \"dark\"?'),
(410, 9, 'What is the antonym of \"strong\"?'),
(411, 9, 'What is the antonym of \"weak\"?'),
(412, 9, 'What is the antonym of \"hot\"?'),
(413, 9, 'What is the antonym of \"cold\"?'),
(414, 9, 'What is the antonym of \"rich\"?'),
(415, 9, 'What is the antonym of \"poor\"?'),
(416, 9, 'What is the antonym of \"clean\"?'),
(417, 9, 'What is the antonym of \"dirty\"?'),
(418, 9, 'What is the antonym of \"safe\"?'),
(419, 9, 'What is the antonym of \"dangerous\"?'),
(420, 9, 'What is the antonym of \"easy\"?'),
(421, 9, 'What is the antonym of \"hard\"?'),
(422, 9, 'What is the antonym of \"new\"?'),
(423, 9, 'What is the antonym of \"old\"?'),
(424, 9, 'What is the antonym of \"beautiful\"?'),
(425, 9, 'What is the antonym of \"ugly\"?'),
(426, 9, 'What is the antonym of \"quick\"?'),
(427, 9, 'What is the antonym of \"lazy\"?'),
(428, 9, 'What is the antonym of \"bright\"?'),
(429, 9, 'What is the antonym of \"sharp\"?'),
(430, 9, 'What is the antonym of \"soft\"?'),
(431, 9, 'What is the antonym of \"hard\"?'),
(432, 9, 'What is the antonym of \"strong\"?'),
(433, 9, 'What is the antonym of \"weak\"?'),
(434, 9, 'What is the antonym of \"simple\"?'),
(435, 9, 'What is the antonym of \"complex\"?'),
(436, 9, 'What is the antonym of \"tall\"?'),
(437, 9, 'What is the antonym of \"short\"?'),
(438, 9, 'What is the antonym of \"bright\"?'),
(439, 9, 'What is the antonym of \"dim\"?'),
(440, 9, 'What is the antonym of \"full\"?'),
(441, 9, 'What is the antonym of \"empty\"?'),
(442, 9, 'What is the antonym of \"clear\"?'),
(443, 9, 'What is the antonym of \"vague\"?'),
(444, 9, 'What is the antonym of \"light\"?');

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
(109, 1, 32, '2025-10-06', 'da xac nhan', '2025-10-06 11:52:19', 'BASIC-01-25', NULL),
(110, 1, 32, '2025-10-06', 'cho xac nhan', '2025-10-06 11:57:20', 'BASIC-01-25', NULL);

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
(1179, 444, NULL, 'Strong', 0);

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
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hocvien`
--

INSERT INTO `hocvien` (`id_hocvien`, `ten_hocvien`, `email`, `so_dien_thoai`, `mat_khau`, `trinh_do`, `is_admin`) VALUES
(1, 'Trần Hữu Hiếu', 'hieutran170626@gmail.com', '0337123222', '$2y$10$qB.9F5.WtQaDQ1Jfzu4MK./RUa/1.OQhJAAteaDf.3amHMsRQmX5q', 'Cơ bản (A1-A2)', 1),
(26, 'Hieu Huu', 'hieutran170619@gmail.com', '0123456789', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, 0),
(27, 'Test 1', 'T123456@gmail.com', '0123456781', '$2y$10$cTnTEQ2WdJNCGwiiYkOKsug1lvvBaSFjHZsajC3TPIfw3IPXvp4HG', NULL, 0),
(29, 'Nguyễn Văn A ', 'A123456@gmail.com', '0332343454', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, 0),
(30, 'Thu Phương ', 'Tp123456@gmail.com', '0387254814', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, 0),
(31, 'Nguyễn Hải ', 'NugyenHai1@gmail.com', '0866264811', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, 0),
(32, 'Nguyễn Ngọc Lâm', 'Lamngoc23@gmail.com', '0382648264', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, 0),
(33, 'Hiền', 'admin', '0974928364', '$2y$10$rASa/JWzEajB2DCUVb5q6OiPkY/t5jA4ajBKbNPSFUZLwAFhDTYzW', NULL, 1),
(37, 'Plee', 'nthuphuong2710@gmail.com', '111123', '$2y$10$PmdVCiif//irfQpXD51c.u1JSThDU1vQBvX0I1W/8WVFN33dTuRIi', NULL, 1),
(41, 'Trần Hữu Hiếu', 'hieutran@gmail.com', '1234567', '$2y$10$dMy3VA66k4xMkhKTBvpEM.tI5QiSTPwYTRcfRnzBJhaltk2tJ6CRe', NULL, 0),
(42, 'Trần Hữu Hiếu', 'hieutran17@gmail.com', '12345678', '$2y$10$QeFNKr065e.75rq0F0e1HOXK6rUgUQQ6igY7W3zXuLF1acw/6vLhe', NULL, 1),
(43, 'Trần Hữu Hiếu', 'hieutran1706111126@gmail.com', '123456', '$2y$10$FSFFVTaHNGbmecbHb0ju3eEulKdnb9EAQfNw1NBOwZ86pQE7rcMB6', NULL, 0);

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
(13, NULL, 'BASIC-01-25', 'Anh', 'JFIF', 'uploads/materials/1759393844_147fc92a-ba00-4431-b275-974efff1c43b.jfif', '2025-10-02 08:30:44');

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
(12, NULL, 1, 9, 3.00, '2025-10-02 15:37:00');

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
(32, 'Khóa học tiếng Anh cho người mất gốc', '<p>Kh&oacute;a học tiếng anh online cho người mất gốc l&agrave; kh&oacute;a học được thiết kế d&agrave;nh ri&ecirc;ng cho những người bắt đầu học tiếng Anh từ con số 0 tr&ecirc;n nền tảng trực tuyến. Những học vi&ecirc;n bị mất căn bản &amp; cần x&acirc;y dựng lại nền tảng kiến thức Anh ngữ từ đầu v&agrave; tiết kiệm thời gian di chuyển đến trung t&acirc;m th&igrave; c&oacute; thể tham khảo kh&oacute;a học n&agrave;y nh&eacute;!<br />\r\nLộ tr&igrave;nh kh&oacute;a học được x&acirc;y dựng b&agrave;i bản, tập trung v&agrave;o những chủ đề gần gũi, thiết thực trong đời sống. Ngo&agrave;i ra, kh&oacute;a học hướng tới yếu tố &ldquo;học s&acirc;u, nhớ l&acirc;u&rdquo;, ph&aacute;t triển kỹ năng tập trung gi&uacute;p người học tiếng Anh từ &ldquo;zero&rdquo; th&agrave;nh &ldquo;hero&rdquo;.</p>\r\n\r\n<h3>Ưu điểm của kh&oacute;a tiếng Anh online cho người mất gốc:</h3>\r\n\r\n<ul>\r\n	<li>Được thiết kế d&agrave;nh ri&ecirc;ng cho người mất gốc tiếng Anh tr&ecirc;n nền tảng học online</li>\r\n	<li>Học bất bất cứ nơi đ&acirc;u, bất cứ thời gian n&agrave;o theo lịch rảnh của bản th&acirc;n</li>\r\n	<li>Học trực tiếp với giảng vi&ecirc;n thay v&igrave; c&aacute;c chuỗi video</li>\r\n	<li>Được m&ocirc; phỏng giống 100% so với c&aacute;c lớp học offline tại trung t&acirc;m</li>\r\n	<li>Slide b&agrave;i giảng trực quan, thiết thực, đi s&acirc;u v&agrave;o ph&acirc;n t&iacute;ch &amp; cải thiện từng kỹ năng cho người học</li>\r\n	<li>Phương ph&aacute;p học tập khoa học, mang t&iacute;nh tương t&aacute;c cao giữa gi&aacute;o vi&ecirc;n &amp; học vi&ecirc;n trong suốt qu&aacute; tr&igrave;nh học tập trực tuyến, gi&uacute;p học vi&ecirc;n dễ tiếp thu b&agrave;i giảng &amp; vận dụng nhanh ch&oacute;ng v&agrave;o thực tế</li>\r\n	<li>Cam kết x&acirc;y dựng nền tảng tiếng Anh hiệu quả trong suốt thời gian học online</li>\r\n	<li>Ứng dụng c&ocirc;ng nghệ khoa học v&agrave;o giảng dạy, gi&uacute;p học vi&ecirc;n trải nghiệm học online đạt chuẩn quốc tế</li>\r\n	<li>Đội ngũ gi&aacute;o vi&ecirc;n Việt &amp; bản xứ giỏi, tận t&acirc;m, được đ&agrave;o tạo chuy&ecirc;n s&acirc;u về giảng dạy</li>\r\n	<li>Hệ thống đăng k&yacute; lịch học online c&ocirc;ng nghệ hiện đại với 10 khung giờ linh hoạt mỗi ng&agrave;y</li>\r\n	<li>Kết hợp với kh&oacute;a học ph&aacute;t &acirc;m tiếng Anh cho học vi&ecirc;n giọng chuẩn bản xứ cực kỳ chi tiết</li>\r\n</ul>\r\n\r\n<p>Kh&oacute;a học tiếng Anh giao tiếp Online cho người mất gốc sẽ gi&uacute;p học vi&ecirc;n điều chỉnh ph&aacute;t &acirc;m chuẩn theo bản phi&ecirc;n &acirc;m quốc tế từ Gi&aacute;o vi&ecirc;n người Việt &amp; bản ngữ. Học ph&aacute;t &acirc;m từng bước từ ph&aacute;t &acirc;m từ đơn, đến ph&aacute;t &acirc;m chuẩn nguy&ecirc;n c&acirc;u &amp; ph&aacute;t &acirc;m hay k&egrave;m ngữ điệu tự nhi&ecirc;n. Học vi&ecirc;n cũng được ph&aacute;t triển kỹ năng nghe (Listening) trong suốt qu&aacute; tr&igrave;nh học tiếng Anh trực tuyến.</p>\r\n', NULL, 2000, 'uploads/img1.jpg', 0.00),
(35, 'Khóa học tiếng Anh cho trẻ em và thanh thiếu niên', '<p>Đội ngũ gi&aacute;o vi&ecirc;n sẽ phối hợp với qu&yacute; phụ huynh để đảm bảo c&aacute;c em học sinh được hỗ trợ trong từng bước h&agrave;nh tr&igrave;nh học tiếng Anh. Cũng như qu&yacute; phụ huynh, ch&uacute;ng t&ocirc;i hiểu được tiềm năng của trẻ v&agrave; mong muốn gi&uacute;p trẻ đạt được tiến bộ r&otilde; rệt.&nbsp;</p>\r\n\r\n<p>Chứng kiến sự trưởng th&agrave;nh về học lực v&agrave; sự tự tin của trẻ. Th&ocirc;ng qua c&aacute;c kh&oacute;a học, trẻ sẽ ph&aacute;t triển sự s&aacute;ng tạo, tăng cường c&aacute;c kỹ năng gi&uacute;p th&agrave;nh c&ocirc;ng v&agrave; khả năng tiếng Anh - ng&ocirc;n ngữ chung của thế giới.</p>\r\n\r\n<h2><strong>Ph&aacute;t huy sự tự tin v&agrave; truyền cảm hứng s&aacute;ng tạo&nbsp;</strong></h2>\r\n', NULL, 2000, 'uploads/anh_email_hs_0.avif', NULL),
(36, 'Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam', '<p>N&oacute;i nhanh, n&oacute;i chuẩn, n&oacute;i linh hoạt theo từng ngữ cảnh, tự tin bắt chuyện với đối t&aacute;c nước ngo&agrave;i, l&agrave;m chủ giao tiếp hang ng&agrave;y trong c&ocirc;ng việc.</p>\r\n\r\n<p><strong>1. Phương ph&aacute;p học tập A.I.T.E.C.H</strong></p>\r\n\r\n<ul>\r\n	<li>Lấy giao tiếp l&agrave;m cốt l&otilde;i</li>\r\n	<li>Lấy học vi&ecirc;n l&agrave;m trọng t&acirc;m</li>\r\n	<li>Tập trung n&acirc;ng cao về kỹ năng giao tiếp v&agrave; thực h&agrave;nh phản xạ nghe n&oacute;i tự nhi&ecirc;n, chỉnh sửa ph&aacute;t &acirc;m chuẩn quốc tế, &aacute;p dụng c&aacute;c t&igrave;nh huống giao tiếp gắn liền với cuộc sống v&agrave; c&ocirc;ng việc h&agrave;ng ng&agrave;y gi&uacute;p chị r&egrave;n kỹ năng tư duy thẳng ho&agrave;n to&agrave;n bằng tiếng Anh.</li>\r\n</ul>\r\n\r\n<p><strong>2. Gi&aacute;o tr&igrave;nh chuẩn 100% quốc tế v&agrave; được Hội đồng chuy&ecirc;n m&ocirc;n thiết kế c&aacute; nh&acirc;n ho&aacute; ph&ugrave; hợp theo từng mục ti&ecirc;u, tr&igrave;nh độ của học vi&ecirc;n</strong></p>\r\n\r\n<p>Dựa tr&ecirc;n mong muốn học tập của học vi&ecirc;n th&igrave; Hội đồng chuy&ecirc;n m&ocirc;n sẽ x&acirc;y dựng gi&aacute;o tr&igrave;nh tiếng Anh ph&ugrave; hợp. Chương tr&igrave;nh c&oacute; 3 loại gi&aacute;o tr&igrave;nh:</p>\r\n\r\n<ul>\r\n	<li><strong>Gi&aacute;o tr&igrave;nh cho c&aacute;c b&eacute; Kids theo ti&ecirc;u chuẩn của Cambridge:</strong>&nbsp;Tất cả c&aacute;c chương tr&igrave;nh học đều được thiết kế đa phương tiện gồm: H&igrave;nh ảnh, &acirc;m thanh, video, c&acirc;u chuyện sinh động, nh&acirc;n vật hoạt h&igrave;nh đồng h&agrave;nh trong to&agrave;n bộ qu&aacute; tr&igrave;nh học. C&aacute;c chủ đề từ vựng, ngữ ph&aacute;p được thiết kế xen kẽ c&aacute;c t&igrave;nh huống giao tiếp đời sống, học tập. Ngo&agrave;i ra con được học kết hợp c&aacute;c bộ m&ocirc;n khoa học thưởng thức v&agrave; b&agrave;i học đạo đức x&atilde; hội, gi&uacute;p con ph&aacute;t triển to&agrave;n diện Kỹ năng giao tiếp, kỹ năng mềm v&agrave; kỹ năng tư duy.</li>\r\n	<li><strong>GT th&ocirc;ng dụng GE:</strong>&nbsp;X&acirc;y dựng c&aacute;c t&igrave;nh huống giao tiếp trong cuộc sống hằng ng&agrave;y, giao tiếp bạn b&egrave;; định cư; du lịch&hellip;</li>\r\n	<li><strong>MBE &ndash; tiếng anh giao tiếp trong m&ocirc;i trường c&ocirc;ng sở:</strong>&nbsp;kinh doanh; họp h&agrave;nh; b&aacute;o c&aacute;o; thuyết tr&igrave;nh, đ&agrave;m ph&aacute;n.</li>\r\n</ul>\r\n\r\n<p><strong>3. Anh/ Chị đăng k&yacute; theo lịch học cố định ph&ugrave; hợp:</strong></p>\r\n\r\n<ul>\r\n	<li>Từ 8h &ndash; 23h, từ thứ 2-thứ 6 (nghỉ t7-cn)</li>\r\n	<li>Luyện n&oacute;i phản xạ tối thiểu 30 ph&uacute;t/buổi; 3 &ndash; 5 buổi/tuần</li>\r\n</ul>\r\n\r\n<p><strong>4. Hai gi&aacute;o vi&ecirc;n đồng h&agrave;nh xuy&ecirc;n suốt qu&aacute; tr&igrave;nh học: Với kho&aacute; học n&agrave;y th&igrave; học vi&ecirc;n sẽ được học 100% gi&aacute;o vi&ecirc;n Việt Nam</strong></p>\r\n\r\n<p><strong>Gi&aacute;o vi&ecirc;n cố định 1 k&egrave;m 1:</strong></p>\r\n\r\n<ul>\r\n	<li>Với kho&aacute; học n&agrave;y th&igrave; học vi&ecirc;n sẽ được học 100% gi&aacute;o vi&ecirc;n Việt Nam với đầy đủ chứng chỉ sư phạm, chứng chỉ tiếng Anh hoặc c&aacute;c chứng chỉ kh&aacute;c tương đương v&agrave; &iacute;t nhất hai năm kinh nghiệm giảng dạy</li>\r\n	<li>Được đ&agrave;o tạo theo quy chuẩn 5 bước về kỹ năng giảng dạy v&agrave; chuy&ecirc;n m&ocirc;n sư phạm bởi hội đồng chuy&ecirc;n gia h&agrave;ng đầu về ng&ocirc;n ngữ:( Phỏng vấn &ndash; Dạy thử &ndash; QC &ndash; Nhận lớp &ndash; Đ&aacute;nh gi&aacute;)</li>\r\n	<li>\r\n	<p><strong>Cố vấn học tập v&agrave; hội đồng QC:</strong></p>\r\n	</li>\r\n	<li>Sẽ đồng h&agrave;nh c&ugrave;ng học vi&ecirc;n theo s&aacute;t lộ tr&igrave;nh học tập về: lịch học; chất lượng gi&aacute;o vi&ecirc;n; chất lượng buổi học</li>\r\n	<li>Học vi&ecirc;n sẽ li&ecirc;n hệ Cố vấn học tập qua nh&oacute;m chat học tập zalo</li>\r\n</ul>\r\n\r\n<p><strong>5. Hệ thống Gi&aacute;o dục trực tuyến độc quyền LMS ( Learning Management Systerm) 5 trong 1:</strong></p>\r\n\r\n<ul>\r\n	<li>Tương t&aacute;c đa chiều</li>\r\n	<li>L&agrave;m b&agrave;i tập trực tuyến.</li>\r\n	<li>T&iacute;ch hợp t&agrave;i liệu bổ trợ.</li>\r\n	<li>Kiểm so&aacute;t b&aacute;o c&aacute;o tiến bộ định kỳ : định kỳ hệ thống sẽ thống k&ecirc; b&aacute;o c&aacute;o kết quả học tập của chị</li>\r\n	<li>Lưu trữ buổi học trực tuyến tự động: lưu lại tr&ecirc;n t&agrave;i khoản học tập để chị xem lại khi cần &ocirc;n tập; đ&aacute;nh gi&aacute; về qu&aacute; tr&igrave;nh học của m&igrave;nh v&agrave; chất lượng dịch vụ học tập của nh&agrave; trường</li>\r\n</ul>\r\n\r\n<p><strong>6. Cam kết ho&agrave;n học ph&iacute; đ&agrave;o tạo 100% nếu kh&ocirc;ng đạt được điểm số cam kết theo hợp đồng gi&aacute;o dục:</strong></p>\r\n\r\n<ul>\r\n	<li>Cam kết chất lượng được thể hiện bằng điểm số GSE-về năng lực giao tiếp nghe n&oacute;i theo chuẩn quốc tế tr&ecirc;n tổng điểm 90</li>\r\n	<li>Cam kết sẽ thể hiện bằng văn bản: Hợp đồng gi&aacute;o dục.</li>\r\n</ul>\r\n', NULL, 2000, 'uploads/1kem1.jpg', NULL),
(37, 'Khóa Học Tiếng Anh Giao Tiếp', '<p>Tiếng Anh l&agrave; một trong những ng&ocirc;n ngữ phổ biến khắp thế giới. Với khả năng tiếng Anh tốt, bạn c&oacute; thể giao tiếp với khoảng 1/6 d&acirc;n số tr&ecirc;n thế giới, mở ra những c&aacute;nh cửa cơ hội trong cuộc sống v&agrave; đặc biệt sẽ gi&uacute;p &iacute;ch cho c&ocirc;ng việc của bạn rất nhiều.</p>\r\n\r\n<p>Nhận thấy tầm quan trọng của tiếng Anh trong x&atilde; hội to&agrave;n cầu h&oacute;a hiện nay, Thi&ecirc;n T&uacute; Academy đ&atilde; tổ chức c&aacute;c kh&oacute;a học Tiếng Anh Giao Tiếp với &ldquo;<em>Học ph&iacute; Việt Nam &ndash; Chất lượng to&agrave;n cầu</em>&rdquo;. Kh&oacute;a học nhằm gi&uacute;p học vi&ecirc;n ph&aacute;t triển c&aacute;c kỹ năng tiếng Anh ph&ugrave; hợp với mục ti&ecirc;u học tập, nghề nghiệp v&agrave; cả mục ti&ecirc;u c&aacute; nh&acirc;n. Đặc biệt l&agrave; đối với những ai c&oacute; &yacute; định đi du học hay định cư,&hellip;khả năng giao tiếp tiếng Anh tốt đ&atilde; gi&uacute;p c&aacute;c bạn đi được đến hơn 1/3 chặng đường.</p>\r\n\r\n<p><img alt=\"\" src=\"https://thientu-academy.com/wp-content/uploads/2020/10/like.png\" style=\"height:64px; width:64px\" /></p>\r\n\r\n<p>Lợi &Iacute;ch Kh&oacute;a Học</p>\r\n\r\n<p>1. Ph&aacute;t triển kỹ năng nghe &ndash; n&oacute;i một c&aacute;ch tối đa</p>\r\n\r\n<p>2. Mở rộng kiến thức ngo&agrave;i s&aacute;ch gi&aacute;o khoa</p>\r\n\r\n<p>3. Tăng khả năng tư duy, học hỏi, s&aacute;ng tạo</p>\r\n\r\n<p>4. Kỹ năng n&oacute;i tr&ocirc;i chảy v&agrave; tự tin hơn trong giao tiếp</p>\r\n\r\n<p>5. Tạo tiền đề cho c&aacute;c kh&oacute;a học luyện thi IELTS sau n&agrave;y</p>\r\n\r\n<p>6. Hoạt động nh&oacute;m li&ecirc;n tục v&agrave; đa dạng h&igrave;nh thức</p>\r\n\r\n<p>7. Phục vụ nhu cầu đi du học &amp; định cư cho tương lai</p>\r\n\r\n<p><img alt=\"\" src=\"https://thientu-academy.com/wp-content/uploads/2020/10/book-1.png\" style=\"height:64px; width:64px\" /></p>\r\n\r\n<h3>Điều Kiện Đầu V&agrave;o</h3>\r\n\r\n<h3>Độ tuổi:</h3>\r\n\r\n<ul>\r\n	<li>Từ 7 tuổi trở l&ecirc;n</li>\r\n</ul>\r\n\r\n<h3>Tr&igrave;nh độ học vấn:</h3>\r\n\r\n<ul>\r\n	<li>Kh&ocirc;ng y&ecirc;u cầu</li>\r\n</ul>\r\n\r\n<h3>Tr&igrave;nh độ ngoại ngữ:</h3>\r\n\r\n<ul>\r\n	<li>Ho&agrave;n th&agrave;nh b&agrave;i kiểm tra đầu v&agrave;o của trung t&acirc;m (nếu cần)</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n', NULL, 3000000, 'uploads/sGRAe3NTTS.jpg', NULL),
(38, ' Khóa học TOEIC 4 KỸ NĂNG', '<p>Kh&oacute;a học TOEIC 4 kỹ năng bao gồm luyện tập cả 4 kỹ năng nghe, n&oacute;i, đọc v&agrave; viết, nhằm gi&uacute;p học vi&ecirc;n cải thiện khả năng sử dụng tiếng Anh một c&aacute;ch to&agrave;n diện v&agrave; chuẩn bị tốt hơn cho kỳ thi TOEIC. Kh&oacute;a học n&agrave;y c&oacute; thể gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng giao tiếp tiếng Anh, đọc hiểu c&aacute;c t&agrave;i liệu chuy&ecirc;n ng&agrave;nh, viết b&aacute;o c&aacute;o v&agrave; email c&ocirc;ng việc, v&agrave; cải thiện điểm số TOEIC của m&igrave;nh.</p>\r\n\r\n<h2>1. Giới thiệu về kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p><a href=\"https://edusa.vn/toeic-4-ky-nang-bao-nhieu-tien/\">Kh&oacute;a học TOEIC 4 kỹ năng</a>&nbsp;(TOEIC 4 Skills) l&agrave; một kh&oacute;a học tiếng Anh tổng qu&aacute;t, tập trung v&agrave;o cải thiện cả bốn kỹ năng ng&ocirc;n ngữ tiếng Anh, bao gồm Nghe, N&oacute;i, Đọc v&agrave; Viết. Kh&oacute;a học n&agrave;y gi&uacute;p người học x&acirc;y dựng nền tảng ng&ocirc;n ngữ tiếng Anh vững chắc để chuẩn bị cho kỳ thi TOEIC hoặc c&aacute;c kỳ thi tương tự. Trong kh&oacute;a học, học vi&ecirc;n sẽ được trang bị vốn từ vựng phong ph&uacute;, kỹ năng ph&aacute;t &acirc;m, luyện nghe hiểu, n&acirc;ng cao kỹ năng viết v&agrave; n&oacute;i tiếng Anh th&ocirc;ng qua c&aacute;c b&agrave;i tập v&agrave; c&aacute;c hoạt động tương t&aacute;c. Kh&oacute;a học n&agrave;y th&iacute;ch hợp cho những người muốn n&acirc;ng cao tr&igrave;nh độ tiếng Anh chung v&agrave; sẵn s&agrave;ng đạt được điểm số cao trong kỳ thi TOEIC.</p>\r\n\r\n<p><strong>C&oacute; thể bạn quan t&acirc;m:&nbsp;<a href=\"https://edusa.vn/luyen-thi-toeic-cap-toc-online/\">Kh&oacute;a luyện thi toeic cấp tốc online trải nghiệm Học thật &ndash; thi thật</a></strong></p>\r\n\r\n<p><strong>C&oacute; thể bạn quan t&acirc;m:</strong>&nbsp;<a href=\"https://edusa.vn/khoa-hoc-toeic-4-ky-nang-online/\"><strong>Chi tiết về kh&oacute;a học TOEIC 4 kỹ năng Online</strong></a></p>\r\n\r\n<h2>2. Tại sao n&ecirc;n học kh&oacute;a học TOEIC 4 kỹ năng?</h2>\r\n\r\n<p>Kh&oacute;a học TOEIC 4 kỹ năng l&agrave; một kh&oacute;a học tiếng Anh được thiết kế để gi&uacute;p học vi&ecirc;n cải thiện 4 kỹ năng quan trọng: nghe, đọc, n&oacute;i v&agrave; viết, để c&oacute; thể đạt được kết quả cao trong kỳ thi TOEIC. Tại sao n&ecirc;n học kh&oacute;a học TOEIC 4 kỹ năng? Dưới đ&acirc;y l&agrave; một số l&yacute; do quan trọng:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Tăng khả năng giao tiếp bằng tiếng Anh: Kh&oacute;a học TOEIC 4 kỹ năng sẽ gi&uacute;p bạn n&acirc;ng cao kỹ năng nghe v&agrave; n&oacute;i của m&igrave;nh, gi&uacute;p bạn tự tin hơn khi giao tiếp bằng tiếng Anh. Bạn sẽ c&oacute; cơ hội luyện tập kỹ năng nghe v&agrave; ph&aacute;t &acirc;m trong m&ocirc;i trường học tập chuy&ecirc;n nghiệp v&agrave; thuận lợi.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cải thiện kỹ năng đọc hiểu: Trong kh&oacute;a học n&agrave;y, bạn sẽ được đ&agrave;o tạo để c&oacute; thể đọc hiểu c&aacute;c đoạn văn bản học thuật v&agrave; kinh doanh bằng tiếng Anh. Điều n&agrave;y sẽ gi&uacute;p bạn n&acirc;ng cao khả năng đọc hiểu v&agrave; giải quyết c&aacute;c vấn đề li&ecirc;n quan đến c&ocirc;ng việc hoặc học tập.</p>\r\n	</li>\r\n	<li>\r\n	<p>N&acirc;ng cao kỹ năng viết: Kỹ năng viết lu&ocirc;n l&agrave; một trong những kỹ năng kh&oacute; nhất trong tiếng Anh. Tuy nhi&ecirc;n, kh&oacute;a học TOEIC 4 kỹ năng sẽ gi&uacute;p bạn n&acirc;ng cao kỹ năng viết v&agrave; cung cấp c&aacute;c kỹ thuật để viết đ&uacute;ng, đủ v&agrave; r&otilde; r&agrave;ng.</p>\r\n	</li>\r\n	<li>\r\n	<p>Đ&aacute;p ứng y&ecirc;u cầu của thị trường lao động: Nếu bạn muốn th&agrave;nh c&ocirc;ng trong sự nghiệp, việc c&oacute; một chứng chỉ TOEIC với điểm số cao rất quan trọng. Với kết quả cao trong kỳ thi TOEIC, bạn sẽ c&oacute; nhiều cơ hội hơn để t&igrave;m kiếm việc l&agrave;m tốt hơn v&agrave; c&oacute; thu nhập cao hơn.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cập nhật kiến thức tiếng Anh mới nhất: Với kh&oacute;a học TOEIC 4 kỹ năng, bạn sẽ được cập nhật c&aacute;c kiến thức mới nhất trong lĩnh vực tiếng Anh học thuật v&agrave; kinh doanh. Bạn sẽ học c&aacute;c từ vựng v&agrave; thuật ngữ mới, v&agrave; n&acirc;ng cao kỹ năng sử dụng ng&ocirc;n ngữ chuy&ecirc;n ng&agrave;nh.</p>\r\n	</li>\r\n</ol>\r\n\r\n<h2>3. C&aacute;c phương ph&aacute;p v&agrave; kỹ thuật luyện thi TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Luyện thi TOEIC 4 kỹ năng l&agrave; qu&aacute; tr&igrave;nh r&egrave;n luyện v&agrave; n&acirc;ng cao kỹ năng ng&ocirc;n ngữ Anh cần thiết để đạt được điểm số cao trong kỳ thi TOEIC. Kh&oacute;a học n&agrave;y tập trung v&agrave;o 4 kỹ năng ch&iacute;nh bao gồm: Nghe, Đọc, N&oacute;i v&agrave; Viết. Dưới đ&acirc;y l&agrave; một số phương ph&aacute;p v&agrave; kỹ thuật hiệu quả trong việc luyện thi TOEIC 4 kỹ năng.</p>\r\n\r\n<p>Nghe:</p>\r\n\r\n<p>Học c&aacute;c từ vựng chuy&ecirc;n ng&agrave;nh: Tập trung v&agrave;o ngữ ph&aacute;p v&agrave; từ vựng chuy&ecirc;n ng&agrave;nh thường được sử dụng trong c&aacute;c cuộc giao tiếp trong ng&agrave;nh của bạn. Điều n&agrave;y gi&uacute;p bạn dễ d&agrave;ng hiểu được c&aacute;c c&acirc;u hỏi v&agrave; nội dung chủ đề trong đề thi TOEIC.<br />\r\nLuyện nghe nhiều: H&atilde;y luyện nghe tiếng Anh một c&aacute;ch chủ động, bằng c&aacute;ch nghe c&aacute;c bản tin, phim, chương tr&igrave;nh thực tế hoặc c&aacute;c b&agrave;i giảng học thuật li&ecirc;n quan đến ng&agrave;nh của bạn.<br />\r\nL&agrave;m b&agrave;i tập nghe: L&agrave;m c&aacute;c b&agrave;i tập nghe từ c&aacute;c t&agrave;i liệu luyện thi TOEIC để củng cố kỹ năng nghe của bạn.</p>\r\n\r\n<p>Đọc:</p>\r\n\r\n<p>Học từ vựng v&agrave; ngữ ph&aacute;p cần thiết: Tập trung v&agrave;o học c&aacute;c từ vựng v&agrave; ngữ ph&aacute;p li&ecirc;n quan đến chuy&ecirc;n ng&agrave;nh của bạn, gi&uacute;p bạn dễ d&agrave;ng hiểu được c&aacute;c c&acirc;u hỏi v&agrave; c&aacute;c nội dung chủ đề trong đề thi.<br />\r\nĐọc nhiều: Đọc c&aacute;c b&aacute;o, tạp ch&iacute; v&agrave; s&aacute;ch về chuy&ecirc;n ng&agrave;nh của bạn. Điều n&agrave;y gi&uacute;p bạn l&agrave;m quen với c&aacute;c từ vựng v&agrave; thuật ngữ chuy&ecirc;n m&ocirc;n.<br />\r\nL&agrave;m b&agrave;i tập đọc: L&agrave;m c&aacute;c b&agrave;i tập đọc từ c&aacute;c t&agrave;i liệu luyện thi TOEIC để củng cố kỹ năng đọc của bạn.</p>\r\n\r\n<p>N&oacute;i:</p>\r\n\r\n<p>Luyện n&oacute;i thường xuy&ecirc;n: H&atilde;y t&igrave;m kiếm cơ hội để n&oacute;i tiếng Anh với bạn b&egrave;, đồng nghiệp hoặc tham gia c&aacute;c lớp học n&oacute;i tiếng Anh.<br />\r\nThực h&agrave;nh c&acirc;u trả lời đ&uacute;ng dạng: Tập trung v&agrave;o c&aacute;c c&acirc;u hỏi phổ biến trong đề thi TOEIC, nghi&ecirc;n cứu v&agrave; thực h&agrave;nh c&acirc;u trả lời đ&uacute;ng dạng để củng cố kỹ năng n&oacute;i của bạn.</p>\r\n\r\n<p>Luyện ngữ ph&aacute;p v&agrave; từ vựng đồng thời: Kh&ocirc;ng thể thiếu việc học ngữ ph&aacute;p v&agrave; từ vựng trong qu&aacute; tr&igrave;nh luyện thi TOEIC. Tuy nhi&ecirc;n, để tối ưu h&oacute;a qu&aacute; tr&igrave;nh học, bạn n&ecirc;n học ngữ ph&aacute;p v&agrave; từ vựng đồng thời với c&aacute;c kỹ năng kh&aacute;c như đọc hiểu, nghe v&agrave; n&oacute;i. Việc n&agrave;y gi&uacute;p bạn ph&aacute;t triển vốn từ vựng v&agrave; khả năng sử dụng ngữ ph&aacute;p trong c&aacute;c b&agrave;i thi TOEIC.</p>\r\n\r\n<p><br />\r\nTập trung v&agrave;o phần nghe: Phần nghe trong kỳ thi TOEIC chiếm tỷ lệ điểm kh&aacute; cao, do đ&oacute; việc tập trung luyện nghe l&agrave; rất quan trọng. Bạn c&oacute; thể luyện nghe qua c&aacute;c b&agrave;i nghe tr&ecirc;n mạng hoặc qua c&aacute;c t&agrave;i liệu luyện thi TOEIC. Bạn n&ecirc;n luyện nghe tr&ecirc;n nhiều chủ đề kh&aacute;c nhau để cải thiện khả năng nghe của m&igrave;nh.</p>\r\n\r\n<p><br />\r\nTổ chức thời gian hợp l&yacute;: Khi luyện thi TOEIC 4 kỹ năng, bạn cần phải biết c&aacute;ch ph&acirc;n bổ thời gian hợp l&yacute; cho c&aacute;c kỹ năng kh&aacute;c nhau. Bạn n&ecirc;n sử dụng một lịch tr&igrave;nh học tập để luyện tập mỗi kỹ năng theo từng phần nhỏ trong ng&agrave;y.</p>\r\n\r\n<p><br />\r\nThi thử TOEIC: Thi thử TOEIC l&agrave; c&aacute;ch tốt nhất để kiểm tra khả năng v&agrave; đo lường tiến độ luyện tập của m&igrave;nh. Thi thử gi&uacute;p bạn l&agrave;m quen với cấu tr&uacute;c đề thi, c&aacute;ch đọc v&agrave; hiểu c&acirc;u hỏi, từ đ&oacute; gi&uacute;p bạn tự tin hơn khi bước v&agrave;o kỳ thi thật.</p>\r\n\r\n<p><br />\r\nTham gia lớp học TOEIC: Nếu bạn muốn c&oacute; kết quả tốt nhất trong kỳ thi TOEIC, h&atilde;y tham gia lớp học TOEIC. Lớp học TOEIC cung cấp kiến thức chuy&ecirc;n s&acirc;u, gi&uacute;p bạn hiểu r&otilde; hơn về cấu tr&uacute;c đề thi TOEIC cũng như phương ph&aacute;p giải đề thi. B&ecirc;n cạnh đ&oacute;, lớp học c&ograve;n gi&uacute;p bạn r&egrave;n luyện kỹ năng nghe, n&oacute;i, đọc v&agrave; viết.</p>\r\n\r\n<h2>4. C&aacute;c lưu &yacute; v&agrave; ch&uacute; &yacute; khi học kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Khi học kh&oacute;a học TOEIC 4 kỹ năng, bạn cần lưu &yacute; một số điểm sau để đạt hiệu quả tốt nhất:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>X&aacute;c định mục ti&ecirc;u học tập r&otilde; r&agrave;ng: Bạn n&ecirc;n đặt ra mục ti&ecirc;u cụ thể cho m&igrave;nh về điểm số TOEIC m&agrave; muốn đạt được v&agrave; l&ecirc;n kế hoạch học tập cho ph&ugrave; hợp với mục ti&ecirc;u đ&oacute;.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tập trung v&agrave;o 4 kỹ năng: Bạn cần học đồng thời 4 kỹ năng l&agrave; Nghe, N&oacute;i, Đọc v&agrave; Viết, thay v&igrave; tập trung qu&aacute; nhiều v&agrave;o một kỹ năng cụ thể.</p>\r\n	</li>\r\n	<li>\r\n	<p>Sử dụng t&agrave;i liệu học tập chất lượng: Chọn lựa t&agrave;i liệu học tập ph&ugrave; hợp v&agrave; c&oacute; chất lượng tốt sẽ gi&uacute;p bạn tiết kiệm thời gian v&agrave; đạt được kết quả tốt nhất.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tham gia lớp học trực tuyến: Việc tham gia lớp học trực tuyến gi&uacute;p bạn tiết kiệm được thời gian di chuyển, c&oacute; cơ hội học tập v&agrave; tương t&aacute;c với c&aacute;c giảng vi&ecirc;n v&agrave; học vi&ecirc;n kh&aacute;c.</p>\r\n	</li>\r\n	<li>\r\n	<p>Thực h&agrave;nh thường xuy&ecirc;n: Thực h&agrave;nh l&agrave; c&aacute;ch tốt nhất để n&acirc;ng cao kỹ năng của bạn. Bạn cần l&ecirc;n kế hoạch thực h&agrave;nh thường xuy&ecirc;n để r&egrave;n luyện khả năng sử dụng tiếng Anh một c&aacute;ch th&agrave;nh thạo.</p>\r\n	</li>\r\n	<li>\r\n	<p>Đ&aacute;nh gi&aacute; tiến độ học tập: Bạn cần đ&aacute;nh gi&aacute; tiến độ học tập thường xuy&ecirc;n để biết m&igrave;nh đang ở đ&acirc;u v&agrave; cần cải thiện điểm g&igrave; để đạt được mục ti&ecirc;u của m&igrave;nh.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tự tin v&agrave; ki&ecirc;n nhẫn: Cuối c&ugrave;ng, bạn cần tự tin v&agrave; ki&ecirc;n nhẫn trong qu&aacute; tr&igrave;nh học tập. Đ&ocirc;i khi bạn c&oacute; thể gặp kh&oacute; khăn v&agrave; thất vọng, nhưng h&atilde;y ki&ecirc;n tr&igrave; v&agrave; kh&ocirc;ng bỏ cuộc. Sự cố gắng v&agrave; nỗ lực sẽ mang lại kết quả tốt cho bạn.</p>\r\n	</li>\r\n</ol>\r\n\r\n<blockquote>\r\n<p><strong>&gt;&gt;&gt;&gt; Tham khảo th&ecirc;m :&nbsp;<a href=\"https://edusa.vn/khoa-hoc-toeic/\">Kh&oacute;a luyện thi TOEIC 4 kỹ năng tại Edusa&nbsp;</a></strong></p>\r\n</blockquote>\r\n\r\n<h2>5. B&agrave;i tập v&agrave; đề thi mẫu trong kh&oacute;a học TOEIC 4 kỹ năng</h2>\r\n\r\n<p>Trong kh&oacute;a học TOEIC 4 kỹ năng, c&aacute;c b&agrave;i tập v&agrave; đề thi mẫu được thiết kế để gi&uacute;p học vi&ecirc;n củng cố kiến thức v&agrave; kỹ năng của m&igrave;nh trong 4 kỹ năng Nghe, Đọc, N&oacute;i v&agrave; Viết, c&ugrave;ng với c&aacute;c kỹ năng li&ecirc;n quan như Từ vựng, Ngữ ph&aacute;p v&agrave; Ph&aacute;t &acirc;m.</p>\r\n\r\n<p>Dưới đ&acirc;y l&agrave; một số v&iacute; dụ về c&aacute;c b&agrave;i tập v&agrave; đề thi mẫu trong kh&oacute;a học TOEIC 4 kỹ năng:</p>\r\n\r\n<p>B&agrave;i tập Nghe: Học vi&ecirc;n sẽ được luyện nghe qua c&aacute;c b&agrave;i tập nghe, đối thoại, bản tin, c&aacute;c cuộc phỏng vấn, c&aacute;c b&agrave;i diễn thuyết v&agrave; c&aacute;c b&agrave;i đọc giả tưởng. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng lắng nghe v&agrave; hiểu r&otilde; &yacute; nghĩa của c&aacute;c từ, c&acirc;u v&agrave; đoạn văn.&nbsp;</p>\r\n\r\n<p>B&agrave;i tập Đọc: Học vi&ecirc;n sẽ được đọc c&aacute;c b&agrave;i b&aacute;o, đoạn văn, thư từ v&agrave; c&aacute;c t&agrave;i liệu kh&aacute;c li&ecirc;n quan đến kinh doanh, t&agrave;i ch&iacute;nh, kế to&aacute;n v&agrave; quản l&yacute;. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n ph&aacute;t triển khả năng đọc hiểu, t&igrave;m kiếm th&ocirc;ng tin v&agrave; đưa ra nhận x&eacute;t.</p>\r\n\r\n<p>B&agrave;i tập N&oacute;i: Học vi&ecirc;n sẽ được luyện n&oacute;i qua c&aacute;c b&agrave;i tập, đối thoại v&agrave; c&aacute;c b&agrave;i thuyết tr&igrave;nh. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n n&acirc;ng cao khả năng diễn đạt, ph&aacute;t &acirc;m v&agrave; sử dụng ng&ocirc;n ngữ ch&iacute;nh x&aacute;c.</p>\r\n\r\n<p>B&agrave;i tập Viết: Học vi&ecirc;n sẽ được luyện viết qua c&aacute;c b&agrave;i tập, b&agrave;i luận v&agrave; c&aacute;c b&aacute;o c&aacute;o. C&aacute;c b&agrave;i tập n&agrave;y sẽ gi&uacute;p học vi&ecirc;n ph&aacute;t triển khả năng viết đ&uacute;ng ch&iacute;nh tả, sử dụng ngữ ph&aacute;p v&agrave; từ vựng ch&iacute;nh x&aacute;c.</p>\r\n\r\n<p>Đề thi mẫu: C&aacute;c đề thi mẫu được thiết kế để gi&uacute;p học vi&ecirc;n l&agrave;m quen với định dạng, thang điểm v&agrave; kiểu c&acirc;u hỏi của kỳ thi TOEIC. Học vi&ecirc;n c&oacute; thể sử dụng c&aacute;c đề thi mẫu để đ&aacute;nh gi&aacute; khả năng của m&igrave;nh v&agrave; củng cố kiến thức trước khi tham gia kỳ thi thực tế.</p>\r\n', NULL, 2500000, 'uploads/khoahoc10.jpg', NULL),
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
(35, 'IELTS-PREP-01-25', '2025-09-23', '08:30:00', '10:30:00', 'Link Zoom', NULL),
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
(139, 'TOEIC-4S-01-25', '2025-10-15', '08:00:00', '09:30:00', 'Phòng C301', NULL),
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
(262, 'TOEIC-4S-01-25', '2025-09-15', '16:27:00', '16:31:00', 'aaaa', ''),
(264, 'BASIC-01-25', '2025-09-30', '09:11:00', '00:11:00', 'Phòng A101', ''),
(265, 'BASIC-01-25', '2025-09-27', '18:09:00', '21:12:00', 'Phòng A101', ''),
(266, 'BASIC-01-25', '2025-09-19', '16:09:00', '18:09:00', 'Phòng A101', ''),
(269, 'BASIC-01-25', '2025-10-08', '18:37:00', '23:37:00', 'Phòng A101', '');

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
('BASIC-01-25', 32, 'Lớp mất gốc Tối T2-T4-T6', 2, 1, 'dang hoc'),
('BASIC-02-25', 32, 'Lớp mất gốc Sáng T3-T5-T7', 2, 2, 'dang hoc'),
('BEGINNER-01-25', 44, 'Lớp Người mới bắt đầu Sáng T2-T4', 4, 2, 'dang hoc'),
('BEGINNER-02-25', 44, 'Lớp Người mới bắt đầu Tối T3-T5-T7', 4, 3, 'dang hoc'),
('COM-1V1-01-25', 36, 'Lớp Giao tiếp 1-1 (Lịch linh hoạt)', 3, 3, 'dang hoc'),
('COM-BASIC-01-25', 37, 'Lớp Giao tiếp cơ bản Tối T2-T4', 3, 2, 'dang hoc'),
('COM-BASIC-02-25', 37, 'Lớp Giao tiếp cơ bản Tối T3-T5', 6, 2, 'dang hoc'),
('IELTS-0-7-01-25', 42, 'Lớp IELTS 0-7+ Tối T3-T5', 1, 3, 'dang hoc'),
('IELTS-4S-01-25', 43, 'Lớp IELTS Online 4 Kỹ năng Chiều T2-T4', 6, 3, 'dang hoc'),
('IELTS-4S-02-25', 43, 'Lớp IELTS Online 4 Kỹ năng Tối T3-T5', 1, 2, 'dang hoc'),
('IELTS-F-01-25', 39, 'Lớp IELTS Foundation Tối T2-T4', 1, 3, 'dang hoc'),
('IELTS-F-02-25', 39, 'Lớp IELTS Foundation Chiều T3-T5', 6, 3, 'dang hoc'),
('IELTS-PREP-01-25', 40, 'Lớp Luyện thi IELTS Sáng T3-T5-T7', 1, 0, 'dang hoc'),
('IELTS-PREP-02-25', 40, 'Lớp Luyện thi IELTS Cuối tuần (Chiều T7-CN)', 5, 4, 'dang hoc'),
('KIDS-01-25', 35, 'Lớp Thiếu niên Chiều T3-T5', 5, 2, 'dang hoc'),
('KIDS-02-25', 35, 'Lớp Thiếu nhi Cuối tuần (Sáng T7)', 5, 2, 'dang hoc'),
('TOEIC-4S-01-25', 38, 'Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6', 2, 0, 'dang hoc'),
('TOEIC-4S-02-25', 38, 'Lớp TOEIC 4 Kỹ năng Tối T3-T5', 2, 3, 'dang hoc'),
('TOEIC-DE-01-25', 41, 'Lớp Giải đề TOEIC Tối T2-T4-T6', 2, 3, 'dang hoc'),
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
(35, '2025-10-06', 8);

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
(47, 1, 36, NULL, 'Lớp học \"2222\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 20/09/2025', '2025-09-16 04:08:15', 1, 'Thông báo lịch học mới', 'đã đọc'),
(48, 37, 36, NULL, 'Lớp học \"2222\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 20/09/2025', '2025-09-16 04:08:15', 1, 'Thông báo lịch học mới', 'đã đọc'),
(65, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 29/09/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(66, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 29/09/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(68, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 06/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(69, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 06/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(71, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 13/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(72, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 13/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(74, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 20/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(75, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 20/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(77, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 27/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(78, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 27/10/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(80, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 03/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(81, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 03/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(83, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 10/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(84, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 10/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(86, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 17/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(87, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 17/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(89, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 24/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(90, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 24/11/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(92, 1, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 01/12/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(93, 37, 36, NULL, 'Lớp học \"Lớp Giao tiếp 1-1 (Lịch linh hoạt)\" của khóa học \"Khóa học Tiếng Anh giao tiếp Basic 1 kèm 1 GV Việt Nam\" có lịch học mới vào ngày: 01/12/2025', '2025-09-16 17:00:35', 1, 'Thông báo lịch học mới', 'đã đọc'),
(110, 37, 38, NULL, 'Lớp học \"Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6\" của khóa học \" Khóa học TOEIC 4 KỸ NĂNG\" có lịch học mới vào ngày: 15/09/2025', '2025-09-17 16:25:51', 1, 'Thông báo lịch học mới', 'đã đọc'),
(111, 1, 38, NULL, 'Lớp học \"Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6\" của khóa học \" Khóa học TOEIC 4 KỸ NĂNG\" có lịch học mới vào ngày: 15/09/2025', '2025-09-17 16:25:51', 1, 'Thông báo lịch học mới', 'đã đọc'),
(122, 1, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 09/09/2025.', '2025-09-18 15:04:29', 1, 'Thông báo lịch học mới', 'đã đọc'),
(123, 26, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 09/09/2025.', '2025-09-18 15:04:29', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(124, 32, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 09/09/2025.', '2025-09-18 15:04:29', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(125, 27, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 09/09/2025.', '2025-09-18 15:04:29', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(129, 1, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 30/09/2025', '2025-09-18 15:06:14', 1, 'Thông báo lịch học mới', 'đã đọc'),
(130, 26, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 30/09/2025', '2025-09-18 15:06:14', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(131, 32, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 30/09/2025', '2025-09-18 15:06:14', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(132, 27, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 30/09/2025', '2025-09-18 15:06:14', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(136, 1, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 27/09/2025', '2025-09-18 15:08:39', 1, 'Thông báo lịch học mới', 'đã đọc'),
(137, 26, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 27/09/2025', '2025-09-18 15:08:39', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(138, 32, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 27/09/2025', '2025-09-18 15:08:39', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(139, 27, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 27/09/2025', '2025-09-18 15:08:39', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(140, 37, 32, NULL, 'Lớp học \"Lớp mất gốc Tối T2-T4-T6\" của khóa học \"Khóa học tiếng Anh cho người mất gốc\" có lịch học mới vào ngày: 27/09/2025', '2025-09-18 15:08:39', 1, 'Thông báo lịch học mới', 'đã đọc'),
(143, 1, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 19/09/2025.', '2025-09-18 15:09:23', 1, 'Thông báo lịch học mới', 'đã đọc'),
(144, 26, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 19/09/2025.', '2025-09-18 15:09:23', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(145, 32, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 19/09/2025.', '2025-09-18 15:09:23', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(146, 27, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 19/09/2025.', '2025-09-18 15:09:23', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(147, 37, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 19/09/2025.', '2025-09-18 15:09:23', 1, 'Thông báo lịch học mới', 'đã đọc'),
(150, 27, 38, NULL, 'Lớp \"222\" của bạn có lịch học mới vào ngày: 02/09/2025.', '2025-09-18 17:12:31', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(151, 37, 38, 'TOEIC-4S-01-25', 'Lớp \"Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6\" của bạn có lịch học mới vào ngày: 18/10/2025.', '2025-10-02 00:57:38', 1, 'Thông báo lịch học mới', 'chưa đọc'),
(152, 1, 38, 'TOEIC-4S-01-25', 'Lớp \"Lớp TOEIC 4 Kỹ năng Sáng T2-T4-T6\" của bạn có lịch học mới vào ngày: 18/10/2025.', '2025-10-02 00:57:38', 1, 'Thông báo lịch học mới', 'đã đọc'),
(159, 1, 32, 'BASIC-01-25', 'Lớp \"Lớp mất gốc Tối T2-T4-T6\" của bạn có lịch học mới vào ngày: 08/10/2025.', '2025-10-06 18:37:49', 1, 'Thông báo lịch học mới', 'đã đọc');

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
(34, 1, 32, 'BASIC-01-25', 0.00, 0, 16, '2025-10-06 11:55:20');

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
-- Indexes for table `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD PRIMARY KEY (`id_cauhoi`),
  ADD KEY `id_baitest` (`id_baitest`);

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
  MODIFY `id_baitest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `cauhoi`
--
ALTER TABLE `cauhoi`
  MODIFY `id_cauhoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `dangkykhoahoc`
--
ALTER TABLE `dangkykhoahoc`
  MODIFY `id_dangky` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `danhgiakhoahoc`
--
ALTER TABLE `danhgiakhoahoc`
  MODIFY `id_danhgia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dapan`
--
ALTER TABLE `dapan`
  MODIFY `id_dapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1229;

--
-- AUTO_INCREMENT for table `diem_danh`
--
ALTER TABLE `diem_danh`
  MODIFY `id_diemdanh` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diem_so`
--
ALTER TABLE `diem_so`
  MODIFY `id_diem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `giangvien`
--
ALTER TABLE `giangvien`
  MODIFY `id_giangvien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hocvien`
--
ALTER TABLE `hocvien`
  MODIFY `id_hocvien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `hoc_lieu`
--
ALTER TABLE `hoc_lieu`
  MODIFY `id_hoclieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ketquabaitest`
--
ALTER TABLE `ketquabaitest`
  MODIFY `id_ketqua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `id_khoahoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `lichhoc`
--
ALTER TABLE `lichhoc`
  MODIFY `id_lichhoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `lichsu_thanhtoan`
--
ALTER TABLE `lichsu_thanhtoan`
  MODIFY `id_thanhtoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `luot_truy_cap`
--
ALTER TABLE `luot_truy_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id_thongbao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `tien_do_hoc_tap`
--
ALTER TABLE `tien_do_hoc_tap`
  MODIFY `id_tien_do` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
