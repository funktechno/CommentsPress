<?php
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "../";
require_once '../config/connections.php';
require_once '../library/functions.php';
require_once '../model/configuration-model.php';
require_once '../model/conversations-model.php';
require_once '../library/error_responses.php';
header("Access-Control-Allow-Origin: " . Allowed_Origins);
header("Access-Control-Allow-Methods: " . Allowed_Methods);
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-type: application/json');

$errorStatus = App\errorStatus::getInstance();
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input)) // if null then set to $_POST for simple posts
{
    $input = $_POST;
}

$directoryURI = $_SERVER['REQUEST_URI'];
