<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Rate Limiter Library
 * Implements server-side rate limiting with automated traffic detection
 * 
 * Features:
 * - IP-based request tracking
 * - Automated traffic detection via User-Agent and headers
 * - Request frequency analysis
 * - 429 Too Many Requests response
 * - Configurable rate limits per endpoint
 */
class RateLimiter
{
    private $CI;
    private $cache_prefix = 'rate_limit_';
    private $request_log_prefix = 'request_log_';
    private $cache_initialized = false;
    private $config_initialized = false;
    
    // Configuration
    private $config = [
        'enabled' => true,
        'requests_per_minute' => 60,          // 60 requests per minute (default)
        'requests_per_hour' => 1000,          // 1000 requests per hour
        'burst_threshold' => 5,               // Flag if 5+ requests in 10 seconds
        'block_bots_immediately' => true,     // Block bots on first request
        'cache_driver' => 'file',             // Use CI cache driver
        'automated_traffic_patterns' => [     // User-Agent patterns for bots
            'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget', 'python',
            'java(?!script)', 'perl', 'ruby', 'php', 'go-http-client', 'requests',
            'httpclient', 'httpunit', 'mechanize', 'selenium', 'puppeteer'
        ]
    ];
    
    // Suspicious headers indicating automated traffic
    private $suspicious_headers = [
        'Accept-Language' => false,           // Missing = likely bot
        'Accept-Encoding' => false,           // Missing = likely bot
        'Connection' => false,                // Missing = likely bot
        'DNT' => true                         // Present but abnormal for bots
    ];

    public function __construct($config = [])
    {
        // Initialize CI instance - allow NULL during hook phase
        $this->CI = &get_instance();
        
        // If CI is available, load configuration immediately
        if ($this->CI !== null && method_exists($this->CI, 'load')) {
            $this->initialize_config($config);
        } else {
            // During hook phase, CI might not be ready yet
            // Configuration will be loaded on first actual use
            log_message('debug', 'RateLimiter: Deferring initialization - CI not ready yet');
        }
    }

    /**
     * Initialize configuration when needed
     * 
     * @param array $config
     * @return void
     */
    private function initialize_config($config = [])
    {
        if ($this->config_initialized) {
            return;
        }

        // Get fresh CI instance
        $this->CI = &get_instance();

        if ($this->CI === null || !method_exists($this->CI, 'config')) {
            log_message('error', 'RateLimiter: Cannot initialize - CI instance not available');
            return;
        }

        try {
            // Load cache driver (deferred)
            if (!$this->cache_initialized && method_exists($this->CI, 'load')) {
                $this->CI->load->driver('cache', [
                    'adapter' => $this->config['cache_driver'],
                    'backup' => 'file'
                ]);
                $this->cache_initialized = true;
            }

            // Load rate limiter configuration
            if (method_exists($this->CI->config, 'load')) {
                @$this->CI->config->load('rate_limiter', true);
            }
            
            // Build configuration from config file
            $file_config = [
                'enabled' => $this->CI->config->item('rate_limit_enabled', 'rate_limiter'),
                'requests_per_minute' => $this->CI->config->item('rate_limit_requests_per_minute', 'rate_limiter'),
                'requests_per_hour' => $this->CI->config->item('rate_limit_requests_per_hour', 'rate_limiter'),
                'burst_threshold' => $this->CI->config->item('rate_limit_burst_threshold', 'rate_limiter'),
                'block_bots_immediately' => $this->CI->config->item('rate_limit_block_bots_immediately', 'rate_limiter'),
                'cache_driver' => $this->CI->config->item('rate_limit_cache_driver', 'rate_limiter'),
                'automated_traffic_patterns' => $this->CI->config->item('rate_limit_automated_patterns', 'rate_limiter'),
                'whitelist_ips' => $this->CI->config->item('rate_limit_whitelist_ips', 'rate_limiter'),
                'blacklist_ips' => $this->CI->config->item('rate_limit_blacklist_ips', 'rate_limiter'),
                'exclude_paths' => $this->CI->config->item('rate_limit_exclude_paths', 'rate_limiter'),
                'monitor_mode' => $this->CI->config->item('rate_limit_monitor_mode', 'rate_limiter'),
                'required_headers' => $this->CI->config->item('rate_limit_required_headers', 'rate_limiter'),
            ];
            
            // Merge custom config with file config
            $file_config = array_filter($file_config, function($val) { return $val !== false; });
            $this->config = array_merge($this->config, $file_config);
            
            if (!empty($config)) {
                $this->config = array_merge($this->config, $config);
            }
            
            $this->config_initialized = true;
            log_message('debug', 'RateLimiter initialized with config: ' . json_encode($this->config));
        } catch (Exception $e) {
            log_message('error', 'RateLimiter initialization error: ' . $e->getMessage());
        }
    }

