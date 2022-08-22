<?php
$hs = "localhost";
$un = "id16177648_rblxhub_user";
$pw = "1O]a/~rn+GE}26TB";

$down = false;
$meonly = true;

if ($meonly && $down) {
  if ($_SERVER['HTTP_CF_CONNECTING_IP'] != "your ip") {
    header("Location: /maintenance");
    die();
  }
}
$cn = mysqli_connect($hs, $un, $pw) or die("Failed to connect to SQL DB: ". mysqli_connect_error());
mysqli_select_db($cn, "id16177648_rblxhubdatabase") or die(mysqli_error($cn));

if (!isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
  $_SERVER['HTTP_CF_CONNECTING_IP'] = $_SERVER['REMOTE_ADDR'];
}

$haship = md5($_SERVER['HTTP_CF_CONNECTING_IP']);

if (mysqli_num_rows(mysqli_query($cn, "SELECT * FROM ip_bans WHERE ip='$haship'")) != 0) {
  header("Location: /ipbanned.php");
  die("Access denied.");
}



if ($meonly && $down) {
  if ($_SERVER['HTTP_CF_CONNECTING_IP'] != "your ip") {
    header("Location: /Upgrading");
    die();
  }
}

$ips = array("your ip");

$usedarr = $ips;

if ($down == true) {
  if (!in_array($_SERVER['HTTP_CF_CONNECTING_IP'], $usedarr)) {
    header("Location: /Upgrading");
    die();
  }
}
?>
