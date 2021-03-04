<?php
// debug options uncomment
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
$mailConfig = array(
    'From' => 'sender@example.com',
    'To' => 'recipient@example.com',
    'Subject' => 'test subject',
    'Reply-To' => 'sender@example.com',
    'Msg' => 'test message',
    'Host' => 'smtp.gmail.com',
    'Port' => '465',
    'SendGridKey' => 'xxx',
    'Password' => 'pw',
    'Username' => 'user'
);

// echo json_encode($mailConfig);