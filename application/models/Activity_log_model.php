<?php
class Activity_log_model extends CI_Model {

    public function log_activity($alumni_id, $activity) {
        $data = [
            'alumni_id' => $alumni_id,
            'activity' => $activity,
        ];
        $this->db->insert('activity_logs', $data);
    }

    public function get_logs_by_alumni($alumni_id) {
        return $this->db->where('alumni_id', $alumni_id)
                        ->order_by('created_at', 'DESC')
                        ->get('activity_logs')
                        ->result();
    }

    public function get_all_logs() {
        return $this->db->select('activity_logs.*, alumni.first_name, alumni.last_name')
                        ->from('activity_logs')
                        ->join('alumni', 'alumni.id = activity_logs.alumni_id')
                        ->order_by('activity_logs.created_at', 'DESC')
                        ->get()
                        ->result();
    }
    public function get_logs_count($search = '') {
        $this->db->from('activity_logs');
        $this->db->join('alumni', 'alumni.id = activity_logs.alumni_id');
    
        if (!empty($search)) {
            $this->db->group_start()
                ->like('alumni.first_name', $search)
                ->or_like('alumni.last_name', $search)
                ->or_like('activity_logs.activity', $search)
                ->group_end();
        }
    
        return $this->db->count_all_results();
    }
    
    public function get_logs_paginated($limit, $start, $search = '') {
        $this->db->select('activity_logs.*, alumni.first_name, alumni.last_name');
        $this->db->from('activity_logs');
        $this->db->join('alumni', 'alumni.id = activity_logs.alumni_id');
        $this->db->order_by('activity_logs.created_at', 'DESC');
    
        if (!empty($search)) {
            $this->db->group_start()
                ->like('alumni.first_name', $search)
                ->or_like('alumni.last_name', $search)
                ->or_like('activity_logs.activity', $search)
                ->group_end();
        }
    
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function get_logs_with_search($search = null, $limit = 15, $offset = 0) {
        $this->db->select('activity_logs.*, alumni.first_name, alumni.last_name');
        $this->db->from('activity_logs');
        $this->db->join('alumni', 'activity_logs.alumni_id = alumni.id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('alumni.first_name', $search);
            $this->db->or_like('alumni.last_name', $search);
            $this->db->or_like('activity_logs.activity', $search);
            $this->db->group_end();
        }

        $this->db->order_by('activity_logs.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_logs_with_search($search = null) {
        $this->db->from('activity_logs');
        $this->db->join('alumni', 'activity_logs.alumni_id = alumni.id');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('alumni.first_name', $search);
            $this->db->or_like('alumni.last_name', $search);
            $this->db->or_like('activity_logs.activity', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }
    
    
}
