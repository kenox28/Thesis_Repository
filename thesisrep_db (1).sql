-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 03:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesisrep_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `fname`, `lname`, `email`, `pass`, `created_at`, `updated_at`) VALUES
(6, 'ADM001', 'Default', 'Admin', 'admin@gmail.com', 'a66abb5684c45962d887564f08346e8d', '2025-05-27 19:06:49', '2025-05-27 19:06:49'),
(7, 'ADM002', 'Default', 'Admin', 'iquenxzx@gmail.com', 'b00276f305d1fd1983d14d6f9e9adc65', '2025-05-27 19:06:49', '2025-05-27 19:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `publicrepo`
--

CREATE TABLE `publicrepo` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `abstract` varchar(255) DEFAULT NULL,
  `ThesisFile` varchar(255) DEFAULT NULL,
  `reviewer_id` varchar(255) DEFAULT NULL,
  `Privacy` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publicrepo`
--

INSERT INTO `publicrepo` (`id`, `student_id`, `fname`, `lname`, `title`, `abstract`, `ThesisFile`, `reviewer_id`, `Privacy`, `created_at`, `updated`) VALUES
(1, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', 'heyow_1638482254_1747669270.pdf', '536824103', 'public', '2025-05-20 19:48:54', '2025-05-26 13:26:12'),
(2, '1386862220', 'iquen', 'marba', 'iquenmarba', 'lkfhs;ladfkhjdsklfh;slkfhjhkl;sdhfsdfhsdflkhsd;laf', '6835e0809dd2f9.35926609.pdf', '536824103', 'public', '2025-05-27 23:57:46', '2025-05-28 00:05:51'),
(3, '1386862220', 'iquen', 'marba', 'AI ni russel', 'abstract intro and wtf ', '6837bf2a825874.18443647.pdf', '1426418352', 'private', '2025-05-29 10:00:50', '2025-05-29 23:09:53'),
(4, '1386862220', 'iquen', 'marba', 'thesis ni cholo', 'abstract intro and wtf ', '6837bf6889f0a4.77250501.pdf', '1426418352', 'public', '2025-05-29 12:15:59', '2025-05-29 12:15:59'),
(5, '1386862220', 'iquen', 'marba', 'Thesis new title ', 'blasblablahdfjlkhsdlkfjh', 'Thesis_new_title__1386862220_1748583530.pdf', '1426418352', 'public', '2025-05-30 13:40:45', '2025-05-30 13:42:06'),
(6, '1386862220', 'iquen', 'marba', 'no', 'alsdalsd', '683960a3b69f98.35555697.pdf', '1426418352', 'private', '2025-05-30 15:44:26', '2025-05-30 15:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `repotable`
--

CREATE TABLE `repotable` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `abstract` varchar(50) DEFAULT NULL,
  `ThesisFile` varchar(50) DEFAULT NULL,
  `reviewer_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repotable`
--

INSERT INTO `repotable` (`id`, `student_id`, `fname`, `lname`, `title`, `abstract`, `ThesisFile`, `reviewer_id`, `status`, `created_at`, `updated`) VALUES
(33, '1638482254', 'ken', 'fsdfasdf', 'heloo', 'world', '6824462013d0a0.74249791.pdf', '536824103', 'Revised', '2025-05-14 15:28:32', '2025-05-26 01:44:26'),
(34, '1638482254', 'ken', 'fsdfasdf', 'hello', 'dasdasdasdasfadsfa', '68244e6c9a83b7.81309303.pdf', '536824103', 'rejected', '2025-05-14 16:03:56', '2025-05-26 02:26:01'),
(35, '1638482254', 'ken', 'fsdfasdf', 'hello', 'dasdasdasdasfadsfa', '68244e7171ef43.57691958.pdf', '536824103', 'approved', '2025-05-14 16:04:01', '2025-05-16 01:54:40'),
(36, '1638482254', 'ken', 'fsdfasdf', 'hello', 'dasdasdasdasfadsfa', '68244e7504b3b9.24244572.pdf', '536824103', 'approved', '2025-05-14 16:04:05', '2025-05-16 01:54:38'),
(37, '1638482254', 'ken', 'fsdfasdf', 'iquen', 'dofhklasdhgfoadshf;lkhasd;lkfhadsf', 'iquen_1638482254_1747674486.pdf', '342162454', 'Revised', '2025-05-15 21:25:31', '2025-05-20 01:08:06'),
(38, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262ba6aaca36.36749368.pdf', '536824103', 'Pending', '2025-05-16 02:00:06', '2025-05-16 02:00:06'),
(39, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262babb96ac9.84085696.pdf', '536824103', 'Pending', '2025-05-16 02:00:11', '2025-05-16 02:00:11'),
(40, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262baeb22339.76998318.pdf', '536824103', 'Pending', '2025-05-16 02:00:14', '2025-05-16 02:00:14'),
(41, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb05441a3.47039644.pdf', '536824103', 'Pending', '2025-05-16 02:00:16', '2025-05-16 02:00:16'),
(42, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb3af9c34.43393921.pdf', '536824103', 'rejected', '2025-05-16 02:00:19', '2025-05-16 02:28:22'),
(43, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb655c576.74452338.pdf', '536824103', 'rejected', '2025-05-16 02:00:22', '2025-05-16 02:28:17'),
(44, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb9f26453.65024547.pdf', '536824103', 'rejected', '2025-05-16 02:00:25', '2025-05-16 02:28:10'),
(45, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bbce2c623.75329792.pdf', '536824103', 'rejected', '2025-05-16 02:00:28', '2025-05-16 02:27:12'),
(46, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bc0db48e8.26307790.pdf', '536824103', 'approved', '2025-05-16 02:00:32', '2025-05-20 19:19:22'),
(47, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', 'heyow_1638482254_1747669270.pdf', '536824103', 'approved', '2025-05-16 02:23:57', '2025-05-20 19:31:52'),
(48, '1638482254', 'ken', 'fsdfasdf', 'fdsfsdfsdf', 'sdfsdfsdfsdfsdfsdfsd', '683367f140f4d4.96339432.pdf', '536824103', 'Pending', '2025-05-26 02:56:49', '2025-05-26 02:56:49'),
(50, '1386862220', 'iquen', 'marba', 'iquenmarba', 'lkfhs;ladfkhjdsklfh;slkfhjhkl;sdhfsdfhsdflkhsd;laf', '6835e0809dd2f9.35926609.pdf', '536824103', 'approved', '2025-05-27 23:55:44', '2025-05-28 00:03:58'),
(51, '1386862220', 'iquen', 'marba', 'title 1', 'absdaksdh;alksaljf', '6835fb90dfd6e8.21187764.pdf', '536824103', 'Pending', '2025-05-28 01:51:12', '2025-05-28 01:51:12'),
(52, '1386862220', 'iquen', 'marba', 'title 2 ', 'kapoya na oy \r\n', '6835fbcd8f9102.92834776.pdf', '', 'Pending', '2025-05-28 01:52:13', '2025-05-28 01:52:13'),
(53, '1386862220', 'iquen', 'marba', 'title 3', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc1254fd53.96568440.pdf', '536824103', 'Pending', '2025-05-28 01:53:22', '2025-05-28 01:53:22'),
(54, '1386862220', 'iquen', 'marba', 'title 4', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc16d78b52.73316516.pdf', '536824103', 'Pending', '2025-05-28 01:53:26', '2025-05-28 01:53:26'),
(55, '1386862220', 'iquen', 'marba', 'title 5', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc1b2b87a2.57965252.pdf', '536824103', 'Pending', '2025-05-28 01:53:31', '2025-05-28 01:53:31'),
(56, '1386862220', 'iquen', 'marba', 'title 6', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc1f661cd1.84056597.pdf', '536824103', 'Pending', '2025-05-28 01:53:35', '2025-05-28 01:53:35'),
(57, '1386862220', 'iquen', 'marba', 'title 7', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc231763a5.97359460.pdf', '536824103', 'Pending', '2025-05-28 01:53:39', '2025-05-28 01:53:39'),
(58, '1386862220', 'iquen', 'marba', 'title 8', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc27144442.86765285.pdf', '536824103', 'Pending', '2025-05-28 01:53:43', '2025-05-28 01:53:43'),
(59, '1386862220', 'iquen', 'marba', 'title 9', 'shesh ka kapoy ba AHAHAHAHAHA', '6835fc2ad75431.79916195.pdf', '536824103', 'Pending', '2025-05-28 01:53:46', '2025-05-28 01:53:46'),
(60, '1386862220', 'iquen', 'marba', 'assistant jabis', 'abstract intro and wtf ', '6837bea3249c68.48419726.pdf', '1426418352', 'rejected', '2025-05-29 09:55:47', '2025-05-29 12:03:55'),
(61, '1386862220', 'iquen', 'marba', 'AI ni russel', 'abstract intro and wtf ', '6837bf2a825874.18443647.pdf', '1426418352', 'approved', '2025-05-29 09:58:02', '2025-05-29 10:00:50'),
(62, '1386862220', 'iquen', 'marba', 'thesis ni roxanne', 'abstract intro and wtf ', '6837bf3d2d79d7.57882275.pdf', '1426418352', 'rejected', '2025-05-29 09:58:21', '2025-05-29 12:17:45'),
(63, '1386862220', 'iquen', 'marba', 'thesis ni kathy', 'abstract intro and wtf ', 'thesis_ni_kathy_1386862220_1748590843.pdf', '1426418352', 'Revised', '2025-05-29 09:58:48', '2025-05-30 15:43:11'),
(64, '1386862220', 'iquen', 'marba', 'thesis ni cholo', 'abstract intro and wtf ', '6837bf6889f0a4.77250501.pdf', '1426418352', 'approved', '2025-05-29 09:59:04', '2025-05-29 12:15:59'),
(65, '1386862220', 'iquen', 'marba', 'Thesis new title ', 'blasblablahdfjlkhsdlkfjh', 'Thesis_new_title__1386862220_1748583530.pdf', '1426418352', 'approved', '2025-05-29 14:06:50', '2025-05-30 13:40:45'),
(66, '1386862220', 'iquen', 'marba', 'test the swall alert', 'test', 'test_the_swall_alert_1386862220_1748584616.pdf', '1426418352', 'Pending', '2025-05-29 14:09:35', '2025-05-30 13:56:56'),
(67, '1386862220', 'iquen', 'marba', 'test debug', 'debug abstract', '6837fa660f3775.10502936.pdf', '1426418352', 'Pending', '2025-05-29 14:10:46', '2025-05-29 14:10:46'),
(68, '1386862220', 'iquen', 'marba', 'test', 'test again', '6837fa9c1db284.92688690.pdf', '1426418352', 'Pending', '2025-05-29 14:11:40', '2025-05-29 14:11:40'),
(69, '1386862220', 'iquen', 'marba', 'Thesis ni von', 'gwapo', '68389afb70fc81.90650388.pdf', '1426418352', 'Pending', '2025-05-30 01:35:55', '2025-05-30 01:35:55'),
(70, '1386862220', 'iquen', 'marba', 'repository for all', 'shit this', '68393e70782691.18610457.pdf', '1426418352', 'Pending', '2025-05-30 13:13:20', '2025-05-30 13:13:20'),
(71, '1386862220', 'iquen', 'marba', 'no', 'alsdalsd', '683960a3b69f98.35555697.pdf', '1426418352', 'approved', '2025-05-30 15:39:15', '2025-05-30 15:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `id` int(11) NOT NULL,
  `reviewer_id` varchar(255) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `profileImg` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `bdate` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Approve` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`id`, `reviewer_id`, `fname`, `lname`, `email`, `pass`, `profileImg`, `gender`, `bdate`, `created_at`, `updated`, `Approve`) VALUES
