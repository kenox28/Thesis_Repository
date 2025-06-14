CREATE TABLE `activity_logs` (
  `log_id` int AUTO_INCREMENT PRIMARY KEY,
  `user_id` varchar(255),
  `user_type` enum('admin','super_admin'),
  `action_type` varchar(50),
  `description` text,
  `ip_address` varchar(45),
  `created_at` timestamp
);

CREATE TABLE `activity_log_admin` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `admin_id` varchar(255),
  `activity` varchar(255),
  `date` datetime
);

CREATE TABLE `admin` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `admin_id` varchar(255) UNIQUE,
  `fname` varchar(50),
  `lname` varchar(50),
  `email` varchar(50) UNIQUE,
  `pass` varchar(255),
  `created_at` datetime,
  `updated_at` datetime,
  `profileImg` varchar(255)
);

CREATE TABLE `publicrepo` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `student_id` varchar(50),
  `fname` varchar(50),
  `lname` varchar(50),
  `title` varchar(255),
  `abstract` varchar(255),
  `ThesisFile` varchar(255),
  `reviewer_id` varchar(255),
  `Privacy` varchar(255),
  `created_at` datetime,
  `updated` datetime
);

CREATE TABLE `repotable` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `student_id` varchar(50),
  `fname` varchar(50),
  `lname` varchar(50),
  `title` varchar(255),
  `abstract` varchar(255),
  `ThesisFile` varchar(255),
  `reviewer_id` varchar(255),
  `status` varchar(50),
  `created_at` datetime,
  `updated` datetime,
  `introduction` varchar(1000),
  `Project_objective` varchar(1000),
  `significance_of_study` varchar(1000),
  `system_analysis_and_design` varchar(1000),
  `Chapter` varchar(1000),
  `message` varchar(1000),
  `members_id` varchar(1000)
);

CREATE TABLE `reviewer` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `reviewer_id` varchar(255),
  `fname` varchar(50),
  `lname` varchar(50),
  `email` varchar(50),
  `pass` varchar(50),
  `profileImg` varchar(255),
  `created_at` datetime,
  `updated` datetime,
  `Approve` tinyint(1),
  `last_active` datetime,
  `role` varchar(255)
);

CREATE TABLE `revise_table` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `student_id` varchar(50),
  `fname` varchar(50),
  `lname` varchar(50),
  `title` varchar(255),
  `abstract` varchar(50),
  `ThesisFile` varchar(50),
  `reviewer_id` varchar(255),
  `status` varchar(50),
  `created_at` datetime,
  `updated` datetime
);

CREATE TABLE `student` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `student_id` varchar(255),
  `fname` varchar(50),
  `lname` varchar(50),
  `email` varchar(50),
  `passw` varchar(50),
  `profileImg` varchar(255),
  `failed_attempts` int,
  `lockout_time` datetime,
  `created_at` datetime,
  `updated` datetime,
  `role` varchar(255)
);

CREATE TABLE `super_admin` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `super_admin_id` varchar(255) UNIQUE,
  `fname` varchar(50),
  `lname` varchar(50),
  `email` varchar(50) UNIQUE,
  `pass` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `thesis_history` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `thesis_id` int,
  `student_id` varchar(50),
  `revision_num` int,
  `file_name` varchar(255),
  `revised_by` varchar(255),
  `revised_at` datetime,
  `status` varchar(50),
  `notes` text
);
