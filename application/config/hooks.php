<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// =========================================================================
// RATE LIMITING MIDDLEWARE
// =========================================================================
// Pre-controller hook to check rate limits and block automated traffic
// Returns 429 Too Many Requests for exceeded limits
// =========================================================================
$hook['pre_controller'] = array(
    'class'    => 'RateLimiter',
    'function' => 'check_rate_limit',
    'filename' => 'RateLimiter.php',
    'filepath' => 'libraries',
    'params'   => array()
);
