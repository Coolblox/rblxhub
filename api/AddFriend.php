<?php
header("Content-type: text/plain");
include "../core/conn.php";
include "../core/util_func.php";
include "../core/logged_in.php";

if (!$isloggedin) {
  die("You are not logged in!");
}


$user_from = $_USER['id'];
$user_to = intval($_GET['id']);

if ($user_to < 1) {
  die ("Invalid ID.");
}

$_1 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE user_from='$user_from' AND user_to='$user_to'"));
$_2 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE user_from='$user_to' AND user_to='$user_from'"));
$_3 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE user_from='$user_to' AND user_to='$user_from' AND arefriends='1'"));
$_4 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE user_from='$user_from' AND user_to='$user_to' AND arefriends='1'"));

//die($_1." ".$_2." ".$_3." ".$_4);
if (($_1 != 0) || ($_3 != 0) || ($_4 != 0) || ($user_to == $user_from)) {
  //Friend request already sent or users are already friends: Go back to user page.
  //die("1");
  //header("Location: User?id=".$user_to);

} else if ($_2 != 0) {
  //Other user already sent friend request: Accept request.
  //die("2");
  $arefriends = 1;
  $hash = md5($user_from.$user_to.$arefriends);
  $query = mysqli_query($connect, "UPDATE friends SET arefriends='1', hash='$hash' WHERE user_from='$user_to' AND user_to='$user_from'") or die(mysqli_query($connect));
  SendAutomatedMessageToId("Friend request accepted", $_USER['username'] . " has accepted your friend request.", $user_to);
} else {
  //All checks completed
  //die("3");

  if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE id='$user_to'")) == 0) {
    die("Invalid ID.");
  }
  $arefriends = 0;
  $hash = md5($user_from.$user_to.$arefriends);
  $query = mysqli_query($connect, "INSERT INTO  `friends` (
`id` ,
`user_from` ,
`user_to` ,
`arefriends` ,
`hash`
)
VALUES (
NULL ,  '$user_from',  '$user_to',  '0',  '$hash'
);") or die(mysqli_error($connect));
//SendAutomatedMessageToId("Friend request from {$_USER['username']}", $_USER['username'] . " has sent you a friend request.<br><a href=\"/api/AddFriend?id=$user_from\">Accept friend request</a>", $user_to);
}

if (isset($_GET['from_rq_page'])) {
  header("Location: /Requests");
} else {
  header("Location: /User.php?id=".$user_to);
}


?>