<?php
namespace App;
if (!defined('APP_INIT')) {
    require_once '../library/defaultRouting.php';
}

class errorStatus
{
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new errorStatus();
        }
        return self::$_instance;
    }
    /**
     * returns error response, may have conflicting names later on
     * $errors are thrown as a string... may need to update to be an array
     */
    public function response($statuscode, $errors, $debug = DEBUG)
    {
        // if isset($errors)
        // $errors=$errors[0]

        $errormessage = !isset($errors) ? "}" : ', "errors": "' . $errors . '"}';
        switch ($statuscode) {
            case 400:
                $message = '{"errorMsg":"Bad Request"' . $errormessage;
                break;
            case 401:
                $message = '{"errorMsg":"Unauthorized"' . $errormessage; // key not valid
                break;
            case 402:
                $message = '{"errorMsg":"Payment required"' . $errormessage;
                break;
            case 403:
                $message = '{"errorMsg":"Access forbidden"' . $errormessage; // dont have permission for premium features
                break;
            case 404:
                $message = '{"errorMsg":"Not Found"' . $errormessage; // use w/ invalid ?t or integrations
                break;
            case 405:
                $message = '{"errorMsg":"Method Not Allowed"' . $errormessage; // for anything, but post
                break;
            case 406:
                $message = '{"errorMsg":"Not Acceptable"' . $errormessage; // if invalid function passed
                break;
            case 407:
                $message = '{"errorMsg":"Proxy Authentication Required"' . $errormessage;
                break;
            case 408:
                $message = '{"errorMsg":"Request Timeout"' . $errormessage;
                break;
            case 409:
                $message = '{"errorMsg":"Conflict"' . $errormessage;
                break;
            case 410:
                $message = '{"errorMsg":"Gone"' . $errormessage;
                break;
            case 411:
                $message = '{"errorMsg":"Length Required"' . $errormessage;
                break;
            case 412:
                $message = '{"errorMsg":"Precondition Failed"' . $errormessage; // use if not a valid json or missing parameters
                break;
            case 413:
                $message = '{"errorMsg":"Payload Too Large"' . $errormessage;
                break;
            case 414:
                $message = '{"errorMsg":"Request-URI Too Long"' . $errormessage;
                break;
            case 415:
                $message = '{"errorMsg":"Unsupported Media Type"' . $errormessage;
                break;
            case 416:
                $message = '{"errorMsg":"Requested Range Not Satisfiable"' . $errormessage;
                break;
            case 417:
                $message = '{"errorMsg":"Expectation Failed"' . $errormessage;
                break;
            case 418:
                $message = '{"errorMsg":"I\'m a teapot"' . $errormessage;
                break;
            case 421:
                $message = '{"errorMsg":"Misdirected Request"' . $errormessage;
                break;
            case 422:
                $message = '{"errorMsg":"Unprocessable Entity"' . $errormessage; // if not valid json
                break;
            case 423:
                $message = '{"errorMsg":"Locked"' . $errormessage;
                break;
            case 424:
                $message = '{"errorMsg":"Failed Dependency"' . $errormessage;
                break;
            case 426:
                $message = '{"errorMsg":"Upgrade Required"' . $errormessage;
                break;
            case 428:
                $message = '{"errorMsg":"Precondition Required"' . $errormessage;
                break;
            case 429:
                $message = '{"errorMsg":"Too Many Requests"' . $errormessage; // pending max requests by api call
                break;
            case 431:
                $message = '{"errorMsg":"Request Header Fields Too Large"' . $errormessage;
                break;
            case 444:
                $message = '{"errorMsg":"Connection Closed Without Response"' . $errormessage;
                break;
            case 451:
                $message = '{"errorMsg":"Unavailable For Legal Reasons"' . $errormessage;
                break;
            case 499:
                $message = '{"errorMsg":"Client Closed Request"' . $errormessage;
                break;
            default:
                $statuscode = 500;
                $message = '{"errorMsg":"Internal Server Error"' . $errormessage;
                break;

        }

        header("HTTP/1.1 " . $statuscode);

        echo json_encode(json_decode($message));

        exit();
    }
}
