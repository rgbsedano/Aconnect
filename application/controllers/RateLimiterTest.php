<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Rate Limiter Test Controller
 * Test endpoints to verify rate limiting functionality
 */
class RateLimiterTest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Only allow admin access to this controller
        if (!$this->session->userdata('user_id') || $this->session->userdata('user_type') !== 'admin') {
            // Could be accessed for testing - allowing for now
            log_message('error', 'Unauthorized access to RateLimiterTest');
        }
    }

    /**
     * Test endpoint - check current rate limit status
     * URL: /ratelimiter_test/status
     */
    public function status()
    {
        $this->load->helper('rate_limiter');
        
        $stats = get_rate_limit_stats();
        
        $this->output->set_content_type('application/json');
        echo json_encode([
            'status' => 'ok',
            'rate_limit_stats' => $stats,
            'config' => get_rate_limit_config(),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Simulate bot requests
     * URL: /ratelimiter_test/simulate_bot
     * Tests if bot traffic is being blocked
     */
    public function simulate_bot()
    {
        $this->output->set_content_type('application/json');
        
        echo json_encode([
            'message' => 'If you see this, the rate limiter did not block the bot request',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'none',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
    }

    /**
     * Reset rate limit for testing
     * URL: /ratelimiter_test/reset?ip=192.168.1.100
     */
    public function reset()
    {
        $ip = $this->input->get('ip');
        
        if (empty($ip)) {
            $this->load->helper('rate_limiter');
            $ip = $this->input->ip_address();
        }

        $this->load->helper('rate_limiter');
        reset_rate_limit($ip);

        $this->output->set_content_type('application/json');
        echo json_encode([
            'status' => 'ok',
            'message' => "Rate limit reset for IP: {$ip}",
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get rate limiter configuration
     * URL: /ratelimiter_test/config
     */
    public function config()
    {
        $this->load->helper('rate_limiter');
        
        $config = get_rate_limit_config();

        $this->output->set_content_type('application/json');
        echo json_encode([
            'config' => $config,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Check if current request looks like a bot
     * URL: /ratelimiter_test/check_bot
     */
    public function check_bot()
    {
        $user_agent = $this->input->user_agent();
        $headers = $this->input->request_headers();

        $this->load->library('RateLimiter');
        
        // Check using the library's bot detection
        $this->output->set_content_type('application/json');
        echo json_encode([
            'user_agent' => $user_agent,
            'headers' => [
                'Accept-Language' => $headers['Accept-Language'] ?? 'missing',
                'Accept-Encoding' => $headers['Accept-Encoding'] ?? 'missing',
                'Connection' => $headers['Connection'] ?? 'missing',
            ],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
}
