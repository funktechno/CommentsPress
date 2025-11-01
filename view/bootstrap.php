<?php
if (!defined('APP_INIT')) {
  require_once '../library/defaultRouting.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>bootstrap</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/mobile.css" media="screen and (max-width: 585px)">

</head>

<body>
  <header>
    <?php include 'common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1 class="acmeHeader">Database Connection Test</h1>
    <?php 
    try{
      $db = acmeConnect();
      // echo $db;
      $status = $db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
      echo "database connection successful";
    } catch (Exception $e) {
      // echo $e;
      // $error = $e;
      echo "database connection failed";
      // echo $error;
      // echo 'Sorry, the connection failed';
      // header('location: /view/500.php');
      // include $GLOBALS['root'] . 'view/500.php';
      // exit;
    }
    ?>
      
    </section>
  </main>

  <footer class="text-center">
    <!-- Footer Text  -->
    <?php include 'common/footer.php'; ?>
  </footer>
</body>

</html>