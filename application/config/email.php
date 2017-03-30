<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/


$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.mxhichina.com';
$config['smtp_user'] = 'service@xuebabank.com';
$config['smtp_pass'] = 'Xuebabank012';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";
$config['admin'] = array(
    'email' => 'service@xuebabank.com',
    'name'  => '学霸银行',
);
/* End of file email.php */
/* Location: ./application/config/email.php */