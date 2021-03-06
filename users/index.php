<?php
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "../";
// Get the database connection file
require_once '../library/connections.php';
require_once '../library/functions.php';

// require_once '../library/jwt/ValidatesJWT.php';
// require_once '../library/jwt/JWTException.php';
// require_once '../library/jwt/JWT.php';

require_once '../model/accounts-model.php';
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
switch ($action) {
    case 'login':
        $clientEmail = $input['email'];
        $clientPassword = $input['password'];
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);
        if (empty($clientEmail) || empty($checkPassword)) {
            $errorStatus->response(400, "Valid email, and password fields are required.");
        }
        $clientData = getClient($clientEmail);

        if (!isset($clientData) || !isset($clientData['id'])) {
            $errorStatus->response(400, "Invalid user or password");
        }

        $hashCheck = password_verify($clientPassword, $clientData['password']);

        if (!$hashCheck) {
            $errorStatus->response(400, "Invalid user or password.");
        }

        $statuscode = 200;

        header("HTTP/1.1 " . $statuscode);
        // generate jwt
        unset($clientData['password']);
        // $token = $jwt->encode($payload, $header);
        $token = getJwtToken($clientData);

        $response = array('Status' => 'success', 'userInfo' => $clientData, 'token' => $token);

        echo json_encode($response);

        // $payload = $jwt->decode($token);

        // echo json_encode($payload);

        break;
    case 'profile':
        // get token from user
        $payload = getJwtPayload();
        $clientData = getClient($payload['email']);

        if (!isset($clientData) || !isset($clientData['id'])) {
            $errorStatus->response(400, "Invalid user or password");
        }

        $statuscode = 200;

        header("HTTP/1.1 " . $statuscode);
        unset($clientData['password']);

        echo json_encode($clientData);

        break;
    case 'register':
        $clientDisplayName = $input['displayName'];
        $clientEmail = $input['email'];
        $clientPassword = $input['password'];
        // echo $clientEmail;
        // echo $clientDisplayName;
        // echo $clientPassword;
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);
        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $errorStatus->response(400, "That email address already exists. Do you want to login instead?");
            exit;
        }

        if (empty($clientDisplayName) || empty($clientEmail) || empty($checkPassword)) {
            $errorStatus->response(400, "Valid email, password, and displayName fields are required.");
            exit;
        } else {
            try {
                // Hash the checked password
                $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

                // Send the data to the model
                $regOutcome = regClient($clientEmail, $clientDisplayName, $hashedPassword);
                if ($regOutcome === 1) {
                    $statuscode = 201;

                    header("HTTP/1.1 " . $statuscode);

                    $response = array('Status' => 'success');

                    echo json_encode($response);
                    exit;
                } else {
                    $errorStatus->response(500, "Error registering user");
                    exit;
                }
            } catch (\Throwable $th) {
                $errorStatus->response(500, json_encode($th));
            }
        }

        break;
    default;
        $errorStatus->response(404, "Method not valid");
        break;
}
