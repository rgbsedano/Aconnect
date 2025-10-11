<?php
class Support_model extends CI_Model {

    public function get_messages($user_id) {
        $this->db->where("(sender_id = $user_id OR receiver_id = $user_id)");
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get('support_messages');
        return $query->result();
    }

    public function send_message($data) {
        $this->db->insert('support_messages', $data);
    }
    public function get_alumni_support_list()
    {
        $this->db->select('a.id, a.first_name, a.last_name, a.profile_image, a.gender, MAX(sm.created_at) as last_contact');
        $this->db->from('support_messages sm');
        $this->db->join('alumni a', 'a.id = sm.sender_id');
        $this->db->where('sm.is_admin', 0); // messages from alumni
        $this->db->group_by('a.id');
        $this->db->order_by('last_contact', 'DESC');
        return $this->db->get()->result();
    }
    public function get_by_id($id)
    {
        return $this->db->get_where('alumni', ['id' => $id])->row();
    }
}
