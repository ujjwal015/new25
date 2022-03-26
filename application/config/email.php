<?php

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'ssl://smtp.googlemail.com', 
    'smtp_port' => 587,
    'smtp_user' => 'myschool.oncloud@gmail.com',
    'smtp_pass' => 'abcd1234efgh5678',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);

?>
