<?php
//if (!$isloggedin) {
    //header("Location: /");
//}
require ("/storage/ssd1/648/16177648/public_html/core/conn.php");
          if (isset($_POST['username'])) {
            if (false) {
              $error = true;
              $errormsg = "Captcha failed, please try again.";
            } else {
              $ip_address = md5($_SERVER['REMOTE_ADDR']);
              $error = false;
              $errormsg = "";

              $username = mysqli_real_escape_string($connect, $_POST['username']);
              $password = mysqli_real_escape_string($connect, $_POST['password']);

              $dbuserq = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'") or die(mysqli_error($connect));

              if (mysqli_num_rows($dbuserq) < 1) {
                $error = true;
                $errormsg = "That account doesn't exist. Login using a different account or create a new one.";
              } else {
                $dbuser = mysqli_fetch_assoc($dbuserq);
                if (password_verify($password, $dbuser['password'])) {
                  $user = $dbuser;
                  $token = md5($username . $user['id'] . $ip_address . time() . rand(0, 1000));

                  $tokenq = mysqli_query($connect, "INSERT INTO `session_tokens`(`id`, `token`, `user_id`, `ip_address`)
                  VALUES
                  (NULL, '$token', '". $user['id'] ."','$ip_address')") or die(mysqli_error($connect));

                  setcookie("BT_AUTH", $token, time() + (60 * 60 * 24 * 7000), "/");

                  if (isset($_GET['ReturnUrl'])) {
                    $loc = utf8_decode(urldecode($_GET['ReturnUrl']));

                    header("Location: $loc");
                  } else {
                    header("Location: /");
                  }
                } else {
                  $error = true;
                  $errormsg = "Password is incorrect.";
                }
              }
            }


            if ($error) {
              echo "<article class=\"message is-danger is-small\">
          <div class=\"message-body\">
          $errormsg
          </div>
          </article>";
            }
          }
          ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><link rel="stylesheet" crossorigin="anonymous" href="http://gc.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cDovL3dlYi5hcmNoaXZlLm9yZy93ZWIvMjAwNzA4MTMwMzQ1MDUvaHR0cDovd3d3LnJvYmxveC5jb20vTG9naW4vRGVmYXVsdC5hc3B4"><script src="//archive.org/includes/analytics.js?v=cf34f82" type="text/javascript"></script>
<script type="text/javascript">window.addEventListener('DOMContentLoaded',function(){var v=archive_analytics.values;v.service='wb';v.server_name='wwwb-app43.us.archive.org';v.server_ms=1181;archive_analytics.send_pageview({});});</script><script type="text/javascript" src="/_static/js/playback.bundle.js?v=BsQ6byDz" charset="utf-8"></script>
<script type="text/javascript" src="/_static/js/wombat.js?v=cRqOKCOw" charset="utf-8"></script>
<script type="text/javascript">
  __wm.init("http://web.archive.org/web");
  __wm.wombat("http://www.roblox.com:80/Login/Default.aspx","20070813034505","http://web.archive.org/","web","/_static/",
	      "1186976705");
</script>
<link rel="stylesheet" type="text/css" href="/_static/css/banner-styles.css?v=NHuXCfBH">
<link rel="stylesheet" type="text/css" href="/_static/css/iconochive.css?v=qtvMKcIJ">
<!-- End Wayback Rewrite JS Include -->
<title>
<?=$title?>
</title><link rel="stylesheet" type="text/css" href="/CSS/AllCSS.ashx.css"><link rel="Shortcut Icon" type="image/ico" href="/web/20070813034505im_/http://www.roblox.com/roblox.ico"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="author" content="ROBLOX Corporation"><meta name="description" content="ROBLOX is SAFE for kids! ROBLOX is a FREE casual virtual world with fully constructible/desctructible environments and immersive physics. Build, battle, chat, or just hang out."><meta name="keywords" content="game, video game, building game, contstruction game, online game, LEGO game, LEGO, MMO, MMORPG, virtual world, avatar chat"><meta name="robots" content="all"></head>
	<body><!-- BEGIN WAYBACK TOOLBAR INSERT -->
<style type="text/css">
body {
  margin-top:0 !important;
  padding-top:0 !important;
  /*min-width:800px !important;*/
}
</style>
<script>__wm.rw(0);</script>
<div id="wm-ipp-base" lang="en" style="display: block; direction: ltr;">
</div>
			<div id="Container">
				<div id="Header">
					<div id="Banner">
						<div id="Options">
							<div id="Settings"></div>
						</div>
						<div id="Logo"><a id="ctl00_Image1" title="<?=$sitename?>" href="/" style="display:inline-block;cursor:hand;"><img src="/images/Logo.png" border="0" id="img" blankurl="http://t2.roblox.com:80/blank-267x70.gif"></a></div>
					</div>
				</div>
				<div id="Body"><br>
  <?php
        if(!empty($error)){
            echo $error;
        }
        ?>
        <br>
	<div id="FrameLogin" style="margin: 150px auto 150px auto; width: 500px; border: black thin solid; padding: 45px;">
		<div id="PaneNewUser">
			<h3>New User?</h3>
			<p>You need an account to play <?=$sitename?>.</p>
			<p>If you aren't a <?=$sitename?> member then <a id="ctl00_cphRoblox_HyperLink1" href="/register">register</a>. It's easy and we do <em>not</em> share your personal information with anybody.</p>
		</div>
		<div id="PaneLogin">
			<h3>Log In</h3>
          <form method="POST" action="">
<div class="AspNet-Login">
	<div class="AspNet-Login-UserPanel">
		<label for="username" class="TextboxLabel"><em>U</em>ser Name:</label>
		<input type="text" name="username" value="" accesskey="u">&nbsp;
	</div>
	<div class="AspNet-Login-PasswordPanel">
		<label for="password" class="TextboxLabel"><em>P</em>assword:</label>
		<input type="password" name="password" value="" accesskey="p">&nbsp;
	</div>
	<div class="AspNet-Login-SubmitPanel">
		<input href="#" type="submit" name="sign_in" value="Log In">
	</div>
</div>
</form>
		</div>
	</div>

				</div>
				<?php
				require ("/storage/ssd1/648/16177648/public_html/core/footer.php");
				?>
			</body></html>
