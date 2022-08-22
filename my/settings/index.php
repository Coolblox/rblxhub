<?php
include '/storage/ssd1/648/16177648/public_html/core/header.php';
include '/storage/ssd1/648/16177648/public_html/core/nav.php';
if (!$isloggedin) {
  die("You are not logged in.");
}

function obfuscate_email($email)
{
    $em   = explode("@",$email);
    $name = implode(array_slice($em, 0, count($em)-1), '@');
    $len  = floor(strlen($name)/2);

    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
}

if (isset($_POST['descupd'])) {
  $desc = $_POST['desc'] ?? "";

  $desc = mysqli_real_escape_string($connect, htmlspecialchars($desc));
  $newdesc = $desc;

  while (FilterString($newdesc) != "OK") {
    $profanity = FilterString($newdesc);
    $repl = str_repeat("*", strlen($profanity));
    $newdesc = str_replace($profanity, $repl, $newdesc);
  }

   $upd = mysqli_query($connect, "UPDATE users SET description='$newdesc' WHERE id='{$_USER['id']}'") or die(mysqli_error($connect));
   die("<script>document.location = document.location</script>");
}
?>
<div id="Body">
	<style>
	#EditProfileContainer {
    background-color: #eeeeee;
    border: 1px solid #000;
    color: #555;
    margin: 0 auto;
    width: 620px;
}
fieldset {
    font-size: 1.2em;
    margin: 15px 0 0 0;
}
</style>
	<form method="post" action="">
	<div id="EditProfileContainer">
		<h2>Edit Profile</h2>
		<div><span id="WrongOldPW" style="color:Red;"><?php
        if(!empty($error)){
            echo $error;
        }
        ?></span></div>
		<div id="Blurb">
			<fieldset title="Update your personal blurb">
				<legend>Update your personal blurb</legend>
				<div class="Suggestion">
					Describe yourself here (max. 1000 characters).  Make sure not to provide any details that can be used to identify you outside <?=$sitename?>.
				</div>
				<div class="Validators">

				</div>
				<div class="BlurbRow">
					<textarea rows="8" name="desc" <?php echo $_USER['description'] ?> cols="2" id="Blurb" tabindex="3" class="MultilineTextBox"></textarea>
				</div>
			</fieldset>
		</div>
		<div class="Buttons">
			<input id="Submit" tabindex="4" class="Button" type="submit" name="descupd" value="Update">&nbsp;<a id="Cancel" tabindex="5" class="Button" href="/home/my">Cancel</a>
		</div>
	</div>
</form>
</div>
