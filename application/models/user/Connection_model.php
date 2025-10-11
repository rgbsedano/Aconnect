<?php
class Connection_model extends CI_Model {

    public function send_request($sender_id, $receiver_id) {
        $data = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('connections', $data);
    }

    public function respond_request($connection_id, $response) {
        $this->db->where('id', $connection_id)
                 ->update('connections', [
                     'status' => $response,
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
    }

    public function get_requests($user_id) {
        return $this->db->select('c.*, a.first_name, a.last_name')
                        ->from('connections c')
                        ->join('alumni a', 'a.id = c.sender_id')
                        ->where('c.receiver_id', $user_id)
                        ->where('c.status', 'pending')
                        ->get()->result();
    }

    public function get_connections($user_id) {
        return $this->db->query("SELECT a.* FROM alumni a
            JOIN connections c ON (a.id = c.receiver_id AND c.sender_id = ? OR a.id = c.sender_id AND c.receiver_id = ?)
            WHERE c.status = 'accepted' AND a.id != ?", [$user_id, $user_id, $user_id])->result();
    }

    public function check_connection_status($user_id, $other_id) {
        $query = $this->db->where("(sender_id = $user_id AND receiver_id = $other_id) OR (sender_id = $other_id AND receiver_id = $user_id)")
                          ->get('connections');
        return $query->row();
    }
}