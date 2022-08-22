<div style="width: 84%; float: right;">
			<center>
<?php
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

if (isset($_POST['sd'])) {
  $sdq = mysqli_query($connect, "UPDATE site_settings SET value='true' WHERE name='is_site_down'") or die(mysqli_error($connect));
  die("<br><br><br><br><br><center>Shutting Down Website.</center><meta http-equiv=\"refresh\" content=\"3;url=/maintenance\" />");
}

?>
<?php
include ("sidebar.php");
?>
<h2>Emergency Site Shutdown</h2>
<p>Pressing the button below will make the site shut down and visiting the site will redirect you to /maintenance.<br><b>
<form method="post">
  <br><br><br><br><br><br><input type="submit" name="sd" value="Maintenance Mode">
</form>
