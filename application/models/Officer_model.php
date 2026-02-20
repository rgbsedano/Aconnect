<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Officer_model extends CI_Model {

    private $table = 'alumni_officers';

    // ===============================
    // GET ALL OFFICERS (ADMIN)
    // ===============================
    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')
                        ->get($this->table)
                        ->result();
    }

    // ===============================
    // GET ACTIVE OFFICERS (ALUMNI VIEW)
    // ===============================
    public function get_active()
    {
        return $this->db->where('status', 1)
                        ->order_by('position', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    // ===============================
    // GET SINGLE OFFICER
    // ===============================
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                        ->get($this->table)
                        ->row();
    }

    // ===============================
    // INSERT OFFICER
    // ===============================
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ===============================
    // UPDATE OFFICER
    // ===============================
    public function update($id, $data)
    {
        return $this->db->where('id', $id)
                        ->update($this->table, $data);
    }

    // ===============================
    // DELETE OFFICER
    // ===============================
    public function delete($id)
    {
        return $this->db->where('id', $id)
                        ->delete($this->table);
    }
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_paginated($limit, $start)
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->limit($limit, $start)
            ->get($this->table)
            ->result();
    }

    public function count_search($keyword = null)
{
    if (!empty($keyword)) {
        $this->db->group_start()
            ->like('full_name', $keyword)
            ->or_like('position', $keyword)
            ->or_like('email', $keyword)
        ->group_end();
    }

    return $this->db->count_all_results($this->table);
}

public function search_paginated($limit, $start, $keyword = null)
{
    if (!empty($keyword)) {
        $this->db->group_start()
            ->like('full_name', $keyword)
            ->or_like('position', $keyword)
            ->or_like('email', $keyword)
        ->group_end();
    }

    return $this->db
        ->order_by('id', 'DESC')
        ->limit($limit, $start)
        ->get($this->table)
        ->result();
}
}