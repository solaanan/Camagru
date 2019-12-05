-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Dec 05, 2019 at 07:48 AM
-- Server version: 5.7.28
-- PHP Version: 7.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_body` varchar(500) NOT NULL,
  `dateOfCom` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment_body`, `dateOfCom`) VALUES
(1, 20, 11, 'test', '2019-11-20 13:01:59'),
(2, 20, 13, 'zahia', '2019-11-20 13:03:34'),
(7, 41, 13, 'damn boy', '2019-11-21 04:25:55'),
(8, 20, 13, 'hey\n', '2019-11-21 04:26:37'),
(10, 8, 13, 'bseha hwayj l3id\n', '2019-11-21 04:27:50'),
(11, 21, 13, 'beautiful', '2019-11-21 04:28:35'),
(12, 42, 13, 'sonic the tb\n', '2019-11-21 04:29:06'),
(13, 45, 11, 'Hh', '2019-11-21 04:47:56'),
(14, 41, 11, 'fractol dzebi', '2019-11-22 10:53:11'),
(15, 41, 15, 'hadchi 3andk ki xi teb', '2019-11-22 21:33:35'),
(16, 50, 13, 'Ø¹Ù†Ø¯Ù…Ø§ ÙŠØµØ¨Ø­ Ø§Ù„Ø­ÙˆØ§ÙŠ Ù…Ø­ÙˆÙŠ\n', '2019-11-23 23:42:57'),
(17, 50, 13, 'wa tkwity\n', '2019-11-23 23:43:11'),
(18, 10, 11, 'fgfgfg', '2019-11-25 20:13:58'),
(19, 51, 15, 'dwzo liya ngado\n', '2019-11-25 22:42:38'),
(20, 50, 15, 'Sir Tahwa', '2019-11-25 22:44:11'),
(21, 55, 16, 'ras l9elwa', '2019-11-25 23:06:31'),
(22, 51, 16, 'mok', '2019-11-25 23:07:02'),
(23, 58, 11, 'ayyyy', '2019-11-25 23:30:58'),
(24, 58, 17, 'kanbghik bb\n', '2019-11-25 23:37:19'),
(25, 42, 17, 'passi privi ki 3jboni chnawa', '2019-11-25 23:37:40'),
(26, 51, 17, 'ouali wjah tabon doz tanta nhwik', '2019-11-25 23:39:26'),
(27, 58, 13, 'tsatahl jim\n', '2019-11-25 23:49:40'),
(28, 51, 13, 'hamda\n', '2019-11-25 23:50:07'),
(29, 83, 17, 'haw jibo le9hab yaw baghi nhwi 9am zbibi 9am', '2019-11-27 22:59:46'),
(30, 65, 17, 'ahhhhhhhhhh', '2019-11-27 23:01:02'),
(31, 93, 18, 'watchi ziiiin\n', '2019-11-29 21:42:52'),
(34, 93, 11, 'ddd\ndddd\nddd', '2019-11-29 21:52:04'),
(37, 101, 15, 'a frayma', '2019-12-02 21:23:15'),
(38, 102, 11, '&lt;script&gt;alert(\'hehe\');&lt;/script&gt;', '2019-12-02 23:52:00'),
(39, 104, 13, 'hh', '2019-12-03 01:10:32'),
(40, 95, 13, '&lt;script&gt;alert(\'hehe\');&lt;/script&gt;', '2019-12-03 01:12:23'),
(41, 82, 11, 'aaa', '2019-12-03 21:46:49'),
(42, 14, 11, 'Hehe', '2019-12-03 21:49:54'),
(46, 105, 19, '1', '2019-12-04 22:20:46'),
(47, 105, 19, '2', '2019-12-04 22:20:49'),
(49, 104, 19, 'http://10.12.2.2/camagru/profile?username=yoouali', '2019-12-04 22:24:33'),
(57, 102, 19, 'ilio', '2019-12-04 22:45:30'),
(58, 108, 15, '&lt;script&gt;alert(\'ha2\');&lt;/script&gt;', '2019-12-05 05:34:23'),
(60, 108, 11, 'tnaker', '2019-12-05 05:51:08'),
(61, 108, 15, '7410', '2019-12-05 05:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `id_post`, `id_user`) VALUES
(88, 16, 13),
(89, 21, 13),
(90, 20, 13),
(91, 19, 13),
(92, 43, 13),
(93, 45, 13),
(103, 42, 14),
(137, 51, 13),
(139, 14, 13),
(141, 42, 13),
(142, 41, 13),
(176, 50, 15),
(177, 21, 16),
(179, 56, 16),
(180, 41, 16),
(181, 58, 16),
(185, 59, 17),
(186, 58, 17),
(187, 61, 16),
(188, 59, 16),
(189, 57, 17),
(190, 56, 17),
(191, 42, 17),
(192, 57, 16),
(193, 51, 17),
(195, 58, 13),
(196, 56, 13),
(198, 83, 17),
(199, 82, 17),
(200, 64, 17),
(201, 83, 16),
(202, 82, 16),
(203, 79, 16),
(204, 78, 16),
(205, 65, 17),
(206, 73, 16),
(207, 72, 16),
(208, 71, 16),
(209, 70, 16),
(210, 69, 16),
(211, 67, 16),
(212, 80, 16),
(213, 81, 17),
(214, 77, 17),
(220, 68, 16),
(257, 83, 11),
(259, 81, 11),
(260, 80, 11),
(261, 79, 11),
(262, 78, 11),
(276, 83, 18),
(277, 81, 18),
(278, 79, 18),
(279, 93, 16),
(280, 92, 16),
(281, 91, 16),
(282, 97, 18),
(283, 92, 18),
(289, 97, 11),
(296, 93, 11),
(305, 104, 13),
(306, 82, 11),
(307, 14, 11),
(326, 104, 19),
(327, 113, 19),
(329, 108, 19),
(331, 108, 15),
(334, 109, 11),
(335, 64, 15),
(336, 21, 15),
(337, 109, 15),
(338, 102, 15),
(342, 101, 15);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `publication` varchar(1000) NOT NULL,
  `dateOfPub` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `picture`, `publication`, `dateOfPub`) VALUES
