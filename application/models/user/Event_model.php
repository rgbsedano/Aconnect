<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

    public function get_all_events($alumni_id = null) {
        $this->db->select('events.*');
        if ($alumni_id) {
            $this->db->select('IF(event_registrations.id IS NOT NULL, 1, 0) as is_registered');
            $this->db->join('event_registrations', 'event_registrations.event_id = events.id AND event_registrations.alumni_id = ' . $alumni_id, 'left');
        }
        $this->db->order_by('event_date', 'DESC');
        return $this->db->get('events')->result();
    }

    public function get_alumni_id_by_student_number($student_number) {
        $this->db->select('id');
        $this->db->from('alumni');
        $this->db->where('student_number', $student_number);
        $query = $this->db->get();
        $row = $query->row();

        return $row ? $row->id : null;
    }

    public function register_to_event($event_id, $alumni_id) {
        // Prevent duplicate registration
        $this->db->where(['event_id' => $event_id, 'alumni_id' => $alumni_id]);
        $exists = $this->db->get('event_registrations')->row();

        if (!$exists) {
            $this->db->insert('event_registrations', [
                'event_id' => $event_id,
                'alumni_id' => $alumni_id
            ]);
        }
    }
}
