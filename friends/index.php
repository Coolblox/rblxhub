<?php
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");
if (!$isloggedin) {
    header('Location: /Login/');
}
$msg = mysqli_query($connect, "SELECT * FROM friends WHERE user_to='{$_USER['id']}' AND arefriends='0' ORDER BY id DESC") or die(mysqli_error($connect));
$achievements = mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}'") or die(mysqli_error($connect));

if (!isset($_GET['id'])) {
  if (!$isloggedin) {
    die("<script>document.location = \"/Login/\"</script>");
  } else {
    die("<script>document.location = \"/User.php?id={$_USER['id']}\"</script>");
  }
}
$id = intval($id);


$userq = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'") or die(mysqli_error($connect));

if (mysqli_num_rows($userq) < 1) {
  //User doesn't exist.
  die("<script>document.location = \"/Users/\"</script>");
}

$user = mysqli_fetch_assoc($userq);

$ippv = md5($_SERVER['REMOTE_ADDR']);

if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM pageviews WHERE userid='$id' AND ip='$ippv'")) < 1) {
  mysqli_query($connect, "INSERT INTO `pageviews`(`id`, `ip`, `userid`) VALUES (NULL, '$ippv', '$id')") or die(mysqli_error($connect));
}
/*
  PLAYER STATS
*/
$joindate = new DateTime("@{$user['time_joined']}");
$joindate = $joindate->format("d/m/Y");
$page_views = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM pageviews WHERE userid='$id'"));

$item_sales = 0;
$items = mysqli_query($connect, "SELECT * FROM catalog WHERE creator='$id'") or die(mysqli_error($connect));

while ($item = mysqli_fetch_assoc($items)) {
  $item_sales = $item_sales + $item['sales'];
}

$trade_value = 0;
$asdfs = mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='{$user['id']}'") or die(mysqli_error($connect));

while ($inv = mysqli_fetch_assoc($asdfs)) {
  $asset = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM catalog WHERE id='{$inv['assetid']}'"));

  if ($asset['is_limited'] == 1) {
    $totalsales = 0;
    $salesc = 0;

    $slq = mysqli_query($connect, "SELECT * FROM limited_sales WHERE item_id='{$asset['id']}'") or die(mysqli_error($connect));
    while ($sssssss = mysqli_fetch_assoc($slq)) {
      $totalsales = $totalsales + $sssssss['price'];
      $salesc++;
    }
    if ($totalsales != 0) {
      $avg_price = round($totalsales / $salesc);
    } else {
      $avg_price = 0;
    }
    $trade_value = $trade_value + $avg_price;
  }
}

$invtype = $_GET['invtype'] ?? 'hat';

$achievements = mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$user['id']}'") or die(mysqli_error($connect));

if ($invtype == "hat") {
    //do stuff here
} else if ($invtype == "face") {
  //do stuff here
} else if ($invtype == "shirt") {
  //do stuff here
} else if ($invtype == "pants") {
  //do stuff here
} else if ($invtype == "tool") {
  //do stuff here
} else {
  $invtype = "hat";
}

$inventory_items_per_row = 4;

$invq = mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='{$user['id']}' AND type='$invtype'") or die(mysqli_error($connect));


$onlinetext = ($user['lastseen'] + 300 <= time()) ? "<span class=\"UserOfflineMessage\">[ Offline ]</span>" : "<span class=\"UserOnlineMessage\">[ Online: Website ]</span>";


                    $resultsperpage = 3;
                    $check = mysqli_query($connect, "SELECT * FROM users");
                    $usercount = mysqli_num_rows($check);

                    $numberofpages = ceil($usercount/$resultsperpage);

                    if(!isset($_GET['page'])) {
                        $page = 1;
                    }else{
                        $page = $_GET['page'];
                    }

                    $thispagefirstresult = ($page-1)*$resultsperpage;

$friendq = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$user['id']} AND `arefriends`='1') OR  (`user_to` = {$user['id']} AND `arefriends`='1') LIMIT ".$thispagefirstresult.",".$resultsperpage) or die(mysqli_error($connect));

$friendnew = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$user['id']} AND `arefriends`='1') OR  (`user_to` = {$user['id']} AND `arefriends`='1')") or die(mysqli_error($connect));

$friendcount = mysqli_num_rows($friendnew);

$arefriends = false;

if ($isloggedin) {
  if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE user_to='{$_USER['id']}' AND user_from='{$user['id']}' AND arefriends='1'")) > 0) {
    $arefriends = true;
  }
  if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends WHERE user_to='{$user['id']}' AND user_from='{$_USER['id']}' AND arefriends='1'")) > 0) {
    $arefriends = true;
  }
}
if ($user['is_banned'] == 1) {
    header("Location: /error/");
}

