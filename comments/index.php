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

$directoryURI = $_SERVER['REQUEST_URI'];
switch ($action) {
    case 'mod':
        // include '../view/registration.php';
    case 'del':
        // include '../view/registration.php';
    case 'moderate':
        include '../view/commentModeration.php';

        break;
    default;
        header('location: /accounts/');
        // include '../view/admin.php';
        break;
        // include '../view/404.php';
}
