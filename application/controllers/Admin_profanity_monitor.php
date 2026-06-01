<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin_profanity_monitor Controller
 * 
 * Displays profanity filter cache statistics and allows admin review
 * Monitor and manage profanity violations
 */

class Admin_profanity_monitor extends CI_Controller {

    /**
     * Check if user is admin
     */
    public function __construct() {
        parent::__construct();
        
        // Verify admin access
        if (!$this->session->userdata('is_admin')) {
            redirect('login');
        }

        $this->load->model('Profanity_filter_cache');
        $this->load->helper('profanity_filter');
    }

    /**
     * Dashboard showing profanity statistics
     */
    public function index() {
        $data['page_title'] = 'Profanity Filter Monitor';
        
        // Get overall statistics
        $data['cache_stats'] = $this->Profanity_filter_cache->get_stats();
        
        // Get top flagged alumni
        $data['top_flagged'] = $this->Profanity_filter_cache->get_top_flagged_alumni(10);
        
        // Get recent flagged content
        $data['recent_flagged'] = $this->db
            ->where('is_profane', 1)
            ->order_by('created_at', 'DESC')
            ->limit(20)
            ->get('profanity_filter_cache')
            ->result();

        // Convert JSON fields
        foreach ($data['recent_flagged'] as $record) {
            $record->detected_profanities = json_decode($record->detected_profanities, true);
        }

        $this->load->view('__header');
        $this->load->view('admin/profanity_monitor', $data);
        $this->load->view('__footer');
    }

    /**
     * View detailed cache for specific alumni member
     */
    public function alumni($alumni_id) {
        $data['alumni_id'] = $alumni_id;
        $data['stats'] = $this->Profanity_filter_cache->get_stats($alumni_id);
        $data['cache_entries'] = $this->Profanity_filter_cache->get_by_alumni($alumni_id, 100);

        // Convert JSON fields
        foreach ($data['cache_entries'] as $entry) {
            $entry->detected_profanities = json_decode($entry->detected_profanities, true);
            $entry->api_response = json_decode($entry->api_response, true);
        }

        $this->load->view('__header');
        $this->load->view('admin/profanity_alumni_detail', $data);
        $this->load->view('__footer');
    }

    /**
     * View specific cache entry details
     */
    public function view_entry($cache_id) {
        $entry = $this->db->where('id', $cache_id)->get('profanity_filter_cache')->row();

        if (!$entry) {
            show_404();
        }

        $entry->detected_profanities = json_decode($entry->detected_profanities, true);
        $entry->api_response = json_decode($entry->api_response, true);

        $data['entry'] = $entry;

        $this->load->view('__header');
        $this->load->view('admin/profanity_entry_detail', $data);
        $this->load->view('__footer');
    }

    /**
     * Export profanity report for date range
     */
    public function export_report() {
        $start_date = $this->input->get('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $end_date = $this->input->get('end_date') ?? date('Y-m-d');

        $records = $this->Profanity_filter_cache->export_report($start_date, $end_date);

        // Generate CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="profanity_report_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Post ID', 'Alumni ID', 'Original Text', 'Censored Text', 'Detected Words', 'Is Profane', 'Date']);

        foreach ($records as $record) {
            fputcsv($output, [
                $record->id,
                $record->post_id,
                $record->alumni_id,
                substr($record->original_text, 0, 100),
                substr($record->censored_text, 0, 100),
                implode(', ', json_decode($record->detected_profanities, true)),
                $record->is_profane ? 'Yes' : 'No',
                $record->created_at
            ]);
        }

        fclose($output);
    }

    /**
     * Cleanup old cache entries
     */
    public function cleanup() {
        $days = $this->input->post('days') ?? 90;
        $deleted = $this->Profanity_filter_cache->cleanup_old_cache($days);

        redirect('admin_profanity_monitor');
    }

    /**
     * Get cache statistics via AJAX
     */
    public function get_stats_ajax() {
        $this->output->set_content_type('application/json');
        
        $stats = $this->Profanity_filter_cache->get_stats();
        
        echo json_encode([
            'total_cached' => $stats->total_cached,
            'profanity_found' => $stats->profanity_found_count,
            'avg_processing_time' => round($stats->avg_processing_time, 2)
        ]);
    }

}
