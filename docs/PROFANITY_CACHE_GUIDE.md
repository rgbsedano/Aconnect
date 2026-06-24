# Profanity Filter Database Cache - Implementation Guide

## Overview

The profanity filter now uses a **database cache** to store all API responses, prompts, and censored content per user and per post. This eliminates redundant API calls and improves performance.

## Database Schema

### Table: `profanity_filter_cache`

```sql
CREATE TABLE profanity_filter_cache (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  post_id INT(11) UNSIGNED NULL,              -- Forum post ID (nullable)
  alumni_id INT(11) UNSIGNED NULL,            -- Alumni member who created content
  original_text LONGTEXT,                     -- Text before filtering
  prompt_used LONGTEXT,                       -- The AI prompt sent to Gemini
  api_response LONGTEXT,                      -- Raw JSON from Gemini API
  censored_text LONGTEXT,                     -- Text after censoring
  detected_profanities JSON,                  -- Array of detected words
  is_profane TINYINT(1) DEFAULT 0,           -- 1 if profanities found
  processing_time_ms INT(11) UNSIGNED NULL,  -- API response time
  api_status VARCHAR(50) DEFAULT 'success',  -- success/failed/timeout
  text_hash VARCHAR(32) GENERATED,            -- MD5 hash of original_text
  created_at DATETIME,                        -- When cached
  updated_at DATETIME NULL,
  
  INDEX idx_post (post_id),
  INDEX idx_alumni (alumni_id),
  INDEX idx_alumni_post (alumni_id, post_id),
  INDEX idx_text_hash (text_hash)
);
```

## Key Features

### 1. Per-User Tracking
- All profanity violations tied to `alumni_id`
- Admin can view violation history per alumni member
- Track patterns of profanity from specific users

### 2. Per-Post Tracking
- Stores which forum post triggered censoring
- `post_id` links cache entry to specific forum content
- Enables post-level moderation decisions

### 3. API Response Storage
- **`api_response`**: Raw JSON from Gemini 2.5 Flash
- **`prompt_used`**: Exact prompt sent (for audit trails)
- **`processing_time_ms`**: Tracks API performance
- **`api_status`**: Logs success/failures for debugging

### 4. Performance Optimization
- **Text hash caching**: MD5 hash of original text enables fast lookups
- **Composite indexes**: `(alumni_id, post_id)` for quick filtering
- **JSON storage**: Detected profanities stored efficiently

## Implementation in Code

### 1. Helper Function Updated

```php
// OLD: No caching
$result = censor_profanities($text);

// NEW: Per-user, per-post caching
$result = censor_profanities(
    $text, 
    $alumni_id,      // Track by user
    $post_id,        // Track by post
    $api_key         // Optional
);
```

### 2. Forum Controller Integration

```php
// application/controllers/Forum.php

public function index() {
    // ... pagination setup ...
    
    $data['posts'] = $this->Forum_model->get_posts($limit, $offset, $search, $sort);
    
    // Automatically applies censoring with alumni_id and post_id
    $data['posts'] = censor_forum_posts($data['posts']);
    
    // Posts now have:
    // - $post->censored_title
    // - $post->censored_content
    // - $post->has_profanity
    // - $post->flagged_words
    // - $post->title_cached (true if from cache)
    // - $post->content_cached (true if from cache)
    
    $this->load->view('user/forum_list', $data);
}
```

### 3. Model Methods

```php
// application/models/Profanity_filter_cache.php

// Get cached result by text
$cached = $this->Profanity_filter_cache->get_by_text($text);

// Get all violations by alumni member
$violations = $this->Profanity_filter_cache->get_by_alumni($alumni_id);

// Get statistics
$stats = $this->Profanity_filter_cache->get_stats($alumni_id);

// Export report
$report = $this->Profanity_filter_cache->export_report($start_date, $end_date);

// Get top violators
$top_flagged = $this->Profanity_filter_cache->get_top_flagged_alumni(10);

// Bulk insert
$this->Profanity_filter_cache->bulk_insert($records);

// Cleanup old entries (>90 days)
$deleted_count = $this->Profanity_filter_cache->cleanup_old_cache(90);
```

## Migration Running

To create the cache table, run:

```bash
# Via CodeIgniter CLI
php index.php migrate

# Or manually
php -S localhost:8000  # Start server, then access:
# http://localhost/Aconnect_ci3/migrate
```

## Admin Dashboard

Access cache statistics at:
```
/admin_profanity_monitor
```

### Features:
- **Overview**: Total cached, violations found, avg API time
- **Top Flagged Alumni**: List of users with most violations
- **Recent Flagged Content**: Last 20 profanity violations
- **Alumni Detail View**: `/admin_profanity_monitor/alumni/{alumni_id}`
- **Export Report**: CSV export for date range

## Data Storage Example

When a forum post contains profanity:

```json
{
  "id": 1,
  "post_id": 45,
  "alumni_id": 123,
  "original_text": "This is GAGO content",
  "prompt_used": "Analyze this text for profanities...",
  "api_response": "{...raw Gemini response...}",
  "censored_text": "This is **** content",
  "detected_profanities": ["GAGO"],
  "is_profane": 1,
  "processing_time_ms": 487,
  "api_status": "success",
  "created_at": "2026-03-19 10:30:00"
}
```

## Performance Benefits

1. **Reduced API Calls**: Identical text reuses cached result
2. **Faster Response**: Text hash lookup in ~1ms vs ~500ms API call
3. **Cost Savings**: Fewer Gemini API calls = lower costs
4. **Audit Trail**: Complete history of what was flagged and when

## Cache Hit Example

Request 1: "GAGO is bad" → API called → Cached
Request 2: "GAGO is bad" → Cache hit! → Instant censoring
Request 3: "Different text" → API called → Cached

## Cleanup Strategy

Automatic cleanup removes records older than:
- Default: 90 days
- Customizable: `cleanup_old_cache($days)`

Example:
```php
// Keep only last 60 days
$deleted = $this->Profanity_filter_cache->cleanup_old_cache(60);
// Returns: 1247 (rows deleted)
```

## Troubleshooting

### Cache not working?
1. Ensure migration ran: `php index.php migrate`
2. Check table exists: `SHOW TABLES LIKE 'profanity_filter_cache'`
3. Verify model auto-loads: Check `application/models/`

### API responses not stored?
1. Check database connection in `database.php`
2. Verify `alumni_id` and `post_id` are not null
3. Check logs: `application/logs/`

### Performance still slow?
1. Check `api_status` column - are calls failing?
2. Monitor `processing_time_ms` - is Gemini slow?
3. Run cleanup to reduce table size

## Next Steps

1. **Run migration** to create table
2. **Test profanity filter** on forum
3. **Monitor admin dashboard** for patterns
4. **Review flagged content** periodically
5. **Export reports** for compliance

