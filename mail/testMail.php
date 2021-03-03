<?php

require_once './mailConfig.php';

// standard mail from server

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($mailConfig['Msg'],70);
// echo json_encode($mailConfig);
// echo $msg;

// send email
// mail($mailConfig['To'],$mailConfig['Subject'],$mailConfig['Msg']);

mail($mailConfig['To'],
        "This is the message subject",
        "This is the message body",
        "From: sender@example.com" . "\r\n" . "Content-Type: text/plain; charset=utf-8",
        "-fsender@example.com");