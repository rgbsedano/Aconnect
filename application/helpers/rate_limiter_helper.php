<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Rate Limiter Helper
 * Provides convenient functions for rate limit management and monitoring
 * Load with: $this->load->helper('rate_limiter');
 */

/**
 * Get rate limit statistics for an IP address
 * 
 * Usage: $stats = get_rate_limit_stats('192.168.1.100');
 * 
 * @param string|null $ip_address IP to check (defaults to current user)
 * @return array Statistics including request count and limit status
 */
if (!function_exists('get_rate_limit_stats')) {
    function get_rate_limit_stats($ip_address = null)
    {
        $CI = &get_instance();
        $CI->load->library('RateLimiter');
        return $CI->ratelimiter->get_stats($ip_address);
    }
}

/**
 * Reset rate limit for an IP address (Admin function)
 * Use after unblocking a legitimate user
 * 
 * Usage: reset_rate_limit('192.168.1.100');
 * 
 * @param string $ip_address
 * @return bool
 */
if (!function_exists('reset_rate_limit')) {
    function reset_rate_limit($ip_address)
    {
        $CI = &get_instance();
        $CI->load->library('RateLimiter');
        return $CI->ratelimiter->reset_ip_limit($ip_address);
    }
}

/**
 * Check if an IP is currently rate limited
 * 
 * @param string|null $ip_address
 * @return bool
 */
if (!function_exists('is_rate_limited')) {
    function is_rate_limited($ip_address = null)
    {
        $stats = get_rate_limit_stats($ip_address);
        return $stats['is_rate_limited'];
    }
}

/**
 * Get current rate limit configuration
 * 
 * @return array
 */
if (!function_exists('get_rate_limit_config')) {
    function get_rate_limit_config()
    {
        $CI = &get_instance();
        $CI->load->library('RateLimiter');
        return $CI->ratelimiter->get_config();
    }
}

/**
 * Update rate limit configuration
 * 
 * @param array $new_config
 * @return void
 */
if (!function_exists('set_rate_limit_config')) {
    function set_rate_limit_config($new_config = [])
    {
        $CI = &get_instance();
        $CI->load->library('RateLimiter');
        $CI->ratelimiter->set_config($new_config);
    }
}
