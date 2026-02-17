<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

    public function get_user_by_student_number($student_number) {
        $this->db->where('student_number', $student_number);
        $query = $this->db->get('alumni');
        return $query->row(); // return single row object
    }

    public function get_admin_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('admin_users');
        return $query->row(); // return single row object
    }

    // New: fetch admin by email
    public function get_admin_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('admin_users');
        return $query->row();
    }
}
