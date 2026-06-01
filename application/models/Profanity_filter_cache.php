<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profanity_filter_cache Model
 * 
 * Handles database operations for profanity filter cache
 * Stores AI responses per user/post to avoid redundant API calls
 */

class Profanity_filter_cache extends CI_Model {

    private $table = 'profanity_filter_cache';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get cache entry by text hash
     * Uses MD5 hash of original text for efficient lookups
     * 
     * @param string $text The text to look up
     * @return object|null Cache record if found
     */
    public function get_by_text($text) {
        $text_hash = md5($text);
        return $this->db
            ->where('text_hash', $text_hash)
            ->order_by('created_at', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();
    }

    /**
     * Get cache entry by post ID
     * 
     * @param int $post_id Forum post ID
     * @param int $alumni_id Alumni ID (for verification)
     * @return object|null Cache record if found
     */
    public function get_by_post($post_id, $alumni_id = null) {
        $this->db->where('post_id', $post_id);
        if ($alumni_id) {
            $this->db->where('alumni_id', $alumni_id);
        }
        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();
    }

    /**
     * Get all cache entries for a specific alumni member
     * 
     * @param int $alumni_id Alumni ID
     * @param int $limit Number of records to return
     * @return array Array of cache records
     */
    public function get_by_alumni($alumni_id, $limit = 50) {
        return $this->db
            ->where('alumni_id', $alumni_id)
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    /**
     * Store profanity filter result in cache
     * 
     * @param array $data Cache data to store
     *   - post_id: int (optional)
     *   - alumni_id: int
     *   - original_text: string
     *   - prompt_used: string
     *   - api_response: string (JSON)
     *   - censored_text: string
     *   - detected_profanities: array
     *   - is_profane: bool
     *   - processing_time_ms: int (optional)
     *   - api_status: string (default: 'success')
     * @return int Insert ID
     */
    public function store_cache($data) {
        // Prepare data
        $cache_data = [
            'post_id' => $data['post_id'] ?? NULL,
            'alumni_id' => $data['alumni_id'] ?? NULL,
            'original_text' => $data['original_text'] ?? '',
            'prompt_used' => $data['prompt_used'] ?? '',
            'api_response' => is_array($data['api_response']) ? json_encode($data['api_response']) : $data['api_response'],
            'censored_text' => $data['censored_text'] ?? '',
            'detected_profanities' => json_encode($data['detected_profanities'] ?? []),
            'is_profane' => (int)($data['is_profane'] ?? 0),
            'processing_time_ms' => $data['processing_time_ms'] ?? NULL,
            'api_status' => $data['api_status'] ?? 'success',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert($this->table, $cache_data);
        return $this->db->insert_id();
    }

    /**
     * Check if text has been filtered before (returns cached result)
     * 
     * @param string $text The text to check
     * @param int $alumni_id Optional: alumni ID for user-specific cache
     * @return array|null Cached filter result or null if not found
     */
    public function get_cached_result($text, $alumni_id = null) {
        $result = $this->get_by_text($text);
        
        if ($result) {
            return [
                'is_profane' => (bool)$result->is_profane,
                'censored_text' => $result->censored_text,
                'detected_words' => json_decode($result->detected_profanities, true) ?: [],
                'cached' => true,
                'cache_id' => $result->id,
                'cache_age' => strtotime($result->created_at)
            ];
        }
        
        return null;
    }

    /**
     * Delete old cache entries (older than X days)
     * Useful for cleanup and reducing table size
     * 
     * @param int $days Number of days to keep (default: 90)
     * @return int Number of rows deleted
     */
    public function cleanup_old_cache($days = 90) {
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $this->db->where('created_at <', $cutoff_date);
        $this->db->update($this->table, ['deleted_at' => date('Y-m-d H:i:s')]);
        return $this->db->affected_rows();
    }

    /**
     * Get cache statistics
     * 
     * @param int $alumni_id Optional: filter by alumni
     * @return object Statistics about cache
     */
    public function get_stats($alumni_id = null) {
        $this->db->select('
            COUNT(*) as total_cached,
            SUM(is_profane) as profanity_found_count,
            AVG(processing_time_ms) as avg_processing_time,
            MAX(created_at) as last_cached'
        );
        
        if ($alumni_id) {
            $this->db->where('alumni_id', $alumni_id);
        }
        
        return $this->db->get($this->table)->row();
    }

    /**
     * Get profanity statistics by alumni
     * Shows which users have most profanity flags
     * 
     * @param int $limit Number of top users to return
     * @return array Array of alumni with profanity counts
     */
    public function get_top_flagged_alumni($limit = 10) {
        return $this->db
            ->select('alumni_id, COUNT(*) as flagged_count, SUM(is_profane) as profanity_instances')
            ->where('is_profane', 1)
            ->group_by('alumni_id')
            ->order_by('profanity_instances', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    /**
     * Bulk insert cache entries
     * Useful when processing multiple posts at once
     * 
     * @param array $records Array of cache records
     * @return int Number of rows inserted
     */
    public function bulk_insert($records) {
        if (empty($records)) {
            return 0;
        }

        // Prepare records
        $prepared = [];
        foreach ($records as $record) {
            $prepared[] = [
                'post_id' => $record['post_id'] ?? NULL,
                'alumni_id' => $record['alumni_id'] ?? NULL,
                'original_text' => $record['original_text'] ?? '',
                'prompt_used' => $record['prompt_used'] ?? '',
                'api_response' => is_array($record['api_response']) ? json_encode($record['api_response']) : $record['api_response'],
                'censored_text' => $record['censored_text'] ?? '',
                'detected_profanities' => json_encode($record['detected_profanities'] ?? []),
                'is_profane' => (int)($record['is_profane'] ?? 0),
                'processing_time_ms' => $record['processing_time_ms'] ?? NULL,
                'api_status' => $record['api_status'] ?? 'success',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $this->db->insert_batch($this->table, $prepared);
        return $this->db->affected_rows();
    }

    /**
     * Export cache report
     * Generate CSV-friendly data for admin review
     * 
     * @param string $start_date Date range start (Y-m-d)
     * @param string $end_date Date range end (Y-m-d)
     * @return array Array of cache records for export
     */
    public function export_report($start_date, $end_date) {
        return $this->db
            ->select('id, post_id, alumni_id, original_text, censored_text, detected_profanities, is_profane, created_at')
            ->where('created_at >=', $start_date . ' 00:00:00')
            ->where('created_at <=', $end_date . ' 23:59:59')
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

}
