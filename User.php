<?php
// main headers
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");
$id = $_GET['id'] ?? 0;

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
	<div id="UserContainer">
		<div id="LeftBank">
			<div id="ProfilePane">

<table width="100%" bgcolor="lightsteelblue" cellpadding="6" cellspacing="0">
    <tbody><tr>
        <td>
            <span id="ctl00_cphRoblox_rbxUserPane_lUserName" class="Title"><?php echo $user['username'] ?></span><br>
            <?php echo $onlinetext ?> 
                    </td>
    </tr>
    <tr>
        <td>
            <span id="ctl00_cphRoblox_rbxUserPane_lUserRobloxURL"><?php echo $user['username'] ?>'s <?=$sitename?>:</span><br>
            <a href="/User.php?id=<?php echo $user['id'] ?>">https://rblxhub.ga/User.php?id=<?php echo $user['id'] ?></a><br>
            <br>
            <div style="left: 0px; float: left; position: relative; top: 0px">
<iframe height="220" width="200" src="https://web.archive.org/web/20110711055128im_/http://t7.roblox.com/Avatar-180x220-a4c138a9343e14c5357d62566d3c9c1b.Png" frameborder="0" scrolling="no"></iframe>
                <div id="ctl00_cphRoblox_rbxUserPane_AbuseReportButton1_AbuseReportPanel" class="ReportAbusePanel">

    <span class="AbuseIcon"><a id="ctl00_cphRoblox_rbxUserPane_AbuseReportButton1_ReportAbuseIconHyperLink"><img src="/images/abuse.gif" alt="Report Abuse" border="0"></a></span>
    <span class="AbuseButton"><a id="ctl00_cphRoblox_rbxUserPane_AbuseReportButton1_ReportAbuseTextHyperLink" href="#">Report Abuse</a></span>

</div>
            </div>


<p><a href="/">Send Message</a></p>
<p><a href="/api/AddFriend.php?id=<?php echo $user['id'] ?>">Send Friend Request</a></p>
<p><span id="ctl00_cphRoblox_rbxUserPane_rbxPublicUser_lBlurb"><?php echo nl2br($user['description']) ?></span></p>
        </td>
    </tr>
</tbody></table>

			</div>
			<div id="UserBadgesPane">
			<div id="UserBadges">
				<h4><a href="/Badges">Badges</a></h4>
				<table cellspacing="0" border="0" align="Center">
					<tbody>
					<td>
      <?php

            $i = 0;

            while ($ownedachievement = mysqli_fetch_assoc($achievements)) {
              $achievement = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM achievements WHERE id='{$ownedachievement['achievement_id']}'"));
              echo "<div class=\"Badge\">
                <div class=\"BadgeImage\">
                  <img src=\"/images/Badges/{$achievement['name_file']}.png\" title=\"{$achievement['description']}\" alt=\"{$achievement['name_file']}\"><br>
                  <div class=\"BadgeLabel\"><a href=\"/Badges\">{$achievement['name']}</a>
                </div>
              </div>
              <td><td>";
              $i += 1;

              if ($i >= 3) {
                echo "";
                $i = 0;
              }
            }

            ?>
	</tr>
</tbody></table>

