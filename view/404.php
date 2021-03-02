<!DOCTYPE html>
<html lang="en">

<?php include $GLOBALS['root'] . 'common/head.php'; ?>

<body>
  <header>
    <div id="topNav">
      <figure>
      <img src="<?php echo $GLOBALS['documentRoot']; ?>images/site/logo.png" alt="Comment Logo">
      </figure>
      <div class="toplinks">
        <span><a href="/accounts/">Welcome test</a> |</span> <a href="/accounts/?action=login" id="folder"><img src="/images/site/account.gif" title="folder" alt="Image of red folder"> My account </a> </div>
    </div>
    <nav id="bottomNav">
      <div>
        <ul>
          <li><a class="" href="/index.php" title="View the Comment home page">Home</a></li>
        </ul>
      </div>
    </nav>
    <?php //include '../common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1>Page Not Found</h1>
      <p>Requested page not found.</p>
      <?php
      if (isset($error) && $error != null) {
        echo '<p>' . $error . '</p>';
      }
      ?>
      <hr>
    </section>
  </main>

  <footer class="text-center">
    <!-- Footer Text  -->
    <?php include $GLOBALS['root'] . 'common/footer.php'; ?>
  </footer>
</body>

</html>