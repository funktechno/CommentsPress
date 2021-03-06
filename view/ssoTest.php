<!DOCTYPE html>
<html lang="en">

<?php include '../common/head.php'; ?>

<body>
  <header>
    <?php include '../common/header.php'; ?>
  </header>

  <main>
    <section>
      <h1>SSO Test</h1>
      <?php
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
      }
      ?>
      <a target="_blank" rel="noopener noreferrer" href="/sso/?sso=facebook&from=https%3A%2F%2Fdemo.remark42.com%2Fweb%2Fiframe.html%3FselfClose&amp;site=remark" class="oauth-button oauth-module__button_0d123" data-provider-name="Facebook" title="Sign In with Facebook"><img class="oauth-icon" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMjAgMTAuMDYwOUMyMCA0LjUwMzA0IDE1LjUyNDIgMCAxMCAwQzQuNDc1ODEgMCAwIDQuNTAzMDQgMCAxMC4wNjA5QzAgMTUuMDgyNCAzLjY1Njg2IDE5LjI0NDYgOC40Mzc1IDIwVjEyLjk2OTJINS44OTcxOFYxMC4wNjA5SDguNDM3NVY3Ljg0NDIyQzguNDM3NSA1LjMyMjkyIDkuOTI5NDQgMy45MzAyMiAxMi4yMTQ1IDMuOTMwMjJDMTMuMzA4OSAzLjkzMDIyIDE0LjQ1MzIgNC4xMjY1NyAxNC40NTMyIDQuMTI2NTdWNi42MDEyMkgxMy4xOTE5QzExLjk1IDYuNjAxMjIgMTEuNTYyNSA3LjM3Njg4IDExLjU2MjUgOC4xNzI0MVYxMC4wNjA5SDE0LjMzNTlMMTMuODkyMyAxMi45NjkySDExLjU2MjVWMjBDMTYuMzQzMSAxOS4yNDQ2IDIwIDE1LjA4MjQgMjAgMTAuMDYwOVoiIGZpbGw9IiMwQTgyRUQiLz48L3N2Zz4K" width="20" height="20" alt="" aria-hidden="true"></a>
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