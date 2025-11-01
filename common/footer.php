<?php
if (!defined('APP_INIT')) {
    require_once '../library/defaultRouting.php';
}
?>
&copy; Comment Administration, All rights reserved. <?php
$startYear = 2022;
$currentYear = date('Y');
echo $startYear . ($currentYear > $startYear ? ' - ' . $currentYear : '');
?><br>
All images used are believed to be in "Fair Use". Please notify the author if any are not and they will be removed.