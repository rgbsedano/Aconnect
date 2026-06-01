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

    public function get_user_by_email($email)
    {
        return $this->db->get_where('alumni', ['email' => $email])->row();
    }

    public function save_reset_token($email, $token)
    {
        $this->db->where('email', $email);
        $this->db->update('alumni', [
            'reset_token' => $token,
            'token_created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_user_by_token($token)
    {
        return $this->db->get_where('alumni', ['reset_token' => $token])->row();
    }

    public function update_password_by_token($token, $password)
    {
        $this->db->where('reset_token', $token);
        $this->db->update('alumni', [
            'password' => $password,
            'reset_token' => NULL,
            'token_created_at' => NULL
        ]);
    }

    /**
     * Authenticate employer login
     * @param string $email
     * @param string $password
     * @return object|false
     */
    public function login_employer($email, $password)
    {
        // Check if employers table exists
        if (!$this->db->table_exists('employers')) {
            return false;
        }

        // Query for employer by email
        $this->db->where('email', $email);
        $query = $this->db->get('employers');
        $employer = $query->row();

        // If employer not found
        if (!$employer) {
            return false;
        }

        // Verify password - check if it's bcrypt hashed or plain text
        if (!password_verify($password, $employer->password) && $password !== $employer->password) {
            return false;
        }

        $approval_status = strtolower(trim((string) ($employer->approval_status ?? 'pending')));

        if ($approval_status === 'pending' || $approval_status === 'rejected') {
            return false;
        }

        if ((int) ($employer->is_active ?? 0) !== 1) {
            return false;
        }

        return $employer;
    }
}
