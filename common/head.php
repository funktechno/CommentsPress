<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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