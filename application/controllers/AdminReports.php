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
        $this->load->helper(['url','text']);
        $this->load->library('session');
        $this->load->model('Employment_model');
    }

    /* =====================================================================
     * MAIN REPORTS PAGE (Engagement + Employment)
     * ===================================================================== */
    public function index()
    {
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'status'    => $this->input->get('status', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];

        $data['engagement_by_year'] = $this->get_engagement_report_data();
        $data['employment_rows']    = $this->get_employment_report_data($filters);
        $data['ai_insights']        = $this->generate_ai_insights(
            $data['employment_rows'],
            $data['engagement_by_year']
        );
        $data['filters']            = $filters;
        $data['employment_enabled'] = $this->db->table_exists('employment');

        $this->load->view('__header', $data);
        $this->load->view('admin/reports', $data);
        $this->load->view('__footer', $data);
    }

    /* =====================================================================
     * TRACER STUDY REPORT PAGE
     * ===================================================================== */
    public function tracer_report()
    {
        if (!$this->db->table_exists('tracer_survey_responses')) {
            $this->session->set_flashdata('error', 'Tracer survey table not found. Please run the migration first.');
            redirect('AdminReports');
            return;
        }

        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];

        $data['tracer_rows']    = $this->get_tracer_report_data($filters);
        $data['tracer_summary'] = $this->get_tracer_summary($data['tracer_rows']);
        $data['tracer_ai']      = $this->generate_tracer_ai_insights($data['tracer_rows'], $data['tracer_summary']);
        $data['filters']        = $filters;

        $this->load->view('__header', $data);
        $this->load->view('admin/tracer_report', $data);
        $this->load->view('__footer', $data);
    }

    /* =====================================================================
     * PRIVATE DATA METHODS
     * ===================================================================== */

    private function get_engagement_report_data()
    {
        $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));

        $alumni_by_year = $this->db
            ->select('graduation_year, COUNT(*) AS total_alumni')
            ->from('alumni')
            ->group_by('graduation_year')
            ->order_by('graduation_year', 'DESC')
            ->get()->result_array();

        $active_by_year = $this->db
            ->select('graduation_year, COUNT(*) AS active_alumni')
            ->from('alumni')
            ->where('last_login >=', $thirty_days_ago)
            ->group_by('graduation_year')
            ->get()->result_array();

        $applications_by_batch = [];
        if ($this->db->table_exists('job_applications')) {
            $applications_by_batch = $this->db
                ->select('a.graduation_year, COUNT(*) AS job_applications')
                ->from('job_applications ja')
                ->join('alumni a', 'a.id = ja.alumni_id', 'left')
                ->group_by('a.graduation_year')
                ->get()->result_array();
        }

        $events_by_batch = [];
        if ($this->db->table_exists('event_registrations')) {
            $events_by_batch = $this->db
                ->select('a.graduation_year, COUNT(*) AS event_registrations')
                ->from('event_registrations er')
                ->join('alumni a', 'a.id = er.alumni_id', 'left')
                ->group_by('a.graduation_year')
                ->get()->result_array();
        }

        $data = [];
        foreach ($alumni_by_year as $row) {
            $year = $row['graduation_year'];
            $data[$year] = [
                'graduation_year' => $year, 'total_alumni' => (int)$row['total_alumni'],
                'active_alumni' => 0, 'event_registrations' => 0, 'job_applications' => 0,
            ];
        }
        foreach ($active_by_year as $row) {
            if (isset($data[$row['graduation_year']]))
                $data[$row['graduation_year']]['active_alumni'] = (int)$row['active_alumni'];
        }
        foreach ($events_by_batch as $row) {
            if (isset($data[$row['graduation_year']]))
                $data[$row['graduation_year']]['event_registrations'] = (int)$row['event_registrations'];
        }
        foreach ($applications_by_batch as $row) {
            if (isset($data[$row['graduation_year']]))
                $data[$row['graduation_year']]['job_applications'] = (int)$row['job_applications'];
        }

        krsort($data);
        return array_values($data);
    }

    private function get_employment_report_data($filters = [])
    {
        $this->db->select('e.*, a.first_name, a.last_name, a.email, a.graduation_year');
        $this->db->from('employment e');
        $this->db->join('alumni a', 'a.id = e.alumni_id', 'left');

        if (!empty($filters['grad_year']))  $this->db->where('a.graduation_year', $filters['grad_year']);
        if (!empty($filters['status']))     $this->db->where('e.employment_status', $filters['status']);
        if (!empty($filters['date_from']))  $this->db->where('e.created_at >=', $filters['date_from'].' 00:00:00');
        if (!empty($filters['date_to']))    $this->db->where('e.created_at <=', $filters['date_to'].' 23:59:59');

        $this->db->order_by('a.graduation_year', 'DESC');
        return $this->db->get()->result_array();
    }

    private function get_tracer_report_data($filters = [])
    {
        $this->db->select('tsr.*, a.first_name, a.last_name, a.email, a.alumni_number');
        $this->db->from('tracer_survey_responses tsr');
        $this->db->join('alumni a', 'a.id = tsr.alumni_id', 'left');

        if (!empty($filters['grad_year'])) $this->db->where('tsr.year_graduated', $filters['grad_year']);
        if (!empty($filters['date_from'])) $this->db->where('tsr.created_at >=', $filters['date_from'].' 00:00:00');
        if (!empty($filters['date_to']))   $this->db->where('tsr.created_at <=', $filters['date_to'].' 23:59:59');

        $this->db->order_by('tsr.year_graduated', 'DESC');
        $this->db->order_by('tsr.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    private function get_tracer_summary($rows)
    {
        $summary = [
            'total_responses'   => count($rows),
            'avg_rating_1'      => 0, 'avg_rating_2' => 0,
            'avg_rating_3'      => 0, 'avg_rating_4' => 0,
            'waiting_time_dist' => [],
            'satisfaction_dist' => [],
            'intent_dist'       => [],
            'competency_freq'   => [],
            'performance_avg'   => [],
            'responses_by_year' => [],
        ];

        if (empty($rows)) return $summary;

        $r1 = $r2 = $r3 = $r4 = 0;
        $perf_sums = []; $perf_counts = [];

        foreach ($rows as $row) {
            $r1 += (int)$row['rating_1'];
            $r2 += (int)$row['rating_2'];
            $r3 += (int)$row['rating_3'];
            $r4 += (int)$row['rating_4'];

            if (!empty($row['waiting_time'])) {
                $wt = $row['waiting_time'];
                $summary['waiting_time_dist'][$wt] = ($summary['waiting_time_dist'][$wt] ?? 0) + 1;
            }
            if (!empty($row['satisfaction'])) {
                $s = $row['satisfaction'];
                $summary['satisfaction_dist'][$s] = ($summary['satisfaction_dist'][$s] ?? 0) + 1;
            }
            if (!empty($row['intent'])) {
                $i = $row['intent'];
                $summary['intent_dist'][$i] = ($summary['intent_dist'][$i] ?? 0) + 1;
            }
            if (!empty($row['competencies'])) {
                $comps = @json_decode($row['competencies'], true);
                if (is_array($comps)) {
                    foreach ($comps as $c) {
                        if (!empty($c))
                            $summary['competency_freq'][$c] = ($summary['competency_freq'][$c] ?? 0) + 1;
                    }
                }
            }
            if (!empty($row['performance_ratings'])) {
                $perfs = @json_decode($row['performance_ratings'], true);
                if (is_array($perfs)) {
                    foreach ($perfs as $idx => $val) {
                        $perf_sums[$idx]   = ($perf_sums[$idx]   ?? 0) + (int)$val;
                        $perf_counts[$idx] = ($perf_counts[$idx] ?? 0) + 1;
                    }
                }
            }
            $y = $row['year_graduated'] ?? 'Unknown';
            $summary['responses_by_year'][$y] = ($summary['responses_by_year'][$y] ?? 0) + 1;
        }

        $n = count($rows);
        $summary['avg_rating_1'] = round($r1 / $n, 2);
        $summary['avg_rating_2'] = round($r2 / $n, 2);
        $summary['avg_rating_3'] = round($r3 / $n, 2);
        $summary['avg_rating_4'] = round($r4 / $n, 2);

        foreach ($perf_sums as $idx => $sum)
            $summary['performance_avg'][$idx] = round($sum / ($perf_counts[$idx] ?? 1), 2);

        arsort($summary['waiting_time_dist']);
        arsort($summary['satisfaction_dist']);
        arsort($summary['intent_dist']);
        arsort($summary['competency_freq']);
        krsort($summary['responses_by_year']);

        return $summary;
    }

    /* =====================================================================
     * AI INSIGHTS
     * ===================================================================== */

    private function generate_tracer_ai_insights($rows, $summary)
    {
        $insights = [];
        $total    = $summary['total_responses'];

        if ($total == 0) return ['No tracer survey responses have been submitted yet.'];

        // Overall rating
        $avg_overall = round(($summary['avg_rating_1'] + $summary['avg_rating_2'] +
                              $summary['avg_rating_3'] + $summary['avg_rating_4']) / 4, 2);
        $insights[] = "Overall program satisfaction average is {$avg_overall}/5 based on {$total} alumni responses.";

        // Weakest dimension
        $dims = [
            'Curriculum Relevance' => $summary['avg_rating_1'],
            'Teaching Quality'     => $summary['avg_rating_2'],
            'Skills Development'   => $summary['avg_rating_3'],
            'Career Preparation'   => $summary['avg_rating_4'],
        ];
        $min_dim = array_search(min($dims), $dims);
        $insights[] = "{$min_dim} scored lowest at {$dims[$min_dim]}/5 — consider targeted curriculum or faculty review in this area.";

        // Waiting time
        if (!empty($summary['waiting_time_dist'])) {
            $top_wait  = array_key_first($summary['waiting_time_dist']);
            $top_wpct  = round(($summary['waiting_time_dist'][$top_wait] / $total) * 100);
            $insights[] = "{$top_wpct}% of graduates secured employment within \"{$top_wait}\" after graduation.";
        }

        // Satisfaction
        if (!empty($summary['satisfaction_dist'])) {
            $top_sat  = array_key_first($summary['satisfaction_dist']);
            $top_spct = round(($summary['satisfaction_dist'][$top_sat] / $total) * 100);
            $insights[] = "{$top_spct}% of respondents rated their work satisfaction as \"{$top_sat}\".";
        }

        // Top competency
        if (!empty($summary['competency_freq'])) {
            $top_comp  = array_key_first($summary['competency_freq']);
            $top_cpct  = round(($summary['competency_freq'][$top_comp] / $total) * 100);
            $insights[] = "\"{$top_comp}\" was the most commonly cited core competency by {$top_cpct}% of alumni.";
        }

        // Performance average
        if (!empty($summary['performance_avg'])) {
            $avg_perf = round(array_sum($summary['performance_avg']) / count($summary['performance_avg']), 2);
            $insights[] = "Average self-assessed workplace performance rating is {$avg_perf}/5 across all evaluated competency statements.";
        }

        // Try Ollama for richer AI insights
        try {
            if (!function_exists('call_ollama_api')) $this->load->helper('ai_helper');
            $this->config->load('ollama');
            if ($this->config->item('ollama_enabled', 'ollama') && function_exists('call_ollama_api')) {
                $payload = [
                    'total_responses'  => $total,
                    'avg_ratings'      => array_combine(array_keys($dims), array_values($dims)),
                    'waiting_time'     => $summary['waiting_time_dist'],
                    'satisfaction'     => $summary['satisfaction_dist'],
                    'intent'           => $summary['intent_dist'],
                    'top_competencies' => array_slice($summary['competency_freq'], 0, 5, true),
                    'performance_avg'  => $summary['performance_avg'],
                    'by_year'          => $summary['responses_by_year'],
                ];
                $prompt = "You are an academic analytics assistant for a Philippine university alumni tracer study. "
                    . "Analyze this data and return ONLY valid JSON: {\"insights\":[\"...\"]} — 4–6 short, actionable insight strings targeting curriculum gaps, "
                    . "employment readiness, and institutional improvements.\n\nData:\n" . json_encode($payload);

                $result = call_ollama_api($prompt, [
                    'temperature' => 0.2, 'format' => 'json', 'max_tokens' => 500,
                    'system' => 'Respond only with valid JSON: {"insights":["..."]}.',
                ]);

                if ($result && isset($result['_parsed_result']['insights'])
                    && is_array($result['_parsed_result']['insights'])
                    && count($result['_parsed_result']['insights']) > 0)
                {
                    return $result['_parsed_result']['insights'];
                }
            }
        } catch (Exception $e) {
            log_message('error', 'generate_tracer_ai_insights Ollama: ' . $e->getMessage());
        }

        return $insights;
    }

    private function generate_ai_insights($employment_rows, $engagement_by_year)
    {
        $insights = [];
        $total    = count($employment_rows);

        if ($total == 0) { $insights[] = "No employment data available yet."; return $insights; }

        $employed = $unemployed = $self = 0;
        $top_company = [];
        $total_years = 0;

        foreach ($employment_rows as $row) {
            if ($row['employment_status'] == 'Employed')      $employed++;
            if ($row['employment_status'] == 'Unemployed')    $unemployed++;
            if ($row['employment_status'] == 'Self-employed') $self++;
            if (!empty($row['company_name']))
                $top_company[$row['company_name']] = ($top_company[$row['company_name']] ?? 0) + 1;
            $total_years += (int)$row['year_of_service'];
        }

        $employment_rate = round(($employed / $total) * 100);
        $self_rate       = round(($self / $total) * 100);
        $avg_service     = round($total_years / $total, 1);
        arsort($top_company);
        $top_co = key($top_company);

        $insights[] = "{$employment_rate}% of alumni in the tracer database are currently employed.";
        $insights[] = "{$self_rate}% of alumni are self-employed, indicating entrepreneurial activity among graduates.";
        $insights[] = "Average alumni work experience is approximately {$avg_service} years.";
        if ($top_co) $insights[] = "{$top_co} appears as the most common employer among graduates.";
        $insights[] = $employment_rate >= 70
            ? "The employment outcome of graduates is considered strong."
            : "Employment rate suggests that graduate employability may need improvement.";

        try {
            if (!function_exists('call_ollama_api')) $this->load->helper('ai_helper');
            $this->config->load('ollama');
            if ($this->config->item('ollama_enabled', 'ollama') && function_exists('call_ollama_api')) {
                $payload = [
                    'total' => $total, 'employed' => $employed,
                    'unemployed' => $unemployed, 'self_employed' => $self,
                    'employment_rate' => $employment_rate, 'self_rate' => $self_rate,
                    'avg_years_service' => $avg_service,
                    'top_companies' => array_slice($top_company, 0, 10),
                    'engagement_by_year' => $engagement_by_year,
                ];
                $prompt = "You are an analytics assistant. Return ONLY valid JSON with a single field `insights` — "
                    . "an array of short, actionable insight strings (3-6 items).\nReturn nothing else.\n\nData:\n"
                    . json_encode($payload);
                $result = call_ollama_api($prompt, [
                    'temperature' => 0.2, 'format' => 'json', 'max_tokens' => 400,
                    'system' => 'Respond only with valid JSON: {"insights":["..."]}.',
                ]);
                if ($result && isset($result['_parsed_result']['insights'])
                    && is_array($result['_parsed_result']['insights'])
                    && count($result['_parsed_result']['insights']) > 0)
                    return $result['_parsed_result']['insights'];
            }
        } catch (Exception $e) {
            log_message('error', 'generate_ai_insights Ollama: ' . $e->getMessage());
        }

        return $insights;
    }

    /* =====================================================================
     * EXPORTS — EMPLOYMENT
     * ===================================================================== */

    public function employment_excel()
    {
        if (!$this->db->table_exists('employment')) {
            $this->session->set_flashdata('error','Employment table not found.');
            redirect('AdminReports'); return;
        }
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'status'    => $this->input->get('status', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];
        $rows = $this->get_employment_report_data($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Employment Report');

        $headers = [
            'A1'=>'Alumni ID','B1'=>'Name','C1'=>'Email','D1'=>'Graduation Year',
            'E1'=>'Status','F1'=>'Company','G1'=>'Job Title','H1'=>'Job Description',
            'I1'=>'Years of Service','J1'=>'Promotions','K1'=>'Submitted At',
        ];
        foreach ($headers as $cell=>$text) $sheet->setCellValue($cell, $text);

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
        foreach (range('A','K') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);

        $filename = 'employment_report_'.date('Ymd_His').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    public function employment_pdf()
    {
        if (!$this->db->table_exists('employment')) {
            $this->session->set_flashdata('error','Employment table not found.');
            redirect('AdminReports'); return;
        }
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'status'    => $this->input->get('status', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];
        $rows = $this->get_employment_report_data($filters);
        $html = $this->load->view('admin/reports_employment_pdf', ['rows' => $rows], TRUE);

        $options = new Options(); $options->set('isRemoteEnabled', TRUE);
        $dompdf  = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();
        $dompdf->stream('employment_report_'.date('Ymd_His').'.pdf', ['Attachment' => true]);
        exit;
    }

    /* =====================================================================
     * EXPORTS — TRACER
     * ===================================================================== */

    public function tracer_excel()
    {
        if (!$this->db->table_exists('tracer_survey_responses')) {
            $this->session->set_flashdata('error','Tracer survey table not found.');
            redirect('AdminReports'); return;
        }
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];
        $rows = $this->get_tracer_report_data($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tracer Survey Report');

        $headers = [
            'A1'=>'Alumni Name',    'B1'=>'Alumni Number',    'C1'=>'Email',
            'D1'=>'Year Graduated', 'E1'=>'R1 Curriculum',    'F1'=>'R2 Teaching',
            'G1'=>'R3 Skills',      'H1'=>'R4 Career Prep',   'I1'=>'Waiting Time',
            'J1'=>'Satisfaction',   'K1'=>'Intent',            'L1'=>'Competencies',
            'M1'=>'Subjects',       'N1'=>'Performance Ratings','O1'=>'Further Study',
            'P1'=>'Submitted At',
        ];
        foreach ($headers as $cell=>$text) $sheet->setCellValue($cell, $text);

        $r = 2;
        foreach ($rows as $row) {
            $comps   = @json_decode($row['competencies'] ?? '', true);
            $subjs   = @json_decode($row['subjects'] ?? '', true);
            $perfs   = @json_decode($row['performance_ratings'] ?? '', true);
            $further = @json_decode($row['further_study'] ?? '', true);

            $sheet->setCellValue('A'.$r, trim($row['last_name'].', '.$row['first_name']));
            $sheet->setCellValue('B'.$r, $row['alumni_number'] ?? '');
            $sheet->setCellValue('C'.$r, $row['email']);
            $sheet->setCellValue('D'.$r, $row['year_graduated']);
            $sheet->setCellValue('E'.$r, $row['rating_1']);
            $sheet->setCellValue('F'.$r, $row['rating_2']);
            $sheet->setCellValue('G'.$r, $row['rating_3']);
            $sheet->setCellValue('H'.$r, $row['rating_4']);
            $sheet->setCellValue('I'.$r, $row['waiting_time'] ?? '');
            $sheet->setCellValue('J'.$r, $row['satisfaction'] ?? '');
            $sheet->setCellValue('K'.$r, $row['intent'] ?? '');
            $sheet->setCellValue('L'.$r, is_array($comps) ? implode(', ', $comps) : ($row['competencies'] ?? ''));
            $sheet->setCellValue('M'.$r, is_array($subjs)  ? implode(', ', $subjs)  : ($row['subjects'] ?? ''));
            $sheet->setCellValue('N'.$r, is_array($perfs)  ? implode(', ', $perfs)  : ($row['performance_ratings'] ?? ''));
            $sheet->setCellValue('O'.$r, is_array($further)? json_encode($further)  : ($row['further_study'] ?? ''));
            $sheet->setCellValue('P'.$r, $row['created_at']);
            $r++;
        }
        foreach (range('A','P') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);

        $filename = 'tracer_report_'.date('Ymd_His').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    public function tracer_pdf()
    {
        if (!$this->db->table_exists('tracer_survey_responses')) {
            $this->session->set_flashdata('error','Tracer survey table not found.');
            redirect('AdminReports'); return;
        }
        $filters = [
            'grad_year' => $this->input->get('grad_year', TRUE),
            'date_from' => $this->input->get('date_from', TRUE),
            'date_to'   => $this->input->get('date_to', TRUE),
        ];
        $rows    = $this->get_tracer_report_data($filters);
        $summary = $this->get_tracer_summary($rows);
        $html    = $this->load->view('admin/tracer_report_pdf', ['rows'=>$rows,'summary'=>$summary], TRUE);

        $options = new Options(); $options->set('isRemoteEnabled', TRUE);
        $dompdf  = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();
        $dompdf->stream('tracer_report_'.date('Ymd_His').'.pdf', ['Attachment'=>true]);
        exit;
    }
}
