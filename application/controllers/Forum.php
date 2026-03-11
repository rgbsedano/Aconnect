<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

    public function __construct(){
    parent::__construct();
    $this->load->model('Forum_model');
    $this->load->helper('text'); 
    $this->load->helper('time');
}

    public function index()
    {
        $this->load->view('__header');
        $this->load->library('pagination');

        $limit = 6;
        $page = $this->input->get('page');
        $offset = ($page) ? $page : 0;

        $search = $this->input->get('search');
        $sort = $this->input->get('sort');

        $total = $this->Forum_model->count_posts($search,$sort);

        $config['base_url'] = base_url('forum');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<div class="flex justify-center mt-8"><ul class="flex items-center gap-2">';
        $config['full_tag_close'] = '</ul></div>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><span class="bg-rose-700 text-white px-4 py-2 rounded-lg text-sm font-bold">';
        $config['cur_tag_close'] = '</span></li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['posts'] = $this->Forum_model->get_posts($limit,$offset,$search,$sort);
        $data['pagination'] = $this->pagination->create_links();

        
        $this->load->view('user/forum_list',$data);
        $this->load->view('__footer');
    }

    public function create_post(){

        $image = '';

        if(!empty($_FILES['image']['name'])){
            $config['upload_path'] = './assets/uploads/forum/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload',$config);

            if($this->upload->do_upload('image')){
                $image = $this->upload->data('file_name');
            }
        }

        $data = [
            'alumni_id' => $this->session->userdata('alumni_id'),
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'image' => $image,
            'is_anonymous' => $this->input->post('anonymous') ? 1 : 0
        ];

        $this->Forum_model->insert_post($data);

        redirect('forum');
    }

    public function comment(){

        $data = [
            'post_id'=>$this->input->post('post_id'),
            'parent_id' => $this->input->post('parent_id'),
            'alumni_id'=>$this->session->userdata('alumni_id'),
            'comment'=>$this->input->post('comment'),
            'is_anonymous'=>$this->input->post('anonymous') ? 1 : 0
        ];

        $this->Forum_model->insert_comment($data);

        redirect('forum/view/'.$this->input->post('post_id'));
    }

    public function like($post_id){
        $this->Forum_model->toggle_like($post_id,$this->session->userdata('alumni_id'));
        redirect('forum/view/'.$post_id);
    }

    public function delete($post_id)
    {
        $alumni_id = $this->session->userdata('alumni_id');

        $this->Forum_model->delete_post($post_id, $alumni_id);

         redirect('forum');
    }

    public function report($post_id){

        $data = [
            'post_id'=>$post_id,
            'alumni_id'=>$this->session->userdata('alumni_id'),
            'reason'=>'Reported by user'
        ];

        $this->Forum_model->report_post($data);

         redirect('forum/view/'.$post_id);
    }

    public function view($id = null)
    {
        if(!$id){
            redirect('forum');
        }

        $data['post'] = $this->Forum_model->get_post($id);
        $data['comments'] = $this->Forum_model->get_comments($id);

        $this->load->view('__header');
        $this->load->view('user/forum_view',$data);
        $this->load->view('__footer');
    }

   public function live_search()
{
    $search = $this->input->get('search');
    $sort   = $this->input->get('sort');
    $page   = (int) $this->input->get('page');

    $limit = 6; // same as your normal pagination
    $offset = $page ? $page : 0;

    $posts = $this->Forum_model->get_posts($limit,$offset,$search,$sort);
    $total = $this->Forum_model->count_posts($search,$sort);

    echo json_encode([
        "posts" => $posts,
        "total" => $total
    ]);
}


}