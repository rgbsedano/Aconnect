-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 11:56 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aconnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `alumni_id`, `activity`, `created_at`) VALUES
(26, 2, 'Logged out', '2025-04-30 08:24:18'),
(27, 1, 'Logged in', '2025-04-30 08:26:43'),
(28, 1, 'Logged in', '2025-04-30 08:46:17'),
(29, 1, 'Logged out', '2025-04-30 08:55:04'),
(30, 1, 'Logged in', '2025-04-30 08:55:12'),
(31, 1, 'Logged out', '2025-04-30 10:44:25'),
(32, 1, 'Logged in', '2025-04-30 10:56:00'),
(33, 1, 'Logged in', '2025-04-30 10:57:03'),
(34, 1, 'Logged in', '2025-04-30 10:57:30'),
(35, 1, 'Logged out', '2025-04-30 11:01:17'),
(36, 1, 'Logged in', '2025-04-30 11:01:33'),
(37, 1, 'Logged in', '2025-05-02 02:04:01'),
(38, 1, 'Logged out', '2025-05-02 02:09:44'),
(39, 1, 'Logged in', '2025-05-02 02:13:11'),
(40, 1, 'Updated his/her Profile', '2025-05-02 02:36:41'),
(41, 1, 'Logged in', '2025-05-02 06:23:00'),
(42, 1, 'Logged out', '2025-05-02 06:24:47'),
(43, 1, 'Logged in', '2025-05-02 06:26:57'),
(44, 1, 'Logged out', '2025-05-02 06:38:52'),
(45, 1, 'Logged in', '2025-05-02 06:38:58'),
(46, 1, 'Logged out', '2025-05-02 07:01:29'),
(47, 1, 'Logged in', '2025-05-02 09:01:10'),
(48, 1, 'Logged out', '2025-05-02 09:11:47'),
(49, 1, 'Logged in', '2025-05-02 09:11:54'),
(50, 1, 'Logged out', '2025-05-02 09:11:59'),
(51, 1, 'Logged in', '2025-05-02 09:14:27'),
(52, 1, 'Logged out', '2025-05-02 09:18:42'),
(53, 1, 'Logged in', '2025-05-02 10:29:39'),
(54, 1, 'Logged out', '2025-05-02 10:30:41'),
(55, 1, 'Logged in', '2025-05-02 11:02:14'),
(56, 1, 'Logged out', '2025-05-02 11:16:21'),
(57, 1, 'Logged in', '2025-05-02 11:59:31'),
(58, 1, 'Logged out', '2025-05-02 12:18:28'),
(59, 1, 'Logged in', '2025-05-02 16:20:47'),
(60, 1, 'Logged out', '2025-05-02 16:22:54'),
(61, 1, 'Logged in', '2025-05-02 16:26:23'),
(62, 1, 'Register to an event', '2025-05-02 16:28:22'),
(63, 1, 'Register to an event', '2025-05-02 16:28:40'),
(64, 1, 'Logged out', '2025-05-02 16:28:43'),
(65, 1, 'Logged in', '2025-05-04 02:01:06'),
(66, 1, 'Updated his/her Profile', '2025-05-04 02:51:14'),
(67, 1, 'Logged in', '2025-05-04 03:28:36'),
(68, 1, 'Logged in', '2025-05-04 03:28:52'),
(69, 1, 'Logged out', '2025-05-04 04:58:43'),
(70, 15, 'Logged in', '2025-05-04 04:58:48'),
(71, 15, 'Logged out', '2025-05-04 04:58:59'),
(72, 1, 'Logged in', '2025-05-04 04:59:05'),
(73, 1, 'Logged in', '2025-05-04 05:42:02'),
(74, 1, 'Logged in', '2025-05-04 16:26:20'),
(75, 1, 'Updated his/her Profile', '2025-05-04 16:54:54'),
(76, 1, 'Updated his/her Profile', '2025-05-04 16:55:12'),
(77, 1, 'Updated his/her Profile', '2025-05-04 16:55:19'),
(78, 1, 'Updated his/her Profile', '2025-05-04 16:55:27'),
(79, 1, 'Updated his/her Profile', '2025-05-04 16:55:31'),
(80, 1, 'Updated his/her Profile', '2025-05-04 16:57:19'),
(81, 1, 'Logged out', '2025-05-04 16:57:34'),
(82, 1, 'Logged in', '2025-05-04 16:57:44'),
(83, 1, 'Logged out', '2025-05-04 17:01:46'),
(84, 15, 'Logged in', '2025-05-04 17:02:22'),
(85, 15, 'Logged out', '2025-05-04 17:02:36'),
(86, 2, 'Logged in', '2025-05-04 17:02:43'),
(87, 2, 'Logged out', '2025-05-04 17:03:02'),
(88, 17, 'Logged in', '2025-05-04 17:04:05'),
(89, 17, 'Logged out', '2025-05-04 17:05:50'),
(90, 1, 'Logged in', '2025-05-04 17:05:59'),
(91, 1, 'Logged out', '2025-05-04 17:18:08'),
(92, 1, 'Logged in', '2025-05-04 22:02:04'),
(93, 1, 'Logged out', '2025-05-04 22:02:06'),
(94, 1, 'Logged in', '2025-05-04 22:24:21'),
(95, 1, 'Logged out', '2025-05-04 22:33:21'),
(96, 1, 'Logged in', '2025-05-05 10:39:03'),
(97, 1, 'Logged out', '2025-05-05 11:16:27'),
(98, 1, 'Logged in', '2025-05-05 11:34:55'),
(99, 1, 'Logged out', '2025-05-05 11:40:32'),
(100, 1, 'Logged in', '2025-05-05 12:02:07'),
(101, 1, 'Logged out', '2025-05-05 12:12:29'),
(102, 1, 'Logged in', '2025-05-05 13:08:51'),
(103, 1, 'Logged out', '2025-05-05 13:36:35'),
(104, 1, 'Logged in', '2025-05-05 13:43:42'),
(105, 1, 'Logged out', '2025-05-05 14:16:26'),
(106, 1, 'Logged in', '2025-05-05 14:17:23'),
(107, 1, 'Logged in', '2025-05-05 20:40:21'),
(108, 1, 'Logged in', '2025-05-14 14:21:23'),
(109, 1, 'Updated his/her Profile', '2025-05-14 14:21:40'),
(110, 1, 'Updated his/her Profile', '2025-05-14 14:22:13'),
(111, 1, 'Register to an event', '2025-05-14 14:22:55'),
(112, 1, 'Applied for a job', '2025-05-14 14:23:14'),
(113, 1, 'Logged out', '2025-05-14 14:23:38'),
(114, 1, 'Logged in', '2025-05-14 14:26:08'),
(115, 1, 'Updated his/her Profile', '2025-05-14 14:27:14'),
(116, 1, 'Logged out', '2025-05-14 14:36:22'),
(117, 15, 'Logged in', '2025-05-14 15:00:45'),
(118, 15, 'Applied for a job', '2025-05-14 15:01:52'),
(119, 15, 'Register to an event', '2025-05-14 15:02:07'),
(120, 15, 'Logged out', '2025-05-14 15:02:41'),
(121, 1, 'Logged in', '2025-06-04 10:42:01'),
(122, 1, 'Applied for a job', '2025-06-04 10:42:59'),
(123, 1, 'Logged out', '2025-06-04 10:46:35'),
(124, 2, 'Logged in', '2025-06-04 10:48:09'),
(125, 2, 'Logged out', '2025-06-04 10:48:33'),
(126, 2, 'Logged in', '2025-06-07 19:02:08'),
(127, 2, 'Updated his/her Profile', '2025-06-07 19:22:44'),
(128, 2, 'Updated his/her Profile', '2025-06-07 19:23:32'),
(129, 2, 'Updated his/her Profile', '2025-06-07 19:34:36'),
(130, 2, 'Updated his/her Profile', '2025-06-07 19:39:14'),
(131, 2, 'Updated his/her Profile', '2025-06-07 19:39:28'),
(132, 2, 'Updated his/her Profile', '2025-06-07 19:39:54'),
(133, 2, 'Logged out', '2025-06-07 19:57:04'),
(134, 2, 'Logged in', '2025-06-07 19:57:12'),
(135, 2, 'Logged in', '2025-06-16 16:14:12'),
(136, 2, 'Updated his/her Profile', '2025-06-16 16:15:10'),
(137, 2, 'Logged in', '2025-06-16 18:56:01'),
(138, 2, 'Logged out', '2025-06-16 18:56:36'),
(139, 2, 'Logged in', '2025-06-16 18:58:49'),
(140, 2, 'Logged out', '2025-06-16 18:59:39'),
(141, 2, 'Logged in', '2025-06-16 18:59:45'),
(142, 2, 'Logged out', '2025-06-16 19:00:01'),
(143, 2, 'Logged in', '2025-06-16 19:01:12'),
(144, 2, 'Updated his/her Profile', '2025-06-16 19:07:38'),
(145, 2, 'Updated his/her Profile', '2025-06-16 19:07:41'),
(146, 2, 'Logged out', '2025-06-16 19:15:17'),
(147, 2, 'Logged in', '2025-06-16 19:15:34'),
(148, 2, 'Register to an event', '2025-06-16 19:15:43'),
(149, 2, 'Register to an event', '2025-06-16 19:15:45'),
(150, 2, 'Register to an event', '2025-06-16 19:16:14'),
(151, 2, 'Logged in', '2025-06-16 20:37:46'),
(152, 2, 'Logged out', '2025-06-16 20:37:48'),
(153, 1, 'Logged in', '2025-06-16 20:37:56'),
(154, 1, 'Logged out', '2025-06-16 20:38:11'),
(155, 1, 'Logged in', '2025-06-16 21:55:48'),
(156, 1, 'Logged in', '2025-06-17 01:27:15'),
(157, 1, 'Applied for a job', '2025-06-17 01:27:26'),
(158, 1, 'Logged out', '2025-06-17 01:27:36'),
(159, 2, 'Logged in', '2025-06-17 01:32:57'),
(160, 2, 'Applied for a job', '2025-06-17 01:33:06'),
(161, 2, 'Logged out', '2025-06-17 01:34:41'),
(162, 2, 'Logged in', '2025-06-17 03:35:18'),
(163, 2, 'Logged out', '2025-06-17 03:42:10'),
(164, 33, 'Logged in', '2025-06-17 03:42:33'),
(165, 33, 'Logged out', '2025-06-17 03:43:19'),
(169, 2, 'Logged in', '2025-06-17 03:50:23'),
(170, 1, 'Logged in', '2025-06-17 10:39:40'),
(171, 1, 'Logged out', '2025-06-17 10:42:10'),
(172, 1, 'Logged in', '2025-06-17 10:47:29'),
(173, 1, 'Logged in', '2025-06-17 10:50:24'),
(174, 1, 'Logged out', '2025-06-17 10:50:33'),
(175, 1, 'Logged in', '2025-06-17 10:57:13'),
(176, 1, 'Logged out', '2025-06-17 10:57:18'),
(177, 35, 'Logged in', '2025-06-17 11:30:21'),
(178, 35, 'Updated his/her Profile', '2025-06-17 11:39:18'),
(179, 2, 'Logged in', '2025-06-17 11:49:58'),
(180, 2, 'Logged out', '2025-06-17 11:54:42'),
(181, 2, 'Logged in', '2025-07-29 19:18:45'),
(182, 2, 'Logged out', '2025-07-29 19:21:05'),
(183, 2, 'Logged in', '2025-07-29 19:26:25'),
(184, 2, 'Logged out', '2025-07-29 19:27:15'),
(185, 15, 'Logged in', '2025-11-21 21:46:00'),
(186, 15, 'Logged out', '2025-11-21 21:46:07'),
(187, 15, 'Logged in', '2025-11-21 23:38:45'),
(188, 15, 'Logged out', '2025-11-21 23:39:00'),
(189, 2, 'Logged in', '2025-11-21 23:39:21'),
(190, 2, 'Logged out', '2025-11-21 23:39:45'),
(191, 2, 'Logged in', '2025-11-21 23:40:46'),
(192, 2, 'Logged out', '2025-11-21 23:41:15'),
(193, 15, 'Logged in', '2025-11-22 11:50:41'),
(194, 15, 'Updated his/her Profile', '2025-11-22 11:50:57'),
(195, 15, 'Logged out', '2025-11-22 11:54:33'),
(196, 15, 'Logged in', '2025-11-22 11:54:46'),
(197, 15, 'Logged out', '2025-11-22 11:55:44'),
(198, 1, 'Logged in', '2025-11-25 22:03:13'),
(199, 1, 'Logged out', '2025-11-25 22:03:50'),
(200, 17, 'Logged in', '2025-11-25 22:04:35'),
(201, 17, 'Logged out', '2025-11-25 22:05:25'),
(202, 1, 'Logged in', '2025-11-25 22:05:37'),
(203, 1, 'Logged out', '2025-11-25 22:06:57'),
(204, 1, 'Logged in', '2025-11-25 22:08:04'),
(205, 1, 'Logged out', '2025-11-25 22:12:37'),
(206, 15, 'Logged in', '2025-12-03 22:53:32'),
(207, 15, 'Logged out', '2025-12-03 22:55:42'),
(208, 1, 'Logged in', '2025-12-04 00:06:58'),
(209, 1, 'Logged out', '2025-12-04 00:09:37'),
(210, 1, 'Logged in', '2025-12-04 00:10:18'),
(211, 1, 'Logged out', '2025-12-04 00:10:43'),
(212, 15, 'Logged in', '2025-12-04 00:40:05'),
(213, 15, 'Logged out', '2025-12-04 00:40:51'),
(214, 15, 'Logged in', '2025-12-04 01:32:17'),
(215, 15, 'Updated his/her Profile', '2025-12-04 01:34:43'),
(216, 15, 'Updated his/her Profile', '2025-12-04 01:34:45'),
(217, 15, 'Logged out', '2025-12-04 01:38:22'),
(218, 1, 'Logged in', '2025-12-04 01:42:56'),
(219, 1, 'Logged out', '2025-12-04 02:10:19'),
(220, 1, 'Logged in', '2025-12-04 02:23:33'),
(221, 1, 'Logged out', '2025-12-04 03:09:52'),
(222, 1, 'Logged out', '2025-12-11 12:50:56'),
(225, 1, 'Logged in', '2025-12-12 13:12:47'),
(226, 1, 'Logged out', '2025-12-12 13:24:19'),
(227, 1, 'Logged in', '2025-12-12 13:24:27'),
(228, 1, 'Logged out', '2025-12-12 13:57:23'),
(229, 1, 'Logged in', '2025-12-12 13:57:34'),
(230, 1, 'Logged out', '2025-12-12 15:02:28'),
(231, 15, 'Logged in', '2025-12-12 15:02:48'),
(232, 15, 'Updated his/her Profile', '2025-12-12 15:03:35'),
(233, 15, 'Logged out', '2025-12-12 15:03:49'),
(234, 1, 'Logged in', '2025-12-12 15:04:59'),
(235, 15, 'Logged in', '2025-12-12 15:41:32'),
(236, 15, 'Logged out', '2025-12-12 15:41:50'),
(237, 15, 'Logged in', '2025-12-12 15:44:36'),
(238, 15, 'Logged out', '2025-12-12 15:46:30'),
(239, 45, 'Logged out', '2025-12-12 17:16:57'),
(240, 45, 'Logged out', '2025-12-12 17:19:56'),
(241, 45, 'Logged out', '2025-12-12 17:51:52'),
(242, 45, 'Logged out', '2025-12-12 17:52:28'),
(243, 45, 'Logged out', '2025-12-12 18:46:08'),
(244, 44, 'Logged out', '2025-12-12 18:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `created_at`, `last_login`, `first_name`, `last_name`) VALUES
(1, 'admin123', 'admin123@gmail.com', '$2y$10$B4zULLnxkTflCFw4xNefV.pd9XzSXS4iB/jEqn7bDp4wUqPGo9MAS', '2025-04-21 10:16:04', '2025-11-21 17:55:02', 'admin', 'name');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `alumni_number` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `alternative_email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `alternative_phone` varchar(20) DEFAULT NULL,
  `graduation_year` int(11) DEFAULT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'inactive',
  `current_job` varchar(100) DEFAULT NULL,
  `current_job_organization` varchar(150) DEFAULT NULL,
  `current_job_length` varchar(50) DEFAULT NULL,
  `soft_skills` text DEFAULT NULL,
  `technical_skills` text DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(128) DEFAULT NULL,
  `verification_sent_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `alumni_number`, `first_name`, `last_name`, `gender`, `email`, `alternative_email`, `password`, `phone`, `alternative_phone`, `graduation_year`, `degree`, `profile_image`, `student_number`, `last_login`, `status`, `current_job`, `current_job_organization`, `current_job_length`, `soft_skills`, `technical_skills`, `school`, `created_at`, `email_verified`, `verification_token`, `verification_sent_at`) VALUES
