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
        $user_batch = $this->session->userdata('graduation_year'); // Example batch (this should come from the logged-in user session)
        $this->load->view('__header');

        if (!$user_batch) {
            show_error("Batch information is missing.", 400);
            return;
        }

        $this->load->helper('text');
        $all_posts = $this->Post_model->get_all_posts();
        $grouped_posts = [];

        foreach ($all_posts as $post) {
            $grouped_posts[$post->post_type][] = $post;
        }

        $this->load->view('user/posts_view', ['grouped_posts' => $grouped_posts]);
		
        $this->load->view('__footer');
    
    }
}