(1, '1732791361', 'iquen', 'marba', 'Iquen@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', '2025-05-06 21:50:19', '2025-05-29 14:38:00', 1),
(3, '1356694778', 'reviewer@gmail.com', 'reviewer', 'reviewer@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '', '', '', '2025-05-06 22:57:25', '2025-05-29 14:38:13', 1),
(4, '536824103', 'ben', 'laguna', 'marvin@gmail.com', '24e8c6cf22786682415147959708435b', 'noprofile.png', '', '', '2025-05-11 18:26:35', '2025-05-29 14:38:16', 1),
(7, '1426418352', 'iquen', 'marba', 'iquen.marba@evsu.edu.ph', 'b0ae8ca3692e32086cb546f732f17481', 'noprofile.png', 'Male', '2025-05-15', '2025-05-28 03:17:35', '2025-05-29 14:38:19', 1),
(8, '132957139', 'kaye', 'neuvo', 'lorencapuyan@gmail.com', 'd9bbb0d9342f93c1019e42ab5ecf0e8f', 'noprofile.png', 'Female', '2025-05-15', '2025-05-30 15:36:49', '2025-05-30 15:55:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `revise_table`
--

CREATE TABLE `revise_table` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `abstract` varchar(50) DEFAULT NULL,
  `ThesisFile` varchar(50) DEFAULT NULL,
  `reviewer_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revise_table`
--

INSERT INTO `revise_table` (`id`, `student_id`, `fname`, `lname`, `title`, `abstract`, `ThesisFile`, `reviewer_id`, `status`, `created_at`, `updated`) VALUES
(1, '536576771', 'iquen', 'marba', 'iquen', 'dasdasdsad', '681cba70c2f801.15661698.pdf', '1356694778', 'Revised', '2025-05-08 22:06:40', '2025-05-08 22:06:40'),
(2, '536576771', 'iquen', 'marba', 'iquen', 'dasdasdsad', '681cc0c1edcc91.06597394.pdf', '1356694778', 'Revised', '2025-05-08 22:33:37', '2025-05-08 22:33:37'),
(3, '1423659693', 'iquen', 'marba', 'kenox', 'dskhjflk;asdhfl;kjhasdhfjklsadhflkjasdhfkljhasdlkj', '681cd0dd417811.49525203.pdf', '1356694778', 'Revised', '2025-05-08 23:42:21', '2025-05-08 23:42:21'),
(4, '536576771', 'iquen', 'marba', 'jabis', 'shesh', '681cef20bfba07.01026877.pdf', '1356694778', 'Revised', '2025-05-09 01:51:28', '2025-05-09 01:51:28'),
(5, '536576771', 'iquen', 'marba', 'software engineerting', 'gwapooo', '681cf377f40420.42727229.pdf', '1356694778', 'Revised', '2025-05-09 02:10:00', '2025-05-09 02:10:00'),
(6, '1386862220', 'iquen', 'marba', 'title 4', 'bksfjklsdjfl;kasjdf;l', '68207d26a07ab5.80674540.pdf', '536824103', 'Revised', '2025-05-11 18:34:14', '2025-05-11 18:34:14'),
(7, '1386862220', 'iquen', 'marba', 'title 4', 'bksfjklsdjfl;kasjdf;l', '68207d83d13cf2.35971913.pdf', '536824103', 'Revised', '2025-05-11 18:35:47', '2025-05-11 18:35:47'),
(8, '1386862220', 'iquen', 'marba', 'title 4', 'bksfjklsdjfl;kasjdf;l', '68207ea05ff121.60675512.pdf', '536824103', 'Revised', '2025-05-11 18:40:32', '2025-05-11 18:40:32'),
(9, '1386862220', 'iquen', 'marba', 'title 4', 'bksfjklsdjfl;kasjdf;l', '682081612395c7.12518431.pdf', '536824103', 'Revised', '2025-05-11 18:52:17', '2025-05-11 18:52:17'),
(10, '1386862220', 'iquen', 'marba', 'title 4', 'bksfjklsdjfl;kasjdf;l', '682083a7bbf3f8.09436076.pdf', '536824103', 'Revised', '2025-05-11 19:01:59', '2025-05-11 19:01:59'),
(11, '1386862220', 'iquen', 'marba', 'title 4', 'bksfjklsdjfl;kasjdf;l', '68208b8d26ee65.28763880.pdf', '536824103', 'Revised', '2025-05-11 19:35:41', '2025-05-11 19:35:41'),
(12, '1386862220', 'iquen', 'marba', 'gwapo', 'iquen', '68209732c01322.28764202.pdf', '536824103', 'Revised', '2025-05-11 20:25:22', '2025-05-11 20:25:22'),
(13, '421004543', 'ken', 'men', 'iquen', 'gikapoy nako sheyt', '6821e426ab3c69.97900922.pdf', '536824103', 'Revised', '2025-05-12 20:05:58', '2025-05-12 20:05:58'),
(14, '421004543', 'ken', 'men', '2', 'qweqweqweqwe', '6821f05b9ecb06.71567109.pdf', '536824103', 'Revised', '2025-05-12 20:58:03', '2025-05-12 20:58:03'),
(15, '1638482254', 'ken', 'fsdfasdf', 'heloo', 'world', '682452600dafa3.97907780.pdf', '536824103', 'Revised', '2025-05-14 16:20:48', '2025-05-14 16:20:48'),
(16, '1638482254', 'ken', 'fsdfasdf', 'heloo', 'world', '68246ac19ba9d2.44128498.pdf', '536824103', 'Revised', '2025-05-14 18:04:49', '2025-05-14 18:04:49'),
(17, '1638482254', 'ken', 'fsdfasdf', 'heloo', 'world', '68246ceca05d84.61166479.pdf', '536824103', 'Revised', '2025-05-14 18:14:04', '2025-05-14 18:14:04'),
(18, '1638482254', 'ken', 'fsdfasdf', 'heloo', 'world', '6824799f3d8bd2.86420473.pdf', '536824103', 'Revised', '2025-05-14 19:08:15', '2025-05-14 19:08:15'),
(19, '1638482254', 'ken', 'fsdfasdf', 'iquen', 'dofhklasdhgfoadshf;lkhasd;lkfhadsf', '6825eb88eeeb78.82389821.pdf', '342162454', 'Revised', '2025-05-15 21:26:32', '2025-05-15 21:26:32'),
(20, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', '6826398082c518.96590509.pdf', '536824103', 'Revised', '2025-05-16 02:59:12', '2025-05-16 02:59:12'),
(21, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', '6826399981fe86.09721312.pdf', '536824103', 'Revised', '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(22, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', '68263a83627c38.90364393.pdf', '536824103', 'Revised', '2025-05-16 03:03:31', '2025-05-16 03:03:31'),
(23, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', '68263ab940edf2.23810961.pdf', '536824103', 'Revised', '2025-05-16 03:04:25', '2025-05-16 03:04:25'),
(24, '1638482254', 'ken', 'fsdfasdf', 'heloo', 'world', '683356fa75ade9.19709178.pdf', '536824103', 'Revised', '2025-05-26 01:44:26', '2025-05-26 01:44:26'),
(25, '1386862220', 'iquen', 'marba', 'iquenmarba', 'lkfhs;ladfkhjdsklfh;slkfhjhkl;sdhfsdfhsdflkhsd;laf', '6835e0caa6db86.17715250.pdf', '536824103', 'Revised', '2025-05-27 23:56:58', '2025-05-27 23:56:58'),
(26, '1386862220', 'iquen', 'marba', 'iquenmarba', 'lkfhs;ladfkhjdsklfh;slkfhjhkl;sdhfsdfhsdflkhsd;laf', '6835e16fe91663.54454200.pdf', '536824103', 'Revised', '2025-05-27 23:59:43', '2025-05-27 23:59:43'),
(27, '1386862220', 'iquen', 'marba', 'thesis ni kathy', 'abstract intro and wtf ', '6837e5b3d63a62.99437974.pdf', '1426418352', 'Revised', '2025-05-29 12:42:27', '2025-05-29 12:42:27'),
(28, '1386862220', 'iquen', 'marba', 'Thesis new title ', 'blasblablahdfjlkhsdlkfjh', '683943671bcdd1.13180055.pdf', '1426418352', 'Revised', '2025-05-30 13:34:31', '2025-05-30 13:34:31'),
(29, '1386862220', 'iquen', 'marba', 'test the swall alert', 'test', '6839462b2176c1.59839585.pdf', '1426418352', 'Revised', '2025-05-30 13:46:19', '2025-05-30 13:46:19'),
(30, '1386862220', 'iquen', 'marba', 'thesis ni kathy', 'abstract intro and wtf ', '6839618f9d0344.75136591.pdf', '1426418352', 'Revised', '2025-05-30 15:43:11', '2025-05-30 15:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `passw` varchar(50) DEFAULT NULL,
  `profileImg` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `bdate` varchar(255) DEFAULT NULL,
  `failed_attempts` int(11) NOT NULL,
  `lockout_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `fname`, `lname`, `email`, `passw`, `profileImg`, `gender`, `bdate`, `failed_attempts`, `lockout_time`, `created_at`, `updated`) VALUES
(12, '1386862220', 'iquen', 'marba', 'iquenxzx@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'profilejuly4.jpg', 'Male', '2025-05-15', 0, NULL, '2025-05-11 18:23:40', '2025-05-30 13:54:32'),
(13, '182184128', 'ken', 'marba', 'ken1@gmail.com', '6966dbc7dd4f4feb7e2c4a92b17fe472', 'noprofile.png', 'Male', '2025-05-15', 0, NULL, '2025-05-12 20:01:21', '2025-05-14 18:49:24'),
(14, '1638482254', 'ken', 'fsdfasdf', '1@gmail.com', '4d29dcf7dc907b2d239bdb16b48d7019', 'framing2.jpg', 'Male', '2025-05-28', 0, NULL, '2025-05-14 02:04:44', '2025-05-16 02:14:52'),
(15, '1421744535', 'gwapo', 'keyo', 'iquendaksl@gmail.com', 'bf756934d4e8d4464e5baf8b1222ae43', 'noprofile.png', 'Male', '2025-05-15', 0, NULL, '2025-05-28 02:43:23', '2025-05-28 02:43:23'),
(16, '1402351309', 'iquen', 'marba', 'iquen.marba1@evsu.edu.ph', '237781b01f2a333630a2bc044d90cedf', 'noprofile.png', 'Female', '2025-05-08', 0, NULL, '2025-05-28 02:58:34', '2025-05-28 02:58:34'),
(17, '1636419848', 'iquen', 'men', 'Iquedasdn@gmail.com', '211378793f3727de10dfeb061cc274c2', 'noprofile.png', 'Female', '2025-05-21', 0, NULL, '2025-05-28 03:06:14', '2025-05-28 03:06:14'),
(18, '879194746', 'Mike', 'Donaire', 'alfelorvonlaurence04@gmail.com', '2eaaab36b1b735306df4eea2e63c3c32', 'noprofile.png', 'Male', '2025-05-21', 0, NULL, '2025-05-30 15:51:25', '2025-05-30 15:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `thesis_history`
--

CREATE TABLE `thesis_history` (
  `id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `revision_num` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `revised_by` varchar(255) DEFAULT NULL,
  `revised_at` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_history`
--

INSERT INTO `thesis_history` (`id`, `thesis_id`, `student_id`, `revision_num`, `file_name`, `revised_by`, `revised_at`, `status`, `notes`) VALUES
(1, 20, '1386862220', 1, '68207ea05ff121.60675512.pdf', '536824103', '2025-05-11 18:40:32', 'Revised', ''),
(2, 20, '1386862220', 2, '682081612395c7.12518431.pdf', '536824103', '2025-05-11 18:52:17', 'Revised', ''),
(3, 20, '1386862220', 3, '682083a7bbf3f8.09436076.pdf', '536824103', '2025-05-11 19:01:59', 'Revised', ''),
(4, 20, '1386862220', 4, '68208b8d26ee65.28763880.pdf', '536824103', '2025-05-11 19:35:41', 'Revised', ''),
(5, 0, '1386862220', 1, '6820930d65db48.48460004.pdf', '1386862220', '2025-05-11 20:07:41', 'Student Revised', ''),
(6, 21, '1386862220', 1, '68209732c01322.28764202.pdf', '536824103', '2025-05-11 20:25:22', 'Revised', ''),
(7, 22, '421004543', 1, '6821e426ab3c69.97900922.pdf', '536824103', '2025-05-12 20:05:58', 'Revised', ''),
(8, 23, '421004543', 1, '6821f05b9ecb06.71567109.pdf', '536824103', '2025-05-12 20:58:03', 'Revised', ''),
(9, 33, '1638482254', 1, '682452600dafa3.97907780.pdf', '536824103', '2025-05-14 16:20:48', 'Revised', ''),
(10, 33, '1638482254', 2, '68246ac19ba9d2.44128498.pdf', '536824103', '2025-05-14 18:04:49', 'Revised', ''),
(11, 33, '1638482254', 3, '68246ceca05d84.61166479.pdf', '536824103', '2025-05-14 18:14:04', 'Revised', ''),
(12, 33, '1638482254', 4, '6824799f3d8bd2.86420473.pdf', '536824103', '2025-05-14 19:08:15', 'Revised', ''),
(13, 37, '1638482254', 1, '6825eb88eeeb78.82389821.pdf', '342162454', '2025-05-15 21:26:32', 'Revised', ''),
(14, 47, '1638482254', 1, '6826398082c518.96590509.pdf', '536824103', '2025-05-16 02:59:12', 'Revised', ''),
(15, 47, '1638482254', 2, '6826399981fe86.09721312.pdf', '536824103', '2025-05-16 02:59:37', 'Revised', ''),
(16, 47, '1638482254', 3, '68263a83627c38.90364393.pdf', '536824103', '2025-05-16 03:03:31', 'Revised', ''),
(17, 47, '1638482254', 4, '68263ab940edf2.23810961.pdf', '536824103', '2025-05-16 03:04:25', 'Revised', ''),
(18, 47, '1638482254', 5, 'heyow_1638482254_1747668958.pdf', 'ken fsdfasdf', '2025-05-19 23:35:58', 'Revised', ''),
(19, 47, '1638482254', 6, 'heyow_1638482254_1747669270.pdf', 'ken fsdfasdf', '2025-05-19 23:41:10', 'Revised', ''),
(20, 37, '1638482254', 2, 'iquen_1638482254_1747674486.pdf', 'ken fsdfasdf', '2025-05-20 01:08:06', 'Revised', ''),
(21, 33, '1638482254', 5, '683356fa75ade9.19709178.pdf', '536824103', '2025-05-26 01:44:26', 'Revised', ''),
(22, 50, '1386862220', 1, '6835e0caa6db86.17715250.pdf', '536824103', '2025-05-27 23:56:58', 'Revised', ''),
(23, 50, '1386862220', 2, '6835e16fe91663.54454200.pdf', '536824103', '2025-05-27 23:59:44', 'Revised', ''),
(24, 63, '1386862220', 1, '6837e5b3d63a62.99437974.pdf', '1426418352', '2025-05-29 12:42:27', 'Revised', ''),
(25, 63, '1386862220', 2, 'thesis_ni_kathy_1386862220_1748582407.pdf', 'iquen marba', '2025-05-30 13:20:07', 'Revised', ''),
(26, 65, '1386862220', 1, '683943671bcdd1.13180055.pdf', '1426418352', '2025-05-30 13:34:31', 'Revised', ''),
(27, 65, '1386862220', 2, 'Thesis_new_title__1386862220_1748583429.pdf', 'iquen marba', '2025-05-30 13:37:09', 'Revised', ''),
(28, 65, '1386862220', 3, 'Thesis_new_title__1386862220_1748583530.pdf', 'iquen marba', '2025-05-30 13:38:50', 'Revised', ''),
(29, 66, '1386862220', 1, '6839462b2176c1.59839585.pdf', '1426418352', '2025-05-30 13:46:19', 'Revised', ''),
(30, 66, '1386862220', 2, 'test_the_swall_alert_1386862220_1748584616.pdf', 'iquen marba', '2025-05-30 13:56:56', 'Revised', ''),
(31, 63, '1386862220', 3, 'thesis_ni_kathy_1386862220_1748590843.pdf', 'iquen marba', '2025-05-30 15:40:43', 'Revised', ''),
(32, 63, '1386862220', 4, '6839618f9d0344.75136591.pdf', '1426418352', '2025-05-30 15:43:11', 'Revised', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `publicrepo`
--
ALTER TABLE `publicrepo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repotable`
--
ALTER TABLE `repotable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revise_table`
--
ALTER TABLE `revise_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thesis_history`
--
ALTER TABLE `thesis_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `publicrepo`
--
ALTER TABLE `publicrepo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `repotable`
--
ALTER TABLE `repotable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `reviewer`
--
ALTER TABLE `reviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `revise_table`
--
ALTER TABLE `revise_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `thesis_history`
--
ALTER TABLE `thesis_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
