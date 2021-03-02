<?php
// change document root if serving from somewhere else such as /
// copy this file to connections.php w/ proper info
$GLOBALS['documentRoot']='/';
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
// createConnection();
