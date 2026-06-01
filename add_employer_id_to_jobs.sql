-- Add employer_id column to jobs table
ALTER TABLE `jobs` ADD COLUMN `employer_id` INT(11) NULL AFTER `id`;

-- Create index for faster queries
ALTER TABLE `jobs` ADD INDEX `idx_employer_id` (`employer_id`);
