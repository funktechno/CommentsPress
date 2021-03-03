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
    case 'mod':
        // include '../view/registration.php';
        break;
    case 'del':
        // include '../view/registration.php';
        break;
    case 'get':

        break;
    case 'submit':
        // todo retrieve from jwt
        $userId = $input['userId'];

        $slug = $input['slug'];
        // $pageId = $input['pageId'];
        $parentId = $input['parentId'];
        $body = $input['body'];

        if (empty($userId) || empty($slug) || empty($body)) {
            $errorStatus->response(400, "page slug and body fields are required");
        }

        if (empty($parentId)) {
            $parentId = null;
        }


        // check if page locked
        $pageData = getPageStatus($slug);

        if (
            isset($parentId) &&
            (!isset($pageData['unlimitedReplies']) ||
                $pageData['unlimitedReplies'] != 'true')
        ) {
            echo $parentId;
            // grab comment and check that it doesn't have a parent id
            // $parentComment = getComment($parentId);

            // echo json_encode($parentComment);
            exit();
            // if()
        }
        // check config if auto create page

        echo json_encode($pageData);
        // if not unlimited and parentid passed check existing comment if it has a parent id
        // getComment()
        exit();
        $resut = createComment($userId, $pageId, $parentId, $body);

        break;
    case 'moderate':
        include '../view/commentModeration.php';

        break;
    default;
        // header('location: /accounts/');
        $errorStatus->response(404, "Method not valid");
        // include '../view/admin.php';
        break;
        // include '../view/404.php';
}
