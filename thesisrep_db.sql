-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 08:40 PM
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
(18, 'ADM002', 'Moved from student to reviewer', '2025-06-09 20:36:04');

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
(26, '1086249761', 'Christian', 'Colo', 'A Study on the Impact of Online Games on Academic Performance of High School Students', 'The research analyzes the correlation between time spent on online gaming and students\' academic outcomes, attendance, and study habits.', '6845e1d4b6d2c9.23674370.pdf', '1426418352', 'public', '2025-06-09 03:19:32', '2025-06-09 03:19:32');

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
(38, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262ba6aaca36.36749368.pdf', '536824103', 'Revised', '2025-05-16 02:00:06', '2025-06-03 19:17:43'),
(39, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262babb96ac9.84085696.pdf', '536824103', 'Revised', '2025-05-16 02:00:11', '2025-06-03 19:45:56'),
(41, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb05441a3.47039644.pdf', '536824103', 'rejected', '2025-05-16 02:00:16', '2025-06-03 19:17:24'),
(42, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb3af9c34.43393921.pdf', '536824103', 'rejected', '2025-05-16 02:00:19', '2025-05-16 02:28:22'),
(43, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb655c576.74452338.pdf', '536824103', 'rejected', '2025-05-16 02:00:22', '2025-05-16 02:28:17'),
(44, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bb9f26453.65024547.pdf', '536824103', 'rejected', '2025-05-16 02:00:25', '2025-05-16 02:28:10'),
(45, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bbce2c623.75329792.pdf', '536824103', 'rejected', '2025-05-16 02:00:28', '2025-05-16 02:27:12'),
(46, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '68262bc0db48e8.26307790.pdf', '536824103', 'approved', '2025-05-16 02:00:32', '2025-05-20 19:19:22'),
(47, '1638482254', 'ken', 'fsdfasdf', 'heyow', 'test mic test', 'heyow_1638482254_1747669270.pdf', '536824103', 'approved', '2025-05-16 02:23:57', '2025-05-20 19:31:52'),
(50, '1386862220', 'iquen', 'marba', 'iquenmarba', 'lkfhs;ladfkhjdsklfh;slkfhjhkl;sdhfsdfhsdflkhsd;laf', '6835e0809dd2f9.35926609.pdf', '536824103', 'approved', '2025-05-27 23:55:44', '2025-05-28 00:03:58'),
(51, '1386862220', 'iquen', 'marba', 'title 1', 'absdaksdh;alksaljf', 'title_1_1386862220_1748961016.pdf', '536824103', 'Pending', '2025-05-28 01:51:12', '2025-06-03 22:30:16'),
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
(63, '1386862220', 'iquen', 'marba', 'thesis ni kathy', 'abstract intro and wtf ', 'thesis_ni_kathy_1386862220_1748892780.pdf', '1426418352', 'approved', '2025-05-29 09:58:48', '2025-06-03 03:34:56'),
(64, '1386862220', 'iquen', 'marba', 'thesis ni cholo', 'abstract intro and wtf ', '6837bf6889f0a4.77250501.pdf', '1426418352', 'approved', '2025-05-29 09:59:04', '2025-05-29 12:15:59'),
(65, '1386862220', 'iquen', 'marba', 'Thesis new title ', 'blasblablahdfjlkhsdlkfjh', 'Thesis_new_title__1386862220_1748583530.pdf', '1426418352', 'approved', '2025-05-29 14:06:50', '2025-05-30 13:40:45'),
(66, '1386862220', 'iquen', 'marba', 'okay done na', 'hays AHAHAAHAH', 'okay_done_na_1386862220_1749357536.pdf', '1426418352', 'approved', '2025-05-29 14:09:35', '2025-06-08 12:39:19'),
(67, '1386862220', 'iquen', 'marba', 'test debug', 'debug abstract', 'test_debug_1386862220_1748892744.pdf', '1426418352', 'approved', '2025-05-29 14:10:46', '2025-06-03 03:34:58'),
(68, '1386862220', 'iquen', 'marba', 'okay update it para nani approve', 'yowwww yey', 'okay_update_it_para_nani_approve_1386862220_174935', '1426418352', 'rejected', '2025-05-29 14:11:40', '2025-06-08 12:35:24'),
(69, '1386862220', 'iquen', 'marba', 'Thesis ni von para approve', 'gwapo', 'Thesis_ni_von_para_approve_1386862220_1749357009.p', '1426418352', 'rejected', '2025-05-30 01:35:55', '2025-06-08 12:35:27'),
(70, '1386862220', 'iquen', 'marba', 'Online Booking and Reservation System for Public Transport Terminals', 'This project creates a centralized web-based system for bus terminals to facilitate ticket booking, seat selection, and scheduling, aimed at reducing waiting times and overcrowding.', 'Online_Booking_and_Reservation_System_for_Public_T', '1426418352', 'rejected', '2025-05-30 13:13:20', '2025-06-09 02:41:52'),
(71, '1386862220', 'iquen', 'marba', 'no', 'alsdalsd', '683960a3b69f98.35555697.pdf', '1426418352', 'approved', '2025-05-30 15:39:15', '2025-05-30 15:44:26'),
(72, '1402351309', 'iquen', 'marba', '', 'gwapo', '684316d4124f68.55349646.pdf', '1426418352', 'rejected', '2025-06-07 00:27:00', '2025-06-07 00:28:16'),
(73, '1402351309', 'iquen', 'marba', 'gwapo', 'fsdfsdf', '6843178c493491.14898958.pdf', '1426418352', 'approved', '2025-06-07 00:30:04', '2025-06-07 00:30:15'),
(74, '1402351309', 'iquen', 'marba', 'shesh title sa thesis', 'kuyaw kaayo hays', '68431bce87d794.84209049.pdf', '1426418352', 'Revised', '2025-06-07 00:48:14', '2025-06-07 01:31:04'),
(75, '1402351309', 'iquen', 'marba', 'thesis uploaded', 'heyow', 'thesis_uploaded_1402351309_1749230015.pdf', '1426418352', 'approved', '2025-06-07 01:10:23', '2025-06-07 01:13:55'),
(77, '1421744535', 'roxanne', 'dalag', 'Smart Waste Management System Using IoT Sensors', 'This study develops a smart waste monitoring syste', '6845c7fe0dbb07.64814751.pdf', '1426418352', 'approved', '2025-06-09 01:27:26', '2025-06-09 01:31:30'),
(78, '1421744535', 'roxanne', 'dalag', 'The Impact of Social Media on Academic Performance of College Students', 'This research examines how social media usage affe', '6845c84bbc46c4.23800302.pdf', '1426418352', 'rejected', '2025-06-09 01:28:43', '2025-06-09 01:31:37'),
(79, '1421744535', 'roxanne', 'dalag', 'The Impact of Social Media on Academic Performance of College Students', 'This research examines how social media usage affects the academic performance of college students, identifying both positive influences such as knowledge sharing and negative effects like reduced study time.', '6845c8b17fb260.47813326.pdf', '1426418352', 'approved', '2025-06-09 01:30:25', '2025-06-09 01:31:34'),
(80, '1421744535', 'roxanne', 'dalag', 'Design and Development of a Mobile-Based Voting System for Student Council Elections', 'This project presents a secure and user-friendly mobile application that allows students to vote electronically, aiming to increase participation and streamline election processes in academic institutions.', '6845c9bb3cbfd4.23323616.pdf', '1426418352', 'approved', '2025-06-09 01:34:51', '2025-06-09 01:36:49'),
(81, '1421744535', 'roxanne', 'dalag', '\"A Study on Cybersecurity Awareness Among Senior High School Students', 'The research evaluates the level of cybersecurity awareness among senior high school students, focusing on password hygiene, phishing threats, and social media privacy settings', '6845cc09573894.85558468.pdf', '1426418352', 'approved', '2025-06-09 01:44:41', '2025-06-09 01:47:59'),
(82, '1638482254', 'Kathy', 'Geses', 'Automated Plant Watering System Based on Soil Moisture Detection', 'The study builds an automated irrigation system using sensors to monitor soil moisture and regulate watering, promoting efficient water usage for home and small-scale farms.', '6845ce0992e8c5.82038770.pdf', '1426418352', 'approved', '2025-06-09 01:53:13', '2025-06-09 02:17:32'),
(83, '1638482254', 'Kathy', 'Geses', 'Analyzing the Effects of Online Learning on Student Engagement Post-Pandemic', 'This research investigates the impact of online learning methods on student participation and motivation, comparing data from pre- and post-pandemic education systems.', '6845ce991bb4c7.22746164.pdf', '1426418352', 'approved', '2025-06-09 01:55:37', '2025-06-09 03:13:50'),
(84, '1638482254', 'Kathy', 'Geses', 'Mobile Application for Disaster Preparedness and Emergency Response', 'The thesis proposes an all-in-one disaster preparedness app providing alerts, evacuation routes, emergency contacts, and safety tips to enhance public readiness.', '6845d06e746891.55593190.pdf', '1426418352', 'approved', '2025-06-09 02:03:26', '2025-06-09 03:13:33'),
(85, '1638482254', 'Kathy', 'Geses', 'Game-Based Learning Platform for Basic Programming Education', 'This study presents a game-based application designed to teach basic programming concepts to beginners, aiming to increase learner interest and retention.', '6845d1d0ca6515.61738639.pdf', '1426418352', 'Pending', '2025-06-09 02:09:20', '2025-06-09 02:09:20'),
(86, '1638482254', 'Kathy', 'Geses', 'Mental Health Monitoring System for College Students Using a Web Platform', ' The project develops a web-based system that allows students to self-assess their mental health, offering resources and referral options for psychological support.', '6845d207df57a1.50186337.pdf', '1426418352', 'rejected', '2025-06-09 02:10:15', '2025-06-09 03:13:46'),
(87, '1386862220', 'iquen', 'marba', 'Fingerprint-Based Attendance System for University Classrooms', 'This research designs a biometric attendance system using fingerprint recognition to ensure accurate and tamper-proof student attendance records.', '6845d2b4a1d3c9.63858417.pdf', '1426418352', 'approved', '2025-06-09 02:13:08', '2025-06-09 02:54:44'),
(88, '1386862220', 'iquen', 'marba', 'Blockchain-Based Certificate Verification System for Academic Institutions', 'The study proposes a decentralized certificate verification platform using blockchain technology to enhance security, authenticity, and accessibility of academic records.', '6845d2fb770823.65840415.pdf', '1426418352', 'rejected', '2025-06-09 02:14:19', '2025-06-09 02:18:26'),
(89, '1386862220', 'iquen', 'marba', 'An AI Chatbot for Campus Information and Student Support Services', 'This thesis develops an intelligent chatbot that assists students with campus-related queries, including schedules, deadlines, and facility directions, improving service accessibility.', '6845d324d76334.31803436.pdf', '1426418352', 'approved', '2025-06-09 02:15:00', '2025-06-09 02:17:45'),
(91, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile App', 'This research analyzes user preferences, readability, and battery consumption between light and dark modes in mobile applications, aiming to provide design recommendations for developers.', '6845d359087b48.82354095.pdf', '1426418352', 'approved', '2025-06-09 02:15:53', '2025-06-09 02:17:54'),
(93, '1386862220', 'iquen', 'marba', 'adasdasdasssssssssss  ssssssdasdasd dfsdaffasd  asdfs dfasdfasdfasdfas asdfasfasdfasfd', 'asdasdasdasdadsdasdasd ad ad asdfd dsf asf asdf asd fsdf asg fdg sdfg sdfg sdfg', 'adasdasdasssssssssss__ssssssdasdasd_dfsdaffasd__asdfs_dfasdfasdfasdfas_asdfasfasdfasfd_1386862220_1749409992.pdf', '1426418352', 'Pending', '2025-06-09 02:48:56', '2025-06-09 03:13:12'),
(94, '1386862220', 'iquen', 'marba', 'A Comparative Study on the Effectiveness of Light vs. Dark Mode Interfaces in Mobile Apps', ' This research analyzes user preferences, readability, and battery consumption between light and dark modes in mobile applications, aiming to provide design recommendations for developers.', 'A_Comparative_Study_on_the_Effectiveness_of_Light_vs__Dark_Mode_Interfaces_in_Mobile_Apps_1386862220_1749408851.pdf', '1426418352', 'approved', '2025-06-09 02:51:09', '2025-06-09 02:54:50'),
(95, '1086249761', 'Christian', 'Colo', 'Evaluating the Effects of Online Shopping on Consumer Buying Behavior in the Philippines', 'The study investigates how convenience, security, and product availability influence consumer decision-making in e-commerce platforms.', '6845e18fde6dd0.62843455.pdf', '1426418352', 'Pending', '2025-06-09 03:16:31', '2025-06-09 03:16:31'),
(96, '1086249761', 'Christian', 'Colo', 'Facial Expression Recognition System for Emotion Detection in Online Classes', 'This research develops an AI-based system that analyzes students\' facial expressions during online classes to assess engagement and emotional states.\r\n\r\n', '6845e1a5893e09.24485488.pdf', '1426418352', 'approved', '2025-06-09 03:16:53', '2025-06-09 03:19:24'),
(97, '1086249761', 'Christian', 'Colo', 'Development of a Mobile Expense Tracker App for College Students', 'The project involves creating a mobile application that helps students manage their budget and monitor spending habits through real-time expense tracking and analytics.', '6845e1c43e0139.76899962.pdf', '1426418352', 'approved', '2025-06-09 03:17:24', '2025-06-09 03:19:11'),
(98, '1086249761', 'Christian', 'Colo', 'A Study on the Impact of Online Games on Academic Performance of High School Students', 'The research analyzes the correlation between time spent on online gaming and students\' academic outcomes, attendance, and study habits.', '6845e1d4b6d2c9.23674370.pdf', '1426418352', 'approved', '2025-06-09 03:17:40', '2025-06-09 03:19:32'),
(99, '1086249761', 'Christian', 'Colo', 'Development of a Personalized Learning Management System for Programming Courses', 'This research builds a learning platform that adapts content difficulty based on students\' performance, supporting personalized learning in programming.', '6845e1e70655e7.89873723.pdf', '1426418352', 'approved', '2025-06-09 03:17:59', '2025-06-09 03:19:04'),
(100, '539348499', 'Janpol', 'vasquez', 'new title ', 'final presentation', '68466be34bd589.50146570.pdf', '1426418352', 'Revised', '2025-06-09 13:06:43', '2025-06-09 13:08:46');

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
(3, '1356694778', 'reviewer@gmail.com', 'reviewer', 'reviewer@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '', '2025-05-06 22:57:25', '2025-06-09 14:01:37', 0, NULL, 'reviewer'),
(4, '536824103', 'ben', 'laguna', 'marvin@gmail.com', '24e8c6cf22786682415147959708435b', 'noprofile.png', '2025-05-11 18:26:35', '2025-06-08 11:19:38', 1, '2025-06-08 05:19:38', 'reviewer'),
(7, '1426418352', 'iquen', 'marba', 'iquen.marba@evsu.edu.ph', 'b0ae8ca3692e32086cb546f732f17481', 'noprofile.png', '2025-05-28 03:17:35', '2025-06-09 13:07:48', 1, '2025-06-09 07:07:48', 'reviewer'),
(8, '132957139', 'kaye', 'neuvo', 'lorencapuyan@gmail.com', 'd9bbb0d9342f93c1019e42ab5ecf0e8f', 'noprofile.png', '2025-05-30 15:36:49', '2025-05-30 15:55:00', 1, NULL, 'reviewer'),
(30, '1386862220', 'iquen', 'marba', 'iquenxzx1@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'profilejuly4.jpg', '2025-06-10 02:20:27', '2025-06-10 02:24:11', 1, NULL, 'student'),
(45, '1719876343', 'iquennew', 'marbanew', 'iquenxzx@gmail.com', '9aaab865ee5fed5f4f5c491eba8c713d', 'noprofile.png', '2025-06-10 02:36:04', '2025-06-10 02:36:04', 0, NULL, 'reviewer');

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
(30, '1386862220', 'iquen', 'marba', 'thesis ni kathy', 'abstract intro and wtf ', '6839618f9d0344.75136591.pdf', '1426418352', 'Revised', '2025-05-30 15:43:11', '2025-05-30 15:43:11'),
(31, '1386862220', 'iquen', 'marba', 'test the swall alert', 'test', '683df7b942c9b7.63427446.pdf', '1426418352', 'Revised', '2025-06-03 03:12:57', '2025-06-03 03:12:57'),
(32, '1386862220', 'iquen', 'marba', 'test debug', 'debug abstract', '683df8455aff20.10030905.pdf', '1426418352', 'Revised', '2025-06-03 03:15:17', '2025-06-03 03:15:17'),
(33, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '683ed9d7714bd7.43832698.pdf', '536824103', 'Revised', '2025-06-03 19:17:43', '2025-06-03 19:17:43'),
(34, '1386862220', 'iquen', 'marba', 'title 1', 'absdaksdh;alksaljf', '683ee02a4fe3f7.06605334.pdf', '536824103', 'Revised', '2025-06-03 19:44:42', '2025-06-03 19:44:42'),
(35, '1638482254', 'ken', 'fsdfasdf', 'sheyt', 'gwapo', '683ee074126917.91577064.pdf', '536824103', 'Revised', '2025-06-03 19:45:56', '2025-06-03 19:45:56'),
(36, '1386862220', 'iquen', 'marba', 'test the swall alert', 'test', '683f08c0c6dd04.93259276.pdf', '1426418352', 'Revised', '2025-06-03 22:37:52', '2025-06-03 22:37:52'),
(37, '1386862220', 'iquen', 'marba', 'test', 'test again', '683f08d6c6c4d0.74920631.pdf', '1426418352', 'Revised', '2025-06-03 22:38:14', '2025-06-03 22:38:14'),
(38, '1386862220', 'iquen', 'marba', 'Thesis ni von', 'gwapo', '683f120aa98b57.36197732.pdf', '1426418352', 'Revised', '2025-06-03 23:17:30', '2025-06-03 23:17:30'),
(39, '1402351309', 'iquen', 'marba', 'thesis uploaded', 'heyow', '6843211bb5e555.40218330.pdf', '1426418352', 'Revised', '2025-06-07 01:10:51', '2025-06-07 01:10:51'),
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
(57, '539348499', 'Janpol', 'vasquez', 'new title ', 'final presentation', '68466c5ed41da3.16494707.pdf', '1426418352', 'Revised', '2025-06-09 13:08:46', '2025-06-09 13:08:46');

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
(14, '1638482254', 'Kathy', 'Geses', 'Kathy@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'kat.jpg', 0, NULL, '2025-05-14 02:04:44', '2025-06-09 01:56:22', 'student'),
(15, '1421744535', 'roxanne', 'dalag', 'Roxanne@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'rox2.jpg', 0, NULL, '2025-05-28 02:43:23', '2025-06-09 01:26:02', 'student'),
(16, '1402351309', 'iquen', 'marba', 'iquen.marba1@evsu.edu.ph', '8858a21600ce1019aed3959de2f2bb7c', 'hahahashahd.jpg', 0, NULL, '2025-05-28 02:58:34', '2025-06-07 00:26:39', 'student'),
(17, '1636419848', 'Janpol', 'vasquez', 'paul@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'noprofile.png', 0, NULL, '2025-05-28 03:06:14', '2025-06-09 01:24:29', 'student'),
(18, '879194746', 'Mike', 'Donaire', 'alfelorvonlaurence04@gmail.com', '2eaaab36b1b735306df4eea2e63c3c32', 'noprofile.png', 0, NULL, '2025-05-30 15:51:25', '2025-05-30 15:51:25', 'student'),
(19, '1086249761', 'Christian', 'Colo', 'kuya4949@gmail.com', '8858a21600ce1019aed3959de2f2bb7c', 'chan.jpg', 0, NULL, '2025-06-09 00:39:40', '2025-06-10 02:20:41', 'student'),
(20, '539348499', 'Janpol', 'vasquez', 'pol.miro@evsu.edu.ph', 'f543fe85e492cdd370734224cfb88b31', 'noprofile.png', 0, NULL, '2025-06-09 13:04:11', '2025-06-10 02:20:42', 'student');

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
(32, 63, '1386862220', 4, '6839618f9d0344.75136591.pdf', '1426418352', '2025-05-30 15:43:11', 'Revised', ''),
(33, 66, '1386862220', 3, '683df7b942c9b7.63427446.pdf', '1426418352', '2025-06-03 03:12:57', 'Revised', ''),
(34, 67, '1386862220', 1, '683df8455aff20.10030905.pdf', '1426418352', '2025-06-03 03:15:17', 'Revised', ''),
(35, 66, '1386862220', 4, 'test_the_swall_alert_1386862220_1748892638.pdf', 'iquen marba', '2025-06-03 03:30:38', 'Revised', ''),
(36, 67, '1386862220', 2, 'test_debug_1386862220_1748892737.pdf', 'iquen marba', '2025-06-03 03:32:17', 'Revised', ''),
(37, 67, '1386862220', 3, 'test_debug_1386862220_1748892744.pdf', 'iquen marba', '2025-06-03 03:32:24', 'Revised', ''),
(38, 63, '1386862220', 5, 'thesis_ni_kathy_1386862220_1748892780.pdf', 'iquen marba', '2025-06-03 03:33:00', 'Revised', ''),
(39, 38, '1638482254', 1, '683ed9d7714bd7.43832698.pdf', '536824103', '2025-06-03 19:17:43', 'Revised', ''),
(40, 51, '1386862220', 1, '683ee02a4fe3f7.06605334.pdf', '536824103', '2025-06-03 19:44:42', 'Revised', ''),
(41, 39, '1638482254', 1, '683ee074126917.91577064.pdf', '536824103', '2025-06-03 19:45:56', 'Revised', ''),
(42, 51, '1386862220', 2, 'title_1_1386862220_1748961016.pdf', 'iquen marba', '2025-06-03 22:30:16', 'Revised', ''),
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
(85, 100, '539348499', 1, '68466c5ed41da3.16494707.pdf', '1426418352', '2025-06-09 13:08:46', 'Revised', '');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `thesis_history`
--
ALTER TABLE `thesis_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log_admin`
--
ALTER TABLE `activity_log_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `publicrepo`
--
ALTER TABLE `publicrepo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `repotable`
--
ALTER TABLE `repotable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `reviewer`
--
ALTER TABLE `reviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `revise_table`
--
ALTER TABLE `revise_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `thesis_history`
--
ALTER TABLE `thesis_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
