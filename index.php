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
require_once 'config/connections.php';
require_once 'library/functions.php';

// Build a navigation bar using the $categories array
$directoryURI = $_SERVER['REQUEST_URI'];
if ($action == NULL) {
    include 'view/home.php';
    exit;
}

switch ($action) {
    case 'home':
        include 'view/home.php';
        break;
    case 'bootstrap':
        include 'view/bootstrap.php';
        break;
    default:
        include 'view/404.php';
}
