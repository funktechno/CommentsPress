<?php
//should contain app meta data such as version
define('APP_VERSION', '0.0.7');

define('APP_Name','CommentsPress');
// comment out this line if you don't want this meta response header
header('x-powered-by: ' . APP_Name . '/' . APP_VERSION);
