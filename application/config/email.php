<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['email'] = array(

    'protocol'    => 'smtp',
    'smtp_host'   => 'smtp.hostinger.com',
    'smtp_port'   => 465,
    'smtp_user'   => 'aconnect_admin@sdcaconnect.online',
    'smtp_pass'   => 'Aconnecthostinger@123',
    'smtp_crypto' => 'ssl',
    'mailtype'    => 'html',
    'charset'     => 'utf-8',
    'newline'     => "\r\n",
    'crlf'        => "\r\n",
    'wordwrap'    => TRUE,
    'smtp_timeout' => 30, // seconds
);
