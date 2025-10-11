<?php
class Alumni_model extends CI_Model {

    public function get_alumni_by_id($id) {
        return $this->db->get_where('alumni', ['id' => $id])->row();
    }


    public function get_all_except($exclude_id) {
        $this->db->where('id !=', $exclude_id);
        return $this->db->get('alumni')->result();
    }
    public function search_alumni($current_user_id, $search = '') {
        $this->db->select('a.*, cr.status AS connection_status');
        $this->db->from('alumni a');
        $this->db->where('a.id !=', $current_user_id);

        if (!empty($search)) {
            $this->db->group_start()
                     ->like('a.first_name', $search)
                     ->or_like('a.last_name', $search)
                     ->group_end();
        }

        $this->db->join(
            'connection_requests cr',
            "(cr.sender_id = $current_user_id AND cr.receiver_id = a.id)
             OR (cr.receiver_id = $current_user_id AND cr.sender_id = a.id)",
            'left'
        );

        return $this->db->get()->result();
    }

    public function connection_exists($sender_id, $receiver_id) {
        $this->db->where('sender_id', $sender_id);
        $this->db->where('receiver_id', $receiver_id);
        return $this->db->get('connection_requests')->row();
    }

    public function send_connection_request($sender_id, $receiver_id) {
        $this->db->insert('connection_requests', [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending'
        ]);
    }
    // Get incoming pending requests for current user
public function get_pending_requests($alumni_id) {
    $this->db->select('cr.*, a.first_name, a.last_name, a.profile_image');
    $this->db->from('connection_requests cr');
    $this->db->join('alumni a', 'a.id = cr.sender_id');
    $this->db->where('cr.receiver_id', $alumni_id);
    $this->db->where('cr.status', 'pending');
    return $this->db->get()->result();
}

// Accept request
public function accept_request($request_id) {
    $this->db->where('id', $request_id);
    return $this->db->update('connection_requests', ['status' => 'accepted']);
}

// Decline request
public function decline_request($request_id) {
    $this->db->where('id', $request_id);
    return $this->db->update('connection_requests', ['status' => 'declined']);
}
// Check if 2 users are connected
public function is_connected($user1, $user2) {
    $this->db->where("(sender_id = $user1 AND receiver_id = $user2) OR (sender_id = $user2 AND receiver_id = $user1)");
    $this->db->where('status', 'accepted');
    return $this->db->get('connection_requests')->num_rows() > 0;
}

// Get chat history between 2 users
public function get_messages($user1, $user2) {
    $this->db->where("(
        (sender_id = $user1 AND receiver_id = $user2) OR
        (sender_id = $user2 AND receiver_id = $user1)
    )");
    $this->db->order_by('sent_at', 'ASC');
    return $this->db->get('messages')->result();
}

// Send a message
public function send_message($sender_id, $receiver_id, $message) {
    return $this->db->insert('messages', [
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'message' => $message
    ]);
}
// Get all connected alumni for the current user
public function get_connections($alumni_id) {
    $this->db->select('a.id, a.first_name, a.last_name, a.profile_image, a.gender');
    $this->db->from('connection_requests cr');
    $this->db->join('alumni a', 'a.id = IF(cr.sender_id = '.$alumni_id.', cr.receiver_id, cr.sender_id)');
    $this->db->where('cr.status', 'accepted');
    $this->db->where('('.
        '(cr.sender_id = '.$alumni_id.' AND cr.status = "accepted") OR '.
        '(cr.receiver_id = '.$alumni_id.' AND cr.status = "accepted")'.
    ')');
    return $this->db->get()->result();
    }

    public function insert($data) {
        return $this->db->insert('alumni', $data);
    }

    public function get_alumni_count($search = '')
    {
        if (!empty($search)) {
            $this->db->group_start()
                ->like('first_name', $search)
                ->or_like('last_name', $search)
                ->or_like('email', $search)
                ->or_like('student_number', $search)
                ->group_end();
        }
        return $this->db->count_all_results('alumni');
    }
    
    public function get_alumni_paginated($limit, $start, $search = '')
    {
        if (!empty($search)) {
            $this->db->group_start()
                ->like('first_name', $search)
                ->or_like('last_name', $search)
                ->or_like('email', $search)
                ->or_like('student_number', $search)
                ->group_end();
        }
    
        $this->db->limit($limit, $start);
        return $this->db->get('alumni')->result_array();
    }



    // Update alumni record
    public function update_alumni($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('alumni', $data);
    }

    // Optional: If you ever need to get all alumni (e.g., admin side)
    public function get_all_alumni()
    {
        return $this->db->get('alumni')->result();
    }

}