(14, 13, '/camagru/assets/images/posts/IMG_POST_5dd06a2289c7f.png', 'ljounoud dirou shi j\'aime please! up up up', '2019-11-16 21:29:06'),
(20, 11, '/camagru/assets/images/posts/IMG_POST_5dd398ea694c7.png', 'yup', '2019-11-19 07:25:30'),
(21, 11, '/camagru/assets/images/posts/IMG_POST_5dd399081bdae.png', 'big picture', '2019-11-19 07:26:00'),
(41, 13, '/camagru/assets/images/posts/IMG_POST_5dd611bd80b49.png', 'crown', '2019-11-21 04:25:33'),
(42, 14, '/camagru/assets/images/posts/IMG_POST_5dd7c601a1756.png', 'ì„±ëª¨ë³‘ì› ìž¥ë¡€ì‹ìž¥ì—ì„œ ë³¼ë•Œ ì–¼êµ´ë“¤ê³ ì™€ë¼.ë‘˜ë‹¤í•´ì•¼ì§€.ë„ˆë„¤ ì•„ë¹ ì§‘ ìš©ì¸ì´ë¼ê³  í•˜ë”ë¼ ê·¸ëŸ¼ ì´ì§‘ì €ì§‘ì€ ì´ëª¨ê±°ë‹¤.!\"\"\"\"ë’·ì§‘ì€ í• ë¨¸ë‹ˆ.ë˜ë‹¤ë¥¸ ê°€ì¡±ë“¤ì´ ì•Œê³ ìžˆë‹¤.ì¡±ë³´ë¡œ ë†€ìž”ë‹ˆ!íŒì´.', '2019-11-22 11:26:57'),
(51, 13, '/camagru/assets/images/posts/IMG_POST_5dd9c39675b01.png', 'tbon', '2019-11-23 23:41:10'),
(56, 16, '/camagru/assets/images/posts/IMG_POST_5ddc5ed46243e.png', '', '2019-11-25 23:08:04'),
(57, 16, '/camagru/assets/images/posts/IMG_POST_5ddc5ee36514a.png', 'a7777', '2019-11-25 23:08:19'),
(58, 16, '/camagru/assets/images/posts/IMG_POST_5ddc628d69c08.png', '', '2019-11-25 23:23:57'),
(64, 11, '/camagru/assets/images/posts/IMG_POST_5ddc99f3c6d06.png', 'Hollyyy', '2019-11-26 03:20:19'),
(65, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9a064878b.png', 'Hollyyy mollyy', '2019-11-26 03:20:38'),
(66, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9ad88ab21.png', 'Mmmmmm', '2019-11-26 03:24:08'),
(67, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9aea04877.png', '', '2019-11-26 03:24:26'),
(68, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9aefde638.png', '', '2019-11-26 03:24:31'),
(69, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9af8a3a12.png', '', '2019-11-26 03:24:40'),
(70, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b03dd40b.png', '', '2019-11-26 03:24:51'),
(71, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b0df3a69.png', '', '2019-11-26 03:25:02'),
(72, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b150cbe4.png', '', '2019-11-26 03:25:09'),
(73, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b20d407e.png', '', '2019-11-26 03:25:20'),
(74, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b26c6edf.png', '', '2019-11-26 03:25:26'),
(76, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b3396547.png', '', '2019-11-26 03:25:39'),
(77, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b3bd255b.png', '', '2019-11-26 03:25:47'),
(78, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b6e3cec8.png', '', '2019-11-26 03:26:38'),
(79, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b76aad39.png', '', '2019-11-26 03:26:46'),
(80, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b7f60418.png', '', '2019-11-26 03:26:55'),
(81, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b89b2a5f.png', '', '2019-11-26 03:27:05'),
(82, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9b9e2b122.png', '', '2019-11-26 03:27:26'),
(83, 11, '/camagru/assets/images/posts/IMG_POST_5ddc9bab80982.png', '', '2019-11-26 03:27:39'),
(89, 16, '/camagru/assets/images/posts/IMG_POST_5de1751e46308.png', '', '2019-11-29 19:44:30'),
(90, 16, '/camagru/assets/images/posts/IMG_POST_5de1752416e4d.png', '', '2019-11-29 19:44:36'),
(91, 16, '/camagru/assets/images/posts/IMG_POST_5de1752dcfd29.png', '', '2019-11-29 19:44:45'),
(92, 16, '/camagru/assets/images/posts/IMG_POST_5de17539aaeee.png', '', '2019-11-29 19:44:57'),
(93, 16, '/camagru/assets/images/posts/IMG_POST_5de1753f93645.png', '', '2019-11-29 19:45:03'),
(101, 15, '/camagru/assets/images/posts/IMG_POST_5de58032a3ef0.png', '', '2019-12-02 21:20:50'),
(104, 13, '/camagru/assets/images/posts/IMG_POST_5de5b6015b845.png', '', '2019-12-03 01:10:25'),
(110, 15, '/camagru/assets/images/posts/IMG_POST_5de8af4479951.png', 'ops', '2019-12-05 07:18:28'),
(111, 15, '/camagru/assets/images/posts/IMG_POST_5de8af636790b.png', '', '2019-12-05 07:18:59'),
(121, 11, '/camagru/assets/images/posts/IMG_POST_5de8b39abdcd1.png', '', '2019-12-05 07:36:58'),
(122, 15, '/camagru/assets/images/posts/IMG_POST_5de8b412e3049.png', '', '2019-12-05 07:38:59'),
(123, 15, '/camagru/assets/images/posts/IMG_POST_5de8b417dd357.png', '', '2019-12-05 07:39:04'),
(124, 15, '/camagru/assets/images/posts/IMG_POST_5de8b42200375.png', '', '2019-12-05 07:39:14'),
(125, 15, '/camagru/assets/images/posts/IMG_POST_5de8b43b4f304.png', '', '2019-12-05 07:39:39'),
(126, 15, '/camagru/assets/images/posts/IMG_POST_5de8b44a85541.png', '', '2019-12-05 07:39:54'),
(130, 11, '/camagru/assets/images/posts/IMG_POST_5de8b5646df6d.png', '', '2019-12-05 07:44:36'),
(132, 11, '/camagru/assets/images/posts/IMG_POST_5de8b5b500235.png', '', '2019-12-05 07:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `passwd` varchar(128) NOT NULL,
  `signUpDate` date NOT NULL,
  `profilePic` varchar(500) NOT NULL,
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `signUpDate`, `profilePic`, `token`) VALUES
(11, 'slaanani', 'slaanani@inbox-me.top', 'a85093ac65dbebb1be7a620b5e696c748d8593b6ffd3563bee88109f2a91ba4f6b2eee7459451721f1576be893e45e279557207a94134b8663fa6ce72cc43309', '2019-11-05', '/camagru/assets/images/profilePics/IMG_PP_slaanani_5de8b1e58dd0c.png', ''),
(13, 'yoouali', 'yoouali@student.1337.ma', '4a6ddbeae96ebf866963b379434fbcb8b27563ae6dfe12b9bacfe3f8162e74f4a02297a2061f85afa508f940a1daac76b7bfeb87ee684fdde796b4b1cf61e2c5', '2019-11-10', '/camagru/assets/images/profilePics/IMG_PP_yoouali_5dd612f41330d.png', ''),
(14, 'EdgeLord', 'mderri@student.1337.ma', '6e95319fd838b812096cd4402e1b8a4664fabe2c55b63f5d52bf98f04801d34d0f6d740950d65f26e49ec711610aebf31899787426816ba21ddd863e7416852b', '2019-11-22', '/camagru/assets/images/profilePics/IMG_PP_EdgeLord_5dd7c4539e8f3.png', ''),
(15, 'hwayKolchi', 'rkeqokz89m@smart-email.me', '16ef440ad1a59e39404b24f82edeaebf1d46d2ae9caf2441756636520ea752348738abe35b500bc56ccf3103580022782fa3b3c92989cca8c72ddf778b30b020', '2019-11-22', '/camagru/assets/images/profilePics/IMG_PP_hwayKolchi_5de8977000494.png', ''),
(16, 'HwayHwayKolchi', 'sopeja3781@4xmail.net', '0856e52ffa2c8575e385ba5a047d30230e7ab74f92ed7712cb5b53f11b866e3a1d9994128fa0704379896294db204f29aad62181ff381f26905bb5d8a4582b7e', '2019-11-25', '/camagru/assets/images/profilePics/IMG_PP_Ysrbolles_5ddc60780e022.png', ''),
(17, '7wayLe9hab', 'lirkirelma@enayu.com', '9027a9e11947a795621efdfe46c65875c9d553660d33ae5e2f12310cce035bd0a8a3b81f6192d72a737a3a081d6051c71d6e7077702e06d448d7080ceca92ac8', '2019-11-25', '/camagru/assets/images/profilePics/IMG_PP_7wayLe9hab_5ddc6498a7a02.png', ''),
(18, 'sizebu', 'achrafeddaqqaq@gmail.com', '5e461c49db214937582af6d213a5ccbaf9671e01fba7d7c8607b2f3c14e925e0b32416dd1ff9ad5a83c8cf88cc9f0d573c3d5ad535eb7886489700a0f6537b3b', '2019-11-29', '/camagru/assets/images/profilePics/default.png', ''),
(19, '0000000', 'erradi20erradi@gmail.com', '11976a680ab2d8d9435bb37211ed13a194b00af00e648a054ed9c5bcaab51f47faca9f6b8e26523ec685a8484cd0c73e5482feed2effa5f0a6b5930d58b9747c', '2019-12-04', '/camagru/assets/images/profilePics/IMG_PP_0000000_5de8379e3631e.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
