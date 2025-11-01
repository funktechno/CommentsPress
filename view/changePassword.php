<?php
if (!defined('APP_INIT')) {
  require_once '../library/defaultRouting.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include '../common/head.php'; ?>

<body>
  <header>
    <?php include '../common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1>Reset Pasword</h1>
      <p>* indicates required fields</p>
      <?php
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <form action="/accounts/?action=resetPassword" method="post">
        <label>Email Reset Code *</label>
        <br>
        <input name="resetCode" id="resetCode" type="text" <?php echo (isset($resetCode)) ? "value='$resetCode'" : "" ?> required>

        <br>
        <br>
        <label>Email Address *</label>
        <br>
        <input name="clientEmail" id="clientEmail" <?php echo (isset($clientEmail)) ? "value='$clientEmail'" : "" ?> type="email" required>
        <br>
        <label>Password *</label>
        <br>

        <em>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character</em>
        <br>

        <input type="password" name="clientPassword" id="clientPassword" <?php echo (isset($clientPassword)) ? "value='$clientPassword'" : "" ?> pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        <br>
        <!-- <button class=" btn red" type="submit">Register</button> -->
        <input type="submit" class="btn red" name="submit" id="regbtn" value="Reset Password">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="reset_password">

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