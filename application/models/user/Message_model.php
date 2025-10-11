<?php 
class Message_model extends CI_Model {

    public function get_messages($sender_id, $receiver_id) {
        return $this->db->where("(sender_id = $sender_id AND receiver_id = $receiver_id) OR (sender_id = $receiver_id AND receiver_id = $sender_id)")
                        ->order_by('created_at', 'ASC')
                        ->get('messages')
                        ->result();
    }

    public function send_message($sender_id, $receiver_id, $message) {
        $this->db->insert('messages', [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}