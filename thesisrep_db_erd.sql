-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 09:02 PM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `user_type` enum('admin','super_admin') NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `user_id`, `user_type`, `action_type`, `description`, `ip_address`, `created_at`) VALUES
(1, 'ADM002', 'admin', 'LOGIN', 'Admin logged in successfully', '::1', '2025-06-12 07:42:29'),
(2, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:42:29'),
(3, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:43:04'),
(4, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:43:41'),
(5, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:43:50'),
(6, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:44:20'),
(7, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:45:49'),
(8, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:46:14'),
(9, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:47:54'),
(10, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:48:53'),
(11, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:51:32'),
(12, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:54:06'),
(13, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:56:20'),
(14, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:57:08'),
(15, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 07:57:33'),
(16, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:00:14'),
(17, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:04:14'),
(18, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:07:50'),
(19, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:08:19'),
(20, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:08:38'),
(21, 'SADM001', 'super_admin', 'LOGOUT', 'Super admin logged out', '::1', '2025-06-12 08:09:17'),
(22, 'ADM002', 'admin', 'LOGIN', 'Admin logged in successfully', '::1', '2025-06-12 08:09:37'),
(23, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:09:37'),
(24, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:12:10'),
(25, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:12:39'),
(26, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:14:10'),
(27, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:15:21'),
(28, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:17:55'),
(29, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:18:39'),
(30, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:18:56'),
(31, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:19:39'),
(32, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:20:50'),
(33, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:22:26'),
(34, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:25:38'),
(35, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:31:08'),
(36, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:31:37'),
(37, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:32:12'),
(38, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:32:33'),
(39, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:33:07'),
(40, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:33:26'),
(41, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:34:56'),
(42, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:35:47'),
(43, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:36:00'),
(44, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:36:08'),
(45, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:36:53'),
(46, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:40:20'),
(47, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:41:24'),
(48, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:41:30'),
(49, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:41:45'),
(50, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:42:23'),
(51, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:43:09'),
(52, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:43:20'),
(53, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:45:31'),
(54, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 08:51:54'),
(55, 'SADM001', 'super_admin', 'LOGIN', 'Super admin logged in successfully', '::1', '2025-06-12 08:54:36'),
(56, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 08:54:45'),
(57, 'ADM002', 'admin', 'UPDATE', 'Updated admin: Default pol', '::1', '2025-06-12 08:56:25'),
(58, 'ADM002', 'admin', 'UPDATE', 'Updated admin: Default ken', '::1', '2025-06-12 08:56:34'),
(59, 'ADM002', 'admin', 'UPDATE', 'Updated admin: Default ken', '::1', '2025-06-12 08:56:48'),
(60, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 08:56:54'),
(61, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 09:02:15'),
(62, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 09:04:46'),
(63, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 09:14:22'),
(64, 'ADM002', 'admin', 'Moved from student to reviewer', 'Moved from student to reviewer', '::1', '2025-06-12 09:14:38'),
(65, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 09:14:50'),
(66, 'ADM002', 'admin', 'Demote', 'Moved from reviewer to student', '::1', '2025-06-12 09:16:51'),
(67, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 09:16:55'),
(68, 'ADM002', 'admin', 'LOGOUT', 'Admin logged out', '::1', '2025-06-12 09:25:17'),
(69, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 09:50:01'),
(70, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 09:50:07'),
(71, 'SADM001', 'super_admin', 'LOGOUT', 'Super admin logged out', '::1', '2025-06-12 09:50:13'),
(72, 'ADM002', 'admin', 'LOGIN_FAILED', 'Failed login attempt for admin account', '::1', '2025-06-12 09:50:21'),
(73, 'SADM001', 'super_admin', 'LOGIN', 'Super admin logged in successfully', '::1', '2025-06-12 14:17:40'),
(74, 'SADM001', 'super_admin', 'VIEW', 'Accessed activity logs page', '::1', '2025-06-12 14:18:32'),
(75, 'SADM001', 'super_admin', 'LOGOUT', 'Super admin logged out', '::1', '2025-06-12 14:19:13'),
(76, 'SADM001', 'super_admin', 'LOGIN', 'Super admin logged in successfully', '::1', '2025-06-12 14:19:27'),
(77, 'SADM001', 'super_admin', 'LOGOUT', 'Super admin logged out', '::1', '2025-06-12 14:19:32'),
(78, 'ADM002', 'admin', 'LOGIN', 'Admin logged in successfully', '::1', '2025-06-12 16:27:07'),
(79, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 16:27:07'),
(80, 'ADM002', 'admin', 'Promote', 'Moved from student to reviewer', '::1', '2025-06-12 16:27:44'),
(81, 'ADM002', 'admin', 'LOGOUT', 'Admin logged out', '::1', '2025-06-12 16:28:16'),
(82, 'ADM002', 'admin', 'LOGIN_FAILED', 'Failed login attempt for admin account', '::1', '2025-06-12 17:07:53'),
(83, 'ADM002', 'admin', 'LOGIN', 'Admin logged in successfully', '::1', '2025-06-12 17:07:58'),
(84, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:07:58'),
(85, 'ADM002', 'admin', 'LOGIN', 'Admin logged in successfully', '::1', '2025-06-12 17:20:52'),
(86, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:20:52'),
(87, 'ADM002', 'admin', 'Promote', 'Moved from student to reviewer', '::1', '2025-06-12 17:21:38'),
(88, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:26:02'),
(89, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:26:20'),
(90, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:30:25'),
(91, 'ADM002', 'admin', 'Demote', 'Moved from reviewer to student', '::1', '2025-06-12 17:30:40'),
(92, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:41:12'),
(93, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:41:35'),
(94, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:43:57'),
(95, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 17:45:19'),
(96, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:00:16'),
(97, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:01:26'),
(98, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:02:18'),
(99, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:06:32'),
(100, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:07:29'),
(101, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:08:29'),
(102, 'ADM002', 'admin', 'LOGIN', 'Admin logged in successfully', '::1', '2025-06-12 18:17:20'),
(103, 'ADM002', 'admin', 'VIEW', 'Accessed admin dashboard', '::1', '2025-06-12 18:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log_admin`
--

CREATE TABLE `activity_log_admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log_admin`
--

INSERT INTO `activity_log_admin` (`id`, `admin_id`, `activity`, `date`) VALUES
(18, 'ADM002', 'Moved from student to reviewer', '2025-06-09 20:36:04'),
(19, 'ADM002', 'Moved from student to reviewer', '2025-06-10 15:09:36'),
(20, 'ADM002', 'Moved from reviewer to student', '2025-06-10 15:10:37'),
(21, 'ADM002', 'Moved from reviewer to student', '2025-06-12 07:32:41'),
(22, 'ADM002', 'Moved from student to reviewer', '2025-06-12 07:39:12'),
(23, 'ADM002', 'Moved from reviewer to student', '2025-06-12 07:41:02'),
(24, 'ADM002', 'Moved from student to reviewer', '2025-06-12 07:44:29'),
(25, 'ADM002', 'Moved from reviewer to student', '2025-06-12 08:00:46'),
(26, 'ADM002', 'Moved from student to reviewer', '2025-06-12 10:26:23'),
(27, 'ADM002', 'Moved from reviewer to student', '2025-06-12 10:26:32'),
(28, 'ADM002', 'Moved from reviewer to student', '2025-06-12 10:35:07'),
(29, 'ADM002', 'Moved from student to reviewer', '2025-06-12 10:36:56'),
(30, 'ADM002', 'Moved from student to reviewer', '2025-06-12 11:14:38'),
(31, 'ADM002', 'Moved from reviewer to student', '2025-06-12 11:16:51'),
(32, 'ADM002', 'Moved from student to reviewer', '2025-06-12 18:27:44'),
(33, 'ADM002', 'Moved from student to reviewer', '2025-06-12 19:21:38'),
(34, 'ADM002', 'Moved from reviewer to student', '2025-06-12 19:30:40');

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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profileImg` varchar(255) DEFAULT 'noprofile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `fname`, `lname`, `email`, `pass`, `created_at`, `updated_at`, `profileImg`) VALUES
(6, 'ADM001', 'Default', 'pol', 'admin@gmail.com', 'a66abb5684c45962d887564f08346e8d', '2025-05-27 19:06:49', '2025-06-12 16:56:25', 'noprofile.png'),
(7, 'ADM002', 'Default', 'ken', 'iquenxzx@gmail.com', '0192023a7bbd73250516f069df18b500', '2025-05-27 19:06:49', '2025-06-12 16:56:34', 'noprofile.png'),
(8, 'ADM003', 'chan', 'colo', 'chan@gmail.com', '0192023a7bbd73250516f069df18b500', '2025-06-12 11:36:10', '2025-06-12 11:36:10', 'noprofile.png');

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
(2, '1386862220', 'iquen', 'marba', 'iquenmarba', 'lkfhs;ladfkhjdsklfh;slkfhjhkl;sdhfsdfhsdflkhsd;laf', '6835e0809dd2f9.35926609.pdf', '536824103', 'private', '2025-05-27 23:57:46', '2025-06-03 03:36:39'),
(3, '1386862220', 'iquen', 'marba', 'AI ni russel', 'abstract intro and wtf ', '6837bf2a825874.18443647.pdf', '1426418352', 'public', '2025-05-29 10:00:50', '2025-06-08 17:56:43'),
(4, '1386862220', 'iquen', 'marba', 'thesis ni cholo', 'abstract intro and wtf ', '6837bf6889f0a4.77250501.pdf', '1426418352', 'public', '2025-05-29 12:15:59', '2025-05-29 12:15:59'),
(5, '1386862220', 'iquen', 'marba', 'Thesis new title ', 'blasblablahdfjlkhsdlkfjh', 'Thesis_new_title__1386862220_1748583530.pdf', '1426418352', 'public', '2025-05-30 13:40:45', '2025-05-30 13:42:06'),
(6, '1386862220', 'iquen', 'marba', 'no', 'alsdalsd', '683960a3b69f98.35555697.pdf', '1426418352', 'private', '2025-05-30 15:44:26', '2025-05-30 15:45:40'),
(7, '1386862220', 'iquen', 'marba', 'thesis ni kathy', 'abstract intro and wtf ', 'thesis_ni_kathy_1386862220_1748892780.pdf', '1426418352', 'private', '2025-06-03 03:34:56', '2025-06-03 03:36:52'),
(8, '1386862220', 'iquen', 'marba', 'test debug', 'debug abstract', 'test_debug_1386862220_1748892744.pdf', '1426418352', 'public', '2025-06-03 03:34:58', '2025-06-03 03:34:58'),
(9, '1402351309', 'iquen', 'marba', 'gwapo', 'fsdfsdf', '6843178c493491.14898958.pdf', '1426418352', 'private', '2025-06-07 00:30:15', '2025-06-07 00:57:47'),
(10, '1402351309', 'iquen', 'marba', 'thesis uploaded', 'heyow', 'thesis_uploaded_1402351309_1749230015.pdf', '1426418352', 'public', '2025-06-07 01:13:55', '2025-06-07 01:13:55'),
(11, '1386862220', 'iquen', 'marba', 'okay done na', 'hays AHAHAAHAH', 'okay_done_na_1386862220_1749357536.pdf', '1426418352', 'public', '2025-06-08 12:39:19', '2025-06-08 12:39:59'),
(12, '1421744535', 'roxanne', 'dalag', 'Smart Waste Management System Using IoT Sensors', 'This study develops a smart waste monitoring syste', '6845c7fe0dbb07.64814751.pdf', '1426418352', 'public', '2025-06-09 01:31:30', '2025-06-09 01:31:30'),
(13, '1421744535', 'roxanne', 'dalag', 'The Impact of Social Media on Academic Performance of College Students', 'This research examines how social media usage affects the academic performance of college students, identifying both positive influences such as knowledge sharing and negative effects like reduced study time.', '6845c8b17fb260.47813326.pdf', '1426418352', 'public', '2025-06-09 01:31:34', '2025-06-09 01:31:34'),
(14, '1421744535', 'roxanne', 'dalag', 'Design and Development of a Mobile-Based Voting System for Student Council Elections', 'This project presents a secure and user-friendly mobile application that allows students to vote electronically, aiming to increase participation and streamline election processes in academic institutions.', '6845c9bb3cbfd4.23323616.pdf', '1426418352', 'public', '2025-06-09 01:36:49', '2025-06-09 01:36:49'),
(15, '1421744535', 'roxanne', 'dalag', '\"A Study on Cybersecurity Awareness Among Senior High School Students', 'The research evaluates the level of cybersecurity awareness among senior high school students, focusing on password hygiene, phishing threats, and social media privacy settings', '6845cc09573894.85558468.pdf', '1426418352', 'public', '2025-06-09 01:47:59', '2025-06-09 01:47:59'),
(16, '1638482254', 'Kathy', 'Geses', 'Automated Plant Watering System Based on Soil Moisture Detection', 'The study builds an automated irrigation system using sensors to monitor soil moisture and regulate watering, promoting efficient water usage for home and small-scale farms.', '6845ce0992e8c5.82038770.pdf', '1426418352', 'public', '2025-06-09 02:17:32', '2025-06-09 02:17:32'),
(17, '1386862220', 'iquen', 'marba', 'An AI Chatbot for Campus Information and Student Support Services', 'This thesis develops an intelligent chatbot that assists students with campus-related queries, including schedules, deadlines, and facility directions, improving service accessibility.', '6845d324d76334.31803436.pdf', '1426418352', 'public', '2025-06-09 02:17:45', '2025-06-09 02:17:45'),
(18, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile App', 'This research analyzes user preferences, readability, and battery consumption between light and dark modes in mobile applications, aiming to provide design recommendations for developers.', '6845d359087b48.82354095.pdf', '1426418352', 'public', '2025-06-09 02:17:54', '2025-06-09 02:17:54'),
(19, '1386862220', 'iquen', 'marba', 'Fingerprint-Based Attendance System for University Classrooms', 'This research designs a biometric attendance system using fingerprint recognition to ensure accurate and tamper-proof student attendance records.', '6845d2b4a1d3c9.63858417.pdf', '1426418352', 'public', '2025-06-09 02:54:44', '2025-06-09 02:54:44'),
(20, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile Apps', ' This research analyzes user preferences, readability, and battery consumption between light and dark modes in mobile applications, aiming to provide design recommendations for developers.', 'A_Comparative_Study_on_the_Effectiveness_of_Light_vs__Dark_Mode_Interfaces_in_Mobile_Apps_1386862220_1749408851.pdf', '1426418352', 'public', '2025-06-09 02:54:50', '2025-06-09 02:54:50'),
(21, '1638482254', 'Kathy', 'Geses', 'Mobile Application for Disaster Preparedness and Emergency Response', 'The thesis proposes an all-in-one disaster preparedness app providing alerts, evacuation routes, emergency contacts, and safety tips to enhance public readiness.', '6845d06e746891.55593190.pdf', '1426418352', 'public', '2025-06-09 03:13:33', '2025-06-09 03:13:33'),
(22, '1638482254', 'Kathy', 'Geses', 'Analyzing the Effects of Online Learning on Student Engagement Post-Pandemic', 'This research investigates the impact of online learning methods on student participation and motivation, comparing data from pre- and post-pandemic education systems.', '6845ce991bb4c7.22746164.pdf', '1426418352', 'public', '2025-06-09 03:13:51', '2025-06-09 03:13:51'),
(23, '1086249761', 'Christian', 'Colo', 'Development of a Personalized Learning Management System for Programming Courses', 'This research builds a learning platform that adapts content difficulty based on students\' performance, supporting personalized learning in programming.', '6845e1e70655e7.89873723.pdf', '1426418352', 'public', '2025-06-09 03:19:04', '2025-06-09 03:19:04'),
(24, '1086249761', 'Christian', 'Colo', 'Development of a Mobile Expense Tracker App for College Students', 'The project involves creating a mobile application that helps students manage their budget and monitor spending habits through real-time expense tracking and analytics.', '6845e1c43e0139.76899962.pdf', '1426418352', 'public', '2025-06-09 03:19:11', '2025-06-09 03:20:28'),
(25, '1086249761', 'Christian', 'Colo', 'Facial Expression Recognition System for Emotion Detection in Online Classes', 'This research develops an AI-based system that analyzes students\' facial expressions during online classes to assess engagement and emotional states.\r\n\r\n', '6845e1a5893e09.24485488.pdf', '1426418352', 'public', '2025-06-09 03:19:24', '2025-06-09 03:19:24'),
(26, '1086249761', 'Christian', 'Colo', 'A Study on the Impact of Online Games on Academic Performance of High School Students', 'The research analyzes the correlation between time spent on online gaming and students\' academic outcomes, attendance, and study habits.', '6845e1d4b6d2c9.23674370.pdf', '1426418352', 'public', '2025-06-09 03:19:32', '2025-06-09 03:19:32'),
(27, '1638482254', 'Kathy', 'Geses', 'Game-Based Learning Platform for Basic Programming Education', 'This study presents a game-based application designed to teach basic programming concepts to beginners, aiming to increase learner interest and retention.', '6845d1d0ca6515.61738639.pdf', '1426418352', 'public', '2025-06-10 23:29:02', '2025-06-10 23:29:02'),
(28, '1386862220', 'iquen', 'marba', 'adasdasdasssssssssss  ssssssdasdasd dfsdaffasd  asdfs dfasdfasdfasdfas asdfasfasdfasfd', 'asdasdasdasdadsdasdasd ad ad asdfd dsf asf asdf asd fsdf asg fdg sdfg sdfg sdfg', 'adasdasdasssssssssss__ssssssdasdasd_dfsdaffasd__asdfs_dfasdfasdfasdfas_asdfasfasdfasfd_1386862220_1749409992.pdf', '1426418352', 'public', '2025-06-10 23:29:06', '2025-06-10 23:29:06'),
(29, '1086249761', 'Christian', 'Colo', 'Evaluating the Effects of Online Shopping on Consumer Buying Behavior in the Philippines', 'The study investigates how convenience, security, and product availability influence consumer decision-making in e-commerce platforms.', '6845e18fde6dd0.62843455.pdf', '1426418352', 'public', '2025-06-10 23:29:15', '2025-06-10 23:29:15'),
(34, '1491190329', 'iquen', 'marba', 'roxanne demo', '', 'rev_684ae478b091a6.27654965.pdf', '1426418352', 'public', '2025-06-12 22:30:31', '2025-06-12 22:30:31');

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
  `abstract` varchar(255) DEFAULT NULL,
  `ThesisFile` varchar(255) DEFAULT NULL,
  `reviewer_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `introduction` varchar(1000) DEFAULT NULL,
  `Project_objective` varchar(1000) DEFAULT NULL,
  `significance_of_study` varchar(1000) DEFAULT NULL,
  `system_analysis_and_design` varchar(1000) DEFAULT NULL,
  `Chapter` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `members_id` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repotable`
--

INSERT INTO `repotable` (`id`, `student_id`, `fname`, `lname`, `title`, `abstract`, `ThesisFile`, `reviewer_id`, `status`, `created_at`, `updated`, `introduction`, `Project_objective`, `significance_of_study`, `system_analysis_and_design`, `Chapter`, `message`, `members_id`) VALUES
(81, '1421744535', 'roxanne', 'dalag', '\"A Study on Cybersecurity Awareness Among Senior High School Students', 'The research evaluates the level of cybersecurity awareness among senior high school students, focusing on password hygiene, phishing threats, and social media privacy settings', '6845cc09573894.85558468.pdf', '1426418352', 'approved', '2025-06-09 01:44:41', '2025-06-09 01:47:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, '1638482254', 'Kathy', 'Geses', 'Automated Plant Watering System Based on Soil Moisture Detection', 'The study builds an automated irrigation system using sensors to monitor soil moisture and regulate watering, promoting efficient water usage for home and small-scale farms.', '6845ce0992e8c5.82038770.pdf', '1426418352', 'approved', '2025-06-09 01:53:13', '2025-06-09 02:17:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, '1638482254', 'Kathy', 'Geses', 'Analyzing the Effects of Online Learning on Student Engagement Post-Pandemic', 'This research investigates the impact of online learning methods on student participation and motivation, comparing data from pre- and post-pandemic education systems.', '6845ce991bb4c7.22746164.pdf', '1426418352', 'approved', '2025-06-09 01:55:37', '2025-06-09 03:13:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, '1638482254', 'Kathy', 'Geses', 'Mobile Application for Disaster Preparedness and Emergency Response', 'The thesis proposes an all-in-one disaster preparedness app providing alerts, evacuation routes, emergency contacts, and safety tips to enhance public readiness.', '6845d06e746891.55593190.pdf', '1426418352', 'approved', '2025-06-09 02:03:26', '2025-06-09 03:13:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, '1638482254', 'Kathy', 'Geses', 'Game-Based Learning Platform for Basic Programming Education', 'This study presents a game-based application designed to teach basic programming concepts to beginners, aiming to increase learner interest and retention.', '6845d1d0ca6515.61738639.pdf', '1426418352', 'approved', '2025-06-09 02:09:20', '2025-06-10 23:29:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, '1638482254', 'Kathy', 'Geses', 'Mental Health Monitoring System for College Students Using a Web Platform', ' The project develops a web-based system that allows students to self-assess their mental health, offering resources and referral options for psychological support.', '6845d207df57a1.50186337.pdf', '1426418352', 'rejected', '2025-06-09 02:10:15', '2025-06-09 03:13:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, '1386862220', 'iquen', 'marba', 'Fingerprint-Based Attendance System for University Classrooms', 'This research designs a biometric attendance system using fingerprint recognition to ensure accurate and tamper-proof student attendance records.', '6845d2b4a1d3c9.63858417.pdf', '1426418352', 'approved', '2025-06-09 02:13:08', '2025-06-09 02:54:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, '1386862220', 'iquen', 'marba', 'Blockchain-Based Certificate Verification System for Academic Institutions', 'The study proposes a decentralized certificate verification platform using blockchain technology to enhance security, authenticity, and accessibility of academic records.', '6845d2fb770823.65840415.pdf', '1426418352', 'rejected', '2025-06-09 02:14:19', '2025-06-09 02:18:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, '1386862220', 'iquen', 'marba', 'An AI Chatbot for Campus Information and Student Support Services', 'This thesis develops an intelligent chatbot that assists students with campus-related queries, including schedules, deadlines, and facility directions, improving service accessibility.', '6845d324d76334.31803436.pdf', '1426418352', 'approved', '2025-06-09 02:15:00', '2025-06-09 02:17:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile App', 'This research analyzes user preferences, readability, and battery consumption between light and dark modes in mobile applications, aiming to provide design recommendations for developers.', '6845d359087b48.82354095.pdf', '1426418352', 'approved', '2025-06-09 02:15:53', '2025-06-09 02:17:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, '1386862220', 'iquen', 'marba', 'adasdasdasssssssssss  ssssssdasdasd dfsdaffasd  asdfs dfasdfasdfasdfas asdfasfasdfasfd', 'asdasdasdasdadsdasdasd ad ad asdfd dsf asf asdf asd fsdf asg fdg sdfg sdfg sdfg', 'adasdasdasssssssssss__ssssssdasdasd_dfsdaffasd__asdfs_dfasdfasdfasdfas_asdfasfasdfasfd_1386862220_1749409992.pdf', '1426418352', 'approved', '2025-06-09 02:48:56', '2025-06-10 23:29:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile Apps', ' This research analyzes user preferences, readability, and battery consumption between light and dark modes in mobile applications, aiming to provide design recommendations for developers.', 'A_Comparative_Study_on_the_Effectiveness_of_Light_vs__Dark_Mode_Interfaces_in_Mobile_Apps_1386862220_1749408851.pdf', '1426418352', 'approved', '2025-06-09 02:51:09', '2025-06-09 02:54:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, '1086249761', 'Christian', 'Colo', 'Evaluating the Effects of Online Shopping on Consumer Buying Behavior in the Philippines', 'The study investigates how convenience, security, and product availability influence consumer decision-making in e-commerce platforms.', '6845e18fde6dd0.62843455.pdf', '1426418352', 'approved', '2025-06-09 03:16:31', '2025-06-10 23:29:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, '1086249761', 'Christian', 'Colo', 'Facial Expression Recognition System for Emotion Detection in Online Classes', 'This research develops an AI-based system that analyzes students\' facial expressions during online classes to assess engagement and emotional states.\r\n\r\n', '6845e1a5893e09.24485488.pdf', '1426418352', 'approved', '2025-06-09 03:16:53', '2025-06-09 03:19:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, '1086249761', 'Christian', 'Colo', 'Development of a Mobile Expense Tracker App for College Students', 'The project involves creating a mobile application that helps students manage their budget and monitor spending habits through real-time expense tracking and analytics.', '6845e1c43e0139.76899962.pdf', '1426418352', 'approved', '2025-06-09 03:17:24', '2025-06-09 03:19:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, '1086249761', 'Christian', 'Colo', 'A Study on the Impact of Online Games on Academic Performance of High School Students', 'The research analyzes the correlation between time spent on online gaming and students\' academic outcomes, attendance, and study habits.', '6845e1d4b6d2c9.23674370.pdf', '1426418352', 'approved', '2025-06-09 03:17:40', '2025-06-09 03:19:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, '1086249761', 'Christian', 'Colo', 'Development of a Personalized Learning Management System for Programming Courses', 'This research builds a learning platform that adapts content difficulty based on students\' performance, supporting personalized learning in programming.', '6845e1e70655e7.89873723.pdf', '1426418352', 'approved', '2025-06-09 03:17:59', '2025-06-09 03:19:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, '539348499', 'Janpol', 'vasquez', 'new title ', 'final presentation', '68466be34bd589.50146570.pdf', '1426418352', 'Revised', '2025-06-09 13:06:43', '2025-06-09 13:08:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'Array', 'iquen', 'marba', 'fjsakl;fjkljsd f\'kl', '', 'apa_6847bf85788c87.80240911.pdf', '1426418352', 'approved', '2025-06-10 13:15:52', '2025-06-10 23:29:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'Array', 'iquen', 'marba', 'fsdffgsdaf', '', 'apa_6847c02b8a8be6.12064817.pdf', '1426418352', 'rejected', '2025-06-10 13:18:37', '2025-06-10 23:29:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'Array', 'iquen', 'marba', 'dsadasfdsdf', '', 'apa_6847c06590f203.44641889.pdf', '1426418352', 'rejected', '2025-06-10 13:19:35', '2025-06-10 23:29:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'Array', 'iquen', 'marba', 'dfsdfsdfwsdf', '', 'apa_6847c07bf00237.14076963.pdf', '1426418352', 'rejected', '2025-06-10 13:19:58', '2025-06-10 23:29:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, '1386862220', 'iquen', 'marba', 'gwapooookayyoooo ka wtf ka', '', 'apa_6847c3b08c9f68.76872952.pdf', '1426418352', 'rejected', '2025-06-10 13:33:40', '2025-06-11 00:01:02', NULL, NULL, NULL, NULL, NULL, 'kjklj;jf;lsdjflasd', NULL),
(111, '1386862220', 'iquen', 'marba', 'title sa proposal', '', 'apa_684831ec738529.50229824.pdf', '1426418352', 'Revised', '2025-06-10 21:24:16', '2025-06-10 21:32:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, '1386862220', 'iquen', 'marba', 'posposal  again please submit', '', 'rev_684877a31972e2.32748510.pdf', '1426418352', 'Accepted', '2025-06-10 21:48:43', '2025-06-12 00:50:46', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d flkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf \';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf gjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl; kdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg jlsdkfj glskdfjg lksdfjgsdlfk; gjl', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d flkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf \';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf gjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl; kdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg jlsdkfj glskdfjg lksdfjgsdlfk; gjl', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d flkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf \';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf gjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl; kdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg jlsdkfj glskdfjg lksdfjgsdlfk; gjl', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d flkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf \';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf gjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl; kdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg jlsdkfj glskdfjg lksdfjgsdlfk; gjl', '2', '', NULL),
(113, '1386862220', 'iquen', 'marba', 'title ni iquen gwapo kaayo shetttssss gwapo', '', 'rev_684877f215a3a0.10029903.pdf', '1426418352', 'Accepted', '2025-06-10 21:49:17', '2025-06-12 00:50:57', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glk', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdjf glkjsdf klgjlk dsjg', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjfdfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdfdfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg', '2', '', NULL),
(114, '1386862220', 'iquen', 'marba', 'title ni sa proposal', '', 'rev_68487d50c9cbd1.33107480.pdf', '1426418352', 'continue', '2025-06-10 21:52:37', '2025-06-12 10:52:45', '$stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();\r\n        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $st', '$stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt', '$stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt', '$stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt4->execute();\r\n        $stmt4->close();        $stmt4 = $connect->prepare(\"INSERT INTO thesis_history (thesis_id, student_id, revision_num, file_name, revised_by, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)\");\r\n        $stmt4->bind_param(\"iisssss\", $thesis_id, $student_id, $next_revision, $newFileName, $revised_by, $status, $notes);\r\n        $stmt', '1', '', NULL),
(115, '1386862220', 'iquen', 'marba', 'fgsdgdfsgesdfgsdfg', '', 'apa_684838d5e55241.61643980.pdf', '132957139', 'pending', '2025-06-10 21:53:27', '2025-06-11 00:21:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, '1386862220', 'iquen', 'marba', 'thesis repo and peer reviewer', '', 'apa_68483ae5556fc7.19141254.pdf', '1426418352', 'pending', '2025-06-10 22:02:15', '2025-06-11 00:21:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, '1386862220', 'iquen', 'marba', 'geffsdkjgkjosdfgsdf;iklgkl;sf', NULL, 'apa_68484ab96d0e06.86104070.pdf', '132957139', 'pending', '2025-06-10 23:09:47', '2025-06-11 00:21:29', '', '', '', '', '1', NULL, NULL),
(120, '1386862220', 'iquen', 'marba', 'lfjsadlkfjldksajflsdfasdfgffsdg', '', 'apa_68484d8a1a2515.97719857.pdf', '1426418352', 'pending', '2025-06-10 23:21:48', '2025-06-11 00:21:15', '', '', '', '', '1', '', NULL),
(121, '1386862220', 'iquen', 'marba', 'sir mao nani ang proposal', '', 'rev_684874030eb6b3.16722153.pdf', '1426418352', 'Pending', '2025-06-11 02:02:02', '2025-06-11 02:05:57', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdjf glkjsdf klgjlk dsjg', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdjf glkjsdf klgjlk dsjg', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdjf glkjsdf klgjlk dsjg', 'dfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;ddfgfeksdfjngkl fdshglkhjsdfkg hjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;ls fdjgkl efjhdsklgj e;d\r\nflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdj f glkjsdf k lgjlk dsjgk jlkdjf g;lsdkffj gl;\r\nkdsffjg lk;dsjf glkdfj glk;jsdflfkgj dlfkf jlkdsj glkdsjf g;lsdkjg lkdssfjg lk;dsjfg lkjdf;lkg\r\njlsdkfj glskdfjg lksdfjgsdlfk; gjl\r\nProject Objective\r\ndfgfeksdfjngklfdshglkhjsdfkghjfeksdhglsdffkhgjgzs;ldjg ;lwjsdgl;kj;lsfdjgkl efjhdsklgj\r\ne;dflkjgk;ldsfjgkljdf lkjg klefdjg kljefdsklg jdfklj gkldjfgk jefkldjg kldfjglk jefdkl;jg lksdjf\r\n\';gjefdg\'jdfg j\'kksfdj gff\'dfsjg kdfjg kl;esjfdg;l ksdjg; jsdfflk; jgkfdj glksdjg ;lksdjfg ;lkjsdf\r\ngjdkl jg;lsdkfjg ;lksjdfg lkjsdklg jsdlfl jklsdfj glksdjf glkjsdf klgjlk dsjg', '2', '', NULL),
(122, '1386862220', 'iquen', 'marba', 'dsffsdfgfdsfgsdfg', '', 'apa_68487f1c8ad9b4.86521451.pdf', '1426418352', 'pending', '2025-06-11 02:53:18', '2025-06-11 02:53:18', '', '', '', '', '1', '', 'Array'),
(123, '1386862220', 'iquen', 'marba', 'bagong title na proposal', '', 'apa_68487f80d75193.77355323.pdf', '1426418352', 'continue', '2025-06-11 02:54:58', '2025-06-12 02:05:28', '', '', '', '', '2', '', '182184128,1638482254,539348499,1086249761'),
(124, '1386862220', 'iquen', 'marba', 'new title na lagi ni para sa thesis', '', 'apa_6848827525d8f9.33367006.pdf', '1386862220', 'pending', '2025-06-11 03:07:34', '2025-06-11 03:07:34', '', '', '', '', '1', '', '182184128,1638482254,1421744535,1086249761'),
(125, '1386862220', 'iquen', 'marba', 'Student Performance Monitoring System with Predictive Analytics', '', 'rev_68488b84bd67b4.12162963.pdf', '1426418352', 'Pending', '2025-06-11 03:08:49', '2025-06-12 00:58:57', 'In today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digital tools to streamline this process. This study proposes the development of a Student Performance Monitoring System with integrated predictive analytics that helps educators track and forecast student outcomes based on historical and real-time data.In today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digital tools to streamline this process. This study p', 'In today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digital tools to streamline this process. This study proposes the development of a Student Performance Monitoring System with integrated predictive analytics that helps educators track and forecast student outcomes based on historical and real-time data.In today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digital tools to streamline this process. This study p', 'The system is designed as a web-based platform built using PHP and MySQL for the backend, and JavaScript for interacIn today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digital tools to streamline this process. This study proposes the development of a Student Performance Monitoring System with integrated predictive analytics that helps educators track and forecast student outcomes based on historical and real-time data.In today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data ', 'The system is designed as a web-based platform buIn today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digital tools to streamline this process. This study proposes the development of a Student Performance Monitoring System with integrated predictive analytics that helps educators track and forecast student outcomes based on historical and real-time data.In today’s academic environment, it is essential to monitor and evaluate students’ academic performance accurately and efficiently. Traditional methods of tracking performance through manual grading and reporting are time-consuming and prone to human error. With advancements in data analytics and system automation, institutions can now utilize digit', '1', '', '1386862220,182184128,1638482254,1421744535,1086249761'),
(126, '1491190329', 'iquen', 'marba', 'ito ay title', '', 'rev_6849b501d85209.74549815.pdf', '1426418352', 'continue', '2025-06-11 20:09:32', '2025-06-12 00:58:54', 'gflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhds', 'gflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg', 'gflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg', 'gflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhdsflkjghlkjsdf hglksdhlgkjhdsflkjglksdjhfg \r\ngflk;hj gl jkdfshgjkld sfhgjkldshfgljksdhlgfkj hsdfljkghsdljkhgljkdshffgjlkhsd  lkgjhdlskjfhgkjlsdhflgkhds', '1', '', '1402351309,1636419848,879194746,539348499,1086249761'),
(127, '1491190329', 'iquen', 'marba', 'thesis repo docu', '', 'apa_6849b4111f3940.67454237.pdf', '1426418352', 'continue', '2025-06-12 00:51:31', '2025-06-12 00:58:51', '', '', '', '', '1', '', '1386862220,182184128,1638482254,1421744535,1402351309,1636419848,879194746,539348499,1086249761,1491190329'),
(128, '1491190329', 'iquen', 'marba', 'iot weather satation docu', '', 'rev_6849c60f42c2e9.99394765.pdf', '1426418352', 'continue', '2025-06-12 01:00:33', '2025-06-12 02:08:30', 'basta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjv basta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkj basta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkj basta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkjbasta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;basta kay itnro nisadjhf;klsdajflkjsad;lfjs;alkdjf ;lkj', '', '', '', '2', '', '1638482254,1421744535,879194746,539348499'),
(129, '1491190329', 'iquen', 'marba', 'new vtitle', '', 'rev_6849d0855fe448.24613700.pdf', '1426418352', 'approved', '2025-06-12 01:57:16', '2025-06-12 03:16:18', 'titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl', 'titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;', 'titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgtitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgj', 'titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gtitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;titjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkdsfjg ;lkdjf kljdl;kfgj l;ksdfj gl;kdsfjg lk;djsfgl; kjdf;lk gjdljfg lk;ds klgjdf;lkgj l;kdsfjg l;ksdjf glkjdf;lk gjdslk;fjg d;lktitjsdklfg jos;kdhg;sdl g;lksfj g;ldjsflkgj ;lskdfjg ljsdfkl;g j;lksdfj gkl;sdj fg;lkjdf kl;gjdkl;f gjlk;dsfj gl;kdjf gkldjf glk;jed ;flkgjs;ld jfg;kldsj fkl;gj dflk;jg ;lkds', '4', '', '1638482254,1421744535,539348499,1086249761'),
(130, '1491190329', 'iquen', 'marba', 'gffdgsfdgsdfg', '', 'rev_684a7b7b4245e1.83402662.pdf', '1426418352', 'Revised', '2025-06-12 10:41:01', '2025-06-12 15:03:18', 'fjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; fjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkh', 'fjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;kfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg', 'fjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lkfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;l', 'fjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlkhglk; shldk; hfjdkslfghj;lksadjgkl;jasf;klg a hjsdg;kl hsflkgh ;ljshfgl; hsdlk', '4', '', '1638482254,1421744535'),
(131, '1491190329', 'iquen', 'marba', 'merge super admin gwapo', '', 'rev_684a53588ed731.36908463.pdf', '1426418352', 'approved', '2025-06-12 10:58:55', '2025-06-12 12:11:15', 'ekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jk', 'ekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jk', 'ekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jk', 'ekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jkekp\'olfjsd\'kl;gj;klsdffjdgfl;kj sdf;lkgjkl; sdefjgpes i;fdnvu gsf jk', '4', '', '182184128,1638482254,539348499,1086249761'),
(132, '1491190329', 'iquen', 'marba', 'dafdsgasgfsdg', '', 'rev_684a52729f1a51.48428460.pdf', '1426418352', 'pending', '2025-06-12 11:04:53', '2025-06-12 12:07:34', 'dafdsgasgfsdgdafdsgasgfsdgd vdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgafdsgadafdsgasgfsdgdafdsgasgfsdgsgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsg dafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdg sgfsdg', 'dafdsgasgfsdgdafdsgasgfsdgd vdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgafdsgadafdsgasgfsdgdafdsgasgfsdgsgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsg dafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdg sgfsdg', 'dafdsgasgfsdgdafdsgasgfsdgd vdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgafdsgadafdsgasgfsdgdafdsgasgfsdgsgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsg dafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdg sgfsdg', 'dafdsgasgfsdgdafdsgasgfsdgd vdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgafdsgadafdsgasgfsdgdafdsgasgfsdgsgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdgdafdsg dafdsgasgfsdgdafdsgasgfsdgdafdsgasgfsdg sgfsdg', '5', '', '1638482254,1421744535,539348499,1086249761');
INSERT INTO `repotable` (`id`, `student_id`, `fname`, `lname`, `title`, `abstract`, `ThesisFile`, `reviewer_id`, `status`, `created_at`, `updated`, `introduction`, `Project_objective`, `significance_of_study`, `system_analysis_and_design`, `Chapter`, `message`, `members_id`) VALUES
(133, '1491190329', 'iquen', 'marba', 'upload kag title na proposal', '', 'rev_684a56ac690c30.92711200.pdf', '1426418352', 'approved', '2025-06-12 12:22:01', '2025-06-12 12:25:27', 'dskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjd', 'dskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjd', 'dskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjd', 'dskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjddskhjf lo;sdhfgjs afho shfgjklsfhgfjkhdfs sljksghslekjd', '4', '', '1638482254,1421744535,1636419848,1086249761'),
(134, '1491190329', 'iquen', 'marba', 'new title ni sa na merge ni janpol', '', 'rev_684b085fce9db7.11662705.pdf', '1426418352', 'continue', '2025-06-12 17:31:19', '2025-06-13 01:03:59', 'new title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpol', 'new title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni s', 'new title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni sa na merge ni janpolnew title ni s', '', '4', '', '1638482254,1421744535,539348499,1086249761,1491190329,1392587064,1719876343,879194746'),
(135, '1491190329', 'iquen', 'marba', 'main updated merge janpol', '', 'rev_684b02906bad55.78279779.pdf', '1426418352', 'continue', '2025-06-12 17:51:13', '2025-06-13 00:39:07', 'main updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpol', 'main updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpol', 'main updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpolmain updated merge janpol', '', '4', '', '182184128,1638482254,1421744535,539348499,1086249761,879194746'),
(136, '1491190329', 'iquen', 'marba', 'roxanne demo', '', 'rev_684ae478b091a6.27654965.pdf', '1426418352', 'approved', '2025-06-12 22:21:50', '2025-06-12 22:30:31', 'fj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj dsfsdfsdf fsdfsdfsdfsdfsddsfsdfsdfsdfsdfsdfsdffj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj   adfasfdasdfaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;fj;aksdjgfk;lsdaj;lfj dasdaklsjfj;aksdjgfk;lsdaj;lfj aklsjlfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsj', 'fj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj dsfsdfsdf fsdfsdfsdfsdfsddsfsdfsdfsdfsdfsdfsdffj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj   adfasfdasdfaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;fj;aksdjgfk;lsdaj;lfj dasdaklsjfj;aksdjgfk;lsdaj;lfj aklsjlfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsj', 'fj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj dsfsdfsdf fsdfsdfsdfsdfsddsfsdfsdfsdfsdfsdfsdffj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj   adfasfdasdfaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;fj;aksdjgfk;lsdaj;lfj dasdaklsjfj;aksdjgfk;lsdaj;lfj aklsjlfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsj', 'fj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj dsfsdfsdf fsdfsdfsdfsdfsddsfsdfsdfsdfsdfsdfsdffj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj   adfasfdasdfaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;fj;aksdjgfk;lsdaj;lfj dasdaklsjfj;aksdjgfk;lsdaj;lfj aklsjlfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj dsfsdfsdf fsdfsdfsdfsdfsddsfsdfsdfsdfsdfsdfsdffj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj   adfasfdasdfaklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;lfj aklsjfj;aksdjgfk;lsdaj;l', '4', '', '1638482254,1421744535,539348499,1086249761'),
(137, '1491190329', 'iquen', 'marba', 'why man upload title', '', 'apa_684ae4ed741c93.23428702.pdf', '1426418352', 'rejected', '2025-06-12 22:32:18', '2025-06-12 22:47:52', '', '', '', '', '0', 'mali inyo title please utro', '1638482254,1421744535,1402351309,1636419848,539348499,1086249761'),
(138, '1491190329', 'iquen', 'marba', 'shesh', '', 'apa_684aebae406f93.95419958.pdf', '1426418352', 'rejected', '2025-06-12 23:01:04', '2025-06-12 23:30:51', '', '', '', '', '0', '', '1638482254,1421744535,1402351309,1636419848,539348499,1086249761'),
(139, '1491190329', 'iquen', 'marba', 'shesh2', '', 'apa_684aebd8260e75.82795181.pdf', '1426418352', 'rejected', '2025-06-12 23:01:45', '2025-06-12 23:30:55', '', '', '', '', '0', '', '1638482254,1421744535,1402351309,1636419848,539348499,1086249761'),
(140, '1491190329', 'iquen', 'marba', 'shesh223', '', 'apa_684aebea5ab944.02030840.pdf', '1426418352', 'pending', '2025-06-12 23:02:04', '2025-06-12 23:02:04', '', '', '', '', '0', '', '1638482254,1421744535,1402351309,1636419848,539348499,1086249761'),
(141, '1491190329', 'iquen', 'marba', 'shesh22323', '', 'apa_684aebfd3768e2.70985906.pdf', '1426418352', 'pending', '2025-06-12 23:02:25', '2025-06-12 23:02:25', '', '', '', '', '0', '', '1638482254,1421744535,1402351309,1636419848,539348499,1086249761');

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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Approve` tinyint(1) DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `role` varchar(255) DEFAULT 'reviewer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`id`, `reviewer_id`, `fname`, `lname`, `email`, `pass`, `profileImg`, `created_at`, `updated`, `Approve`, `last_active`, `role`) VALUES
(1, '1732791361', 'iquen', 'marba', 'Iquen@gmail.com', '202cb962ac59075b964b07152d234b70', '', '2025-05-06 21:50:19', '2025-05-29 14:38:00', 1, NULL, 'reviewer'),
(4, '536824103', 'ben', 'laguna', 'marvin@gmail.com', '24e8c6cf22786682415147959708435b', 'noprofile.png', '2025-05-11 18:26:35', '2025-06-08 11:19:38', 1, '2025-06-08 05:19:38', 'reviewer'),
(7, '1426418352', 'iquen', 'marba', 'iquen.marba@evsu.edu.ph', 'b0ae8ca3692e32086cb546f732f17481', 'noprofile.png', '2025-05-28 03:17:35', '2025-06-12 22:19:49', 1, '2025-06-12 16:19:49', 'reviewer'),
(8, '132957139', 'kaye', 'neuvo', 'lorencapuyan@gmail.com', 'd9bbb0d9342f93c1019e42ab5ecf0e8f', 'noprofile.png', '2025-05-30 15:36:49', '2025-06-10 11:49:26', 1, NULL, 'reviewer'),
(30, '1386862220', 'iquen', 'marba', 'iquenxzx1@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'profilejuly4.jpg', '2025-06-10 02:20:27', '2025-06-10 02:24:11', 1, NULL, 'student'),
(52, '1636419848', 'Janpol', 'vasquez', 'paul@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'noprofile.png', '2025-06-13 00:27:44', '2025-06-13 00:27:44', 0, NULL, 'reviewer');

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
(40, '1402351309', 'iquen', 'marba', 'shesh title sa thesis', 'kuyaw kaayo hays', '684325d8e3ed67.83624771.pdf', '1426418352', 'Revised', '2025-06-07 01:31:04', '2025-06-07 01:31:04'),
(41, '1386862220', 'iquen', 'marba', 'test', 'test again', '6845061ea1d659.95316130.pdf', '1426418352', 'Revised', '2025-06-08 11:40:14', '2025-06-08 11:40:14'),
(42, '1386862220', 'iquen', 'marba', 'okay update it', 'yowwww yey', '68450e0a3f0d36.62454339.pdf', '1426418352', 'Revised', '2025-06-08 12:14:02', '2025-06-08 12:14:02'),
(43, '1386862220', 'iquen', 'marba', 'HAYNAKO', 'SHET KAYO', '68451325421c02.01558676.pdf', '1426418352', 'Revised', '2025-06-08 12:35:49', '2025-06-08 12:35:49'),
(44, '1386862220', 'iquen', 'marba', 'paraaa najud ni approve ', 'kayg gi kapoy nako', '684513c6787b13.12745573.pdf', '1426418352', 'Revised', '2025-06-08 12:38:30', '2025-06-08 12:38:30'),
(45, '1386862220', 'iquen', 'marba', 'title nako kay para ugma', 'yow', '68454eff115636.28373143.pdf', '1426418352', 'Revised', '2025-06-08 16:51:11', '2025-06-08 16:51:11'),
(46, '1386862220', 'iquen', 'marba', 'Online Booking and Reservation System for Public Transport Terminals', 'This project creates a centralized web-based syste', '6845d3e840e8a0.17045677.pdf', '1426418352', 'Revised', '2025-06-09 02:18:16', '2025-06-09 02:18:16'),
(47, '1386862220', 'iquen', 'marba', 'repository for all', 'shit this', '6845d76c51d506.80332065.pdf', '1426418352', 'Revised', '2025-06-09 02:33:16', '2025-06-09 02:33:16'),
(48, '1386862220', 'iquen', 'marba', 'repository for all', 'shit this', '6845d804c2d2b1.51561034.pdf', '1426418352', 'Revised', '2025-06-09 02:35:48', '2025-06-09 02:35:48'),
(49, '1386862220', 'iquen', 'marba', 'kakapoy ba nimo', 'atay ka', '6845d86e050078.00905542.pdf', '1426418352', 'Revised', '2025-06-09 02:37:34', '2025-06-09 02:37:34'),
(50, '1386862220', 'iquen', 'marba', 'fgsfdgsfdgsdfg', 'esdfgsdfgsdfgsfedgsfdg', '6845d992b96c21.79846770.pdf', '1426418352', 'Revised', '2025-06-09 02:42:26', '2025-06-09 02:42:26'),
(51, '1386862220', 'iquen', 'marba', 'kapoy nako', 'as in', '6845d9f5cfc517.21376579.pdf', '1426418352', 'Revised', '2025-06-09 02:44:05', '2025-06-09 02:44:05'),
(52, '1386862220', 'iquen', 'marba', 'kapoy nakosdadasfsdaaf', 'as infasdfasdf', '6845da3dccaf43.82782585.pdf', '1426418352', 'Revised', '2025-06-09 02:45:17', '2025-06-09 02:45:17'),
(53, '1386862220', 'iquen', 'marba', 'adasdasdas', 'asdasdasdasd', '6845db2a08a587.35841542.pdf', '1426418352', 'Revised', '2025-06-09 02:49:14', '2025-06-09 02:49:14'),
(54, '1386862220', 'iquen', 'marba', 'adasdasdasssssssssssssssssdasdasd dfsdaffasd  asdfsdfasdfasdfasdfas asdfasfasdfasfd', 'asdasdasdasd', '6845dbc3c57f74.38811442.pdf', '1426418352', 'Revised', '2025-06-09 02:51:47', '2025-06-09 02:51:47'),
(55, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile Apps', ' This research analyzes user preferences, readabil', '6845dbd3bb8ee5.25975215.pdf', '1426418352', 'Revised', '2025-06-09 02:52:03', '2025-06-09 02:52:03'),
(56, '1386862220', 'iquen', 'marba', 'adasdasdasssssssssss  ssssssdasdasd dfsdaffasd  asdfs dfasdfasdfasdfas asdfasfasdfasfd', 'asdasdasdasdadsdasdasd ad ad asdfd dsf asf asdf as', '6845dc8662b4f9.92554230.pdf', '1426418352', 'Revised', '2025-06-09 02:55:02', '2025-06-09 02:55:02'),
(57, '539348499', 'Janpol', 'vasquez', 'new title ', 'final presentation', '68466c5ed41da3.16494707.pdf', '1426418352', 'Revised', '2025-06-09 13:08:46', '2025-06-09 13:08:46'),
(58, '1386862220', 'iquen', 'marba', 'title sa proposal', '', '684833d0956522.96276466.pdf', '1426418352', 'Revised', '2025-06-10 21:32:00', '2025-06-10 21:32:00'),
(59, '1491190329', 'iquen', 'marba', 'new vtitle', '', '6849cc2ed18805.40529879.pdf', '1426418352', 'Revised', '2025-06-12 02:34:22', '2025-06-12 02:34:22'),
(60, '1491190329', 'iquen', 'marba', 'gffdgsfdgsdfg', '', '684a7bb6df80f4.89349698.pdf', '1426418352', 'Revised', '2025-06-12 15:03:18', '2025-06-12 15:03:18'),
(61, '1491190329', 'iquen', 'marba', 'main updated merge janpol', '', '684aa3966b3992.79917892.pdf', '1426418352', 'Revised', '2025-06-12 17:53:26', '2025-06-12 17:53:26'),
(62, '1491190329', 'iquen', 'marba', 'roxanne demo', '', '684ae41dc0f2c4.00803179.pdf', '1426418352', 'Revised', '2025-06-12 22:28:45', '2025-06-12 22:28:45');

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
  `failed_attempts` int(11) NOT NULL,
  `lockout_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(255) DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `fname`, `lname`, `email`, `passw`, `profileImg`, `failed_attempts`, `lockout_time`, `created_at`, `updated`, `role`) VALUES
(12, '1386862220', 'iquen', 'marba', 'iquenxzx1@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'profilejuly4.jpg', 0, NULL, '2025-05-11 18:23:40', '2025-06-10 00:11:38', 'student'),
(13, '182184128', 'ken', 'marba', 'ken1@gmail.com', '6966dbc7dd4f4feb7e2c4a92b17fe472', 'noprofile.png', 0, NULL, '2025-05-12 20:01:21', '2025-06-10 02:18:00', 'student'),
(15, '1421744535', 'roxanne', 'dalag', 'Roxanne@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'rox2.jpg', 0, NULL, '2025-05-28 02:43:23', '2025-06-09 01:26:02', 'student'),
(16, '1402351309', 'iquen', 'marba', 'iquen.marba1@evsu.edu.ph', '8858a21600ce1019aed3959de2f2bb7c', 'hahahashahd.jpg', 0, NULL, '2025-05-28 02:58:34', '2025-06-07 00:26:39', 'student'),
(20, '539348499', 'Janpol', 'vasquez', 'pol.miro@evsu.edu.ph', 'f543fe85e492cdd370734224cfb88b31', 'noprofile.png', 0, NULL, '2025-06-09 13:04:11', '2025-06-10 02:20:42', 'student'),
(23, '1086249761', 'Christian', 'Colo', 'kuya4949@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'chan.jpg', 0, NULL, '2025-06-10 21:10:37', '2025-06-10 21:10:37', 'student'),
(30, '1491190329', 'iquen', 'marba', 'iquenxzx2@gmail.com', '7b47ac8eb4422e5f85b2f23cf21517cc', 'hahahashahd.jpg', 0, NULL, '2025-06-11 20:07:41', '2025-06-13 00:28:32', 'student'),
(31, '1392587064', 'iquen', 'marba', 'iquenxzx3@gmail.com', 'f7234be6580fbd27143e3005d13aa8fe', 'noprofile.png', 1, NULL, '2025-06-12 13:16:33', '2025-06-12 17:25:32', 'student'),
(32, '1719876343', 'iquennew', 'marbanew', 'iquenxzx3@gmail.com', '9aaab865ee5fed5f4f5c491eba8c713d', 'noprofile.png', 0, NULL, '2025-06-12 13:32:41', '2025-06-12 13:43:06', 'student'),
(33, '879194746', 'Mike', 'Donaire', 'alfelorvonlaurence04@gmail.com', '2eaaab36b1b735306df4eea2e63c3c32', 'noprofile.png', 0, NULL, '2025-06-12 13:41:02', '2025-06-12 13:41:02', 'student'),
(38, '585128517', 'iquen2', 'marba2', 'iquenxzx@gmail.com', '4f7803a0be5ed87b249aaa81d5a30760', 'noprofile.png', 0, NULL, '2025-06-12 17:16:51', '2025-06-12 17:16:51', 'student'),
(39, '1638482254', 'Kathy', 'Geses', 'Kathy@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'kat.jpg', 0, NULL, '2025-06-13 01:30:40', '2025-06-13 01:30:40', 'reviewer');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `super_admin_id` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `super_admin_id`, `fname`, `lname`, `email`, `pass`, `created_at`, `updated_at`) VALUES
(1, 'SADM001', 'Super', 'Admin', 'superadmin@gmail.com', '90bbb23d2b633ac4b95bcee603286e67', '2025-06-12 10:11:01', '2025-06-12 10:11:01');

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
(43, 66, '1386862220', 5, '683f08c0c6dd04.93259276.pdf', '1426418352', '2025-06-03 22:37:52', 'Revised', ''),
(44, 68, '1386862220', 1, '683f08d6c6c4d0.74920631.pdf', '1426418352', '2025-06-03 22:38:14', 'Revised', ''),
(45, 69, '1386862220', 1, '683f120aa98b57.36197732.pdf', '1426418352', '2025-06-03 23:17:30', 'Revised', ''),
(46, 75, '1402351309', 1, '6843211bb5e555.40218330.pdf', '1426418352', '2025-06-07 01:10:51', 'Revised', ''),
(47, 75, '1402351309', 2, 'thesis_uploaded_1402351309_1749230015.pdf', 'iquen marba', '2025-06-07 01:13:35', 'Revised', ''),
(48, 74, '1402351309', 1, '684325d8e3ed67.83624771.pdf', '1426418352', '2025-06-07 01:31:04', 'Revised', ''),
(49, 68, '1386862220', 2, 'test_1386862220_1749353952.pdf', 'iquen marba', '2025-06-08 11:39:12', 'Revised', ''),
(50, 68, '1386862220', 3, '6845061ea1d659.95316130.pdf', '1426418352', '2025-06-08 11:40:14', 'Revised', ''),
(51, 68, '1386862220', 4, 'okay_update_it_1386862220_1749354406.pdf', 'iquen marba', '2025-06-08 11:46:46', 'Revised', ''),
(52, 68, '1386862220', 5, '68450e0a3f0d36.62454339.pdf', '1426418352', '2025-06-08 12:14:02', 'Revised', ''),
(53, 68, '1386862220', 6, 'okay_update_it_para_nani_approve_1386862220_1749356816.pdf', 'iquen marba', '2025-06-08 12:26:56', 'Revised', ''),
(54, 69, '1386862220', 2, 'Thesis_ni_von_para_approve_1386862220_1749357009.pdf', 'iquen marba', '2025-06-08 12:30:09', 'Revised', ''),
(55, 66, '1386862220', 6, 'HAYNAKO_1386862220_1749357153.pdf', 'iquen marba', '2025-06-08 12:32:33', 'Revised', ''),
(56, 66, '1386862220', 7, '68451325421c02.01558676.pdf', '1426418352', '2025-06-08 12:35:49', 'Revised', ''),
(57, 66, '1386862220', 8, 'paraaa_najud_ni_approve__1386862220_1749357485.pdf', 'iquen marba', '2025-06-08 12:38:05', 'Revised', ''),
(58, 66, '1386862220', 9, '684513c6787b13.12745573.pdf', '1426418352', '2025-06-08 12:38:30', 'Revised', ''),
(59, 66, '1386862220', 10, 'okay_done_na_1386862220_1749357536.pdf', 'iquen marba', '2025-06-08 12:38:56', 'Revised', ''),
(60, 76, '1386862220', 1, '68454eff115636.28373143.pdf', '1426418352', '2025-06-08 16:51:11', 'Revised', ''),
(61, 90, '1386862220', 1, '6845d3e840e8a0.17045677.pdf', '1426418352', '2025-06-09 02:18:16', 'Revised', ''),
(62, 90, '1386862220', 2, 'Online_Booking_and_Reservation_System_for_Public_Transport_Terminals_1386862220_1749406744.pdf', 'iquen marba', '2025-06-09 02:19:04', 'Revised', ''),
(63, 76, '1386862220', 2, 'okay_update_it_para_nani_approve_1386862220_1749406992.pdf', 'iquen marba', '2025-06-09 02:23:12', 'Revised', ''),
(64, 70, '1386862220', 1, '6845d76c51d506.80332065.pdf', '1426418352', '2025-06-09 02:33:16', 'Revised', ''),
(65, 70, '1386862220', 2, 'repository_for_all_1386862220_1749407612.pdf', 'iquen marba', '2025-06-09 02:33:32', 'Revised', ''),
(66, 70, '1386862220', 3, '6845d804c2d2b1.51561034.pdf', '1426418352', '2025-06-09 02:35:48', 'Revised', ''),
(67, 70, '1386862220', 4, 'kakapoy_ba_nimo_1386862220_1749407802.pdf', 'iquen marba', '2025-06-09 02:36:42', 'Revised', ''),
(68, 70, '1386862220', 5, '6845d86e050078.00905542.pdf', '1426418352', '2025-06-09 02:37:34', 'Revised', ''),
(69, 70, '1386862220', 6, 'Online_Booking_and_Reservation_System_for_Public_Transport_Terminals_1386862220_1749407899.pdf', 'iquen marba', '2025-06-09 02:38:19', 'Revised', ''),
(70, 92, '1386862220', 1, '6845d992b96c21.79846770.pdf', '1426418352', '2025-06-09 02:42:26', 'Revised', ''),
(71, 92, '1386862220', 2, 'kapoy_nako_1386862220_1749408197.pdf', 'iquen marba', '2025-06-09 02:43:17', 'Revised', ''),
(72, 92, '1386862220', 3, '6845d9f5cfc517.21376579.pdf', '1426418352', '2025-06-09 02:44:05', 'Revised', ''),
(73, 92, '1386862220', 4, 'kapoy_nakosdadasfsdaaf_1386862220_1749408269.pdf', 'iquen marba', '2025-06-09 02:44:29', 'Revised', ''),
(74, 92, '1386862220', 5, '6845da3dccaf43.82782585.pdf', '1426418352', '2025-06-09 02:45:17', 'Revised', ''),
(75, 92, '1386862220', 6, 'kapoy_nakosdadasfsdaafssssssssssssssssssssssssssssssssssssssssssssssssssss_1386862220_1749408332.pdf', 'iquen marba', '2025-06-09 02:45:32', 'Revised', ''),
(76, 93, '1386862220', 1, '6845db2a08a587.35841542.pdf', '1426418352', '2025-06-09 02:49:14', 'Revised', ''),
(77, 93, '1386862220', 2, 'adasdasdasssssssssssssssssdasdasd_dfsdaffasd__asdfsdfasdfasdfasdfas_asdfasfasdfasfd_1386862220_1749408579.pdf', 'iquen marba', '2025-06-09 02:49:39', 'Revised', ''),
(78, 93, '1386862220', 3, '6845dbc3c57f74.38811442.pdf', '1426418352', '2025-06-09 02:51:47', 'Revised', ''),
(79, 94, '1386862220', 1, '6845dbd3bb8ee5.25975215.pdf', '1426418352', '2025-06-09 02:52:03', 'Revised', ''),
(80, 93, '1386862220', 4, 'adasdasdasssssssssss__ssssssdasdasd_dfsdaffasd__asdfs_dfasdfasdfasdfas_asdfasfasdfasfd_1386862220_1749408755.pdf', 'iquen marba', '2025-06-09 02:52:35', 'Revised', ''),
(81, 94, '1386862220', 2, 'A_Comparative_Study_on_the_Effectiveness_of_Light_vs__Dark_Mode_Interfaces_in_Mobile_Apps_1386862220_1749408842.pdf', 'iquen marba', '2025-06-09 02:54:05', 'Revised', ''),
(82, 94, '1386862220', 3, 'A_Comparative_Study_on_the_Effectiveness_of_Light_vs__Dark_Mode_Interfaces_in_Mobile_Apps_1386862220_1749408851.pdf', 'iquen marba', '2025-06-09 02:54:11', 'Revised', ''),
(83, 93, '1386862220', 5, '6845dc8662b4f9.92554230.pdf', '1426418352', '2025-06-09 02:55:02', 'Revised', ''),
(84, 93, '1386862220', 6, 'adasdasdasssssssssss__ssssssdasdasd_dfsdaffasd__asdfs_dfasdfasdfasdfas_asdfasfasdfasfd_1386862220_1749409992.pdf', 'iquen marba', '2025-06-09 03:13:12', 'Revised', ''),
(85, 100, '539348499', 1, '68466c5ed41da3.16494707.pdf', '1426418352', '2025-06-09 13:08:46', 'Revised', ''),
(86, 111, '1386862220', 1, '684833d0956522.96276466.pdf', '1426418352', '2025-06-10 21:32:00', 'Revised', ''),
(87, 129, '1491190329', 1, '6849cc2ed18805.40529879.pdf', '1426418352', '2025-06-12 02:34:22', 'Revised', ''),
(88, 130, '1491190329', 1, '684a7bb6df80f4.89349698.pdf', '1426418352', '2025-06-12 15:03:18', 'Revised', ''),
(89, 135, '1491190329', 1, '684aa3966b3992.79917892.pdf', '1426418352', '2025-06-12 17:53:26', 'Revised', ''),
(90, 136, '1491190329', 1, '684ae41dc0f2c4.00803179.pdf', '1426418352', '2025-06-12 22:28:45', 'Revised', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `activity_log_admin`
--
ALTER TABLE `activity_log_admin`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `super_admin_id` (`super_admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `thesis_history`
--
ALTER TABLE `thesis_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `activity_log_admin`
--
ALTER TABLE `activity_log_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `publicrepo`
--
ALTER TABLE `publicrepo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `repotable`
--
ALTER TABLE `repotable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `reviewer`
--
ALTER TABLE `reviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `revise_table`
--
ALTER TABLE `revise_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `thesis_history`
--
ALTER TABLE `thesis_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
