<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$acme = strpos($path, 'acme');
$components = explode('/', $path);
$first_part = $components[sizeof($components) - 1];
if (isset($_COOKIE['firstname'])) {
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}
?>
<div id="topNav">
  <figure>
    <a href="/"><img src="<?php echo $GLOBALS['documentRoot']; ?>images/site/logo.png" alt="Comment Logo"></a>
  </figure>
  <div class="toplinks">
    <?php if (isset($cookieFirstname)) {
      echo "<span>Welcome $cookieFirstname</span>";
    } ?>
    <?php
    if (!isset($_SESSION['loggedin'])) {
      echo '<a href="/accounts/?action=login" id="folder"><img src="' . $GLOBALS['documentRoot'] . 'images/site/account.gif" title="folder" alt="Image of red folder"> My account </a>';
    } else {
      echo '<a href="/accounts/?action=logout" id="folder">Log out</a>';
    }
    ?>
  </div>
</div>
<nav id="bottomNav">
  <div>
    <?php echo $navList;

    /*<ul>
    <li><a href="index.php?action=home" class="<?php echo (strpos($directoryURI, 'home') || !strpos($directoryURI, 'action') ? 'active' : '')?>">Home</a></li>
    <li><a href="/acme/cannon.php" class="<?php echo (strpos($directoryURI, 'cannon') ? 'active' : '')?>">Cannon</a></li>
    <li><a href="" class="<?php echo ($first_part == "explosive.php" ? 'active' : '')?>">Explosive</a></li>
    <li><a href="" class="<?php echo ($first_part == "misc.php" ? 'active' : '')?>">Misc</a></li>
    <li><a href="" class="<?php echo ($first_part == "rocket.php" ? 'active' : '')?>">Rocket</a></li>
    <li><a href="" class="<?php echo ($first_part == "trap.php" ? 'active' : '')?>">Trap</a></li>
  </ul> */
    ?>
  </div>
</nav>