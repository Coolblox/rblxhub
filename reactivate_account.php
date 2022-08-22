<?php
include "core/conn.php";
include "core/logged_in.php";
$ban_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM bans WHERE username='". $_USER['username'] ."' AND unbanned='0'"));
$redir = false;
if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM bans WHERE username='". $_USER['username'] ."' AND unbanned='0'")) == 0) {
  $redir = true;
}

if ($ban_data['bantype'] == 'ipban') {
  die("Cannot reactivate account.");
}

if ($ban_data['bantype'] == 'hwidban') {
  die("Cannot reactivate account.");
}

if ($ban_data['bantype'] == 'deleteaccount') {
  die("Cannot reactivate account.");
}

if ($ban_data['bantype'] == 'deleteaccountwipe') {
  die("Cannot reactivate account.");
}

if ($ban_data['unbantime'] <= time()) {
  $unban = true;
}

if ($unban == true) {
  $unban_q = mysqli_query($connect, "UPDATE bans SET unbanned='1' WHERE username='". $_USER['username'] ."'") or die(mysqli_error($connect));
  $unban_q = mysqli_query($connect, "UPDATE users SET is_banned='0' WHERE username='". $_USER['username'] ."'") or die(mysqli_error($connect));
  $redir = true;
}

if ($redir == true) {
  header("Location: /");
}

?>
