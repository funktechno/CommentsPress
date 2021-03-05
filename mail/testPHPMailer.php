<?php
// will require composer to pull then upload the vendor contents
use PHPMailer\PHPMailer\PHPMailer;
require_once './library/connectios.php';
$mailConfig = getMailConfig();
require '../vendor/autoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = gethostname();
$mail->SMTPAuth = true;
$mail->Username = $mailConfig['To'];
$mail->Password = $mailConfig['Password'];
$mail->setFrom($mailConfig['From']);
$mail->addAddress($mailConfig['To']);
$mail->Subject = $mailConfig['Subject'];
$mail->Body    = $mailConfig['Msg'];
$mail->send();
?>