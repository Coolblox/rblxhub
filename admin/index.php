<div style="width: 84%; float: right;">
			<center>
<?php
//include "include.php";
include "/storage/ssd1/648/16177648/public_html/core/conn.php";
require("/storage/ssd1/648/16177648/public_html/core/logged_in.php");
if (!$isloggedin) {
  die("<center>
    <h1>404 Not Found</h1>
  <hr>
    nginx/1.10.3
  </center>
");
}

if ($_USER['permission_level'] != "ADMINISTRATOR") {
  die("<center>
    <h1>404 Not Found</h1>
  <hr>
    nginx/1.10.3
  </center>
");
}

?>
<br><br><br>
<h1>Welcome to admin panel, <?php echo $_USER['username'] ; ?></h1>
  <?php
include ("sidebar.php");
?>
<link id="ctl00_Imports" rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"></link>