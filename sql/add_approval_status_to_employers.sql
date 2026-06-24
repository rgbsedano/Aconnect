-- Add approval_status column to employers table
-- Run this in your database if you prefer SQL directly (phpMyAdmin / mysql CLI)

ALTER TABLE `employers`
  ADD COLUMN `approval_status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending' AFTER `is_active`;
