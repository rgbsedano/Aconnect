-- Create Employer Groups Table
CREATE TABLE IF NOT EXISTS `employer_groups` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `group_name` varchar(150) NOT NULL,
    `description` text,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_group_name` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Employer-Group Assignment Table
CREATE TABLE IF NOT EXISTS `employer_group_assignments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `employer_id` int(11) NOT NULL,
    `group_id` int(11) NOT NULL,
    `assigned_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_employer_group` (`employer_id`, `group_id`),
    FOREIGN KEY (`employer_id`) REFERENCES `employers`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`group_id`) REFERENCES `employer_groups`(`id`) ON DELETE CASCADE,
    INDEX `idx_employer_id` (`employer_id`),
    INDEX `idx_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
