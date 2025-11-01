<!DOCTYPE html>
<html lang="en">

<?php
if (!defined('APP_INIT')) {
  require_once '../library/defaultRouting.php';
}
$titleValue = "Login";
include '../common/head.php';
?>

<body>
  <header>
    <?php include '../common/header.php'; ?>
  </header>
  
  <main>
    <section>
      <h1 class="acmeHeader">Comment Login</h1>
      <?php
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <form action="/accounts/" method="post">
        <p>* indicates required fields</p>

        <label>Email Address *</label>

        <br>
        <input name="clientEmail" class="long" id="clientEmail" type="email" <?php echo htmlentities(isset($clientEmail) ? "value='$clientEmail'" : "") ?> required>
        <br>
        <label>Password *</label>
        <br>

        <em>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character</em>
        <br>

        <input type="password" name="clientPassword" id="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" <?php echo htmlentities(isset($clientPassword) ? "value='$clientPassword'" : "") ?> required>
        <br>

        <!-- <button class="btn red" type="submit">Login</button> -->
        <input type="submit" class="btn red" name="submit" id="loginbtn" value="Login">

        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="login_user">
        <br />
        <a href="/accounts/?action=forgotPassword" class="btn">Forgot Password</a>

      </form>
      <h2>Not a member?</h2>
      <a href="/accounts/?action=registration" class="btn red big">Create an Account</a>

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