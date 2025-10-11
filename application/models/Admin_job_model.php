<?php
class Admin_job_model extends CI_Model {

    public function get_all_jobs() {
        return $this->db->get('jobs')->result_array();
    }

    public function create_job($data) {
        return $this->db->insert('jobs', $data);
    }

    public function update_job($id, $data) {
        return $this->db->where('id', $id)->update('jobs', $data);
    }


    public function get_job($id) {
        return $this->db->where('id', $id)->get('jobs')->row_array();
    }

    public function get_applicants_by_job($job_id) {
        $this->db->select('a.student_number, a.first_name, a.last_name, a.email, a.graduation_year, a.degree');
        $this->db->from('job_applications ja');
        $this->db->join('alumni a', 'ja.alumni_id = a.id');
        $this->db->where('ja.job_id', $job_id);
        return $this->db->get()->result_array();
    }

    public function get_job_by_id($id)
    {
        $query = $this->db->get_where('jobs', ['id' => $id]);
        return $query->row_array(); // returns associative array or null
    }

    public function delete_job($id)
{
    return $this->db->delete('jobs', ['id' => $id]);
}

}
