<?php

// application/controllers/PostController.php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostController extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
            redirect(base_url("Login"));
        }
        $this->load->model('user/Post_model');
    }

public function index() {
    // allow viewing posts even if graduation_year not set
    $user_batch = $this->session->userdata('graduation_year'); 

    $this->load->view('__header');

    $this->load->helper('text');
    $all_posts = $this->Post_model->get_all_posts();

    // If you want to filter by batch when available, do it here.
    if ($user_batch) {
        // Example: only include posts targeted to that batch (if your post has recipient_batch)
        // $filtered = array_filter($all_posts, function($p) use ($user_batch) {
        //     return (empty($p->recipient_batch) || in_array($user_batch, explode(',', $p->recipient_batch)));
        // });
        // $all_posts = array_values($filtered);
    }

    $grouped_posts = [];
    foreach ($all_posts as $post) {
        $pt = isset($post->post_type) && $post->post_type ? $post->post_type : 'general';
        $grouped_posts[$pt][] = $post;
    }

    $this->load->view('user/posts_view', ['grouped_posts' => $grouped_posts]);
    $this->load->view('__footer');
}

}