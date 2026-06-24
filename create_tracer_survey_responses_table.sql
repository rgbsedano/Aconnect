CREATE TABLE `tracer_survey_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumni_id` int(11) NOT NULL,
  `year_graduated` int(11) NOT NULL,
  `rating_1` tinyint(1) NOT NULL DEFAULT 0,
  `rating_2` tinyint(1) NOT NULL DEFAULT 0,
  `rating_3` tinyint(1) NOT NULL DEFAULT 0,
  `rating_4` tinyint(1) NOT NULL DEFAULT 0,
  `waiting_time` varchar(100) DEFAULT NULL,
  `competencies` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `alumni_id` (`alumni_id`),
  CONSTRAINT `tracer_survey_responses_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;