    /**
     * Check if request should be rate limited
     * Called as pre_controller hook
     * 
     * @return bool true if request is allowed, false if rate limited
     */
    public function check_rate_limit()
    {
        // Ensure initialization is complete
        $this->initialize_config();

        if (!$this->config_initialized) {
            // If still not initialized, allow request (fail-safe)
            log_message('error', 'RateLimiter: Config not initialized, allowing request');
            return true;
        }

        if (!$this->config['enabled']) {
            return true;
        }

        // Ensure CI is available
        if ($this->CI === null) {
            $this->CI = &get_instance();
            if ($this->CI === null) {
                return true; // Fail-safe
            }
        }

        $ip_address = $this->get_client_ip();
        $uri = $this->CI->uri->uri_string();

        // Check if path is excluded from rate limiting
        if ($this->is_excluded_path($uri)) {
            log_message('debug', "Path excluded from rate limiting: {$uri}");
            return true;
        }

        // Check whitelist (bypass rate limiting)
        if ($this->is_whitelisted_ip($ip_address)) {
            log_message('debug', "IP whitelisted, bypassing rate limit: {$ip_address}");
            return true;
        }

        // Check blacklist (always limit)
        if ($this->is_blacklisted_ip($ip_address)) {
            log_message('error', "IP blacklisted: {$ip_address}");
            $this->reject_request($ip_address, 'blacklist');
            return false;
        }

        $user_agent = $this->CI->input->user_agent();
        $current_time = time();

        // Log request information
        log_message('debug', "Rate limit check: IP={$ip_address}, UA={$user_agent}, Time={$current_time}, URI={$uri}");

        $should_reject = false;
        $rejection_reason = null;

        // 1. Check if this is automated traffic
        if ($this->is_automated_traffic($user_agent)) {
            log_message('error', "AUTOMATED TRAFFIC detected from IP: {$ip_address}, UA: {$user_agent}");
            $this->apply_strict_limit($ip_address);
            
            // If block_bots_immediately is enabled, reject on first request
            if ($this->config['block_bots_immediately']) {
                $should_reject = true;
                $rejection_reason = 'automated_traffic_detected';
            } elseif ($this->is_rate_limited($ip_address, $this->config['requests_per_minute'] / 10)) {
                // Otherwise, use stricter rate limit (1/10th normal)
                $should_reject = true;
                $rejection_reason = 'automated_traffic';
            }
        }

        // 2. Check if request headers look suspicious
        if (!$should_reject && $this->has_suspicious_headers()) {
            log_message('error', "SUSPICIOUS HEADERS detected from IP: {$ip_address}");
            if ($this->is_rate_limited($ip_address, $this->config['requests_per_minute'] / 5)) {
                $should_reject = true;
                $rejection_reason = 'suspicious_headers';
            }
        }

        // 3. Check for burst/spike traffic (many requests in short time)
        if (!$should_reject && $this->detect_burst_traffic($ip_address, $current_time)) {
            log_message('error', "BURST TRAFFIC detected from IP: {$ip_address}");
            if ($this->is_rate_limited($ip_address, $this->config['burst_threshold'])) {
                $should_reject = true;
                $rejection_reason = 'burst_traffic';
            }
        }

        // 4. Normal rate limiting check
        if (!$should_reject && $this->is_rate_limited($ip_address, $this->config['requests_per_minute'])) {
            log_message('error', "RATE LIMIT exceeded for IP: {$ip_address}");
            $should_reject = true;
            $rejection_reason = 'rate_limit';
        }

        if ($should_reject) {
            if ($this->config['monitor_mode']) {
                log_message('error', "MONITOR MODE: Would reject {$ip_address} for reason: {$rejection_reason}");
                $this->record_request($ip_address, $current_time);
                return true; // Allow in monitor mode
            } else {
                $this->reject_request($ip_address, $rejection_reason);
                return false;
            }
        }

        // Record this request
        $this->record_request($ip_address, $current_time);

        return true;
    }

