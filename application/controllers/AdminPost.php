<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminPost extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // load needed libs/helpers
        $this->load->database();
        $this->load->helper(['url','text','form','file']);
        $this->load->library(['session']);
        // optionally load model if you have one
        // $this->load->model('Post_model');
    }

    public function index()
    {
        // Auto-migration for carousel table
        if (!$this->db->field_exists('title', 'carousel_photos')) {
            $this->db->query("ALTER TABLE carousel_photos ADD COLUMN title VARCHAR(255) DEFAULT ''");
        }
        if (!$this->db->field_exists('description', 'carousel_photos')) {
            $this->db->query("ALTER TABLE carousel_photos ADD COLUMN description TEXT");
        }

        $data['announcements'] = $this->db->get_where('post', ['post_type' => 'announcements'])->result_array();
        $data['news'] = $this->db->get_where('post', ['post_type' => 'news'])->result_array();
        $data['stories'] = $this->db->get_where('post', ['post_type' => 'stories'])->result_array();
        $data['carousel'] = $this->db->get('carousel_photos')->result_array();

        $this->load->view('__header');
        $this->load->view('admin/manage_post', $data);
        $this->load->view('__footer');
    }

    /**
     * Create new post
     */
    public function create()
    {
        // prepare upload config
        $upload_path = './assets/uploads/post/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 7048, // ~7mb
            'encrypt_name'  => FALSE, // we will prefix with uniqid below
        ];
        $this->load->library('upload', $config);

        $image = '';

        if (!empty($_FILES['image']['name'])) {
            // give unique name
            $_FILES['image']['name'] = uniqid() . '_' . $_FILES['image']['name'];
            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                $image = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                redirect('AdminPost');
                return;
            }
        }

        $admin_id = $this->session->userdata('admin_id') ?: 1;

        $data = [
            'title'           => $this->input->post('title', TRUE),
            'content'         => $this->input->post('content', TRUE),
            'post_type'       => $this->input->post('post_type', TRUE),
            'image'           => $image,
            'recipient_batch' => $this->input->post('recipient_batch', TRUE),
            'created_by'      => $admin_id,
            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('post', $data);
        $this->session->set_flashdata('success', 'Post created successfully.');
        redirect('AdminPost');
    }

    /**
     * Upload single carousel image
     */
    /**
     * Delete carousel image
     */
    public function delete_carousel($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid photo ID.');
            redirect('AdminPost');
            return;
        }

        $photo = $this->db->get_where('carousel_photos', ['id' => $id])->row_array();
        if ($photo) {
            $file = FCPATH . 'assets/uploads/carousel/' . $photo['file_name'];
            if (file_exists($file)) {
                @unlink($file);
            }
            $this->db->where('id', $id)->delete('carousel_photos');
            $this->session->set_flashdata('success', 'Banner removed successfully.');
        } else {
            $this->session->set_flashdata('error', 'Photo not found.');
        }

        redirect('AdminPost');
    }

    public function upload()
    {
        $upload_path = './assets/uploads/carousel/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 7048,
            'file_name'     => time() . '_' . basename($_FILES['carousel_photo']['name'])
        ];
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('carousel_photo')) {
            $data = $this->upload->data();
            $insert_data = [
                'file_name'   => $data['file_name'],
                'title'       => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE)
            ];
            $this->db->insert('carousel_photos', $insert_data);
            $this->session->set_flashdata('success', 'Banner added successfully!');
        } else {
            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
        }

        redirect('AdminPost');
    }

    /**
     * Update carousel image/details
     */
    public function update_carousel($id = null)
    {
        if (!$id) redirect('AdminPost');

        $photo = $this->db->get_where('carousel_photos', ['id' => $id])->row_array();
        if (!$photo) redirect('AdminPost');

        $file_name = $photo['file_name'];

        if (!empty($_FILES['carousel_photo']['name'])) {
            $upload_path = './assets/uploads/carousel/';
            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 7048,
                'file_name'     => time() . '_' . basename($_FILES['carousel_photo']['name'])
            ];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('carousel_photo')) {
                $data = $this->upload->data();
                $file_name = $data['file_name'];
                
                // delete old file
                if (file_exists($upload_path . $photo['file_name'])) {
                    @unlink($upload_path . $photo['file_name']);
                }
            }
        }

        $update_data = [
            'file_name'   => $file_name,
            'title'       => $this->input->post('title', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];

        $this->db->where('id', $id)->update('carousel_photos', $update_data);
        $this->session->set_flashdata('success', 'Banner updated successfully!');
        redirect('AdminPost');
    }

    /**
     * Delete post (and its image file)
     */
    public function delete($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid post ID.');
            redirect('AdminPost');
            return;
        }

        $post = $this->db->get_where('post', ['id' => $id])->row_array();
        if (!$post) {
            $this->session->set_flashdata('error', 'Post not found.');
            redirect('AdminPost');
            return;
        }

        // remove image file if exists
        if (!empty($post['image'])) {
            $file = FCPATH . 'assets/uploads/post/' . $post['image'];
            if (file_exists($file)) {
                @unlink($file);
            }
        }

        $this->db->where('id', $id)->delete('post');
        $this->session->set_flashdata('success', 'Post deleted.');
        redirect('AdminPost');
    }

    /**
     * Update post
     */
    public function update($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid post ID.');
            redirect('AdminPost');
            return;
        }

        $post = $this->db->get_where('post', ['id' => $id])->row_array();
        if (!$post) {
            $this->session->set_flashdata('error', 'Post not found.');
            redirect('AdminPost');
            return;
        }

        // default keep old image
        $image = $post['image'];

        // if new image uploaded, process it
        if (!empty($_FILES['image']['name'])) {
            $upload_path = './assets/uploads/post/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            // ensure unique filename
            $_FILES['image']['name'] = uniqid() . '_' . $_FILES['image']['name'];

            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 7048,
            ];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image = $uploadData['file_name'];

                // delete old file if exists and different
                if (!empty($post['image']) && $post['image'] !== $image) {
                    $oldFile = FCPATH . 'assets/uploads/post/' . $post['image'];
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
            } else {
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                redirect('AdminPost');
                return;
            }
        }

        $admin_id = $this->session->userdata('admin_id') ?: 1;

        $data = [
            'title'           => $this->input->post('title', TRUE),
            'content'         => $this->input->post('content', TRUE),
            'post_type'       => $this->input->post('post_type', TRUE),
            'recipient_batch' => $this->input->post('recipient_batch', TRUE),
            'image'           => $image,
            'updated_by'      => $admin_id,
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id', $id)->update('post', $data);
        $this->session->set_flashdata('success', 'Post updated.');
        redirect('AdminPost');
    }
}
