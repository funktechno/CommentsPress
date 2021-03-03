<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once './mailConfig.php';
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