<?php
// change document root if serving from somewhere else such as /
// copy this file to connections.php w/ proper info
$GLOBALS['documentRoot'] = '/';
$GLOBALS['email_from '] = 'support@me.com';

// run composer require phpmailer/phpmailer
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\PHPMailer;
// require '../vendor/autoload.php';
define('Allowed_Origins','*');
define('Allowed_Methods','GET,POST');
// jwt secret
define('SECRET','SECRET');

// http://localhost/acme/library/connections.php
function acmeConnect()
{
    $server = 'localhost';
    $dbname = 'acme';
    $password = 'acme';
    $username = 'acme';
    $dsn = 'mysql:host=' . $server . ';dbname=' . $dbname;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    // Create the actual connection object and assign it to a variable
    try {
        $link = new PDO($dsn, $username, $password, $options);
        // echo 'link works!!';
        return $link;
    } catch (PDOException $e) {
        // echo $e;
        $error = $e;
        // echo 'Sorry, the connection failed';
        // header('location: /view/500.php');
        include $GLOBALS['root'] . 'view/500.php';
        exit;
    }
}
function emailConnect()
{
    $host = "ssl://smtp.dreamhost.com";
    $username = "youremail@example.com";
    $password = "your email password";
    $port = "465";
    $mail->Host       = "mail.example.com"; // SMTP server example
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
    $mail->Username   = "username"; // SMTP account username example
    $mail->Password   = "password";        // SMTP account password example

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    return $mail;

    // $to = "address_form_will_send_TO@example.com";
    // $email_from = "youremail@example.com";
    // $email_subject = "Subject Line Here:";
    // // $email_body = "whatever you like";
    // $email_address = "reply-to@example.com";
    // $headers = array('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
    // try {
    //     $smtp = Mail::factory('smtp', array('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
    //     // echo 'link works!!';
    //     return $smtp;
    // } catch (Exception $e) {
    //     // echo $e;
    //     $error = $e;
    //     // echo 'Sorry, the connection failed';
    //     // header('location: /view/500.php');
    //     include $GLOBALS['root'] . 'view/500.php';
    //     exit;
    // }
}
// createConnection();
