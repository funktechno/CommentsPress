<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Comment Management</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/mobile.css" media="screen and (max-width: 585px)">

</head>

<body>
  <header>
    <?php include 'common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1 id="welcome">Welcome to Comment Management!</h1>

      <!-- Hero description text -->
      <div class="row">
        <div class="col col-12">
          <!-- Hero Product Review text -->
          <h3>Comment </h3>
          <ul>
          <?php if (isset($_SESSION['loggedin'])) { ?>
          <li><a href="/accounts/">Account</a></li>
          <?php } else {?>
            <li><a href="/accounts/?action=login">Login</a></li>
          <?php } ?>
          </ul>
        </div>

      </div>
      <hr>
    </section>
  </main>

  <footer class="text-center">
    <!-- Footer Text  -->
    <?php include 'common/footer.php'; ?>
  </footer>
</body>

</html>