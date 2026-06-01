<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['email'] = array(
    'protocol'     => 'smtp',
    'smtp_host'    => env_value('ACONNECT_SMTP_HOST', 'smtp.hostinger.com'),
    'smtp_port'    => (int) env_value('ACONNECT_SMTP_PORT', 465),
    'smtp_user'    => env_value('ACONNECT_SMTP_USER', 'aconnect_admin@sdcaconnect.online'),
    'smtp_pass'    => env_value('ACONNECT_SMTP_PASS', ''),
    'smtp_crypto'  => env_value('ACONNECT_SMTP_CRYPTO', 'ssl'),
    'mailtype'     => 'html',
    'charset'      => 'utf-8',
    'newline'      => "\r\n",
    'crlf'         => "\r\n",
    'wordwrap'     => TRUE,
    'smtp_timeout' => 30,
);
