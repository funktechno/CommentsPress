<!DOCTYPE html>
<html lang="en">

<?php include '../common/head.php'; ?>

<body>
  <header>
    <?php include '../common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1>Forgot Password</h1>
      <p>* indicates required fields</p>
      <?php
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <form action="/accounts/?action=forgotPassword" method="post">
        <label>Email Address *</label>
        <br>
        <input name="clientEmail" id="clientEmail" <?php echo (isset($clientEmail)) ? "value='$clientEmail'" : "" ?> type="email" required>
        <br />
        <input type="submit" class="btn red" name="submit" id="regbtn" value="Forgot Password">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="forgot_password">
        <br />

        <a href="/accounts/?action=resetPassword" class="btn">Reset Password</a>


      </form>
      <br>
      <br>
      <hr>
    </section>
  </main>

  <footer class="text-center">
    <!-- Footer Text  -->
    <?php include '../common/footer.php'; ?>
  </footer>
</body>

</html>