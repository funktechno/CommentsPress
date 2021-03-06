<!DOCTYPE html>
<html lang="en">

<?php
$titleValue = "Comment Management";
include 'common/head.php';
?>

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
            <?php } else { ?>
              <li><a href="/accounts/?action=login">Login</a></li>
            <?php } ?>
            <?php if (folder_exist('examples')) { ?>
              <li><a href="/examples/vue.html">Examples</a></li>
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