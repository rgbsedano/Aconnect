<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'email']);
        $this->load->helper(['url', 'form', 'security']);
        $this->load->model('Employer_model');
    }

    private function require_admin_access()
    {
        $login_status = $this->session->userdata('login_status');
        $role = strtolower(trim((string) $this->session->userdata('role')));

        if (! $login_status || ! in_array($role, ['administrator', 'admin'], TRUE)) {
            redirect('adminlogin');
            return FALSE;
        }

        return TRUE;
    }

    public function pending_employers()
    {
        if (! $this->require_admin_access()) {
            return;
        }

        $search = trim((string) $this->input->get('search', TRUE));

        // pagination settings per tab
        $results_per_page = 6;

        // pending tab pagination
        $pending_page = (int) $this->input->get('pending_page', TRUE);
        if ($pending_page < 1) $pending_page = 1;
        $pending_offset = ($pending_page - 1) * $results_per_page;
        $total_pending = $this->Employer_model->count_pending_employers($search);
        $total_pending_pages = (int) max(1, ceil($total_pending / $results_per_page));
        if ($pending_page > $total_pending_pages) { $pending_page = $total_pending_pages; $pending_offset = ($pending_page -1) * $results_per_page; }

        // approved tab pagination
        $approved_page = (int) $this->input->get('approved_page', TRUE);
        if ($approved_page < 1) $approved_page = 1;
        $approved_offset = ($approved_page - 1) * $results_per_page;
        $total_approved = $this->Employer_model->count_approved_employers($search);
        $total_approved_pages = (int) max(1, ceil($total_approved / $results_per_page));
        if ($approved_page > $total_approved_pages) { $approved_page = $total_approved_pages; $approved_offset = ($approved_page -1) * $results_per_page; }

        // fetch paginated lists
        $pending_list = $this->Employer_model->get_pending_employers_paginated($results_per_page, $pending_offset, $search);
        $approved_list = $this->Employer_model->get_approved_employers_paginated($results_per_page, $approved_offset, $search);

        // build pagination links preserving other query params
        $this->load->helper('admin_pagination');
        $base = base_url('Admin/pending_employers');
        $pending_params = [];
        $approved_params = [];
        if ($search !== '') {
            $pending_params['search'] = $search;
            $approved_params['search'] = $search;
        }

        $pending_links = admin_build_pagination_links($base, $pending_params, $pending_page, $total_pending_pages, 'pending_page');
        $approved_links = admin_build_pagination_links($base, $approved_params, $approved_page, $total_approved_pages, 'approved_page');

        // rejected tab pagination
        $rejected_page = (int) $this->input->get('rejected_page', TRUE);
        if ($rejected_page < 1) $rejected_page = 1;
        $rejected_offset = ($rejected_page - 1) * $results_per_page;
        $total_rejected = $this->Employer_model->count_rejected_employers($search);
        $total_rejected_pages = (int) max(1, ceil($total_rejected / $results_per_page));
        if ($rejected_page > $total_rejected_pages) { $rejected_page = $total_rejected_pages; $rejected_offset = ($rejected_page -1) * $results_per_page; }

        $rejected_list = $this->Employer_model->get_rejected_employers_paginated($results_per_page, $rejected_offset, $search);
        $rejected_params = [];
        if ($search !== '') {
            $rejected_params['search'] = $search;
        }
        $rejected_links = admin_build_pagination_links($base, $rejected_params, $rejected_page, $total_rejected_pages, 'rejected_page');

        $data = [
            'pending_employers' => $pending_list,
            'approved_employers' => $approved_list,
            'rejected_employers' => $rejected_list,
            'pagination_pending_links' => $pending_links,
            'pagination_approved_links' => $approved_links,
            'pagination_rejected_links' => $rejected_links,
            'search' => $search,
        ];

        $this->load->view('__header');
        $this->load->view('admin/pending_employers', $data);
        $this->load->view('__footer');
    }

    /**
     * AJAX: return rendered rows for a given status filtered by search
     */
    public function ajax_search_employers()
    {
        if (! $this->require_admin_access()) {
            echo json_encode(['html' => '']);
            return;
        }

        $search = trim((string) $this->input->get('search', TRUE));
        $status = (string) $this->input->get('status', TRUE);
        if ($status === '') $status = 'pending';

        $limit = 50;
        $offset = 0;

        if ($status === 'pending') {
            $list = $this->Employer_model->get_pending_employers_paginated($limit, $offset, $search);
        } elseif ($status === 'approved') {
            $list = $this->Employer_model->get_approved_employers_paginated($limit, $offset, $search);
        } else {
            $list = $this->Employer_model->get_rejected_employers_paginated($limit, $offset, $search);
        }

        $html = $this->load->view('admin/_employer_rows', ['employers' => $list, 'status' => $status], TRUE);

        echo json_encode(['html' => $html]);
    }

    public function verify_employer($id, $action)
    {
        if (! $this->require_admin_access()) {
            return;
        }

        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $id = (int) $id;
        $action = strtolower(trim((string) $action));

        if ($id <= 0 || ! in_array($action, ['approve', 'reject'], TRUE)) {
            show_404();
            return;
        }

        $employer = $this->Employer_model->get_employer_by_id($id);

        if (empty($employer)) {
            $this->session->set_flashdata('error_message', 'Employer record not found.');
            redirect('Admin/pending_employers');
            return;
        }

        if (strtolower(trim((string) ($employer['approval_status'] ?? 'pending'))) !== 'pending') {
            $this->session->set_flashdata('error_message', 'This employer has already been processed.');
            redirect('Admin/pending_employers');
            return;
        }

        $updated = $this->Employer_model->update_approval_status($id, $action);

        if (! $updated) {
            $this->session->set_flashdata('error_message', 'Unable to update employer approval status.');
            redirect('Admin/pending_employers');
            return;
        }

        $email_sent = $this->send_employer_notification($employer, $action);

        if ($action === 'approve') {
            $message = $email_sent
                ? 'Employer approved and notification email sent.'
                : 'Employer approved, but the notification email could not be sent.';
        } else {
            $message = $email_sent
                ? 'Employer rejected and notification email sent.'
                : 'Employer rejected, but the notification email could not be sent.';
        }

        $this->session->set_flashdata('success_message', $message);
        redirect('Admin/pending_employers');
    }

    private function send_employer_notification(array $employer, $action)
    {
        $action = strtolower(trim((string) $action));
        $company_name = html_escape((string) ($employer['company_name'] ?? ''));
        $first_name = html_escape((string) ($employer['first_name'] ?? 'Employer'));
        $email = trim((string) ($employer['email'] ?? ''));

        if ($email === '') {
            return FALSE;
        }

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => env_value('ACONNECT_SMTP_HOST', 'smtp.hostinger.com'),
            'smtp_port' => (int) env_value('ACONNECT_SMTP_PORT', 465),
            'smtp_user' => env_value('ACONNECT_SMTP_USER', 'aconnect_admin@sdcaconnect.online'),
            'smtp_pass' => env_value('ACONNECT_SMTP_PASS', ''),
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n",
            'smtp_crypto' => env_value('ACONNECT_SMTP_CRYPTO', 'ssl'),
            'smtp_timeout' => 30,
            'wordwrap' => TRUE,
        ];

        $this->email->initialize($config);
        $this->email->from('aconnect_admin@sdcaconnect.online', 'AConnect Admin');
        $this->email->to($email);

        if ($action === 'approve') {
            $this->email->subject('Your Employer Account Has Been Approved');
            $message = '<p>Hello ' . $first_name . ',</p>'
                . '<p>Your employer account for <strong>' . $company_name . '</strong> has been approved.</p>'
                . '<p>You can now sign in to post jobs and manage your employer profile.</p>'
                . '<p>Regards,<br>AConnect Administration</p>';
        } else {
            $this->email->subject('Your Employer Account Was Rejected');
            $message = '<p>Hello ' . $first_name . ',</p>'
                . '<p>After review, your employer account for <strong>' . $company_name . '</strong> was not approved.</p>'
                . '<p>If you believe this was a mistake, please contact the AConnect administrator for clarification.</p>'
                . '<p>Regards,<br>AConnect Administration</p>';
        }

        $this->email->message($message);

        return (bool) $this->email->send();
    }
}