<?php
// handle sso
session_start();
$sso = filter_input(INPUT_POST, 'sso');
if ($sso == NULL) {
    $sso = filter_input(INPUT_GET, 'sso');
}
$from = filter_input(INPUT_POST, 'from');
if ($from == NULL) {
    $from = filter_input(INPUT_GET, 'from');
}
$GLOBALS['root'] = "../";
require_once '../config/connections.php';

$directoryURI = $_SERVER['REQUEST_URI'];


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

$facebookApp = getFacebookSSO();
require_once '../library/sso/Facebook/autoload.php';
// library\sso\Facebook\autoload.php
// ex using https://github.com/sunnykhatri/Login-with-facebook-using-php
// use Facebook\Facebook;
// use Facebook\Exceptions\FacebookResponseException;
// use Facebook\Exceptions\FacebookSDKException;

// $facebook = new Facebook(array('app_id' => $facebookApp['clientId'], 'app_secret' => $facebookApp['clientSecret'], 'default_graph_version' => $facebookApp['graphApiVersion'],));
// $helper = $facebook->getRedirectLoginHelper();
// echo json_encode($_SESSION);
// require_once '.jwt/ValidatesJWT.php';
// require_once 'jwt/JWTException.php';
// require_once 'jwt/JWT.php';

// $provider = new \League\OAuth2\Client\Provider\Facebook([
//     'clientId'          => '{facebook-app-id}',
//     'clientSecret'      => '{facebook-app-secret}',
//     'redirectUri'       => 'https://example.com/callback-url',
//     'graphApiVersion'   => 'v2.10',
// ]);
// try {
// 	if(isset($_SESSION['fb_token'])){
// 		$accessToken = $_SESSION['fb_token'];
// 	}else{
//   		$accessToken = $helper->getAccessToken();
// 	}
// } catch(FacebookResponseException $e) {
//  	echo 'Facebook Responser error: ' . $e->getMessage();
//   	exit;
// } catch(FacebookSDKException $e) {
// 	echo 'Facebook SDK error: ' . $e->getMessage();
//   	exit;
// }

echo $action;
switch ($action) {
    case 'test':
        include '../view/ssoTest.php';

        break;
    default:
        echo "sso:" . $sso . "<br>";

        echo "from:" . $from . "<br>";

        break;
}
