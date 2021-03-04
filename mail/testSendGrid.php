<?php
$curl = curl_init();
require_once './mailConfig.php';

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\"personalizations\": [{\"to\": [{\"email\": \"" . $mailConfig['To'] . "\"}]}],\"from\": {\"email\": \"" . $mailConfig['From'] . "\"},\"subject\": \"" . $mailConfig['Subject'] . 'send grid' . "\",\"content\": [{\"type\": \"text/plain\",\"value\": \"" . $mailConfig['Msg'] . "\"}]}",
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authorization: Bearer " . $mailConfig['SendGridKey'],
        "content-type: application/json",
        "user-agent: vscode-restclient"
    ],
]);


$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo "sucess send grid email";
}
