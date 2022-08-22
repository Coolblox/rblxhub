<?php
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");

if (!$isloggedin) {
  die("<center>
    <h1>Games are only available to admins for testing.</h1>
  </center>
");
}

if ($_USER['permission_level'] != "ADMINISTRATOR") {
  die("<center>
    <h1>Games are only available to admins for testing.</h1>
  </center>
");
}
?>
