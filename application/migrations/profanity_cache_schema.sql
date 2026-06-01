-- Profanity Filter Cache Table
-- AConnect Forum - Profanity Detection & Caching System
-- Created: 2026-03-19

-- This table stores all profanity filter cache entries
-- including API responses, prompts, and censored content per user/post

CREATE TABLE IF NOT EXISTS profanity_filter_cache (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  
  post_id INT(11) UNSIGNED COMMENT 'Forum post ID (nullable if not from forum)',
  alumni_id INT(11) UNSIGNED COMMENT 'Alumni ID of content creator - for tracking per user',
  
  original_text LONGTEXT NOT NULL COMMENT 'Original text before filtering',
  prompt_used LONGTEXT NOT NULL COMMENT 'The AI prompt sent to Gemini API',
  api_response LONGTEXT COMMENT 'Raw JSON response from Gemini API',
  
  censored_text LONGTEXT NOT NULL COMMENT 'Final text after profanity censoring',
  detected_profanities JSON COMMENT 'JSON array of detected profanity words',
  
  is_profane TINYINT(1) UNSIGNED DEFAULT 0 COMMENT 'Boolean: 1 if profanities detected',
  processing_time_ms INT(11) UNSIGNED COMMENT 'API response time in milliseconds',
  api_status VARCHAR(50) DEFAULT 'success' COMMENT 'API call status: success, failed, timeout, parse_error',
  
  text_hash VARCHAR(32) GENERATED ALWAYS AS (MD5(original_text)) STORED COMMENT 'MD5 hash for fast cache lookups',
  
  created_at DATETIME NOT NULL COMMENT 'When this cache entry was created',
  updated_at DATETIME NULL COMMENT 'When record was last updated',
  
  PRIMARY KEY (id),
  KEY idx_post_id (post_id),
  KEY idx_alumni_id (alumni_id),
  KEY idx_alumni_post (alumni_id, post_id) COMMENT 'Composite index for alumni+post queries',
  KEY idx_text_hash (text_hash) COMMENT 'Fast lookup by text hash',
  KEY idx_is_profane (is_profane) COMMENT 'Query all profane entries',
  KEY idx_created_at (created_at) COMMENT 'Sort by date for cleanup'
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Stores profanity filter API responses and censoring results per user/post - AI: Gemini 2.5 Flash';


-- ============================================================================
-- SAMPLE QUERIES
-- ============================================================================

-- View all cache entries for a specific alumni member
-- SELECT * FROM profanity_filter_cache WHERE alumni_id = 123 ORDER BY created_at DESC;

-- Count total profanities found
-- SELECT COUNT(*) as total_violations FROM profanity_filter_cache WHERE is_profane = 1;

-- List top 10 alumni with most profanity violations
-- SELECT alumni_id, COUNT(*) as violation_count 
--   FROM profanity_filter_cache 
--   WHERE is_profane = 1 
--   GROUP BY alumni_id 
--   ORDER BY violation_count DESC 
--   LIMIT 10;

-- Get cache statistics
-- SELECT 
--   COUNT(*) as total_cached,
--   SUM(is_profane) as profanity_count,
--   AVG(processing_time_ms) as avg_api_time,
--   MAX(created_at) as last_cached
-- FROM profanity_filter_cache;

-- Find duplicate texts (cache hits)
-- SELECT text_hash, COUNT(*) as count 
--   FROM profanity_filter_cache 
--   GROUP BY text_hash 
--   HAVING count > 1 
--   ORDER BY count DESC;

-- Delete old cache entries (older than 90 days)
-- DELETE FROM profanity_filter_cache WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Export CSV for audit
-- SELECT 
--   id, post_id, alumni_id, 
--   SUBSTRING(original_text, 1, 100) as text_preview,
--   detected_profanities, is_profane, created_at
-- FROM profanity_filter_cache 
-- WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
-- ORDER BY created_at DESC;
