<?php
ob_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require("whitelist.php");
include ("conn.php");
include ("logged_in.php");
require("util_func.php");

require("rendering.php");

require("achievement_rewarder.php");

$down = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `site_settings` WHERE name='is_site_down' AND value='true'")) > 0;
$meonly = true;

if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
$CSRF = $_SESSION['token'];

if (!$isloggedin) {
	// none
} else {
	$unreadmsg = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM messages WHERE readto='0' AND user_to='{$_USER['id']}'"));
}

if ($down) {
  header("Location: /maintenance");
  die();
}
if (!$isloggedin) {
	// none for now
} else {
$currenttime = time();

  $q = mysqli_query($connect, "UPDATE users SET `lastseen` = '$currenttime' WHERE id='{$_USER['id']}'") or die(mysqli_error($connect));

  if ($_USER['next_tix_reward'] < time()) {
    $dailyreward = 15;
    $nextrew = time() + 86400;
    mysqli_query($connect, "UPDATE users SET `tickets` = `tickets` + '$dailyreward', `next_tix_reward` = '$nextrew' WHERE id='{$_USER['id']}'") or die(mysqli_error($connect));
    }
  }

$alert = "";


if (mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM site_settings WHERE name='is_alert_showing'"))['value'] == "true") {
  $alerttext = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM site_settings WHERE name='alert_text'"))['value'];
  $alert = "<div class=\"SystemAlert\">
					<div class=\"SystemAlertText\" style=\"background-color: #dfa811\">
						<div class=\"Exclamation\">
						</div>
						<div>$alerttext</div>
					</div>
				</div>";
}
$alert2 = "";


if (mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM site_settings WHERE name='is_alert_2_showing'"))['value'] == "true") {
  $alert2text = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM site_settings WHERE name='alert_2_text'"))['value'];
  $alert2 = "<div class=\"SystemAlert\">
					<div class=\"SystemAlertText\" style=\"background-color: green\">
						<div class=\"Exclamation\">
						</div>
						<div>$alert2text</div>
					</div>
				</div>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" id="www-roblox-com">
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>
	<?=$title?>
</title><link id="ctl00_Imports" rel="stylesheet" type="text/css" href="/CSS/AllCSSnew.css"/><link id="ctl00_Favicon" rel="Shortcut Icon" type="image/ico" href="roblox.ico"/><meta name="author" content="<?=$sitename?> Corporation"/><meta name="description" content="<?=$sitename?> is SAFE for kids! <?=$sitename?> is a FREE casual virtual world with fully constructible/desctructible 3D environments and immersive physics. Build, battle, chat, or just hang out."/><meta name="keywords" content="game, video game, building game, construction game, online game, LEGO game, LEGO, MMO, MMORPG, virtual world, avatar chat"/><meta name="robots" content="all"/></head>
	<body>
			<div id="Container">
<div id="AdvertisingLeaderboard">
     <script type="text/javascript"><!--
	    google_ad_client = "pub-2247123265392502";
	    google_ad_width = 728;
	    google_ad_height = 90;
	    google_ad_format = "728x90_as";
	    google_ad_type = "text_image";
	    google_ad_channel = "";
	    //-->
    </script>
    <script type="text/javascript" src="pagead/show_ads.js"></script>
</div>
				<div id="Header">
					<div id="Banner">
						<div id="Options">
							<div id="Authentication">
                                                                <?php

              if (!$isloggedin) {
                echo "<a href=\"Login\">Login</a>";
              } else {
                echo "
                Logged in as {$_USER['username']}&nbsp;<strong>|</strong>&nbsp;<a href=\"/Login/logout.php\">Logout</a>
                  ";
              }

              ?>
							</div>
							<?php

              if (!$isloggedin) {
                // none
              } else {
                echo "
                <div id=\"Settings\">
								Age 13+, Chat Mode: Filter
							</div>
                  ";
              }

              ?>
						
						</div>
						<div id="Logo"><a id="ctl00_rbxImage_Logo" title="<?=$sitename?>" href="/" style="display:inline-block;cursor:pointer;"><img src="/images/Logo.png" border="0" id="img" alt="<?=$sitename?>" blankurl="http://t2.roblox.com:80/blank-267x70.gif"/></a>
						</div>
						<div id="Alerts"><table style="width:100%;height:100%"><tr><td valign="middle">
              <?php
              if (!$isloggedin) {
                echo "<a id=\"ctl00_rbxAlerts_SignupAndPlayHyperLink\" class=\"SignUpAndPlay\" href=\"/register\"><img src=\"/images/SignupBannerV2.png\" alt=\"Sign-up and Play!\" border=\"0\"/></a>";
              } else {
                echo "
                <table style=\"width:123%;height:101%\">
			<tbody><tr>
				<td valign=\"middle\">

					<div>
						<div id=\"AlertSpace\">
							<div>
                                                                    <div id=\"MessageAlert\">
									<a class=\"TicketsAlertIcon\"><img src=\"/images/Message.gif\" style=\"border-width:0px;\"></a>&nbsp;
									<a href=\"/currency\" class=\"TicketsAlertCaption\">$unreadmsg New Messages!</a>
								</div>
								<div id=\"RobuxAlert\">
									<a class=\"TicketsAlertIcon\"><img src=\"/images/Robux.png\" style=\"border-width:0px;\"></a>&nbsp;
									<a href=\"/currency\" class=\"TicketsAlertCaption\">{$_USER['robux']} ROBUX</a>
								</div>
								<div id=\"TicketsAlert\">
									<a class=\"TicketsAlertIcon\"><img src=\"/images/Tickets.png\" style=\"border-width:0px;\"></a>&nbsp;
									<a href=\"/currency\" class=\"TicketsAlertCaption\">{$_USER['tickets']} Tickets</a>
								</div>
				</div>
						</div>
					</div>
				</td>
						</tr>
					</tbody></table>
				</div>
                  ";
              }

              ?>
</td></tr></table></div>
          </div>