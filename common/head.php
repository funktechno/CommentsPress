<?php
if (!defined('APP_INIT')) {
    require_once '../library/defaultRouting.php';
}
?>
<head>
  <!-- this will be broken if there are any echos before the head -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="apple-touch-icon" sizes="180x180" href="/images/site/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/site/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/site/favicon-16x16.png">
  <link rel="manifest" href="/images/site/site.webmanifest">
  <link rel="mask-icon" href="/images/site/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <title>
    <?php
    if (isset($titleValue)) {
      echo $titleValue;
    } else
      echo 'Comment page'
    ?>
  </title>
  <link rel="stylesheet" href="<?php echo $GLOBALS['documentRoot']; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo $GLOBALS['documentRoot']; ?>css/mobile.css" media="screen and (max-width: 585px)">
</head>