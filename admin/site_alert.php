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
<h2>Site Alert</h2>
<form method="post">
  <?php
  $calertxt = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM site_settings WHERE name='alert_text'"))['value'];
  if (isset($_POST['upd'])) {
    $text = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['alert']));
    $visibility = ($_POST['show'] == 'ye');
    $vtext = $visibility ? "true" : "false";
    $upd = mysqli_query($connect, "UPDATE `site_settings` SET value='$vtext' WHERE name='is_alert_showing'") or die(mysqli_error($connect));
    $updt = mysqli_query($connect, "UPDATE `site_settings` SET value='$text' WHERE name='alert_text'") or die(mysqli_error($connect));
    echo "Updated alert.<br><br>";

  }
  ?>
  <?php
  $caltxt = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM site_settings WHERE name='alert_2_text'"))['value'];
  if (isset($_POST['upd2'])) {
    $text = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['alert2']));
    $visibility = ($_POST['show2'] == 'ye2');
    $vtext = $visibility ? "true" : "false";
    $upd2 = mysqli_query($connect, "UPDATE `site_settings` SET value='$vtext' WHERE name='is_alert_2_showing'") or die(mysqli_error($connect));
    $updt = mysqli_query($connect, "UPDATE `site_settings` SET value='$text' WHERE name='alert_2_text'") or die(mysqli_error($connect));
    echo "Updated alert.<br><br>";

  }
  ?>
  <?php
include ("sidebar.php");
?>

  Alert Text 1 (Color: Yellow): <input type="text" maxlength="256" name="alert" value="<?php echo $calertxt ?>"><br><br>
  Show Site Alert?<br>
  <input type="radio" name="show" value="ye" checked> Yes<br>
  <input type="radio" name="show" value="nah"> No<br><br>
  <input type="submit" name="upd" value="Update Site Alert"><br>
</form>
Alert Text 2 (Color: Green): <input type="text" maxlength="256" name="alert2" value="<?php echo $caltxt ?>"><br><br>
  Show Site Alert?<br>
  <input type="radio" name="show2" value="ye2" checked> Yes<br>
  <input type="radio" name="show2" value="nah2"> No<br><br>
  <input type="submit" name="upd2" value="Update Site Alert"><br>
</form>
