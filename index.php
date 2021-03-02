<?php
/**
 * acme controller
 */
// Create or access a Session 
session_start();
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "";
// Get the database connection file
require_once 'library/connections.php';
require_once 'library/functions.php';
// Get the acme model for use as needed
require_once 'model/acme-model.php';

// Get the array of categories
// $categories = getCategories();

// var_dump($categories);
// exit;

// Build a navigation bar using the $categories array
$directoryURI = $_SERVER['REQUEST_URI'];
// $navList = getNavList($categories, $directoryURI);

// echo $navList;
// exit;

if ($action == NULL) {
    include 'view/home.php';
    exit;
}

switch ($action) {
    // case 'registration':
    //     include 'view/registration.php';

    //     break;
    case 'login':
        include 'view/login.php';

        break;
    case 'home':
        include 'view/home.php';
        break;

    case 'bootstrap':
        include 'view/bootstrap.php';
        break;
    // case 'contact':
    //     include 'template/template.php';

    //     break;
    default:
        include 'view/404.php';
}
