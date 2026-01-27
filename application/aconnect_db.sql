-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2026 at 08:13 AM
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
(177, 35, 'Logged in', '2025-06-17 11:30:21'),
(178, 35, 'Updated his/her Profile', '2025-06-17 11:39:18'),
(239, 45, 'Logged out', '2025-12-12 17:16:57'),
(240, 45, 'Logged out', '2025-12-12 17:19:56'),
(241, 45, 'Logged out', '2025-12-12 17:51:52'),
(242, 45, 'Logged out', '2025-12-12 17:52:28'),
(243, 45, 'Logged out', '2025-12-12 18:46:08'),
(245, 45, 'Applied for a job', '2025-12-12 22:52:19'),
(246, 45, 'Logged out', '2025-12-12 22:52:28'),
(247, 45, 'Logged out', '2025-12-13 04:42:49'),
(248, 45, 'Logged out', '2025-12-13 05:19:22'),
(249, 45, 'Logged out', '2025-12-13 07:30:34'),
(250, 45, 'Logged out', '2025-12-13 07:32:26'),
(255, 45, 'Logged out', '2025-12-13 08:21:53'),
(260, 49, 'Updated his/her Profile', '2025-12-13 10:26:40'),
(261, 49, 'Logged out', '2025-12-13 10:31:49'),
(262, 49, 'Logged out', '2025-12-13 10:53:17'),
(263, 49, 'Logged out', '2025-12-13 11:59:31'),
(264, 49, 'Logged out', '2025-12-13 12:09:22'),
(265, 49, 'Register to an event', '2025-12-13 12:20:16'),
(266, 49, 'Register to an event', '2025-12-13 12:20:18'),
(267, 49, 'Register to an event', '2025-12-13 12:21:58'),
(268, 49, 'Register to an event', '2025-12-13 12:21:58'),
(269, 49, 'Register to an event', '2025-12-13 12:21:59'),
(270, 49, 'Register to an event', '2025-12-13 12:22:00'),
(271, 49, 'Register to an event', '2025-12-13 12:22:01'),
(272, 49, 'Register to an event', '2025-12-13 12:22:03'),
(273, 49, 'Register to an event', '2025-12-13 12:22:05'),
(274, 49, 'Register to an event', '2025-12-13 12:24:49'),
(275, 49, 'Register to an event', '2025-12-13 12:24:51'),
(276, 49, 'Register to an event', '2025-12-13 12:34:44'),
(277, 49, 'Register to an event', '2025-12-13 12:34:45'),
(278, 49, 'Register to an event', '2025-12-13 12:34:46'),
(279, 49, 'Register to an event', '2025-12-13 12:38:14'),
(280, 49, 'Register to an event', '2025-12-13 12:38:15'),
(281, 49, 'Register to an event', '2025-12-13 12:38:15'),
(282, 49, 'Register to an event', '2025-12-13 12:38:15'),
(283, 49, 'Register to an event', '2025-12-13 13:20:05'),
(284, 49, 'Register to an event', '2025-12-13 13:24:10'),
(285, 49, 'Register to an event', '2025-12-13 13:24:11'),
(286, 49, 'Register to an event', '2025-12-13 13:24:13'),
(287, 49, 'Register to an event', '2025-12-13 13:24:13'),
(288, 49, 'Register to an event', '2025-12-13 13:24:14'),
(289, 49, 'Register to an event', '2025-12-13 13:25:11'),
(290, 49, 'Register to an event', '2025-12-13 13:25:12'),
(291, 49, 'Register to an event', '2025-12-13 13:25:12'),
(292, 49, 'Register to an event', '2025-12-13 13:25:12'),
(293, 49, 'Register to an event', '2025-12-13 13:25:12'),
(294, 49, 'Register to an event', '2025-12-13 13:25:14'),
(295, 49, 'Register to an event', '2025-12-13 13:26:16'),
(296, 49, 'Register to an event', '2025-12-13 13:26:17'),
(297, 49, 'Register to an event', '2025-12-13 13:27:48'),
(298, 49, 'Register to an event', '2025-12-13 13:27:49'),
(299, 49, 'Register to an event', '2025-12-13 13:27:49'),
(300, 49, 'Register to an event', '2025-12-13 13:27:49'),
(301, 49, 'Register to an event', '2025-12-13 13:27:52'),
(302, 49, 'Register to an event', '2025-12-13 13:27:54'),
(303, 49, 'Register to an event', '2025-12-13 13:27:56'),
(304, 49, 'Register to an event', '2025-12-13 13:28:58'),
(305, 49, 'Register to an event', '2025-12-13 13:28:59'),
(306, 49, 'Register to an event', '2025-12-13 13:30:30'),
(307, 49, 'Register to an event', '2025-12-13 13:30:33'),
(308, 49, 'Register to an event', '2025-12-13 13:31:40'),
(309, 49, 'Register to an event', '2025-12-13 13:31:43'),
(310, 49, 'Register to an event', '2025-12-13 13:33:40'),
(311, 49, 'Register to an event', '2025-12-13 13:33:42'),
(312, 49, 'Register to an event', '2025-12-13 13:35:06'),
(313, 49, 'Register to an event', '2025-12-13 13:35:45'),
(314, 49, 'Register to an event', '2025-12-13 13:36:46'),
(315, 49, 'Register to an event', '2025-12-13 13:36:58'),
(316, 49, 'Register to an event', '2025-12-13 13:37:00'),
(317, 49, 'Register to an event', '2025-12-13 13:38:24'),
(318, 49, 'Register to an event', '2025-12-13 13:38:25'),
(319, 49, 'Register to an event', '2025-12-13 13:38:28'),
(320, 49, 'Register to an event', '2025-12-13 13:40:02'),
(321, 49, 'Register to an event', '2025-12-13 13:40:07'),
(322, 49, 'Register to an event', '2025-12-13 13:40:16'),
(323, 49, 'Register to an event', '2025-12-13 13:40:33'),
(324, 49, 'Register to an event', '2025-12-13 13:41:36'),
(325, 49, 'Register to an event', '2025-12-13 13:41:44'),
(326, 49, 'Register to an event', '2025-12-13 13:43:36'),
(327, 49, 'Register to an event', '2025-12-13 13:45:34'),
(328, 49, 'Register to an event', '2025-12-13 13:45:45'),
(329, 49, 'Logged out', '2025-12-13 13:45:53'),
(330, 49, 'Logged out', '2025-12-13 13:49:14'),
(331, 49, 'Register to an event', '2025-12-13 13:50:54'),
(332, 49, 'Register to an event', '2025-12-13 13:51:01'),
(333, 49, 'Register to an event', '2025-12-13 13:51:01'),
(334, 49, 'Register to an event', '2025-12-13 13:51:14'),
(335, 49, 'Register to an event', '2025-12-13 13:52:15'),
(336, 49, 'Register to an event', '2025-12-13 13:52:17'),
(337, 49, 'Register to an event', '2025-12-13 13:52:19'),
(338, 49, 'Register to an event', '2025-12-13 13:52:21'),
(339, 49, 'Register to an event', '2025-12-13 13:52:27'),
(340, 49, 'Register to an event', '2025-12-13 13:52:30'),
(341, 49, 'Register to an event', '2025-12-13 13:52:32'),
(342, 49, 'Register to an event', '2025-12-13 13:52:43'),
(343, 49, 'Register to an event', '2025-12-13 13:53:11'),
(344, 49, 'Register to an event', '2025-12-13 14:07:42'),
(345, 50, 'Logged out', '2025-12-13 15:09:28'),
(346, 50, 'Logged out', '2025-12-13 15:12:39'),
(347, 50, 'Logged out', '2025-12-13 15:43:22'),
(348, 45, 'Logged out', '2026-01-21 22:25:32'),
(349, 49, 'Logged out', '2026-01-21 22:27:25'),
(350, 49, 'Logged out', '2026-01-22 00:11:50'),
(351, 45, 'Updated his/her Profile', '2026-01-22 00:18:08'),
(352, 45, 'Updated his/her Profile', '2026-01-22 00:43:40'),
(353, 45, 'Updated his/her Profile', '2026-01-22 00:44:04'),
(354, 45, 'Updated his/her Profile', '2026-01-22 01:24:23'),
(355, 45, 'Updated his/her Profile', '2026-01-22 01:24:50'),
(356, 45, 'Updated his/her Profile', '2026-01-22 01:30:23'),
(357, 45, 'Updated his/her Profile', '2026-01-22 01:30:47'),
(358, 45, 'Logged out', '2026-01-22 01:41:49'),
(359, 45, 'Logged out', '2026-01-22 12:09:46'),
(360, 49, 'Logged out', '2026-01-22 17:26:44'),
(361, 53, 'Logged out', '2026-01-23 10:31:22'),
(362, 53, 'Logged out', '2026-01-23 10:31:32'),
(363, 50, 'Logged out', '2026-01-23 10:31:45'),
(364, 50, 'Logged out', '2026-01-23 10:31:48'),
(365, 53, 'Logged out', '2026-01-23 10:31:59'),
(366, 50, 'Logged out', '2026-01-23 10:32:11'),
(367, 50, 'Logged out', '2026-01-23 10:36:37'),
(368, 50, 'Logged out', '2026-01-23 10:36:42'),
(369, 50, 'Logged out', '2026-01-23 10:36:56'),
(370, 53, 'Logged out', '2026-01-23 10:37:59'),
(371, 50, 'Logged out', '2026-01-23 10:38:15'),
(372, 50, 'Logged out', '2026-01-23 10:39:44'),
(373, 53, 'Logged out', '2026-01-23 10:40:19'),
(374, 53, 'Logged out', '2026-01-23 10:43:14'),
(375, 53, 'Logged out', '2026-01-23 10:49:27'),
(376, 53, 'Logged out', '2026-01-24 22:04:33'),
(377, 50, 'Logged out', '2026-01-24 22:05:11'),
(378, 53, 'Logged out', '2026-01-27 09:23:01'),
(379, 53, 'Applied for a job', '2026-01-27 09:29:32'),
(380, 53, 'Logged out', '2026-01-27 09:29:41');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