</div>
			</div>
      <div id="UserStatisticsPane">
  					<div id="UserStatistics">
  						<div id="StatisticsPanel" style="transition: height 0.5s ease-out 0s; overflow: hidden; height: 200px;">
  							<div class="Header">
  								<h4>Statistics</h4>
  								<span class="PanelToggle"></span>
  							</div>
  							<div style="margin: 10px 10px 150px 10px;" id="Results">
  								<div class="Statistic">
  									<div class="Label"><acronym title="The number of this user's friends.">Friends</acronym>:</div>
  									<div class="Value"><span><?php echo $friendcount ?></span></div>
  								</div>
  																<div class="Statistic">
  									<div class="Label"><acronym title="The number of posts this user has made to the <?=$sitename?> forum.">Forum Posts</acronym>:</div>
  									<div class="Value"><span>0</span></div>
  								</div>
  								<div class="Statistic">
  									<div class="Label"><acronym title="The number of times this user's profile has been viewed.">Profile Views</acronym>:</div>
  									<div class="Value"><span><?php echo number_format($page_views) ?></span></div>
  								</div>
  								<div class="Statistic">
  									<div class="Label"><acronym title="The number of times this user's place has been visited.">Place Visits</acronym>:</div>
  									<div class="Value"><span>0</span></div>
  								</div>
  								<div class="Statistic">
  									<div class="Label"><acronym title="The number of times this user's models have been viewed - unfinished.">Model Views</acronym>:</div>
  									<div class="Value"><span>0</span></div>
  								</div>
  								<div class="Statistic">
  									<div class="Label"><acronym title="The number of times this user's character has destroyed another user's character in-game.">Knockouts</acronym>:</div>
  									<div class="Value"><span>0</span></div>
  								</div>
  								<div class="Statistic">
  									<div class="Label"><acronym title="The number of times this user's character has been destroyed in-game.">Wipeouts</acronym>:</div>
  									<div class="Value"><span>0</span></div>
                  </div>
  							</div>
  						</div>
  					</div>
  				</div>
		</div>
		<div id="RightBank">
    <div id='UserPlacesPane'>
				 <p style='padding: 10px 10px 10px 10px;''>This person doesn't have any <?=$sitename?> places.</p> 			</div>      <div id="FriendsPane">
					<div id="Friends">
					    <h4><?php echo $user['username'] ?>'s friends 
												
	<a href="/friends/?of=<?php echo $user['id'] ?>">See all <?php echo $friendcount ; ?></a>					    </h4>
                                                <!--<p style="padding: 10px 10px 10px 10px;">This person doesn't have any <?=$sitename?> friends.</p>-->
                                                <table cellspacing="0" align="Center" border="0" style="border-collapse:collapse;">
					<tbody><tr>
                                                <tr>
                                                <?php
            if ($friendcount < 1) {
              echo "<p style=\"padding: 10px 10px 10px 10px;\">This person doesn't have any $sitename friends.</p>";
            } else {
              echo "<div class=\"columns\">";
              $total = 0;
              $row = 0;
              
              while ($friend = mysqli_fetch_assoc($friendq)) {
                if ($total <= 5) {


                $friendid = 0;

                if ($friend['user_from'] == $user['id']) {
                  $friendid = $friend['user_to'];
                } else {
                  $friendid = $friend['user_from'];
                }

                $friend_online = mysqli_query($connect, "SELECT * FROM users WHERE id='$friendid'") or die(mysqli_error($connect));
                
                $finfo = mysqli_fetch_assoc($friend_online);

                $usr = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='$friendid' LIMIT ".$thispagefirstresult.",".$resultsperpage));
                echo "<td><div class=\"Friend\">
																																<div class=\"Avatar\">
																																		<a title=\"{$usr['username']}\" href=\"/User.php?id=$friendid\" style=\"display:inline-block;max-height:100px;max-width:100px;cursor:pointer;\">
												<img src=\"/images/Avatar.png\" width=\"95\" border=\"0\" alt=\"{$usr['username']}\" blankurl=\"http://t6.roblox.com:80/blank-100x100.gif\">
																																		</a>
																																</div>
																																<div class=\"Summary\">
																																																								<span class=\"OnlineStatus\">
							";													
							$onlinetest = ($finfo['lastseen'] + 300 <= time()) ? "<img src=\"/images/Offline.gif\" style=\"border-width:0px;\">" : "<img src=\"/images/Online.gif\" style=\"border-width:0px;\">";
							echo"$onlinetest</span>
																																																								<span class=\"Name\"><a href=\"/User.php?id=$friendid\">{$usr['username']}</a></span>
																																</div>
																														</div></td>";
                $total++;
                $row++;

                if ($row >= 3) {
                  echo "</div><div class=\"columns\">";
                  $row = 0;
                }
              }}
              echo "</div>";
            }
            ?></tr>
            <tr>
                                                <?php
            if ($friendcount < 1) {
              echo "<p style=\"padding: 10px 10px 10px 10px;\">This person doesn't have any $sitename friends.</p>";
            } else {
              echo "<div class=\"columns\">";
              $total = 0;
              $row = 0;
              
                    $resultsperpage = 3;

                    $numberofpages = ceil($usercount/$resultsperpage);

                    if(!isset($_GET['page'])) {
                        $page = 2;
                    }else{
                        $page = $_GET['page'];
                    }

                    $thispagefirstresult = ($page-1)*$resultsperpage;
             
              
              $friendpage = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$user['id']} AND `arefriends`='1') OR  (`user_to` = {$user['id']} AND `arefriends`='1') LIMIT ".$thispagefirstresult.",".$resultsperpage) or die(mysqli_error($connect));
              
              while ($friend = mysqli_fetch_assoc($friendpage)) {
                if ($total <= 5) {


                $friendid = 0;

                if ($friend['user_from'] == $user['id']) {
                  $friendid = $friend['user_to'];
                } else {
                  $friendid = $friend['user_from'];
                }

                $friend_online = mysqli_query($connect, "SELECT * FROM users WHERE id='$friendid'") or die(mysqli_error($connect));
                
                $finfo = mysqli_fetch_assoc($friend_online);

                $uesr = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='$friendid'"));
                echo "<td><div class=\"Friend\">
																																<div class=\"Avatar\">
																																		<a title=\"{$uesr['username']}\" href=\"/User.php?id=$friendid\" style=\"display:inline-block;max-height:100px;max-width:100px;cursor:pointer;\">
												<img src=\"/images/Avatar.png\" width=\"95\" border=\"0\" alt=\"{$uesr['username']}\" blankurl=\"http://t6.roblox.com:80/blank-100x100.gif\">
																																		</a>
																																</div>
																																<div class=\"Summary\">
																																																								<span class=\"OnlineStatus\">
							";													
							$onlinetest = ($finfo['lastseen'] + 300 <= time()) ? "<img src=\"/images/Offline.gif\" style=\"border-width:0px;\">" : "<img src=\"/images/Online.gif\" style=\"border-width:0px;\">";
							echo"$onlinetest</span>
																																																								<span class=\"Name\"><a href=\"/User.php?id=$friendid\">{$uesr['username']}</a></span>
																																</div>
																														</div></td>";
                $total++;
                $row++;

                if ($row >= 3) {
                  echo "</div><div class=\"columns\">";
                  $row = 0;
                }
              }}
              echo "</div>";
            }
            ?></tr></tbody></table>
											</div>
				</div>
        <div id="FavoritesPane" style="clear: right; margin: 10px 0 0 0; border: solid 1px #000;">
  					<div>
  			            <style>
  			                #FavoritesPane #Favorites h4
  			                {
  		                        background-color: #ccc;
  		                        border-bottom: solid 1px #000;
  		                        color: #333;
  		                        font-family: Comic Sans MS,Verdana,Sans-Serif;
  		                        margin: 0;
  		                        text-align: center;
  		                    }
  		                    #Favorites .PanelFooter
  		                    {
  							    background-color: #fff;
  							    border-top: solid 1px #000;
  							    color: #333;
  							    font-family: Verdana,Sans-Serif;
  							    margin: 0;
  							    padding: 3px;
  							    text-align: center;
  							}
  							#UserContainer #AssetsContent .HeaderPager, #UserContainer #FavoritesContent .HeaderPager
  							{
  							    margin-bottom: 10px;
  							}
  							#UserContainer #AssetsContent .HeaderPager, #UserContainer #FavoritesContent .HeaderPager, #UserContainer #AssetsContent .FooterPager, #UserContainer #FavoritesContent .FooterPager {
  							    margin: 0 12px 0 10px;
  							    padding: 2px 0;
  							    text-align: center;
  							}
  		                </style>
  						<div id="Favorites">
  							<h4>Favorites</h4>
  							<div id="FavoritesContent">This user does not have any favorites for this type</div>
  							<div class="PanelFooter">
  								Category:&nbsp;
  								<select id="FavCategories">
  									<option value="7">Heads</option>
  									<option value="8">Faces</option>
  									<option value="2">T-Shirts</option>
  									<option value="5">Shirts</option>
  									<option value="6">Pants</option>
  									<option value="1">Hats</option>
  									<option value="4">Decals</option>
  									<option value="3">Models</option>
  									<option selected="selected" value="0">Places</option>
  								</select>
  							</div>
  						</div>
  					</div>
  				</div>
		</div>
<div style="clear:both"></div>
    <?php
    require ("/storage/ssd1/648/16177648/public_html/core/footer.php");
    ?>