<?php
// debug options uncomment
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
// change document root if serving from somewhere else such as /
// copy this file to connections.php w/ proper info
$GLOBALS['documentRoot'] = '/';
require_once 'Core.php';

// run composer require phpmailer/phpmailer
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\PHPMailer;
// require '../vendor/autoload.php';
define('Allowed_Origins','*');
define('Allowed_Methods','GET,POST');
// jwt secret
define('SECRET','CHANGEME!');
define('DEBUG',false);

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
function getMailConfig(){
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
    return $mailConfig;
}
