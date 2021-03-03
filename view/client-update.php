<!DOCTYPE html>
<html lang="en">

<?php include '../common/head.php'; ?>

<body>
  <header>
    <?php include '../common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1 class="acmeHeader">Update Account</h1>
      <?php
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <form action="/accounts/" method="post">
        <p>Use this form to update your name or email information</p>
        <div class="red-border">
          <label>Display Name:</label>
          <br>
          <input name="clientDisplayName" id="clientDisplayName" type="text" <?php echo (isset($_SESSION['clientData']['clientDisplayName'])) ? "value='" . $_SESSION['clientData']['clientDisplayName'] . "'" : "" ?> required>

          <label>Email Address:</label>

          <br>


          <input name="clientEmail" class="long" id="clientEmail" type="email" <?php echo (isset($_SESSION['clientData']['clientEmail'])) ? "value='" . $_SESSION['clientData']['clientEmail'] . "'" : "" ?> required>
          <br>
          <!-- <button class="btn red" type="submit">Login</button> -->
          <input type="submit" class="btn red" name="submit" id="updatebtn" value="Update Account">

          <input type="hidden" name="clientId" value="<?php if (isset($_SESSION['clientData']['id'])) {
                                                        echo $_SESSION['clientData']['id'];
                                                      } elseif (isset($clientId)) {
                                                        echo $clientId;
                                                      } ?>">

          <!-- Add the action name - value pair -->
          <input type="hidden" name="action" value="updateClient">
        </div>
      </form>
      <h2 class="acmeHeader">Password Change</h2>
      <?php
      if (isset($_SESSION['message'])) {
        echo "<p class='message'>" . $_SESSION['message'] . "</p>";
      }
      ?>

      <form action="/accounts/" method="post">
        <p>Use this form to change your password</p>
        <div class="red-border">

          <label>New Password:</label>
          <br>

          <em>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character</em>
          <br>

          <input type="password" name="clientPassword" id="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" <?php echo (isset($clientPassword)) ? "value='$clientPassword'" : "" ?> required>
          <br>

          <!-- <button class="btn red" type="submit">Login</button> -->
          <input type="submit" class="btn red" name="submit" id="pwbtn" value="Change Password">

          <input type="hidden" name="clientId" value="<?php if (isset($_SESSION['clientData']['id'])) {
                                                        echo $_SESSION['clientData']['id'];
                                                      } elseif (isset($clientId)) {
                                                        echo $clientId;
                                                      } ?>">

          <!-- Add the action name - value pair -->
          <input type="hidden" name="action" value="updatePassword">
        </div>
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