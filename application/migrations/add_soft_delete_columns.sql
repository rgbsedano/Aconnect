-- Migration: Add deleted_at column to forum-related tables for soft deletes
-- Date: 2026-03-31
-- Purpose: Support soft deletes on forum_likes, forum_dislikes, and related tables

-- =====================================================
-- 1. ALTER forum_likes table
-- =====================================================
ALTER TABLE `forum_likes` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- =====================================================
-- 2. ALTER forum_dislikes table
-- =====================================================
ALTER TABLE `forum_dislikes` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- =====================================================
-- 3. ALTER forum_comments table (if not already present)
-- =====================================================
ALTER TABLE `forum_comments` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- =====================================================
-- 4. ALTER forum_posts table (if not already present)
-- =====================================================
ALTER TABLE `forum_posts` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- =====================================================
-- OPTIONAL: Create indexes on deleted_at for query performance
-- =====================================================
ALTER TABLE `forum_likes` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_dislikes` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_comments` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_posts` ADD INDEX `idx_deleted_at` (`deleted_at`);

-- =====================================================
-- Verification queries (run these to check)
-- =====================================================
-- DESCRIBE forum_likes;
-- DESCRIBE forum_dislikes;
-- DESCRIBE forum_comments;
-- DESCRIBE forum_posts;
