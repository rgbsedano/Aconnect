-- Create Employer Page Visibility Table
-- This table controls which pages are visible to which employers

CREATE TABLE IF NOT EXISTS `employer_page_visibility` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `page_slug` varchar(100) NOT NULL,
    `employer_id` int(11) NOT NULL,
    `is_visible` tinyint(1) DEFAULT 1,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_page_employer` (`page_slug`, `employer_id`),
    FOREIGN KEY (`employer_id`) REFERENCES `employers`(`id`) ON DELETE CASCADE,
    INDEX `idx_page_slug` (`page_slug`),
    INDEX `idx_employer_id` (`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
