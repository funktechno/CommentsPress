<?php
 require 'Mail.php';
 require_once './mailConfig.php';
//  ini_set("include_path", 'localpath' . ini_get("include_path") );

 error_reporting(E_ALL);
 ini_set('display_errors', '1');
 // Define basic e-mail parameters:
 $recipient = $mailConfig['To'];
 $headers['From'] = $mailConfig['From'];
 $headers['Reply-to'] = $mailConfig['From'];
 $headers['To'] = $mailConfig['To'];
 $headers['Subject'] = $mailConfig['Subject'];
 $headers['Date'] = date('r');
//  $headers['Message-Id'] = '<' . uniqid() . '@example.com>';
 $headers['Content-Type'] = 'text/plain; charset=utf-8';
 $body = $mailConfig['Msg'];

 // Define SMTP authentication parameters:
 $smtp_params['host'] = $mailConfig['Host'];
 $smtp_params['auth'] = true;
 $smtp_params['username'] = $mailConfig['Username'];
 $smtp_params['password'] = $mailConfig['Password'];
 $smtp_params['port'] = $mailConfig['Port'];

 // Create a Mail class instance with the above parameters, and then send the message:
 $message = Mail::factory('smtp', $smtp_params);
 $message->send($recipient, $headers, $body);