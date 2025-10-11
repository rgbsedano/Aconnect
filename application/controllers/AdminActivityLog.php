<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Dompdf\Dompdf;
use Dompdf\Options;

class AdminActivityLog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Activity_log_model');
        $this->load->model('user/Alumni_model');
        $this->load->library('pagination');
        date_default_timezone_set('Asia/Manila');
    }

    public function index() {
        $this->load->library('pagination');
        $search = $this->input->get('search');
        $limit = 15;
        $start = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
    
        // Get total rows for pagination
        $total_rows = $this->Activity_log_model->get_logs_count($search);
    
        // Pagination configuration
        $config['base_url'] = site_url('AdminActivityLog/') . ($search ? '?search=' . urlencode($search) : '');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'per_page';
    
        // Bootstrap 4 pagination styling
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
    
        $this->pagination->initialize($config);
    
        $data['logs'] = $this->Activity_log_model->get_logs_paginated($limit, $start, $search);
        $data['pagination'] = $this->pagination->create_links();

         
        $data['current_page'] = ($start / $limit) + 1;
        $data['total_pages'] = ceil($total_rows / $limit);

    
        $this->load->view('__header');
        $this->load->view('admin/activity_log', $data);
        $this->load->view('__footer');
    }

    public function download() {
        $search = $this->input->get('search');
        $page = $this->input->get('page') ?? 1;
        $per_page = $this->input->get('per_page') ?? 15;
        $offset = ($page - 1) * $per_page;

        if (!empty($search)) {
            $logs = $this->Activity_log_model->get_logs_with_search($search, $per_page, $offset);
        } else {
            // No search = fetch ALL logs
            $logs = $this->Activity_log_model->get_logs_with_search(null, 999999, 0);
        }
        
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Activity Logs');
    
        // Set headers
        $sheet->setCellValue('A1', 'Alumni Name');
        $sheet->setCellValue('B1', 'Activity');
        $sheet->setCellValue('C1', 'Date & Time');
    
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);
    
        // Insert data
        $row = 2;
        foreach ($logs as $log) {
            $sheet->setCellValue("A{$row}", $log->first_name . ' ' . $log->last_name);
            $sheet->setCellValue("B{$row}", $log->activity);
            $sheet->setCellValue("C{$row}", \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($log->created_at)));
    
            // Set date column format
            $sheet->getStyle("C{$row}")->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_DATE_DATETIME);
    
            $row++;
        }
    
        // Auto size columns
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Output to browser
        $writer = new Xlsx($spreadsheet);
        $filename = 'activity_logs_' . date('Ymd_His') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }
    
    public function download_pdf() {
        $search = $this->input->get('search');
        $logs = $this->Activity_log_model->get_logs_with_search($search, 999999, 0); // Fetch all logs or by search
    
        // Load view into a variable
        $data['logs'] = $logs;
        $data['printed_at'] = date('F j, Y g:i A');
        $html = $this->load->view('admin/pdf_activity_log', $data, true);
    
        // Dompdf settings
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Output
        $dompdf->stream('activity_logs_' . date('Ymd_His') . '.pdf', ['Attachment' => 1]);
    }
    
}
