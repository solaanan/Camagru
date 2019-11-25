-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Nov 25, 2019 at 12:54 AM
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
(17, 50, 13, 'wa tkwity\n', '2019-11-23 23:43:11');

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
(82, 30, 11),
(88, 16, 13),
(89, 21, 13),
(90, 20, 13),
(91, 19, 13),
(92, 43, 13),
(93, 45, 13),
(94, 45, 11),
(103, 42, 14),
(105, 42, 15),
(118, 14, 11),
(128, 42, 11),
(137, 51, 13),
(139, 14, 13),
(141, 42, 13),
(142, 41, 13),
(146, 21, 11);

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
(8, 11, '/camagru/assets/images/posts/IMG_POST_5dceef1bc3f91.png', 'camagru en poche!', '2019-11-15 18:31:55'),
(10, 11, '/camagru/assets/images/posts/IMG_POST_5dcf2092605d5.png', 'nmilou ou manti7oush\n#maroc #zahia #3eshran #khribga #greengosst', '2019-11-15 22:02:58'),
(14, 13, '/camagru/assets/images/posts/IMG_POST_5dd06a2289c7f.png', 'ljounoud dirou shi j\'aime please! up up up', '2019-11-16 21:29:06'),
(19, 11, '/camagru/assets/images/posts/IMG_POST_5dd3987350f38.png', 'check out my spotify playlist.', '2019-11-19 07:23:31'),
(20, 11, '/camagru/assets/images/posts/IMG_POST_5dd398ea694c7.png', 'yup', '2019-11-19 07:25:30'),
(21, 11, '/camagru/assets/images/posts/IMG_POST_5dd399081bdae.png', 'big picture', '2019-11-19 07:26:00'),
(41, 13, '/camagru/assets/images/posts/IMG_POST_5dd611bd80b49.png', 'crown', '2019-11-21 04:25:33'),
(42, 14, '/camagru/assets/images/posts/IMG_POST_5dd7c601a1756.png', 'ì„±ëª¨ë³‘ì› ìž¥ë¡€ì‹ìž¥ì—ì„œ ë³¼ë•Œ ì–¼êµ´ë“¤ê³ ì™€ë¼.ë‘˜ë‹¤í•´ì•¼ì§€.ë„ˆë„¤ ì•„ë¹ ì§‘ ìš©ì¸ì´ë¼ê³  í•˜ë”ë¼ ê·¸ëŸ¼ ì´ì§‘ì €ì§‘ì€ ì´ëª¨ê±°ë‹¤.!\"\"\"\"ë’·ì§‘ì€ í• ë¨¸ë‹ˆ.ë˜ë‹¤ë¥¸ ê°€ì¡±ë“¤ì´ ì•Œê³ ìžˆë‹¤.ì¡±ë³´ë¡œ ë†€ìž”ë‹ˆ!íŒì´.', '2019-11-22 11:26:57'),
(50, 15, '/camagru/assets/images/posts/IMG_POST_5dd855cb7019f.png', 'Wydaaad', '2019-11-22 21:40:27'),
(51, 13, '/camagru/assets/images/posts/IMG_POST_5dd9c39675b01.png', 'tbon', '2019-11-23 23:41:10');

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
(11, 'slaanani', 'nbj9x2albk@lalala.fun', 'f0d1fa99e699226713c727d370090e769d3fd21f55cc4ae4b480068fe94bad2a58c037f4f3dfd0b721a87264a30b483252b123f11d6fa8102f4c608706e0450f', '2019-11-05', '/camagru/assets/images/profilePics/IMG_PP_slaanani_5dd538c106b66.png', ''),
(13, 'yoouali', 'eldj2lsey9@smart-email.me', '4a6ddbeae96ebf866963b379434fbcb8b27563ae6dfe12b9bacfe3f8162e74f4a02297a2061f85afa508f940a1daac76b7bfeb87ee684fdde796b4b1cf61e2c5', '2019-11-10', '/camagru/assets/images/profilePics/IMG_PP_yoouali_5dd612f41330d.png', ''),
(14, 'EdgeLord', 'mderri@student.1337.ma', '58d30863d4a57f6c183333349c23ad678ad6503f65e9d19b5c3ecc51db7a36cb7650c460fd293e7feaa33d787f9d3c34b2c900b2de2f81251f245a9e1223e6f1', '2019-11-22', '/camagru/assets/images/profilePics/IMG_PP_EdgeLord_5dd7c4539e8f3.png', ''),
(15, 'hwayKolchi', 'jayatob299@mytmail.net', '9d4d26dec97ad2a3111359c70f28c09b0db18faecf6bba8fcbed76157b01c4093468a78e058877e195406882d64c4db3624062d991e94e5f7a0ea41c8a537975', '2019-11-22', '/camagru/assets/images/profilePics/IMG_PP_hwayKolchi_5dd8546fd7032.png', '');

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
