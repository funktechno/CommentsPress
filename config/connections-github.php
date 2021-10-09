<?php
// change document root if serving from somewhere else such as /
// debug options
error_reporting(E_ALL);
ini_set('display_errors', '1');
$GLOBALS['documentRoot'] = '/';
$GLOBALS['email_from'] = 'xxx@gmail.com';
// require_once $GLOBALS['root'] .'library/Core.php';

// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\PHPMailer;

// require '../vendor/phpmailer/phpmailer/src/Exception.php';
// require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '../vendor/phpmailer/phpmailer/src/SMTP.php';
// require '../vendor/autoload.php';
define('Allowed_Origins', '*');
define('Allowed_Methods', 'GET,POST');
// jwt secret
define('SECRET', 'SECRET');
define('DEBUG', false);
define('DEMO', true);

function getFacebookSSO()
{
    $facebookApp = array(
        'clientId'          => 'xxx',
        'clientSecret'      => 'xxx',
        'redirectUri'       => 'http://localhost:8000/',
        'graphApiVersion'   => 'v2.10',
    );
    return $facebookApp;
}
function getConnConfig()
{
    $config = array(
        'server' => "localhost",
        'port' => "3306",
        'dbname' => 'testcomments',
        'password' => 'mysecretpw',
        'username' => 'root'
    );
    return $config;
}

// http://localhost/acme/library/connections.php
function acmeConnect()
{
    $config = getConnConfig();

    // same config from docker
    $server = $config['server'];
    $dbname = $config['dbname'];
    $password = $config['password'];
    $username = $config['username'];
    $port = $config["port"];
    $dsn = 'mysql:host=' . $server . ';port=' . $port . ';dbname=' . $dbname;
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
        if (isset($GLOBALS['root']))
            include $GLOBALS['root'] . 'view/500.php';
        else
            throw $error;
        exit;
    }
}

function getMailConfig()
{
    $mailConfig = array(
        'From' => 'xxx@gmail.com',
        'To' => 'xx@gmail.com',
        'Subject' => 'test subject',
        'Reply-To' => 'xxx@gmail.com',
        'Msg' => 'test message',
        'Host' => 'smtp.gmail.com',
        'Port' => '465',
        'SendGridKey' => 'xxx',
        'Password' => 'xx',
        'Username' => 'xx@gmail.com'
    );
    return $mailConfig;
}
