<?php

class AdminPost extends CI_Controller {

public function index() {
    $this->load->helper('text');

    $this->load->view('__header');
    $data['announcements'] = $this->db->get_where('post', ['post_type' => 'announcements'])->result_array();
    $data['news'] = $this->db->get_where('post', ['post_type' => 'news'])->result_array();
    $data['stories'] = $this->db->get_where('post', ['post_type' => 'stories'])->result_array();

    $this->load->view('admin/manage_post', $data);
	$this->load->view('__footer');

}
public function create() {
    $config['upload_path'] = './assets/uploads/post/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 7048;

    $this->load->library('upload', $config);
    $image = '';

    if ($this->upload->do_upload('image')) {
        $upload_data = $this->upload->data();
        $image = $upload_data['file_name'];
    }

    $data = [
        'title' => $this->input->post('title'),
        'content' => $this->input->post('content'),
        'post_type' => $this->input->post('post_type'),
        'image' => $image,
        'recipient_batch' => $this->input->post('recipient_batch'),
        'created_by' => 1, // Replace with session admin ID if available
    ];

    $this->db->insert('post', $data);
    redirect('AdminPost');
}
public function upload()
    {
        if (!empty($_FILES['carousel_photo']['name'])) {
            $config['upload_path'] = './assets/uploads/carousel/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time() . '_' . $_FILES['carousel_photo']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('carousel_photo')) {
                $data = $this->upload->data();
                $this->db->insert('carousel_photos', ['file_name' => $data['file_name']]);
                $this->session->set_flashdata('success', 'Image uploaded!');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }

        redirect('AdminPost');
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('post');
        redirect('AdminPost');
    }

    public function update($id) {

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './assets/uploads/post/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = uniqid() . '_' . $_FILES['image']['name'];
    
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data['image'] = $uploadData['file_name'];
            }
        }
    
        $data = [
           'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'post_type' => $this->input->post('post_type'),
            'image' => $data['image'],
            'recipient_batch' => $this->input->post('recipient_batch'), 
            'updated_by' => $this->session->set_userdata('admin_id')
        ];
    
        $this->db->where('id', $id)->update('post', $data);
        redirect('AdminEvents');
    }
    

}
