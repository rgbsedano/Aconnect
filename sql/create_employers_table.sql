-- Create Employers Table
CREATE TABLE IF NOT EXISTS `employers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `company_name` varchar(150) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `hear_about_us` varchar(255) DEFAULT NULL,
    `account_type` varchar(50) DEFAULT 'employer',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `is_active` tinyint(1) DEFAULT 1,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
