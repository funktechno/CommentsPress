<?php

// send grid email
/**
 * to is a comma split list of emails to send to
 */
function sendEmail($subject, $to, $msg)
{
    $toEmails = explode(',', $to);
    // echo json_encode($toEmails);

    $toEmailFields = "";
    foreach ($toEmails as $email) {
        // echo $email . ",";
        if (!empty($toEmailFields))
            $toEmailFields .= ",";
        $toEmailFields .= "{\"email\": \"" . $email . "\"}";
    }


    // {\"email\": \"" . $to . "\"}
    // exit();

    $mailConfig = getMailConfig();
    $curl = curl_init();
    $postfields = "{\"personalizations\": [{\"to\": [" . $toEmailFields . "]}],\"from\": {\"email\": \"" . $mailConfig['From'] . "\"},\"subject\": \"" . $subject . "\",\"content\": [{\"type\": \"text/plain\",\"value\": \"" . $msg . "\"}]}";
    // echo json_encode($postfields);
    // exit();

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
    // $info = curl_getinfo($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // 202 is valid
        // echo 'Unexpected HTTP code: ', $http_code, "\n";
        // echo json_encode($response);
        return $http_code;
        // echo "sucess send grid email";
    }
}
