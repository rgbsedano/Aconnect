<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email Worker (CLI Only)
 *
 * Run manually:
 *   php index.php Email_worker send
 *
 * Cron every 1 minute recommended:
 * * * * * php /path/to/index.php Email_worker send
 */

class Email_worker extends CI_Controller
{
    const MAX_ATTEMPTS = 3;

    public function __construct()
    {
        parent::__construct();

        // Restrict to CLI
        if (!$this->input->is_cli_request()) {
            show_error('This script can only be run from the command line.', 403);
        }

        $this->load->database();
        $this->load->helper('date');
        $this->load->library('email');

        // Load email configuration from application/config/email.php
        $email_config = $this->config->item('email');

        if (!empty($email_config)) {
            $this->email->initialize($email_config);
        } else {
            echo "⚠ ERROR: email.php config not loaded.\n";
        }
    }

    /**
     * SEND EMAIL QUEUE
     */
    public function send($limit = 20)
    {
        $limit = (int)$limit ?: 20;

        // Get pending emails
        $emails = $this->db
            ->where('status', 'pending')
            ->where('(send_after IS NULL OR send_after <= NOW())', NULL, FALSE)
            ->order_by('created_at', 'ASC')
            ->limit($limit)
            ->get('email_queue')
            ->result();

        if (empty($emails)) {
            echo "No pending emails.\n";
            return;
        }

        echo "Processing " . count($emails) . " email(s)...\n";

        foreach ($emails as $email)
        {
            $this->email->clear(TRUE); // clear attachment + headers

            // FROM values (fallback)
            $email_config = $this->config->item('email');
            $from_email = 'aconnect_admin@sdcaconnect.online';

            $from_name = 'AConnect Alumni System';

            $this->email->from($from_email, $from_name);
            $this->email->to($email->recipient);
            $this->email->subject($email->subject);
            $this->email->message($email->body);

            echo "Sending ID {$email->id} to {$email->recipient}... ";

            if ($this->email->send())
            {
                echo "✔ Sent\n";

                $this->db->update(
                    'email_queue',
                    ['status' => 'sent'],
                    ['id' => $email->id]
                );
            }
            else
            {
                echo "✖ FAILED\n";

                $attempts = $email->attempts + 1;
                $update_data = ['attempts' => $attempts];

                if ($attempts >= self::MAX_ATTEMPTS) {
                    $update_data['status'] = 'failed';
                    echo "❌ Marked as FAILED permanently.\n";
                } else {
                    $delay = pow(2, $attempts); // 2, 4, 8 min
                    $retry_time = date('Y-m-d H:i:s', strtotime("+{$delay} minutes"));
                    $update_data['send_after'] = $retry_time;

                    echo "⏳ Retrying at: {$retry_time}\n";
                }

                $this->db->update('email_queue', $update_data, ['id' => $email->id]);

                // Log detailed error
                log_message('error', "Email_worker: FAILED ID {$email->id} → " . $this->email->print_debugger(['headers']));
            }

            // Anti-spam delay (Gmail-friendly)
            usleep(250000); // 0.25 sec
        }

        echo "Worker complete.\n";
        $this->load->model('Email_queue_model');
        $count = $this->Email_queue_model->process_queue($limit);

        echo "Processed {$count} emails.\n";

    }
}