/*
<div class="column is-one-third">
  <div class="box">
    <img src="https://via.placeholder.com/150"><br>
    <center><span style="font-size: 12px;">Crew Member</span></center>
  </div>
</div>
*/
?>
<div id="Body">
<div id="FriendsContainer">
	<div id="Friend">
		<style>
		body {
    font: normal 8pt/normal 'Comic Sans MS',Verdana,sans-serif;
    margin-top: 0;
    text-transform: none;
    text-decoration: none;
}
		h4 {
    font-size: 10pt;
    font-weight: bold;
    line-height: 1em;
    margin-bottom: 5px;
    margin-top: 5px;
}
</style>
				<h4>Codex's friends (19)</h4>
		<div align="center">
		    							</div>
		<table cellspacing="0" border="0" align="Center">
			<tbody>
				<tr>
<td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Ktrain" href="/user/?id=21" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=21&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Ktrain" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=21">Ktrain</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="brannan" href="/user/?id=691" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=691&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="brannan" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=691">brannan</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Billy" href="/user/?id=571" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=571&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Billy" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=571">Billy</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Luigi" href="/user/?id=567" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=567&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Luigi" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=567">Luigi</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Patrick" href="/user/?id=518" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=518&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Patrick" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=518">Patrick</a></span>
															                                        </div>
															                                    </div></td>                			    </tr><tr>
									                    						<td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="redbear2700" href="/user/?id=619" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=619&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="redbear2700" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=619">redbear2700</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Teapot" href="/user/?id=18" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=18&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Teapot" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=18">Teapot</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="spider404error" href="/user/?id=366" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=366&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="spider404error" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=366">spider404error</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Test" href="/user/?id=30" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=30&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Test" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=30">Test</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="apa" href="/user/?id=371" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=371&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="apa" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=371">apa</a></span>
															                                        </div>
															                                    </div></td>									                			    </tr><tr>
																	<td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Crossroads" href="/user/?id=638" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=638&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Crossroads" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=638">Crossroads</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="samsung" href="/user/?id=376" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=376&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="samsung" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=376">samsung</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="funny374747" href="/user/?id=652" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=652&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="funny374747" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=652">funny374747</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Admin" href="/user/?id=1" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=1&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Admin" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=1">Admin</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Northern" href="/user/?id=81" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=81&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Northern" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=81">Northern</a></span>
															                                        </div>
															                                    </div></td>			                			    </tr><tr>						<td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="KonekoKittenWasTaken" href="/user/?id=110" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=110&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="KonekoKittenWasTaken" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=110">KonekoKittenWasTaken</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="KonekoKittenWasTaken" href="/user/?id=110" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=110&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="KonekoKittenWasTaken" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=110">KonekoKittenWasTaken</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="KonekoKittenWasTaken" href="/user/?id=110" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=110&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="KonekoKittenWasTaken" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=110">KonekoKittenWasTaken</a></span>
															                                        </div>
															                                    </div></td><td><div class="Friend">
															                                        <div class="Avatar">
															                                            <a title="Torchic99" href="/user/?id=326" style="display:inline-block;max-height:100px;max-width:100px;cursor:pointer;">
															<iframe height="100" width="100" src="/api/getAvatar.php?id=326&amp;size=85" frameborder="0" scrolling="no"></iframe>
															                                            </a>
															                                        </div>
															                                        <div class="Summary">
															                                                                                        <span class="OnlineStatus">
															                                                <img src="/images/OnlineStatusIndicator_IsOffline.gif" alt="Torchic99" style="border-width:0px;"></span>
															                                                                                        <span class="Name"><a href="/user/?id=326">Torchic99</a></span>
															                                        </div>
															                                    </div></td></tr><tr>																			                			    </tr>
			</tbody>
		</table>
	</div>
</div>
<div id="Footer">
<hr>
<p class="Legalese">
RBXAcer, "Online Building Toy", characters, logos, names, and all related indicia
are trademarks of
<a>RBXAcer Corporation</a>,
©2020<br>
RBXAcer Corp. is not affliated with Lego, MegaBloks, Bionicle, Pokemon, Nintendo, Lincoln Logs, Yu Gi Oh, K'nex, Tinkertoys, Erector Set, or the Pirates of the Caribbean. ARrrr!<br>
Use of this site signifies your acceptance of the <a href="/info/terms">Terms and Conditions</a>.
			 <br><a href="/info/privacy">Privacy Policy</a>
        &nbsp;|&nbsp; <a href="/info/about">About Us</a>
        &nbsp;|&nbsp; <a href="https://discord.gg/VnR6pZ3fEJ">Discord</a>
</p></div>
</div>