    /**
     * Check if path is excluded from rate limiting
     * 
     * @param string $uri
     * @return bool
     */
    private function is_excluded_path($uri)
    {
        if (empty($this->config['exclude_paths'])) {
            return false;
        }

        foreach ($this->config['exclude_paths'] as $pattern) {
            if (preg_match('/' . $pattern . '/', $uri)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if IP is whitelisted (bypass rate limiting)
     * 
     * @param string $ip_address
     * @return bool
     */
    private function is_whitelisted_ip($ip_address)
    {
        if (empty($this->config['whitelist_ips'])) {
            return false;
        }

        return in_array($ip_address, $this->config['whitelist_ips']);
    }

    /**
     * Check if IP is blacklisted (always rate limit)
     * 
     * @param string $ip_address
     * @return bool
     */
    private function is_blacklisted_ip($ip_address)
    {
        if (empty($this->config['blacklist_ips'])) {
            return false;
        }

        return in_array($ip_address, $this->config['blacklist_ips']);
    }

    /**
        if (empty($user_agent)) {
            return true; // No User-Agent = likely bot
        }

        $user_agent_lower = strtolower($user_agent);

        // Check against known bot patterns
        foreach ($this->config['automated_traffic_patterns'] as $pattern) {
            if (preg_match('/' . $pattern . '/i', $user_agent_lower)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if request headers are suspicious
     * Legitimate browsers include specific headers that bots often omit
     * 
     * @return bool
     */
    private function has_suspicious_headers()
    {
        if (empty($this->config['required_headers'])) {
            return false;
        }

        $missing_count = 0;

        // Check for missing standard browser headers
        foreach ($this->config['required_headers'] as $header) {
            if (empty($this->CI->input->request_headers($header))) {
                $missing_count++;
            }
        }

        // If 2+ standard headers are missing, likely a bot
        if ($missing_count >= 2) {
            return true;
        }

        // Check for abnormal header combinations
        $user_agent = $this->CI->input->user_agent();
        if (strpos($user_agent, 'Chrome') !== false && empty($this->CI->input->request_headers('Accept-Language'))) {
            return true; // Chrome without Accept-Language is suspicious
        }

        return false;
    }

    /**
     * Safely get a value from cache
     * 
     * @param string $key
     * @return mixed
     */
    private function get_cache($key)
    {
        if ($this->CI === null || !isset($this->CI->cache)) {
            return null;
        }
        
        try {
            return $this->CI->cache->get($key);
        } catch (Exception $e) {
            log_message('error', 'RateLimiter cache get error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Safely save a value to cache
     * 
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    private function set_cache($key, $value, $ttl = 60)
    {
        if ($this->CI === null || !isset($this->CI->cache)) {
            return false;
        }
        
        try {
            return $this->CI->cache->save($key, $value, $ttl);
        } catch (Exception $e) {
            log_message('error', 'RateLimiter cache save error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Safely delete a value from cache
     * 
     * @param string $key
     * @return bool
     */
    private function delete_cache($key)
    {
        if ($this->CI === null || !isset($this->CI->cache)) {
            return false;
        }
        
        try {
            return $this->CI->cache->delete($key);
        } catch (Exception $e) {
            log_message('error', 'RateLimiter cache delete error: ' . $e->getMessage());
            return false;
        }
    }

    /**
    private function detect_burst_traffic($ip_address, $current_time)
    {
        $log_key = $this->request_log_prefix . $ip_address;
        $request_times = $this->get_cache($log_key) ?: [];

        if (!is_array($request_times)) {
            $request_times = [];
        }

        // Count requests in last 10 seconds
        $recent_requests = array_filter($request_times, function ($timestamp) use ($current_time) {
            return ($current_time - $timestamp) <= 10;
        });

        // If more than burst_threshold requests in 10 seconds, flag as burst
        if (count($recent_requests) >= $this->config['burst_threshold']) {
            log_message('debug', "Burst traffic detected: {$ip_address} made " . count($recent_requests) . " requests in 10 seconds");
            return true;
        }

        return false;
    }

    /**
     * Check if IP address has exceeded rate limit
     * 
     * @param string $ip_address
     * @param int $limit
     * @return bool true if rate limited
     */
    private function is_rate_limited($ip_address, $limit)
    {
        $cache_key = $this->cache_prefix . $ip_address;
        $current_count = $this->get_cache($cache_key) ?: 0;

        if ($current_count >= $limit) {
            return true;
        }

        return false;
    }

    /**
     * Record a request for rate limiting
     * 
     * @param string $ip_address
     * @param int $current_time
     * @return void
     */
    private function record_request($ip_address, $current_time)
    {
        $cache_key = $this->cache_prefix . $ip_address;
        $log_key = $this->request_log_prefix . $ip_address;

        // Increment per-minute counter (expires after 60 seconds)
        $current_count = $this->get_cache($cache_key) ?: 0;
        $this->set_cache($cache_key, $current_count + 1, 60);

        // Record request timestamp for burst detection
        $request_times = $this->get_cache($log_key) ?: [];
        if (!is_array($request_times)) {
            $request_times = [];
        }
        
        $request_times[] = $current_time;
        
        // Keep only timestamps from last 60 seconds
        $request_times = array_filter($request_times, function ($timestamp) use ($current_time) {
            return ($current_time - $timestamp) <= 60;
        });
        
        $this->set_cache($log_key, $request_times, 60);

        log_message('debug', "Request recorded for {$ip_address}, count: " . ($current_count + 1));
    }

    /**
     * Apply strict rate limiting for automated traffic
     * 
     * @param string $ip_address
     * @return void
     */
    private function apply_strict_limit($ip_address)
    {
        // Add IP to automated traffic list for enhanced monitoring
        $automation_key = 'automated_ips';
        $automated_ips = $this->get_cache($automation_key) ?: [];

        if (!in_array($ip_address, $automated_ips)) {
            $automated_ips[] = $ip_address;
            $this->set_cache($automation_key, $automated_ips, 3600); // 1 hour
        }
    }

    /**
     * Reject request with 429 Too Many Requests
     * 
     * @param string $ip_address
     * @param string $reason
     * @return void
     */
    private function reject_request($ip_address, $reason = 'rate_limit')
    {
        // Log the rejection
        log_message('error', "REQUEST REJECTED from IP: {$ip_address}, Reason: {$reason}");

        // Write to dedicated rate limit log
        $log_file = APPPATH . 'logs/rate_limit.log';
        $log_entry = sprintf(
            "[%s] REJECTED - IP: %s, Reason: %s, URI: %s\n",
            date('Y-m-d H:i:s'),
            $ip_address,
            $reason,
            $this->CI->uri->uri_string()
        );
        file_put_contents($log_file, $log_entry, FILE_APPEND);

        // Send 429 Too Many Requests response
        $this->CI->output->set_status_header(429);
        $this->CI->output->set_content_type('application/json');
        
        $response = [
            'status' => 429,
            'message' => 'Too many requests. Please try again later.',
            'reason' => $reason,
            'retry_after' => 60
        ];
        
        echo json_encode($response);
        exit;
    }

    /**
     * Get client IP address with proxy support
     * 
     * @return string
     */
    private function get_client_ip()
    {
        // Check for shared internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Check for IP passed from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            // Handle multiple IPs (take the first one)
            if (strpos($ip, ',') !== false) {
                $ips = explode(',', $ip);
                $ip = trim($ips[0]);
            }
        }
        // Check for remote address
        else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }

        // Validate IP
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return '0.0.0.0';
        }

        return $ip;
    }

    /**
     * Get rate limit statistics for an IP address
     * Useful for monitoring and debugging
     * 
     * @param string $ip_address
     * @return array
     */
    public function get_stats($ip_address = null)
    {
        if ($ip_address === null) {
            $ip_address = $this->get_client_ip();
        }

        $cache_key = $this->cache_prefix . $ip_address;
        $log_key = $this->request_log_prefix . $ip_address;

        $current_count = $this->get_cache($cache_key) ?: 0;
        $request_times = $this->get_cache($log_key) ?: [];

        return [
            'ip_address' => $ip_address,
            'requests_this_minute' => $current_count,
            'request_history' => $request_times,
            'is_rate_limited' => $this->is_rate_limited($ip_address, $this->config['requests_per_minute']),
            'limit_per_minute' => $this->config['requests_per_minute']
        ];
    }

    /**
     * Reset rate limit for specific IP (admin function)
     * 
     * @param string $ip_address
     * @return bool
     */
    public function reset_ip_limit($ip_address)
    {
        $cache_key = $this->cache_prefix . $ip_address;
        $log_key = $this->request_log_prefix . $ip_address;

        $this->delete_cache($cache_key);
        $this->delete_cache($log_key);

        log_message('info', "Rate limit reset for IP: {$ip_address}");
        return true;
    }

    /**
     * Get configuration
     * 
     * @return array
     */
    public function get_config()
    {
        return $this->config;
    }

    /**
     * Update configuration
     * 
     * @param array $new_config
     * @return void
     */
    public function set_config($new_config = [])
    {
        $this->config = array_merge($this->config, $new_config);
        log_message('info', 'RateLimiter config updated: ' . json_encode($this->config));
    }
}
