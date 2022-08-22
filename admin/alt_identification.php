<div style="width: 84%; float: right;">
			<center>
<?php
include ("/storage/ssd1/648/16177648/public_html/core/conn.php");
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
<?php
include ("sidebar.php");
?>
<h2>Alt Identification</h2>
<form method="post">
  User ID: <input type="number" name="uid" min="1" value="<?php echo $_POST['uid'] ?? 1 ?>"><br>
  <input type="submit" name="submit" value="Lookup">
</form>

<table>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <!--<th>Email</th>-->
    <th>Date Joined</th>
    <th>Robux</th>
    <th>Tickets</th>
    <th>Last seen</th>
    <th>Rank</th>
    <th>Membership type</th>
  </tr>
  <?php
  if (isset($_POST['submit'])) {
    $id = intval($_POST['uid']) ?? 1;
    $usq = mysqli_query($connect , "SELECT * FROM users WHERE id='$id'") or die(mysqli_error($connect));
    $ip = mysqli_fetch_assoc($usq)['ip_address'];

    $ipusq = mysqli_query($connect, "SELECT * FROM `users` WHERE ip_address='$ip'") or die(mysqli_error($connect));
    $total = mysqli_num_rows($ipusq);
    while ($user = mysqli_fetch_assoc($ipusq)) {

      echo "<tr><td>{$user['id']}</td>
      <td>{$user['username']}</td>
      <td>{$user['time_joined']}</td>
      <td>{$user['robux']}</td>
      <td>{$user['tickets']}</td>
      <td>{$user['lastseen']}</td>
      <td>{$user['permission_level']}</td>
      <td>{$user['membership_type']}</td></tr>";
    }
    echo "<tr><td>Total: $total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
  }
   ?>

</table>
