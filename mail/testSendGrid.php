<?php
// uses sendgrid api directly using curl method
// no external library
// will need an api key from sendgrid
// also need to verify from email address for the send to work
$curl = curl_init();
require_once './library/connectios.php';
$mailConfig = getMailConfig();
$postfields = "{\"personalizations\": [{\"to\": [{\"email\": \"" . $mailConfig['To'] . "\"}]}],\"from\": {\"email\": \"" . $mailConfig['From'] . "\"},\"subject\": \"" . $mailConfig['Subject'] . 'send grid' . "\",\"content\": [{\"type\": \"text/plain\",\"value\": \"" . $mailConfig['Msg'] . "\"}]}";
// echo json_encode($postfields);

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postfields,
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authorization: Bearer " . $mailConfig['SendGridKey'],
        "content-type: application/json",
        "user-agent: vscode-restclient"
    ],
]);

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// exit();
$response = curl_exec($curl);
$info = curl_getinfo($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo 'Unexpected HTTP code: ', $http_code, "\n";
    echo json_encode($response);
    echo "sucess send grid email";
}
