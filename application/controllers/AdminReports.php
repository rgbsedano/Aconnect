<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class AdminReports extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url','text']); // text helper for word_limiter
        $this->load->library('session');

        // load models you need
        // if you have separated models, adjust names/paths accordingly
        $this->load->model('Employment_model');
    }

    /**
     * Landing page for reports: shows engagement and employment analytics
     */
    public function index()
    {
        // Read filters from GET
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'status'    => $this->input->get('status', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];

       

        // Engagement analytics (per graduation year)
        $data['engagement_by_year'] = $this->get_engagement_report_data();


     
        // Employment rows (filtered)
        $data['employment_rows'] = $this->get_employment_report_data($filters);
        $data['ai_insights'] = $this->generate_ai_insights(
    $data['employment_rows'],
    $data['engagement_by_year']
);
        $data['filters'] = $filters;

        // whether employment table exists
        $data['employment_enabled'] = $this->db->table_exists('employment');

        // load view
        $this->load->view('__header', $data);
        $this->load->view('admin/reports', $data);
        $this->load->view('__footer', $data);
    }

    /**
     * Engagement analytics per graduation year
     * Returns array of rows: graduation_year, total_alumni, active_alumni, event_registrations, job_applications
     */
    private function get_engagement_report_data()
    {
        $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));

        // total alumni per year
        $alumni_by_year = $this->db
            ->select('graduation_year, COUNT(*) AS total_alumni')
            ->from('alumni')
            ->group_by('graduation_year')
            ->order_by('graduation_year', 'DESC')
            ->get()
            ->result_array();


            // echo print_r($alumni_by_year);exit;
        // active alumni (last 30 days) per year
        $active_by_year = $this->db
            ->select('graduation_year, COUNT(*) AS active_alumni')
            ->from('alumni')
            ->where('last_login >=', $thirty_days_ago)
            ->group_by('graduation_year')
            ->get()
            ->result_array();

            // echo print_r($alumni_by_year);exit;
      
        // job applications per batch (if exists)
        $applications_by_batch = [];
        if ($this->db->table_exists('job_applications')) {
            $applications_by_batch = $this->db
                ->select('a.graduation_year, COUNT(*) AS job_applications')
                ->from('job_applications ja')
                ->join('alumni a', 'a.id = ja.alumni_id', 'left')
                ->group_by('a.graduation_year')
                ->get()
                ->result_array();
        }

        // event registrations per batch (if exists)
        $events_by_batch = [];
        if ($this->db->table_exists('event_registrations')) {
            $events_by_batch = $this->db
                ->select('a.graduation_year, COUNT(*) AS event_registrations')
                ->from('event_registrations er')
                ->join('alumni a', 'a.id = er.alumni_id', 'left')
                ->group_by('a.graduation_year')
                ->get()
                ->result_array();
        }

        // merge
        $data = [];
        foreach ($alumni_by_year as $row) {
            $year = $row['graduation_year'];
            $data[$year] = [
                'graduation_year'     => $year,
                'total_alumni'        => (int)$row['total_alumni'],
                'active_alumni'       => 0,
                'event_registrations' => 0,
                'job_applications'    => 0,
            ];
        }

        foreach ($active_by_year as $row) {
            $year = $row['graduation_year'];
            if (!isset($data[$year])) {
                $data[$year] = [
                    'graduation_year'     => $year,
                    'total_alumni'        => 0,
                    'active_alumni'       => 0,
                    'event_registrations' => 0,
                    'job_applications'    => 0,
                ];
            }
            $data[$year]['active_alumni'] = (int)$row['active_alumni'];
        }

        foreach ($events_by_batch as $row) {
            $year = $row['graduation_year'];
            if (!isset($data[$year])) continue;
            $data[$year]['event_registrations'] = (int)$row['event_registrations'];
        }

        foreach ($applications_by_batch as $row) {
            $year = $row['graduation_year'];
            if (!isset($data[$year])) continue;
            $data[$year]['job_applications'] = (int)$row['job_applications'];
        }

        krsort($data);
        return array_values($data);
    }

    /**
     * Get employment rows applying optional filters
     */
    private function get_employment_report_data($filters = [])
    {
        $this->db->select('e.*, a.first_name, a.last_name, a.email, a.graduation_year');
        $this->db->from('employment e');
        $this->db->join('alumni a', 'a.id = e.alumni_id', 'left');

        if (!empty($filters['grad_year'])) {
            $this->db->where('a.graduation_year', $filters['grad_year']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('e.employment_status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $this->db->where('e.created_at >=', $filters['date_from'] . ' 00:00:00');
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('e.created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        $this->db->order_by('a.graduation_year', 'DESC');
        $q = $this->db->get();
        return $q->result_array();
    }


    /**
     * Export employment rows to Excel (filtered by GET params)
     */
    public function employment_excel()
    {
        if (! $this->db->table_exists('employment')) {
            $this->session->set_flashdata('error','Employment table not found.');
            redirect('AdminReports');
            return;
        }

        // read filters
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'status'    => $this->input->get('status', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE)
        ];

        $rows = $this->get_employment_report_data($filters);

        // build spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Employment Report');

        $headers = [
            'A1' => 'Alumni ID', 'B1' => 'Name', 'C1' => 'Email', 'D1' => 'Graduation Year',
            'E1' => 'Status', 'F1' => 'Company', 'G1' => 'Job Title', 'H1' => 'Job Description',
            'I1' => 'Years of Service', 'J1' => 'Promotions', 'K1' => 'Submitted At'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        $r = 2;
        foreach ($rows as $row) {
            $sheet->setCellValue('A'.$r, $row['alumni_id']);
            $sheet->setCellValue('B'.$r, $row['last_name'].', '.$row['first_name']);
            $sheet->setCellValue('C'.$r, $row['email']);
            $sheet->setCellValue('D'.$r, $row['graduation_year']);
            $sheet->setCellValue('E'.$r, $row['employment_status']);
            $sheet->setCellValue('F'.$r, $row['company_name']);
            $sheet->setCellValue('G'.$r, $row['job_title']);
            $sheet->setCellValue('H'.$r, $row['job_description']);
            $sheet->setCellValue('I'.$r, $row['year_of_service']);
            $sheet->setCellValue('J'.$r, $row['promotion_count']);
            $sheet->setCellValue('K'.$r, $row['created_at']);
            $r++;
        }

        foreach (range('A','K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'employment_report_'.date('Ymd_His').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export employment rows to PDF using Dompdf
     */
    public function employment_pdf()
    {
        if (! $this->db->table_exists('employment')) {
            $this->session->set_flashdata('error','Employment table not found.');
            redirect('AdminReports');
            return;
        }

        // filters
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'status'    => $this->input->get('status', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE)
        ];

        $rows = $this->get_employment_report_data($filters);

        $html = $this->load->view('admin/reports_employment_pdf', ['rows' => $rows], TRUE);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();

        $filename = 'employment_report_'.date('Ymd_His').'.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }

    private function generate_ai_insights($employment_rows, $engagement_by_year)
{
    $insights = [];

    $total = count($employment_rows);

    if ($total == 0) {
        $insights[] = "No employment data available yet.";
        return $insights;
    }

    $employed = 0;
    $unemployed = 0;
    $self = 0;

    $top_company = [];
    $total_years_service = 0;

    foreach ($employment_rows as $row) {

        if ($row['employment_status'] == 'Employed') {
            $employed++;
        }

        if ($row['employment_status'] == 'Unemployed') {
            $unemployed++;
        }

        if ($row['employment_status'] == 'Self-employed') {
            $self++;
        }

        if (!empty($row['company_name'])) {
            $top_company[$row['company_name']] =
                ($top_company[$row['company_name']] ?? 0) + 1;
        }

        $total_years_service += (int)$row['year_of_service'];
    }

    $employment_rate = round(($employed / $total) * 100);
    $self_rate = round(($self / $total) * 100);
    $unemployment_rate = round(($unemployed / $total) * 100);

    $avg_service = round($total_years_service / $total, 1);

    arsort($top_company);
    $top_company_name = key($top_company);

    $insights[] = "$employment_rate% of alumni in the tracer database are currently employed.";

    $insights[] = "$self_rate% of alumni are self-employed, indicating entrepreneurial activity among graduates.";

    
    $insights[] = "Average alumni work experience is approximately $avg_service years.";

    if ($top_company_name) {
        $insights[] = "$top_company_name appears as the most common employer among graduates.";
    }

    if ($employment_rate >= 70) {
        $insights[] = "The employment outcome of graduates is considered strong.";
    } else {
        $insights[] = "Employment rate suggests that graduate employability may need improvement.";
    }

    return $insights;
}

}
