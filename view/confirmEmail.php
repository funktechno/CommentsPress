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
      <h1>Confirm Email</h1>
      <p>* indicates required fields</p>
      <?php
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <form action="/accounts/?action=confirmEmail" method="post">

        <label>Email Address *</label>
        <br />

        <input name="clientEmail" id="clientEmail" <?php echo (isset($clientEmail)) ? "value='$clientEmail'" : "" ?> type="email" required>
        <br />
        <input type="submit" name="sendConfirmEmail" class="btn red" name="submit" id="regbtn" value="Send Confirm Email">

        <br>
        <label>Confirm Email Code *</label>
        <br>
        <input name="emailCode" id="emailCode" type="text" <?php echo (isset($emailCode)) ? "value='$emailCode'" : "" ?> required>

        <br>
        <!-- <button class=" btn red" type="submit">Register</button> -->
        <input type="submit" name="confirmEmail" class="btn red" name="submit" id="regbtn" value="Confirm Email">


        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="confirmEmail">

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