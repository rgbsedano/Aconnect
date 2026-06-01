<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employer_model extends CI_Model {

    private function apply_employer_search($search)
    {
        $search = trim((string) $search);

        if ($search === '') {
            return;
        }

        $this->db->group_start()
            ->like('company_name', $search)
            ->or_like('email', $search)
            ->or_like('first_name', $search)
            ->or_like('last_name', $search)
        ->group_end();
    }

    public function get_pending_employers($search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return [];
        }

        return $this->db
            ->select('id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, created_at')
            ->from('employers')
            ->where('approval_status', 'pending')
            ->order_by('created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_pending_employers_with_search($search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return [];
        }

        $this->db
            ->select('id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, created_at')
            ->from('employers')
            ->where('approval_status', 'pending');
        $this->apply_employer_search($search);

        return $this->db
            ->order_by('created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function count_pending_employers($search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return 0;
        }

        $this->db->from('employers')
            ->where('approval_status', 'pending');
        $this->apply_employer_search($search);

        return (int) $this->db->count_all_results();
    }

    public function get_pending_employers_paginated($limit, $offset, $search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return [];
        }

        $this->db
            ->select('id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, created_at')
            ->from('employers')
            ->where('approval_status', 'pending');
        $this->apply_employer_search($search);

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit((int) $limit, (int) $offset)
            ->get()
            ->result_array();
    }

    public function get_approved_employers($search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return [];
        }

        $this->db
            ->select('id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, created_at')
            ->from('employers')
            ->where('approval_status', 'approved');
        $this->apply_employer_search($search);

        return $this->db
            ->order_by('created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function count_approved_employers($search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return 0;
        }

        $this->db->from('employers')
            ->where('approval_status', 'approved');
        $this->apply_employer_search($search);

        return (int) $this->db->count_all_results();
    }

    public function get_approved_employers_paginated($limit, $offset, $search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return [];
        }

        $this->db
            ->select('id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, created_at')
            ->from('employers')
            ->where('approval_status', 'approved');
        $this->apply_employer_search($search);

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit((int) $limit, (int) $offset)
            ->get()
            ->result_array();
    }

    public function count_rejected_employers($search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return 0;
        }

        $this->db->from('employers')
            ->where('approval_status', 'rejected');
        $this->apply_employer_search($search);

        return (int) $this->db->count_all_results();
    }

    public function get_rejected_employers_paginated($limit, $offset, $search = '')
    {
        if (! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return [];
        }

        $this->db
            ->select('id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, created_at')
            ->from('employers')
            ->where('approval_status', 'rejected');
        $this->apply_employer_search($search);

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit((int) $limit, (int) $offset)
            ->get()
            ->result_array();
    }

    public function get_employer_by_id($id)
    {
        $id = (int) $id;

        if ($id <= 0 || ! $this->db->table_exists('employers')) {
            return [];
        }

        $select = 'id, company_name, first_name, last_name, email, phone, role, account_type, is_active, password, created_at';

        if ($this->db->field_exists('approval_status', 'employers')) {
            $select = 'id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, password, created_at';
        }

        return $this->db
            ->select($select)
            ->from('employers')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    public function get_employer_by_email($email)
    {
        $email = trim((string) $email);

        if ($email === '' || ! $this->db->table_exists('employers')) {
            return [];
        }

        $select = 'id, company_name, first_name, last_name, email, phone, role, account_type, is_active, password, created_at';

        if ($this->db->field_exists('approval_status', 'employers')) {
            $select = 'id, company_name, first_name, last_name, email, phone, role, account_type, is_active, approval_status, password, created_at';
        }

        return $this->db
            ->select($select)
            ->from('employers')
            ->where('email', $email)
            ->limit(1)
            ->get()
            ->row_array();
    }

    public function update_approval_status($id, $action)
    {
        $id = (int) $id;
        $action = strtolower(trim((string) $action));

        if ($id <= 0 || ! in_array($action, ['approve', 'reject'], TRUE) || ! $this->db->table_exists('employers') || ! $this->db->field_exists('approval_status', 'employers')) {
            return FALSE;
        }

        $data = $action === 'approve'
            ? ['approval_status' => 'approved', 'is_active' => 1]
            : ['approval_status' => 'rejected', 'is_active' => 0];

        $this->db->where('id', $id);
        $this->db->where('approval_status', 'pending');

        return (bool) $this->db->update('employers', $data);
    }
}