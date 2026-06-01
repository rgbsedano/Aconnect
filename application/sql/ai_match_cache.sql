-- AI Match Cache Table
-- Stores Gemini API responses and prompts for alumni-job combinations
-- Primary key: (alumni_id, job_id)

CREATE TABLE IF NOT EXISTS `ai_match_cache` (
  `alumni_id` INT(11) NOT NULL,
  `job_id` INT(11) NOT NULL,
  `prompt` LONGTEXT NOT NULL,
  `api_response` LONGTEXT NOT NULL,
  `match_percentage` INT(3),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`alumni_id`, `job_id`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
