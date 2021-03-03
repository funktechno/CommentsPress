<?php

$user = 'me';
$strSubject = 'Test mail using GMail API' . date('M d, Y h:i:s A');
$strRawMessage = "From: myAddress<myemail@gmail.com>\r\n";
$strRawMessage .= "To: toAddress <recptAddress@gmail.com>\r\n";
$strRawMessage .= 'Subject: =?utf-8?B?' . base64_encode($strSubject) . "?=\r\n";
$strRawMessage .= "MIME-Version: 1.0\r\n";
$strRawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
$strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
$strRawMessage .= "this <b>is a test message!\r\n";
// The message needs to be encoded in Base64URL
$mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
$msg = new Google_Service_Gmail_Message();
$msg->setRaw($mime);
//The special value **me** can be used to indicate the authenticated user.
$service->users_messages->send("me", $msg);