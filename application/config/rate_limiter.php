<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Rate Limiter Configuration
 * Customize rate limiting behavior and thresholds
 */

// Enable/disable rate limiting globally
$config['rate_limit_enabled'] = true;

// ===== NORMAL TRAFFIC LIMITS =====
// Standard rate limits for legitimate users
$config['rate_limit_requests_per_minute'] = 60;        // 60 requests per minute = 1 per second
$config['rate_limit_requests_per_hour'] = 1000;        // 1000 requests per hour

// ===== AUTOMATED TRAFFIC DETECTION =====
// Requests in this time window trigger burst detection
$config['rate_limit_burst_window'] = 10;               // 10 seconds
$config['rate_limit_burst_threshold'] = 5;             // 5 requests = flag as burst
$config['rate_limit_block_bots_immediately'] = true;   // Block bot traffic on first request (no grace period)

// ===== CACHE CONFIGURATION =====
// Which cache driver to use for storing rate limit data
// Options: 'file', 'memcached', 'redis', 'apc'
$config['rate_limit_cache_driver'] = 'file';

// Cache expiration times
$config['rate_limit_cache_ttl_minute'] = 60;           // 1 minute for per-minute counters
$config['rate_limit_cache_ttl_hour'] = 3600;           // 1 hour for per-hour counters

// ===== AUTOMATED TRAFFIC PATTERNS =====
// User-Agent patterns that identify automated/bot traffic
// These patterns trigger stricter rate limiting (1/10th of normal limit)
$config['rate_limit_automated_patterns'] = [
    'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget', 'python',
    'java(?!script)', 'perl', 'ruby', 'php', 'go-http-client', 'requests',
    'httpclient', 'httpunit', 'mechanize', 'selenium', 'puppeteer', 'headless',
    'phantomjs', 'jsdom', 'noto', 'apify', 'scrapy'
];

// ===== WHITELIST & BLACKLIST =====
// Bypass rate limiting for trusted sources or enforce strict limits for known bad actors
$config['rate_limit_whitelist_ips'] = [
    // '127.0.0.1',     // Uncomment to whitelist localhost
    // '192.168.1.100', // Example: internal server
];

$config['rate_limit_blacklist_ips'] = [
    // '192.168.1.50',  // Example: known attacker IP
];

// ===== ENDPOINT SPECIFIC LIMITS =====
// Override default limits for specific endpoints
// Useful for API endpoints or resource-intensive operations
$config['rate_limit_endpoint_overrides'] = [
    // Example: Stricter limit for login attempts
    'admin/login' => ['requests_per_minute' => 5],
    
    // Example: Stricter limit for API endpoints
    'api/jobs/search' => ['requests_per_minute' => 30],
    
    // Example: More relaxed limit for static assets
    'assets' => ['requests_per_minute' => 200],
    
    // Add more endpoint-specific configs as needed
];

// ===== HEADER VALIDATION =====
// Check for standard browser headers that bots often omit
// Missing 2+ of these headers triggers suspicious traffic flag
$config['rate_limit_required_headers'] = [
    'Accept-Language',   // Standard browser header
    'Accept-Encoding',   // Standard browser header
    'Connection',        // Standard browser header
];

// ===== RESPONSE CONFIGURATION =====
// Customize the 429 response
$config['rate_limit_response_message'] = 'Too many requests. Please try again later.';
$config['rate_limit_response_retry_after'] = 60;  // Seconds to wait before retrying

// ===== LOGGING CONFIGURATION =====
// Where to log rate limit events
$config['rate_limit_log_file'] = 'rate_limit.log';
$config['rate_limit_log_rejections'] = true;           // Log all rejections
$config['rate_limit_log_automated_traffic'] = true;   // Log detected automated traffic
$config['rate_limit_log_debug'] = true;               // Log debug information

// ===== MONITOR MODE (dry-run) =====
// Enable to log rate limit violations without actually blocking requests
// Useful for tuning limits before enforcement
$config['rate_limit_monitor_mode'] = false;

// ===== EXCLUDE PATHS FROM RATE LIMITING =====
// Paths that bypass rate limiting entirely
// Useful for health checks, monitoring, static files
$config['rate_limit_exclude_paths'] = [
    '^assets/',                    // Static assets
    '^health-check',              // Health check endpoint
    '^status',                     // Status endpoint
    '^robots\.txt',               // Robots file
    '^favicon\.ico',              // Favicon
];
