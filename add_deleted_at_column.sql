-- Add deleted_at column to jobs table for soft deletes
-- Copy and paste this SQL into HeidiSQL or PHPMyAdmin Query window

ALTER TABLE `jobs` 
ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL 
AFTER `created_at`;

-- Verify the column was added
SHOW COLUMNS FROM `jobs` LIKE 'deleted_at';
