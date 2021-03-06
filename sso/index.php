<?php
// handle sso
session_start();
$sso = filter_input(INPUT_POST, 'sso');
if ($sso == NULL) {
    $sso = filter_input(INPUT_GET, 'sso');
}
$from = filter_input(INPUT_POST, 'from');
if ($from == NULL) {
    $from = filter_input(INPUT_GET, 'from');
}
$GLOBALS['root'] = "../";
require_once '../config/connections.php';

$directoryURI = $_SERVER['REQUEST_URI'];


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
echo $action;
switch ($action) {
    case 'test':
        include '../view/ssoTest.php';

        break;
    default:
        echo "sso:" . $sso . "<br>";

        echo "from:" . $from . "<br>";

        break;
}
