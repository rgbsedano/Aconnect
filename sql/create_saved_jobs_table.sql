-- Create saved_jobs table for persisting user's saved job listings
-- This table stores the relationship between alumni and jobs they've saved for later

CREATE TABLE IF NOT EXISTS `saved_jobs` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `job_id` int NOT NULL,
  `alumni_id` int NOT NULL,
  `saved_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  
  -- Ensure each alumni can only save a job once
  UNIQUE KEY `unique_save` (`job_id`, `alumni_id`),
  
  -- Foreign key constraints (optional, comment out if referential integrity issues)
  -- FOREIGN KEY (`job_id`) REFERENCES `jobs`(`id`) ON DELETE CASCADE,
  -- FOREIGN KEY (`alumni_id`) REFERENCES `alumni`(`id`) ON DELETE CASCADE,
  
  -- Indices for fast queries
  KEY `idx_alumni_id` (`alumni_id`),
  KEY `idx_job_id` (`job_id`),
  KEY `idx_saved_at` (`saved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
