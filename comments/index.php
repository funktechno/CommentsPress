<?php
// session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "../";
// Get the database connection file
require_once '../library/connections.php';
require_once '../library/functions.php';
require_once '../model/reviews-model.php';
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
    case 'del':
        $payload = getJwtPayload();
        $clientData = getClient($payload['email']);

        if (!isset($clientData) || !isset($clientData['id'])) {
            $errorStatus->response(400, "Invalid user or password");
        }
        $userId = $clientData['id'];
        $id = $input['id'];

        if (empty($userId) || empty($id)) {
            $errorStatus->response(400, "comment id field is required");
        }

        $comment = getComment($id);
        if (!isset($comment['id'])) {
            $errorStatus->response(404, "Comment doesn't exist.");
        }

        if ($comment['userId'] != $userId) {
            $errorStatus->response(403, "You are not the creator of this comment.");
        }

        $result = deleteUserComment($id);
        // echo "test";
        // exit();
        if ($result === 1 || $result === 0) {
            // echo "test";

            $statuscode = 200;
            // 204 is different
            header("HTTP/1.1 " . $statuscode);
            // exit;


            $response = array('Status' => 'success');

            echo json_encode($response);
        } else {
            $errorStatus->response(500, "Error updating message");
        }

        break;
    case 'mod':
        $payload = getJwtPayload();
        $clientData = getClient($payload['email']);

        if (!isset($clientData) || !isset($clientData['id'])) {
            $errorStatus->response(400, "Invalid user or password");
        }
        $userId = $clientData['id'];
        $id = $input['id'];
        $body = $input['body'];

        if (empty($userId) || empty($id) || empty($body)) {
            $errorStatus->response(400, "comment id and body fields are required");
        }

        $comment = getComment($id);
        if (!isset($comment['id'])) {
            $errorStatus->response(404, "Comment doesn't exist.");
        }

        if ($comment['userId'] != $userId) {
            $errorStatus->response(403, "You are not the creator of this comment.");
        }

        $result = updateUserComment($id, $body);
        // echo $result;
        if ($result === 1 || $result === 0) {

            $statuscode = 200;

            header("HTTP/1.1 " . $statuscode);

            $response = array('Status' => 'success');

            echo json_encode($response);
        } else {
            $errorStatus->response(500, "Error updating message");
        }

        break;
    case 'get':
        $token = getBearerToken();
        $userId = null;
        if (!empty($token)) {
            $payload = getJwtPayload($token);
            $clientData = getClient($payload['email']);

            if (!isset($clientData) || !isset($clientData['id'])) {
                $errorStatus->response(400, "Invalid user or password");
            }
            $userId = $clientData['id'];
        }
        // echo $payload;
        // exit;

        $slug = $input['slug'];
        if (empty($slug)) {
            $errorStatus->response(400, "page slug field is required");
        }
        $comments = getPageComments($slug);
        // recursively updated comments w/ child comments

        echo json_encode($comments);

        break;
    case 'submit':
        // TODO guest check
        $payload = getJwtPayload();
        $clientData = getClient($payload['email']);

        if (!isset($clientData) || !isset($clientData['id'])) {
            $errorStatus->response(400, "Invalid user or password");
        }
        $userId = $clientData['id'];

        $slug = $input['slug'];
        // $pageId = $input['pageId'];
        $parentId = isset($input['parentId']) ? $input['parentId'] : null;
        $body = $input['body'];

        if (empty($userId) || empty($slug) || empty($body)) {
            $errorStatus->response(400, "page slug and body fields are required");
        }

        if (empty($parentId)) {
            $parentId = null;
        }


        // check if page locked
        $pageData = getPageStatus($slug);
        // if manual pages enabled then don't auto create page if it doesn't exist
        if (
            isset($pageData['manualPages']) &&
            $pageData['manualPages'] == 'true' &&
            !isset($pageData['id'])
        ) {
            $errorStatus->response(400, "Page doesn't exist.");
        }

        if (!isset($pageData['id'])) {
            // create page
            $newRecord = createPage($slug);
            if ($newRecord == 1) {
                $pageData = getPageStatus($slug);
            } else {
                $errorStatus->response(500, "Failed to auto create missing page.");
            }
        }

        if (isset($pageData['lockedComments']) && $pageData['lockedComments'] = 1) {
            $errorStatus->response(403, "Comments are locked on this page.");
        }
        // if not unlimited and parentid passed check existing comment if it has a parent id
        if (
            isset($parentId)
        ) {
            // echo $parentId;
            // grab comment and check that it doesn't have a parent id
            $parentComment = getComment($parentId);
            if (!isset($parentComment['id'])) {
                $errorStatus->response(404, "Parent comment doesn't exist.");
            }
            // check that pageid matches
            if ($parentComment['pageId'] != $pageData['id']) {
                $errorStatus->response(400, "Parent comment must be of the same page.");
            }
            if ((!isset($pageData['unlimitedReplies']) ||
                $pageData['unlimitedReplies'] != 'true')) {
                if (isset($parentComment['parentId'])) {
                    $errorStatus->response(400, "Unlimited replies are disabled. Only one level reply is permitted.");
                }
            }
        }
        $regOutcome = createComment($userId, $pageData['id'], $parentId, $body);
        if ($regOutcome === 1) {

            $statuscode = 201;

            header("HTTP/1.1 " . $statuscode);

            $response = array('Status' => 'success');

            echo json_encode($response);
        } else {
            $errorStatus->response(500, "Error saving message");
        }

        break;
    default;
        // header('location: /accounts/');
        $errorStatus->response(404, "Method not valid");
        // include '../view/admin.php';
        break;
        // include '../view/404.php';
}
