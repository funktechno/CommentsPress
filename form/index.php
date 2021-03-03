<?php
session_start();
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "../";
// Get the database connection file
require_once '../library/connections.php';
require_once '../library/functions.php';
require_once '../model/reviews-model.php';
require_once '../library/error_responses.php';

$errorStatus = App\errorStatus::getInstance();

$directoryURI = $_SERVER['REQUEST_URI'];
switch ($action) {
    // case 'submit':
    //     // include '../view/registration.php';
    //     break;
    default;
        
        $errorStatus->response(404, "Method not valid");
        // include '../view/admin.php';
        break;
        // include '../view/404.php';
}
