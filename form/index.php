<?php
// session_start();
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "../";
// Get the database connection file
require_once '../library/connections.php';
require_once '../library/functions.php';
require_once '../model/form-model.php';
require_once '../library/error_responses.php';
require_once '../library/mailFunctions.php';
require_once '../model/configuration-model.php';

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
switch ($action) {
    case 'submit':
        $email = $input['email'];
        $body = $input['body'];
        $subject = $input['subject'];

        $checkEmail = checkEmail($email);

        if (empty($checkEmail)) {
            $errorStatus->response(400, "Please provide valid email" . $email);
        }

        if (empty($email) || empty($body) || empty($subject)) {
            $errorStatus->response(400, "email, body, subject fields are required");
        }


        $regOutcome = submitForm($subject, $body, $email);
        if ($regOutcome === 1) {

            $statuscode = 201;

            header("HTTP/1.1 " . $statuscode);

            $response = array('Status' => 'success');

            $formEmails = getContactFormEmails();

            // maybe disable or comment out?
            // send email
            $result = sendEmail('[Contact Form]' . $subject, $formEmails['data'], $body . "\nFrom:" . $email);

            echo json_encode($response);
        } else {
            $errorStatus->response(500, "Error saving message");
        }
        break;
    default;

        $errorStatus->response(404, "Method not valid");
        break;
}
