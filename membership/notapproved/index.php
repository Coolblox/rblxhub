<?php
include "/opt/htdocs/core/conn.php";
include "/opt/htdocs/core/logged_in.php";
$ban_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM bans WHERE userid='". $_USER['id'] ."' AND unbanned='0'"));
$extra_message = "";
if ($ban_data['bantype'] == 'reminder') {
  $ban_type = 'Reminder';
} else if ($ban_data['bantype'] == 'warning') {
  $ban_type = 'Warning';
} else if ($ban_data['bantype'] == '1dayban') {
  $ban_type = 'Banned for 1 Day';
  $extra_message = "<p>
    Your account has been disabled for 1 day.
  </p>";
} else if ($ban_data['bantype'] == '3dayban') {
  $ban_type = 'Banned for 3 Days';
  $extra_message = "<p>
    Your account has been disabled for 3 days.
  </p>";
} else if ($ban_data['bantype'] == '7dayban') {
  $ban_type = 'Banned for 1 Week';
  $extra_message = "<p>
    Your account has been disabled for 7 days.
  </p>";
} else if ($ban_data['bantype'] == '14dayban') {
  $ban_type = 'Banned for 2 Weeks';
  $extra_message = "<p>
    Your account has been disabled for 14 days.
  </p>";
} else if ($ban_data['bantype'] == 'deleteaccount') {
  $ban_type = 'Account Deleted';
  $extra_message = "<p>
    Your account has been terminated.
  </p>";
} else {
  $ban_type = $ban_data['bantype'];
}


?>

<style>
  body {
    font-family: "Trebuchet MS";
  }
</style>
<title>NovaBricks - Banned</title>
<body>
  <br>
  <br>
  <br>
<div style="border: solid 1px #000; margin: 0 auto; padding: 30px; max-width: 500px;">
  <h2><?php echo $ban_type ?></h2>
  <p>
    Our content monitors have determined that your behaviour at <?=$sitename?> has been in violation of our Terms of Service. We will terminate your account if you do not abide by the rules.
  </p>
  <p>
    Moderator note:
    <div style='border: solid 1px #000; margin: 0 auto; padding: 10px; max-width: 500px;'>
      <?php echo $ban_data['reason'] ?>
    </div>
  </p>
  <p>
    Please abide by the <?=$sitename?> Community Guidelines so that <?=$sitename?> can be fun for users of all ages.
  </p>

  <?php
  echo $extra_message;
  ?>

  <p>
    <a href='/Login/Expire.php'>Log out</a>
    <?php
    if (($ban_data['unbantime'] <= time()) && ($ban_data['bantype'] != 'deleteaccount')) {
      echo " | <a href='/reactivate_account.php'>Reactivate account</a>";
    }
    ?>
  </p>
</div>
</body>