(1, 'A2020-1034', 'Rg', 'sedano', 'male', 'rgsedano@gmail.com', NULL, '$2y$10$q9N0zFSsz5S7F.0akf3VreasmsfnGr29YJXEAbQdiqU79v7wDkfMu', '09952341640', NULL, 2020, 'BSIT', '680b3ba0d34c2_ako.jpg', '201313476', '2025-12-12 00:04:59', 'active', '', '', '', '', '', 'St. Dominic', '2025-04-21 11:33:02', 0, NULL, NULL),
(2, 'A2024-1236', 'Argie', 'Sedano', 'male', 'argiesedano@gmail.com', NULL, '$2y$10$aBwmkt5wxOOzGrjMzQF3lulFl0.KCjeFpAIG2uSDnv1rHSNryS1Eu', '09952341640', NULL, 2024, 'BS Information Technology', '68116bce22ee0_akodin.jpg', '202402271', '2025-11-21 08:40:46', 'active', '', '', '', '', '', NULL, '2025-04-21 11:46:03', 0, NULL, NULL),
(6, 'A2024-2345', 'gie', 'sedano', 'male', 'giesedano@gmail.com', NULL, '$2y$10$bW8Uy2CbWxeeSg/c8JGsyexijQLWUjbAEmn7CLQ3.hUH2hxbpfoMy', '09952341640', NULL, 2024, 'BS Information Technology', NULL, '2024131331', '2025-06-16 11:09:21', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-23 00:52:35', 0, NULL, NULL),
(15, 'A2024-1234', 'Pierce', 'estudillo', 'male', 'pirs@gmail.com', NULL, '$2y$10$mc4//91uzF7XWl3pNEMc5e6RioDJD0TJgZ5KXjnhQeCvEsGfIhYQy', '182903812', NULL, 2024, 'BS INFORMATION TECHNOLOGY', '693bbe47569da_akodin.jpg', '2024101010', '2025-12-12 00:44:36', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-23 22:44:35', 0, NULL, NULL),
(17, 'A2013-7654', 'sharmaine', 'arias', 'female', 'sha@gmail.com', NULL, '$2y$10$2RVdI15VCEfVB2DzrkAkQuwGKFNBsaU79Cya.3fubAEDi.uXXQWKK', '09999999999', NULL, 2023, 'BS Accountancy', NULL, '201913477', '2025-11-25 07:04:35', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-25 04:42:57', 0, NULL, NULL),
(18, 'ALU-0001', 'John', 'Doe', 'male', 'john.doe@example.com', 'john.alt@example.com', 'hashed_password_1', '09171234567', '09987654321', 2018, 'BS Computer Science', NULL, '20181234', '2025-05-04 14:27:37', 'active', 'Software Developer', 'Tech Corp', '2 years', 'Teamwork, Communication', 'Java, PHP, SQL', 'ABC University', '2025-05-04 12:02:10', 0, NULL, NULL),
(19, 'ALU-0002', 'Jane', 'Smith', 'female', 'jane.smith@example.com', 'jane.alt@example.com', 'hashed_password_2', '09181234567', '09986543210', 2017, 'BS Information Technology', NULL, '20171234', '2025-05-04 14:28:37', 'active', 'System Analyst', 'Solutions Inc.', '3 years', 'Leadership, Critical Thinking', 'Python, JavaScript, HTML/CSS', 'XYZ University', '2025-05-04 12:02:10', 0, NULL, NULL),
(20, 'ALU-0003', 'Alex', 'Reyes', 'other', 'alex.reyes@example.com', 'alex.alt@example.com', 'hashed_password_3', '09192223333', '09190001122', 2020, 'BS Information Systems', NULL, '20201234', '2025-05-04 14:28:42', 'inactive', 'IT Consultant', 'Consultify', '1 year', 'Adaptability, Creativity', 'React, Node.js, MongoDB', 'DEF College', '2025-05-04 12:02:10', 0, NULL, NULL),
(21, 'ALU-0004', 'Maria', 'Lopez', 'female', 'maria.lopez@example.com', 'maria.alt@example.com', 'hashed_password_4', '09173456789', '09228889999', 2016, 'BS Computer Engineering', NULL, '20163456', '2025-05-04 14:28:41', 'active', 'DevOps Engineer', 'CloudNet', '4 years', 'Problem Solving, Teamwork', 'Docker, Kubernetes, Python', 'LMN University', '2025-05-04 12:02:10', 0, NULL, NULL),
(22, 'ALU-0005', 'Carlos', 'Santos', 'male', 'carlos.santos@example.com', 'carlos.alt@example.com', 'hashed_password_5', '09175554444', '09334445555', 2019, 'BS Electronics Engineering', NULL, '20194567', '2025-05-04 14:28:44', 'inactive', 'Network Engineer', 'Telecom PH', '2.5 years', 'Attention to Detail, Communication', 'Cisco, Linux, Network Security', 'GHI College', '2025-05-04 12:02:10', 0, NULL, NULL),
(23, 'ALU-0006', 'Emily', 'Johnson', 'female', 'emily.johnson@example.com', 'emily.alt@example.com', 'hashed_password_6', '09173334455', '09190002233', 2015, 'BS Civil Engineering', NULL, '20152345', '2025-05-04 14:28:50', 'active', 'Project Manager', 'BuildTech Ltd.', '5 years', 'Leadership, Time Management', 'AutoCAD, Project Management', 'JKL University', '2025-05-04 13:54:04', 0, NULL, NULL),
(24, 'ALU-0007', 'Michael', 'Garcia', 'male', 'michael.garcia@example.com', 'michael.alt@example.com', 'hashed_password_7', '09223334455', '09178889999', 2021, 'BS Marketing', NULL, '20212345', '2025-05-04 14:28:48', 'inactive', 'Marketing Specialist', 'BrandLab', '1 year', 'Creative Thinking, Communication', 'SEO, Social Media Marketing', 'MNO University', '2025-05-04 13:54:04', 0, NULL, NULL),
(25, 'ALU-0008', 'Sophia', 'Martinez', 'female', 'sophia.martinez@example.com', 'sophia.alt@example.com', 'hashed_password_8', '09182223344', '09221122334', 2014, 'BS Architecture', NULL, '20141098', '2025-05-04 14:28:52', 'active', 'Architect', 'UrbanDesigns', '6 years', 'Attention to Detail, Negotiation', 'AutoCAD, Revit', 'PQR University', '2025-05-04 13:54:04', 0, NULL, NULL),
(26, 'ALU-0009', 'David', 'Taylor', 'male', 'david.taylor@example.com', 'david.alt@example.com', 'hashed_password_9', '09224445566', '09335567788', 2018, 'BS Electrical Engineering', NULL, '20187564', '2025-05-04 14:29:07', 'active', 'Electrical Engineer', 'PowerGrid Co.', '2 years', 'Analytical Thinking, Teamwork', 'MATLAB, Circuit Design', 'STU University', '2025-05-04 13:54:04', 0, NULL, NULL),
(28, 'ALU-0011', 'Lucas', 'Miller', 'male', 'lucas.miller@example.com', 'lucas.alt@example.com', 'hashed_password_11', '09172223344', '09223334411', 2017, 'BS Computer Science', NULL, '20176543', '2025-05-04 14:29:02', 'active', 'Full Stack Developer', 'TechWorks', '3 years', 'Collaboration, Adaptability', 'React, Node.js, MongoDB', 'XYZ University', '2025-05-04 13:54:04', 0, NULL, NULL),
(29, 'ALU-0012', 'Charlotte', 'Wilson', 'female', 'charlotte.wilson@example.com', 'charlotte.alt@example.com', 'hashed_password_12', '09221122333', '09332223344', 2019, 'BS Biochemistry', NULL, '20192222', '2025-05-04 14:29:00', 'active', 'Research Scientist', 'BioTech Labs', '2 years', 'Analytical Thinking, Problem Solving', 'Lab Techniques, PCR', 'ABC University', '2025-05-04 13:54:04', 0, NULL, NULL),
(30, 'ALU-0013', 'James', 'Moore', 'male', 'james.moore@example.com', 'james.alt@example.com', 'hashed_password_13', '09172233444', '09223334455', 2021, 'BS Environmental Science', NULL, '20213456', '2025-05-04 14:28:58', 'inactive', 'Environmental Consultant', 'GreenWorks', '1 year', 'Sustainability, Communication', 'GIS, Environmental Impact Analysis', 'LMN University', '2025-05-04 13:54:04', 0, NULL, NULL),
(31, 'ALU-0014', 'Ava', 'Taylor', 'female', 'ava.taylor@example.com', 'ava.alt@example.com', 'hashed_password_14', '09223334466', '09337778888', 2016, 'BS Finance', NULL, '20167890', '2025-05-04 14:28:56', 'active', 'Financial Analyst', 'InvestPro', '4 years', 'Financial Analysis, Negotiation', 'Excel, Financial Modeling', 'OPQ University', '2025-05-04 13:54:04', 0, NULL, NULL),
(32, 'ALU-0015', 'Ethan', 'Anderson', 'male', 'ethan.anderson@example.com', 'ethan.alt@example.com', 'hashed_password_15', '09174445566', '09223334477', 2019, 'BS Physics', NULL, '20191111', '2025-05-04 14:28:54', 'inactive', 'Data Scientist', 'DataSoft', '2 years', 'Critical Thinking, Communication', 'Python, R, SQL', 'XYZ University', '2025-05-04 13:54:04', 0, NULL, NULL),
(33, 'A2025-1234', 'Ina', 'De Borja', 'female', 'Ina@gmail.com', NULL, '$2y$10$Lqybqm5GW0IAA9JCa/ZEMO7sHju3RxGiIHO74W8R43DRixchqExGK', '09191234759', NULL, 2025, 'BSIT', NULL, '202130495', '2025-06-16 19:49:26', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-16 19:27:16', 0, NULL, NULL),
(35, 'A2025-2345', 'JP', 'VALENZUELA', 'male', 'JVALENZUEAL@SDCA.COM', NULL, '$2y$10$FsuIv6B5TL9JR68xx1yQ.OW55SPi.nqdEIi/elRQwfMZIdIPcibu2', '09988994071', NULL, 2026, 'BSIT', '6850e36681169_akodin.jpg', '202000163', '2025-06-17 03:42:22', 'inactive', 'WEB DEVELOPER', 'SDA', '2 YEARS', NULL, NULL, NULL, '2025-06-17 03:30:11', 0, NULL, NULL),
(44, NULL, 'ARGIE', 'SEDANO', 'male', 'argie.sedano@sdca.edu.ph', NULL, '$2y$10$t.w4ce/BPWlB1EAqN8NncOBrGoE5zRlFf91ZG4wAMVBWyVcZDNivy', '09952341006', NULL, 2022, 'BS in Psychology', NULL, '2013131010', '2025-12-12 10:47:55', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-11 06:28:55', 1, NULL, NULL),
(45, 'SDCA12345678', 'argie', 'sedano', 'male', 'rgbsedano@gmail.com', NULL, '$2y$10$Pn.KVvKcd/d4cKI3QFQrUuT.iszuIF0wrgo6iGE2svSghQFoReR56', '09952341006', NULL, 2025, 'BS in Information Technology', NULL, '202202271', '2025-12-12 09:13:53', 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-12 08:58:27', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carousel_photos`
--

CREATE TABLE `carousel_photos` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel_photos`
--

INSERT INTO `carousel_photos` (`id`, `file_name`, `uploaded_at`) VALUES
(4, '1750071488_auntie_anne.jpg', '2025-06-16 10:58:08'),
(5, '1750071499_ALUMNI_EXTENSION_SERVICE.jpg', '2025-06-16 10:58:19'),
(6, '1750071509_BALIK_DOMINIC.jpg', '2025-06-16 10:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`) VALUES
(1, 1, 1, 'pending', '2025-04-23 09:02:04'),
(2, 1, 2, 'pending', '2025-04-23 09:06:26'),
(3, 1, 1, 'pending', '2025-04-23 03:22:56'),
(4, 1, 1, 'pending', '2025-04-23 03:22:59'),
(5, 1, 1, 'pending', '2025-04-23 03:23:00'),
(6, 1, 1, 'pending', '2025-04-23 03:23:01'),
(7, 1, 1, 'pending', '2025-04-23 03:23:25'),
(8, 1, 2, 'pending', '2025-04-23 03:23:31'),
(9, 1, 6, 'pending', '2025-04-23 03:23:49'),
(10, 1, 2, 'pending', '2025-04-23 13:06:21'),
(11, 1, 2, 'pending', '2025-04-23 13:06:23'),
(12, 1, 1, 'pending', '2025-04-23 13:07:38'),
(13, 1, 1, 'pending', '2025-04-23 13:07:57'),
(14, 1, 1, 'pending', '2025-04-23 13:07:57'),
(15, 1, 1, 'pending', '2025-04-23 13:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `connection_requests`
--

CREATE TABLE `connection_requests` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connection_requests`
--

INSERT INTO `connection_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`) VALUES
(1, 1, 2, 'accepted', '2025-04-23 19:43:39'),
(10, 1, 17, 'accepted', '2025-05-02 04:07:11'),
(13, 1, 15, 'accepted', '2025-05-03 20:58:40'),
(14, 1, 18, 'pending', '2025-05-04 14:26:15'),
(15, 2, 6, 'pending', '2025-06-16 14:48:02'),
(16, 35, 1, 'pending', '2025-06-17 03:48:00'),
(17, 35, 2, 'accepted', '2025-06-17 03:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `employment`
--

CREATE TABLE `employment` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `employment_status` enum('Employed','Unemployed','Self-employed') NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `job_description` text NOT NULL,
  `year_of_service` int(11) DEFAULT 0,
  `promotion_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employment`
--

INSERT INTO `employment` (`id`, `alumni_id`, `employment_status`, `company_name`, `job_title`, `job_description`, `year_of_service`, `promotion_count`, `created_at`) VALUES
(1, 1, 'Self-employed', 'Rgbsedano Co.', 'IT', 'ASDASDASD', 1, 1, '2025-12-12 13:15:58'),
(2, 15, 'Employed', '1112121', '21312312', '221212', 1212, 121, '2025-12-12 15:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `event_time_duration` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `event_date`, `event_time_duration`, `location`, `contact_person`, `description`, `image`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(6, 'Tech Innovations Webinar 2025', '2025-07-10 14:00:00', '2hrs', 'Online (Zoom)', 'techinnovations@gmail.com', 'A virtual webinar highlighting the latest tech innovations presented by industry experts and notable alumni.', '68142cf9ce30a_undraw_books_wxzz.png', 1, NULL, '2025-04-24 05:47:56', '2025-05-02 04:24:57'),
(7, 'Career Fair and Networking Day', '2025-08-05 09:00:00', '1hr', 'University Convention Center', 'ucc@gmail.com', 'Meet top companies and connect with fellow alumni for exciting career opportunities and mentoring sessions.', '68182e3d1da90_careertalk.jpg', 1, NULL, '2025-04-24 05:47:56', '2025-05-05 05:19:25'),
(8, 'Annual General Alumni Meeting', '2025-09-20 10:00:00', NULL, 'Alumni Hall, North Wing', NULL, 'Discuss the future plans of the alumni association, vote on important matters, and get updated on key initiatives.', 'general_meeting_2025.jpg', 1, NULL, '2025-04-24 05:47:56', NULL),
(9, 'Alumni Outreach: Tree Planting Activity', '2025-05-30 07:00:00', NULL, 'Eco Park, City Outskirts', NULL, 'Give back to nature with this community tree planting event organized by the alumni environmental committee.', 'tree_planting_2025.jpg', 1, NULL, '2025-04-24 05:47:56', NULL),
(15, 'Career Fair 2025', '2025-06-15 09:00:00', '9:00 AM - 4:00 PM', 'Main Hall, Building B', 'Ms. Ana Santos', 'A great opportunity for alumni to meet recruiters and explore job openings.', 'career_fair.jpg', NULL, NULL, '2025-04-25 10:43:37', NULL),
(17, 'Alumni Homecoming 2025', '2025-05-30 15:00:00', '3:00 PM - 7:00 PM', 'University Auditorium', 'Prof. Juan Dela Cruz', 'Join us for a memorable evening of reunion, fun, and networking with fellow alumni.', 'homecoming2025.jpg', NULL, NULL, '2025-04-25 10:44:08', NULL),
(19, 'Web Development Workshop', '2025-07-10 13:00:00', '1:00 PM - 5:00 PM', 'Computer Lab 3, IT Building', 'Engr. Mark Villanueva', 'Hands-on workshop on building modern web apps using PHP and React.', 'web_workshop.jpg', NULL, NULL, '2025-04-25 10:44:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `alumni_id` int(11) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`id`, `event_id`, `alumni_id`, `registered_at`) VALUES
(2, 1, 1, '2025-04-22 04:20:49'),
(3, 2, 1, '2025-04-22 08:20:25'),
(4, 8, 1, '2025-04-23 21:48:22'),
(5, 7, 1, '2025-04-23 21:54:08'),
(6, 9, 15, '2025-04-23 22:46:44'),
(7, 19, 15, '2025-04-26 02:55:51'),
(8, 6, 15, '2025-05-14 07:02:07'),
(9, 8, 2, '2025-06-16 11:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `contact_details` varchar(255) DEFAULT NULL,
  `image_filename` varchar(255) DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_title`, `company`, `description`, `location`, `salary_range`, `qualifications`, `contact_details`, `image_filename`, `posted_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(18, 'Software Developer', 'TechCorp Inc.', 'Develop and maintain web applications using modern frameworks.1 ', 'Makati City', 'PHP 30,000 - PHP 50,000', 'Bachelor\'s Degree in Computer Science or related field. Knowledge in PHP, JavaScript, MySQL. Develop and maintain web applications using modern frameworks. Develop and maintain web applications using modern frameworks.', 'Email: hr@techcorp.com | Phone: 0917-123-4567', NULL, 1, NULL, '2025-04-25 08:10:40', '2025-12-03 17:20:29'),
(19, 'Marketing Specialist', 'Bright Ideas Co.', 'Plan and execute marketing campaigns across various platforms. ', 'Cebu City', 'PHP 25,000 - PHP 40,000', 'Bachelor\'s Degree in Marketing or Business. Strong communication skills.Plan and execute marketing campaigns across various platforms.Plan and execute marketing campaigns across various platforms. 1', 'Email: marketing@brightideas.com', NULL, 1, NULL, '2025-04-25 08:10:58', '2025-12-03 17:16:58'),
(20, 'IT Support Technician', 'Metro IT Solutions', 'Provide tech support to clients and ensure smooth IT operations. ', 'Quezon City', 'PHP 20,000 - PHP 30,000', 'Diploma or Degree in IT or Computer Engineering. Basic networking knowledge required.Provide tech support to clients and ensure smooth IT operations.Provide tech support to clients and ensure smooth IT operations. 1', 'Call: (02) 8123-4567', NULL, 1, NULL, '2025-04-25 08:10:58', '2025-12-03 17:20:56'),
(21, 'Graphic Designer', 'Creative Minds Studio', 'Design digital assets for social media and client branding.', 'Davao City', 'PHP 28,000 - PHP 35,000', 'Experience with Adobe Photoshop, Illustrator, and Canva. Creative portfolio required.', 'Submit to: design@creativeminds.ph', NULL, 1, NULL, '2025-04-25 08:10:58', NULL),
(22, 'Finance Analyst', 'ExcelBank', 'Analyze financial reports and assist in forecasting trends.', 'Makati City', 'PHP 40,000 - PHP 60,000', 'Bachelor\'s in Finance or Accounting. CPA is an advantage.', 'financejobs@excelbank.com', NULL, 1, NULL, '2025-04-25 08:10:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `alumni_id` int(11) DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `alumni_id`, `applied_at`) VALUES
(1, 7, 1, '2025-04-24 00:44:17'),
(3, 18, 1, '2025-04-26 02:21:11'),
(4, 19, 1, '2025-05-14 06:23:14'),
(5, 20, 15, '2025-05-14 07:01:52'),
(8, 19, 2, '2025-06-16 17:33:06');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(27, 2, 1, 'ey', '2025-06-16 13:41:31'),
(28, 1, 2, 'hello?', '2025-06-16 13:56:00'),
(29, 1, 15, 'hey pirs!', '2025-06-16 13:57:24'),
(30, 1, 15, 'how are you?', '2025-06-16 13:58:46'),
(33, 1, 15, 'are you ok?', '2025-06-16 13:58:58'),
(35, 2, 1, 'hi', '2025-06-16 14:07:33'),
(37, 17, 1, 'hellow po', '2025-11-25 14:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `post_type` enum('announcements','news','stories') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `recipient_batch` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `post_type`, `image`, `recipient_batch`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 'Welcome to AConnect', 'We are excited to welcome you to the official alumni platform.', 'announcements', '69212d4b5e61f_WELCOME.png', 'All', 1, 1, '2025-04-21 19:00:24', '2025-12-03 08:24:32'),
(10, 'Graduation Ceremony Schedule for Batch 2025', 'The official schedule for the 2025 graduation ceremony has been released. Please check your department bulletin for further details.', 'announcements', '6920874492968_ALUMNI_EXTENSION_SERVICE.jpg', '2011', 1, 1, '2025-04-23 21:57:52', '2025-12-03 12:11:35'),
(11, 'Alumnus Wins National Startup Award', 'Our very own alumnus, Maria Torres (Batch 2015), has won the National Startup Award for her groundbreaking work in tech-driven healthcare.', 'news', NULL, 'All', 1, NULL, '2025-04-23 21:57:52', NULL),
(12, 'From Campus to CEO: John Cruz\'s Journey', 'John Cruz, a 2010 graduate, shares his inspiring story of building a successful logistics company from scratch.', 'stories', NULL, 'All', 1, NULL, '2025-04-23 21:57:52', NULL),
(13, 'Alumni ID Application Now Open', 'The alumni office is now accepting applications for the official Alumni ID. Apply online or visit our office.', 'announcements', NULL, 'All', 1, NULL, '2025-04-23 21:57:52', NULL),
(14, 'University Named Among Top 10 in Southeast Asia', 'Our university has ranked 7th among Southeast Asian institutions according to the latest regional academic rankings.', 'news', NULL, 'All', 1, NULL, '2025-04-23 21:57:52', NULL),
(15, 'Alumni Couple Ties the Knot After 10 Years', 'High school sweethearts from Batch 2012 recently tied the knot. Their love story began in the campus library!', 'stories', NULL, '2012', 1, NULL, '2025-04-23 21:57:52', NULL),
(21, 'ICT Hiring', 'Look for ms Meg, get 50K sign up bonus', 'announcements', '', 'all', 1, NULL, '2025-06-17 03:35:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_admin`, `created_at`) VALUES
(19, 1, 1, 'hi\r\n', 0, '2025-05-05 14:17:31'),
(20, 1, 1, 'Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.', 1, '2025-05-05 14:17:31'),
(21, 1, 1, 'hey\r\n', 0, '2025-06-04 10:43:11'),
(22, 1, 1, 'Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.', 1, '2025-06-04 10:43:11'),
(23, 1, 1, 'hi admin\r\n', 0, '2025-06-04 10:46:28'),
(24, 1, 1, 'Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.', 1, '2025-06-04 10:46:28'),
(25, 2, 1, 'hi admin can u help me\r\n', 0, '2025-06-04 10:48:20'),
(26, 1, 2, 'Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.', 1, '2025-06-04 10:48:20'),
(27, 1, 1, 'hey', 1, '2025-06-16 18:57:15'),
(28, 2, 1, 'hello', 0, '2025-06-16 19:13:34'),
(29, 1, 2, 'Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.', 1, '2025-06-16 19:13:34'),
(30, 1, 2, 'Hello there, what is your concern?', 1, '2025-06-16 20:38:54'),
(31, 2, 1, 'hi admin', 0, '2025-07-29 19:21:01'),
(32, 1, 2, 'Thanks for contacting support. We will get back to you shortly. If you want a faster reply email me instead in admin@gmail.com.', 1, '2025-07-29 19:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `tracer_responses`
--

CREATE TABLE `tracer_responses` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `year_graduated` int(11) NOT NULL,
  `employment_status` enum('Employed','Unemployed','Self-employed') NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `job_description` text DEFAULT NULL,
  `year_of_service` int(11) DEFAULT 0,
  `promotion_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tracer_responses`
--

INSERT INTO `tracer_responses` (`id`, `alumni_id`, `year_graduated`, `employment_status`, `company_name`, `job_title`, `job_description`, `year_of_service`, `promotion_count`, `created_at`) VALUES
(1, 1, 2025, 'Unemployed', 'Rgbsedano Co.', 'IT', 'IT ngani', 1, 2, '2025-12-04 00:09:28'),
(2, 15, 2023, 'Employed', 'ORACLE', 'IT', 'DEVELOPER', 2, 2, '2025-12-04 00:40:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD UNIQUE KEY `alumni_number` (`alumni_number`);

--
-- Indexes for table `carousel_photos`
--
ALTER TABLE `carousel_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `connection_requests`
--
ALTER TABLE `connection_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `employment`
--
ALTER TABLE `employment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employment_alumni` (`alumni_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracer_responses`
--
ALTER TABLE `tracer_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `carousel_photos`
--
ALTER TABLE `carousel_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `connection_requests`
--
ALTER TABLE `connection_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employment`
--
ALTER TABLE `employment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tracer_responses`
--
ALTER TABLE `tracer_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `alumni` (`id`),
  ADD CONSTRAINT `connections_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `alumni` (`id`);

--
-- Constraints for table `connection_requests`
--
ALTER TABLE `connection_requests`
  ADD CONSTRAINT `connection_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `alumni` (`id`),
  ADD CONSTRAINT `connection_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `alumni` (`id`);

--
-- Constraints for table `employment`
--
ALTER TABLE `employment`
  ADD CONSTRAINT `fk_employment_alumni` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `alumni` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `alumni` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `tracer_responses`
--
ALTER TABLE `tracer_responses`
  ADD CONSTRAINT `tracer_responses_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
