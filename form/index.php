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
    case 'submit':
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_EMAIL);
        $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);

        $checkEmail = checkEmail($email);

        if (empty($checkEmail)) {
            $errorStatus->response(400, "Please provide valid email");
        }

        if (empty($email) || empty($body) || empty($subject)) {
            $errorStatus->response(400, "email, body, subject fields are required");
        }


        $regOutcome = submitForm($subject, $body, $email);
        if ($regOutcome === 1) {

            $statuscode = 201;

            header("HTTP/1.1 " . $statuscode);

            $response = array('Status' => 'success');


            echo json_encode(json_decode($response));
        } else {
            $errorStatus->response(500, "Error saving message");
        }
        break;
    default;

        $errorStatus->response(404, "Method not valid");
        break;
}
