<div style="width: 84%; float: right;">
			<center>
<?php
require("/storage/ssd1/648/16177648/public_html/core/conn.php");
require("/storage/ssd1/648/16177648/public_html/core/logged_in.php");
require("/storage/ssd1/648/16177648/public_html/core/util_func.php");
require("/storage/ssd1/648/16177648/public_html/core/whitelist.php");
require("/storage/ssd1/648/16177648/public_html/core/rendering.php");
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
$oneday = 86400;

if (isset($_GET['id'])) {
  $lols = "value=\"".intval($_GET['id'])."\"";
} else {
  $lols = "";
}


?>
<?php
include ("sidebar.php");
?>

<h2>User Moderation</h2>
<?php
if (isset($_POST['submit'])) {
  $idtoban = intval($_POST['id']);
  $type = $_POST['type'];
  $reason = mysqli_real_escape_string($connect, $_POST['reason']);
  
  if (!isset($_POST['reason'])) {
    echo "Please provide a reason.";
  } else {
    if (!isset($_POST['id'])) {
      echo "Please provide a reason.";
    } else {
      $usertobanq = mysqli_query($connect, "SELECT * FROM users WHERE id = '$idtoban'") or die(mysqli_error($connect));
      if (mysqli_num_rows($usertobanq) == 0) {
        echo "User does not exist.";
      } else {
        $usertoban = mysqli_fetch_assoc($usertobanq);
        $username = $usertoban['username'];
        $userid = $usertoban['id'];
        $moderator = $_USER['id'];
        $ip = $usertoban['ip_address'];
        $unbanned = 0;

        if ($username == $moderator) {
          die("really?");
        }

        if ($userid <= 0) {
          die("Please enter a valid user ID");
        }

        if ($type == "reminder") {
          $unbantime = time();
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));
        } else if ($type == "warning") {
          $unbantime = time();
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));
        } else if ($type=='1dayban') {
          $unbantime = time() + $oneday;
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          
        } else if ($type == '3dayban') {
          $unbantime = time() + ($oneday * 3);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          
        } else if ($type == '7dayban') {
          $unbantime = time() + ($oneday * 7);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          
        } else if ($type == '14dayban') {
          $unbantime = time() + ($oneday * 14);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          
        } else if ($type == 'deleteaccount') {
          if (false) {
            die("Community Manger + required.");
          }
          $unbantime = time() + (9999999999);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1', description='This user has been terminated.', avatar_hash='89ed2771639dc2f8780769730effac5d' WHERE id='$userid'") or die(mysqli_error($connect));
          //$forumupd = mysqli_query($connect, "UPDATE forum SET content='[ Content Deleted ]', content='This forum post has been created by a user which account has been terminated.' WHERE author='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          
        } else if ($type == 'deleteaccountwipe') {
          if (false) {
            die("Community Manger + required.");
          }
          $unbantime = time() + (9999999999);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1', username='[ Content Deleted $userid ]', description='This user has been terminated.', avatar_hash='89ed2771639dc2f8780769730effac5d' WHERE id='$userid'") or die(mysqli_error($connect));
          $forumupd = mysqli_query($connect, "UPDATE forum SET content='[ Content Deleted ]', content='This forum post has been created by a user which account has been terminated.' WHERE author='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          
        } else if ($type == 'hwidban') {
          if (false) {
            die("Community Manger + required.");
          }
          $unbantime = time() + (9999999999);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));

          $banhwid = mysqli_query($connect, "UPDATE `hardware-ids` SET banned='1' WHERE ip_address='$ip'") or die("Couldn't ban HWID: " . mysqli_error($connect));

          
        } else if ($type == 'ipban') {
          if (false) {
            die("Community Manger + required.");
          }
          $unbantime = time() + (9999999999);
          $set = mysqli_query($connect, "UPDATE `users` SET is_banned='1' WHERE id='$userid'") or die(mysqli_error($connect));
          $qqq = mysqli_query($connect, "
          INSERT INTO `bans` (`id`, `username`, `userid`, `moderator`, `reason`, `unbantime`, `ip`, `bantype`, `unbanned`)
          VALUES (NULL, '$username', '$userid', '$moderator', '$reason', '$unbantime', '$ip', '$type', '$unbanned');") or die(mysqli_error($connect));
          $ipban = mysqli_query($connect, "INSERT INTO ip_bans (`ip`) VALUES ('$ip')") or die(mysqli_error($connect));

          
        } else {
          echo "Invalid type.";
        }

        
        echo "User moderated with ID $userid ($username) has been moderated.";
      }
    }
  }
}
?>
<br><br>
<form method="post">
  <input type='number' name='id' <?php echo $lols ?> placeholder="User ID"><br><br><select name="type">
    <option value="reminder">Reminder</option>
    <option value="warning">Warning</option>
    <option value="1dayban">1 day ban</option>
    <option value="3dayban">3 day ban</option>
    <option value="7dayban">7 day ban</option>
    <option value="14dayban">14 day ban</option>
    <option value="deleteaccount">Delete Account</option>
    <option value="deleteaccountwipe">Delete account + Wipe Username and forum posts</option>
    <option value="ipban">IP Ban</option>
  </select><br><br>
  <textarea name='reason' placeholder="Reason" rows='14' cols='70'></textarea><br><br>
  <input type='submit' name='submit' value='Moderate'>
</form>