<?php
if ($isloggedin) {
  $a__friend_count = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$_USER['id']} AND `arefriends`='1') OR  (`user_to` = {$_USER['id']} AND `arefriends`='1')"));
  $a__trade_value = 0;
  $a__asdfs = mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='{$_USER['id']}'") or die(mysqli_error($connect));

  while ($a__inv = mysqli_fetch_assoc($a__asdfs)) {
    $a__asset = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM catalog WHERE id='{$a__inv['assetid']}'"));

    if ($a__asset['is_limited'] == 1) {
      $a__totalsales = 0;
      $a__salesc = 0;

      $a__slq = mysqli_query($connect, "SELECT * FROM limited_sales WHERE item_id='{$a__asset['id']}'") or die(mysqli_error($connect));
      while ($a__sssssss = mysqli_fetch_assoc($a__slq)) {
        $a__totalsales = $a__totalsales + $a__sssssss['price'];
        $a__salesc++;
      }
      if ($a__totalsales != 0) {
        $a__avg_price = round($a__totalsales / $a__salesc);
      } else {
        $a__avg_price = 0;
      }
      $a__trade_value = $a__trade_value + $a__avg_price;
    }
  }



  if ($a__friend_count >= 25) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='1'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '1')") or die(mysqli_error($connect));
    }
  }

  if ($a__friend_count >= 50) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='2'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '2')") or die(mysqli_error($connect));
    }
  }

  if ($a__friend_count >= 100) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='3'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '3')") or die(mysqli_error($connect));
    }
  }

  if ($a__friend_count >= 500) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='4'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '4')") or die(mysqli_error($connect));
    }
  }

  if ($a__friend_count >= 1000) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='5'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '5')") or die(mysqli_error($connect));
    }
  }

  if ($_USER['permission_level'] != "DEFAULT") {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='6'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '6')") or die(mysqli_error($connect));
    }
  }

  if ($a__trade_value >= 1000) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='7'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '7')") or die(mysqli_error($connect));
    }
  }

  if ($a__trade_value >= 10000) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='9'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '9')") or die(mysqli_error($connect));
    }
  }

  if ($a__trade_value >= 100000) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='10'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '10')") or die(mysqli_error($connect));
    }
  }

  if ($a__trade_value >= 1000000) {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='11'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '11')") or die(mysqli_error($connect));
    }
  }

  if ($_USER['super_mod'] != "0") {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='12'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '12')") or die(mysqli_error($connect));
    }
  }

  if ($_USER['image_mod'] != "0") {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='13'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '13')") or die(mysqli_error($connect));
    }
  }

  if ($_USER['forum_mod'] != "0") {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='14'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '14')") or die(mysqli_error($connect));
    }
  }

  if ($_USER['membership_type'] != "NONE") {
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}' AND achievement_id='15'")) == 0) {
      $ins = mysqli_query($connect, "INSERT INTO owned_achievements (`user_id`, `achievement_id`) VALUES ('{$_USER['id']}', '15')") or die(mysqli_error($connect));
    }
  }
}
?>