<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_login_activity_per_month($months_back = 12) {
        $this->db->select("DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS total_logins", false);
        $this->db->from('activity_logs');
        $this->db->where("activity", 'Logged in');
        $this->db->group_by('month');
        $this->db->order_by('month', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_event_participation() {
        $sql = "SELECT e.id, e.event_name, COUNT(r.id) AS participants
                FROM events e
                LEFT JOIN event_registrations r ON r.event_id = e.id
                GROUP BY e.id
                ORDER BY participants DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_job_applications_summary() {
        $sql = "SELECT j.id, j.job_title, COUNT(a.id) AS applicants
                FROM jobs j
                LEFT JOIN job_applications a ON a.job_id = j.id
                GROUP BY j.id
                ORDER BY applicants DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_tracer_summary() {
        if ($this->db->table_exists('tracer_responses')) {
            $table = 'tracer_responses';
            $col = 'employment_status';
            if (! $this->db->field_exists($col, $table)) {
                $col = 'currently_employed';
            }
        } else {
            $table = 'tracer_study';
            $col = $this->db->field_exists('currently_employed', $table) ? 'currently_employed' : 'currently_employed';
        }

        $sql = "SELECT {$col} AS status, COUNT(*) AS total FROM {$table} GROUP BY {$col}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_tracer_export_rows() {
        if ($this->db->table_exists('tracer_responses')) {
            $table = 'tracer_responses';
        } else {
            $table = 'tracer_study';
        }

        $sql = "SELECT t.*, a.first_name, a.last_name, a.email, a.student_number
                FROM {$table} t
                LEFT JOIN alumni a ON a.id = t.alumni_id
                ORDER BY t.created_at DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_event_export_rows() {
        $sql = "SELECT e.event_name, e.event_date, a.first_name, a.last_name, ar.registered_at
                FROM event_registrations ar
                JOIN events e ON e.id = ar.event_id
                LEFT JOIN alumni a ON a.id = ar.alumni_id
                ORDER BY e.event_date DESC, a.last_name ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
