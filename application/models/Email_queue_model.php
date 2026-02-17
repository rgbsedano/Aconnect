<?php
class Email_queue_model extends CI_Model {

    const MAX_ATTEMPTS = 3;

    public function process_queue($limit = 20)
    {
        $this->load->library('email');
        $this->load->database();

        // Load email config
        $this->config->load('email');
        $email_config = $this->config->item('email');   
        $this->email->initialize($email_config);

        $pending = $this->db
            ->where('status', 'pending')
            ->where('(send_after IS NULL OR send_after <= NOW())', NULL, FALSE)
            ->limit($limit)
            ->get('email_queue')
            ->result();

        foreach ($pending as $email) {

            $this->email->clear(TRUE);
            $this->email->from('no-reply@yourdomain.com', 'Aconnect');
            $this->email->to($email->recipient);
            $this->email->subject($email->subject);
            $this->email->message($email->body);

            if ($this->email->send()) {
                $this->db->update('email_queue', ['status' => 'sent'], ['id' => $email->id]);
            } else {
                $attempts = $email->attempts + 1;
                $data = ['attempts' => $attempts];

                if ($attempts >= self::MAX_ATTEMPTS) {
                    $data['status'] = 'failed';
                } else {
                    $retry = date('Y-m-d H:i:s', strtotime("+2 minutes"));
                    $data['send_after'] = $retry;
                }

                $this->db->update('email_queue', $data, ['id' => $email->id]);
            }
        }

        return count($pending);
    }
}
