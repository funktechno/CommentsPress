<?php

require_once './mailConfig.php';

// standard mail from server

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($mailConfig['Msg'],70);

// send email
mail($mailConfig['To'],$mailConfig['Subject'],$mailConfig['Msg']);