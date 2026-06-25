<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminOfficers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Officer_model');
        $this->load->helper(['url', 'form','text', 'admin_pagination']);
        $this->load->library(['session']);
        
    }

    // ===============================
    // LIST ALL OFFICERS (ADMIN VIEW)
    // ===============================
    public function index()
    {
        $results_per_page = 5;
        $page = (int) $this->input->get('page', TRUE);
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $results_per_page;

        $keyword = trim((string) $this->input->get('keyword', TRUE));

        $total_records = $keyword !== ''
            ? $this->Officer_model->count_search($keyword)
            : $this->Officer_model->count_all();

        $total_pages = (int) ceil($total_records / $results_per_page);
        if ($total_pages < 1) $total_pages = 1;
        if ($page > $total_pages) {
            $page = $total_pages;
            $offset = ($page - 1) * $results_per_page;
        }

        $data['officers'] = $keyword !== ''
            ? $this->Officer_model->search_paginated($results_per_page, $offset, $keyword)
            : $this->Officer_model->get_paginated($results_per_page, $offset);

        $params = [];
        if ($keyword !== '') $params['keyword'] = $keyword;
        $data['pagination'] = admin_build_pagination_links(base_url('AdminOfficers'), $params, $page, $total_pages);

        $this->load->view('__header');
        $this->load->view('admin/manage_officers', $data);
        $this->load->view('__footer');
    }
    // ===============================
    // SAVE NEW OFFICER (MODAL)
    // ===============================
    public function store()
    {
        $photo = $this->_upload_photo();

        // ❗ if user selected file but upload failed → STOP
        if (!empty($_FILES['photo']['name']) && !$photo) {
            redirect('AdminOfficers');
            return;
        }

        $data = [
            'full_name' => ucwords(strtolower(trim($this->input->post('full_name')))),
            'gender'    => $this->input->post('gender'), 
            'position'  => $this->input->post('position'),
            'email'     => $this->input->post('email'),
            'bio'       => $this->input->post('bio'),
            'photo'     => $photo,
            'status'    => $this->input->post('status')
        ];

        $this->Officer_model->insert($data);

        $this->session->set_flashdata('success', 'Officer added successfully.');
        $this->session->set_flashdata('success_source', 'officers');

        redirect('AdminOfficers');
    }

    // ===============================
    // UPDATE OFFICER (MODAL)
    // ===============================
    public function update($id)
    {
        $officer = $this->Officer_model->get_by_id($id);

        $photo = $officer ? $officer->photo : null;

        if (!empty($_FILES['photo']['name'])) {

            $newPhoto = $this->_upload_photo();

            // ❗ stop if upload failed
            if (!$newPhoto) {
                redirect('AdminOfficers');
                return;
            }

            // ✅ DELETE OLD PHOTO (IMPORTANT)
            if (!empty($officer->photo)) {
                $this->_delete_photo_file($officer->photo);
            }

            $photo = $newPhoto;
        }

        $data = [
            'full_name' => ucwords(strtolower(trim($this->input->post('full_name')))),
            'gender'    => $this->input->post('gender'), 
            'position'  => $this->input->post('position'),
            'email'     => $this->input->post('email'),
            'bio'       => $this->input->post('bio'),
            'photo'     => $photo,
            'status'    => $this->input->post('status')
        ];

        $this->Officer_model->update($id, $data);

        $this->session->set_flashdata('success', 'Officer updated successfully.');
        $this->session->set_flashdata('success_source', 'officers');
        redirect('AdminOfficers');
    }

    // ===============================
    // DELETE OFFICER
    // ===============================
   public function delete($id)
    {
        $officer = $this->Officer_model->get_by_id($id);

        // ✅ delete photo file first
        if ($officer && !empty($officer->photo)) {
            $this->_delete_photo_file($officer->photo);
        }

        // ✅ delete database row
        $this->Officer_model->delete($id);

        $this->session->set_flashdata('success', 'Officer deleted successfully.');
        $this->session->set_flashdata('success_source', 'officers');

        redirect('AdminOfficers');
    }

    // ===============================
    // AJAX: GET SINGLE OFFICER
    // ===============================
    public function get_officer()
    {
        $id = $this->input->post('id');

        if (!$id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(null));
            return;
        }

        $officer = $this->Officer_model->get_by_id($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($officer ?: null));
    }

    // ===============================
    // PHOTO UPLOAD HELPER
    // ===============================
   private function _upload_photo()
    {

        if (empty($_FILES['photo']['name'])) {
                return null;
            }
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        $allowed_ext = ['jpg','jpeg','png','gif','jfif','webp'];

        if (!in_array($ext, $allowed_ext)) {
            $this->session->set_flashdata('error', 'File type not allowed.');
            $this->session->set_flashdata('error_source', 'officers');
            return null;
        }

        

        // ⭐ normalize mime
        if (function_exists('mime_content_type') && !empty($_FILES['photo']['tmp_name'])) {
            $_FILES['photo']['type'] = mime_content_type($_FILES['photo']['tmp_name']);
        }

        $config['upload_path']      = FCPATH . 'assets/uploads/officers/';
        $config['allowed_types'] = '*';
        $config['max_size']         = 5120;
        $config['encrypt_name']     = TRUE;
        $config['detect_mime']      = FALSE;
        $config['mod_mime_fix']     = FALSE;
        $config['file_ext_tolower'] = TRUE;
        $config['remove_spaces']    = TRUE;
        $config['overwrite']        = FALSE;
        $config['max_filename']     = 0;

        $this->load->library('upload', $config, 'officer_upload');
        $this->officer_upload->initialize($config);

        if ($this->officer_upload->do_upload('photo')) {

            $file = $this->officer_upload->data();
            return 'assets/uploads/officers/' . $file['file_name'];

        } else {

            $realError = $this->officer_upload->display_errors('', '');

            $this->session->set_flashdata(
                'error',
                'Upload failed: ' . $realError
            );
            $this->session->set_flashdata('error_source', 'officers');

            return null;
        }
    }


    public function search()
    {
        $this->load->library('pagination');

        $keyword = $this->input->get('keyword');

        $config['base_url'] = site_url('AdminOfficers/search');
        $config['total_rows'] = $this->Officer_model->count_search($keyword);
        $config['per_page'] = 5;

        // ✅ use query string pagination
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'per_page';
        $config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        // ✅ ONLY THIS — DO NOT USE uri->segment
        $page = $this->input->get('per_page');
        $page = ($page) ? $page : 0;

        $data['officers'] = $this->Officer_model->search_paginated(
            $config['per_page'],
            $page,
            $keyword
        );

        $data['pagination'] = $this->pagination->create_links();

        // ✅ partial only
        $this->load->view('admin/partials/officers_table', $data);
    }
    private function _delete_photo_file($photoPath)
    {
        if (!empty($photoPath)) {

            $fullPath = FCPATH . $photoPath;

            if (file_exists($fullPath) && is_file($fullPath)) {
                @unlink($fullPath); // safe delete
            }
        }
    }

    public function alumni_view()
    {
        $data['officers'] = $this->Officer_model->get_active();

        $this->load->view('__header');
        $this->load->view('alumni/officers', $data); // ✅ your filename
        $this->load->view('__footer');
    }


}