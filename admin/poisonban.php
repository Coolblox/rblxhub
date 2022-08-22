<?php
include "include.php";
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
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 66.6%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<h2>Ban all linked accounts</h2>
<form method="post">
  <?php
  if (isset($_POST['submit'])) {
    $id = intval($_POST['userid']);
    $pbuser = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='$id'"));

    $ip = $pbuser['ip_address'];
    
    $upd = mysqli_query($connect, "UPDATE users SET `username` = CONCAT('Deleted Account ', id), `description` = 'This user has broken the rules and therefore this account has been terminated.' WHERE ip_address='$ip'") or die(mysqli_error($connect));
    $ins = mysqli_query($connect, "INSERT INTO ip_bans (`ip`) VALUES ('$ip')") or die(mysqli_error($connect));
    echo "Done!";
  }
  ?>
  User ID: <input type="number" name="userid" min="1" value="<?php echo $_POST['userid'] ?? 1 ?>"><br>
  <input type="submit" name="submit" value="Poison ban">
</form>