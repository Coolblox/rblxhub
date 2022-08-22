<?php
include "../core/conn.php";
include "../core/util_func.php";
require_once "ReCaptcha.php";

//die("<title>Disabled</title><div id=\"Body\"><div style=\"margin: 100px auto 100px auto; width: 500px; border: black thin solid; padding: 22px; color: black;\"><h2 style=\"text-align:center;\"></h2><p>Register has been disabled.</p>");

$secret = "recaptcha secret here";

// empty response
/*$response = null;

$reCaptcha = new ReCaptcha($secret);

if (isset($_POST["g-recaptcha-response"])) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}
if ($response != null && $response->success) {
	$captcha_completed = true;
} else {
	$captcha_completed = false;
}*/

$captcha_completed = true;

if (isset($_POST['username'])) {

  $ageGroup = 0;//mysqli_real_escape_string($connect, $_POST['AgeGroup']);
  $username = mysqli_real_escape_string($connect, $_POST['username']);
  $password = $_POST['password'];
  $repeatpassword = $_POST['confirmpassword'];
  $supersafechat = 0;//mysqli_real_escape_string($connect, $_POST['rblChatMode']);
  $email = mysqli_real_escape_string($connect, $_POST['email']);

  if (!$captcha_completed) {
    die("reCAPTCHA failed, please try again.");
  }

  if (strlen($username) == 0) {
    die("Your username must be at least 3 characters.");
  }

  if (strlen($username) < 3) {
    die("Your username must be at least 3 characters.");
  }

  if (strlen($username) > 20) {
    die("Your username's length must be less than 20 characters");
  }

  if (preg_match('/[^a-zA-Z\d]/', $username)) {
    die("Username contains special characters.");
  }

  if (FilterString($username) != "OK") {
    $bw = FilterString($username);
    die("Username contains profanity! Please remove \"$bw\" from your username and try again.");
  }
  $iphash = md5($_SERVER['REMOTE_ADDR']);
  if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE ip_address='$iphash'")) > 25 && $_SERVER['REMOTE_ADDR'] != "your ip") {
    die("You have reached the account limit.");
  }

  $check = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'") or die("{\"Error\": true,\"Message\": \"An unknown error has occurred, please try again later.\"}");

  if (mysqli_num_rows($check) < 1) {
    //Can sign up.

    if ($password != $repeatpassword) {
      die("The two entered passwords do not match eachother!");
    } else {
      $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("invalid email");
      } else {

        /*              */
        $id = "NULL";
        $username = $username;
        $password = $hashedpassword;
        $email = $email;
        $underthirteen = 0;//($ageGroup != 2);
        $supersafechat = 0;//$supersafechat;
        $time_joined = time();
        $ip_address = md5($_SERVER['REMOTE_ADDR']);
        $robux = 0;
        $tickets = 0;
        /*              */

        $query_user = mysqli_query($connect, "INSERT INTO `users`
          (`id`, `username`, `password`, `email`, `underthirteen`, `supersafechat`, `time_joined`, `ip_address`, `robux`, `tickets`)
          VALUES
          ($id,'$username','$password','$email','$underthirteen','$supersafechat','$time_joined','$ip_address','$robux','$tickets')") or die(mysqli_error($connect));

        $userq = mysqli_query($connect, "SELECT * FROM users WHERE `username`='$username'") or die(mysqli_error($connect));

        $user = mysqli_fetch_assoc($userq);

        $token = md5($username . $user['id'] . $ip_address . time() . rand(0, 1000));

        $tokenq = mysqli_query($connect, "INSERT INTO `session_tokens`(`id`, `token`, `user_id`, `ip_address`)
        VALUES
        (NULL, '$token', '". $user['id'] ."','$ip_address')") or die(mysqli_error($connect));

        setcookie("BT_AUTH", $token, time()+(60 * 60 * 24 * 7000), "/");

        if (isset($_GET['ReturnUrl'])) {
          $loc = utf8_decode(urldecode($_GET['ReturnUrl']));

          header("Location: $loc");
        } else {
          header("Location: /?ns=true");
        }


        die();
      }
    }

  } else {
    $newname = $name.rand(1, 999);
    die("{\"Error\": true,\"Message\": \"This username is already taken! Try $newname instead!\"}");
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><link rel="stylesheet" crossorigin="anonymous" href="http://gc.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cDovL3dlYi5hcmNoaXZlLm9yZy93ZWIvMjAwNzA4MDQwODM5MjcvaHR0cDovcm9ibG94LmNvbS9Mb2dpbi9OZXcuYXNweA"><script src="//archive.org/includes/analytics.js?v=cf34f82" type="text/javascript"></script>
<title>
<?=$title?>
</title><link rel="stylesheet" type="text/css" href="/CSS/AllCSS.ashx.css"><link rel="Shortcut Icon" type="image/ico" href="/web/20070804083927im_/http://roblox.com/roblox.ico"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="author" content="ROBLOX Corporation"><meta name="description" content="ROBLOX is SAFE for kids! ROBLOX is a FREE casual virtual world with fully constructible/desctructible environments and immersive physics. Build, battle, chat, or just hang out."><meta name="keywords" content="game, video game, building game, contstruction game, online game, LEGO game, LEGO, MMO, MMORPG, virtual world, avatar chat"><meta name="robots" content="all"></head>
	<body>
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
						<div id="Logo"><a id="ctl00_Image1" title="<?=$sitename?>" href="/" style="display:inline-block;cursor:hand;"><img src="/images/Logo_267_70.png" border="0" id="img" blankurl="http://t2.roblox.com:80/blank-267x70.gif"></a></div>
					</div>
				</div>
				<div id="Body">
          <?php
                  if(!empty($error)){
                      echo $error;
                  }
                  ?>
<form method="POST" action="">
		<div id="Registration">
			<div id="ctl00_cphRoblox_upAccountRegistration">

					<h2>Sign Up and Play</h2>
					<h3>Step 1 of 2: Create Account</h3>
					<div id="EnterUsername">
						<fieldset title="Choose a name for your <?=$sitename?> character">
							<legend>Choose a name for your <?=$sitename?> character</legend>
							<div class="Suggestion">
								Use 3-20 alphanumeric characters: A-Z, a-z, 0-9, no spaces
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="UsernameRow">
								<label for="ctl00_cphRoblox_UserName" id="ctl00_cphRoblox_UserNameLabel" class="Label">Character Name:</label>&nbsp;<input type="text" name="username" tabindex="1" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div id="EnterPassword">
						<fieldset title="Choose your <?=$sitename?> password">
							<legend>Choose your <?=$sitename?> password</legend>
							<div class="Suggestion">
								4-10 characters, no spaces
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="PasswordRow">
								<label for="ctl00_cphRoblox_Password" id="ctl00_cphRoblox_LabelPassword" class="Label">Password:</label>&nbsp;<input type="password" name="password" id="ctl00_cphRoblox_Password" tabindex="2" class="TextBox">
							</div>
							<div class="ConfirmPasswordRow">
								<label for="ctl00_cphRoblox_TextBoxPasswordConfirm" id="ctl00_cphRoblox_LabelPasswordConfirm" class="Label">Confirm Password:</label>&nbsp;<input type="password" name="confirmpassword" id="ctl00_cphRoblox_TextBoxPasswordConfirm" tabindex="3" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div id="EnterEmail">
						<fieldset title="Provide your parent's email address">
							<legend>Provide your email address</legend>
							<div class="Suggestion">
								We need to verify you.
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="EmailRow">
								<label for="ctl00_cphRoblox_TextBoxEMail" id="ctl00_cphRoblox_LabelEmail" class="Label">Your Email:</label>&nbsp;<input type="text" name="email" id="ctl00_cphRoblox_TextBoxEMail" tabindex="4" class="TextBox">
							</div>
						</fieldset>
                    </div>
                    <div id="EnterPassword">
						<fieldset title="Please complete the CAPTCHA Check.">
							<legend>Please complete the CAPTCHA Check.</legend>
							<div class="Suggestion">
								This is to avoid raiders, bots, etc...
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="g-recaptcha" data-sitekey="6LcXul0aAAAAALhsBRGZyxZSUs236JYZd32Thr_B"></div>
						</fieldset>
					</div>
					<div class="Confirm">
						<input href="#" type="submit" name="sign_up" value="Register" class="BigButton">
					</div>

</div>
		</div>
  </form>
		<div id="Sidebars">
			<div id="AlreadyRegistered">
				<h3>Already Registered?</h3>
				<p>If you just need to login, go to the <a id="ctl00_cphRoblox_HyperLinkLogin" href="/Login">Login</a> page.</p>
				<p>If you have already registered but you still need to download the game installer, go directly to <a id="ctl00_cphRoblox_HyperLinkDownload" href="/download/">download</a>.</p>
			</div>
			<div id="TermsAndConditions">
				<h3>Terms &amp; Conditions</h3>
				<p>Registration does not provide any guarantees of service. See our <a id="ctl00_cphRoblox_HyperLinkDownload" href="/tos/"><a>Terms of Service</a> and <a>Licensing Agreement</a> for details.</p>
				<p><?=$sitename?> will not share your email address with 3rd parties. See our <a>Privacy Policy</a> for details.</p>
			</div>
		</div>
		<div id="ctl00_cphRoblox_ie6_peekaboo" style="clear: both"></div>

				</div>
                <?php
                require ("../core/footer.php");
                ?>
			</div>


        <script src="http://web.archive.org/web/20070804083927js_/http://www.google-analytics.com/urchin.js" type="text/javascript"></script>

        <script type="text/javascript">_uacct="UA-486632-1"; _udn="roblox.com"; urchinTracker(); __utmSetVar('Visitor/Anonymous');</script>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>




<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEWDALL+oj3DwLJkK28AQLIkK28AQLG/4fSDQKE6ZusCALXpOCmBAKSpqybAwL+hoiUBwKa1tDYBwK3uZGsCQKEhOyWAwLm0ND0CGXCOx8sBzG++DWJChg75+Pd38gO">

<script type="text/javascript">
<!--
Roblox.Controls.Image.IE6Hack($get('ctl00_Image1'));Sys.Application.initialize();
// -->
</script>


</body></html>
