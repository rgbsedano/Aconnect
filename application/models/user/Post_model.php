<?php

// application/models/Post_model.php
class Post_model extends CI_Model {

    public function get_all_posts() {
        return $this->db->order_by('created_at', 'DESC')->get('post')->result();
    }
}
