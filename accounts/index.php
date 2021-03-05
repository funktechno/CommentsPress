<?php

/**
 * account controller
 */
// Create or access a Session 
session_start();
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
$GLOBALS['root'] = "../";
// Get the database connection file
require_once '../library/connections.php';
require_once '../library/functions.php';
// Get the acme model for use as needed
require_once '../model/accounts-model.php';
require_once '../model/pages-model.php';
require_once '../model/reviews-model.php';
require_once '../model/configuration-model.php';


// Get the array of categories
// $categories = getCategories();
// var_dump($categories);
// exit;

// Build a navigation bar using the $categories array
$directoryURI = $_SERVER['REQUEST_URI'];
// $navList = getNavList($categories, $directoryURI);

// echo $navList;
// exit;

// if ($action == NULL) {
//     include 'view/home.php';
//     exit;
// }
// echo $action;
// exit();

switch ($action) {
    case 'registration':
        include '../view/registration.php';

        break;
    case 'logout':
        // destroy session
        session_destroy();
        session_start();
        // include '../view/login.php';
        header('location: /');
        break;
    case 'register_user':
        // echo 'You are in the register case statement.';
        // $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientDisplayName = filter_input(INPUT_POST, 'clientDisplayName', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        // validate
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if ($existingEmail) {
            $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }
        // else {
        //     //return 1;
        //     echo 'Match found';
        //     exit;
        // }
        if (empty($clientDisplayName) || empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = '<p class="error">Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit;
        } else {
            try {
                // Hash the checked password
                $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

                // Send the data to the model
                $regOutcome = regClient($clientEmail, $clientDisplayName, $hashedPassword);
                if ($regOutcome === 1) {
                    setcookie('displayName', $clientDisplayName, strtotime('+1 year'), '/');
                    $_SESSION['message'] = "<p>Thanks for registering $clientDisplayName. Please use your  email and password to login.</p>";
                    // header('location: /acme/accounts/?action=login');
                    // include '../view/login.php';
                    exit;
                } else {
                    $_SESSION['message'] = "<p class='error'>Sorry $clientDisplayName, but the registration failed. Please try again.</p>";
                    include '../view/registration.php';
                    exit;
                }
            } catch (\Throwable $th) {
                $_SESSION['message'] = '<p class="error">' . $th . '.</p>';
                include '../view/registration.php';
                exit;
            }
        }
        break;
    case 'moderate':
        include '../view/commentModeration.php';

        break;
    case 'confirmEmail':
        include '../view/confirmEmail.php';
        break;
    case 'resetPassword':
        include '../view/changePassword.php';
        break;
    case 'forgotPassword':
        include '../view/forgotPassword.php';
        break;
    case 'login':
        include '../view/login.php';
        break;

    case 'login_user':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        // validate
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);
        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = '<p class="error">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['password']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $_SESSION['message'] = '<p class="error">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view
        include '../view/admin.php';
        exit;

        break;
        // case 'home':
        //     include 'view/home.php';
        //     break;
        // case 'template':
        //     include 'template/template.php';

        //     break;
    case 'modClient':
        // $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
        $clientId = $_SESSION['clientData']['id'];

        // $prodInfo = getProductInfo($invId);
        // if (count($prodInfo) < 1) {
        //     $_SESSION['message'] = '<p class="error">Sorry, no product information could be found.</p>';
        //     header('location: /acme/products/');
        //     exit;
        // }
        include '../view/client-update.php';
        break;
    case 'updateClient':
        if (!IsLoggedInAndHasAccess()) {
            include '../view/client-update.php';
            exit();
        }
        $clientDisplayName = filter_input(INPUT_POST, 'clientDisplayName', FILTER_SANITIZE_STRING);
        // $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        // $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        // $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        // validate
        // $clientEmail = checkEmail($clientEmail);
        // $checkPassword = checkPassword($clientPassword);

        // $existingEmail = checkExistingEmail($clientEmail);

        // $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING);
        $clientId = $_SESSION['clientData']['id'];

        // exit();
        if (empty($clientDisplayName) || empty($clientEmail)) {
            $_SESSION['message'] = '<p class="error">Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit;
        }

        $updateResult = updateClient(
            $clientDisplayName,
            $clientId
        );

        if ($updateResult) {
            $message = "<p class='notice'>$clientDisplayName, your update was successful.</p>";
            $_SESSION['message'] = $message;
            $clientData = getClient($clientEmail);
            array_pop($clientData);
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            header('location: /accounts/');
            exit;
        } else {
            $message = "<p class='notice'>Error. $clientDisplayName was not updated.</p>";
            $_SESSION['message'] = $message;
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'testEmail':
        if (!IsLoggedInAndHasAccess(2)) {
            include '../view/admin.php';
            exit();
        }
        // echo 'test1';
        // echo 'test55';
        $formEmails = getContactFormEmails();
        // echo json_encode($formEmails);
        // echo 'test2';
        // exit;
        $sentEmail = sentTestEmail($formEmails);
        echo $sentEmail;
        // send email
        include '../view/admin.php';
        break;
    case 'updateConfig':
        // load config data
        include '../view/updateConfig.php';
        break;
    case 'deleteUpdatePage':
        // don't do any actions if not valid access
        if (!IsLoggedInAndHasAccess(2)) {
            include '../view/managePages.php';
            exit();
        }
        $configInput = [];
        $configInput['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if (isset($_POST['update'])) {
            $configInput['slug'] = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
            $configInput['lockedComments'] = filter_input(INPUT_POST, 'lockedComments', FILTER_SANITIZE_STRING);
            // $configInput['userId'] = $_SESSION['clientData']['id'];

            // echo json_encode($configInput);
            // exit();
            try {
                $updateResult = updatePage(
                    $configInput
                );
            } catch (\Throwable $th) {
                if (isset($th->errorInfo)) {
                    $message = "<p class='notice'>Error. Updating page " . $configInput['id'] . ".<br/>" . json_encode($th->errorInfo) . "</p>";
                    $_SESSION['message'] = $message;
                } else {
                    $message = "<p class='notice'>Error. Updating page " . $configInput['id'] . ".</p>";
                    $_SESSION['message'] = $message;
                }
                include '../view/managePages.php';
                exit();
            }


            if ($updateResult) {
                $message = "<p class='notice'>Page " . $configInput['id'] . " was updated successfuly.</p>";
                $_SESSION['message'] = $message;
                // header('location: /acme/accounts/');
                // exit;
            } else {
                $message = "<p class='notice'>Error. Updating page " . $configInput['id'] . ".</p>";
            }
        } elseif (isset($_POST['delete'])) {
            $result = deletePage($configInput['id']);
            if ($result === 1 || $result === 0) {
                $message = "<p class='notice'>Page " . $configInput['id'] . " was deleted successfuly.</p>";
            } else {
                $message = "<p class='notice'>Error. Deleting page " . $configInput['id'] . ".</p>";
            }
            $_SESSION['message'] = $message;
        }

        include '../view/managePages.php';
        break;
    case 'updateConfigData':
        // don't do any actions if not valid access
        if (!IsLoggedInAndHasAccess(2)) {
            include '../view/updateConfig.php';
            exit();
        }
        $configInput = [];
        $configInput['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $configInput['data'] = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
        // $configInput['userId'] = $_SESSION['clientData']['id'];
        $configInput['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        // echo json_encode($configInput);
        // exit();
        try {
            $updateResult = updateConfig(
                $configInput
            );
        } catch (\Throwable $th) {
            if (isset($th->errorInfo)) {
                $message = "<p class='notice'>Error. Updating config " . $configInput['id'] . ".<br/>" . json_encode($th->errorInfo) . "</p>";
                $_SESSION['message'] = $message;
            } else {
                $message = "<p class='notice'>Error. Updating config " . $configInput['id'] . ".</p>";
                $_SESSION['message'] = $message;
            }
            include '../view/updateConfig.php';
            exit();
        }

        if ($updateResult) {
            $message = "<p class='notice'>Config " . $configInput['id'] . " was updated successfuly.</p>";
            $_SESSION['message'] = $message;
            // header('location: /acme/accounts/');
            // exit;
        } else {
            $message = "<p class='notice'>Error. Updating config " . $configInput['id'] . ".</p>";
        }

        include '../view/updateConfig.php';
        break;
    case 'addPage':
        if (!IsLoggedInAndHasAccess(2)) {
            include '../view/managePage.php';
            exit();
        }
        $configInput = [];
        $configInput['slug'] = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
        $configInput['lockedComments'] = filter_input(INPUT_POST, 'lockedComments', FILTER_SANITIZE_STRING);
        try {
            $updateResult = addPage(
                $configInput['slug'],
                $configInput['lockedComments']
            );
        } catch (\Throwable $th) {
            if (isset($th->errorInfo)) {
                $message = "<p class='notice'>Error. Adding page " . $configInput['name'] . ".<br/>" . json_encode($th->errorInfo) . "</p>";
                $_SESSION['message'] = $message;
            } else {
                $message = "<p class='notice'>Error. Adding page " . $configInput['name'] . ".</p>";
                $_SESSION['message'] = $message;
            }
            include '../view/managePage.php';
            exit();
        }

        if ($updateResult) {
            $message = "<p class='notice'>Config " . $configInput['slug'] . " was added successfuly.</p>";
            $_SESSION['message'] = $message;
            // header('location: /acme/accounts/');
            // exit;
        } else {
            $message = "<p class='notice'>Error. Adding page " . $configInput['slug'] . ".</p>";
            $_SESSION['message'] = $message;
        }
        include '../view/managePages.php';
        break;
    case 'addConfigData':
        if (!IsLoggedInAndHasAccess(2)) {
            include '../view/updateConfig.php';
            exit();
        }
        $configInput = [];
        $configInput['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $configInput['data'] = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
        try {
            $updateResult = addConfig(
                $configInput
            );
        } catch (\Throwable $th) {
            if (isset($th->errorInfo)) {
                $message = "<p class='notice'>Error. Adding config " . $configInput['name'] . ".<br/>" . json_encode($th->errorInfo) . "</p>";
                $_SESSION['message'] = $message;
            } else {
                $message = "<p class='notice'>Error. Adding config " . $configInput['name'] . ".</p>";
                $_SESSION['message'] = $message;
            }
            include '../view/updateConfig.php';
            exit();
        }

        if ($updateResult) {
            $message = "<p class='notice'>Config " . $configInput['name'] . " was added successfuly.</p>";
            $_SESSION['message'] = $message;
            // header('location: /acme/accounts/');
            // exit;
        } else {
            $message = "<p class='notice'>Error. Adding config " . $configInput['name'] . ".</p>";
            $_SESSION['message'] = $message;
        }
        include '../view/updateConfig.php';
        break;
    case 'contactForms':
        include '../view/contactForms.php';
        break;
    case 'managePages':
        include '../view/managePages.php';
        break;
    case 'updatePassword':
        if (!IsLoggedInAndHasAccess()) {
            include '../view/client-update.php';
            exit();
        }
        // $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        // $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        // $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        // validate
        // $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // $existingEmail = checkExistingEmail($clientEmail);
        // $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING);
        $clientId = $_SESSION['clientData']['id'];
        if (empty($checkPassword)) {
            $_SESSION['message'] = '<p class="error">Please provide information for all empty form fields.</p>';
            include '../client-update.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $updateResult = updatePassword(
            $hashedPassword,
            $clientId
        );

        if ($updateResult) {
            $message = "<p class='notice'>Your password update was successful.</p>";
            $_SESSION['message'] = $message;
            header('location: /accounts/');
            exit;
        } else {
            $message = "<p class='notice'>Error. Password was not updated.</p>";
            include '../client-update.php';
            exit;
        }
        break;
    default:
        include '../view/admin.php';
        // include '../view/404.php';
}
